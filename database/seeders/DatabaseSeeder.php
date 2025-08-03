<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AboutUs;
use App\Models\Slider;
use App\Models\WebConfig;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call(DichVuSeeder::class);
         $this->call(TaiSanSeeder::class);
         $this->call(PermissionSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
         WebConfig::create([
            // Thông tin cơ bản
            'site_name' => 'Nhà trọ metaa',
            'site_slogan' => 'Nơi an cư lý tưởng cho sinh viên và người đi làm',
            'key' => 'nhatro-metaa',
            'language' => 'vi',
            'timezone' => 'Asia/Ho_Chi_Minh',

            // Liên hệ
            'email' => 'lienhe@nhatro.com',
            'hotline' => '0909 000 111',
            'phone' => '028 1234 5678',
            'zalo_number' => '0909000111',
            'address' => '123 Đường Trọ, Quận 9, TP. Hồ Chí Minh',
            'google_map_embed' => '<iframe src="https://maps.google.com/..."></iframe>',

            // Mạng xã hội
            'facebook_url' => 'https://facebook.com/nhatro.metaa',
            'zalo_url' => 'https://zalo.me/0909000111',
            'youtube_url' => 'https://youtube.com/@nhatro.metaa',
            'tiktok_url' => 'https://tiktok.com/@nhatro.metaa',
            'instagram_url' => 'https://instagram.com/nhatro.metaa',
            'linkedin_url' => null,
            'twitter_url' => null,

            // SEO
            'meta_title' => 'Nhà trọ metaa - Giải pháp nhà trọ toàn diện',
            'meta_keywords' => 'nhà trọ, phòng trọ giá rẻ, phòng trọ sinh viên',
            'meta_description' => 'Hệ thống nhà trọ uy tín, sạch đẹp, an ninh cho sinh viên và người đi làm.',

            // Scripts
            'script_header' => null,
            'script_footer' => null,
            'google_analytics_id' => 'G-XXXXXXXXXX',
            'facebook_pixel_id' => '1234567890',
            'chat_widget_script' => '<script>/* chat widget code */</script>',

            // Favicon & logo
            'logo' => '',
            'favicon_16' => '',
            'favicon_32' => '',
            'favicon_144' => '',
            'favicon_192' => '',
            'favicon_114' => '',
            'favicon_120' => '',
            'favicon_152' => '',
            'favicon_180' => '',
            'favicon_57' => '',
            'favicon_60' => '',
            'favicon_72' => '',
            'favicon_76' => '',
        ]);
        
        AboutUs::create([
            'title' => 'Về chúng tôi',
            'description' => 'Chúng tôi là công ty hàng đầu trong lĩnh vực...',
            'content' => '<p>Chào mừng đến với công ty chúng tôi...</p>',
            'image' => '',
            'mission_title' => 'Sứ mệnh của chúng tôi',
            'mission' => 'Mang đến giá trị bền vững cho khách hàng.',
            'vision_title' => 'Tầm nhìn',
            'vision' => 'Trở thành doanh nghiệp hàng đầu khu vực.',
            'active' => true,
        ]);
        for ($i=0; $i < 4; $i++) { 
            Slider::create([
                'title' => 'title ' .$i,
                'subtitle' => 'Subtitle ' . $i,
                'link' => '',
                'active' => 1,
                'position' => 0,
            ]);
        }
        $tinTucs = [
            [
                'tieu_de' => 'Phong thủy nhà ở năm 2025',
                'mo_ta_ngan' => 'Chọn hướng nhà, màu sắc hợp mệnh trong năm 2025.',
                'hinh_anh' => 'uploads/tin-tuc/nha-o-2025.jpg',
            ],
            [
                'tieu_de' => 'Ngày tốt khai trương tháng 8',
                'mo_ta_ngan' => 'Lịch ngày tốt khai trương theo tuổi và mệnh tháng 8.',
                'hinh_anh' => 'uploads/tin-tuc/ngay-khai-truong.jpg',
            ],
            [
                'tieu_de' => 'Xem ngày cưới hỏi hợp tuổi',
                'mo_ta_ngan' => 'Tư vấn chọn ngày cưới theo tuổi hai bên và ngũ hành.',
                'hinh_anh' => 'uploads/tin-tuc/ngay-cuoi.jpg',
            ],
            [
                'tieu_de' => '12 con giáp và vận hạn năm 2025',
                'mo_ta_ngan' => 'Dự đoán vận mệnh 12 con giáp năm 2025.',
                'hinh_anh' => 'uploads/tin-tuc/van-han-2025.jpg',
            ],
            [
                'tieu_de' => 'Bí quyết đặt bếp đúng phong thủy',
                'mo_ta_ngan' => 'Vị trí bếp giúp gia đạo hưng vượng và tránh xui xẻo.',
                'hinh_anh' => 'uploads/tin-tuc/dat-bep.jpg',
            ],
            [
                'tieu_de' => 'Trang trí bàn thờ hợp phong thủy',
                'mo_ta_ngan' => 'Cách bài trí bàn thờ để thu hút tài lộc.',
                'hinh_anh' => 'uploads/tin-tuc/ban-tho.jpg',
            ],
            [
                'tieu_de' => 'Tử vi tháng 8 cho người tuổi Tý',
                'mo_ta_ngan' => 'Xem tử vi sự nghiệp, tình cảm, tài chính tháng 8.',
                'hinh_anh' => 'uploads/tin-tuc/tuoi-ty.jpg',
            ],
            [
                'tieu_de' => 'Cách chọn cây phong thủy trong nhà',
                'mo_ta_ngan' => 'Những loại cây hút tài lộc, xua tà khí nên trồng.',
                'hinh_anh' => 'uploads/tin-tuc/cay-phong-thuy.jpg',
            ],
        ];

        foreach ($tinTucs as $tin) {
            DB::table('tin_tucs')->insert([
                'tieu_de' => $tin['tieu_de'],
                'slug' => Str::slug($tin['tieu_de']),
                'mo_ta_ngan' => $tin['mo_ta_ngan'],
                'noi_dung' => '<p>Nội dung bài viết về: ' . $tin['tieu_de'] . '</p>',
                'hinh_anh' => $tin['hinh_anh'],
                'tac_gia' => 'Admin',
                'trang_thai' => 'hien_thi',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
