<div wire:ignore.self class="modal fade" id="detail-rencana" data-backdrop="static" data-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DETAIL RENCANA PROGRAM PENTASYARUFAN
                </h5>
                <div>
                    <button wire:click="resetValue" id="toggleCollapseButton" type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                {{-- alert --}}
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="far fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- <div class="m-3">
                    <i class="fas fa-info-circle"></i> Inputkan data penerima manfaat sesuai jumlah
                    penerima manfaat yang direncanakan
                    <br>
                </div> --}}
                <div class="card light">
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
                </div>
                <div class="row">
                    {{-- rincian pengajuan --}}
                    <div class="col col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-body modal-detail-rencana-pentasyarufan">
                                <div class="d-flex justify-content-between " style="cursor: pointer"
                                    data-toggle="collapse" data-target="#detailRencana" aria-expanded="false"
                                    aria-controls="detailRencana">
                                    <div>
                                        <i class="fas fa-clipboard-list"></i><b class="ml-2"> RENCANA
                                            PENTASYARUFAN</b>
                                    </div>
                                    <div id="toggleRencana" class="d-flex align-items-center">
                                        <!-- Gunakan ikon "fa-sort-down" sebagai ikon atas yang berubah -->
                                        <i class="fas fa-sort-down mr-2"></i>

                                    </div>
                                </div>
                                <div class="collapse mt-1" id="detailRencana" wire:ignore.self>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="ml-auto">
                                            @if ($data_detail and $data->status_pengajuan == 'Direncanakan')

                                                <button
                                                    wire:click="modal_edit_rencana('{{ $data_detail->id_pengajuan_detail ?? null }}')"
                                                    class="btn btn-sm btn-outline-secondary hover mr-1"
                                                    data-toggle="modal" data-target="#create-edit-rencana"><i
                                                        class="fas fa-edit"></i>
                                                    Ubah </button>
                                                <button class="btn btn-sm btn-outline-danger hover" type="button"
                                                    data-toggle="collapse" data-target="#deletePengajuan"
                                                    aria-expanded="false" aria-controls="deletePengajuan"><i
                                                        class="fas fa-trash"></i>
                                                    Hapus</button>
                                            @elseif($data_detail and $data->status_pengajuan == 'Diajukan')
                                                @if ($data->status_rekomendasi == 'Belum Terbit')
                                                    @if ($data_detail and $data_detail->approval_status == 'Ditolak')
                                                        <button
                                                            wire:click="modal_edit_rencana('{{ $data_detail->id_pengajuan_detail ?? null }}')"
                                                            class="btn btn-sm btn-outline-secondary hover mr-1"
                                                            data-toggle="modal" data-target="#create-edit-rencana"><i
                                                                class="fas fa-edit"></i>
                                                            Ubah </button>
                                                    @endif
                                                @endif
                                            @endif

                                        </div>
                                    </div>
                                    <div class="collapse mt-2" id="deletePengajuan">
                                        <div class="card card-body" style="background-color:#ffbbbb">
                                            <span class=" text-bold">
                                                <em>Yakin Ingin Menghapus Data?</em>
                                            </span>
                                            <div class="float-left mt-1">
                                                <button
                                                    wire:click="delete_pengajuan_detail('{{ $data_detail->id_pengajuan_detail ?? null }}')"
                                                    class="btn btn-sm btn-danger hover"><i
                                                        class="fas fa-check-circle"></i>
                                                    Iya, Saya Ingin Menghapus Data Ini</button>
                                                <button class="btn btn-sm btn-secondary hover" type="button"
                                                    data-toggle="collapse" data-target="#deletePengajuan"
                                                    aria-expanded="false" aria-controls="deletePengajuan">
                                                    Batalkan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-6 col-sm-12">
                                            <table class="table table-bordered mt-2">
                                                <thead>
                                                    <tr style="height:74px;">
                                                        <td class="text-bold"
                                                            style="width: 35%;vertical-align: middle;">
                                                            Petugas<br>
                                                            Pentasyarufan
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            @if ($data->tingkat == 'Upzis MWCNU')
                                                                {{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $data_detail->petugas_upzis ?? null) }}
                                                            @elseif($data->tingkat == 'Ranting NU')
                                                                {{ \App\Http\Controllers\Helper::getNamaPengurus('ranting', $data_detail->petugas_ranting ?? null) }}
                                                            @endif
                                                            <br>
                                                            <span style="font-size:11pt;">
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
                                                        <td class="text-bold"
                                                            style="width: 35%;vertical-align: middle;">
                                                            Pilar
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ \App\Http\Controllers\Helper::getDataPilar($data_detail->id_program_pilar ?? null)->pluck('pilar')->first() }}
                                                        </td>
                                                    </tr>
                                                    <tr style="height:74px;">
                                                        <td class="text-bold"
                                                            style="width: 35%;vertical-align: middle;">
                                                            Jenis Program
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ \App\Http\Controllers\Helper::getDataKegiatan($data_detail->id_program_kegiatan ?? null)->pluck('nama_program')->first() }}
                                                        </td>
                                                    </tr>
                                                    <tr style="height:74px;">
                                                        <td class="text-bold"
                                                            style="width: 35%;vertical-align: middle;">
                                                            Keterangan
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $data_detail->pengajuan_note ?? '-' }}
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="col col-md-6 col-sm-12">
                                            <table class="table table-bordered mt-2">
                                                <thead>
                                                    <tr style="height:74px;">
                                                        <td class="text-bold"
                                                            style="width: 35%;vertical-align: middle;">
                                                            Target <br> Penerima Manfaat
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $data_detail->nama_penerima ?? null }}
                                                        </td>
                                                    </tr>
                                                    <tr style="height:74px;">
                                                        <td class="text-bold"
                                                            style="width: 35%;vertical-align: middle;">
                                                            Jumlah<br>Penerima Manfaat
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $data_detail->jumlah_penerima ?? null }} Orang
                                                        </td>
                                                    </tr>
                                                    <tr style="height:74px;">
                                                        <td class="text-bold"
                                                            style="width: 35%;vertical-align: middle;">
                                                            Nominal Satuan

                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $this->numberFormat($data_detail->satuan_pengajuan ?? null) }}
                                                        </td>
                                                    </tr>
                                                    <tr style="height:74px;">
                                                        <td class="text-bold"
                                                            style="width: 35%;vertical-align: middle;">
                                                            Jumlah Nominal
                                                        </td>
                                                        <td style="vertical-align: middle;">
                                                            {{ $this->numberFormat($data_detail->nominal_pengajuan ?? null) }}
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
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- daftar penerima --}}
                    <div class="col col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-body modal-detail-rencana-pentasyarufan">
                                <div class="d-flex justify-content-between " style="cursor: pointer"
                                    data-toggle="collapse" data-target="#penerimaManfaat" aria-expanded="false"
                                    aria-controls="penerimaManfaat">
                                    <div>
                                        <i class="fas fa-clipboard-list"></i><b class="ml-2">DAFTAR PENERIMA
                                            MANFAAT</b>
                                    </div>
                                    <div id="togglePenerima" class="d-flex align-items-center">
                                        <!-- Gunakan ikon "fa-sort-down" sebagai ikon atas yang berubah -->
                                        <i class="fas fa-sort-down mr-2"></i>
                                    </div>
                                </div>
                                <div class="collapse" id="penerimaManfaat" wire:ignore.self>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="ml-auto">
                                            @if ($data_detail and Auth::user()->gocap_id_upzis_pengurus != null and $data->status_rekomendasi == 'Belum Terbit')
                                                <button wire:click="modal_tambah_penerima" data-toggle="modal"
                                                    data-target="#tambah-penerima"
                                                    class="btn btn-sm btn-outline-success hover">
                                                    <i class="fas fa-plus-circle"></i>
                                                    Tambah
                                                </button>
                                            @endif
                                        </div>
                                    </div>
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

                                                        @if ($data_detail and Auth::user()->gocap_id_upzis_pengurus != null and $data->status_rekomendasi == 'Belum Terbit')
                                                            <th style="width: 20%;vertical-align:middle;">
                                                                Keterangan & <br>Tgl Bantuan</th>
                                                            <th style="width: 10%;vertical-align:middle;">Aksi
                                                            </th>
                                                        @else
                                                            <th style="width: 30%;vertical-align:middle;">
                                                                Keterangan & <br>Tgl Bantuan</th>
                                                        @endif

                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @forelse($data_penerima as $a)
                                                    @empty
                                                        <tr>

                                                            @if ($data_detail and Auth::user()->gocap_id_upzis_pengurus != null and $data->status_rekomendasi == 'Belum Terbit')
                                                                <td colspan="6" class="text-center">Data
                                                                    penerima
                                                                    manfaat belum ada</td>
                                                            @else
                                                                <td colspan="5" class="text-center">Data
                                                                    penerima
                                                                    manfaat belum ada</td>
                                                            @endif

                                                        </tr>
                                                    @endforelse
                                                    @foreach ($data_penerima as $a)
                                                        <tr style="cursor: pointer;">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td><b style="font-size:11pt;">
                                                                    {{ $a->nama }}</b>
                                                                <br>
                                                                <span style="font-size: 10pt;">
                                                                    NIK : {{ $a->nik == '' ? ' - ' : $a->nik }}
                                                                    <br>
                                                                    KK &nbsp; : {{ $a->nokk == '' ? ' - ' : $a->nokk }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <b style="font-size:11pt;">
                                                                    {{ $a->alamat == '' ? ' - ' : $a->alamat }}</b>
                                                                <br>
                                                                <span style="font-size: 10pt;">
                                                                    No HP : {{ $a->nohp == '' ? ' - ' : $a->nohp }}
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
                                                            @if ($data_detail and Auth::user()->gocap_id_upzis_pengurus != null and $data->status_rekomendasi == 'Belum Terbit')
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

                                                                            @if (Auth::user()->gocap_id_upzis_pengurus != null)
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
                                                                                    href="#">Hapus</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                </td>
                                                            @endif
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
                    {{-- persetujuan direktur --}}
                    <div class="col col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body modal-detail-persetujuan-pc-lazisnu">
                                <div class="d-flex justify-content-between align-items-center" style="cursor: pointer"
                                    data-toggle="collapse" data-target="#acc2" aria-expanded="false"
                                    aria-controls="acc2">
                                    <div>
                                        <i class="fas fa-clipboard-check"></i><b class="ml-2"> STATUS PERSETUJUAN
                                        </b>
                                    </div>
                                    <div id="togglePersetujuan" class="d-flex align-items-center">
                                        <i class="fas fa-sort-down mr-2"></i>
                                    </div>
                                </div>
                                <div class="collapse" id="acc2" wire:ignore.self>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="ml-auto">
                                            @if (
                                                $data_detail and
                                                    Auth::user()->gocap_id_pc_pengurus != null and
                                                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                                                    $data->status_pengajuan == 'Diajukan' and
                                                    $data_detail->pencairan_status != 'Berhasil Dicairkan')
                                                <div class="dropdown float-right">
                                                    <button
                                                        class="btn btn-outline-secondary btn-sm dropdown-toggle hover"
                                                        type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Respon
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <button class="dropdown-item" data-toggle="collapse"
                                                            data-target="#acc" aria-expanded="false"
                                                            aria-controls="acc" onclick="accPengajuan()">
                                                            <i class="fas fa-user-check"></i>
                                                            {{ $data_detail && ($data_detail->approval_status == 'Ditolak' || $data_detail->approval_status == 'Disetujui') ? 'ACC Ulang' : 'ACC' }}
                                                        </button>
                                                        <button class="dropdown-item" data-toggle="collapse"
                                                            data-target="#tolak" aria-expanded="false"
                                                            aria-controls="tolak" onclick="tolakPengajuan()">
                                                            <i class="fas fa-ban"></i> Tolak
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                    {{-- alert --}}
                                    @if (session()->has('accTolak'))
                                        <div class="alert alert-success alert-dismissible fade show mt-3"
                                            role="alert">
                                            <i class="far fa-check-circle"></i>
                                            {{ session('accTolak') }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    @if (
                                        $data_detail and
                                            Auth::user()->gocap_id_pc_pengurus != null and
                                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                                            $data->scan == null)
                                        <div class="callout callout-danger mt-2">
                                            <span style="font-size: 12pt;" class="text-bold"><i
                                                    class="icon fas fa-exclamation-triangle mr-1"></i> Respon
                                                persetujuan belum bisa dilakukan
                                            </span>
                                            <p class="mt-1">Lembar pengajuan belum dikonfirmasi upzis</p>
                                        </div>
                                    @endif
                                    {{-- acc persetujuan --}}
                                    <div class="collapse" id="acc" wire:ignore.self>
                                        <div class="card card-body mt-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <b class="text-success">ACC PENGAJUAN</b>
                                                <a class="close" data-toggle="collapse" href="#acc"
                                                    role="button" aria-expanded="false" aria-controls="acc">
                                                    <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            {{-- <div class="mt-2">
                                                <div class="card p-3 hover">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <em>Yang Menyetujui</em><br>
                                                            <span class="text-bold">Direktur Eksekutif -
                                                                {{ \App\Http\Controllers\Helper::getDataPengurusByJabatan('pc', 'Direktur Eksekutif')->nama ?? null }}</span><br>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <em>Tgl Persetujuan</em><br>
                                                            <span
                                                                class="text-bold">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}</span>
                                                        </div>
                    
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <form wire:submit.prevent="acc">
                                                <div class="form-row mt-1">
                                                    {{-- nama stuan --}}
                                                    <div
                                                        class="form-group col-md-12 nominal-satuan-modal-data-pengajuan">
                                                        <label for="inputNama">NOMINAL DISETUJUI (SATUAN)
                                                            &nbsp;</label>
                                                        <sup class="badge badge-danger text-white mb-2"
                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bor-abu">Rp</span>
                                                            </div>
                                                            <input wire:model="satuan_disetujui" id="satuan_disetujui"
                                                                type="text" value="" class="form-control"
                                                                placeholder="Masukan Nominal Satuan">
                                                        </div>
                                                    </div>

                                                    {{-- nominal disetujui --}}
                                                    <div
                                                        class="form-group col-md-12 nominal-satuan-modal-data-pengajuan">
                                                        <div class="d-flex">
                                                            <label for="inputNama">NOMINAL DISETUJUI (TOTAL)
                                                                &nbsp;</label>
                                                            <span class="ml-auto">
                                                                <em>({{ $data_detail->jumlah_penerima ?? null }}
                                                                    Penerima Manfaat)</em>
                                                            </span>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bor-abu">Rp</span>
                                                            </div>
                                                            <input id="nominal" type="text"
                                                                value="{{ $this->updateTotal2() }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputAlamat">KETERANGAN&nbsp;</label>
                                                        <textarea type="text" class="form-control" wire:model="approval_note" placeholder="Masukan Keterangan"
                                                            rows="3"> </textarea>
                                                    </div>
                                                </div>
                                                {{-- tombol acc --}}
                                                <div class="d-flex float-right">
                                                    {{-- @if ($approval_date == '' or $satuan_disetujui == '')
                                                        <button class="btn btn-success btn-block" disabled
                                                            wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                                            ACC</button>
                                                    @else --}}
                                                    <button type="submit" name="submit"
                                                        class="btn btn-success hover" wire:loading.attr="disabled"><i
                                                            class="fas fa-check-circle"></i>
                                                        ACC</button>
                                                    {{-- @endif --}}
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    {{-- tolak persetujuan --}}
                                    <div class="collapse" id="tolak" wire:ignore.self>
                                        <div class="card card-body mt-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <b class="text-danger">TOLAK PENGAJUAN</b>
                                                <a class="close" data-toggle="collapse" href="#tolak"
                                                    role="button" aria-expanded="false" aria-controls="tolak">
                                                    <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            {{-- <div class="mt-2">
                                                <div class="card p-3 hover">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <em>Yang Menolak</em><br>
                                                            <span class="text-bold">Direktur Eksekutif -
                                                                {{ \App\Http\Controllers\Helper::getDataPengurusByJabatan('pc', 'Direktur Eksekutif')->nama ?? null }}</span><br>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <em>Tgl Penolakan</em><br>
                                                            <span
                                                                class="text-bold">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div> --}}
                                            <form wire:submit.prevent="tolak">
                                                <div class="form-row mt-1">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputAlamat">ALASAN PENOLAKAN&nbsp;</label>
                                                        <sup class="badge badge-danger text-white mb-2"
                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                        <textarea type="text" class="form-control" wire:model="denial_note" placeholder="Masukan Keterangan"
                                                            rows="3"> </textarea>
                                                    </div>
                                                </div>
                                                {{-- tombol acc --}}
                                                <div class="d-flex float-right">
                                                    @if ($denial_note == '')
                                                        <button class="btn btn-danger btn-block" disabled
                                                            wire:loading.attr="disabled"><i class="fas fa-ban"></i>
                                                            TOLAK</button>
                                                    @else
                                                        <button type="submit" name="submit"
                                                            class="btn btn-danger hover"
                                                            wire:loading.attr="disabled"><i class="fas fa-ban"></i>
                                                            TOLAK</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <table class="table table-bordered mt-2">
                                        <thead>
                                            <tr>
                                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                    Tgl
                                                    Respon
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    @if ($data_detail and $data_detail->approval_status == 'Disetujui')
                                                        @if ($data_detail and $data_detail->approval_date == null)
                                                            -
                                                        @else
                                                            {{ Carbon\Carbon::parse($data_detail->approval_date ?? null)->isoFormat('dddd, D MMMM Y') }}
                                                        @endif
                                                    @elseif($data_detail and $data_detail->approval_status == 'Ditolak')
                                                        {{ Carbon\Carbon::parse($data_detail->denial_date ?? null)->isoFormat('dddd, D MMMM Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- status --}}
                                            <tr>
                                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                    Status
                                                </td>
                                                <td style="vertical-align: middle;">

                                                    @if ($data_detail and $data_detail->approval_status == 'Disetujui')
                                                        <b style="font-size: 12pt;" class="text-success">
                                                            {{ $data_detail->approval_status ?? null }}
                                                        </b>
                                                    @elseif($data_detail and $data_detail->approval_status == 'Ditolak')
                                                        <b style="font-size: 12pt;" class="text-danger">
                                                            {{ $data_detail->approval_status ?? null }}
                                                        </b>
                                                    @else
                                                        {{ $data_detail->approval_status ?? null }}
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- petugas pentasyarufan --}}
                                            <tr>
                                                @if ($data_detail and $data_detail->approval_status == 'Ditolak')
                                                    <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                        Direspon Oleh
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ \App\Http\Controllers\Helper::getNamaPengurus('pc', $data_detail->denial_tingkat_pc) }}
                                                        <br>
                                                        <span style="font-size:11pt;">(
                                                            {{ \App\Http\Controllers\Helper::getJabatanPengurus('pc', $data_detail->denial_tingkat_pc) }}
                                                            )</span>
                                                    </td>
                                                @else
                                                    <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                        Direspon Oleh
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        @if ($data_detail and $data_detail->approver_tingkat_pc == null)
                                                            -
                                                        @else
                                                            {{ \App\Http\Controllers\Helper::getNamaPengurus('pc', $data_detail->approver_tingkat_pc ?? null) }}
                                                            <br>
                                                            <span style="font-size:11pt;">(
                                                                {{ \App\Http\Controllers\Helper::getJabatanPengurus('pc', $data_detail->approver_tingkat_pc ?? null) }}
                                                                )</span>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                            @if ($data_detail and $data_detail->approval_status == 'Ditolak')
                                                <tr>
                                                    <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                        Alasan Penolakan
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $data_detail->denial_note ?? null }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                        Keterangan
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        {{ $data_detail->approval_note ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </thead>
                                    </table>
                                    {{-- <div class="card p-3 hover mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <em>Nominal Yang Telah Disetujui (Satuan)</em><br>
                                                <span class="text-bold text-green">
                                                    {{ $this->numberFormat($data_detail->satuan_disetujui ?? null) }}
                                                </span>
                                            </div>
                                            <div class="col-md-6">
                                                <em>Nominal Yang Telah Disetujui (Total)</em><br>
                                                <span class="text-bold text-green">
                                                    {{ $this->numberFormat($data_detail->nominal_disetujui ?? null) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <table>
                                                <tr>
                                                    <td style="width: 60%"> Nominal Satuan Disetujui
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                                    </td>
                                                    <td style="width: 40%"> <b style="font-size: 12pt;"
                                                            class="text-success">
                                                            {{ $this->numberFormat($data_detail->satuan_disetujui ?? null) }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 60%"> Jumlah Nominal Disetujui &nbsp;&nbsp;&nbsp;
                                                        : </td>
                                                    <td style="width: 40%"> <b style="font-size: 12pt;"
                                                            class="text-success">
                                                            {{ $this->numberFormat($data_detail->nominal_disetujui ?? null) }}
                                                        </b>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- pencairan keuangan --}}
                    <div class="col col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body ">
                                <div class="d-flex justify-content-between align-items-center" style="cursor: pointer"
                                    data-toggle="collapse" data-target="#pencairan2" aria-expanded="false"
                                    aria-controls="pencairan2">
                                    <div>
                                        <i class="fas fa-clipboard-check"></i><b class="ml-2"> STATUS PENCAIRAN
                                        </b>
                                    </div>
                                    <div id="togglePencairan" class="d-flex align-items-center">
                                        <i class="fas fa-sort-down mr-2"></i>

                                    </div>
                                </div>
                                <div class="collapse" id="pencairan2" wire:ignore.self>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="ml-auto">
                                            @if (
                                                $data_detail and
                                                    Auth::user()->gocap_id_pc_pengurus != null and
                                                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '3b5ce3c4-a045-11ed-a0ac-040300000000' and
                                                    $data_detail->approval_status == 'Disetujui' and
                                                    $data->status_rekomendasi == 'Belum Terbit')
                                                <div class="dropdown float-right">
                                                    <button
                                                        class="btn btn-outline-secondary btn-sm dropdown-toggle hover"
                                                        type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Respon
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <button class="dropdown-item" data-toggle="collapse"
                                                            data-target="#pencairan" aria-expanded="false"
                                                            aria-controls="pencairan" onclick="accPencairan()">
                                                            <i class="fas fa-user-check"></i>
                                                            {{ $data_detail && $data_detail->pencairan_status == 'Berhasil Dicairkan' ? 'ACC Ulang' : 'ACC' }}
                                                        </button>
                                                        <button class="dropdown-item" data-toggle="collapse"
                                                            data-target="#tolakPencairan" aria-expanded="false"
                                                            aria-controls="tolakPencairan" onclick="tolakPencairan()">
                                                            <i class="fas fa-ban"></i> Tolak
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- alert --}}
                                    @if (session()->has('pencairan'))
                                        <div class="alert alert-success alert-dismissible fade show mt-3"
                                            role="alert">
                                            <i class="far fa-check-circle"></i>
                                            {{ session('pencairan') }}
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    @if (
                                        $data_detail and
                                            Auth::user()->gocap_id_pc_pengurus != null and
                                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '3b5ce3c4-a045-11ed-a0ac-040300000000' and
                                            $data_detail->approval_status != 'Disetujui')
                                        <div class="callout callout-danger mt-2">
                                            <span style="font-size: 12pt;" class="text-bold"><i
                                                    class="icon fas fa-exclamation-triangle mr-1"></i> Respon pencairan
                                                belum bisa
                                                dilakukan
                                            </span>
                                            <p class="mt-1">Program belum disetujui Direktur</p>
                                        </div>
                                    @endif
                                    {{-- acc pencairan --}}
                                    <div class="collapse" id="pencairan" wire:ignore.self>
                                        <div class="card card-body mt-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <b class="text-warning">ACC PENCAIRAN</b>
                                                <a class="close" data-toggle="collapse" href="#pencairan"
                                                    role="button" aria-expanded="false" aria-controls="pencairan">
                                                    <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            <form wire:submit.prevent="pencairan">
                                                <div class="form-row mt-1">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputNama">SUMBER DANA &nbsp;</label>
                                                        <sup class="badge badge-danger text-white mb-2"
                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                        <select wire:model="id_rekening" class="form-control"
                                                            id="select2Rekening">
                                                            <option value="">Pilih Rekening</option>
                                                            @foreach ($list_rekening as $a)
                                                                <option value="{{ $a->id_rekening }}">
                                                                    {{ \App\Http\Controllers\Helper::getNamaBmtByIdRekening($a->id_rekening ?? null) ?? '-' }}
                                                                    ({{ $a->no_rekening }})
                                                                    <br>
                                                                    {{ $a->nama_rekening }} <br>
                                                                    ({{ $this->numberFormat($a->saldo) }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputNama">NOMINAL BISA DICAIRKAN (SATUAN)
                                                            &nbsp;</label>
                                                        <sup class="badge badge-danger text-white mb-2"
                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bor-abu">Rp</span>
                                                            </div>
                                                            <input wire:model="satuan_pencairan" id="satuan_pencairan"
                                                                type="text" value="" class="form-control"
                                                                placeholder="Masukan Nominal Satuan">
                                                        </div>
                                                    </div>
                                                    {{-- nominal pencairan --}}
                                                    <div class="form-group col-md-12">
                                                        <div class="d-flex">
                                                            <label for="inputNama">NOMINAL BISA DICAIRKAN (TOTAL)
                                                                &nbsp;</label>
                                                            <span class="ml-auto">
                                                                <em>({{ $data_detail->jumlah_penerima ?? null }}
                                                                    Penerima Manfaat)</em>
                                                            </span>
                                                        </div>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bor-abu">Rp</span>
                                                            </div>
                                                            <input id="nominal" type="text"
                                                                value="{{ $this->updateTotal3() }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="inputAlamat">KETERANGAN&nbsp;</label>

                                                        <textarea type="text" class="form-control" wire:model="pencairan_note" placeholder="Masukan Keterangan"
                                                            rows="3"> </textarea>
                                                    </div>
                                                </div>
                                                {{-- tombol cairkan --}}
                                                <div class="d-flex float-right">
                                                    @if ($id_rekening == '' and $satuan_pencairan == '')
                                                        <button class="btn btn-warning btn-block" disabled
                                                            wire:loading.attr="disabled"><i
                                                                class="fas fa-check-circle"></i>
                                                            BISA DICAIRKAN</button>
                                                    @else
                                                        <button type="submit" name="submit"
                                                            class="btn btn-warning hover"
                                                            wire:loading.attr="disabled"><i
                                                                class="fas fa-check-circle"></i>
                                                            BISA DICAIRKAN</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    {{-- tolak pencairan --}}
                                    <div class="collapse" id="tolakPencairan" wire:ignore.self>
                                        <div class="card card-body mt-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <b class="text-danger">TOLAK PENCAIRAN</b>
                                                <a class="close" data-toggle="collapse" href="#tolakPencairan"
                                                    role="button" aria-expanded="false"
                                                    aria-controls="tolakPencairan">
                                                    <span aria-hidden="true">&times;</span>
                                                </a>
                                            </div>
                                            {{-- <div class="mt-2">
                                                <div class="card p-3 hover">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <em>Yang Menolak</em><br>
                                                            <span class="text-bold">Direktur Eksekutif -
                                                                {{ \App\Http\Controllers\Helper::getDataPengurusByJabatan('pc', 'Direktur Eksekutif')->nama ?? null }}</span><br>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <em>Tgl Penolakan</em><br>
                                                            <span
                                                                class="text-bold">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div> --}}
                                            <form wire:submit.prevent="tolakPencairan">
                                                <div class="form-row mt-1">
                                                    <div class="form-group col-md-12">
                                                        <label for="inputAlamat">ALASAN PENOLAKAN&nbsp;</label>
                                                        <sup class="badge badge-danger text-white mb-2"
                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                        <textarea type="text" class="form-control" wire:model="pencairan_note" placeholder="Masukan Keterangan"
                                                            rows="3"> </textarea>
                                                    </div>
                                                </div>
                                                {{-- tombol acc --}}
                                                <div class="d-flex float-right">
                                                    @if ($pencairan_note == '')
                                                        <button class="btn btn-danger btn-block" disabled
                                                            wire:loading.attr="disabled"><i class="fas fa-ban"></i>
                                                            TOLAK</button>
                                                    @else
                                                        <button type="submit" name="submit"
                                                            class="btn btn-danger hover"
                                                            wire:loading.attr="disabled"><i class="fas fa-ban"></i>
                                                            TOLAK</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <table class="table table-bordered mt-2">
                                        <thead>
                                            <tr>
                                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                    Tgl Respon
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    @if ($data_detail and $data_detail->pencairan_status == 'Berhasil Dicairkan')
                                                        {{ Carbon\Carbon::parse($data_detail->tgl_pencairan ?? null)->isoFormat('dddd, D MMMM Y') }}
                                                    @elseif($data_detail and $data_detail->pencairan_status == 'Ditolak')
                                                        {{ Carbon\Carbon::parse($data_detail->tgl_tolak_pencairan ?? null)->isoFormat('dddd, D MMMM Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- status --}}
                                            <tr>
                                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                    Status
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    @if ($data_detail and $data_detail->pencairan_status == 'Berhasil Dicairkan')
                                                        <b style="font-size: 12pt;" class="text-warning">
                                                            Bisa Dicairkan
                                                        </b>
                                                    @elseif ($data_detail and $data_detail->pencairan_status == 'Belum Direspon')
                                                        Belum Direpon
                                                    @elseif ($data_detail and $data_detail->pencairan_status == 'Ditolak')
                                                        <b style="font-size: 12pt;" class="text-danger">
                                                            Tidak Bisa Dicairkan
                                                        </b>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            {{-- petugas pentasyarufan --}}
                                            <tr>
                                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                    Direspon Oleh
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    @if ($data_detail and $data_detail->staf_keuangan_pc == null)
                                                        -
                                                    @else
                                                        {{ \App\Http\Controllers\Helper::getNamaPengurus('pc', $data_detail->staf_keuangan_pc ?? null) }}
                                                        <br>
                                                        <span style="font-size:11pt;">(
                                                            {{ \App\Http\Controllers\Helper::getJabatanPengurus('pc', $data_detail->staf_keuangan_pc ?? null) }}
                                                            )</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                    Keterangan
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    {{ $data_detail->pencairan_note ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                                    Sumber Dana
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    {{-- {{ $data_detail->id_rekening ?? '-' }} --}}
                                                    {{ \App\Http\Controllers\Helper::getDataRekening2($data_detail->id_rekening ?? null)->pluck('nama_rekening')->first() ?? null }}<br>
                                                    <span style="font-size:10pt;">
                                                        {{ \App\Http\Controllers\Helper::getDataRekening2($data_detail->id_rekening ?? null)->pluck('no_rekening')->first() ?? null }}
                                                        -
                                                        {{ \App\Http\Controllers\Helper::getNamaBmtByIdRekening($data_detail->id_rekening ?? null) ?? null }}
                                                    </span>
                                                </td>
                                            </tr>

                                        </thead>
                                    </table>
                                    {{-- <div class="card p-3 hover mt-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <em>Nominal Yang Bisa Dicairkan (Satuan)</em><br>
                                                <span class="text-bold text-warning">
                                                    {{ $this->numberFormat($data_detail->satuan_pencairan ?? null) }}
                                                </span>
                                            </div>
                                            <div class="col-md-6">
                                                <em>Nominal Yang Bisa Dicairkan (Total)</em><br>
                                                <span class="text-bold text-warning">
                                                    {{ $this->numberFormat($data_detail->nominal_pencairan ?? null) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <table>
                                                <tr>
                                                    <td style="width: 70%"> Nominal Satuan Bisa Dicairkan &nbsp; :
                                                    </td>
                                                    <td style="width: 30%"> <b style="font-size: 12pt;"
                                                            class="text-warning">
                                                            {{ $this->numberFormat($data_detail->satuan_pencairan ?? null) }}
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 70%"> Jumlah Nominal Bisa Dicairkan &nbsp;: </td>
                                                    <td style="width: 30%"> <b style="font-size: 12pt;"
                                                            class="text-warning">
                                                            {{ $this->numberFormat($data_detail->nominal_pencairan ?? null) }}
                                                        </b>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
