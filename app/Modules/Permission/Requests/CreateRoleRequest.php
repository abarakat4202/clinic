<?php

namespace App\Modules\Permission\Requests;

use App\Modules\Permission\Enums\UserPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateRoleRequest extends FormRequest
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
        return [];
    }
}
