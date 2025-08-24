@extends('admin.index')
@section('contentadmin')
   

    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Thêm mới dịch vụ</h5>

                    </div>
                    <div class="col-12">
                        <form id="formDichVu" action="{{ route('dichvus.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="ten_dich_vu" class="form-label">Tên dịch vụ</label><br>
                                    <input type="text" class="form-control" id="ten_dich_vu" name="ten_dich_vu"
                                        value="{{ old('ten_dich_vu') }}">
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
                                        'phi_quan_ly' => 'Phí quản lý'
                                    ];
                                @endphp

                                <div class="col-lg-6">
                                    <label for="ma_dich_vu" class="form-label">Mã dịch vụ</label>
                                    <select class="form-control" id="ma_dich_vu" name="ma_dich_vu">
                                        <option value="">-- Chọn mã dịch vụ --</option>
                                        @foreach ($dichVuOptions as $value => $label)
                                            @php
                                                $isDisabled = in_array($value, $maDichVuDaTonTai ?? []);
                                                $isSelected = old('ma_dich_vu') == $value;
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
                                                {{ old('don_vi_tinh_id') == $dvt->id ? 'selected' : '' }}>
                                                {{ $dvt->ma_don_vi }} - {{ $dvt->ten_day_du }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger" id="err-don_vi_tinh_id"></div>
                                    @error('don_vi_tinh_id')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>

                               

                                <div>
                                    <label for="mo_ta" class="form-label">Mô tả</label><br>
                                    <textarea id="mo_ta" name="mo_ta" class="form-control">{{ old('mo_ta') }}</textarea>
                                    @error('mo_ta')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="text-end pt-4">
                                <button type="submit" class="btn btn-success">Thêm dịch vụ</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
