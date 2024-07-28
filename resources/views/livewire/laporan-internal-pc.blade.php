<div>
    {{-- The best athlete wants his opponent at his best. --}}
    {{-- filter --}}

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body intro-header-data-pengajuan-pcs">


            {{-- ekspor --}}
            @php

                if ($filter_status == '' or $filter_status == null) {
                    $filter_status = 'Semua';
                }

                if ($filter_tujuan == '' or $filter_tujuan == null) {
                    $filter_tujuan = 'Semua';
                }

            @endphp


            <form action="/{{ $role }}/laporan_filter_internal_pc_post" method="post" id="filterFormInternal">
                @csrf

                {{-- baris 1 --}}
                <div class="form-row intro-filter-data-pengajuan-pc">
                    <input type="hidden" name="sub" value="{{ $this->sub }}">

                    {{-- date range --}}
                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control text-center icon-input" id="reportrange"
                                name="filter_daterange" readonly
                                style="background-color: white;cursor: pointer;min-width:175px;height:37.5px;">
                        </div>
                    </div>

                    {{-- status --}}


                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Penggunaan Dana</span>
                            </div>
                            <select wire:model="filter_tujuan" wire:loading.attr="disabled" class="form-control"
                                onchange="submitFormInternal();" name="tujuan_lv">
                                <option value="">Semua</option>
                                <option value="Uang Muka">Uang Muka</option>
                                <option value="Reimbursement">Reimbursement</option>
                                <option value="Pembayaran">Pembayaran</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    {{-- end status --}}


                    {{-- status --}}
                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Status </span>
                            </div>
                            <select wire:model="filter_status" wire:loading.attr="disabled" class="form-control"
                                onchange="submitFormInternal();" name="status_lv">
                                <option value="">Semua</option>
                                <option value="Belum Direspon">Belum Direspon</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    {{-- end status --}}

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
                                    href="/{{ $role }}/print_internal_laporan/{{ $filter_daterange }}/{{ $filter_status }}/{{ $filter_tujuan }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf"></i>&nbsp; Pdf
                                </a>
                                <a class="dropdown-item" onMouseOver="this.style.color='green'"
                                    onMouseOut="this.style.color='black'" type="button"
                                    href="/{{ $role }}/print_internal_excel_laporan/{{ $filter_daterange }}/{{ $filter_status }}/{{ $filter_tujuan }}">
                                    <i class="fas fa-file-excel"></i>&nbsp; Excel
                                </a>

                            </div>
                        </div>
                    </div>

                    {{-- end ekspor --}}

                </div>
                {{-- end baris 1 --}}

            </form>

            {{-- baris 2 --}}
            <div class="form-row mt-0">

                {{-- info --}}
                <div class="col-12 col-md-10 col-sm-12 mb-2 mb-xl-0">
                    <div class="d-flex flex-row bd-highlight align-items-center">
                        <div class="p-2 bd-highlight">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="p-1 bd-highlight">
                            <span>Pengajuan untuk
                                <span class="text-bold"> kebutuhan internal.
                                </span>
                                Dapat ditambahkan oleh semua staf. </span>
                        </div>
                    </div>
                </div>
                {{-- end info --}}


                {{-- tombol tambah --}}
                <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0 intro-tambah-data-pengajuan-pc">
                    <button wire:click="modal_internal_pc_tambah" class="btn btn btn-success btn-block"
                        class="btn btn-primary" data-toggle="modal" data-target="#modal_internal_pc_tambah"
                        type="button"><i class="fas fa-plus-circle"></i>
                        Tambah</button>
                </div>
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
                            <b> Rp. {{ number_format($total_nominal, 0, ',', '.') }}</b>

                            <div class="h6 mb-0 mb-1" style="color: #28a745">
                                {{ $pengajuan_total }} Data</div>
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
                            <div class="h6">Disetujui Direktur

                            </div>

                            <b> Rp. {{ number_format($disetujui_direktur, 0, ',', '.') }}</b>

                            <div class="h6 mb-0 mb-1">
                                <span style="color: #28a745">{{ $acc_direktur }} Acc</span> (0
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

                            <b> Rp. {{ number_format($disetujui_keuangan, 0, ',', '.') }}</b>

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

                            <b>Rp 0</b>

                            <div class="h6 mb-0 mb-1" style="color: #28a745">
                                - </div>

                        </div>
                        <div class="col-auto">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="intro-table-data-pengajuan-pc">

        {{-- tabel --}}
        <div class="table-responsive ">
            <table class="table table-bordered table-hover" id="Internal" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th style="vertical-align:middle;width: 3%;">No</th>
                        <th style="vertical-align:middle;width: 30%;">Nomor
                            &amp; Nominal Pengajuan</th>
                        <th style="vertical-align:middle;width: 10%;">Tujuan
                            &amp; Keterangan</th>
                        <th style="vertical-align:middle;width: 10%;">Nominal Disetujui
                        </th>
                        <th style="vertical-align:middle;width: 10%;">Nominal Dicairkan
                        </th>
                        <th style="vertical-align:middle;width: 35%;">Nominal Digunakan
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $a)
                    @empty
                        <tr>
                            {{-- jika tabel kosong --}}
                            <td colspan="6" class="text-center"> Data
                                tidak ditemukan</td>
                        </tr>
                    @endforelse
                    @foreach ($data as $a)
                        <tr onclick="window.open('/{{ $role }}/detail-pengajuan-internal-pc/{{ $a->id_internal }}', '_blank');"
                            style=" cursor: pointer;">
                            <td class="text-center text-bold">{{ $loop->iteration }}</td>
                            <td style="width: 30%">
                                @if ($a->tgl_pengajuan != null)
                                    <sup class="badge badge-success text-white">FPPD berhasil diajukan</sup>
                                    <br>
                                @else
                                    <sup class="badge badge-warning text-white">FPPD belum selesai diajukan</sup>
                                    <br>
                                @endif

                                <span class="text-bold" style="font-size: 13px">
                                    {{ $a->nomor_surat }}
                                </span>
                                <br>
                                <div class="d-flex justify-content-between" style="font-size: 13px">
                                    <div>Pengajuan</div>
                                    <div class="text-bold">
                                        Rp{{ number_format($a->nominal_pengajuan), 0, '.', '.' }}
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between" style="font-size: 13px">
                                    <div>Tgl Pengajuan</div>
                                    <div class="text-bold">
                                        {{ Carbon\Carbon::parse($a->tgl_pengajuan)->isoFormat('D MMM YYYY') }}
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between" style="font-size: 13px">
                                    <div>Tgl Input</div>
                                    <div class="text-bold">
                                        {{ Carbon\Carbon::parse($a->created_at)->isoFormat('D MMM YYYY') }}
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between" style="font-size: 13px">
                                    <div>Diajukan Oleh</div>
                                    <div class="text-bold" style="font-size: 13px">
                                        {{ $this->nama_pengurus_pc($a->maker_tingkat_pc) }}<br>
                                    </div>
                                </div>
                            </td>

                            <td style="width: 10%">
                                @if ($a->approval_status_divpro == 'Disetujui')
                                    <sup class="text-light badge badge-success">Disposisi Diterima Div. Program</sup>
                                    <br>
                                @else
                                    <sup class="text-light badge badge-warning">Disposisi Blm Diterima Div. Program
                                    </sup>
                                    <br>
                                @endif
                                <div class="d-flex justify-content-between" style="font-size: 13px">
                                    <div class="text-bold">Tgl Tenggat</div>
                                    <div class="text-bold">
                                        {{ Carbon\Carbon::parse($a->tgl_tenggat)->isoFormat('D MMM YYYY') }}
                                    </div>
                                </div>
                                <div class="text-left" style="font-size: 13px;">
                                    <span class="text-bold" style="font-size: 13px;">
                                        {{ $a->tujuan }}
                                    </span>
                                    <br>
                                    <em class="text-secondary">
                                        {{ $a->note ?? '-' }}
                                    </em>
                                </div>
                            </td>

                            <td>
                                @if ($a->approval_status_divpro == 'Disetujui')
                                    @if ($a->approval_status == 'Belum Direspon')
                                        <sup class="badge badge-warning text-white">Pengajuan blm disetujui
                                            Direktur</sup>
                                        <br>
                                    @elseif($a->approval_status == 'Disetujui')
                                        <sup class="badge badge-success text-white">Pengajuan disetujui Direktur</sup>
                                        <br>
                                    @else
                                        <sup class="badge badge-danger text-white">Pengajuan ditolak Direktur</sup>
                                        <br>
                                    @endif
                                @else
                                    <sup class="text-secondary" style="font-size: 13px;">Blm Disetujui</sup>
                                    <br>
                                @endif
                                <div class="d-flex justify-content-between" style="font-size: 13px">
                                    <div class="text-bold">Tgl Disetujui</div>
                                    @if ($a->approval_status == 'Disetujui')
                                        <div class="text-bold">
                                            {{ Carbon\Carbon::parse($a->approval_date)->isoFormat('D MMM YYYY') }}
                                        </div>
                                    @else
                                        <span>-</span>
                                    @endif

                                </div>
                                <div class="row text-right">
                                    <div class="col text-bold  text-left" style="font-size: 10pt;">
                                        Nominal
                                    </div>
                                    <div class="col text-bold text-right" style="font-size: 10pt;">
                                        <b class="text-success" style="font-size: 10pt;">
                                            Rp{{ number_format($a->nominal_disetujui), 0, '.', '.' }}
                                        </b>
                                    </div>
                                </div>
                                <em class="text-secondary" style="font-size: 13px;">
                                    {{ $a->approval_note ?? '-' }}
                                </em>
                            </td>
                            <td>
                                @if ($a->approval_status == 'Disetujui')
                                    @if ($a->pencairan_status == 'Belum Dicairkan')
                                        <sup class="badge badge-warning text-white">Pencairan blm disetujui Div.
                                            Keuangan</sup>
                                    @elseif ($a->pencairan_status == 'Berhasil Dicairkan')
                                        <sup class="badge badge-success text-white">Pencairan disetujui Div.
                                            Keuangan</sup>
                                    @else
                                        <sup class="badge badge-danger text-white">Pencairan ditolak Div.
                                            Keuangan</sup>
                                    @endif
                                    <br>
                                @else
                                    @if ($a->approval_status != 'Ditolak')
                                        <sup class="text-secondary" style="font-size: 13px;">Blm Disetujui</sup>
                                        <br>
                                    @else
                                        <sup class="text-secondary" style="font-size: 13px;"> -</sup>
                                        <br>
                                    @endif
                                @endif

                                <div class="d-flex justify-content-between" style="font-size: 13px">
                                    <div class="text-bold">Tgl Dicairkan</div>
                                    @if ($a->pencairan_status == 'Berhasil Dicairkan')
                                        <div class="text-bold">
                                            {{ Carbon\Carbon::parse($a->tgl_pencairan)->isoFormat('D MMM YYYY') }}
                                        </div>
                                    @else
                                        <span>-</span>
                                    @endif

                                </div>
                                <div class="row text-right">
                                    <div class="col text-bold  text-left" style="font-size: 10pt;">
                                        Nominal
                                    </div>
                                    <div class="col text-bold text-right" style="font-size: 10pt;">
                                        <b class="text-success" style="font-size: 10pt;">
                                            Rp{{ number_format($a->nominal_pencairan), 0, '.', '.' }}
                                        </b>
                                    </div>
                                </div>
                                <em class="text-secondary" style="font-size: 13px;">
                                    {{ $a->pencairan_note ?? '-' }}
                                </em>
                            </td>
                            <td>
                                @php
                                    $totalDigunakan = App\Models\lpjInternal::where('id_internal', $a->id_internal)->sum('nominal');
                                    $sisaNominal = $a->nominal_pencairan - $totalDigunakan;
                                    if ($sisaNominal < 0) {
                                        $format_sisa_dana = '-Rp' . number_format(abs($sisaNominal), 0, '.', '.');
                                        $warna = 'danger';
                                    } else {
                                        $format_sisa_dana = 'Rp' . number_format($sisaNominal, 0, '.', '.');
                                        $warna = 'black';
                                    }
                                @endphp

                                <div class="row text-right">
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
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- end tabel --}}

    </div>


    @include('modal.modal_internal_pc_tambah')



    <br>
    <div class="row">
        <div class="col-md-8">

            <div class="card " style="height: 50vh;" wire:ignore>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <strong>
                            Jumlah Pengajuan Berdasarkan Tujuan
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
                        <canvas id="myChart4"
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
                        Statistik Pengajuan Internal
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



    @push('script-internalpc')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            $(document).ready(function() {
                $('#Internal').DataTable({
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
                            'month').endOf('month')],
                        'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
                        'Semua': [moment('{{ $data_first }}'), moment('{{ $data_last }}')]

                    }
                }, function(start, end) {
                    $('#reportrange').val(start.format('Y-MM-DD') + ' - ' + end.format('Y-MM-DD'));
                    $('#filterFormInternal').submit(); // Mengirimkan formulir saat terjadi perubahan
                });

                // moment.locale('id');
                cb(start, end);
                window.start = start;
                window.end = end;

            });

            function submitFormUpzis() {
                $('#reportrange').val(window.start.format('Y-MM-DD') + ' - ' + window.end.format('Y-MM-DD'));
                $('#filterFormInternal').submit();
            }

            function submitFormInternal() {
                $('#reportrange').val(window.start.format('Y-MM-DD') + ' - ' + window.end.format('Y-MM-DD'));
                $('#filterFormInternal').submit();
            }
        </script>
    @endpush
</div>
