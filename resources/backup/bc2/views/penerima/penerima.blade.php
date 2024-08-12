@extends('main')
@section('penerima', 'active')
@section('css')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">

                <div class="col-sm-6 text-secondary mt-1">
                    <a href="/{{ $role }}/dashboard"> Dashboard</a> /
                    <a> {{ $page }}</a>
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



                    {{-- livewire program --}}
                    @livewire('penerima')



                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->


@endsection
