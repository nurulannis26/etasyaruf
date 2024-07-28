  {{-- modal body --}}
  <div class="modal-body">
      <div class="form-row">
          {{-- nomor pengajuan --}}
          <div class="form-group col-md-6 modal-tambah-pengajuan-nomor-pengajuan-panduan">
              <label for="inputNama">NOMOR PENGAJUAN &nbsp;</label>
              <input wire:model="nomor_surat" type="text" class="form-control" readonly>
          </div>
          {{-- end nomor pengajuan --}}
          <hr>
          <div class="form-group col-md-6">
              <label for="inputNama">JENIS PEMOHON &nbsp;</label>
              {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
              <select wire:model="opsi_pemohon" class="select2dulus form-control ">
                  <option value="">Pilih Jenis</option>
                  <option value="Entitas">Entitas</option>
                  <option value="Individu">Individu</option>
                 
              </select>
          </div>
          <hr>
          @if ($this->opsi_pemohon == 'Individu')
              {{-- pemohon --}}
              <div class="form-group col-md-6 modal-tambah-pengajuan-pemohon-pengajuan-panduan">
                  <label>NAMA PEMOHON &nbsp;</label>
                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="nama_pemohon" type="text" class="form-control"
                      placeholder="Masukan Nama Pemohon">
              </div>
              <hr>
              {{-- end pemohon --}}

              {{-- nohp --}}
              <div class="form-group col-md-6 modal-tambah-pengajuan-no-hp-pemohon-pengajuan-panduan">
                  <label>NO.HP PEMOHON &nbsp;</label>

                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="nohp_pemohon" id="nohp_pemohon" type="text" class="form-control"
                      placeholder="Masukan No HP Pemohon"
                      oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
              </div>
              <hr>
              {{-- end nohp --}}

              {{-- alamat --}}
              <div class="form-group col-md-6 modal-tambah-pengajuan-alamat-pemohon-pengajuan-panduan">
                <label>NIK PEMOHON &nbsp;</label>

                {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                <input wire:model="nik_individu" id="nik_individu" type="text" class="form-control"
                    placeholder="Masukan NIK Pemohon"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
            </div>
              <div class="form-group col-md-6 modal-tambah-pengajuan-alamat-pemohon-pengajuan-panduan">
                  <label>ALAMAT PEMOHON &nbsp;</label>
                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="alamat_pemohon" type="text" class="form-control"
                      placeholder="Masukan Alamat Pemohon">
              </div>

              {{-- end alamat --}}
          @elseif ($this->opsi_pemohon == 'Entitas')
              <div class="form-group col-md-6">
                  <label>NAMA ENTITAS &nbsp;</label>
                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="nama_entitas" type="text" class="form-control"
                      placeholder="Masukan Nama Entitas">
              </div>
              <hr>
              <div class="form-group col-md-6">
                  <label>NO PERIJINAN ENTITAS &nbsp;</label>
                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="no_perijinan_entitas" type="text" class="form-control"
                      placeholder="Masukan No Perijinan Entitas">
              </div>
              <hr>
              <div class="form-group col-md-12">
                  <label>ALAMAT ENTITAS &nbsp;</label>
                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="alamat_entitas" type="text" class="form-control"
                      placeholder="Masukan Alamat Entitas">
              </div>
              <hr>

              <div class="form-group col-md-6">
                  <label>NAMA PJ PERMOHONAN &nbsp;</label>
                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="pj_entitas" type="text" class="form-control"
                      placeholder="Masukan PJ Permohonan">
              </div>

              <div class="form-group col-md-6">
                  <label>JABATAN &nbsp;</label>
                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="jabatan_entitas" type="text" class="form-control"
                      placeholder="Masukan Jabatan">
              </div>
              <hr>
              <div class="form-group col-md-6">
                  <label>NIK &nbsp;</label>
                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="nik_entitas" type="text" class="form-control" placeholder="Masukan NIK">
              </div>
              <div class="form-group col-md-6">
                  <label>NO HP &nbsp;</label>
                  {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
                  <input wire:model="no_hp_entitas" type="text" class="form-control"
                      placeholder="Masukan No HP">
              </div>
          @elseif ($this->opsi_pemohon == 'Internal')
              <div class="form-group col-md-12">
                  <label for="inputNama">PEMOHON &nbsp;</label>
                  <select wire:model="pemohon_internal" id="select2PemohonInternal" class="form-control select2">
                      <option value="">Pilih Nama Pemohon</option>
                      @foreach ($pc_petugas as $a)
                          <option value="{{ $a->id_pc_pengurus }}">{{ $a->nama }} - {{ $a->jabatan }}</option>
                      @endforeach
                  </select>
                  {{-- <select class="form-control" name="pj_ranting" id="select2PemohonInternal">
                    <option value="" selected>Pilih Ranting Terlebih Dahulu</option>
                </select> --}}
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
              <select wire:model="jenis_tanda_terima" class="form-control">
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
              <input @if ($this->jenis_tanda_terima == 'lainnya') @else disabled @endif wire:model="lainnya" type="text"
                  class="form-control" placeholder="Masukkan Tanda Terima Lainnya">
          </div>


          <hr>
          <div class="form-group col-md-6">
              <label>NOMOR SURAT &nbsp;</label>
              {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgb(0, 187, 31)">Optional</sup> --}}
              <input wire:model="no_surat" type="text" class="form-control" placeholder="Masukkan Nomor Surat">
          </div>
          {{-- end no surat --}}
          <hr>
          <hr>
          <hr>
          {{--  tgl surat  --}}
          <div class="form-group col-md-6">
              <label>TGL SURAT &nbsp;</label>
              <input wire:model="tgl_surat" type="date" class="form-control">
          </div>
          {{-- end tgl surat --}}
          <hr>
          <hr>
          {{--  no surat  --}}


          {{--  tgl pengajuan  --}}
          <div class="form-group col-md-6 modal-tambah-pengajuan-tgl-pengajuan-pemohon-pengajuan-panduan">
              <label for="inputNama">TGL PENGAJUAN &nbsp;</label>
              <input wire:model="tgl_pengajuan" type="date" class="form-control">
          </div>
          {{-- end tgl pengajuan --}}
          <hr>
          {{--  tgl pelaksanaan  --}}
          <div class="form-group col-md-6 modal-tambah-pengajuan-tgl-pelaksanaan-pemohon-pengajuan-panduan">
              <label for="inputNama">TGL PELAKSANAAN &nbsp;</label>
              <sup class="badge badge-danger text-white mb-2" style="background-color:rgb(0, 187, 31)">Optional</sup>
              <input wire:model="tgl_pelaksanaan" type="date" class="form-control sos">
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
          <div class="form-group col-md-6 modal-tambah-asnaf-pilar">
              <label for="inputNama">ASNAF &nbsp;</label>
              <sup class="badge badge-danger text-white mb-2" style="background-color:rgb(0, 187, 31)">Optional</sup>
              {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
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
          <hr>
          {{-- end program --}}
          {{-- pilar --}}
          <hr>
          <div class="form-group col-md-6 modal-tambah-asnaf-pilar">
              <label for="inputNama">PILAR &nbsp;</label>
              <sup class="badge badge-danger text-white mb-2" style="background-color:rgb(0, 187, 31)">Optional</sup>
              {{-- <sup class="badge badge-danger text-white mb-2 "
                      style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
              <select wire:model="id_program_pilar" id="id_program_pilars" class="select2dulur form-control pilar">
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
          <hr>
          {{-- end pilar --}}

          <hr>
          {{-- kegiatan --}}
          <div class="form-group col-md-12">
              <label for="inputNama">JENIS PROGRAM &nbsp;</label>
              {{-- <sup class="badge badge-danger text-white  mb-2"
                      style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
              <select class="form-control" id="select2-dropdown" wire:model="selectedProgram"
                  data-placeholder="Pilih Pilar Terlebih Dahulu">

                  @if ($id_program_pilar == '')
                      <option value="" disabled>Pilih Pilar Terlebih Dahulu</option>
                  @else
                      @foreach ($daftar_kegiatan as $aa)
                          <option value="{{ $aa->id_program_kegiatan }}">{{ $aa->no_urut }}
                              {{ $aa->nama_program }}</option>
                      @endforeach
                      @foreach ($daftar_kegiatan2 as $bb)
                          <option value="{{ $bb->id_program_kegiatan }}">{{ $bb->no_urut }}
                              {{ $bb->nama_program }}</option>
                      @endforeach
                  @endif
              </select>
          </div>
          {{-- end kegiatan --}}
          {{-- {{ $this->selectedProgram }}
          {{ $this->jumlah_penerima . $this->satuan_pengajuan}} --}}
          {{-- nama penerima manfaat --}}
          <hr>
          <div class="form-group col-md-12">
              <label for="inputNama">TARGET PENERIMA MANFAAT &nbsp;</label>
              {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
              <input wire:model="nama_penerima" type="text" class="form-control"
                  placeholder="Contoh : UMKM Binaan, Warga Duafa, DLL.">
          </div>
          {{-- end keterangan --}}
          <hr>
          <!--<div class="form-group col-md-12">-->
          <!--    <label for="inputNama">JENIS PERMOHONAN &nbsp;</label>-->
          <!--    {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}-->
          <!--    {{-- <input type="text" wire:model="jenis_permohonan" class="form-control"-->
          <!--        placeholder="Bantuan apa yang diajukan"> --}}-->
          <!--    <select wire:model="jenis_permohonan" class="form-control">-->
          <!--        <option value="">Pilih Jenis Permohonan</option>-->
          <!--        <option value="Pendidikan">Pendidikan</option>-->
          <!--        <option value="Kesehatan">Kesehatan</option>-->
          <!--        <option value="Ekonomi">Ekonomi</option>-->
          <!--        <option value="Siaga Bencana">Siaga Bencana</option>-->
          <!--        <option value="Bantuan Kegiatan">Bantuan Kegiatan</option>-->
          <!--        <option value="Sosial Kemanusiaan">Sosial Kemanusiaan</option>-->
          <!--        <option value="Keagamaan">Keagamaan</option>-->
          <!--        <option value="Santunan">Santunan</option>-->
          <!--        <option value="Pembangunan">Pembangunan</option>-->
          <!--        <option value="Lainnya">Lainnya</option>-->
          <!--    </select>-->
          <!--</div>-->


          <hr>
          {{-- nama stuan --}}
          <div class="form-group col-md-4">
              <label for="inputNama">NOMINAL PENGAJUAN &nbsp;</label>
              {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
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
          {{-- <div class="form-group col-md-3">
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
          </div> --}}
          <hr>
          <div class="form-group col-md-4">
              <label for="inputNama">JML PENERIMA &nbsp;</label>
              {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
              <div class="input-group">
                  <div class="input-group-prepend">
                      <span class="input-group-text bor-abu"><i class="fas fa-users"></i></span>
                  </div>
                  <input type="text" wire:model="jumlah_penerima" id="jumlah_penerima" class="form-control"
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
                  <input type="text" class="form-control"
                      value="{{ number_format((int) str_replace('.', '', $this->satuan_pengajuan) * $this->jumlah_penerima, 0, ',', '.') }}"
                      readonly>

              </div>
          </div>
          {{-- end nominal --}}
          <hr>
          {{--  pengajuan note --}}
          <div class="form-group col-md-12">
              <label for="inputAlamat">KETERANGAN / PERIHAL&nbsp;</label>
              {{-- <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup> --}}
              <textarea type="text" class="form-control" wire:model="pengajuan_note" placeholder="Masukan Keterangan / Perihal"
                  rows="4"> </textarea>

          </div>
          {{-- end pengajuan note --}}



      </div>
  </div>



  @push('script')
      <script>
          $(document).ready(function() {
              // Menginisialisasi Select2 setelah halaman dimuat sepenuhnya
              $('#select2PemohonInternal').select2();
          });
      </script>

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
  @endpush
