<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubmissionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_submission_type', 'submission_type_id', 'event_id');
    }

    public function document(): HasOne
    {
        return $this->hasOne(Document::class);
    }
}
