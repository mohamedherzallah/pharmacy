<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'medicine_id',
        'pharmacy_medicine_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    // إضافة العلاقة مع pharmacy_medicine
    public function pharmacyMedicine()
    {
        return $this->belongsTo(pharmacy_medicine::class, 'pharmacy_medicine_id');
    }

    // علاقة غير مباشرة مع الصيدلية
    public function pharmacy()
    {
        return $this->hasOneThrough(
            Pharmacy::class,
            pharmacy_medicine::class,
            'id', // Foreign key on pharmacy_medicine table
            'id', // Foreign key on pharmacy table
            'pharmacy_medicine_id', // Local key on order_items table
            'pharmacy_id' // Local key on pharmacy_medicine table
        );
    }
}
