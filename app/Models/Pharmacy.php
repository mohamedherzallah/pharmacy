<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;


    protected $fillable = [
        'pharmacy_name',
        'address',
        'user_id',
        'license_image',
        'logo',
        'is_approved',
    ];

//    protected $casts = [
//        'is_approved' => 'boolean',
//    ];

    // العلاقة مع المستخدم (مالك الصيدلية)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة: الصيدلية يمكن أن تمتلك عدة أدوية
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'pharmacy_medicines')
            ->withPivot('price', 'stock')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
