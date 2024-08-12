<div>
    {{-- Stop trying to control. --}}

    {{-- header --}}
    <div class="card ijo-atas">
        <div class="card-body">

            {{-- judul --}}
            <div class="row ">
                <div class="col-4 pr-0 d-highlight pr-0 mr-0 ">
                    <h5 class="d-flex ">
                        <b class="text-success">DETAIL PROGRAM</b>
                    </h5>

                </div>
            </div>
            {{-- end judul --}}

            {{-- card info --}}
            <div class="card mt-2">
                <div class="card-body">
                    <div class="form-row">

                        {{-- info --}}
                        <div class="col-12 col-md-8 col-sm-12 mb-2 mb-xl-0">
                            <div class="d-flex flex-row bd-highlight align-items-center">
                                <div class="p-2 bd-highlight">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div class="p-1 bd-highlight">
                                    <span>Menampilkan daftar program, pilar, dan kegiatan pentasyarufan
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- end info --}}

                        {{-- tombol tambah --}}
                        <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 text-right">
                            <button class="btn btn btn-outline-success" type="button">
                                Jumlah Pilar : 30</button>
                        </div>
                        {{-- end tombol tambah --}}

                    </div>
                </div>
            </div>
            {{-- card info --}}

            {{-- alert --}}
            @if (session()->has('alert_pilar'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="far fa-check-circle"></i>
                    {{ session('alert_pilar') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- tabel --}}
            <table class="table table-bordered table-hover" style="width:100%" wire:ignore.self>
                <thead>
                    <tr>
                        <th style="width: 10px;">No</th>
                        <th>Nama Pilar</th>
                        <th style="width:10%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- jika tabel kosong --}}
                    @forelse($data as $object)
                    @empty
                        <tr>
                            <td colspan="3" class="text-center"> Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                    @foreach ($data as $a)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <a data-toggle="collapse" href="#multiCollapseExample{{ $loop->iteration }}"
                                    role="button" class="text-dark" aria-expanded="false"
                                    aria-controls="multiCollapseExample{{ $loop->iteration }}">
                                    {{ $a->pilar }}
                                </a>
                                <div wire:ignore class="col">
                                    <div class="collapse multi-collapse ml-2"
                                        id="multiCollapseExample{{ $loop->iteration }}">
                                        @php
                                            $kegs = DB::table('program_kegiatan')
                                                ->where('id_program_pilar', $a->id_program_pilar)
                                                ->get();
                                        @endphp
                                        @foreach ($kegs as $b)
                                            <a wire:click="modal_ubah_kegiatan('{{ $b->id_program_kegiatan }}')"
                                                onMouseOver="this.style.color='green'"
                                                onMouseOut="this.style.color='black'" data-toggle="modal"
                                                data-target="#modal_ubah_kegiatan"
                                                type="button">{{ $loop->iteration }}.
                                                {{ $b->kegiatan }}</a><br>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">Kelola</button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">

                                        <a onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                            class="dropdown-item"
                                            wire:click="modal_ubah_kegiatan('{{ $a->id_program_pilar }}')"
                                            data-toggle="modal" data-target="#modal_ubah_kegiatan" type="button"><i
                                                class="fas fa-trash"></i>
                                            Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- end tabel --}}
        </div>
    </div>
    {{-- end header --}}



    {{-- modal ubah kegiatan --}}
    <div wire:ignore.self class="modal fade" id="modal_ubah_kegiatan" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">


        <div class="modal-dialog modal-md">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">KEGIATAN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- form --}}
                <form wire:submit.prevent="ubah_kegiatan">
                    <div class="modal-body mt-2">
                        <div id="form-baru">
                            <div class="form-row">

                                {{-- nama kegiatan --}}
                                <div class="form-group col-md-12">
                                    <label for="inputTempat">NAMA KEGIATAN &nbsp;</label>
                                    <sup class="badge badge-danger text-white mb-2"
                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                    <input type="text" class="form-control @error('kegiatan') is-invalid @enderror"
                                        wire:model="kegiatan" placeholder="Masukan nama kegiatan">
                                </div>
                                {{-- end nama kegiatan --}}

                            </div>
                        </div>
                    </div>

                    {{-- footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mr-auto" data-dismiss="modal"><i
                                class="fas fa-trash"></i>
                            Hapus</button>
                        <button type="button" class="btn btn-secondary " data-dismiss="modal"><i
                                class="fas fa-ban"></i>
                            Batal</button>
                        @if ($kegiatan == '')
                            <button class="btn btn-success" wire:loading.attr="disabled" disabled><i
                                    class="fas fa-save"></i>
                                Simpan Perubahan</button>
                        @else
                            <button class="btn btn-success" type="submit" name="submit"
                                wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                Simpan Perubahan</button>
                        @endif
                    </div>
                    {{-- endfooter --}}

                </form>
                {{-- endform --}}

            </div>
        </div>
    </div>
    {{-- end modal ubah kegiatan --}}






</div>
