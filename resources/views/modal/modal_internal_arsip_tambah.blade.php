   {{--  tambah pilar --}}
   <div wire:ignore.self class="modal fade" id="modal_internal_arsip_tambah" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">TAMBAH ARSIP PENGAJUAN INTERNAL
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form wire:submit.prevent="tambah_arsip">
                   <div class="modal-body form-row">

                       <div class="form-group col-md-6">
                           <label for="inputNama">JUDUL ARSIP &nbsp;</label>
                           <span style="color:rgba(230, 82, 82)">*</span>
                           <input wire:model="judul" type="text" class="form-control"
                               placeholder="Masukan Judul Lampiran">
                       </div>


                       <div class="form-group col-md-6">
                           <label for="inputHP">FILE ARSIP</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB
                               (PDF/JPG/JPEG/PNG)</sup>
                           <div class="custom-file custom-file-arsip">
                               <input type="file" wire:model="file_arsip"
                                   accept="application/pdF image/png, image/jpg, image/jpeg" class="custom-file-input"
                                   id="file" name="file">
                               <label class="custom-file-label" for="customFile">Pilih
                                   file</label>
                           </div>
                       </div>

                   </div>
                   {{-- footer --}}
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                           Batal</button>
                       @if ($file_arsip == '' or $judul == '')
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



   </div>
   {{-- end tambah pilar --}}
