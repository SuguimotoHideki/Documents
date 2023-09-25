<?php

namespace App\Http\Controllers;

use App\Models\SubmissionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;


class SubmissionTypeController extends Controller
{
    //
    public function index()
    {
        $response = Gate::inspect('accessTypes', SubmissionType::class);

        if($response->allowed())
        {
            $types = SubmissionType::all();

            return view('submission_type.index', [
                "types" => $types
            ]);
        }
        else
        {
            return redirect()->back()->with('error', $response->message());
        }
    }

    public function store(Request $request)
    {
        $this->authorize('manageTypes', SubmissionType::class);

        $formFields = $request->validate([
            "name" => ["required", "string", Rule::unique('submission_types', 'name')],
        ]);
    
        $formFields['name'] = strtolower($formFields['name']);

        SubmissionType::create($formFields);

        return redirect()->back()->with('success', "Tipo de submissão criada.");
    }

    public function update(Request $request, SubmissionType $type)
    {
        $this->authorize('manageTypes', SubmissionType::class);

        $formFields = $request->validate([
            "name" => ["required", "string", Rule::unique('submission_types', 'name')->ignore($type, 'id')],
        ]);

        $formFields['name'] = strtolower($formFields['name']);

        $type->update($formFields);

        return redirect()->back()->with('success', "Tipo de submissão atualizada.");
    }

    public function destroy(SubmissionType $type)
    {
        $this->authorize('manageTypes', SubmissionType::class);

        $type->delete();

        return redirect()->back()->with('success', "Tipo de submissão excluído.");
    }
}
