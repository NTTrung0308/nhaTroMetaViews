<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuongTien extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'bien_so',
        'loai_phuong_tien',
        'ten_chu_xe',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
