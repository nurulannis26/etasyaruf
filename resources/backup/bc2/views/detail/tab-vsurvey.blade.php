{{-- diinput oleh --}}

<div class="card mt-3 ml-2 mr-2">
    <div class="card-body">
        @php
            $dp = App\Models\Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        @endphp
        <p class="tab-tab-status-detail-pengajuan-umum-pc d-inline">
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
        </p>
        <br>
        <span>
            <i class="fas fa-info-circle"></i>

            @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Penyaluran')
                Input survey pada masing - masing penerima manfaat lalu konfirmasi selesai survey
            @else
                Survey diinputkan oleh Div. Penyaluran
            @endif
        </span>

        {{-- <a class="btn btn-primary" target="_blank" href="{{ route('print_penyaluran_dana') }}">Cetak Penyaluran</a>
        <a class="btn btn-primary" target="_blank" href="{{ route('print_tanda_terima_fo') }}">Cetak Tanda Terima FO</a>
        <a class="btn btn-primary" target="_blank" href="{{ route('print_pencairan_dana') }}">Cetak pencairan</a> --}}


    </div>


</div>

{{-- penerima manfaat --}}
<div class="col-sm-12 col-lg-12 col-md-12 mt-2 tab-tab-daftar-penerima-manfaat-pengajuan-umum-pc">
    {{-- judul --}}
    <div class="d-flex  align-items-center float-right mb-2 ">
        <div class="row ">
            @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Penyaluran')
                @if ($data_detail->pil_survey == 'Perlu')

                    <div class="col-lg-12 col-md-6 col-sm-12 mr-2 ">
                        <div>
                            @if (empty($data_detail->approval_status_pencairan_direktur))
                                <div class="">
                                    <div class="dropdown ">
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
                            @else
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle hover" type="button"
                                    id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                    disabled>
                                    Selesai survey
                                </button>
                            @endif
                        </div>



                    </div>
                @else
                @endif
            @endif



        </div>

        @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3' ||
                Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3')
            <button class="btn btn-outline-success btn-sm tombol-tambah" class="btn btn-primary" data-toggle="modal"
                wire:click="modal_pengajuan_penerima_manfaat" data-target="#modal_pengajuan_penerima_manfaat2"
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
                <th style="width: 20%;vertical-align:middle;">Alamat & No HP</th>
                <th style="width: 20%;vertical-align:middle;">Nominal & Jenis Permohonan</th>
                <th style="width: 20%;vertical-align:middle;">Keterangan</th>
                @if ($data_detail->approval_status == 'Disetujui')
                    <th style="width: 35%;vertical-align:middle;">Survey</th>
                @endif
                @if ($data_detail->pil_survey == 'Perlu')
                    @if (count($penerima) > 0)
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
                        <b style="font-size:16px;">Rp{{ number_format($a->nominal_bantuan, 0, '.', '.') }},- </b> <br>
                        Jenis Bantuan: {{ $a->jenis_bantuan ?? '-' }}
                    </td>
                    {{-- <td>{{ $a->keterangan }}</td> --}}

                    <td><b style="font-size:16px;">{{ $a->keterangan ?? '-' }}</b> <br>
                        {{-- {{ Carbon\Carbon::parse($a->tgl_penyaluran)->isoFormat('dddd, D MMMM Y') }} --}}
                    </td>
                    @if ($data_detail->approval_status == 'Disetujui')
                        <td>
                            {{-- @if ($data_detail->pil_survey == 'Tidak Perlu')
                                <span class="badge badge-secondary" style="font-size: 14px;">Tidak Perlu</span>
                            @elseif($data_detail->pil_survey == 'Perlu')
                                <span class="badge badge-success" style="font-size: 14px;">Perlu</span>
                            @endif
                            <br> --}}

                            @if ($data_detail->pil_survey == 'Perlu')
                                @php
                                    $tgl = App\Models\SurveyPenerimaManfaat::where('id_penerima_manfaat', $a->id_pengajuan_penerima)->first();
                                @endphp
                                @if ($tgl->tanggal_survey)
                                    {{ Carbon\Carbon::parse($tgl->tanggal_survey)->isoFormat('dddd, D MMMM Y') }}
                                    <br>
                                @endif
                                @php
                                    $pengajuanSurvey = DB::table('survey_penerima_manfaat')
                                        ->leftjoin('pengajuan_penerima', 'pengajuan_penerima.id_pengajuan_penerima', '=', 'survey_penerima_manfaat.id_penerima_manfaat')
                                        ->where('pengajuan_penerima.id_pengajuan_penerima', $a->id_pengajuan_penerima)
                                        ->where('pengajuan_penerima.id_pengajuan', $data_detail->id_pengajuan)
                                        ->where('pengajuan_penerima.id_pengajuan_detail', $data_detail->id_pengajuan_detail)
                                        ->first();
                                    // dd($a->id_pengajuan_penerima .'/////'. $data_detail->id_pengajuan  .'/////'. $data_detail->id_pengajuan_detail);
                                    // dd($pengajuanSurvey->hasil);
                                @endphp

                                @if ($pengajuanSurvey)
                                    @if ($pengajuanSurvey->hasil == 'disetujui')
                                        <span class="badge badge-success" style="font-size: 14px;">Disetujui</span>
                                    @elseif($pengajuanSurvey->hasil == 'ditolak')
                                        <span class="badge badge-danger" style="font-size: 14px;">Ditolak</span>
                                    @endif
                                @else
                                    <span class="badge badge-secondary" style="font-size: 14px;">Belum Direspon</span>
                                @endif
                            @endif

                        </td>
                    @endif
                    @if ($data_detail->pil_survey == 'Perlu')
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

                                    @if ($data_detail->pil_survey == 'Perlu')
                                        @if (Auth::user()->gocap_id_pc_pengurus != $data->pj_pc and $this->kelolaSurvey($a->id_pengajuan_penerima) == 0)
                                            <a onMouseOver="this.style.color='green'"
                                                onMouseOut="this.style.color='black'"
                                                class="dropdown-item tombol-survey" wire:click="belum_survey()">
                                                <i class="fas fa-poll" style="width:20px"></i>Survey</a>
                                            @if ($this->kelolaSurvey($a->id_pengajuan_penerima) == 1)
                                                <a onMouseOver="this.style.color='orange'"
                                                    onMouseOut="this.style.color='black'"
                                                    class="dropdown-item tombol-orange" wire:click="belum_survey()">
                                                    <i class="fas fa-print" style="width: 20px"></i>Cetak Survey</a>
                                            @endif
                                        @else
                                            <a onMouseOver="this.style.color='green'"
                                                onMouseOut="this.style.color='black'"
                                                class="dropdown-item tombol-survey"
                                                wire:click="modal_pengajuan_penerima_manfaat_survey2('{{ $a->id_pengajuan_penerima }}')"
                                                type="button" data-toggle="modal"
                                                data-target="#modal_pengajuan_penerima_manfaat_survey2"><i
                                                    class="fas fa-poll" style="width:20px"></i>
                                                {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($a->id_pengajuan_penerima) == 2 ? 'Survey Ulang' : 'Survey' }}</a>
                                            @if ($this->kelolaSurvey($a->id_pengajuan_penerima) == 1)
                                                <a onMouseOver="this.style.color='orange'"
                                                    onMouseOut="this.style.color='black'"
                                                    class="dropdown-item tombol-orange" target="_blank"
                                                    {{-- wire:click="ngok('{{ $a->id_pengajuan_penerima }}')" --}}
                                                    href="/pc/survey/{{ $a->id_pengajuan_penerima }}"><i
                                                        class="fas fa-print" style="width: 20px"></i>Cetak Survey</a>
                                            @endif
                                        @endif
                                    @endif
                                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3' ||
                                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3')
                                        <a onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='black'"
                                            class="dropdown-item tombol-ubah"
                                            wire:click="modal_pengajuan_penerima_manfaat_ubah('{{ $a->id_pengajuan_penerima }}')"
                                            type="button" data-toggle="modal"
                                            data-target="#modal_pengajuan_penerima_manfaat2"><i class="fas fa-edit"
                                                style="width:20px"></i>
                                            Ubah</a>
                                        <a onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                            class="dropdown-item"
                                            wire:click="modal_pengajuan_penerima_manfaat_hapus('{{ $a->id_pengajuan_penerima }}')"
                                            data-toggle="modal" data-target="#modal_pengajuan_penerima_manfaat_hapus2"
                                            type="button"><i class="fas fa-trash" style="width:20px"></i>
                                            Hapus</a>
                                    @endif
                                </div>

                            </div>
                            {{-- end tombol aksi --}}
                        </td>
                    @endif
                </tr>
            @endforeach
            {{-- {{ dd($data_detail->id_pengajuan); }} --}}
        </tbody>
    </table>
    {{-- end tabel --}}
</div>
{{-- end penerima manfaat --}}



@include('modal.modal_pengajuan_penerima_manfaat2')
@include('modal.modal_pengajuan_penerima_manfaat_survey2')
@include('modal.modal_pengajuan_penerima_manfaat_hapus2')
