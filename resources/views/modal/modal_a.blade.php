{{-- modal ubah kegiatan --}}
<div wire:ignore.self class="modal fade" id="modal_a" data-backdrop="static" data-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    {{-- jika ada foto --}}

    <div class="modal-dialog modal-xl">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">KEGIATAN PENTASYARUFAN</h5>
                <div class="col-auto float-right">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

            </div>

            <form wire:submit.prevent="ubah_kegiatan">

                <div class="modal-body mt-2">



                    <div id="form-baru">

                        <div class="form-row">
                            {{-- judul kegiatan --}}
                            <div class="form-group col-md-8">
                                <label for="inputTempat">JUDUL KEGIATAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <input type="text" class="form-control " wire:model="judul"
                                    placeholder="Masukan judul kegiatan">

                            </div>
                            {{-- tanggal kegiatan --}}
                            <div class="form-group col-md-4">
                                <label for="inputTempat">TANGGAL KEGIATAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <input type="date" class="form-control " wire:model="tgl_kegiatan">

                            </div>
                            {{-- lokasi kegiatan --}}
                            <div class="form-group col-md-4">
                                <label for="inputTempat">LOKASI KEGIATAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <input type="text" class="form-control " wire:model="lokasi"
                                    placeholder="Masukan lokasi kegiatan">

                            </div>
                            {{-- jumlah kehadiran --}}
                            <div class="form-group col-md-4">
                                <label for="inputTempat">JUMLAH KEHADIRAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <input type="text" class="form-control " wire:model="jumlah_kehadiran"
                                    placeholder="Masukan jumlah kehadiran">

                            </div>

                            {{-- kendala pelaksanaan --}}
                            <div class="form-group col-md-4">
                                <label for="inputTempat">KENDALA KEGIATAN &nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <input type="text" class="form-control" wire:model="kendala"
                                    placeholder="Masukan kendala kegiatan">

                            </div>
                            {{-- ringkasan kegiatan --}}
                            <div class="form-group col-md-12">
                                <label for="inputAlamat">RINGKASAN KEGIATAN&nbsp;</label>
                                <span style="color:rgba(230, 82, 82)">*</span>
                                <textarea type="text" class="form-control" wire:model="ringkasan" placeholder="Masukan ringkasan kegiatan"
                                    rows="4"> </textarea>

                            </div>
                        </div>

                    </div>
                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>

                    @if (
                        $judul == '' or
                            $tgl_kegiatan == '' or
                            $lokasi == '' or
                            $jumlah_kehadiran == '' or
                            $kendala == '' or
                            $ringkasan == '')
                        <button class="btn btn-success" wire:loading.attr="disabled" disabled><i
                                class="fas fa-save"></i>
                            Simpan</button>
                    @else
                        <button type="submit" name="submit" class="btn btn-success" wire:loading.attr="disabled"><i
                                class="fas fa-save"></i>
                            Simpan</button>
                    @endif


                </div>

            </form>
        </div>

    </div>

</div>
