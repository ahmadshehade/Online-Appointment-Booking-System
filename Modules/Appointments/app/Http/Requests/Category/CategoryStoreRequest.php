<?php

namespace Modules\Appointments\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\Appointments\Models\Category;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "name" => ['required', 'string', 'max:255', 'unique:categories,name'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Category::class);
    }

    /**
     * Summary of messages
     * @return array{name.required: string, name.string: string, name.unique: string}
     */
    public function messages(): array
    {

        return [
            'name.required' => 'name must be required.',
            'name.string' => 'name must be string.',
            'name.unique' => 'name must be  unique .',
            'name.max' => 'name must be under  255 character.'
        ];
    }

    /**
     * Summary of attributes
     * @return array{name: string}
     */
    public function attributes(): array
    {
        return [
            'name' => 'Category Name'
        ];
    }
}
