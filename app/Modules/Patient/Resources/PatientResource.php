<?php

namespace App\Modules\Patient\Resources;

use App\Modules\Patient\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Patient */
class PatientResource extends JsonResource
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
            'name' => $this->name,
            'age' => $this->age,
            'gender' => $this->gender->toArray(),
            'phone' => $this->phone,
            'emergency_name' => $this->emergency_name,
            'emergency_phone' => $this->emergency_phone,
            'address' => $this->address,
            'medical_history' => $this->medical_history,
            'allergies' => $this->allergies,
        ];
    }
}
