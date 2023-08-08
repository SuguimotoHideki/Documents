<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

class CoAuthor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email'
    ];

    public function formatName($name, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("de", "da", "do", "das", "dos"))
    {
        $name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
        foreach($delimiters as $dlnr => $delimiter)
        {
            $words = explode($delimiter, $name);
            $newWords = array();
            foreach($words as $word)
            {
                if(!in_array($word, $exceptions))
                {
                    $word = ucfirst($word);
                }
                if(in_array(mb_strtolower($word, "UTF-8"), $exceptions))
                {
                    $word = mb_strtolower($word, "UTF-8");
                }
                array_push($newWords, $word);
            }
            $name = join($delimiter, $newWords);
        }
        return $name;
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class)->withPivot('number')->orderByPivot('number', 'asc');
    }
}
