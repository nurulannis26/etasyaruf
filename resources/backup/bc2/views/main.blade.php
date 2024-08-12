<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- into js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/intro.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/intro.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/intro.min.js.map"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/introjs-rtl.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/introjs-rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/introjs-rtl.min.css.map">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/introjs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/introjs.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/6.0.0/introjs.min.css.map">
    <script src="https://cdn.jsdelivr.net/npm/intro.js@6.0.0/intro.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intro.js@6.0.0/intro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intro.js@6.0.0/intro.module.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@6.0.0/introjs.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js@6.0.0/introjs-rtl.css">
    <script src="https://cdn.bootcdn.net/ajax/libs/intro.js/6.0.0/intro.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/intro.js/6.0.0/intro.min.js"></script>
    <link href="https://cdn.bootcdn.net/ajax/libs/intro.js/6.0.0/introjs-rtl.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/intro.js/6.0.0/introjs-rtl.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/intro.js/6.0.0/introjs.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/intro.js/6.0.0/introjs.min.css" rel="stylesheet">
    <!-- intro js end -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.bootstrap4.min.css">
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">




    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            overflow-x: hidden;
        }

        .select2-selection {
            height: 38px !important;
        }

        .select2-selection__arrow {
            height: 38px !important;
        }
    </style>
    <title>E-TASYARUF</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo_siftnu.png') }}">
    @include('template.css')

    @yield('css')
    @livewireStyles
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">


    <div class="wrapper">
        <!-- Navbar -->
        @include('template.nav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('template.side')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('template.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @include('template.js')

    @yield('js')
    
    <script>
        $(document).ready(function() {
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-top-right"
            }
        });

        window.addEventListener('success', event => {
            toastr.success(event.detail.message);
        });
        window.addEventListener('warning', event => {
            toastr.warning(event.detail.message);
        });
        window.addEventListener('error', event => {
            toastr.error(event.detail.message);
        });
    </script>
    
    @livewireScripts
    @stack('script')
    @stack('cart-js-internal-pc')
    {{-- 
    @stack('intro_tour_dashboard')
    @stack('intro_data_pengajuan')
    @stack('intro_data_pengajual_detail')
    @stack('intro-program-dan-pilar')
    @stack('intro-data-pengajuan-pc-lazisnu')
    @stack('detail-pengajuan-internal-pc')
    @stack('detail-pengajuan-umum-pc-lazisnu') --}}




    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>


    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
    <script type="text/javascript" class="init">
        $(document).ready(function() {
            var table = $('#example1').DataTable({
                // scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                fixedColumns: {
                    left: 2,
                },
                "paging": false,
                "ordering": false,
                "info": false

            });
        });
    </script>

@stack('s2')

</body>

<script>
    $(document).ready(function() {
        $('#nav-tab a[href="#{{ old('tab') }}"]').tab('show')
    });
</script>
{{-- 
<script>
    $.cookie('last-scroll-top', $(window).scrollTop());
    document.location.reload(true);

    var lastScrollTop = $.cookie('last-scroll-top');
    if (lastScrollTop) {
        $(window).scrollTop(lastScrollTop);
        $.removeCookie('last-scroll-top');
    }
</script> --}}

<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.js') }}"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>


<script>
    // $(document).ready(function() {
    //     $('.select2dulu').select2();
    // });
</script>
<script>
    // $('#id_program_pilars').on('change', function() {
    //     var s = $("#id_program_pilars").val();
    //     var x = '{{ url('/jenis-program/') }}';
    //     var a = x + '/' + s;
    //     $('#jenis_program').select2({
    //         ajax: {
    //             url: a,
    //             dataType: 'json',
    //             processResults: function(data) {
    //                 return {
    //                     results: data.items
    //                 }
    //             }
    //         }
    //     });
    // });
</script>


</html>
