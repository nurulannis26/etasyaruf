<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
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
                        <a wire:ignore.self class="nav-link text-secondary active" id="a-tab" data-toggle="tab"
                            data-target="#a" type="button" role="tab" aria-controls="a" aria-selected="true">
                            1. Daftar Rencana
                        </a>
                    </li>
                    {{-- tab b --}}
                    <li class="nav-item" role="presentation">
                        <a wire:ignore.self class="nav-link text-secondary " id="b-tab" data-toggle="tab"
                            data-target="#b" type="button" role="tab" aria-controls="b" aria-selected="false">
                            2. Lembar Pengajuan
                        </a>
                    </li>
                    {{-- tab c --}}
                    <li class="nav-item" role="presentation">
                        <a wire:ignore.self class="nav-link text-secondary " id="c-tab" data-toggle="tab"
                            data-target="#c" type="button" role="tab" aria-controls="c" aria-selected="false">3.
                            Lembar Rekomendasi</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTab2">
                {{-- isi tab a  --}}
                <div wire:ignore.self class="tab-pane fade show active intro-detail-data-pengajuan-card-rencana-program"
                    id="a" role="tabpanel" aria-labelledby="a-tab">
                    @include('detail.new.tab-a')
                </div>
                {{-- isi tab b  --}}
                <div wire:ignore.self class="tab-pane fade intro-detail-data-pengajuan-card-lembar-pengajuan"
                    id="b" role="tabpanel" aria-labelledby="b-tab">
                    @include('detail.new.tab-b')
                </div>
                {{-- isi tab c  --}}
                <div wire:ignore.self class="tab-pane fade intro-detail-data-pengajuan-card-lembar-rekomendasi"
                    id="c" role="tabpanel" aria-labelledby="c-tab">
                    @include('detail.new.tab-c')
                </div>
            </div>
        </div>
    </div>

    @include('modal.new.create-edit-rencana')
    @include('modal.new.create-edit-penerima')
    @include('modal.new.create-lampiran-berita')
    @include('modal.new.edit-berita')
    {{-- @include('modal.new.create-edit-kegiatan') --}}
    {{-- @include('modal.new.create-edit-pengeluaran') --}}
    @include('modal.new.lampiran')
    @include('modal.new.detail-laporan')
    @include('modal.new.detail-rencana')

    @include('modal.new.hapus-penerima')
    @include('modal.new.hapus-semua-penerima')
    @include('modal.new.hapus-lampiran-berita')


    @push('script')

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip({
                animated: 'fade',
                placement: 'bottom',
                trigger: 'click'
            });
        });
    </script>


