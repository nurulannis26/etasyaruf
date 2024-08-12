{{--  tambah pilar --}}
<div wire:ignore.self class="modal fade" id="modal_pengeluaran_tambah" data-backdrop="static" tabindex="-1"
    data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TAMBAH PENYALURAN
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="tambah_pengeluaran">

                <div class="modal-body">
                    <div class="card" style="background-color:#cbf2d6">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-sm-4 invoice-col">
                                    Nominal Pencairan
                                    <address>
                                        <b>
                                            @if ($nominal_pencairan == null)
                                                -
                                            @else
                                                Rp{{ number_format($nominal_pencairan, 0, '.', '.') }},-
                                            @endif
                                        </b>
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                    Dana Digunakan
                                    <address>
                                        <b> Rp{{ number_format($dana_digunakan, 0, '.', '.') }},-</b>

                                    </address>
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    Dana Tersisa
                                    <address>
                                        <b>Rp{{ number_format($nominal_pencairan - $dana_digunakan, 0, '.', '.') }},-</b>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (str_replace('.', '', $nominal_pengeluaran) > $nominal_pencairan - $dana_digunakan)
                        {{-- alert --}}
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-minus-circle"></i> Nominal Penyaluran Melebihi Dana Tersisa
                        </div>
                        {{-- end alert --}}
                    @endif

                    <div class="form-row">
                        {{-- judul pengeluaran --}}
                        <div class="form-group col-md-8">
                            <label for="inputTempat">JUDUL PENYALURAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input type="text" class="form-control " wire:model="judul_pengeluaran"
                                placeholder="Masukan judul pengeluaran">
                        </div>
                        {{-- tanggal --}}
                        <div class="form-group col-md-4">
                            <label for="inputTempat">TGL PENYALURAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input type="date" class="form-control " wire:model="tgl_pengeluaran"
                                placeholder="Masukan tanggal pengeluaran">
                        </div>
                        {{-- jumlah unit/barang --}}
                        <div class="form-group col-md-4">
                            <label for="inputTempat">JUMLAH UNIT/BARANG &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input type="text" class="form-control" wire:model="jumlah_pengeluaran"
                                placeholder="Masukan jumlah unit/barang">
                        </div>

                        {{-- nominal --}}
                        <div class="form-group col-md-4">
                            <label for="inputTempat">NOMINAL PENYALURAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input type="text" class="form-control" wire:model="nominal_pengeluaran"
                                    placeholder="Masukan nominal pengeluaran" id="nominal_pengeluaran">
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputHP">NOTA</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB
                                (PDF/JPG/JPEG/PNG)</sup>
                            <div class="custom-file custom-file-arsip">
                                <input type="file" wire:model="nota_pengeluaran"
                                    accept="application/pdf, image/png, image/jpg, image/jpeg" class="custom-file-input"
                                    id="file" name="file">
                                <label class="custom-file-label" for="customFile">Pilih
                                    file</label>
                            </div>
                        </div>

                    </div>

                </div>
                {{-- footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>
                    @if (
                        $judul_pengeluaran == '' or
                            $tgl_pengeluaran == '' or
                            $jumlah_pengeluaran == '' or
                            $nominal_pengeluaran == '' or
                            $nota_pengeluaran == '' or
                            str_replace('.', '', $nominal_pengeluaran) > $nominal_pencairan - $dana_digunakan)
                        <button class="btn btn-success" disabled wire:loading.attr="disabled"><i
                                class="fas fa-save"></i>
                            Simpan</button>
                    @else
                        <button type="submit" name="submit" class="btn btn-success" wire:loading.attr="disabled"><i
                                class="fas fa-save"></i>
                            Simpan</button>
                    @endif
                </div>
                {{-- endfooter --}}
            </form>
        </div>



    </div>
</div>



{{-- end tambah pilar --}}
