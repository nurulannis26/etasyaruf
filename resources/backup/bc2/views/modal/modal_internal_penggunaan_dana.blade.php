   {{--  tambah pilar --}}
   <div wire:ignore.self class="modal fade" id="modal_internal_penggunaan_dana" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">TAMBAH PENGGUNAAN DANA
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               {{-- @if (str_replace('.', '', $nominal_pencairan2) > str_replace('.', '', $saldo))
                            <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                <i class="fas fa-minus-circle"></i>
                                Saldo Tidak Cukup!
                            </div>
                        @endif --}}
               @if (str_replace('.', '', $nominal) > str_replace('.', '', $data->nominal_pencairan))
                   <div class="alert alert-warning alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
                       <i class="fas fa-minus-circle"></i>
                       Nominal yang dimasukkan melebihi jumlah nominal pencairan
                   </div>
               @endif
               @if ($sisa_dana != $data->nominal_pencairan)
                   @if (str_replace('.', '', $nominal) > str_replace('.', '', $sisa_dana))
                       <div class="alert alert-warning alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
                           <i class="fas fa-minus-circle"></i>
                           Nominal melebihi sisa dana, berikan catatan untuk Div. Keuangan
                       </div>
                   @endif
               @endif

               <form wire:submit.prevent="tambah_internal_penggunaan_dana">
                   <div class="modal-body">
                       <div class="form-row">
                           <div class="form-group col-md-6 intro-tgl_pengjuanz">
                               <label for="inputNama">TGL PENGGUNAAN DANA&nbsp;</label>
                               <span style="color:rgba(230, 82, 82)">*</span>
                               <input wire:model="tgl_penggunaan_dana" type="date" class="form-control">
                           </div>
                           <div class="form-group col-md-6 intro-tgl_pengjuanz">
                               <label for="inputTempat">DIBAYARKAN KEPADA &nbsp;</label>
                               <span style="color:rgba(230, 82, 82)">*</span>
                               <input wire:model="dibayarkan_kepada" type="text" class="form-control"
                                   placeholder="Masukan dibayarkan kepada">
                           </div>
                           <div class="form-group col-md-6 intro-dibayarkan">
                               <label for="inputTempat">NOMINAL &nbsp;</label>
                               <span style="color:rgba(230, 82, 82)">*</span>
                               <div class="input-group">
                                   <div class="input-group-prepend">
                                       <span class="input-group-text bor-abu">Rp</span>
                                   </div>
                                   <input wire:model="nominal" id="nominal" type="text" class="form-control"
                                       placeholder="Masukan nominal">
                               </div>
                           </div>
                           <div class="form-group col-md-6 intro-dibayarkan">
                               <label for="inputHP">NOTA/KWITANSI</label>
                               <span style="color:rgba(230, 82, 82)">*</span>
                               <div class="custom-file custom-file-lampiran">
                                   <input type="file" wire:model="nota"
                                       accept="application/pdf, image/png, image/jpg, image/jpeg"
                                       class="custom-file-input" id="file" name="nota">
                                   <label class="custom-file-label" for="customFile">Pilih
                                       file</label>
                               </div>
                           </div>
                           <div class="form-group col-md-12 intro-keterangan">
                               <label for="inputAlamat">KETERANGAN &nbsp;</label>
                               <span style="color:rgba(230, 82, 82)">*</span>
                               <textarea type="text" class="form-control " wire:model="keterangan" placeholder="Masukan keterangan penggunaan dana"
                                   rows="2"></textarea>
                           </div>

                       </div>
                   </div>

                   {{-- footer --}}
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                           Batal</button>
                       @if ($tgl_penggunaan_dana == '' or $dibayarkan_kepada == '' or $nominal == '' or $nota == '' or $keterangan == '')
                           <button class="btn btn-success" disabled wire:loading.attr="disabled"><i
                                   class="fas fa-save"></i>
                               Tambah</button>
                       @else
                           <button type="submit" name="submit" class="btn btn-success" wire:loading.attr="disabled"><i
                                   class="fas fa-save"></i>
                               Tambah</button>
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

                       $('#nominal').on('input', function(e) {
                           $('#nominal').val(formatRupiah($('#nominal').val(),
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
