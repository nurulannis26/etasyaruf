{{-- diinput oleh --}}

<div class="card mt-3 ml-2 mr-2">
    <div class="card-body">
        @php
            $dp = App\Models\Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        @endphp

        {{-- @if ($dp->status_pengajuan == 'Direncanakan')
                <sup class="text-light badge badge-warning">Data pengajuan belum selesai </sup>
            @endif

            @if ($dp->status_pengajuan == 'Diajukan')
                <sup class="text-light badge badge-success">Data pengajuan selesai </sup>
            @endif

            @if ($data_detail->pil_survey == 'Perlu')
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


        {{-- END badge --}}



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
            {{-- Direktur --}}
            @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Front Office')
                Lengkapi data pengajuan (lampiran & penerima manfaat) lalu konfirmasi selesai input
                {{-- Divisi Penyaluran --}}
            @else
                Data pengajuan, penerima manfaat & lampiran diinput oleh Front Office.
            @endif
        </span>

        {{-- <a class="btn btn-primary" target="_blank" href="{{ route('print_penyaluran_dana') }}">Cetak Penyaluran</a> --}}
        {{-- <a class="btn btn-primary" target="_blank" href="{{ route('print_tanda_terima_fo') }}">Cetak Tanda Terima FO</a> --}}
        {{-- <a class="btn btn-primary" target="_blank" href="{{ route('print_pencairan_dana') }}">Cetak pencairan</a> --}}

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
        </svg> <a href="{{ route('print_tanda_terima_fo', ['id_pengajuan' => $data_detail->id_pengajuan]) }}"
            target="_blank" class="text-center mt-2"> &nbsp;&nbsp;Tanda Terima Front Office.pdf</a>


    </div>
</div>

@if (session()->has('alert_nominal'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <i class="far fa-check-circle"></i> {{ session('alert_nominal') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6  tab-tab-detail-pengajuan-umum-pc">
        {{-- end diinput oleh --}}
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center mt-3">

            @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Front Office')
                <div>
                    <b class="ml-2">A. DETAIL
                        PENGAJUAN UMUM PC</b>
                </div>

                {{-- @if ($data_detail->approval_status != 'Disetujui') --}}


                {{-- @endif --}}
            @else
                <div class="col-lg-12 col-md-6 col-sm-12">
                    <b class="ml-2">A. DETAIL
                        PENGAJUAN UMUM PC</b>
                </div>
            @endif
        </div>
        {{-- end judul --}}





        {{-- tabel --}}
        <div class="col-12 mt-2">
            <table class="table  table-bordered">
                <thead>
                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Nomor Pengajuan</td>
                        <td>{{ $dp->nomor_surat }}
                        </td>
                    </tr>

                    {{-- pemohont --}}

                    <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Pemohon
                        </td>




                        @if ($dp->opsi_pemohon == 'Entitas')
                            <td style="vertical-align: middle;">
                                <sup class="text-light badge badge-primary">{{ $dp->opsi_pemohon }} </sup> <br>
                                <b style="font-size: 12pt;"> {{ $data_detail->nama_entitas }}</b><br>
                                <span style="font-size:11pt;">No Perijinan Entitas
                                    &nbsp;&nbsp;&nbsp;:
                                    {{ $data_detail->no_perijinan_entitas }}</span><br>
                                <span style="font-size:11pt;">Nama PJ Permohonan
                                    &nbsp;&nbsp;&nbsp;:
                                    {{ $data_detail->nama_pj_permohonan_entitas }}</span><br>
                                <span style="font-size:11pt;">No HP &nbsp;&nbsp;&nbsp;:
                                    {{ $data_detail->no_hp_entitas }}</span><br>
                                <span style="font-size:11pt;">Alamat&nbsp; : {{ $data_detail->alamat_entitas }}</span>
                            </td>
                        @elseif($dp->opsi_pemohon == 'Individu')
                            <td style="vertical-align: middle;">
                                <sup class="text-light badge badge-success">{{ $dp->opsi_pemohon }} </sup> <br>
                                <b style="font-size: 12pt;"> {{ $data_detail->nama_pemohon }}</b> <br>
                                <span style="font-size:11pt;">No HP &nbsp;&nbsp;&nbsp;:
                                    {{ $data_detail->nohp_pemohon }}</span><br>
                                <span style="font-size:11pt;">Alamat&nbsp; : {{ $data_detail->alamat_pemohon }}</span>
                            </td>
                        @else
                        <td style="vertical-align: middle;">
                            <sup class="text-light badge badge-secondary">{{ $dp->opsi_pemohon }} </sup> <br>
                            <b style="font-size: 12pt;"> {{ $this->nama_pengurus_pc($dp->pemohon_internal) }}</b> <br>
                            <span style="font-size:11pt;">No HP &nbsp;&nbsp;&nbsp;:
                                {{ $this->nohp_pengurus_pc($dp->pemohon_internal) }}</span><br>
                            <span style="font-size:11pt;">Alamat&nbsp; : {{ $this->alamat_pc($dp->pemohon_internal) }}</span>
                        </td>
                        @endif

                    </tr>
                    {{-- pemohont --}}

                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Tanda Terima</td>
                        <td>{{ ucfirst($data_detail->jenis_tanda_terima) }}
                            @if ($data_detail->jenis_tanda_terima == 'lainnya')
                                ({{ $data_detail->lainnya }})
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Tgl & Nomor Surat</td>
                        <td>{{ Carbon\Carbon::parse($data_detail->tgl_surat)->isoFormat('dddd, D MMMM Y') }} <br>
                            {{ $data_detail->no_surat }}
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
                            Tgl Pelaksanaan</td>
                        <td>{{ Carbon\Carbon::parse($data_detail->tgl_pelaksanaan)->isoFormat('dddd, D MMMM Y') }}
                        </td>
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

    <div class="col-sm-6 mt-3 col-md-6 col-lg-6 ">


        {{-- judul --}}
        <div class="d-flex align-items-center mb-2 text-right" style="flex-grow: 1;">
            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3')
                <div class="text-right" style="flex-grow: 1;">
                    <button wire:click="modal_pc_hapus('{{ $id_pengajuan_detail }}')"
                        style="cursor: pointer" class="btn btn-outline-secondary btn-sm mr-1" data-toggle="modal"
                        data-target="#modal_pc_hapus" type="button">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>

                <button wire:click="modal_ubah_nominal_pengajuan('{{ $id_pengajuan_detail }}')"
                    style="cursor: pointer" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                    data-target="#modal_ubah_nominal_pengajuan" type="button">
                    <i class="fas fa-edit"></i> Ubah
                </button>

                &nbsp;

                @if ($data_detail->approval_status_divpro == 'Disetujui')
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle hover" type="button"
                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Selesai input
                    </button>
                @else
                    <div class="btn-group">
                        @if ($dp->status_pengajuan == 'Diajukan')
                            <button style="cursor: pointer"
                                class="btn btn-outline-secondary btn-sm dropdown-toggle hover" type="button"
                                id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
                                Selesai input
                            </button>
                        @else
                            <button style="cursor: pointer"
                                class="btn btn-outline-secondary btn-sm dropdown-toggle hover" type="button"
                                id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
                                Belum selesai input
                            </button>
                        @endif
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <button class="dropdown-item"
                                wire:click="ajukan_pengajuan('{{ $data_detail->id_pengajuan }}')">
                                <i class="fas fa-check"></i> Selesai input
                            </button>
                            <button class="dropdown-item"
                                wire:click="batalkan_pengajuan('{{ $data_detail->id_pengajuan }}')">
                                <i class="fas fa-ban"></i> Belum selesai input
                            </button>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        {{-- end judul --}}







        {{-- tabel lanjutan --}}
        {{-- tabel --}}
        <div class="col-12 mt-2">
            <table class="table  table-bordered">
                <thead>

                    <tr>
                        <td class="text-bold">Nominal Pengajuan
                        </td>
                        <td>

                            <div class="d-flex justify-content-between">
                                <div>
                                    <b style="font-size: 12pt;">Rp{{ number_format($data_detail->nominal_pengajuan, 0, '.', '.') }},-
                                    </b>
                                    (
                                    Rp{{ number_format($data_detail->satuan_pengajuan, 0, '.', '.') }} x
                                    {{ $data_detail->jumlah_penerima }} Penerima Manfaat )
                                </div>
                                {{-- @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3' and ($data_detail->approval_status == 'Belum Direspon' or $data_detail->approval_status == 'Ditolak'))
                                    <div>
                                        <button
                                            wire:click="modal_ubah_nominal_pengajuan('{{ $id_pengajuan_detail }}')"
                                            class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                            data-target="#modal_ubah_nominal_pengajuan" type="button"><i
                                                class="fas fa-edit"></i>
                                            Ubah</button>
                                    </div>
                                @endif --}}
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Target Penerima Manfaat</td>
                        <td>
                            {{ $data_detail->nama_penerima }}
                        </td>
                    </tr>


                    @if ($data_detail->sumber_dana == 'Dana Infak')
                        {{-- program & pilar --}}
                        <tr>
                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                Pilar
                            </td>
                            <td style="vertical-align: middle;">
                                <b style="font-size: 12pt;"> {{ $this->nama_pilar($data_detail->id_program_pilar) }}
                                </b> <br>
                                {{ $this->nama_kegiatan($data_detail->id_program_kegiatan) }}
                            </td>
                        </tr>
                        {{-- end program & pilar --}}

                        {{-- kegiatan --}}
                        {{-- <tr>
                            <td class="text-bold" style="width: 35%;vertical-align: middle;">
                                Jenis Program
                            </td>
                            <td style="vertical-align: middle;">
                                {{ $this->nama_kegiatan($data_detail->id_program_kegiatan) }}
                            </td>
                        </tr> --}}
                        {{-- end kegiatan --}}
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
                    @endif

                    <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Jenis Bantuan
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $dp->jenis_permohonan }}
                        </td>
                    </tr>

                    {{-- keterangan --}}
                    <tr>
                        <td class="text-bold" style="width: 35%;vertical-align: middle;">
                            Keterangan / Perihal
                        </td>
                        <td style="vertical-align: middle;">
                            {{ $data_detail->pengajuan_note }}
                        </td>
                    </tr>
                    {{-- end keterangan --}}

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








                </thead>
            </table>
        </div>
        {{-- end tabel --}}
    </div>
</div>


<div class="col-sm-12 mt-3 col-md-12 col-lg-12 tab-tab-lampiran-pengajuan-umum-pc">
    {{-- judul --}}
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <b>B. LAMPIRAN PENGAJUAN/PROPOSAL/LAINNYA</b>
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
                    <td colspan="4" class="text-center"> Belum ada data</td>
                </tr>
            @endforelse


        </tbody>
    </table>
    {{-- end tabel --}}
</div>


{{-- penerima manfaat --}}
<div class="col-sm-12 col-lg-12 col-md-12 mt-3 tab-tab-daftar-penerima-manfaat-pengajuan-umum-pc">
    {{-- judul --}}
    <div class="d-flex justify-content-between align-items-center">
        <div class="row">

            {{-- @if ($data_detail->pil_survey == 'Perlu') --}}
            {{-- <div
                    class="col-lg-{{ $data_detail->approval_status != 'Disetujui' ? '10' : '12' }} col-md-12 col-sm-12">
                    <b class="ml-2">C. DAFTAR PENERIMA MANFAAT
                    </b>
                </div> --}}
            <div class="col-lg-12 col-md-12 col-sm-12">
                <b class="ml-2">C. DAFTAR @if ($dp->opsi_pemohon == 'Entitas')
                        ENTITAS PENERIMA MANFAAT
                    @else
                        PENERIMA MANFAAT
                    @endif
                </b>
            </div>
            {{-- @if ($data_detail->approval_status != 'Disetujui' && Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3')
                    <div
                        class="col-lg-{{ $data_detail->approval_status != 'Disetujui' ? '2' : '0' }} col-md-6 col-sm-12 float-right ">
                        <div>

                            <div class="float-right">
                                <div class="dropdown float-right">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle hover"
                                        type="button" id="dropdownMenu2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="true">
                                        @if ($dp->status_survey == 'Diajukan')
                                            Selesai survey
                                        @else
                                            Belum selesai survey
                                        @endif
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                        x-placement="bottom-start"
                                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, 31px, 0px);">
                                        <button class="dropdown-item" aria-expanded="false"
                                            wire:click="ajukan_pengajuan_survey('{{ $data_detail->id_pengajuan }}')">
                                            <i class="fas fa-check"></i>
                                            Selesai survey
                                        </button>
                                        <button class="dropdown-item" aria-expanded="false"
                                            wire:click="batalkan_pengajuan_survey('{{ $data_detail->id_pengajuan }}')">
                                            <i class="fas fa-ban"></i> Belum selesai survey
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                @endif --}}
            {{-- @else --}}
            {{-- <div class="col-lg-12 col-md-12 col-sm-12">
                    <b class="ml-2">C. DAFTAR PENERIMA MANFAAT
                    </b>
                </div> --}}
            {{-- @endif --}}



        </div>

        @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3' ||
                Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3')
            <button class="btn btn-outline-success btn-sm tombol-tambah" class="btn btn-primary" data-toggle="modal"
                wire:click="modal_pengajuan_penerima_manfaat" data-target="#modal_pengajuan_penerima_manfaat"
                type="button"><i class="fas fa-plus-circle"></i>
                Tambah</button>
        @endif
    </div>
    {{-- end judul --}}

    {{-- alert --}}
    @if (session()->has('alert_penerima'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <i class="far fa-check-circle"></i> {{ session('alert_penerima') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('alert_warning'))
        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
            <i class="fa fa-exclamation-circle"></i> {{ session('alert_warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    {{-- end alert --}}

    {{-- tabel --}}
    {{-- tabel dokumentasi --}}

    <table class="table table-bordered table-hover mt-2" style="width:100%">
        <thead>
            <tr class="text-center">
                <th style="width: 10px;vertical-align:middle;">No</th>
                <th style="width: 25%;vertical-align:middle;">Penerima Manfaat</th>
                <th style="width: 35%;vertical-align:middle;">Alamat & No HP</th>
                <th style="width: 20%;vertical-align:middle;">Nominal & Jenis Permohonan</th>
                <th style="width: 20%;vertical-align:middle;">Keterangan</th>
                @if (count($penerima) > 0)
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3' ||
                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3')
                        <th style="vertical-align:middle;">Aksi</th>
                    @endif
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($penerima as $a)
            @empty
                <tr>
                    <td colspan="6" class="text-center"> Belum ada data</td>
                </tr>
            @endforelse
            @foreach ($penerima as $a)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><b style="font-size:16px;">{{ $a->nama }}</b> <br>
                        NIK: {{ $a->nik ?? '-' }} <br>
                        KK: {{ $a->nokk ?? '-' }}
                        {{-- <span style="font-size: 10pt">Diinput Oleh :
                            {{ $this->nama_pengurus_pc($a->maker_tingkat_pc) }}
                            ({{ $this->jabatan_pengurus_pc($a->maker_tingkat_pc) }})
                        </span> --}}
                    </td>
                    <td> <b style="font-size:16px;">{{ $a->alamat ?? '-' }}</b> <br>
                        No HP: {{ $a->nohp ?? '-' }}</td>
                    <td class="text-left">
                        <b style="font-size:16px;">Rp{{ number_format($a->nominal_bantuan, 0, '.', '.') }},- </b>
                        <br>
                        Jenis Bantuan: {{ $a->jenis_bantuan ?? '-' }}
                    </td>
                    {{-- <td>{{ $a->keterangan }}</td> --}}

                    <td><b style="font-size:16px;">{{ $a->keterangan ?? '-' }}</b> <br>
                        {{-- {{ Carbon\Carbon::parse($a->tgl_penyaluran)->isoFormat('dddd, D MMMM Y') }} --}}
                    </td>
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3' ||
                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3')
                        <td>
                            <!-- tombol aksi -->
                            <div class="btn-group">

                                {{-- {{ $this->kelolaSurvey($a->id_pengajuan_penerima) }}
                            {{ Auth::user()->gocap_id_pc_pengurus }} --}}
                                <button type="button" class=" btn btn-success btn-sm" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Kelola</button>
                                <button type="button"
                                    class=" btn btn-success dropdown-toggle dropdown-toggle-split btn-sm"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle
                                        Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    {{-- @if ($data_detail->pil_survey == 'Perlu')
                                    @if (Auth::user()->gocap_id_pc_pengurus != $data->pj_pc and $this->kelolaSurvey($a->id_pengajuan_penerima) == 0)
                                        <a onMouseOver="this.style.color='green'"
                                            onMouseOut="this.style.color='black'" class="dropdown-item tombol-survey"
                                            wire:click="belum_survey()">
                                            <i class="fas fa-poll" style="width:20px"></i>Survey</a>
                                        @if ($this->kelolaSurvey($a->id_pengajuan_penerima) == 1)
                                            <a onMouseOver="this.style.color='orange'"
                                                onMouseOut="this.style.color='black'"
                                                class="dropdown-item tombol-orange" wire:click="belum_survey()">
                                                <i class="fas fa-print" style="width: 20px"></i>Cetak Survey</a>
                                        @endif
                                    @else
                                        <a onMouseOver="this.style.color='green'"
                                            onMouseOut="this.style.color='black'" class="dropdown-item tombol-survey"
                                            wire:click="modal_pengajuan_penerima_manfaat_survey('{{ $a->id_pengajuan_penerima }}')"
                                            type="button" data-toggle="modal"
                                            data-target="#modal_pengajuan_penerima_manfaat_survey"><i
                                                class="fas fa-poll" style="width:20px"></i>
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($a->id_pengajuan_penerima) == 2 ? 'Survey Ulang' : 'Survey' }}</a>
                                        @if ($this->kelolaSurvey($a->id_pengajuan_penerima) == 1)
                                            <a onMouseOver="this.style.color='orange'"
                                                onMouseOut="this.style.color='black'"
                                                class="dropdown-item tombol-orange" target="_blank"
                                              
                                                href="/pc/survey/{{ $a->id_pengajuan_penerima }}"><i
                                                    class="fas fa-print" style="width: 20px"></i>Cetak Survey</a>
                                        @endif
                                    @endif
                                @endif --}}
                                    <a onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='black'"
                                        class="dropdown-item tombol-ubah"
                                        wire:click="modal_pengajuan_penerima_manfaat_ubah('{{ $a->id_pengajuan_penerima }}')"
                                        type="button" data-toggle="modal"
                                        data-target="#modal_pengajuan_penerima_manfaat"><i class="fas fa-edit"
                                            style="width:20px"></i>
                                        Ubah</a>
                                    <a onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                        class="dropdown-item"
                                        wire:click="modal_pengajuan_penerima_manfaat_hapus('{{ $a->id_pengajuan_penerima }}')"
                                        data-toggle="modal" data-target="#modal_pengajuan_penerima_manfaat_hapus"
                                        type="button"><i class="fas fa-trash" style="width:20px"></i>
                                        Hapus</a>
                                </div>
                            </div>
                            {{-- end tombol aksi --}}
                        </td>
                    @endif
                </tr>
            @endforeach

        </tbody>
    </table>
    {{-- end tabel --}}
</div>
{{-- end penerima manfaat --}}



@include('modal.modal_pengajuan_penerima_manfaat')
{{-- @include('modal.modal_pengajuan_penerima_manfaat_survey') --}}
@include('modal.modal_pengajuan_penerima_manfaat_hapus')

@include('modal.modal_internal_lampiran_tambah')
@include('modal.modal_internal_lampiran_ubah')
@include('modal.modal_internal_lampiran_hapus')
@include('modal.modal_pc_hapus')

@include('modal.modal_ubah_nominal_pengajuan')
@push('script')
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
