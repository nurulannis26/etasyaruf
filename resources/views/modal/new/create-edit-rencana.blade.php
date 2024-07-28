<div wire:ignore.self class="modal fade" id="create-edit-rencana" data-backdrop="static"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ empty($id_pengajuan_detail) ? 'TAMBAH' : 'UBAH' }} RENCANA PROGRAM PENTASYARUFAN
                </h5>
                <div>
                    <button wire:click="resetValue" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form wire:submit.prevent="create_edit_rencana">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">NOMOR SURAT&nbsp;</label>
                            <input type="text" readonly class="form-control" value="{{ $data->nomor_surat }}">
                        </div>

                        {{--  tgl pengajuan  --}}
                        <div class="form-group col-md-6 tgl-pelaksanaan-modal-data-pengajuan">
                            <label for="inputNama">TGL PELAKSANAAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="tgl_pelaksanaan" type="date" class="form-control">
                        </div>
                        {{--  tgl setor lpj  --}}
                        <div class="form-group col-md-6 ">
                            <label for="inputNama">TGL SETOR LPJ&nbsp;</label>
                            <input wire:model="tgl_setor" type="date" class="form-control">
                        </div>

                        {{-- program --}}
                        <div class="form-group col-md-6 jenis-modal-data-pengajuan">
                            <label for="inputNama">KATEGORI &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <select wire:model="id_program" class="form-control" id="select2Program">
                                <option value="">Pilih Kategori</option>
                                @foreach ($list_program as $a)
                                    <option value="{{ $a->id_program }}">{{ $a->program }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- pilar --}}
                        <div class="form-group col-md-6 pilar-modal-data-pengajuan">
                            <label for="inputNama">PILAR &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <select wire:model="id_program_pilar" id="select2Pilar" class="form-control">
                                @if ($id_program == '')
                                    <option value="">Pilih Kategori Terlebih Dahulu</option>
                                @else
                                    <option value="">Pilih Pilar</option>
                                    @foreach ($list_pilar as $a)
                                        <option value="{{ $a->id_program_pilar }}">{{ $a->pilar }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        {{-- {{ $id_program }} wdw {{ $id_program_pilar }} --}}
                        {{-- kegiatan --}}
                        <div class="form-group col-md-12 jenis-program-modal-data-pengajuan">
                            <label for="inputNama">JENIS PROGRAM &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <select wire:model="id_program_kegiatan" class="form-control" id="select2Kegiatan">
                                @if ($id_program_pilar == '' or $id_program == '')
                                    <option value="">Pilih Kategori Terlebih Dahulu</option>
                                @else
                                    <option value="">Pilih Jenis Program</option>
                                    @foreach ($list_kegiatan as $a)
                                        <option value="{{ $a['id_program_kegiatan'] }}">{{ $a['no_urut'] }}
                                            {{ $a['nama_program'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        {{-- petugas pentasyarufan --}}
                        <div class="form-group col-md-12 petugas-pentasyarufan-modal-data-pengajuan">
                            <label for="inputNama">PETUGAS PENTASYARUFAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <select wire:model="petugas" class="form-control" id="select2Petugas">
                                <option value="">Pilih Petugas Pentasyarufan</option>
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    @foreach (\App\Http\Controllers\PengajuanController::getDaftarPengurus('upzis', $data->id_upzis) as $a)
                                        <option value="{{ $a->id_upzis_pengurus }}">
                                            {{ $a->jabatan . ' - ' . $a->nama }}
                                        </option>
                                    @endforeach
                                @elseif($data->tingkat == 'Ranting NU')
                                    @foreach (\App\Http\Controllers\PengajuanController::getDaftarPengurus('ranting', $data->id_ranting) as $a)
                                        <option value="{{ $a->id_ranting_pengurus }}">
                                            {{ $a->jabatan . ' - ' . $a->nama }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        {{-- nama penerima manfaat --}}
                        <div class="form-group col-md-12 target-penerima-manfaat-modal-data-pengajuan">
                            <label for="inputNama">TARGET PENERIMA MANFAAT &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="nama_penerima" type="text" class="form-control"
                                placeholder="Contoh : UMKM Binaan, Warga Duafa, DLL.">
                        </div>

                        {{-- nama stuan --}}
                        <div class="form-group col-md-5 nominal-satuan-modal-data-pengajuan">
                            <label for="inputNama">NOMINAL PER PENERIMA &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input wire:model="satuan_pengajuan" id="satuan_pengajuan" type="text"
                                    class="form-control" placeholder="Masukan Nominal Satuan">
                            </div>
                        </div>
                        {{-- jumlah --}}
                        <div class="form-group col-md-3 jumlah-modal-data-pengajuan">
                            <label for="inputNama">JML PENERIMA&nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu"><i class="fas fa-users"></i></span>
                                </div>
                                <input wire:model="jumlah_penerima" type="text" class="form-control"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                    placeholder="Jumlah">
                            </div>
                        </div>
                        {{-- nominal --}}
                        <div class="form-group col-md-4 nominal-total-modal-data-pengajuan">
                            <label for="inputNama">NOMINAL TOTAL &nbsp;</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input type="text" class="form-control" value="{{ $this->updateTotal() }}"
                                    readonly>
                            </div>
                        </div>
                        {{-- keterangan --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">KETERANGAN &nbsp;</label>
                            <textarea wire:model="pengajuan_note" class="form-control" cols="30" rows="3"
                                placeholder="Masukan Keterangan">
                                    </textarea>
                        </div>
                        {{-- info --}}
                        <div class="card card-body " style="background-color:#cbf2d6;">
                            <b>INFORMASI!</b>
                            <span>
                                Setelah rencana program pentasyarufan ditambahkan, wajib melampirkan daftar penerima
                                manfaat
                            </span>
                        </div>
                    </div>
                </div>
                {{-- footer --}}
                <div class="modal-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-secondary hover" data-dismiss="modal"><i
                                class="fas fa-ban"></i>
                            Batal</button>
                        @if ($this->pengajuanValidation() == 0)
                            <button class="btn btn-success " data-toggle="tooltip" data-placement="top"
                                title="Input Belum Lengkap" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-save"></i>
                                Simpan</button>
                        @else
                            <button type="submit" class="btn btn-success hover" wire:loading.attr="disabled"><i
                                    class="fas fa-save"></i>
                                Simpan</button>
                        @endif
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
