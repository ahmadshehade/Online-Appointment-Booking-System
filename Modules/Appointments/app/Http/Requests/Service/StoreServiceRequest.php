<?php

namespace Modules\Appointments\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\Appointments\Models\Service;

class StoreServiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "category_id"   => ['required', 'integer', 'exists:categories,id'],
            "name"          => ['required', 'string', 'min:5', 'max:255'],
            "description"   => ['nullable', 'string', 'min:12', 'max:2048'],
            "price"         => ['nullable', 'numeric', 'between:0,999999.99'],

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Service::class);
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            "category_id.required"   => "The category field is required.",
            "category_id.exists"     => "The selected category does not exist.",

            "name.required"          => "The service name is required.",
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
