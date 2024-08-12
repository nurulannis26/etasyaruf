   {{--  tambah pilar --}}
   <div wire:ignore.self class="modal fade" id="modal_ubah_nominal_pengajuan" data-backdrop="static" tabindex="-1"
       data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

       <div class="modal-dialog modal-lg ">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">UBAH PENGAJUAN UMUM
                   </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="card-body">
                   <form wire:submit.prevent="ubah_nominal_pengajuan">
                       <div class="form-row">
                           {{-- nomor pengajuan --}}
                           <div class="form-group col-md-6 modal-tambah-pengajuan-nomor-pengajuan-panduan">
                               <label for="inputNama">NOMOR PENGAJUAN &nbsp;</label>
                               <input wire:model="nomor_surat_edit" type="text" class="form-control" readonly>
                           </div>
                           {{-- end nomor pengajuan --}}
                           <hr>
                           <div class="form-group col-md-6">
                               <label for="inputNama">JENIS PEMOHON &nbsp;</label>
                               {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                               <select wire:model="opsi_pemohon_edit" class="select2dulus form-control ">
                                   <option value="">Pilih Jenis</option>
                                   <option value="Entitas">Entitas</option>
                                   <option value="Individu">Individu</option>
                                   <option value="Internal">Internal</option>
                               </select>
                           </div>
                           <hr>
                           @if ($this->opsi_pemohon_edit == 'Individu')
                               {{-- pemohon --}}
                               <div class="form-group col-md-6 modal-tambah-pengajuan-pemohon-pengajuan-panduan">
                                   <label>NAMA PEMOHON &nbsp;</label>
                                   {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                                   <input wire:model="nama_pemohon_edit" type="text" class="form-control"
                                       placeholder="Masukan Nama Pemohon">
                               </div>
                               <hr>
                               {{-- end pemohon --}}

                               {{-- nohp --}}
                               <div class="form-group col-md-6 modal-tambah-pengajuan-no-hp-pemohon-pengajuan-panduan">
                                   <label>NO.HP PEMOHON &nbsp;</label>

                                   {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                                   <input wire:model="nohp_pemohon_edit" type="text" class="form-control"
                                       placeholder="Masukan No HP Pemohon"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                               </div>
                               <hr>
                               {{-- end nohp --}}

                               {{-- alamat --}}
                               <div
                                   class="form-group col-md-12 modal-tambah-pengajuan-alamat-pemohon-pengajuan-panduan">
                                   <label>ALAMAT PEMOHON &nbsp;</label>
                                   {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                                   <input wire:model="alamat_pemohon_edit" type="text" class="form-control"
                                       placeholder="Masukan Alamat Pemohon">
                               </div>

                               {{-- end alamat --}}
                           @elseif ($this->opsi_pemohon_edit == 'Entitas')
                               <div class="form-group col-md-6">
                                   <label>NAMA ENTITAS &nbsp;</label>
                                   {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                                   <input wire:model="nama_entitas_edit" type="text" class="form-control"
                                       placeholder="Masukan Nama Entitas">
                               </div>
                               <hr>
                               <div class="form-group col-md-6">
                                   <label>NO PERIJINAN ENTITAS &nbsp;</label>
                                   {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                                   <input wire:model="no_perijinan_entitas_edit" type="text" class="form-control"
                                       placeholder="Masukan No Perijinan Entitas">
                               </div>
                               <hr>
                               <div class="form-group col-md-12">
                                   <label>ALAMAT ENTITAS &nbsp;</label>
                                   {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                                   <input wire:model="alamat_entitas_edit" type="text" class="form-control"
                                       placeholder="Masukan Alamat Entitas">
                               </div>
                               <hr>

                               <div class="form-group col-md-6">
                                   <label>NAMA PJ PERMOHONAN &nbsp;</label>
                                   {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                                   <input wire:model="pj_entitas_edit" type="text" class="form-control"
                                       placeholder="Masukan PJ Permohonan">
                               </div>
                               <hr>

                               <div class="form-group col-md-6">
                                   <label>NO HP &nbsp;</label>
                                   {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                                   <input wire:model="no_hp_entitas_edit" type="text" class="form-control"
                                       placeholder="Masukan No HP">
                               </div>
                           @elseif ($this->opsi_pemohon_edit == 'Internal')
                               <div class="form-group col-md-12">
                                   <label for="inputNama">PEMOHON &nbsp;</label>
                                   <select wire:model="pemohon_internal_edit" id="select2PemohonInternal"
                                       class="form-control select2">
                                       <option value="">Pilih Nama Pemohon</option>
                                       @foreach ($this->pc_petugas_edit as $a)
                                           <option value="{{ $a->id_pc_pengurus }}">{{ $a->nama }} -
                                               {{ $a->jabatan }}</option>
                                       @endforeach
                                   </select>
                               </div>
                           @endif
                           {{-- petugas pentasyarufan --}}
                           {{-- <div class="form-group col-md-8 modal-tambah-pengajuan-petugas-pentasyarufan-pemohon-pengajuan-panduan">
                        <label for="inputNama">PETUGAS PENTASYARUFAN &nbsp;</label>
                        <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                        <select wire:model="petugas" class="form-control">
                          
                            @foreach ($daftar_petugas as $a)
                                <option value="{{ $a->id_pc_pengurus }}">{{ $a->jabatan . ' - ' . $a->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div> --}}
                           {{-- end petugas pentasyarufan --}}

                           {{-- survey --}}
                           {{-- <div class="form-group col-md-4 modal-tambah-pengajuan-petugas-pentasyarufan-pemohon-pengajuan-panduan">
                        <label for="inputNama">SURVEY &nbsp;</label>
                        <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                        <select wire:model="survey" class="form-control">
                            <option value="Perlu">Perlu</option>
                            <option value="Tidak Perlu">Tidak Perlu</option>
                        </select>
                    </div> --}}
                           {{-- end survey --}}
                           <hr>
                           <hr style="width: 100%; border: none; border-top: 1px solid #797b7d; margin: 10px 0;">

                           <div class="form-group col-md-6">
                               <label for="inputNama">JENIS TANDA TERIMA &nbsp;</label>
                               <select wire:model="jenis_tanda_terima_edit" class="form-control">
                                   <option value="">Pilih Tanda Terima</option>
                                   <option value="barang">Barang</option>
                                   <option value="dokumen">Dokumen</option>
                                   <option value="surat">Surat</option>
                                   <option value="lainnya">Lainnya</option>
                               </select>
                           </div>
                           <hr>

                           <div class="form-group col-md-6">
                               <label>KETERANGAN LAINNYA &nbsp;</label>
                               <input @if ($this->jenis_tanda_terima_edit == 'lainnya') @else disabled @endif wire:model="lainnya_edit"
                                   type="text" class="form-control" placeholder="Masukkan Tanda Terima Lainnya">
                           </div>


                           {{--  no surat  --}}
                           <div class="form-group col-md-6">
                               <label>NOMOR SURAT &nbsp;</label>
                               {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgb(0, 187, 31)">Optional</sup> --}}
                               <input wire:model="no_surat_edit" type="text" class="form-control"
                                   placeholder="Masukkan Nomor Surat">
                           </div>
                           {{-- end no surat --}}

                           <hr>
                           {{--  tgl surat  --}}
                           <div class="form-group col-md-6">
                               <label>TGL SURAT &nbsp;</label>
                               <input wire:model="tgl_surat_edit" type="date" class="form-control">
                           </div>
                           {{-- end tgl surat --}}
                           <hr>

                           <hr>

                           {{--  tgl pengajuan  --}}
                           <div
                               class="form-group col-md-6 modal-tambah-pengajuan-tgl-pengajuan-pemohon-pengajuan-panduan">
                               <label for="inputNama">TGL PENGAJUAN &nbsp;</label>
                               <input wire:model="tgl_pengajuan_edit" type="date" class="form-control">
                           </div>
                           {{-- end tgl pengajuan --}}
                           <hr>
                           {{--  tgl pelaksanaan  --}}
                           <div
                               class="form-group col-md-6 modal-tambah-pengajuan-tgl-pelaksanaan-pemohon-pengajuan-panduan">
                               <label for="inputNama">TGL PELAKSANAAN &nbsp;</label>
                               <sup class="badge badge-danger text-white mb-2"
                                   style="background-color:rgb(0, 187, 31)">Optional</sup>
                               <input wire:model="tgl_pelaksanaan_edit" type="date" class="form-control sos">
                           </div>
                           {{-- end tgl pelaksanaan --}}

                           <hr>

                           {{--  tgl setor lpj  --}}
                           {{-- <div class="form-group col-md-4">
                        <label for="inputNama">TGL SETOR LPJ&nbsp;</label>
                        <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                        <input wire:model="tgl_setor" type="date" class="form-control">
                    </div> --}}
                           {{-- end tgl setor lpj --}}

                           <hr style="width: 100%; border: none; border-top: 1px solid #797b7d; margin: 10px 0;">
                           <hr>
                           {{-- program --}}
                           <div class="form-group col-md-6">
                               <label for="inputNama">ASNAF / PILAR &nbsp;</label>
                               {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                               <select wire:model="sumber_dana_edit" class="select2dulus form-control ">
                                   <option value="">Pilih Jenis</option>
                                   {{-- <option value="ba84d782-81a8-11ed-b4ef-dc215c5aad51">PENGUATAN KELEMBAGAAN</option>
                          <option value="bed10d9c-81a8-11ed-b4ef-dc215c5aad51">PROGRAM SOSIAL</option>
                          <option value="c51700b1-81a8-11ed-b4ef-dc215c5aad51">OPERASIONAL PC LAZISNU</option> --}}
                                   <option value="Dana Zakat">Asnaf</option>
                                   <option value="Dana Infak">Pilar</option>
                               </select>
                           </div>
                           {{-- end program --}}
                           <hr>
                           @if (empty($this->sumber_dana_edit))
                               <div class="form-group col-md-6">
                                   <label for="inputAlamat">ASNAF / PILAR &nbsp;</label>
                                   <input type="text" class="form-control" disabled
                                       placeholder="Pilih Asnaf / Pilar dahulu">

                               </div>
                               <hr>
                           @elseif ($this->sumber_dana_edit == 'Dana Zakat')
                               <div class="form-group col-md-6">
                                   <label for="inputNama">ASNAF &nbsp;</label>
                                   <select wire:model="id_asnaf_edit" class="select2dulus form-control ">
                                       <option value="">Pilih Asnaf</option>
                                       @php
                                           $asnaf_get_edit = DB::table('asnaf')->get();
                                       @endphp
                                       @foreach ($asnaf_get_edit as $as)
                                           <option value="{{ $as->id_asnaf }}">{{ $as->nama_asnaf }}</option>
                                       @endforeach
                                   </select>
                               </div>
                               <hr>
                           @elseif ($this->sumber_dana_edit == 'Dana Infak')
                               <hr>
                               <div class="form-group col-md-6">
                                   <label for="inputNama">PILAR &nbsp;</label>
                                   <select wire:model="id_program_pilar_edit" id="id_program_pilars"
                                       class="select2dulur form-control pilar">
                                       <option value="">Pilih Pilar</option>
                                       @foreach ($this->daftar_pilar_edit as $a)
                                           <option value="{{ $a->id_program_pilar }}">{{ $a->pilar }}</option>
                                       @endforeach
                                   </select>
                               </div>

                               <hr>
                               <div class="form-group col-md-12">
                                   <label for="inputNama">JENIS PROGRAM &nbsp;</label>
                                   <select class="form-control" wire:model="id_program_kegiatan_edit"
                                       data-placeholder="Pilih Pilar Terlebih Dahulu">

                                       @php
                                           $daftar_kegiatan_edit = App\Models\ProgramKegiatan::where('id_program_pilar', $this->id_program_pilar_edit)
                                               ->whereRaw('LENGTH(no_urut) = 3')
                                               ->orderBy('no_urut', 'ASC')
                                               ->get();

                                           $daftar_kegiatan2_edit = App\Models\ProgramKegiatan::where('id_program_pilar', $this->id_program_pilar_edit)
                                               ->whereRaw('LENGTH(no_urut) = 4')
                                               ->orderBy('no_urut', 'ASC')
                                               ->get();
                                       @endphp
                                       @if ($this->id_program_pilar_edit == '')
                                           <option value="" disabled>Pilih Pilar Terlebih Dahulu</option>
                                       @else
                                           @foreach ($daftar_kegiatan_edit as $aa)
                                               <option value="{{ $aa->id_program_kegiatan }}">{{ $aa->no_urut }}
                                                   {{ $aa->nama_program }}</option>
                                           @endforeach
                                           @foreach ($daftar_kegiatan2_edit as $bb)
                                               <option value="{{ $bb->id_program_kegiatan }}">{{ $bb->no_urut }}
                                                   {{ $bb->nama_program }}</option>
                                           @endforeach
                                       @endif
                                   </select>
                               </div>
                           @endif

                           <hr>
                           <div class="form-group col-md-12">
                               <label for="inputNama">TARGET PENERIMA MANFAAT &nbsp;</label>
                               <input wire:model="nama_penerima_edit" type="text" class="form-control"
                                   placeholder="Contoh : UMKM Binaan, Warga Duafa, DLL.">
                           </div>
                           {{-- end keterangan --}}
                           <hr>
                           <div class="form-group col-md-12">
                               <label for="inputNama">JENIS PERMOHONAN &nbsp;</label>
                               {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                               {{-- <input type="text" wire:model="jenis_permohonan" class="form-control"
                            placeholder="Bantuan apa yang diajukan"> --}}
                               <select wire:model="jenis_permohonan_edit" class="form-control">
                                   <option value="">Pilih Jenis Permohonan</option>
                                   <option value="Pendidikan">Pendidikan</option>
                                   <option value="Kesehatan">Kesehatan</option>
                                   <option value="Ekonomi">Ekonomi</option>
                                   <option value="Siaga Bencana">Siaga Bencana</option>
                                   <option value="Bantuan Kegiatan ">Bantuan Kegiatan </option>
                                   <option value="Sosial Kemanusiaan">Sosial Kemanusiaan</option>
                                   <option value="Keagamaan">Keagamaan</option>
                                   <option value="Santunan">Santunan</option>
                                   <option value="Pembangunan">Pembangunan</option>
                                   <option value="Lainnya">Lainnya</option>
                               </select>
                           </div>


                           <hr>
                           {{-- nama stuan --}}
                           <div class="form-group col-md-4">
                               <label for="inputNama">NOMINAL PENGAJUAN &nbsp;</label>
                               {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                               <div class="input-group">
                                   <div class="input-group-prepend">
                                       <span class="input-group-text bor-abu">Rp</span>
                                   </div>

                                   <input type="text" wire:model="satuan_pengajuan_edit" class="form-control"
                                       placeholder="Nominal Per-penerima">
                               </div>
                           </div>
                           {{-- end satuan --}}

                           <hr>
                           <div class="form-group col-md-4">
                               <label for="inputNama">JML PENERIMA &nbsp;</label>
                               {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                               <div class="input-group">
                                   <div class="input-group-prepend">
                                       <span class="input-group-text bor-abu"><i class="fas fa-users"></i></span>
                                   </div>
                                   <input type="text" wire:model="jumlah_penerima_edit" class="form-control"
                                       placeholder="Jml Penerima">
                               </div>
                           </div>

                           <hr>
                           {{-- end jumlah --}}
                           {{-- {{ $this->jumlah_penerima . $this->satuan_pengajuan}} --}}
                           {{-- nominal --}}
                           <div class="form-group col-md-4">
                               <label for="inputNama">NOMINAL TOTAL &nbsp;</label>
                               {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                               <div class="input-group">
                                   <div class="input-group-prepend">
                                       <span class="input-group-text bor-abu">Rp</span>
                                   </div>
                                   <input type="text" class="form-control" wire:model="total_edit" readonly>

                               </div>
                           </div>
                           {{-- end nominal --}}
                           <hr>
                           {{--  pengajuan note --}}
                           <div class="form-group col-md-12">
                               <label for="inputAlamat">KETERANGAN / PERIHAL &nbsp;</label>
                               {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                               <textarea type="text" class="form-control" wire:model="pengajuan_note_edit"
                                   placeholder="Masukan Keterangan / Perihal" rows="4"> </textarea>

                           </div>
                           {{-- end pengajuan note --}}
                       </div>

                       {{-- footer --}}
                       <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                   class="fas fa-ban"></i>
                               Batal</button>

                           <button type="submit" name="submit" class="btn btn-success"
                               wire:loading.attr="disabled"><i class="fas fa-save"></i>
                               Simpan Perubahan</button>

                       </div>
                       {{-- endfooter --}}
                   </form>
               </div>
           </div>
       </div>



   </div>
   {{-- end tambah pilar --}}

   {{-- @push('script')
       <script>
           $(document).ready(function() {
               $('#satuan_pengajuan_edit').on('input', function(e) {
                   $('#satuan_pengajuan_edit').val(formatRupiah($('#satuan_pengajuan_edit').val(),
                       'Rp. '));
               });

           });
       </script>
   @endpush

   @push('script')
       <script>
           $(document).ready(function() {

               window.loadContactDeviceSelect2 = () => {

                   $('#nominal_pengajuan').on('input', function(e) {
                       $('#nominal_pengajuan').val(formatRupiah($('#nominal_pengajuan').val(),
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



   @push('script')
       <script>
           $(document).ready(function() {
               bsCustomFileInput.init();
               window.loadContactDeviceSelect2 = () => {
                   window.initSelectStationDrop = () => {
                       $('#select2-dropdown').select2();
                       $('#select2-dropdown').on('change', function() {
                           var selectedValue = $(this).val();
                           @this.set('id_program_kegiatan', selectedValue);
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
   @endpush --}}