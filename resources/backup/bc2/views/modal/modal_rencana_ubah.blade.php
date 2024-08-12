@if (Auth::user()->gocap_id_upzis_pengurus != null)
    {{--  tambah program_penguatan_kelembagaan --}}
    <div wire:ignore.self class="modal fade" id="modal_rencana_ubah" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> UBAH RENCANA PROGRAM PENTASYARUFAN
                    </h5>
                    <div>
                        {{-- <a style="color: blue; font-size:18px;" class="d-inline btn" id="modal_rencana_ubah_panduan">
                            PANDUAN </a> --}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>




                {{-- form --}}
                <form wire:submit.prevent="ubah_rencana('{{ $id_pengajuan_detail }}')">

                    {{-- modal body --}}
                    <div class="modal-body">

                        {{-- alert --}}
                        {{-- @if (session()->has('alert_rencana'))
                            <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                                <i class="fas fa-minus-circle"></i>
                                {{ session('alert_rencana') }}
                            </div>
                        @endif --}}
                        {{-- end alert --}}


                        <div class="form-row">

                            {{-- nomor pengajuan --}}
                            <div class="form-group col-md-12 nomor-pengajuan-modal-data-pengajuan">
                                <label for="inputNama">NOMOR PENGAJUAN &nbsp;</label>
                                <input type="text" class="form-control" value="{{ $data->nomor_surat }}" readonly>
                            </div>
                            {{-- end nomor pengajuan --}}

                            {{-- petugas pentasyarufan --}}
                            <div class="form-group col-md-12 petugas-pentasyarufan-modal-data-pengajuan">
                                <label for="inputNama">PETUGAS PENTASYARUFAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <select wire:model="edit_petugas" class="form-control">
                                    {{-- <option value="">Pilih Petugas Pentasyarufan</option> --}}
                                    @if ($data->tingkat == 'Upzis MWCNU')
                                        @foreach ($daftar_petugas as $a)
                                            <option value="{{ $a->id_upzis_pengurus }}">
                                                {{ $a->jabatan . ' - ' . $a->nama }}
                                            </option>
                                        @endforeach
                                    @else
                                        @foreach ($daftar_petugas as $a)
                                            <option value="{{ $a->id_ranting_pengurus }}">
                                                {{ $a->jabatan . ' - ' . $a->nama }}
                                            </option>
                                        @endforeach
                                    @endif


                                </select>

                            </div>
                            {{-- end petugas pentasyarufan --}}

                            {{--  tgl pengajuan  --}}
                            <div class="form-group col-md-6 tgl-pelaksanaan-modal-data-pengajuan">
                                <label for="inputNama">TGL PELAKSANAAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="edit_tgl_pelaksanaan" type="date" class="form-control">
                            </div>
                            {{-- end tgl pengajuan --}}

                            {{--  tgl setor lpj  --}}
                            <div class="form-group col-md-6 tgl-setor-lpj-modal-data-pengajuan">
                                <label for="inputNama">TGL SETOR LPJ&nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="edit_tgl_setor" type="date" class="form-control">
                            </div>
                            {{-- end tgl setor lpj --}}

                            {{-- program --}}
                            <div class="form-group col-md-6 jenis-modal-data-pengajuan">
                                <label for="inputNama">KATEGORI &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <select wire:model="programId" id="edit_id_program" class="form-control">
                                    @foreach ($daftar_program as $a)
                                        <option value="{{ $a->id_program }}">{{ $a->program }}
                                        </option>
                                    @endforeach
                                </select>


                            </div>
                            {{-- end program --}}

                            {{-- pilar --}}
                            <div class="form-group col-md-6 pilar-modal-data-pengajuan">
                                <label for="inputNama">PILAR &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <select wire:model="pilarId" id="id_program_pilar" class="form-control">

                                    <option value="">Pilih Pilar</option>
                                    @foreach ($edit_daftar_pilar as $a2)
                                        <option value="{{ $a2->id_program_pilar }}">{{ $a2->pilar }}</option>
                                    @endforeach

                                </select>
                            </div>
                            {{-- end pilar --}}

                            {{-- kegiatan --}}
                            <div class="form-group col-md-12 jenis-program-modal-data-pengajuan">
                                <label for="inputNama">JENIS PROGRAM &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <select class="form-control" id="select2-dropdown" wire:model="edit_id_program_kegiatan"
                                    data-placeholder="Pilih Pilar Terlebih Dahulu">

                                    @if ($pilarId == null or $programId == null)
                                        <option value="">Pilih Pilar Terlebih Dahulu</option>
                                    @else
                                        <option value="">Pilih Pilar Terlebih Dahulu</option>

                                        @foreach ($edit_daftar_kegiatan as $z)
                                            <option value="{{ $z->id_program_kegiatan }}">{{ $z->no_urut }}
                                                {{ $z->nama_program }}</option>
                                        @endforeach
                                        @foreach ($edit_daftar_kegiatan2 as $z)
                                            <option value="{{ $z->id_program_kegiatan }}">{{ $z->no_urut }}
                                                {{ $z->nama_program }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            {{-- end kegiatan --}}



                            {{-- nama penerima manfaat --}}
                            <div class="form-group col-md-12 target-penerima-manfaat-modal-data-pengajuan">
                                <label for="inputNama">TARGET PENERIMA MANFAAT &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="edit_nama_penerima" type="text" class="form-control"
                                    placeholder="Contoh : UMKM Binaan, Warga Duafa, DLL.">
                            </div>
                            {{-- end keterangan --}}



                          


                            {{-- nama stuan --}}
                            <div class="form-group col-md-5 nominal-satuan-modal-data-pengajuan">
                                <label for="inputNama">NOMINAL PER PENERIMA &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu">Rp</span>
                                    </div>
                                    <input wire:model="edit_satuan_pengajuan" id="satuan_pengajuan2" type="text"
                                        class="form-control" placeholder="Masukan Nominal Satuan">
                                </div>
                            </div>
                            {{-- end satuan --}}

                            {{-- jumlah --}}
                            <div class="form-group col-md-3 jumlah-modal-data-pengajuan">
                                <label for="inputNama">JML PENERIMA&nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu"><i class="fas fa-users"></i></span>
                                    </div>
                                    <input wire:model="edit_jumlah_penerima" type="text" class="form-control"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                        placeholder="Jumlah">
                                </div>
                            </div>
                            {{-- end jumlah --}}

                            {{-- nominal --}}
                            <div class="form-group col-md-4 nominal-total-modal-data-pengajuan">
                                <label for="inputNama">NOMINAL TOTAL &nbsp;</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bor-abu">Rp</span>
                                    </div>
                                    <input type="text" class="form-control"
                                        value="{{ number_format($edit_nominal_pengajuan, 0, '.', '.') }}" readonly>
                                </div>
                            </div>
                            {{-- end nominal --}}

                            {{-- keterangan --}}
                            <div class="form-group col-md-12 ">
                                <label for="inputNama">KETERANGAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <textarea wire:model="edit_pengajuan_note" class="form-control" cols="30" rows="3"
                                    placeholder="Masukan Keterangan">
                                    </textarea>
                            </div>
                            {{-- end keterangan --}}

                            {{-- info --}}
                            <div class="card card-body " style="background-color:#cbf2d6;">
                                <b>INFORMASI!</b>
                                <span>
                                    Setelah rencana program pentasyarufan ditambahkan, wajib melampirkan daftar penerima
                                    manfaat
                                </span>
                            </div>
                            {{-- end info --}}

                        </div>
                    </div>
                    {{-- end modal body --}}

                    {{-- footer --}}
                    <div class="modal-footer">
                        <button wire:click="tombol_batal_rencana" type="button"
                            class="btn btn-secondary batal-modal-data-pengajuan" data-dismiss="modal"><i
                                class="fas fa-ban"></i>
                            Batal</button>




                        @if (
                            $edit_petugas == '' or
                                $edit_tgl_pelaksanaan == '' or
                                $edit_tgl_setor == '' or
                                $programId == '' or
                                $pilarId == '' or
                                $edit_id_program_kegiatan == '' or
                                $edit_nama_penerima == '' or
                                $edit_jumlah_penerima == '' or
                                $edit_satuan_pengajuan == '')
                            <button class="btn btn-success simpan-modal-data-pengajuan" disabled
                                wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                Simpan</button>
                        @else
                            <button type="submit" name="submit" class="btn btn-success"
                                wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                Simpan</button>
                        @endif

                    </div>
                    {{-- endfooter --}}

                </form>
                {{-- end form --}}

            </div>
        </div>

        @push('script')
            <script>
                $(document).ready(function() {
                    bsCustomFileInput.init();

                    window.loadContactDeviceSelect2 = () => {


                        // pemohon
                        // select2_id_pemohon
                        // $('#select2-dropdown').select2().on('change', function() {
                        //     livewire.emitTo('tenant.contact-component', 'devicesSelect', $(this).val());
                        //     var data = $('#select2-dropdown').select2("val");
                        //     @this.set('id_program_kegiatan', data);
                        // });



                        window.initSelectStationDrop = () => {
                            $('#select2-dropdown').select2();
                            $('#select2-dropdown').on('change', function() {
                                var selectedValue = $(this).val();
                                @this.set('selectedProgramEdit', selectedValue);
                            });

                        }
                        initSelectStationDrop();
                        window.livewire.on('select2', () => {
                            initSelectStationDrop();
                        });



                        $('#id_program').on('change', function() {
                            @this.set('id_program_pilar', '');
                        });
                        $('#id_program_pilar').on('change', function() {
                            @this.set('id_program_kegiatan', '');
                        });

                        $('#satuan_pengajuan2').on('input', function(e) {
                            $('#satuan_pengajuan2').val(formatRupiah($('#satuan_pengajuan2').val(),
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
    </div>
    {{-- end tambah program_penguatan_kelembagaan --}}
@endif
