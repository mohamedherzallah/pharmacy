<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // طلبات المستخدم الحالية
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->role === 'pharmacy') {
            // طلبات لصيدلية
            $orders = Order::where('pharmacy_id', $user->pharmacy->id)->with('items.medicine')->latest()->paginate(20);
        } else {
            $orders = Order::where('user_id', $user->id)->with('items.medicine')->latest()->paginate(20);
        }

        return OrderResource::collection($orders);
    }

    public function show($id, Request $request)
    {
        $order = Order::with('items.medicine')->findOrFail($id);
        // Authorization: user or pharmacy only
        $user = $request->user();
        if ($user->role === 'user' && $order->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        if ($user->role === 'pharmacy' && $order->pharmacy_id !== $user->pharmacy->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return new OrderResource($order);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    // تحديث حالة (للصيدلية أو الادمن)
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,cancelled,delivered'
        ]);

        $order->update(['status' => $request->status]);

        return new OrderResource($order);
    }

    // حذف طلب (حسب سياساتك)
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }
}
