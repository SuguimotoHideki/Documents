<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CoAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Kyslik\ColumnSortable\Sortable;

class Document extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'title',
        'user_id',
        'keyword',
        'institution',
        'submission_type_id',
        'attachment_author',
        'attachment_no_author'
    ];

    public $sortable = [
        'id',
        'title',
        'user_id',
        'keyword',
        'institution',
        'submission_type_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Formats timestamps
     */
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

    /**
     * Defines many-to-many relationship with User
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'document_user', 'document_id', 'user_id');
    }

    /**
     * Defines many-to-many relationship with CoAuthor
     */
    public function coAuthors(): BelongsToMany
    {
        return $this->belongsToMany(CoAuthor::class, 'co_authors_documents', 'document_id', 'co_author_id')->withPivot('number')->orderByPivot('number', 'asc');
    }

    /**
     * Defines many-to-many relationship with Submission
     */
    public function submission(): HasOne
    {
        return $this->hasOne(Submission::class);
    }

    /**
     * Defines one-to-one relationship with Review
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Defines one-to-one relationship with SubmissionType
     */
    public function submissionType(): BelongsTo
    {
        return $this->belongsTo(SubmissionType::class);
    }

    /**
     * Queries document models by title, id or author's name
     */
    public function scopegetAllDocuments($query, $search)
    {
        if($search !== null)
        {
            return $query->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('id', $search)
            ->orWhereHas('submission', function($submissionQuery) use($search){
                $submissionQuery->WhereHas('user', function($userQuery) use($search){
                    $userQuery->where('user_name', 'LIKE', '%' . $search . '%');
                });
            });
        }
        else
            return Document::sortable();
    }

    /**
     * Queries document models by title or id for reviewer users
     */
    public function scopegetReviewerDocuments($query, $search, $user)
    {
        $doc = $user->documents()->sortable();
        if($search !== null)
            $doc = $doc->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('document_id', $search);
        return $doc;
    }

    public function scopegetModeratedDocuments($query, $search, $user)
    {
        if($search !== null)
        {
            return $query->whereHas('Submission.Event.Moderators', function($modQuery) use ($user){
                $modQuery->where('event_moderator.user_id', $user->id);
            })
            ->whereHas('Submission.User', function ($authorQuery) use ($search) {
                $authorQuery->where('user_name', 'LIKE', '%' . $search . '%')
                ->orWhere('title', 'LIKE', '%'. $search . '%')
                ->orWhere('documents.id', $search);
            });
        }
        return $query->whereHas('Submission.Event.Moderators', function($query) use ($user){
            $query->where('user_id', $user->id);
        })->select('documents.*');
    }
}