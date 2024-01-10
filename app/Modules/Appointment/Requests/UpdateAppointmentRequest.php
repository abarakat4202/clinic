<?php

namespace App\Modules\Appointment\Requests;

use App\Modules\Appointment\Enums\AppointmentGender;
use App\Modules\Appointment\Enums\AppointmentStatus;
use App\Modules\Appointment\Models\Appointment;
use App\Modules\Permission\Enums\UserPermission;
use App\Modules\User\Models\User;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the role is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(UserPermission::AppointmentsEdit->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'appointment_date' => ['required', 'date', 'after:' . now()->addMinutes(10)],
            'duration' => ['required', 'integer', 'min:5', 'max:120'],
            'status' => ['required', Rule::enum(AppointmentStatus::class)],
            'diagnosis' => ['nullable', 'min:5', 'string'],
            'procedures' => ['nullable', 'string'],
            'prescription' => ['nullable', 'min:5', 'string'],
            'doctor' => [
                'required',
                Rule::exists('users', 'id'),
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!empty($this->get('doctor')) && !empty($this->get('appointment_date')) &&  !empty($this->get('duration'))) {
                        $start = Carbon::parse($this->get('appointment_date'));
                        $end = $start->clone()->addMinutes($this->get('duration'));
                        //check if patient has another appointment withing this range
                        if (Appointment::withinTimes($start, $end, $this->route('appointment'))->where('assignee_id', $this->get('assignee'))->exists()) {
                            $fail("The {$attribute} is already assigned to another appointments within that time!");
                        }
                    }
                },
            ],
        ];
    }
}
