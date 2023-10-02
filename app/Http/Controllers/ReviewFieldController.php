<?php

namespace App\Http\Controllers;

use App\Models\ReviewField;
use Illuminate\Http\Request;
use App\Models\SubmissionType;
use Illuminate\Validation\Rule;

class ReviewFieldController extends Controller
{
    //
    public function index()
    {
        $fields = ReviewField::all();
        $subTypes = SubmissionType::all();
        
        return view('review_fields.index', [
            "fields" => $fields,
            "types" => $subTypes
        ]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ["required", "string", Rule::unique('review_fields', 'name')],
            'submission_type' => ['required', 'array'],
        ]);

        $field = ReviewField::create($formFields);

        $field->submissionTypes()->sync($formFields['submission_type']);

        return redirect()->back()->with('success', "Campo de avaliação criado.");
    }

    public function update(Request $request, ReviewField $field)
    {
        $formFields = $request->validate([
            'name' => ["required", "string", Rule::unique('review_fields', 'name')->ignore($field, 'id')],
            'submission_type' => ['required', 'array'],
        ]);
        
        $field->update($formFields);
        $field->submissionTypes()->sync($formFields['submission_type']);

        return redirect()->back()->with('success', "Campo de avaliação atualizado.");
    }

    public function destroy(ReviewField $field)
    {  
        $field->delete();

        return redirect()->back()->with('success', "Campo de avaliação excluído.");
    }
}
