{{-- modal tambah --}}
<div wire:ignore.self class="modal fade" id="modal_penerima_tambah" data-backdrop="static" data-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Penerima Manfaat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- tabbed --}}
            <ul class="nav nav-tabs mt-1" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $tab_a }} {{ $tab_color_a }} noClick" data-toggle="tab"
                        href="#profile" role="tab" aria-controls="profile">1. Jenis
                        Penerima</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab_b }} {{ $tab_color_b }} noClick" data-toggle="tab" href="#home"
                        role="tab" aria-controls="home">2. Data
                        Detail</a>
                </li>
            </ul>



            {{-- tab a --}}
            @if ($tab_a == 'active')

                <div class="modal-body mt-2">
                    <div class="form-row">


                        {{-- tingkat --}}
                        <div class="form-group col-md-6">
                            <label for="inputNama">TINGKAT &nbsp;</label>
                            <input type="text" class="form-control" placeholder="" value="{{ $nama_pc }}"
                                disabled>
                        </div>
                        {{-- end tingkat --}}

                        {{-- wilayah --}}
                        <div class="form-group col-md-6">
                            <label for="inputNama">WILAYAH &nbsp;</label>
                            <input type="text" class="form-control" placeholder="" value="{{ $nama_pc }}"
                                disabled>
                        </div>
                        {{-- end wilayah --}}


                        {{-- jenis penerima --}}
                        <div class="form-group col-md-6">
                            <label for="inputNama">JENIS &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <select class="form-control" wire:model="jenis">
                                <option value="">Pilih jenis</option>
                                <option value="Entitas">Entitas</option>
                                <option value="Perorangan">Perorangan</option>
                            </select>
                        </div>
                        {{-- end jenis penerima --}}



                        {{-- golongan --}}
                        @if ($jenis == 'Perorangan')
                            <div class="form-group col-md-3">
                                <label for="inputNama">GOLONGAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <select class="form-control" wire:model="golongan">
                                    <option value="">Pilih golongan</option>
                                    <option value="Fakir">Fakir</option>
                                    <option value="Miskin">Miskin</option>
                                    <option value="Ghorimin">Ghorimin</option>
                                    <option value="Amil">Amil</option>
                                    <option value="Fisabilillah">Fisabilillah</option>
                                    <option value="Ibnus sabil">Ibnus sabil</option>
                                    <option value="Mualaf">Mualaf</option>
                                    <option value="Riqab">Riqab</option>
                                </select>
                            </div>
                        @endif
                        {{-- end golongan --}}

                        {{-- jenis penerima --}}
                        <div class="form-group  @if ($jenis == 'Perorangan') col-md-3 @else col-md-6 @endif">
                            <label for="inputNama">KATEGORI &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <select class="form-control " wire:model="id_kategori">
                                <option value="">Pilih kategori</option>
                                @foreach ($kategoris as $a)
                                    <option value="{{ $a->id_kategori }}">
                                        {{ $a->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- end jenis penerima --}}

                        @if ($jenis == 'Entitas')
                            {{-- nomor registrasi --}}
                            <div class="form-group col-md-6">
                                <label for="inputTempat">NOMOR REGISTRASI &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input type="text" class="form-control" wire:model="nomor_registrasi"
                                    placeholder="Masukan nomor registrasi">
                            </div>
                            {{-- end nomor registrasi --}}

                            {{-- nomor perijinan --}}
                            <div class="form-group col-md-6">
                                <label for="inputTanggal">NOMOR PERIJINAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input type="text" class="form-control" wire:model="nomor_perijinan"
                                    placeholder="Masukan nama lembaga">
                            </div>
                            {{-- end nomor perijinan --}}

                            {{-- nama lembaga --}}
                            <div class="form-group col-md-6">
                                <label for="inputAlamat">NAMA ENTITAS &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input type="text" class="form-control" wire:model="nama_lembaga"
                                    placeholder="Masukan nama lembaga">
                            </div>
                            {{-- end nama lembaga --}}

                            {{-- nama pimpinan --}}
                            <div class="form-group col-md-6">
                                <label for="inputHP">NAMA PIMPINAN&nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input type="text" class="form-control" placeholder="Masukan nama pimpinan"
                                    wire:model="nama_pimpinan" onkeydown="return /[a-z ]/i.test(event.key)">
                            </div>
                            {{-- end nama pimpinan --}}

                            {{-- alamat --}}
                            <div class="form-group col-md-12">
                                <label for="inputAlamat">ALAMAT ENTITAS&nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <textarea type="text" class="form-control" wire:model="alamat_lembaga" placeholder="Masukan alamat lembaga"
                                    rows="4"> </textarea>
                            </div>
                            {{-- end alamat --}}
                        @endif
                    </div>
                </div>
                {{-- end tab a --}}

            @endif

            {{-- footer --}}
            <div class="modal-footer">

                @if ($tab_a == 'active')

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>

                    {{-- validasi perorangan --}}
                    @if ($jenis == 'Perorangan' or $jenis == '')
                        @if ($id_kategori == '' or $golongan == '')
                            <button type="button" class="btn btn-success" wire:loading.attr="disabled" disabled>
                                Selanjutnya <i class="fas fa-forward"></i></button>
                        @else
                            <div wire:click="selanjutnya">
                                <button class="btn btn-success" wire:loading.attr="disabled">
                                    Selanjutnya <i class="fas fa-forward"></i></button>
                            </div>
                        @endif
                    @endif
                    {{-- end validasi perorangan --}}

                    {{-- validasi entitas --}}
                    @if ($jenis == 'Entitas')
                        @if ($id_kategori == '' or
                            $nomor_registrasi == '' or
                            $nomor_perijinan == '' or
                            $nama_lembaga == '' or
                            $nama_pimpinan == '' or
                            $alamat_lembaga == '')
                            <button wire:click="selanjutnya" type="button" class="btn btn-success"
                                wire:loading.attr="disabled" disabled>
                                Selanjutnya <i class="fas fa-forward"></i></button>
                        @else
                            <div wire:click="selanjutnya">
                                <button class="btn btn-success" wire:loading.attr="disabled">
                                    Selanjutnya <i class="fas fa-forward"></i></button>
                            </div>
                        @endif
                    @endif
                    {{-- end validasi entitas --}}

                @endif

                @if ($tab_b == 'active')
                    <button wire:click="kembali" class="btn btn-primary mr-auto"><i class="fas fa-backward"></i>
                        Kembali </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>

                    <div wire:click="selanjutnya">
                        <button class="btn btn-success" wire:loading.attr="disabled">
                            Selanjutnya <i class="fas fa-forward"></i></button>
                    </div>
                @endif


            </div>
            {{-- end footer --}}


        </div>
    </div>
</div>

{{-- end modal --}}
