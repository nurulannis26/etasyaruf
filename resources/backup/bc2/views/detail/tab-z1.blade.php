{{-- diinput oleh --}}
{{-- {{ dd($data) }} --}}
<div class="card mt-3 ml-2 mr-2">
    <div class="card-body">
        {{-- @if ($data->approval_status == 'Belum Direspon' and $data->pencairan_status == 'Belum Dicairkan')
            <sup class="badge badge-warning text-white">Menunggu Persetujuan</sup>
        @elseif ($data->approval_status == 'Ditolak' and $data->pencairan_status == 'Belum Dicairkan')
            <sup class="badge badge-danger text-white">Ditolak</sup>
        @elseif ($data->approval_status == 'Disetujui' and $data->pencairan_status == 'Belum Dicairkan')
            <sup class="badge badge-primary text-white">Menunggu Dicairkan</sup>
        @else
            <sup class="badge badge-success text-white">Dana Sudah Dicairkan</sup>
        @endif --}}

        @if ($data->tgl_pengajuan != null)
            <sup class="badge badge-success text-white">FPPD berhasil diajukan</sup>
        @else
            <sup class="badge badge-warning text-white">FPPD belum selesai diajukan</sup>
        @endif

        @if ($data->approval_status_divpro == 'Disetujui')
            <sup class="text-light badge badge-success">Disposisi Diterima Div. Program</sup>
        @else
            <sup class="text-light badge badge-warning">Disposisi Blm Diterima Div. Program
            </sup>
        @endif

        @if ($data->approval_status_divpro == 'Disetujui')
            @if ($data->approval_status == 'Belum Direspon')
                <sup class="badge badge-warning text-white mb-2">Pengajuan blm disetujui Direktur</sup>
            @elseif($data->approval_status == 'Disetujui')
                <sup class="badge badge-success text-white mb-2">Pengajuan disetujui Direktur</sup>
            @else
                <sup class="badge badge-danger text-white mb-2">Pengajuan ditolak Direktur</sup>
            @endif
        @endif

        @if ($data->approval_status == 'Disetujui')
            @if ($data->pencairan_status == 'Belum Dicairkan')
                <sup class="badge badge-warning text-white mb-2">Pencairan blm disetujui Div. Keuangan</sup>
            @elseif($data->pencairan_status == 'Berhasil Dicairkan')
                <sup class="badge badge-success text-white mb-2">Pencairan disetujui Div. Keuangan</sup>
            @else
                <sup class="badge badge-danger text-white mb-2">Pencairan ditolak Div. Keuangan</sup>
            @endif
        @endif


        
        <br>
        <div class="row align-items-center">
            <span class="col-md-8">
                <i class="fas fa-info-circle "></i>
                Diajukan Oleh
                {{ $this->jabatan_pengurus_pc($data->maker_tingkat_pc) }}
                ({{ $this->nama_pengurus_pc($data->maker_tingkat_pc) }})
            </span>
            <div class="col-md-4 text-md-right">
                <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                <svg height="35px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <title>file_type_pdf2</title>
                    <path d="M24.1,2.072h0l5.564,5.8V29.928H8.879V30H29.735V7.945L24.1,2.072" style="fill:#909090" />
                    <path d="M24.031,2H8.808V29.928H29.664V7.873L24.03,2" style="fill:#f4f4f4" />
                    <path d="M8.655,3.5H2.265v6.827h20.1V3.5H8.655" style="fill:#7a7b7c" />
                    <path d="M22.472,10.211H2.395V3.379H22.472v6.832" style="fill:#dd2025" />
                    <path
                        d="M9.052,4.534h-.03l-.207,0H7.745v4.8H8.773V7.715L9,7.728a2.042,2.042,0,0,0,.647-.117,1.427,1.427,0,0,0,.493-.291,1.224,1.224,0,0,0,.335-.454,2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65A2.149,2.149,0,0,0,9.37,4.56a2.232,2.232,0,0,0-.319-.026M8.862,6.828l-.089,0V5.348h.193a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                        style="fill:#464648" />
                    <path
                        d="M12.533,4.521c-.111,0-.219.008-.295.011L12,4.538h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.392h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                        style="fill:#464648" />
                    <path d="M17.43,4.538H15v4.8h1.028V7.434h1.3V6.542h-1.3V5.43h1.4V4.538" style="fill:#464648" />
                    <path
                        d="M21.781,20.255s3.188-.578,3.188.511S22.994,21.412,21.781,20.255Zm-2.357.083a7.543,7.543,0,0,0-1.473.489l.4-.9c.4-.9.815-2.127.815-2.127a14.216,14.216,0,0,0,1.658,2.252,13.033,13.033,0,0,0-1.4.288Zm-1.262-6.5c0-.949.307-1.208.546-1.208s.508.115.517.939a10.787,10.787,0,0,1-.517,2.434A4.426,4.426,0,0,1,18.161,13.841ZM13.513,24.354c-.978-.585,2.051-2.386,2.6-2.444C16.11,21.911,14.537,24.966,13.513,24.354ZM25.9,20.895c-.01-.1-.1-1.207-2.07-1.16a14.228,14.228,0,0,0-2.453.173,12.542,12.542,0,0,1-2.012-2.655,11.76,11.76,0,0,0,.623-3.1c-.029-1.2-.316-1.888-1.236-1.878s-1.054.815-.933,2.013a9.309,9.309,0,0,0,.665,2.338s-.425,1.323-.987,2.639-.946,2.006-.946,2.006a9.622,9.622,0,0,0-2.725,1.4c-.824.767-1.159,1.356-.725,1.945.374.508,1.683.623,2.853-.91a22.549,22.549,0,0,0,1.7-2.492s1.784-.489,2.339-.623,1.226-.24,1.226-.24,1.629,1.639,3.2,1.581,1.495-.939,1.485-1.035"
                        style="fill:#dd2025" />
                    <path d="M23.954,2.077V7.95h5.633L23.954,2.077Z" style="fill:#909090" />
                    <path d="M24.031,2V7.873h5.633L24.031,2Z" style="fill:#f4f4f4" />
                    <path
                        d="M8.975,4.457h-.03l-.207,0H7.668v4.8H8.7V7.639l.228.013a2.042,2.042,0,0,0,.647-.117,1.428,1.428,0,0,0,.493-.291A1.224,1.224,0,0,0,10.4,6.79a2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65,2.149,2.149,0,0,0-.411-.105,2.232,2.232,0,0,0-.319-.026M8.785,6.751l-.089,0V5.271H8.89a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                        style="fill:#fff" />
                    <path
                        d="M12.456,4.444c-.111,0-.219.008-.295.011l-.235.006h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.315h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                        style="fill:#fff" />
                    <path d="M17.353,4.461h-2.43v4.8h1.028V7.357h1.3V6.465h-1.3V5.353h1.4V4.461" style="fill:#fff" />
                </svg> <a
                    href="/pc/internal{{ $data->id_internal }}/{{ str_replace('/', '_', $data->nomor_surat) . '_FPPD' }}"
                    target="_blank" class="text-center"> &nbsp;&nbsp;FPPD.pdf</a>


            </div>
        </div>
    </div>
