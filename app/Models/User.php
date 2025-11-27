<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    // has paid 
    public function hasPaid()
    {
        return $this->userPayment()->where('payment_status', 'completed')->exists();
    }

    # Relations
    public function userPayment()
    {
        return $this->hasOne(UserPayment::class);
    }

    public function applications(){
        return $this->hasMany(Application::class, 'candidate_id', 'id');
    }

    public function faq(){
        return $this->hasMany(FaqQuestion::class);
    }

    public function likedProjects(){
        return $this->belongsToMany(
            Project::class,
            'project_likes', 
            'user_id',
            'project_id'
        );
    }
}
