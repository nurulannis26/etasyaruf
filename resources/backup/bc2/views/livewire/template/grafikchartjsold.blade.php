<div>
    {{-- The best athlete wants his opponent at his best. --}}
    {{-- filter --}}



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
            <form action="/{{ $role }}/filter_internal_pc_post" method="post">
                @csrf
                {{-- baris 1 --}}
                <div class="form-row intro-filter-data-pengajuan-pc">


                    {{-- bulan --}}
                    <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Bulan</span>
                            </div>
                            <select wire:model="filter_bulan" wire:loading.attr="disabled" class="form-control"
                                onchange="javascript:this.form.submit();" name="bulan_lv">
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
                    {{-- end bulan --}}

                    {{-- tahun --}}
                    <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Tahun </span>
                            </div>
                            <select wire:model="filter_tahun" wire:loading.attr="disabled" class="form-control"
                                onchange="javascript:this.form.submit();" name="tahun_lv">
                                @if (count($tahun_pengajuan) == 0)
                                    <option value="">-</option>
                                @else
                                    @foreach ($tahun_pengajuan as $a)
                                        <option value="{{ $a->tahun }}">{{ $a->tahun }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    {{-- end tahun --}}

                    {{-- status --}}
                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Status </span>
                            </div>
                            <select wire:model="filter_status" wire:loading.attr="disabled" class="form-control"
                                onchange="javascript:this.form.submit();" name="status_lv">
                                <option value="">Semua</option>
                                <option value="Belum Direspon">Belum Direspon</option>
                                <option value="Disetujui">Disetujui</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    {{-- end status --}}


                    {{-- status --}}
                    <div class="col-12 col-md-5 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Penggunaan Dana</span>
                            </div>
                            <select wire:model="filter_tujuan" wire:loading.attr="disabled" class="form-control"
                                onchange="javascript:this.form.submit();" name="tujuan_lv">
                                <option value="">Semua</option>
                                <option value="Uang Muka">Uang Muka</option>
                                <option value="Reimbursement">Reimbursement</option>
                                <option value="Pembayaran">Pembayaran</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    {{-- end status --}}






                </div>
                {{-- end baris 1 --}}

            </form>

            {{-- baris 2 --}}
            <div class="form-row mt-4">

                {{-- info --}}
                <div class="col-12 col-md-7 col-sm-12 mb-2 mb-xl-0">
                    <div class="d-flex flex-row bd-highlight align-items-center">
                        <div class="p-2 bd-highlight">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="p-1 bd-highlight">
                            <span>Menampilkan data pengajuan
                                <span class="text-bold"> Internal Manajemen Eksekutif Lazisnu Cilacap
                                </span>
                                pada filter
                                terpilih. </span>
                        </div>
                    </div>
                </div>
                {{-- end info --}}




                {{-- tombol reset --}}
                <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                    <button class="btn btn-secondary btn-block intro-reset-filter-data-pengajuan-pc"
                        wire:click="reset_filter_internal_pc"><i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                {{-- end tombol reset --}}


                <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0 ">
                    <a href="/{{ $role }}/print_internal/{{ $filter_bulan }}/{{ $filter_tahun }}/{{ $filter_status }}/{{ $filter_tujuan }}"
                        target="_blank" class="btn btn-block btn-outline-success intro-ekspor-data-pengajuan-pc">
                        <i class="fas fa-file-pdf"></i> Ekspor</a>
                </div>

                {{-- end ekspor --}}




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


    <div class="intro-table-data-pengajuan-pc">
        {{-- page number --}}
        <nav class="navbar navbar-expand-sm">
            <ul class="navbar-nav mr-auto my-4 my-sm-0 navbar-nav-scroll">
                <div class="row">
                    <div class="col mt-1">Show</div>
                    <div class="col">

                        <li class="nav-item p-0">
                            <div class="dataTables_length" id="example_length">
                                <select wire:model="page_number" name="example_length" aria-controls="example_length"
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

        {{-- tabel --}}
        <div class="table-responsive ">
            <table class="table table-bordered table-hover" style="width:100%" wire:ignore>
                <thead>
                    <tr class="text-center">
                        <th style="vertical-align:middle;width: 3%;">No</th>
                        <th style="vertical-align:middle;width: 30%;">Pengajuan</th>
                        <th style="vertical-align:middle;">Tenggat Pencairan</th>
                        <th style="vertical-align:middle;width: 15%;">Keterangan</th>
                        <th style="vertical-align:middle;width: 15%;">Bentuk Pencairan & Nominal Disetujui </th>
                        <th style="vertical-align:middle;width: 15%;">Status </th>
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
                        <tr wire:click="detail('{{ $a->id_internal }}')" style=" cursor: pointer;">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <b style="font-size: 16px"> {{ $a->nomor_surat }}</b><br>
                                <b style="font-size: 12pt;">
                                    Rp{{ number_format($a->nominal_pengajuan), 0, '.', '.' }},-</b><br>
                                <span style="font-size: 10pt;">
                                    {{ $this->nama_pengurus_pc($a->maker_tingkat_pc) }}
                                    ({{ $this->jabatan_pengurus_pc($a->maker_tingkat_pc) }})
                                </span><br>
                                <span style="font-size: 10pt;">
                                    {{ Carbon\Carbon::parse($a->tgl_pengajuan)->isoFormat('D MMMM Y') }}
                                    {{ Carbon\Carbon::parse($a->created_at)->format('H:i:s') }} <br>
                                </span>
                            </td>

                            <td>
                                <b style="font-size: 16px">Sebelum</b><br>
                                <span style="font-size: 10pt;">
                                    {{ Carbon\Carbon::parse($a->tgl_tenggat)->isoFormat('D MMMM Y') }}
                                </span>
                            </td>



                            <td>
                                <b style="font-size: 16px">{{ $a->tujuan }}</b><br>
                                <span style="font-size: 10pt;">
                                    {{ $a->note }}
                                </span>
                            </td>
                            <td class="text-right">
                                <b style="font-size: 16px">{{ $a->bentuk }}</b><br>
                                <b class="text-success" style="font-size: 12pt;">
                                    Rp{{ number_format($a->nominal_disetujui), 0, '.', '.' }},-</b><br>
                                {{-- <span style="font-size: 10pt;">
                                @if ($a->staf_keuangan_pc == null)
                                    -
                                @else
                                    ({{ $this->nama_pengurus_pc($a->staf_keuangan_pc) }})
                                @endif
                            </span> --}}
                            </td>
                            <td>
                                <div class='btn btn-light btn-block noClick btn-sm'
                                    style='border-radius:10px;
                            @if ($a->approval_status == 'Belum Direspon') background-color:#f7c353
                            @elseif($a->approval_status == 'Disetujui') background-color:#cbf2d6
                            @else background-color:#cccccc @endif'>
                                    {{ $a->approval_status }}
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-right">
                {{-- pagination --}}
                {{ $data->links() }}
            </div>
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
                        <style>
                            canvas {
                                overflow-clip-margin: content-box;
                                overflow: clip;
                                overflow-x: ;
                                overflow-y: ;
                            }
                        </style>

                        <canvas id="myChart4"
                            style="min-height: 250px; height: 255px; max-height: 250px; max-width: 100%; display: block; width: 511px;"
                            class="chartjs-render-monitor" width="598" height="298"></canvas>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("myChart4");
        debugger;
        var data = {
            labels: [
                'Uang Muka', 'Reimbursement', 'Pembayaran', 'Lainnya'
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
                ],

            }]
        }
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,

            options: {
                "hover": {
                    "animationDuration": 0
                },
                "animation": {
                    "duration": 1,
                    "onComplete": function() {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;

                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart
                            .defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function(dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                            });
                        });
                    }
                },
                legend: {
                    "display": true
                },
                tooltips: {
                    "enabled": false
                },
                scales: {
                    yAxes: [{

                        display: true,
                        gridLines: {
                            display: true
                        },

                        ticks: {

                            max: Math.max(...data.datasets[0].data),
                            display: true,
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: true
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

</div>
