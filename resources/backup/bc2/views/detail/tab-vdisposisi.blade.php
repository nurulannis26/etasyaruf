{{-- diinput oleh --}}

<div class="card mt-3 ml-2 mr-2">
    <div class="card-body">
        @php
            $dp = App\Models\Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        @endphp
        {{-- <p class="tab-tab-status-detail-pengajuan-umum-pc d-inline"> --}}
        {{-- @if ($dp->status_pengajuan == 'Direncanakan')
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
        @endif --}}


        {{-- START badge --}}

        @if ($dp->status_pengajuan == 'Direncanakan')
            <sup class="text-light badge badge-warning">Pengajuan Blm Selesai Diinput FO</sup>
        @endif

        @if ($dp->status_pengajuan == 'Diajukan')
            <sup class="text-light badge badge-success">Pengajuan Selesai Diinput FO</sup>
        @endif


        @if ($data_detail->approval_status_divpro == 'Disetujui')
            <sup class="text-light badge badge-success">Disposisi Diterima Div. Program</sup>
        @else
            <sup class="text-light badge badge-warning">Disposisi blm diterima Div. Program
            </sup>
        @endif

        @if ($data_detail->approval_status_divpro == 'Disetujui')
            @if ($data_detail->approval_status == 'Disetujui')
                <sup class="text-light badge badge-success">Disposisi Disetujui Direktur</sup>
            @elseif($data_detail->approval_status == 'Ditolak')
                <sup class="text-light badge badge-danger">Disposisi Ditolak Direktur
                </sup>
            @else
                <sup class="text-light badge badge-warning">Disposisi Belum disetujui direktur
                </sup>
            @endif
        @endif


        @if ($data_detail->approval_status == 'Disetujui')
            @if ($data_detail->pil_survey == 'Perlu')
                @if ($dp->status_survey == 'Direncanakan')
                    <sup class="text-light badge badge-warning">Survey Blm Selesai</sup>
                @elseif($dp->status_survey == 'Diajukan')
                    <sup class="text-light badge badge-success">Survey Selesai
                    </sup>
                @endif
            @elseif($data_detail->pil_survey == 'Tidak Perlu')
                <sup class="text-light badge badge-secondary">Tanpa Survey
                </sup>
            @else
                <sup class="text-light badge badge-warning">Survey Blm Selesai</sup>
            @endif
        @endif

        @if ($data_detail->pil_survey == 'Tidak Perlu')
            @if ($data_detail->approval_status_pencairan_direktur == 'Disetujui')
                <sup class="text-light badge badge-success">Pencairan Disetujui Direktur
                </sup>
            @elseif ($data_detail->approval_status_pencairan_direktur == 'Ditolak')
                <sup class="text-light badge badge-danger">Pencairan Ditolak Direktur
                </sup>
            @else
                <sup class="text-light badge badge-warning">Pencairan Blm Disetujui Direktur
                </sup>
            @endif
        @elseif($data_detail->pil_survey == 'Perlu' && $dp->status_survey == 'Diajukan')
            @if ($data_detail->approval_status_pencairan_direktur == 'Disetujui')
                <sup class="text-light badge badge-success">Pencairan Disetujui Direktur
                </sup>
            @elseif ($data_detail->approval_status_pencairan_direktur == 'Ditolak')
                <sup class="text-light badge badge-danger">Pencairan Ditolak Direktur
                </sup>
            @else
                <sup class="text-light badge badge-warning">Pencairan Blm Disetujui Direktur
                </sup>
            @endif
        @endif


        @if ($data_detail->approval_status_pencairan_direktur == 'Disetujui')
            @if ($data_detail->pencairan_status == 'Berhasil Dicairkan')
                <sup class="text-light badge badge-success">Pencairan Disetujui Div. Keuangan
                </sup>
            @elseif ($data_detail->pencairan_status == 'Ditolak')
                <sup class="text-light badge badge-danger">Pencairan Ditolak Div. Keuangan
                </sup>
            @else
                <sup class="text-light badge badge-warning">Pencairan Blm Disetujui Div. Keuangan
                </sup>
            @endif
        @endif
        
        @if ($data_detail->pencairan_status == 'Berhasil Dicairkan')

            @if ($data_detail->berita_konfirmasi_pc)
                <sup class="text-light badge badge-success">LPJ Dikonfirmasi Div. Penyaluran
                </sup>
            @else
                <sup class="text-light badge badge-warning">LPJ Blm Dikonfirmasi Div. Penyaluran
                </sup>
            @endif


            @if ($data_detail->konfirmasi_lpj_div_prog != 'Dikonfirmasi')
                <sup class="text-light badge badge-warning">LPJ Blm Diperiksa Div. Program
                </sup>
            @else
                <sup class="text-light badge badge-success">LPJ Diperiksa Div. Program
                </sup>
            @endif
        @endif


        {{-- END badge --}}




        {{-- </p> --}}



        {{-- @if ($survey != null)
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
                        ? 'Ditolak/revisi direktur'
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
                        ? 'Ditolak/revisi direktur'
                        : '' }}

                    {{ $data_detail->approval_status == 'Disetujui' && $data_detail->pencairan_status == 'Belum Dicairkan'
                        ? 'Menunggu Dicairkan'
                        : '' }}

                    {{ $data_detail->approval_status == 'Disetujui' && $data_detail->pencairan_status == 'Berhasil Dicairkan'
                        ? 'Dana Sudah Dicairkan'
                        : '' }}
                </sup>
            @endif --}}

        <br>
        <span>
            <i class="fas fa-info-circle"></i>
            @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Direktur Eksekutif')
                Berikan respon persetujuan disposisi penyaluran & tentukan apakah diperlukan survey
            @elseif(Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Program dan Administrasi Umum')
                Berikan respon konfirmasi disposisi penyaluran
            @else
                Lembar Disposisi Penyaluran (Div. Program & Direktur)
            @endif
        </span>


        {{-- <a class="btn btn-primary" target="_blank" href="{{ route('print_penyaluran_dana') }}">Cetak Penyaluran</a>
        <a class="btn btn-primary" target="_blank" href="{{ route('print_tanda_terima_fo') }}">Cetak Tanda Terima FO</a>
        <a class="btn btn-primary" target="_blank" href="{{ route('print_pencairan_dana') }}">Cetak pencairan</a> --}}

    </div>


</div>

<div class="row ml-2 mr-2">
    <div class="d-flex float-left" style="margin-bottom: 0px; margin-top: 0px">
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
        </svg> <a href="{{ route('print_penyaluran_dana', ['id_pengajuan' => $data_detail->id_pengajuan]) }}"
            target="_blank" class="text-center mt-2"> &nbsp;&nbsp;Lembar Disposisi Penyaluran.pdf</a>


    </div>
</div>

@include('detail.form_persetujuan_modal')
{{-- {{ $this->none_block_tolak_program }} --}}

<div class="tab-persetujuan_direktur-detail-umum-pc">

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
                <b class="text-success">RESPON ACC PENGAJUAN DIREKTUR</b>
                <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>


            {{-- alert --}}
            <div wire:ignore.self>
                @if ($id_rekening != null)
                    @if (str_replace('.', '', $nominal_disetujui) > str_replace('.', '', $saldo))
                        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert"
                            wire:ignore.self>
                            <i class="fas fa-minus-circle"></i>
                            Saldo Tidak Cukup!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                @endif
            </div>

            @if (str_replace('.', '', $satuan_disetujui) > str_replace('.', '', $satuan_pengajuan))
                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-minus-circle"></i>
                    Nominal disetujui melebihi nominal pengajuan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
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
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl
                                    Disetujui</span>
                            </div>
                            <input wire:model="approval_date" type="date" class="form-control">
                        </div>
                    </div>
                    {{-- end tgl disetujui --}}

                    {{-- Pj Pencairan Dana --}}
                    <div class="form-group col-md-7">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span style="width: 200px; display: flex; justify-content: center; align-items: center;"
                                    class="input-group-text bor-abu">PJ
                                    Pencairan
                                    Dana</span>
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

                    {{-- survey --}}
                    <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Survey</span>
                            </div>
                            <select class="form-control" name="pil_survey" wire:model="pil_survey">
                                <option value="" selected>Pilih Survey</option>
                                <option value="Tidak Perlu">Tidak Perlu</option>
                                <option value="Perlu">Perlu</option>

                            </select>
                        </div>
                    </div>
                    {{-- end survey --}}


                    {{-- 
                    <div class="form-group col-md-12">
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

                    {{-- sumber dana --}}
                    {{-- <div class="form-group col-md-12" wire:ignore>
                        <div class="input-group" wire:ignore>
                            <select wire:model="id_rekening" class="form-control" id="inptKabupaten2">
                                <option value="">Rekening Sumber Dana </option>
                                @foreach ($rekening as $a)
                                    <option value="{{ $a->id_rekening }}">
                                        {{ $a->nama_rekening }} -
                                        {{ $a->no_rekening }}
                                        - Rp{{ number_format($a->saldo, 0, '.', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
 --}}


                    {{-- {{ $this->id_rekening }} --}}
                    {{-- end sumber dana --}}




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
                    {{-- <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nominal
                                    Disetujui (Satuan)</span>
                            </div>
                            <input wire:model="satuan_disetujui" type="input" class="form-control "
                                id="satuan_disetujui" placeholder="Masukan Nominal Satuan Disetujui">

                        </div>
                    </div> --}}
                    {{-- end satuan disetujui --}}





                    {{-- nominal disetujui --}}
                    {{-- <div class="form-group col-md-12">
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
                    </div> --}}
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
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Keterangan</span>
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
                                Dengan klik tombol ACC, direktur memberikan persetujuan disposisi penyaluran dengan
                                {{ $this->pil_survey }} Survey @if ($this->pil_survey == 'Tidak Perlu')
                                    Lanjutkan ke langkah 4. Pencairan Keuangan
                                @endif
                            </span>
                        </div>
                    </div>
                    {{-- end info --}}

                    <div class="form-group col-md-9">
                    </div>

                    {{-- tombol acc --}}
                    <div class="form-group col-md-3">
                        @if ($staf_keuangan == '' or $satuan_disetujui == '' or $keterangan_acc == '' or $pil_survey == '')
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
                <b class="text-danger">RESPON TOLAK PENGAJUAN DIREKTUR</b>
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
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl
                                    Penolakan</span>
                            </div>
                            <input wire:model="denial_date" type="date" class="form-control">
                        </div>
                    </div>
                    {{-- end tgl penolakan --}}


                    {{-- denial note --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Alasan</span>
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


</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6  tab-tab-detail-pengajuan-umum-pc">
        {{-- end diinput oleh --}}
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            {{-- <div class="row"> --}}
            <div>
                <i class="fas fa-clipboard-check mr-2"></i><b> A. RESPON DIV. PROGRAM </b>

            </div>

            {{-- @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Front Office') --}}
            {{-- <div
                        class="col-lg-{{ $data_detail->approval_status != 'Disetujui' ? '10' : '12' }} col-md-6 col-sm-12">
                        <b class="ml-2">A. RESPON DIV. PROGRAM</b>
                    </div>
                    <div
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
            {{-- @else --}}
            {{-- <div> --}}
            {{-- <i class="fas fa-clipboard-check mr-2"></i><b> A. RESPON DIV. PROGRAM </b> --}}
            {{-- <p class="tab-persetujuan-direktur-status-detail-umum-pc d-inline">
                                @if ($data_detail->approval_status == 'Belum Direspon')
                                    <sup class="badge badge-danger text-white bg-warning mb-2">{{ $data_detail->approval_status }}</sup>
                                @elseif($data_detail->approval_status == 'Disetujui')
                                    <sup class="badge badge-danger text-white bg-success mb-2">{{ $data_detail->approval_status }}</sup>
                                @else
                                    <sup class="badge badge-danger text-white bg-danger mb-2">{{ $data_detail->approval_status }}</sup>
                                @endif
                            </p> --}}
            {{-- </div> --}}
            @if (Auth::user()->gocap_id_pc_pengurus != null)


                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3' and
                        ($data_detail->approval_status_divpro == 'Belum Direspon' or
                            $data_detail->approval_status_divpro == 'Ditolak' or
                            $data_detail->approval_status_divpro == ''))
                    {{-- <div class="ml-2" style="padding-left: 200px;"> --}}
                    <div class="btn-group ">

                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" style="background-color: #cccccc">Respon</button>
                        <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="background-color: #cccccc">
                            <span class="sr-only">Toggle
                                Dropdown</span>
                        </button>

                        <div class="dropdown-menu ">
                            <a wire:click="tombol_acc_program" onMouseOver="this.style.color='green'"
                                onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                data-target="#modal_acc" type="button"><i class="fas fa-user-check"></i>
                                {{-- @if ($data_detail->approval_status_divpro == 'Ditolak')
                                                ACC Ulang
                                            @else --}}
                                ACC
                                {{-- @endif --}}
                            </a>
                            {{-- <a wire:click="tombol_tolak_program" onMouseOver="this.style.color='red'"
                                            onMouseOut="this.style.color='black'" class="dropdown-item"
                                            data-toggle="modal" data-target="#modal_tolak" type="button"><i
                                                class="fas fa-ban"></i>
                                            Tolak</a> --}}
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
            {{-- @endif --}}
            {{-- </div> --}}
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

                    {{-- <tr>
                        @if ($data_detail->approval_status_divpro == 'Disetujui' or $data_detail->approval_status_divpro == 'Belum Direspon' or $data_detail->approval_status_divpro == '')
                            <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                Direspon Oleh:
                            </td>
                            <td style="vertical-align: middle;">
                                @if ($data_detail->denial_divpro == null)
                                    -
                                @else
                                    {{ $this->nama_pengurus_pc($data_detail->denial_divpro) }}
                                    <br>
                                    <span
                                        style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data_detail->denial_divpro) }}
                                        - {{ $this->nama_pc($data->id_pc) }})</span>
                                @endif
                            </td>
                        @elseif($data_detail->approval_status_divpro == 'Ditolak')
                            <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                Ditolak Oleh
                            </td>
                            <td style="vertical-align: middle;">
                                @if ($data_detail->denial_divpro == null)
                                    -
                                @else
                                    {{ $this->nama_pengurus_pc($data_detail->denial_divpro) }}
                                    <br>
                                    <span
                                        style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data_detail->denial_divpro) }}
                                        - {{ $this->nama_pc($data->id_pc) }})</span>
                                @endif
                            </td>
                        @endif
                    </tr> --}}

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

                    {{-- <tr>
                        <td class="text-bold " style="width: 30%">
                            Tgl Respon</td>
                        <td>{{ Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('dddd, D MMMM Y') }}
                        </td>
                    </tr> --}}

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

                    {{-- <tr>
                        <td class="text-bold">Nominal Pengajuan
                        </td>
                        <td>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <b style="font-size: 12pt;">Rp{{ number_format($data_detail->nominal_pengajuan, 0, '.', '.') }},-
                                    </b>
                                    ({{ $data_detail->jumlah_penerima }} x
                                    Rp{{ number_format($data_detail->satuan_pengajuan, 0, '.', '.') }})
                                </div>
                                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3' and ($data_detail->approval_status == 'Belum Direspon' or $data_detail->approval_status == 'Ditolak'))
                                    <div>
                                        <button
                                            wire:click="modal_ubah_nominal_pengajuan('{{ $id_pengajuan_detail }}')"
                                            class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                            data-target="#modal_ubah_nominal_pengajuan" type="button"><i
                                                class="fas fa-edit"></i>
                                            Ubah</button>
                                    </div>
                                @endif
                            </div>

                        </td>
                    </tr> --}}

                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Sumber Dana
                        </td>
                        <td style="vertical-align: middle;">

                            @if ($data_detail->sumber_dana == 'Dana Zakat')
                                <span class="badge badge-success" style="font-size:15px;font-weight:normal">
                                    {{ $data_detail->sumber_dana }}
                                </span>
                            @else
                                <span class="badge badge-primary" style="font-size:15px;font-weight:normal">
                                    {{ $data_detail->sumber_dana }}
                                </span>
                            @endif


                        </td>
                    </tr> --}}

                    {{-- @if ($data_detail->sumber_dana == 'Dana Infak')
                     
                        <tr>
                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                Pilar
                            </td>
                            <td style="vertical-align: middle;">
                                {{ $this->nama_pilar($data_detail->id_program_pilar) }}
                            </td>
                        </tr>
                       
                        <tr>
                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                Jenis Program
                            </td>
                            <td style="vertical-align: middle;">
                                {{ $this->nama_kegiatan($data_detail->id_program_kegiatan) }}
                            </td>
                        </tr>
                     
                    @endif

                    @if ($data_detail->sumber_dana == 'Dana Zakat')
                        <tr>
                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                Asnaf
                            </td>
                            @php
                                $asn = DB::table('asnaf')
                                    ->where('id_asnaf', $data_detail->id_asnaf)
                                    ->value('nama_asnaf');
                            @endphp
                            <td style="vertical-align: middle;">
                                {{ $asn }}
                            </td>
                        </tr>
                    @endif --}}


                    {{-- keterangan --}}
                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Keterangan
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $data_detail->pengajuan_note }}
                        </td>
                    </tr> --}}
                    {{-- end keterangan --}}

                    {{-- survey --}}
                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Survey
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($this->cek_survey($id_pengajuan) == 'Perlu')
                                <span class="badge badge-success" style="font-size:15px;font-weight:normal">
                                    {{ $this->cek_survey($id_pengajuan) }}
                                </span>
                            @else
                                <span class="badge badge-secondary" style="font-size:15px;font-weight:normal">
                                    {{ $this->cek_survey($id_pengajuan) }}
                                </span>
                            @endif

                        </td>
                    </tr> --}}
                    {{-- end survey --}}

                    {{-- penerima manfaat --}}
                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Penerima Manfaat
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $data_detail->nama_penerima }}<br>
                            <span style="font-size:11pt;">Jumlah Penerima : {{ $data_detail->jumlah_penerima }}</span>
                        </td>
                    </tr> --}}
                    {{-- penerima manfaat --}}

                    {{-- pemohont --}}
                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Pemohon
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $data_detail->nama_pemohon }}<br>
                            <span style="font-size:11pt;">No HP &nbsp;&nbsp;&nbsp;:
                                {{ $data_detail->nohp_pemohon }}</span><br>
                            <span style="font-size:11pt;">Alamat&nbsp; : {{ $data_detail->alamat_pemohon }}</span>
                        </td>
                    </tr> --}}
                    {{-- pemohont --}}

                    {{-- <tr>
                <td class="text-bold">
                    Lembar
                    Pengajuan <br>(generate
                    by
                    sistem)
                </td>
                <td style="vertical-align: middle;">
                    <a href="/pc/print{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_PERMOHONAN' }}"
                        target="_blank" class="btn btn-sm btn-outline-success float-left mr-2" role="button"
                        style="border-radius:10px; ">Download
                    </a>
                </td>
            </tr> --}}

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
                                        onMouseOut="this.style.color='black'" class="dropdown-item"
                                        data-toggle="modal" data-target="#modal_acc" type="button"><i
                                            class="fas fa-user-check"></i>
                                        @if ($data_detail->approval_status == 'Ditolak')
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


                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Sumber Dana
                        </td>
                        <td style="vertical-align: middle;">

                            @if ($data_detail->sumber_dana == 'Dana Zakat')
                                <span class="badge badge-success" style="font-size:15px;font-weight:normal">
                                    {{ $data_detail->sumber_dana }}
                                </span>
                            @else
                                <span class="badge badge-primary" style="font-size:15px;font-weight:normal">
                                    {{ $data_detail->sumber_dana }}
                                </span>
                            @endif


                        </td>
                    </tr> --}}



                    {{-- @if ($data_detail->sumber_dana == 'Dana Infak')
                      
                        <tr>
                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                Pilar
                            </td>
                            <td style="vertical-align: middle;">
                                {{ $this->nama_pilar($data_detail->id_program_pilar) }}
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                Jenis Program
                            </td>
                            <td style="vertical-align: middle;">
                                {{ $this->nama_kegiatan($data_detail->id_program_kegiatan) }}
                            </td>
                        </tr>
                       
                    @endif

                    @if ($data_detail->sumber_dana == 'Dana Zakat')
                        <tr>
                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                Asnaf
                            </td>
                            @php
                                $asn = DB::table('asnaf')
                                    ->where('id_asnaf', $data_detail->id_asnaf)
                                    ->value('nama_asnaf');
                            @endphp
                            <td style="vertical-align: middle;">
                                {{ $asn }}
                            </td>
                        </tr>
                    @endif --}}


                    {{-- keterangan --}}
                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Keterangan
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $data_detail->pengajuan_note }}
                        </td>
                    </tr> --}}

                    {{-- <tr>
                        <td class="text-bold">Nominal Pengajuan
                        </td>
                        <td>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <b style="font-size: 12pt;">Rp{{ number_format($data_detail->nominal_pengajuan, 0, '.', '.') }},-
                                    </b>
                                    ({{ $data_detail->jumlah_penerima }} x
                                    Rp{{ number_format($data_detail->satuan_pengajuan, 0, '.', '.') }})
                                </div>
                                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3' and ($data_detail->approval_status == 'Belum Direspon' or $data_detail->approval_status == 'Ditolak'))
                                    <div>
                                        <button
                                            wire:click="modal_ubah_nominal_pengajuan('{{ $id_pengajuan_detail }}')"
                                            class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                            data-target="#modal_ubah_nominal_pengajuan" type="button"><i
                                                class="fas fa-edit"></i>
                                            Ubah</button>
                                    </div>
                                @endif
                            </div>

                        </td>
                    </tr> --}}

                    {{-- <tr>
                        <td> <b style="font-size: 12pt;">Sumber Dana</b></td>
                        <td>{{ $data_detail->sumber_dana }}</td>
                    </tr>

                    @php
                        $rek = App\Models\Rekening::where('id_rekening', $data_detail->id_rekening)->first();
                    @endphp
                    @if ($data_detail->id_rekening)
                        <tr>
                            <td>
                                <b style="font-size: 12pt;">Rekening</b>
                            </td>
                            <td>
                                {{ $rek->nama_rekening . ' - ' . $rek->no_rekening }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>
                                <b style="font-size: 12pt;">Rekening</b>
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                    @endif --}}

                    {{-- {{ $data_detail->keterangan_acc .$data_detail->denial_note}} --}}
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

                    {{-- end keterangan --}}

                    {{-- survey --}}
                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Survey
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($this->cek_survey($id_pengajuan) == 'Perlu')
                                <span class="badge badge-success" style="font-size:15px;font-weight:normal">
                                    {{ $this->cek_survey($id_pengajuan) }}
                                </span>
                            @else
                                <span class="badge badge-secondary" style="font-size:15px;font-weight:normal">
                                    {{ $this->cek_survey($id_pengajuan) }}
                                </span>
                            @endif

                        </td>
                    </tr> --}}
                    {{-- end survey --}}

                    {{-- penerima manfaat --}}
                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Penerima Manfaat
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $data_detail->nama_penerima }}<br>
                            <span style="font-size:11pt;">Jumlah Penerima : {{ $data_detail->jumlah_penerima }}</span>
                        </td>
                    </tr> --}}
                    {{-- penerima manfaat --}}

                    {{-- pemohont --}}
                    {{-- <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Pemohon
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $data_detail->nama_pemohon }}<br>
                            <span style="font-size:11pt;">No HP &nbsp;&nbsp;&nbsp;:
                                {{ $data_detail->nohp_pemohon }}</span><br>
                            <span style="font-size:11pt;">Alamat&nbsp; : {{ $data_detail->alamat_pemohon }}</span>
                        </td>
                    </tr> --}}
                    {{-- pemohont --}}



                    {{-- <tr>
                <td class="text-bold">
                    Lembar
                    Pengajuan <br>(generate
                    by
                    sistem)
                </td>
                <td style="vertical-align: middle;">
                    <a href="/pc/print{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_PERMOHONAN' }}"
                        target="_blank" class="btn btn-sm btn-outline-success float-left mr-2" role="button"
                        style="border-radius:10px; ">Download
                    </a>
                </td>
            </tr> --}}

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
