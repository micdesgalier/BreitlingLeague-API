<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAttemptChoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'user_attempt_question_id',
        'choice_code_id',
        'is_selected',
        'is_correct',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'user_attempt_question_id' => 'integer',
        'choice_code_id'           => 'string',
        'is_selected'              => 'boolean',
        'is_correct'               => 'boolean',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * La question tentée à laquelle cette sélection appartient.
     */
    public function userAttemptQuestion(): BelongsTo
    {
        return $this->belongsTo(UserAttemptQuestion::class, 'user_attempt_question_id', 'id');
    }

    /**
     * Le choix sélectionné/de choix candidat pour la question.
     */
    public function choice(): BelongsTo
    {
        return $this->belongsTo(Choice::class, 'choice_code_id', 'code_id');
    }
}