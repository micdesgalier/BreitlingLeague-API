<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAttemptChoice extends Model
{
    use HasFactory;

    /**
     * Attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_attempt_question_id',
        'choice_code_id',
        'is_selected',
        'is_correct',
    ];

    /**
     * Casts automatiques des attributs dans les bons types PHP.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_attempt_question_id' => 'integer',
        'choice_code_id'           => 'string',
        'is_selected'              => 'boolean',
        'is_correct'               => 'boolean',
    ];

    // ========================
    // ===== RELATIONS ========
    // ========================

    /**
     * La question à laquelle cette réponse est liée.
     */
    public function userAttemptQuestion(): BelongsTo
    {
        return $this->belongsTo(UserAttemptQuestion::class, 'user_attempt_question_id', 'id');
    }

    /**
     * Le choix (réponse possible) concerné par cette sélection.
     */
    public function choice(): BelongsTo
    {
        return $this->belongsTo(Choice::class, 'choice_code_id', 'code_id');
    }
}