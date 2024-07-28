{{--  modal --}}
<div wire:ignore.self class="modal fade" id="modal_rencana_kegiatan" data-backdrop="static" tabindex="-1"
    data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">LAPORAN KEGIATAN PROGRAM PENTASYARUFAN
                </h5>
                <div>
                    {{-- <a style="color: blue; font-size:18px;" class="d-inline btn" id="modal_rencana_kegiatan_panduan">
                        PANDUAN </a> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>


            {{-- tabbed --}}
            <div class="row mt-3 mr-2 ml-2">
                <div class="col-4 col-md-12  col-sm-12 ">
                    <ul class="nav nav-tabs mt-1 ml-1 mr-1" id="myTab1" role="tablist">
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
                        {{-- tab y1 --}}
                        <li class="nav-item" role="presentation">
                            <a wire:ignore.self class="nav-link text-secondary active" id="y1-tab" data-toggle="tab"
                                data-target="#y1" type="button" role="tab" aria-controls="y1"
                                aria-selected="true">1. Dokumentasi</a>
                        </li>
                        {{-- end tab y1 --}}
                        {{-- tab y2 --}}
                        <li class="nav-item" role="presentation">
                            <a wire:ignore.self class="nav-link text-secondary " id="y2-tab" data-toggle="tab"
                                data-target="#y2" type="button" role="tab" aria-controls="y2"
                                aria-selected="false">2. Pengeluaran</a>
                        </li>
                        {{-- end tab y2 --}}

                    </ul>
                </div>
            </div>
            {{-- end tabbed --}}

            <div class="modal-body">

                {{-- isi tabbed --}}
                <div class="tab-content" id="myTab1">

                    {{-- isi tab y1  --}}
                    <div wire:ignore.self class="tab-pane fade show active" id="y1" role="tabpanel"
                        aria-labelledby="y1-tab">
                        @include('detail.tab-y1')
                        {{-- alert --}}

                    </div>
                    {{-- end isi tab y1 --}}

                    {{-- isi tab y2  --}}
                    <div wire:ignore.self class="tab-pane fade " id="y2" role="tabpanel"
                        aria-labelledby="y2-tab">
                        @include('detail.tab-y2')

                    </div>
                    {{-- end modal body --}}


                </div>

                {{-- @push('script')
                    <script>
                        $(document).ready(function() {

                            window.loadContactDeviceSelect2 = () => {
                                bsCustomFileInput.init();


                                // $('#satuan_disetujui').on('input', function(e) {
                                //     $('#satuan_disetujui').val(formatRupiah($('#satuan_disetujui').val(),
                                //         'Rp. '));
                                // });
                                // $('#nominal_bantuan').on('input', function(e) {
                                //     $('#nominal_bantuan').val(formatRupiah($('#nominal_bantuan').val(),
                                //         'Rp. '));
                                // });
                                // $('#nominal_pengeluaran').on('input', function(e) {
                                //     $('#nominal_pengeluaran').val(formatRupiah($('#nominal_pengeluaran').val(),
                                //         'Rp. '));
                                // });

                                // $('.tombol-tambah').click(function() {
                                //     $(".custom-file-tambah-dokumentasi").html('').change();
                                //     $(".custom-file-nota-pengeluaran").html('').change();
                                //     // bsCustomFileInput.init();
                                // });

                                // $('.tombol-reset').click(function() {
                                //     $(".custom-file-tambah-dokumentasi").html('').change();
                                //     $(".custom-file-nota-pengeluaran").html('').change();
                                //     bsCustomFileInput.init();
                                // });

                            }

                            loadContactDeviceSelect2();
                            window.livewire.on('loadContactDeviceSelect2', () => {
                                loadContactDeviceSelect2();
                            });

                        });
                    </script>
                @endpush --}}

            </div>





        </div>
    </div>

</div>
{{-- end modal --}}

<script>
    var yeso = document.getElementById("modal_rencana_kegiatan_panduan");
    yeso.onclick = function() {
        introJs().setOptions({
            steps: [{
                    element: document.querySelector('.modal-detail-kegiatan-dokumentasi_panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector('.modal-detail-kegiatan-dokumentasi_foto_panduan'),
                    title: 'Dokumentasi Kegiatan',
                    intro: 'Berisi gambar dokumentasi program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector('.modal-detail-kegiatan-pengeluaran_panduan'),
                    title: 'Detail Dana Pentasyarufana',
                    intro: 'Menampilkan informasi mengenai dana yang digunakan dan tersisa dari program pentasyarufan'
                },
                {
                    element: document.querySelector(
                        '.modal-detail-kegiatan-pengeluaran_penyaluran_kwitansi_panduan'),
                    title: 'Kwitansi',
                    intro: 'Klik tombol kwitansi untuk mendownload format kwitansi'
                },
                {
                    element: document.querySelector(
                        '.modal-detail-kegiatan-pengeluaran_penyaluran_berita_acara_panduan'),
                    title: 'Berita Acara',
                    intro: 'Klik tombol kwitansi untuk mendownload format berita acara'
                },
                {
                    element: document.querySelector(
                        '.modal-detail-kegiatan-pengeluaran_penyaluran_panduan'),
                    title: 'Data Penyaluran',
                    intro: 'Data penyaluran yang sudah ditambahkan akan tampil di tabel ini'
                }
            ]
        }).onbeforechange(function() {
            if (this._currentStep === 0) {
                $("#y1").attr('aria-selected', 'true');
                $("#y2").attr('aria-selected', 'false');

                $("#y1").attr('class', 'tab-pane fade show active');
                $("#y2").attr('class', 'tab-pane fade show');

                $("#y1-tab").attr('class', 'nav-link text-secondary active');
                $("#y2-tab").attr('class', 'nav-link text-secondary ');
                return true;
            }

            if (this._currentStep === 2) {
                $("#y1").attr('aria-selected', 'false');
                $("#y2").attr('aria-selected', 'true');

                $("#y1").attr('class', 'tab-pane fade show ');
                $("#y2").attr('class', 'tab-pane fade show active');

                $("#y1-tab").attr('class', 'nav-link text-secondary ');
                $("#y2-tab").attr('class', 'nav-link text-secondary active');
                return true;
            }


        }).
        start();
    }
</script>
