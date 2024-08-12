@extends('main')
@section('upzis_ranting', 'active')
@section('pengajuan_ac', 'active menu-open')
@section('pengajuan_mo', 'menu-open')
@section('css')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-sm-6 text-secondary mt-1">
                    <a href="/{{ $role }}/dashboard"> Dashboard</a> /
                    <a href="/{{ $role }}/upzis-ranting"> Data Pengajuan
                        {{ $data->tingkat == 'Upzis MWCNU' ? 'Upzis' : 'Ranting' }}</a> /
                    <a> Detail Pengajuan {{ $data->tingkat == 'Upzis MWCNU' ? 'Upzis' : 'Ranting' }}</a>
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

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="far fa-check-circle"></i>
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('fail'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ session('fail') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    {{-- card1 --}}
                    <div class="card ijo-atas">
                        <div class="card-body mt-2">
                            <div class="card intro-detail-data-pengajuan-card">
                                <div class="card-body">

                                    <div class="row mb-2">
                                        {{-- judul --}}
                                        <div class="col-12 col-md-11 col-sm-12 mb-2 mb-xl-0">
                                            <b><i class="fas fa-user"></i> DETAIL PENGAJUAN </b>
                                        </div>
                                        {{-- print --}}
                                        <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                                            <a href="/{{ $role }}/laporan/{{ $data->id_pengajuan }}" target="_blank"
                                                class="btn btn-block btn-sm btn-outline-success hover intro-ekspors-data-pengajuan">
                                                <i class="fas fa-file-pdf"></i> Cetak</a>
                                        </div>
                                        {{-- @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                            <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                                                <a data-toggle="collapse" data-target="#delete" aria-expanded="false"
                                                    aria-controls="delete"
                                                    class="btn btn-block btn-sm btn-outline-danger hover intro-ekspors-data-pengajuan">
                                                    <i class="fas fa-trash"></i> Hapus</a>
                                            </div>
                                        @endif --}}
                                    </div>

                                    <div class="form-row">
                                        {{-- nomor pengajuan --}}
                                        <div class="col-sm-4 invoice-col">
                                            Nomor Pengajuan
                                            <address>
                                                <b> {{ $data->nomor_surat }}</b><br>
                                                Tgl input :
                                                {{ Carbon\Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM Y') }}
                                                <br>
                                            </address>
                                        </div>
                                        {{-- pj pengambilan dana --}}
                                        <div class="col-sm-3 invoice-col">
                                            PJ Pengambilan Dana
                                            <address>
                                                @if ($data->tingkat == 'Upzis MWCNU')
                                                    <b>{{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $data->pj_upzis) }}</b><br>
                                                    {{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data->pj_upzis) }}
                                                @else
                                                    <b>{{ \App\Http\Controllers\Helper::getNamaPengurus('ranting', $data->pj_ranting) }}</b><br>
                                                    {{ \App\Http\Controllers\Helper::getJabatanPengurus('ranting', $data->pj_ranting) }}
                                                @endif
                                            </address>
                                        </div>
                                        <div class="col-sm-3 invoice-col">
                                            Petugas Input
                                            <address>
                                                @if ($data->tingkat == 'Upzis MWCNU')
                                                    <b>{{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $data->maker_tingkat_upzis) }}</b><br>
                                                    {{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data->maker_tingkat_upzis) }}
                                                @else
                                                    <b>{{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $data->maker_tingkat_upzis) }}</b><br>
                                                    {{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data->maker_tingkat_upzis) }}
                                                    {{-- <b>{{ \App\Http\Controllers\Helper::getNamaPengurus('ranting', $data->pj_ranting) }}</b><br>
                                                    {{ \App\Http\Controllers\Helper::getJabatanPengurus('ranting', $data->pj_ranting) }} --}}
                                                @endif
                                            </address>
                                        </div>
                                        <div class="col-sm-2 invoice-col">
                                            Tingkat
                                            <address>
                                                <b>Umum</b><br>
                                                @if ($data->tingkat == 'Upzis MWCNU')
                                                    Upzis MWCNU
                                                    {{ \App\Http\Controllers\Helper::getNamaUpzis($data->id_upzis) }}
                                                @elseif($data->tingkat == 'Ranting NU')
                                                    Ranting NU
                                                    {{ \App\Http\Controllers\Helper::getNamaRanting($data->id_ranting) }}
                                                @endif
                                            </address>
                                        </div>
                                        {{-- <div class="col-md-12">
                                            <div class="collapse mt-2" id="delete">
                                                <div class="card card-body" style="background-color:#ffbbbb">
                                                    <span class=" text-bold">
                                                        <em>Yakin Ingin Menghapus Data? (Semua Data Yg Berkaitan Akan
                                                            Dihapus)</em>
                                                    </span>
                                                    <div class="float-left mt-1">
                                                        <a href="/upzis/delete-pengajuan/{{ $data->id_pengajuan }}"
                                                            class="btn btn-sm btn-danger hover"><i
                                                                class="fas fa-check-circle"></i>
                                                            Iya, Saya Ingin Menghapus Data Ini</a>

                                                        <button class="btn btn-sm btn-secondary hover" type="button"
                                                            data-toggle="collapse" data-target="#delete"
                                                            aria-expanded="false" aria-controls="delete">
                                                            Batalkan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- card2 --}}
                    @livewire('detail-pengajuan', ['id_pengajuan' => $data->id_pengajuan])
                </div>
            </div>
        </div>

    </section>

@endsection


@section('js')
    {{-- 
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script> --}}

@endsection
