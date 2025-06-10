<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizMatch extends Model
{
    use HasFactory;

    // Si votre table s'appelle différemment, décommentez et ajustez :
    // protected $table = 'quiz_matches';

    // Clé primaire auto-incrémentée par défaut
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // On suppose que la colonne "created_date" stocke la date de création.
    // Laravel va automatiquement remplir created_date, et on n’a pas d’updated_at.
    const CREATED_AT = 'created_date';
    const UPDATED_AT = null;

    /**
     * Les attributs "mass assignable".
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'quiz_code_id',
        'status',
        // 'created_date' est géré automatiquement par Laravel lors de la création
    ];

    /**
     * Casts des attributs.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'quiz_code_id' => 'string',
        'created_date' => 'datetime',
        'status'       => 'string',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Le quiz associé à ce match.
     *
     * @return BelongsTo
     */
    public function quiz(): BelongsTo
    {
        // Quiz::class doit avoir protected $primaryKey = 'code_id'
        return $this->belongsTo(Quiz::class, 'quiz_code_id', 'code_id');
    }

    /**
     * Les participants de ce match.
     *
     * @return HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(QuizMatchParticipant::class, 'quiz_match_id', 'id');
    }

    /**
     * Les questions de ce match.
     *
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(QuizMatchQuestion::class, 'quiz_match_id', 'id');
    }
}