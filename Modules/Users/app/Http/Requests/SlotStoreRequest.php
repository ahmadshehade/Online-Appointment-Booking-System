<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\Users\Models\AvailabilitySlot;

class SlotStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorize using Gate
        return Gate::allows('create',AvailabilitySlot::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

            "day_of_week" => ["required", "in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday"],
            "start_time" => ["required", "date_format:H:i"],
            "end_time"   => ["required", "date_format:H:i", "after:start_time"],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [


            "day_of_week.required" => "The :attribute field is required.",
            "day_of_week.in"       => "The :attribute must be a valid day of the week.",

            "start_time.required"    => "The :attribute field is required.",
            "start_time.date_format" => "The :attribute must be in the format HH:MM.",

            "end_time.required"    => "The :attribute field is required.",
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
