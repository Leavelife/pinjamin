<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowRequest extends Model
{
    protected $fillable = [
        'item_id',
        'borrower_id',
        'owner_id',
        'start_date',
        'end_date',
        'actual_return_date',
        'status',
        'message',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'actual_return_date' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function borrower()
    {
        return $this->belongsTo(User::class, 'borrower_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Scope untuk mendapatkan permintaan yang pending
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope untuk mendapatkan permintaan yang approved
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope untuk mendapatkan permintaan milik user tertentu sebagai owner
    public function scopeForOwner($query, $userId)
    {
        return $query->where('owner_id', $userId);
    }

    // Scope untuk mendapatkan permintaan milik user tertentu sebagai borrower
    public function scopeForBorrower($query, $userId)
    {
        return $query->where('borrower_id', $userId);
    }
}
