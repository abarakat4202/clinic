<?php

namespace App\Modules\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'avatar' => ['nullable', 'mimes:jpg,png', 'max:800'],
            'current_password' => [
                'nullable',
                function (string $attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()?->password)) {
                        $fail('Current Password didn\'t match');
                    }
                }
            ],
        ];

        if (!empty($this->get('current_password'))) {
            $rules['password'] = ['required', 'min:6', 'confirmed'];
        }
    }
}
