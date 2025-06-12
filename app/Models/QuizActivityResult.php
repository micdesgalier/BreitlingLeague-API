<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizActivityResult extends Model
{
    use HasFactory;

    // Désactive la gestion automatique des timestamps (created_at, updated_at)
    public $timestamps = false;

    // Attributs assignables en masse
    protected $fillable = [
        'score',
        'correct_answer_count',
        'activity_result_id',
    ];

    // Conversion automatique des types des attributs
    protected $casts = [
        'score'                => 'float',
        'correct_answer_count' => 'integer',
        'activity_result_id'   => 'integer',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Relation vers le résultat d’activité associé à ce résultat de quiz.
     */
    public function activityResult(): BelongsTo
    {
        return $this->belongsTo(ActivityResult::class, 'activity_result_id', 'id');
    }
}