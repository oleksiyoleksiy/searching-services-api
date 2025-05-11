<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'email' => ['required', 'string', 'email:rfc,dns', 'ends_with:.com,.net,.ua', "unique:users,email,{$this->user()->id},id",],
            'phone_number' => ['required', 'phone', "unique:users,phone_number,{$this->user()->id},id"],
            'address' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:8192', 'mimes:png,jpg,svg,jpeg,webp'],
            'avatar_remove' => ['required', 'boolean']
        ];
    }
}
