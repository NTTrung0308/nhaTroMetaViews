<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongTo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nha_tro_id',
        'room_id',
        'loai',
        'chi_so_dau',
    ];

    /**
     * Quan hệ: Công tơ thuộc về một nhà trọ
     */
    public function nhaTro()
    {
        return $this->belongsTo(NhaTros::class, 'nha_tro_id');
    }

    /**
     * Quan hệ: Công tơ thuộc về một phòng (có thể null)
     */
    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }
}
