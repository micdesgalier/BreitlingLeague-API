<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserActivityGroupActivity extends Model
{
    use HasFactory;

    // Désactive la gestion automatique des timestamps (created_at / updated_at)
    public $timestamps = false;

    /**
     * Attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
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
     * Définition des conversions automatiques de types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date'                 => 'datetime',
        'end_date'                   => 'datetime',
        'progression_score'          => 'float',
        'progression_score_percent'  => 'float',
        'external_id'                => 'integer',
        'user_id'                    => 'integer',
        'activity_group_activity_id' => 'integer',
        'activity_result_id'         => 'integer',
    ];

    // ========================
    // ===== RELATIONS ========
    // ========================

    /**
     * L'utilisateur ayant participé à l'activité.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Le résultat détaillé associé à cette activité.
     */
    public function activityResult(): HasOne
    {
        return $this->hasOne(ActivityResult::class, 'id', 'activity_result_id');
    }
}