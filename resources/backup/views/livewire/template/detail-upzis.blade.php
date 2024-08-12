<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">



                {{-- card data pentasyarufan --}}
                <div class="card ijo-atas">
                    <!-- /.card-header -->
                    <div class="card-body mt-2">

                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">

                                    {{-- judul --}}
                                    <div class="col-12 col-md-8 col-sm-12 mb-2 mb-xl-0">
                                        <b><i class="fas fa-user"></i> DATA PENGAJUAN </b>
                                    </div>
                                    {{-- end judul --}}

                                    {{-- status --}}
                                    {{-- <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                        <div class="float-right">
                                            <span class="mt-4 mr-4">Diinput :
                                                {{ Carbon\Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM Y') }}
                                                {{ Carbon\Carbon::parse($data->created_at)->format('H:i:s') }}
                                            </span>
                                            <a class="btn btn-warning " wire:click="" data-toggle="modal"
                                                data-target="#modal_profil_penerima" role="button"><i
                                                    class="fas fa-user"></i>
                                                {{ $data->status_pengajuan }}</a>
                                        </div>
                                    </div> --}}
                                    {{-- end status --}}

                                </div>
                                <div class="form-row">

                                    {{-- nomor pengajuan --}}
                                    <div class="col-sm-4 invoice-col">
                                        Nomor Pengajuan
                                        <address>
                                            <b> {{ $data->nomor_surat }}</b><br>
                                            Tgl Pengajuan :
                                            {{ Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('dddd, D MMMM Y') }}<br>
                                        </address>
                                    </div>
                                    {{-- end nomor pengajuan --}}

                                    {{-- tingkat --}}
                                    <div class="col-sm-4 invoice-col">
                                        Tingkat
                                        <address>
                                            <b>Umum</b><br>
                                            @if ($data->id_ranting == null)
                                                {{ $this->nama_upzis($data->id_upzis) }}
                                            @else
                                                {{ $this->nama_ranting($data->id_ranting) }}
                                            @endif
                                        </address>
                                    </div>
                                    {{-- end tingkat --}}

                                    {{-- pj pengambilan dana --}}
                                    <div class="col-sm-4 invoice-col">
                                        PJ Pengambilan Dana
                                        <address>
                                            <b>{{ $this->nama_pengurus_upzis($data->pj_upzis) }}</b><br>
                                            {{ $this->jabatan_pengurus_upzis($data->pj_upzis) }}
                                        </address>
                                    </div>
                                    {{-- end pj pengambila dana --}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- end card data pentasyarufan --}}



                {{-- detail --}}
                <div class="card ijo-atas">

                    {{-- tabbed --}}
                    <div class="row mt-3 mr-2 ml-2">
                        <div class="col-4 col-md-12  col-sm-12 ">
                            <ul class="nav nav-tabs mt-1 ml-1 mr-1" id="myTab2" role="tablist">
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
                                {{-- tab a --}}
                                <li class="nav-item" role="presentation">
                                    <a wire:ignore.self class="nav-link text-secondary active" id="a-tab"
                                        data-toggle="tab" data-target="#a" type="button" role="tab"
                                        aria-controls="a" aria-selected="true">

                                        1. Daftar Rencana

                                    </a>
                                </li>
                                {{-- end tab a --}}
                                {{-- tab b --}}
                                <li class="nav-item" role="presentation">
                                    <a wire:ignore.self class="nav-link text-secondary " id="b-tab"
                                        data-toggle="tab" data-target="#b" type="button" role="tab"
                                        aria-controls="b" aria-selected="false">

                                        2. Lembar Pengajuan

                                    </a>
                                </li>
                                {{-- end tab b --}}

                                {{-- tab c --}}
                                <li class="nav-item" role="presentation">
                                    <a wire:ignore.self class="nav-link text-secondary " id="c-tab"
                                        data-toggle="tab" data-target="#c" type="button" role="tab"
                                        aria-controls="c" aria-selected="false">3. Lembar Rekomendasi</a>
                                </li>
                                {{-- end tab c --}}


                            </ul>
                        </div>
                    </div>
                    {{-- end tabbed --}}

                    {{-- card body --}}
                    <div class="card-body">

                        {{-- isi tabbed --}}
                        <div class="tab-content" id="myTab2">

                            {{-- isi tab a  --}}
                            <div wire:ignore.self class="tab-pane fade show active" id="a" role="tabpanel"
                                aria-labelledby="a-tab">
                                @include('detail.tab-a')
                            </div>
                            {{-- end tab a --}}

                            {{-- isi tab b  --}}
                            <div wire:ignore.self class="tab-pane fade " id="b" role="tabpanel"
                                aria-labelledby="b-tab">
                                @include('detail.tab-b')
                            </div>
                            {{-- end tab b --}}

                            {{-- isi tab c  --}}
                            <div wire:ignore.self class="tab-pane fade" id="c" role="tabpanel"
                                aria-labelledby="c-tab">
                                @include('detail.tab-c')
                            </div>
                            {{-- end tab c --}}




                        </div>
                        {{-- end isi tabbed --}}

                    </div>
                    {{-- end card body --}}

                </div>
                {{-- end detail --}}


            </div>
        </div>
    </div>

    @include('modal.modal_rencana_detail')
    @include('modal.modal_rencana_berita')
    @include('modal.modal_rencana_tambah')
    @include('modal.modal_rencana_kegiatan')
    @include('modal.modal_pengajuan_rekomendasi')
    @include('modal.modal_pengajuan_konfirmasi')



</div>
