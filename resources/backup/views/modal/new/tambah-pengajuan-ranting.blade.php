<div class="modal fade" id="tambah-pengajuan-ranting" data-backdrop="static" data-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title"> TAMBAH PERMOHONAN PENTASYARUFAN
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- form --}}
            <form action="/{{ $role }}/tambah-pengajuan" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">

                        <input type="hidden" name="tingkat" value="Ranting NU">
                        <input type="hidden" name="pj_upzis" value="">
                        {{-- upzis --}}
                        <div class="form-group col-md-4">
                            <label for="inputNama">RANTING NU &nbsp;</label>
                            <select class="form-control" name="id_ranting2" id="select2Ranting3">
                                <option value="" {{ $id_ranting2 == null ? 'selected' : '' }}>Pilih Ranting
                                </option>
                                @foreach ($daftar_ranting2 as $a)
                                    <option value="{{ $a->id_ranting }}"
                                        {{ $id_ranting2 == $a->id_ranting ? 'selected' : '' }}>
                                        {{ $a->nama }}
                                        ({{ $a->id_wilayah }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- nomor pengajuan --}}
                        <div class="form-group col-md-8">
                            <label for="inputNama">NOMOR PENGAJUAN &nbsp;</label>
                            <input type="text" class="form-control" name="nomor_surat" id="NomorPengajuanRanting"
                                value="" readonly>
                        </div>

                        {{-- TGL INPUT --}}
                        <div class="form-group col-md-4">
                            <label for="inputNama">TGL INPUT &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color: rgba(230,82,82)">WAJIB</sup>
                            <input type="date" class="form-control" name="tgl_pengajuan" id="tgl_pengajuan2" readonly
                                value="{{ date('Y-m-d') }}">
                        </div>


                        {{-- pj pengambilan dana --}}
                        <div class="form-group col-md-8">
                            <label for="inputNama">PJ PENGAMBILAN DANA&nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <select class="form-control" name="pj_ranting" id="select2PjRanting">
                                <option value="" selected>Pilih Ranting Terlebih Dahulu</option>
                            </select>
                        </div>

                        {{-- info --}}
                        <div class="card card-body m-2" style="background-color:#cbf2d6;">
                            <b>INFORMASI!</b>
                            <span>
                                Setelah berhasil menambahkan pengajuan pentasyarufan, anda wajib melengkapi data
                                rencana
                                program & daftar penerima manfaat
                            </span>
                        </div>

                    </div>
                </div>

                {{-- footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary hover" data-dismiss="modal"><i
                            class="fas fa-ban"></i>
                        Batal</button>
                    <button type="submit" class="btn btn-success hover" id="tombol_tambah2"><i class="fas fa-save"></i>
                        Tambah</button>
                </div>

            </form>
            {{-- end form --}}

        </div>
    </div>
</div>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function() {
            // Menginisialisasi Select2 setelah halaman dimuat sepenuhnya
            $('#select2PjRanting').select2();
            $('#select2Ranting3').select2();
            // Menambahkan event listener pada Select2 untuk memeriksa perubahan pada input tanggal pengajuan dan select PJ UPZIS
            $('#select2PjRanting').on('change', checkFormValidity2);

            var inputNomorPengajuan = $('#NomorPengajuanRanting');
            inputNomorPengajuan.val('-');
        });
        $(document).ready(function() {

            // PjRantingByRanting
            $('#select2Ranting3').on('change', function() {
                var selectedRanting = $(this).val();
                var selectPj = $('#select2PjRanting');

                // Hapus semua opsi saat ini dalam elemen select PJ
                selectPj.empty();

                if (selectedRanting === null || selectedRanting === '') {
                    // Jika nilai selectedRanting adalah null atau kosong, tambahkan opsi "Harap pilih ranting!"
                    var defaultOption = new Option('Pilih Ranting Terlebih Dahulu', '');
                    selectPj.append(defaultOption);
                } else {
                    var defaultOption = new Option('Pilih Pengurus', '');
                    selectPj.append(defaultOption);
                    // Kirim permintaan AJAX ke server untuk mendapatkan data PJ berdasarkan ranting yang dipilih
                    axios
                        .post('/get-pj-by-ranting', {
                            rantingId: selectedRanting
                        })
                        .then(function(response) {
                            // Tambahkan opsi baru ke elemen select PJ berdasarkan data PJ yang diterima dari server
                            $.each(response.data, function(index, pj) {
                                var option = new Option(pj.jabatan + ' - ' + pj.nama, pj
                                    .id_ranting_pengurus);
                                selectPj.append(option);
                            });
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
                // Perbarui tampilan Select2 pada elemen select PJ
                selectPj.trigger('change');
            });

            // NomorPengajuanByRanting
            $('#select2Ranting3').on('change', function() {
                var selectedRanting = $(this).val();
                var inputNomorPengajuan = $('#NomorPengajuanRanting');

                if (selectedRanting === null || selectedRanting === '') {
                    // Jika nilai selectedRanting adalah null atau kosong, kosongkan nilai input NOMOR PENGAJUAN
                    inputNomorPengajuan.val('Pilih Ranting Terlebih Dahulu');
                } else {
                    // Kirim permintaan AJAX ke server untuk mendapatkan nomor pengajuan berdasarkan pilihan ranting yang dipilih
                    axios.post('/get-nomor-pengajuan', {
                            rantingId: selectedRanting,
                            upzisId: '{{ $id_upzis }}'
                        })
                        .then(function(response) {
                            var nomorPengajuan = response.data;

                            // Atur nilai input NOMOR PENGAJUAN sesuai dengan nomor pengajuan yang diterima dari server
                            inputNomorPengajuan.val(nomorPengajuan);
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                }
            });

        });
    </script>

    <!-- ... (Previous HTML code) ... -->

    <script>
        // Mendapatkan elemen input tanggal pengajuan
        // var inputTglPengajuan2 = document.getElementById('tgl_pengajuan2');

        // Mendapatkan elemen select PJ UPZIS
        var selectPjRanting = document.getElementById('select2PjRanting');
        var selectRanting = document.getElementById('select2Ranting3');

        // Mendapatkan elemen tombol tambah
        var tombolTambah2 = document.getElementById('tombol_tambah2');

        // Menonaktifkan tombol tambah saat halaman dimuat
        tombolTambah2.disabled = true;

        // Membuat event listener untuk memeriksa perubahan pada input tanggal pengajuan dan select PJ UPZIS
        // inputTglPengajuan2.addEventListener('change', checkFormValidity2);
        selectPjRanting.addEventListener('change', checkFormValidity2);

        // Membuat event listener untuk memeriksa perubahan pada select RANTING NU menggunakan Select2
        $(document).ready(function() {
            $('#select2Ranting3').on('select2:select', function() {
                // Set tanggal pengajuan menjadi null ketika ada perubahan di selectRanting
                // inputTglPengajuan2.value = '';
                checkFormValidity2();
            });
        });

        function checkFormValidity2() {
            // Memeriksa apakah nilai input tanggal pengajuan dan select PJ UPZIS sudah diisi
            if (selectPjRanting.value !== '' && selectRanting.value !== '') {
                // Jika input tanggal pengajuan dan select PJ UPZIS diisi, tombol tambah akan diaktifkan
                tombolTambah2.disabled = false;
            } else {
                // Jika salah satu atau keduanya kosong, tombol tambah akan tetap dinonaktifkan
                tombolTambah2.disabled = true;
            }
        }
    </script>

    {{-- dynamic option --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
@endpush
