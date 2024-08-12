@extends('main')

@section('laporankeu', 'active')

@section('css')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">

                <div class="col-sm-6 text-secondary mt-1">
                    <a href="/{{ $role }}/dashboard"> Dashboard</a> /
                    <a> Laporan Keuangan</a>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ">
        <div class="container-fluid">





            <div class="row">
                <div class="col-12">
                    <div class="card ijo-atas">
                        <h5 class="d-flex mt-2 ml-2">
                            <b class="text-success pl-2 mt-1">LAPORAN KEUANGAN UPZIS MWCNU KEDUNGREJA</b>
                        </h5>

                        <livewire:laporankeu>

                            <button type="button" class="btn btn-success toastsDefaultSuccess">
                                Launch Success Toast
                            </button>

                            {{-- card body --}}
                            <div class="card-body">
                                <table id="example1" class=" table-bordered table-hover mt-0 pt-0"
                                    style="text-align: center;vertical-align: middle;">
                                    <thead>
                                        <tr>
                                            <th style="width:50px;vertical-align:middle;text-align:center;height:20px"
                                                rowspan="4">
                                                NO
                                            </th>
                                            <th style="width:220px;vertical-align:middle;text-align:center;height:20px"
                                                rowspan="4">
                                                BULAN</th>
                                            <th style="vertical-align:middle;text-align:center;height:20px" rowspan="2"
                                                colspan="3">
                                                SALDO AWAL BANK
                                            </th>
                                            <th style="vertical-align:middle;text-align:center;height:20px" rowspan="2"
                                                colspan="3">
                                                SALDO AWAL KAS
                                            </th>
                                            <th style="vertical-align:middle;text-align:center;height:20px" rowspan="2"
                                                colspan="5">
                                                PENERIMAAN
                                            </th>
                                            <th style="vertical-align:middle;text-align:center;height:35px" colspan="13">
                                                PENYALURAN
                                            </th>

                                            <th style="width:150px;vertical-align:middle;text-align:center;height:20px"
                                                rowspan="4">
                                                PENGELUARAN <br> LAINNYA (ex:adm bank,dll)
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center;height:20px"
                                                rowspan="4">
                                                SALDO AKHIR
                                            </th>
                                            <th style="width:100px;vertical-align:middle;text-align:center;height:20px"
                                                rowspan="4">
                                                JUMLAH <br>
                                                PENERIMA <br>
                                                MANFAAT
                                            </th>
                                            <th style="width:250px;vertical-align:middle;text-align:center;height:20px"
                                                rowspan="4">
                                                KETERANGAN
                                            </th>
                                        </tr>

                                        <tr>
                                            {{-- penyaluran --}}
                                            <th style="vertical-align:middle;text-align:center" colspan="12">
                                                Pengeluaran Dana Berdasarkan Program
                                            </th>

                                            <th style="width:150px;vertical-align:middle;text-align:center" rowspan="3">
                                                JUMLAH PENYALURAN PROGRAM
                                            </th>
                                        </tr>

                                        <tr>
                                            <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                                                SOSIAL
                                                (12345)
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                                                KELEMBAGAAN (12345)
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                                                OPERASIONAL
                                                (12345)
                                            </th>

                                            <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                                                SOSIAL
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                                                KELEMBAGAAN
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                                                OPERASIONAL
                                            </th>

                                            <th style="vertical-align:middle;text-align:center" colspan="3">
                                                PROSENTASE KOIN NU
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                PENERIMAAN LAINNYA (ex:bagi hasil bank,dll)
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                                                JUMLAH
                                                PENERIMAAN
                                            </th>

                                            <th style="vertical-align:middle;text-align:center" colspan="2">
                                                Pendidikan
                                            </th>
                                            <th style="vertical-align:middle;text-align:center" colspan="2">
                                                Kesehatan
                                            </th>
                                            <th style="vertical-align:middle;text-align:center" colspan="2">
                                                Ekonomi
                                            </th>
                                            <th style="vertical-align:middle;text-align:center" colspan="2">
                                                Dakwah dan Kemanusiaan
                                            </th>
                                            <th style="vertical-align:middle;text-align:center" colspan="2">
                                                Lingkungan
                                            </th>
                                            <th style="vertical-align:middle;text-align:center" colspan="2">
                                                Kelembagaan
                                            </th>


                                        </tr>

                                        <tr>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                SOSIAL
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                KELEMBAGAAN
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                OPERASIONAL
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                JUMLAH
                                            </th>

                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                Jumlah
                                            </th>
                                            <th style="width:50px;vertical-align:middle;text-align:center">
                                                PM
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                Jumlah
                                            </th>
                                            <th style="width:50px;vertical-align:middle;text-align:center">
                                                PM
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                Jumlah
                                            </th>
                                            <th style="width:50px;vertical-align:middle;text-align:center">
                                                PM
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                Jumlah
                                            </th>
                                            <th style="width:50px;vertical-align:middle;text-align:center">
                                                PM
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                Jumlah
                                            </th>
                                            <th style="width:50px;vertical-align:middle;text-align:center">
                                                PM
                                            </th>
                                            <th style="width:150px;vertical-align:middle;text-align:center">
                                                Jumlah
                                            </th>
                                            <th style="width:50px;vertical-align:middle;text-align:center">
                                                PM
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($bul as $data)
                                            <tr data-toggle="collapse" href="#collapseExample{{ $loop->iteration }}"
                                                role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ $loop->iteration }}</td>
                                                <td
                                                    style="text-align:left;padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ app\Helpers\BasicHelper::getNamaBulan($data['bulan']) }}
                                                    {{ $tahun }}
                                                    {{-- {{ $a->bulan }} --}}

                                                    {{-- {{ $a->bulan }} --}}

                                                    @if ($data['sab_sosial'] != '-')
                                                        <div class="collapse" id="collapseExample{{ $loop->iteration }}">

                                                            <a href="" data-toggle="modal"
                                                                data-target="#modal_laporan_saldo_awal{{ $data['bulan'] }}">a.
                                                                Laporan Saldo Awal
                                                            </a> <br>

                                                            <a href="" onclick="showConsoleLog('12')"
                                                                data-toggle="modal" data-target="#myModal">b. Laporan
                                                                Penerimaan</a> <br>

                                                            <a
                                                                href="/{{ $role }}/laporanpenyaluran/04/2023/{{ $id_upzis }}">c.
                                                                Laporan
                                                                Penyaluran</a>
                                                            <br>
                                                            <a
                                                                href="/{{ $role }}/laporanperudana/04/2023/{{ $id_upzis }}">d.
                                                                Laporan Perubahan
                                                                Dana</a>
                                                            <br>

                                                        </div>
                                                    @endif


                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span
                                                        style="float: left;">{{ $data['sab_sosial'] == '-' ? '' : 'Rp' }}</span>
                                                    <span
                                                        style="float: right;">{{ $data['sab_sosial'] == '-' ? '-' : number_format($data['sab_sosial'], 0, '.', '.') . '-,' }}</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span
                                                        style="float: left;">{{ $data['sab_kelembagaan'] == '-' ? '' : 'Rp' }}</span>
                                                    <span
                                                        style="float: right;">{{ $data['sab_kelembagaan'] == '-' ? '-' : number_format($data['sab_kelembagaan'], 0, '.', '.') . '-,' }}</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span
                                                        style="float: left;">{{ $data['sab_operasional'] == '-' ? '' : 'Rp' }}</span>
                                                    <span
                                                        style="float: right;">{{ $data['sab_operasional'] == '-' ? '-' : number_format($data['sab_operasional'], 0, '.', '.') . '-,' }}</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span
                                                        style="float: left;">{{ $data['sak_sosial'] == '-' ? '' : 'Rp' }}</span>
                                                    <span
                                                        style="float: right;">{{ $data['sak_sosial'] == '-' ? '-' : number_format($data['sak_sosial'], 0, '.', '.') . '-,' }}</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span
                                                        style="float: left;">{{ $data['sak_kelembagaan'] == '-' ? '' : 'Rp' }}</span>
                                                    <span
                                                        style="float: right;">{{ $data['sak_kelembagaan'] == '-' ? '-' : number_format($data['sak_kelembagaan'], 0, '.', '.') . '-,' }}</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span
                                                        style="float: left;">{{ $data['sak_operasional'] == '-' ? '' : 'Rp' }}</span>
                                                    <span
                                                        style="float: right;">{{ $data['sak_operasional'] == '-' ? '-' : number_format($data['sak_operasional'], 0, '.', '.') . '-,' }}</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span style="float: left;">Rp</span>
                                                    <span style="float: right;">,-</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span style="float: left;">Rp</span>
                                                    <span style="float: right;">12.000.000</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span style="float: left;">Rp</span>
                                                    <span style="float: right;">12.000.000</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span style="float: left;">Rp</span>
                                                    <span style="float: right;">12.000.000</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span style="float: left;">Rp</span>
                                                    <span style="float: right;">12.000.000</span>
                                                </td>


                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">

                                                    {!! app\Http\Controllers\LaporanController::getJumlahPilar(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_pendidikan'],
                                                    ) !!}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ app\Http\Controllers\LaporanController::getJumlahPenerimaManfaat(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_pendidikan'],
                                                    ) }}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {!! app\Http\Controllers\LaporanController::getJumlahPilar(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_kesehatan'],
                                                    ) !!}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ app\Http\Controllers\LaporanController::getJumlahPenerimaManfaat(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_kesehatan'],
                                                    ) }}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {!! app\Http\Controllers\LaporanController::getJumlahPilar(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_ekonomi'],
                                                    ) !!}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ app\Http\Controllers\LaporanController::getJumlahPenerimaManfaat(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_ekonomi'],
                                                    ) }}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {!! app\Http\Controllers\LaporanController::getJumlahPilar(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_kemanusiaan'],
                                                    ) !!}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ app\Http\Controllers\LaporanController::getJumlahPenerimaManfaat(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_kemanusiaan'],
                                                    ) }}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {!! app\Http\Controllers\LaporanController::getJumlahPilar(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_lingkungan'],
                                                    ) !!}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ app\Http\Controllers\LaporanController::getJumlahPenerimaManfaat(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_lingkungan'],
                                                    ) }}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {!! app\Http\Controllers\LaporanController::getJumlahPilar(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_kelembagaan'],
                                                    ) !!}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ app\Http\Controllers\LaporanController::getJumlahPenerimaManfaat(
                                                        $data['bulan'],
                                                        $tahun,
                                                        $id_upzis,
                                                        $data['id_pilar_kelembagaan'],
                                                    ) }}
                                                </td>

                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {!! app\Http\Controllers\LaporanController::getJumlahPenyaluranProgram($data['bulan'], $tahun, $id_upzis) !!}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span style="float: left;">Rp</span>
                                                    <span style="float: right;">12.000.000</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    <span
                                                        style="float: left;">{{ $data['saldo_akhir'] == '-' ? '' : 'Rp' }}</span>
                                                    <span
                                                        style="float: right;">{{ $data['saldo_akhir'] == '-' ? '-' : number_format($data['saldo_akhir'], 0, '.', '.') . '-,' }}</span>
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ app\Http\Controllers\LaporanController::getJumlahPenerimaManfaatTotal($data['bulan'], $tahun, $id_upzis) }}
                                                </td>
                                                <td
                                                    style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                                                    {{ $data['keterangan'] == null ? '-' : $data['keterangan'] }}
                                                </td>

                                            </tr>

                                            @include('modal.modal_laporan_saldo_awal')
                                        @endforeach

                                    </tbody>

                                </table>

                                {{-- <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <p>Nilai dari server: <span id="value"></span></p>
                                </div>
                            </div> --}}

                                <div class="modal fade show" id="myModal" tabindex="-1"
                                    aria-labelledby="jemputVerifikasiLabel" aria-modal="true" role="dialog">
                                    <div class="modal-dialog modal-lg modal-dialog-centered ">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="jemputVerifikasiLabel">Verifikasi Penghimpunan
                                                    Ranting</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class=" bg-ijo d-flex justify-content-around p-2 rounded">
                                                    <div class="col">
                                                        <span class="text-bold">Ranting</span><br>
                                                        <span id="value1"></span><br>
                                                        <span id="value2"></span><br>
                                                    </div>
                                                    <div class="col">
                                                        <span class="text-bold">Koordinator Desa</span><br>
                                                        <span>Suyadi</span><br>
                                                        <span>085726036689</span><br>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="card" style="height: 135px">
                                                            <div class="card-body">
                                                                <span class="text-bold">PLPK</span><br>
                                                                <table style="width: 100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Aktif</td>
                                                                            <td>:</td>
                                                                            <td>25</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Menjemput</td>
                                                                            <td>:</td>
                                                                            <td>9</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Persentase</td>
                                                                            <td>:</td>
                                                                            <td>36.0 %</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="card" style="height: 135px">
                                                            <div class="card-body">
                                                                <span class="text-bold">Munfiq</span><br>
                                                                <table style="width: 100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Aktif</td>
                                                                            <td>:</td>
                                                                            <td>1705</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Terjemput</td>
                                                                            <td>:</td>
                                                                            <td>187</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Persentase</td>
                                                                            <td>:</td>
                                                                            <td>10.9 %</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
                                                        <div class="card" style="height: 135px">
                                                            <div class="card-body">
                                                                <span class="text-bold">Periode</span><br>
                                                                <span class="-">Mei 2023</span><br>
                                                                <span class="text-bold">Nominal</span><br>
                                                                <span class="-">Rp.
                                                                    3.769.100,-</span><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="">
                                                <div class="mr-auto">
                                                    <span class="text-bold text-danger mr-auto">Belum diVerifikasi
                                                        Upzis</span><br>
                                                    <span>Verifikasi sebagai konfirmasi bahwa dana koin sudah diterima
                                                        upzis</span>
                                                </div>
                                                <button type="button" class="btn btn-outline-success"
                                                    onclick="openInNewTab('/koin-ranting/P05/05/2023')"><i
                                                        class="fas fa-info-circle"></i> Detail</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            {{-- end card body --}}

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection


