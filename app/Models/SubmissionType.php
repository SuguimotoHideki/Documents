<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SubmissionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_submission_type', 'event_id', 'submission_type_id');
    }
}
