<div wire:ignore.self class="modal fade" id="create-lampiran-berita" data-keyboard="true" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    TAMBAH LAMPIRAN
                </h5>
                <div>
                    <button wire:click="batalLaporan" type="button" class="close" data-dismiss="modal"
                        onclick="batalLampiranBerita()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form wire:submit.prevent="uploadLampiranBerita">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">JUDUL LAMPIRAN</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="judul_file" type="text" class="form-control"
                                placeholder="Masukan Judul Lampiran">
                        </div>
                        {{-- lampiran --}}
                        <div class="form-group col-md-12">
                            <label for="inputHP">UPLOAD LAMPIRAN</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <div class="custom-file" id="customFileLampiranBerita">
                                <input type="file" wire:model="file"
                                    accept="application/pdf, image/png, image/jpg, image/jpeg" class="custom-file-input"
                                    name="file">
                                <label class="custom-file-label" for="customFile">Pilih
                                    file</label>
                            </div>
                        </div>
                    </div>


                </div>
                {{-- footer --}}
                <div class="modal-footer">
                    <button onclick="batalLampiranBerita()" type="button" class="btn btn-secondary hover"
                        data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>
                    @if ($file == null)
                        <button type="submit" class="btn btn-success hover" disabled wire:loading.attr="disabled"> <i
                                class="fas fa-save"></i> Simpan
                        </button>
                    @elseif ($judul_file == null)
                        <button type="submit" class="btn btn-success hover" disabled wire:loading.attr="disabled"> <i
                                class="fas fa-save"></i> Simpan
                        </button>
                    @else
                        <button type="submit" class="btn btn-success hover" wire:loading.attr="disabled"><i
                                class="fas fa-save"></i> Simpan
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
