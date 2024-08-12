<div>
    {{-- Because she competes with no one, no one can compete with her. --}}

    {{-- program --}}
    {{-- <div class="form-group col-md-6" >
            <label for="inputNama">KATEGORI &nbsp;</label>
            <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
            <select wire:model="id_program" id="id_programs" class="select2dulus form-control " >
                <option value="">Pilih Jenis</option>
                <option value="ba84d782-81a8-11ed-b4ef-dc215c5aad51">PENGUATAN KELEMBAGAAN</option>
                <option value="bed10d9c-81a8-11ed-b4ef-dc215c5aad51">PROGRAM SOSIAL</option>
                <option value="c51700b1-81a8-11ed-b4ef-dc215c5aad51">OPERASIONAL PC LAZISNU</option>
            </select>
        </div> --}}
    {{-- end program --}}

    {{-- pilar --}}
    {{-- <div class="form-group col-md-6"  >
            <label for="inputNama">PILAR &nbsp;</label>
            <sup class="badge badge-danger text-white mb-2 " style="background-color:rgba(230,82,82)">WAJIB</sup>
            <select wire:model="id_program_pilar" name="id_program" id="id_program_pilars" class="select2dulur form-control pilar">
                @if ($id_program == '')
                    <option value="">Pilih Kategori Terlebih Dahulu</option>
                @else
                    <option value="">Pilih Pilar</option>
                    @foreach ($daftar_pilar as $a)
                        <option value="{{ $a->id_program_pilar }}">{{ $a->pilar }}</option>
                    @endforeach
                @endif
            </select>
        </div> --}}
    {{-- end pilar --}}

    {{-- <div class="" wire:ignore>
            <select name="" id="mySelect2" >
                <option value="a">a</option>
                <option value="a">a</option>
            </select> 
        </div> --}}
    {{-- {{ dd($petugas_pc) }} --}}

    <div class="card">
        <div class="card-body">
            {{-- ekspor --}}
            @php
                if ($filter_pilar == '' or $filter_pilar == null) {
                    $filter_pilar = 'Semua';
                }

                if ($filter_kategori == '' or $filter_kategori == null) {
                    $filter_kategori = 'Semua';
                }

                if ($filter_status == '' or $filter_status == null) {
                    $filter_status = 'Semua';
                }
            @endphp
            {{-- baris 1 --}}
            <form action="/{{ $role }}/filter_pc_umum_post" method="post" id="filterFormUmum">
                @csrf
                <div class="form-row">
                    <input type="hidden" name="sub" id="" value="{{ $this->sub }}">
                    {{-- bulan --}}


                    {{-- date range --}}
                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-center icon-input" id="reportrange2" wire:ignore
                                name="filter_daterange2" readonly
                                style="background-color: white;cursor: pointer;min-width:175px;height:37.5px;">
                        </div>
                    </div>

                    {{-- status --}}
                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Status </span>
                            </div>
                            <select wire:model="filter_status" wire:loading.attr="disabled" class="form-control"
                                onchange="submitFormUmum();" name="status_lv">
                                <option value="">Semua</option>
                                <option value="Belum Direspon">Belum Direspon</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Berhasil Dicairkan">Berhasil Dicairkan</option>
                            </select>
                        </div>
                    </div>
                    {{-- end status --}}

                    {{-- pilar --}}
                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Asnaf / Pilar </span>
                            </div>
                            <select wire:model="filter_kategori" id="filter_kategori" wire:loading.attr="disabled"
                                class="form-control" onchange="submitFormUmum();" name="kategori_lv" disabled>
                                <option value="">Semua Kategori</option>
                                <option value="Dana Infak">Pilar</option>
                                <option value="Dana Zakat">Asnaf</option>
                                {{-- <option value="c51700b1-81a8-11ed-b4ef-dc215c5aad51">OPERASIONAL PC LAZISNU</option> --}}
                            </select>
                        </div>
                    </div>
                    {{-- end pilar --}}

                    @if ($this->filter_kategori == 'Dana Infak')
                        {{-- pilar --}}
                        <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Pilar </span>
                                </div>
                                <select wire:model="filter_pilar" wire:loading.attr="disabled" class="form-control"
                                    onchange="submitFormUmum();" name="pilar_lv">

                                    <option value="">Semua Pilar</option>
                                    @foreach ($daftar_pilar2 as $a)
                                        <option value="{{ $a->id_program_pilar }}">{{ $a->pilar }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    @elseif($this->filter_kategori == 'Dana Zakat')
                        <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Asnaf </span>
                                </div>
                                @php
                                    $asnaf = DB::table('asnaf')->get();
                                    //    dd($asnaf);
                                @endphp
                                <select wire:model="filter_asnaf" wire:loading.attr="disabled" class="form-control"
                                    onchange="submitFormUmum();" name="asnaf_lv">

                                    <option value="">Semua Asnaf</option>
                                    @foreach ($asnaf as $asf)
                                        <option value="{{ $asf->id_asnaf }}">{{ $asf->nama_asnaf }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    @else
                        {{-- pilar --}}
                        <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Pilar / Asnaf </span>
                                </div>
                                <input type="text" class="form-control" value="Pilih Sumber Dana" disabled>
                            </div>
                        </div>
                    @endif
                    {{-- end pilar --}}

                    {{--  umum pc  --}}
                    {{-- <div
                    class="col-12 @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3') col-md-3 @else col-md-5 @endif col-sm-12 mb-2 mb-xl-0">
                    <input type="text" class="form-control" value="Diinput Oleh Front Office" readonly>
                </div> --}}
                    {{-- end umum pc --}}


                </div>
            </form>
            {{-- end baris 1 --}}

            {{-- baris 2 --}}

            {{-- baris 2 --}}
            <div class="form-row mt-3">

                {{-- info --}}
                <div
                    class="col-12 @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3') col-md-7 @else col-md-9 @endif  col-sm-12 mb-2 mb-xl-0">
                    <div class="d-flex flex-row bd-highlight align-items-center">
                        <div class="p-2 bd-highlight">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="p-1 bd-highlight">
                            <span>Pengajuan untuk
                                <b style="font-size:12pt;">kebutuhan umum / eksternal</b>. Dapat ditambahkan oleh Front
                                Office.
                            </span>
                        </div>
                    </div>
                </div>
                {{-- end info --}}



                {{-- tombol reset --}}
                {{-- <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                    <button class="btn btn-secondary btn-block tombol-reset-pc" wire:click="reset_filter_umum_pc"><i
                            class="fas fa-sync-alt"></i>&nbsp;
                    </button>
                </div> --}}

                {{-- end tombol reset --}}

                {{-- tombol reset --}}
                <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                    <a class="btn btn-light border-grey hover btn-block tombol-reset-pc"
                        href="/{{ $role }}/internalpc-pc"><i class="fas fa-sync-alt"></i>&nbsp;
                    </a>
                </div>
                {{-- end tombol reset --}}



                <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                    <div class="btn-group btn-block ">
                        <button type="button" class="btn btn-outline-success btn-block dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-file"></i>&nbsp; Ekspor
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" onMouseOver="this.style.color='red'"
                                onMouseOut="this.style.color='black'" type="button"
                                href="/{{ $role }}/print_pc/{{ $filter_daterange2 }}/{{ $filter_status }}"
                                target="_blank">
                                <i class="fas fa-file-pdf"></i>&nbsp; Pdf
                            </a>
                            <a class="dropdown-item" onMouseOver="this.style.color='green'"
                                onMouseOut="this.style.color='black'" type="button" href="#" target="_blank">
                                <i class="fas fa-file-excel"></i>&nbsp; Excel
                            </a>
                        </div>
                    </div>
                </div>

                {{-- end ekspor --}}







                {{-- tombol tambah --}}
                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '300ff4f3-725c-11ed-ad27-e4a8df91d8b3')
                    <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <button wire:click="modal_umum_pc_tambah" class="btn btn btn-success btn-block"
                            class="btn btn-primary" data-toggle="modal" data-target="#modal_umum_pc_tambah"
                            type="button"><i class="fas fa-plus-circle"></i>
                            Tambah</button>
                    </div>
                @endif
                {{-- end tombol tambah --}}


            </div>
            {{-- end baris 2 --}}




        </div>
    </div>
    {{-- end filter --}}

    <div class="row">
        <div class="col-12 col-md-3 mb-2">
            <div class="card ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="h6">FPPD Diajukan

                            </div>
                            <b> Rp. {{ number_format($total_nominal_pengajuan, 0, ',', '.') }},-</b>

                            <div class="h6 mb-0 mb-1" style="color: #28a745">
                                {{ $jumlah_pengajuan }} Data</div>
                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-2">
            <div class="card ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="h6">Disetujui KC

                            </div>

                            <b> Rp. {{ number_format($jumlah_disetujui_direktur, 0, ',', '.') }},-</b>

                            <div class="h6 mb-0 mb-1">
                                <span style="color: #28a745">{{ $acc_direktur }} Acc</span> ({{ $belum_direktur }}
                                Belum, {{ $tolak_direktur }} Ditolak)
                            </div>

                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-2">
            <div class="card ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="h6">Dicairkan Div. Keu

                            </div>

                            <b> Rp. {{ number_format($jumlah_disetujui_keuangan, 0, ',', '.') }},-</b>

                            <div class="h6 mb-0 mb-1">
                                <span style="color: #28a745">{{ $acc_keuangan }} Acc</span> ({{ $belum_keuangan }}
                                Belum, {{ $tolak_keuangan }} Ditolak)
                            </div>

                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-2">
            <div class="card ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="h6">Disalurkan / LPJ

                            </div>

                            <b> Rp. 0,-</b>

                            <div class="h6 mb-0 mb-1">
                                <span style="color: #28a745">0 Acc</span> (0
                                Belum, 0 Ditolak)
                            </div>

                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- tabel --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="Umum-Pc" style="width:100%">

            <thead>
                <tr class="text-center">
                    <th style="width: 20.2px; vertical-align: middle; text-align: center;" class="sorting sorting_asc"
                        tabindex="0" aria-controls="Upzis" rowspan="1" colspan="1" aria-sort="ascending">
                        No
                    </th>
                    <th style="vertical-align: middle; text-align: center; width: 159.2px;" class="sorting"
                        tabindex="0" aria-controls="Upzis" rowspan="1" colspan="1">Nomor
                        &amp; Nominal Pengajuan</th>

                    <th style="width: 96.2px; vertical-align: middle; text-align: center;" class="sorting"
                        tabindex="0" aria-controls="Upzis" rowspan="1" colspan="1">Penerima Manfaat
                    </th>
                    <th style="width: 89.2px; vertical-align: middle; text-align: center;" class="sorting"
                        tabindex="0" aria-controls="Upzis" rowspan="1" colspan="1">
                        Status Survey
                    </th>
                    <th style="width: 89.2px; vertical-align: middle; text-align: center;" class="sorting"
                        tabindex="0" aria-controls="Upzis" rowspan="1" colspan="1">
                        Nominal
                        <br>
                        Disetujui
                    </th>
                    <th style="width: 81.2px; vertical-align: middle; text-align: center;" class="sorting"
                        tabindex="0" aria-controls="Upzis" rowspan="1" colspan="1">
                        Nominal Dapat<br>
                        Dicairkan</th>

                    <th style="width: 75.2px; vertical-align: middle; text-align: center;" class="sorting"
                        tabindex="0" aria-controls="Upzis" rowspan="1" colspan="1">Sumber Dana</th>
                    {{-- <th style="width: 30.2px; vertical-align: middle; text-align: center;" class="sorting"
                        tabindex="0" aria-controls="Upzis" rowspan="1" colspan="1">Aksi</th> --}}

                    {{-- 
                    <th style="vertical-align:middle;">Pilar, Program & Penerima Manfaat </th> --}}
                    {{-- <th style="width: 8%;vertical-align:middle;">
                        Jumlah<br>
                        Penerima Manfaat
                    </th> --}}
                    {{-- <th style="width: 10%;vertical-align:middle;">Status </th> --}}
                    {{-- <th style="vertical-align:middle;">Status <br> Survey</th>
                    <th style="vertical-align:middle;">Status <br> Pencairan</th>
                    <th style="vertical-align:middle;">Status <br> Berita</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse($data as $a)
                @empty
                    <tr>
                        {{-- jika tabel kosong --}}
                        <td colspan="7" class="text-center"> Data
                            tidak ditemukan</td>
                    </tr>
                @endforelse

                @foreach ($data as $a)
                    {{-- @php
                        dd($data);
                    @endphp --}}
                    <tr onclick="openInNewTab('/pc/detail-pengajuan-pc/{{ $a->id_pengajuan }}');"
                        style="cursor: pointer;">
                        <td class="text-bold" style=" cursor: pointer;text-align:center;padding-top:3mm;">
                            {{ $loop->iteration }}</td>

                        <td style=" cursor: pointer;font-size: 12pt;width: 30%; ">
                            @if ($a->status_pengajuan == 'Direncanakan')
                                <sup class="text-light badge badge-warning">Pengajuan Blm Selesai Diinput
                                    FO</sup>
                            @endif

                            @if ($a->status_pengajuan == 'Diajukan')
                                <sup class="text-light badge badge-success">Pengajuan Selesai Diinput FO</sup>
                            @endif
                            <br>
                            @if ($a->opsi_pemohon == 'Entitas')
                                <sup class="text-light badge badge-primary">Pemohon Entitas</sup>
                            @elseif($a->opsi_pemohon == 'Individu')
                                <sup class="text-light badge badge-success">Pemohon Individu</sup>
                            @else
                                <sup class="text-light badge badge-secondary">Pemohon Internal</sup>
                            @endif
                            <br>
                            <span class="text-bold" style="font-size: 13px">
                                {{ $a->nomor_surat }}
                            </span>
                            <br>
                            <div class="d-flex justify-content-between" style="font-size: 13px">
                                <div>Pengajuan</div>
                                <div class="text-bold">
                                    Rp{{ number_format($a->nominal_pengajuan), 0, '.', '.' }},-
                                </div>
                            </div>
                            <div class="d-flex justify-content-between" style="font-size: 13px">
                                <div>Tgl Pengajuan</div>
                                <div class="text-bold">
                                    {{ Carbon\Carbon::parse($a->tgl_pengajuan)->isoFormat('D MMMM Y') }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between" style="font-size: 13px">
                                <div>Tgl Input</div>
                                <div class="text-bold">
                                    {{ Carbon\Carbon::parse($a->created_at)->isoFormat('D MMMM Y') }}
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div style="display: flex; align-items: center; font-size: 13px;">
                                    <span>Pemohon &nbsp;</span>
                                </div>
                                <div class="text-bold" style="font-size: 13px">
                                    @if ($a->opsi_pemohon == 'Entitas')
                                        {{ $a->nama_entitas }}
                                    @elseif($a->opsi_pemohon == 'Individu')
                                        {{ $a->nama_pemohon }}
                                    @elseif($a->opsi_pemohon == 'Internal')
                                        {{ $this->nama_pengurus_pc($a->pemohon_internal) }}
                                    @endif
                                </div>
                            </div>

                        </td>






                        <td style="cursor: pointer; width: 16%;">
                            @if ($a->approval_status_divpro == 'Disetujui')
                                <sup class="text-light badge badge-success">Disposisi Diterima Div. Program</sup>
                            @else
                                <sup class="text-light badge badge-warning">Disposisi Blm Diterima Div. Program
                                </sup>
                                <br>
                            @endif

                            @if ($a->approval_status_divpro == 'Disetujui')
                                @if ($a->approval_status == 'Disetujui')
                                    <sup class="text-light badge badge-success">Disposisi Disetujui KC</sup>
                                @elseif($a->approval_status == 'Ditolak')
                                    <sup class="text-light badge badge-danger">Disposisi Ditolak KC
                                    </sup>
                                @else
                                    <sup class="text-light badge badge-warning">Disposisi Blm Disetujui KC
                                    </sup>
                                @endif
                                <br>
                            @endif
                            
                            @if ($a->approval_status_divpro == 'Disetujui')
                                @if ($a->status_ketua == 'Disetujui')
                                    <sup class="text-light badge badge-success">Ketua Mengetahui</sup>
                                    
                                @elseif($a->respon_ketua != 'Tidak Perlu' and $a->status_ketua == 'Belum Direspon')
                                    <sup class="text-light badge badge-warning">Ketua Blm Merespon
                                    </sup>
                                    
                                @elseif ($a->status_ketua == 'Ditolak')
                                    <sup class="text-light badge badge-danger">Ditolak Ketua</sup>
                                    
                                @endif
                            @endif

                            @if ($a->approval_status_divpro == 'Disetujui')
                                @if ($a->respon_ketua == 'Tidak Perlu')
                                    <sup class="text-light badge badge-secondary">Tanpa Respon Ketua</sup>
                                    
                                @else
                                    
                                @endif
                            @endif

                            <div class="row">
                                <div class="col text-bold  text-left" style="font-size: 10pt;">
                                    Jml.Penerima
                                </div>
                                <div class="col text-bold text-right" style="font-size: 10pt;">
                                    @php
                                        $jml_penerima = App\Models\PengajuanDetail::where('id_pengajuan', $a->id_pengajuan)->sum('jumlah_penerima');
                                    @endphp
                                    {{ $jml_penerima }}
                                </div>
                            </div>
                            <div class="text-left" style="font-size: 10pt;">
                                <span class="text-bold" style="font-size: 10pt;">
                                    Asnaf
                                    {{ DB::table('asnaf')->where('id_asnaf', $a->id_asnaf)->value('nama_asnaf') ?? '-' }}
                                </span>
                                <br>
                                <span class="text-bold" style="font-size: 10pt;">
                                    {{ App\Models\ProgramPilar::where('id_program_pilar', $a->id_program_pilar)->value('pilar') ?? '-' }}
                                </span>
                                <br>
                                {{-- digantii --}}
                                <span>
                                    {{ App\Models\ProgramKegiatan::where('id_program_kegiatan', $a->id_program_kegiatan)->value('nama_program') ?? '-' }}
                                </span>
                                <br>
                                <em class="text-secondary">
                                    {{ $a->pengajuan_note ?? '-' }}
                                </em>
                            </div>
                        </td>





                        <td style=" cursor: pointer; width: 15%;">
                            @if ($a->approval_status == 'Disetujui')
                                @if ($a->pil_survey == 'Perlu')
                                    @if ($a->status_survey == 'Direncanakan')
                                        <sup class="text-light badge badge-warning">Survey Blm Selesai</sup>
                                    @elseif($a->status_survey == 'Diajukan')
                                        <sup class="text-light badge badge-success">Survey Selesai
                                        </sup>
                                    @endif
                                @elseif($a->pil_survey == 'Tidak Perlu')
                                    <sup class="text-light badge badge-secondary">Tanpa Survey
                                    </sup>
                                @else
                                    <sup class="text-light badge badge-warning">Survey Blm Selesai</sup>
                                @endif
                            @else
                                {{-- <sup class="text-light badge badge-secondary">Survey Belum Dipilih
                                </sup> --}}
                                <div class="text-left" style="font-size: 10pt;">
                                    <span class="text-secondary">
                                        Blm Dipilih
                                    </span>
                                </div>
                            @endif
                            <div class="row text-right">
                                <div class="col text-bold  text-left" style="font-size: 10pt;">
                                    Survey
                                </div>
                                @if ($a->pil_survey == 'Perlu')
                                    <div class="col text-bold text-right text-success" style="font-size: 10pt;">
                                        {{ $a->pil_survey }}
                                    </div>
                                @elseif ($a->pil_survey == 'Tidak Perlu')
                                    <div class="col text-bold text-right text-secondary" style="font-size: 10pt;">
                                        {{ $a->pil_survey }}
                                    </div>
                                @else
                                    <div class="col text-bold text-right text-secondary" style="font-size: 10pt;">
                                        -
                                    </div>
                                @endif
                            </div>
                            @if ($a->pil_survey == 'Perlu')
                                <div class="text-right" style="font-size: 10pt;">
                                    @php
                                        $disetujui = App\Models\SurveyPenerimaManfaat::where('id_pengajuan', $a->id_pengajuan)
                                            ->where('hasil', 'disetujui')
                                            ->count();

                                        $ditolak = App\Models\SurveyPenerimaManfaat::where('id_pengajuan', $a->id_pengajuan)
                                            ->where('hasil', 'ditolak')
                                            ->count();

                                        $belum_disurvey = App\Models\PengajuanPenerima::leftJoin('survey_penerima_manfaat', function ($join) {
                                            $join->on('survey_penerima_manfaat.id_penerima_manfaat', '=', 'pengajuan_penerima.id_pengajuan_penerima');
                                        })
                                            ->whereNull('survey_penerima_manfaat.id_penerima_manfaat')
                                            ->where('pengajuan_penerima.id_pengajuan', $a->id_pengajuan)
                                            ->count();

                                    @endphp
                                    <em class="text-success">{{ $disetujui }}
                                        ACC</em><br>
                                    <em class="text-secondary">{{ $belum_disurvey }}
                                        Belum</em><br>
                                    <em class="text-danger">{{ $ditolak }}
                                        Ditolak</em>
                                </div>
                            @endif
                        </td>



                        <td style=" cursor: pointer; width: 15%;">
                            @if ($a->pil_survey == 'Tidak Perlu')
                                @if ($a->approval_status_pencairan_direktur == 'Disetujui')
                                    <sup class="text-light badge badge-success">Pencairan Disetujui KC
                                    </sup>
                                @elseif ($a->approval_status_pencairan_direktur == 'Ditolak')
                                    <sup class="text-light badge badge-danger">Pencairan Ditolak KC
                                    </sup>
                                @endif
                            @elseif($a->pil_survey == 'Perlu' && $a->status_survey == 'Diajukan')
                                @if ($a->approval_status_pencairan_direktur == 'Disetujui')
                                    <sup class="text-light badge badge-success">Pencairan Disetujui KC
                                    </sup>
                                @elseif ($a->approval_status_pencairan_direktur == 'Ditolak')
                                    <sup class="text-light badge badge-danger">Pencairan Ditolak KC
                                    </sup>
                                @else
                                    <sup class="text-light badge badge-warning">Pencairan Blm Disetujui KC
                                    </sup>
                                @endif
                            @endif
                            <div class="text-left" style="font-size: 10pt;">
                                <span class="text-secondary">
                                    @if ($a->approval_status == 'Disetujui')
                                        {{ Carbon\Carbon::parse($a->approval_date_pencairan_direktur)->isoFormat('D MMMM Y') }}
                                    @else
                                        Blm Disetujui
                                    @endif
                                </span>
                            </div>
                            <div class="row text-right">
                                <div class="col text-bold  text-left" style="font-size: 10pt;">
                                    Total
                                </div>
                                <div class="col text-bold text-right" style="font-size: 10pt;">
                                    <b class="text-success" style="font-size: 10pt;">
                                        Rp{{ number_format($a->nominal_disetujui_pencairan_direktur), 0, '.', '.' }},-
                                    </b>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col text-bold  text-left" style="font-size: 10pt;">
                                    Satuan
                                </div>
                                <div class="col text-bold text-right" style="font-size: 10pt;">
                                    <b class="text-success" style="font-size: 10pt;">
                                        Rp{{ number_format($a->satuan_disetujui_pencairan_direktur), 0, '.', '.' }},-
                                    </b>
                                </div>
                            </div>
                            <div class="text-left" style="font-size: 10pt;">
                                <em class="text-secondary">
                                    {{ $a->keterangan_acc ?? '-' }}
                                </em>
                            </div>




                        </td>


                        <td style=" cursor: pointer; width: 15%;">
                            @if ($a->approval_status_pencairan_direktur == 'Disetujui')
                                @if ($a->pencairan_status == 'Berhasil Dicairkan')
                                    <sup class="text-light badge badge-success">Pencairan Disetujui Div. Keu
                                    </sup>
                                @elseif ($a->pencairan_status == 'Ditolak')
                                    <sup class="text-light badge badge-danger">Pencairan Ditolak Div. Keu
                                    </sup>
                                @else
                                    <sup class="text-light badge badge-warning">Pencairan Blm Disetujui Div. Keu
                                    </sup>
                                @endif
                            @endif
                            <div class="text-left" style="font-size: 10pt;">
                                <span class="text-secondary">
                                    @if ($a->pencairan_status == 'Berhasil Dicairkan')
                                        {{ Carbon\Carbon::parse($a->tgl_pencairan)->isoFormat('D MMMM Y') }}
                                    @else
                                        Blm Dicairkan
                                    @endif
                                </span>
                            </div>
                            <div class="row text-right">
                                <div class="col text-bold  text-left" style="font-size: 10pt;">
                                    Total
                                </div>
                                <div class="col text-bold text-right" style="font-size: 10pt;">
                                    <b class="text-warning" style="font-size: 10pt;">
                                        Rp{{ number_format($a->nominal_pencairan), 0, '.', '.' }},-
                                    </b>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col text-bold  text-left" style="font-size: 10pt;">
                                    Satuan
                                </div>
                                <div class="col text-bold text-right" style="font-size: 10pt;">
                                    <b class="text-warning" style="font-size: 10pt;">
                                        Rp{{ number_format($a->satuan_pencairan), 0, '.', '.' }},-
                                    </b>
                                </div>
                            </div>
                            <div class="text-left" style="font-size: 10pt;">
                                <em class="text-secondary">
                                    {{ $a->keterangan_pencairan ?? '-' }}
                                </em>
                            </div>
                            
                            <div class="text-left" style="font-size: 10pt;margin-top: 5pt;">
                                <span class="text-bold" style="font-size: 10pt;">
                                    {{ $a->sumber_dana_opsi }}
                                </span>
                            </div>

                            @if ($a->pencairan_status == 'Berhasil Dicairkan')
                                @php
                                    $rek = App\Models\Rekening::where('id_rekening', $a->id_rekening)->first();
                                    $bmt = App\Models\Bmt::where('id_bmt', $rek->id_bmt)->first();
                                @endphp
                                <div class="text-left" style="font-size: 10pt;">
                                    <em class="text-secondary">
                                        {{ $rek->no_rekening }}
                                    </em>
                                    <br>

                                    <span class="text-bold" style="font-size: 10pt;">
                                        {{ $rek->nama_rekening }}
                                    </span>
                                    <br>
                                    <span class="text-secondary" style="font-size: 10pt;">
                                        {{ $bmt->nama_bmt ?? '' }}
                                    </span>
                                </div>
                            @else
                                <div class="text-left" style="font-size: 10pt;">
                                    <span class="text-secondary">
                                        Rek. blm dipilih
                                        <br>
                                        <b>-</b>
                                        <br>
                                        -
                                    </span>
                                </div>
                            @endif




                        </td>


                        <td style=" cursor: pointer;width: 23%;">
                            @if ($a->approval_status_pencairan_direktur == 'Disetujui')
                                @if ($a->berita_konfirmasi_pc)
                                    <sup class="text-light badge badge-success">LPJ Dikonfirmasi Div. Pyl
                                    </sup>
                                @else
                                    <sup class="text-light badge badge-warning">LPJ Blm Dikonfirmasi Div. Pyl
                                    </sup>
                                @endif


                                @if ($a->konfirmasi_lpj_div_prog != 'Dikonfirmasi')
                                    <sup class="text-light badge badge-warning">LPJ Blm Diperiksa Div. Program
                                    </sup>
                                @else
                                    <sup class="text-light badge badge-success">LPJ Diperiksa Div. Program
                                    </sup>
                                @endif
                                <br>
                            @endif

                            <div class="d-flex justify-content-between" style="font-size: 10pt;">
                                <div>Tgl LPJ</div>
                                <div class="text-bold">
                                    @if ($a->tgl_konfirmasi)
                                        {{ Carbon\Carbon::parse($a->tgl_konfirmasi)->isoFormat('D MMMM Y') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between" style="font-size: 10pt;">
                                <div>Tgl Diperiksa</div>
                                <div class="text-bold">

                                    @if ($a->tgl_diperiksa)
                                        {{ Carbon\Carbon::parse($a->tgl_diperiksa)->isoFormat('D MMMM Y') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            @php
                                    $totalDigunakan = App\Models\lpjUmum::where('id_pengajuan_detail', $a->id_pengajuan_detail)->sum('nominal');
                                    if ($a->nominal_pencairan == null || $a->nominal_pencairan == '') {
                                        $sisaNominal = $a->nominal_disetujui - $totalDigunakan;
                                    } else {
                                        $sisaNominal = $a->nominal_pencairan - $totalDigunakan;
                                    }
                                    
                                    if ($sisaNominal < 0) {
                                        $format_sisa_dana = '-Rp' . number_format(abs($sisaNominal), 0, '.', '.') ;
                                        $warna = 'danger';
                                    } else {
                                        $format_sisa_dana = 'Rp' . number_format($sisaNominal, 0, '.', '.');
                                        $warna = 'black';
                                    }
                            @endphp
                            
                            <div class="row text-right mt-1">
                                    <div class="col text-bold  text-left" style="font-size: 10pt;">
                                        Digunakan
                                    </div>
                                    <div class="col text-bold text-right" style="font-size: 10pt;">
                                        <b class="text-success" style="font-size: 10pt;">
                                            Rp{{ number_format($totalDigunakan), 0, '.', '.' }}
                                        </b>
                                    </div>
                                </div>
                                <div class="row text-right">
                                    <div class="col text-bold  text-left" style="font-size: 10pt;">
                                        Tersisa
                                    </div>
                                    <div class="col text-bold text-right" style="font-size: 10pt;">
                                        <b class="text-{{ $warna }}" style="font-size: 10pt;">
                                            {{ $format_sisa_dana }}
                                        </b>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                    <script>
                        function openInNewTab(url) {
                            window.open(url, '_blank');
                        }
                    </script>
                @endforeach
            </tbody>
        </table>

    </div>
    {{-- end tabel --}}


    @include('modal.modal_umum_pc_tambah')

    @push('script')
        <script>
            $(document).ready(function() {

                window.loadContactDeviceSelect2 = () => {

                    $('#filter_kategori').on('change', function() {
                        @this.set('filter_pilar', '');
                    });

                }

                loadContactDeviceSelect2();
                window.livewire.on('loadContactDeviceSelect2', () => {
                    loadContactDeviceSelect2();
                });

            });
        </script>
    @endpush

    <br>
    <div class="row">
        <div class="col-md-8">

            <div class="card " style="height: 50vh;" wire:ignore>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <strong>
                            Jumlah Kegiatan Berdasarkan Pilar
                        </strong>
                        {{-- <div>

                        <p class="badge badge-success align-items-center">PERIODE - AGUSTUS 2022</p>
                    </div> --}}
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-3">
                        <div class="mt-2">
                            <span class="info-box-text">Total Kegiatan</span>
                            <p class="mb-0 mt-0"><b>1566</b></p>
                            <small class="mb-6 mt-0">+10% dari bulan lalu</small>
                        </div>

                    </div> --}}

                        {{-- <canvas id="barChart3"
                            style="min-height: 200px; height: 250px; max-height: 300px; max-width: 100%;"
                            class="chartjs-render-monitor"></canvas> --}}
                        <canvas id="myChart5"
                            style="min-height: 300px; height: 300px; max-height: 100%; max-width: 100%; "></canvas>


                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card " style="height: 50vh;">

                {{-- <div class="col-md-12 col-sm-12 my-1">
                <div class="btn-group btn-block">
                    <button style="width:50px" class="btn btn-outline-primary"><span style="font-size: 10pt">
                            Total Pengajuan: {{ $pengajuan_total }} </span></button>
                    <button style="width:50px" class="btn btn-outline-success"><span style="font-size: 10pt">
                            Total Kegiatan:
                            {{ $jumlah_rencana_kegiatan }}</span></button>
                    <button style="width:50px" class="btn btn-outline-danger"><span style="font-size: 10pt">
                            Total Penerima : {{ $jumlah_penerima }}</span></button>
                    <button style="width:50px" class="btn btn-outline-secondary"><span style="font-size: 10pt">
                            Total Disetujui : Rp.
                            {{ number_format($nominal_disetujui, 0, ',', '.') }}</span></button>
                </div>

            </div> --}}

                <div class="card-body">
                    <strong>
                        Statistik Pentasyarufan
                    </strong>
                    <br><br>
                    {{-- <p>Notifikasi whatsapp: <span class="text-success">39.832</span> terkirim &
                    <span class="text-danger">9.832</span> gagal
                </p> --}}

                    {{-- @foreach ($detail_pilar as $item)
                    {{ $item->pilar }} <br>ds
                @endforeach --}}

                    <div class="table-responsive">
                        <table class="table">


                            <tr>
                                <th style="width:50%">Jumlah Pengajuan:</th>
                                <td>{{ $jumlah_pengajuan }} </td>
                            </tr>
                            <tr>
                                <th>Total Nominal Pengajuan:</th>
                                <td> {{ number_format($total_nominal_pengajuan, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th> Total Penerima :</th>
                                <td>{{ $penerima_total }}</td>
                            </tr>
                            <tr>
                                <th>Total Nominal Disetujui :</th>
                                <td>Rp. {{ number_format($nominal_disetujui, 0, ',', '.') }}</td>
                            </tr>
                            

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.size = 12;
        const ctx3 = document.getElementById('myChart5');

        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: [
                    'Ekonomi', 'Pendidikan', 'Kesehatan', ['Dakwah', 'Kemanusiaan'],
                    'Lingkungan', 'Operasional'
                ],
                datasets: [{
                    label: 'Jumlah Kegiatan',
                    backgroundColor: 'rgba(40,167,69)',
                    borderColor: 'rgba(40,167,69)',
                    pointRadius: false,
                    pointColor: '#28A745',
                    pointStrokeColor: 'rgba(40,167,69)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(40,167,69)',
                    data: [ {{ $detail_pilar_ekonomi }},
                        {{ $detail_pilar_pendidikan }}, {{ $detail_pilar_kesehatan }}, {{ $detail_pilar_dakwah_dan_kemanusiaan }},
                        {{ $detail_pilar_lingkungan }}, {{ $detail_pilar_amil }}
                    ]
                }, ]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                hover: {
                    mode: 'nearest',
                    intersect: false
                }


            }
        });
    </script>

    @push('script')
        <script>
            $('.lolo').on('change', function() {
                var x = $("#jenis_program").val();
                @this.set('id_program_kegiatan', x);
            });

            $(document).ready(function() {

                window.loadContactDeviceSelect2 = () => {

                    $('#nominal_pengajuan').on('input', function(e) {
                        $('#nominal_pengajuan').val(formatRupiah($('#nominal_pengajuan').val(),
                            'Rp. '));
                    });
                }

                loadContactDeviceSelect2();
                window.livewire.on('loadContactDeviceSelect2', () => {
                    loadContactDeviceSelect2();
                });

            });
        </script>

        @php
            $data_first = App\Models\Pengajuan::orderBy('created_at', 'asc')->first();
            $data_last = App\Models\Pengajuan::orderBy('created_at', 'desc')->first();

            if ($data_first) {
                $data_first = $data_first->created_at->format('Y-m-d');
            } else {
                $data_first = null;
            }

            if ($data_last) {
                $data_last = $data_last->created_at->format('Y-m-d');
            } else {
                $data_last = null;
            }
        @endphp

        <script>
            // daterange
            $(function() {

                var start_date = '{{ $start_date }}';
                var end_date = '{{ $end_date }}';

                var start = moment(start_date);
                var end = moment(end_date);

                function cb(start, end) {
                    $('#reportrange2').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
                }
                // moment.locale('id');
                $('#reportrange2').daterangepicker({
                    startDate: start,
                    endDate: end,
                    locale: {
                        format: 'D MMMM YYYY',
                        separator: ' - ',
                        applyLabel: 'Pilih',
                        cancelLabel: 'Batal',
                        fromLabel: 'Dari',
                        toLabel: 'Hingga',
                        customRangeLabel: 'Pilih Tanggal',
                        weekLabel: 'Mg',
                        daysOfWeek: ['Mg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
                        monthNames: [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                            'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ],
                        firstDay: 1
                    },
                    ranges: {
                        'Hari ini': [moment(), moment()],
                        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                        'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')],
                        'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
                        'Semua': [moment('{{ $data_first }}'), moment('{{ $data_last }}')]

                    }
                }, function(start, end) {
                    $('#reportrange2').val(start.format('Y-MM-DD') + ' - ' + end.format('Y-MM-DD'));
                    $('#filterFormUmum').submit(); // Mengirimkan formulir saat terjadi perubahan
                });

                // moment.locale('id');
                cb(start, end);
                window.start = start;
                window.end = end;

            });

            function submitFormUpzis() {
                $('#reportrange2').val(window.start.format('Y-MM-DD') + ' - ' + window.end.format('Y-MM-DD'));
                $('#filterFormUmum').submit();
            }

            function submitFormUmum() {
                $('#reportrange2').val(window.start.format('Y-MM-DD') + ' - ' + window.end.format('Y-MM-DD'));
                $('#filterFormUmum').submit();
            }
        </script>

        <script>
        $(document).ready(function() {
            $('#Umum-Pc').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                },
                "paging": true,    // Aktifkan pagination
                "searching": true, // Aktifkan search box
                "info": true,      // Aktifkan informasi tampilan data
                "lengthMenu": [5, 10, 25, 50, 100], // Pilihan jumlah baris per halaman
                "pageLength": 5 // Jumlah baris awal yang ditampilkan
            });
        });
    </script>
    @endpush
</div>
