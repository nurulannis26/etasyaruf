{{-- Disetujui oleh Direktur Eksekutif --}}
<div class="card mt-3 ml-2 mr-2">
    <div class="card-body">
        @php
            $dp = App\Models\Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();
            
        @endphp
        <p class="tab-tab-status-detail-pengajuan-umum-pc d-inline">
            @if ($dp->status_pengajuan == 'Direncanakan')
                <sup class="text-light badge badge-warning">Data pengajuan belum selesai </sup>
            @endif

            @if ($dp->status_pengajuan == 'Diajukan')
                <sup class="text-light badge badge-success">Data pengajuan selesai </sup>
            @endif

            @if ($dp->survey_pc == 'Perlu')
                @if ($dp->status_survey == 'Direncanakan')
                    <sup class="text-light badge badge-warning">Survey belum selesai </sup>
                @endif

                @if ($dp->status_survey == 'Diajukan')
                    <sup class="text-light badge badge-success">Survey selesai </sup>
                @endif
            @else
                <sup class="text-light badge badge-secondary">Tanpa Survey </sup>
            @endif


            @if ($data_detail->approval_status == 'Belum Direspon')
                <sup class="text-light badge badge-warning">Menunggu persetujuan direktur </sup>
            @elseif($data_detail->approval_status == 'Disetujui')
                <sup class="text-light badge badge-success">Disetujui direktur</sup>
                @if ($data_detail->pencairan_status == 'Belum Dicairkan')
                    <sup class="text-light badge badge-warning">Menunggu pencairan keuangan </sup>
                @elseif($data_detail->pencairan_status == 'Berhasil Dicairkan')
                    <sup class="text-light badge badge-success">Disetujui div. keuangan
                    </sup>
                @else
                    <sup class="text-light badge badge-danger">Ditolak div. keuangan
                    </sup>
                @endif
            @elseif($data_detail->approval_status == 'Ditolak')
                <sup class="text-light badge badge-danger">Ditolak/revisi direktur</sup>
            @endif



            {{-- 
            @if ($survey != null)
                <sup
                    class="badge  text-white {{ $this->status_survey($id_pengajuan) == 0 || $this->status_survey($id_pengajuan) == 1
                        ? 'badge-warning'
                        : ($this->status_survey($id_pengajuan) == 2
                            ? 'badge-danger'
                            : ($this->status_survey($id_pengajuan) == 3
                                ? 'badge-success'
                                : '')) }} mb-2">
                    {{ $this->status_survey($id_pengajuan) == 0 || $this->status_survey($id_pengajuan) == 1
                        ? 'Menunggu Persetujuan Direktur'
                        : '' }}

                    {{ $this->status_survey($id_pengajuan) == 2 ? 'Survey Ditolak, Tinjau Kembali' : '' }}

                    {{ $this->status_survey($id_pengajuan) == 3 &&
                    $data_detail->approval_status == 'Belum Direspon' &&
                    $data_detail->pencairan_status == 'Belum Dicairkan'
                        ? 'Menunggu Persetujuan Direktur'
                        : '' }}

                    {{ $this->status_survey($id_pengajuan) == 3 &&
                    $data_detail->approval_status == 'Ditolak' &&
                    $data_detail->pencairan_status == 'Belum Dicairkan'
                        ? 'Ditolak Direktur'
                        : '' }}

                    {{ $this->status_survey($id_pengajuan) == 3 &&
                    $data_detail->approval_status == 'Disetujui' &&
                    $data_detail->pencairan_status == 'Belum Dicairkan'
                        ? 'Menunggu Dicairkan'
                        : '' }}

                    {{ $this->status_survey($id_pengajuan) == 3 &&
                    $data_detail->approval_status == 'Disetujui' &&
                    $data_detail->pencairan_status == 'Berhasil Dicairkan'
                        ? 'Dana Sudah Dicairkan'
                        : '' }}
                </sup>
            @else
                <sup
                    class="badge @if ($data_detail->approval_status == 'Belum Direspon' && $data_detail->pencairan_status == 'Belum Dicairkan') badge-warning text-dark
            @elseif($data_detail->approval_status == 'Ditolak' && $data_detail->pencairan_status == 'Belum Dicairkan')
            badge-danger text-white
            @elseif($data_detail->approval_status == 'Disetujui' && $data_detail->pencairan_status == 'Belum Dicairkan')
            badge-warning text-white
            @elseif($data_detail->approval_status == 'Disetujui' && $data_detail->pencairan_status == 'Berhasil Dicairkan')
            badge-success text-white @endif
              mb-2">

                    {{ $data_detail->approval_status == 'Belum Direspon' && $data_detail->pencairan_status == 'Belum Dicairkan'
                        ? 'Menunggu Persetujuan Direktur'
                        : '' }}

                    {{ $data_detail->approval_status == 'Ditolak' && $data_detail->pencairan_status == 'Belum Dicairkan'
                        ? 'Ditolak Direktur'
                        : '' }}

                    {{ $data_detail->approval_status == 'Disetujui' && $data_detail->pencairan_status == 'Belum Dicairkan'
                        ? 'Menunggu Dicairkan'
                        : '' }}

                    {{ $data_detail->approval_status == 'Disetujui' && $data_detail->pencairan_status == 'Berhasil Dicairkan'
                        ? 'Dana Sudah Dicairkan'
                        : '' }}
                </sup>
            @endif --}}
        </p>
        <br>

        @if ($data_detail->approval_status == 'Belum Direspon')
            @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Direktur Eksekutif')
                <span>
                    <i class="fas fa-info-circle"></i>
                    Berikan respon persetujuan direktur
                </span>
            @else
                <span>
                    <i class="fas fa-info-circle"></i>
                    Menunggu respon persetujuan direktur
                    ({{ $this->nama_pengurus_pc($id_direktur) }})
                </span>
            @endif
        @elseif($data_detail->approval_status == 'Disetujui')
            <span> <i class="fas fa-info-circle"></i>
                Telah disetujui direktur
                ({{ $this->nama_pengurus_pc($id_direktur) }})
            </span>
        @elseif($data_detail->approval_status == 'Ditolak')
            <span>
                <i class="fas fa-info-circle"></i>
                Pengajuan ditolak/revisi
            </span>

        @endif



    </div>
