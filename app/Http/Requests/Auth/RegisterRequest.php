<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'user_type' => 'required|string|in:client,provider',
            'name' => 'required|string|max:50',
            'email' => ['required', 'string', 'email:rfc,dns', 'ends_with:.com,.net,.ua', "unique:users,email,{$this->user_id},id",],
            'phone_number' => ['required', 'phone', "unique:users,phone_number,{$this->user_id},id"],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required_if:user_type,provider', 'nullable', 'string', 'max:50'],
            'categories' => ['required_if:user_type,provider', 'nullable', 'array'],
            'categories.*' => ['required', 'integer', 'exists:categories,id'],
            'years_of_experience' => ['required_if:user_type,provider', 'nullable', 'integer', 'min:0'],
        ];
    }
}
