<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class LoginRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'ends_with:.com,.net,.ua',
                "exists:users,email",
            ],
            'password' => ['string', 'required', 'min:8']
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {

            $data = [
                'email' => $this->email,
                'password' => $this->password
            ];

            if (!Auth::attempt($data)) {
                $validator->errors()->add('email', 'incorrect email or password');
            }
        });
    }
}
