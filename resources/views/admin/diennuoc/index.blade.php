@extends('admin.index')
@section('contentadmin')
    <div class="pagetitle">
        <h1>Người quản trị</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Người quản trị</li>
            </ol>
        </nav>
    </div>




    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-sm-flex justify-content-between align-items-center">
                        <h5 class="card-title">Nội dung Người quản trị</h5>
                        <a href="{{ route('admin.quanly.create') }}" class="btn btn-success rounded-pill">Thêm Người quản
                            trị</a>
                    </div>

                    <form method="GET" action="{{ route('diennuoc.index') }}" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label>Tòa nhà</label>
                                <select name="nha_tro_id" class="form-select" required>
                                    <option value="">-- Chọn tòa nhà --</option>
                                    @foreach ($nhaTros as $nt)
                                        <option value="{{ $nt->id }}"
                                            {{ $selectedNhaTroId == $nt->id ? 'selected' : '' }}>
                                            {{ $nt->ten_toa_nha }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Tháng</label>
                                <select name="thang" class="form-select" required>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $thang == $i ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            @php
                                $currentYear = date('Y');
                                $startYear = 1990;
                                $endYear = $currentYear + 5;
                            @endphp

                            <div class="col-md-2">
                                <label>Năm</label>
                                <select name="nam" class="form-select" required>
                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option value="{{ $year }}"
                                            {{ ($nam ?? $currentYear) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-2 align-self-end">
                                <button class="btn btn-primary w-100">Xem dữ liệu</button>
                            </div>
                        </div>
                    </form>

                    @if ($canTao)
                        <form method="POST" action="{{ route('diennuoc.store') }}">
                            @csrf
                            <input type="hidden" name="nha_tro_id" value="{{ $selectedNhaTroId }}">
                            <input type="hidden" name="thang" value="{{ $thang }}">
                            <input type="hidden" name="nam" value="{{ $nam }}">
                            <button class="btn btn-success">Tạo dữ liệu điện nước</button>
                        </form>
                    @endif

                    @if (!empty($dienNuocs))
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Phòng</th>
                                    <th>Số điện (kWh)</th>
                                    @if ($kieuTinhNuoc == 'cong_to')
                                        <th>Số nước (m³)</th>
                                    @elseif($kieuTinhNuoc == 'dau_nguoi')
                                        <th>Số nước (Tính theo đầu người)</th>
                                    @elseif($kieuTinhNuoc == 'co_dinh')
                                        <th>Số nước (Tính theo phòng)</th>
                                    @endif
                                    <th>Số người</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dienNuocs as $dn)
                                    <tr>
                                        <form method="POST" action="{{ route('diennuoc.update', $dn->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <td>{{ optional($dn->room)->ten_phong }}</td>

                                            {{-- Chỉ số điện --}}
                                            <td>
                                                <input type="number" step="0.1" name="chi_so_dien" class="form-control"
                                                    value="{{ $dn->chi_so_dien }}">
                                            </td>

                                            {{-- Số nước --}}
                                            <td>
                                                @if ($kieuTinhNuoc == 'cong_to')
                                                    <input type="number" step="0.1" name="so_m3_nuoc"
                                                        class="form-control" value="{{ $dn->so_m3_nuoc }}">
                                                @elseif($kieuTinhNuoc == 'dau_nguoi')
                                                    <input type="number" class="form-control" name="so_m3_nuoc"
                                                        value="{{ $dn->so_nguoi }}" readonly>
                                                @elseif($kieuTinhNuoc == 'co_dinh')
                                                    <input type="text" class="form-control" value="1"
                                                        name="so_m3_nuoc" readonly>
                                                @endif
                                            </td>

                                            {{-- Số người --}}
                                            <td>
                                                <input type="number" name="so_nguoi" class="form-control"
                                                    value="{{ $dn->so_nguoi }}">
                                            </td>

                                            <td>
                                                <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>


            </div>
        </div>

    </div>
@endsection
