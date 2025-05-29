<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserActivityGroupActivity extends Model
{
    use HasFactory;

    /**
     * Si votre table ne suit pas la convention plurielle standard,
     * décommentez et ajustez la ligne suivante :
     */
    // protected $table = 'user_activity_group_activities';

    /**
     * Clé primaire non standard (ici « id », donc facultatif).
     *
     * @var string
     */
    // protected $primaryKey = 'id';

    /**
     * Désactive les timestamps si vous n'avez pas created_at / updated_at.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Attributs assignables en masse.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'progression_score',
        'progression_score_percent',
        'external_id',
        'user_id',
        'activity_group_activity_id',
        'activity_result_id',
    ];

    /**
     * Casts pour convertir automatiquement les types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'start_date'                  => 'datetime',
        'end_date'                    => 'datetime',
        'progression_score'           => 'float',
        'progression_score_percent'   => 'float',
        'external_id'                 => 'integer',
        'user_id'                     => 'integer',
        'activity_group_activity_id'  => 'integer',
        'activity_result_id'          => 'integer',
    ];

    // ========================
    // === RELATIONS =========
    // ========================

    /**
     * L’activité de groupe à laquelle se réfère cette instance.
     */
    public function activityGroupActivity(): BelongsTo
    {
        return $this->belongsTo(ActivityGroupActivity::class, 'activity_group_activity_id');
    }

    /**
     * L’utilisateur qui a réalisé cette activité.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Le résultat détaillé de l’activité.
     */
    public function activityResult(): HasOne
    {
        return $this->hasOne(ActivityResult::class, 'id', 'activity_result_id');
    }
}