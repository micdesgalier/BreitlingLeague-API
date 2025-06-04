<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     * Laravel’s default is “id”, so this line is actually optional
     * if you keep the column named “id” in your users table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * Again, “true” is the default for an integer primary key,
     * so you can safely remove this if you like.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The “type” of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
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
        // Si vous gérez l’authentification par mot de passe, décommentez la ligne suivante :
        // 'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'id'                      => 'integer',
        'is_active'               => 'boolean',
        'onboarding_done'         => 'boolean',
        'user_type'               => 'string',
        'last_name'               => 'string',
        'first_name'              => 'string',
        'nickname'                => 'string',
        'email'                   => 'string',
    ];

    /**
     * Si vous utilisez les timestamps Laravel classiques (created_at / updated_at),
     * laissez ceci à true. Sinon, mettez false.
     *
     * @var bool
     */
    public $timestamps = true;

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Toutes les tentatives de quiz (UserAttempt) faites par cet utilisateur.
     *
     * @return HasMany
     */
    public function quizAttempts(): HasMany
    {
        return $this->hasMany(UserAttempt::class, 'fk_User', 'id');
    }

    /**
     * Toutes les réponses de type “match” que cet utilisateur a fournies
     * (QuizUserMatchAnswer).
     *
     * @return HasMany
     */
    public function quizUserMatchAnswers(): HasMany
    {
        return $this->hasMany(QuizUserMatchAnswer::class, 'fk_User', 'id');
    }

    /**
     * Toutes les activités de groupe associées à cet utilisateur
     * (UserActivityGroupActivity).
     *
     * @return HasMany
     */
    public function userActivityGroupActivities(): HasMany
    {
        return $this->hasMany(UserActivityGroupActivity::class, 'fk_User', 'id');
    }

    // Si besoin, vous pouvez ajouter d’autres relations qui pointent sur la table “users”,
    // par exemple vers QuizActivityResult, UserActivityGroupActivityResult, etc.
    // mais celles-ci couvrent déjà les liens directs du schéma relationnel.
}
