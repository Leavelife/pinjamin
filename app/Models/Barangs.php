<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'category',
        'description',
        'pickup_address',
        'qty',
        'condition',
        'photo',
        'status',
    ];

    /* RELATIONS */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pinjamans()
    {
        return $this->hasMany(Loan::class);
    }
}
