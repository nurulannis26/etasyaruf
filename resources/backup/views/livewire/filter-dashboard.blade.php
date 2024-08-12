<div>
    <div class="row">

        <div class="card  h-card col-12">

            <div class="card-body">
                <form action="/{{ $role }}/filter_dashboard_post" method="post" class="d-inline">
                    {{-- baris 2 --}}
                    <div class="form-row mt-1 mb-3">

                        {{-- info --}}
                        <div class="col-12 col-md-8 col-sm-12 mb-2 mb-xl-0">
                            <div class="d-flex flex-row bd-highlight align-items-center">
                                <div class="p-2 bd-highlight">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="p-1 bd-highlight" wire:ignore>

                                    <span>Menampilkan data pengajuan umum tingkat <b style="font-size: 12pt;">

                                            @if ($this->pilih_tingkat == 'INTERNAL')
                                                Internal Manajemen Eksekutif
                                            @elseif ($this->pilih_tingkat == 'UMUM')
                                                Umum Lazisnu Cilacap
                                            @elseif ($this->pilih_tingkat == 'UPZIS')
                                                UPZIS MWCNU
                                            @elseif ($this->pilih_tingkat == 'RANTING')
                                                RANTING NU
                                            @endif

                                        </b>
                                        pada filter terpilih

                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- end info --}}


                        <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                            <select onchange="javascript:this.form.submit();" class="form-control " name="pilih_tingkat"
                                wire:model="pilih_tingkat">
                                <option selected hidden>Pilih Tingkat</option>
                                @if (Auth::user()->gocap_id_pc_pengurus != null)
                                    <option value="INTERNAL">Tingkat Internal PC</option>
                                    <option value="UMUM">Tingkat Umum PC</option>
                                    <option value="UPZIS">Tingkat UPZIS</option>
                                    <option value="RANTING">Tingkat RANTING</option>
                                @else
                                    <option value="UPZIS">Tingkat UPZIS</option>
                                    <option value="RANTING">Tingkat RANTING</option>
                                @endif
                            </select>
                        </div>

                        @if ($this->pilih_tingkat == 'INTERNAL')
                            <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0 ">
                                <a href="/{{ $role }}/print_internal/{{ $filter_bulan }}/{{ $filter_tahun }}/{{ $filter_status }}/{{ $filter_tujuan }}"
                                    target="_blank"
                                    class="btn btn-block btn-outline-success intro-ekspor-data-pengajuan-pc">
                                    <i class="fas fa-file-pdf"></i> Ekspor</a>
                            </div>
                        @elseif ($this->pilih_tingkat == 'UMUM')
                            <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                <a href="/{{ $role }}/print_pc/{{ $filter_bulan }}/{{ $filter_tahun }}/{{ $filter_status }}/{{ $filter_kategori }}/{{ $filter_pilar }}"
                                    target="_blank" class="btn btn-block btn-outline-success">
                                    <i class="fas fa-file-pdf"></i> Ekspor</a>
                            </div>
                        @elseif ($this->pilih_tingkat == 'UPZIS')
                            <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                <a href="/{{ $role }}/print_upzis/{{ $filter_bulan }}/{{ $filter_tahun }}/{{ $filter_status }}/{{ $filter_id_upzis }}"
                                    target="_blank"
                                    class="btn btn-block btn-outline-success intro-ekspors-data-pengajuan">
                                    <i class="fas fa-file-pdf"></i> Ekspor</a>
                            </div>
                        @elseif ($this->pilih_tingkat == 'RANTING')
                            <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                <a href="/{{ $role }}/print_ranting/{{ $filter_bulan }}/{{ $filter_tahun }}/{{ $filter_status }}/{{ $filter_id_upzis }}/{{ $filter_id_ranting }}"
                                    target="_blank" class="btn btn-block btn-outline-success">
                                    <i class="fas fa-file-pdf"></i> Ekspor</a>
                            </div>
                        @endif


                        {{-- <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <a href="" target="_blank" class="btn btn-block btn-outline-success">
                            <i class="fas fa-file-pdf"></i> Ekspor</a>
                    </div> --}}



                        {{-- end ekspor --}}
                        {{-- tombol reset --}}
                        {{-- <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                        <button class="btn btn-secondary btn-block tombol-reset-pc" wire:click="reset_filter"><i
                                class="fas fa-sync-alt"></i>&nbsp;
                        </button>
                    </div> --}}
                        {{-- end tombol reset --}}


                    </div>

                    @php
                        if ($this->pilih_tingkat == 'INTERNAL' || $this->pilih_tingkat == 'UPZIS') {
                            $md = 'col-md-3';
                            if ($this->pilih_tingkat == 'UPZIS') {
                                $md1 = 'col-md-3';
                            } else {
                                $md1 = 'col-md-2';
                            }
                        } else {
                            if ($this->pilih_tingkat == 'UPZIS') {
                                $md1 = 'col-md-3';
                            } else {
                                $md1 = 'col-md-2';
                            }
                            $md = 'col-md-2';
                        }
                    @endphp

                    @php
                        
                        if ($this->filter_status == '' or $this->filter_status == null) {
                            $filter_status = 'Semua';
                        }
                        
                        if ($this->filter_tujuan == '' or $this->filter_tujuan == null) {
                            $filter_tujuan = 'Semua';
                        }
                        
                        if ($this->filter_pilar == '' or $this->filter_pilar == null) {
                            $filter_pilar = 'Semua';
                        }
                        
                        if ($this->filter_kategori == '' or $this->filter_kategori == null) {
                            $filter_kategori = 'Semua';
                        }
                        
                        if ($this->filter_id_upzis == '' or $this->filter_id_upzis == null) {
                            $filter_id_upzis = 'Semua';
                        }
                        
                        if ($this->filter_id_ranting == '' or $this->filter_id_ranting == null) {
                            $filter_id_ranting = 'Semua';
                        }
                        
                    @endphp

                    {{-- ekspor --}}

                    @csrf
                    {{-- eeeeeeeeeee  {{ $this->filter_bulan . '/' . $this->filter_tahun . '/' . $this->filter_status . '/' . $this->filter_tujuan . '/' . $this->c_tingkat }} --}}

                    {{-- @if ($this->pilih_tingkat == 'INTERNAL')
                        <input type="hidden" name="pilih_tingkat" value="INTERNAL">
                    @elseif ($this->pilih_tingkat == 'UMUM')
                        <input type="hidden" name="pilih_tingkat" value="UMUM">
                    @elseif ($this->pilih_tingkat == 'UPZIS')
                        <input type="hidden" name="pilih_tingkat" value="UPZIS">
                    @elseif ($this->pilih_tingkat == 'RANTING')
                        <input type="hidden" name="pilih_tingkat" value="RANTING">
                    @endif --}}

                    {{-- baris 1 --}}
                    <div class="form-row" wire:ignore>
                        {{-- periode --}}
                        <div class="col-12 {{ $md1 }} col-sm-12 mb-2 mb-xl-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Bulan</span>
                                </div>
                                <select onchange="javascript:this.form.submit();" wire:model="filter_bulan"
                                    wire:loading.attr="disabled" class="form-control" name="bulan_lv">
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        {{-- end periode --}}

                        {{-- tahun --}}
                        <div class="col-12 {{ $md1 }} col-sm-12 mb-2 mb-xl-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Tahun</span>
                                </div>
                                <select onchange="javascript:this.form.submit();" wire:model="filter_tahun"
                                    wire:loading.attr="disabled" class="form-control" name="tahun_lv">
                                    @if (count($tahun_pengajuan) == 0)
                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                    @else
                                        @foreach ($tahun_pengajuan as $a)
                                            <option value="{{ $a->tahun }}">{{ $a->tahun }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        {{-- end tahun --}}

                        <div class="col-12 {{ $md }} col-sm-12 mb-2 mb-xl-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Status</span>
                                </div>
                                <select onchange="javascript:this.form.submit();" wire:model="filter_status"
                                    wire:loading.attr="disabled" name="status_lv" class="form-control">
                                    @if ($this->pilih_tingkat == 'RANTING' || $this->pilih_tingkat == 'UPZIS')
                                        <option value="">Semua</option>
                                        <option value="Direncanakan">Direncanakan</option>
                                        <option value="Diajukan">Diajukan</option>
                                    @elseif ($this->pilih_tingkat == 'INTERNAL' || $this->pilih_tingkat == 'UMUM')
                                        <option value="">Semua</option>
                                        <option value="Belum Direspon">Belum Direspon</option>
                                        <option value="Disetujui">Disetujui</option>
                                        <option value="Ditolak">Ditolak</option>
                                    @endif

                                </select>
                            </div>
                        </div>

                        @if ($this->pilih_tingkat == 'INTERNAL')
                            <div class="col-12 col-md-5 col-sm-12 mb-2 mb-xl-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu">Penggunaan Dana</span>
                                    </div>
                                    <select onchange="javascript:this.form.submit();" wire:model="filter_tujuan"
                                        wire:loading.attr="disabled" class="form-control" name="tujuan_lv">
                                        <option value="">Semua</option>
                                        <option value="Uang Muka">Uang Muka</option>
                                        <option value="Reimbursement">Reimbursement</option>
                                        <option value="Pembayaran">Pembayaran</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        @endif

                        @if ($this->pilih_tingkat == 'UMUM')
                            {{-- pilar --}}
                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu">Kategori </span>
                                    </div>
                                    <select onchange="javascript:this.form.submit();" wire:model="filter_kategori"
                                        id="filter_kategori" wire:loading.attr="disabled" class="form-control"
                                        name="kategori_lv">
                                        <option value="">Semua Kategori</option>
                                        <option value="ba84d782-81a8-11ed-b4ef-dc215c5aad51">PENGUATAN KELEMBAGAAN
                                        </option>
                                        <option value="bed10d9c-81a8-11ed-b4ef-dc215c5aad51">PROGRAM SOSIAL</option>
                                        <option value="c51700b1-81a8-11ed-b4ef-dc215c5aad51">OPERASIONAL PC LAZISNU
                                        </option>
                                    </select>
                                </div>
                            </div>
                            {{-- end pilar --}}

                            {{-- pilar --}}
                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu">Pilar </span>
                                    </div>
                                    <select onchange="javascript:this.form.submit();" wire:model="filter_pilar"
                                        wire:loading.attr="disabled" class="form-control" name="pilar_lv">

                                        <option value="">Semua Pilar</option>
                                        @foreach ($daftar_pilar2 as $a)
                                            <option value="{{ $a->id_program_pilar }}">{{ $a->pilar }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            {{-- end pilar --}}
                        @endif


                        {{--  upzis  --}}
                        @if ($this->pilih_tingkat != 'INTERNAL' && $this->pilih_tingkat != 'UMUM')
                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu">UPZIS</span>
                                    </div>

                                    <select onchange="javascript:this.form.submit();" wire:model="filter_id_upzis"
                                        wire:loading.attr="disabled" name="id_upzis_lv" class="form-control"
                                        @if (Auth::user()->gocap_id_upzis_pengurus != null) disabled @endif>
                                        <option value="">Semua</option>
                                        @foreach ($daftar_upzis as $a)
                                            <option value="{{ $a->id_upzis }}">{{ $a->nama }}
                                                ({{ $a->id_wilayah }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        {{-- end upzis --}}



                        {{--  ranting  --}}
                        @if ($this->pilih_tingkat != 'INTERNAL' && $this->pilih_tingkat != 'UMUM' && $this->pilih_tingkat != 'UPZIS')
                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu">RANTING</span>
                                    </div>

                                    <select onchange="javascript:this.form.submit();" wire:model="filter_id_ranting"
                                        wire:loading.attr="disabled" name="id_ranting_lv" class="form-control">
                                        <option value="">Semua</option>
                                        @foreach ($daftar_ranting as $a)
                                            <option value="{{ $a->id_ranting }}">{{ $a->nama }}
                                                ({{ $a->id_wilayah }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                </form>
            </div>
            {{-- end baris 1 --}}


        </div>
    </div>

    <div class="row" wire:ignore>

        <div class="col-12 col-sm-3">
            <div class="card h-card">
                <div class="container pl-2">
                    <div class="d-flex align-items-start">
                        <div class="info-box-content pt-1">
                            @if ($this->pilih_tingkat == 'INTERNAL' || $this->pilih_tingkat == 'UMUM')
                                <span class="info-box-text">Belum Direspon</span>
                            @else
                                <span class="info-box-text">Sudah Direncanakan</span>
                            @endif
                            <span class="info-box-text"><b>
                                    <h3>
                                        @if ($this->pilih_tingkat == 'INTERNAL')
                                            {{ $belum_direspon_internal }}
                                        @elseif ($this->pilih_tingkat == 'UMUM')
                                            {{ $belum_direspon_umum }}
                                        @elseif ($this->pilih_tingkat == 'UPZIS')
                                            {{ $direncanakan_upzis }}
                                        @elseif ($this->pilih_tingkat == 'RANTING')
                                            {{ $direncanakan_ranting }}
                                        @endif
                                    </h3>
                                </b></span>
                            <p class="info-box-text">

                                <b class="text-success">
                                    @if ($this->pilih_tingkat == 'INTERNAL')
                                        Rp{{ number_format($nominal_belum_direspon_internal, 0, '.', '.') }},-
                                    @elseif ($this->pilih_tingkat == 'UMUM')
                                        Rp{{ number_format($nominal_belum_direspon_umum, 0, '.', '.') }},-
                                    @elseif ($this->pilih_tingkat == 'UPZIS')
                                        Rp{{ number_format($nominal_direncanakan_upzis, 0, '.', '.') }},-
                                    @elseif ($this->pilih_tingkat == 'RANTING')
                                        Rp{{ number_format($nominal_direncanakan_ranting, 0, '.', '.') }},-
                                    @endif
                                </b>

                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

        <div class="col-12 col-sm-3">
            <div class="card  h-card">
                <div class="container pl-2">

                    <div class="d-flex align-items-start">
                        <div class="info-box-content pt-1">
                            @if ($this->pilih_tingkat == 'INTERNAL' || $this->pilih_tingkat == 'UMUM')
                                <span class="info-box-text">Sudah Disetujui</span>
                            @else
                                <span class="info-box-text">Sudah Diajukan</span>
                            @endif
                            <span class="info-box-text"><b>
                                    <h3>
                                        @if ($this->pilih_tingkat == 'INTERNAL')
                                            {{ $disetujui_internal }}
                                        @elseif ($this->pilih_tingkat == 'UMUM')
                                            {{ $disetujui_umum }}
                                        @elseif ($this->pilih_tingkat == 'UPZIS')
                                            {{ $diajukan_upzis }}
                                        @elseif ($this->pilih_tingkat == 'RANTING')
                                            {{ $diajukan_ranting }}
                                        @endif

                                    </h3>
                                </b></span>
                            <p class="info-box-text">

                                <b class="text-success">
                                    @if ($this->pilih_tingkat == 'INTERNAL')
                                        Rp{{ number_format($nominal_disetujui_internal, 0, '.', '.') }},-
                                    @elseif ($this->pilih_tingkat == 'UMUM')
                                        Rp{{ number_format($nominal_disetujui_umum, 0, '.', '.') }},-
                                    @elseif ($this->pilih_tingkat == 'UPZIS')
                                        Rp{{ number_format($nominal_diajukan_upzis, 0, '.', '.') }},-
                                    @elseif ($this->pilih_tingkat == 'RANTING')
                                        Rp{{ number_format($nominal_diajukan_ranting, 0, '.', '.') }},-
                                    @endif
                                </b>

                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-12 col-sm-3">
            <div class="card  h-card">
                <div class="container pl-2">
                    <div class="d-flex align-items-start">
                        <div class="info-box-content pt-1">
                            @if ($this->pilih_tingkat == 'INTERNAL' || $this->pilih_tingkat == 'UMUM')
                                <span class="info-box-text">Permohonan Ditolak</span>
                            @else
                                <span class="info-box-text">Sudah Diterbitkan</span>
                            @endif
                            <span class="info-box-text"><b>
                                    <h3>
                                        @if ($this->pilih_tingkat == 'INTERNAL')
                                            {{ $ditolak_internal }}
                                        @elseif ($this->pilih_tingkat == 'UMUM')
                                            {{ $ditolak_umum }}
                                        @elseif ($this->pilih_tingkat == 'UPZIS')
                                            {{ $terbit_upzis }}
                                        @elseif ($this->pilih_tingkat == 'RANTING')
                                            {{ $terbit_ranting }}
                                        @endif
                                    </h3>
                                </b></span>
                            <p class="info-box-text">
                                <b class="text-success">
                                    @if ($this->pilih_tingkat == 'INTERNAL')
                                        Rp{{ number_format($nominal_ditolak_internal, 0, '.', '.') }},-
                                    @elseif ($this->pilih_tingkat == 'UMUM')
                                        Rp{{ number_format($nominal_ditolak_umum, 0, '.', '.') }},-
                                    @elseif ($this->pilih_tingkat == 'UPZIS')
                                        Rp{{ number_format($nominal_sudah_terbit_upzis, 0, '.', '.') }},-
                                    @elseif ($this->pilih_tingkat == 'RANTING')
                                        Rp{{ number_format($nominal_sudah_terbit_ranting, 0, '.', '.') }},-
                                    @endif
                                </b>
                            </p>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-3">

            <div class="card  h-card">
                <div class="container pl-2">
                    <div class="d-flex align-items-start">
                        <div class="info-box-content pt-1">
                            <span class="info-box-text">PERIODE</span>
                            <span class="info-box-text"><b>
                                    <h3>{{ $bulan . ' ' . $this->filter_tahun }}</h3>
                                </b></span>
                            <p class="info-box-text">
                                <b class="text-success"></b>⠀
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

        <div class="col-md-8">

            <div class="card ">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <strong>
                            Jumlah Kegiatan Berdasarkan Pilar
                        </strong>
                        <div>

                            <p class="badge badge-success align-items-center">PERIODE -
                                {{ $bulan . ' ' . $this->filter_tahun }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" wire:ignore>

                            @if ($this->pilih_tingkat == 'INTERNAL')
                                <canvas id="myChart4"
                                    style="min-height: 200px; height: 250px; max-height: 300px; max-width: 100%;"
                                    class="chartjs-render-monitor"></canvas>
                            @else
                                <canvas id="myChart5"
                                    style="min-height: 200px; height: 250px; max-height: 300px; max-width: 100%;"
                                    class="chartjs-render-monitor"></canvas>
                            @endif


                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card ">
                <div class="card-body">
                    <strong>
                        Statistik Pentasyarufan
                    </strong>


                    <div class="table-responsive">
                        <table class="table">
                            @if ($this->pilih_tingkat == 'INTERNAL')
                                <tr>
                                    <th style="width:50%">Jumlah Pengajuan:</th>
                                    <td>{{ $pengajuan_total }} </td>
                                </tr>
                                <tr>
                                    <th>Total Nominal Pengajuan:</th>
                                    <td>Rp. {{ number_format($total_nominal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Nominal Disetujui :</th>
                                    <td>Rp. {{ number_format($total_nominal_disetujui, 0, ',', '.') }}</td>
                                </tr>
                            @elseif($this->pilih_tingkat == 'UMUM')
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
                            @elseif($this->pilih_tingkat == 'UPZIS')
                                <tr>
                                    <th style="width:50%">Total Pengajuan:</th>
                                    <td>{{ $pengajuan_total_upzis }} </td>
                                </tr>
                                <tr>
                                    <th>Total Kegiatan:</th>
                                    <td> {{ $jumlah_rencana_kegiatan_upzis }}</td>
                                </tr>
                                <tr>
                                    <th> Total Penerima :</th>
                                    <td>{{ $jumlah_penerima_upzis }}</td>
                                </tr>
                                <tr>
                                    <th>Total Disetujui :</th>
                                    <td>Rp. {{ number_format($nominal_disetujui_upzis, 0, ',', '.') }}</td>
                                </tr>
                            @elseif($this->pilih_tingkat == 'RANTING')
                                <tr>
                                    <th style="width:50%">Pengajuan Total:</th>
                                    <td>{{ $nominal_pengajuan_ranting }} </td>
                                </tr>
                                <tr>
                                    <th>Kegiatan Total:</th>
                                    <td> {{ $jumlah_rencana_kegiatan_ranting }}</td>
                                </tr>
                                <tr>
                                    <th> Penerima Total :</th>
                                    <td>{{ $jumlah_penerima_ranting }}</td>
                                </tr>
                                <tr>
                                    <th>Total Disetujui :</th>
                                    <td>Rp. {{ number_format($nominal_disetujui_ranting, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

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
                ['Penguat', 'Kelembagaan'], 'Ekonomi', 'Pendidikan', 'Kesehatan', ['Dakwah', 'Kemanusiaan'],
                'Kemanusiaan', 'Lingkungan'
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
                data: [{{ $detail_pilar_penguat_kelembagaan }}, {{ $detail_pilar_ekonomi }},
                    {{ $detail_pilar_pendidikan }},
                    {{ $detail_pilar_kesehatan }}, {{ $detail_pilar_dakwah_dan_kemanusiaan }},
                    {{ $detail_pilar_kemanusiaan }}, {{ $detail_pilar_lingkungan }}
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


<script>
    Chart.defaults.font.size = 12;
    const ct4 = document.getElementById('myChart4');

    new Chart(ct4, {
        type: 'bar',
        data: {
            labels: [
                ['Uang', 'Muka'], 'Reimbursement', 'Pembayaran', 'Lainnya'
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
                data: [{{ $uang_muka }}, {{ $reimbursement }},
                    {{ $pembayaran }}, {{ $lainnya }}
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
