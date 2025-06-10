<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizMatchAnswer extends Model
{
    use HasFactory;

    // Si la table s'appelle différemment, décommentez et ajustez :
    // protected $table = 'quiz_match_answers';

    // Clé primaire auto-incrémentée par défaut
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Utilisation des timestamps created_at/updated_at par défaut
    public $timestamps = true;

    /**
     * Attributs "mass assignable".
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'quiz_match_id',
        'quiz_match_participant_id',
        'quiz_match_question_id',
        'choice_code_id',
        'is_correct',
        'answer_date',
    ];

    /**
     * Casts des attributs.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'quiz_match_id'              => 'string',
        'quiz_match_participant_id'  => 'string',
        'quiz_match_question_id'     => 'string',
        'choice_code_id'             => 'string',
        'is_correct'                 => 'boolean',
        'answer_date'                => 'datetime',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Le match associé à cette réponse.
     *
     * @return BelongsTo
     */
    public function quizMatch(): BelongsTo
    {
        return $this->belongsTo(QuizMatch::class, 'quiz_match_id', 'id');
    }

    /**
     * Le participant qui a donné cette réponse.
     *
     * @return BelongsTo
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(QuizMatchParticipant::class, 'quiz_match_participant_id', 'id');
    }

    /**
     * La question du match associée à cette réponse.
     *
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizMatchQuestion::class, 'quiz_match_question_id', 'id');
    }

    /**
     * Le choix sélectionné par le participant.
     *
     * @return BelongsTo
     */
    public function choice(): BelongsTo
    {
        // Le modèle Choice utilise 'code_id' comme primaryKey
        return $this->belongsTo(Choice::class, 'choice_code_id', 'code_id');
    }
}