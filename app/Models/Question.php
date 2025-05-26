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

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'code_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'code_id',
        'label_translation_code_id',
        'is_active',
        'media_id',
        'type',
        'is_choice_shuffle',
        'correct_value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'code_id'                    => 'integer',
        'label_translation_code_id'  => 'integer',
        'is_active'                  => 'boolean',
        'media_id'                   => 'integer',
        'type'                       => 'string',
        'is_choice_shuffle'          => 'boolean',
        'correct_value'              => 'string',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Les choix possibles pour cette question.
     */
    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class, 'question_code_id', 'code_id');
    }

    /**
     * Les entrées pivot PoolQuestion pour ordonnancer la question dans les pools.
     */
    public function poolQuestions(): HasMany
    {
        return $this->hasMany(PoolQuestion::class, 'question_code_id', 'code_id');
    }

    /**
     * Les pools contenant cette question.
     */
    public function pools(): BelongsToMany
    {
        return $this
            ->belongsToMany(Pool::class, 'pool_questions', 'question_code_id', 'pool_code_id')
            ->withPivot('order')
            ->orderBy('pivot_order');
    }

    /**
     * Les réponses dans les tentatives utilisateur pour cette question.
     */
    public function userAttemptQuestions(): HasMany
    {
        return $this->hasMany(UserAttemptQuestion::class, 'question_code_id', 'code_id');
    }

    /**
     * Le média associé à la question (optionnel).
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }
}
