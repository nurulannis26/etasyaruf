<div>

    @php
        
        function penyebut($nilai)
        {
            $nilai = abs($nilai);
            $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
            $temp = '';
            if ($nilai < 12) {
                $temp = ' ' . $huruf[$nilai];
            } elseif ($nilai < 20) {
                $temp = penyebut($nilai - 10) . ' Belas';
            } elseif ($nilai < 100) {
                $temp = penyebut($nilai / 10) . ' Puluh' . penyebut($nilai % 10);
            } elseif ($nilai < 200) {
                $temp = ' Seratus' . penyebut($nilai - 100);
            } elseif ($nilai < 1000) {
                $temp = penyebut($nilai / 100) . ' Ratus' . penyebut($nilai % 100);
            } elseif ($nilai < 2000) {
                $temp = ' Seribu' . penyebut($nilai - 1000);
            } elseif ($nilai < 1000000) {
                $temp = penyebut($nilai / 1000) . ' Ribu' . penyebut($nilai % 1000);
            } elseif ($nilai < 1000000000) {
                $temp = penyebut($nilai / 1000000) . ' Juta' . penyebut($nilai % 1000000);
            } elseif ($nilai < 1000000000000) {
                $temp = penyebut($nilai / 1000000000) . ' Milyar' . penyebut(fmod($nilai, 1000000000));
            } elseif ($nilai < 1000000000000000) {
                $temp = penyebut($nilai / 1000000000000) . ' Trilyun' . penyebut(fmod($nilai, 1000000000000));
            }
            return $temp;
        }
        
        function terbilang($nilai)
        {
            if ($nilai < 0) {
                $hasil = 'Minus ' . trim(penyebut($nilai));
            } elseif ($nilai == 0) {
                $hasil = 'Nol ' . trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }
            return '(' . $hasil . ' Rupiah)';
        }
    @endphp


    {{-- Be like water. --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">



                {{-- card data pentasyarufan --}}
                {{-- <div class="card ijo-atas">
                    <div class="card-body mt-2">

                        <div class="card">
                            <div class="card-body intro-profil-pengajuan-pc">
                                <div class="row mb-2">

                                    <div class="col-12 col-md-8 col-sm-12 mb-2 mb-xl-0">
                                        <b><i class="fas fa-user"></i> DETAIL PENGAJUAN </b>
                                    </div>


                                </div>
                                <div class="form-row">

                                    
                                    <div class="col-sm-4 invoice-col">
                                        Nomor Pengajuan
                                        <address>
                                            <b> {{ $data->nomor_surat }}</b><br>
                                            Tgl Pengajuan :
                                            {{ Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('dddd, D MMMM Y') }}<br>
                                        </address>
                                    </div>
                                 

                                 
                                    <div class="col-sm-4 invoice-col">
                                        Tingkat
                                        <address>
                                            <b>Umum</b><br>
                                            PC Lazisnu Cilacap
                                        </address>
                                    </div>
                                 

                                    <div class="col-sm-4 invoice-col">
                                        Petugas Pentasyarufan
                                        <address>
                                            <b>{{ $this->nama_pengurus_pc($data->pj_pc) }}</b><br>
                                            {{ $this->jabatan_pengurus_pc($data->pj_pc) }}
                                        </address>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>

                </div> --}}



                <div class="row">
                    {{-- card jenis data --}}
                    {{-- <div class="col col-md-4 col-sm-12"> --}}
                    {{-- <div class="card ijo-atas">
                            <b class="d-flex justify-content-center mt-3 ">Pilih Jenis Data</b>
                            <div class="card-body"> --}}

                    {{-- tombol pengajuan --}}
                    {{-- <div wire:click="tombol_pengajuan" class="text-dark" style="cursor: pointer">
                                    <div class="card ijo-card {{ $bg_card_pengajuan }} tab-pengajuan-umum-pc"
                                        id="woy1">
                                        <div class="card-body ">
                                            <div class="form-row">
                                                <div class="col-6 float-left">
                                                    <b class="mt-1">Pengajuan</b>
                                                </div>
                                                <div class="col-6 float-right">
                                                    @if ($bg_card_pengajuan == 'bg-success')
                                                        <div class='btn btn-light btn-block '
                                                            style='border-radius:10px;  '>
                                                            {{ $data_detail->approval_status }}
                                                        </div>
                                                    @else
                                                        @if ($data_detail->approval_status == 'Belum Direspon')
                                                            <div class='btn btn-secondary btn-block '
                                                                style='border-radius:10px;  '>
                                                                {{ $data_detail->approval_status }}
                                                            </div>
                                                        @elseif($data_detail->approval_status == 'Disetujui')
                                                            <div class='btn btn-success btn-block '
                                                                style='border-radius:10px;  '>
                                                                {{ $data_detail->approval_status }}
                                                            </div>
                                                        @else
                                                            <div class='btn btn-danger btn-block '
                                                                style='border-radius:10px;  '>
                                                                {{ $data_detail->approval_status }}
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <hr class="bg-light">
                                            <div class="row">

                                                <div class="col-6 float-left">
                                                    <p class="mt-1">
                                                        Nominal Pengajuan
                                                    </p>
                                                </div>

                                                <div class="col-6 mr-auto">
                                                    <strong class="float-right">
                                                        Rp{{ number_format($data_detail->nominal_pengajuan, 0, '.', '.') }},-
                                                    </strong>
                                                </div>
                                            </div>

                                            <span class="float-right">
                                                {{ terbilang($data_detail->nominal_pengajuan) }}
                                            </span>
                                        </div>
                                    </div>
                                </div> --}}
                    {{-- end tombol pengajuan --}}

                    {{-- tombol kegiatan --}}
                    {{-- <div wire:click="tombol_kegiatan" class="text-dark" style="cursor: pointer">
                                    <div class="card ijo-card {{ $bg_card_kegiatan }} tab-lpj-umum-pc " id="woy2">
                                        <div class="card-body ">
                                            <div class="form-row">
                                                <div class="col-12 float-left">
                                                    <b class="mt-1">LPJ Penggunaan Dana</b>
                                                </div>

                                            </div>
                                            <hr class="bg-light">
                                            <div class="row">
                                                <div class="col-6 float-left">
                                                    <p class="mt-1">
                                                        Dana Digunakan
                                                    </p>
                                                </div>
                                                <div class="col-6 mr-auto">
                                                    <strong class="float-right">
                                                        Rp{{ number_format($dana_digunakan, 0, '.', '.') }},-
                                                    </strong>
                                                </div>
                                            </div>
                                            <span class="float-right">
                                                {{ terbilang($dana_digunakan) }}
                                            </span>
                                        </div>
                                    </div>
                                </div> --}}
                    {{-- end tombol pengajuan --}}

                    {{-- tombol berita --}}
                    {{-- <div wire:click="tombol_berita" class="text-dark" style="cursor: pointer">
                                    <div class="card ijo-card {{ $bg_card_berita }} tab-berita-umum-pc" id="woy3">
                                        <div class="card-body ">
                                            <div class="form-row">

                                                <div class="col-6 float-left">
                                                    <b class="mt-1">Berita</b>
                                                </div>

                                                <div class="col-6 float-right">
                                                    @if ($bg_card_berita == 'bg-success')
                                                        @if ($berita == null)
                                                            <div class='btn btn-light btn-block '
                                                                style='border-radius:10px;  '>
                                                                Belum Diinput
                                                            </div>
                                                        @else
                                                            @if ($berita->status == 'Belum Terbit')
                                                                <div class='btn btn-light btn-block '
                                                                    style='border-radius:10px;  '>
                                                                    Belum Terbit
                                                                </div>
                                                            @elseif($berita->status == 'Belum Diinput')
                                                                <div class='btn btn-light btn-block '
                                                                    style='border-radius:10px;  '>
                                                                    Belum Diinput
                                                                </div>
                                                            @else
                                                                <div class='btn btn-light btn-block '
                                                                    style='border-radius:10px;  '>
                                                                    Sudah Terbit
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if ($berita == null)
                                                            <div class='btn btn-secondary btn-block '
                                                                style='border-radius:10px;  '>
                                                                Belum Diinput
                                                            </div>
                                                        @else
                                                            @if ($berita->status == 'Belum Terbit')
                                                                <div class='btn btn-warning btn-block '
                                                                    style='border-radius:10px;  '>
                                                                    Belum Terbit
                                                                </div>
                                                            @elseif($berita->status == 'Belum Diinput')
                                                                <div class='btn btn-secondary btn-block '
                                                                    style='border-radius:10px;  '>
                                                                    Belum Diinput
                                                                </div>
                                                            @else
                                                                <div class='btn btn-success btn-block '
                                                                    style='border-radius:10px;  '>
                                                                    Sudah Terbit
                                                                </div>
                                                            @endif
                                                        @endif


                                                    @endif
                                                </div>
                                            </div>
                                            <hr class="bg-light">
                                            <div class="row">
                                                <div class="col-12 float-left">
                                                    <p class="mt-1">
                                                        @if ($berita == null)
                                                            -
                                                        @else
                                                            {{ $berita->judul_berita }}
                                                        @endif
                                                    </p>
                                                </div>

                                            </div>
                                            <span class="float-right">
                                            </span>
                                        </div>
                                    </div>
                                </div> --}}
                    {{-- end tombol berita --}}



                    {{-- </div>
                        </div>
                    </div> --}}
                    {{-- end card jenis data --}}


                    <div class="col col-md-12 col-sm-12">
                        <div class="card ijo-atas">
                            <div class="card-body">

                                {{-- card pengajuan --}}
                                <div class="card card-body" id="nt-0"
                                    style="display: @if ($bg_card_pengajuan == 'bg-success') block @else none @endif ">
                                    {{-- tabbed --}}
                                    <div class="row">
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
                                                {{-- tab v1 --}}
                                                <li class="nav-item tab-tab-pengajuan-umum-pc" role="presentation">
                                                    <a wire:ignore.self class="nav-link text-secondary active"
                                                        id="v1-tab" data-toggle="tab" data-target="#v1"
                                                        type="button" role="tab" aria-controls="v1"
                                                        aria-selected="true">1. Data Pengajuan</a>
                                                </li>
                                                {{-- end tab v1 --}}
                                                {{-- tab v2 --}}
                                                {{-- <li  class="nav-item tab-survey-umum-pc" role="presentation">
                                                    <a wire:ignore.self class="nav-link text-secondary "
                                                        id="v2-tab" data-toggle="tab" data-target="#v2"
                                                        type="button" role="tab" aria-controls="v2"
                                                        aria-selected="false">2.
                                                        Survey</a>
                                                </li> --}}
                                                {{-- end tab v2 --}}
                                                {{-- tab v3 --}}
                                                <li class="nav-item " role="presentation">
                                                    <a wire:ignore.self class="nav-link text-secondary " id="vdisposisi-tab"
                                                        data-toggle="tab" data-target="#vdisposisi" type="button"
                                                        role="tab" aria-controls="vdisposisi" aria-selected="false">2.
                                                        Disposisi Penyaluran</a>
                                                </li>
                                                {{-- end tab v3 --}}

                                                {{-- tab v3 --}}
                                                <li class="nav-item survey" role="presentation">
                                                    <a wire:ignore.self class="nav-link text-secondary "
                                                        id="vsurvey-tab" data-toggle="tab" data-target="#vsurvey"
                                                        type="button" role="tab" aria-controls="vsurvey"
                                                        aria-selected="false">3.
                                                        Survey</a>
                                                </li>
                                                {{-- end tab v3 --}}


                                                {{-- tab v3 --}}
                                                {{-- <li class="nav-item tab-persetujuan_direktur-umum-pc"
                                                    role="presentation">
                                                    <a wire:ignore.self class="nav-link text-secondary " id="v3-tab"
                                                        data-toggle="tab" data-target="#v3" type="button"
                                                        role="tab" aria-controls="v3" aria-selected="false">4.
                                                        Persetujuan Direktur</a>
                                                </li> --}}
                                                {{-- end tab v3 --}}
                                                {{-- tab v4 --}}
                                                <li class="nav-item tab-keuangan-umum-pc" role="presentation">
                                                    <a wire:ignore.self class="nav-link text-secondary " id="v4-tab"
                                                        data-toggle="tab" data-target="#v4" type="button"
                                                        role="tab" aria-controls="v4" aria-selected="false">4.
                                                        Pencairan Keuangan</a>
                                                </li>
                                                {{-- end tab v4 --}}

                                                {{-- tab lpj --}}
                                                <li class="nav-item" role="presentation">
                                                    <a wire:click="tombol_kegiatan" wire:ignore.self
                                                        class="nav-link text-secondary " id="lpj-tab"
                                                        data-toggle="tab" data-target="#lpj" type="button"
                                                        role="tab" aria-controls="lpj" aria-selected="false">5. LPJ
                                                        & BA</a>
                                                </li>
                                                {{-- end tab lpj --}}


                                                {{-- tab berita --}}
                                                <!--<li class="nav-item" role="presentation">-->
                                                <!--    <a wire:click="tombol_berita" wire:ignore.self-->
                                                <!--        class="nav-link text-secondary " id="berita-tab"-->
                                                <!--        data-toggle="tab" data-target="#berita" type="button"-->
                                                <!--        role="tab" aria-controls="berita" aria-selected="false">6.-->
                                                <!--        Berita</a>-->
                                                <!--</li>-->
                                                {{-- end tab berita --}}


                                            </ul>
                                        </div>
                                    </div>
                                    {{-- end tabbed --}}



                                    {{-- isi tabbed --}}
                                    <div class="tab-content" id="myTab1">


                                        <div wire:ignore.self class="tab-pane fade show active " id="v1"
                                            role="tabpanel" aria-labelledby="v1-tab">
                                            @include('detail.tab-v1')
                                        </div>

                                        <div wire:ignore.self class="tab-pane fade" id="vdisposisi"
                                        role="tabpanel" aria-labelledby="vdisposisi-tab">
                                        @include('detail.tab-vdisposisi')
                                    </div>

                                        {{-- <div wire:ignore.self class="tab-pane fade " id="v2" role="tabpanel"
                                            aria-labelledby="v2-tab">
                                            @include('detail.tab-v2')
                                        </div> --}}
                                        {{-- <div wire:ignore.self class="tab-pane fade " id="v3" role="tabpanel"
                                            aria-labelledby="v3-tab">
                                            @include('detail.tab-v3')
                                        </div> --}}

                                        <div wire:ignore.self class="tab-pane fade " id="vsurvey" role="tabpanel"
                                            aria-labelledby="vsurvey-tab">
                                            @include('detail.tab-vsurvey')
                                        </div>

                                        {{-- <div wire:ignore.self class="tab-pane fade " id="v4" role="tabpanel"
                                            aria-labelledby="v4-tab">
                                            @include('detail.tab-v4')
                                        </div> --}}

                                        <div wire:ignore.self class="tab-pane fade " id="v4" role="tabpanel"
                                            aria-labelledby="v4-tab">
                                            @include('detail.tab-v4')
                                        </div>

                                        <div wire:ignore.self class="tab-pane fade " id="lpj" role="tabpanel"
                                            aria-labelledby="lpj-tab">
                                            @include('detail.tab-lpj')
                                        </div>


                                        <!--<div wire:ignore.self class="tab-pane fade " id="berita" role="tabpanel"-->
                                        <!--    aria-labelledby="berita-tab">-->
                                        <!--    @include('detail.tab-berita')-->
                                        <!--</div>-->

                                    </div>
                                    {{-- end isi tabbed --}}
                                </div>
                                {{-- end card pengajuan --}}

                            </div>

                        </div>
                    </div>


                </div>

            </div>

            @include('modal.modal_pengajuan_kegiatan')
            @include('modal.modal_pengajuan_dokumentasi')
            @include('modal.modal_pengeluaran_tambah')
            @include('modal.modal_pengeluaran_ubah')
            @include('modal.modal_pengeluaran_hapus')
            @include('modal.modal_pengajuan_berita')
            @include('modal.edit_berita_pengajuan')
            @include('modal.modal_umum_lpj_tambah')
            @include('modal.modal_umum_lpj_ubah')
            @include('modal.modal_umum_lpj_hapus')


            {{-- modal tab v1 --}}
            {{-- @include('modal.modal_pengajuan_penerima_manfaat_survey')    --}}


            @push('script')
                <script>
                    $(document).ready(function() {
                        window.loadContactDeviceSelect2 = () => {
                            bsCustomFileInput.init();
                            $('.tombol-tambah').click(function() {
                                $(".custom-file-arsip").html('').change();
                            });

                            $('.tombol-ubah').click(function() {
                                $(".custom-file-arsip").html('').change();
                                $(".custom-file-berita").html('').change();
                            });

                            $('#nominal_pengeluaran').on('input', function(e) {
                                $('#nominal_pengeluaran').val(formatRupiah($('#nominal_pengeluaran').val(),
                                    'Rp. '));
                            });
                            $('#nominal_pengeluaran2').on('input', function(e) {
                                $('#nominal_pengeluaran2').val(formatRupiah($('#nominal_pengeluaran2').val(),
                                    'Rp. '));
                            });

                        }

                        // loadContactDeviceSelect2();
                        // window.livewire.on('loadContactDeviceSelect2', () => {
                        //     loadContactDeviceSelect2();
                        // });

                    });
                </script>
            @endpush

        </div>
    </div>
</div>
