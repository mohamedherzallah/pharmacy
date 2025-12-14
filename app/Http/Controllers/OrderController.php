<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * عرض قائمة الطلبات (sales.listing)
     */
    public function index()
    {
        // إذا كان المستخدم صيدلي، يرى طلبات صيدليته فقط

//            $orders = Order::where('pharmacy_id', Auth::user()->pharmacy_id)
//                ->latest()
//                ->paginate(10);

        // إذا كان عميل، يرى طلباته فقط
            $orders = Order::with('user')->latest()->paginate(10);


        return view('sales.listing', compact('orders'));
    }

    /**
     * عرض نموذج إنشاء طلب جديد (sales.add-order)
     */
    public function create()
    {
        $medicines = Medicine::where('is_active', 'active')->get();
        $pharmacies = Pharmacy::where('is_approved', 'active')->get();

        return view('sales.add-order', compact('medicines', 'pharmacies'));
    }

    /**
     * حفظ طلب جديد (POST)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'notes' => 'nullable|string|max:1000',
            'prescription_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // رفع ملف الوصفة إذا موجود
            $prescriptionPath = null;
            if ($request->hasFile('prescription_file')) {
                $prescriptionPath = $request->file('prescription_file')
                    ->store('prescriptions', 'public');
            }

            // حساب الإجمالي
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $medicine = Medicine::find($item['medicine_id']);
                $totalAmount += $medicine->price * $item['quantity'];
            }

            // إنشاء الطلب
            $order = Order::create([
                'user_id' => Auth::id(),
                'pharmacy_id' => $validated['pharmacy_id'],
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'prescription_file' => $prescriptionPath,
            ]);

            // إضافة عناصر الطلب
            foreach ($validated['items'] as $item) {
                $medicine = Medicine::find($item['medicine_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'price' => $medicine->price, // سعر الدواء وقت الشراء
                ]);
            }

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'تم إنشاء الطلب بنجاح!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * عرض تفاصيل طلب (sales.details)
     */
    public function show($id)
    {
        $order = Order::with(['items.medicine', 'user', 'pharmacy'])
            ->findOrFail($id);

        // التحقق من صلاحية المستخدم
        $this->authorizeOrderAccess($order);

        return view('sales.details', compact('order'));
    }

    /**
     * عرض نموذج تعديل طلب (sales.edit-order)
     */
    public function edit($id)
    {
        $order = Order::with('items.medicine')->findOrFail($id);
        $medicines = Medicine::where('status', 'active')->get();
        $pharmacies = Pharmacy::where('status', 'active')->get();

        // التحقق من الصلاحية
        $this->authorizeOrderAccess($order);

        // يمكن التعديل فقط إذا كان pending
        if ($order->status != 'pending') {
            return back()->with('error', 'لا يمكن تعديل طلب في حالة: ' . $order->status);
        }

        return view('sales.edit-order', compact('order', 'medicines', 'pharmacies'));
    }

    /**
     * تحديث الطلب (PUT/PATCH)
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // التحقق من الصلاحية
        $this->authorizeOrderAccess($order);

        // يمكن التعديل فقط إذا كان pending
        if ($order->status != 'pending') {
            return back()->with('error', 'لا يمكن تعديل طلب في حالة: ' . $order->status);
        }

        $validated = $request->validate([
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'notes' => 'nullable|string|max:1000',
            'prescription_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*._destroy' => 'sometimes|boolean',
        ]);

        try {
            DB::beginTransaction();

            // تحديث ملف الوصفة إذا تم رفع جديد
            if ($request->hasFile('prescription_file')) {
                // حذف الملف القديم إذا موجود
                if ($order->prescription_file) {
                    Storage::disk('public')->delete($order->prescription_file);
                }

                $prescriptionPath = $request->file('prescription_file')
                    ->store('prescriptions', 'public');
                $order->prescription_file = $prescriptionPath;
            }

            // حساب الإجمالي الجديد
            $totalAmount = 0;
            $existingItemIds = [];

            foreach ($validated['items'] as $item) {
                // إذا كان العنصر محدد للحذف
                if (isset($item['_destroy']) && $item['_destroy']) {
                    if (isset($item['id'])) {
                        OrderItem::where('id', $item['id'])->delete();
                    }
                    continue;
                }

                $medicine = Medicine::find($item['medicine_id']);
                $subtotal = $medicine->price * $item['quantity'];

                if (isset($item['id'])) {
                    // تحديث عنصر موجود
                    $orderItem = OrderItem::find($item['id']);
                    $orderItem->update([
                        'medicine_id' => $item['medicine_id'],
                        'quantity' => $item['quantity'],
                        'price' => $medicine->price,
                    ]);
                    $existingItemIds[] = $item['id'];
                } else {
                    // إضافة عنصر جديد
                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'medicine_id' => $item['medicine_id'],
                        'quantity' => $item['quantity'],
                        'price' => $medicine->price,
                    ]);
                    $existingItemIds[] = $orderItem->id;
                }

                $totalAmount += $subtotal;
            }

            // حذف العناصر غير المضمنة
            OrderItem::where('order_id', $order->id)
                ->whereNotIn('id', $existingItemIds)
                ->delete();

            // تحديث بيانات الطلب
            $order->update([
                'pharmacy_id' => $validated['pharmacy_id'],
                'notes' => $validated['notes'] ?? null,
                'total_amount' => $totalAmount,
            ]);

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'تم تحديث الطلب بنجاح!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * تحديث حالة الطلب فقط (للقبول/الرفض/التوصيل)
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // التحقق من أن المستخدم صاحب الصيدلية
        if (Auth::user()->pharmacy_id != $order->pharmacy_id) {
            abort(403, 'غير مصرح لك بتغيير حالة هذا الطلب');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected,delivering,completed',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح!');
    }

    /**
     * حذف طلب (DELETE)
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // التحقق من الصلاحية
        $this->authorizeOrderAccess($order);

        // يمكن الحذف فقط إذا كان pending
        if ($order->status != 'pending') {
            return back()->with('error', 'لا يمكن حذف طلب في حالة: ' . $order->status);
        }

        try {
            DB::beginTransaction();

            // حذف ملف الوصفة إذا موجود
            if ($order->prescription_file) {
                Storage::disk('public')->delete($order->prescription_file);
            }

            // حذف العناصر أولاً
            OrderItem::where('order_id', $order->id)->delete();

            // حذف الطلب
            $order->delete();

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'تم حذف الطلب بنجاح!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء الحذف: ' . $e->getMessage());
        }
    }

    /**
     * دالة مساعدة للتحقق من صلاحية الوصول للطلب
     */
    private function authorizeOrderAccess(Order $order)
    {
        $user = Auth::user();

        // العميل يمكنه الوصول لطلباته فقط
        if ($user->hasRole('customer') && $order->user_id != $user->id) {
            abort(403, 'غير مصرح لك بالوصول لهذا الطلب');
        }

        // الصيدلي يمكنه الوصول لطلبات صيدليته فقط
        if ($user->hasRole('pharmacy') && $order->pharmacy_id != $user->pharmacy_id) {
            abort(403, 'غير مصرح لك بالوصول لهذا الطلب');
        }

        // المدير يمكنه الوصول لجميع الطلبات
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * تحميل ملف الوصفة
     */
    public function downloadPrescription($id)
    {
        $order = Order::findOrFail($id);

        // التحقق من الصلاحية
        $this->authorizeOrderAccess($order);

        if (!$order->prescription_file) {
            abort(404, 'الملف غير موجود');
        }

        return Storage::disk('public')->download($order->prescription_file);
    }
}
