<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * Uncomment and adjust if your PK is not 'id'.
     */
    protected $primaryKey = 'code_id';
    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'code_id',
        'quiz_code_id',
        'order',
        'number_of_time_to_use',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'code_id'               => 'string',
        'quiz_code_id'          => 'string',
        'order'                 => 'integer',
        'number_of_time_to_use' => 'integer',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Le quiz auquel appartient ce stage.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_code_id', 'code_id');
    }

    /**
     * Les pools (groupes de questions) de ce stage.
     */
    public function pools(): HasMany
    {
        return $this->hasMany(Pool::class, 'stage_code_id', 'code_id');
    }
}