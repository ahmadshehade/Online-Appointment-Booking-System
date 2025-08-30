<?php

namespace Modules\Reviews\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ReviewUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $review = $this->route('review');
        return Gate::allows('update', $review);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'service_provider_id' => ['sometimes', 'exists:service_providers,id'],
            'rating'              => ['sometimes', 'numeric', 'min:1', 'max:5'],
            'comment'             => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'service_provider_id.exists'   => 'The selected service provider is invalid.',

            'rating.numeric'  => 'The rating must be a number.',
            'rating.min'      => 'The rating must be at least 1.',
            'rating.max'      => 'The rating may not be greater than 5.',

            'comment.string'  => 'The comment must be a valid text.',
            'comment.max'     => 'The comment may not be greater than 1000 characters.',
        ];
    }

    /**
     * Custom attribute names for errors.
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
