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
     * The primary key associated with the table.
     */
    protected $primaryKey = 'code_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code_id',
        'media_id',
        'order',
        'is_correct',
        'question_code_id',
        'label', // Ajout du champ "label"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'code_id'          => 'string',
        'media_id'         => 'integer',
        'order'            => 'integer',
        'is_correct'       => 'boolean',
        'question_code_id' => 'string',
        'label'            => 'string', // Casting du champ "label"
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * La question à laquelle appartient ce choix.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_code_id', 'code_id');
    }

    /**
     * Le média associé à ce choix (optionnel).
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    /**
     * Les sélections utilisateur associées à ce choix.
     */
    public function userAttemptChoices(): HasMany
    {
        return $this->hasMany(UserAttemptChoice::class, 'choice_code_id', 'code_id');
    }
}