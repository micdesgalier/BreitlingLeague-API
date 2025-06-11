<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizMatchQuestion extends Model
{
    use HasFactory;

    // Si la table s'appelle différemment, décommentez et ajustez :
    // protected $table = 'quiz_match_questions';

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
        'id',
        'quiz_match_id',
        'question_code_id',
        'order',
    ];

    /**
     * Casts des attributs.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'quiz_match_id'     => 'string',
        'question_code_id'  => 'string',
        'order'             => 'integer',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Le match associé à cette entrée.
     *
     * @return BelongsTo
     */
    public function quizMatch(): BelongsTo
    {
        return $this->belongsTo(QuizMatch::class, 'quiz_match_id', 'id');
    }

    /**
     * La question associée dans le quiz (référence à Question::code_id).
     *
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        // Le modèle Question utilise 'code_id' comme primaryKey
        return $this->belongsTo(Question::class, 'question_code_id', 'code_id');
    }

    /**
     * Les réponses données pour cette question par les participants.
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(QuizMatchAnswer::class, 'quiz_match_question_id', 'id');
    }
}