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

                    <a> Laporan Penyaluran Program</a>
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

                            <a href="/{{ $role }}/print_penyaluran/{{ $bulan }}/{{ $tahun }}/{{ $id_upzis }}"
                                target="_blank" class="btn btn-outline-success intro-ekspors-data-pengajuan">
                                <i class="fas fa-file-pdf"></i> Cetak</a>
                        </div>

                        {{-- card body --}}
                        <div class="card-body">

                            <div class="bg-light p-2 text-bold text-center mb-3" style="border-radius: 10px">
                                LAPORAN PENYALURAN PROGRAM<br>
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
                                    <td style="padding-left:2mm;padding-right:2mm;" colspan="2">

                                    </td>
                                    <td style="width: 35%;text-align:center" class="text-bold">
                                        <span>KETERANGAN</span>
                                    </td>
                                    <td style="width: 10%;text-align:center" class="text-bold">
                                        <span>JML P.MANFAAT</span>
                                    </td>
                                    <td style="width: 10%;text-align:center" class="text-bold">
                                        <span>TGL PENYALURAN</span>
                                    </td>
                                    <td style="width: 15%;text-align:center" class="text-bold">
                                        <span>NOMINAL</span>
                                    </td>
                                </tr>

                                <tr style="background-color: #E4E9EF;">
                                    <td colspan="6" style="padding-left:2mm;padding-right:2mm;">
                                        <span class="text-bold">PENYALURAN DANA SOSIAL</span>
                                    </td>
                                </tr>

                                @php
                                    $jml_dana_sosial = 0;
                                    
                                @endphp

                                @foreach ($pilar_sosial as $index => $a)
                                    <tr style="background-color: #E4E9EF;">
                                        <td style="text-align: center;width:2%">
                                            <span class="text-bold">{{ array_shift($letter_a) }}.</span>
                                        </td>
                                        <td colspan="6" style="padding-left:2mm;padding-right:2mm;">
                                            <span class="text-bold">{{ $a->pilar }}</span>
                                        </td>
                                    </tr>

                                    @php
                                        $etasyaruf = config('app.database_etasyaruf');
                                        $siftnu = config('app.database_siftnu');
                                        $gocap = config('app.database_gocap');
                                        $kegiatan = DB::table($etasyaruf . '.pengajuan_detail')
                                            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                                            ->join($etasyaruf . '.program_kegiatan', $etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $etasyaruf . '.pengajuan_detail.id_program_kegiatan')
                                            ->where('approval_status', 'Disetujui')
                                            ->whereNotNull('id_pc')
                                            ->where('id_upzis', $id_upzis)
                                            ->whereNull('id_ranting')
                                            ->whereMonth($etasyaruf . '.pengajuan_detail.created_at', $bulan)
                                            ->whereYear($etasyaruf . '.pengajuan_detail.created_at', $tahun)
                                            ->where($etasyaruf . '.pengajuan_detail.id_program_pilar', $a->id_program_pilar)
                                            ->where($etasyaruf . '.pengajuan_detail.id_program', $a->id_program)
                                            ->get();
                                    @endphp

                                    @if (count($kegiatan) == 0)
                                        <tr style="line-height: 1.5em">
                                            <td style=" border-bottom: 1px solid #ffffff;">
                                            </td>
                                            <td colspan="4">
                                                <span style="padding-left:2mm" class="text-bold">-</span>
                                            </td>
                                        </tr>
                                    @else
                                        @php
                                            $total_penyaluran_a = 0;
                                            $total_penerima_a = 0;
                                        @endphp
                                        @foreach ($kegiatan as $a1)
                                            <tr style="line-height: 1.5em">
                                                <td style=" border-bottom: 1px solid #ffffff;">
                                                </td>
                                                <td>
                                                    <span style="padding-left:2mm">{{ $loop->iteration }}.
                                                        {{ $a1->nama_program }}</span>
                                                </td>
                                                <td
                                                    @if ($a1->pengajuan_note == '-') style="padding-left:2mm;padding-right:2mm;text-align:center" @else style="padding-left:2mm;padding-right:2mm;text-align:justify" @endif>
                                                    <span>{{ $a1->pengajuan_note }}</span>
                                                </td>
                                                <td style="padding-left:2mm;padding-right:2mm;text-align:center">
                                                    <span>{{ $a1->jumlah_penerima }}</span>
                                                </td>
                                                <td style="padding-left:2mm;padding-right:2mm;text-align:center">
                                                    <span>
                                                        {{ Carbon\Carbon::parse($a1->tgl_pelaksanaan)->isoFormat('DD MMMM Y') }}
                                                    </span>
                                                </td>
                                                <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                                    <span style="float: left;">Rp</span>
                                                    <span style="float: right;">
                                                        {{ number_format($a1->nominal_disetujui, 0, '.', '.') }},-</span>
                                                </td>
                                            </tr>

                                            @php
                                                $total_penyaluran_a += $a1->nominal_disetujui;
                                                $total_penerima_a += $a1->jumlah_penerima;
                                            @endphp
                                        @endforeach

                                        <tr style="line-height: 1.5em">
                                            <td style=" border-bottom: 1px solid #ffffff;">
                                            </td>
                                            <td colspan="2">
                                                <span style="padding-left:2mm" class="text-bold">Jumlah Penyaluran Pilar
                                                    {{ $a->pilar }}
                                                    {{ app\Helpers\BasicHelper::getNamaBulan($bulan) }} Tahun
                                                    {{ $tahun }}</span>
                                            </td>


                                            <td style="padding-left:2mm;padding-right:2mm;text-align:center"
                                                class="text-bold">
                                                <span>{{ $total_penerima_a }}</span>
                                            </td>
                                            <td>
                                            </td>
                                            <td style="clear: both;padding-left:2mm;padding-right:2mm;" class="text-bold">
                                                <span style="float: left;">Rp</span>
                                                <span
                                                    style="float: right;">{{ number_format($total_penyaluran_a, 0, '.', '.') }},-</span>
                                            </td>
                                        </tr>
                                    @endif
                                    @php
                                        $jml_dana_sosial += $total_penyaluran_a;
                                    @endphp
                                @endforeach

                                <tr style="background-color: #E4E9EF;">
                                    <td class="text-right" colspan="5" style="padding-left:2mm;padding-right:2mm;">
                                        <span class="text-bold">JUMLAH PENYALURAN DANA SOSIAL </span>
                                    </td>
                                    <td style="clear: both;padding-left:2mm;padding-right:2mm;" class="text-bold">
                                        <span style="float: left;">Rp</span>
                                        <span style="float: right;">
                                            {{ number_format($jml_dana_sosial, 0, '.', '.') }},-</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="padding-left:2mm;padding-right:2mm;">
                                        <span class="text-bold"></span>
                                    </td>
                                </tr>

                                <tr style="background-color: #E4E9EF;">
                                    <td colspan="6" style="padding-left:2mm;padding-right:2mm;">
                                        <span class="text-bold">PENYALURAN DANA KELEMBAGAAN</span>
                                    </td>
                                </tr>

                                @foreach ($pilar_kelembagaan as $index => $b)
                                    <tr style="background-color: #E4E9EF;">
                                        <td style="text-align: center;width:2%">
                                            <span class="text-bold">{{ array_shift($letter_b) }}.</span>
                                        </td>
                                        <td colspan="6" style="padding-left:2mm;padding-right:2mm;">
                                            <span class="text-bold">{{ $b->pilar }}</span>
                                        </td>
                                    </tr>

                                    @php
                                        $etasyaruf = config('app.database_etasyaruf');
                                        $siftnu = config('app.database_siftnu');
                                        $gocap = config('app.database_gocap');
                                        $kegiatan = DB::table($etasyaruf . '.pengajuan_detail')
                                            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                                            ->join($etasyaruf . '.program_kegiatan', $etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $etasyaruf . '.pengajuan_detail.id_program_kegiatan')
                                            ->where('approval_status', 'Disetujui')
                                            ->whereNotNull('id_pc')
                                            ->where('id_upzis', $id_upzis)
                                            ->whereNull('id_ranting')
                                            ->whereMonth($etasyaruf . '.pengajuan_detail.created_at', $bulan)
                                            ->whereYear($etasyaruf . '.pengajuan_detail.created_at', $tahun)
                                            ->where($etasyaruf . '.pengajuan_detail.id_program_pilar', $b->id_program_pilar)
                                            ->where($etasyaruf . '.pengajuan_detail.id_program', $b->id_program)
                                            ->get();
                                    @endphp

                                    @if (count($kegiatan) == 0)
                                        <tr style="line-height: 1.5em">
                                            <td style=" border-bottom: 1px solid #ffffff;">
                                            </td>
                                            <td colspan="4">
                                                <span style="padding-left:2mm" class="text-bold">-</span>
                                            </td>
                                        </tr>
                                    @else
                                        @php
                                            $total_penyaluran_b = 0;
                                            $total_penerima_b = 0;
                                        @endphp
                                        @foreach ($kegiatan as $b1)
                                            <tr style="line-height: 1.5em">
                                                <td style=" border-bottom: 1px solid #ffffff;">
                                                </td>
                                                <td>
                                                    <span style="padding-left:2mm">{{ $loop->iteration }}.
                                                        {{ $b1->nama_program }}</span>
                                                </td>
                                                <td
                                                    @if ($b1->pengajuan_note == '-') style="padding-left:2mm;padding-right:2mm;text-align:center" @else style="padding-left:2mm;padding-right:2mm;text-align:justify" @endif>

                                                    <span>{{ $b1->pengajuan_note }}</span>
                                                </td>
                                                <td style="padding-left:2mm;padding-right:2mm;text-align:center">

                                                    <span>{{ $b1->jumlah_penerima }}</span>
                                                </td>
                                                <td style="padding-left:2mm;padding-right:2mm;text-align:center">
                                                    <span>
                                                        {{ Carbon\Carbon::parse($b1->tgl_pelaksanaan)->isoFormat('DD MMMM Y') }}
                                                    </span>
                                                </td>
                                                <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                                    <span style="float: left;">Rp</span>
                                                    <span style="float: right;">
                                                        {{ number_format($b1->nominal_disetujui, 0, '.', '.') }},-</span>
                                                </td>
                                            </tr>

                                            @php
                                                $total_penyaluran_b += $b1->nominal_disetujui;
                                                $total_penerima_b += $b1->jumlah_penerima;
                                            @endphp
                                        @endforeach

                                        <tr style="line-height: 1.5em">
                                            <td style=" border-bottom: 1px solid #ffffff;">
                                            </td>
                                            <td colspan="2">
                                                <span style="padding-left:2mm" class="text-bold">Jumlah Penyaluran Pilar
                                                    Pendidikan
                                                    {{ app\Helpers\BasicHelper::getNamaBulan($bulan) }} Tahun
                                                    {{ $tahun }}</span>
                                            </td>


                                            <td style="padding-left:2mm;padding-right:2mm;text-align:center"
                                                class="text-bold">
                                                <span>{{ $total_penerima_b }}</span>
                                            </td>
                                            <td>
                                            </td>
                                            <td style="clear: both;padding-left:2mm;padding-right:2mm;" class="text-bold">
                                                <span style="float: left;">Rp</span>
                                                <span
                                                    style="float: right;">{{ number_format($total_penyaluran_b, 0, '.', '.') }},-</span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                <tr style="background-color: #E4E9EF;">
                                    <td colspan="6" style="padding-left:2mm;padding-right:2mm;">
                                        <span class="text-bold">PENYALURAN DANA OPERASIONAL</span>
                                    </td>
                                </tr>

                                @foreach ($pilar_operasional as $index => $c)
                                    <tr style="background-color: #E4E9EF;">
                                        <td style="text-align: center;width:2%">
                                            <span class="text-bold">{{ array_shift($letter_c) }}.</span>
                                        </td>
                                        <td colspan="6" style="padding-left:2mm;padding-right:2mm;">
                                            <span class="text-bold">{{ $c->pilar }}</span>
                                        </td>
                                    </tr>

                                    @php
                                        $etasyaruf = config('app.database_etasyaruf');
                                        $siftnu = config('app.database_siftnu');
                                        $gocap = config('app.database_gocap');
                                        $kegiatan = DB::table($etasyaruf . '.pengajuan_detail')
                                            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                                            ->join($etasyaruf . '.program_kegiatan', $etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $etasyaruf . '.pengajuan_detail.id_program_kegiatan')
                                            ->where('approval_status', 'Disetujui')
                                            ->whereNotNull('id_pc')
                                            ->where('id_upzis', $id_upzis)
                                            ->whereNull('id_ranting')
                                            ->whereMonth($etasyaruf . '.pengajuan_detail.created_at', $bulan)
                                            ->whereYear($etasyaruf . '.pengajuan_detail.created_at', $tahun)
                                            ->where($etasyaruf . '.pengajuan_detail.id_program_pilar', $c->id_program_pilar)
                                            // id_program2 karena operasional
                                            ->where($etasyaruf . '.pengajuan_detail.id_program', $c->id_program2)
                                        
                                            ->get();
                                    @endphp

                                    @if (count($kegiatan) == 0)
                                        <tr style="line-height: 1.5em">
                                            <td style=" border-bottom: 1px solid #ffffff;">
                                            </td>
                                            <td colspan="4">
                                                <span style="padding-left:2mm" class="text-bold">-</span>
                                            </td>
                                        </tr>
                                    @else
                                        @php
                                            $total_penyaluran_c = 0;
                                            $total_penerima_c = 0;
                                        @endphp
                                        @foreach ($kegiatan as $c1)
                                            <tr style="line-height: 1.5em">
                                                <td style=" border-bottom: 1px solid #ffffff;">
                                                </td>
                                                <td>
                                                    <span style="padding-left:2mm">{{ $loop->iteration }}.
                                                        {{ $c1->nama_program }}</span>
                                                </td>
                                                <td
                                                    @if ($c1->pengajuan_note == '-') style="padding-left:2mm;padding-right:2mm;text-align:center" @else style="padding-left:2mm;padding-right:2mm;text-align:justify" @endif>
                                                    <span>{{ $c1->pengajuan_note }}</span>
                                                </td>
                                                <td style="padding-left:2mm;padding-right:2mm;text-align:center">

                                                    <span>{{ $c1->jumlah_penerima }}</span>
                                                </td>
                                                <td style="padding-left:2mm;padding-right:2mm;text-align:center">
                                                    <span>
                                                        {{ Carbon\Carbon::parse($c1->tgl_pelaksanaan)->isoFormat('DD MMMM Y') }}
                                                    </span>
                                                </td>
                                                <td style="clear: both;padding-left:2mm;padding-right:2mm;">
                                                    <span style="float: left;">Rp</span>
                                                    <span style="float: right;">
                                                        {{ number_format($c1->nominal_disetujui, 0, '.', '.') }},-</span>
                                                </td>
                                            </tr>

                                            @php
                                                $total_penyaluran_c += $c1->nominal_disetujui;
                                                $total_penerima_c += $c1->jumlah_penerima;
                                            @endphp
                                        @endforeach

                                        <tr style="line-height: 1.5em">
                                            <td style=" border-bottom: 1px solid #ffffff;">
                                            </td>
                                            <td colspan="2">
                                                <span style="padding-left:2mm" class="text-bold">Jumlah Penyaluran Pilar
                                                    Pendidikan
                                                    {{ app\Helpers\BasicHelper::getNamaBulan($bulan) }} Tahun
                                                    {{ $tahun }}</span>
                                            </td>


                                            <td style="padding-left:2mm;padding-right:2mm;text-align:center"
                                                class="text-bold">
                                                <span>{{ $total_penerima_c }}</span>
                                            </td>
                                            <td>
                                            </td>
                                            <td style="clear: both;padding-left:2mm;padding-right:2mm;" class="text-bold">
                                                <span style="float: left;">Rp</span>
                                                <span
                                                    style="float: right;">{{ number_format($total_penyaluran_c, 0, '.', '.') }},-</span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

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
