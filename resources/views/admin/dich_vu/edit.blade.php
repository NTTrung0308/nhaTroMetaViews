@extends('admin.index')
@section('contentadmin')
   

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Sửa dịch vụ</h5>

                    </div>
                    <div class="col-12">



                        <form action="{{ route('dichvus.update', $dichvu->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="ten_dich_vu" class="form-label">Tên dịch vụ</label><br>
                                    <input type="text" class="form-control" id="ten_dich_vu" name="ten_dich_vu"
                                        value="{{ old('ten_dich_vu', $dichvu->ten_dich_vu) }}">
                                    <div class="text-danger" id="err-ten_dich_vu"></div>
                                    @error('ten_dich_vu')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                @php
                                    $dichVuOptions = [
                                        'dien_sinh_hoat' => 'Điện sinh hoạt',
                                        'nuoc' => 'Nước',
                                        'mang' => 'Mạng internet',
                                        'rac' => 'Phí rác',
                                        'bao_tri' => 'Phí bảo trì',
                                        'giu_xe_may' => 'Gửi xe máy',
                                        'giu_xe_dap' => 'Gửi xe đạp',
                                        'giu_xe_oto' => 'Gửi ô tô',
                                        'vs_chung' => 'Vệ sinh chung',
                                        'an_ninh' => 'An ninh',
                                        'truyen_hinh' => 'Truyền hình cáp',
                                        'thang_may' => 'Phí thang máy',
                                        'wifi' => 'Wifi',
                                        'khu_tu_quan' => 'Phí tự quản',
                                        'dich_vu_khac' => 'Dịch vụ khác',
                                        'phi_quan_ly' => 'Phí quản lý',
                                    ];
                                @endphp

                                <div class="col-lg-6">
                                    <label for="ma_dich_vu" class="form-label">Mã dịch vụ</label>
                                    <select class="form-control" id="ma_dich_vu" name="ma_dich_vu">
                                        <option value="">-- Chọn mã dịch vụ --</option>
                                        @foreach ($dichVuOptions as $value => $label)
                                            @php
                                                $isDisabled =
                                                    in_array($value, $maDichVuDaTonTai ?? []) &&
                                                    $value !== $dichvu->ma_dich_vu;
                                                $isSelected = old('ma_dich_vu', $dichvu->ma_dich_vu) == $value;
                                            @endphp
                                            <option value="{{ $value }}" {{ $isSelected ? 'selected' : '' }}
                                                {{ $isDisabled ? 'disabled' : '' }}>
                                                {{ $label }} {{ $isDisabled ? '(Đã tồn tại)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="text-danger" id="err-ma_dich_vu"></div>
                                    @error('ma_dich_vu')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-lg-12">
                                    <label for="don_vi_tinh_id" class="form-label">Đơn vị tính</label><br>
                                    <select id="don_vi_tinh_id" name="don_vi_tinh_id" class="select_ted form-control">
                                        <option value="">-- Chọn đơn vị tính --</option>
                                        @foreach ($donViTinhs as $dvt)
                                            <option value="{{ $dvt->id }}"
                                                {{ old('don_vi_tinh_id', $dichvu->don_vi_tinh_id) == $dvt->id ? 'selected' : '' }}>
                                                {{ $dvt->ma_don_vi }} - {{ $dvt->ten_day_du }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger" id="err-don_vi_tinh_id"></div>
                                    @error('don_vi_tinh_id')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-lg-6">
                                    <label for="kieu_tinh" class="form-label">Kiểu tính</label><br>
                                    <select id="kieu_tinh" name="kieu_tinh" class="select_ted form-control">
                                          <option value="">-- Chọn kiểu tính --</option>
                                    <option value="cong_to"
                                        {{ old('kieu_tinh', $dichvu->kieu_tinh) == 'cong_to' ? 'selected' : '' }}>Tính theo
                                        công tơ</option>
                                    <option value="dau_nguoi"
                                        {{ old('kieu_tinh', $dichvu->kieu_tinh) == 'dau_nguoi' ? 'selected' : '' }}>Tính
                                        theo đầu người</option>
                                    <option value="co_dinh"
                                        {{ old('kieu_tinh', $dichvu->kieu_tinh) == 'co_dinh' ? 'selected' : '' }}>Cố định
                                        hàng tháng</option>
                                    </select>
                                    <div class="text-danger" id="err-kieu_tinh"></div>
                                    @error('kieu_tinh')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="don_gia" class="form-label">Đơn giá</label><br>
                                    <input type="number" id="don_gia" class="form-control" name="don_gia" step="0.01"
                                        value="{{ old('don_gia', $dichvu->don_gia) }}">
                                    <div class="text-danger" id="err-don_gia"></div>
                                    @error('don_gia')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div>
                                    <label for="mo_ta" class="form-label">Mô tả</label><br>
                                    <textarea id="mo_ta" name="mo_ta" class="form-control">{{ old('mo_ta', $dichvu->mo_ta) }}</textarea>
                                    @error('mo_ta')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="text-end pt-4">
                                <button type="submit" class="btn btn-success">Cập nhật dịch vụ</button>
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
