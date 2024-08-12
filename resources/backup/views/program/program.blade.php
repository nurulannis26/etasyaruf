@extends('main')
@section('program', 'active')
@section('css')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">

                <div class="col-sm-6 text-secondary mt-1">
                    <a href="/{{ $role }}/dashboard"> Dashboard</a> /
                    <a> Pilar & Program</a>
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



                    {{-- livewire program --}}
                    @livewire('program')



                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->



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

@endsection


@push('intro-program-dan-pilar')
    <script>
        var yesol = document.getElementById("panduan");
        yesol.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.intro-data-pilar-program-header'),
                        title: 'Dashboard', 
                        intro: 'Untuk Menampilkan Statistik Data Pada Sistem Pengelolaan E-Arsip'
                    },
                    {
                        element: document.querySelector('.intro-button-ekspor-pilar-program'),
                        title: 'Dashboard',
                        intro: 'Untuk Menampilkan Statistik Data Pada Sistem Pengelolaan E-Arsip'
                    },
                    {
                        element: document.querySelector('.intro-daftar-pilar-table'),
                        title: 'Dashboard',
                        intro: 'Untuk Menampilkan Statistik Data Pada Sistem Pengelolaan E-Arsip'
                    },
                    {
                        element: document.querySelector('.intro-daftar-program-table'),
                        title: 'Dashboard',
                        intro: 'Untuk Menampilkan Statistik Data Pada Sistem Pengelolaan E-Arsip'
                    }
                ]
            }).start();
        }
    </script>
@endpush
