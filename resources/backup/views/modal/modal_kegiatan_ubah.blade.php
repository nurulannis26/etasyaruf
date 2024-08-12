   {{--  ubah kegiatan --}}
   <div wire:ignore.self class="modal fade" id="modal_kegiatan_ubah" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog modal-l">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Ubah Program ({{ $pilar }})
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form wire:submit.prevent="ubah_kegiatan">
                   <div class="modal-body">

                       {{-- pilar --}}
                       <div class="form-group col-md-12">
                           <label for="inputNama">NO URUT &nbsp;</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB</sup>
                           <input wire:model="ubah_no_urut" type="text" class="form-control" placeholder="No Urut">
                       </div>
                       {{-- end pilar --}}

                       {{-- kegiatan --}}
                       <div class="form-group col-md-12">
                           <label for="inputNama">NAMA PROGRAM &nbsp;</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB</sup>
                           <input wire:model="ubah_kegiatan" type="text" class="form-control"
                               placeholder="Nama Program">
                       </div>
                       {{-- end kegiatan --}}

                   </div>
                   {{-- footer --}}
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                           Batal</button>
                       @if ($ubah_kegiatan == '' or $ubah_no_urut == '')
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
   {{-- end ubah pilar --}}
