   {{--  tambah pilar --}}
   <div wire:ignore.self class="modal fade" id="modal_internal_lampiran_tambah" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">TAMBAH LAMPIRAN PENGAJUAN
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form wire:submit.prevent="tambah_lampiran">
                   <div class="modal-body form-row">

                       <div class="form-group col-md-6">
                           <label for="inputNama">JUDUL/NOMOR LAMPIRAN &nbsp;</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB</sup>
                           <input wire:model="judul" type="text" class="form-control"
                               placeholder="Masukan Judul/Nomor Lampiran">
                       </div>


                       <div class="form-group col-md-6">
                           <label for="inputHP">FILE LAMPIRAN</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB
                               (PDF/JPG/JPEG/PNG)</sup>
                           <div class="custom-file custom-file-lampiran">
                               <input type="file" wire:model="file_lampiran"
                                   accept="application/pdf, image/png, image/jpg, image/jpeg" class="custom-file-input"
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
                       @if ($file_lampiran == '' or $judul == '')
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



   </div>
   {{-- end tambah pilar --}}
