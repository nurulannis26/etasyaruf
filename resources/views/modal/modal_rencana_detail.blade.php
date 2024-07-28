{{--  tambah program_penguatan_kelembagaan --}}
<div wire:ignore.self class="modal fade" id="modal_rencana_detail" data-backdrop="static" tabindex="-1"
    data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DETAIL RENCANA PROGRAM PENTASYARUFAN
                </h5>
                <div>
                    {{-- <a style="color: blue; font-size:18px;" class="d-inline btn" id="modal_rencana_detail_panduan">
                        PANDUAN </a> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            {{-- tabbed --}}
            <div class="row mt-3 mr-2 ml-2">
                <div class="col-4 col-md-9 col-sm-12 ">
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
                        {{-- tab x1 --}}
                        <li class="nav-item" role="presentation">
                            <a wire:ignore.self class="nav-link text-secondary active" id="x1-tab" data-toggle="tab"
                                data-target="#x1" type="button" role="tab" aria-controls="x1"
                                aria-selected="true">1. Rincian
                                Program</a>
                        </li>
                        {{-- end tab x --}}
                        {{-- tab x2 --}}
                        <li class="nav-item" role="presentation">
                            <a wire:ignore.self class="nav-link text-secondary " id="x2-tab" data-toggle="tab"
                                data-target="#x2" type="button" role="tab" aria-controls="x2"
                                aria-selected="false">2. Penerima Manfaat</a>
                        </li>
                        {{-- end tab x2 --}}

                    </ul>
                </div>

                @if (Auth::user()->gocap_id_upzis_pengurus != null and
                        $data->tgl_konfirmasi == null and
                        $data->status_rekomendasi == 'Belum Terbit')
                    <div class="col-4 col-md-3  col-sm-12 ">
                        <div class="float-right">
                            <button wire:click="modal_rencana_ubah('{{ $id_pengajuan_detail }}')" type="button"
                                class="btn btn-secondary batal-modal-data-pengajuan" data-dismiss="modal"><i
                                    class="fas fa-edit"></i>
                                Ubah</button>
                            <button wire:click="modal_hapus_rencana('{{ $id_pengajuan_detail }}')" data-toggle="modal"
                                data-target="#modal_rencana_hapus" class="btn btn-danger batal-modal-data-pengajuan"
                                data-dismiss="modal"><i class="fas fa-trash"></i>
                                Hapus</button>
                        </div>
                    </div>
                @endif

                @if ($detail_a != null)
                    @if (Auth::user()->gocap_id_upzis_pengurus != null and
                            $data->tgl_konfirmasi != null and
                            $data->status_rekomendasi == 'Belum Terbit' and
                            $detail_a->approval_status == 'Ditolak')
                        <div class="col-4 col-md-3  col-sm-12 ">
                            <div class="float-right">
                                <button wire:click="modal_rencana_ubah('{{ $id_pengajuan_detail }}')" type="button"
                                    class="btn btn-secondary batal-modal-data-pengajuan" data-dismiss="modal"><i
                                        class="fas fa-edit"></i>
                                    Ubah</button>

                            </div>
                        </div>
                    @endif
                @endif

            </div>
            {{-- end tabbed --}}

            {{-- modal body --}}
            <div class="modal-body">
                @if ($detail_a != null)
                    <div class="m-3">
                        {{-- info --}}
                        <i class="fas fa-info-circle"></i> Inputkan data penerima manfaat sesuai jumlah
                        penerima manfaat yang direncanakan
                        <br>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    No : {{ $data->nomor_surat }}
                                </div>
                                <div class="float-right">
                                    Pelaksanaan :
                                    {{ Carbon\Carbon::parse($detail_a->tgl_pelaksanaan)->isoFormat(' D-MM-Y') }}

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end info --}}
                @endif

                {{-- alert --}}
                @if (session()->has('alert_rencana'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="far fa-check-circle"></i> {{ session('alert_rencana') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- end alert --}}


                {{-- isi tabbed --}}
                <div class="tab-content" id="myTab1">




                    {{-- isi tab x  --}}
                    <div wire:ignore.self class="tab-pane fade show active" id="x1" role="tabpanel"
                        aria-labelledby="x1-tab">

                        @include('detail.tab-x1')

                    </div>
                    {{-- end isi tab x --}}


                    {{-- isi tab y  --}}
                    <div wire:ignore.self class="tab-pane fade " id="x2" role="tabpanel"
                        aria-labelledby="x2-tab">
                        @include('detail.tab-x2')
                    </div>
                    {{-- end modal body --}}


                </div>
            </div>




        </div>

    </div>


    @push('script')
        <script>
            $(document).ready(function() {

                window.loadContactDeviceSelect2 = () => {


                    $('#satuan_disetujui').on('input', function(e) {
                        $('#satuan_disetujui').val(formatRupiah($('#satuan_disetujui').val(),
                            'Rp. '));
                    });

                    $('#nominal_bantuan').on('input', function(e) {
                        $('#nominal_bantuan').val(formatRupiah($('#nominal_bantuan').val(),
                            'Rp. '));
                    });


                }

                loadContactDeviceSelect2();
                window.livewire.on('loadContactDeviceSelect2', () => {
                    loadContactDeviceSelect2();

                });

            });
        </script>
    @endpush

</div>
{{-- end tambah program_penguatan_kelembagaan --}}

<script>
    var yeso = document.getElementById("modal_rencana_detail_panduan");
    yeso.onclick = function() {
        introJs().setOptions({
            steps: [{
                    element: document.querySelector('.modal-detail-rencana-pentasyarufan'),
                    title: 'Rencana Pentasyarufan',
                    intro: 'Menampilkan informasi mengenai detail rencana program pentasyarufan'
                },
                {
                    element: document.querySelector('.modal-detail-persetujuan-pc-lazisnu'),
                    title: 'Persetujuan',
                    intro: 'Menampilkan informasi mengenai persetujuan rencana program pentasyarufan oleh Lazisnu Cilacap terutama total nominal yang disetujui'
                },
                @if (Auth::user()->gocap_id_upzis_pengurus)
                    {
                        element: document.querySelector(
                            '.modal-detail-persetujuan-penerima-manfaat-filter'),
                        title: 'Kolom penerima manfaat',
                        intro: 'Untuk menambahkan/mengubah penerima manfaat program pentasyarufan dilakukan di kolom2 ini'
                    }, {
                        element: document.querySelector(
                            '.modal-detail-persetujuan-penerima-manfaat-clear-filter'),
                        title: 'Clear',
                        intro: 'Klik tombol clear untuk mereset kolom'
                    }, {
                        element: document.querySelector(
                            '.modal-detail-persetujuan-penerima-manfaat-tambah'),
                        title: 'Tambah',
                        intro: 'Klik tombol tambah untuk menambahkan penerima manfaat program pentasyarufan'
                    },
                @endif
                @if (Auth::user()->gocap_id_upzis_pengurus)

                    {
                        element: document.querySelector(
                            '.modal-detail-persetujuan-penerima-manfaat-table'),
                        title: 'Daftar Penerima Manfaat',
                        intro: 'Data penerima manfaat yang sudah ditambahkan akan tampil di tabel ini, klik mana saja pada penerima manfaat terpilih untuk mengubah/menghapus data'
                    },
                @endif
                @if (Auth::user()->gocap_id_pc_pengurus)
                    {
                        element: document.querySelector(
                            '.modal-detail-persetujuan-penerima-manfaat-table'),
                        title: 'Daftar Penerima Manfaat',
                        intro: 'Data penerima manfaat yang sudah ditambahkan akan tampil di tabel ini'
                    }
                @endif

            ]
        }).onbeforechange(function() {
            if (this._currentStep === 0) {
                $("#x1").attr('aria-selected', 'true');
                $("#x2").attr('aria-selected', 'false');

                $("#x1").attr('class', 'tab-pane fade show active');
                $("#x2").attr('class', 'tab-pane fade show');

                $("#x1-tab").attr('class', 'nav-link text-secondary active');
                $("#x2-tab").attr('class', 'nav-link text-secondary ');
                return true;
            }

            if (this._currentStep === 2) {
                $("#x1").attr('aria-selected', 'false');
                $("#x2").attr('aria-selected', 'true');

                $("#x1").attr('class', 'tab-pane fade show ');
                $("#x2").attr('class', 'tab-pane fade show active');

                $("#x1-tab").attr('class', 'nav-link text-secondary ');
                $("#x2-tab").attr('class', 'nav-link text-secondary active');
                return true;
            }


        }).start();
    }
</script>
