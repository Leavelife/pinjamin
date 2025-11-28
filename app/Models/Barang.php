<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'category', 'quantity', 'status', 'image', 'user_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}