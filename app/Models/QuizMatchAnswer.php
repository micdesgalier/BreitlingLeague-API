<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizMatchAnswer extends Model
{
    use HasFactory;

    // Clé primaire non auto-incrémentée de type string
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Utilisation des timestamps created_at et updated_at par défaut
    public $timestamps = true;

    // Attributs assignables en masse
    protected $fillable = [
        'id',
        'quiz_match_id',
        'quiz_match_participant_id',
        'quiz_match_question_id',
        'choice_code_id',
        'is_correct',
        'answer_date',
    ];

    // Conversion automatique des types des attributs
    protected $casts = [
        'quiz_match_id'             => 'string',
        'quiz_match_participant_id' => 'string',
        'quiz_match_question_id'    => 'string',
        'choice_code_id'            => 'string',
        'is_correct'                => 'boolean',
        'answer_date'               => 'datetime',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Le match auquel cette réponse appartient.
     */
    public function quizMatch(): BelongsTo
    {
        return $this->belongsTo(QuizMatch::class, 'quiz_match_id', 'id');
    }

    /**
     * Le participant ayant fourni cette réponse.
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(QuizMatchParticipant::class, 'quiz_match_participant_id', 'id');
    }

    /**
     * La question du match liée à cette réponse.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizMatchQuestion::class, 'quiz_match_question_id', 'id');
    }

    /**
     * Le choix sélectionné par le participant pour cette réponse.
     */
    public function choice(): BelongsTo
    {
        return $this->belongsTo(Choice::class, 'choice_code_id', 'code_id');
    }
}