   {{--  tambah pilar --}}
   <div wire:ignore.self class="modal fade" id="modal_umum_lpj_ubah" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">UBAH LAMPIRAN LPJ
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form wire:submit.prevent="ubah_lampiran_lpj">
                   <div class="modal-body form-row">

                       <div class="form-group col-md-5">
                           <label for="inputNama">JUDUL LAMPIRAN &nbsp;</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB</sup>
                           <input wire:model="judul_lpj" type="text" class="form-control"
                               placeholder="Masukan Judul Lampiran">
                       </div>


                       <div class="form-group col-md-7">
                           <label for="inputHP">FILE LAMPIRAN</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgb(82, 166, 230)">ABAIKAN JIKA TIDAK
                               ADA
                               PERUBAHAN (PDF/JPG/JPEG/PNG)</sup>
                           <div class="custom-file custom-file-lampiran">
                               <input type="file" wire:model="file_lpj"
                                   accept="application/pdf, image/png, image/jpg, image/jpeg" class="custom-file-input"
                                   id="file" name="file_lpj">
                               <label class="custom-file-label" for="customFile">Pilih
                                   file</label>
                           </div>
                       </div>

                   </div>
                   {{-- footer --}}
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                           Batal</button>
                       @if ($judul_lpj == '')
                           <button class="btn btn-success" disabled wire:loading.attr="disabled"><i
                                   class="fas fa-save"></i>
                               Simpan Perubahan</button>
                       @else
                           <button type="submit" name="submit" class="btn btn-success" wire:loading.attr="disabled"><i
                                   class="fas fa-save"></i>
                               Simpan Perubahan</button>
                       @endif
                   </div>
                   {{-- endfooter --}}
               </form>
           </div>
       </div>



   </div>
   {{-- end tambah pilar --}}
