<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'related_id',
        'related_type',
        'read_at'
    ];

    /* RELATIONS */
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Custom relation for barang/pinjaman
    public function related()
    {
        return $this->morphTo(null, 'related_type', 'related_id');
    }
}
