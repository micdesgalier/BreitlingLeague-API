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
     * Si votre table ne suit pas le nom standard « activity_results »,
     * décommentez et ajustez la ligne suivante :
     */
    // protected $table = 'activity_result';

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
        'duration',
    ];

    /**
     * Les casts pour convertir automatiquement les types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'duration' => 'integer',
    ];

    // ========================
    // === RELATIONS =========
    // ========================

    /**
     * L’activité de groupe (UserActivityGroupActivity) à laquelle
     * ce résultat est rattaché.
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
     * Le détail du résultat quiz (score, nb bonnes réponses).
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