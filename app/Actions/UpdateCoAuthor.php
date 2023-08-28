<?php

namespace App\Actions;

use App\Models\CoAuthor;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UpdateCoAuthor extends Controller
{
    public function handle(Request $request, Document $document)
    {
        $user = $document->submission->user;
        $submissionData = null;

        $coAuthors[] = [
            'name' => $user->user_name,
            'email' => $user->user_email
        ];

        for($i=0; $i<7; ++$i)
        {
            $validationRules["author_{$i}_name"] = ['nullable', 'string', 'required_with:author_' . $i .'_email'];
            $validationRules["author_{$i}_email"] = ['nullable', 'string', 'email', 'required_with:author_' . $i . '_name'];

            $coAuthorData = $request->validate($validationRules);

            if($coAuthorData["author_{$i}_name"] !== null && $coAuthorData["author_{$i}_email"] !== null)
            {
                if(!in_array($coAuthorData["author_{$i}_name"], array_column($coAuthors, 'name')) && !in_array($coAuthorData["author_{$i}_email"], array_column($coAuthors, 'email')))
                {
                    $coAuthors[] = [
                        'name' => $coAuthorData["author_{$i}_name"],
                        'email' => $coAuthorData["author_{$i}_email"]
                    ];

                    $coAuthor = CoAuthor::firstOrCreate([
                        'email' => $coAuthorData["author_{$i}_email"],
                        'name' => $coAuthorData["author_{$i}_name"]
                    ]);
    
                    $submissionData[$coAuthor->id] = [
                        'number' => $i+1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                else
                {
                    return redirect()->back()->withErrors(["author_{$i}_name" => "Autor(a) já registrado(a).", "author_{$i}_email" => "Autor(a) já registrado(a)."])->withInput();
                }
            }
        }

        $changes = $document->coAuthors()->sync($submissionData);

        //Update timestamps if co authors were altered
        if(!empty($changes["attached"]) || !empty($changes["detached"]))
        {
            $document->touch();
            $document->submission->touch();
        }

        return redirect()->route('showDocument', [$document])->with('success', "Submissão atualizada.");
    }
}