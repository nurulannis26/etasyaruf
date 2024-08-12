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
                    <a href="/{{ $role }}/internalpc-pc"> Data Pengajuan Lazisnu Cilacap</a> /
                    <a> Detail Pengajuan PC Lazisnu</a>
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
        @livewire('detail-pc', ['id_pengajuan' => $id_pengajuan])
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

@push('detail-pengajuan-umum-pc-lazisnu')
    <script>
        var yesoy = document.getElementById("panduan");
        yesoy.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.intro-profil-pengajuan-pc'),
                        title: 'Detail Pengajuan',
                        intro: 'Menampilkan informasi mengenai detail pengajuan pentasyarufan'
                    },
                    {
                        element: document.querySelector('.tab-pengajuan-umum-pc'),
                        title: 'Card Pengajuan',
                        intro: 'Klik disini untuk menampilkan detail pengajuan (Pengajuan, Survey, Persetujuan Direktur, Pencairan Keuangan)'

                    },

                    {
                        element: document.querySelector('.tab-tab-pengajuan-umum-pc'),
                        title: 'Pengajuan',
                        intro: 'Menampilkan informasi mengenai detail pengajuan, daftar penerima manfaat, dan lampiran pengajuan'
                    },
                    {
                        element: document.querySelector('.tab-tab-detail-pengajuan-umum-pc'),
                        title: 'Detail Pengajuan',
                        intro: 'Menampilkan informasi mengenai detail pengajuan yang diajukan'
                    },
                    {
                        element: document.querySelector('.tab-tab-status-detail-pengajuan-umum-pc'),
                        title: 'Status Pengajuan',
                        intro: 'Menampilkan status pengajuan terkini (Menunggu Survey/Survey Ditolak/Menunggu Persetujuan/Ditolak Direktur/Menunggu Dicairkan/Berhasil Dicairkan)'
                    },
                    {
                        element: document.querySelector(
                            '.tab-tab-daftar-penerima-manfaat-pengajuan-umum-pc'),
                        title: 'Daftar Penerima Manfaat',
                        intro: 'Tabel ini menampilkan daftar penerima manfaat di pengajuan yang diajukan'
                    },
                    {
                        element: document.querySelector('.tab-tab-lampiran-pengajuan-umum-pc'),
                        title: 'Lampiran Pengajuan',
                        intro: 'Tabel ini menampilkan lampiran di pengajuan yang diajukan '
                    },
                    {
                        element: document.querySelector('.tab-survey-umum-pc'),
                        title: 'Survey',
                        intro: 'Menampilkan informasi mengenai survey pengajuan yang diajukan'
                    },
                    {
                        element: document.querySelector('.tab-survey-detail-umum-pc'),
                        title: 'Detail Survey',
                        intro: 'Menampilkan tanggal survey, hasil, lokasi,dan catatan survey'
                    },
                    {
                        element: document.querySelector('.tab-survey-status-detail-umum-pc'),
                        title: 'Status Survey',
                        intro: 'Menampilkan status survey terkini (Belum Survey/Sudah Survey)'
                    },
                    {
                        element: document.querySelector('.tab-persetujuan_direktur-umum-pc'),
                        title: 'Persetujuan Direktur',
                        intro: 'Menampilkan informasi mengenai persetujuan oleh Direktur Eksekutif Lazisnu Cilacap'
                    },
                    {
                        element: document.querySelector('.tab-persetujuan_direktur-detail-umum-pc'),
                        title: 'Persetujuan Direktur',
                        intro: 'Menampilkan tanggal disetujui, total nominal yang disetujui, dan rekening sumber dana untuk pengajuan yang diajukan'
                    },
                    {
                        element: document.querySelector(
                            '.tab-persetujuan-direktur-status-detail-umum-pc'),
                        title: 'Status Persetujuan Direktur',
                        intro: 'Menampilkan status persetujuan direktur terkini (Belum Direspon/Disetujui/Ditolak)'
                    },
                    {
                        element: document.querySelector('.tab-keuangan-umum-pc'),
                        title: 'Pencairan Keuangan',
                        intro: 'Menampilkan informasi mengenai pencairan keuangan oleh Divisi Keuangan'
                    },
                    {
                        element: document.querySelector('.tab-keuangan-detail-umum-pc'),
                        title: 'Pencairan Keuangan',
                        intro: 'Menampilkan tanggal pencairan, total nominal yang dicairkan, dan rekening sumber dana untuk pengajuan yang diajukan'
                    },
                    {
                        element: document.querySelector('.tab-keuangan-status-detail-umum-pc'),
                        title: 'Status Pencairan',
                        intro: 'Menampilkan status pencairan terkini (Belum Dicairkan/Berhasil Dicairkan)'
                    },
                    {
                        element: document.querySelector('.tab-lpj-umum-pc'),
                        title: 'Card LPJ',
                        intro: 'Klik disini untuk menampilkan arsip dokumentasi dan penggunaan dana pengajuan'
                    },
                    {
                        element: document.querySelector('.dana-tersisa-detail-umum-pc'),
                        title: 'Dana Tersisa',
                        intro: 'Menampilkan dana tersisa dari nominal pengajuan internal yang berhasil di cairkan'
                    },
                    {
                        element: document.querySelector('.dana-detail-kegiatan-detail-umum-pc'),
                        title: 'Detail Kegiatan',
                        intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                    },
                    {
                        element: document.querySelector('.dana-dokumentasi-detail-umum-pc'),
                        title: 'Dokumentasi Kegiatan',
                        intro: 'Berisi gambar dokumentasi program pentasyarufan yang sudah dilaksanakan'
                    },
                    {
                        element: document.querySelector('.dana-penyaluran-detail-umum-pc'),
                        title: 'Penyaluran',
                        intro: 'Tabel ini menampilkan rincian penyaluran dari pengajuan internal yang sudah dilaksanakan'
                    },
                    {
                        element: document.querySelector('.tab-berita-umum-pc'),
                        title: 'Card Berita',
                        intro: 'Klik disini untuk menampilkan berita acara'
                    },
                    {
                        element: document.querySelector('.tab-detail-berita-umum-pc'),
                        title: 'Detail Berita',
                        intro: 'Menampilkan foto, tanggal terbit, pewarta, judul berita, dan narasi berita'
                    },


                ]
            }).onbeforechange(function() {

                if (this._currentStep === 1 || this._currentStep === 0 || this._currentStep === 15) {
                    $("#woy1").attr('class',
                        'card ijo-card bg-success');
                    $("#woy2").attr('class',
                        'card ijo-card ');
                    $("#woy3").attr('class',
                        'card ijo-card ');

                    $("#nt-0").attr('style', 'display:block');
                    $("#nt-1").attr('style', 'display:none');
                    $("#nt-2").attr('style', 'display:none');
                    $("#nt-3").attr('style', 'display:none');
                    $("#nt-4").attr('style', 'display:none');
                    $("#nt-5").attr('style', 'display:none');


                    return true;
                }

                if (this._currentStep === 16 || this._currentStep === 20) {
                    $("#woy1").attr('class',
                        'card ijo-card ');
                    $("#woy2").attr('class',
                        'card ijo-card bg-success');
                    $("#woy3").attr('class',
                        'card ijo-card ');

                    $("#nt-0").attr('style', 'display:none');
                    $("#nt-1").attr('style', 'display:block');
                    $("#nt-2").attr('style', 'display:block');
                    $("#nt-3").attr('style', 'display:block');
                    $("#nt-4").attr('style', 'display:none');
                    $("#nt-5").attr('style', 'display:none');

                    return true;
                }

                if (this._currentStep === 21) {
                    $("#woy1").attr('class',
                        'card ijo-card ');
                    $("#woy2").attr('class',
                        'card ijo-card ');
                    $("#woy3").attr('class',
                        'card ijo-card bg-success');

                    $("#nt-0").attr('style', 'display:none');
                    $("#nt-1").attr('style', 'display:none');
                    $("#nt-2").attr('style', 'display:none');
                    $("#nt-3").attr('style', 'display:none');
                    $("#nt-4").attr('style', 'display:block');
                    $("#nt-5").attr('style', 'display:block');

                    return true;
                }


                if (this._currentStep === 6 || this._currentStep === 2) {
                    $("#v1-tab").attr('aria-selected', 'true');
                    $("#v2-tab").attr('aria-selected', 'false');
                    $("#v3-tab").attr('aria-selected', 'false');
                    $("#v4-tab").attr('aria-selected', 'false');


                    $("#v1-tab").attr('class', 'nav-link text-secondary active');
                    $("#v2-tab").attr('class', 'nav-link text-secondary ');
                    $("#v3-tab").attr('class', 'nav-link text-secondary');
                    $("#v4-tab").attr('class', 'nav-link text-secondary');


                    $("#v1").attr('class', 'tab-pane fade active show');
                    $("#v2").attr('class', 'tab-pane fade ');
                    $("#v3").attr('class', 'tab-pane fade');
                    $("#v4").attr('class', 'tab-pane fade');


                    return true;
                }

                if (this._currentStep === 7 || this._currentStep === 9) {
                    $("#v1-tab").attr('aria-selected', 'false');
                    $("#v2-tab").attr('aria-selected', 'true');
                    $("#v3-tab").attr('aria-selected', 'false');
                    $("#v4-tab").attr('aria-selected', 'false');

                    $("#v1-tab").attr('class', 'nav-link text-secondary');
                    $("#v2-tab").attr('class', 'nav-link text-secondary active');
                    $("#v3-tab").attr('class', 'nav-link text-secondary');
                    $("#v4-tab").attr('class', 'nav-link text-secondary');


                    $("#v1").attr('class', 'tab-pane fade');
                    $("#v2").attr('class', 'tab-pane fade active show');
                    $("#v3").attr('class', 'tab-pane fade');
                    $("#v4").attr('class', 'tab-pane fade');
                    return true;
                }

                if (this._currentStep === 10 || this._currentStep === 12) {
                    $("#v1-tab").attr('aria-selected', 'false');
                    $("#v2-tab").attr('aria-selected', 'false');
                    $("#v3-tab").attr('aria-selected', 'true');
                    $("#v4-tab").attr('aria-selected', 'false');

                    $("#v1-tab").attr('class', 'nav-link text-secondary');
                    $("#v2-tab").attr('class', 'nav-link text-secondary ');
                    $("#v3-tab").attr('class', 'nav-link text-secondary active');
                    $("#v4-tab").attr('class', 'nav-link text-secondary');


                    $("#v1").attr('class', 'tab-pane fade');
                    $("#v2").attr('class', 'tab-pane fade');
                    $("#v3").attr('class', 'tab-pane fade  active show');
                    $("#v4").attr('class', 'tab-pane fade');


                    return true;
                }

                if (this._currentStep === 13) {
                    $("#v1-tab").attr('aria-selected', 'false');
                    $("#v2-tab").attr('aria-selected', 'false');
                    $("#v3-tab").attr('aria-selected', 'false');
                    $("#v4-tab").attr('aria-selected', 'true');

                    $("#v1-tab").attr('class', 'nav-link text-secondary');
                    $("#v2-tab").attr('class', 'nav-link text-secondary ');
                    $("#v3-tab").attr('class', 'nav-link text-secondary');
                    $("#v4-tab").attr('class', 'nav-link text-secondary active');


                    $("#v1").attr('class', 'tab-pane fade');
                    $("#v2").attr('class', 'tab-pane fade');
                    $("#v3").attr('class', 'tab-pane fade');
                    $("#v4").attr('class', 'tab-pane fade active show');


                    return true;
                }


            }).oncomplete(function() {
                location.reload();
            }).start();
        }
    </script>
@endpush
