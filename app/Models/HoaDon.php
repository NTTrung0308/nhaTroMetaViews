<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HoaDon extends Model
{
    use HasFactory;
    protected $fillable = [
        'ma_hoa_don',
        'nha_tro_id',
        'room_id',
        'user_id',
        'hop_dong_thue_phong_id',
        'thang',
        'nam',
        'ngay_tao_hoa_don',
        'han_thanh_toan',
        'tien_thue_phong',
        'tien_dien',
        'tien_nuoc',
        'chi_tiet_dich_vu_khac',
        'tong_phu_phi',
        'no_ky_truoc',
        'tong_tien',
        'da_thanh_toan',
        // 'con_no' là cột ảo (generated column), không cần fillable
        'trang_thai',
        'ghi_chu',
        'ghi_chu_nguoi_thue',
    ];

    protected $casts = [
        'ngay_tao_hoa_don' => 'date',
        'han_thanh_toan' => 'date',
        'chi_tiet_dich_vu_khac' => 'array',
    ];
    
    /**
     * Lấy tòa nhà của hóa đơn này.
     */
    public function nhaTro()
    {
        return $this->belongsTo(NhaTros::class, 'nha_tro_id');
    }
    
    /**
     * Lấy phòng của hóa đơn này.
     */
    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    /**
     * Lấy người nhận hóa đơn.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Lấy hợp đồng liên quan tại thời điểm tạo hóa đơn.
     */
    public function hopDong()
    {
        return $this->belongsTo(HopDongThuePhong::class, 'hop_dong_thue_phong_id');
    }
     public function transactions(): HasMany
    {
        // 'hoa_don_id' là khóa ngoại trong bảng 'transactions'
        // 'id' là khóa chính trong bảng 'hoa_dons' (bảng hiện tại)
        return $this->hasMany(Transaction::class, 'hoa_don_id', 'id');
    }
}
