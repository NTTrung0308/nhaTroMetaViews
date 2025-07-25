<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\AdministratorController;
use App\Http\Controllers\Admin\CongtoController;
use App\Http\Controllers\Admin\CongtoDienController;
use App\Http\Controllers\Admin\CongtoNuocController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DichVuController;
use App\Http\Controllers\Admin\DienNuocController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\HoaDonController;
use App\Http\Controllers\Admin\HopDongController;
use App\Http\Controllers\Admin\NhaTroController;
use App\Http\Controllers\Admin\PhuongTienController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolesControler;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TaiSanChungRiengController;
use App\Http\Controllers\Admin\TaiSanController;
use App\Http\Controllers\Admin\TintucController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VnpayController;
use App\Http\Controllers\Admin\WebConfigController;
use App\Http\Controllers\Admin\ZaloPayController;
use App\Http\Controllers\UploadController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('admin.dashboard.stats');
        Route::get('/getrooms/{id}', [DashboardController::class, 'getRoomsByNhaTro'])->name('admin.dashboard.getRooms');
    });


    Route::prefix('dich-vus')->group(function () {
        Route::get('/', [DichVuController::class, 'index'])->name('dichvu.index');
        Route::get('/create', [DichVuController::class, 'create'])->name('dichvus.create');
        Route::post('', [DichVuController::class, 'store'])->name('dichvus.store');
        Route::get('/{id}/edit', [DichVuController::class, 'edit'])->name('dichvus.edit');
        Route::put('/{id}', [DichVuController::class, 'update'])->name('dichvus.update');
        Route::delete('/{id}', [DichVuController::class, 'destroy'])->name('dichvus.destroy');
    });

    Route::prefix('nha-tro')->group(function () {
        Route::get('/', [NhaTroController::class, 'index'])->name('nha_tro.index');
        Route::get('/create', [NhaTroController::class, 'create'])->name('nha_tro.create');
        Route::post('/store', [NhaTroController::class, 'store'])->name('nha_tro.store');
        Route::get('/edit/{nhaTro}', [NhaTroController::class, 'edit'])->name('nha_tro.edit');
        Route::put('/update/{nhaTro}', [NhaTroController::class, 'update'])->name('nha_tro.update');
        Route::delete('/delete/{nhaTro}', [NhaTroController::class, 'destroy'])->name('nha_tro.destroy');
    });


    Route::prefix('phong-tro')->name('rooms.')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/', [RoomController::class, 'store'])->name('store');
        Route::get('/{room}/edit', [RoomController::class, 'edit'])->name('edit');
        Route::put('/{room}', [RoomController::class, 'update'])->name('update');
        Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('dien-nuoc')->group(function () {
        Route::get('/', [DienNuocController::class, 'index'])->name('diennuoc.index');
        Route::post('/tao-du-lieu', [DienNuocController::class, 'store'])->name('diennuoc.store');
        Route::put('/{id}', [DienNuocController::class, 'update'])->name('diennuoc.update');
        Route::put('/chot/{id}', [DienNuocController::class, 'chot'])->name('diennuoc.chot');
    });

    Route::prefix('tai-sans')->group(function () {
        Route::get('/', [TaiSanController::class, 'index'])->name('tai-sans.index');           // Danh sách
        Route::get('/create', [TaiSanController::class, 'create'])->name('tai-sans.create');   // Form thêm
        Route::post('/store', [TaiSanController::class, 'store'])->name('tai-sans.store');           // Xử lý thêm
        Route::get('/{id}/edit', [TaiSanController::class, 'edit'])->name('tai-sans.edit');    // Form sửa
        Route::put('/{id}', [TaiSanController::class, 'update'])->name('tai-sans.update');     // Xử lý sửa
        Route::delete('/{id}', [TaiSanController::class, 'destroy'])->name('tai-sans.destroy'); // Xử lý xóa
    });
    Route::prefix('tin_tuc')->group(function () {
        Route::get('/', [TintucController::class, 'index'])->name('tin_tuc.index'); // Danh sách tin
        Route::get('/create', [TinTucController::class, 'create'])->name('tin_tuc.create'); // Form thêm
        Route::post('/store', [TinTucController::class, 'store'])->name('tin_tuc.store'); // Lưu tin mới
        Route::get('/{tinTuc}/edit', [TinTucController::class, 'edit'])->name('tin_tuc.edit'); // Form sửa
        Route::put('/{tinTuc}', [TinTucController::class, 'update'])->name('tin_tuc.update'); // Cập nhật tin
        Route::delete('/{tinTuc}/delete', [TinTucController::class, 'destroy'])->name('tin_tuc.destroy'); // Xóa tin

    });
    Route::prefix('tai-san-chung-rieng')->group(function () {
        Route::get('/', [TaiSanChungRiengController::class, 'index'])->name('tai_san_chung_riengs.index');
        Route::get('/create', [TaiSanChungRiengController::class, 'create'])->name('tai_san_chung_riengs.create');
        Route::post('/store', [TaiSanChungRiengController::class, 'store'])->name('tai_san_chung_riengs.store');
        Route::get('/{id}/edit', [TaiSanChungRiengController::class, 'edit'])->name('tai_san_chung_riengs.edit');
        Route::put('/{id}', [TaiSanChungRiengController::class, 'update'])->name('tai_san_chung_riengs.update');
        Route::delete('/{id}', [TaiSanChungRiengController::class, 'destroy'])->name('tai_san_chung_riengs.destroy');
    });
    Route::prefix('chinh-sach')->group(function () {
        Route::get('/', [PolicyController::class, 'index'])->name('policies.index');
        Route::get('/create', [PolicyController::class, 'create'])->name('policies.create');
        Route::post('/store', [PolicyController::class, 'store'])->name('policies.store');
        Route::get('/{policy}/edit', [PolicyController::class, 'edit'])->name('policies.edit');
        Route::put('/{policy}', [PolicyController::class, 'update'])->name('policies.update');
        Route::delete('/{policy}', [PolicyController::class, 'destroy'])->name('policies.destroy');
    });
    Route::prefix('sliders')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('sliders.index');
        Route::get('/create', [SliderController::class, 'create'])->name('sliders.create');
        Route::post('/store', [SliderController::class, 'store'])->name('sliders.store');
        Route::get('/{slider}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
        Route::put('/{slider}', [SliderController::class, 'update'])->name('sliders.update');
        Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('sliders.destroy');
    });
    Route::prefix('feedbacks')->name('feedbacks.')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('index');           // Danh sách
        Route::get('/create', [FeedbackController::class, 'create'])->name('create');   // Form thêm
        Route::post('/store', [FeedbackController::class, 'store'])->name('store');     // Lưu mới
        Route::get('/edit/{feedback}', [FeedbackController::class, 'edit'])->name('edit'); // Form sửa
        Route::put('/update/{feedback}', [FeedbackController::class, 'update'])->name('update'); // Cập nhật
        Route::post('/delete/{feedback}', [FeedbackController::class, 'destroy'])->name('destroy'); // Xóa
    });
    Route::prefix('web-config')->name('web-config.')->group(function () {
        Route::get('/', [WebConfigController::class, 'edit'])->name('edit');
        Route::put('/', [WebConfigController::class, 'update'])->name('update');
    });
    // Route::prefix('web-config')->name('web-config.')->group(function () {
    //     Route::get('/', [WebConfigController::class, 'edit'])->name('edit');
    //     Route::put('/', [WebConfigController::class, 'update'])->name('update');
    // });
    Route::prefix('about_us')->name('about_us.')->group(function () {
        Route::get('/', [AboutUsController::class, 'edit'])->name('edit');
        Route::put('/', [AboutUsController::class, 'update'])->name('update');
    });
    Route::prefix('khach-hang')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('quan-ly')->name('admin.quanly.')->group(function () {
        Route::get('/', [AdministratorController::class, 'index'])->name('index');
        Route::get('/create', [AdministratorController::class, 'create'])->name('create');
        Route::post('/store', [AdministratorController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [AdministratorController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdministratorController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdministratorController::class, 'destroy'])->name('destroy');
    });


    Route::get('/lien-he', [ContactController::class, 'index'])->name('lien_he.index.admin');


    Route::prefix('vai-tro')->name('admin.roles.')->group(function () {
        Route::get('/', [RolesControler::class, 'index'])->name('index');
        Route::get('/create', [RolesControler::class, 'create'])->name('create');
        Route::post('/', [RolesControler::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RolesControler::class, 'edit'])->name('edit');
        Route::put('/{role}', [RolesControler::class, 'update'])->name('update');
        Route::delete('/{role}', [RolesControler::class, 'destroy'])->name('destroy');
    });

    // Routes chính cho quản lý phương tiện
    Route::prefix('phuong-tiens')->name('admin.phuong_tiens.')->group(function () {
        Route::get('/', [PhuongTienController::class, 'index'])->name('index');
        Route::get('/create', [PhuongTienController::class, 'create'])->name('create');
        Route::post('/', [PhuongTienController::class, 'store'])->name('store');
        Route::get('/{phuong_tien}/edit', [PhuongTienController::class, 'edit'])->name('edit');
        Route::put('/{phuong_tien}', [PhuongTienController::class, 'update'])->name('update');
        Route::delete('/{phuong_tien}', [PhuongTienController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('cong-to')->name('admin.cong_tos.')->group(function () {
        Route::get('/', [CongtoController::class, 'index'])->name('index');
        Route::get('/create', [CongtoController::class, 'create'])->name('create');
        Route::post('/', [CongtoController::class, 'store'])->name('store');
        Route::get('/{congTo}/edit', [CongtoController::class, 'edit'])->name('edit');
        Route::put('/{congTo}', [CongtoController::class, 'update'])->name('update');
        Route::delete('/{congTo}', [CongtoController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('cong-to-dien')->name('admin.cong_tos.dien.')->group(function () {
        Route::get('/', [CongtoDienController::class, 'index'])->name('index');
        Route::get('/create', [CongtoDienController::class, 'create'])->name('create');
        Route::post('/', [CongtoDienController::class, 'store'])->name('store');
        Route::get('/{congTo}/edit', [CongtoDienController::class, 'edit'])->name('edit');
        Route::put('/{congTo}', [CongtoDienController::class, 'update'])->name('update');
        Route::delete('/{congTo}', [CongtoDienController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('cong-to-nuoc')->name('admin.cong_tos.nuoc.')->group(function () {
        Route::get('/', [CongtoNuocController::class, 'index'])->name('index');
        Route::get('/create', [CongtoNuocController::class, 'create'])->name('create');
        Route::post('/', [CongtoNuocController::class, 'store'])->name('store');
        Route::get('/{congTo}/edit', [CongtoNuocController::class, 'edit'])->name('edit');
        Route::put('/{congTo}', [CongtoNuocController::class, 'update'])->name('update');
        Route::delete('/{congTo}', [CongtoNuocController::class, 'destroy'])->name('destroy');
    });

    // routes/web.php

    Route::prefix('hop-dong')->name('admin.hop_dong.')->group(function () {
        Route::get('/', [HopDongController::class, 'index'])->name('index');
        Route::get('/create', [HopDongController::class, 'create'])->name('create');
        Route::post('/', [HopDongController::class, 'store'])->name('store');
        Route::get('/{hopDong}/print', [HopDongController::class, 'printContract'])->name('print');
        Route::get('/{hopDong}/edit', [HopDongController::class, 'edit'])->name('edit');
        Route::put('/{hopDong}', [HopDongController::class, 'update'])->name('update');
        Route::delete('/{hopDong}', [HopDongController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('hoa-dons')->name('hoa-dons.')->group(function () {
        Route::get('/', [HoaDonController::class, 'index'])->name('index');
        Route::get('/create', [HoaDonController::class, 'showGenerateForm'])->name('create');
        Route::post('/', [HoaDonController::class, 'generateInvoices'])->name('store');
        Route::get('/{hoaDon}/edit', [HoaDonController::class, 'edit'])->name('edit');
        Route::put('/{hoaDon}', [HoaDonController::class, 'update'])->name('update');
        Route::get('/{hoaDon}', [HoaDonController::class, 'show'])->name('show');
        Route::delete('/{hoaDon}', [HoaDonController::class, 'destroy'])->name('destroy');
    });

    // 3. Route để tạo một hóa đơn duy nhất trực tiếp từ một hợp đồng cụ thể
    Route::post('/hop-dongs/{hop_dong}/tao-hoa-don', [HoaDonController::class, 'taoHoaDonChoHopDong'])
        ->name('hop-dongs.tao-hoa-don');
    Route::prefix('thong-tin-ca-nhan')->name('admin.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('profile', [ProfileController::class, 'update'])->name('update');
        Route::put('change-password', [ProfileController::class, 'updatePassword'])->name('change_password');
        Route::get('vehicles', [ProfileController::class, 'getVehicles'])->name('vehicles.index');
        Route::post('vehicles', [ProfileController::class, 'storeVehicle'])->name('vehicles.store');
        // THAY ĐỔI Ở ĐÂY: {vehicle} -> {phuongTien}
        Route::get('vehicles/{phuongTien}', [ProfileController::class, 'showVehicle'])->name('vehicles.show');
        Route::put('vehicles/{phuongTien}', [ProfileController::class, 'updateVehicle'])->name('vehicles.update');
        Route::delete('vehicles/{phuongTien}', [ProfileController::class, 'destroyVehicle'])->name('vehicles.destroy');
    });
    Route::prefix('faqs')->name('admin.faqs.')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('index');
        Route::get('/create', [FaqController::class, 'create'])->name('create');
        Route::post('/', [FaqController::class, 'store'])->name('store');
        Route::get('/{faq}/edit', [FaqController::class, 'edit'])->name('edit');
        Route::put('/{faq}', [FaqController::class, 'update'])->name('update');
        Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('destroy');
    });

    // Route cho các cổng thanh toán
    Route::prefix('payment')->name('payment.')->group(function () {
        // VNPay routes
        Route::post('/vnpay/create/{hoaDon}', [VnpayController::class, 'createPayment'])->name('vnpay.create');
        Route::get('/vnpay/return', [VnpayController::class, 'handleReturn'])->name('vnpay.return');

        // THÊM MỚI: ZaloPay routes
        Route::post('/zalopay/create/{hoaDon}', [ZaloPayController::class, 'createPayment'])->name('zalopay.create');
        Route::post('/zalopay/callback', [ZaloPayController::class, 'handleCallback'])->name('zalopay.callback');
    });

    Route::post('/upload-image', [UploadController::class, 'uploadImage'])->name('upload-image');
    Route::post('/delete-image', [UploadController::class, 'deleteImage'])->name('delete-image');
});
