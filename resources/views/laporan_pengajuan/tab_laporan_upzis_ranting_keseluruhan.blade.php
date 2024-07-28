{{-- filter --}}
<div class="card intro-card-data-pengajuan">
    <div class="card-body ">

        {{-- row1 1 --}}
        <form action="/{{ $role }}/filter_umum_laporan_upzis_ranting_keseluruhan" method="post"
            id="filterFormKeseluruhan">
            @csrf

            <input type="hidden" name="sub" value="{{ $sub }}">
            <input type="hidden" name="status" value="semua">
            <input type="hidden" name="status2" value="semua">
            <input type="hidden" name="status_lpj" value="semua">


            <div class="form-row ">

                {{-- date range --}}
                <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control text-center icon-input" id="reportrange2"
                            name="filter_daterange2" readonly
                            style="background-color: white;cursor: pointer;min-width:175px;height:37.5px;">
                    </div>
                </div>

                {{-- upzis --}}
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group ">
                            <select class="form-control" onchange="submitFormRanting()" name="id_upzis2"
                                id="select2Upzis2">
                                @if (Auth::user()->gocap_id_pc_pengurus != null)
                                    <option value="" {{ $id_upzis2 == null ? 'selected' : '' }}>Semua Kecamatan
                                    </option>
                                @endif
                                @foreach ($daftar_upzis as $a)
                                    <option value="{{ $a->id_upzis }}"
                                        {{ $id_upzis2 == $a->id_upzis ? 'selected' : '' }}>
                                        {{ $a->nama }}
                                        ({{ $a->id_wilayah }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif


                {{-- status --}}
                {{-- <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0" style="pointer-events: none; opacity: 0.6;">
                    <div class="input-group ">
                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                            <select onchange="submitFormRanting()" name="status2" class="form-control select2"
                                id="select2Status2" readonly>
                                <option value="Diajukan" {{ $status2 == 'Diajukan' ? 'selected' : '' }}>Semua Status
                                    Rekom
                                <option value="Sudah Terbit" {{ $status2 == 'Sudah Terbit' ? 'selected' : '' }}>Sudah
                                    Terbit Rekom
                                </option>
                                <option value="Belum Terbit" {{ $status2 == 'Belum Terbit' ? 'selected' : '' }}>Belum
                                    Terbit Rekom
                                </option>
                            </select>
                        @else
                            <select onchange="submitFormRanting()" name="status2" class="form-control select2"
                                id="select2Status2">

                                <option value="Semua" {{ $status2 == 'Semua' ? 'selected' : '' }}>Semua Status
                                </option>
                                <option value="Direncanakan" {{ $status2 == 'Direncanakan' ? 'selected' : '' }}>
                                    Direncanakan
                                </option>
                                <option value="Diajukan" {{ $status2 == 'Diajukan' ? 'selected' : '' }}>Diajukan
                                </option>
                                <option value="Sudah Terbit" {{ $status2 == 'Sudah Terbit' ? 'selected' : '' }}>Sudah
                                    Terbit Rekom
                                </option>
                                <option value="Belum Terbit" {{ $status2 == 'Belum Terbit' ? 'selected' : '' }}>Belum
                                    Terbit Rekom
                                </option>
                            </select>
                        @endif
                    </div>
                </div> --}}

                <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                    <div class="input-group ">
                        <select onchange="submitFormRanting()" name="status_lpj2"
                            class="form-control select2 text-center" id="select2StatusLPJ2">
                            <option value="semua" {{ $status_lpj2 == 'semua' ? 'selected' : '' }}>
                                Semua Status LPJ
                            <option value="Selesai LPJ" {{ $status_lpj2 == 'Selesai LPJ' ? 'selected' : '' }}>
                                Selesai LPJ
                            </option>
                            <option value="Belum Selesai LPJ"
                                {{ $status_lpj2 == 'Belum Selesai LPJ' ? 'selected' : '' }}>
                                Belum Selesai LPJ
                            </option>
                        </select>
                    </div>
                </div>

                @php
                    if ($id_upzis2 == null) {
                        $daftar_ranting2 = [];
                    }
                @endphp

                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                        <a class="btn btn-light border-grey hover btn-block tombol-reset-pc"
                            href="/{{ $role }}/upzis-ranting">
                            <i class="fas fa-sync-alt"></i>&nbsp;
                        </a>
                    </div>
                @endif

                <div class="col-12 col-md-2 col-sm-12 mb-xl-0">
                    <div class="btn-group btn-block">
                        <button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fas fa-file-download"></i>&ensp;Ekspor All
                        </button>
                        <div class="dropdown-menu" style="border-radius: 10px;">
                            <a class="dropdown-item btn-block" target="_blank"
                                href="{{ route('pdf_all_umum_laporan_keseluruhan', [
                                    'role' => $role,
                                    'status' => $status2,
                                    'start_date' => $start_date2,
                                    'end_date' => $end_date2,
                                    'filter_daterange' => $filter_daterange2,
                                    'id_upzis' => $id_upzis ?? 'semua',
                                    'id_upzis2' => $id_upzis2 ?? 'semua',
                                    'id_ranting2' => $id_ranting2 ?? 'semua',
                                    'status2' => $status2,
                                    'filter_daterange2' => $filter_daterange2,
                                    'sub' => $sub,
                                    'status_lpj' => $status_lpj,
                                    'status_lpj2' => $status_lpj2,
                                ]) }}">
                                <i class="fas fa-file-pdf"></i> PDF ALL
                            </a>

                            <a class="dropdown-item btn-block" target="_blank"
                                href="{{ route('berita_acara_laporan_keseluruhan', [
                                    'role' => $role,
                                    'status' => $status2,
                                    'start_date' => $start_date2,
                                    'end_date' => $end_date2,
                                    'filter_daterange' => $filter_daterange2,
                                    'id_upzis' => $id_upzis ?? 'semua',
                                    'id_upzis2' => $id_upzis2 ?? 'semua',
                                    'id_ranting2' => $id_ranting2 ?? 'semua',
                                    'status2' => $status2,
                                    'filter_daterange2' => $filter_daterange2,
                                    'sub' => $sub,
                                    'status_lpj' => $status_lpj,
                                    'status_lpj2' => $status_lpj2,
                                ]) }}">
                                <i class="fas fa-file-pdf"></i> PDF BERITA ACARA
                            </a>
                        </div>
                    </div>
                </div>

                {{-- reset --}}
                @if (auth::user()->gocap_id_upzis_pengurus != null)
                    <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <a class="btn btn-light border-grey hover btn-block tombol-reset-pc"
                            href="/{{ $role }}/upzis-ranting"><i class="fas fa-sync-alt"></i>&nbsp;
                        </a>
                    </div>
                @endif

                @if (Auth::user()->gocap_id_upzis_pengurus != null)
                    {{-- tambah --}}
                    <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0 intro-tambah-data-pengajuan">
                        <button class="btn btn btn-success hover btn-block" data-toggle="modal"
                            data-target="#tambah-pengajuan-ranting" type="button"><i class="fas fa-plus-circle"></i>
                            Tambah</button>
                    </div>
                @endif
            </div>


            <div class="form-row">
                {{-- info --}}
                <div
                    class="col-12 {{ auth::user()->gocap_id_pc_pengurus != null ? 'col-md-9' : 'col-md-10' }} col-md-9 col-sm-12 mb-xl-0">
                    <div class="d-flex flex-row bd-highlight align-items-center">
                        <div class="p-1 bd-highlight">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="p-1 bd-highlight">
                            <span>
                                {{-- Menampilkan data pengajuan umum tingkat <b style="font-size: 11pt;">RANTING NU</b> pada filter terpilih --}}
                                Pilih filter untuk menampilkan data by tgl rekom. Klik Ekspor untuk mencetak.
                            </span>
                        </div>
                    </div>
                </div>


            </div>


            {{-- ranting --}}
            {{-- <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0" style="pointer-events: none; opacity: 0;">
                <div class="input-group ">
                    <select class="form-control" onchange="submitFormRanting()" name="id_ranting2" id="select2Ranting2">
                        <option value="" {{ $id_ranting2 == null ? 'selected' : '' }}>Semua Ranting
                        </option>
                        @foreach ($daftar_ranting2 as $a)
                            <option value="{{ $a->id_ranting }}"
                                {{ $id_ranting2 == $a->id_ranting ? 'selected' : '' }}>
                                {{ $a->nama }}
                                ({{ $a->id_wilayah }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> --}}


        </form>
    </div>
</div>

{{-- @if (Auth::user()->gocap_id_pc_pengurus != null) --}}
<div class="row">
    <div class="col-12 col-md-3 mb-2">
        <div class="card ">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <div class="h6">Total Pengajuan

                        </div>
                        @php
                            $nominal = App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('nominal_total', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2);
                        @endphp
                        <b> Rp. {{ number_format($nominal, 0, ',', '.') }},-</b>
                        {{-- <b> Rp. 230.000.000</b> --}}

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            {{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('total', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            Pengajuan
                            ({{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('program_total', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            Program)</div>
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
                        <div class="h6">Terbit Rekomendasi/Pencairan

                        </div>

                        {{-- @php
                            $nominal = App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('nominal_terbit_rekom', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2);
                        @endphp
                        <b> Rp. {{ number_format($nominal, 0, ',', '.') }},-</b> --}}
                        {{-- <b> Rp. 230.000.000</b> --}}

                        @php
                            $totalNominalPencairan = 0;
                        @endphp

                        @foreach ($data2 as $a)
                            @php
                                $totalNominalPencairan += app\Http\Controllers\PengajuanController::hitung_nominal_pencairan($a->id_pengajuan);
                            @endphp
                        @endforeach

                        <b> Rp{{ number_format($totalNominalPencairan, 0, '.', '.') }},-</b>

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            {{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('total_terbit_rekom', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            Pengajuan
                            ({{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('program_terbit_rekom', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            Program)</div>

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

                        @php
                            $nominal = App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('nominal_sudah_lpj', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2);
                        @endphp
                        <b> Rp. {{ number_format($nominal, 0, ',', '.') }},-</b>
                        {{-- <b> Rp. 230.000.000</b> --}}

                        <div class="h6 mb-0 mb-1" style="color: #28a745">
                            {{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('sudah_lpj', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            Program Sudah LPJ</div>

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
                        <div class="h6">Penerima Manfaat
                        </div>

                        {{-- @php
                            $nominal = App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('nominal_dalam_proses', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2);
                        @endphp --}}
                        @php
                            $total_jumlah_penerima_manfaat2 = 0;
                        @endphp

                        @foreach ($program2 as $pilar => $details)
                            @php
                                $jumlah_penerima_manfaat2 = 0; // Inisialisasi ulang variabel di setiap iterasi pilar
                            @endphp

                            @foreach ($details as $x)
                                @php
                                    $jumlah_penerima_manfaat2 += $x->jumlah_penerima;
                                @endphp
                            @endforeach

                            @php
                                $total_jumlah_penerima_manfaat2 += $jumlah_penerima_manfaat2;
                            @endphp
                        @endforeach

                        <b>{{ $total_jumlah_penerima_manfaat2 }} Orang</b>

                        {{-- <b> Rp. 230.000.000</b> --}}

                        <div class="h6 mb-0 mb-1" style="color: #28a745"><br>
                            {{-- {{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('total_dalam_proses', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            Pengajuan
                            ({{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('program_dalam_proses', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            Program) --}}
                        </div>

                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endif --}}

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif




<div class="table-responsive card card-body">

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div style="margin-left:5px; ">
            <b style="font-size:16px;">
                Data Realisasi By Pengajuan </b>
        </div>
        <div>
            <div class="btn btn-group btn-block p-0 m-0" role="group">
                <button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-file-download"></i>&ensp;Ekspor
                </button>
                <div class="dropdown-menu btn-block" style="border-radius: 10px">

                    <a class="dropdown-item btn-block" target="_blank"
                        href="{{ route('pdf_keseluruhan_realisasi_pengajuan', [
                            'role' => $role,
                            'status' => $status2,
                            'start_date' => $start_date2,
                            'end_date' => $end_date2,
                            'filter_daterange' => $filter_daterange2,
                            'id_upzis' => $id_upzis ?? 'semua',
                            'id_upzis2' => $id_upzis2 ?? 'semua',
                            'id_ranting2' => $id_ranting2 ?? 'semua',
                            'status2' => $status2,
                            'filter_daterange2' => $filter_daterange2,
                            'sub' => $sub,
                            'status_lpj' => $status_lpj,
                            'status_lpj2' => $status_lpj2,
                        ]) }}">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>

                </div>
            </div>
        </div>
    </div>

    <br>


    <table class="table table-bordered table-hover" id="Ranting" style="width:100%">
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

            @foreach ($data2 as $a)
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
                                Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_pengajuan($a->id_pengajuan), 0, '.', '.') }},-
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
                                {{ $a->dikonfirmasi_oleh_upzis ? app\Http\Controllers\PengajuanController::getNamaPengurus('upzis', $a->dikonfirmasi_oleh_upzis) : '-' }}
                            </span>
                            <br>
                            <span style="font-size: 10pt;">
                                {{ $a->dikonfirmasi_oleh_upzis ? app\Http\Controllers\PengajuanController::getJabatanPengurus('upzis', $a->dikonfirmasi_oleh_upzis) : '-' }}
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
                        @elseif ($a->status_rekomendasi == 'Ditolak')
                            <div class="btn btn-light btn-block noClick btn-sm text-bold text-danger"
                                style="border-radius:10px;background-color:#f2cbcc">
                                Ditolak
                            </div>
                        @else
                            <div class="btn btn-light btn-block noClick btn-sm text-bold text-secondary"
                                style="border-radius:10px;background-color:#dcdcdc">
                                Belum Terbit
                            </div>
                        @endif

                        @if ($a->pj_upzis)
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
                        @else
                            <div class="text-left" style="font-size: 10pt;">
                                <em class="text-secondary">
                                    {{ $a->tgl_terbit_rekomendasi ? Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('D MMMM Y') : '-' }}</em><br>
                                PJ Pengambilan Dana <br>

                                <span class="text-bold" style="font-size: 10pt;">
                                    {{ $a->pj_ranting ? app\Http\Controllers\PengajuanController::getNamaPengurus('ranting', $a->pj_ranting) : '-' }}
                                </span>
                                <br>
                                <span style="font-size: 10pt;">
                                    {{ $a->pj_ranting ? app\Http\Controllers\PengajuanController::getJabatanPengurus('ranting', $a->pj_ranting) : '-' }}
                                </span>
                            </div>
                        @endif

                    </td>
                    {{-- status rekomendasi --}}



                    {{-- row3 --}}
                    <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                        class="text-right" style=" cursor: pointer;">
                        <b class="text-success" style="font-size: 12pt;">
                            Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_pengajuan_disetujui($a->id_pengajuan), 0, '.', '.') }},-
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
                            Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_pencairan($a->id_pengajuan), 0, '.', '.') }},-
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
                            Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_penyaluran($a->id_pengajuan), 0, '.', '.') }},-
                        </b>

                        <div class="text-right" style="font-size: 10pt;">
                            <em class="text-primary">{{ app\Http\Controllers\PengajuanController::detailPenyaluran($a->id_pengajuan)['konfirmasi'] }}
                                Sudah LPJ</em><br>

                        </div>
                        <b class="text-success" style="font-size: 12pt;">
                            Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_penyaluran2($a->id_pengajuan), 0, '.', '.') }},-
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

                {{-- modal  --}}

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


@php
    [$start, $end] = explode(' - ', $filter_daterange2);
    $startDate = \Carbon\Carbon::parse($start)->locale('id')->isoFormat('D MMMM Y');
    $endDate = \Carbon\Carbon::parse($end)->locale('id')->isoFormat('D MMMM Y');
@endphp
<style>
    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }


    /* Sticky header styles */
    .sticky-header {
        position: sticky;
        top: 0;
        background-color: #cbf2d6;
        z-index: 1;
    }

    /* Container styles */
    .table-container {
        overflow-x: auto;
        max-height: 100vh;
        /* Adjust as needed */
    }

    /* Body styles */
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Content styles */
    .content {
        flex: 1;
        overflow-y: auto;
    }
</style>
</head>

<body>


    <div class="table-responsive card card-body">

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="margin-left:5px; ">
                <b style="font-size:16px;">
                    Data Realisasi By Pilar & Program </b> <br>
                <i class="fas fa-info-circle" style="margin-right: 5px;"></i> Untuk melakukan pencarian, tekan Ctrl+F
                pada keyboard


            </div>

            <div>

                <button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-file-download"></i>&ensp;Ekspor
                </button>
                <div class="dropdown-menu" style="border-radius: 10px">

                    <a class="dropdown-item btn-block" target="_blank"
                        href="{{ route('pdf_umum_keseluruhan', [
                            'role' => $role,
                            'status' => $status2,
                            'start_date' => $start_date2,
                            'end_date' => $end_date2,
                            'filter_daterange' => $filter_daterange2,
                            'id_upzis' => $id_upzis ?? 'semua',
                            'id_upzis2' => $id_upzis2 ?? 'semua',
                            'id_ranting2' => $id_ranting2 ?? 'semua',
                            'status2' => $status2,
                            'filter_daterange2' => $filter_daterange2,
                            'sub' => $sub,
                            'status_lpj' => $status_lpj,
                            'status_lpj2' => $status_lpj2,
                        ]) }}">
                        <i class="fas fa-file-pdf"></i> PDF
                    </a>

                    <a class="dropdown-item btn-block" target="_blank"
                        href="{{ route('excel_umum_keseluruhan', [
                            'role' => $role,
                            'status' => $status2,
                            'start_date' => $start_date2,
                            'end_date' => $end_date2,
                            'filter_daterange' => $filter_daterange2,
                            'id_upzis' => $id_upzis ?? 'semua',
                            'id_upzis2' => $id_upzis2 ?? 'semua',
                            'id_ranting2' => $id_ranting2 ?? 'semua',
                            'status2' => $status2,
                            'filter_daterange2' => $filter_daterange2,
                            'sub' => $sub,
                            'status_lpj' => $status_lpj,
                            'status_lpj2' => $status_lpj2,
                        ]) }}">
                        <i class="fas fa-file-alt"></i> EXCEL
                    </a>

                </div>
            </div>

        </div>


        <br>

        <div class="table-container">
            <table class="table table-bordered table-hover" style="font-size:14px; border-collapse: collapse;">

                <thead class="sticky-header bg-success" style="font-size:16px">
                    <tr>
                        <th style="vertical-align:middle; text-align:center;width: 3%;">NO</th>
                        <th style="vertical-align:middle; text-align:center;width: 20%;">NAMA PROGRAM</th>
                        <th style="vertical-align:middle; text-align:center;width: 18%;">SUMBER DANA</th>
                        <th style="vertical-align:middle; text-align:center;width: 13%;">TGL <br> KONFIRMASI</th>
                        <th style="vertical-align:middle; text-align:center;width: 12%;">NOMINAL<br> PENGAJUAN </th>
                        <th style="vertical-align:middle; text-align:center;width: 13%;">TGL <br> REKOM</th>
                        <th style="vertical-align:middle; text-align:center;width: 12%;">NOMINAL <br> PENCAIRAN</th>
                        <th style="vertical-align:middle; text-align:center;width: 9%;">PENERIMA MANFAAT</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($program2) > 0)
                        @foreach ($program2 as $pilar => $details)
                            @php
                                $jumlah_nominal_pengajuan = 0;
                                $jumlah_nominal_pencairan = 0;
                                $jumlah_penerima_manfaat = 0;
                            @endphp
                            {{-- foreach menghitung total --}}
                            @foreach ($details as $x)
                                @php
                                    $jumlah_nominal_pengajuan += $x->nominal_pengajuan;
                                    $jumlah_nominal_pencairan += $x->nominal_pencairan;
                                    $jumlah_penerima_manfaat += $x->jumlah_penerima;
                                @endphp
                            @endforeach

                            <tr style=" background-color: #cbf2d6; text-align: left; page-break-inside: avoid;">
                                <td style="width: 54%;vertical-align:middle;padding-left:3.0mm;" colspan="4">
                                    <b>{{ strtoupper(chr(64 + $loop->iteration)) }}. {{ $pilar }} </b>
                                </td>

                                <td style="width: 12%;vertical-align:middle; text-align:center; ">
                                    <b>Rp{{ number_format($jumlah_nominal_pengajuan, 0, '.', '.') }},-</b>
                                </td>
                                <td style="width: 13%; text-align:center; "></td>
                                <td style="width: 12%;vertical-align:middle; text-align:center; ">
                                    <b>Rp{{ number_format($jumlah_nominal_pencairan, 0, '.', '.') }},-</b>
                                </td>
                                <td style="width: 9%;vertical-align:middle; text-align:center; ">
                                    <b>{{ $jumlah_penerima_manfaat }}</b>
                                </td>
                            </tr>

                            @php
                                $uniquePrograms = $details->unique('nama_program');
                            @endphp

                            {{-- foreach data --}}
                            @foreach ($uniquePrograms as $a)
                                @php
                                    // Anda mungkin perlu menyesuaikan ini tergantung pada struktur model dan propertinya
                                    $firstDetail = $details->where('nama_program', $a->nama_program)->first();
                                @endphp

                                <tr style="background-color:#e6e6e6; text-align: left; page-break-inside: avoid;">
                                    <td style="width: 54%;vertical-align:middle;padding-left:3.0mm;" colspan="4">
                                        <b>{{ $loop->iteration }}.
                                            {{ app\Http\Controllers\PengajuanController::get_nama_program($firstDetail->id_program_kegiatan) }}
                                        </b>
                                    </td>

                                    <td style="width: 12%;vertical-align:middle;text-align:center;">
                                        <b>Rp{{ number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pengajuan'), 0, '.', '.') }},-</b>
                                    </td>
                                    <td style="width: 13%;text-align:center;"></td>
                                    <td style="width: 12%;vertical-align:middle;text-align:center;">
                                        <b>Rp{{ number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pencairan'), 0, '.', '.') }},-</b>
                                    </td>
                                    <td style="width: 9%;vertical-align:middle;text-align:center;">
                                        <b>{{ $details->where('nama_program', $a->nama_program)->sum('jumlah_penerima') }}</b>
                                    </td>
                                </tr>



                                @foreach ($details->where('nama_program', $a->nama_program) as $b)
                                    <tr style=" page-break-inside: avoid;">
                                        <td
                                            style="width: 3%; vertical-align:middle;padding-left:7mm;text-align:center;">
                                            {{ $loop->iteration }}</td>
                                        <td style="width: 20%;vertical-align:middle;  text-align:left;">
                                            {{ $b->pengajuan_note }}
                                        </td>

                                        <td style="width: 18%;vertical-align:middle; text-align:center;">
                                            @if ($b->id_ranting == '' or $b->id_ranting == null)
                                                <b>UPZ
                                                    {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($b->id_upzis)) }}</b><br>{{ app\Http\Controllers\PengajuanController::get_nama_bmt($b->id_rekening) }}<br>({{ app\Http\Controllers\PengajuanController::no_rekening($b->id_rekening) }})
                                            @else
                                                <b>RTG
                                                    {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_ranting($b->id_ranting)) }}</b><br>{{ app\Http\Controllers\PengajuanController::get_nama_bmt($b->id_rekening) }}<br>({{ app\Http\Controllers\PengajuanController::no_rekening($b->id_rekening) }})
                                            @endif
                                        </td>
                                        @php
                                            $tgl_konfirmasi = App\Models\Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_konfirmasi');
                                            $tgl_terbit_rekomendasi = App\Models\Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_terbit_rekomendasi');
                                        @endphp
                                        <td style="width: 13%; vertical-align:middle;text-align:center;">
                                            {{ Carbon\Carbon::parse($tgl_konfirmasi)->isoFormat('D/M/Y') }}
                                        </td>
                                        <td style="width: 12%; vertical-align:middle;text-align:center;">
                                            Rp{{ number_format($b->nominal_pengajuan, 0, '.', '.') }},-
                                        </td>
                                        <td style="width: 13%; vertical-align:middle;text-align:center;">
                                            {{ Carbon\Carbon::parse($tgl_terbit_rekomendasi)->isoFormat('D/M/Y') }}
                                        </td>
                                        <td style="width: 12%; vertical-align:middle;text-align:center;">
                                            Rp{{ number_format($b->nominal_pencairan, 0, '.', '.') }},-
                                        </td>
                                        <td style="width: 9%; vertical-align:middle;text-align:center;">
                                            {{ $b->jumlah_penerima ?? '0' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" style="vertical-align:top;padding-left:7mm;text-align:center;">
                                Tidak Ada Data
                            </td>
                        </tr>
                    @endif
                </tbody>

            </table>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="card ">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <b style="font-size: 16px;">
                            Grafik Jumlah Program By Piilar
                        </b>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <canvas id="ChartRanting"
                                style="min-height: 300px; height: 300px; max-height: 100%; max-width: 100%; "></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">

            <div class="card ">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <b style="font-size: 16px;">
                            Grafik Nominal Pencairan By Pilar
                        </b>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <canvas id="ChartRantingNominal"
                                style="min-height: 300px; height: 300px; max-height: 100%; max-width: 100%; "></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive card card-body">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="margin-left:5px; ">
                <b style="font-size:16px;">
                    Data Realisasi Penerima Manfaat </b>
            </div>
            <div>
                <div class="btn btn-group btn-block p-0 m-0" role="group">
                    <button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false"><i class="fas fa-file-download"></i>&ensp;Ekspor
                    </button>
                    <div class="dropdown-menu btn-block" style="border-radius: 10px">

                        <a class="dropdown-item btn-block" target="_blank"
                            href="{{ route('pdf_umum_keseluruhan_realisasi_penerima_manfaat', [
                                'role' => $role,
                                'status' => $status2,
                                'start_date' => $start_date2,
                                'end_date' => $end_date2,
                                'filter_daterange' => $filter_daterange2,
                                'id_upzis' => $id_upzis ?? 'semua',
                                'id_upzis2' => $id_upzis2 ?? 'semua',
                                'id_ranting2' => $id_ranting2 ?? 'semua',
                                'status2' => $status2,
                                'filter_daterange2' => $filter_daterange2,
                                'sub' => $sub,
                                'status_lpj' => $status_lpj,
                                'status_lpj2' => $status_lpj2,
                            ]) }}">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>

                        <a class="dropdown-item btn-block" target="_blank"
                            href="{{ route('excel_umum_keseluruhan_realisasi_penerima_manfaat', [
                                'role' => $role,
                                'status' => $status2,
                                'start_date' => $start_date2,
                                'end_date' => $end_date2,
                                'filter_daterange' => $filter_daterange2,
                                'id_upzis' => $id_upzis ?? 'semua',
                                'id_upzis2' => $id_upzis2 ?? 'semua',
                                'id_ranting2' => $id_ranting2 ?? 'semua',
                                'status2' => $status2,
                                'filter_daterange2' => $filter_daterange2,
                                'sub' => $sub,
                                'status_lpj' => $status_lpj,
                                'status_lpj2' => $status_lpj2,
                            ]) }}">
                            <i class="fas fa-file-alt"></i>
                            EXCEL</a>

                    </div>
                </div>
            </div>
        </div>

        <br>


        <table class="table table-bordered table-hover" id="Keseluruhan2" style="width:100%">
            <thead>
                <tr class="text-center ">
                    <th style="width: 3%;vertical-align:middle;text-align:center"> NO
                    </th>
                    <th style="vertical-align:middle;text-align:center">TANGGAL</th>

                    <th style="width: 13%;vertical-align:middle;text-align:center">NAMA</th>
                    <th style="width: 13%;vertical-align:middle;text-align:center">ALAMAT</th>
                    <th style="width: 15%;vertical-align:middle;text-align:center">
                        NOMINAL
                        <br>
                        BANTUAN
                    </th>
                    <th style="width: 15%;vertical-align:middle;text-align:center">
                        ASNAF
                    </th>
                    <th style="width: 14%;vertical-align:middle;text-align:center">JENIS <br>BANTUAN</th>
                    <th style="width: 14%;vertical-align:middle;text-align:center">PILAR</th>
                    <th style="width: 14%;vertical-align:middle;text-align:center">JENIS <br>PROGRAM</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($penerima_manfaat_keseluruhan as $p_manfaat_keseluruhan)
                    <tr>
                        {{-- row1 --}}
                        <td class="text-bold" style=" cursor: pointer;text-align:center;padding-top:3mm;">
                            {{ $loop->iteration }}</td>
                        <td>{{ Carbon\Carbon::parse($p_manfaat_keseluruhan->tgl_bantuan)->isoFormat('D/M/Y') }}</td>
                        <td><b style="font-size:16px;">{{ $p_manfaat_keseluruhan->nama }} </b><br>
                            NIK : {{ $p_manfaat_keseluruhan->nik }} <br>
                            KK : {{ $p_manfaat_keseluruhan->nokk }} <br>
                            NO HP : {{ $p_manfaat_keseluruhan->nohp }}
                        </td>
                        <td>{{ $p_manfaat_keseluruhan->alamat }}</td>
                        <td>Rp{{ number_format($p_manfaat_keseluruhan->nominal_bantuan, 0, '.', '.') }},-</td>
                        <td>{{ $p_manfaat_keseluruhan->nama_asnaf }}</td>
                        <td>{{ $p_manfaat_keseluruhan->jenis_bantuan }}</td>
                        <td>{{ $p_manfaat_keseluruhan->pilar }}</td>
                        <td>{{ $p_manfaat_keseluruhan->nama_program }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

{{-- <div class="row">
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
                        <canvas id="ChartRanting"
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
                                {{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('total', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <em>Total Program</em><br>
                            <span class="text-bold">
                                {{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('program', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <em>Total Penerima</em><br>
                            <span class="text-bold">
                                {{ App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('penerima', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <em>Total Dapat Dicairkan</em><br>
                            <span class="text-bold text-warning">
                                Rp{{ number_format(App\Http\Controllers\ChartLaporanKeseluruhan::getStatisticPengajuan('dicairkan', 'ranting', $id_upzis2, $id_ranting2, $start_date2, $end_date2, $status2), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}




@push('filter_umum_ranting')
    <script>
        Chart.defaults.font.size = 12;
        const ctxRanting = document.getElementById('ChartRanting');

        new Chart(ctxRanting, {
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
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByPilar('ranting', $id_upzis2, $id_ranting2, '9e2ea277-9550-4ff7-bd6a-5fb36ef30633', $start_date2, $end_date2, $status_lpj2) }},
                        // ekonomi
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByPilar('ranting', $id_upzis2, $id_ranting2, '30746c18-3f7a-4736-ae47-ea91154a5a00', $start_date2, $end_date2, $status_lpj2) }},
                        // pendidikan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByPilar('ranting', $id_upzis2, $id_ranting2, 'e47c6722-98b5-42b9-9b37-22f7b8437450', $start_date2, $end_date2, $status_lpj2) }},
                        // kesehatan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByPilar('ranting', $id_upzis2, $id_ranting2, '2a700a8d-dd49-46d3-9e25-2953266cf9a5', $start_date2, $end_date2, $status_lpj2) }},
                        // dakwah kemanusiaan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByPilar('ranting', $id_upzis2, $id_ranting2, 'cde8bd7b-7467-40c5-a92a-957a8176aed9', $start_date2, $end_date2, $status_lpj2) }},
                        // kemanusiaan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByPilar('ranting', $id_upzis2, $id_ranting2, 'ce2ac72c-02bc-4d8c-b143-9d526b1edd2b', $start_date2, $end_date2, $status_lpj2) }},
                        // lingkungan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByPilar('ranting', $id_upzis2, $id_ranting2, 'd578e2e4-23d4-4cc6-9657-2415ba633420', $start_date2, $end_date2, $status_lpj2) }},
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

    <script>
        Chart.defaults.font.size = 12;
        const ctxRantingNom = document.getElementById('ChartRantingNominal');

        new Chart(ctxRantingNom, {
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
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByNominal('ranting', $id_upzis2, $id_ranting2, '9e2ea277-9550-4ff7-bd6a-5fb36ef30633', $start_date2, $end_date2, $status_lpj2) }},
                        // ekonomi
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByNominal('ranting', $id_upzis2, $id_ranting2, '30746c18-3f7a-4736-ae47-ea91154a5a00', $start_date2, $end_date2, $status_lpj2) }},
                        // pendidikan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByNominal('ranting', $id_upzis2, $id_ranting2, 'e47c6722-98b5-42b9-9b37-22f7b8437450', $start_date2, $end_date2, $status_lpj2) }},
                        // kesehatan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByNominal('ranting', $id_upzis2, $id_ranting2, '2a700a8d-dd49-46d3-9e25-2953266cf9a5', $start_date2, $end_date2, $status_lpj2) }},
                        // dakwah kemanusiaan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByNominal('ranting', $id_upzis2, $id_ranting2, 'cde8bd7b-7467-40c5-a92a-957a8176aed9', $start_date2, $end_date2, $status_lpj2) }},
                        // kemanusiaan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByNominal('ranting', $id_upzis2, $id_ranting2, 'ce2ac72c-02bc-4d8c-b143-9d526b1edd2b', $start_date2, $end_date2, $status_lpj2) }},
                        // lingkungan
                        {{ App\Http\Controllers\ChartLaporanKeseluruhan::getTotalByNominal('ranting', $id_upzis2, $id_ranting2, 'd578e2e4-23d4-4cc6-9657-2415ba633420', $start_date2, $end_date2, $status_lpj2) }},
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
            $('#select2Status2').select2();
            $('#select2StatusLPJ2').select2();
            $('#select2Upzis2').select2();
            $('#select2Ranting2').select2();
        });
        //  datatable
        $(document).ready(function() {
            $('#Ranting').DataTable({
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

        $(document).ready(function() {
            $('#Keseluruhan2').DataTable({
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

            var start_date2 = '{{ $start_date2 }}';
            var end_date2 = '{{ $end_date2 }}';

            var start2 = moment(start_date2);
            var end2 = moment(end_date2);

            function cb(start2, end2) {
                $('#reportrange2').html(start2.format('D MMMM, YYYY') + ' - ' + end2.format('D MMMM, YYYY'));
            }
            // moment.locale('id');
            $('#reportrange2').daterangepicker({
                startDate: start2,
                endDate: end2,
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
            }, function(start2, end2) {
                $('#reportrange2').val(start2.format('Y-MM-DD') + ' - ' + end2.format('Y-MM-DD'));
                $('#filterFormKeseluruhan').submit(); // Mengirimkan formulir saat terjadi perubahan
            });

            // moment.locale('id');
            cb(start2, end2);
            window.start2 = start2;
            window.end2 = end2;

        });

        function submitFormRanting() {
            $('#reportrange2').val(window.start2.format('Y-MM-DD') + ' - ' + window.end2.format('Y-MM-DD'));
            $('#filterFormKeseluruhan').submit();
        }
    </script>
@endpush
