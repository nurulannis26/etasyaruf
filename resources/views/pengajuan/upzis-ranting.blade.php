@extends('main')

@if($sub == 'pengajuan')
    @section('upzis_ranting', 'active')
    @section('pengajuan_ac', 'active menu-open')
    @section('pengajuan_mo', 'menu-open')
@else
    @section('lap_upzis_ranting', 'active')
    @section('laporan_ac', 'active menu-open')
    @section('laporan_mo', 'menu-open')
@endif
@section('css')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">

                <div class="col-sm-6 text-secondary mt-1">
                    <a href="/{{ $role }}/dashboard"> Dashboard</a> /
                    <a> Data {{ ucfirst($sub) }} UPZIS & Ranting</a>
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
        <div class="container-fluid">


            <div class="row">
                <div class="col-12">
                    <div class="card ijo-atas">
                        {{-- tabbed --}}
                        <div class="row mt-2 mr-2 ml-2 card-header-data-pengajuan">
                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0 pl-2">
                                <h5 class="d-flex justify-content-center mt-2">
                                    <b class="text-success pl-2 mt-1">DATA {{ strtoupper($sub) }}</b>
                                </h5>
                            </div>
                            <div class="col-12 col-md-9  col-sm-12 mb-2 mb-xl-0">
                                <ul class="nav nav-tabs mt-1 ml-1 mr-1" id="myTabContent" role="tablist">
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

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-secondary {{ $tab_upzis }}" id="upzis-tab"
                                            data-toggle="tab" data-target="#upzis" type="button" role="tab"
                                            aria-controls="upzis" aria-selected="true">
                                            <span>
                                                Upzis MWCNU
                                            </span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-secondary {{ $tab_ranting }}" id="ranting-tab"
                                            data-toggle="tab" data-target="#ranting" type="button" role="tab"
                                            aria-controls="ranting" aria-selected="false">Ranting NU
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {{-- end tabbed --}}

                        {{-- card body --}}
                        <div class="card-body">

                            {{-- isi tabbed --}}
                            <div class="tab-content " id="myTabContent">

                                {{-- upzis  --}}
                                <div class="tab-pane fade {{ $tab_upzis }}" id="upzis" role="tabpanel"
                                    aria-labelledby="upzis-tab">
                                    @include('detail.new.tab-umum-upzis')
                                </div>


                                {{-- ranting --}}
                                <div class="tab-pane fade {{ $tab_ranting }}" id="ranting" role="tabpanel"
                                    aria-labelledby="ranting-tab">
                                    @include('detail.new.tab-umum-ranting')
                                </div>


                            </div>
                            {{-- end isi tabbed --}}

                        </div>
                        {{-- end card body --}}

                    </div>

                </div>
            </div>
        </div>

        @if (Auth::user()->gocap_id_upzis_pengurus != null)
            @include('modal.new.tambah-pengajuan-upzis')
            @include('modal.new.tambah-pengajuan-ranting')
        @endif


    </section>
@endsection


@section('js')


    <!-- AdminLTE -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>


@endsection
