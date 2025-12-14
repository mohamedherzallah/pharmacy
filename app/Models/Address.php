<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'area', 'street', 'building_number',
        'floor', 'apartment', 'additional_info', 'is_default',
        'latitude', 'longitude'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
