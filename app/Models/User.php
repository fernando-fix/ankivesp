<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'is_admin',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    // Relationships

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function isAdmin()
    {
        return $this->is_admin == 1 ? true : false;
    }

    public function hasPermission($permission)
    {
        return $this->roles->pluck('permissions')->flatten()->contains('slug', $permission);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'watcheds');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'subscriptions');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_user');
    }
}
