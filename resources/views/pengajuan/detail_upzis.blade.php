@extends('main')
@section('upzis_ranting', 'active')
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
                    @if ($title2 == 'Detail Pengajuan UPZIS')
                        <a href="/{{ $role }}/upzis-ranting"> Data Pengajuan UPZIS</a> /
                    @else
                        <a href="/{{ $role }}/upzis-ranting"> Data Pengajuan Ranting</a> /
                    @endif
                    <a> {{ $title2 }} </a>
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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="far fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @livewire('detail-upzis', ['id_pengajuan' => $id_pengajuan])
    </section>

@endsection


@section('js')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('toastMessage', message => {
                var toast = new bootstrap.Toast(document.getElementById('toastMessage'));
                toast.show();
            });
        });
    </script>
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

{{-- @if (Auth::user()->gocap_id_upzis_pengurus != null)
    @if ($datas->status_pengajuan == 'Direncanakan')
        @php
            $value1 = 4;
            $value2 = 8;
        @endphp
    @else
        @php
            $value1 = 3;
            $value2 = 7;
        @endphp
    @endif
@endif --}}

@push('intro_data_pengajual_detail')
    <script>
        @if (Auth::user()->gocap_id_upzis_pengurus != null)
            @if ($datas->status_pengajuan == 'Direncanakan')
                $value0 = 0;
                $value00 = 3;

                $value1 = 4;
                $value11 = 7;

                $value2 = 8;
            @else
                $value0 = 0;
                $value00 = 2;

                $value1 = 3;
                $value1 = 6;

                $value2 = 7;
            @endif
        @else
            $value0 = 0;
            $value00 = 2;

            $value1 = 3;
            $value11 = 6;

            $value2 = 7;
        @endif

        function klikkene(value) {
            introJs().setOptions({
                    steps: [{
                            element: document.querySelector('.intro-detail-data-pengajuan-card'),
                            title: 'Detail Pengajuan',
                            intro: 'Menampilkan informasi mengenai detail pengajuan pentasyarufan'
                        },
                        {
                            element: document.querySelector('.intro-detail-data-pengajuan-card-rencana-program'),
                            title: 'Daftar Rencana Program',
                            intro: 'Menampilkan daftar rencana program pentasyarufan yang terdiri dari 3 kategori, setelah menambahkan data, klik rencana terpilih untuk melihat detail lebih lanjut'
                        },
                        {
                            element: document.querySelector(
                                '.intro-detail-data-pengajuan-status-rencana-program'),
                            title: 'Status Rencana Program',
                            intro: 'Menampilkan status rencana program pentasyarufan terbaru'
                        },
                        @if (Auth::user()->gocap_id_upzis_pengurus != null)
                            @if ($datas->status_pengajuan == 'Direncanakan')
                                {
                                    element: document.querySelector('.intro-tombol-tambah-rencana-program'),
                                    title: 'Tambah',
                                    intro: 'Klik untuk menambahkan rencana program pentasyarufan'
                                },
                            @endif
                        @endif {
                            element: document.querySelector('.intro-detail-data-pengajuan-card-lembar-pengajuan'),
                            title: 'Konfirmasi Pengajuan',
                            intro: 'Setelah rencana program pentasyarufan selesai diinput, wajib melakukan konfirmasi pengajuan'
                        },
                        {
                            element: document.querySelector(
                                '.intro-detail-data-pengajuan-status-lembar-pengajuan'),
                            title: 'Status Konfirmasi',
                            intro: 'Menampilkan status konfirmasi pengajuan terkini (Belum Dikonfirmasi/Sudah Dikonfirmasi)'

                        },
                        {
                            element: document.querySelector(
                                '.intro-detail-data-pengajuan-konfirmasi-format-berkas-download'),
                            title: 'Format Berkas',
                            intro: 'Klik tombol download, untuk mendownload lembar permohonan sesuai dengan data yang telah diinputkan '
                        },

                        @if (Auth::user()->gocap_id_upzis_pengurus != null)
                            {
                                element: document.querySelector(
                                    '.intro-detail-data-pengajuan-konfirmasi-upload-berkas'),
                                title: 'Upload Berkas',
                                intro: 'Setelah melakukan scan berkas yang sudah di-TTD & stampel, wajib upload berkas untuk menerbitkan lembar rekomendasi oleh Lazisnu Cilacap'
                            },
                        @endif

                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                            {
                                element: document.querySelector(
                                    '.intro-detail-data-pengajuan-konfirmasi-upload-berkas'),
                                title: 'Upload Berkas',
                                intro: 'Setelah UPZIS mengupload scan berkas yang sudah di-TTD & stampel, berkas akan muncul disini'
                            },
                        @endif {
                            element: document.querySelector('.intro-detail-data-pengajuan-card-lembar-rekomendasi'),
                            title: 'Rekomendasi',
                            intro: 'Menampilkan informasi mengenai detail rekomendasi rencana program pentasyarufan (Diinput & Diterbitkan oleh Lazisnu Cilacap) '
                        },
                        {
                            element: document.querySelector(
                                '.intro-detail-data-pengajuan-status-lembar-rekomendasi'),
                            title: 'Status Rekomendasi',
                            intro: 'Menampilkan status rekomendasi pengajuan terkini (Belum Terbit/Sudah Terbit)'
                        },
                        {
                            element: document.querySelector(
                                '.intro-detail-data-pengajuan-lembar-rekomendasi-preview'),
                            title: 'Lembar Rekomendasi',
                            intro: 'Klik tombol preview untuk mendownload preview lembar rekomendasi(tanpa TTD & Stampel. Ketika rekomendasi sudah diterbitkan, maka akan berubah menjadi download lembar rekomendasi(dengan TTD & Stampel)'
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
                }).onbeforechange(function() {

                    if (this._currentStep === $value0 || this._currentStep === $value00) {
                        $("#a").attr('class',
                            'tab-pane fade   show active intro-detail-data-pengajuan-card-rencana-program')
                        $("#b").attr('class',
                            'tab-pane fade  intro-detail-data-pengajuan-card-lembar-pengajuan'
                        )
                        $("#c").attr('class', 'tab-pane fade intro-detail-data-pengajuan-card-lembar-rekomendasi');

                        $("#a").attr('aria-selected', 'true');
                        $("#b").attr('aria-selected', 'false');
                        $("#c").attr('aria-selected', 'false');

                        $("#a-tab").attr('class', 'nav-link text-secondary active');
                        $("#b-tab").attr('class', 'nav-link text-secondary ');
                        $("#c-tab").attr('class', 'nav-link text-secondary ');
                        return true;
                    }

                    if (this._currentStep === $value1 || this._currentStep === $value11) {
                        $("#a").attr('class',
                            'tab-pane fade   intro-detail-data-pengajuan-card-rencana-program')
                        $("#b").attr('class',
                            'tab-pane fade show active intro-detail-data-pengajuan-card-lembar-pengajuan'
                        )
                        $("#c").attr('class', 'tab-pane fade intro-detail-data-pengajuan-card-lembar-rekomendasi');
                        $("#a").attr('aria-selected', 'false');
                        $("#b").attr('aria-selected', 'true');
                        $("#c").attr('aria-selected', 'false');

                        $("#a-tab").attr('class', 'nav-link text-secondary ');
                        $("#b-tab").attr('class', 'nav-link text-secondary active');
                        $("#c-tab").attr('class', 'nav-link text-secondary ');
                        return true;
                    }
                    if (this._currentStep === $value2) {
                        $("#a").attr('class',
                            'tab-pane fade   intro-detail-data-pengajuan-card-rencana-program')
                        $("#b").attr('class',
                            'tab-pane fade  intro-detail-data-pengajuan-card-lembar-pengajuan'
                        )
                        $("#c").attr('class',
                            'tab-pane show active fade intro-detail-data-pengajuan-card-lembar-rekomendasi');
                        $("#a").attr('aria-selected', 'false');
                        $("#b").attr('aria-selected', 'false');
                        $("#c").attr('aria-selected', 'true');

                        $("#a-tab").attr('class', 'nav-link text-secondary ');
                        $("#b-tab").attr('class', 'nav-link text-secondary ');
                        $("#c-tab").attr('class', 'nav-link text-secondary active');
                        return true;
                    }
                }).oncomplete(function() {
                    location.reload();
                }).start();
        }

        $(document).ready(function() {
            klikkene(true);
            $("#panduan").click(function() {
                klikkene(false);
            });
        });
    </script>

    <script>
        var yeso = document.getElementById("modal_rencana_tambah_panduan");
        yeso.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.nomor-pengajuan-modal-data-pengajuan'),
                        title: 'Nomor Pengajuan',
                        intro: 'Menampilkan nomor pengajuan pentasyarufan'
                    },
                    {
                        element: document.querySelector('.petugas-pentasyarufan-modal-data-pengajuan'),
                        title: 'Petugas Pentasyarufan',
                        intro: 'Pilih petugas pentasyarufan'
                    },
                    {
                        element: document.querySelector('.tgl-pelaksanaan-modal-data-pengajuan'),
                        title: 'Tanggal Pelaksanaan',
                        intro: 'Masukan tanggal pelaksanaan program pentasyarufan'
                    },
                    {
                        element: document.querySelector('.tgl-setor-lpj-modal-data-pengajuan'),
                        title: 'Tanggal Setor LPJ',
                        intro: 'Masukan tanggal setor lpj program pentasyarufan'
                    },
                    {
                        element: document.querySelector('.jenis-modal-data-pengajuan'),
                        title: 'Kategori',
                        intro: 'Pilih kategori program pentasyarufan'
                    },
                    {
                        element: document.querySelector('.pilar-modal-data-pengajuan'),
                        title: 'Pilar',
                        intro: 'Pilih pilar program pentasyarufan berdasarkan kategori terpilih'
                    },
                    {
                        element: document.querySelector('.jenis-program-modal-data-pengajuan'),
                        title: 'Jenis Program',
                        intro: 'Pilih jenis program pentasyarufan berdasarkan kategori & pilar terpilih'
                    },
                    {
                        element: document.querySelector('.target-penerima-manfaat-modal-data-pengajuan'),
                        title: 'Target Penerima Manfaat',
                        intro: 'Masukan nama penerima manfaat program pentasyarufan'
                    },
                    {
                        element: document.querySelector('.nominal-satuan-modal-data-pengajuan'),
                        title: 'Nominal Satuan',
                        intro: 'Masukan nominal satuan untuk penerima manfaat program pentasyarufan'
                    },
                    {
                        element: document.querySelector('.jumlah-modal-data-pengajuan'),
                        title: 'Jumlah Orang',
                        intro: 'Masukan jumlah orang bagi penerima manfaat program pentasyarufan'
                    },
                    {
                        element: document.querySelector('.nominal-total-modal-data-pengajuan'),
                        title: 'Nominal Total',
                        intro: 'Nominal total akan generate secara otomatis berdasarkan nominal satuan dikalikan dengan jumlah orang penerima manfaat'
                    },
                    {
                        element: document.querySelector('.batal-modal-data-pengajuan'),
                        title: 'Batal',
                        intro: 'Klik untuk membatalkan rencana program pentasyarufan'
                    },
                    {
                        element: document.querySelector('.simpan-modal-data-pengajuan'),
                        title: 'Simpan',
                        intro: 'Jika semua data sudah terisi dengan benar, klik simpan untuk menyimpan data'
                    }
                ]
            }).start();
        }
    </script>
@endpush
