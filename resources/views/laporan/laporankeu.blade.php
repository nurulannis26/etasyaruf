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
                    <a> Laporan Keuangan</a>
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

                       

                        <livewire:laporankeu>





                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection


@section('js')


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        function showConsoleLog(id) {
            axios.get('/upzis/server?id=' + id)
                .then(response => {
                    const data = response.data;
                    document.getElementById('value1').innerHTML = data.value;
                    document.getElementById('value2').innerHTML = data.value2;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    </script>



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
