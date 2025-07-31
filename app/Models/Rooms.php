<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    protected $fillable = [
        'nha_tro_id',
        'ten_phong',
        'ma_phong',
        'dien_tich',
        'so_khach',
        'bancong',
        'loai_phong',
        'gia_thue',
        'da_thue',
        'images',
        'ghi_chu',
        'status',
    ];



    public function tang()
    {
        return $this->belongsTo(Tangs::class);
    }

    // public function hopDongThue()
    // {
    //     return $this->hasMany(HopDongThue::class);
    // }
    protected $casts = [
        'da_thue' => 'boolean',
        'images' => 'array',
    ];
    public function congViecs()
    {
        return $this->hasMany(CongViec::class, 'phong_id');
    }
      public function hopDongHienTai()
    {
        return $this->hasOne(HopDongThuePhong::class, 'room_id')->where('active', true);
    }
    public function nhaTro()
    {
        return $this->belongsTo(NhaTros::class);
    }
  public function taiSanChungRiengs()
{
    return $this->hasMany(TaiSanChungRieng::class, 'room_id');
}

public function congTos()
{
    return $this->hasMany(CongTo::class, 'room_id');
}


public function congToDien()
{
    return $this->hasOne(CongTo::class)->where('loai', 'dien');
}

public function congToNuoc()
{
    return $this->hasOne(CongTo::class)->where('loai', 'nuoc');
}


}
