<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ← para login
use Illuminate\Notifications\Notifiable;

class Doctor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'dni',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // 🔁 Relación con roles (muchos a muchos)
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // 🔁 Relación con tokens
    public function tokens()
    {
        return $this->hasMany(Token::class);
    }
}
