<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="https://code.iconify.design/iconify-icon/1.0.0-beta.3/iconify-icon.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>


<!-- bootstrap-select -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.js') }}"></script>
<script src="{{ asset('autoNumeric.js') }}"></script>

{{-- date range picker --}}


{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


{{-- <script>
    $(function() {
        bsCustomFileInput.init();
    });
</script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@if (session('toast'))
    <script>
        toastr.success('Berhasil Diubah')
    </script>
@endif


{{-- auto hide alert --}}
<script>
    $(document).ready(function() {
        $(".alert-success").delay(2000).slideUp(200, function() {
            $(this).alert('close');
        });
        $(".alert-danger").delay(2000).slideUp(200, function() {
            $(this).alert('close');
        });
        $(".alert-warning").delay(2000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
    $(document).ready(function() {
        window.livewire.on('waktu_alert', () => {
            $(".alert-success").delay(2000).slideUp(200, function() {
                $(this).alert('close');
            });
            $(".alert-danger").delay(2000).slideUp(200, function() {
                $(this).alert('close');
            });
            
        });
    });
</script>



{{-- auto close modal --}}
<script>
    window.addEventListener('closeModal', event => {
        console.log('BISA MASUK SINI');
        $('#modal_pilar_tambah').modal('hide')
        $('#modal_pilar_ubah').modal('hide')
        $('#modal_kegiatan_tambah').modal('hide')
        $('#modal_kegiatan_ubah').modal('hide')
        $('#modal_pengajuan_konfirmasi').modal('hide')
        $('#modal_pengajuan_rekomendasi').modal('hide')
        $('#modal_internal_lampiran_tambah').modal('hide')
        $('#modal_internal_lampiran_ubah').modal('hide')
        $('#modal_internal_arsip_tambah').modal('hide')
        $('#modal_internal_arsip_ubah').modal('hide')
        $('#modal_pengeluaran_tambah').modal('hide')
        $('#modal_pengeluaran_ubah').modal('hide')
        $('#modal_pengajuan_penerima_manfaat_survey').modal('hide')
        $('#modal_pengajuan_penerima_manfaat').modal('hide')
        $('#modal_pengajuan_kegiatan').modal('hide')
        $('#modal_pengajuan_berita').modal('hide')
        $('#modal_ubah_nominal_pengajuan').modal('hide')
    });

    window.addEventListener('tambah_rencana', event => {
        $('#modal_rencana_tambah').modal('hide')
        $('#modal_rencana_detail').modal('show').css('overflow-y', 'auto');
    });

    window.addEventListener('ubah_rencana', event => {
        $('#modal_rencana_detail').modal('hide')
        $('#modal_rencana_ubah').modal('show').css('overflow-y', 'auto');
    });

    window.addEventListener('berhasil_ubah_rencana', event => {
        $('#modal_rencana_ubah').modal('hide')
        $('#modal_rencana_detail').modal('show').css('overflow-y', 'auto');
    });

    window.addEventListener('berhasil_hapus_rencana', event => {
        $('#modal_rencana_detail').modal('hide')
    });
</script>

{{-- script format rupiah --}}
<script>
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        console.log(rupiah);
        return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }
</script>

{{-- <script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script> --}}


<!-- Modal -->
<div class="modal fade" id="SesiLogin" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h5 class=" text-center text-bold" id="staticBackdropLabel">SESI LOGIN ANDA SUDAH HABIS</h5>
                <span>
                    SILAHKAN LOGIN ULANG
                </span>
            </div>
            <div class="modal-footer">
                <a href="/" type="button" class="btn btn-success btn-block">LOGIN ULANG</a>
            </div>
        </div>
    </div>
</div>

@if (Auth::check())
    <script>
        var timeout = ({{ config('session.lifetime') }} * 60000) - 10;
        setTimeout(function() {
            $('#SesiLogin').modal('show')
        }, timeout)
    </script>
@endif

<script>
    document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
        element.addEventListener('keyup', function(e) {
            let cursorPosition = this.selectionStart;
            let value = parseInt(this.value.replace(/[^,\d]/g, ''));
            let originalLength = this.value.length;
            if (isNaN(value)) {
                this.value = "";
            } else {
                this.value = value.toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                });
                cursorPosition = this.value.length - originalLength + cursorPosition;
                this.setSelectionRange(cursorPosition, cursorPosition);
            }
        });
    });
</script>
