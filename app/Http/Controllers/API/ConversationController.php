<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    // قائمة المحادثات للمستخدم
    public function index(Request $request)
    {
        $convs = Conversation::where(function($q) use($request){
            $q->where('user_id', $request->user()->id)
                ->orWhere('pharmacy_id', optional($request->user()->pharmacy)->id);
        })->with('messages')->latest()->get();

        return response()->json($convs);
    }

    // انشاء محادثة جديدة (عند الحاجة)
    public function store(Request $request)
    {
        $request->validate([
            'pharmacy_id' => 'required|exists:pharmacies,id',
        ]);

        $conv = Conversation::firstOrCreate([
            'user_id' => $request->user()->id,
            'pharmacy_id' => $request->pharmacy_id,
        ]);

        return response()->json($conv, 201);
    }
}
