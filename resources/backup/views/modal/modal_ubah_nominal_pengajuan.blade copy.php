   {{--  tambah pilar --}}
   <div wire:ignore.self class="modal fade" id="modal_ubah_nominal_pengajuan" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog ">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">UBAH NOMINAL PENGAJUAN
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form wire:submit.prevent="ubah_nominal_pengajuan">
                   <div class="modal-body form-row">

                       <div class="form-group col-md-12">
                           <label for="inputNama">SATUAN PENERIMA &nbsp;</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB</sup>
                           <div class="input-group">
                               <div class="input-group-prepend">
                                   <span class="input-group-text bor-abu">Rp</span>
                               </div>
                               <input wire:model="satuan_pengajuan_edit" id="satuan_pengajuan" type="text"
                                   class="form-control" placeholder="Masukan Nominal Satuan">
                           </div>
                       </div>
                       <div class="form-group col-md-12">
                           <label for="inputNama">JUMLAH PENERIMA &nbsp;</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB</sup>
                           <div class="input-group">

                               <input wire:model="jumlah_penerima_edit" type="text" class="form-control"
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                   placeholder="Masukan Jumlah Penerima">
                               <div class="input-group-prepend">
                                   <span class="input-group-text bor-abu">Orang</span>
                               </div>
                           </div>

                       </div>

                       <div class="form-group col-md-12">
                           <label for="inputNama">TOTAL &nbsp;</label>
                           {{-- <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                           <div class="input-group">
                               <div class="input-group-prepend">
                                   <span class="input-group-text bor-abu">Rp</span>
                               </div>
                               <input wire:model="total_edit" type="text" class="form-control" readonly>
                           </div>

                       </div>

                   </div>
                   {{-- footer --}}
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                           Batal</button>

                       <button type="submit" name="submit" class="btn btn-success" wire:loading.attr="disabled"><i
                               class="fas fa-save"></i>
                           Simpan Perubahan</button>

                   </div>
                   {{-- endfooter --}}
               </form>
           </div>
       </div>

       @push('script')
           <script>
               $(document).ready(function() {
                   $('#satuan_pengajuan').on('input', function(e) {
                       $('#satuan_pengajuan').val(formatRupiah($('#satuan_pengajuan').val(),
                           'Rp. '));
                   });

               });
           </script>
       @endpush

   </div>
   {{-- end tambah pilar --}}
