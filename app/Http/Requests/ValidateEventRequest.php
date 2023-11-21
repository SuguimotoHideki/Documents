<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule; 

class ValidateEventRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $event = $this->route('event');
        if($event === null)
        {
             return [
                'name' => ['required', 'string', Rule::unique('events', 'name')],
                'website' => ['required', 'string'],
                'information' => ['required', 'string'],
                'email' => ['required', 'string'],
                'submission_type' => ['required', 'array'],
                'organizer' => ['required', 'string'],
                'organizer_email' => ['required', 'string'],
                'organizer_website' => ['required', 'string'],
                'subscription_start' => ['required', 'date_format:Y-m-d H:i:s', 'before:subscription_deadline'],
                'subscription_deadline' => ['required', 'date_format:Y-m-d H:i:s', 'before:submission_start'],
                'submission_start' => ['required', 'date_format:Y-m-d H:i:s', 'before:submission_deadline'],
                'submission_deadline' => ['required', 'date_format:Y-m-d H:i:s'],
            ];
        }
        else
        {
            return [
                'name' => ['required', 'string', Rule::unique('events', 'name')->ignore($event, 'id')],
                'website' => ['required', 'string'],
                'information' => ['required', 'string'],
                'email' => ['required', 'string'],
                'published' => ['boolean'],
                'submission_type' => ['required', 'array'],
                'organizer' => ['required', 'string'],
                'organizer_email' => ['required', 'string'],
                'organizer_website' => ['required', 'string'],
                'subscription_start' => ['required', 'date_format:Y-m-d H:i:s', 'before:subscription_deadline'],
                'subscription_deadline' => ['required', 'date_format:Y-m-d H:i:s', 'before:submission_start'],
                'submission_start' => ['required', 'date_format:Y-m-d H:i:s', 'before:submission_deadline'],
                'submission_deadline' => ['required', 'date_format:Y-m-d H:i:s'],
            ];
        }

    }

    public function prepareForValidation()
    {
        $this->merge([
            'subscription_start' => Carbon::createFromFormat('Y-m-d H:i:s', $this['subscription_start'] . ' ' . "00:00:00")->format("Y-m-d H:i:s"),
            'subscription_deadline' => Carbon::createFromFormat('Y-m-d H:i:s', $this['subscription_deadline'] . ' ' . "23:59:59")->format("Y-m-d H:i:s"),
            'submission_start' => Carbon::createFromFormat('Y-m-d H:i:s', $this['submission_start'] . ' ' . "00:00:00")->format("Y-m-d H:i:s"),
            'submission_deadline' => Carbon::createFromFormat('Y-m-d H:i:s', $this['submission_deadline'] . ' ' . "23:59:59")->format("Y-m-d H:i:s"),
        ]);
    }
}
