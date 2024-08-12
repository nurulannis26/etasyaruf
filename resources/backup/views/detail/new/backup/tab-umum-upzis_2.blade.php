{{-- filter --}}
<div class="card intro-card-data-pengajuan">
    <div class="card-body ">
        {{-- row1 1 --}}
        <form action="/{{ $role }}/filter_umum_upzis" method="post" id="filterFormUpzis">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">
            <input type="hidden" name="status2" value="{{ $status2 }}">
            <input type="hidden" name="start_date2" value="{{ $start_date2 }}">
            <input type="hidden" name="end_date2" value="{{ $end_date2 }}">
            <input type="hidden" name="id_upzis2" value="{{ $id_upzis2 }}">
            <input type="hidden" name="filter_daterange2" value="{{ $filter_daterange2 }}">

            {{-- <input type="text" name="" id="" value="{{ $id_upzis }}">
            <input type="text" name="" id="" value="{{ $status }}"> --}}

            <div class="form-row ">

                {{-- date range --}}
                <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control text-center icon-input" id="reportrange"
                            name="filter_daterange" readonly
                            style="background-color: white;cursor: pointer;min-width:175px;height:37.5px;">
                    </div>
                </div>

                {{-- status --}}
                <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                    <div class="input-group ">
                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                            <select onchange="submitFormUpzis()" name="status" class="form-control select2"
                                id="select2Status" readonly>
                                <option value="Diajukan" {{ $status == 'Diajukan' ? 'selected' : '' }}>Semua Status Rekom
                                <option value="Sudah Terbit Rekom"
                                    {{ $status == 'Sudah Terbit Rekom' ? 'selected' : '' }}>
                                    Sudah Terbit Rekom
                                </option>
                                <option value="Belum Terbit Rekom"
                                    {{ $status == 'Belum Terbit Rekom' ? 'selected' : '' }}>
                                    Belum Terbit Rekom
                                </option>
                            </select>
                        @else
                            <select onchange="submitFormUpzis()" name="status" class="form-control select2"
                                id="select2Status">
                                <option value="Semua" {{ $status == 'Semua' ? 'selected' : '' }}>Semua Status
                                </option>
                                <option value="Direncanakan" {{ $status == 'Direncanakan' ? 'selected' : '' }}>
                                    Direncanakan
                                </option>
                                <option value="Diajukan" {{ $status == 'Diajukan' ? 'selected' : '' }}>Diajukan
                                </option>
                                <option value="Sudah Terbit Rekom"
                                    {{ $status == 'Sudah Terbit Rekom' ? 'selected' : '' }}>
                                    Sudah Terbit Rekom
                                </option>
                                <option value="Belum Terbit Rekom"
                                    {{ $status == 'Belum Terbit Rekom' ? 'selected' : '' }}>
                                    Belum Terbit Rekom
                                </option>
                            </select>
                        @endif
                    </div>
                </div>

                {{-- upzis --}}
                <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                    <div class="input-group ">
                        <select class="form-control" onchange="submitFormUpzis()" name="id_upzis" id="select2Upzis">
                            @if (Auth::user()->gocap_id_pc_pengurus != null)
                                <option value="" {{ $id_upzis == null ? 'selected' : '' }}>Semua Upzis
                                </option>
                            @endif
                            @foreach ($daftar_upzis as $a)
                                <option value="{{ $a->id_upzis }}" {{ $id_upzis == $a->id_upzis ? 'selected' : '' }}>
                                    {{ $a->nama }}
                                    ({{ $a->id_wilayah }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- reset --}}
                <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                    <a class="btn btn-light border-grey hover btn-block tombol-reset-pc"
                        href="/{{ $role }}/upzis-ranting"><i class="fas fa-sync-alt"></i>&nbsp;
                    </a>
                </div>


                <div class="col-12 col-md-2 col-sm-12  mb-xl-0">
                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                        {{-- <a href="#" target="_blank"
                        class="btn btn-block btn-outline-success  hover intro-ekspors-data-pengajuan">
                        <i class="fas fa-file-pdf"></i> Ekspor</a> --}}
                        <div class="btn btn-group btn-block p-0 m-0" role="group">
                            <button type="button" class="btn btn-outline-success dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="false"><i
                                    class="fas fa-file-download"></i>&ensp;Ekspor
                            </button>
                            <div class="dropdown-menu btn-block" style="border-radius: 10px">
                                
                                <a class="dropdown-item btn-block" target="_blank"
                                    href="{{ route('pdf_umum_upzis', [
                                        'role' => $role,
                                        'status' => $status,
                                        'start_date' => $start_date,
                                        'end_date' => $end_date,
                                        'filter_daterange' => $filter_daterange,
                                        'id_upzis' => $id_upzis ??'semua',
                                        'id_upzis2' => $id_upzis2 ??'semua',
                                        'id_ranting2' => $id_ranting2 ??'semua',
                                        'status2' => $status2,
                                        'filter_daterange2' => $filter_daterange2,
                                    ]) }}">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>



                                <a class="dropdown-item btn-block" href=""><i class="fas fa-file-alt"></i>
                                    EXCEL</a>
                            </div>
                        </div>
                    @else
                        <button class="btn btn btn-success hover btn-block" data-toggle="modal"
                            data-target="#tambah-pengajuan-upzis" type="button"><i class="fas fa-plus-circle"></i>
                            Tambah</button>
                    @endif
                </div>
            </div>
        </form>

        {{-- row2 2 --}}
        <div class="form-row">
            {{-- info --}}
            <div class="col-12 col-md-10 col-sm-12  mb-xl-0">
                <div class="d-flex flex-row bd-highlight align-items-center">
                    <div class="p-1 bd-highlight">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="p-1 bd-highlight">
                        <span>
                            Data pengajuan yang telah disetujui otomatis menjadi <a
                                href="https://e-askeu.nucarecilacap.id/upzis/laporankeu" target="_blank"><b
                                    style="font-size: 12pt;">
                                    laporan penyaluran</b></a>
                        </span>
                    </div>
                </div>
            </div>
            {{-- ekspor --}}
           {{-- @if (Auth::user()->gocap_id_upzis_pengurus != null)
                <div class="col-12 col-md-2 col-sm-12  mb-xl-0">
                    <div class="btn btn-group btn-block  " role="group">
                        <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle"
                            data-toggle="dropdown" aria-expanded="false"><i
                                class="fas fa-file-download"></i>&ensp;Ekspor
                        </button>
                        <div class="dropdown-menu btn-block" style="border-radius: 10px">
                            <a class="dropdown-item btn-block"
                                href="/{{ $role }}/laporan/{{ $data->id_pengajuan }}" target="_blank"><i
                                    class="fas fa-file-pdf"></i> PDF</a>
                            <a class="dropdown-item btn-block"
                                href="/{{ $role }}/laporan-excel/{{ $data->id_pengajuan }}"><i
                                    class="fas fa-file-alt"></i>
                                EXCEL</a>
                        </div>
                    </div>
                </div>
            @endif --}}
        </div>
    </div>
