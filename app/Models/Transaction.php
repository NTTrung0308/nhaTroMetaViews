<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
     protected $fillable = [
        'transaction_code',
        'hoa_don_id',
        'user_id',
        'amount',
        'currency',
        'description',
        'gateway',
        'gateway_transaction_code',
        'metadata',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'completed_at' => 'datetime',
    ];

    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
