<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pharmacy_medicine extends Model
{
     use HasFactory;

        protected $table = 'pharmacy_medicines';

        protected $fillable = [
            'pharmacy_id',
            'medicine_id',
            'stock',
            'price',
        ];

        public function medicine()
        {
            return $this->belongsTo(Medicine::class);
        }

        public function pharmacy()
        {
            return $this->belongsTo(Pharmacy::class);
        }
}
