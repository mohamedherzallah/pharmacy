<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $conv = Conversation::findOrFail($conversationId);

        // تحقق أن المستخدم يشارك في المحادثة
        $user = $request->user();
        if ($conv->user_id !== $user->id && $conv->pharmacy_id !== optional($user->pharmacy)->id) {
            return response()->json(['message'=>'Forbidden'], 403);
        }

        $msg = Message::create([
            'conversation_id' => $conv->id,
            'sender_id' => $user->id,
            'sender_type' => $user->role,
            'message' => $request->message,
        ]);

        return response()->json($msg, 201);
    }

    public function index($conversationId, Request $request)
    {
        $conv = Conversation::with('messages')->findOrFail($conversationId);
        // authorization similar to store
        return response()->json($conv->messages);
    }
}
