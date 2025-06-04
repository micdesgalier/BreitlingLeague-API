<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivityGroupActivityResult extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée (optionnel si pluriel standard).
     *
     * @var string
     */
    // protected $table = 'user_activity_group_activity_results';

    /**
     * Désactive les timestamps si la table ne contient pas created_at / updated_at.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int,string>
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
     * Les casts pour convertir automatiquement les types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'user_id'                      => 'integer',
        'activity_group_activity_id'   => 'integer',
        'is_completed'                 => 'boolean',
        'completion_date'              => 'datetime',
        'score'                        => 'float',
        'score_percent'                => 'float',
        'has_improved_score'           => 'boolean',
    ];

    // ========================
    // === RELATIONS =========
    // ========================

    /**
     * Le résultat appartient à un utilisateur.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}