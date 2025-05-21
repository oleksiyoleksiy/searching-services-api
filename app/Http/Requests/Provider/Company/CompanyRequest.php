<?php

namespace App\Http\Requests\Provider\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer', 'exists:categories,id'],
            'years_of_experience' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],

            'business_hours' => ['required', 'array'],

            'business_hours.0' => ['nullable', 'array'],
            'business_hours.0.start' => ['nullable', 'date_format:H:i'],
            'business_hours.0.end' => ['nullable', 'date_format:H:i'],

            'business_hours.1' => ['nullable', 'array'],
            'business_hours.1.start' => ['nullable', 'date_format:H:i'],
            'business_hours.1.end' => ['nullable', 'date_format:H:i'],

            'business_hours.2' => ['nullable', 'array'],
            'business_hours.2.start' => ['nullable', 'date_format:H:i'],
            'business_hours.2.end' => ['nullable', 'date_format:H:i'],

            'business_hours.3' => ['nullable', 'array'],
            'business_hours.3.start' => ['nullable', 'date_format:H:i'],
            'business_hours.3.end' => ['nullable', 'date_format:H:i'],

            'business_hours.4' => ['nullable', 'array'],
            'business_hours.4.start' => ['nullable', 'date_format:H:i'],
            'business_hours.4.end' => ['nullable', 'date_format:H:i'],

            'business_hours.5' => ['nullable', 'array'],
            'business_hours.5.start' => ['nullable', 'date_format:H:i'],
            'business_hours.5.end' => ['nullable', 'date_format:H:i'],

            'business_hours.6' => ['nullable', 'array'],
            'business_hours.6.start' => ['nullable', 'date_format:H:i'],
            'business_hours.6.end' => ['nullable', 'date_format:H:i'],

            'preview' => ['nullable', 'image', 'max:5120'],
            'preview_remove' => ['nullable', 'boolean'],

            'gallery_images' => ['nullable', 'array', 'max:9'],
            'gallery_images.*' => ['image', 'max:5120'],

            'gallery_images_remove' => ['nullable', 'array'],
            'gallery_images_remove.*' => ['integer', 'exists:files,id'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $galleryImages = count($this->input('gallery_images', []));
            $userGalleryImages = auth()->user()->company->filesByType('gallery')->count();

            if ($galleryImages + $userGalleryImages > 9) {
                $validator->errors()->add(
                    "gallery_images",
                    'maximum number of gallery images 9.'
                );
            }

            foreach ($this->input('business_hours', []) as $day => $hours) {
                if (
                    isset($hours['start'], $hours['end']) &&
                    $hours['start'] &&
                    $hours['end'] &&
                    strtotime($hours['end']) <= strtotime($hours['start'])
                ) {
                    $validator->errors()->add(
                        "business_hours.$day.end",
                        'End time must be after start time.'
                    );
                }
            }
        });
    }
}
