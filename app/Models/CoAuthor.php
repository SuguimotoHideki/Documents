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

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
