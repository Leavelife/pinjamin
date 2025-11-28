<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'program_studi',
        'location',
        'phone',
        'avatar',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}