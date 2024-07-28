{{-- Disetujui oleh Direktur Eksekutif --}}
<div class="card mt-3 ml-2 mr-2">
    <div class="card-body">
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
                <sup class="badge badge-warning text-white mb-2">Pengajuan blm disetujui KC</sup>
            @elseif($data->approval_status == 'Disetujui')
                <sup class="badge badge-success text-white mb-2">Pengajuan disetujui KC</sup>
            @else
                <sup class="badge badge-danger text-white mb-2">Pengajuan ditolak KC</sup>
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
            <span class="col-md-6">
                <i class="fas fa-info-circle"></i>
                Persetujuan pencairan dana oleh Kepala Cabang & Div. Keuangan
            </span>
            <div class="col-md-6 text-md-right">
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
                    href="/pc/internal{{ $data->id_internal }}/{{ str_replace('/', '_', $data->nomor_surat) . '_INTERNAL' }}"
                    target="_blank" class="text-center"> &nbsp;&nbsp;FPPD.pdf</a>


            </div>
        </div>
    </div>
</div>




@if (session()->has('alert_notif'))
    <div class="alert alert-warning alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
        <i class="far fa-check-circle"></i>
        {{ session('alert_notif') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('upload_kwitansi'))
    <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
        <i class="far fa-check-circle"></i>
        {{ session('upload_kwitansi') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


@if (session()->has('upload_kwitansi_gagal'))
    <div class="alert alert-danger alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
        <i class="far fa-check-circle"></i>
        {{ session('upload_kwitansi_gagal') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


{{-- end Disetujui oleh Direktur Eksekutif --}}
<div class="intro-detail-pencairan-keuangan-arsips">
    {{-- judul --}}
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="d-flex justify-content-between align-items-center mt-2 ">
                <div>
                    <b> A. PERSETUJUAN KEPALA CABANG </b>
                    <p class="intro-detail-status-persetujuan-direkturs-arsips d-inline">
                        {{-- @if ($data->approval_status == 'Belum Direspon')
                            <sup
                                class="badge badge-danger text-white bg-warning mb-2">{{ $data->approval_status }}</sup>
                        @elseif($data->approval_status == 'Disetujui')
                            <sup
                                class="badge badge-danger text-white bg-success mb-2">{{ $data->approval_status }}</sup>
                        @else
                            <sup class="badge badge-danger text-white bg-danger mb-2">{{ $data->approval_status }}</sup>
                        @endif --}}
                    </p>
                </div>
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                            ($data->approval_status_divpro == 'Disetujui' or $data->approval_status_divpro == 'Ditolak'))
                        @if ($data->pencairan_status != 'Berhasil Dicairkan')
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
                                            onMouseOut="this.style.color='black'" class="dropdown-item"
                                            data-toggle="modal" data-target="#modal_acc" type="button"><i
                                                class="fas fa-user-check"></i>
                                            @if ($data->approval_status == 'Ditolak' || $data->approval_status == 'Disetujui')
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
                        <a wire:click="close" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
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

                            <div class="form-group col-md-12">
                                <input type="input" class="form-control"
                                    value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                                    readonly>
                            </div>

                            {{-- end direktur --}}


                            {{-- tgl disetujui --}}
                            <div class="form-group col-md-12">
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
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu"
                                            style="width: 200px; text-align: center; display: block;">PJ Pencairan
                                            Dana</span>
                                    </div>
                                    <select wire:model="staf_keuangan" wire:loading.attr="disabled"
                                        class="form-control">
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
                                        <span class="input-group-text"
                                            style="width: 200px; text-align: center; display: block;">Nominal Pengajuan
                                        </span>
                                    </div>
                                    <input value="{{ number_format($data->nominal_pengajuan, 0, '.', '.') }}"
                                        type="text" class="form-control" readonly>
                                </div>
                            </div>



                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 200px; text-align: center; display: block;">Nominal Disetujui
                                        </span>
                                    </div>
                                    <input wire:model="nominal_disetujui" type="text" class="form-control"
                                        id="nominal_disetujui" placeholder="Masukan Nominal Satuan Disetujui">
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu"
                                            style="width: 200px; display: flex; justify-content: center; align-items: center;">Rekomendasi Sumber
                                            Dana</span>
                                    </div>
                                    <select wire:model="sumber_dana" wire:loading.attr="disabled"
                                        class="form-control">
                                        <option value="" selected>Pilih Rekomendasi Sumber Dana</option>
                                        <option value="Dana Zakat">Dana Zakat</option>
                                        <option value="Dana Infak Umum">Dana Infak Umum</option>
                                        <option value="Dana Infak Terikat">Dana Infak Terikat</option>
                                        <option value="Dana Amil">Dana Amil</option>
                                    </select>
                                </div>

                            </div>
                            
                            {{-- asnaf --}}
                            @if ($this->sumber_dana == 'Dana Zakat')
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bor-abu"
                                                style="width: 170px; display: flex; justify-content: center; align-items: center;">Asnaf</span>
                                        </div>
                                        <select wire:model="id_asnaf" wire:loading.attr="disabled"
                                            class="form-control">
                                            <option value="" selected>Pilih Asnaf</option>
                                            @php
                                                $asnaf_get = DB::table('asnaf')->get();
                                            @endphp
                                            @foreach ($asnaf_get as $as)
                                                <option value="{{ $as->id_asnaf }}">{{ $as->nama_asnaf }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                @php $this->id_asnaf = null; @endphp
                            @endif
                            @if ($this->sumber_dana == 'Dana Infak Umum' or $this->sumber_dana == 'Dana Infak Terikat')
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bor-abu"
                                                style="width: 170px; display: flex; justify-content: center; align-items: center;">Pilar</span>
                                        </div>
                                        <select wire:model="id_program_pilar" id="id_program_pilars"
                                            class="select2pils form-control pilar">
                                            <option value="">Pilih Pilar</option>
                                            @php
                                                $pilar_get_edit = DB::table('program_pilar')
                                                    ->orderBy('pilar', 'ASC')
                                                    ->get();
                                            @endphp
                                            @foreach ($pilar_get_edit as $as)
                                                <option value="{{ $as->id_program_pilar }}">{{ $as->pilar }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <select class="form-control" id="select2-dropdown"
                                            wire:model="id_program_kegiatan"
                                            data-placeholder="Pilih Pilar Terlebih Dahulu">

                                            @php
                                                $daftar_kegiatan = App\Models\ProgramKegiatan::where(
                                                    'id_program_pilar',
                                                    $this->id_program_pilar,
                                                )
                                                    ->whereRaw('LENGTH(no_urut) = 3')
                                                    ->orderBy('no_urut', 'ASC')
                                                    ->get();

                                                $daftar_kegiatan2 = App\Models\ProgramKegiatan::where(
                                                    'id_program_pilar',
                                                    $this->id_program_pilar,
                                                )
                                                    ->whereRaw('LENGTH(no_urut) = 4')
                                                    ->orderBy('no_urut', 'ASC')
                                                    ->get();
                                            @endphp
                                            @if ($this->id_program_pilar == '')
                                                <option value="" disabled>Pilih Pilar Terlebih Dahulu</option>
                                            @else
                                                @foreach ($daftar_kegiatan as $aa)
                                                    <option value="{{ $aa->id_program_kegiatan }}">
                                                        {{ $aa->no_urut }}
                                                        {{ $aa->nama_program }}</option>
                                                @endforeach
                                                @foreach ($daftar_kegiatan2 as $bb)
                                                    <option value="{{ $bb->id_program_kegiatan }}">
                                                        {{ $bb->no_urut }}
                                                        {{ $bb->nama_program }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            @else
                                @php
                                    $this->id_program_pilar = null;
                                    $this->id_program_kegiatan = null;
                                @endphp
                            @endif

                            @if ($this->sumber_dana == 'Dana Amil')
                                @php
                                    $this->id_asnaf = null;
                                    $this->id_program_pilar = null;
                                    $this->id_program_kegiatan = null;
                                @endphp
                            @endif
                            
                           

                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 200px; text-align: center; display: block;">Keterangan
                                        </span>
                                    </div>
                                    <input wire:model="approval_note" type="text" class="form-control"
                                        id="approval_note" placeholder="Masukan Keterangan">
                                </div>
                            </div>





                            {{-- info --}}
                            <div class="form-group col-md-12">
                                <div class="card card-body " style="background-color:#e0e0e0;">
                                    <b>INFORMASI!</b>
                                    <span>
                                        Dengan klik tombol ACC, Kepala Cabang memberikan persetujuan untuk dilakukan
                                        pencairan dana
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
                        <a wire:click="close" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <form wire:submit.prevent="tolak">

                        <div class="form-row mt-3">

                            {{-- Direktur --}}
                            <div class="form-group col-md-12">
                                <input type="input" class="form-control"
                                    value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                                    readonly>
                            </div>
                            {{-- end rekening --}}

                            {{-- tgl penolakan --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 170px; text-align: center; display: block;">Tgl
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
                                            style="width: 170px; text-align: center; display: block;">Alasan</span>
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
                                        Dengan klik tombol tolak, Kepala Cabang memberikan penolakan untuk dilakukan
                                        pencairan dana
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
                        
                        <tr>
                            <td class="text-bold">Rekomendasi Sumber Dana
                            </td>
                            <td>
                                @if ($data->sumber_dana == null)
                                    -
                                @else
                                    <span style="font-size: 12pt;">{{ $data->sumber_dana }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        
                            <tr>
                                <td class="text-bold">Asnaf
                                </td>
                                <td>
                                    {{ $asnaf ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold">Pilar
                                </td>
                                <td>
                                    <b style="font-size: 12pt;">
                                        {{ $this->nama_pilar($data->id_program_pilar) ?? '-' }}
                                    </b> <br>
                                    {{ $this->nama_kegiatan($data->id_program_kegiatan) ?? '-' }}


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
                        @if ($data->approval_status != 'Ditolak')

                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Keterangan
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($data->approval_note == null)
                                        -
                                    @else
                                        {{ $data->approval_note }}
                                    @endif
                                </td>
                            </tr>

                        @endif




                    </thead>
                </table>
                {{-- end tabel --}}


            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div>
                    <b> B. PENCAIRAN KEUANGAN </b>
                    <p class="intro-detail-status-persetujuan-pencairan-keuangan-arsips d-inline">
                        {{-- @if ($data->pencairan_status == 'Belum Dicairkan')
                            <sup
                                class="badge badge-danger text-white bg-warning mb-2">{{ $data->pencairan_status }}</sup>
                        @else
                            <sup
                                class="badge badge-danger text-white bg-success mb-2">{{ $data->pencairan_status }}</sup>
                        @endif --}}
                    </p>
                </div>
                {{-- {{ dd($data->staf_keuangan_pc) }} --}}
                @if (Auth::user()->gocap_id_pc_pengurus == $data->staf_keuangan_pc)

                        @if ($data->approval_status == 'Belum Direspon' or $data->approval_status == 'Ditolak')
                            <div class="mr-2">
                                <div class="btn-group float-right">
                                    <button type="button" class="btn" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false" style="background-color: #cccccc"
                                        disabled>Respon</button>
                                    <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" disabled aria-haspopup="true" aria-expanded="false"
                                        style="background-color: #cccccc">
                                        <span class="sr-only">Toggle
                                            Dropdown</span>
                                    </button>
                                </div>

                            </div>
                        @else
                            <div class="mr-2">
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
                                        <a wire:click="tombol_acc" onMouseOver="this.style.color='green'"
                                            onMouseOut="this.style.color='black'" class="dropdown-item"
                                            type="button"><i class="fas fa-user-check"></i>
                                            @if ($data->pencairan_status == 'Belum Dicairkan')
                                                Cairkan Dana
                                            @else
                                                Cairkan Ulang
                                            @endif
                                            </a>
                                        <a wire:click="tombol_tolak_keuangan" onMouseOver="this.style.color='red'"
                                            onMouseOut="this.style.color='black'" class="dropdown-item"
                                            data-toggle="modal" data-target="#modal_tolak" type="button"><i
                                                class="fas fa-ban"></i>
                                            Tolak</a>
                                    </div>
                                </div>

                            </div>
                        @endif

                @endif
            </div>
            {{-- end judul --}}


            {{-- alert --}}
            @if (session()->has('alert_keuangan'))
                <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
                    <i class="far fa-check-circle"></i>
                    {{ session('alert_keuangan') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- end alert --}}
            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3')
                {{-- card pencairan --}}
                <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $none_block_acc }};">

                    <div class="d-flex justify-content-between align-items-center">
                        <b class="text-success">CAIRKAN DANA</b>
                        <a wire:click="close" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    {{-- alert --}}
                    @if ($id_rekening2 != null)
                        @if (str_replace('.', '', $nominal_pencairan2) > str_replace('.', '', $saldo))
                            <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                <i class="fas fa-minus-circle"></i>
                                Saldo Tidak Cukup!
                            </div>
                        @endif
                    @endif
                    @if (str_replace('.', '', $nominal_pencairan2) > str_replace('.', '', $data->nominal_pengajuan))
                        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                            <i class="fas fa-minus-circle"></i>
                            Nominal disetujui melebihi nominal pengajuan
                        </div>
                    @endif
                    {{-- end alert --}}

                    {{-- form --}}
                    <form wire:submit.prevent="pencairan">
                        <div class="form-row mt-3">

                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl
                                            Dicairkan</span>
                                    </div>
                                    
                                    <input wire:model="tgl_pencairan" type="date"  class="form-control">
                                </div>
                            </div>

                            {{-- Direktur --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 200px; display: flex; justify-content: center; align-items: center;">Yang
                                            Mencairkan</span>
                                    </div>
                                    <input type="input" class="form-control"
                                        value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                                        readonly>
                                </div>

                            </div>
                            {{-- end direktur --}}


                            {{-- nominal Pencairan --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 200px; display: flex; justify-content: center; align-items: center;">Nominal
                                            Pencairan</span>
                                    </div>
                                    <input wire:model="nominal_pencairan2" type="input" class="form-control"
                                        id="nominal_pencairan2">
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 200px; display: flex; justify-content: center; align-items: center;">Sumber
                                            Dana</span>
                                    </div>
                                    <select wire:model="sumber_dana_opsi_keuangan" class="form-control">
                                        <option value="">Pilih Sumber Dana</option>
                                        <option value="Dana Zakat">Dana Zakat</option>
                                        <option value="Dana Infak Umum">Dana Infak Umum</option>
                                        <option value="Dana Infak Terikat">Dana Infak Terikat</option>
                                        <option value="Dana Amil">Dana Amil</option>
                                    </select>
                                </div>
                            </div>
                            
                            @if ($this->sumber_dana_opsi_keuangan == 'Dana Amil')
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bor-abu"
                                                style="width: 200px; display: flex; justify-content: center; align-items: center;">Biaya</span>
                                        </div>
                                        <select wire:model="selectedMainRekening" class="form-control">
                                            <option value="">Pilih Biaya</option>
                                            @foreach ($mainRekenings as $as)
                                                <option value="{{ $as->nomor_akun }}">{{ $as->nama_rekening }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                @if (!empty($subRekenings))
                                    <div class="form-group col-md-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bor-abu"
                                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Kategori
                                                    Biaya</span>
                                            </div>
                                            <select wire:model="selectedSubRekening" id="select2biaya"
                                                class="form-control">
                                                <option value="">Pilih Kategori Biaya</option>
                                                @foreach ($subRekenings as $subRekening)
                                                    <option value="{{ $subRekening->nomor_akun }}">
                                                        {{ $subRekening->nama_rekening }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                @endif
                            @endif

                            {{-- bentuk pencairan --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 200px; display: flex; justify-content: center; align-items: center;">Bentuk
                                            Pencairan</span>
                                    </div>
                                    <select wire:model="bentuk" class="form-control">
                                        <option value="">Pilih Bentuk Pencairan</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Transfer">Transfer</option>
                                    </select>
                                </div>
                            </div>
                            {{-- sumber dana --}}
                            <div class="form-group col-md-12">

                                <select wire:model="id_rekening2" class="form-control" id="select2RekeningInternal">
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


                            {{-- end sumber dana --}}
                            @if ($bentuk == 'Transfer')
                                {{-- atas nama --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="width: 200px; display: flex; justify-content: center; align-items: center;">Atas
                                                Nama</span>
                                        </div>
                                        <input wire:model="atas_nama_pencairan" type="input" class="form-control"
                                            id="atas_nama_pencairan" placeholder="Masukan Atas Nama">
                                    </div>
                                </div>
                                {{-- bank tujuan --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="width: 200px; display: flex; justify-content: center; align-items: center;">Bank
                                                Tujuan</span>
                                        </div>
                                        <input wire:model="bank_tujuan_pencairan" type="input" class="form-control"
                                            id="bank_tujuan_pencairan" placeholder="Masukan Bank Tujuan">
                                    </div>
                                </div>
                                {{-- no rek transfer --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="width: 200px; display: flex; justify-content: center; align-items: center;">No
                                                Rek Tujuan</span>
                                        </div>
                                        <input wire:model="no_rek_tujuan_pencairan" type="input"
                                            class="form-control" id="no_rek_tujuan_pencairans"
                                            placeholder="Masukan Nomor Rekening Tujuan">
                                    </div>
                                </div>
                            @endif

                            {{-- nominal Pencairan --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 200px; display: flex; justify-content: center; align-items: center;">Keterangan</span>
                                    </div>
                                    <input wire:model="pencairan_note" type="input" class="form-control"
                                        placeholder="Masukan keterangan pencairan" id="pencairan_note">
                                </div>
                            </div>





                            {{-- info --}}
                            <div class="form-group col-md-12">
                                <div class="card card-body " style="background-color:#e0e0e0;">
                                    <b>INFORMASI!</b>
                                    <span>
                                        Dengan klik tombol Cairkan, divisi keuangan memberikan konfirmasi pencairan dana
                                        &
                                        mutasi
                                        pada rekening terpilih
                                    </span>
                                </div>
                            </div>
                            {{-- end info --}}

                            <div class="form-group col-md-9">
                            </div>
                            {{-- tombol acc --}}
                            <div class="form-group col-md-3">
                                @if ($bentuk == 'Cash')
                                    @if ($nominal_pencairan2 == '' or $id_rekening2 == '')
                                        <button class="btn btn-success btn-block" disabled
                                            wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                            Cairkan</button>
                                    @else
                                        <button type="submit" name="submit"
                                            class="btn btn-success btn-block tombol-cair"
                                            wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                            Cairkan</button>
                                    @endif
                                @elseif($bentuk == 'Transfer')
                                    @if (
                                        $nominal_pencairan2 == '' or
                                            $id_rekening2 == '' or
                                            $atas_nama_pencairan == '' or
                                            $bank_tujuan_pencairan == '' or
                                            $no_rek_tujuan_pencairan == '')
                                        <button class="btn btn-success btn-block" disabled
                                            wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                            Cairkan</button>
                                    @else
                                        <button type="submit" name="submit"
                                            class="btn btn-success btn-block tombol-cair"
                                            wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                            Cairkan</button>
                                    @endif
                                @else
                                    <button class="btn btn-success btn-block tombol-cair" disabled><i
                                            class="fas fa-save"></i>
                                        Cairkan</button>

                                @endif
                            </div>
                            {{-- acc --}}


                        </div>
                    </form>
                </div>
                {{-- end card pencairan --}}

                {{-- card tolak --}}
                <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $none_block_tolak }};">
                    <div class="d-flex justify-content-between align-items-center">
                        <b class="text-danger">TOLAK PENCAIRAN</b>
                        <a wire:click="close" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                    <form wire:submit.prevent="tolak_keuangan">

                        <div class="form-row mt-3">

                            {{-- Direktur --}}
                            <div class="form-group col-md-12">
                                <input type="input" class="form-control"
                                    value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                                    readonly>
                            </div>
                            {{-- end rekening --}}

                            {{-- tgl penolakan --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 170px; text-align: center; display: block;">Tgl
                                            Penolakan</span>
                                    </div>
                                    <input wire:model="denial_keuangan_date" type="date" class="form-control">
                                </div>
                            </div>
                            {{-- end tgl penolakan --}}


                            {{-- denial note --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            style="width: 170px; text-align: center; display: block;">Alasan</span>
                                    </div>
                                    <input wire:model="denial_keuangan_note" type="input" class="form-control"
                                        placeholder="Masukan Alasan Penolakan">
                                </div>
                            </div>
                            {{-- end denial note --}}

                            {{-- info --}}
                            <div class="form-group col-md-12">
                                <div class="card card-body " style="background-color:#e0e0e0;">
                                    <b>INFORMASI!</b>
                                    <span>
                                        Dengan klik tombol tolak, divisi keuangan memberikan penolakan untuk dilakukan
                                        pencairan dana.
                                    </span>
                                </div>
                            </div>
                            {{-- end info --}}


                            <div class="form-group col-md-9">
                            </div>

                            {{-- tombol tolak --}}
                            <div class="form-group col-md-3">
                                @if ($denial_keuangan_note == '')
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

                        @if ($data->pencairan_status == 'Berhasil Dicairkan' or $data->pencairan_status == 'Belum Dicairkan')
                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Tgl Pencairan
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($data->tgl_pencairan == null)
                                        -
                                    @else
                                        {{ Carbon\Carbon::parse($data->tgl_pencairan)->isoFormat('dddd, D MMMM Y') }}
                                    @endif
                                </td>
                            </tr>



                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Nominal Pencairan
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($data->nominal_pencairan == null)
                                        <b style="font-size: 12pt;">Rp0,-</b>
                                    @else
                                        <b style="font-size: 12pt;">Rp{{ number_format($data->nominal_pencairan, 0, '.', '.') }},-
                                        </b>
                                    @endif
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Sumber Dana
                                </td>
                                <td style="vertical-align: middle;">
                                    <span style="font-size: 12pt;">{{ $data->sumber_dana_opsi_keuangan ?? '-' }}</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold">Rekening Sumber Dana
                                </td>
                                <td>
                                    {{ \App\Http\Controllers\Helper::getDataRekening2($data->id_rekening ?? null)->pluck('nama_rekening')->first() ?? null }}<br>
                                    <span style="font-size:10pt;">
                                        {{ \App\Http\Controllers\Helper::getDataRekening2($data->id_rekening ?? null)->pluck('no_rekening')->first() ?? null }}
                                        -
                                        {{ \App\Http\Controllers\Helper::getNamaBmtByIdRekening($data->id_rekening ?? null) ?? null }}
                                    </span>

                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold " style="width: 30%">
                                    Bentuk Pencairan</td>
                                @if ($data->pencairan_status == 'Belum Dicairkan')
                                <td>-</td>
                                @else
                                <td><b style="font-size: 12pt"></b>
                                    @if ($data->bentuk== 'Transfer')
                                        <span class="text-light badge badge-primary">Transfer
                                        </span>
                                        <br>
                                        <span style="font-size:
                                        12pt">
                                            Atas Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                                            {{ $data->atas_nama_pencairan }}
                                            <br>
                                            Bank Tujuan &nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->bank_tujuan_pencairan }}
                                            <br>
                                            No Rek Tujuan : {{ $data->no_rek_tujuan_pencairan }} <br>

                                        </span>
                                    @elseif($data->bentuk == 'Cash')
                                        <span class="text-light badge badge-success">Tunai
                                        </span>
                                        <br>
                                    @else
                                        -
                                    @endif
                                </td>
                                @endif
                            </tr>

                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Dicairkan Kepada
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($data->dicairkan_kepada == null)
                                        -
                                    @else
                                        {{ $this->nama_pengurus_pc($data->dicairkan_kepada) }}
                                        <br>
                                        <span
                                            style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data->dicairkan_kepada) }}
                                            - {{ $this->nama_pc($data->id_pc) }})</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Keterangan
                                </td>
                                <td style="vertical-align: middle;">
                                    <span style="font-size: 12pt;">{{ $data->pencairan_note ?? '-' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Kwitansi Pencairan
                                </td>
                                <td>
                                    <span>Format Kwitansi Pencairan </span><br>
                                    <a href="/pc/kwitansi_pencairan/{{ $data->id_internal }}" target="_blank"
                                        class="btn btn-sm btn-outline-success hover float-left mr-2 mt-2"
                                        role="button" style="border-radius:10px; width:3cm;">Download
                                    </a>
                                    @if (Auth::user()->gocap_id_pc_pengurus == $data->maker_tingkat_pc and $data->pencairan_status == 'Berhasil Dicairkan')
                                        <button wire:click="sendNotifKwitansi()"
                                            class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                            role="button" style="border-radius:10px; width:3cm;" @if ($data->terima_kwitansi == '1') disabled @endif>Terima
                                            Kwitansi
                                        </button>
                                    @endif

                                </td>
                            </tr>
                            
                            

                            
                        @else
                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Tgl
                                    Ditolak
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($data->denial_keuangan_date == null)
                                        -
                                    @else
                                        {{ Carbon\Carbon::parse($data->denial_keuangan_date)->isoFormat('dddd, D MMMM Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Ditolak Oleh
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($data->denial_keuangan_pc == null)
                                        -
                                    @else
                                        {{ $this->nama_pengurus_pc($data->denial_keuangan_pc) }}
                                        <br>
                                        <span
                                            style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data->denial_keuangan_pc) }}
                                            - {{ $this->nama_pc($data->id_pc) }})</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Status
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($data->pencairan_status == 'Ditolak Dicairkan')
                                        Ditolak
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                    Alasan Penolakan
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($data->denial_keuangan_note == null)
                                        -
                                    @else
                                        {{ $data->denial_keuangan_note }}
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </thead>
                </table>
                {{-- end tabel --}}


            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12 col-md-12 mt-2 tab-tab-daftar-penerima-manfaat-pengajuan-umum-pc">
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <b class="ml-2">C. LAMPIRAN PENCAIRAN
                    </b>
                </div>
            </div>

            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3')
                <button class="btn btn-outline-success btn-sm tombol-tambah"
                    wire:click="modal_lampiran_pencairan_tambah_internal" class="btn btn-primary" data-toggle="modal"
                    data-target="#modal_lampiran_pencairan_tambah_internal" type="button"><i class="fas fa-plus-circle"></i>
                    Tambah</button>
            @endif
        </div>

        {{-- alert --}}
        @if (session()->has('alert_lampiran_pencairan'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_lampiran_pencairan') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('alert_lampiran_pencairan_hapus'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_lampiran_pencairan_hapus') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('alert_lampiran_pencairan_ubah'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_lampiran_pencairan_ubah') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        {{-- end alert --}}
        <table class="table table-bordered table-hover mt-2" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th style="width: 5%;vertical-align:middle;">No</th>
                    <th style="width: 30%;vertical-align:middle;">Judul</th>
                    <!--<th style="width: 30%;vertical-align:middle;">Pembuat</th>-->
                    <th style="width: 25%;vertical-align:middle;">File</th>
                    @if (count($lampiran_pencairan) > 0)
                        @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3')
                            <th style="width: 10%;vertical-align:middle;">Aksi</th>
                        @endif
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($lampiran_pencairan as $lp)
                @empty
                    <tr>
                        <td colspan="6" class="text-center"> Belum ada data</td>
                    </tr>
                @endforelse
                @foreach ($lampiran_pencairan as $lp)
                    <tr>
                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                        <td><span style="font-size:16px;">{{ $lp->judul }}</span>
                        </td>



                        <td><span style="font-size:16px;"><a target="_blank"
                                    href="{{ asset('uploads/lampiran_pencairan_internal/' . $lp->file) }}">{{ $lp->file }}</a></span>
                            <br>
                            {{ Carbon\Carbon::parse($lp->created_at)->isoFormat('dddd, D MMMM Y') }}
                        </td>

                        @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3' ||
                                Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
                            <td style="text-align:center;">
                                <!-- tombol aksi -->
                                <div class="btn-group">
                                    <button type="button" class=" btn btn-success btn-sm" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">Kelola</button>
                                    <button type="button"
                                        class=" btn btn-success dropdown-toggle dropdown-toggle-split btn-sm"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle
                                            Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='black'"
                                            class="dropdown-item tombol-ubah"
                                            wire:click="modal_lampiran_pencairan_ubah_internal('{{ $lp->id_lampiran_pencairan }}')"
                                            type="button" data-toggle="modal"
                                            data-target="#modal_lampiran_pencairan_ubah_internal"><i class="fas fa-edit"
                                                style="width:20px"></i>
                                            Ubah</a>
                                        <a onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                            class="dropdown-item"
                                            wire:click="modal_lampiran_pencairan_hapus_internal('{{ $lp->id_lampiran_pencairan }}')"
                                            data-toggle="modal" data-target="#modal_lampiran_pencairan_hapus_internal"
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
    <div class="col-sm-12 col-lg-12 col-md-12 mt-2 tab-tab-daftar-penerima-manfaat-pengajuan-umum-pc">
        <div class="card card-outline mb-0 pb-0" style="border-radius: 10px;">
            <div class="card-body">
                <div class="row mb-0 pb-0 pl-0">
                    <div class="col-10 pr-0 d-highlight pr-0 mr-0 mb-1">
                        <strong>
                            <b class="text-success">Detail Jurnal Umum {{ $detail_jurnal->nomor ?? '' }} </b>
                        </strong>
                    </div>

                    @if ($detail_jurnal && isset($detail_jurnal->id_jurnal_umum))
                        <div class="col-2 pr-0 d-highlight pr-0 mr-0 mb-1 btn-block">
                            <a class="text-center btn btn-primary" target="_blank"
                                href="{{ route('print_jurnal_umum', $detail_jurnal->id_jurnal_umum) }}"><i
                                    class="fa fa-print nav-icon"></i> CETAK JURNAL</a>
                        </div>
                    @else
                        <div class="col-2 pr-0 d-highlight pr-0 mr-0 mb-1 btn-block">
                            <span class="text-center btn btn-primary disabled">CETAK JURNAL</span>
                        </div>
                    @endif

                </div>

            </div>
            @include('jurnal_umum.form_detail_jurnal_umum')
        </div>
    </div>
</div>

@include('modal.modal_lampiran_pencairan_tambah_internal')
@include('modal.modal_lampiran_pencairan_ubah_internal')
@include('modal.modal_lampiran_pencairan_hapus_internal')

@push('script')
<script>
    Livewire.on('dataTersimpanTambah', () => {
        $('#modal_lampiran_pencairan_tambah_internal').modal('hide');
    });
</script>

<script>
    Livewire.on('dataTersimpanHapus', () => {
        $('#modal_lampiran_pencairan_hapus_internal').modal('hide');
    });
</script>

<script>
    Livewire.on('dataTersimpanPerubahan', () => {
        $('#modal_lampiran_pencairan_ubah_internal').modal('hide');
    });
</script>
<script>
    Livewire.on('resetKwitansi', () => {
        let inputFile = document.querySelector('#customFileScanKwitansi input[type="file"]');
        let inputLabel = document.querySelector('#customFileLabel');
        
        if (inputFile) {
            inputFile.value = '';
        }

        if (inputLabel) {
            inputLabel.innerHTML = 'Pilih file';
        } 
    });
</script>
@endpush

@push('script')
    <script>
        $(document).ready(function() {

            window.loadContactDeviceSelect2 = () => {

                bsCustomFileInput.init();



                $('.tombol-cair').click(function() {
                    $(".custom-file-kwitansi").html('').change();

                });

                $('#nominal_pencairan2').on('input', function(e) {
                    $('#nominal_pencairan2').val(formatRupiah($('#nominal_pencairan2').val(),
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
