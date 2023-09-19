<?php

namespace App\Models;

use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'name',
        'website',
        'information',
        'paper_topics',
        'email',
        'status',
        'published',
        'logo',
        'submission_type',
        'organizer', 
        'organizer_email', 
        'organizer_website',
        'subscription_start',
        'subscription_deadline',
        'submission_start',
        'submission_deadline',
    ];

    public $sortable = [
        'id',
        'name',
        'website',
        'information',
        'paper_topics',
        'email',
        'status',
        'published',
        'logo',
        'submission_type',
        'organizer', 
        'organizer_email', 
        'organizer_website',
        'subscription_start',
        'subscription_deadline',
        'submission_start',
        'submission_deadline',
    ];

    public const STATUSES = [
        0 => 'Em breve',
        1 => 'Encerrado',
        2 => 'Inscrições abertas',
        3 => 'Inscrições encerradas',
        4 => 'Submissões abertas',
        5 => 'Submissões encerradas',
        6 => 'Adiado',
        7 => 'Cancelado',
    ];

    public const TYPES = [
        'Artigo',
        'Resumo',
        'TCC',
        'Monografia'
    ];

    /**
     * Returns formated date to d/m/Y
     */
    public function getSubscriptionDates()
    {
        $start = Carbon::parse($this->subscription_start)->format('d/m/Y');
        $end = Carbon::parse($this->subscription_deadline)->format('d/m/Y');
        
        $string = ($start ." - " . $end);

        return $string;
    }

    public function getSubmissionDates()
    {
        $start = Carbon::parse($this->submission_start)->format('d/m/Y');
        $end = Carbon::parse($this->submission_deadline)->format('d/m/Y');
        
        $string = ($start ." - " . $end);

        return $string;
    }

    public function formatDateTime($date)
    {
        if(strtotime($date))
        {
            return Carbon::parse($date)->format('d/m/Y - G:i:s');
        }
        else
        {
            return('Invalid date');
        }
    }

    public function formatDate($date)
    {
        if(strtotime($date))
        {
            return Carbon::parse($date)->format('l, d \d\e F \d\e Y');
        }
        else
        {
            return('Invalid date');
        }
    }

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

    public function setStatus()
    {
        $statusID = self::getStatusID();
        if($statusID)
        {
            $this->attributes['status'] = $statusID;
        }
    }

    /**
     * Returns list of submission types
     */
    public function getSubmissionTypes()
    {
        $types = explode(",", $this->submission_types);
        dd($types);
    }

    /**
     * Updates the status depending on the set dates (MUST OVERHAUL LATER)
     */
    public function updateStatus()
    {
        if($this->getStatusID() < 6)
        {
            $today = Carbon::today();
        
            if($today < $this->submission_start)
            {
                if($today < $this->subscription_start)
                {
                    $this->status = 0;
                }
                else if($today >= $this->subscription_start && $today <= $this->subscription_deadline)
                {
                    $this->status = 2;
                }
                else if($today > $this->subscription_deadline)
                {
                    $this->status = 3;
                }
            }
            else
            {
                if($today >= $this->submission_start && $today <= $this->submission_deadline)
                {
                    $this->status = 4;
                }
                else if($today > $this->submission_deadline)
                {
                    $this->status = 5;
                }
            }
            $this->save();
        }
        
        return $this->getStatusValue();
    }

    /**
     * Checks if a given user is subscribbed to the event
     */
    public function hasUser(User $user)
    {
        return $this->users()
        ->where('user_id', $user->id)
        ->exists();
    }

    /**
     * Returns a given user's submission to a given event
     */
    public function userSubmission(User $user)
    {
        $userId = $user->id;
        
        return $this->submission()
        ->where('user_id', $userId)
        ->first();
    }

    /**
     * Returns the number of subscribers in an event
     */
    public function subscriptionCount()
    {
        return $this->users()->count();
    }

    /**
     * Defines many-to-many relationship with User, for subscriptions
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')->withPivot(['id', 'created_at']);
    }

    /**
     * Defines one-to-one relationship with Submission
     */
    public function submission(): HasOne
    {
        return $this->hasOne(Submission::class);
    }

    /**
     * Defines many-to-many relationship with User, for moderators
     */
    public function moderators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_moderator', 'event_id', 'user_id');
    }
}
