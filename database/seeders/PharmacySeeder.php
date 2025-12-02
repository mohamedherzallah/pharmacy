<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pharmacy;

class PharmacySeeder extends Seeder
{
    public function run(): void
    {
        Pharmacy::factory()->count(20)->create();
    }
}
