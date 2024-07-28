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
                    <a> Detail Pengajuan Internal PC </a>
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
        @livewire('detail-internal-pc', ['id_internal' => $id_internal])
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

@push('detail-pengajuan-internal-pc')
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
                        element: document.querySelector('.intro-tombol-pengajuans'),
                        title: 'Card Pengajuan',
                        intro: 'Klik disini untuk menampilkan detail pengajuan internal (Pengajuan, Persetujuan Kepala Cabang, Pencairan Keuangan)'
                    },

                    {
                        element: document.querySelector('.intro-pengajuans-arsips'),
                        title: 'Pengajuan',
                        intro: 'Menampilkan informasi mengenai detail pengajuan dan lampiran pengajuan'
                    },
                    {
                        element: document.querySelector('.intro-detail-pengajuans-arsips'),
                        title: 'Detail Pengajuan',
                        intro: 'Menampilkan informasi mengenai detail pengajuan yang diajukan'
                    },
                    {
                        element: document.querySelector('.intro-detail-status-pengajuans-arsips'),
                        title: 'Status Pengajuan',
                        intro: 'Menampilkan status pengajuan terkini (Menunggu Persetujuan/Ditolak/Menunggu Dicairkan/Dana Sudah Dicairkan)'
                    },
                    {
                        element: document.querySelector('.intro-download-detail-pengajuan-arsips'),
                        title: 'Lembar Pengajuan Internal',
                        intro: 'Klik tombol download, untuk mendownload lembar pengajuan internal sesuai dengan data yang telah diinputkan '
                    },
                    {
                        element: document.querySelector('.intro-lampiran-pengajuans-arsips'),
                        title: 'Lampiran Pengajuan',
                        intro: 'Tabel ini menampilkan lampiran di pengajuan internal yang diajukan '
                    },
                    {
                        element: document.querySelector('.intro-persetujuan-direktur-arsips'),
                        title: 'Persetujuan Kepala Cabang',
                        intro: 'Menampilkan informasi mengenai persetujuan oleh Kepala Cabang Lazisnu Cilacap '
                    },

                    {
                        element: document.querySelector('.intro-detail-persetujuan-direktur-arsips'),
                        title: 'Persetujuan Kepala Cabang',
                        intro: 'Menampilkan tanggal disetujui, total nominal yang disetujui, dan rekening sumber dana untuk pengajuan internal yang diajukan'
                    },
                    {
                        element: document.querySelector(
                            '.intro-detail-status-persetujuan-direkturs-arsips'),
                        title: 'Status Persetujuan Kepala Cabang',
                        intro: 'Menampilkan status persetujuan Kepala Cabang terkini (Belum Direspon/Disetujui/Ditolak)'
                    },
                    {
                        element: document.querySelector('.intro-pencairan-keuangan-arsips'),
                        title: 'Pencairan Keuangan',
                        intro: 'Menampilkan informasi mengenai pencairan keuangan oleh Divisi Keuangan '
                    },
                    {
                        element: document.querySelector('.intro-detail-pencairan-keuangan-arsips'),
                        title: 'Pencairan Keuangan',
                        intro: 'Menampilkan tanggal pencairan, total nominal yang dicairkan, dan rekening sumber dana untuk pengajuan internal yang diajukan'
                    },
                    {
                        element: document.querySelector(
                            '.intro-detail-status-persetujuan-pencairan-keuangan-arsips'),
                        title: 'Status Pencairan',
                        intro: 'Menampilkan status pencairan terkini (Belum Dicairkan/Berhasil Dicairkan)'
                    },
                    {
                        element: document.querySelector('.intro-tombol-arsips'),
                        title: 'Card LPJ',
                        intro: 'Klik disini untuk menampilkan arsip dokumentasi dan penggunaan dana pengajuan internal'
                    },
                    {
                        element: document.querySelector('.intro-dana-tersisa-internal-arsips'),
                        title: 'Dana Tersisa',
                        intro: 'Menampilkan dana tersisa dari nominal pengajuan internal yang berhasil di cairkan'
                    },
                    {
                        element: document.querySelector('.intro-arsip-dokumentasis'),
                        title: 'Arsip Dokumentasi',
                        intro: 'Tabel ini menampilkan arsip dokumentasi dari pengajuan internal yang sudah dilaksanakan'
                    },
                    {
                        element: document.querySelector('.intro-penggunaan-danas'),
                        title: 'Penyaluran',
                        intro: 'Tabel ini menampilkan rincian penyaluran dari pengajuan internal yang sudah dilaksanakan'
                    },
                ]
            }).onbeforechange(function() {

                if (this._currentStep === 1 || this._currentStep === 12) {
                    $("#ijocard1").attr('class',
                        'card ijo-card bg-success');
                    $("#ijocard2").attr('class',
                        'card ijo-card ');

                    $("#ns-0").attr('style', 'display:block');
                    $("#ns-1").attr('style', 'display:none');
                    $("#ns-2").attr('style', 'display:none');
                    $("#ns-3").attr('style', 'display:none');

                    return true;
                }
                if (this._currentStep === 13) {
                    $("#ijocard1").attr('class',
                        'card ijo-card ');
                    $("#ijocard2").attr('class',
                        'card ijo-card bg-success');

                    $("#ns-0").attr('style', 'display:none');
                    $("#ns-1").attr('style', 'display:block');
                    $("#ns-2").attr('style', 'display:block');
                    $("#ns-3").attr('style', 'display:block');
                    return true;
                }

                if (this._currentStep === 2 || this._currentStep === 6) {
                    $("#z1-tab").attr('aria-selected', 'true');
                    $("#z2-tab").attr('aria-selected', 'false');
                    $("#z3-tab").attr('aria-selected', 'false');

                    $("#z1-tab").attr('class', 'nav-link text-secondary active');
                    $("#z2-tab").attr('class', 'nav-link text-secondary ');
                    $("#z3-tab").attr('class', 'nav-link text-secondary');

                    $("#z1").attr('class', 'tab-pane fade active show');
                    $("#z2").attr('class', 'tab-pane fade ');
                    $("#z3").attr('class', 'tab-pane fade');

                    return true;
                }

                if (this._currentStep === 7 || this._currentStep === 9) {
                    $("#z1-tab").attr('aria-selected', 'false');
                    $("#z2-tab").attr('aria-selected', 'true');
                    $("#z3-tab").attr('aria-selected', 'false');

                    $("#z1-tab").attr('class', 'nav-link text-secondary');
                    $("#z2-tab").attr('class', 'nav-link text-secondary active');
                    $("#z3-tab").attr('class', 'nav-link text-secondary');

                    $("#z1").attr('class', 'tab-pane fade');
                    $("#z2").attr('class', 'tab-pane fade active show');
                    $("#z3").attr('class', 'tab-pane fade');

                    return true;
                }

                if (this._currentStep === 10 || this._currentStep === 13) {
                    $("#z1-tab").attr('aria-selected', 'false');
                    $("#z2-tab").attr('aria-selected', 'false');
                    $("#z3-tab").attr('aria-selected', 'true');

                    $("#z1-tab").attr('class', 'nav-link text-secondary');
                    $("#z2-tab").attr('class', 'nav-link text-secondary ');
                    $("#z3-tab").attr('class', 'nav-link text-secondary active');

                    $("#z1").attr('class', 'tab-pane fade');
                    $("#z2").attr('class', 'tab-pane fade');
                    $("#z3").attr('class', 'tab-pane fade  active show');

                    $("#ijocard1").attr('class',
                        'card ijo-card bg-success');
                    $("#ijocard2").attr('class',
                        'card ijo-card ');

                    $("#ns-0").attr('style', 'display:block');
                    $("#ns-1").attr('style', 'display:none');
                    $("#ns-2").attr('style', 'display:none');
                    $("#ns-3").attr('style', 'display:none');
                    return true;
                }


            }).oncomplete(function() {
                location.reload();
            }).start();
        }
    </script>
@endpush
