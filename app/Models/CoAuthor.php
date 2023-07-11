<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoAuthor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'document_id'
    ];

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
