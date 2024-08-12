@extends('main')

@section('arsip_berita', 'active')



@section('css')
@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/berita">Berita Pentasyarufan</a> /
                            <a>{{ $page }}</a>
                        </li>
                    </ol>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid ">
            <!-- Form Element sizes -->
            @php
                $rul = strtolower($role);
            @endphp


            <form method="post" action="/{{ $role }}/aksi_tambah_berita" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="role" value="{{ $role }}">

                <div class="card card-success ">

                    <div class="card-body">
                        <!-- Form Element sizes -->
                        <div class="card card-success ijo-atas">
                            <div class="row mt-4 ml-4 justify-content-between">
                                <div>
                                    <h3 class="card-title "><b>Rincian Berita Pentasyarufan</b> </h3> &nbsp;<span
                                        class="information-content">
                                        <a href="#" class="sweet-tooltip" data-style-tooltip="tooltip-mini-slick"
                                            data-text-tooltip=" Lorem ipsum, dolor sit amet  <br> consectetur  <br> adipisicing elit. Facere
                                               , asperiores ullam  <br> esse quibusdam recusandae <br>  libero explicabo inventore  <br> sit dolore iure. "><i
                                                class="far fa-question-circle"></i></a>
                                    </span>
                                </div>
                                <!-- Button trigger modal -->
                                <div class="col-auto mr-3">
                                </div>
                                <input type="hidden" name="pelaksana_kegiatan">
                            </div>

                            <div class="card-body">

                                @livewire('kategori-berita')



                                {{-- disini --}}
                                <div class="mb-3 input-isi-berita-umum" wire:ignore>
                                    <p class="form-label">Isi Berita</p>
                                    <textarea name="narasi_berita" class="my-editor form-control @error('narasi_berita') is-invalid @enderror"
                                        id="my-editor" cols="30" rows="10">{{ old('narasi_berita') }}</textarea>
                                    @error('narasi_berita')
                                        <span
                                            style="color: #dc3545;font-weight: bolder;
                                        font-size: 100%;">
                                            Narasi Berita harus diisi</span>
                                    @enderror
                                </div>





                            </div>
                        </div>




                        <!-- /.card -->
                        {{-- LAMPIRAN --}}
                        <div class="card card-success ijo-atas card-upload-file-berita-umum">
                            <div class="row mt-4 ml-4 justify-content-between">
                                <div>
                                    <h3 class="card-title "><b>Upload Foto Berita</b>
                                    </h3>
                                    &nbsp; <a href="#" class="sweet-tooltip" data-style-tooltip="tooltip-mini-slick"
                                        data-text-tooltip=" Lorem ipsum, dolor sit amet  <br> consectetur  <br> adipisicing elit. Facere
                               , asperiores ullam  <br> esse quibusdam recusandae <br>  libero explicabo inventore  <br> sit dolore iure. "><i
                                            class="far fa-question-circle"></i></a>
                                </div>

                                <div class="col-auto mr-3">

                                    <button id="addRow" type="button"
                                        class="btn btn-primary card-tambah-lampiran-berita-umum"> <i
                                            class="fas fa-plus-circle" aria-hidden="true"></i> Tambah
                                        Lampiran</button>
                                </div>

                            </div>

                            <div class="card-body mr-3 ml-3">

                                <div class="form-group row ">

                                    <p> Silahkan pilih Background Berita Pentasyarufan ,
                                        Jenis File yang diijinkan adalah: <b> jpg, png, jpeg,
                                            png</b></p>
                                </div>

                                <div class="form-group row ">
                                    <p class="text-danger">*Jika Foto Dokumentasi tidak ada maka tidak perlu
                                        dilampirkan</p>
                                </div>

                                <div class="form-group row ">

                                    <p class="col-sm-4 col-form-label">
                                        File Foto Background </p>
                                    <input style="width: 100%;" class="form-control" class="form-control m-input"
                                        type="text" name="judul_file_bg" placeholder="Masukan Judul File Background">



                                </div>
                                <div class="form-group row ">

                                    <input style="width: 100%;" class="form-control" class="form-control m-input"
                                        type="file" name="foto_background_berita" accept=".jpg,.jpeg,.png">
                                </div>

                                <div class="form-group row ">

                                    <p class="col-sm-4 col-form-label">
                                        File Foto Dokumentasi </p>
                                    <input style="width: 100%;" class="form-control" class="form-control m-input"
                                        type="text" name="judul_file_doc" placeholder="Masukan Judul File Dokumentasi">

                                </div>
                                <div class="form-group row ">

                                    <input style="width: 100%;" class="form-control" class="form-control m-input"
                                        type="file" name="foto_dokumentasi_berita" accept=".jpg,.jpeg,.png">
                                </div>




                                {{-- <link rel="stylesheet"
                                        href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
                                    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}


                                <div id="newRow"></div>


                                <script type="text/javascript">
                                    // add row

                                    $("#addRow").click(function() {

                                        var html = '';

                                        html += '<div id="inputFormRow1">';
                                        html += '<label class="col-form-label">File Foto Dokumentasi</label > ';
                                        html += '<div class="form-group row">';
                                        html +=
                                            '<input type="text" name="judul_files[]" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off">';

                                        html += '</div>';
                                        html += '<div class="form-group row " >';
                                        html += '<div class="input-group" id="inputFormRow">';
                                        html +=
                                            '<input  type="file" name="foto_dokumentasi_beritas[]" accept=".jpg,.jpeg,.png" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off">' +
                                            '<div class="input-group-append">' +
                                            '<button id="removeRow" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>' +
                                            '</div>';
                                        html += '</div>';
                                        html += '</div>';
                                        html += '</div>';

                                        $('#newRow').append(html);
                                    });


                                    // remove row
                                    $(document).on('click', '#removeRow', function() {

                                        $(this).closest('#inputFormRow1').remove();
                                    });
                                </script>
                            </div>

                        </div>
                        <!-- /.LAMPIRAN -->
                        <!-- /.card -->
                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-body -->
                    <div class="card-footer ">
                        <div class="col-auto float-right">
                            <!-- Button trigger modal -->
                            <a href=" javascript:history.back()" type="button" class="btn btn-secondary">
                                <i class="fas fa-ban"></i> Batal
                            </a>



                            <button onclick="$('#cover-spin').show(0)" type="submit"
                                class="btn btn-success card-simpan-berita-umum" name="submit">
                                <i class="fas fa-save"></i> Simpan

                            </button>





                        </div>
                    </div>
                </div>
            </form>


    </section>



@endsection



@section('js')

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
    </script>
    <script>
        CKEDITOR.replace('my-editor', options);
    </script>

    <script src="{{ asset('tagjs/tagsinput.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
        integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg=="
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"
        integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js"
        integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg=="
        crossorigin="anonymous"></script>
    <!-- daterange picker -->
    <style type="text/css">
        .bootstrap-tagsinput {
            width: 100%;
        }

        .label-info {
            background-color: green;

        }

        .label {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out,
                border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
    </style>



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




@endsection


@push('custom-scripts')
    {{-- ada disposisi atau tidak --}}


    <script>
        $(document).ready(function() {
            document.getElementById('disposisi-card').style.display = 'none';
            document.getElementById('sppd-card').style.display = 'none';
        });
        document.getElementById('tombol-disposisi1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-disposisi2').checked = false;
                document.getElementById('disposisi-card').style.display = 'block';

            }
        });
        document.getElementById('tombol-disposisi2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-disposisi1').checked = false;
                // document.getElementById('tombol-sppd2').checked = true;
                // document.getElementById('tombol-sppd1').checked = false;
                document.getElementById('sppd1actv1').classList.remove('active');
                document.getElementById('sppd1actv2').classList.add('active');
                document.getElementById('sppd-card').style.display = 'none';
                document.getElementById('disposisi-card').style.display = 'none';
                document.getElementById('sppd-card').style.display = 'none';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            document.getElementById('sppd-card').style.display = 'none';
        });
        document.getElementById('tombol-sppd1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-sppd2').checked = false;

                document.getElementById('sppd-card').style.display = 'block';
            }
        });
        document.getElementById('tombol-sppd2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-sppd1').checked = false;

                document.getElementById('sppd-card').style.display = 'none';
            }
        });
    </script>

    <script>
        var harga = document.getElementById('anggaran');
        harga.addEventListener('keyup', function(e) {
            harga.value = formatRupiah(this.value, '');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
    </script>


    {{-- golongan atau satuan --}}
    <script>
        $(document).ready(function() {
            document.getElementById('select2-golongan').style.display = 'none';
            document.getElementById('select2-internal').style.display = 'none';


        });
        document.getElementById('tombol-jenis-disposisi1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi3').checked = false;
                document.getElementById('tombol-jenis-disposisi2').checked = false;
                document.getElementById('select2-satuan_upzis').style.display = 'block';

                document.getElementById('select2-internal').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'none';
            }
        });
        document.getElementById('tombol-jenis-disposisi2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi1').checked = false;
                document.getElementById('tombol-jenis-disposisi3').checked = false;
                document.getElementById('select2-satuan_upzis').style.display = 'none';

                document.getElementById('select2-internal').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'block';
            }
        });
        document.getElementById('tombol-jenis-disposisi3').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi1').checked = false;
                document.getElementById('tombol-jenis-disposisi2').checked = false;

                document.getElementById('select2-satuan_upzis').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'none';
                document.getElementById('select2-internal').style.display = 'block';
            }
        });
    </script>

    @push('intro_tambah_berita')
        <script>
            function klikkene(value) {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.input-tgl-terbit-berita-umum'),
                                title: 'Tanggal Terbit Berita',
                                intro: 'Berfungsi untuk mengisikan Tanggal Terbit Berita Pentasyarufan'
                            },
                            {
                                element: document.querySelector('.input-kategori-berita-umum'),
                                title: 'Kategori Berita',
                                intro: 'Untuk Menunjukan Kategori Berita Yang Akan Diterbitkan, Kategori Berita Bisa di Isikan Pada Form Kategori Berita '
                            },
                            {
                                element: document.querySelector('.input-tag-berita-umum'),
                                title: 'Tag Berita',
                                intro: 'Untuk Memberikan Tagar Pada Berita Pentasyarufan, Kolom Input Ini Tidak Wajib Diisikan'
                            },
                            {
                                element: document.querySelector('.input-isi-berita-umum'),
                                title: 'Isi Berita',
                                intro: 'Untuk Mengisikan Narasi Berita Yang Akan Dibuat'
                            },
                            {
                                element: document.querySelector('.card-tambah-lampiran-berita-umum'),
                                title: 'Tambah Lampiran Berita',
                                intro: 'Untuk Melakukan Penambahan File Dokumentasi Berita Yang Dibutuhkan'
                            },
                            {
                                element: document.querySelector('.card-upload-file-berita-umum'),
                                title: 'Upload File Berita',
                                intro: 'Upload Foto File Berita Pentasyarufan tidak Wajib Diisikan Bila Tidak Ada, Upload File Foto Berita ini Nantinya Akan Dimunculkan Di Background Berita Pentasyarufan Yang Sudah Terbit'
                            },
                            {
                                element: document.querySelector('.card-simpan-berita-umum'),
                                title: 'Simpan Berita',
                                intro: 'Jika Isian Form Berita Sudah Lengkap , Maka Tekan Tombol Simpan Untuk Menyimpan Berita, Berita Yang Telah Tersimpan Akan Otomatis Diterbitkan Dan Bisa Dilihat Oleh Pengurus PCNU Lazisnu Cilacap'
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
    @endpush
@endpush
