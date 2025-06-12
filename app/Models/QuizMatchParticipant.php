<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizMatchParticipant extends Model
{
    use HasFactory;

    // Clé primaire non auto-incrémentée de type string
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Utilisation des timestamps created_at et updated_at
    public $timestamps = true;

    /**
     * Attributs pouvant être assignés en masse.
     */
    protected $fillable = [
        'id',
        'quiz_match_id',
        'user_id',
        'invitation_state',
        'last_answer_date',
        'score',
        'points_bet',
        'is_winner',
    ];

    /**
     * Conversion automatique des types des attributs.
     */
    protected $casts = [
        'quiz_match_id'    => 'string',
        'user_id'          => 'integer',
        'invitation_state' => 'string',
        'last_answer_date' => 'datetime',
        'score'            => 'integer',
        'points_bet'       => 'integer',
        'is_winner'        => 'boolean',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Le match auquel ce participant est rattaché.
     */
    public function quizMatch(): BelongsTo
    {
        return $this->belongsTo(QuizMatch::class, 'quiz_match_id', 'id');
    }

    /**
     * L'utilisateur correspondant à ce participant.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Les réponses données par ce participant lors du match.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(QuizMatchAnswer::class, 'quiz_match_participant_id', 'id');
    }
}