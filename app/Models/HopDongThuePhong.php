<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopDongThuePhong extends Model
{
    use HasFactory;
      protected $fillable = [
        'user_id',
        'room_id',
        'nha_tro_id',
        'ngay_bat_dau',
        'ngay_het_han',
        'gia_thue',
        'tien_coc',
        'ghi_chu',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class);
    }

    // Khi tạo hợp đồng mới: cập nhật trạng thái phòng
    protected static function booted()
    {
        static::created(function ($contract) {
            $contract->room->update([
                'status' => 'da_thue',
                'da_thue' => true,
            ]);
        });

        static::deleted(function ($contract) {
            // Kiểm tra xem phòng này còn hợp đồng nào active không
            $room = $contract->room;

            $stillActive = self::where('room_id', $room->id)
                ->where('active', true)
                ->exists();

            if (!$stillActive) {
                $room->update([
                    'status' => 'trong',
                    'da_thue' => false,
                ]);
            }
        });
    }
   public function nhaTro()
{
    return $this->belongsTo(NhaTros::class);
}
}
