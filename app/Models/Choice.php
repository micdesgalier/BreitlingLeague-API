<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Choice extends Model
{
    use HasFactory;

    /**
     * Clé primaire de la table (par défaut : 'id', ici 'code_id').
     */
    protected $primaryKey = 'code_id';

    /**
     * Attributs pouvant être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code_id',
        'media_id',
        'order',
        'is_correct',
        'question_code_id',
        'label',
    ];

    /**
     * Conversion automatique des attributs en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'code_id'          => 'string',
        'media_id'         => 'integer',
        'order'            => 'integer',
        'is_correct'       => 'boolean',
        'question_code_id' => 'string',
        'label'            => 'string',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Retourne la question à laquelle ce choix est lié.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_code_id', 'code_id');
    }

    /**
     * Retourne le média associé à ce choix (peut être null).
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    /**
     * Retourne les sélections utilisateur liées à ce choix.
     */
    public function userAttemptChoices(): HasMany
    {
        return $this->hasMany(UserAttemptChoice::class, 'choice_code_id', 'code_id');
    }
}