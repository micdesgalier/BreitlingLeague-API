<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAttempt extends Model
{
    use HasFactory;

    /**
     * Attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'quiz_code_id',
        'user_id',
        'is_completed',
        'duration',
        'score',
        'initial_score',
        'combo_bonus_score',
        'time_bonus_score',
    ];

    /**
     * Casts permettant de convertir automatiquement les attributs dans les bons types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date'         => 'datetime',
        'end_date'           => 'datetime',
        'quiz_code_id'       => 'string',
        'user_id'            => 'integer',
        'is_completed'       => 'boolean',
        'duration'           => 'integer',
        'score'              => 'integer',
        'initial_score'      => 'integer',
        'combo_bonus_score'  => 'integer',
        'time_bonus_score'   => 'integer',
    ];

    // ========================
    // ===== RELATIONS ========
    // ========================

    /**
     * L'utilisateur qui a effectué cette tentative.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Le quiz auquel cette tentative est associée.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_code_id', 'code_id');
    }

    /**
     * Les réponses associées à cette tentative.
     */
    public function userAttemptQuestions(): HasMany
    {
        return $this->hasMany(UserAttemptQuestion::class, 'user_attempt_id', 'id');
    }
}