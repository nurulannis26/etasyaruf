{{-- Disetujui oleh Direktur Eksekutif --}}
<div class="card mt-3 ml-2 mr-2">
    <div class="card-body">
        <span>
            <i class="fas fa-info-circle"></i>
            Direspon oleh Kepala Cabang
            ({{ $nama_direktur }})
        </span>
    </div>
</div>
{{-- end Disetujui oleh Direktur Eksekutif --}}

@if (session()->has('alert_notif'))
    <div class="alert alert-warning alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
        <i class="far fa-check-circle"></i>
        {{ session('alert_notif') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="intro-detail-persetujuan-direktur-arsips">
    {{-- judul --}}
    <div class="d-flex justify-content-between align-items-center mt-2 ">
        <div>
            <i class="fas fa-clipboard-check ml-2"></i><b> PERSETUJUAN KEPALA CABANG </b>
            <p class="intro-detail-status-persetujuan-direkturs-arsips d-inline">
                @if ($data->approval_status == 'Belum Direspon')
                    <sup class="badge badge-danger text-white bg-warning mb-2">{{ $data->approval_status }}</sup>
                @elseif($data->approval_status == 'Disetujui')
                    <sup class="badge badge-danger text-white bg-success mb-2">{{ $data->approval_status }}</sup>
                @else
                    <sup class="badge badge-danger text-white bg-danger mb-2">{{ $data->approval_status }}</sup>
                @endif
            </p>
        </div>
        @if (Auth::user()->gocap_id_pc_pengurus != null)
            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                    ($data->approval_status_divpro == 'Disetujui' or $data->approval_status_divpro == 'Ditolak'))
                <div class="mr-2">
                    <div class="btn-group float-right">

                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" style="background-color: #cccccc">Respon</button>
                        <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="background-color: #cccccc">
                            <span class="sr-only">Toggle
                                Dropdown</span>
                        </button>

                        <div class="dropdown-menu ">
                            <a wire:click="tombol_acc" onMouseOver="this.style.color='green'"
                                onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                data-target="#modal_acc" type="button"><i class="fas fa-user-check"></i>
                                @if ($data->approval_status == 'Ditolak')
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


            @if (str_replace('.', '', $nominal_disetujui) > str_replace('.', '', $data->nominal_pengajuan))
                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-minus-circle"></i>
                    Nominal disetujui melebihi nominal pengajuan
                </div>
            @endif
            {{-- end alert --}}

            {{-- form --}}
            <form wire:submit.prevent="acc">
                <div class="form-row mt-3">

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
                                <span class="input-group-text bor-abu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PJ Pencairan
                                    Dana&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </div>
                            <select wire:model="staf_keuangan" wire:loading.attr="disabled" class="form-control">
                                {{-- <option value="">Pilih Staf Keuangan</option> --}}
                                @foreach ($pengurus_keuangan as $b)
                                    <option value="{{ $b->id_pc_pengurus }}">
                                        {{ $b->nama . ' - ' . $b->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    {{-- end Pj Pencairan Dana --}}

                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;Nominal
                                    Pengajuan&nbsp;&nbsp;&nbsp;&nbsp;
                                </span>
                            </div>
                            <input value="{{ number_format($data->nominal_pengajuan, 0, '.', '.') }}" type="text"
                                class="form-control" readonly>
                        </div>
                    </div>



                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nominal
                                    Disetujui&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </span>
                            </div>
                            <input wire:model="nominal_disetujui" type="text" class="form-control"
                                id="nominal_disetujui" placeholder="Masukan Nominal Satuan Disetujui">
                        </div>
                    </div>





                    {{-- info --}}
                    <div class="form-group col-md-12">
                        <div class="card card-body " style="background-color:#e0e0e0;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol ACC, Kepala Cabang memberikan persetujuan untuk dilakukan pencairan dana
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
                        @if (
                            $staf_keuangan == '' or
                                $nominal_disetujui == '' or
                                str_replace('.', '', $nominal_disetujui) > str_replace('.', '', $saldo))
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

                <div class="form-row mt-3">

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
                                Dengan klik tombol tolak, Kepala Cabang memberikan penolakan untuk dilakukan pencairan dana
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

                @if ($data->approval_status == 'Disetujui' or $data->approval_status == 'Belum Direspon')
                    {{-- tanggal disetujui --}}
                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Tgl
                            Disetujui
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data->approval_date == null)
                                -
                            @else
                                {{ Carbon\Carbon::parse($data->approval_date)->isoFormat('dddd, D MMMM Y') }}
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
                            @if ($data->denial_date == null)
                                -
                            @else
                                {{ Carbon\Carbon::parse($data->denial_date)->isoFormat('dddd, D MMMM Y') }}
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
                    {{ $data->approval_status }}
                </td>
            </tr> --}}
                {{-- end status --}}


                <tr>
                    <td class="text-bold">Nominal Disetujui
                    </td>
                    <td>
                        @if ($data->nominal_pengajuan == null)
                            Rp0,-
                        @else
                            <b style="font-size: 12pt;">Rp{{ number_format($data->nominal_disetujui, 0, '.', '.') }},-
                            </b>
                        @endif

                    </td>
                </tr>

                {{-- <tr>
                    <td class="text-bold">Rekening Sumber Dana
                    </td>
                    <td>
                        @if ($data->id_rekening == null)
                            -
                        @else
                            {{ $this->nama_rekening($data->id_rekening) }}
                        @endif

                    </td>
                </tr> --}}


                {{-- disetujui oleh --}}
                <tr>
                    @if ($data->approval_status == 'Disetujui' or $data->approval_status == 'Belum Direspon')
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Disetujui Oleh
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data->approver_tingkat_pc == null)
                                -
                            @else
                                {{ $this->nama_pengurus_pc($data->approver_tingkat_pc) }}
                                <br>
                                <span
                                    style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data->approver_tingkat_pc) }}
                                    - {{ $this->nama_pc($data->id_pc) }})</span>
                            @endif
                        </td>
                    @elseif($data->approval_status == 'Ditolak')
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Ditolak Oleh
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data->denial_tingkat_pc == null)
                                -
                            @else
                                {{ $this->nama_pengurus_pc($data->denial_tingkat_pc) }}
                                <br>
                                <span
                                    style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data->denial_tingkat_pc) }}
                                    - {{ $this->nama_pc($data->id_pc) }})</span>
                            @endif
                        </td>
                    @endif
                </tr>
                {{-- end petugas pentasyaruan --}}

                @if ($data->approval_status == 'Ditolak')

                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Alasan Penolakan
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data->denial_note == null)
                                -
                            @else
                                {{ $data->denial_note }}
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
            }

            loadContactDeviceSelect2();
            window.livewire.on('loadContactDeviceSelect2', () => {
                loadContactDeviceSelect2();
            });

        });
    </script>
@endpush


@push('script')
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();
            window.loadContactDeviceSelect2 = () => {
                window.initSelectStationDrop = () => {
                    $('#select2-dropdown').select2();
                    $('#select2-dropdown').on('change', function() {
                        var selectedValue = $(this).val();
                        @this.set('selectedProgram', selectedValue);
                    });

                }
                initSelectStationDrop();
                window.livewire.on('select2', () => {
                    initSelectStationDrop();
                });
            }

            loadContactDeviceSelect2();
            window.livewire.on('loadContactDeviceSelect2', () => {
                loadContactDeviceSelect2();
            });

        });
    </script>
@endpush
