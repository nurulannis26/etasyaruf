<div>
    {{-- Be like water. --}}

    @php
        
        function penyebut($nilai)
        {
            $nilai = abs($nilai);
            $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
            $temp = '';
            if ($nilai < 12) {
                $temp = ' ' . $huruf[$nilai];
            } elseif ($nilai < 20) {
                $temp = penyebut($nilai - 10) . ' Belas';
            } elseif ($nilai < 100) {
                $temp = penyebut($nilai / 10) . ' Puluh' . penyebut($nilai % 10);
            } elseif ($nilai < 200) {
                $temp = ' Seratus' . penyebut($nilai - 100);
            } elseif ($nilai < 1000) {
                $temp = penyebut($nilai / 100) . ' Ratus' . penyebut($nilai % 100);
            } elseif ($nilai < 2000) {
                $temp = ' Seribu' . penyebut($nilai - 1000);
            } elseif ($nilai < 1000000) {
                $temp = penyebut($nilai / 1000) . ' Ribu' . penyebut($nilai % 1000);
            } elseif ($nilai < 1000000000) {
                $temp = penyebut($nilai / 1000000) . ' Juta' . penyebut($nilai % 1000000);
            } elseif ($nilai < 1000000000000) {
                $temp = penyebut($nilai / 1000000000) . ' Milyar' . penyebut(fmod($nilai, 1000000000));
            } elseif ($nilai < 1000000000000000) {
                $temp = penyebut($nilai / 1000000000000) . ' Trilyun' . penyebut(fmod($nilai, 1000000000000));
            }
            return $temp;
        }
        
        function terbilang($nilai)
        {
            if ($nilai < 0) {
                $hasil = 'Minus ' . trim(penyebut($nilai));
            } elseif ($nilai == 0) {
                $hasil = 'Nol ' . trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }
            return '(' . $hasil . ' Rupiah)';
        }
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{-- card data pentasyarufan --}}
                <div class="card ijo-atas">
                    <!-- /.card-header -->
                    <div class="card-body mt-2">

                        <div class="card">
                            <div class="card-body intro-profil-pengajuan-pc">
                                <div class="row mb-2">

                                    {{-- judul --}}
                                    <div class="col-12 col-md-8 col-sm-12 mb-2 mb-xl-0">
                                        <b><i class="fas fa-user"></i> DETAIL PENGAJUAN INTERNAL</b>
                                    </div>
                                    {{-- end judul --}}

                                    {{-- status --}}
                                    {{-- <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                        <div class="float-right">
                                            <span class="mt-4 mr-4">Diinput :
                                                {{ Carbon\Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM Y') }}
                                                {{ Carbon\Carbon::parse($data->created_at)->format('H:i:s') }}
                                            </span>
                                            <a class="btn btn-warning " wire:click="" data-toggle="modal"
                                                data-target="#modal_profil_penerima" role="button"><i
                                                    class="fas fa-user"></i>
                                                {{ $data->status_pengajuan }}</a>
                                        </div>
                                    </div> --}}
                                    {{-- end status --}}

                                </div>
                                <div class="form-row ">

                                    {{-- nomor pengajuan --}}
                                    <div class="col-sm-4 invoice-col">
                                        Nomor Pengajuan
                                        <address>
                                            <b> {{ $data->nomor_surat }}</b><br>
                                            Tgl Pengajuan :
                                            {{ Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('dddd, D MMMM Y') }}<br>
                                        </address>
                                    </div>
                                    {{-- end nomor pengajuan --}}

                                    {{-- tingkat --}}
                                    {{-- <div class="col-sm-3 invoice-col">
                                        Tenggat Pencairan
                                        <address>
                                            <b>Sebelum</b><br>
                                            {{ Carbon\Carbon::parse($data->tgl_tenggat)->isoFormat('dddd, D MMMM Y') }}<br>
                                        </address>
                                    </div> --}}
                                    {{-- end tingkat --}}

                                    {{-- pj pengambilan dana --}}
                                    <div class="col-sm-4 invoice-col">
                                        Tujuan
                                        <address>
                                            <b>{{ $data->tujuan }}</b><br>

                                            {{ $data->bentuk ? 'Bentuk Pencairan : ' . $data->bentuk : null }}<br>
                                        </address>
                                    </div>
                                    {{-- end pj pengambila dana --}}

                                    {{-- pj pengambilan dana --}}
                                    <div class="col-sm-4 invoice-col">
                                        Diajukan Oleh
                                        <address>
                                            <b>{{ $this->nama_pengurus_pc($data->maker_tingkat_pc) }}</b><br>
                                            {{ $this->jabatan_pengurus_pc($data->maker_tingkat_pc) }}
                                        </address>
                                    </div>
                                    {{-- end pj pengambila dana --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end card data pentasyarufan --}}

                <div class="row">
                    {{-- card jenis data --}}
                    <div class="col col-md-4 col-sm-12">
                        <div class="card ijo-atas">
                            <b class="d-flex justify-content-center mt-3 ">Pilih Jenis Data</b>
                            <div class="card-body ">

                                <div wire:click="tombol_pengajuan" class="text-dark " style="cursor: pointer">
                                    <div class="card ijo-card {{ $bg_card_pengajuan }} intro-tombol-pengajuans"
                                        id="ijocard1">
                                        <div class="card-body ">
                                            <div class="form-row">
                                                <div class="col-6 float-left">
                                                    <b class="mt-1">Pengajuan</b>
                                                </div>
                                                <div class="col-6 float-right">
                                                    @if ($bg_card_pengajuan == 'bg-success')
                                                        <div class='btn btn-light btn-block '
                                                            style='border-radius:10px;  '>
                                                            {{ $data->approval_status }}
                                                        </div>
                                                    @else
                                                        @if ($data->approval_status == 'Belum Direspon')
                                                            <div class='btn btn-warning btn-block '
                                                                style='border-radius:10px;  '>
                                                                {{ $data->approval_status }}
                                                            </div>
                                                        @elseif($data->approval_status == 'Disetujui')
                                                            <div class='btn btn-success btn-block '
                                                                style='border-radius:10px;  '>
                                                                {{ $data->approval_status }}
                                                            </div>
                                                        @else
                                                            <div class='btn btn-danger btn-block '
                                                                style='border-radius:10px;  '>
                                                                {{ $data->approval_status }}
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <hr class="bg-light">
                                            <div class="row">
                                                <div class="col-6 float-left">
                                                    <p class="mt-1">
                                                        Nominal Pengajuan
                                                    </p>
                                                </div>
                                                <div class="col-6 mr-auto">
                                                    <strong class="float-right">
                                                        Rp{{ number_format($data->nominal_pengajuan, 0, '.', '.') }},-
                                                    </strong>
                                                </div>
                                            </div>
                                            <span class="float-right">
                                                {{ terbilang($data->nominal_pengajuan) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- tombol arsip --}}
                                <div wire:click="tombol_arsip" class="text-dark " style="cursor: pointer">
                                    <div class="card ijo-card {{ $bg_card_arsip }} intro-tombol-arsips" id="ijocard2">
                                        <div class="card-body ">
                                            <div class="form-row">
                                                <div class="col-12 float-left">
                                                    <b class="mt-1">LPJ Penggunaan Dana</b>
                                                </div>

                                            </div>
                                            <hr class="bg-light">
                                            <div class="row">
                                                {{-- tanggal disetujui --}}
                                                <div class="col-6 float-left">
                                                    <p class="mt-1">
                                                        Dana Digunakan
                                                    </p>
                                                </div>
                                                {{-- nominal disetujui --}}
                                                <div class="col-6 mr-auto">
                                                    <strong class="float-right">
                                                        Rp{{ number_format($dana_digunakan, 0, '.', '.') }},-
                                                    </strong>
                                                </div>
                                            </div>
                                            {{-- terbilang nominal disetujui --}}
                                            <span class="float-right">

                                                {{ terbilang($dana_digunakan) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                {{-- end tombol arsip --}}

                            </div>
                        </div>
                    </div>
                    {{-- end card jenis data --}}


                    <div class="col col-md-8 col-sm-12">
                        <div class="card ijo-atas">
                            <div class="card-body">

                                {{-- card pengajuan --}}
                                <div class="card card-body" id="ns-0"
                                    style="display: @if ($bg_card_pengajuan == 'bg-success') block @else none @endif ">
                                    {{-- tabbed --}}
                                    <div class="row">
                                        <div class="col-4 col-md-12  col-sm-12 ">
                                            <ul class="nav nav-tabs mt-1 ml-1 mr-1" id="myTab1" role="tablist">
                                                <style>
                                                    div>ul>li>a.active {
                                                        color: #28a745 !important;
                                                        font-weight: bold;
                                                    }

                                                    div>ul>li>a.active:hover {
                                                        color: #28a745 !important;
                                                        font-weight: bold;
                                                    }

                                                    div>ul>li>a.nav-link:hover {
                                                        font-weight: bold;
                                                    }
                                                </style>
                                                {{-- tab z1 --}}
                                                <li class="nav-item intro-pengajuans-arsips" role="presentation">
                                                    <a wire:ignore.self class="nav-link text-secondary active"
                                                        id="z1-tab" data-toggle="tab" data-target="#z1"
                                                        type="button" role="tab" aria-controls="z1"
                                                        aria-selected="true">1. Pengajuan</a>
                                                </li>
                                                {{-- end tab z1 --}}
                                                {{-- tab z2 --}}
                                                <li class="nav-item intro-persetujuan-direktur-arsips"
                                                    role="presentation">
                                                    <a wire:ignore.self class="nav-link text-secondary " id="z2-tab"
                                                        data-toggle="tab" data-target="#z2" type="button"
                                                        role="tab" aria-controls="z2" aria-selected="false">2.
                                                        Persetujuan Direktur</a>
                                                </li>
                                                {{-- end tab z2 --}}
                                                {{-- tab z3 --}}
                                                <li class="nav-item intro-pencairan-keuangan-arsips"
                                                    role="presentation">
                                                    <a wire:ignore.self class="nav-link text-secondary " id="z3-tab"
                                                        data-toggle="tab" data-target="#z3" type="button"
                                                        role="tab" aria-controls="z3" aria-selected="false">3.
                                                        Pencairan Keuangan</a>
                                                </li>
                                                {{-- end tab z3 --}}

                                            </ul>
                                        </div>
                                    </div>
                                    {{-- end tabbed --}}



                                    {{-- isi tabbed --}}
                                    <div class="tab-content" id="myTab1">


                                        <div wire:ignore.self class="tab-pane fade show active" id="z1"
                                            role="tabpanel" aria-labelledby="z1-tab">
                                            @include('detail.tab-z1')
                                        </div>

                                        <div wire:ignore.self class="tab-pane fade " id="z2" role="tabpanel"
                                            aria-labelledby="z2-tab">
                                            @include('detail.tab-z2')
                                        </div>
                                        <div wire:ignore.self class="tab-pane fade " id="z3" role="tabpanel"
                                            aria-labelledby="z3-tab">
                                            @include('detail.tab-z3')
                                        </div>


                                    </div>
                                    {{-- end isi tabbed --}}
                                </div>
                                {{-- end card pengajuan --}}


                                {{-- info --}}
                                <div class="card mt-2" id="ns-1"
                                    style="display: @if ($bg_card_arsip == 'bg-success') block @else none @endif ">
                                    <div class="card-body ">
                                        <div class="form-row ">

                                            <div class="col-12 col-md-9 col-sm-12 mb-2 mb-xl-0">
                                                <div class="d-flex flex-row bd-highlight align-items-center">
                                                    <div class="p-2 bd-highlight">
                                                        <i class="fas fa-info-circle"></i>
                                                    </div>
                                                    <div class="p-1 bd-highlight">
                                                        <span> Diinput oleh
                                                            {{ $this->jabatan_pengurus_pc($data->maker_tingkat_pc) }}
                                                            ({{ $this->nama_pengurus_pc($data->maker_tingkat_pc) }})
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                class="col-12 col-md-3  col-sm-12 mb-2 mb-xl-0 intro-dana-tersisa-internal-arsips">
                                                <button data-toggle="modal"
                                                    class="btn btn-outline-success noClick btn-block">
                                                    Dana
                                                    Tersisa
                                                    Rp{{ number_format($data->nominal_pencairan - $dana_digunakan, 0, '.', '.') }},-</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- card arsip --}}
                                <div class="card" id="ns-2"
                                    style="display: @if ($bg_card_arsip == 'bg-success') block @else none @endif ">

                                    <div class="card-body">

                                        <div class="col-12 intro-arsip-dokumentasis">
                                            {{-- judul --}}
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-clipboard-check "></i><b> ARSIP DOKUMENTASI </b>
                                                </div>
                                                @if (Auth::user()->gocap_id_pc_pengurus == $data->maker_tingkat_pc)
                                                    @if ($data->pencairan_status == 'Berhasil Dicairkan')
                                                        <button class="btn btn-outline-success btn-sm tombol-tambah"
                                                            class="btn btn-primary" data-toggle="modal"
                                                            wire:click="modal_internal_arsip_tambah"
                                                            data-target="#modal_internal_arsip_tambah"
                                                            type="button"><i class="fas fa-plus-circle"></i>
                                                            Tambah</button>
                                                    @else
                                                        <button class="btn btn-outline-success btn-sm tombol-tambah"
                                                            class="btn btn-primary" data-toggle="tooltip"
                                                            data-placement="bottom" disabled
                                                            title="Arsip dokumentasi dapat diakses ketika dana sudah dicairkan"><i
                                                                class="fas fa-plus-circle"></i>
                                                            Tambah</button>
                                                    @endif

                                                @endif
                                            </div>
                                            {{-- end judul --}}

                                            {{-- alert --}}
                                            @if (session()->has('alert_arsip'))
                                                <div class="alert alert-success alert-dismissible fade show mt-2"
                                                    role="alert">
                                                    <i class="far fa-check-circle"></i> {{ session('alert_arsip') }}
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            {{-- end alert --}}

                                            {{-- tabel --}}
                                            {{-- tabel dokumentasi --}}
                                            <div class="table-responsive">
                                                <table class="table table-bordered mt-2 mb-2" style="width:100%">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th style="width: 5%;">No</th>
                                                            <th style="width: 50%">Judul</th>
                                                            <th>File</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @forelse($arsip as $a)
                                                            <tr>
                                                                <td>
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td>
                                                                    {{ $a->judul }} <br>
                                                                    <span style="font-size: 10pt">Diinput Oleh :
                                                                        {{ $this->nama_pengurus_pc($a->maker_tingkat_pc) }}
                                                                        ({{ $this->jabatan_pengurus_pc($a->maker_tingkat_pc) }})
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('uploads/pengajuan_arsip/' . $a->file) }}"
                                                                        target="_blank">
                                                                        {{ $a->file }}
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <!-- tombol aksi -->
                                                                    <div class="btn-group">

                                                                        <button type="button"
                                                                            class="btn btn-success btn-sm"
                                                                            data-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">Kelola</button>
                                                                        <button type="button"
                                                                            class="btn btn-success dropdown-toggle dropdown-toggle-split btn-sm"
                                                                            data-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            <span class="sr-only">Toggle
                                                                                Dropdown</span>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a onMouseOver="this.style.color='blue'"
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item tombol-ubah"
                                                                                wire:click="modal_internal_arsip_ubah('{{ $a->id_pengajuan_arsip }}','{{ $a->file }}')"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#modal_internal_arsip_ubah"><i
                                                                                    class="fas fa-edit"></i>
                                                                                Detail</a>
                                                                            <a onMouseOver="this.style.color='red'"
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item"
                                                                                wire:click="modal_internal_arsip_hapus('{{ $a->id_pengajuan_arsip }}','{{ $a->file }}')"
                                                                                data-toggle="modal"
                                                                                data-target="#modal_internal_arsip_hapus"
                                                                                type="button"><i
                                                                                    class="fas fa-trash"></i>
                                                                                Hapus</a>
                                                                        </div>
                                                                    </div>
                                                                    {{-- end tombol aksi --}}
                                                                </td>


                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center"> Data
                                                                    tidak ditemukan</td>
                                                            </tr>
                                                        @endforelse


                                                    </tbody>
                                                </table>
                                            </div>
                                            {{-- end tabel --}}
                                        </div>
                                    </div>

                                </div>

                                <div class="card" id="ns-3"
                                    style="display: @if ($bg_card_arsip == 'bg-success') block @else none @endif ">

                                    <div class="card-body">

                                        <div class="col-12 intro-penggunaan-danas">
                                            {{-- judul --}}
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-clipboard-check "></i><b> PENYALURAN</b>
                                                </div>
                                                @if (Auth::user()->gocap_id_pc_pengurus == $data->maker_tingkat_pc)
                                                    @if ($data->pencairan_status == 'Berhasil Dicairkan')
                                                        <button class="btn btn-outline-success btn-sm tombol-tambah"
                                                            class="btn btn-primary" data-toggle="modal"
                                                            wire:click="modal_pengeluaran_tambah"
                                                            data-target="#modal_pengeluaran_tambah" type="button"><i
                                                                class="fas fa-plus-circle"></i>
                                                            Tambah</button>
                                                    @else
                                                        <div>
                                                            <button class="btn btn-outline-danger btn-sm noClick"
                                                                class="btn btn-primary" type="button">
                                                                Dana Belum Dicairkan!</button>

                                                            <button
                                                                class="btn btn-outline-success btn-sm tombol-tambah"
                                                                class="btn btn-primary" type="button"
                                                                data-toggle="tooltip" data-placement="bottom" disabled
                                                                title="Penggunaan dana dapat diakses ketika dana sudah dicairkan"><i
                                                                    class="fas fa-plus-circle"></i>
                                                                Tambah</button>

                                                        </div>
                                                    @endif

                                                @endif
                                            </div>
                                            {{-- end judul --}}




                                            {{-- alert --}}
                                            @if (session()->has('alert_pengeluaran'))
                                                <div class="alert alert-success alert-dismissible fade show mt-2"
                                                    role="alert">
                                                    <i class="far fa-check-circle"></i>
                                                    {{ session('alert_pengeluaran') }}
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            {{-- end alert --}}

                                            {{-- tabel --}}
                                            {{-- tabel dokumentasi --}}
                                            {{-- tabel pengeluaran --}}
                                            <div class="table-responsive">
                                                <table class="table table-bordered mt-2" style="width:100%">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th style="width: 4%;">No</th>
                                                            <th style="width: 35%;">Judul</th>
                                                            <th style="width: 15%;">Tgl Pengeluaran</th>
                                                            <th style="width: 10%;">Jumlah</th>
                                                            <th>Nominal</th>
                                                            <th style="width: 15%;">Saldo Akhir </th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @php
                                                            $saldo_akhir = 0;
                                                            
                                                            $v = 1;
                                                        @endphp
                                                        @forelse ($pengeluaran as $a)
                                                            <tr>
                                                                <td>
                                                                    {{ $loop->iteration }}</td>
                                                                <td>
                                                                    <a href="{{ asset('uploads/nota_pengeluaran/' . $a->nota) }}"
                                                                        target="_blank">
                                                                        {{ $a->judul }} </a><br>
                                                                    {{-- <span
                                                                        style="font-size: 10pt">Diinput Oleh :
                                                                        {{ $this->nama_pengurus_pc($a->maker_tingkat_pc) }}
                                                                        ({{ $this->jabatan_pengurus_pc($a->maker_tingkat_pc) }}) --}}
                                                                    </span>
                                                                </td>
                                                                <td style="text-align: center">
                                                                    {{ Carbon\Carbon::parse($a->tgl_pengeluaran)->isoFormat('DD-MM-Y') }}
                                                                </td>
                                                                <td style="text-align: center">
                                                                    {{ $a->jumlah }}</td>
                                                                <td style="text-align: center">
                                                                    Rp{{ number_format($a->nominal_pengeluaran, 0, '.', '.') }},-
                                                                </td>
                                                                <td class="text-center">
                                                                    @php
                                                                        if ($v == 1) {
                                                                            $saldo_akhir = $data->nominal_pencairan - $dana_digunakan;
                                                                            // $saldo_akhir = $saldo_akhir + $pengeluaran->nominal_pengeluaran;
                                                                        }
                                                                    @endphp

                                                                    Rp{{ number_format($saldo_akhir, 0, '.', '.') }},-

                                                                    @php
                                                                        $saldo_akhir = $saldo_akhir + $a->nominal_pengeluaran;
                                                                        // $b =  $dana_digunakan - ($dana_digunakan - $pengeluaran->nominal_pengeluaran );
                                                                        
                                                                        $v++;
                                                                        
                                                                    @endphp
                                                                </td>

                                                                <td>
                                                                    <!-- tombol aksi -->
                                                                    <div class="btn-group">

                                                                        <button type="button"
                                                                            class="btn btn-success btn-sm"
                                                                            data-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">Kelola</button>
                                                                        <button type="button"
                                                                            class="btn btn-success dropdown-toggle dropdown-toggle-split btn-sm"
                                                                            data-toggle="dropdown"
                                                                            aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            <span class="sr-only">Toggle
                                                                                Dropdown</span>
                                                                        </button>
                                                                        <div class="dropdown-menu">
                                                                            <a onMouseOver="this.style.color='blue'"
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item tombol-ubah"
                                                                                wire:click="modal_pengeluaran_ubah('{{ $a->id_pengajuan_pengeluaran }}','{{ $a->nota }}')"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#modal_pengeluaran_ubah"><i
                                                                                    class="fas fa-edit"></i>
                                                                                Detail</a>
                                                                            <a onMouseOver="this.style.color='red'"
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item"
                                                                                wire:click="modal_pengeluaran_hapus('{{ $a->id_pengajuan_pengeluaran }}','{{ $a->nota }}')"
                                                                                data-toggle="modal"
                                                                                data-target="#modal_pengeluaran_hapus"
                                                                                type="button"><i
                                                                                    class="fas fa-trash"></i>
                                                                                Hapus</a>
                                                                        </div>
                                                                    </div>
                                                                    {{-- end tombol aksi --}}
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" class="text-center">
                                                                    Belum
                                                                    ada pengeluaran</td>
                                                            </tr>
                                                        @endforelse

                                                    </tbody>
                                                </table>
                                                {{-- end tabel --}}
                                            </div>
                                        </div>

                                    </div>


                                    {{-- end card arsip --}}

                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

        @include('modal.modal_pengeluaran_hapus')
        @include('modal.modal_internal_arsip_hapus')

        @include('modal.modal_internal_arsip_tambah')
        @include('modal.modal_internal_arsip_ubah')
        @include('modal.modal_pengeluaran_tambah')
        @include('modal.modal_pengeluaran_ubah')



        @push('script')
            <script>
                $(document).ready(function() {
                    window.loadContactDeviceSelect2 = () => {
                        bsCustomFileInput.init();
                        $('.tombol-tambah').click(function() {
                            $(".custom-file-arsip").html('').change();
                        });

                        $('.tombol-ubah').click(function() {
                            $(".custom-file-arsip").html('').change();
                        });

                        $('#nominal_pengeluaran').on('input', function(e) {
                            $('#nominal_pengeluaran').val(formatRupiah($('#nominal_pengeluaran').val(),
                                'Rp. '));
                        });

                        $('#nominal_pengeluaran2').on('input', function(e) {
                            $('#nominal_pengeluaran2').val(formatRupiah($('#nominal_pengeluaran2').val(),
                                'Rp. '));
                        });

                        // petugas
                        $('#select2RekeningInternal').select2();
                        $('#select2RekeningInternal').on('change', function() {
                            var data = $(this).val();
                            @this.set('id_rekening2', data);
                        });
                    }

                    loadContactDeviceSelect2();
                    window.livewire.on('loadContactDeviceSelect2', () => {
                        loadContactDeviceSelect2();
                    });

                });
            </script>
        @endpush


    </div>
