<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizMatchParticipant extends Model
{
    use HasFactory;

    // Si votre table s’appelle différemment, décommentez et ajustez :
    // protected $table = 'quiz_match_participants';

    // Clé primaire auto-incrémentée par défaut (id)
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Si vous n’utilisez pas les timestamps created_at/updated_at, mettez false
    public $timestamps = true;

    /**
     * Attributs "mass assignable".
     *
     * @var array<int,string>
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
     * Casts des attributs.
     *
     * @var array<string,string>
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
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Le match associé à ce participant.
     *
     * @return BelongsTo
     */
    public function quizMatch(): BelongsTo
    {
        return $this->belongsTo(QuizMatch::class, 'quiz_match_id', 'id');
    }

    /**
     * L’utilisateur associé à ce participant.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Les réponses de ce participant pour les questions du match.
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(QuizMatchAnswer::class, 'quiz_match_participant_id', 'id');
    }
}