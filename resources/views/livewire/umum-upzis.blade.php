<div>


    {{-- Do your work, then step back. --}}
    <div>
        {{-- Be like water. --}}
        <div>
            {{-- Because she competes with no one, no one can compete with her. --}}

            {{-- filter --}}
            <div class="card intro-card-data-pengajuan">
                <div class="card-body ">

                    {{-- baris 1 --}}
                    <div class="form-row ">

                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                            <div class="col-12">
                            @else
                                <div class="col-10">
                        @endif

                        {{-- ekspor --}}
                        @php
                            
                            if ($filter_status == '' or $filter_status == null) {
                                $filter_status = 'Semua';
                            }
                            
                            if ($filter_id_upzis == '' or $filter_id_upzis == null) {
                                $filter_id_upzis = 'Semua';
                            }
                            
                            if ($this->filter_status == '' or $this->filter_status == null) {
                                $this->filter_status = 'Semua';
                            }
                            
                            if ($this->filter_id_upzis == '' or $this->filter_id_upzis == null) {
                                $this->filter_id_upzis = 'Semua';
                            }
                            
                        @endphp



                        <form action="/{{ $role }}/filter_upzis_post" method="post" id="filterForm">
                            @csrf
                            <div class="form-row intro-filter-data-pengajuan">

                                {{-- bulan --}}
                                <div class="col-12 col-md-6 col-sm-12 mb-2 mb-xl-0">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3">Pilih Tanggal</span>
                                        </div>
                                        <input type="text" class="form-control" id="reportrange"
                                            name="filter_daterange" readonly
                                            style="background-color: white;cursor: pointer;min-width:175px;height:37.5px;">

                                        {{-- <div class="input-group-prepend">
                                            <span class="input-group-text" 
                                                style="border-top-right-radius:4px;border-bottom-right-radius:4px;"
                                              
                                                id="basic-addon3"> <i
                                                    class="fa fa-calendar"></i>&nbsp;</span>
                                        </div> --}}
                                    </div>

                                </div>
                                {{-- end bulan --}}

                                {{-- tahun --}}
                                {{-- <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bor-abu">Tahun</span>
                                        </div>
                                        <select onchange="javascript:this.form.submit();" name="tahun_lv"
                                            wire:model="filter_tahun" wire:loading.attr="disabled" class="form-control">
                                            @if (count($tahun_pengajuan) == 0)
                                                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                            @else
                                                @foreach ($tahun_pengajuan as $a)
                                                    <option value="{{ $a->tahun }}">{{ $a->tahun }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div> --}}
                                {{-- end tahun --}}


                                {{-- status --}}
                                <div
                                    class="col-12 @if (Auth::user()->gocap_id_pc_pengurus != null) col-md-3 @else col-md-6 @endif col-sm-12 mb-2 mb-xl-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bor-abu">Status </span>
                                        </div>
                                        <select onchange="javascript:this.form.submit();" name="status_lv"
                                            wire:model="filter_status" wire:loading.attr="disabled"
                                            class="form-control">
                                            <option value="">Semua</option>
                                            <option value="Direncanakan">Direncanakan</option>
                                            <option value="Diajukan">Diajukan</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- end status --}}


                                @if (Auth::user()->gocap_id_pc_pengurus != null)
                                    {{--  upzis  --}}
                                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bor-abu">UPZIS</span>
                                            </div>

                                            <select onchange="javascript:this.form.submit();" name="id_upzis_lv"
                                                wire:model="filter_id_upzis" wire:loading.attr="disabled"
                                                class="form-control" @if (Auth::user()->gocap_id_upzis_pengurus != null) disabled @endif>
                                                <option value="">Semua</option>
                                                @foreach ($daftar_upzis as $a)
                                                    <option value="{{ $a->id_upzis }}">{{ $a->nama }}
                                                        ({{ $a->id_wilayah }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- end upzis --}}
                                @endif
                            </div>


                    </div>


                    </form>


                    {{-- tombol tambah --}}
                    {{-- @if (Auth::user()->gocap_id_upzis_pengurus != null)
                        <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0 intro-tambah-data-pengajuan">
                            @if ($status_rekomendasi == 'Sudah Terbit')
                                <button class="btn btn btn-success btn-block" data-toggle="modal"
                                    wire:click="modal_upzis_tambah" data-target="#modal_upzis_tambah" type="button"><i
                                        class="fas fa-plus-circle"></i>
                                    Tambah</button>
                            @else
                                <button class="btn btn btn-success btn-block" data-toggle="modal"
                                    wire:click="modal_upzis_tambah" data-target="#modal_upzis_tambah" type="button"><i
                                        class="fas fa-plus-circle"></i>
                                    Tambah</button>
                                <button class="btn btn btn-success btn-block disabled" data-toggle="tooltip"
                                    data-placement="top" title="Harap selesaikan pengajuan sebelumnya terlebih dahulu"
                                    type="button"><i class="fas fa-plus-circle"></i>
                                    Tambah</button>
                            @endif

                        </div>
                    @endif --}}


                    @if (Auth::user()->gocap_id_upzis_pengurus != null)
                        <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0 intro-tambah-data-pengajuan">

                            <button class="btn btn btn-success btn-block" data-toggle="modal"
                                wire:click="modal_upzis_tambah" data-target="#modal_upzis_tambah" type="button"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah</button>


                        </div>
                    @endif
                    {{-- end tombol tambah --}}

                </div>
                {{-- end baris 1 --}}

                {{-- baris 2 --}}
                <div class="form-row">

                    {{-- info --}}
                    <div class="col-12 col-md-8 col-sm-12 mb-2 mb-xl-0">
                        <div class="d-flex flex-row bd-highlight align-items-center">
                            <div class="p-2 bd-highlight">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="p-1 bd-highlight">
                                <span>
                                    Data pengajuan yang telah disetujui otomatis menjadi <a
                                        href="https://e-askeu.nucarecilacap.id/upzis/laporankeu" target="_blank"><b
                                            style="font-size: 12pt;">
                                            laporan penyaluran</b></a>

                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- end info --}}



                    <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0 intro-reset-data-pengajuan">

                    </div>

                    {{-- tombol reset --}}
                    <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0 intro-reset-data-pengajuan">
                        <a class="btn btn-secondary btn-block tombol-reset-pc"
                            href="/{{ $role }}/filter_upzis/{{ date('Y-m-01') }}/{{ date('Y') . '-' . date('m') . '-' . app\Http\Controllers\PengajuanController::getTanggalTerakhir(date('m'), date('Y')) }}/Semua/Semua"><i
                                class="fas fa-sync-alt"></i>&nbsp;
                        </a>
                    </div>


                    {{-- <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                        <a href="/{{ $role }}/filter_upzis/{{ $filter_bulan }}/{{ $filter_tahun }}/{{ $filter_status }}/{{ $filter_id_upzis }}"
                            class="btn btn-block btn-outline-success intro-ekspors-data-pengajuan">
                            <i class="fas fa-search"></i></a>
                    </div> --}}

                    <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <a href="/{{ $role }}/print_upzis/{{ $filter_bulan }}/{{ $filter_tahun }}/{{ $filter_status }}/{{ $filter_id_upzis }}"
                            target="_blank" class="btn btn-block btn-outline-success intro-ekspors-data-pengajuan">
                            <i class="fas fa-file-pdf"></i> Ekspor</a>
                    </div>

                    {{-- end ekspor --}}


                </div>
                {{-- end baris 2 --}}




            </div>




        </div>
        {{-- end filter --}}

        {{-- <span class="info-box-text text-success text-bold" wire:loading>
            <span class="spinner-border spinner-border-sm text-success" role="status" aria-hidden="true"></span>
            Loading...
        </span>
 --}}

        @if (session()->has('alert'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="far fa-check-circle"></i>
                {{ session('alert') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <div class="intro-table-pengajuan">
            {{-- page number --}}
            <nav class="navbar navbar-expand-sm">
                <ul class="navbar-nav mr-auto my-4 my-sm-0 navbar-nav-scroll">
                    <div class="row">
                        <div class="col mt-1">Show</div>
                        <div class="col">

                            <li class="nav-item p-0">
                                <div class="dataTables_length" id="example_length">
                                    <select wire:model="page_number" name="example_length"
                                        aria-controls="example_length"
                                        class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="200">200</option>
                                    </select>
                                </div>
                            </li>
                        </div>
                    </div>
                </ul>


                <form>
                    <div class="input-group mr-12 float-right">

                        <input wire:model="cari" type="search" class="form-control form-control-sm"
                            placeholder="Cari Nomor Pengajuan" value="">

                        <div class="input-group-append">
                            <button class="btn btn-sm btn-default noClick">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                    </div>
                </form>
            </nav>


            <div class="table-responsive ">
                <table class="table table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr class="text-center ">
                            <th style="width: 10px;vertical-align:middle;"> No
                            </th>
                            <th style="vertical-align:middle;">Nomor & Nominal Pengajuan</th>

                            <th style="width: 15%;vertical-align:middle;">
                                Nominal
                                <br>
                                Disetujui
                            </th>
                            <th style="width: 15%;vertical-align:middle;">
                                Nominal Dapat<br>
                                Dicairkan
                            </th>
                            <th style="width: 13%;vertical-align:middle;">Status Pengajuan</th>
                            <th style="width: 13%;vertical-align:middle;">Status Rekomendasi</th>
                            @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                <th style="width: 9%;vertical-align:middle;">PJ <br>Pengambilan Dana</th>
                                <th style="width: 5%;vertical-align:middle;">Aksi</th>
                            @else
                                <th style="width: 14%;vertical-align:middle;">PJ <br>Pengambilan Dana</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $a)
                        @empty
                            <tr>
                                @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                    <td colspan="9" class="text-center"> Data
                                        tidak ditemukan</td>
                                @else
                                    <td colspan="8" class="text-center"> Data
                                        tidak ditemukan</td>
                                @endif


                            </tr>
                        @endforelse
                        @foreach ($data as $a)
                            <tr>
                                <td wire:click="detail('{{ $a->id_pengajuan }}')" class="text-bold"
                                    style=" cursor: pointer;text-align:center;padding-top:3mm;">
                                    {{ $loop->iteration }}</td>

                                {{-- nomor pengajuan --}}
                                <td wire:click="detail('{{ $a->id_pengajuan }}')"
                                    style=" cursor: pointer;font-size: 12pt ">
                                    <span class="text-bold" style="font-size: 13pt">
                                        {{ $a->nomor_surat }}
                                    </span>
                                    <br>
                                    <div class="d-flex justify-content-between">
                                        <div>Pengajuan</div>
                                        <div class="text-bold">
                                            Rp{{ number_format($this->hitung_nominal_pengajuan($a->id_pengajuan), 0, '.', '.') }},-
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div>Tgl Input</div>
                                        <div class="text-bold">
                                            {{ Carbon\Carbon::parse($a->tgl_pengajuan)->isoFormat('D MMMM Y') }}
                                            {{-- {{ Carbon\Carbon::parse($a->created_at)->format('H:i:s') }} --}}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>Jml.Rencana Kegiatan</div>
                                        <div class="text-bold">
                                            {{ $this->hitung_jumlah_rencana($a->id_pengajuan) }}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>Jml.Penerima Manfaat</div>
                                        <div class="text-bold">
                                            {{ $this->hitung_jumlah_penerima($a->id_pengajuan) }}
                                        </div>
                                    </div>



                                </td>
                                {{-- end nomor pengajuan --}}

                                {{-- jumlah rencana kegiatan --}}
                                {{-- <td class="text-center" wire:click="detail('{{ $a->id_pengajuan }}')"
                                    style=" cursor: pointer;">
                                  
                                </td> --}}
                                {{-- end jumlah rencana kegiatan --}}

                                {{-- jumlah penerima manfaat --}}
                                {{-- <td class="text-center" wire:click="detail('{{ $a->id_pengajuan }}')"
                                    style=" cursor: pointer;">
                                   
                                </td> --}}
                                {{-- end jumlah penerima manfaat --}}

                                {{-- jumlah nominal diajukan --}}
                                <td class="text-right" wire:click="detail('{{ $a->id_pengajuan }}')"
                                    style=" cursor: pointer;">
                                    <b class="text-success" style="font-size: 12pt;">
                                        Rp{{ number_format($this->hitung_nominal_pengajuan_disetujui($a->id_pengajuan), 0, '.', '.') }},-</b>
                                </td>
                                {{-- end jumlah nominal diajukan --}}

                                {{-- jumlah nominal pencairan --}}
                                <td class="text-right" wire:click="detail('{{ $a->id_pengajuan }}')"
                                    style=" cursor: pointer;">
                                    <b class="text-success" style="font-size: 12pt;">
                                        Rp{{ number_format($this->hitung_nominal_pencairan($a->id_pengajuan), 0, '.', '.') }},-</b>
                                </td>
                                {{-- end jumlah nominal pencairan --}}

                                {{-- status pengajuan --}}
                                <td wire:click="detail('{{ $a->id_pengajuan }}')" style=" cursor: pointer;">
                                    @if ($a->status_pengajuan == 'Diajukan')
                                        <div class="btn btn-light btn-block noClick btn-sm text-bold text-success"
                                            style="border-radius:10px;background-color:#cbf2d6">
                                            Diajukan
                                        </div>
                                    @else
                                        <div class="btn btn-light btn-block noClick btn-sm text-bold text-secondary"
                                            style="border-radius:10px;background-color:#dcdcdc">
                                            Direncanakan
                                        </div>
                                    @endif


                                </td>
                                {{-- status pengajuan --}}

                                {{-- status persetujuan --}}
                                <td wire:click="detail('{{ $a->id_pengajuan }}')" style=" cursor: pointer;">
                                    @if ($a->status_rekomendasi == 'Sudah Terbit')
                                        <div class="btn btn-light btn-block noClick btn-sm text-bold text-success"
                                            style="border-radius:10px;background-color:#cbf2d6">
                                            Sudah Terbit
                                        </div>
                                    @else
                                        <div class="btn btn-light btn-block noClick btn-sm text-bold text-secondary"
                                            style="border-radius:10px;background-color:#dcdcdc">
                                            Belum Terbit
                                        </div>
                                    @endif


                                </td>
                                {{-- status persetujuan --}}

                                {{-- pj pengambila dana --}}
                                <td wire:click="detail('{{ $a->id_pengajuan }}')" style=" cursor: pointer;">
                                    <span class="text-bold" style="font-size: 12pt;">
                                        {{ $this->nama_pengurus_upzis($a->pj_upzis) }}
                                    </span>
                                    <br>
                                    <span style="font-size: 12pt;">
                                        {{ $this->jabatan_pengurus_upzis($a->pj_upzis) }}
                                    </span>
                                </td>
                                {{-- end pj pengambilan dana --}}

                                @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                    {{-- hapus --}}
                                    <td>
                                        <div class="text-center">

                                            @if ($a->status_rekomendasi == 'Sudah Terbit')
                                                {{-- tombol hapus --}}
                                                <a type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Pengajuan ini tidak dapat dihapus"><i class="fas fa-trash"
                                                        style="color: rgb(158, 158, 158);"></i></a>
                                                {{-- end tombol hapus --}}
                                            @else
                                                {{-- tombol hapus --}}
                                                <a wire:click="modal_pengajuan_hapus('{{ $a->id_pengajuan }}')"
                                                    data-toggle="modal" data-target="#modal_pengajuan_hapus"
                                                    type="button"><i class="fas fa-trash"
                                                        style="color: red;"></i></a>
                                                {{-- end tombol hapus --}}
                                            @endif
                                        </div>
                                    </td>
                                    {{-- end hapus --}}
                                @endif



                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-right">
                    {{-- pagination --}}
                    {{ $data->links() }}
                </div>

            </div>
        </div>
        {{-- end tabel --}}

        {{-- modal tambah --}}
        @include('modal.modal_upzis_tambah')
        @include('modal.modal_pengajuan_hapus')
        {{-- end modal tambah --}}


    </div>

</div>

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
                    <div class="col-md-12">
                        <canvas id="myChart"
                            style="min-height: 300px; height: 300px; max-height: 100%; max-width: 100%; "></canvas>

                        {{-- <canvas id="barChart2"
                            style="min-height: 200px; height: 250px; max-height: 300px; max-width: 100%;"
                            class="chartjs-render-monitor"></canvas> --}}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card " style="height: 50vh;">

            {{-- <div class="col-md-12 col-sm-12 my-1">
                <div class="btn-group btn-block">
                    <button style="width:50px" class="btn btn-outline-primary"><span style="font-size: 12pt">
                            Total Pengajuan: {{ $pengajuan_total }} </span></button>
                    <button style="width:50px" class="btn btn-outline-success"><span style="font-size: 12pt">
                            Total Kegiatan:
                            {{ $jumlah_rencana_kegiatan }}</span></button>
                    <button style="width:50px" class="btn btn-outline-danger"><span style="font-size: 12pt">
                            Total Penerima : {{ $jumlah_penerima }}</span></button>
                    <button style="width:50px" class="btn btn-outline-secondary"><span style="font-size: 12pt">
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
                            <th style="width:50%">Total Pengajuan:</th>
                            <td>{{ $pengajuan_total }} </td>
                        </tr>
                        <tr>
                            <th>Total Kegiatan:</th>
                            <td> {{ $jumlah_rencana_kegiatan }}</td>
                        </tr>
                        <tr>
                            <th> Total Penerima :</th>
                            <td>{{ $jumlah_penerima }}</td>
                        </tr>
                        <tr>
                            <th>Total Disetujui :</th>
                            <td>Rp. {{ number_format($nominal_disetujui, 0, ',', '.') }}</td>
                        </tr>

                        {{-- <tr>
                            <th>Kelembagaan : {{ $detail_pilar_penguat_kelembagaan }}</th>
                            <td></td>
                        </tr>

                        <tr>
                            <th>Ekonimi : {{ $detail_pilar_ekonomi }}</th>
                            <td></td>
                        </tr>

                        <tr>
                            <th>Pendidikan: {{ $detail_pilar_pendidikan }}</th>
                            <td></td>
                        </tr>

                        <tr>
                            <th>Kesehatan : {{ $detail_pilar_kesehatan }}</th>
                            <td></td>
                        </tr>

                        <tr>
                            <th>dakwah : {{ $detail_pilar_dakwah_dan_kemanusiaan }}</th>
                            <td></td>
                        </tr>

                        <tr>
                            <th>kemanusiaan : {{ $detail_pilar_kemanusiaan }}</th>
                            <td></td>
                        </tr>

                        <tr>
                            <th>lingkungan: {{ $detail_pilar_lingkungan }}</th>
                            <td></td>
                        </tr> --}}

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    Chart.defaults.font.size = 12;
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
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



<script type="text/javascript">
    $(function() {

        var start_date = {!! $c_start_date ? "'" . $c_start_date . "'" : "moment().startOf('month').format('YYYY-MM-DD')" !!};
        var end_date = {!! $c_end_date ? "'" . $c_end_date . "'" : "moment().endOf('month').format('YYYY-MM-DD')" !!};

        var start = moment(start_date);
        var end = moment(end_date);

        function cb(start, end) {
            $('#reportrange').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
        }
        // moment.locale('id');
        $('#reportrange').daterangepicker({
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
                    'month').endOf('month')]
            }
        }, function(start, end) {
            $('#reportrange').val(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
            $('#filterForm').submit(); // Mengirimkan formulir saat terjadi perubahan
        });
        // moment.locale('id');
        cb(start, end);
    });
</script>



{{-- <script>
    $(function() {

        var areaChartDatas = {
            labels: [
                'Penguat Kelembagaan', 'Ekonomi', 'Pendidikan', 'Kesehatan', ' Dakwah dan Kemanusiaan',
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
        }
        //-------------
        //- BAR CHART -
        //-------------
        var barChart2Canvas = $('#barChart2').get(0).getContext('2d')
        var barChart2Data = $.extend(true, {}, areaChartDatas)
        var temp0 = areaChartDatas.datasets[0]
        barChart2Data.datasets[0] = temp0

        var barChart2Options = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        }

        new Chart(barChart2Canvas, {
            type: 'bar',
            data: barChart2Data,
            options: barChart2Options
        })

        //---------------------
        //- STACKED BAR CHART -
        //---------------------
        var stackedBarChart2Canvas = $('#stackedBarChart2').get(0).getContext('2d')


        var stackedBarChart2Options = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }

        new Chart(stackedBarChart2Canvas, {
            type: 'bar',
            data: stackedBarChart2Data,
            options: stackedBarChart2Options
        })
    })
</script> --}}
</div>
