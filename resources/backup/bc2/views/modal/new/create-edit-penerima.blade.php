<div wire:ignore.self class="modal fade" id="create-edit-penerima" data-keyboard="true" role="dialog" data-backdrop="static"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> {{ empty($id_pengajuan_penerima) ? 'TAMBAH' : 'UBAH' }} PENERIMA MANFAAT
                </h5>
                <div>
                    <button wire:click="batalLaporan" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form wire:submit.prevent="create_edit_penerima">
                <div class="modal-body">
                    <div class="form-row">
                        {{-- tgl bantuan --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">TGL PENYALURAN BANTUAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="tgl_bantuan" type="date" class="form-control">
                        </div>
                        {{-- nama penerima manfaat --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">TARGET PENERIMA MANFAAT &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="penerima_manfaat" type="text" class="form-control"
                                placeholder="Masukan Nama Penerima Manfaat">
                        </div>
                        {{-- nik --}}
                        <div class="form-group col-md-6 ">
                            <label for="inputNama">NIK &nbsp;</label>

                            <input wire:model="nik" type="text" class="form-control" placeholder="Masukan NIK">
                        </div>
                        {{-- nokk --}}
                        <div class="form-group col-md-6 ">
                            <label for="inputNama">NO KARTU KELUARGA &nbsp;</label>

                            <input wire:model="nokk" type="text" class="form-control"
                                placeholder="Masukan No Kartu Keluarga">
                        </div>
                        {{-- no hp --}}
                        <div class="form-group col-md-6 ">
                            <label for="inputNama">NO HP &nbsp;</label>

                            <input wire:model="nohp" type="text" class="form-control" placeholder="Masukan No HP">
                        </div>
                        {{-- nominal --}}
                        <div class="form-group col-md-6 ">
                            <label for="inputNama">NOMINAL BANTUAN&nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input wire:model="nominal_bantuan" id="nominal_bantuan" type="text"
                                    class="form-control" placeholder="Masukan Nominal Bantuan">
                            </div>
                        </div>
                        {{-- jenis bantuan --}}
                        <div class="form-group col-md-6 ">
                            <label for="inputNama">JENIS BANTUAN &nbsp;</label>

                            <input wire:model="jenis_bantuan" type="text" class="form-control"
                                placeholder="Masukan Jenis Bantuan">
                        </div>
                        {{-- pilar --}}
                        <div class="form-group col-md-6 ">
                            <label for="inputNama">PILAR &nbsp;</label>
                            <input type="text" class="form-control" readonly
                                value="{{ \App\Http\Controllers\Helper::getDataPilar($data_detail->id_program_pilar ?? null)->pluck('pilar')->first() }}">
                        </div>
                        {{-- kegiatan --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">KEGIATAN &nbsp;</label>
                            <input type="text" class="form-control" readonly
                                value=" {{ \App\Http\Controllers\Helper::getDataKegiatan($data_detail->id_program_kegiatan ?? null)->pluck('nama_program')->first() }}">
                        </div>
                        {{-- alamat --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">ALAMAT &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <textarea wire:model="alamat_penerima" class="form-control" cols="30" rows="3"
                                placeholder="Masukan Alamat Penerima">
                                    </textarea>
                        </div>
                        {{-- keterangan --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">KETERANGAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <textarea wire:model="penerima_note" class="form-control" cols="30" rows="3"
                                placeholder="Masukan Keterangan">
                                    </textarea>
                        </div>
                    </div>
                </div>
                {{-- footer --}}
                <div class="modal-footer">

                    <div class="float-right">
                        <button wire:click="batalLaporan" type="button" class="btn btn-secondary hover"><i
                                class="fas fa-ban"></i>
                            Batal</button>
                        @if ($this->penerimaValidation() == 0)
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
