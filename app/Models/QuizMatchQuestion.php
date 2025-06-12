<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizMatchQuestion extends Model
{
    use HasFactory;

    // Clé primaire de type string, non auto-incrémentée
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Utilisation automatique des timestamps (created_at, updated_at)
    public $timestamps = true;

    /**
     * Attributs pouvant être assignés en masse.
     */
    protected $fillable = [
        'id',
        'quiz_match_id',
        'question_code_id',
        'order',
    ];

    /**
     * Conversion automatique des types des attributs.
     */
    protected $casts = [
        'quiz_match_id'     => 'string',
        'question_code_id'  => 'string',
        'order'             => 'integer',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Le match auquel cette question est associée.
     */
    public function quizMatch(): BelongsTo
    {
        return $this->belongsTo(QuizMatch::class, 'quiz_match_id', 'id');
    }

    /**
     * La question liée à cette instance de match.
     * Référence à Question::code_id.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_code_id', 'code_id');
    }

    /**
     * Les réponses fournies par les participants pour cette question.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(QuizMatchAnswer::class, 'quiz_match_question_id', 'id');
    }
}