@if (Auth::user()->gocap_id_pc_pengurus != null)
    {{--  tambah program_penguatan_kelembagaan --}}
    <div wire:ignore.self class="modal fade" id="modal_ubah_internal" data-backdrop="static" tabindex="-1"
        data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> UBAH PENGAJUAN INTERNAL
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
                <form wire:submit.prevent="ubah_internal_pc">

                    {{-- modal body --}}
                    <div class="modal-body">
                        <div class="form-row">

                            {{-- nomor pengajuan --}}
                            <div class="form-group col-md-6 intro-nomor_pengjuanz">
                                <label for="inputNama">NOMOR PENGAJUAN &nbsp;</label>
                                <input wire:model="nomor_surat_edit" type="text" class="form-control" value=""
                                    readonly>
                            </div>
                            {{-- end nomor pengajuan --}}

                            {{-- yang mengajukan --}}
                            <div class="form-group col-md-6 intro-yang_pengjuanz">
                                <label for="inputNama">PEMOHON &nbsp;</label>
                                <input wire:model="pemohon_edit" type="text" class="form-control"
                                    value="{{ $pemohon_edit }}" readonly>
                                <input type="hidden" wire:model="maker_tingkat_pc" value="{{ $maker_tingkat_pc }}">
                            </div>
                            {{-- end yang mengajukan --}}

                            {{--  tenggat pencairan --}}
                            <div class="form-group col-md-6 intro-tgl_pengjuanz">
                                <label for="inputNama">TGL PENGAJUAN&nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                {{-- <input wire:model="tgl_pengajuan" type="date" class="form-control" readonly> --}}
                                <input wire:model="tgl_pengajuan_edit" type="date" class="form-control">
                            </div>
                            {{-- end tenggat pencairan --}}

                            {{--  tenggat pencairan --}}
                            <div class="form-group col-md-6 intro-tenggat_pengjuanz">
                                <label for="inputNama">TGL TENGGAT PENCAIRAN&nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <input wire:model="tgl_tenggat_edit" type="date" class="form-control">
                            </div>
                            {{-- end tenggat pencairan --}}

                            {{-- tujuan pengajuan --}}
                            <div class="form-group col-md-6 intro-dana_pengjuanz">
                                <label for="inputNama">MOHON DANA DIKELUARKAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <select wire:model="bentuk_dana_edit" class="form-control">
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
                                    <input wire:model="nominal_pengajuan_edit" id="nominal_pengajuan" type="text"
                                        class="form-control" placeholder="Masukan Jumlah Dana">
                                </div>
                            </div>
                            {{-- end PENCAIRAN --}}

                            {{-- tujuan pengajuan --}}
                            <div class="form-group col-md-6 intro-tujuan_pengjuanz">
                                <label for="inputNama">TUJUAN PENGAJUAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <select wire:model="tujuan_edit" class="form-control">
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
                                <input wire:model.debounce.500ms="atas_nama_edit" type="text" class="form-control"
                                    placeholder="Masukan Nama">
                            </div>
                            {{-- end atas nama --}}

                            @if ($this->bentuk_dana_edit == 'Cash')
                                {{-- bank tujuan --}}
                                <div class="form-group col-md-6">
                                    <label for="inputTempat">BANK TUJUAN &nbsp;</label>
                                    <span style="color:rgba(230, 82, 82)">*</span>
                                    <input wire:model.debounce.500ms="bank_tujuan_edit" type="text"
                                        class="form-control" placeholder="-" disabled>
                                </div>
                                {{-- end bank tujuan --}}

                                {{-- nomor rekening tujuan --}}
                                <div class="form-group col-md-6">
                                    <label for="inputTempat">NO.REK TUJUAN &nbsp;</label>
                                    <span style="color:rgba(230, 82, 82)">*</span>
                                    <input wire:model.debounce.500ms="no_rek_tujuan_edit" type="text"
                                        class="form-control" placeholder="-" disabled>
                                </div>
                                {{-- end norek --}}
                            @else
                                <div class="form-group col-md-6">
                                    <label for="inputTempat">BANK TUJUAN &nbsp;</label>
                                    <span style="color:rgba(230, 82, 82)">*</span>
                                    <input wire:model.debounce.500ms="bank_tujuan_edit" type="text"
                                        class="form-control" placeholder="Masukan Bank Tujuan">
                                </div>
                                {{-- end bank tujuan --}}

                                {{-- nomor rekening tujuan --}}
                                <div class="form-group col-md-6">
                                    <label for="inputTempat">NO.REK TUJUAN &nbsp;</label>
                                    <span style="color:rgba(230, 82, 82)">*</span>
                                    <input wire:model.debounce.500ms="no_rek_tujuan_edit" type="text"
                                        class="form-control" placeholder="Masukan Nomor Rekening">
                                </div>
                            @endif

                            {{-- keterangan --}}
                            <div class="form-group col-md-12 intro-keterangan_pengjuanz">
                                <label for="inputAlamat">KETERANGAN PPD &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <textarea type="text" class="form-control " wire:model="keterangan_ppd_edit"
                                    placeholder="Mendesak / Segera / Lainnya" rows="2"></textarea>
                            </div>

                            <div class="form-group col-md-12 intro-keterangan_pengjuanz">
                                <label for="inputAlamat">KETERANGAN PENGAJUAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <textarea type="text" class="form-control " wire:model="note_edit" placeholder="Masukan keterangan"
                                    rows="3"></textarea>
                            </div>
                            {{-- keterangan --}}

                        </div>
                    </div>
                    {{-- end modal body --}}

                    {{-- footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-ban"></i>
                            Batal</button>

                        <button type="submit" name="submit" class="btn btn-success"
                            wire:loading.attr="disabled"><i class="fas fa-save"></i>
                            Simpan Perubahan</button>

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

                        $('#nominal_pengajuan_edit').on('input', function(e) {
                            $('#nominal_pengajuan_edit').val(formatRupiah($('#nominal_pengajuan_edit').val(),
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
