<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DienNuocTheoPhong extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nha_tro_id',
        'room_id',
        'thang',
        'nam',
        'chi_so_dien',
        'so_m3_nuoc',
        'so_nguoi',
        'tieu_thu_dien',
        'tieu_thu_nuoc'
    ];

    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }

    public function toaNha()
    {
        return $this->belongsTo(NhaTros::class, 'nha_tro_id');
    }
}
