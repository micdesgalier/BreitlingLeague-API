<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoolQuestion extends Model
{
    use HasFactory;

    /**
     * La table associée à ce modèle.
     * Par convention, Laravel utiliserait “pool_questions” automatiquement,
     * donc cette ligne est optionnelle si votre table s’appelle bien “pool_questions”.
     *
     * @var string
     */
    protected $table = 'pool_questions';

    /**
     * Comme il n'y a pas de colonne “id” auto-incrémentée dans cette table,
     * on désactive l’auto-incrémentation et on indique que la clé n'est pas un entier auto-incrémenté.
     */
    public $incrementing = false;
    protected $keyType = 'string'; // ou 'int' si vos clés (pool_code_id, question_code_id) sont de type integer

    /**
     * Si vous n’utilisez pas les timestamps “created_at”/“updated_at” dans cette table,
     * mettez à false. En général, pour une table pivot, on n’a pas de timestamps.
     */
    public $timestamps = false;

    /**
     * Les colonnes “mass assignable” de cette table pivot.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'pool_code_id',
        'question_code_id',
        'order',
    ];

    /**
     * Les casts pour que Laravel interprète correctement les types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'pool_code_id'     => 'integer',
        'question_code_id' => 'integer',
        'order'            => 'integer',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Le pool auquel cette entrée (pivot) est attachée.
     *
     * @return BelongsTo
     */
    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class, 'pool_code_id', 'code_id');
    }

    /**
     * La question référencée dans ce pool.
     *
     * @return BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_code_id', 'code_id');
    }
}