<div wire:ignore.self class="modal fade" id="detail-laporan" data-backdrop="static" data-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">LPJ & BERITA ACARA
                </h5>
                <div>
                    <button wire:click="resetValue" id="toggleCollapseButton" type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <div class="modal-body">

                @if ($data->status_rekomendasi == 'Belum Terbit' and $data_detail and $data_detail->approval_status == 'Belum Direspon')
                    <div class="callout callout-danger mt-2">
                        <span style="font-size: 12pt;" class="text-bold"><i
                                class="icon fas fa-exclamation-triangle mr-1"></i> Lembar Rekomendasi Belum Diterbitkan
                        </span>
                        <p class="mt-1">Belum dapat input LPJ & BA</p>
                    </div>
                @endif
                @if ($data->status_rekomendasi == 'Belum Terbit' and $data_detail and $data_detail->approval_status == 'Disetujui')
                    <div class="callout callout-danger mt-2">
                        <span style="font-size: 12pt;" class="text-bold"><i
                                class="icon fas fa-exclamation-triangle mr-1"></i> Lembar Rekomendasi Belum Diterbitkan
                        </span>
                        <p class="mt-1">Belum dapat input LPJ & BA</p>
                    </div>
                @endif
                @if ($data_detail and $data_detail->approval_status == 'Ditolak')
                    <div class="callout callout-danger mt-2">
                        <span style="font-size: 12pt;" class="text-bold"><i
                                class="icon fas fa-exclamation-triangle mr-1"></i> Rencana Program Pentasyarufan Ditolak
                        </span>
                        <p class="mt-1">Belum dapat input LPJ & BA</p>
                    </div>
                @endif
                @if ($data_detail and $data_detail->pencairan_status == 'Ditolak')
                    <div class="callout callout-danger mt-2">
                        <span style="font-size: 12pt;" class="text-bold"><i
                                class="icon fas fa-exclamation-triangle mr-1"></i> Rencana Program Pentasyarufan Tidak
                            Bisa
                            Dicairkan
                        </span>
                        <p class="mt-1">Belum dapat input LPJ & BA</p>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="far fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- <div class="card light">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                No : {{ $data->nomor_surat }}
                            </div>
                            <div class="float-right">
                                Pelaksanaan :
                                {{ Carbon\Carbon::parse($data_detail->tgl_pelaksanaan ?? null)->isoFormat('dddd, D MMMM Y') }}
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="row">

                    {{-- no rekomendasi --}}
                    <div class="col col-md-12 col-sm-12">
                        <div class="row mt-2">
                            <div class="col col-md-6 col-sm-12">

                                <table class="table table-bordered mt-2">
                                    <thead>
                                        <tr style="height:74px;">
                                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                Petugas<br>
                                                Pentasyarufan
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span class="text-bold">
                                                    @if ($data->tingkat == 'Upzis MWCNU')
                                                        {{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $data_detail->petugas_upzis ?? null) }}
                                                    @elseif($data->tingkat == 'Ranting NU')
                                                        {{ \App\Http\Controllers\Helper::getNamaPengurus('ranting', $data_detail->petugas_ranting ?? null) }}
                                                    @endif
                                                </span>
                                                <br>
                                                <span style="font-size:16px;">
                                                    @if ($data->tingkat == 'Upzis MWCNU')
                                                        {{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data_detail->petugas_upzis ?? null) }}
                                                        -
                                                        Upzis MWCNU
                                                        {{ \App\Http\Controllers\Helper::getNamaUpzis($data->id_upzis ?? null) }}
                                                    @elseif($data->tingkat == 'Ranting NU')
                                                        {{ \App\Http\Controllers\Helper::getJabatanPengurus('ranting', $data_detail->petugas_ranting ?? null) }}
                                                        -
                                                        Ranting NU
                                                        {{ \App\Http\Controllers\Helper::getNamaRanting($data->id_ranting ?? null) }}
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr style="height:74px;">
                                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                Pilar & Program
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span class="text-bold">
                                                    {{ \App\Http\Controllers\Helper::getDataPilar($data_detail->id_program_pilar ?? null)->pluck('pilar')->first() }}
                                                </span>
                                                <br>
                                                {{ \App\Http\Controllers\Helper::getDataKegiatan($data_detail->id_program_kegiatan ?? null)->pluck('nama_program')->first() }}
                                                <br>
                                                {{ $data_detail->pengajuan_note ?? '-' }}
                                            </td>
                                        </tr>
                                        {{-- <tr style="height:74px;">
                                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                Jenis Program
                                            </td>
                                            <td style="vertical-align: middle;">
                                            </td>
                                        </tr>
                                        <tr style="height:74px;">
                                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                Keterangan
                                            </td>
                                            <td style="vertical-align: middle;">
                                            </td>
                                        </tr> --}}
                                    </thead>
                                </table>
                            </div>
                            <div class="col col-md-6 col-sm-12">
                                <table class="table table-bordered mt-2">
                                    <thead>
                                        <tr style="height:74px;">
                                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                Target <br> Penerima Manfaat
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span class="text-bold">
                                                    {{ $data_detail->nama_penerima ?? null }}
                                                </span>
                                                <br>
                                                {{ $data_detail->jumlah_penerima ?? null }} Orang

                                            </td>
                                        </tr>

                                        <tr style="height:74px;">
                                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                Nominal Penyaluran
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <span class="text-bold">
                                                    (Berdasarkan Rekomendasi)
                                                </span>
                                                <div class="row">
                                                    @if ($data->status_rekomendasi == 'Sudah Terbit')
                                                        <div class="col-md-2">Satuan</div>
                                                        <div class="col-md-10">:
                                                            {{ $this->numberFormat($data_detail->satuan_pencairan ?? null) }}
                                                        </div>
                                                        <div class="col-md-2">Total</div>
                                                        <div class="col-md-10">:
                                                            {{ $this->numberFormat($data_detail->nominal_pencairan ?? null) }}
                                                        </div>
                                                    @endif
                                                    @if ($data->status_rekomendasi == 'Belum Terbit')
                                                        <div class="col-md-2">Satuan</div>
                                                        <div class="col-md-10">:
                                                            -
                                                        </div>
                                                        <div class="col-md-2">Total</div>
                                                        <div class="col-md-10">:
                                                            -
                                                        </div>
                                                    @endif
                                                </div>

                                            </td>
                                        </tr>


                                    </thead>
                                </table>
                                {{-- info --}}
                                {{-- <div class="card mt-2">
                                    <div class="card-body">
                                        <em>Penerima Manfaat</em> <br>
                                        <span class="text-bold">{{ $data_detail->nama_penerima ?? null }}</span><br>
                                        <em>Jumlah Penerima Manfaat</em> <br>
                                        <span class="text-bold">{{ $data_detail->jumlah_penerima ?? null }} Orang</span><br>
                                        <em>Nominal Satuan Diajukan</em> <br>
                                        <span
                                            class="text-bold">{{ $this->numberFormat($data_detail->satuan_pengajuan ?? null) }}</span><br>
                                        <em>Jumlah Nominal Diajukan</em> <br>
                                        <span
                                            class="text-bold">{{ $this->numberFormat($data_detail->nominal_pengajuan ?? null) }}</span>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        {{-- <div class="card callout callout-success">
                            <div class="modal-detail-rencana-pentasyarufan">
                                <div class="d-flex justify-content-between " style="cursor: pointer"
                                    data-toggle="collapse" data-target="#detailNoRekomendasi" aria-expanded="false"
                                    aria-controls="detailNoRekomendasi">
                                    <div>
                                        <i class="fas fa-clipboard-list"></i><b class="ml-2"> LEMBAR REKOMENDASI </b>
                                        @if ($data->status_rekomendasi == 'Belum Terbit')
                                            <sup class="badge badge-danger text-white bg-secondary mb-2 hover">Belum
                                                Terbit</sup>
                                        @else
                                            <sup class="badge  text-white bg-success mb-2 hover">Sudah Terbit</sup>
                                        @endif
                                    </div>
                                    <div id="toggleRencana" class="d-flex align-items-center">

                                        <i class="fas fa-sort-down mr-2"></i>
                                    </div>
                                </div>
                                <div class="collapse " id="detailNoRekomendasi" wire:ignore.self>
                                    <div class="card p-3 mt-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                No Rekom BMT<br>
                                                <em>
                                                    {{ $data->no_rekom_bmt ?? '-' }}
                                                </em>
                                            </div>
                                            <div class="col-md-6">
                                                No Rekom BRI<br>
                                                <em>
                                                    {{ $data->no_rekom_bri ?? '-' }}
                                                </em>
                                            </div>

                                        </div>
                                    </div>


                                   
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    @if ($data and $data->status_rekomendasi == 'Sudah Terbit')
                        @if (
                            $data_detail and
                                $data_detail->approval_status == 'Disetujui' and
                                $data_detail->pencairan_status == 'Berhasil Dicairkan')
                            {{-- berita acara --}}
                            <div class="col col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body modal-detail-rencana-pentasyarufan">
                                        <div class="d-flex justify-content-between " style="cursor: pointer"
                                            data-toggle="collapse" data-target="#detailBerita" aria-expanded="false"
                                            aria-controls="detailBerita">
                                            <div>
                                                <i class="fas fa-clipboard-list"></i><b class="ml-2"> BERITA ACARA</b>
                                                <br>
                                                @if ($data_detail and $data_detail->status_berita == 'Belum Dikonfirmasi')
                                                    <sup class="badge badge-danger text-white bg-secondary ml-4">Belum
                                                        Dikonfirmasi</sup>
                                                @elseif($data_detail and $data_detail->status_berita == 'Sudah Dikonfirmasi')
                                                    <sup class="badge badge-danger text-white bg-primary ml-4">Sudah
                                                        Dikonfirmasi,
                                                        Menunggu Diperiksa</sup>
                                                @elseif($data_detail and $data_detail->status_berita == 'Sudah Diperiksa')
                                                    <sup class="badge badge-danger text-white bg-success ml-4">Selesai
                                                        LPJ</sup>
                                                @elseif($data_detail and $data_detail->status_berita == 'Revisi')
                                                    <sup class="badge badge-danger text-white bg-danger ml-4">Sudah
                                                        Diperiksa
                                                        &
                                                        Revisi</sup>
                                                @endif

                                            </div>
                                            <div id="toggleRencana" class="d-flex align-items-center">
                                                <!-- Gunakan ikon "fa-sort-down" sebagai ikon atas yang berubah -->
                                                <i class="fas fa-sort-down mr-2"></i>
                                            </div>
                                        </div>

                                        <div class="collapse " id="detailBerita" wire:ignore.self>

                                            {{-- fafa  --}}
                                            @if (Auth::user()->gocap_id_pc_pengurus != null)

                                                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')
                                                    @if ($data_detail and $data_detail->status_berita != 'Belum Dikonfirmasi')
                                                        <div class="card mt-2">
                                                            <div class="card-body">
                                                                @if (
                                                                    $data_detail and $data_detail->status_berita == 'Sudah Dikonfirmasi' or
                                                                        $data_detail->status_berita == 'Belum Dikonfirmasi')
                                                                    <span wire:ignore id="infoText"
                                                                        style="font-size: 12pt;"> <i
                                                                            class="fas fa-info-circle mr-1"></i>
                                                                        Berita Acara Sudah Lengkap?
                                                                    </span>
                                                                @endif
                                                                @if ($data_detail and $data_detail->status_berita == 'Sudah Diperiksa' or $data_detail->status_berita == 'Revisi')
                                                                    <span wire:ignore id="infoText2"
                                                                        style="font-size: 12pt;"> <i
                                                                            class="fas fa-info-circle mr-1"></i>
                                                                        Respon Ulang?
                                                                    </span>
                                                                @endif
                                                                <br>
                                                                <div id="buttonAccTolakBerita" wire:ignore.self>
                                                                    <button class="btn btn-sm btn-success hover mt-2"
                                                                        data-toggle="collapse"
                                                                        data-target="#accBerita" aria-expanded="false"
                                                                        aria-controls="accBerita"
                                                                        onclick="accBerita()">
                                                                        {{ $data_detail->status_berita == 'Sudah Dikonfirmasi' ? 'Ya, ACC' : 'ACC Ulang' }}
                                                                    </button>
                                                                    <button class="btn btn-sm btn-danger hover mt-2"
                                                                        data-toggle="collapse"
                                                                        data-target="#tolakBerita"
                                                                        aria-expanded="false" onclick="tolakBerita()"
                                                                        aria-controls="tolakBerita">
                                                                        {{ $data_detail->status_berita == 'Sudah Dikonfirmasi' ? 'Tidak, Revisi' : 'Revisi' }}
                                                                    </button>
                                                                </div>
                                                                <div class="collapse" id="accBerita" wire:ignore.self>
                                                                    <div class="form-row mt-2">

                                                                        <div
                                                                            class="col-12 col-md-8 col-sm-12 mb-2 mb-xl-0">
                                                                            <div class="input-group mb-3">
                                                                                <input wire:model="diperiksa_note"
                                                                                    type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Masukan Catatan ACC(Jika Ada)">
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                                            <button wire:click="accBerita"
                                                                                class="btn btn-success hover btn-block ">
                                                                                ACC
                                                                            </button>
                                                                        </div>
                                                                        <div
                                                                            class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                                            <button
                                                                                class="btn btn-secondary hover btn-block "
                                                                                onclick="batalBerita()">
                                                                                Batal
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="collapse" id="tolakBerita"
                                                                    wire:ignore.self>
                                                                    <div class="form-row mt-2">

                                                                        <div
                                                                            class="col-12 col-md-8 col-sm-12 mb-2 mb-xl-0">
                                                                            <div class="input-group mb-3">
                                                                                <input wire:model="diperiksa_note_rev"
                                                                                    type="text"
                                                                                    class="form-control"
                                                                                    placeholder="Masukan Catatan Penolakan(Jika Ada)">
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                                            <button wire:click="tolakBerita"
                                                                                class="btn btn-danger hover btn-block ">
                                                                                Tolak
                                                                            </button>
                                                                        </div>
                                                                        <div
                                                                            class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                                            <button
                                                                                class="btn btn-secondary hover btn-block "
                                                                                onclick="batalBerita()">
                                                                                Batal
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif


                                            {{-- <ul class="nav nav-tabs mt-2" id="myTab" role="tablist">
                                                <style>
                                                    ul>li>a.active {
                                                        color: #28a745 !important;
                                                        font-weight: bold;
                                                    }

                                                    ul>li>a.active:hover {
                                                        color: #28a745 !important;
                                                        font-weight: bold;
                                                    }

                                                    ul>li>a.nav-link:hover {
                                                        font-weight: bold;
                                                    }
                                                </style>
                                                <li class="nav-item">
                                                    <a wire:ignore.self class="nav-link text-secondary active"
                                                        id="home-tab" data-toggle="tab" data-target="#home"
                                                        type="button" role="tab" aria-controls="home"
                                                        aria-selected="true">
                                                        Urung Ngerti
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a wire:ignore.self class="nav-link text-secondary "
                                                        id="profile-tab" data-toggle="tab" data-target="#profile"
                                                        type="button" role="tab" aria-controls="profile"
                                                        aria-selected="true">
                                                        Konfirmasi
                                                    </a>
                                                </li>

                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                    aria-labelledby="home-tab">
                                                    <div class="table-responsive mt-3">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr
                                                                    class="intro-detail-data-pengajuan-konfirmasi-upload-berkas">
                                                                    <td class="text-bold" style="width: 40%;">
                                                                        Tanggal Penyaluran
                                                                    </td>
                                                                    <td>
                                                                        {{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}
                                                                        (Sementara Tanggal Hari INI)
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="text-bold" style="width: 40%;">
                                                                        Disalurkan Oleh
                                                                    </td>
                                                                    <td>
                                                                        @if ($data_detail and $data_detail->berita_konfirmasi_upzis)
                                                                            <span class="text-bold">
                                                                                {{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $data_detail->berita_konfirmasi_upzis ?? null) }}</span>
                                                                            <span style="font-size:11pt;">
                                                                                ({{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data_detail->berita_konfirmasi_upzis ?? null) }})</span>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        <br>
                                                                        Tanggal :
                                                                        @if ($data_detail and $data_detail->tgl_konfirmasi == null)
                                                                            -
                                                                        @elseif($data_detail)
                                                                            {{ Carbon\Carbon::parse($data_detail->tgl_konfirmasi)->isoFormat('dddd, D MMMM Y') }}
                                                                        @endif

                                                                        <br>
                                                                        Catatan :
                                                                        {{ $data_detail->konfirmasi_note ?? '-' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-bold" style="width: 40%;">
                                                                        Diterima Oleh
                                                                    </td>
                                                                    <td>
                                                                        @if ($data_detail and $data_detail->berita_diperiksa_pc)
                                                                            <span class="text-bold">
                                                                                {{ \App\Http\Controllers\Helper::getNamaPengurus('pc', $data_detail->berita_diperiksa_pc ?? null) }}</span>
                                                                            <span style="font-size:11pt;">
                                                                                ({{ \App\Http\Controllers\Helper::getJabatanPengurus('pc', $data_detail->berita_diperiksa_pc ?? null) }})</span>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        <br>
                                                                        Tanggal :
                                                                        @if ($data_detail and $data_detail->tgl_diperiksa == null)
                                                                            -
                                                                        @elseif($data_detail)
                                                                            {{ Carbon\Carbon::parse($data_detail->tgl_diperiksa)->isoFormat('dddd, D MMMM Y') }}
                                                                        @endif

                                                                        <br>
                                                                        Catatan :
                                                                        {{ $data_detail->diperiksa_note ?? '-' }}
                                                                    </td>
                                                                </tr>

                                                                <tr
                                                                    class="intro-detail-data-pengajuan-konfirmasi-upload-berkas">
                                                                    <td class="text-bold" style="width: 40%;">
                                                                        Bentuk Bantuan
                                                                    </td>
                                                                    <td>
                                                                        (Belum Tahu Isine Kie apa)
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="profile" role="tabpanel"
                                                    aria-labelledby="profile-tab">
                                                    
                                                </div>

                                            </div> --}}

                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered">
                                                    <thead>

                                                        @if (Auth::user()->gocap_id_upzis_pengurus != null and $data_detail and $data_detail->status_berita != 'Sudah Diperiksa')
                                                            <tr
                                                                class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                                                <td class="text-bold" style="width: 40%;">
                                                                    Isi Berita Acara
                                                                </td>
                                                                <td>
                                                                    <span>Isi Kelengkapan Data Berita Acara</span><br>

                                                                    <a wire:click="modal_edit_berita()"
                                                                        onclick="createEditBerita()"
                                                                        class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                                        data-toggle="modal" data-target="#edit-berita"
                                                                        style="border-radius:10px; width:3cm;">Isi
                                                                        Data
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                                                <td class="text-bold" style="width: 40%;">
                                                                    Format
                                                                    Berita
                                                                    Acara
                                                                </td>
                                                                <td>
                                                                    <span>Format Berita Acara</span><br>
                                                                    <a href="/upzis/berita_acara/{{ $data_detail->id_pengajuan_detail ?? null }}"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-outline-success hover float-left mr-2 mt-2"
                                                                        role="button"
                                                                        style="border-radius:10px; width:3cm;">Download
                                                                    </a>
                                                                    {{-- <a wire:click="modal_edit_berita()"
                                                                        onclick="createEditBerita()"
                                                                        class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                                        data-toggle="modal" data-target="#edit-berita"
                                                                        style="border-radius:10px; width:3cm;">Ubah
                                                                        Berita
                                                                    </a> --}}
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="intro-detail-data-pengajuan-konfirmasi-upload-berkas">
                                                                <td class="text-bold" style="width: 40%;">
                                                                    Upload
                                                                    Berita
                                                                    Acara
                                                                </td>
                                                                <td>
                                                                    <div class="custom-file"
                                                                        id="customFileScanBerita">
                                                                        <input type="file" wire:model="scan_berita"
                                                                            accept="application/pdf"
                                                                            class="custom-file-input" name="file">
                                                                        <label class="custom-file-label"
                                                                            for="customFile">Pilih
                                                                            file</label>
                                                                    </div><br>
                                                                    <input wire:model="konfirmasi_note" type="text"
                                                                        class="form-control mt-2"
                                                                        placeholder="Masukan Catatan (Jika Ada)">

                                                                    @if ($scan_berita == null)
                                                                        <button
                                                                            class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                                            style="border-radius:10px; width:3cm;"
                                                                            disabled wire:loading.attr="disabled"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Input Belum Lengkap">Upload
                                                                        </button>
                                                                    @else
                                                                        <button wire:click="uploadBerita"
                                                                            class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                                            style="border-radius:10px; width:3cm;"
                                                                            id="uploadBerita"
                                                                            wire:loading.attr="disabled">Upload
                                                                        </button>
                                                                    @endif
                                                                    {{-- <div wire:loading class="mt-3">
                                                                Harap Tunggu...
                                                            </div> --}}

                                                                </td>
                                                            </tr>
                                                        @endif

                                                        @if (Auth::user()->gocap_id_upzis_pengurus != null and $data_detail and $data_detail->status_berita == 'Sudah Diperiksa')
                                                            <tr
                                                                class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                                                <td class="text-bold" style="width: 40%;">
                                                                    Format
                                                                    Berita
                                                                    Acara
                                                                </td>
                                                                <td>
                                                                    <span>Format Berita Acara</span><br>
                                                                    <a href="/upzis/berita_acara/{{ $data_detail->id_pengajuan_detail ?? null }}"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-outline-success hover float-left mr-2 mt-2"
                                                                        role="button"
                                                                        style="border-radius:10px; width:3cm;">Download
                                                                    </a>
                                                                    {{-- <a wire:click="modal_edit_berita()"
                                                                    onclick="createEditBerita()"
                                                                    class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                                    data-toggle="modal" data-target="#edit-berita"
                                                                    style="border-radius:10px; width:3cm;">Ubah
                                                                    Berita
                                                                </a> --}}
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                            <tr
                                                                class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                                                <td class="text-bold" style="width: 40%;">
                                                                    Format
                                                                    Berita
                                                                    Acara
                                                                </td>
                                                                <td>
                                                                    <span>Format Berita Acara</span><br>
                                                                    <a href="/upzis/berita_acara/{{ $data_detail->id_pengajuan_detail ?? null }}"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                                        role="button"
                                                                        style="border-radius:10px; width:3cm;">Preview
                                                                    </a>
                                                                    {{-- <a wire:click="modal_edit_berita()"
                                                                onclick="createEditBerita()"
                                                                class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                                data-toggle="modal" data-target="#edit-berita"
                                                                style="border-radius:10px; width:3cm;">Ubah
                                                                Berita
                                                            </a> --}}
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        <tr
                                                            class="intro-detail-data-pengajuan-konfirmasi-upload-berkas">
                                                            <td class="text-bold" style="width: 40%;">
                                                                Berita Acara
                                                                ber
                                                                TTD &
                                                                Stampel
                                                            </td>
                                                            <td>
                                                                @if ($data_detail and $data_detail->file_berita == null)
                                                                    -
                                                                @elseif($data_detail)
                                                                    @if ($data_detail->status_berita == 'Sudah Diperiksa')
                                                                        <a href="/print-pdf/{{ $data_detail->id_pengajuan_detail }}"
                                                                            target="_blank">{{ $data_detail->file_berita ?? null }}</a>
                                                                    @else
                                                                        <a href="{{ asset('uploads/pengajuan_berita/' . $data_detail->file_berita ?? null) }}"
                                                                            target="_blank">{{ $data_detail->file_berita ?? null }}</a>
                                                                    @endif

                                                                @endif
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-bold" style="width: 40%;">
                                                                Dikonfirmasi
                                                                Oleh
                                                            </td>
                                                            <td>
                                                                @if ($data_detail and $data_detail->berita_konfirmasi_upzis)
                                                                    <span class="text-bold">
                                                                        {{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $data_detail->berita_konfirmasi_upzis ?? null) }}</span>
                                                                    <span style="font-size:11pt;">
                                                                        ({{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data_detail->berita_konfirmasi_upzis ?? null) }})</span>
                                                                @else
                                                                    -
                                                                @endif
                                                                <br>
                                                                Tanggal :
                                                                @if ($data_detail and $data_detail->tgl_konfirmasi == null)
                                                                    -
                                                                @elseif($data_detail)
                                                                    {{ Carbon\Carbon::parse($data_detail->tgl_konfirmasi)->isoFormat('dddd, D MMMM Y') }}
                                                                @endif

                                                                <br>
                                                                Catatan :
                                                                {{ $data_detail->konfirmasi_note ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-bold" style="width: 40%;">
                                                                Diperiksa Oleh
                                                            </td>
                                                            <td>
                                                                @if ($data_detail and $data_detail->berita_diperiksa_pc)
                                                                    <span class="text-bold">
                                                                        {{ \App\Http\Controllers\Helper::getNamaPengurus('pc', $data_detail->berita_diperiksa_pc ?? null) }}</span>
                                                                    <span style="font-size:11pt;">
                                                                        ({{ \App\Http\Controllers\Helper::getJabatanPengurus('pc', $data_detail->berita_diperiksa_pc ?? null) }})</span>
                                                                @else
                                                                    -
                                                                @endif
                                                                <br>

                                                                Tanggal :
                                                                @if ($data_detail and $data_detail->tgl_diperiksa == null)
                                                                    -
                                                                @elseif($data_detail)
                                                                    {{ Carbon\Carbon::parse($data_detail->tgl_diperiksa)->isoFormat('dddd, D MMMM Y') }}
                                                                @endif

                                                                <br>
                                                                @if ($data_detail and $data_detail->status_berita == 'Sudah Diperiksa')
                                                                    ACC - Catatan :
                                                                    {{ $data_detail->diperiksa_note ?? '-' }}
                                                                @endif
                                                                @if ($data_detail and $data_detail->status_berita == 'Revisi')
                                                                    REVISI - Catatan :
                                                                    {{ $data_detail->diperiksa_note_rev ?? '-' }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>









                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- penerima manfaat lpj --}}
                            <div class="col col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body modal-detail-rencana-pentasyarufan">
                                        <div class="d-flex justify-content-between " style="cursor: pointer"
                                            data-toggle="collapse" data-target="#detailPenerimaManfaatLpj"
                                            aria-expanded="false" aria-controls="detailPenerimaManfaatLpj">
                                            <div>
                                                <i class="fas fa-clipboard-list"></i><b class="ml-2"> PENERIMA
                                                    MANFAAT & PENYALURANNYA
                                                </b>
                                                <br>
                                                <sup
                                                    class="badge {{ $data_penerima_lpj->count('id_pengajuan_penerima') == 0 ? 'badge-secondary' : 'badge-primary' }}  text-white ml-4">
                                                    {{ count($data_penerima_lpj) > 0 ? $data_penerima_lpj->count('id_pengajuan_penerima') : '0' }}
                                                    Orang
                                                </sup>

                                            </div>
                                            <div id="toggleRencana" class="d-flex align-items-center">
                                                <!-- Gunakan ikon "fa-sort-down" sebagai ikon atas yang berubah -->
                                                <i class="fas fa-sort-down mr-2"></i>

                                            </div>
                                        </div>
                                        <div class="collapse mt-1" id="detailPenerimaManfaatLpj" wire:ignore.self>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span>
                                                        Total Penerima Manfaat :
                                                        {{ count($data_penerima_lpj) > 0 ? $data_penerima_lpj->count('id_pengajuan_penerima') : '0' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    
                                                      <a href="{{ route('import_penerima_manfaat', ['id_pengajuan_detail' => $data_detail->id_pengajuan_detail]) }}" target="_blank" class="btn btn-sm btn-outline-primary hover">
                                                        <i class="fas fa-plus-circle"></i> Import
                                                    </a>
                                                    
                                                    
                                                    @if (
                                                        $data_detail and
                                                            Auth::user()->gocap_id_upzis_pengurus != null and
                                                            $data->status_rekomendasi == 'Sudah Terbit' and
                                                            $data_detail->status_berita != 'Sudah Diperiksa')
                                                        <button wire:click="modal_tambah_penerima" data-toggle="modal"
                                                            data-target="#tambah-penerima"
                                                            class="btn btn-sm btn-outline-success hover">
                                                            <i class="fas fa-plus-circle"></i>
                                                            Tambah
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mr-auto">
                                                <span>
                                                    Total Nominal Tersalurkan
                                                    : <span
                                                        class="text-bold text-primary">{{ count($data_penerima_lpj) > 0 ? $this->numberFormat($data_penerima_lpj->sum('nominal_bantuan')) : '-' }}</span>
                                                </span>
                                            </div>
                                            {{-- <div wire:ignore.self class="collapse mt-3" id="deletePenerima">
                                                <div class="card card-body" style="background-color:#ffbbbb">
                                                    <span class=" text-bold">
                                                        <em>Yakin Ingin Menghapus Penerima Manfaat
                                                            {{ $nama_penerima }}?
                                                            (Semua
                                                            Lampiran Terkait Akan Ikut Terhapus)</em>
                                                    </span>
                                                    <div class="float-left mt-1">
                                                        <button
                                                            wire:click="delete_penerima('{{ $id_pengajuan_penerima }}')"
                                                            class="btn btn-sm btn-danger hover"><i
                                                                class="fas fa-check-circle"></i>
                                                            Iya, Saya Ingin Menghapus Data Ini</button>
                                                        <button class="btn btn-sm btn-secondary hover" type="button"
                                                            data-toggle="collapse" data-target="#deletePenerima"
                                                            aria-expanded="false" aria-controls="deletePenerima">
                                                            Batalkan</button>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="row">
                                                <div class="col col-md-12 col-sm-12">
                                                    <table class="table table-bordered mt-3" style="width:100%">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th style="width: 10px;vertical-align:middle;">No</th>
                                                                <th style="width: 25%;vertical-align:middle;">Penerima
                                                                    Manfaat</th>
                                                                <th style="width: 25%;vertical-align:middle;"> Alamat &
                                                                    No
                                                                    HP
                                                                </th>
                                                                <th style="width: 20%;vertical-align:middle;">Nominal &
                                                                    <br>
                                                                    Jenis
                                                                    Bantuan
                                                                </th>

                                                                @if (
                                                                    $data_detail and
                                                                        Auth::user()->gocap_id_upzis_pengurus != null and
                                                                        $data->status_rekomendasi == 'Sudah Terbit' and
                                                                        $data_detail->status_berita != 'Sudah Diperiksa')
                                                                    <th style="width: 20%;vertical-align:middle;">
                                                                        Keterangan & <br>Tgl Bantuan</th>
                                                                    <th style="width: 10%;vertical-align:middle;">Aksi
                                                                    </th>
                                                                @else
                                                                    <th style="width: 30%;vertical-align:middle;">
                                                                        Keterangan & <br>Tgl Bantuan</th>
                                                                    <th style="width: 10%;vertical-align:middle;">Aksi
                                                                    </th>
                                                                @endif

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @forelse($data_penerima_lpj as $a)
                                                            @empty
                                                                <tr>

                                                                    @if (
                                                                        $data_detail and
                                                                            Auth::user()->gocap_id_upzis_pengurus != null and
                                                                            $data->status_rekomendasi == 'Sudah Terbit' and
                                                                            $data_detail->status_berita != 'Sudah Diperiksa')
                                                                        <td colspan="6" class="text-center">Data
                                                                            penerima
                                                                            manfaat belum ada</td>
                                                                    @else
                                                                        <td colspan="6" class="text-center">Data
                                                                            penerima
                                                                            manfaat belum ada</td>
                                                                    @endif

                                                                </tr>
                                                            @endforelse
                                                            @foreach ($data_penerima_lpj as $a)
                                                                <tr style="cursor: pointer;">
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td><b style="font-size:11pt;">
                                                                            {{ $a->nama }}</b>
                                                                        <br>
                                                                        <span style="font-size: 10pt;">
                                                                            NIK : {{ $a->nik == '' ? ' - ' : $a->nik }}
                                                                            <br>
                                                                            KK &nbsp; :
                                                                            {{ $a->nokk == '' ? ' - ' : $a->nokk }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <b style="font-size:11pt;">
                                                                            {{ $a->alamat == '' ? ' - ' : $a->alamat }}</b>
                                                                        <br>
                                                                        <span style="font-size: 10pt;">
                                                                            No HP :
                                                                            {{ $a->nohp == '' ? ' - ' : $a->nohp }}
                                                                        </span>
                                                                    </td>
                                                                    <td><b style="font-size:11pt;">
                                                                            {{ $this->numberFormat($a->nominal_bantuan) }}</b>
                                                                        <br>
                                                                        <span style="font-size: 10pt;">
                                                                            Jenis Bantuan :
                                                                            {{ $a->jenis_bantuan == '' ? ' - ' : $a->jenis_bantuan }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <b style="font-size:11pt;">
                                                                            {{ $a->keterangan == '' ? ' - ' : $a->keterangan }}
                                                                        </b>
                                                                        <br>
                                                                        <span style="font-size: 10pt;">
                                                                            Tgl :
                                                                            {{ $a->tgl_bantuan ? Carbon\Carbon::parse($a->tgl_bantuan ?? null)->isoFormat('dddd, D MMMM Y') : ' - ' }}
                                                                        </span>
                                                                    </td>

                                                                    <td class="text-center">
                                                                        <div class="btn-group">
                                                                            <button
                                                                                class="btn btn-secondary btn-sm dropdown-toggle"
                                                                                type="button" data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                Detail
                                                                            </button>
                                                                            <div class="dropdown-menu">
                                                                                <a wire:click="detail_lampiran('{{ $a->id_pengajuan_penerima }}')"
                                                                                    data-toggle="modal"
                                                                                    data-target="#lampiran"
                                                                                    class="dropdown-item"
                                                                                    href="#">Lampiran</a>
                                                                                @if (
                                                                                    $data_detail and
                                                                                        Auth::user()->gocap_id_upzis_pengurus != null and
                                                                                        $data->status_rekomendasi == 'Sudah Terbit' and
                                                                                        $data_detail->status_berita != 'Sudah Diperiksa')
                                                                                    <a wire:click="modal_edit_penerima('{{ $a->id_pengajuan_penerima }}',
                                                                                '{{ $a->nama }}','{{ $a->nominal_bantuan }}','{{ $a->alamat }}','{{ $a->keterangan }}'
                                                                                ,'{{ $a->tgl_bantuan }}','{{ $a->jenis_bantuan }}','{{ $a->nik }}','{{ $a->nokk }}','{{ $a->nohp }}')"
                                                                                        data-toggle="modal"
                                                                                        data-target="#create-edit-penerima"
                                                                                        class="dropdown-item"
                                                                                        href="#">Edit</a>
                                                                                    <a wire:click="collapse_delete_penerima('{{ $a->id_pengajuan_penerima }}','{{ $a->nama }}')"
                                                                                        data-toggle="modal"
                                                                                        data-target="#hapus-penerima"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="deletePenerima"
                                                                                        class="dropdown-item"
                                                                                        href="#">Hapus </a>
                                                                                @endif

                                                                            </div>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                    {{-- </div> --}}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- lampiran --}}
                            <div class="col col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="d-flex justify-content-between " style="cursor: pointer"
                                            data-toggle="collapse" data-target="#detailLampiran"
                                            aria-expanded="false" aria-controls="detailLampiran">
                                            <div>
                                                <i class="fas fa-clipboard-list"></i><b class="ml-2"> LAMPIRAN</b>
                                                <br>
                                                <sup
                                                    class="badge  {{ $data_lampiran_berita->count('id_pengajuan_penerima') == 0 ? 'badge-secondary' : 'badge-primary' }}  text-white ml-4">
                                                    {{ count($data_lampiran_berita) > 0 ? $data_lampiran_berita->count('id_pengajuan_penerima') : '0' }}
                                                    Lampiran
                                                </sup>
                                            </div>
                                            <div id="toggleRencana" class="d-flex align-items-center">
                                                <!-- Gunakan ikon "fa-sort-down" sebagai ikon atas yang berubah -->
                                                <i class="fas fa-sort-down mr-2"></i>

                                            </div>
                                        </div>
                                        <div class="collapse mt-1" id="detailLampiran" wire:ignore.self>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span>
                                                        Total Lampiran :
                                                        {{ count($data_lampiran_berita) > 0 ? $data_lampiran_berita->count('id_pengajuan_penerima') : '0' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    @if (
                                                        $data_detail and
                                                            Auth::user()->gocap_id_upzis_pengurus != null and
                                                            $data->status_rekomendasi == 'Sudah Terbit' and
                                                            $data_detail->status_berita != 'Sudah Diperiksa')
                                                        <button wire:click="modal_tambah_lampiran_berita"
                                                            data-toggle="modal" onclick="tambahLampiranBerita()"
                                                            class="btn btn-sm btn-outline-success hover">
                                                            <i class="fas fa-plus-circle"></i>
                                                            Tambah
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <table class="table table-bordered mt-2" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 75%">
                                                            Judul Lampiran
                                                        </th>
                                                        <th class="text-center" style="width: 15%">
                                                            Tgl Upload
                                                        </th>

                                                        <th class="text-center" style="width: 10%">Aksi</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($data_lampiran_berita as $a)
                                                        <tr>
                                                            <td>

                                                                {{ $a->judul_file }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ Carbon\Carbon::parse($a->created_at)->isoFormat('DD-MM-Y') }}

                                                            </td>

                                                            <td class="text-center">
                                                                <a href="{{ asset('uploads/lampiran_berita/' . str_replace('/', '_', $data->nomor_surat ?? null) . '/' . $a->file) }}"
                                                                    target="_blank" type="button"><i
                                                                        class="fas fa-eye mr-2"
                                                                        style="color: rgb(181, 181, 181);"></i>
                                                                </a>
                                                                <a href="{{ asset('uploads/lampiran_berita/' . str_replace('/', '_', $data->nomor_surat ?? null) . '/' . $a->file) }}"
                                                                    download="{{ $a->judul_file }}" type="button"><i
                                                                        class="fas fa-download mr-2"
                                                                        style="color: rgb(0, 119, 255);"></i>
                                                                </a>
                                                                @if (
                                                                    $data_detail and
                                                                        Auth::user()->gocap_id_upzis_pengurus != null and
                                                                        $data->status_rekomendasi == 'Sudah Terbit' and
                                                                        $data_detail->status_berita != 'Sudah Diperiksa')
                                                                    <a data-toggle="modal"
                                                                        data-target="#hapus-lampiran-berita"
                                                                        wire:click="modalHapusLampiranBerita('{{ $a->id_lampiran_berita }}','{{ $a->file }}')"
                                                                        type="button"><i class="fas fa-trash"
                                                                            style="color: red;"></i>
                                                                    </a>
                                                                @endif

                                                            </td>
                                                        </tr>

                                                    @empty
                                                        <tr>
                                                            @if (
                                                                $data_detail and
                                                                    Auth::user()->gocap_id_upzis_pengurus != null and
                                                                    $data->status_rekomendasi == 'Sudah Terbit' and
                                                                    $data_detail->status_berita != 'Sudah Diperiksa')
                                                                <td colspan="3" class="text-center">
                                                                    Belum
                                                                    ada lampiran</td>
                                                            @elseif (
                                                                $data_detail and
                                                                    Auth::user()->gocap_id_pc_pengurus != null and
                                                                    $data->status_rekomendasi == 'Sudah Terbit' and
                                                                    $data_detail->status_berita != 'Sudah Diperiksa')
                                                                <td colspan="3" class="text-center">
                                                                    Belum
                                                                    ada lampiran</td>
                                                            @else
                                                                <td colspan="3" class="text-center">
                                                                    Belum
                                                                    ada lampiran</td>
                                                            @endif

                                                        </tr>
                                                    @endforelse

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>
