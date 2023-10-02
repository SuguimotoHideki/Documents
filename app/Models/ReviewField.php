<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ReviewField extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function submissionTypes(): BelongsToMany
    {
        return $this->belongsToMany(SubmissionType::class, 'submission_type_review_field', 'review_field_id', 'submission_type_id');
    }
}
