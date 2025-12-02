<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        ''
    ];
    protected $guarded = [];

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
}
