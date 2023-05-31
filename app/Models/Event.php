<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_website',
        'event_information',
        'paper_topics',
        'paper_tracks', 
        'event_email',
        'event_status',
        'organizer', 
        'organizer_email', 
        'organizer_website',
        'subscription_deadline',
        'submission_deadline',
        'event_start',
        'event_end'
    ];

    protected static $eventStates = [
        'Em breve',
        'Registro e Submissão abertas',
        'Registro e Submissão encerradas',
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

        if($today > $this->event_start)
        {
            $this->event_status = self::$eventStates[1];
        }
        else if($today > $this->event_end)
        {
            $this->event_status = self::$eventStates[2];
        }

        $this->save();
        return $this->event_status;
    }
}
