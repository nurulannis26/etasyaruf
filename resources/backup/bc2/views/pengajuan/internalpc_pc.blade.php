@extends('main')

@section('internalpc_pc', 'active')
@section('pengajuan_ac', 'active menu-open')
@section('pengajuan_mo', 'menu-open')
@section('css')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">

                <div class="col-sm-6 text-secondary mt-1">
                    <a href="/{{ $role }}/dashboard"> Dashboard</a> /
                    <a> Data Pengajuan Lazisnu Cilacap</a>
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


                        {{-- tabbed --}}
                        <div class="row mt-2 mr-2 ml-2 card-header-data-pengajuan-pc">
                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0 pl-2">
                                <h5 class="d-flex justify-content-center mt-2">
                                    <b class="text-success pl-2 mt-1">DATA PENGAJUAN</b>
                                </h5>
                            </div>
                            <div class="col-12 col-md-9  col-sm-12 mb-2 mb-xl-0 ">
                                <ul class="nav nav-tabs mt-1 ml-1 mr-1" id="myTab" role="tablist">
                                    <style>
                                        div>ul>li>a.active {
                                            color: #28a745 !important;
                                            font-weight: bold;
                                        }

                                        div>ul>li>a.active:hover {
                                            color: #28a745 !important;
                                            font-weight: bold;
                                        }

                                        div>ul>li>a.nav-link:hover {
                                            font-weight: bold;
                                        }
                                    </style>

                                    @php
                                        if ($filter_internal == '' && $filter_pc_umum == 'on') {
                                            $act_tab_filter_pc_umum = 'active';
                                            $act_tab_filter_pc_umum_1 = 'show active';
                                            $act_tab_filter_internal = '';
                                            $act_tab_filter_internal_1 = '';
                                        } elseif ($filter_internal == '' && $filter_pc_umum == '') {
                                            $act_tab_filter_pc_umum = '';
                                            $act_tab_filter_pc_umum_1 = '';
                                            $act_tab_filter_internal = 'active';
                                            $act_tab_filter_internal_1 = 'show active';
                                        } elseif ($filter_internal == 'on' && $filter_pc_umum == '') {
                                            $act_tab_filter_pc_umum = '';
                                            $act_tab_filter_pc_umum_1 = '';
                                            $act_tab_filter_internal = 'active';
                                            $act_tab_filter_internal_1 = 'show active';
                                        }
                                    @endphp

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-secondary {{ $act_tab_filter_internal }}" id="internal-tab"
                                            data-toggle="tab" data-target="#internal" type="button" role="tab"
                                            aria-controls="internal" aria-selected="true">
                                            <span>
                                                Internal Manajemen Eksekutif
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-secondary {{ $act_tab_filter_pc_umum }}" id="pc-tab"
                                            data-toggle="tab" data-target="#pc" type="button" role="tab"
                                            aria-controls="pc" aria-selected="false">Umum Lazisnu Cilacap</a>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        {{-- card body --}}
                        <div class="card-body ">

                            {{-- isi tabbed --}}
                            <div class="tab-content " id="myTabContent">

                                {{-- internal pc --}}
                                <div class="tab-pane fade {{ $act_tab_filter_internal_1 }}" id="internal" role="tabpanel"
                                    aria-labelledby="internal-tab">
                                    {{-- livewire internal pc --}}
                                    @if ($filter_internal == 'on')
                                        <livewire:internal-pc :c_filter_bulan="$c_filter_bulan" :c_filter_tahun="$c_filter_tahun" :c_filter_status="$c_filter_status"
                                            :c_filter_tujuan="$c_filter_tujuan" :filter_internal="$filter_internal">
                                        @elseif($filter_internal == '')
                                            <livewire:internal-pc :filter_internal="$filter_internal">
                                    @endif
                                </div>
                                {{-- end internal pc --}}

                                {{-- pc --}}
                                <div class="tab-pane fade {{ $act_tab_filter_pc_umum_1 }}" id="pc" role="tabpanel"
                                    aria-labelledby="pc-tab">
                                    {{-- livewire internal pc --}}
                                    @if ($filter_pc_umum == 'on')
                                        <livewire:umum-pc :c_filter_bulan="$c_filter_bulan" :c_filter_tahun="$c_filter_tahun" :c_filter_status="$c_filter_status"
                                            :c_filter_kategori="$c_filter_kategori" :c_filter_pilar="$c_filter_pilar" :filter_pc_umum="$filter_pc_umum">
                                        @elseif($filter_pc_umum == '')
                                            <livewire:umum-pc :filter_pc_umum="$filter_pc_umum">
                                    @endif
                                </div>
                                {{-- end internal pc --}}



                            </div>
                            {{-- end isi tabbed --}}

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




@push('intro-data-pengajuan-pc-lazisnu')
    <script>
        var yesoy = document.getElementById("panduan");
        yesoy.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.card-header-data-pengajuan-pc'),
                        title: 'Data Pengajuan',
                        intro: 'Menampilkan pengajuan pentasyarufan tingkat Internal Manajemen Eksekutif dan Umum Lazisnu Cilacap'
                    },
                    {
                        element: document.querySelector('.intro-header-data-pengajuan-pcs'),
                        title: 'Aksi',
                        intro: 'Menampilkan informasi dan aksi mengenai data pengajuan yang dipilih'
                    },
                    {
                        element: document.querySelector('.intro-filter-data-pengajuan-pc'),
                        title: 'Filter Pengajuan',
                        intro: 'Untuk menampilkan data pentasyarufan secara spesifik, gunakan filter'
                    },
                    {
                        element: document.querySelector('.intro-ekspor-data-pengajuan-pc'),
                        title: 'Ekspor',
                        intro: 'Klik disini untuk ekspor data pengajuan pentasyarufan '
                    },
                    {
                        element: document.querySelector('.intro-reset-filter-data-pengajuan-pc'),
                        title: 'Reset',
                        intro: 'Klik disini untuk mereset filter'
                    },
                    {
                        element: document.querySelector('.intro-tambah-data-pengajuan-pc'),
                        title: 'Tambah',
                        intro: 'Klik disini untuk menambahkan pengajuan'
                    },


                    {
                        element: document.querySelector('.intro-table-data-pengajuan-pc'),
                        title: 'Data Pengajuan',
                        intro: 'Data pengajuan berdasarkan filter akan tampil di tabel berikut, klik mana saja pada salah satu data untuk melihat detail'
                    },
                ]

            }).onbeforechange(function() {

                if (this._currentStep === 0) {
                    $('#internal-tab').find('span').trigger('click');
                    return true;
                }
            }).oncomplete(function() {
                location.reload();
            }).start();


        }
    </script>
@endpush
