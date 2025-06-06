<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     * Laravel’s default is “id”, so cette ligne est facultative si vous gardez “id”.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
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
        'media', // Ajout du champ “media” pour stocker l’URL ou le chemin de la photo
        // 'password',
    ];

    /**
     * The attributes that should be cast to native types.
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
        'media'           => 'string', // Ajout du cast pour “media”
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

    // Ajoutez d’autres relations si nécessaire…
}