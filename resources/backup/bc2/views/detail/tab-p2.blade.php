 {{-- modal body --}}
 <div class="modal-body">
     <div class="form-row">


         {{-- program --}}
         <div class="form-group col-md-6">
             <label for="inputNama">ASNAF / PILAR &nbsp;</label>
             <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
             <select wire:model="sumber_dana" class="select2dulus form-control ">
                 <option value="">Pilih Jenis</option>
                 {{-- <option value="ba84d782-81a8-11ed-b4ef-dc215c5aad51">PENGUATAN KELEMBAGAAN</option>
                 <option value="bed10d9c-81a8-11ed-b4ef-dc215c5aad51">PROGRAM SOSIAL</option>
                 <option value="c51700b1-81a8-11ed-b4ef-dc215c5aad51">OPERASIONAL PC LAZISNU</option> --}}
                 <option value="Dana Zakat">Asnaf</option>
                 <option value="Dana Infak">Pilar</option>
             </select>
         </div>
         {{-- end program --}}

         @if ($this->sumber_dana == '')
             <div class="form-group col-md-6">
                 <label for="inputAlamat">ASNAF / PILAR &nbsp;</label>
                 <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                 <input type="text" class="form-control" disabled placeholder="Pilih Sumber Dana Dahulu">

             </div>
         @else
             @if ($this->sumber_dana == 'Dana Infak')
                 {{-- pilar --}}
                 <div class="form-group col-md-6">
                     <label for="inputNama">PILAR &nbsp;</label>
                     <sup class="badge badge-danger text-white mb-2 "
                         style="background-color:rgba(230,82,82)">WAJIB</sup>
                     <select wire:model="id_program_pilar" id="id_program_pilars"
                         class="select2dulur form-control pilar">
                         {{-- @if ($id_program == '')
                     <option value="">Pilih Kategori Terlebih Dahulu</option>
                 @else --}}
                         <option value="">Pilih Pilar</option>
                         @foreach ($daftar_pilar as $a)
                             <option value="{{ $a->id_program_pilar }}">{{ $a->pilar }}</option>
                         @endforeach
                         {{-- @endif --}}
                     </select>
                 </div>
                 {{-- end pilar --}}

                 {{-- kegiatan --}}
                 <div class="form-group col-md-12">
                     <label for="inputNama">JENIS PROGRAM &nbsp;</label>
                     <sup class="badge badge-danger text-white  mb-2"
                         style="background-color:rgba(230,82,82)">WAJIB</sup>
                     <select class="form-control" id="select2-dropdown" wire:model="selectedProgram"
                         data-placeholder="Pilih Pilar Terlebih Dahulu">

                         @if ($id_program_pilar == '')
                             <option value="" disabled>Pilih Pilar Terlebih Dahulu</option>
                         @else
                             @foreach ($daftar_kegiatan as $a)
                                 <option value="{{ $a->id_program_kegiatan }}">{{ $a->no_urut }}
                                     {{ $a->nama_program }}</option>
                             @endforeach
                             @foreach ($daftar_kegiatan2 as $a)
                                 <option value="{{ $a->id_program_kegiatan }}">{{ $a->no_urut }}
                                     {{ $a->nama_program }}</option>
                             @endforeach
                         @endif
                     </select>
                 </div>
                 {{-- end kegiatan --}}
             @endif
         @endif

         @if ($this->sumber_dana == 'Dana Zakat')
             {{-- program --}}
             <div class="form-group col-md-6">
                 <label for="inputNama">ASNAF &nbsp;</label>
                 <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                 <select wire:model="id_asnaf" class="select2dulus form-control ">
                     <option value="">Pilih Asnaf</option>
                     @php
                         $asnaf_get = DB::table('asnaf')->get();
                     @endphp
                     @foreach ($asnaf_get as $as)
                         <option value="{{ $as->id_asnaf }}">{{ $as->nama_asnaf }}</option>
                     @endforeach
                 </select>
             </div>
             {{-- end program --}}
         @endif


         {{--  pengajuan note --}}
         <div class="form-group col-md-12">
             <label for="inputAlamat">KETERANGAN&nbsp;</label>
             <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
             <textarea type="text" class="form-control" wire:model="pengajuan_note" placeholder="Masukan Keterangan"
                 rows="4"> </textarea>

         </div>
         {{-- end pengajuan note --}}

         {{-- nama penerima manfaat --}}
         <div class="form-group col-md-12">
             <label for="inputNama">TARGET PENERIMA MANFAAT &nbsp;</label>
             <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
             <input wire:model="nama_penerima" type="text" class="form-control"
                 placeholder="Contoh : UMKM Binaan, Warga Duafa, DLL.">
         </div>
         {{-- end keterangan --}}

         {{-- nama stuan --}}
         <div class="form-group col-md-5">
             <label for="inputNama">NOMINAL PENGAJUAN &nbsp;</label>
             <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
             <div class="input-group">
                 <div class="input-group-prepend">
                     <span class="input-group-text bor-abu">Rp</span>
                 </div>

                 <input type="text" wire:model="satuan_pengajuan" id="satuan_pengajuan" class="form-control"
                     placeholder="Nominal Per-penerima">
             </div>
         </div>
         {{-- end satuan --}}

         {{-- jumlah --}}
         <div class="form-group col-md-3">
             <label for="inputNama">JML PENERIMA&nbsp;</label>
             <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
             <div class="input-group">
                 <div class="input-group-prepend">
                     <span class="input-group-text bor-abu"><i class="fas fa-users"></i></span>
                 </div>
                 <input wire:model="jumlah_penerima" type="text" class="form-control"
                     oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                     placeholder="Jml Penerima">
             </div>
         </div>
         {{-- end jumlah --}}

         {{-- nominal --}}
         <div class="form-group col-md-4">
             <label for="inputNama">NOMINAL TOTAL &nbsp;</label>
             <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
             <div class="input-group">
                 <div class="input-group-prepend">
                     <span class="input-group-text bor-abu">Rp</span>
                 </div>
                 <input type="text" class="form-control"
                     value="{{ number_format($nominal_pengajuan, 0, '.', '.') }}" readonly>
             </div>
         </div>
         {{-- end nominal --}}

     </div>
 </div>

 @push('script')
     <script>
         $(document).ready(function() {
             bsCustomFileInput.init();
             window.loadContactDeviceSelect2 = () => {
                 window.initSelectStationDrop = () => {
                     $('#select2-dropdown').select2();
                     $('#select2-dropdown').on('change', function() {
                         var selectedValue = $(this).val();
                         @this.set('selectedProgram', selectedValue);
                     });
                 }
                 initSelectStationDrop();
                 window.livewire.on('select2', () => {
                     initSelectStationDrop();
                 });
             }
             loadContactDeviceSelect2();
             window.livewire.on('loadContactDeviceSelect2', () => {
                 loadContactDeviceSelect2();
             });

         });
     </script>
 @endpush

 {{-- end modal body --}}
 @push('script')
     <script>
         $(document).ready(function() {
             $('.select2dulu').select2();
         });
     </script>
     <script>
         $(document).ready(function() {
             window.loadContactDeviceSelect2 = () => {
                 $('#satuan_pengajuan').on('input', function(e) {
                     $('#satuan_pengajuan').val(formatRupiah($('#satuan_pengajuan').val(),
                         'Rp. '));
                 });

                 // $(".pilar").on('change',function () {
                 //     console.log('LOF');
                 //     $('.select2dulu').select2();
                 // });
                 $('#jenis_program').on('change', function() {
                     console.log('asd');
                     console.log($("#jenis_program").val());
                     @this.set('id_program_kegiatan', $("#jenis_program").val(););
                 });
             }
             loadContactDeviceSelect2();
             window.livewire.on('loadContactDeviceSelect2', () => {
                 loadContactDeviceSelect2();
             });
         });
     </script>
     <script>
         // $('#id_programs').on('change',function() {
         //             var s = $("#id_programs").val();
         //             var x = '{{ url('/data-pilar/') }}';
         //             var a = x+'/'+s;
         //             console.log(a);
         //             console.log('as');
         //         });
         // $(document).ready(function () {
         //     $('.select2dulu').select2(
         //         ajax:{
         //         url: 'http://127.0.0.1:8000/data-pilar/bed10d9c-81a8-11ed-b4ef-dc215c5aad51',
         //         dataType:'json',
         //         processResults: function(data) {
         //             return{
         //                 result:data.items
         //             }
         //         }
         //     });
         // });
     </script>
     <script>
         // $(document).ready(function() {
         //     $('#id_programs').select2();
         //     $('#id_programs').on('change', function(e) {
         //         var data = $('#id_programs').select2("val");
         //         @this.set('id_program', data);
         //     });
         // });
     </script>
     <script>
         // $(document).ready(function() {

         // $('#id_programs').on('change',function() {
         //     console.log('as');
         //     var s = $("#id_programs").val();
         //     var x = '{{ url('/data-pilar/') }}';
         //     var a = x+'/'+s;
         //     console.log('JADI');
         //     console.log(a);
         //     console.log(s);
         //     $('#id_program_pilars').select2(
         //         ajax:{
         //         url: a,
         //         console.log('JADI');
         //         dataType:'json',
         //         processResults: function(data) {
         //             return{
         //                 result:data.items
         //             }
         //         }
         //     }
         //     );
         // })
         // $('#id_program_pilars').on('change', function(e) {
         //     var data = $('#id_program_pilars').select2("val");
         //     @this.set('id_program_pilar', data);
         // });
         // });
         //     $(document).ready(function () {
         //     $('#jenis_program').select2({
         //         ajax:{
         //             url: 'http://127.0.0.1:8000/jenis-program/30746c18-3f7a-4736-ae47-ea91154a5a00',
         //             dataType:'json',
         //             processResults: function(data) {
         //                 return{
         //                     results: data.items
         //                 }
         //             }
         //         }
         //     }
         //     );
         // });
     </script>
 @endpush
