<?php

namespace App\Modules\Patient\Requests;

use App\Modules\Patient\Enums\PatientGender;
use App\Modules\Permission\Enums\UserPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Determine if the role is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(UserPermission::PatientsEdit->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'phone' => ['required', 'starts_with:+20,+971,+961'],
            'birth_date' => ['required', 'date', 'before:tomorrow'],
            'gender' => ['required', Rule::enum(PatientGender::class)],
            'address' => ['nullable', 'string', 'min:3', 'max:255'],
            'medical_history' => ['nullable', 'string', 'min:3'],
            'allergies' => ['nullable', 'string', 'min:3'],
            'emergency_name' => ['nullable', 'string', 'min:3', 'max:255'],
            'emergency_phone' => ['required_with:emergency_name', 'starts_with:+20,+971,+961'],
        ];
    }
}
