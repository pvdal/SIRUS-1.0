<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
// Filas de email
use App\Notifications\QueuedVerifyEmail;
use App\Notifications\QueuedResetPassword;
use App\Notifications\QueuedSendPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'access_level',
        'state',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    #region Notificações via email em fila
    public function sendEmailVerificationNotification(): void // Verificação de e-mail
    {
        $this->notify(new QueuedVerifyEmail);
    }

    public function sendPasswordResetNotification($token): void // Reset de senha
    {
        $this->notify(new QueuedResetPassword($token));
    }

    public function sendTemporaryPasswordNotification($password): void // Senha temporária
    {
        $this->notify(new QueuedSendPasswordNotification($password));
    }
    #endregion

    #region Relacionamentos
    public function coordinator(): HasOne // Relacionamento com Coordinator
    {
        return $this->hasOne(Coordinator::class);
    }
    public function professor(): HasOne // Relacionamento com Professor
    {
        return $this->hasOne(Professor::class);
    }
    public function student(): HasOne // Relacionamento com Student
    {
        return $this->hasOne(Student::class);
    }
    public function userCommittee(): HasMany // Relacionamento com UserCommittee
    {
        return $this->hasMany(UserCommittee::class);
    }
    #endregion
}
