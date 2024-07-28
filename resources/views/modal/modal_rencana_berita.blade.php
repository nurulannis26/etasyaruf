{{--  modal --}}
<div wire:ignore.self class="modal fade" id="modal_rencana_berita" data-backdrop="static" data-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">

        <div class="modal-content modal_rencana_berita_detail_berita_panduan">
            <div class="modal-header">
                <h5 class="modal-title">BERITA KEGIATAN PROGRAM PENTASYARUFAN
                </h5>

                <div>
                    {{-- <a style="color: blue; font-size:18px;" class="d-inline btn"
                        id="modal_berita_program_pentasyarufan_panduan">
                        PANDUAN </a> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <div class="ml-3 mr-3 mt-3" style="margin-bottom: -0.2cm;">
                @if (session()->has('alert_berita'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('alert_berita') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>

            <div class="modal-body ">
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'ef77ea4b-725b-11ed-ad27-e4a8df91d8b3')
                        @if ($status_kegiatan == '0')
                            {{-- alert --}}
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fas fa-minus-circle"></i> Tidak bisa membuat berita, karena
                                laporan kegiatan belum diisi
                            </div>
                            {{-- end alert --}}
                        @endif
                    @endif
                @endif

                <div class="row">

                    <div class="col col-md-12 col-sm-12">
                        <div class="card card-body">
                            <div class="row">





                                <div class="col   col-md-8 col-sm-12">
                                    {{-- detail --}}



                                    <div class="form-row ">

                                        <div class="col-12 col-md-7 col-sm-12 mb-2 mb-xl-0">
                                            <div class="d-flex flex-row bd-highlight align-items-center">
                                                <div class="p-2 bd-highlight mb-1">
                                                    <i class="fas fa-newspaper"></i>
                                                </div>
                                                <div class="p-1 bd-highlight">
                                                    <b> DETAIL
                                                        BERITA</b>
                                                    @if ($berita)

                                                        @if ($berita->tanggal_terbit == null)
                                                            <sup class="badge badge-danger text-white bg-warning mb-2">Belum
                                                                Terbit</sup>
                                                        @else
                                                            <sup class="badge badge-danger text-white bg-success mb-2">Sudah
                                                                Terbit</sup>
                                                        @endif
                                                    @else
                                                        <sup class="badge badge-danger text-white bg-warning mb-2">Belum
                                                            Terbit</sup>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                                            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'ef77ea4b-725b-11ed-ad27-e4a8df91d8b3')
                                                <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">

                                                    @if ($berita)
                                                        @if ($berita->tanggal_terbit == null)
                                                            @if ($berita->judul_berita == '' or $berita->narasi_berita == '')
                                                                <button
                                                                    class="btn btn-outline-success btn-sm mr-2 btn-block"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="Tidak dapat menerbitkan berita, karena detail berita belum lengkap"
                                                                    disabled>
                                                                    <i class="fas fa-upload"></i>
                                                                    Terbitkan berita
                                                                </button>
                                                            @else
                                                                <a wire:click="tombol_terbit"
                                                                    class="btn btn-outline-success btn-sm mr-2 btn-block">
                                                                    <i class="fas fa-upload"></i>
                                                                    Terbitkan berita
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <button class="btn btn-outline-success btn-sm mr-2 btn-block"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Tidak dapat menerbitkan berita, karena detail berita belum lengkap"
                                                            disabled>
                                                            <i class="fas fa-upload"></i>
                                                            Terbitkan berita
                                                        </button>
                                                    @endif

                                                </div>

                                                <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                    @if ($none_block_berita == 'none')
                                                        @if ($status_kegiatan == '0')
                                                            <button
                                                                class="btn btn-outline-secondary btn-sm float-right tombol-ubah btn-block"
                                                                role="button" data-toggle="tooltip"
                                                                data-placement="bottom" disabled
                                                                title="Tidak bisa membuat berita, karena laporan kegiatan belum diisi"><i
                                                                    class="fas fa-edit"></i>
                                                                Detail</button>
                                                        @else
                                                            <button wire:click="tambah_ubah_berita_upzis_ranting"
                                                                class="btn btn-outline-secondary btn-sm float-right tombol-ubah btn-block"
                                                                role="button"><i class="fas fa-edit"></i>
                                                                Detail</button>
                                                        @endif
                                                    @endif

                                                    {{-- <button type="button" name="submit"
                                                        class="btn btn-success btn-sm  @if ($none_block_berita == 'none') d-none @endif btn-block"
                                                        id="simpan-berita"><i class="fas fa-save"></i>
                                                        Simpan</button> --}}

                                                </div>
                                            @endif
                                        @endif
                                    </div>




                                    {{-- card acc --}}
                                    <div class="card card-body mt-2"
                                        style="background-color:#cbf2d6;display: {{ $none_block_terbit }};">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <b class="text-success">KONFIRMASI TERBIT BERITA</b>
                                            <div>
                                                <a wire:click="close" type="button" class="btn btn-danger btn-sm"><i
                                                        class="fas fa-ban"></i>
                                                    Batalkan</a>
                                                <a wire:click="terbit_berita" type="button"
                                                    class="btn btn-success btn-sm"><i class="fas fa-check"></i>
                                                    Iya Terbitkan</a>
                                            </div>
                                        </div>


                                    </div>
                                    {{-- end card acc --}}


                                    {{-- form --}}


                                    <table class="table table-sm table-bordered mt-2" style="border: 1px solid;">
                                        <tr>
                                            <th style="width:20%">Foto</th>
                                            <td>
                                                @if ($berita)
                                                    @if ($berita->foto_background_berita == null)
                                                        -
                                                    @else
                                                        <a target="_blank"
                                                            href="{{ asset('uploads/foto_background_berita/' . $berita->foto_background_berita) }}">{{ $berita->foto_background_berita }}</a>
                                                    @endif
                                                @else
                                                    -
                                                @endif

                                            </td>

                                        </tr>

                                        <tr>
                                            <th>Tanggal Terbit</th>
                                            <td>
                                                @if ($berita)

                                                    @if ($berita->tanggal_terbit == null)
                                                        -
                                                    @else
                                                        {{ Carbon\Carbon::parse($berita->tanggal_terbit)->isoFormat('dddd, D MMMM Y') }}
                                                    @endif
                                                @else
                                                    -
                                                @endif

                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Pewarta</th>

                                            <td>
                                                @if ($berita)

                                                    @if ($berita->id_pengguna == null)
                                                        -
                                                    @else
                                                        @php
                                                            $b = config('app.database_siftnu');
                                                            $a = DB::table($b . '.pengguna')
                                                                ->where('id_pengguna', $berita->id_pengguna)
                                                                ->first();
                                                            
                                                        @endphp
                                                        {{ $a->nama }}
                                                    @endif
                                                @else
                                                    -
                                                @endif



                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="text-center" colspan="2">Judul Berita
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="text-justify text-center" colspan="2">
                                                @if ($berita)

                                                    @if ($berita->judul_berita == null)
                                                        -
                                                    @else
                                                        {{ $berita->judul_berita }}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>



                                        <tr>
                                            <td class="text-justify" colspan="2">
                                                @if ($berita)

                                                    @if ($berita->narasi_berita == null or $berita->narasi_berita == '')
                                                        -
                                                    @else
                                                        {!! $berita->narasi_berita !!}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    </table>







                                    {{-- end detail --}}

                                </div>


                                {{-- @if ($tgl_terbit_berita == null and $none_block_berita == 'none') --}}
                                <div class="col col-md-4 col-sm-12 ">

                                    <div class="col-12 col-md-12 col-sm-12 mb-2 mb-xl-0 ">
                                        <div class="d-flex flex-row bd-highlight align-items-center">
                                            <div class="p-2 bd-highlight">
                                                <i class="fas fa-image"></i>
                                            </div>
                                            <div class="p-1 bd-highlight">
                                                <b class="ml-2"> FOTO BERITA</b>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- foto --}}
                                    <div class="mt-2 ">
                                        @if ($berita)
                                            <img class="d-block w-100" style="border-radius:10px; "
                                                @if ($berita->foto_background_berita == null) src="{{ asset('default/no-image.png') }}" 
                                              @else  src="{{ asset('uploads/foto_background_berita/' . $berita->foto_background_berita) }}" @endif
                                                alt="First slide">
                                        @else
                                            <img class="d-block w-100" style="border-radius:10px; "
                                                src="{{ asset('default/no-image.png') }}" alt="First slide">
                                        @endif
                                    </div>
                                    {{-- end foto --}}



                                </div>
                                {{-- end dokumentasi --}}
                                {{-- @endif --}}




                            </div>
                        </div>
                    </div>

                </div>


                @push('script')
                    {{-- ckeditor --}}
                    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
                    <script>
                        var options = {
                            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
                        };
                        CKEDITOR.replace('my-editor', options);
                    </script>

                    <script>
                        $(document).ready(function() {

                            $('#ubah-berita').click(function() {
                                var cuk = $('#cuk').val();
                                console.log(cuk);
                                // @this.set('narasi_berita', 'ets aja');
                                CKEDITOR.instances['my-editor'].setData(cuk);

                            });

                            $('#simpan-berita').click(function() {

                                @this.set('narasi_berita2', CKEDITOR.instances['my-editor'].getData());
                                document.getElementById("simpan-berita2").click();
                                // bsCustomFileInput.init();
                            });

                            window.loadContactDeviceSelect2 = () => {


                                $('.tombol-batal').click(function() {
                                    $(".custom-file-berita").html('').change();

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

        </div>
    </div>

</div>
{{-- end modal --}}

<script>
    var yeso = document.getElementById("modal_berita_program_pentasyarufan_panduan");
    yeso.onclick = function() {
        introJs().setOptions({
            steps: [{
                element: document.querySelector('.modal_rencana_berita_detail_berita_panduan'),
                title: 'Berita',
                intro: 'Menampilkan berita yang dibuat oleh Lazisnu Cilacap seputar program pentasyarufan yang telah dilaksanakan'
            }]
        }).start();
    }
</script>
