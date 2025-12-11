<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'expiration_date',
        'is_active',
    ];

    // علاقة: دواء ينتمي إلى تصنيف واحد
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // علاقة: الدواء يمكن أن تمتلكه عدة صيدليات
    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class, 'pharmacy_medicines')
            ->withPivot('price', 'stock')
            ->withTimestamps();
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $term = strtolower($term); // لضمان تجاهل الحالة
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$term}%"]);
        }
    }
}
