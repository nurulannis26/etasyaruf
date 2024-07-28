<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- Jquery -->
    <script type="text/javascript" src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <link href="{{ asset('select2/css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('select2/js/select2.min.js') }}"></script>
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>

    <link rel="icon" type="image/x-icon" href="{{ asset('img/gocap.png') }}">
    <title>Import Data Munfiq</title>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
</head>

<body>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous">
    </script>

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">NU Care Lazisnu Cilacap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li>{{ Auth::user()->nama }}</li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>

        <div class="container px-1 py-0">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                @if (session('berhasil'))
                    <div class='col-12'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <p> {{ session('berhasil') }}</p><button type='button' class='btn-close'
                                data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                @endif
                <div class="col-12 col-md-8 col-lg-6">
                    <form method="post" enctype="multipart/form-data" action="{{ route('import_excel_arsip_pc') }}">
                        @csrf
                        <div class="">

                            {{-- <br> --}}
                            <label class="form-label">No Pengajuan</label>
                            <input type="text" class="form-control mb-3"
                                value="{{ $data->nomor_surat }}" readonly>
                            <label class="form-label">Pilar</label>
                            <input type="text" class="form-control mb-3"
                                value=" {{ \App\Http\Controllers\Helper::getDataPilar($data_detail->id_program_pilar ?? null)->pluck('pilar')->first() }}" readonly>
                            <label class="form-label">Program</label>
                            <input type="text" class="form-control mb-3"
                                value="{{ \App\Http\Controllers\Helper::getDataKegiatan($data_detail->id_program_kegiatan ?? null)->pluck('nama_program')->first() }}" readonly>

                            <label class="form-label">Keterangan</label>
                            <input type="text" class="form-control mb-3"
                                value="{{ $data_detail->pengajuan_note }}" readonly>

                            <label class="form-label">Target Penerima Manfaat</label>
                            <input type="text" class="form-control mb-3"
                                value="{{ $data_detail->nama_penerima }}" readonly>

                        </div>

                      
                        <input type="hidden" name="id_pengajuan" value="{{ $data_detail->id_pengajuan }}">
                        <input type="hidden" name="id_pengajuan_detail" value="{{ $data_detail->id_pengajuan_detail }}">
                        <div class="mb-3">
                            <label class="form-label"> File Excel  </label>
                            <input class="form-control" name="file_penerima" type="file" id="formFile" accept=".xlsx, .xls" required="required">
                        </div>


                        <div class="mb-3">
                            <input class="btn btn-primary" type="submit" >
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold lh-1 mb-3">Import Data Penerima Manfaat Dari Excel</h1>
                    <p class="lead">Pilih dan Upload file dengan format excel (.xlsx). 1 file berisi data penerima
                        manfaat terkait program yang dipilih (jangan dicampur). Sesuaikan isi data penerima manfaat
                        dengan template excel yang tersedia & panduan yang ada. </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a class="btn btn-outline-primary" href="javascript:close_window();">Kembali</a>
                        <script>
                            function close_window() {
                                window.close();
                            }
                        </script>
                        <a target="_blank" class="btn btn-outline-success"
                            href="{{ asset('template_excel/Template Import Penerima Manfaat.xlsx') }}">Download
                            Template</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            Panduan Import
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Panduan Umum Pengisian Data Penerima Manfaat (Excel)
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ol>
                                            <li>Isikan data dengan lengkap sesuai format excel yang tersedia
                                            </li>
                                            <li>Isikan kolom tanggal seperti contoh berikut : 23/11/2023</li>
                                        </ol>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>




<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
	@if(Session::has('message'))
		var type="{{Session::get('alert-type','info')}}"

		switch(type){
			case 'info':
		         toastr.info("{{ Session::get('message') }}");
		         break;
	        case 'success':
	            toastr.success("{{ Session::get('message') }}");
	            break;
         	case 'warning':
	            toastr.warning("{{ Session::get('message') }}");
	            break;
	        case 'error':
		        toastr.error("{{ Session::get('message') }}");
		        break;
		}
	@endif
</script>
</body>

</html>
