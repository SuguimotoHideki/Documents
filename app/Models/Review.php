<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'score',
        'comment',
        'moderator_comment',
        'recommendation',
        'attachment',
        'user_id',
        'document_id'
    ];

    public const RECOMMENDATIONS = [
        0 => 'Aprovado',
        1 => 'Revisão',
        2 => 'Reprovado',
    ];

    /**
     * Status getters and setters
     */
    public function getStatusID()
    {
        $status = self::RECOMMENDATIONS[$this->attributes['recommendation']];
        return array_search($status, self::RECOMMENDATIONS);
    }

    public function getStatusValue()
    {
        return self::RECOMMENDATIONS[$this->attributes['recommendation']];
    }

    public function setStatus()
    {
        $statusID = self::getStatusID();
        if($statusID)
        {
            $this->attributes['recommendation'] = $statusID;
        }
    }

    /**
     * Formats timestamp
     */
    public function formatDate($date)
    {
        if(strtotime($date))
        {
            return Carbon::parse($date)->format('d/m/Y G:i:s');
        }
        elseif($date === null)
        {
            return('Aguardando avaliação');
        }
        else
        {
            return('Invalid date');
        }
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}