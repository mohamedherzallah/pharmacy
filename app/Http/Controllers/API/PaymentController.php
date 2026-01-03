<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pay(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string',
        ]);

        $order = Order::find($request->order_id);

        // إذا الطلب مدفوع مسبقاً
        if ($order->payment_status == 'paid') {
            return response()->json(['message' => 'This order is already paid'], 400);
        }

        // "عملية الدفع" — محاكاة فقط
        $transactionId = 'TXN_' . uniqid();

        // إنشاء سجل الدفع
        $payment = Payment::create([
            'order_id' => $order->id,
            'status' => 'paid',
            'amount' => $order->total_price,
            'payment_method' => $request->payment_method,
            'transaction_id' => $transactionId,
        ]);

        // تحديث حالة الطلب
        $order->update([
            'payment_status' => 'paid'
        ]);

        return response()->json([
            'message' => 'Payment successful',
            'payment' => $payment
        ]);
    }
}
