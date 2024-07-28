{{-- diinput oleh --}}

<div class="card mt-3 ml-2 mr-2">
    <div class="card-body">
        @php
            $dp = App\Models\Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        @endphp

        <br>
        <span>
            <i class="fas fa-info-circle"></i>
            @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Kepala Cabang')
                Berikan respon persetujuan disposisi penyaluran & tentukan apakah diperlukan survey
            @elseif(Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Program dan Administrasi Umum')
                Berikan respon konfirmasi disposisi penyaluran
            @else
                Lembar Disposisi Penyaluran (Div. Program & Direktur)
            @endif
        </span>

    </div>


</div>

@include('detail.form_persetujuan_disposisi')

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6  tab-tab-detail-pengajuan-umum-pc">
        {{-- end diinput oleh --}}
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            {{-- <div class="row"> --}}
            <div>
                <i class="fas fa-clipboard-check mr-2"></i><b> A. RESPON DIV. PROGRAM </b>

            </div>

            @if (Auth::user()->gocap_id_pc_pengurus != null)


                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3' and
                        ($data_detail->approval_status_divpro == 'Belum Direspon' or
                            $data_detail->approval_status_divpro == 'Ditolak' or
                            $data_detail->approval_status_divpro == ''))
                    <div class="btn-group ">

                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" style="background-color: #cccccc">Respon</button>
                        <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="background-color: #cccccc">
                            <span class="sr-only">Toggle
                                Dropdown</span>
                        </button>

                        <div class="dropdown-menu ">
                            <a wire:click="tombol_acc_program" onMouseOver="this.style.color='green'"
                                onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                data-target="#modal_acc" type="button"><i class="fas fa-user-check"></i>
                                ACC
                            </a>
                        </div>
                    </div>
                @endif

            @endif

        </div>


        @if (session()->has('alert_nominal'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_nominal') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        {{-- tabel --}}
        <div class="col-12 mt-2">
            <table class="table  table-bordered">
                <thead>

                    @if ($data_detail->approval_date_divpro && $data_detail->status_divpro == 'Diterima')
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Direspon Oleh
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $this->nama_pengurus_pc($data_detail->approver_divpro) }}
                            <br>
                            <span
                                style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data_detail->approver_divpro) }}
                                - {{ $this->nama_pc($data->id_pc) }})</span>

                        </td>
                    @else
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Direspon Oleh
                        </td>
                        <td style="vertical-align: middle;">
                            -

                        </td>
                    @endif

                    @if ($data_detail->approval_date_divpro && $data_detail->status_divpro == 'Diterima')
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Tgl Diterima Div. Program</td>
                            <td>{{ Carbon\Carbon::parse($data_detail->approval_date_divpro)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Status</td>
                            <td>{{ $data_detail->status_divpro }}
                            </td>
                        </tr>


                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Tgl Diserahkan ke Direktur</td>
                            <td>{{ Carbon\Carbon::parse($data_detail->tgl_diserahkan_direktur)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Keterangan</td>
                            <td>{{ $data_detail->keterangan_acc_divpro }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Tgl Diterima Div. Program</td>
                            <td>-
                            </td>
                        </tr>


                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Tgl Diserahkan ke Direktur</td>
                            <td>-
                            </td>
                        </tr>

                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Status</td>
                            <td>-
                            </td>
                        </tr>
                    @endif

                </thead>
            </table>
        </div>

    </div>

    <div class="col-sm-6 col-md-6 col-lg-6  tab-tab-detail-pengajuan-umum-pc">
        {{-- end diinput oleh --}}
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center mt-3">


            @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Front Office')
                <div>
                    <i class="fas fa-clipboard-check mr-2"></i><b> B. RESPON DIREKTUR </b>
                </div>

                {{-- <div
                        class="col-lg-{{ $data_detail->approval_status != 'Disetujui' ? '2' : '0' }} col-md-6 col-sm-12 float-right ">
                        <div>
                            @if ($data_detail->approval_status != 'Disetujui')
                                <div class="float-right">
                                    <div class="dropdown float-right">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle hover"
                                            type="button" id="dropdownMenu2" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="true">
                                            @if ($dp->status_pengajuan == 'Diajukan')
                                                Selesai input
                                            @else
                                                Belum selesai input
                                            @endif
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                            x-placement="bottom-start"
                                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, 31px, 0px);">
                                            <button class="dropdown-item" aria-expanded="false"
                                                wire:click="ajukan_pengajuan('{{ $data_detail->id_pengajuan }}')">
                                                <i class="fas fa-check"></i>
                                                Selesai input
                                            </button>
                                            <button class="dropdown-item"
                                                wire:click="batalkan_pengajuan('{{ $data_detail->id_pengajuan }}')">
                                                <i class="fas fa-ban"></i> Belum selesai input
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        </div>
                    </div> --}}
            @else
                {{-- <div class="col-lg-12 col-md-6 col-sm-12">
                        <b class="ml-2">B. RESPON DIREKTUR</b>
                    </div> --}}
                <div>
                    <i class="fas fa-clipboard-check mr-2"></i><b> B. RESPON DIREKTUR </b>
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

                    @if ($data_detail->approval_status_divpro == 'Disetujui')
                        @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                                ($data_detail->approval_status == 'Belum Direspon' or $data_detail->approval_status == 'Ditolak'))
                            {{-- <div class="ml-2" style="padding-left: 250px;"> --}}
                            <div class="btn-group">

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

                            {{-- </div> --}}
                            {{-- @else
                                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and $data_detail->approval_status != 'Disetujui')
                                        <button type="button" class="btn btn-secondary mr-2" data-toggle="tooltip"
                                            data-placement="bottom" disabled
                                            title="Persetujuan Direktur dapat diakses ketika survey sudah disetujui">
                                            Respon </button>
                                    @endif --}}
                        @endif
                    @endif

                @endif


            @endif
        </div>
        {{-- end judul --}}


        @if (session()->has('alert_nominal'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_nominal') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        {{-- tabel --}}
        <div class="col-12 mt-2">
            <table class="table  table-bordered">
                <thead>
                    {{-- disetujui oleh --}}
                    <tr>
                        @if ($data_detail->approval_status == 'Disetujui' or $data_detail->approval_status == 'Belum Direspon')
                            <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                Direspon Oleh:
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
                            <td class="text-bold " style="width: 30%">
                                Tgl Respon</td>
                            <td>{{ Carbon\Carbon::parse($data_detail->denial_date)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                        </tr>
                    @elseif($data_detail->approval_status == 'Disetujui')
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Tgl Respon</td>
                            <td>{{ Carbon\Carbon::parse($data_detail->approval_date)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Tgl Respon</td>
                            <td>-
                            </td>
                        </tr>
                    @endif


                    <tr>
                        <td>
                            <b style="font-size: 12pt;">Status</b>
                        </td>
                        <td> {{ $data_detail->approval_status }}</td>
                    </tr>

                    <tr>
                        <td>
                            <b style="font-size: 12pt;">Survey</b>
                        </td>
                        <td> {{ $data_detail->pil_survey ?? '-' }}</td>
                    </tr>
                    @if ($data_detail->approval_status == 'Ditolak')
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Keterangan</td>
                            <td>{{ $data_detail->denial_note }}
                            </td>
                        </tr>
                    @elseif($data_detail->approval_status == 'Disetujui')
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Keterangan</td>
                            <td>{{ $data_detail->keterangan_acc }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Keterangan</td>
                            <td>-
                            </td>
                        </tr>
                    @endif

                </thead>
            </table>
        </div>

    </div>
</div>




@include('modal.modal_pengajuan_penerima_manfaat')
@include('modal.modal_pengajuan_penerima_manfaat_survey')
@include('modal.modal_pengajuan_penerima_manfaat_hapus')

@include('modal.modal_internal_lampiran_tambah')
@include('modal.modal_internal_lampiran_ubah')
@include('modal.modal_internal_lampiran_hapus')

@include('modal.modal_ubah_nominal_pengajuan')



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



@push('script')
    <script>
        $(document).ready(function() {
            $('#inptKabupaten2').select2();
            $('#inptKabupaten2').on('change', function(e) {
                var data = $('#inptKabupaten2').select2("val");
                @this.set('id_rekening', data);
            });
        });
    </script>


    <script>
        $(document).ready(function() {

            window.loadContactDeviceSelect2 = () => {
                bsCustomFileInput.init();
                $('.tombol-tambah').click(function() {
                    $(".custom-file-lampiran").html('').change();
                });

                $('.tombol-ubah').click(function() {
                    $(".custom-file-lampiran").html('').change();
                });

            }

            loadContactDeviceSelect2();
            window.livewire.on('loadContactDeviceSelect2', () => {
                loadContactDeviceSelect2();
            });


        });
    </script>
@endpush
