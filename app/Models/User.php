<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Clé primaire par défaut (auto-incrémentée)
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Attributs pouvant être assignés en masse.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'nickname',
        'is_active',
        'user_type',
        'onboarding_done',
        'email',
        'media',
        'group',
        'country',
    ];

    /**
     * Conversion automatique des types des attributs.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'id'               => 'integer',
        'is_active'        => 'boolean',
        'onboarding_done'  => 'boolean',
        'user_type'        => 'string',
        'last_name'        => 'string',
        'first_name'       => 'string',
        'nickname'         => 'string',
        'email'            => 'string',
        'media'            => 'string',
        'group'            => 'string',
        'country'          => 'string',
    ];

    public $timestamps = true;

    // ========================
    // ===== RELATIONS ========
    // ========================

    /**
     * Tentatives de quiz faites par l'utilisateur.
     */
    public function quizAttempts(): HasMany
    {
        return $this->hasMany(UserAttempt::class, 'user_id', 'id');
    }

    /**
     * Réponses données par l'utilisateur dans les matchs de quiz.
     */
    public function quizUserMatchAnswers(): HasMany
    {
        return $this->hasMany(QuizUserMatchAnswer::class, 'user_id', 'id');
    }

    /**
     * Activités de groupe auxquelles l'utilisateur a participé.
     */
    public function userActivityGroupActivities(): HasMany
    {
        return $this->hasMany(UserActivityGroupActivity::class, 'user_id', 'id');
    }

    /**
     * Participations de l'utilisateur aux matchs de quiz.
     */
    public function quizMatchParticipants(): HasMany
    {
        return $this->hasMany(\App\Models\QuizMatchParticipant::class, 'user_id', 'id');
    }
}