<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SlotUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "day_of_week" => ["sometimes", "in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday"],
            "start_time" => ["sometimes", "date_format:H:i"],
            "end_time"   => ["sometimes", "date_format:H:i", "after:start_time"],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $availability_slot=$this->route("availability_slot");
        return Gate::allows('update',$availability_slot);
    }


    public function messages(): array
    {
        return [
            "day_of_week.in"       => "The :attribute must be a valid day of the week.",
            "start_time.date_format" => "The :attribute must be in the format HH:MM.",
            "end_time.date_format" => "The :attribute must be in the format HH:MM.",
            "end_time.after"       => "The :attribute must be after the start time.",
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            "day_of_week" => "day of the week",
            "start_time"  => "start time",
            "end_time"    => "end time",
        ];
    }
}
