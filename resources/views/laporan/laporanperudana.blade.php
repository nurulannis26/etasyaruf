@extends('main')

@section('laporankeu', 'active')

@section('css')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">

                <div class="col-sm-6 text-secondary mt-1">
                    <a href="/{{ $role }}/dashboard"> Dashboard</a> /
                    <a href="/{{ $role }}/laporankeu"> Laporan Keuangan</a> /
                    <a> Laporan Perubahan Dana</a>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ">
        <div class="container-fluid">


            <div class="row">
                <div class="col-12">
                    <div class="card ijo-atas">
                        {{-- <h5 class="d-flex mt-2 ml-2">
                            <b class="text-success pl-2 mt-1">LAPORAN PENYALURAN UPZIS MWCNU KEDUNGREJA</b>
                        </h5> --}}
                        <div class="d-flex justify-content-between mt-3 ml-3 mr-3">
                            <div class="d-flex flex-row bd-highlight align-items-center">
                                <div class=" bd-highlight">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="ml-2 bd-highlight">
                                    <span>
                                        Data dalam laporan ini terisi otomatis berdasarkan penyaluran yang sudah disetujui
                                        pada E-TASYARUF. <a href="https://e-tasyaruf.nucarecilacap.id/" target="_blank"><b
                                                style="font-size: 12pt;">
                                                Lihat selengkapnya</b></a>

                                    </span>
                                </div>
                            </div>

                            <a href="/{{ $role }}/print_perudana/{{ $bulan }}/{{ $tahun }}/{{ $id_upzis }}"
                                target="_blank" class="btn btn-outline-success intro-ekspors-data-pengajuan">
                                <i class="fas fa-file-pdf"></i> Cetak</a>
                        </div>


                        {{-- card body --}}
                        <div class="card-body">
                            <div class="bg-light p-2 text-bold text-center mb-3" style="border-radius: 10px">
                                LAPORAN PERUBAHAN DANA<br>
                                UPZIS MWCNU {{ strtoupper(Auth::user()->UpzisPengurus->Upzis->Wilayah->nama) }}<br>
                                {{ strtoupper(app\Helpers\BasicHelper::getNamaBulan($bulan)) }} {{ $tahun }}<br>
                            </div>
                            {{-- <div class="d-flex justify-content-between">
                                <a href="" class="btn btn-outline-secondary btn-sm px-5">Filter</a>
                                <a href="" class="btn btn-success btn-sm px-5">Edit</a>
                            </div> --}}
                            <style>
                                .atas {
                                    border-collapse: separate;
                                    border-spacing: 0 10px;
                                }

                                .atas tr {
                                    line-height: 2em;
                                }

                                .atas td {
                                    border-bottom: 1px solid #E4E9EF;
                                    vertical-align: middle;
                                    ;
                                }

                                /* .tengah tr{
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        text-align: center;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } */

                                .tengah tr {
                                    border: 1px solid black;
                                }

                                .tengah td {
                                    width: 100px;
                                    border: 1px solid black;
                                    text-align: center;
                                }
                            </style>
                            <table width='100%' class="atas">

                                <tr style="background-color: #28A745;color:white">
                                    <td style="width: 70%;padding-left:2mm;padding-right:2mm;" colspan="2">
                                        <span class="text-bold">DANA INFAK/SEDEKAH</span>
                                    </td>
                                    <td style="width: 15%;text-align:center" class="text-bold">
                                        <span></span>
                                    </td>

                                </tr>

                                <tr style="background-color: #E4E9EF;">
                                    <td colspan="3" style="padding-left:2mm;padding-right:2mm;">
                                        <span class="text-bold">Saldo Awal
                                            {{ app\Helpers\BasicHelper::getNamaBulan($bulan) }} Tahun
                                            {{ $tahun }}</span>
                                    </td>
                                </tr>
                                <tr style="line-height: 1.5em">
                                    <td style=" border-bottom: 1px solid #ffffff;">
                                    </td>
                                    <td>
                                        <span style="padding-left:2mm">Kas</span>
                                    </td>

                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                        <span style="float: left;">Rp</span>
                                        <span style="float: right;">{{ number_format($kas, 0, '.', '.') }},-</span>
                                    </td>
                                </tr>
                                <tr style="line-height: 1.5em">
                                    <td style=" border-bottom: 1px solid #ffffff;">
                                    </td>
                                    <td>
                                        <span style="padding-left:2mm">Bank</span>
                                    </td>

                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                        <span style="float: left;">Rp</span>
                                        <span style="float: right;">{{ number_format($bank, 0, '.', '.') }},-</span>
                                    </td>
                                </tr>

                                <tr style="height:0.1cm">
                                </tr>
                                <tr style="background-color: #E4E9EF;">
                                    <td colspan="3" style="padding-left:2mm;padding-right:2mm;">
                                        <span class="text-bold">PENERIMAAN DANA INFAK/SEDEKAH :</span>
                                    </td>
                                </tr>

                                <tr style="line-height: 1.5em">
                                    <td colspan="2">
                                        Prosentase Koin NU
                                    </td>
                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;">

                                    </td>
                                </tr>
                                <tr style="line-height: 1.5em">
                                    <td style=" border-bottom: 1px solid #ffffff;">
                                    </td>
                                    <td>
                                        <span style="padding-left:2mm">Sosial</span>
                                    </td>
                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                        {!! app\Http\Controllers\LaporanController::getPenerimaanPerProgram($bulan, $tahun, $id_rekening_sosial) !!}
                                    </td>

                                </tr>
                                <tr style="line-height: 1.5em">
                                    <td style=" border-bottom: 1px solid #ffffff;">
                                    </td>
                                    <td>
                                        <span style="padding-left:2mm">Kelembagaan</span>
                                    </td>
                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                        {!! app\Http\Controllers\LaporanController::getPenerimaanPerProgram($bulan, $tahun, $id_rekening_kelembagaan) !!}
                                    </td>

                                </tr>
                                <tr style="line-height: 1.5em">
                                    <td style=" border-bottom: 1px solid #ffffff;">
                                    </td>
                                    <td>
                                        <span style="padding-left:2mm">Operasional</span>
                                    </td>
                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                        {!! app\Http\Controllers\LaporanController::getPenerimaanPerProgram($bulan, $tahun, $id_rekening_operasional) !!}
                                    </td>

                                </tr>
                                <tr style="line-height: 1.5em">
                                    <td style=" border-bottom: 1px solid #ffffff;">
                                    </td>
                                    <td>
                                        <span style="padding-left:2mm">Penerimaan Lainnya</span>
                                    </td>
                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                        {!! app\Http\Controllers\LaporanController::getPenerimaanLainnya($bulan, $tahun) !!}
                                    </td>

                                </tr>

                                <tr style="line-height: 1.5em">
                                    <td style=" border-bottom: 1px solid #ffffff;">
                                    </td>
                                    <td>
                                        <span style="padding-left:2mm" class="text-bold">Jumlah Penerimaan Dana Infak /
                                            Sedekah {{ app\Helpers\BasicHelper::getNamaBulan($bulan) }} Tahun
                                            {{ $tahun }}</span>
                                    </td>
                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;" class="text-bold">
                                        {!! app\Http\Controllers\LaporanController::getJumlahPenerimaan(
                                            $bulan,
                                            $tahun,
                                            $id_rekening_sosial,
                                            $id_rekening_kelembagaan,
                                            $id_rekening_operasional,
                                        ) !!}
                                    </td>

                                </tr>

                                <tr style="height:0.1cm"></tr>
                                <tr style="background-color: #E4E9EF;">
                                    <td colspan="3" style="padding-left:2mm;padding-right:2mm;">
                                        <span class="text-bold">PENYALURAN DANA INFAK/SEDEKAH :</span>
                                    </td>
                                </tr>

                                @php
                                    $totalJumlahPerPilar = 0;
                                @endphp

                                @foreach ($pilar as $a)
                                    <tr style="line-height: 1.5em">
                                        <td style=" border-bottom: 1px solid #ffffff;"></td>
                                        <td>
                                            <span style="padding-left:2mm">{{ $a->pilar }}</span>
                                        </td>
                                        <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                            <span style="float: left;">Rp</span>
                                            <span style="float: right;">
                                                {{ number_format(app\Http\Controllers\LaporanController::getJumlahPerPilar($bulan, $tahun, $id_upzis, $a->id_program_pilar), 0, '.', '.') }},-
                                            </span>
                                            @php
                                                $totalJumlahPerPilar += app\Http\Controllers\LaporanController::getJumlahPerPilar($bulan, $tahun, $id_upzis, $a->id_program_pilar);
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                                <tr style="line-height: 1.5em">
                                    <td style=" border-bottom: 1px solid #ffffff;">
                                    </td>
                                    <td>
                                        <span style="padding-left:2mm" class="text-bold">Jumlah Penyaluran Dana
                                            Infak/Sedekah {{ app\Helpers\BasicHelper::getNamaBulan($bulan) }} Tahun
                                            {{ $tahun }}</span>
                                    </td>
                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;" class="text-bold">
                                        <span style="float: left;">Rp</span>
                                        <span
                                            style="float: right;">{{ number_format($totalJumlahPerPilar, 0, '.', '.') }},-</span>
                                    </td>

                                </tr>


                                @if (count($pengeluaran_lainnya) == 0)
                                @else
                                    <tr style="height:0.1cm"></tr>
                                    <tr style="background-color: #E4E9EF;">
                                        <td colspan="3" style="padding-left:2mm;padding-right:2mm;">
                                            <span class="text-bold">PENGELUARAN DANA INFAK/SEDEKAH LAINNYA</span>
                                        </td>
                                    </tr>
                                    @foreach ($pengeluaran_lainnya as $c)
                                        <tr style="line-height: 1.5em">
                                            <td style=" border-bottom: 1px solid #ffffff;">
                                            </td>
                                            <td>
                                                <span style="padding-left:2mm">{{ $c->uraian }}</span>
                                            </td>

                                            <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                                <span style="float: left;">Rp</span>
                                                <span
                                                    style="float: right;">{{ number_format($c->nominal, 0, '.', '.') }},-</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif


                                <tr style="height:0.1cm"></tr>
                                <tr style="height:0.1cm"></tr>
                                <tr style="height:0.1cm"></tr>

                                <tr style="line-height: 1.5em">
                                    <td style=" border-bottom: 1px solid #ffffff;">
                                    </td>
                                    <td>
                                        <span style="padding-left:2mm" class="text-bold">Saldo Akhir Dana Infak/Sedekah
                                            {{ app\Helpers\BasicHelper::getNamaBulan($bulan) }} Tahun
                                            {{ $tahun }}</span>
                                    </td>
                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;" class="text-bold">
                                        {!! app\Http\Controllers\LaporanController::getSaldoAkhir(
                                            $bulan,
                                            $tahun,
                                            $id_upzis,
                                            $kas + $bank,
                                            $id_rekening_sosial,
                                            $id_rekening_kelembagaan,
                                            $id_rekening_operasional,
                                        ) !!}
                                    </td>

                                </tr>






                            </table>





                            <br>
                            <table style="width: 100%">
                                <tr>
                                    <td style="width: 50%;text-align: center;">*Menampilkan laporan penyaluran yang telah
                                        disetujui PC Lazisnu</td>
                                    <td style="width: 50%;text-align: center;">
                                        {{ Auth::user()->UpzisPengurus->Upzis->Wilayah->nama }},
                                        {{ app\Helpers\BasicHelper::getTanggalTerakhir($bulan, $tahun) }}
                                        {{ app\Helpers\BasicHelper::getNamaBulan($bulan) }} {{ $tahun }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;text-align: center;">Mengetahui,</td>
                                    <td style="width: 50%;text-align: center;">Yang Membuat</td>
                                </tr>

                                <tr style="height: 2cm;">
                                    <td style="width: 50%;text-align: center;"></td>
                                    <td style="width: 50%;text-align: center;"> </td>

                                </tr>
                                <tr>
                                    <td style="width: 50%;text-align: center;">
                                        {{ app\Helpers\BasicHelper::getNamaKetuaUpzis($id_upzis) }}</td>
                                    <td style="width: 50%;text-align: center;">
                                        {{ app\Helpers\BasicHelper::getNamaBendaharaUpzis($id_upzis) }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 50%;text-align: center;">Ketua UPZIS</td>
                                    <td style="width: 50%;text-align: center;">Bendahara UPZIS</td>
                                </tr>

                            </table>
                            {{-- end ttd --}}

                        </div>

                        {{-- end card body --}}

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection


@section('js')

    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>


@endsection






@push('intro_data_pengajuan')
    <script>
        function klikkene(value) {
            introJs().setOptions({
                    steps: [{
                            element: document.querySelector('.card-header-data-pengajuan'),
                            title: 'Data Pengajuan',
                            intro: 'Menampilkan pengajuan pentasyarufan tingkat UPZIS MWCNU dan Ranting NU'
                        },
                        {
                            element: document.querySelector('.intro-card-data-pengajuan'),
                            title: 'Aksi',
                            intro: 'Menampilkan informasi dan aksi mengenai data pentasyarufan yang dipilih'
                        },
                        {
                            element: document.querySelector('.intro-filter-data-pengajuan'),
                            title: 'Filter Pengajuan',
                            intro: 'Untuk menampilkan data pentasyarufan secara spesifik, gunakan filter'
                        },
                        {
                            element: document.querySelector('.intro-reset-data-pengajuan'),
                            title: 'Reset',
                            intro: 'Klik disini untuk mereset filter'
                        },
                        @if (Auth::user()->gocap_id_upzis_pengurus != null)
                            {
                                element: document.querySelector('.intro-tambah-data-pengajuan'),
                                title: 'Tambah',
                                intro: 'Klik disini untuk menambahkan pengajuan pentasyarufan'
                            },
                        @endif
                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                            {
                                element: document.querySelector('.intro-ekspors-data-pengajuan'),
                                title: 'Ekspor',
                                intro: 'Klik disini untuk ekspor data pengajuan pentasyarufan '
                            },
                        @endif {
                            element: document.querySelector('.intro-table-pengajuan'),
                            title: 'Data Pengajuan',
                            intro: 'Data pengajuan pentasyarufan berdasarkan filter akan tampil di tabel berikut, klik mana saja pada salah satu data untuk melihat detail'
                        }

                    ]
                }).setOption("dontShowAgain", value)
                .setOption("skipLabel", "<p widht='100px' style='font-size:12px;color:blue;'><u>Lewati</u> </p>")
                .setOption("dontShowAgainLabel", " Jangan Tampilkan Lagi")
                .setOption("disableInteraction", true)
                .setOption("nextLabel", "Lanjut")
                .setOption("prevLabel", "Kembali")
                .setOption("doneLabel", "Selesai")
                .setOptions({
                    showProgress: true,
                })
                .onbeforechange(function() {

                    if (this._currentStep === 0) {
                        $('#upzis-tab').find('span').trigger('click');
                        return true;
                    }
                }).oncomplete(function() {
                    location.reload();
                })
                .start();
        }

        $(document).ready(function() {
            klikkene(true);
            $("#panduan").click(function() {
                klikkene(false);
            });
        });
    </script>
@endpush
