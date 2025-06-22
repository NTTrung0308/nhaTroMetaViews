<?php

namespace App\Console\Commands;

use App\Models\HopDongThuePhong;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiredHopDong extends Command
{
     protected $signature = 'hopdong:check-expired';
    protected $description = 'Kiểm tra hợp đồng hết hạn và cập nhật trạng thái phòng.';

    public function handle()
    {
        $today = Carbon::today();

        $expiredContracts = HopDongThuePhong::whereDate('ngay_het_han', '<', $today)->get();

        foreach ($expiredContracts as $contract) {
            $room = $contract->room;

            // Nếu phòng chưa bị đánh là "tam_khoa" thì cập nhật
            if ($room && $room->status !== 'tam_khoa') {
                $room->update(['status' => 'tam_khoa']);
                $this->info("Đã khóa phòng: {$room->ten_phong}");
            }
        }

        return Command::SUCCESS;
    }
}
