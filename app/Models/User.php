<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('slug', $roles)->exists();
    }

    public function assignRole($role)
    {
        $role = Role::where('slug', $role)->firstOrFail();
        if (!$this->hasRole($role->slug)) {
            $this->roles()->attach($role);
        }
    }

    public function removeRole($role)
    {
        $role = Role::where('slug', $role)->firstOrFail();
        $this->roles()->detach($role);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function assistant()
    {
        return $this->hasOne(Assistant::class);
    }
}