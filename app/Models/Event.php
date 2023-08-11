<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public static $eventStatuses = [
        'Em breve',
        'Encerrado',
        'Inscrições abertas',
        'Inscrições encerradas',
        'Submissões abertas',
        'Submissões encerradas',
        'Adiado',
        'Cancelado',
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

    /**
     * Updates the status depending on the set dates
     */
    public function getStatus()
    {
        return $this->event_status;
    }

    /**
     * Updates the status depending on the set dates
     */
    public function updateStatus()
    {
        if($this->event_status !== self::$eventStatuses[6] & $this->event_status !== self::$eventStatuses[7])
        {
            $today = Carbon::today();
        
            if($today < $this->submission_start)
            {
                if($today < $this->subscription_start)
                {
                    $this->event_status = self::$eventStatuses[0];
                }
                else if($today >= $this->subscription_start && $today <= $this->subscription_deadline)
                {
                    $this->event_status = self::$eventStatuses[2];
                }
                else if($today > $this->subscription_deadline)
                {
                    $this->event_status = self::$eventStatuses[3];
                }
            }
            else
            {
                if($today >= $this->submission_start && $today <= $this->submission_deadline)
                {
                    $this->event_status = self::$eventStatuses[4];
                }
                else if($today > $this->submission_deadline)
                {
                    $this->event_status = self::$eventStatuses[5];
                }
            }
            $this->save();
        }
        
        return $this->event_status;
    }

    public function hasUser()
    {
        return $this->users()
        ->where('user_id', Auth::user()->id)
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

    public function subscriptionCount()
    {
        return $this->users()->count();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }
}
