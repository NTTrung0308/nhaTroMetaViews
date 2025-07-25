<?php

use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HoaDonController;
use App\Http\Controllers\Api\HopDongController;
use App\Http\Controllers\Api\PhuongTienController;
use App\Http\Controllers\Api\UserController;
use App\Models\Rooms;
use App\Models\TaiSanChungRieng;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// routes/web.php
Route::get('/get-used-room-codes/{nha_tro_id}', [RoomController::class, 'getUsedRoomCodes']);

// routes/web.php
// routes/api.php
Route::get('/ajax/rooms-by-nhatro/{nhaTroId}', function ($nhaTroId) {
    $rooms = Rooms::where('nha_tro_id', $nhaTroId)
        ->with(['taiSanChungRiengs']) // giả sử có quan hệ này
        ->get();

    return response()->json($rooms->map(function ($room) {
        return [
            'id' => $room->id,
            'ma_phong' => $room->ma_phong,
            'da_ton_tai' => $room->taiSanChungRiengs->isNotEmpty(),
        ];
    }));
});
Route::get('/rooms-by-nha-tro/{nhaTroId}', function ($nhaTroId) {
    return \App\Models\Rooms::where('nha_tro_id', $nhaTroId)->get(['id', 'ten_phong', 'ma_phong', 'da_thue', 'gia_thue']);
});

// Route công khai, không cần xác thực
Route::post('/login', [AuthController::class, 'login']);
// Các route yêu cầu xác thực người dùng (cần gửi token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
  Route::post('/logout', [AuthController::class, 'logout']);
 Route::post('/logout-all', [AuthController::class, 'logoutAllDevices']);
 
    Route::get('/hop-dong', [HopDongController::class, 'index']);
    // LẤY CHI TIẾT MỘT HỢP ĐỒNG (ROUTE MỚI)
    Route::get('/hop-dong/{hopDong}', [HopDongController::class, 'show'])->where('hopDong', '[0-9]+');
    Route::get('/hoa-dons', [HoaDonController::class, 'index']);

    // API lấy thông tin user đang đăng nhập
    Route::get('/user', [UserController::class, 'profile']);

    // API cập nhật thông tin user đang đăng nhập
    // Sử dụng POST vì form-data không hoàn toàn hỗ trợ PUT/PATCH
    Route::post('/user/update', [UserController::class, 'update']);

    // lIST THÊM SỬA XÓA PHƯƠNG TIỆN
    Route::get('/v-simple/phuong-tien', [PhuongTienController::class, 'index']);
    Route::post('/v-simple/phuong-tien', [PhuongTienController::class, 'store']);
    Route::get('/v-simple/phuong-tien/{id}', [PhuongTienController::class, 'show']);
    Route::post('/v-simple/phuong-tien/{id}', [PhuongTienController::class, 'update']);
    Route::delete('/v-simple/phuong-tien/{id}', [PhuongTienController::class, 'destroy']);
    //eND
});
