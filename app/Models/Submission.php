<?php

namespace App\Models;

use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'event_id',
        'document_id',
        'user_id',
        'status',
        'approved_at'
    ];

    protected $sortable = [
        'event_id',
        'document_id',
        'user_id',
        'status',
        'approved_at'
    ];

    public const STATUSES = [
        1 => 'Aprovado',
        2 => 'Reprovado',
        3 => 'Em revisão',
        4 => 'Enviado'
    ];

    public function getStatusID($status)
    {
        return array_search($status, self::STATUSES);
    }

    public function getStatusValue()
    {
        return self::STATUSES[$this->attributes['status']];
    }

    public function setStatus($value)
    {
        $statusID = self::getStatusID($value);
        if($statusID)
        {
            $this->attributes['status'] = $statusID;
        }
    }

    public function formatDate($date)
    {
        if(strtotime($date))
        {
            return Carbon::parse($date)->format('d/m/Y G:i:s');
        }
        elseif($date === null)
        {
            return('Em aguardo');
        }
        else
        {
            return('Invalid date');
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}