<?php

namespace Modules\Reviews\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\Reviews\Models\Review;

class ReviewStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return Gate::allows('create', Review::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'service_provider_id' => ['required', 'exists:service_providers,id'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'], 
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'service_provider_id.required' => 'The service provider field is required.',
            'service_provider_id.exists'   => 'The selected service provider is invalid.',

            'rating.required' => 'The rating field is required.',
            'rating.numeric'  => 'The rating must be a number.',
            'rating.min'      => 'The rating must be at least 1.',
            'rating.max'      => 'The rating may not be greater than 5.',

            'comment.string'  => 'The comment must be a valid text.',
            'comment.max'     => 'The comment may not be greater than 1000 characters.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'service_provider_id' => 'service provider',
            'rating'              => 'rating',
            'comment'             => 'comment',
        ];
    }
}
