<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Event;
use App\Models\CoAuthor;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CreateCoAuthor extends Controller
{
    public function handle(Request $request, Document $document, User $user, Event $event)
    {
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
                }
                else
                {
                    throw(ValidationException::withMessages([
                        "author_{$i}_name" => "Co-autor já registrado.",
                        "author_{$i}_email" => "Co-autor já registrado."
                    ]))->redirectTo(route('createDocument', $event));
                }

                $document->coAuthors()->attach($coAuthor->id, ['number' => $i+1, 'created_at' => now(), 'updated_at' => now()]);
            }
        }

        return redirect()->route('indexSubmissions', ['user' => Auth::user()])->with('success', 'Submissão enviada.');
    }
}