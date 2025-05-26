<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'nick_name',
        'email',
        'is_active',
        'user_type',
        'onboarding_done',
        'registration_key_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'is_active'           => 'boolean',
        'onboarding_done'     => 'boolean',
        'email_verified_at'   => 'datetime',
        'registration_key_id' => 'integer',
    ];

    // ========================
    // === RELATIONSHIPS ======
    // ========================

    /**
     * Les tentatives de quiz « statique » de l'utilisateur.
     */
    public function userAttempts(): HasMany
    {
        return $this->hasMany(UserAttempt::class);
    }

    /**
     * La clé d'enregistrement utilisée par l'utilisateur (optionnel).
     */
    public function registrationKey(): BelongsTo
    {
        return $this->belongsTo(RegistrationKey::class);
    }
}