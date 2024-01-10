<?php

namespace App\Modules\User\Requests;

use App\Modules\Permission\Enums\UserPermission;
use App\Modules\User\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(UserPermission::UsersEdit->value);
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
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->route('user')->id)],
            'password' => ['nullable', 'min:6'],
            'roles' => ['sometimes', 'array'],
            'roles.*' => [
                'required',
                Rule::exists('roles', 'id')->where('is_protected', false),
                Rule::prohibitedIf($this->route('user')->is_super_admin),
            ],
            'status' => ['sometimes',],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(['status' => $this->get('status', UserStatus::InActive)]);
    }
}
