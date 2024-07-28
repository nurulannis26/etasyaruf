@extends('main')

@section('dashboard', 'active')
@section('title', $title)

@section('css')

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">

                <div class="col-sm-6 text-secondary mt-1">
                    <a> Dashboard</a>
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
    <section class="content">

        <div class="container-fluid ">
            <!-- Info boxes -->
            <div class=" card ijo-atas">

                <div class="card-body">

                    @if ($c_tingkat == 'INTERNAL')
                        <livewire:filter-dashboard :c_filter_bulan="$c_filter_bulan" :c_filter_tahun="$c_filter_tahun" :c_filter_status="$c_filter_status" :c_filter_tujuan="$c_filter_tujuan"
                            :c_tingkat="$c_tingkat" />
                    @elseif ($c_tingkat == 'UMUM')
                        <livewire:filter-dashboard :c_filter_bulan="$c_filter_bulan" :c_filter_tahun="$c_filter_tahun" :c_filter_status="$c_filter_status" :c_filter_kategori="$c_filter_kategori"
                            :c_filter_pilar="$c_filter_pilar" :c_tingkat="$c_tingkat">
                        @elseif ($c_tingkat == 'UPZIS')
                            <livewire:filter-dashboard :c_filter_bulan="$c_filter_bulan" :c_filter_tahun="$c_filter_tahun" :c_filter_status="$c_filter_status"
                                :c_filter_id_upzis="$c_filter_id_upzis" :c_tingkat="$c_tingkat">
                            @elseif ($c_tingkat == 'RANTING')
                                <livewire:filter-dashboard :c_filter_bulan="$c_filter_bulan" :c_filter_tahun="$c_filter_tahun" :c_filter_status="$c_filter_status"
                                    :c_filter_id_ranting="$c_filter_id_ranting" :c_filter_id_upzis="$c_filter_id_upzis" :c_tingkat="$c_tingkat">
                                @else
                                    <livewire:filter-dashboard>
                    @endif


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



    <script>
        $(function() {
            $('#example2').DataTable({
                "pageLength": 6,
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        $('#example3').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>

    <script>
        $(function() {

            var areaChartDatas = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    backgroundColor: 'rgba(40,167,69)',
                    borderColor: 'rgba(40,167,69)',
                    pointRadius: false,
                    pointColor: '#28A745',
                    pointStrokeColor: 'rgba(40,167,69)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(40,167,69)',
                    data: [28, 48, 40, 19, 86, 27, 90]
                }, ]
            }
            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartDatas)
            var temp0 = areaChartDatas.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            //---------------------
            //- STACKED BAR CHART -
            //---------------------
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')


            var stackedBarChartOptions = {
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

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
    </script>

    @push('intro_tour_dashboard')
        @if (Auth::user()->gocap_id_pc_pengurus != null)
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-zero'),
                                    title: 'Tour Guide',
                                    intro: 'Untuk Menampilkan Panduan Penggunaan Sistem Pada Setiap Halaman'
                                },
                                {
                                    element: document.querySelector('.card-first'),
                                    title: 'Dashboard',
                                    intro: 'Untuk Menampilkan Statistik Data Arsip'
                                },
                                {
                                    element: document.querySelector('.card-second'),
                                    title: 'Memo Internal',
                                    intro: 'Manajemen Arsip Memo Internal Kepala Cabang dan Ketua Pengurus'
                                },
                                {
                                    element: document.querySelector('.card-third'),
                                    title: 'Berita Pentasyarufan',
                                    intro: 'Manajemen Arsip Berita Pentasyarufan Yang Tersinkronasi Dengan Aplikasi GOCAP'
                                },
                                {
                                    element: document.querySelector('.card-four'),
                                    title: 'Kegiatan & Notulen',
                                    intro: 'Manajemen Arsip Kegiatan dan Notulen Pembahasan'
                                },
                                {
                                    element: document.querySelector('.card-five'),
                                    title: 'Manajemen Arsip Surat',
                                    intro: 'Membuat Surat Keluar, Menerima Surat Masuk & Mendisposisikan Surat (Penerima Disposisi Mendapatkan Notifikasi WA)'
                                },
                                {
                                    element: document.querySelector('.card-six'),
                                    title: 'Arsip Dokumen',
                                    intro: 'Manajemen Arsip Dokumen, Klasifikasi Dokumen Dan Mendisposisikan Dokumen'
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
                        }).start();
                }

                $(document).ready(function() {
                    klikkene(true);
                    $("#panduan").click(function() {
                        klikkene(false);
                    });
                });
            </script>
        @else
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-zero'),
                                    title: 'Tour Guide',
                                    intro: 'Untuk Menampilkan Panduan Penggunaan Sistem Pada Setiap Halaman'
                                },
                                {
                                    element: document.querySelector('.card-dashboard'),
                                    title: 'Dashboard',
                                    intro: 'Untuk Menampilkan Statistik Data Pada Sistem Pengelolaan E-Arsip'
                                },

                                {
                                    element: document.querySelector('.card-data-pengajuan'),
                                    title: 'Data Pengajuan',
                                    intro: 'Untuk Mengelola Data Kegiatan dan Notulen Pada Sistem Informasi E-ARSIP'
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
                        }).start();
                }

                $(document).ready(function() {
                    klikkene(true);
                    $("#panduan").click(function() {
                        klikkene(false);
                    });
                });
            </script>
        @endif
    @endpush


@endsection
