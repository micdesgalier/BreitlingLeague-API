<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivityGroupActivityResult extends Model
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
        'user_id',
        'activity_group_activity_id',
        'is_completed',
        'completion_date',
        'score',
        'score_percent',
        'has_improved_score',
    ];

    /**
     * Définition des conversions automatiques de types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id'                    => 'integer',
        'activity_group_activity_id'=> 'integer',
        'is_completed'              => 'boolean',
        'completion_date'           => 'datetime',
        'score'                     => 'float',
        'score_percent'             => 'float',
        'has_improved_score'        => 'boolean',
    ];

    // ========================
    // ===== RELATIONS ========
    // ========================

    /**
     * L'utilisateur à qui appartient ce résultat d'activité.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}