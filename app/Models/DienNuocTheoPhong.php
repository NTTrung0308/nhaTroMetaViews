<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DienNuocTheoPhong extends Model
{
    use HasFactory;
    
   protected $fillable = [
        'nha_tro_id', 'room_id', 'thang', 'nam',
        'chi_so_dien', 'so_m3_nuoc_truoc', 'so_nguoi',
        'dien_tieu_thu', 'nuoc_tieu_thu','chi_so_dien_truoc','so_m3_nuoc_sau',
        'trang_thai_chot'
    ];

    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }

    public function nhaTro()
    {
        return $this->belongsTo(NhaTros::class);
    }

    public static function getChiSoTruoc($roomId, $loai, $thang, $nam)
    {
        do {
            if (--$thang == 0) {
                $thang = 12;
                $nam--;
            }

            $record = self::where('room_id', $roomId)
                ->where('thang', $thang)
                ->where('nam', $nam)
                ->first();

        } while (!$record && ($thang != date('n') || $nam != date('Y'))); // dừng nếu quay vòng

        return $record ? ($loai === 'dien' ? $record->chi_so_dien : $record->so_m3_nuoc) : null;
    }

}
