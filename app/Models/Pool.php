<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pool extends Model
{
    use HasFactory;

    protected $primaryKey = 'code_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'code_id',
        'stage_code_id',
        'order',
        'number_of_question',
        'consecutive_correct_answer',
        'minimum_correct_question',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'code_id'                    => 'integer',
        'stage_code_id'              => 'integer',
        'order'                      => 'integer',
        'number_of_question'         => 'integer',
        'consecutive_correct_answer' => 'integer',
        'minimum_correct_question'   => 'integer',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Le stage auquel appartient ce pool.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'stage_code_id', 'code_id');
    }

    /**
     * Les questions pivot de ce pool (avec ordre).
     */
    public function poolQuestions(): HasMany
    {
        return $this->hasMany(PoolQuestion::class, 'pool_code_id', 'code_id');
    }

    /**
     * Les questions de ce pool, via la table pivot.
     */
    public function questions(): BelongsToMany
    {
        return $this
            ->belongsToMany(Question::class, 'pool_questions', 'pool_code_id', 'question_code_id')
            ->withPivot('order')
            ->orderBy('pivot_order');
    }
}