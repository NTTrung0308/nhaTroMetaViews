<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaTros extends Model
{
    use HasFactory;
    protected $fillable = [
        'ten_toa_nha',
        'ma_toa_nha',
        'dia_chi',
        'phuong',
        'quan',
        'thanh_pho',
        'quoc_gia',
        'so_tang',
        'status',
        'dien_tich',
        'chu_so_huu',
        'mo_ta',
        'anh_dai_dien',
        'so_phong_tang'
    ];
    public function tangs()
    {
        return $this->hasMany(Tangs::class);
    }
    public function congViecs()
    {
        return $this->hasMany(CongViec::class);
    }
    public function dichVus()
    {
        return $this->belongsToMany(DichVu::class, 'toa_nha_dich_vus', 'nha_tro_id', 'dich_vu_id')
            ->withPivot('don_gia', 'kieu_tinh')
            ->withTimestamps();
    }


    public function rooms()
    {
        return $this->hasMany(Rooms::class);
    }
    public function congTos()
    {
        return $this->hasMany(CongTo::class);
    }


    // public function baoTris()
    // {
    //     return $this->hasMany(BaoTri::class);
    // }
}