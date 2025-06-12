<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoolQuestion extends Model
{
    use HasFactory;

    // Nom explicite de la table (optionnel si respecte la convention Laravel)
    protected $table = 'pool_questions';

    // Pas de clé auto-incrémentée, clé de type string
    public $incrementing = false;
    protected $keyType = 'string';

    // Pas de timestamps dans cette table pivot
    public $timestamps = false;

    // Champs pouvant être assignés en masse
    protected $fillable = [
        'pool_code_id',
        'question_code_id',
        'order',
    ];

    // Conversion automatique des types
    protected $casts = [
        'pool_code_id'     => 'string',
        'question_code_id' => 'string',
        'order'            => 'integer',
    ];

    // ========================
    // === RELATIONS ==========
    // ========================

    /**
     * Le pool auquel cette entrée pivot appartient.
     */
    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class, 'pool_code_id', 'code_id');
    }

    /**
     * La question associée à cette entrée pivot.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_code_id', 'code_id');
    }
}