<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    // Clé primaire personnalisée, non auto-incrémentée, de type string
    protected $primaryKey = 'code_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Champs assignables en masse
    protected $fillable = [
        'code_id',
        'type',
        'label_translation_code_id',
        'shuffle_type',
        'shuffle_scope',
        'draw_type',
        'max_user_attempt',
        'is_unlimited',
        'duration',
        'question_duration',
        'correct_choice_points',
        'wrong_choice_points',
    ];

    // Conversion automatique des types
    protected $casts = [
        'code_id'                   => 'string',
        'type'                      => 'string',
        'label_translation_code_id' => 'integer',
        'shuffle_type'              => 'string',
        'shuffle_scope'             => 'string',
        'draw_type'                 => 'string',
        'max_user_attempt'          => 'integer',
        'is_unlimited'              => 'boolean',
        'duration'                  => 'integer',
        'question_duration'         => 'integer',
        'correct_choice_points'     => 'integer',
        'wrong_choice_points'       => 'integer',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Les stages (niveaux) liés à ce quiz.
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class, 'quiz_code_id', 'code_id');
    }

    /**
     * Les tentatives des utilisateurs pour ce quiz.
     */
    public function userAttempts(): HasMany
    {
        return $this->hasMany(UserAttempt::class, 'quiz_code_id', 'code_id');
    }

    /**
     * Les duels (quiz matches) associés à ce quiz.
     */
    public function quizMatches(): HasMany
    {
        return $this->hasMany(QuizMatch::class, 'quiz_code_id', 'code_id');
    }
}