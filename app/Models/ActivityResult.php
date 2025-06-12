<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ActivityResult extends Model
{
    use HasFactory;

    /**
     * Désactive la gestion automatique des timestamps (created_at, updated_at)
     * car la table ne les contient pas.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Attributs pouvant être assignés en masse.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'duration',
    ];

    /**
     * Cast des attributs pour forcer leur type.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'duration' => 'integer',
    ];

    // ========================
    // === RELATIONS ===========
    // ========================

    /**
     * Relation "appartient à" vers l'activité de groupe (UserActivityGroupActivity)
     * liée à ce résultat d'activité.
     *
     * Note : la clé locale 'id' est reliée à 'activity_result_id' dans UserActivityGroupActivity.
     *
     * @return BelongsTo
     */
    public function userActivityGroupActivity(): BelongsTo
    {
        return $this->belongsTo(
            UserActivityGroupActivity::class,
            'id',
            'activity_result_id'
        );
    }

    /**
     * Relation "un à un" vers le détail du résultat quiz
     * (ex : score, nombre de bonnes réponses).
     *
     * @return HasOne
     */
    public function quizActivityResult(): HasOne
    {
        return $this->hasOne(
            QuizActivityResult::class,
            'activity_result_id',
            'id'
        );
    }
}