<?php

namespace Modules\Appointments\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $category = $this->route("category");

        return [
            "name" => [
                "required",
                "string",
                "max:255",
                Rule::unique('categories')->ignore($category->id),
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $category = $this->route("category");
        return  Gate::allows('update', $category);
    }

    /**
     * Summary of messages
     * @return array{name.max: string, name.string: string, name.unique: string}
     */
    public function messages(): array
    {
        return [
            'name.string' => ':attribute must be a string.',
            'name.max' => ':attribute must be under 255 characters.',
            'name.unique' => ':attribute must be unique.',
            'name.required' => ':attribute is required.'
        ];
    }


    /**
     * Summary of attributes
     * @return array{name: string}
     */
    public function attributes()
    {
        return [
            'name' => 'Category Name'
        ];
    }
}
