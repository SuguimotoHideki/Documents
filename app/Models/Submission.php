<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'event_id',
        'document_id',
        'user_id',
        'status',
        'reviewed_at',
        'score'
    ];

    protected $sortable = [
        'id',
        'document.title',
        'event.name',
        'document.type',
        'status',
        'reviewed_at',
        'created_at',
        'updated_at',
        'score'
    ];

    public const STATUSES = [
        0 => 'Aprovado',
        1 => 'Revisão',
        2 => 'Reprovado',
        3 => 'Enviado'
    ];

    /**
     * Status getters and setters
     */
    public function getStatusID()
    {
        $status = self::STATUSES[$this->attributes['status']];
        return array_search($status, self::STATUSES);
    }

    public function getStatusValue()
    {
        return self::STATUSES[$this->attributes['status']];
    }

    public function setStatus($statusID)
    {
        $this->status = $statusID;

        if(array_key_exists($statusID, self::STATUSES))
            $this->save();
    }

    /**
     * Formats timestamp
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
     * Returns the score
     */
    public function getScore()
    {
        $score = $this->score;

        if($score !== null)
            return number_format($score, 2);
        else
            return "Aguardando avaliação";
    }

    /**
     * Sets submission as reviewed
     */
    public function setReview($revision, $score, $timestamp)
    {
        if($revision)
        {
            $this->attributes['status'] = 1;
            $this->attributes['score'] = 0;
        }
        else
        {
            if($score >= $this->event->passing_grade)
                $this->attributes['status'] = 0;
            else
                $this->attributes['status'] = 2;
            $this->attributes['score'] = $score;
        }
        $this->attributes['reviewed_at'] = $timestamp;
        $this->save();
    }

    /**
     * Sets submission as not reviewed
     */
    public function unsetReview()
    {
        $this->attributes['status'] = 3;
        $this->attributes['score'] = null;
        $this->attributes['reviewed_at'] = null;
        $this->save();
    }

    public function isReviewed()
    {
        $reviewers = $this->document->users()->count();
        $reviews = $this->document->review()->count();
        if($reviewers > 0)
        {
            if($reviewers === $reviews)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Defines many-to-many relationship with User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines many-to-many relationship with Document
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
    
    /**
     * Defines one-to-one relationship with Event
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
