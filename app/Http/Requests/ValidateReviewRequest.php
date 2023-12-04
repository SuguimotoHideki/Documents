<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateReviewRequest extends FormRequest
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
    public function rules(): array
    {
        $review = $this->route('review');
        if($review === null)
        {
            return [
                'title' => ['required', 'string'],
                'score.*' => ['required', 'integer', 'digits_between:0,10'],
                'comment' => ['required', 'string'],
                'moderator_comment' => ['nullable', 'string'],
                'recommendation' => ['nullable'],
                'user_id' => ['required'],
                'document_id' => ['required']
            ];
        }
        else
        {
            return [
                'title' => ['required', 'string'],
                'comment' => ['required', 'string'],
                'score' => ['required', 'array'],
                'score.*' => ['required', 'integer', 'digits_between:0,10'],
                'moderator_comment' => ['nullable', 'string'],
                'recommendation' => ['nullable'],
            ];
        }
    }
}
