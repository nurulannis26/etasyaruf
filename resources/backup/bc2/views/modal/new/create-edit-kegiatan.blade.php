<div wire:ignore.self class="modal fade" id="create-edit-kegiatan" data-keyboard="true" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ empty($dokumentasi->id_pengajuan_kegiatan) ? 'TAMBAH' : 'UBAH' }} KEGIATAN
                </h5>
                <div>
                    <button wire:click="resetValue" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <form wire:submit.prevent="create_edit_kegiatan">
                <div class="modal-body">
                    <div class="form-row">
                        {{-- judul --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">JUDUL &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="judul_kegiatan" type="text" class="form-control"
                                placeholder="Masukan Judul Kegiatan">
                        </div>
                        {{-- tgl kegiatan --}}
                        <div class="form-group col-md-6 ">
                            <label for="inputNama">TGL KEGIATAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="tgl_kegiatan" type="date" class="form-control">
                        </div>
                        {{-- lokasi --}}
                        <div class="form-group col-md-6 ">
                            <label for="inputNama">LOKASI &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="lokasi" type="text" class="form-control"
                                placeholder="Masukan Lokasi Kegiatan">
                        </div>
                        {{-- jumlah_kehadiran --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">JUMLAH KEHADIRAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="jumlah_kehadiran" type="text" class="form-control"
                                placeholder="Masukan Lokasi Kegiatan">
                        </div>
                        {{-- kendala --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">KENDALA KEGIATAN &nbsp;</label>
                            <textarea wire:model="kendala" class="form-control" cols="30" rows="3"
                                placeholder="Masukan Kendala Kegiatan">
                                    </textarea>
                        </div>
                        {{-- ringkasan --}}
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">RINGKASAN KEGIATAN &nbsp;</label>
                            <textarea wire:model="ringkasan" class="form-control" cols="30" rows="3"
                                placeholder="Masukan Ringkasan Kegiatan">
                                    </textarea>
                        </div>
                    </div>
                </div>
                {{-- footer --}}
                <div class="modal-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-secondary hover" data-dismiss="modal"><i
                                class="fas fa-ban"></i>
                            Batal</button>
                        @if ($this->kegiatanValidation() == 0)
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
