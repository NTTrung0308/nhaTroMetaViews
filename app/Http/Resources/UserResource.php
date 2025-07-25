<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Hàm này sẽ chọn lọc các trường bạn muốn trả về qua API
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'phone' => $this->phone,
            // Tạo URL đầy đủ cho các file ảnh
               'avatar' => $this->avatar ? asset($this->avatar) : null,
            'cmt_mat_truoc' => $this->cmt_mat_truoc ? asset($this->cmt_mat_truoc) : null,
            'cmt_mat_sau' => $this->cmt_mat_sau ? asset($this->cmt_mat_sau) : null,
            'ho_chieu' => $this->ho_chieu ? asset($this->ho_chieu) : null,

            'birthday' => $this->birthday,
            'active' => (bool) $this->active,
            'cmnd' => $this->cmnd,
            'ngay_cap_cmnd' => $this->ngay_cap_cmnd,
            'noi_cap_cmnd' => $this->noi_cap_cmnd,
            'gioi_tinh' => $this->gioi_tinh,
            'thanh_pho' => $this->thanh_pho,
            'huyen' => $this->huyen,
            'xa' => $this->xa,
            'address' => $this->address,
            'stk' => $this->stk,
            'ngan_hang' => $this->ngan_hang,
            'nghe_nghiep' => $this->nghe_nghiep,
            'noi_lam_viec' => $this->noi_lam_viec,
            'note' => $this->note,
            'facebook' => $this->facebook,
            'zalo' => $this->zalo,
            'instar' => $this->instar,
            'linkdin' => $this->linkdin,
            'twitter' => $this->twitter,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            'phuong_tiens' => PhuongTienResource::collection($this->whenLoaded('phuongTiens')),
        ];
    }
}
