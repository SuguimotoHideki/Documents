<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'website', 'email', 'institution', 'sub_events', 'subscription_deadline', 'submission_deadline'];
}
