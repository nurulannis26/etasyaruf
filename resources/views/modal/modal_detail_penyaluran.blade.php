<form wire:submit.prevent="edit_berita_pengajuan">
    <div class="modal-body">
        {{-- alert --}}
        @if (session()->has('alert_lpj_detail'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_lpj_detail') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        {{-- end alert --}}

        <div class="row">
            <div class="col-md-4">
                <div class="card p-3">
                    <span class="text-bold text-center">DETAIL PENYALURAN</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <span class="text-bold text-center">DISALURKAN OLEH</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <span class="text-bold text-center">DITERIMA OLEH</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-row">
                    {{-- tgl berita --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">TGL PENYALURAN &nbsp;</label>
                        <input wire:model="tgl_berita" type="date" class="form-control" placeholder="Masukan Detail">
                    </div>

                    {{-- berupa --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">BENTUK BANTUAN &nbsp;</label>
                        <input wire:model="berupa" type="text" class="form-control"
                            placeholder="Uang Tunai / Nama Barang">
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">JUMLAH BANTUAN &nbsp;</label>
                        <input wire:model="jumlah_bantuan" type="text" class="form-control"
                            placeholder="1 Sak / 1 Unit / 1 Paket">
                    </div>
                    {{-- senilai --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">NILAI BANTUAN (Total Rp)&nbsp;</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Rp</span>
                            </div>
                            <input wire:model="senilai" id="senilai" type="text" class="form-control"
                                placeholder="Masukan Nilai Bantuan">
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">METODE PENYALURAN &nbsp;</label>
                        <select wire:model="metode_penyaluran" class="form-control">
                            <option value="">Pilih Metode Penyaluran</option>
                            <option value="Langsung">Langsung</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>

                    @if ($this->metode_penyaluran == 'Transfer')
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">NAMA BANK &nbsp;</label>
                            <input wire:model="nama_bank_penerima" type="text" class="form-control"
                                placeholder="Masukan nama bank">
                        </div>
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">NOMOR REKENING &nbsp;</label>
                            <input wire:model="no_rek_penerima" type="text" class="form-control" placeholder="Masukan nomor rekening">
                        </div>
                        <div class="form-group col-md-12 ">
                            <label for="inputNama">ATAS NAMA &nbsp;</label>
                            <input wire:model="atas_nama_penerima" type="text" class="form-control"
                                placeholder="Masukan atas nama">
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-md-4">
                <div class="form-row">
                    {{-- nama --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">NAMA &nbsp;</label>
                        <input wire:model="nama1" type="text" class="form-control"
                            placeholder="Masukan Nama Petugas">
                    </div>

                    {{-- jabatan --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">JABATAN &nbsp;</label>
                        <input wire:model="jabatan1" type="text" class="form-control"
                            placeholder="Masukan Jabatan Petugas">
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">NIK &nbsp;</label>
                        <input wire:model="nik1" type="text" class="form-control" placeholder="Masukan NIK Petugas">
                    </div>
                    {{-- no hp --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">NO.HP &nbsp;</label>
                        <input wire:model="nohp1" type="text" class="form-control"
                            placeholder="Masukan No HP Petugas">
                    </div>
                    {{-- alamat --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">ALAMAT &nbsp;</label>
                        <textarea wire:model="alamat1" class="form-control" cols="30" rows="3" placeholder="Masukan Alamat Petugas">
                                            </textarea>
                    </div>

                </div>

            </div>
            <div class="col-md-4">
                <div class="form-row">
                    {{-- nama --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">NAMA &nbsp;</label>
                        <input wire:model="nama2" type="text" class="form-control"
                            placeholder="Masukan Nama Penerima">
                    </div>

                    {{-- jabatan --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">JABATAN &nbsp;</label>
                        <input wire:model="jabatan2" type="text" class="form-control"
                            placeholder="Masukan Jabatan Penerima">
                    </div>
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">NIK &nbsp;</label>
                        <input wire:model="nik2" type="text" class="form-control" placeholder="Masukan NIK Penerima">
                    </div>
                    {{-- no hp --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">NO.HP &nbsp;</label>
                        <input wire:model="nohp2" type="text" class="form-control"
                            placeholder="Masukan No HP Penerima">
                    </div>
                    {{-- alamat --}}
                    <div class="form-group col-md-12 ">
                        <label for="inputNama">ALAMAT &nbsp;</label>
                        <textarea wire:model="alamat2" class="form-control" cols="30" rows="3"
                            placeholder="Masukan Alamat Penerima">
                                            </textarea>
                    </div>

                </div>
            </div>
        </div>

    </div>
    {{-- footer --}}
    <div class="modal-footer">

        <div class="float-right">
            <button data-dismiss="modal" type="button" class="btn btn-secondary hover"><i class="fas fa-ban"></i>
                Batal</button>
            {{-- @if ($this->beritaValidation() == 0)
                            <button class="btn btn-success " data-toggle="tooltip" data-placement="top"
                                title="Input Belum Lengkap" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-save"></i>
                                Simpan</button>
                        @else --}}
            <button type="submit" class="btn btn-success hover" wire:loading.attr="disabled"><i
                    class="fas fa-save"></i>
                Simpan</button>
            {{-- @endif --}}
        </div>
    </div>
</form>
