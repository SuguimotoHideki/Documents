<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'start_date',
        'end_date'
    ];
}
