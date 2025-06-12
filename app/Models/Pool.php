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

    // Clé primaire personnalisée (non auto-incrémentée, de type string)
    protected $primaryKey = 'code_id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Attributs pouvant être assignés en masse.
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
     * Conversion automatique des attributs en types natifs.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'code_id'                    => 'string',
        'stage_code_id'              => 'string',
        'order'                      => 'integer',
        'number_of_question'         => 'integer',
        'consecutive_correct_answer' => 'integer',
        'minimum_correct_question'   => 'integer',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Le stage auquel ce pool est rattaché.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class, 'stage_code_id', 'code_id');
    }

    /**
     * Les entrées pivot PoolQuestion liées à ce pool (contiennent l'ordre des questions).
     */
    public function poolQuestions(): HasMany
    {
        return $this->hasMany(PoolQuestion::class, 'pool_code_id', 'code_id');
    }

    /**
     * Les questions associées à ce pool via la table pivot 'pool_questions', ordonnées.
     */
    public function questions(): BelongsToMany
    {
        return $this
            ->belongsToMany(Question::class, 'pool_questions', 'pool_code_id', 'question_code_id')
            ->withPivot('order')
            ->orderBy('pivot_order');
    }
}