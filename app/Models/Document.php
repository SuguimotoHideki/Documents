<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CoAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

class Document extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'title',
        'user_id',
        'abstract', 
        'keyword',
        'document_institution',
        'document_type',
        'document',
    ];

    public $sortable = [
        'id',
        'title',
        'user_id',
        'abstract', 
        'keyword',
        'document_institution',
        'document_type',
        'created_at',
        'updated_at'
    ];

    public function formatDate($date)
    {
        if(strtotime($date))
        {
            return Carbon::parse($date)->format('d/m/Y G:i:s');
        }
        else
        {
            return('Invalid date');
        }
    }

    //Defining a relationship with Users
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'document_user', 'document_id', 'user_id');
    }

    public function coAuthors(): BelongsToMany
    {
        return $this->belongsToMany(CoAuthor::class, 'co_authors_documents', 'document_id', 'co_author_id')->withPivot('number')->orderByPivot('number', 'asc');
    }

    public function submission(): HasOne
    {
        return $this->hasOne(Submission::class);
    }

    //Get creation date time
    public function getCreatedAttribute()
    {
        return date_format($this->created_at, 'd/m/Y');
    }
}
