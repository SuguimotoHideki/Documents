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
     * Defines relationship with Document
     */
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function getRoles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'role_id', 'model_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function eventsModerated()
    {
        return $this->belongsToMany(Event::class, 'event_moderator', 'user_id', 'event_id');
    }

    public function submission(): HasOne
    {
        return $this->hasOne(Submission::class);
    }
}