</div>

@if (Auth::user()->gocap_id_pc_pengurus != null)
<div class="row">
    <div class="col-12 col-md-3 mb-2">
        <div class="card ">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="h6">Total Pengajuan

                        </div>
                        <b> Rp. 0</b>

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            0 Pengajuan (0 Program)</div>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-2">
        <div class="card ">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="h6">Dalam Proses

                        </div>
                         <b> Rp. 0</b>

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            0 Pengajuan (0 Program)</div>

                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-2">
        <div class="card ">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="h6">Terbit Rekomendasi

                        </div>

                         <b> Rp. 0</b>

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            0 Pengajuan (0 Program)</div>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-2">
        <div class="card ">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="h6">Penyaluran & LPJ

                        </div>

                         <b> Rp. 0</b>

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            0 Pengajuan (0 Program)</div>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if (Auth::user()->gocap_id_upzis_pengurus != null)
<div class="row">
    <div class="col-12 col-md-3 mb-2">
        <div class="card ">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="h6">Pengajuan Direncanakan

                        </div>
                        <b> Rp. 0</b>

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            0 Pengajuan (0 Program)</div>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-2">
        <div class="card ">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="h6">Telah Diajukan

                        </div>

                        <b> Rp. 0</b>

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            0 Pengajuan (0 Program)</div>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-2">
        <div class="card ">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="h6">Terbit Rekomendasi

                        </div>

                        <b> Rp. 0</b>

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            0 Pengajuan (0 Program)</div>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-2">
        <div class="card ">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="h6">Penyaluran & LPJ

                        </div>

                        <b> Rp. 0</b>

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            0 Pengajuan (0 Program)</div>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<div class="table-responsive card card-body">

    <table class="table table-bordered table-hover" id="Upzis" style="width:100%">
        <thead>
            <tr class="text-center ">
                <th style="width: 3%;vertical-align:middle;text-align:center"> No
                </th>
                <th style="vertical-align:middle;text-align:center">Nomor & Nominal Pengajuan</th>

                <th style="width: 13%;vertical-align:middle;text-align:center">Status Pengajuan</th>
                <th style="width: 13%;vertical-align:middle;text-align:center">Status Rekomendasi</th>
                <th style="width: 15%;vertical-align:middle;text-align:center">
                    Nominal
                    <br>
                    Disetujui
                </th>
                <th style="width: 15%;vertical-align:middle;text-align:center">
                    Nominal Dapat<br>
                    Dicairkan
                </th>
                <th style="width: 14%;vertical-align:middle;text-align:center">Penyaluran & <br>Status LPJ</th>
                <th style="width: 5%;vertical-align:middle;text-align:center">Aksi</th>

                {{-- @if (Auth::user()->gocap_id_upzis_pengurus != null)
                <th style="width: 9%;vertical-align:middle;text-align:center">PJ <br>Pengambilan Dana</th>
                <th style="width: 5%;vertical-align:middle;text-align:center">Aksi</th>
                @else
                <th style="width: 14%;vertical-align:middle;text-align:center">PJ <br>Pengambilan Dana</th>
                @endif --}}
            </tr>
        </thead>
        <tbody>

            @foreach ($data as $a)
                <tr>
                    {{-- row1 --}}
                    <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                        class="text-bold" style=" cursor: pointer;text-align:center;padding-top:3mm;">
                        {{ $loop->iteration }}</td>
                    {{-- row2 --}}
                    <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                        style=" cursor: pointer;font-size: 12pt ">
                        <span class="text-bold" style="font-size: 13px">
                            {{ $a->nomor_surat }}
                        </span>
                        <br>
                        <div class="d-flex justify-content-between" style="font-size: 13px">
                            <div>Pengajuan</div>
                            <div class="text-bold">
                                Rp{{ number_format(
                                    app\Http\Controllers\PengajuanController::hitung_nominal_pengajuan($a->id_pengajuan),
                                    0,
                                    '.',
                                    '.',
                                ) }},-
                            </div>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size: 13px">
                            <div>Tgl Input</div>
                            <div class="text-bold">
                                {{ Carbon\Carbon::parse($a->created_at)->isoFormat('D MMMM Y') }}
                                {{-- {{ Carbon\Carbon::parse($a->created_at)->format('H:i:s') }} --}}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size: 13px">
                            <div>Jml.Rencana Kegiatan</div>
                            <div class="text-bold">
                                {{ app\Http\Controllers\PengajuanController::hitung_jumlah_rencana($a->id_pengajuan) }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size: 13px">
                            <div>Jml.Penerima Manfaat</div>
                            <div class="text-bold">
                                {{ app\Http\Controllers\PengajuanController::hitung_jumlah_penerima($a->id_pengajuan) }}
                            </div>
                        </div>
                    </td>

                    {{-- status pengajuan --}}
                    <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                        style=" cursor: pointer;">
                        @if ($a->status_pengajuan == 'Diajukan')
                            <div class="btn btn-light btn-block noClick btn-sm text-bold text-success"
                                style="border-radius:10px;background-color:#cbf2d6">
                                Diajukan
                            </div>
                        @else
                            <div class="btn btn-light btn-block noClick btn-sm text-bold text-secondary"
                                style="border-radius:10px;background-color:#dcdcdc">
                                Direncanakan
                            </div>
                        @endif
                        <div class="text-left" style="font-size: 10pt;">
                            <em class="text-secondary">
                                {{ $a->tgl_konfirmasi ? Carbon\Carbon::parse($a->tgl_konfirmasi)->isoFormat('D MMMM Y') : '-' }}</em><br>
                            Dikonfirmasi Oleh <br>

                            <span class="text-bold" style="font-size: 10pt;">
                                {{ $a->dikonfirmasi_oleh_upzis
                                    ? app\Http\Controllers\PengajuanController::getNamaPengurus('upzis', $a->dikonfirmasi_oleh_upzis)
                                    : '-' }}
                            </span>
                            <br>
                            <span style="font-size: 10pt;">
                                {{ $a->dikonfirmasi_oleh_upzis
                                    ? app\Http\Controllers\PengajuanController::getJabatanPengurus('upzis', $a->dikonfirmasi_oleh_upzis)
                                    : '-' }}
                            </span>
                        </div>
                    </td>
                    {{-- status pengajuan --}}

                    {{-- status rekomendasi --}}
                    <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                        style=" cursor: pointer;">
                        @if ($a->status_rekomendasi == 'Sudah Terbit')
                            <div class="btn btn-light btn-block noClick btn-sm text-bold text-success"
                                style="border-radius:10px;background-color:#cbf2d6">
                                Sudah Terbit
                            </div>
                        @else
                            <div class="btn btn-light btn-block noClick btn-sm text-bold text-secondary"
                                style="border-radius:10px;background-color:#dcdcdc">
                                Belum Terbit
                            </div>
                        @endif
                        <div class="text-left" style="font-size: 10pt;">
                            <em class="text-secondary">
                                {{ $a->tgl_terbit_rekomendasi ? Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('D MMMM Y') : '-' }}</em><br>
                            PJ Pengambilan Dana <br>

                            <span class="text-bold" style="font-size: 10pt;">
                                {{ $a->pj_upzis ? app\Http\Controllers\PengajuanController::getNamaPengurus('upzis', $a->pj_upzis) : '-' }}
                            </span>
                            <br>
                            <span style="font-size: 10pt;">
                                {{ $a->pj_upzis ? app\Http\Controllers\PengajuanController::getJabatanPengurus('upzis', $a->pj_upzis) : '-' }}
                            </span>
                        </div>

                    </td>
                    {{-- status rekomendasi --}}



                    {{-- row3 --}}
                    <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                        class="text-right" style=" cursor: pointer;">
                        <b class="text-success" style="font-size: 12pt;">
                            Rp{{ number_format(
                                app\Http\Controllers\PengajuanController::hitung_nominal_pengajuan_disetujui($a->id_pengajuan),
                                0,
                                '.',
                                '.',
                            ) }},-
                        </b>
                        <div class="text-right" style="font-size: 10pt;">
                            <em class="text-success">{{ app\Http\Controllers\PengajuanController::detailSetujui($a->id_pengajuan)['acc'] }}
                                ACC</em><br>
                            <em class="text-secondary">{{ app\Http\Controllers\PengajuanController::detailSetujui($a->id_pengajuan)['belum'] }}
                                Belum</em><br>
                            <em class="text-danger">{{ app\Http\Controllers\PengajuanController::detailSetujui($a->id_pengajuan)['tolak'] }}
                                Ditolak</em>
                        </div>
                    </td>
                    {{-- end jumlah nominal diajukan --}}

                    {{-- jumlah nominal pencairan --}}
                    <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                        class="text-right" style=" cursor: pointer;">
                        <b class="text-warning" style="font-size: 12pt;">
                            Rp{{ number_format(
                                app\Http\Controllers\PengajuanController::hitung_nominal_pencairan($a->id_pengajuan),
                                0,
                                '.',
                                '.',
                            ) }},-
                        </b>
                        <div class="text-right" style="font-size: 10pt;">
                            <em class="text-warning">{{ app\Http\Controllers\PengajuanController::detailPencairan($a->id_pengajuan)['acc'] }}
                                ACC</em><br>
                            <em class="text-secondary">{{ app\Http\Controllers\PengajuanController::detailPencairan($a->id_pengajuan)['belum'] }}
                                Belum</em><br>
                            <em class="text-danger">{{ app\Http\Controllers\PengajuanController::detailPencairan($a->id_pengajuan)['tolak'] }}
                                Ditolak</em>
                        </div>
                    </td>
                    {{-- end jumlah nominal pencairan --}}




                    {{-- lpj --}}
                    <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                        class="text-right" style=" cursor: pointer;">


                        <b class="text-primary" style="font-size: 12pt;">
                            Rp{{ number_format(
                                app\Http\Controllers\PengajuanController::hitung_nominal_penyaluran($a->id_pengajuan),
                                0,
                                '.',
                                '.',
                            ) }},-
                        </b>

                        <div class="text-right" style="font-size: 10pt;">
                            <em class="text-primary">{{ app\Http\Controllers\PengajuanController::detailPenyaluran($a->id_pengajuan)['konfirmasi'] }}
                                Sudah LPJ</em><br>

                        </div>
                        <b class="text-success" style="font-size: 12pt;">
                            Rp{{ number_format(
                                app\Http\Controllers\PengajuanController::hitung_nominal_penyaluran2($a->id_pengajuan),
                                0,
                                '.',
                                '.',
                            ) }},-
                        </b>
                        <div class="text-right" style="font-size: 10pt;">
                            <em class="text-success">{{ app\Http\Controllers\PengajuanController::detailPenyaluran($a->id_pengajuan)['selesai'] }}
                                ACC</em>
                        </div>
                        <div class="text-right" style="font-size: 10pt;">

                            <em class="text-secondary">{{ app\Http\Controllers\PengajuanController::detailPenyaluran($a->id_pengajuan)['belum'] }}
                                Belum</em><br>
                            <em class="text-danger">{{ app\Http\Controllers\PengajuanController::detailPenyaluran($a->id_pengajuan)['revisi'] }}
                                Ditolak</em>
                        </div>
                    </td>

                    {{-- {{ dd($a) }} --}}

                    <td>
                        <div class="text-center">
                            @if ($a->status_pengajuan == 'Diajukan')
                                <a type="button" data-toggle="tooltip" data-placement="top"
                                    title="Pengajuan ini tidak dapat dihapus"><i class="fas fa-trash"
                                        style="color: rgb(158, 158, 158);"></i>
                                </a>
                            @else
                                <a data-toggle="modal" data-target="#modal_hapus{{ $a->id_pengajuan }}"
                                    type="button"><i class="fas fa-trash" style="color: red;"></i>
                                </a>
                            @endif
                        </div>
                    </td>

                </tr>

                {{-- modal --}}

                <div class="modal fade" id="modal_hapus{{ $a->id_pengajuan }}" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <b>Konfirmasi Hapus Pengajuan</b>
                            </div>
                            <div class="modal-body">
                                <b>{{ $a->nomor_surat }}</b>
                                <p>Yakin ingin menghapus data?</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal"><i
                                        class="fas fa-ban"></i> Batal</button>
                                <a href="/{{ $role }}/pengajuan_hapus/{{ $a->id_pengajuan }}"
                                    class="btn btn-danger close-modal"><i class="fas fa-trash"></i>
                                    Iya, Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>

{{--
<div class="table-responsive card card-body">

    <table class="table" id="myTable" style="width:100%">
        <thead>
            <tr class="text-center">
                <th style="width: 5%;vertical-align:middle;text-align:center"> No
                </th>
                <th style="vertical-align:middle;text-align:center">Detail Singkat Pengajuan</th>

                <th style="width: 30%;vertical-align:middle;text-align:center">
                    Nominal
                </th>
            </tr>
        </thead>

        <tbody>

            @foreach ($data as $a)
            <tr>
                <td class="text-bold" style=" cursor: pointer;text-align:center;padding-top:3mm;">
                    {{ $loop->iteration }}</td>
                <td style=" cursor: pointer;font-size: 12pt ">
                    <div class="d-flex justify-content-between">
                        <span class="text-bold" style="font-size: 13pt">
                            {{ $a->nomor_surat }}
                        </span>
                        <span class="text-secondary" style="font-size: 10pt;"><em>
                                Tgl Input :
                                {{ Carbon\Carbon::parse($a->tgl_pengajuan)->isoFormat('D MMMM Y') }}
                                {{ Carbon\Carbon::parse($a->created_at)->format('H:i:s') }}
                            </em>
                        </span>
                    </div>

                    <sup class="badge badge-success badge1 text-success">Pengajuan : Sedang
                        Direncanakan</sup>
                    <sup class="badge badge-success badge2 text-secondary">Rekomendasi : Belum
                        Terbit</sup>
                    <br>
                    <div><em>Jml.Rencana Kegiatan (8)</em></div>
                    <div class="d-flex justify-content-between">
                        <div><em>Jml.Penerima Manfaat (8 Orang)</em></div>
                        <div><em>PJ Pengambilan Dana (Surya Aji Sevyanto)</em></div>
                    </div>
                </td>
                <td class="text-right" style=" cursor: pointer;">
                    <div class="d-flex justify-content-between">
                        <div class="float-left">
                            <em>
                                <span>Pengajuan</span>
                            </em>
                        </div>
                        <em class="text-bold">
                            Rp12.000.000,-
                        </em>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="float-left">
                            <em>
                                <span>Disetujui</span>
                            </em>
                        </div>
                        <em class="text-bold text-success">
                            Rp12.000.000,-
                        </em>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="float-left">
                            <em>
                                <span>Bisa Dicarikan</span>
                            </em>
                        </div>
                        <em class="text-bold text-warning">
                            Rp12.000.000,-
                        </em>
                    </div>
                    <div class="mt-1">
                        <button class="btn  btn-xs hover text-secondary text-bold"
                            style="border-radius:5px;background-color:rgb(243, 243, 243)">
                            <i class="fas fa-circle-info"></i> Detail
                        </button>
                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>

    </table>
</div> --}}


<div class="row">
    <div class="col-md-8">

        <div class="card ">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <strong>
                        Jumlah Program Berdasarkan Pilar
                    </strong>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <canvas id="ChartUpzis"
                            style="min-height: 300px; height: 300px; max-height: 100%; max-width: 100%; "></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card ">
            <div class="card-body">
                <strong>
                    Statistik Pentasyarufan
                </strong>
                <br>

                <div class="card p-3 mt-2">
                    <div class="row">
                        <div class="col-md-6">
                            <em>Total Pengajuan</em><br>
                            <span class="text-bold">
                                {{ App\Http\Controllers\Chart::getStatisticPengajuan(
                                    'total',
                                    'upzis',
                                    $id_upzis,
                                    null,
                                    $start_date,
                                    $end_date,
                                    $status,
                                ) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <em>Total Program</em><br>
                            <span class="text-bold">
                                {{ App\Http\Controllers\Chart::getStatisticPengajuan(
                                    'program',
                                    'upzis',
                                    $id_upzis,
                                    null,
                                    $start_date,
                                    $end_date,
                                    $status,
                                ) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <em>Total Penerima</em><br>
                            <span class="text-bold">
                                {{ App\Http\Controllers\Chart::getStatisticPengajuan(
                                    'penerima',
                                    'upzis',
                                    $id_upzis,
                                    null,
                                    $start_date,
                                    $end_date,
                                    $status,
                                ) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <em>Total Dapat Dicairkan</em><br>
                            <span class="text-bold text-warning">
                                Rp{{ number_format(
                                    App\Http\Controllers\Chart::getStatisticPengajuan(
                                        'dicairkan',
                                        'upzis',
                                        $id_upzis,
                                        null,
                                        $start_date,
                                        $end_date,
                                        $status,
                                    ),
                                    0,
                                    ',',
                                    '.',
                                ) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@push('script')
    <script>
        Chart.defaults.font.size = 12;
        const ctxUpzis = document.getElementById('ChartUpzis');

        new Chart(ctxUpzis, {
            type: 'bar',
            data: {
                labels: [
                    ['Penguat', 'Kelembagaan'], 'Ekonomi', 'Pendidikan', 'Kesehatan', ['Dakwah', 'Kemanusiaan'],
                    'Kemanusiaan', 'Lingkungan'
                ],
                datasets: [{
                    label: 'Jumlah Program',
                    backgroundColor: 'rgba(40,167,69)',
                    borderColor: 'rgba(40,167,69)',
                    pointRadius: false,
                    pointColor: '#28A745',
                    pointStrokeColor: 'rgba(40,167,69)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(40,167,69)',
                    data: [
                        // penguat kelembagaan
                        {{ App\Http\Controllers\Chart::getTotalByPilar('upzis', $id_upzis, null, '9e2ea277-9550-4ff7-bd6a-5fb36ef30633', $start_date, $end_date, $status) }},
                        // ekonomi
                        {{ App\Http\Controllers\Chart::getTotalByPilar('upzis', $id_upzis, null, '30746c18-3f7a-4736-ae47-ea91154a5a00', $start_date, $end_date, $status) }},
                        // pendidikan
                        {{ App\Http\Controllers\Chart::getTotalByPilar('upzis', $id_upzis, null, 'e47c6722-98b5-42b9-9b37-22f7b8437450', $start_date, $end_date, $status) }},
                        // kesehatan
                        {{ App\Http\Controllers\Chart::getTotalByPilar('upzis', $id_upzis, null, '2a700a8d-dd49-46d3-9e25-2953266cf9a5', $start_date, $end_date, $status) }},
                        // dakwah kemanusiaan
                        {{ App\Http\Controllers\Chart::getTotalByPilar('upzis', $id_upzis, null, 'cde8bd7b-7467-40c5-a92a-957a8176aed9', $start_date, $end_date, $status) }},
                        // kemanusiaan
                        {{ App\Http\Controllers\Chart::getTotalByPilar('upzis', $id_upzis, null, 'ce2ac72c-02bc-4d8c-b143-9d526b1edd2b', $start_date, $end_date, $status) }},
                        // lingkungan
                        {{ App\Http\Controllers\Chart::getTotalByPilar('upzis', $id_upzis, null, 'd578e2e4-23d4-4cc6-9657-2415ba633420', $start_date, $end_date, $status) }},
                    ]
                }, ]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                hover: {
                    mode: 'nearest',
                    intersect: false
                }
            }
        });
    </script>


    @php
        $data_first = App\Models\Pengajuan::orderBy('created_at', 'asc')->first();
        $data_last = App\Models\Pengajuan::orderBy('created_at', 'desc')->first();

        if ($data_first) {
            $data_first = $data_first->created_at->format('Y-m-d');
        } else {
            $data_first = null;
        }

        if ($data_last) {
            $data_last = $data_last->created_at->format('Y-m-d');
        } else {
            $data_last = null;
        }
    @endphp


    <script>
        // select2
        $(document).ready(function() {
            $('#select2Status').select2();
            $('#select2Upzis').select2();
        });
        //  datatable
        $(document).ready(function() {
            $('#Upzis').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                },
                lengthMenu: [5, 10, 25, 50, 100], // Atur pilihan jumlah entri

                pageLength: 5 // Atur jumlah entri awal yang ditampilkan per halamanus

                //  "drawCallback": function(settings) {
                //      // Menyembunyikan thead setelah tabel diinisialisasi
                //      $('#Upzis thead').hide();
                //  }
            });
        });

        // daterange
        $(function() {

            var start_date = '{{ $start_date }}';
            var end_date = '{{ $end_date }}';

            var start = moment(start_date);
            var end = moment(end_date);

            function cb(start, end) {
                $('#reportrange').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
            }
            // moment.locale('id');
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                locale: {
                    format: 'D MMMM YYYY',
                    separator: ' - ',
                    applyLabel: 'Pilih',
                    cancelLabel: 'Batal',
                    fromLabel: 'Dari',
                    toLabel: 'Hingga',
                    customRangeLabel: 'Pilih Tanggal',
                    weekLabel: 'Mg',
                    daysOfWeek: ['Mg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
                    monthNames: [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                        'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ],
                    firstDay: 1
                },
                ranges: {
                    'Hari ini': [moment(), moment()],
                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                    'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
                    'Semua': [moment('{{ $data_first }}'), moment('{{ $data_last }}')]

                }
            }, function(start, end) {
                $('#reportrange').val(start.format('Y-MM-DD') + ' - ' + end.format('Y-MM-DD'));
                $('#filterFormUpzis').submit(); // Mengirimkan formulir saat terjadi perubahan
            });

            // moment.locale('id');
            cb(start, end);
            window.start = start;
            window.end = end;

        });

        function submitFormUpzis() {
            $('#reportrange').val(window.start.format('Y-MM-DD') + ' - ' + window.end.format('Y-MM-DD'));
            $('#filterFormUpzis').submit();
        }
    </script>
@endpush