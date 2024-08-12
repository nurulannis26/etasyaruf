<div class="row">


    {{-- card rencana pentasyarufan --}}
    <div class="col col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body modal-detail-rencana-pentasyarufan">

                {{-- judul --}}
                <div class="d-flex align-items-center">
                    <i class="fas fa-clipboard-list"></i><b class="ml-2"> RENCANA
                        PENTASYARUFAN</b>
                </div>
                {{-- end judul --}}

                <div class="row">
                    <div class="col col-md-6 col-sm-12">
                        @if ($detail_a != null)
                            {{-- tabel --}}
                            <table class="table table-bordered mt-2">
                                <thead>
                                    {{-- petugas pentasyarufan --}}
                                    <tr>
                                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                            Petugas<br>
                                            Pentasyarufan
                                        </td>
                                        <td style="vertical-align: middle;">

                                            @if ($data->tingkat == 'Upzis MWCNU')
                                                {{ $this->nama_pengurus_upzis($detail_a->petugas_upzis) }}
                                                <br>
                                                <span style="font-size:11pt;">(
                                                    {{ $this->jabatan_pengurus_upzis($detail_a->petugas_upzis) }}
                                                    -
                                                    {{ $this->nama_upzis($data->id_upzis) }})</span>
                                            @endif

                                            @if ($data->tingkat == 'Ranting NU')
                                                {{ $this->nama_pengurus_upzis($detail_a->petugas_ranting) }}
                                                <br>
                                                <span style="font-size:11pt;">(
                                                    {{ $this->jabatan_pengurus_upzis($detail_a->petugas_ranting) }}
                                                    -
                                                    {{ $this->nama_ranting($data->id_ranting) }})</span>
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- end petugas pentasyaruan --}}

                                    {{-- program & pilar --}}
                                    <tr>
                                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                            Pilar
                                        </td>
                                        <td style="vertical-align: middle;">
                                            {{ $this->nama_pilar($detail_a->id_program_pilar) }}
                                        </td>
                                    </tr>
                                    {{-- end program & pilar --}}

                                    {{-- kegiatan --}}
                                    <tr>
                                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                            Jenis Program
                                        </td>
                                        <td style="vertical-align: middle;">
                                            {{ $this->nama_kegiatan($detail_a->id_program_kegiatan) }}
                                        </td>
                                    </tr>
                                    {{-- end kegiatan --}}

                                    {{-- Keterangan --}}
                                    <tr>
                                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                            Keterangan
                                        </td>
                                        <td style="vertical-align: middle;">

                                            {{ $detail_a->pengajuan_note ? $detail_a->pengajuan_note : '-' }}
                                        </td>
                                    </tr>
                                    {{-- Keterangan --}}







                                </thead>
                            </table>
                            {{-- end tabel --}}
                        @endif

                    </div>
                    <div class="col col-md-6 col-sm-12">
                        {{-- info --}}
                        <div class="card mt-2">
                            <div class="card-body">
                                @if ($detail_a != null)
                                    <table>
                                        <tr>
                                            <td style="width: 50%"> Penerima Manfaat</td>
                                            <td style="width: 50%">: {{ $detail_a->nama_penerima }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"> Jumlah Penerima Manfaat</td>
                                            <td style="width: 50%">: {{ $detail_a->jumlah_penerima }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"> Nominal Satuan Diajukan</td>
                                            <td>: <b
                                                    style="font-size: 12pt;">Rp{{ number_format($detail_a->satuan_pengajuan, 0, '.', '.') }},-</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%"> Jumlah Nominal Diajukan</td>
                                            <td>: <b
                                                    style="font-size: 12pt;">Rp{{ number_format($detail_a->nominal_pengajuan, 0, '.', '.') }},-</b>
                                            </td>
                                        </tr>
                                    </table>
                                @endif
                                {{-- Jumlah Penerima Manfaat : 10<br>
                Satuan Nonimal Diajukan &nbsp;&nbsp;: Rp250.000<br>
                Jumlah Nominal Diajukan &nbsp;&nbsp;: Rp2.500.000 --}}
                            </div>
                        </div>
                        {{-- end info --}}
                    </div>
                </div>



            </div>
        </div>
    </div>
    {{-- end card rencana pentsyarufan --}}

    {{-- card rencana pentasyarufan --}}
    <div class="col col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body modal-detail-persetujuan-pc-lazisnu">

                {{-- judul --}}
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-clipboard-check"></i><b class="ml-2"> STATUS PERSETUJUAN
                        </b>
                    </div>
                    {{-- tombol acc tolak --}}

                    @if ($detail_a != null)

                        @if (Auth::user()->gocap_id_pc_pengurus != null and
                                $data->tgl_konfirmasi != null and
                                $data->status_rekomendasi == 'Belum Terbit' and
                                ($detail_a->pencairan_status == null or $detail_a->pencairan_status == 'Belum Dicairkan'))
                            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
                                <div>
                                    <div class="btn-group float-right">
                                        <button type="button" class="btn" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"
                                            style="background-color: #cccccc">Respon</button>
                                        <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            style="background-color: #cccccc">
                                            <span class="sr-only">Toggle
                                                Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu ">
                                            <a wire:click="tombol_acc('{{ $id_pengajuan_detail }}')"
                                                onMouseOver="this.style.color='green'"
                                                onMouseOut="this.style.color='black'" class="dropdown-item"
                                                data-toggle="modal" data-target="#modal_acc" type="button"><i
                                                    class="fas fa-user-check"></i>
                                                @if ($detail_a->approval_status == 'Ditolak' or $detail_a->approval_status == 'Disetujui')
                                                    ACC Ulang
                                                @else
                                                    ACC
                                                @endif
                                            </a>
                                            <a wire:click="tombol_tolak" onMouseOver="this.style.color='red'"
                                                onMouseOut="this.style.color='black'" class="dropdown-item"
                                                data-toggle="modal" data-target="#modal_tolak" type="button"><i
                                                    class="fas fa-ban"></i>
                                                Tolak</a>
                                        </div>
                                    </div>
                                </div>

                            @endif
                        @endif
                    @endif
                    {{-- end tombol acc tolak --}}

                </div>
                {{-- end judul --}}

                {{-- alert --}}
                @if (session()->has('alert_persetujuan'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('alert_persetujuan') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($detail_a != null)
                    @if (Auth::user()->gocap_id_pc_pengurus != null and
                            $data->tgl_konfirmasi == null and
                            $data->status_rekomendasi == 'Belum Terbit' and
                            ($detail_a->approval_status == 'Ditolak' or $detail_a->approval_status == 'Belum Direspon'))
                        @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
                            <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                <div class="d-flex justify-content-between">
                                    <div class="mt-2">
                                        <i class="fas fa-minus-circle"></i>
                                    </div>
                                    <div class="ml-2">
                                        ACC belum bisa dilakukan, Harap tunggu UPZIS MWCNU Kesugihan melakukan
                                        konfirmasi lembar
                                        pengajuan
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endif
                @endif


                {{-- end alert --}}

                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    {{-- card acc --}}
                    <div class="card card-body mt-3" style="display: {{ $none_block_acc }};">

                        <div class="d-flex justify-content-between align-items-center">
                            <b class="text-success">ACC PENGAJUAN</b>
                            <a wire:click="close" type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>
                        {{-- alert --}}
                        {{-- @if ($id_rekening != null)
                            @if (str_replace('.', '', $nominal_disetujui) > str_replace('.', '', $saldo))
                                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                    <i class="fas fa-minus-circle"></i>
                                    Saldo Tidak Cukup!
                                </div>
                            @endif

                        @endif
                        @if ($detail_a != null)
                            @if (str_replace('.', '', $satuan_disetujui) > str_replace('.', '', $detail_a->satuan_pengajuan))
                                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                    <i class="fas fa-minus-circle"></i>
                                    Nominal disetujui melebihi nominal diajukan
                                </div>
                            @endif
                        @endif --}}
                        {{-- end alert --}}


                        <form wire:submit.prevent="acc">
                            <div class="form-row mt-3">

                                {{-- form --}}

                                {{-- Direktur --}}
                                @if (Auth::user()->gocap_id_pc_pengurus != null)
                                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
                                        <div class="form-group col-md-8">
                                            <input type="input" class="form-control"
                                                value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                                                readonly>
                                        </div>
                                    @endif
                                @endif
                                {{-- end rekening --}}

                                {{-- tgl disetujui --}}
                                <div class="form-group col-md-4">
                                    <input wire:model="approval_date" type="date" class="form-control" readonly
                                        placeholder="Tgl Disetujui">
                                </div>
                                {{-- end tgl disetujui --}}



                                {{-- saldo --}}
                                {{-- <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saldo
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            value="@foreach ($rekening as $a){{ number_format($a->saldo, 0, '.', '.') }} @endforeach"
                                            disabled>

                                    </div>
                                </div> --}}
                                {{-- end saldo --}}


                                {{-- satuan disetujui --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Nominal
                                                Disetujui
                                                (Satuan)</span>
                                        </div>
                                        <input wire:model="satuan_disetujui" type="text" class="form-control"
                                            id="satuan_disetujui" placeholder="Masukan Nominal Satuan Disetujui">

                                    </div>
                                </div>
                                {{-- end satuan disetujui --}}


                                @if ($detail_a != null)
                                    {{-- nominal disetujui --}}
                                    <div class="form-group col-md-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">&nbsp;&nbsp;Nominal
                                                    Disetujui
                                                    (Total)&nbsp;&nbsp;</span>
                                            </div>
                                            <input wire:model="nominal_disetujui" type="input"
                                                class="form-control text-bold" disabled id="nominal_disetujui"
                                                placeholder="Masukan Nominal Satuan Disetujui">
                                            <div class="input-group-append">
                                                <span class="input-group-text">(Rp{{ $satuan_disetujui }} x
                                                    {{ $detail_a->jumlah_penerima }}
                                                    ) </span>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end satuan disetujui --}}


                                    <div class="form-group col-md-12">
                                        <label for="inputAlamat">KETERANGAN&nbsp;</label>

                                        <textarea type="text" class="form-control" wire:model="approval_note" placeholder="Masukan Keterangan"
                                            rows="4"> </textarea>
                                    </div>
                                @endif


                                {{-- <div class="form-group col-md-12">
                                    <input type="input" class="form-control" value="{{ $nama_bmt }}" readonly>
                                </div> --}}


                                {{-- Direktur --}}
                                {{-- <div class="form-group col-md-8"> --}}
                                {{-- <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input value="{{ $saldo }}" type="input" class="form-control"
                                            readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Saldo
                                                Rekening</span>
                                        </div>
                                    </div> --}}
                                {{-- </div> --}}
                                {{-- end rekening --}}


                                {{-- tombol acc --}}
                                <div class="form-group
                                col-md-4">

                                    @if ($approval_date == '' or $satuan_disetujui == '')
                                        <button class="btn btn-success btn-block" disabled
                                            wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                            ACC</button>
                                    @else
                                        <button type="submit" name="submit" class="btn btn-success btn-block"
                                            wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                            ACC</button>
                                    @endif

                                </div>
                                {{-- acc --}}


                            </div>
                        </form>
                    </div>
                    {{-- end card acc --}}

                    {{-- card tolak --}}
                    <div class="card card-body mt-3" style="display: {{ $none_block_tolak }};">

                        <div class="d-flex justify-content-between align-items-center">
                            <b class="text-danger">TOLAK PENGAJUAN</b>
                            <a wire:click="close" type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>


                        <form wire:submit.prevent="tolak">

                            <div class="form-row mt-3">




                                {{-- Direktur --}}
                                <div class="form-group col-md-8">
                                    <input type="input" class="form-control"
                                        value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                                        readonly>
                                </div>
                                {{-- end rekening --}}

                                {{-- tgl disetujui --}}
                                <div class="form-group col-md-4">
                                    <input wire:model="denial_date" type="date" class="form-control" readonly
                                        placeholder="Tgl Disetujui">
                                </div>
                                {{-- end tgl disetujui --}}


                                {{-- denial date --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Alasan</span>
                                        </div>
                                        <input wire:model="denial_note" type="input" class="form-control"
                                            placeholder="Masukan Alasan Penolakan">
                                    </div>
                                </div>
                                {{-- end denial date --}}

                                <div class="form-group col-md-8">
                                </div>


                                {{-- tombol tolak --}}
                                <div class="form-group col-md-4">
                                    @if ($denial_date == '' or $denial_note == '')
                                        <button class="btn btn-danger btn-block" disabled
                                            wire:loading.attr="disabled"><i class="fas fa-minus-circle"></i>
                                            TOLAK</button>
                                    @else
                                        <button type="submit" name="submit" class="btn btn-danger btn-block"
                                            wire:loading.attr="disabled"><i class="fas fa-minus-circle"></i>
                                            TOLAK</button>
                                    @endif
                                </div>
                                {{-- tolak --}}


                            </div>
                        </form>
                    </div>
                    {{-- end card tolak --}}
                @endif

                @if ($detail_a != null)
                    {{-- tabel --}}
                    <table class="table table-bordered mt-2">
                        <thead>

                            {{-- tanggal disetujui --}}
                            <tr>
                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                    Tgl
                                    Respon
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($detail_a->approval_status == 'Disetujui')
                                        @if ($detail_a->approval_date == null)
                                            -
                                        @else
                                            {{ Carbon\Carbon::parse($detail_a->approval_date)->isoFormat('dddd, D MMMM Y') }}
                                        @endif
                                    @elseif($detail_a->approval_status == 'Ditolak')
                                        {{ Carbon\Carbon::parse($detail_a->denial_date)->isoFormat('dddd, D MMMM Y') }}
                                    @else
                                        -

                                    @endif

                                </td>
                            </tr>
                            {{-- end tanggal disetujui --}}

                            {{-- status --}}
                            <tr>
                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                    Status
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($detail_a->approval_status == 'Disetujui')
                                        <b style="font-size: 12pt;" class="text-success">
                                            {{ $detail_a->approval_status }}
                                        </b>
                                    @elseif($detail_a->approval_status == 'Ditolak')
                                        <b style="font-size: 12pt;" class="text-danger">
                                            {{ $detail_a->approval_status }}
                                        </b>
                                    @else
                                        {{ $detail_a->approval_status }}
                                    @endif

                                </td>
                            </tr>
                            {{-- end status --}}

                            {{-- petugas pentasyarufan --}}
                            <tr>
                                @if ($detail_a->approval_status == 'Disetujui' or $detail_a->approval_status == 'Belum Direspon')
                                    <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                        Disetujui Oleh
                                    </td>
                                    <td style="vertical-align: middle;">
                                        @if ($detail_a->approver_tingkat_pc == null)
                                            -
                                        @else
                                            {{ $this->nama_pengurus_pc($detail_a->approver_tingkat_pc) }}
                                            <br>
                                            <span
                                                style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($detail_a->approver_tingkat_pc) }}
                                                - {{ $this->nama_pc($data->id_pc) }})</span>
                                        @endif
                                    </td>
                                @elseif($detail_a->approval_status == 'Ditolak')
                                    <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                        Ditolak Oleh
                                    </td>
                                    <td style="vertical-align: middle;">
                                        @if ($detail_a->denial_tingkat_pc == null)
                                            -
                                        @else
                                            {{ $this->nama_pengurus_pc($detail_a->denial_tingkat_pc) }}
                                            <br>
                                            <span
                                                style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($detail_a->denial_tingkat_pc) }}
                                                - {{ $this->nama_pc($data->id_pc) }})</span>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                            {{-- end petugas pentasyaruan --}}

                            @if ($detail_a->approval_status == 'Ditolak')
                                {{-- alasan penolakan --}}
                                <tr>
                                    <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                        Alasan Penolakan
                                    </td>
                                    <td style="vertical-align: middle;">
                                        {{ $detail_a->denial_note }}
                                    </td>
                                </tr>
                                {{-- end alasan penolakan --}}
                            @else
                                <tr>
                                    <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                        Keterangan
                                    </td>
                                    <td style="vertical-align: middle;">
                                        @if ($detail_a->approval_note == null)
                                            -
                                        @else
                                            {{ $detail_a->approval_note }}
                                        @endif
                                    </td>
                                </tr>
                            @endif

                        </thead>
                    </table>
                    {{-- end tabel --}}
                @endif

                {{-- info --}}
                <div class="card mt-2">
                    <div class="card-body">
                        @if ($detail_a != null)
                            <table>

                                <tr>
                                    <td style="width: 60%"> Nominal Satuan Disetujui &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                    </td>
                                    <td style="width: 40%"> <b style="font-size: 12pt;" class="text-success">
                                            @if ($detail_a->approval_status == 'Disetujui' or $detail_a->approval_status == 'Belum Direspon')
                                                Rp{{ number_format($detail_a->satuan_disetujui, 0, '.', '.') }},-
                                            @else
                                                -
                                            @endif
                                        </b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 60%"> Jumlah Nominal Disetujui &nbsp;&nbsp;&nbsp; : </td>
                                    <td style="width: 40%"> <b style="font-size: 12pt;" class="text-success">
                                            @if ($detail_a->approval_status == 'Disetujui' or $detail_a->approval_status == 'Belum Direspon')
                                                Rp{{ number_format($detail_a->nominal_disetujui, 0, '.', '.') }},-
                                            @else
                                                -
                                            @endif
                                        </b>
                                    </td>
                                </tr>
                            </table>
                        @endif
                    </div>
                </div>
                {{-- end info --}}

            </div>
        </div>
    </div>
    {{-- end card rencana pentsyarufan --}}

    {{-- card rencana pentasyarufan --}}
    <div class="col col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body modal-detail-persetujuan-pc-lazisnu">

                {{-- judul --}}
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-clipboard-check"></i><b class="ml-2"> STATUS PENCAIRAN</b>
                    </div>
                    {{-- tombol acc tolak --}}

                    @if ($detail_a != null)
                        @if (Auth::user()->gocap_id_pc_pengurus != null)

                            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3' or
                                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '3b5ce3c4-a045-11ed-a0ac-040300000000' and
                                        $detail_a->approval_status == 'Disetujui' and
                                        $data->status_rekomendasi == 'Belum Terbit')
                                <div>
                                    <div class="btn-group float-right">
                                        <button type="button" class="btn" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"
                                            style="background-color: #cccccc">Respon</button>
                                        <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            style="background-color: #cccccc">
                                            <span class="sr-only">Toggle
                                                Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu ">
                                            <a wire:click="tombol_cair('{{ $id_pengajuan_detail }}')"
                                                onMouseOver="this.style.color='green'"
                                                onMouseOut="this.style.color='black'" class="dropdown-item"
                                                data-toggle="modal" type="button"><i class="fas fa-user-check"></i>
                                                @if ($detail_a->pencairan_status == 'Berhasil Dicairkan')
                                                    Respon Ulang
                                                @elseif($detail_a->pencairan_status == 'Belum Dicairkan' or $detail_a->pencairan_status == null)
                                                    Respon
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                    {{-- end tombol acc tolak --}}

                </div>
                {{-- end judul --}}

                {{-- alert --}}
                @if (session()->has('alert_pencairan'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('alert_pencairan') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($detail_a != null)
                    @if (Auth::user()->gocap_id_pc_pengurus != null)

                        @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3' or
                                Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '3b5ce3c4-a045-11ed-a0ac-040300000000' and
                                    $detail_a->approval_status != 'Disetujui')
                            <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                <div class="d-flex justify-content-between">
                                    <div class="mt-2">
                                        <i class="fas fa-minus-circle"></i>
                                    </div>
                                    <div class="ml-2">
                                        Pencairan belum bisa dilakukan, Harap tunggu Direktur melakukan ACC terlebih
                                        dahulu
                                    </div>

                                </div>
                            </div>
                            {{-- end alert --}}
                        @endif
                    @endif
                @endif

                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    {{-- card cair --}}
                    <div class="card card-body mt-3" style="display: {{ $none_block_cair }};">

                        <div class="d-flex justify-content-between align-items-center">
                            <b class="text-success">PENCAIRAN</b>
                            <a wire:click="close" type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </a>
                        </div>

                        <form wire:submit.prevent="cairkan">
                            <div class="form-row mt-3">

                                {{-- form --}}

                                {{-- Direktur --}}
                                @if (Auth::user()->gocap_id_pc_pengurus != null)
                                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3' or
                                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '3b5ce3c4-a045-11ed-a0ac-040300000000')
                                        <div class="form-group col-md-8">
                                            <input type="input" class="form-control"
                                                value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                                                readonly>
                                        </div>
                                    @endif
                                @endif
                                {{-- end rekening --}}

                                {{-- tgl disetujui --}}
                                <div class="form-group col-md-4">
                                    <input wire:model="tgl_pencairan" type="date" class="form-control" readonly
                                        placeholder="Tgl Disetujui">
                                </div>
                                {{-- end tgl disetujui --}}

                                {{-- Rekeningi --}}
                                <div class="form-group col-md-12">
                                    <select wire:model="id_rekening2" class="form-control">
                                        <option value="" selected>
                                            Pilih Rekening</option>
                                        @foreach ($daftar_rekening as $a)
                                            <option value="{{ $a->id_rekening }}">
                                                {{ $a->nama_rekening }} (
                                                Rp{{ number_format($a->saldo, 0, '.', '.') }},-)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- end rekening --}}

                                {{-- saldo --}}
                                {{-- <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saldo
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            value="@foreach ($rekening as $a){{ number_format($a->saldo, 0, '.', '.') }} @endforeach"
                                            disabled>

                                    </div>
                                </div> --}}
                                {{-- end saldo --}}


                                {{-- satuan disetujui --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Nominal
                                                Pencairan
                                                (Satuan)</span>
                                        </div>
                                        <input wire:model="satuan_pencairan" type="text" class="form-control"
                                            id="satuan_pencairan" placeholder="Masukan Nominal Satuan Pencairan">
                                    </div>
                                </div>
                                {{-- end satuan disetujui --}}


                                @if ($detail_a != null)
                                    {{-- nominal disetujui --}}
                                    <div class="form-group col-md-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">&nbsp;&nbsp;Nominal
                                                    Pencairan
                                                    (Total)&nbsp;&nbsp;</span>
                                            </div>
                                            <input wire:model="nominal_pencairan" type="input"
                                                class="form-control text-bold" disabled id="nominal_pencairan"
                                                placeholder="Masukan Nominal Satuan Disetujui">
                                            <div class="input-group-append">
                                                <span class="input-group-text">(Rp{{ $satuan_pencairan }} x
                                                    {{ $detail_a->jumlah_penerima }}
                                                    ) </span>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end satuan disetujui --}}

                                    <div class="form-group col-md-12">
                                        <label for="inputAlamat">KETERANGAN&nbsp;</label>

                                        <textarea type="text" class="form-control" wire:model="pencairan_note" placeholder="Masukan Keterangan"
                                            rows="4"> </textarea>
                                    </div>
                                @endif


                                {{-- tombol acc --}}
                                <div class="form-group
                                col-md-4">

                                    @if ($tgl_pencairan == '' or $satuan_pencairan == '' or $id_rekening2 == '')
                                        <button class="btn btn-success btn-block" disabled
                                            wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                            CAIRKAN</button>
                                    @else
                                        <button type="submit" name="submit" class="btn btn-success btn-block"
                                            wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                            CAIRKAN</button>
                                    @endif

                                </div>
                                {{-- acc --}}


                            </div>
                        </form>
                    </div>
                    {{-- end card cair --}}


                @endif

                @if ($detail_a != null)
                    {{-- tabel --}}
                    <table class="table table-bordered mt-2">
                        <thead>

                            {{-- tanggal disetujui --}}
                            <tr>
                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                    Tgl
                                    Respon
                                </td>
                                <td style="vertical-align: middle;">
                                    {{ $detail_a->tgl_pencairan != null ? Carbon\Carbon::parse($detail_a->tgl_pencairan)->isoFormat('dddd, D MMMM Y') : '-' }}
                                </td>
                            </tr>
                            {{-- end tanggal disetujui --}}

                            {{-- status --}}
                            <tr>
                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                    Status
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($detail_a->pencairan_status == 'Berhasil Dicairkan')
                                        <b style="font-size: 12pt;" class="text-success">
                                            Bisa Dicairkan
                                        </b>
                                    @elseif($detail_a->pencairan_status == 'Belum Dicairkan')
                                        <b style="font-size: 12pt;" class="text-danger">
                                            Belum Direspon
                                        </b>
                                    @endif

                                </td>
                            </tr>
                            {{-- end status --}}

                            {{-- petugas pentasyarufan --}}
                            <tr>
                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                    Dicairkan Oleh
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($detail_a->staf_keuangan_pc == null)
                                        -
                                    @else
                                        {{ $this->nama_pengurus_pc($detail_a->staf_keuangan_pc) }}
                                        <br>
                                        <span
                                            style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($detail_a->staf_keuangan_pc) }}
                                            - {{ $this->nama_pc($data->id_pc) }})</span>
                                    @endif
                                </td>
                            </tr>
                            {{-- end petugas pentasyaruan --}}


                            @if ($detail_a != null)

                                {{-- rekening sumber dana --}}
                                <tr>
                                    <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                        Rekening <br>
                                        Sumber Dana
                                    </td>
                                    <td style="vertical-align: middle;">
                                        @if ($detail_a->id_rekening == null)
                                            -
                                        @else
                                            {{ $this->nama_rekening($detail_a->id_rekening) }} -
                                            {{ $this->no_rekening($detail_a->id_rekening) }} <br>
                                            <span style="font-size:11pt;">
                                                {{ $this->getNamaBmtByIdRekening($detail_a->id_rekening) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                {{-- end rekening sumber dana --}}
                            @endif



                            <tr>
                                <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                    Keterangan
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($detail_a->pencairan_note == null)
                                        -
                                    @else
                                        {{ $detail_a->pencairan_note }}
                                    @endif
                                </td>
                            </tr>



                        </thead>
                    </table>
                    {{-- end tabel --}}
                @endif

                {{-- info --}}
                <div class="card mt-2">
                    <div class="card-body">
                        @if ($detail_a != null)
                            <table>

                                <tr>
                                    <td style="width: 70%"> Nominal Satuan Bisa Dicairkan &nbsp; : </td>
                                    <td style="width: 30%"> <b style="font-size: 12pt;" class="text-success">
                                            Rp{{ number_format($detail_a->satuan_pencairan, 0, '.', '.') }},-
                                        </b>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 70%"> Jumlah Nominal Bisa Dicairkan &nbsp;: </td>
                                    <td style="width: 30%"> <b style="font-size: 12pt;" class="text-success">
                                            Rp{{ number_format($detail_a->nominal_pencairan, 0, '.', '.') }},-
                                        </b>
                                    </td>
                                </tr>

                            </table>
                        @endif
                    </div>
                </div>
                {{-- end info --}}

            </div>
        </div>
    </div>
    {{-- end card rencana pentsyarufan --}}





</div>
