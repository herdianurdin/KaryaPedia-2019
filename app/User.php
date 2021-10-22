<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'address', 'phone_number', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public function roles()
    {
	    return $this->belongsToMany(Role::class, 'role_users');
    }

    public function hasRole($role)
    {
	    return $this->roles()->where('name', $role)->count() == 1;
    }

    public function Orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

}
