<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Medicine;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // عرض السلة للمستخدم الحالي
    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $cart->load('items.medicine');
        return response()->json($cart);
    }

    // إضافة منتج للسلة أو زيادة الكمية
    public function add(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0', // price يمكن ارسالها من client أو نحسبها
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);

        $item = $cart->items()->where('medicine_id', $request->medicine_id)->first();

        $price = $request->price ?? Medicine::find($request->medicine_id)->price ?? 0;

        if ($item) {
            $item->update([
                'quantity' => $item->quantity + $request->quantity,
                'price' => $price
            ]);
        } else {
            $cart->items()->create([
                'medicine_id' => $request->medicine_id,
                'quantity' => $request->quantity,
                'price' => $price
            ]);
        }

        return response()->json(['message' => 'Added to cart']);
    }

    // تحديث كمية عنصر
    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = CartItem::findOrFail($itemId);
        // تأكد أن العنصر ينتمي للمستخدم
        if ($item->cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $item->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Updated']);
    }

    // حذف عنصر من السلة
    public function remove(Request $request, $itemId)
    {
        $item = CartItem::findOrFail($itemId);
        if ($item->cart->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $item->delete();

        return response()->json(['message' => 'Removed']);
    }

    // مسح السلة
    public function clear(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)->first();
        if ($cart) $cart->items()->delete();
        return response()->json(['message' => 'Cart cleared']);
    }
}
