   {{--  acc --}}
   <div wire:ignore.self class="modal fade" id="modal_rencana_acc" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog modal-l">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Tambah Pilar
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form wire:submit.prevent="tambah_pilar">
                   <div class="modal-body">

                       {{-- pilar --}}
                       <div class="form-group col-md-12">
                           <label for="inputNama">NAMA PILAR &nbsp;</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB</sup>
                           <input wire:model="pilar" type="text"
                               class="form-control   @error('pilar') is-invalid @enderror" placeholder="Nama Pilar">
                       </div>
                       {{-- end pilar --}}

                   </div>
                   {{-- footer --}}
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                           Batal</button>

                   </div>
                   {{-- endfooter --}}
               </form>
           </div>
       </div>
   </div>
   {{-- end tambah pilar --}}
