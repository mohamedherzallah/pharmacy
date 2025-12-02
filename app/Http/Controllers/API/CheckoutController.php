<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = $request->user();
        $cart = Cart::with('items')->where('user_id', $user->id)->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // افترضنا أن كل عناصر السلة من نفس الصيدلية أو نتعامل مع أول عنصر لتحديد الصيدلية
        $firstItem = $cart->items->first();
        // افتراض: CartItem يحتوي pharmacy_id في pivot أو medicine->pharmacies؟
        // لتبسيط: ستحدد pharmacy_id من request أو من business logic
        $pharmacyId = $request->pharmacy_id ?? null;
        if (! $pharmacyId) {
            return response()->json(['message' => 'pharmacy_id is required'], 422);
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'pharmacy_id' => $pharmacyId,
                'status' => 'pending',
                'total_amount' => 0,
            ]);

            $total = 0;
            foreach ($cart->items as $item) {
                $lineTotal = $item->quantity * $item->price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'medicine_id' => $item->medicine_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
                $total += $lineTotal;
            }

            $order->update(['total_amount' => $total]);

            // تفريغ السلة
            $cart->items()->delete();

            DB::commit();

            return response()->json(['message' => 'Order created', 'order_id' => $order->id], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating order', 'error' => $e->getMessage()], 500);
        }
    }
}
