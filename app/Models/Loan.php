<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
     protected $table = 'pinjamans';


    protected $fillable = [
        'user_id',
        'barang_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status'
    ];

    /* RELATIONS */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barangs::class);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'related');
    }
}
