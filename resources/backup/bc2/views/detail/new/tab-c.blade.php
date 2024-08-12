<div class="row">
    {{-- @if (Auth::user()->gocap_id_pc_pengurus != null and Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
        <a wire:click="buat_no_rekomendasi('upzis')" class="btn btn-sm btn-outline-success float-left hover ml-2"
            role="button" style="border-radius:10px; ">Buat
            Nomor Upzis
        </a>
        <a wire:click="buat_no_rekomendasi('ranting')" class="btn btn-sm btn-outline-success float-left hover ml-2"
            role="button" style="border-radius:10px; ">Buat
            Nomor Ranting
        </a>
    @endif --}}
    
    

    <div class="col col-md-12 col-sm-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <b>LEMBAR REKOMENDASI</b>
                <p class="intro-detail-data-pengajuan-status-lembar-rekomendasi d-inline">
                    @if ($data->status_rekomendasi == 'Belum Terbit')
                        <sup class="badge badge-danger text-white bg-secondary mb-2 hover">Belum Terbit</sup>
                    @else
                        <sup class="badge  text-white bg-success mb-2 hover">Sudah Terbit</sup>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="col col-md-6 col-sm-12">
        <div class="card mt-2">
            <div class="card-body">
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="d-flex  align-items-center">
                            <div>
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="ml-2">
                                @if ($data->status_rekomendasi == 'Belum Terbit')
                                    @if (Auth::user()->gocap_id_pc_pengurus)
                                        Berikan respon semua data pada daftar rencana program,
                                        lalu terbitkan rekomendasi.
                                    @else
                                        Harap tunggu Lazisnu merespon semua rencana & menerbitkan
                                        lembar rekomendasi
                                    @endif
                                @elseif($data->status_rekomendasi == 'Sudah Terbit')
                                    Lembar rekomendasi sudah diterbitkan
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- alert --}}
                @if (session()->has('alert_rekomendasi'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('alert_rekomendasi') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session()->has('alert_notif'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{-- <i class="far fa-check-circle"></i> --}}
                        {{ session('alert_notif') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>

                            <tr class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                <td class="text-bold" style="width: 40%;">Lembar Rekomendasi
                                </td>
                                <td>
                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                        @if ($data->status_rekomendasi == 'Sudah Terbit')
                                            <a href="/upzis/rekomendasi/bmt/{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                                target="_blank" class="btn btn-sm btn-outline-success float-left hover"
                                                role="button" style="border-radius:10px; ">
                                                Download BMT
                                            </a>

                                            <a href="/upzis/rekomendasi/bri/{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-success float-left hover ml-2"
                                                role="button" style="border-radius:10px; ">
                                                Download BRI
                                            </a>
                                        @else
                                            <a href="/upzis/rekomendasi/bmt/{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary float-left hover"
                                                role="button" style="border-radius:10px; ">Preview BMT
                                            </a>
                                            <a href="/upzis/rekomendasi/bri/{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-primary float-left hover ml-2"
                                                role="button" style="border-radius:10px; ">Preview BRI
                                            </a>
                                        @endif
                                    @endif
                                    @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                        @if ($data->status_rekomendasi == 'Sudah Terbit')
                                            <a href="/upzis/rekomendasi/bmt/{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                                target="_blank" class="btn btn-sm btn-outline-success float-left hover"
                                                role="button" style="border-radius:10px; ">Download BMT
                                            </a>

                                            <a href="/upzis/rekomendasi/bri/{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-success float-left hover ml-2"
                                                role="button" style="border-radius:10px; ">Download BRI
                                            </a>
                                        @else
                                            -
                                        @endif
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold" style="width: 40%;">Tgl Terbit Rekomendasi
                                </td>
                                <td>
                                    @if ($data->tgl_terbit_rekomendasi == null)
                                        -
                                    @else
                                        {{ Carbon\Carbon::parse($data->tgl_terbit_rekomendasi)->isoFormat('dddd, D MMMM Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 40%;">Direkomendasikan Oleh
                                </td>
                                <td>
                                    @if ($data->direkomendasikan_oleh_pc == null)
                                        -
                                    @else
                                        {{ \App\Http\Controllers\Helper::getNamaPengurus('pc', $data->direkomendasikan_oleh_pc) }}<br>
                                        <span style="font-size:11pt;">
                                            (
                                            {{ \App\Http\Controllers\Helper::getJabatanPengurus('pc', $data->direkomendasikan_oleh_pc) }}
                                            )</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 40%;">KELEMBAGAAN
                                </td>
                                <td>
                                    {{ $this->numberFormat($this->totalByProgram('ba84d782-81a8-11ed-b4ef-dc215c5aad51')['jumlah']) }}
                                    <br>
                                    <span style="font-size:11pt;">
                                        ({{ $this->totalByProgram('ba84d782-81a8-11ed-b4ef-dc215c5aad51')['respon'] }}
                                        dari
                                        {{ $this->totalByProgram('ba84d782-81a8-11ed-b4ef-dc215c5aad51')['total'] }}
                                        rencana telah direspon)</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 40%;">PROGRAM SOSIAL
                                </td>
                                <td>
                                    {{ $this->numberFormat($this->totalByProgram('bed10d9c-81a8-11ed-b4ef-dc215c5aad51')['jumlah']) }}
                                    <br>
                                    <span style="font-size:11pt;">
                                        ({{ $this->totalByProgram('bed10d9c-81a8-11ed-b4ef-dc215c5aad51')['respon'] }}
                                        dari
                                        {{ $this->totalByProgram('bed10d9c-81a8-11ed-b4ef-dc215c5aad51')['total'] }}
                                        rencana telah direspon)</span>
                                </td>
                            </tr>
                            @if ($data->tingkat == 'Upzis MWCNU')
                                <tr>
                                    <td class="text-bold" style="width: 40%;">DANA OPERASIONAL
                                    </td>
                                    <td>
                                        {{ $this->numberFormat($this->totalByProgram('c51700b1-81a8-11ed-b4ef-dc215c5aad51')['jumlah']) }}
                                        <br>
                                        <span style="font-size:11pt;">
                                            ({{ $this->totalByProgram('c51700b1-81a8-11ed-b4ef-dc215c5aad51')['respon'] }}
                                            dari
                                            {{ $this->totalByProgram('c51700b1-81a8-11ed-b4ef-dc215c5aad51')['total'] }}
                                            rencana telah direspon)</span>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-bold" style="width: 40%;">TOTAL
                                </td>
                                <td>
                                    <b style="font-size:12pt;">
                                        {{ $this->numberFormat(
                                            $this->totalByProgram('ba84d782-81a8-11ed-b4ef-dc215c5aad51')['jumlah'] +
                                                $this->totalByProgram('bed10d9c-81a8-11ed-b4ef-dc215c5aad51')['jumlah'] +
                                                $this->totalByProgram('c51700b1-81a8-11ed-b4ef-dc215c5aad51')['jumlah'],
                                        ) }}
                                    </b>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <em>Format berkas otomatis berdasarkan respon persetujuan yang telah diinputkan</em><br>
            </div>
        </div>
    </div>
    {{-- ffbbbb --}}

    <div class="col col-md-6 col-sm-12">

        @if (Auth::user()->gocap_id_pc_pengurus != null and
                Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
            @if ($data->status_rekomendasi == 'Belum Terbit')
                @if ($data->status_pengajuan == 'Diajukan' and $this->responValidation() == 1)
                    <div class="callout callout-success mt-2">
                        <span style="font-size: 12pt;" class="text-bold"><i class="fas fa-check-circle mr-1"></i>Semua
                            rencana telah direspon,
                            terbitkan rekomendasi?
                        </span>
                        <br>
                        <button class="btn btn-sm btn-secondary hover mt-2" data-toggle="collapse"
                            data-target="#rekomendasi" aria-expanded="false" aria-controls="rekomendasi">
                            Klik Disini</button>
                    </div>
                @else
                    <div class="callout callout-danger mt-2">
                        <span style="font-size: 12pt;" class="text-bold"><i
                                class="icon fas fa-exclamation-triangle mr-1"></i>Ada beberapa rencana yang belum
                            direspon, belum bisa menerbitkan rekomendasi
                        </span>
                    </div>
                @endif
            @else
                <div class="callout callout-success mt-2">
                    <span style="font-size: 12pt;" class="text-bold"><i class="fas fa-check-circle mr-1"></i>Rekomendasi
                        sudah diterbitkan
                    </span>
                    <br>
                    <button class="btn btn-sm btn-secondary hover mt-2" data-toggle="collapse"
                        data-target="#batalRekomendasi" aria-expanded="false" aria-controls="batalRekomendasi">
                        Batalkan Rekomendasi?</button>
                </div>
            @endif
        @elseif(Auth::user()->gocap_id_pc_pengurus != null and $data->status_rekomendasi == 'Sudah Terbit')
            <div class="callout callout-success mt-2">
                <span style="font-size: 12pt;" class="text-bold"><i class="fas fa-check-circle mr-1"></i>Rekomendasi
                    sudah diterbitkan
                </span>
            </div>
        @endif

        <div class="collapse mt-2" id="batalRekomendasi">
            <div class="card card-body" style="background-color:#ffbbbb">
                <span class=" text-bold">
                    <em>Setelah dibatalkan arus dana akan dihapus dan saldo dikembalikan ke rekening. Lalu bisa
                        dilakukan
                        respon ulang </em>
                </span>
                <div class="float-left mt-1">
                    <button wire:click="batalRekomendasi('{{ $data->id_pengajuan ?? null }}')"
                        class="btn btn-sm btn-danger hover"><i class="fas fa-check-circle"></i>
                        Iya, Saya Ingin Membatalkan Rekomendasi Ini</button>
                </div>
                <div class="ml-auto mr-1">
                    <div wire:loading>
                        Dalam Proses Menghapus Arus Dana Rekening, Harap Tunggu....
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->gocap_id_pc_pengurus != null)
            @if ($data->status_rekomendasi == 'Sudah Terbit')
                <div class="callout callout-success mt-2">
                    <span style="font-size: 12pt;" class="text-bold"> <i class="fas fa-info-circle mr-1"></i>
                        {{ $data->notif_rekomendasi == '0' ? 'Dana Sudah Bisa Dicairkan?' : 'Dana Sudah Bisa Dicairkan, Notifikasi Sudah Terkirim' }}
                    </span>
                    <br>
                    @if (Auth::user()->gocap_id_pc_pengurus != null and
                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '3b5ce3c4-a045-11ed-a0ac-040300000000')
                        <button wire:click="sendNotifWa()" class="btn btn-sm btn-secondary hover mt-2"
                            data-toggle="collapse" data-target="#rekomendasi" aria-expanded="false"
                            aria-controls="rekomendasi">
                            {{ $data->notif_rekomendasi == '0' ? 'Kirim Notif' : 'Kirim Ulang Notif' }}
                        </button>
                    @endif
                </div>
            @endif
        @endif
        
        @php
            $jumlah_lpj = app\Http\Controllers\DetailPengajuanController::detailPenyaluran($data->id_pengajuan)['belum'];
        @endphp

        @if (Auth::user()->gocap_id_pc_pengurus != null)
            @if ($data->status_rekomendasi == 'Sudah Terbit')
                <div class="callout callout-success mt-2">
                    <span style="font-size: 12pt;" class="text-bold"> <i class="fas fa-info-circle mr-1"></i>
                        @if ($jumlah_lpj != 0)
                            @if ($data->notif_lpj == '0')
                                <span>{{ $jumlah_lpj }}
                                    Program Pentasyarufan Belum LPJ</span>
                            @else
                                <span>{{ $jumlah_lpj }}
                                    Program Belum LPJ, Notifikasi Sudah Terkirim</span>
                            @endif
                        @else
                            <span> Semua Program Pentasyarufan Sudah LPJ</span>
                        @endif
                    </span>
                    <br>
                    @if (Auth::user()->gocap_id_pc_pengurus != null and
                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')
                        @if ($jumlah_lpj != 0)
                        <button wire:click="kirimNotifWa()" class="btn btn-sm btn-secondary hover mt-2"
                            data-toggle="collapse" data-target="#rekomendasi" aria-expanded="false"
                            aria-controls="rekomendasi">
                            {{ $data->notif_lpj == '0' ? 'Kirim Notif LPJ' : 'Kirim Ulang Notif LPJ' }}
                        </button>
                        @endif
                    @endif
                </div>
            @endif
        @endif

        @if ($data->status_rekomendasi == 'Belum Terbit')
            <div class="collapse mt-2" id="rekomendasi">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <em>Setelah terbit rekomendasi, otomatis tercatat arus dana & pengurangan saldo pada
                                sumber
                                dana
                                yang dipilih</em>
                        </div>

                        @if (count($this->getListRekeningRencana('bmt')) > 0)
                            <span class="text-bold   mt-1 mb-1  ml-1">
                                Sumber Dana BMT
                            </span>
                        @endif
                        @foreach ($this->getListRekeningRencana('bmt') as $a)
                            <div class="col-md-12">
                                <div class="card p-3">

                                    <span class="text-bold">
                                        {{ \App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('nama_rekening')->first() ?? '-' }}
                                    </span>
                                    <span style="font-size:10pt;">
                                        {{ \App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('no_rekening')->first() ?? '-' }}
                                        -
                                        {{ \App\Http\Controllers\Helper::getNamaBmtByIdRekening($a->id_rekening ?? null) ?? '-' }}
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Saldo Awal <br>
                                            <em>
                                                {{ $this->numberFormat(\App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('saldo')->first()) }}
                                            </em>
                                        </div>
                                        <div class="col-md-4">
                                            Pentasyarufan <br>
                                            <em>
                                                {{ $this->numberFormat($this->totalByIdRekening($a->id_rekening)) }}
                                            </em>
                                        </div>
                                        <div class="col-md-4">
                                            Saldo Akhir <br>
                                            <em>
                                                {{ $this->numberFormat(\App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('saldo')->first() - $this->totalByIdRekening($a->id_rekening)) }}
                                            </em>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if (count($this->getListRekeningRencana('bri')) > 0)
                            <span class="text-bold mt-1 mb-1 ml-2">
                                Sumber Dana BRI
                            </span>
                        @endif
                        @foreach ($this->getListRekeningRencana('bri') as $a)
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <span class="text-bold">
                                        {{ \App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('nama_rekening')->first() ?? '-' }}
                                    </span>
                                    <span style="font-size:10pt;">
                                        {{ \App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('no_rekening')->first() ?? '-' }}
                                        -
                                        {{ \App\Http\Controllers\Helper::getNamaBmtByIdRekening($a->id_rekening ?? null) ?? '-' }}
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Saldo Awal <br>
                                            <em>
                                                {{ $this->numberFormat(\App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('saldo')->first()) }}
                                            </em>
                                        </div>
                                        <div class="col-md-4">
                                            Pentasyarufan <br>
                                            <em>
                                                {{ $this->numberFormat($this->totalByIdRekening($a->id_rekening)) }}
                                            </em>
                                        </div>
                                        <div class="col-md-4">
                                            Saldo Akhir <br>
                                            <em>
                                                {{ $this->numberFormat(\App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('saldo')->first() - $this->totalByIdRekening($a->id_rekening)) }}
                                            </em>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="ml-auto mr-1">
                            <div wire:loading>
                                Dalam Proses Mutasi Rekening, Harap Tunggu....
                            </div>
                            <div wire:loading.remove>
                                <button wire:click="rekomendasi" class="btn btn-success hover"><i
                                        class="fas fa-check-circle"></i>
                                    Terbitkan Rekomendasi</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @elseif($data->status_rekomendasi == 'Sudah Terbit')
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <em>Informasi Arus Dana Rekening :</em>
                    </div>

                    @if (count($this->getListRekeningRencana('bmt')) > 0)
                        <span class="text-bold   mt-1 mb-1  ml-1">
                            Sumber Dana BMT
                        </span>
                    @endif
                    @foreach ($this->getListRekeningRencana('bmt') as $a)
                        <div class="col-md-12">
                            <div class="card p-3">

                                <span class="text-bold">
                                    {{ \App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('nama_rekening')->first() ?? '-' }}
                                </span>
                                <span style="font-size:10pt;">
                                    {{ \App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('no_rekening')->first() ?? '-' }}
                                    -
                                    {{ \App\Http\Controllers\Helper::getNamaBmtByIdRekening($a->id_rekening ?? null) ?? '-' }}
                                </span>
                                <div class="row">

                                    <div class="col-md-6">
                                        Pentasyarufan <br>
                                        <em>
                                            {{ $this->numberFormat($this->totalByIdRekening($a->id_rekening)) }}
                                        </em>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $this->getTotalProgramByIdRekening($a->id_rekening) }}
                                        Program
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if (count($this->getListRekeningRencana('bri')) > 0)
                        <span class="text-bold mt-1 mb-1 ml-2">
                            Sumber Dana BRI
                        </span>
                    @endif
                    @foreach ($this->getListRekeningRencana('bri') as $a)
                        <div class="col-md-12">
                            <div class="card p-3">

                                <span class="text-bold">
                                    {{ \App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('nama_rekening')->first() ?? '-' }}
                                </span>
                                <span style="font-size:10pt;">
                                    {{ \App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('no_rekening')->first() ?? '-' }}
                                    -
                                    {{ \App\Http\Controllers\Helper::getNamaBmtByIdRekening($a->id_rekening ?? null) ?? '-' }}
                                </span>
                                <div class="row">

                                    <div class="col-md-6">
                                        Pentasyarufan <br>
                                        <em>
                                            {{ $this->numberFormat($this->totalByIdRekening($a->id_rekening)) }}
                                        </em>
                                    </div>
                                    <div class="col-md-6">
                                        {{ $this->getTotalProgramByIdRekening($a->id_rekening) }}
                                        Program
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach



                </div>
            </div>

        @endif

    </div>

</div>
