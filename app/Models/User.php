<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Document;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'cpf',
        'user_email',
        'password',
        'birth_date',
        'user_institution',
        'user_phone_number',
    ];

    protected $sortable = [
        'id',
        'user_name',
        'cpf',
        'user_email',
        'password',
        'birth_date',
        'user_institution',
        'user_phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns formated birth date
     */
    public function getBirthDate()
    {
        return Carbon::parse($this->birth_date)->format('d/m/Y');
    }

    /**
     * Formats timestamps
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
     * Checks if the user has a submission in a given event
     */
    public function eventSubmission(Event $event)
    {
        return $this->submission()
        ->where('event_id', $event->id)
        ->first();
    }

    /**
     * Checks if the user is a moderator of a given event
     */
    public function isModerator(Event $event)
    {
        return $this->eventsModerated()
        ->where('event_id', $event->id)
        ->exists();
    }

    /**
     * Defines many-to-many relationship with Document
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function getRoles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'role_id', 'model_id');
    }

    /**
     * Defines many-to-many relationship with Event for subscriptions
     */
    public function events()
    {
        return $this->belongsToMany(Event::class)->withPivot(['id', 'created_at']);
    }

    /**
     * Defines many-to-many relationship with Event for moderators
     */
    public function eventsModerated()
    {
        return $this->belongsToMany(Event::class, 'event_moderator', 'user_id', 'event_id');
    }

    /**
     * Defines one-to-one relationship with Submission
     */
    public function submission(): HasOne
    {
        return $this->hasOne(Submission::class);
    }
}