@section('js')


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function showConsoleLog(id) {
            axios.get('/upzis/server?id=' + id)
                .then(response => {
                    const data = response.data;
                    document.getElementById('value1').innerHTML = data.value;
                    document.getElementById('value2').innerHTML = data.value2;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    </script>



@endsection






@push('intro_data_pengajuan')
    <script>
        function klikkene(value) {
            introJs().setOptions({
                    steps: [{
                            element: document.querySelector('.card-header-data-pengajuan'),
                            title: 'Data Pengajuan',
                            intro: 'Menampilkan pengajuan pentasyarufan tingkat UPZIS MWCNU dan Ranting NU'
                        },
                        {
                            element: document.querySelector('.intro-card-data-pengajuan'),
                            title: 'Aksi',
                            intro: 'Menampilkan informasi dan aksi mengenai data pentasyarufan yang dipilih'
                        },
                        {
                            element: document.querySelector('.intro-filter-data-pengajuan'),
                            title: 'Filter Pengajuan',
                            intro: 'Untuk menampilkan data pentasyarufan secara spesifik, gunakan filter'
                        },
                        {
                            element: document.querySelector('.intro-reset-data-pengajuan'),
                            title: 'Reset',
                            intro: 'Klik disini untuk mereset filter'
                        },
                        @if (Auth::user()->gocap_id_upzis_pengurus != null)
                            {
                                element: document.querySelector('.intro-tambah-data-pengajuan'),
                                title: 'Tambah',
                                intro: 'Klik disini untuk menambahkan pengajuan pentasyarufan'
                            },
                        @endif
                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                            {
                                element: document.querySelector('.intro-ekspors-data-pengajuan'),
                                title: 'Ekspor',
                                intro: 'Klik disini untuk ekspor data pengajuan pentasyarufan '
                            },
                        @endif {
                            element: document.querySelector('.intro-table-pengajuan'),
                            title: 'Data Pengajuan',
                            intro: 'Data pengajuan pentasyarufan berdasarkan filter akan tampil di tabel berikut, klik mana saja pada salah satu data untuk melihat detail'
                        }

                    ]
                }).setOption("dontShowAgain", value)
                .setOption("skipLabel", "<p widht='100px' style='font-size:12px;color:blue;'><u>Lewati</u> </p>")
                .setOption("dontShowAgainLabel", " Jangan Tampilkan Lagi")
                .setOption("disableInteraction", true)
                .setOption("nextLabel", "Lanjut")
                .setOption("prevLabel", "Kembali")
                .setOption("doneLabel", "Selesai")
                .setOptions({
                    showProgress: true,
                })
                .onbeforechange(function() {

                    if (this._currentStep === 0) {
                        $('#upzis-tab').find('span').trigger('click');
                        return true;
                    }
                }).oncomplete(function() {
                    location.reload();
                })
                .start();
        }

        $(document).ready(function() {
            klikkene(true);
            $("#panduan").click(function() {
                klikkene(false);
            });
        });
    </script>
@endpush
