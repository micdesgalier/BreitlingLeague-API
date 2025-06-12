<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;

    // Clé primaire personnalisée, non auto-incrémentée, de type string
    protected $primaryKey = 'code_id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Champs assignables en masse
    protected $fillable = [
        'code_id',
        'label',
        'is_active',
        'media_id',
        'type',
        'is_choice_shuffle',
        'correct_value',
    ];

    // Conversion automatique des types
    protected $casts = [
        'code_id'           => 'string',
        'label'             => 'string',
        'is_active'         => 'boolean',
        'media_id'          => 'integer',
        'type'              => 'string',
        'is_choice_shuffle' => 'boolean',
        'correct_value'     => 'string',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Les choix liés à cette question.
     */
    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class, 'question_code_id', 'code_id');
    }

    /**
     * Les entrées pivot PoolQuestion associées à cette question.
     */
    public function poolQuestions(): HasMany
    {
        return $this->hasMany(PoolQuestion::class, 'question_code_id', 'code_id');
    }

    /**
     * Les pools contenant cette question via la table pivot.
     */
    public function pools(): BelongsToMany
    {
        return $this
            ->belongsToMany(Pool::class, 'pool_questions', 'question_code_id', 'pool_code_id')
            ->withPivot('order')
            ->orderBy('pivot_order');
    }

    /**
     * Les réponses données par les utilisateurs pour cette question.
     */
    public function userAttemptQuestions(): HasMany
    {
        return $this->hasMany(UserAttemptQuestion::class, 'question_code_id', 'code_id');
    }
}