</div>
{{-- end Disetujui oleh Direktur Eksekutif --}}

<div class="tab-persetujuan_direktur-detail-umum-pc">
    {{-- judul --}}
    <div class="d-flex justify-content-between align-items-center mt-2">
        <div>
            <i class="fas fa-clipboard-check ml-2"></i><b> PERSETUJUAN DIREKTUR </b>
            {{-- <p class="tab-persetujuan-direktur-status-detail-umum-pc d-inline">
                @if ($data_detail->approval_status == 'Belum Direspon')
                    <sup class="badge badge-danger text-white bg-warning mb-2">{{ $data_detail->approval_status }}</sup>
                @elseif($data_detail->approval_status == 'Disetujui')
                    <sup class="badge badge-danger text-white bg-success mb-2">{{ $data_detail->approval_status }}</sup>
                @else
                    <sup class="badge badge-danger text-white bg-danger mb-2">{{ $data_detail->approval_status }}</sup>
                @endif
            </p> --}}
        </div>
        @if (Auth::user()->gocap_id_pc_pengurus != null)
            @if ($this->cek_survey($id_pengajuan) == 'Perlu')

                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                        ($data_detail->approval_status == 'Belum Direspon' or $data_detail->approval_status == 'Ditolak') and
                        $survey != null)
                    <div class="mr-2">
                        <div class="btn-group float-right">

                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="background-color: #cccccc">Respon</button>
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="background-color: #cccccc">
                                <span class="sr-only">Toggle
                                    Dropdown</span>
                            </button>

                            <div class="dropdown-menu ">
                                <a wire:click="tombol_acc" onMouseOver="this.style.color='green'"
                                    onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                    data-target="#modal_acc" type="button"><i class="fas fa-user-check"></i>
                                    @if ($data_detail->approval_status == 'Ditolak')
                                        ACC Ulang
                                    @else
                                        ACC
                                    @endif
                                </a>
                                <a wire:click="tombol_tolak" onMouseOver="this.style.color='red'"
                                    onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                    data-target="#modal_tolak" type="button"><i class="fas fa-ban"></i>
                                    Tolak</a>
                            </div>
                        </div>

                    </div>
                @else
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                            $data_detail->approval_status != 'Disetujui')
                        <button type="button" class="btn btn-secondary mr-2" data-toggle="tooltip"
                            data-placement="bottom" disabled
                            title="Persetujuan Direktur dapat diakses ketika survey sudah disetujui">
                            Respon </button>
                    @endif
                @endif
            @else
                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                        ($data_detail->approval_status == 'Disetujui' or $data_detail->approval_status == 'Ditolak'))
                    <div class="mr-2">
                        <div class="btn-group float-right">

                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="background-color: #cccccc">Respon</button>
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="background-color: #cccccc">
                                <span class="sr-only">Toggle
                                    Dropdown</span>
                            </button>

                            <div class="dropdown-menu ">
                                <a wire:click="tombol_acc" onMouseOver="this.style.color='green'"
                                    onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                    data-target="#modal_acc" type="button"><i class="fas fa-user-check"></i>
                                    @if ($data_detail->approval_status == 'Ditolak')
                                        ACC Ulang
                                    @else
                                        ACC
                                    @endif
                                </a>
                                <a wire:click="tombol_tolak" onMouseOver="this.style.color='red'"
                                    onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                    data-target="#modal_tolak" type="button"><i class="fas fa-ban"></i>
                                    Tolak</a>
                            </div>
                        </div>

                    </div>
                @else
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                            $data_detail->approval_status != 'Disetujui')
                        <button type="button" class="btn btn-secondary mr-2" data-toggle="tooltip"
                            data-placement="bottom" disabled>
                            Respon </button>
                    @endif
                @endif
            @endif
        @endif
    </div>
    {{-- end judul --}}

    {{-- alert --}}
    @if (session()->has('alert_direktur'))
        <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
            <i class="far fa-check-circle"></i>
            {{ session('alert_direktur') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- end alert --}}
    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
        {{-- card acc --}}
        <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $none_block_acc }};">
            <div class="d-flex justify-content-between align-items-center">
                <b class="text-success">ACC PENGAJUAN</b>
                <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>


            {{-- alert --}}
            {{-- @if ($id_rekening != null)
                @if (str_replace('.', '', $nominal_disetujui) > str_replace('.', '', $saldo))
                    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                        <i class="fas fa-minus-circle"></i>
                        Saldo Tidak Cukup!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            @endif
            @if (str_replace('.', '', $satuan_disetujui) > str_replace('.', '', $satuan_pengajuan))
                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-minus-circle"></i>
                    Nominal disetujui melebihi nominal pengajuan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif --}}
            {{-- end alert --}}

            {{-- form --}}
            <form wire:submit.prevent="acc">
                <div class="form-row mt-4">

                    {{-- <div class="form-group col-md-7">
                    <label for="inputNama">YANG MENYETUJUI &nbsp;</label>
                    <input type="input" class="form-control"
                        value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                        readonly>
                </div>

                <div class="form-group col-md-5">
                    <label for="inputNama">TGL DISETUJUI &nbsp;</label>
                    <input wire:model="approval_date" type="date" class="form-control" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNama">PJ PENCAIRAN DANA &nbsp;</label>
                    <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                    <select wire:model="staf_keuangan" wire:loading.attr="disabled" class="form-control">
                        <option value="">Pilih Staf Keuangan</option>
                        @foreach ($pengurus_keuangan as $b)
                            <option value="{{ $b->id_pc_pengurus }}">
                                {{ $b->nama . ' - ' . $b->jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label for="inputNama">REKENING SUMBER DANA &nbsp;</label>
                    <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                    <select wire:model="id_rekening" class="form-control">
                        <option value="">Pilih Rekening</option>
                        @foreach ($rekening as $a)
                            <option value="{{ $a->id_rekening }}">
                                {{ $a->nama_rekening }} -
                                {{ $a->no_rekening }}
                                - Rp{{ number_format($a->saldo, 0, '.', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNama">NOMINAL DIAJUKAN (SATUAN) &nbsp;</label>
                    <input wire:model="satuan_pengajuan" type="input" class="form-control"
                        placeholder="Masukan Nominal Satuan Disetujui" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNama">NOMINAL DISETUJUI (SATUAN) &nbsp;</label>
                    <sup class="badge badge-danger text-white mb-2"
                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                    <input wire:model="satuan_disetujui" type="input" class="form-control " id="satuan_disetujui"
                        placeholder="Masukan Nominal Satuan Disetujui">
                </div>

                <div class="form-group col-md-12">
                    <label for="inputNama">NOMINAL DISETUJUI (TOTAL) (Rp{{ $satuan_disetujui }} x
                        {{ $data_detail->jumlah_penerima }}
                        Penerima Manfaat)</label>
                    <input wire:model="nominal_disetujui" type="input" class="form-control text-bold" readonly
                        id="nominal_disetujui" placeholder="Masukan Nominal Satuan Disetujui">
                </div>
 --}}




                    {{-- Direktur --}}
                    <div class="form-group col-md-7">
                        <input type="input" class="form-control"
                            value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                            readonly>
                    </div>
                    {{-- end direktur --}}


                    {{-- tgl disetujui --}}
                    <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tgl Disetujui</span>
                            </div>
                            <input wire:model="approval_date" type="date" class="form-control" readonly>
                        </div>
                    </div>
                    {{-- end tgl disetujui --}}

                    {{-- Pj Pencairan Dana --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span
                                    class="input-group-text bor-abu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PJ
                                    Pencairan
                                    Dana&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </div>
                            <select wire:model="staf_keuangan" wire:loading.attr="disabled" class="form-control">

                                @foreach ($pengurus_keuangan as $b)
                                    <option value="{{ $b->id_pc_pengurus }}">
                                        {{ $b->nama . ' - ' . $b->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    {{-- end Pj Pencairan Dana --}}

                    {{-- <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&nbsp;&nbsp;&nbsp;Rekening
                                    Sumber
                                    Dana&nbsp;&nbsp;&nbsp;&nbsp;
                                </span>
                            </div>
                            <select wire:model="id_rekening" class="form-control">
                                <option value="">Pilih Rekening</option>
                                @foreach ($rekening as $a)
                                    <option value="{{ $a->id_rekening }}">

                                        {{ $a->no_rekening }} -
                                        {{ $a->nama_rekening }} -
                                        Rp{{ number_format($a->saldo, 0, '.', '.') }}
                                    </option>
                                @endforeach
                            </select>




                        </div>
                    </div> --}}
                    {{-- <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp </span>
                        </div>
                        <input wire:model="saldo" type="text" class="form-control" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">Saldo </span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nama BMT</span>
                        </div>
                        <input wire:model="nama_bmt" type="text" class="form-control" readonly>
                    </div>
                </div> --}}


                    {{-- satuan pengajuan --}}
                    {{-- <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nominal
                                    Diajukan (Satuan)</span>
                            </div>
                            <input wire:model="satuan_pengajuan" type="input" class="form-control"
                                placeholder="Masukan Nominal Satuan Disetujui" readonly>

                        </div>
                    </div> --}}
                    {{-- end satuan pengajuan --}}

                    {{-- satuan disetujui --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nominal
                                    Disetujui (Satuan)</span>
                            </div>
                            <input wire:model="satuan_disetujui" type="input" class="form-control "
                                id="satuan_disetujui" placeholder="Masukan Nominal Satuan Disetujui">

                        </div>
                    </div>
                    {{-- end satuan disetujui --}}





                    {{-- nominal disetujui --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&nbsp;&nbsp;Nominal
                                    Disetujui
                                    (Total)&nbsp;&nbsp;</span>
                            </div>
                            <input wire:model="nominal_disetujui" type="input" class="form-control text-bold"
                                disabled id="nominal_disetujui" placeholder="Masukan Nominal Satuan Disetujui">
                            <div class="input-group-append">
                                <span class="input-group-text">(Rp{{ $satuan_disetujui }} x
                                    {{ $data_detail->jumlah_penerima }}
                                    Penerima) </span>
                            </div>
                        </div>
                    </div>
                    {{-- end satuan disetujui --}}




                    {{-- nominal disetujui --}}
                    {{-- <div class="form-group col-md-10">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-bold">Rp</span>
                        </div>
                        <input wire:model="nominal_disetujui" type="input" class="form-control text-bold"
                            placeholder="Nominal disetujui" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text ">Nominal
                                Disetujui (Rp{{ $satuan_disetujui }} x {{ $data_detail->jumlah_penerima }}
                                Penerima
                                Manfaat)</span>
                        </div>
                    </div>

                </div> --}}
                    {{-- end nominal disetujui --}}

                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Keterangan</span>
                            </div>
                            <input wire:model="keterangan_acc" type="input" class="form-control "
                                id="keterangan_acc" placeholder="Masukan Keterangan ACC">

                        </div>
                    </div>


                    {{-- info --}}
                    <div class="form-group col-md-12">
                        <div class="card card-body " style="background-color:#e0e0e0;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol ACC, direktur memberikan persetujuan untuk dilakukan pencairan dana
                                oleh
                                divisi keuangan
                            </span>
                        </div>
                    </div>
                    {{-- end info --}}

                    <div class="form-group col-md-9">
                    </div>

                    {{-- tombol acc --}}
                    <div class="form-group col-md-3">
                        @if ($staf_keuangan == '' or $satuan_disetujui == '' or $keterangan_acc == '')
                            <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-check-circle"></i>
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
        <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $none_block_tolak }};">
            <div class="d-flex justify-content-between align-items-center">
                <b class="text-danger">TOLAK PENGAJUAN</b>
                <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            <form wire:submit.prevent="tolak">

                <div class="form-row mt-4">

                    {{-- Direktur --}}
                    <div class="form-group col-md-7">
                        <input type="input" class="form-control"
                            value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                            readonly>
                    </div>
                    {{-- end rekening --}}

                    {{-- tgl penolakan --}}
                    <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tgl Penolakan</span>
                            </div>
                            <input wire:model="denial_date" type="date" class="form-control" readonly>
                        </div>
                    </div>
                    {{-- end tgl penolakan --}}


                    {{-- denial note --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Alasan</span>
                            </div>
                            <input wire:model="denial_note" type="input" class="form-control"
                                placeholder="Masukan Alasan Penolakan">
                        </div>
                    </div>
                    {{-- end denial note --}}


                    {{-- info --}}
                    <div class="form-group col-md-12">
                        <div class="card card-body " style="background-color:#e0e0e0;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol tolak, direktur memberikan penolakan untuk dilakukan pencairan dana
                                oleh
                                divisi keuangan
                            </span>
                        </div>
                    </div>
                    {{-- end info --}}

                    <div class="form-group col-md-9">
                    </div>

                    {{-- tombol tolak --}}
                    <div class="form-group col-md-3">
                        @if ($denial_note == '')
                            <button class="btn btn-danger btn-block" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-minus-circle"></i>
                                Tolak</button>
                        @else
                            <button type="submit" name="submit" class="btn btn-danger btn-block"
                                wire:loading.attr="disabled"><i class="fas fa-minus-circle"></i>
                                Tolak</button>
                        @endif
                    </div>
                    {{-- tolak --}}


                </div>
            </form>
        </div>
        {{-- end card tolak --}}
    @endif

    {{-- tabel --}}
    <div class="col-12 mt-2">
        {{-- tabel --}}
        <table class="table table-bordered mt-2">
            <thead>

                @if ($data_detail->approval_status == 'Disetujui' or $data_detail->approval_status == 'Belum Direspon')
                    {{-- tanggal disetujui --}}
                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Tgl
                            Disetujui
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->approval_date == null)
                                -
                            @else
                                {{ Carbon\Carbon::parse($data_detail->approval_date)->isoFormat('dddd, D MMMM Y') }}
                            @endif
                        </td>
                    </tr>
                    {{-- end tanggal disetujui --}}
                @else
                    {{-- tanggal ditolak --}}
                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Tgl
                            Ditolak
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->denial_date == null)
                                -
                            @else
                                {{ Carbon\Carbon::parse($data_detail->denial_date)->isoFormat('dddd, D MMMM Y') }}
                            @endif
                        </td>
                    </tr>
                    {{-- end tanggal ditolak --}}
                @endif

                {{-- status --}}
                {{-- <tr>
                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                    Status
                </td>
                <td style="vertical-align: middle;">
                    {{ $data_detail->approval_status }}
                </td>
            </tr> --}}
                {{-- end status --}}


                <tr>
                    <td class="text-bold">Nominal Disetujui
                    </td>
                    <td>
                        @if ($data_detail->nominal_pengajuan == null)
                            Rp0,-
                        @else
                            <b style="font-size: 12pt;">Rp{{ number_format($data_detail->nominal_disetujui, 0, '.', '.') }},-
                            </b>
                            ({{ $data_detail->jumlah_penerima }} x
                            Rp{{ number_format($data_detail->satuan_disetujui, 0, '.', '.') }})
                        @endif

                    </td>
                </tr>

                <tr>
                    <td class="text-bold">Keterangan
                    </td>
                    <td>
                        {{ $data_detail->keterangan_acc }}


                    </td>
                </tr>


                {{-- disetujui oleh --}}
                <tr>
                    @if ($data_detail->approval_status == 'Disetujui' or $data_detail->approval_status == 'Belum Direspon')
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Disetujui Oleh
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->approver_tingkat_pc == null)
                                -
                            @else
                                {{ $this->nama_pengurus_pc($data_detail->approver_tingkat_pc) }}
                                <br>
                                <span
                                    style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data_detail->approver_tingkat_pc) }}
                                    - {{ $this->nama_pc($data->id_pc) }})</span>
                            @endif
                        </td>
                    @elseif($data_detail->approval_status == 'Ditolak')
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Ditolak Oleh
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->denial_tingkat_pc == null)
                                -
                            @else
                                {{ $this->nama_pengurus_pc($data_detail->denial_tingkat_pc) }}
                                <br>
                                <span
                                    style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data_detail->denial_tingkat_pc) }}
                                    - {{ $this->nama_pc($data->id_pc) }})</span>
                            @endif
                        </td>
                    @endif
                </tr>
                {{-- end petugas pentasyaruan --}}

                @if ($data_detail->approval_status == 'Ditolak')

                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Alasan Penolakan
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->denial_note == null)
                                -
                            @else
                                {{ $data_detail->denial_note }}
                            @endif
                        </td>
                    </tr>

                @endif




            </thead>
        </table>
        {{-- end tabel --}}


    </div>

</div>
{{-- 
@include('modal.modal_internal_lampiran_tambah')
@include('modal.modal_internal_lampiran_ubah')
@include('modal.modal_internal_lampiran_hapus') --}}



@push('script')
    <script>
        $(document).ready(function() {

            window.loadContactDeviceSelect2 = () => {


                $('#nominal_disetujui').on('input', function(e) {
                    $('#nominal_disetujui').val(formatRupiah($('#nominal_disetujui').val(),
                        'Rp. '));
                });

                $('#satuan_disetujui').on('input', function(e) {
                    $('#satuan_disetujui').val(formatRupiah($('#satuan_disetujui').val(),
                        'Rp. '));
                });
            }

            loadContactDeviceSelect2();
            window.livewire.on('loadContactDeviceSelect2', () => {
                loadContactDeviceSelect2();
            });

        });
    </script>
@endpush
