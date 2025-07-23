<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\WebConfig;
use Illuminate\Http\Request;

class WebConfigController extends Controller
{
     public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
     
        $this->middleware('can:Cài đặt web')->only(['edit', 'update']);
      
    }
    /**
     * Hiển thị form sửa cấu hình website (chỉ có 1 bản ghi)
     */
    public function edit()
    {
        $config = WebConfig::firstOrCreate(['id' => 1]);
        return view('admin.web_config.index', compact('config'));
    }

    /**
     * Cập nhật thông tin cấu hình website
     */
    public function update(Request $request)
    {
        $config = WebConfig::findOrFail(1);

        $fields = [
            // Nhóm 1: Thông tin cơ bản
            'site_name', 'site_slogan', 'key', 'language', 'timezone',

            // Nhóm 2: Liên hệ
            'email', 'hotline', 'phone', 'zalo_number', 'address', 'google_map_embed',

            // Nhóm 3: Mạng xã hội
            'facebook_url', 'zalo_url', 'youtube_url', 'tiktok_url',
            'instagram_url', 'linkedin_url', 'twitter_url',

            // Nhóm 4: SEO
            'meta_title', 'meta_keywords', 'meta_description',

            // Nhóm 5: Script
            'script_header', 'script_footer', 'google_analytics_id',
            'facebook_pixel_id', 'chat_widget_script',
        ];

        $imageFields = [
            'logo', 'favicon_16', 'favicon_32', 'favicon_144', 'favicon_192',
            'favicon_114', 'favicon_120', 'favicon_152', 'favicon_180',
            'favicon_57', 'favicon_60', 'favicon_72', 'favicon_76',
        ];

        $data = [];

        // Lấy dữ liệu text
        foreach ($fields as $field) {
            $data[$field] = $request->input($field);
        }

        // Xử lý upload ảnh
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {

if (!empty($config->$field) && file_exists(public_path($config->$field))) {
                @unlink(public_path($config->$field));
            }


                $file = $request->file($field);
                $filename = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $data[$field] = '/uploads/' . $filename;
            }
        }

        $config->update($data);
  LogHelper::ghi('Sửa cài đặt web ', 'WebSetting', 'Cập nhật thông tin web trong quản trị viên');
        return redirect()->route('web-config.edit')->with('success', 'Cập nhật cấu hình website thành công!');
    }
}
