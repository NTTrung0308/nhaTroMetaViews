<?php

namespace Database\Seeders;

use App\Models\DichVu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            'Thêm người dùng',
            'Sửa người dùng',
            'Xóa người dùng',
            'Xem người dùng',
            'Thêm vai trò',
            'Sửa vai trò',
            'Xóa vai trò',
            'Xem vai trò',
            'Thêm dịch vụ',
            'Xem dịch vụ',
            'Sửa dịch vụ',
            'Xóa dịch vụ',
            'Thêm nhà trọ',
            'Sửa nhà trọ',
            'Xóa nhà trọ',
            'Xem nhà trọ',
            'Thêm tài sản trọ',
            'Sửa tài sản trọ',
            'Xóa tài sản trọ',
            'Xem tài sản trọ',
            'Xem phòng trọ',
            'Sửa phòng trọ',
            'Thêm phòng trọ',
            'Xóa phòng trọ',
            'Thêm tài sản',
            'Sửa tài sản',
            'Xóa tài sản',
            'Xem tài sản',
            'Xem khách hàng',
            'Thêm khách hàng',
            'Sửa khách hàng',
            'Xóa khách hàng',
            'Thêm tin tức',
            'Xem tin tức',
            'Sửa tin tức',
            'Xóa tin tức',
            'Xem liên hệ',
            'Thêm chính sách',
            'Xem chính sách',
            'Sửa chính sách',
            'Xóa chính sách',
            'Thêm slider',
            'Xem slider',
            'Sửa slider',
            'Xóa slider',
            'Thêm cảm nghĩ',
            'Xem cảm nghĩ',
            'Sửa cảm nghĩ',
            'Xóa cảm nghĩ',
            'Thêm câu hỏi thường gặp',
            'Xóa câu hỏi thường gặp',
            'Sửa câu hỏi thường gặp',
            'Xem câu hỏi thường gặp',
            'Cài đặt web',
            'Về chúng tôi',
            'Xem tài khoản quản trị',
            'Sửa tài khoản quản trị',
            'Xóa tài khoản quản trị',
            'Thêm tài khoản quản trị',
            'Xem phương tiện',
            'Sửa phương tiện',
            'Xóa phương tiện',
            'Thêm phương tiện',
            'Xem công tơ',
            'Sửa công tơ',
            'Thêm công tơ',
            'Xóa công tơ',
            'Xem hợp đồng',
            'Sửa hợp đồng',
            'Thêm hợp đồng',
            'Xóa hợp đồng',
            'Xem quản lý điện nước',
            'Sửa quản lý điện nước',
            'Thêm quản lý điện nước',
            'Chốt quản lý điện nước',
            'Thêm hóa đơn',
            'Sửa hóa đơn',
            'Xóa hóa đơn',
            'Xem hóa đơn',




        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($permissions);

        // Role::firstOrCreate(['name' => 'nguoi-thue-tro']);
        $nguoiThueTroRole  = Role::firstOrCreate(['name' => 'nguoi-thue-tro']);
        $nguoiThueTroRole->givePermissionTo('Xem hợp đồng');
        $nguoiThueTroRole->givePermissionTo('Xem hóa đơn');
        $nguoiThueTroRole->givePermissionTo('Xem phương tiện');

        // Gán Super Admin cho User ID 1
        $admin = User::find(1);
        if ($admin) {
            $admin->assignRole('Super Admin');
        }


        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super-Admin',
                'username' => 'SupperAdmin',
                'password' => Hash::make('password123'), // Đổi mật khẩu mạnh hơn
            ]
        );

        $superAdmin->assignRole('Super Admin');



        // 2. Tạo user và gán vai trò
        $user1 = User::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'test@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $user1->assignRole($nguoiThueTroRole); // Gán vai trò đã tạo

    }
}
