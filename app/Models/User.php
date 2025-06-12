<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Les attributs "mass assignable".
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
        // Ajout des champs boutique et pays :
        'group',
        'country',
    ];

    /**
     * Les attributs à caster en types natifs.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'id'              => 'integer',
        'is_active'       => 'boolean',
        'onboarding_done' => 'boolean',
        'user_type'       => 'string',
        'last_name'       => 'string',
        'first_name'      => 'string',
        'nickname'        => 'string',
        'email'           => 'string',
        'media'           => 'string',
        // Cast pour boutique et pays
        'group'        => 'string',
        'country'            => 'string',
        // si vous stockez password, Laravel ne le caste pas explicitement ici
    ];

    public $timestamps = true;

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(UserAttempt::class, 'user_id', 'id');
    }

    public function quizUserMatchAnswers(): HasMany
    {
        return $this->hasMany(QuizUserMatchAnswer::class, 'user_id', 'id');
    }

    public function userActivityGroupActivities(): HasMany
    {
        return $this->hasMany(UserActivityGroupActivity::class, 'user_id', 'id');
    }

    public function quizMatchParticipants(): HasMany
    {
        // suppose que QuizMatchParticipant a user_id comme clé étrangère
        return $this->hasMany(\App\Models\QuizMatchParticipant::class, 'user_id', 'id');
    }
}