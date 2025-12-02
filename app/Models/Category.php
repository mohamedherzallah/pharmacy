<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'avatar'];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
