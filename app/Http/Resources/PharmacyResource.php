<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PharmacyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->pharmacy_name, // هذا مهم للرياكت
            'pharmacy_name' => $this->pharmacy_name, // للتوافق
            'address' => $this->address,
            'logo' => $this->logo ? asset('storage/' . $this->logo) : null,
            'is_approved' => (bool) $this->is_approved,
            // إضافة حقول افتراضية للرياكت

        ];
    }
}
