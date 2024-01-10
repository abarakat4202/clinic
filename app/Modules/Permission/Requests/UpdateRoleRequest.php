<?php

namespace App\Modules\Permission\Requests;

use App\Modules\Permission\Enums\UserPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the role is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(UserPermission::RolesEdit->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes', 'string', 'min:3', 'max:255',
                Rule::unique('roles')->ignore($this->route('role')->id),
                Rule::prohibitedIf($this->route('role')->is_protected),
            ],
            'is_assignable' => ['sometimes', 'boolean'],
            'permissions' => [
                'sometimes', 'array',
                Rule::prohibitedIf($this->route('role')->is_protected),
            ],
            'permissions.*' => ['required', Rule::enum(UserPermission::class)],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['is_assignable' => $this->get('is_assignable', false)]);
    }
}
