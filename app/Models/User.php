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
        'prodi',
        'no_hp',
        'foto_profile',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* RELATIONS */

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

    public function pinjamans()
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
