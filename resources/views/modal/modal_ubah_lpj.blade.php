   {{--  tambah pilar --}}
   <div wire:ignore.self class="modal fade" id="modal_ubah_lpj" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">UBAH PENGGUNAAN DANA
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form wire:submit.prevent="ubah_internal_penggunaan_dana">
                   <div class="modal-body">
                       <div class="form-row">

                        {{-- <div class="form-group col-md-6 intro-tgl_pengjuanz">
                            <label for="inputNama">TGL INPUT&nbsp;</label>
                            <span style="color:rgba(230, 82, 82)">*</span>
                            <input wire:model="tgl_input_edit" type="date" class="form-control">
                        </div> --}}
                        <div class="form-group col-md-6 intro-tgl_pengjuanz">
                            <label for="inputNama">TGL PENGGUNAAN DANA&nbsp;</label>
                            <span style="color:rgba(230, 82, 82)">*</span>
                            <input wire:model="tgl_penggunaan_dana_edit" type="date" class="form-control">
                        </div>
                        <div class="form-group col-md-6 intro-tgl_pengjuanz">
                            <label for="inputTempat">DIBAYARKAN KEPADA &nbsp;</label>
                            <span style="color:rgba(230, 82, 82)">*</span>
                            <input wire:model="dibayarkan_kepada_edit" type="text" class="form-control"
                                placeholder="Masukan dibayarkan kepada">
                        </div>
                        <div class="form-group col-md-6 modal-ubah-asnaf-pilar">
                            <label for="inputNama">OPSI DANA &nbsp;</label>
                            <select wire:model="opsi_dana_edit" class="form-control">
                                <option value="">Pilih Opsi Dana</option>
                                <option value="Penggunaan Dana">Penggunaan Dana</option>
                                <option value="Pengembalian Dana">Pengembalian Dana</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 modal-ubah-asnaf-pilar">
                            <label for="inputTempat">NOMINAL &nbsp;</label>
                            <span style="color:rgba(230, 82, 82)">*</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input wire:model="nominal_edit" id="nominal" type="text"
                                    class="form-control" placeholder="Masukan nominal">
                            </div>
                        </div>
                        <div class="form-group col-md-6 intro-dibayarkan">
                            <label for="inputHP">NOTA/KWITANSI</label>
                            <span style="color:rgba(230, 82, 82)">*</span>
                            <div class="custom-file custom-file-lampiran">
                                <input type="file" wire:model="nota"
                                    accept="application/pdf, image/png, image/jpg, image/jpeg" class="custom-file-input"
                                    id="file" name="nota">
                                <label class="custom-file-label" for="customFile">Pilih
                                    file</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6 intro-dibayarkan">
                            <label for="inputHP">FOTO BARANG/KEGIATAN</label>
                            <span style="color:rgba(230, 82, 82)">*</span>
                            <div class="custom-file custom-file-lampiran">
                                <input type="file" wire:model="foto_kegiatan"
                                    accept="application/pdf, image/png, image/jpg, image/jpeg" class="custom-file-input"
                                    id="file" name="foto_kegiatan">
                                <label class="custom-file-label" for="customFile">Pilih
                                    file</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12 intro-keterangan">
                            <label for="inputAlamat">KETERANGAN &nbsp;</label>
                            <span style="color:rgba(230, 82, 82)">*</span>
                            <textarea type="text" class="form-control " wire:model="keterangan_edit" placeholder="Masukan keterangan penggunaan dana"
                                rows="2"></textarea>
                        </div>
                        
                       </div>
                   </div>

                   {{-- footer --}}
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                           Batal</button>
                       @if ($tgl_penggunaan_dana_edit == '')
                           <button class="btn btn-success" disabled wire:loading.attr="disabled"><i
                                   class="fas fa-save"></i>
                               Simpan</button>
                       @else
                           <button type="submit" name="submit" class="btn btn-success" wire:loading.attr="disabled"><i
                                   class="fas fa-save"></i>
                               Simpan</button>
                       @endif
                   </div>
                   {{-- endfooter --}}
               </form>
           </div>
       </div>

       @push('script')
            <script>
                $(document).ready(function() {

                    window.loadContactDeviceSelect2 = () => {

                        $('#nominal_edit').on('input', function(e) {
                            $('#nominal_edit').val(formatRupiah($('#nominal_edit').val(),
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
   {{-- end tambah pilar --}}
