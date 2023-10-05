<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'score',
        'comment',
        'moderator_comment',
        'recommendation',
        'attachment',
        'user_id',
        'document_id'
    ];

    public const RECOMMENDATIONS = [
        0 => 'Aprovado',
        1 => 'Revisão',
        2 => 'Reprovado',
    ];

    /**
     * Status getters and setters
     */
    public function getStatusID()
    {
        $status = self::RECOMMENDATIONS[$this->attributes['recommendation']];
        return array_search($status, self::RECOMMENDATIONS);
    }

    public function getStatusValue()
    {
        return self::RECOMMENDATIONS[$this->attributes['recommendation']];
    }

    public function setStatus()
    {
        $statusID = self::getStatusID();
        if($statusID)
        {
            $this->attributes['recommendation'] = $statusID;
        }
    }

    /**
     * Format timestamps
     */
    public function formatDate($date)
    {
        if(strtotime($date))
        {
            return Carbon::parse($date)->format('d/m/Y G:i:s');
        }
        elseif($date === null)
        {
            return('Aguardando avaliação');
        }
        else
        {
            return('Invalid date');
        }
    }
    
    /**
     * Defines one-to-one relationship with Document
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
    
    /**
     * Defines one-to-one relationship with User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines many-to-many relationship with ReviewField
     */
    public function reviewFields(): BelongsToMany
    {
        return $this->belongsToMany(ReviewField::class, 'review_review_field', 'review_id', 'review_field_id')->withPivot('score');
    }

    /**
     * Returns field score if available in the pivot table
     */
    public function getScore(ReviewField $field)
    {
        if($this->reviewFields->contains($field))
        {
            return $field->reviews->where('id', $this->id)->first()->pivot->score;
        }
        return -1;
    }
}
