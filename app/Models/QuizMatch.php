<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizMatch extends Model
{
    use HasFactory;

    // Clé primaire non auto-incrémentée de type string
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Utilisation de "created_date" pour la date de création, pas de updated_at
    const CREATED_AT = 'created_date';
    const UPDATED_AT = null;

    // Attributs assignables en masse
    protected $fillable = [
        'id',
        'quiz_code_id',
        'next_turn_user_id',
        'status',
    ];

    // Conversion automatique des types des attributs
    protected $casts = [
        'quiz_code_id'     => 'string',
        'created_date'     => 'datetime',
        'next_turn_user_id'=> 'integer',
        'status'           => 'string',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Le quiz auquel ce match est associé.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_code_id', 'code_id');
    }

    /**
     * Les participants à ce match.
     */
    public function participants(): HasMany
    {
        return $this->hasMany(QuizMatchParticipant::class, 'quiz_match_id', 'id');
    }

    /**
     * Les questions liées à ce match.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(QuizMatchQuestion::class, 'quiz_match_id', 'id');
    }

    /**
     * L’utilisateur dont c’est le tour au prochain coup.
     */
    public function nextTurnUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'next_turn_user_id', 'id');
    }
}