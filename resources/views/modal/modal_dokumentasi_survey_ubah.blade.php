   {{--  tambah pilar --}}
   <div wire:ignore.self class="modal fade" id="modal_dokumentasi_survey_ubah" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">UBAH DOKUMENTASI SURVEY
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <form wire:submit.prevent="ubah_dokumentasi_survey">
                   <div class="modal-body form-row">

                       <div class="form-group col-md-5">
                           <label for="inputNama">JUDUL LAMPIRAN &nbsp;</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgba(230,82,82)">WAJIB</sup>
                           <input wire:model="judul_dokumentasi_survey_edit" type="text" class="form-control"
                               placeholder="Masukan Judul Lampiran">
                       </div>


                       <div class="form-group col-md-7">
                           <label for="inputHP">FILE LAMPIRAN</label>
                           <sup class="badge badge-danger text-white mb-2"
                               style="background-color:rgb(82, 166, 230)">ABAIKAN JIKA TIDAK
                               ADA
                               PERUBAHAN (PDF/JPG/JPEG/PNG)</sup>
                           <div class="custom-file custom-file-dokumentasi_survey">
                               <input type="file" wire:model="file_dokumentasi_survey_edit"
                                   accept="application/pdf, image/png, image/jpg, image/jpeg" class="custom-file-input"
                                   id="file" name="foto">
                               <label class="custom-file-label" for="customFile">Pilih
                                   file</label>
                           </div>
                       </div>

                   </div>
                   {{-- footer --}}
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                           Batal</button>
                       @if ($judul_dokumentasi_survey_edit == '')
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
   @push('script')
   <script>
       $(document).ready(function() {

           window.loadContactDeviceSelect2 = () => {
               bsCustomFileInput.init();
               $('.tombol-tambah').click(function() {
                   $(".custom-file-lampiran_pencairan").html('').change();
               });

               $('.tombol-ubah').click(function() {
                   $(".custom-file-lampiran_pencairan").html('').change();
               });

           }

           loadContactDeviceSelect2();
           window.livewire.on('loadContactDeviceSelect2', () => {
               loadContactDeviceSelect2();
           });


       });
   </script>


@endpush
