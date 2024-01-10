<?php

namespace App\Modules\Appointment\Resources;

use App\Modules\Appointment\Models\Appointment;
use App\Modules\Patient\Resources\PatientResource;
use App\Modules\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Appointment */
class AppointmentResource extends JsonResource
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
            'status' => $this->status->toArray(),
            'patient' => PatientResource::make($this->whenLoaded('patient')),
            'assignee' => UserResource::make($this->whenLoaded('assignee')),
            'creator' => UserResource::make($this->whenLoaded('creator')),
            'estimated_start' => $this->estimated_start->toDateTimeString(),
            'estimated_end' => $this->estimated_end->toDateTimeString(),
            'diagnosis' => $this->diagnosis,
            'procedures' => $this->procedures,
            'prescription' => $this->prescription,
            'created_at' => $this->created_at,
        ];
    }
}
