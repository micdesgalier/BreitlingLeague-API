<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizActivityResult extends Model
{
    use HasFactory;

    /**
     * Désactive les timestamps si vous n’avez pas de created_at / updated_at.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Les attributs assignables en masse.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'score',
        'correct_answer_count',
        'activity_result_id',
    ];

    /**
     * Les casts pour convertir automatiquement les types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'score'                 => 'float',
        'correct_answer_count'  => 'integer',
        'activity_result_id'    => 'integer',
    ];

    // ========================
    // === RELATIONS =========
    // ========================

    /**
     * Le résultat d’activité auquel ce détail de quiz est rattaché.
     */
    public function activityResult(): BelongsTo
    {
        return $this->belongsTo(
            ActivityResult::class,
            'activity_result_id',
            'id'
        );
    }
}