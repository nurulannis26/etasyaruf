<div class="modal fade" id="tambah-pengajuan-upzis" data-backdrop="static" tabindex="-1" data-keyboard="false"
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

                        <input type="hidden" name="tingkat" value="Upzis MWCNU">
                        <input type="hidden" name="pj_ranting" value="">
                        {{-- upzis --}}
                        <div class="form-group col-md-4">
                            <label for="inputNama">UPZIS MWCNU &nbsp;</label>
                            <input type="text" class="form-control"
                                value="{{ Auth::user()->UpzisPengurus->Upzis->Wilayah->nama }}" readonly>
                        </div>

                        {{-- nomor pengajuan --}}
                        <div class="form-group col-md-8">
                            <label for="inputNama">NOMOR PENGAJUAN &nbsp;</label>
                            <input type="text" class="form-control" name="nomor_surat"
                                value="{{ app\Http\Controllers\PengajuanController::getNomorPengajuan('upzis', $id_upzis) }}"
                                readonly>
                        </div>

                        {{-- TGL INPUT --}}
                        <div class="form-group col-md-4">
                            <label for="inputNama">TGL INPUT &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color: rgba(230,82,82)">WAJIB</sup>
                            <input type="date" class="form-control" name="tgl_pengajuan" id="tgl_pengajuan" readonly
                                value="{{ date('Y-m-d') }}">
                        </div>


                        {{-- pj pengambilan dana --}}
                        <div class="form-group col-md-8">
                            <label for="inputNama">PJ PENGAMBILAN DANA&nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <select class="form-control" name="pj_upzis" id="select2PjUpzis">
                                <option value="" selected>Pilih Pengurus</option>
                                @foreach (app\Http\Controllers\PengajuanController::getDaftarPengurus('upzis', $id_upzis) as $a)
                                    <option value="{{ $a->id_upzis_pengurus }}">{{ $a->jabatan . ' - ' . $a->nama }}
                                    </option>
                                @endforeach
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
                    <button type="submit" class="btn btn-success hover" id="tombol_tambah"><i class="fas fa-save"></i>
                        Tambah</button>
                </div>

            </form>
            {{-- end form --}}

        </div>
    </div>
</div>

@push('script')
    <script>
        // Mendapatkan elemen input tanggal pengajuan
        var inputTglPengajuan = document.getElementById('tgl_pengajuan');

        // Mendapatkan elemen select PJ UPZIS
        var selectPjUpzis = document.getElementById('select2PjUpzis');

        // Mendapatkan elemen tombol tambah
        var tombolTambah = document.getElementById('tombol_tambah');

        // Menonaktifkan tombol tambah saat halaman dimuat
        tombolTambah.disabled = true;

        // Membuat event listener untuk memeriksa perubahan pada input tanggal pengajuan dan select PJ UPZIS
        inputTglPengajuan.addEventListener('change', checkFormValidity);
        selectPjUpzis.addEventListener('change', checkFormValidity);

        function checkFormValidity() {
            // Memeriksa apakah nilai input tanggal pengajuan dan select PJ UPZIS sudah diisi
            if (inputTglPengajuan.value !== '' && selectPjUpzis.value !== '') {
                // Jika input tanggal pengajuan dan select PJ UPZIS diisi, tombol tambah akan diaktifkan
                tombolTambah.disabled = false;
            } else {
                // Jika salah satu atau keduanya kosong, tombol tambah akan tetap dinonaktifkan
                tombolTambah.disabled = true;
            }
        }

        $(document).ready(function() {
            // Menginisialisasi Select2 setelah halaman dimuat sepenuhnya
            $('#select2PjUpzis').select2();

            // Menambahkan event listener pada Select2 untuk memeriksa perubahan pada input tanggal pengajuan dan select PJ UPZIS
            $('#select2PjUpzis').on('change', checkFormValidity);
        });
    </script>
@endpush
