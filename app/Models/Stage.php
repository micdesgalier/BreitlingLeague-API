<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory;

    // Clé primaire de type string, non auto-incrémentée
    protected $primaryKey = 'code_id';
    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * Attributs pouvant être assignés en masse.
     */
    protected $fillable = [
        'code_id',
        'quiz_code_id',
        'order',
        'number_of_time_to_use',
    ];

    /**
     * Conversion automatique des types des attributs.
     */
    protected $casts = [
        'code_id'               => 'string',
        'quiz_code_id'          => 'string',
        'order'                 => 'integer',
        'number_of_time_to_use' => 'integer',
    ];

    // ========================
    // ===== RELATIONS ========
    // ========================

    /**
     * Le quiz auquel ce stage est rattaché.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_code_id', 'code_id');
    }

    /**
     * Les pools (groupes de questions) associés à ce stage.
     */
    public function pools(): HasMany
    {
        return $this->hasMany(Pool::class, 'stage_code_id', 'code_id');
    }
}