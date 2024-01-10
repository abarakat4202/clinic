<?php

namespace App\Modules\Permission\Requests;

use App\Modules\Permission\Enums\UserPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the role is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(UserPermission::RolesAdd->value);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('roles')],
            'is_assignable' => ['sometimes', 'boolean'],
            'permissions' => ['required', 'array'],
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
