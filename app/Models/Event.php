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
        'organizer', 
        'organizer_email', 
        'organizer_website',
        'subscription_start',
        'subscription_deadline',
        'submission_start',
        'submission_deadline',
    ];

    public $sortable = [
        'event_name',
        'event_website',
        'event_information',
        'paper_topics',
        'event_email',
        'event_status',
        'organizer', 
        'organizer_email', 
        'organizer_website',
        'subscription_start',
        'subscription_deadline',
        'submission_start',
        'submission_deadline',
    ];

    protected static $eventStates = [
        'Em breve',
        'Registros abertos',
        'Registros encerrados',
        'Submissões abertas',
        'Submissões encerradas',
        'Cancelado',
        'Adiado'
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
    public static function getStatus()
    {
        return self::$eventStates;
    }

    /**
     * Updates the status depending on the set dates
     */
    public function updateStatus()
    {
        $today = Carbon::today();

        if($today > $this->subscription_start)
        {
            $this->event_status = self::$eventStates[1];
        }
        else if($today > $this->subscription_end)
        {
            $this->event_status = self::$eventStates[2];
        }
        else if($today > $this->submission_start)
        {
            $this->event_status = self::$eventStates[3];
        }
        else if($today > $this->submission_deadline)
        {
            $this->event_status = self::$eventStates[4];
        }
        $this->save();
        return $this->event_status;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }
}
