<?php

namespace App\Models;

use App\Models\User;
use App\Models\CoAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'author',
        'abstract', 
        'keyword',
        'document_institution',
        'document_type',
        'document',
    ];

    //Defining a relationship with Users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function co_authors(): BelongsToMany
    {
        return $this->belongsToMany(CoAuthor::class, 'co_author_documents', 'co_author', 'document');
    }

    //Get creation date time
    public function getCreatedAttribute()
    {
        return date_format($this->created_at, 'd/m/Y');
    }
}
