<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'card_type', 'last_four', 'cardholder_name',
        'expiry_month', 'expiry_year', 'token', 'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    protected $hidden = ['token']; // إخفاء البيانات الحساسة

    public function user() {
        return $this->belongsTo(User::class);
    }
}
