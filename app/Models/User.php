<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   /**
     * Các trường có thể gán giá trị hàng loạt.
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'avatar',
        'birthday',
        'active',
        'cmt_mat_truoc',
        'cmt_mat_sau',
        'cmnd',
        'ho_chieu',
        'gioi_tinh',
        'ngay_cap_cmnd',
        'noi_cap_cmnd',
        'thanh_pho',
        'huyen',
        'xa',
        'address',
        'stk',
        'ngan_hang',
        'nghe_nghiep',
        'noi_lam_viec',
        'ma_van_tay',
        'note',
        'facebook',
        'zalo',
        'instar',
        'twitter',
        'linkdin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /**
     * Kiểu dữ liệu cho các trường.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
    ];
    public function congViecs()
{
    return $this->hasMany(CongViec::class, 'user_thuc_hien');
}
public function hopDongThuePhongs()
{
    return $this->hasMany(HopDongThuePhong::class);
}
public function hoaDon()
{
    return $this->hasMany(HoaDon::class);
}

}
