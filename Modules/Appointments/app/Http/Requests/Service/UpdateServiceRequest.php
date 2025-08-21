<?php

namespace Modules\Appointments\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\Appointments\Models\Service;

class UpdateServiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "category_id"   => ['sometimes', 'integer', 'exists:categories,id'],
            "name"          => ['sometimes', 'string', 'min:5', 'max:255'],
            "description"   => ['nullable', 'string', 'min:12', 'max:2048'],
            "price"         => ['nullable', 'numeric', 'between:0,999999.99'],
            // Or: ['nullable', 'decimal:8,2'] if you are on Laravel 11/12
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $service = $this->route("service"); // expects route model binding
        return Gate::allows('update', $service);
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            "category_id.exists"     => "The selected category does not exist.",
            "name.min"               => "The service name must be at least :min characters.",
            "name.max"               => "The service name may not be greater than :max characters.",

            "description.min"        => "The description must be at least :min characters.",
            "description.max"        => "The description may not be greater than :max characters.",

            "price.numeric"          => "The price must be a valid number.",
            "price.between"          => "The price must be between 0 and 999,999.99.",
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            "category_id" => "category",
            "name"        => "service name",
            "description" => "description",
            "price"       => "price",
        ];
    }
}
