<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kyslik\ColumnSortable\Sortable;

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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }
}