</div>
{{-- end diinput oleh --}}
{{-- end judul --}}

<div class="row mb-2">
    {{-- tabel --}}
    <div class="col-6 mt-2">
        <div class="intro-detail-pengajuans-arsips">
            {{-- judul --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-clipboard-check "></i><b> DETAIL
                        PENGAJUAN</b>
                </div>
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3' or
                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
                        {{-- <div class="ml-2" style="padding-left: 200px;"> --}}
                        <div class="btn-group ">

                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="background-color: #cccccc">Aksi</button>
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="background-color: #cccccc">
                                <span class="sr-only">Toggle
                                    Dropdown</span>
                            </button>

                            <div class="dropdown-menu ">
                                <a wire:click="modal_ubah_internal('{{ $id_internal }}')"
                                    onMouseOver="this.style.color='green'" onMouseOut="this.style.color='black'"
                                    class="dropdown-item" data-toggle="modal" data-target="#modal_ubah_internal"
                                    type="button"><i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a wire:click="modal_internal_hapus('{{ $id_internal }})"
                                    onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                    class="dropdown-item" data-toggle="modal" data-target="#modal_internal_hapus"
                                    type="button"><i class="fas fa-trash"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    @endif

                @endif
            </div>
            @if (session()->has('alert_nominal'))
                <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
                    <i class="far fa-check-circle"></i>
                    {{ session('alert_nominal') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
           <table class="table  table-bordered mt-2 mb-2">
                <thead>
                    <tr>
                        <td class="text-bold " style="width: 30%">
                            No Pengajuan</td>
                        <td>{{ $data->nomor_surat }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Tgl Pengajuan</td>
                        <td>{{ Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('dddd, D MMMM Y') }}
                        </td>
                    </tr>
                     <tr>
                        <td class="text-bold " style="width: 30%">
                            Tgl Tenggat Pencairan</td>
                        <td>{{ Carbon\Carbon::parse($data->tgl_tenggat)->isoFormat('dddd, D MMMM Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Pemohon</td>
                        <td>{{ $this->nama_pengurus_pc($data->maker_tingkat_pc) }}<br>
                            {{ $this->jabatan_pengurus_pc($data->maker_tingkat_pc) }}
                        </td>
                    </tr>
                    

                    <tr>
                        <td class="text-bold">Jumlah Dana
                        </td>
                        <td>
                            <b style="font-size: 12pt;">Rp{{ number_format($data->nominal_pengajuan, 0, '.', '.') }},-
                            </b>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Tujuan Pengajuan</td>
                        <td><span class="text-bold">{{ $data->tujuan }}</span><br>
                            @if ($data->bentuk == 'Cash')
                                <span class="text-light badge badge-success">Tunai </span> <br>
                                <span>Dibayarkan Kepada&nbsp;: </span><br>
                                <span>{{ $data->atas_nama }}</span>
                            @else
                                <span class="text-light badge badge-primary">{{ $data->bentuk }} </span> <br>
                                <span>Dibayarkan Kepada&nbsp;: </span><br>
                                <span>{{ $data->atas_nama }} </span> <br>
                                <span>{{ $data->no_rek_tujuan }} -
                                    {{ $data->bank_tujuan }}</span>
                            @endif

                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">
                            Keterangan Pengajuan
                        </td>
                        <td>{{ $data->note ?? '-' }}</td>
                    </tr>
                     <tr>
                        <td class="text-bold">
                            Keterangan PPD
                        </td>
                        <td>{{ $data->keterangan_ppd ?? '-' }}</td>
                    </tr>
                </thead>
            </table>

        </div>
    </div>
    <div class="col-6 mt-2">
        @include('detail.form_persetujuan_disposisi')
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center ml-1">
            <div>
                <i class="fas fa-clipboard-check "></i><b> RESPON DIV. PROGRAM</b>
            </div>
            @if (Auth::user()->gocap_id_pc_pengurus != null)
                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3' and
                        ($data->approval_status_divpro == 'Belum Direspon' or
                            $data->approval_status_divpro == 'Ditolak' or
                            $data->approval_status_divpro == ''))
                    {{-- <div class="ml-2" style="padding-left: 200px;"> --}}
                    <div class="btn-group ">

                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" style="background-color: #cccccc">Respon</button>
                        <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="background-color: #cccccc">
                            <span class="sr-only">Toggle
                                Dropdown</span>
                        </button>

                        <div class="dropdown-menu ">
                            <a wire:click="tombol_acc_internal" onMouseOver="this.style.color='green'"
                                onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                data-target="#modal_acc_internal" type="button"><i class="fas fa-user-check"></i>
                                ACC
                            </a>
                        </div>
                    </div>
                @endif

            @endif
        </div>

        @if (session()->has('alert_direktur'))
            <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
                <i class="far fa-check-circle"></i>
                {{ session('alert_direktur') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="col-12 mt-2">
            <table class="table  table-bordered">
                <thead>



                    @if ($data->approval_date_divpro && $data->status_divpro == 'Diterima')
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Direspon Oleh
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $this->nama_pengurus_pc($data->approver_divpro) }}
                            <br>
                            <span
                                style="font-size:11pt;">{{ $this->jabatan_pengurus_pc($data->approver_divpro) }}</span>

                        </td>
                    @else
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Direspon Oleh
                        </td>
                        <td style="vertical-align: middle;">
                            -

                        </td>
                    @endif

                    @if ($data->approval_date_divpro && $data->status_divpro == 'Diterima')
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Tgl Diterima Div. Program</td>
                            <td>{{ Carbon\Carbon::parse($data->approval_date_divpro)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Status</td>
                            <td>{{ $data->status_divpro }}
                            </td>
                        </tr>


                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Tgl Diserahkan ke Direktur</td>
                            <td>{{ Carbon\Carbon::parse($data->tgl_diserahkan_direktur)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-bold " style="width: 30%">
                                Keterangan</td>
                            <td>{{ $data->keterangan_acc_divpro }}
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
</div>

<div class="col-12 mt-2 intro-lampiran-pengajuans-arsips">
    {{-- judul --}}
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-clipboard-check "></i><b> LAMPIRAN PENGAJUAN</b>
        </div>
        @if (Auth::user()->gocap_id_pc_pengurus == $data->maker_tingkat_pc)
            <button class="btn btn-outline-success btn-sm tombol-tambah" data-toggle="modal"
                wire:click="modal_internal_lampiran_tambah" data-target="#modal_internal_lampiran_tambah"
                type="button"><i class="fas fa-plus-circle"></i>
                Tambah</button>
        @endif
    </div>
    {{-- end judul --}}

    {{-- alert --}}
    @if (session()->has('alert_lampiran'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <i class="far fa-check-circle"></i> {{ session('alert_lampiran') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    {{-- end alert --}}

    {{-- tabel --}}
    {{-- tabel dokumentasi --}}
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

            @forelse($lampiran as $a)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>
                        {{ $a->judul }} <br>
                        {{-- <span style="font-size: 10pt">Diinput Oleh :
                        {{ $this->nama_pengurus_pc($a->maker_tingkat_pc) }}
                        ({{ $this->jabatan_pengurus_pc($a->maker_tingkat_pc) }})
                    </span> --}}
                    </td>
                    <td>
                        <a href="{{ asset('uploads/pengajuan_lampiran/' . $a->file) }}" target="_blank">
                            {{ $a->file }}
                        </a>
                    </td>
                    <td>
                        <!-- tombol aksi -->
                        <div class="btn-group">

                            <button type="button" class="btn btn-success btn-sm" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Kelola</button>
                            <button type="button"
                                class="btn btn-success dropdown-toggle dropdown-toggle-split btn-sm"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle
                                    Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <a onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='black'"
                                    class="dropdown-item tombol-ubah tombol-tambah"
                                    wire:click="modal_internal_lampiran_ubah('{{ $a->id_pengajuan_lampiran }}','{{ $a->file }}')"
                                    type="button" data-toggle="modal" data-target="#modal_internal_lampiran_ubah"><i
                                        class="fas fa-edit"></i>
                                    Detail</a>
                                <a onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                    class="dropdown-item"
                                    wire:click="modal_internal_lampiran_hapus('{{ $a->id_pengajuan_lampiran }}','{{ $a->file }}')"
                                    data-toggle="modal" data-target="#modal_internal_lampiran_hapus"
                                    type="button"><i class="fas fa-trash"></i>
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
    {{-- end tabel --}}
</div>






@include('modal.modal_internal_lampiran_tambah')
@include('modal.modal_internal_lampiran_ubah')
@include('modal.modal_internal_lampiran_hapus')
@include('modal.modal_internal_hapus')
@include('modal.modal_ubah_internal')


@push('script')
    <script>
        window.addEventListener('closeModal', event => {
            $('#modal_ubah_internal').modal('hide')
        });
    </script>
    <script>
        window.addEventListener('close_modal', event => {
            $('#modal_internal_hapus').modal('hide')
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
