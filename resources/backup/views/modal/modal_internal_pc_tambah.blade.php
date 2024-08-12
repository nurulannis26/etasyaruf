@if (Auth::user()->gocap_id_pc_pengurus != null)
    {{--  tambah program_penguatan_kelembagaan --}}
    <div wire:ignore.self class="modal fade" id="modal_internal_pc_tambah" data-backdrop="static" tabindex="-1"
        data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> TAMBAH PENGAJUAN INTERNAL
                    </h5>
                    <div>
                        {{-- <a style="color: blue; font-size:18px;" class="d-inline btn"
                            id="modal_pengajuan_internal_panduan">
                            PANDUAN </a> --}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                {{-- form --}}
                <form wire:submit.prevent="tambah_internal_pc">

                    {{-- modal body --}}
                    <div class="modal-body">
                        <div class="form-row">

                            {{-- nomor pengajuan --}}
                            <div class="form-group col-md-6 intro-nomor_pengjuanz   ">
                                <label for="inputNama">NOMOR PENGAJUAN &nbsp;</label>
                                <input type="text" class="form-control" value="{{ $nomor_surat }}" readonly>
                            </div>
                            {{-- end nomor pengajuan --}}

                            {{-- yang mengajukan --}}
                            <div class="form-group col-md-6 intro-yang_pengjuanz">
                                <label for="inputNama">PEMOHON &nbsp;</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->nama }} - ({{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }})"
                                    readonly>
                            </div>
                            {{-- end yang mengajukan --}}


                            {{--  tenggat pencairan --}}
                            <div class="form-group col-md-6 intro-tgl_pengjuanz">
                                <label for="inputNama">TGL PENGAJUAN&nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                {{-- <input wire:model="tgl_pengajuan" type="date" class="form-control" readonly> --}}
                                <input wire:model="tgl_pengajuan" type="date" class="form-control">
                            </div>
                            {{-- end tenggat pencairan --}}

                            {{--  tenggat pencairan --}}
                            <div class="form-group col-md-6 intro-tenggat_pengjuanz">
                                <label for="inputNama">TGL TENGGAT PENCAIRAN&nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <input wire:model="tgl_tenggat" type="date" class="form-control">
                            </div>
                            {{-- end tenggat pencairan --}}

                            {{-- tujuan pengajuan --}}
                            <div class="form-group col-md-6 intro-dana_pengjuanz">
                                <label for="inputNama">MOHON DANA DIKELUARKAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <select wire:model="bentuk" class="form-control">
                                    <option value="">Pilih Bentuk Pengeluaran Dana</option>
                                    <option value="Cash">Tunai</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                            </div>
                            {{-- end tujuan pengajuan --}}


                            {{-- nama PENCAIRAN --}}
                            <div class="form-group col-md-6 intro-dana_pengjuanz">
                                <label for="inputNama">JUMLAH DANA &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu">Rp</span>
                                    </div>
                                    <input wire:model="nominal_pengajuan" id="nominal_pengajuan" type="text"
                                        class="form-control" placeholder="Masukan Jumlah Dana">
                                </div>
                            </div>
                            {{-- end PENCAIRAN --}}

                            {{-- @if ($this->bentuk == 'Transfer') --}}
                            {{-- atas nama --}}


                            {{-- tujuan pengajuan --}}
                            <div class="form-group col-md-6 intro-tujuan_pengjuanz">
                                <label for="inputNama">TUJUAN PENGAJUAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <select wire:model="tujuan" class="form-control">
                                    <option value="">Pilih Tujuan Pengajuan</option>
                                    <option value="Uang Muka">Uang Muka</option>
                                    <option value="Reimbursement">Reimbursement</option>
                                    <option value="Pembayaran">Pembayaran</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            {{-- end tujuan pengajuan --}}

                            <div class="form-group col-md-6 intro-tujuan_pengjuanz">
                                <label for="inputTempat">DIBAYARKAN KEPADA &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <input wire:model.debounce.500ms="atas_nama" type="text" class="form-control"
                                    placeholder="Masukan Nama">
                            </div>
                            {{-- end atas nama --}}

                            @if ($this->bentuk == 'Cash')
                                {{-- bank tujuan --}}
                                <div class="form-group col-md-6">
                                    <label for="inputTempat">BANK TUJUAN &nbsp;</label>
                                    <span style="color:rgba(230, 82, 82)">*</span>
                                    <input wire:model.debounce.500ms="bank_tujuan" type="text" class="form-control"
                                        placeholder="-" disabled>
                                </div>
                                {{-- end bank tujuan --}}

                                {{-- nomor rekening tujuan --}}
                                <div class="form-group col-md-6">
                                    <label for="inputTempat">NO.REK TUJUAN &nbsp;</label>
                                    <span style="color:rgba(230, 82, 82)">*</span>
                                    <input wire:model.debounce.500ms="no_rek_tujuan" type="text" class="form-control"
                                        placeholder="-" disabled>
                                </div>
                                {{-- end norek --}}
                            @else
                                <div class="form-group col-md-6">
                                    <label for="inputTempat">BANK TUJUAN &nbsp;</label>
                                    <span style="color:rgba(230, 82, 82)">*</span>
                                    <input wire:model.debounce.500ms="bank_tujuan" type="text" class="form-control"
                                        placeholder="Masukan Bank Tujuan">
                                </div>
                                {{-- end bank tujuan --}}

                                {{-- nomor rekening tujuan --}}
                                <div class="form-group col-md-6">
                                    <label for="inputTempat">NO.REK TUJUAN &nbsp;</label>
                                    <span style="color:rgba(230, 82, 82)">*</span>
                                    <input wire:model.debounce.500ms="no_rek_tujuan" type="text"
                                        class="form-control" placeholder="Masukan Nomor Rekening">
                                </div>
                            @endif








                            {{-- keterangan --}}
                            <div class="form-group col-md-12 intro-keterangan_pengjuanz">
                                <label for="inputAlamat">KETERANGAN PPD &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <textarea type="text" class="form-control " wire:model="keterangan_ppd" placeholder="Mendesak / Segera / Lainnya"
                                    rows="2"></textarea>
                            </div>

                            <div class="form-group col-md-12 intro-keterangan_pengjuanz">
                                <label for="inputAlamat">KETERANGAN PENGAJUAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <textarea type="text" class="form-control " wire:model="note" placeholder="Masukan keterangan" rows="3"></textarea>
                            </div>
                            {{-- keterangan --}}


                            {{-- info --}}
                            <div class="card card-body " style="background-color:#cbf2d6;">
                                <b>INFORMASI!</b>
                                <span>
                                    Setelah pengajuan tersimpan, tambahkan lampiran pengajuan jika ada
                                    (nota/kwitansi/invoice)
                                </span>
                            </div>
                            {{-- end info --}}

                        </div>
                    </div>
                    {{-- end modal body --}}

                    {{-- footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary intro-batal_pengjuanz"
                            data-dismiss="modal"><i class="fas fa-ban"></i>
                            Batal</button>

                        @if ($this->bentuk == 'Cash')
                            @if ($nominal_pengajuan == '' or $tgl_tenggat == '' or $tujuan == '' or $note == '' or $bentuk == '' or $atas_nama == '')
                                <button class="btn btn-success" disabled wire:loading.attr="disabled"><i
                                        class="fas fa-save"></i>
                                    Simpan</button>
                            @else
                                <button type="submit" name="submit" class="btn btn-success"
                                    wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                    Simpan</button>
                            @endif
                        @else
                            @if (
                                $nominal_pengajuan == '' or
                                    $tgl_tenggat == '' or
                                    $tujuan == '' or
                                    $note == '' or
                                    $bentuk == '' or
                                    $atas_nama == '' or
                                    $bank_tujuan == '' or
                                    $no_rek_tujuan == '')
                                <button class="btn btn-success" disabled wire:loading.attr="disabled"><i
                                        class="fas fa-save"></i>
                                    Simpan</button>
                            @else
                                <button type="submit" name="submit" class="btn btn-success"
                                    wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                    Simpan</button>
                            @endif
                        @endif

                    </div>
                    {{-- endfooter --}}

                </form>
                {{-- end form --}}

            </div>
        </div>

        @push('script')
            <script>
                $(document).ready(function() {

                    window.loadContactDeviceSelect2 = () => {

                        $('#nominal_pengajuan').on('input', function(e) {
                            $('#nominal_pengajuan').val(formatRupiah($('#nominal_pengajuan').val(),
                                'Rp. '));
                        });
                    }

                    loadContactDeviceSelect2();
                    window.livewire.on('loadContactDeviceSelect2', () => {
                        loadContactDeviceSelect2();
                    });

                });
            </script>
        @endpush
    </div>
    {{-- end tambah program_penguatan_kelembagaan --}}
@endif

<script>
    var yesoy = document.getElementById("modal_pengajuan_internal_panduan");
    yesoy.onclick = function() {
        introJs().setOptions({
            steps: [{
                    element: document.querySelector('.intro-nomor_pengjuanz'),
                    title: 'Nomor Pengajuan',
                    intro: 'Nomor Pengajuan digenerate otomatis berdasarkan pengajuan internal sebelumnya'
                },
                {
                    element: document.querySelector('.intro-yang_pengjuanz'),
                    title: 'Yang Mengajukan',
                    intro: 'Sesuai dengan pengguna yang login ke sistem'
                },
                {
                    element: document.querySelector('.intro-tgl_pengjuanz'),
                    title: 'Tanggal Pengajuan',
                    intro: 'Tanggal pengajuan internal secara default hari ini'
                },
                {
                    element: document.querySelector('.intro-tenggat_pengjuanz'),
                    title: 'Tanggal Tenggat Pencairan',
                    intro: 'Masukan tanggal tenggat untuk pencairan dana pengajuan internal'
                },
                {
                    element: document.querySelector('.intro-nominal_pengjuanz'),
                    title: 'Nominal Pengajuan',
                    intro: 'Masukan nominal pengajuan yang akan diajukan di pengajuan internal'
                },

                {
                    element: document.querySelector('.intro-tujuan_pengjuanz'),
                    title: 'Tujuan',
                    intro: 'Masukan tujuan dilakukannya pengajuan internal (Uang Muka/Reimbursement/Pembayaran/Lainnya)'
                },
                {
                    element: document.querySelector('.intro-bentuk_pengjuanz'),
                    title: 'Bentuk Pencairan',
                    intro: 'Masukan bentuk pencairan dana yang akan dicairkan (Transfer/Cash)'
                },
                {
                    element: document.querySelector('.intro-keterangan_pengjuanz'),
                    title: 'Keterangan',
                    intro: 'Masukan keterangan mengenai pengajuan internal yang diajukan'
                },
                {
                    element: document.querySelector('.intro-batal_pengjuanz'),
                    title: 'Batal',
                    intro: 'Klik untuk membatalkan pengajuan internal'
                },
                {
                    element: document.querySelector('.intro-done_pengjuanz'),
                    title: 'Simpan',
                    intro: 'Jika semua data sudah terisi dengan benar, klik simpan untuk menyimpan data'
                },
            ]
        }).start();
    }
</script>
