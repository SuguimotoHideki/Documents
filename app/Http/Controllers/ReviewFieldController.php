<?php

namespace App\Http\Controllers;

use App\Models\ReviewField;
use Illuminate\Http\Request;
use App\Models\SubmissionType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class ReviewFieldController extends Controller
{
    //
    public function index()
    {

        $response = Gate::inspect('manageReviewFields', Review::class);

        if($response->allowed())
        {
            $fields = ReviewField::all();
            $subTypes = SubmissionType::all();
            
            return view('review_fields.index', [
                "fields" => $fields,
                "types" => $subTypes
            ]);
        }
        return redirect()->back()->with('error', $response->message());
    }

    public function store(Request $request)
    {
        $response = Gate::inspect('manageReviewFields', Review::class);

        if($response->allowed())
        {
            $formFields = $request->validate([
                'name' => ["required", "string", Rule::unique('review_fields', 'name')],
                'submission_type' => ['required', 'array'],
            ]);

            $field = ReviewField::create($formFields);

            $field->submissionTypes()->sync($formFields['submission_type']);

            return redirect()->back()->with('success', "Campo de avaliação criado.");
        }
        return redirect()->back()->with('error', $response->message());
    }

    public function update(Request $request, ReviewField $field)
    {
        $response = Gate::inspect('manageReviewFields', Review::class);

        if($response->allowed())
        {
            $formFields = $request->validate([
                'name' => ["required", "string", Rule::unique('review_fields', 'name')->ignore($field, 'id')],
                'submission_type' => ['required', 'array'],
            ]);
            
            $field->update($formFields);
            $field->submissionTypes()->sync($formFields['submission_type']);

            return redirect()->back()->with('success', "Campo de avaliação atualizado.");
        }
        return redirect()->back()->with('error', $response->message());
    }

    public function destroy(ReviewField $field)
    {
        $response = Gate::inspect('manageReviewFields', Review::class);

        if($response->allowed())
        {
            $field->delete();
            return redirect()->back()->with('success', "Campo de avaliação excluído.");
        }
        return redirect()->back()->with('error', $response->message());
    }
}
