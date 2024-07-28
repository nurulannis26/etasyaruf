<div class="row">
    <div class="col col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body modal-detail-rencana-pentasyarufan">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fas fa-clipboard-list"></i><b class="ml-2"> BERITA ACARA</b>
                    </div>
                    <div>
                        <button wire:click="modal_kegiatan('{{ $kegiatan->id_pengajuan_kegiatan ?? null }}')"
                            id="createEditKegiatan" class="btn btn-outline-secondary btn-sm hover">
                            <i class="fas fa-edit"></i>
                            Ubah
                        </button>
                    </div>
                </div>

                <div class="card mt-3 p-4 ">
                    @if ($id_pengajuan_penerima == null)
                        <div class="card card-body" style="background-color:#ffbbbb">
                            <span class=" text-bold">
                                <em>Harap Pilih Penerima Untuk Ditampilkan Di Berita Acara</em>
                            </span>
                        </div>
                    @endif
                    @if ($id_pengajuan_penerima and $this->beritaValidation() == 0)
                        <div class="card card-body" style="background-color:#ffeebb">
                            <span class=" text-bold">
                                <em>Harap Lengkapi Data Penerima</em>
                            </span>
                        </div>
                    @elseif($id_pengajuan_penerima and $this->beritaValidation() == 1)
                        <div class="card card-body" style="background-color:#bbe0ff">
                            <span class=" text-bold">
                                <em>Data Penerima Sudah Lengkap</em>
                            </span>
                            <div class="float-left mt-1">
                                <a href="/{{ $role }}/berita_acara/{{ $id_pengajuan_detail }}" target="_blank"
                                    class="btn btn-sm btn-primary hover"><i class="fas fa-check-circle"></i>
                                    Print Berita Acara</a>
                            </div>
                        </div>
                    @endif


                    <div class="row m-2 mt-2">

                        <div class="mt-1 col-md-4">
                            <em>Nama Lengkap</em>
                        </div>
                        <div class="mt-1 col-md-8">
                            {{-- {{ $this->getPenerimaForBerita() }} --}}
                            <select wire:model="id_pengajuan_penerima" class="form-control" id="select2Penerima">
                                <option value="">Pilih Penerima</option>
                                @foreach ($list_penerima as $a)
                                    <option value="{{ $a->id_pengajuan_penerima }}">{{ $a->nama }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mt-1 col-md-4">
                            <em>No.Identitas Penerima </em>
                        </div>
                        <div class="mt-1 col-md-8">
                            <input wire:model="no_identitas" type="text" class="underline-input"
                                style="width: 250px;">
                        </div>

                        <div class="mt-1 col-md-4">
                            <em>Alamat Lengkap Penerima</em>
                        </div>
                        <div class="mt-1 col-md-8">
                            Jln
                            <input wire:model="jalan" type="text" class="underline-input">
                            RT
                            <input wire:model="rt" type="text" class="underline-input" style="width: 40px;">
                            RW
                            <input wire:model="rw" type="text" class="underline-input" style="width: 40px;">
                            Desa/Kelurahan
                            <input wire:model="desakelurahan" type="text" class="underline-input">
                            Kecamatan
                            <input wire:model="kecamatan" type="text" class="underline-input">
                            Kabupaten
                            <input wire:model="kabupaten" type="text" class="underline-input">
                        </div>

                        <div class="mt-1 col-md-4">
                            <em>Tempat, Tanggal Lahir</em>
                        </div>
                        <div class="mt-1 col-md-8">
                            <input wire:model="tempat_tgl_lahir" type="text" class="underline-input"
                                style="width: 250px;">
                        </div>
                        <div class="mt-1 col-md-4">
                            <em>Tanggal Menerima Bantuan</em>
                        </div>
                        <div class="mt-1 col-md-8">
                            <input wire:model="tgl_bantuan" type="text" class="underline-input"
                                style="width: 250px;">
                        </div>
                        <div class="mt-1 col-md-4">
                            <em>No. HP Penerima manfaat</em>
                        </div>
                        <div class="mt-1 col-md-8">
                            <input wire:model="nohp" type="text" class="underline-input" style="width: 250px;">
                        </div>
                        <div class="mt-1 col-md-4">
                            <em>Jabatan</em>
                        </div>
                        <div class="mt-1 col-md-8">
                            <input wire:model="jabatan" type="text" class="underline-input" style="width: 250px;">
                        </div>

                        <div class="mt-1 col-md-4">
                            <em>Hari,Tanggal Menerima
                                Pentasyarufan</em>
                        </div>
                        <div class="mt-1 col-md-8">
                            <input wire:model="tgl_pentasyarufan" type="text" class="underline-input"
                                style="width: 250px;">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
