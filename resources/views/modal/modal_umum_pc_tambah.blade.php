@if (Auth::user()->gocap_id_pc_pengurus != null)
    {{--  tambah program_penguatan_kelembagaan --}}
    <div wire:ignore.self class="modal fade " id="modal_umum_pc_tambah" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">


        <div class="modal-dialog modal-lg modal-detail-kegiatan-dokumentasi_panduan">
            <div class="modal-content">
                <div class="modal-header">

                    {{-- <select name="" class="select2dulu lolo">
                        <option value="a">a</option>
                        <option value="a">a</option>
                    </select> --}}

                    <h5 class="modal-title"> TAMBAH PENGAJUAN UMUM LAZISNU CILACAP
                    </h5>
                    <div>

                        {{-- <a style="color: blue; font-size:18px;" class="d-inline btn"
                            id="modal_tambah_pengajuans_umums_panduan">
                            PANDUAN </a> --}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>



                {{-- 
                @if (session()->has('alert_wa'))
                    <div class="alert alert-warning m-3" role="alert">
                        <i class="fas fa-spinner"></i> {{ session('alert_wa') }}
                    </div>
                @endif --}}


                {{-- {{ $tab_p1_show_active }} - 
                {{ $tab_p2_show_active }} -  --}}
                {{-- tabbed --}}
                <div class="row mt-2  mr-2 ml-2 ">
                    <div class="col-4 col-md-12  col-sm-12 ">
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
                        {{-- <ul class="nav nav-tabs  ml-1 mr-1" id="myTab1" role="tablist"> --}}



                        {{-- tab p1 --}}
                        {{-- <li class="nav-item modal-tambah-pengajuan-pemohon-panduan" role="presentation">
                                <a wire:ignore.self class="nav-link text-secondary tabsatu active" id="p1-tab"
                                    data-toggle="tab" data-target="#p1" type="button" role="tab" aria-controls="p1"
                                    aria-selected="true">1. Pemohon</a>
                            </li> --}}
                        {{-- end tab p1 --}}
                        {{-- tab p2 --}}
                        {{-- <li class="nav-item" role="presentation">
                                <a wire:ignore.self
                                    class="nav-link text-secondary tabdua {{ $nama_pemohon == '' || $nohp_pemohon == '' || $alamat_pemohon == '' || $tgl_pelaksanaan == ''
                                        ? 'disabled'
                                        : '' }}"
                                    id="p2-tab" data-toggle="tab" data-target="#p2" type="button" role="tab"
                                    aria-controls="p2" aria-selected="false">2. Rincian Program</a>
                            </li> --}}
                        {{-- end tab p2 --}}

                        {{-- </ul> --}}
                    </div>
                </div>
                {{-- end tabbed --}}

                {{-- form --}}
                <form wire:submit.prevent="tambah_pengajuan_pc">
                    {{-- isi tabbed --}}
                    <div class="tab-content" id="myTab1">

                        {{-- isi tab x  --}}
                        <div wire:ignore.self class="tab-pane fade  show active" id="p1" role="tabpanel"
                            aria-labelledby="p1-tab">
                            @include('detail.tab-p1')
                        </div>
                        {{-- end isi tab x --}}

                        {{-- isi tab p2  --}}
                        {{-- <div wire:ignore.self class="tab-pane fade " id="p2" role="tabpanel"
                            aria-labelledby="p2-tab">
                            @include('detail.tab-p2')
                        </div> --}}
                        {{-- end modal body --}}


                        {{-- @if ($tab_p1_show_active == 'active')
                            @include('detail.tab-p1')
                        @endif
                        @if ($tab_p2_show_active == 'active')
                            @include('detail.tab-p2')
                        @endif --}}
                    </div>



                    {{-- info --}}
                    <div class="card card-body ml-3 mr-3" style="background-color:#cbf2d6;">
                        <b>INFORMASI!</b>
                        <span>
                            Setelah pengajuan tersimpan, tambahkan daftar penerima manfaat & lampiran pengajuan jika ada
                            (proposal/sktm/dokumen lain)
                        </span>
                    </div>
                    {{-- end info --}}


                    <div class="modal-footer">
                            <button type="button"
                                class="btn btn-secondary modal-tambah-pengajuan-batal-pengajuan-panduan"
                                data-dismiss="modal"><i class="fas fa-ban"></i>
                                Batal</button>
                                     <button class="btn btn-success" wire:loading.attr="disabled"><i
                                    class="fas fa-save"></i>
                                Simpan</button>
                        
                          


                        <script>
                            $(".tabdua").click(function() {
                                @this.set('tab_p1_show_active', '');
                                @this.set('tab_p2_show_active', 'show active');
                            })
                            $(".balik").click(function() {
                                $('#p1-tab').tab('show');
                            });
                        </script>
                    </div>




                </form>
                {{-- end form --}}

            </div>
        </div>



    </div>
    {{-- end tambah program_penguatan_kelembagaan --}}
@endif

@push('script')
    <script>
        $(document).ready(function() {

            window.loadContactDeviceSelect2 = () => {

                $('#id_program').on('change', function() {
                    @this.set('id_program_pilar', '');
                });
                $('#id_program_pilar').on('change', function() {
                    @this.set('id_program_kegiatan', '');
                });

                $('#satuan_pengajuan').on('input', function(e) {
                    $('#satuan_pengajuan').val(formatRupiah($('#satuan_pengajuan').val(),
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


<script>
    var yeso = document.getElementById("modal_tambah_pengajuans_umums_panduan");
    yeso.onclick = function() {
        introJs().setOptions({
            steps: [{
                    element: document.querySelector('.modal-detail-kegiatan-dokumentasi_panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector('.modal-tambah-pengajuan-pemohon-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector('.modal-tambah-pengajuan-nomor-pengajuan-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector(
                        '.modal-tambah-pengajuan-pemohon-pengajuan-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector(
                        '.modal-tambah-pengajuan-no-hp-pemohon-pengajuan-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector(
                        '.modal-tambah-pengajuan-alamat-pemohon-pengajuan-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector(
                        '.modal-tambah-pengajuan-petugas-pentasyarufan-pemohon-pengajuan-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector(
                        '.modal-tambah-pengajuan-tgl-pengajuan-pemohon-pengajuan-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector(
                        '.modal-tambah-pengajuan-tgl-pelaksanaan-pemohon-pengajuan-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector(
                        '.modal-tambah-pengajuan-batal-pengajuan-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                },
                {
                    element: document.querySelector(
                        '.modal-tambah-pengajuan-selanjutnya-pengajuan-panduan'),
                    title: 'Detail Kegiatan',
                    intro: 'Berisi detail kegiatan program pentasyarufan yang sudah dilaksanakan'
                }
            ]
        }).onbeforechange(function() {
            if (this._currentStep === 1) {
                $("#modal_1").attr('disabled', '');

                return true;
            }

        }).start();
    }
</script>

<script>
    // $(document).ready(function () {
    //     $('.select2dulu').select2();
    // });
    $(".lolo").on('change', function() {
        console.log('asd');
        // console.log($("#jenis_program").val());
        // @this.set('id_program_kegiatan', $("#jenis_program").val(););
    });
    // $(".sos").on('input',function () {
    //     console.log('LOL');
    //     $('.select2dulu').select2();
    // });
</script>

<script>
    $('#jenis_program').on('change', function() {
        console.log('asd');
        console.log($("#jenis_program").val());
        @this.set('id_program_kegiatan', $("#jenis_program").val(););
    });
</script>
