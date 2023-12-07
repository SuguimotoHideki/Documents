<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 

class ValidateDocumentRequest extends FormRequest
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
        $document = $this->route('document');
        if($document == null)
        {
            return [
                'title' => ['required', 'string', Rule::unique('documents', 'title')],
                'keyword' => ['required', 'string'],
                'institution' => ['required', 'string'],
                'submission_type_id' => ['required', 'numeric'],
                'attachment_author' => ['required'],
                'attachment_no_author' => ['required']
            ];
        }
        else
        {
            return [
                'title' => ['required', 'string', Rule::unique('documents', 'title')->ignore($document->id)],
                'keyword' => ['required', 'string'],
                'institution' => ['required', 'string'],
                'submission_type_id' => ['required', 'numeric']
            ];
        }

    }
}
