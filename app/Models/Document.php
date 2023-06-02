<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'author',
        'advisor', 
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

    //Get creation date time
    public function getCreatedAttribute()
    {
        return date_format($this->created_at, 'd/m/Y');
    }
}
