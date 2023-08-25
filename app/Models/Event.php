<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'event_name',
        'event_website',
        'event_information',
        'paper_topics',
        'event_email',
        'event_status',
        'event_published',
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
        'event_name',
        'event_website',
        'event_information',
        'paper_topics',
        'event_email',
        'event_status',
        'event_published',
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

    /**
     * Returns formated date to d/m/Y
     */
    public function formatDate($date)
    {
        if(strtotime($date))
        {
            return Carbon::parse($date)->format('d/m/Y');
        }
        else
        {
            return('Invalid date');
        }
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

    public function getStatusID($status)
    {
        return array_search($status, self::STATUSES);
    }

    public function getStatusValue()
    {
        return self::STATUSES[$this->attributes['event_status']];
    }

    public function setStatus($value)
    {
        $statusID = self::getStatusID($value);
        if($statusID)
        {
            $this->attributes['event_status'] = $statusID;
        }
    }
    /**
     * Updates the status depending on the set dates
     */
    public function updateStatus()
    {
        if($this->getStatusID($this->getStatusValue()) < 6)
        {
            $today = Carbon::today();
        
            if($today < $this->submission_start)
            {
                if($today < $this->subscription_start)
                {
                    $this->event_status = 0;
                }
                else if($today >= $this->subscription_start && $today <= $this->subscription_deadline)
                {
                    $this->event_status = 2;
                }
                else if($today > $this->subscription_deadline)
                {
                    $this->event_status = 3;
                }
            }
            else
            {
                if($today >= $this->submission_start && $today <= $this->submission_deadline)
                {
                    $this->event_status = 4;
                }
                else if($today > $this->submission_deadline)
                {
                    $this->event_status = 5;
                }
            }
            $this->save();
        }
        
        return $this->getStatusValue();
    }

    public function hasUser(User $user)
    {
        return $this->users()
        ->where('user_id', $user->id)
        ->exists();
    }

    public function subscriptionData(User $user)
    {
        $subscription = DB::table('event_user')
        ->where('event_id', $this->id)
        ->where('user_id', $user->id);

        $data = [
            'id' => $subscription->value('id'),
            'created_at' => $this->formatDateTime($subscription->value('created_at')),
        ];

        return $data;
    }

    public function userSubmission(User $user)
    {
        $userId = $user->id;
        
        return $this->submission()
        ->where('user_id', $userId)
        ->first();
    }

    public function subscriptionCount()
    {
        return $this->users()->count();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }

    public function submission(): HasOne
    {
        return $this->hasOne(Submission::class);
    }

    public function moderators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_moderator', 'event_id', 'user_id');
    }
}