<script>
    $(document).ready(function(){
      $('.tooltip-icon').click(function() {
        $('.tooltip-icon').not(this).tooltip('hide');
      });
    });
  </script>



        <script>
            $(document).ready(function() {
                $('#create-edit-rencana').on('show.bs.modal', function() {
                    // Disable the select2 when the modal is shown
                    $('#select2Petugas').prop('disabled', true);
                    $('#select2Program').prop('disabled', true);
                    $('#select2Pilar').prop('disabled', true);
                    $('#select2Kegiatan').prop('disabled', true);
                });
                window.loadContactDeviceSelect2 = () => {
                    bsCustomFileInput.init();
                    window.initSelectStationDrop = () => {
                        // Event handler for the modal's show.bs.modal event


                        // petugas
                        $('#select2Petugas').select2();
                        $('#select2Petugas').on('change', function() {
                            // Disable other select elements
                            $('#select2Petugas').prop('disabled', true);
                            $('#select2Program').prop('disabled', true);
                            $('#select2Pilar').prop('disabled', true);
                            $('#select2Kegiatan').prop('disabled', true);
                            var data = $(this).val();
                            @this.set('petugas', data);
                        });
                        // program
                        $('#select2Program').select2();
                        $('#select2Program').on('change', function() {
                            // Disable other select elements
                            $('#select2Petugas').prop('disabled', true);
                            $('#select2Program').prop('disabled', true);
                            $('#select2Pilar').prop('disabled', true);
                            $('#select2Kegiatan').prop('disabled', true);
                            var data = $(this).val();
                            @this.set('id_program', data);
                            @this.set('id_program_pilar', '');
                            @this.set('id_program_kegiatan', '');

                        });
                        // pilar
                        $('#select2Pilar').select2({});
                        $('#select2Pilar').on('change', function() {
                            // Disable other select elements
                            $('#select2Petugas').prop('disabled', true);
                            $('#select2Program').prop('disabled', true);
                            $('#select2Pilar').prop('disabled', true);
                            $('#select2Kegiatan').prop('disabled', true);
                            var data = $(this).val();
                            @this.set('id_program_pilar', data);
                        });
                        // kegiatan
                        $('#select2Kegiatan').select2();
                        $('#select2Kegiatan').on('change', function() {
                            // Disable other select elements
                            $('#select2Petugas').prop('disabled', true);
                            $('#select2Program').prop('disabled', true);
                            $('#select2Pilar').prop('disabled', true);
                            $('#select2Kegiatan').prop('disabled', true);
                            var data = $(this).val();
                            @this.set('id_program_kegiatan', data);
                        });
                        // rekening
                        $('#select2Rekening').select2();
                        $('#select2Rekening').on('change', function() {
                            var data = $(this).val();
                            @this.set('id_rekening', data);
                        });
                        // penerima
                        // $('#select2Penerima').select2();
                        // $('#select2Penerima').on('change', function() {
                        //     var data = $(this).val();
                        //     @this.set('id_pengajuan_penerima', data);
                        //     @this.call('getPenerimaForBerita');
                        // });
                        // satuan
                        $('#satuan_pengajuan').on('input', function(e) {
                            $('#satuan_pengajuan').val(formatRupiah($('#satuan_pengajuan').val(),
                                'Rp. '));
                        });
                        // nominal_bantuan
                        $('#nominal_bantuan').on('input', function(e) {
                            $('#nominal_bantuan').val(formatRupiah($('#nominal_bantuan').val(),
                                'Rp. '));
                        });
                        // satuan_disetujui
                        $('#satuan_disetujui').on('input', function(e) {
                            $('#satuan_disetujui').val(formatRupiah($('#satuan_disetujui').val(),
                                'Rp. '));
                        });
                        // satuan_disetujui
                        $('#satuan_pencairan').on('input', function(e) {
                            $('#satuan_pencairan').val(formatRupiah($('#satuan_pencairan').val(),
                                'Rp. '));
                        });
                        // scan konfirmasi
                        $('#UploadKonfirmasi').click(function() {
                            $("#customFileScan").html('').change();
                        });
                        // scan konfirmasi
                        $('#uploadBerita').click(function() {
                            $("#customFileScanBerita").html('').change();
                        });
                        // foto kegiatan
                        $('#uploadFotoKegiatan').click(function() {
                            $("#customFileFotoKegiatan").html('').change();
                        });
                        // kegiatan
                        $('#createEditKegiatan').on('click', function() {
                            $('#detail-laporan').modal('hide');
                            $('#create-edit-kegiatan').modal('show').css('overflow-y', 'auto');
                        });
                        // pengeluaran
                        $('.createEditPengeluaran').on('click', function() {
                            $('#detail-laporan').modal('hide');
                            $('#create-edit-pengeluaran').modal('show').css('overflow-y', 'auto');
                        });
                        $('#nominal_pengeluaran').on('input', function(e) {
                            $('#nominal_pengeluaran').val(formatRupiah($('#nominal_pengeluaran').val(),
                                'Rp. '));
                        });
                        $('#senilai').on('input', function(e) {
                            $('#senilai').val(formatRupiah($('#senilai').val(),
                                'Rp. '));
                        });
                        // nota
                        $('#UploadLampiran').click(function() {
                            $("#customFileLampiran").html('').change();

                        });
                        $('#Lampiran2').click(function() {
                            $("#customFileLampiran").html('').change();

                        });
                    }

                    initSelectStationDrop();
                }
                loadContactDeviceSelect2();
                window.livewire.on('loadContactDeviceSelect2', () => {
                    loadContactDeviceSelect2();
                });

            });

            // Fungsi untuk menghide/menampilkan tab active
            function toggleCollapseButton() {
                // $('.collapse').collapse('hide');
                // $('#x1-tab').tab('show');
                // $('#berita-tab').tab('show');
                $('#acc2').collapse('show');
                $('#pencairan2').collapse('show');
                $('#penerimaManfaat').collapse('hide');
                $('#detailRencana').collapse('show');
                $('#tolakPencairan').collapse('hide');
                $('#pencairan').collapse('hide');
                $('#tolak').collapse('hide');
                $('#acc').collapse('hide');
                // detail-laporan
                $('#detailPenerimaManfaatLpj').collapse('show');


            }
            $('.toggleCollapseButton').click(function() {
                toggleCollapseButton();
            });

            window.addEventListener('create_rencana', event => {
                $('#create-edit-rencana').modal('hide');
                $('#detail-rencana').modal('show').css('overflow-y', 'auto');
                $('#acc2').collapse('show');
                $('#pencairan2').collapse('show');
                $('#penerimaManfaat').collapse('hide');
                $('#detailRencana').collapse('show');
                $('#tolakPencairan').collapse('hide');
                $('#pencairan').collapse('hide');
                $('#tolak').collapse('hide');
                $('#acc').collapse('hide');
            });
            window.addEventListener('edit_rencana', event => {
                $('#detail-rencana').modal('hide');
                $('#create-edit-rencana').modal('show').css('overflow-y', 'auto');
                // $('body').css("overflow", "hidden");

            });
            window.addEventListener('edit_penerima', event => {
                $('#edit-berita').modal('hide');
                $('#detail-laporan').modal('show').css('overflow-y', 'auto');

                $('#profile').addClass('show active'); // Aktifkan tab "profil"
                $('#home').removeClass('active'); // Hapus kelas "active" dari tab "home"
            });

            window.addEventListener('auto', event => {
                // $('body').css("overflow", "auto");
            });
            window.addEventListener('kirimNotif', event => {
                // $('body').css("overflow", "auto");
            });
            window.addEventListener('kegiatan', event => {
                $('#detail-laporan').modal('hide');
                $('#create-edit-kegiatan').modal('show').css('overflow-y', 'auto');
            });
            window.addEventListener('lampiran', event => {
                $('#detail-laporan').modal('hide');
                $('#lampiran').modal('show').css('overflow-y', 'auto');
                // $("#customFileLampiran").html('').change();
            });
            window.addEventListener('batalLampiran', event => {
                $('#lampiran').modal('hide');
                $('#detail-rencana').modal('show').css('overflow-y', 'auto');
            });
            window.addEventListener('batalLaporan', event => {
                $('#create-edit-penerima').modal('hide');
                $('#detail-rencana').modal('show').css('overflow-y', 'auto');
            });
            window.addEventListener('batalLampiran2', event => {
                $('#lampiran').modal('hide');
                $('#detail-laporan').modal('show').css('overflow-y', 'auto');
            });
            window.addEventListener('batalLaporan2', event => {
                $('#create-edit-penerima').modal('hide');
                $('#detail-laporan').modal('show').css('overflow-y', 'auto');
            });
            window.addEventListener('create_penerima', event => {
                $('#detail-rencana').modal('hide');
                $('#detail-laporan').modal('hide');
                $('#create-edit-penerima').modal('show').css('overflow-y', 'auto');
            });
            window.addEventListener('create_penerima2', event => {
                $('#create-edit-penerima').modal('hide');
                $('#detail-rencana').modal('show').css('overflow-y', 'auto');
            });
            window.addEventListener('create_penerima3', event => {
                $('#create-edit-penerima').modal('hide');
                $('#detail-laporan').modal('show').css('overflow-y', 'auto');
                $('#deletePenerima').collapse('hide');

            });
            window.addEventListener('openTabDokumentasi', event => {
                $('#create-edit-kegiatan').modal('hide');
                $('#detail-laporan').modal('show').css('overflow-y', 'auto');
                $('#dokumentasi-tab').tab('show');
            });
            window.addEventListener('openTabPengeluaran', event => {

                $('#create-edit-pengeluaran').modal('hide');
                $('#detail-laporan').modal('show').css('overflow-y', 'auto');
                $('#pengeluaran-tab').tab('show');
            });
            window.addEventListener('afterUploadPengajuan', event => {
                $('#b-tab').tab('show');
                $('#uploadPengajuan').collapse('hide');
            });
            window.addEventListener('afterUploadLampiranBerita', event => {
                $("#customFileBerita").html('').change();
                $('#create-lampiran-berita').modal('hide');
                $('#detail-laporan').modal('show').css('overflow-y', 'auto');
            });
            window.addEventListener('accTolakBerita', event => {
                $('#tolakBerita').collapse('hide');
                $('#accBerita').collapse('hide');
                $('#buttonAccTolakBerita').show();
            });
            // function accTolak(contentId) {
            //     $('.collapse').collapse('hide');
            //     $('#' + contentId).collapse('show');
            // }

            function createEditBerita() {
                $('#detail-laporan').modal('hide');
                $('#edit-berita').modal('show').css('overflow-y', 'auto');
            }

            function modalHapus() {
                // $('#detail-laporan').modal('hide');
                $('#detail-laporan').modal('show').css('overflow-y', 'auto');
            }


            function tolakPengajuan() {
                $('#tolak').collapse('show');
                $('#acc').collapse('hide');
            }

            function accPengajuan() {
                $('#tolak').collapse('hide');
                $('#acc').collapse('show');
            }

            function tolakPencairan() {
                $('#tolakPencairan').collapse('show');
                $('#pencairan').collapse('hide');
            }

            function accPencairan() {
                $('#tolakPencairan').collapse('hide');
                $('#pencairan').collapse('show');
            }

            function accBerita() {
                $('#tolakBerita').collapse('hide');
                $('#accBerita').collapse('show');
                $('#buttonAccTolakBerita').hide();
            }

            function tolakBerita() {
                // Mengubah teks pada elemen dengan ID "infoText"
                var spanElement = document.getElementById('infoText');
                if (spanElement) {
                    // Mengganti teks dan menambahkan kembali ikon
                    spanElement.innerHTML = '<i class="fas fa-info-circle mr-1"></i> LPJ & BA ditolak? Berikan catatan. ';
                }
                $('#tolakBerita').collapse('show');
                $('#accBerita').collapse('hide');
                $('#buttonAccTolakBerita').hide();
            }

            function batalBerita() {
                var spanElement = document.getElementById('infoText');
                if (spanElement) {
                    // Mengganti teks dan menambahkan kembali ikon
                    spanElement.innerHTML = '<i class="fas fa-info-circle mr-1"></i> Berita Acara Sudah Lengkap?';
                }

                var spanElement2 = document.getElementById('infoText2');
                if (spanElement2) {
                    // Mengganti teks dan menambahkan kembali ikon
                    spanElement2.innerHTML = '<i class="fas fa-info-circle mr-1"></i> Respon Ulang?';
                }

                $('#tolakBerita').collapse('hide');
                $('#accBerita').collapse('hide');
                $('#buttonAccTolakBerita').show();
            }

            function tambahLampiranBerita() {
                $('#detail-laporan').modal('hide');
                $('#create-lampiran-berita').modal('show').css('overflow-y', 'auto');
            }

            function batalLampiranBerita() {
                $('#create-lampiran-berita').modal('hide');
                $('#detail-laporan').modal('show').css('overflow-y', 'auto');
                $("#customFileLampiranBerita").html('').change();
                $("#customFileLampiran").html('').change();

            }

            // Cari collapse berdasarkan ID dan tutup
            Livewire.on('acc', function() {
                var collapseElement = document.getElementById('acc');
                if (collapseElement) {
                    collapseElement.classList.remove('show');
                }
            });
            Livewire.on('tolak', function() {
                var collapseElement = document.getElementById('tolak');
                if (collapseElement) {
                    collapseElement.classList.remove('show');
                }
            });

            Livewire.on('pencairan', function() {
                var collapseElement = document.getElementById('pencairan');
                if (collapseElement) {
                    $('#tolakPencairan').collapse('hide');

                    collapseElement.classList.remove('show');
                }
            });
            Livewire.on('showUploadFotoDokumentasi', function() {
                var collapseElement = document.getElementById('showUploadFotoDokumentasi');
                if (collapseElement) {
                    collapseElement.classList.remove('show');
                }
            });

            // Tambahkan event listener untuk mengubah ikon saat elemen collapse ditampilkan/sembunyikan


            $('#detailRencana').on('show.bs.collapse', function() {
                $('#toggleRencana .fa-sort-down').removeClass('fa-sort-down').addClass('fa-sort-up');
            });

            $('#detailRencana').on('hide.bs.collapse', function() {
                $('#toggleRencana .fa-sort-up').removeClass('fa-sort-up').addClass('fa-sort-down');
            });

            $('#penerimaManfaat').on('show.bs.collapse', function() {
                $('#togglePenerima .fa-sort-down').removeClass('fa-sort-down').addClass('fa-sort-up');
            });

            $('#penerimaManfaat').on('hide.bs.collapse', function() {
                $('#togglePenerima .fa-sort-up').removeClass('fa-sort-up').addClass('fa-sort-down');
            });

            $('#acc2').on('show.bs.collapse', function() {
                $('#togglePersetujuan .fa-sort-down').removeClass('fa-sort-down').addClass('fa-sort-up');
            });

            $('#acc2').on('hide.bs.collapse', function() {
                $('#togglePersetujuan .fa-sort-up').removeClass('fa-sort-up').addClass('fa-sort-down');
            });


            $('#pencairan2').on('show.bs.collapse', function() {
                $('#togglePencairan .fa-sort-down').removeClass('fa-sort-down').addClass('fa-sort-up');
            });

            $('#pencairan2').on('hide.bs.collapse', function() {
                $('#togglePencairan .fa-sort-up').removeClass('fa-sort-up').addClass('fa-sort-down');
            });
        </script>
    @endpush
</div>
