<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAttemptQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'user_attempt_id',
        'order',
        'is_correct',
        'score',
        'question_code_id',
        'combo_bonus_value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'user_attempt_id'    => 'integer',
        'order'              => 'integer',
        'is_correct'         => 'boolean',
        'score'              => 'integer',
        'question_code_id'   => 'string',
        'combo_bonus_value'  => 'integer',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * La tentative de quiz statique à laquelle appartient cette question.
     */
    public function userAttempt(): BelongsTo
    {
        return $this->belongsTo(UserAttempt::class, 'user_attempt_id', 'id');
    }

    /**
     * La question associée à cette entrée.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_code_id', 'code_id');
    }

    /**
     * Les choix faits par l'utilisateur pour cette question.
     */
    public function userAttemptChoices(): HasMany
    {
        return $this->hasMany(UserAttemptChoice::class, 'user_attempt_question_id', 'id');
    }
}