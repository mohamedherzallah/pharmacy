<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_type', // user | pharmacy
        'sender_id',
        'message',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
