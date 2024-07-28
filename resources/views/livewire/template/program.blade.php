<div>
    {{-- Stop trying to control. --}}
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="card ijo-atas">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row ">
                <div class="col-4 pr-0 d-highlight pr-0 mr-0 ">
                    <h5 class="d-flex ">
                        <b class="text-success">DATA PROGRAM</b>
                    </h5>

                </div>
            </div>

            {{-- filter --}}
            <div class="card mt-2">
                <div class="card-body">

                    {{-- baris 1 --}}
                    <div class="form-row">

                        {{-- info --}}
                        <div class="col-12 col-md-9 col-sm-12 mb-2 mb-xl-0">
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
                        <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                            <button class="btn btn btn-success btn-block" class="btn btn-primary" data-toggle="modal"
                                wire:click="modal_tambah" data-target="#modal_tambah" type="button"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah</button>
                        </div>
                        {{-- end tombol tambah --}}

                        {{-- tombol ekspor --}}
                        <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                            <button class="btn btn-block btn-outline-success" disabled>
                                <i class="fas fa-file-pdf"></i> Ekspor</button>
                        </div>
                        {{-- end tombol ekspor --}}

                    </div>
                    {{-- end baris 1 --}}


                </div>
            </div>
            {{-- end filter --}}

            {{-- tabel --}}
            <table class="table table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 10px;">No</th>
                        <th>Nama Program</th>
                        <th style="width: 12%;">Jumlah Pilar</th>
                        <th style="width: 12%;">Jumlah Kegiatan</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- jika tabel kosong --}}
                    @forelse($data as $object)
                    @empty
                        <tr>
                            <td colspan="4" class="text-center"> Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                    @foreach ($data as $a)
                        <tr wire:click="click_pilar('{{ $a->id_program }}','{{ $a->program }}')"
                            @if ($id_program == $a->id_program) style="background-color:#ECECEC;" @endif>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $a->program }}</td>
                            <td>{{ $this->jumlah_pilar($a->id_program) }}</td>
                            <td>{{ $this->jumlah_kegiatan($a->id_program) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-right">
                {{-- pagination --}}
                {{ $data->links() }}
            </div>
            {{-- end tabel --}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->



    <div class="row">

        {{-- card pilar --}}
        <div class="col col-md-4 col-sm-12">
            <div class="card ijo-atas">
                <b class="d-flex justify-content-center mt-3 ">Daftar Pilar </b>

                {{-- nama pilar --}}
                @if ($pilars != null)
                    <span class="d-flex justify-content-center ">({{ $program }})</span>
                @endif
                {{-- end nama pilar --}}

                <div class="card-body ">

                    {{-- info --}}
                    @if ($pilars == null)
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-info-circle"></i> Pilih program terlebih dahulu
                            </div>
                        </div>
                    @endif
                    {{-- end info --}}

                    {{-- alert --}}
                    @if (session()->has('alert_pilar'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="far fa-check-circle"></i> {{ session('alert_pilar') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    {{-- end alert --}}

                    {{-- tabel --}}
                    @if ($pilars != null)
                        {{-- jika tabel kosong --}}
                        @forelse($pilars as $object)
                        @empty
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-info-circle"></i> Program belum memiliki pilar
                                </div>
                            </div>
                        @endforelse
                        <table class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;vertical-align:middle;">No</th>
                                    <th class="align-middle">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div> Nama Pilar</div>
                                            {{-- tombol tambah --}}
                                            <button class="btn btn-sm btn-success float-right" data-toggle="modal"
                                                wire:click="modal_pilar_tambah" data-target="#modal_pilar_tambah"
                                                type="button"><i class="fas fa-plus-circle"></i>
                                                Tambah</button>
                                            {{-- end tombol tambah --}}
                                        </div>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pilars as $object)
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center"> Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                                @foreach ($pilars as $a)
                                    <tr wire:click="click_kegiatan('{{ $a->id_program_pilar }}','{{ $a->pilar }}')"
                                        @if ($id_program_pilar == $a->id_program_pilar) style="background-color:#ECECEC;" @endif>
                                        <td
                                            wire:click="click_kegiatan('{{ $a->id_program_pilar }}','{{ $a->pilar }}')">
                                            {{ $loop->iteration }}</td>
                                        <td
                                            wire:click="click_kegiatan('{{ $a->id_program_pilar }}','{{ $a->pilar }}')">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div> {{ $a->pilar }}</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{-- tombol tambah --}}
                                                    <button class="btn btn-sm btn-primary float-right mr-2"
                                                        data-toggle="modal"
                                                        wire:click="modal_pilar_ubah('{{ $a->id_program_pilar }}','{{ $a->pilar }}')"
                                                        data-target="#modal_pilar_ubah" type="button"><i
                                                            class="fas fa-edit"></i> Ubah
                                                    </button>
                                                    <button class="btn btn-sm btn-danger float-right"
                                                        data-toggle="modal"
                                                        wire:click="modal_pilar_hapus('{{ $a->id_program_pilar }}')"
                                                        data-target="#modal_pilar_hapus" type="button"><i
                                                            class="fas fa-trash"></i> Hapus
                                                    </button>
                                                    {{-- end tombol tambah --}}
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    {{-- end tabel --}}

                </div>
            </div>
        </div>
        {{-- end pilar --}}

        {{--  kegiatan --}}
        <div class="col col-md-8 col-sm-12">
            <div class="card ijo-atas">
                <b class="d-flex justify-content-center mt-3 ">Daftar Kegiatan </b>

                {{-- nama kegiatan --}}
                @if ($kegiatans != null)
                    <span class="d-flex justify-content-center ">({{ $pilar }})</span>
                @endif
                {{-- end nama kegiatan --}}

                <div class="card-body ">

                    {{-- info --}}
                    @if ($kegiatans == null)
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-info-circle"></i> Pilih pilar terlebih dahulu
                            </div>
                        </div>
                    @endif
                    {{-- end info --}}

                    {{-- alert --}}
                    @if (session()->has('alert_kegiatan'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="far fa-check-circle"></i> {{ session('alert_kegiatan') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    {{-- end alert --}}

                    {{-- tabel --}}
                    @if ($kegiatans != null)
                        {{-- jika tabel kosong --}}
                        @forelse($kegiatans as $object)
                        @empty
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-info-circle"></i> Pilar {{ $pilar }} belum memiliki
                                    kegiatan
                                </div>
                            </div>
                        @endforelse
                        <table class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;vertical-align:middle;">No</th>
                                    <th class="align-middle">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div> Nama Kegiatan</div>

                                            <div class="d-flex  align-items-center">
                                                {{-- search --}}
                                                <div class="col-8 input-group ">
                                                    <input wire:model="search_pc" type="search"
                                                        class="form-control form-control-sm" placeholder="Cari"
                                                        value="">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-sm btn-default noClick">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                {{-- end search --}}

                                                {{-- tombol tambah --}}
                                                <button class="col-4 btn btn-sm btn-success float-right"
                                                    data-toggle="modal" wire:click="modal_kegiatan_tambah"
                                                    data-target="#modal_kegiatan_tambah" type="button"><i
                                                        class="fas fa-plus-circle"></i>
                                                    Tambah</button>
                                                {{-- end tombol tambah --}}
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kegiatans as $object)
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center"> Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                                @foreach ($kegiatans as $a)
                                    <tr @if ($id_program_kegiatan == $a->id_program_kegiatan) style="background-color:#ECECEC;" @endif>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div> {{ $a->kegiatan }}</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    {{-- tombol tambah --}}
                                                    <button class="btn btn-sm btn-primary float-right mr-2"
                                                        data-toggle="modal"
                                                        wire:click="modal_kegiatan_ubah('{{ $a->id_program_kegiatan }}','{{ $a->kegiatan }}')"
                                                        data-target="#modal_kegiatan_ubah" type="button"><i
                                                            class="fas fa-edit"></i> Ubah
                                                    </button>
                                                    <button class="btn btn-sm btn-danger float-right"
                                                        data-toggle="modal"
                                                        wire:click="modal_kegiatan_hapus('{{ $a->id_program_kegiatan }}')"
                                                        data-target="#modal_kegiatan_hapus" type="button"><i
                                                            class="fas fa-trash"></i> Hapus
                                                    </button>
                                                    {{-- end tombol tambah --}}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="float-right mt-1">
                            <small>
                                {{-- pagination --}}
                                {{ $kegiatans->links() }}
                            </small>
                        </div>
                    @endif
                    {{-- end tabel --}}

                </div>
            </div>
        </div>
        {{-- end card kegiatan --}}
    </div>

    {{-- pilar --}}
    @include('modal.modal_pilar_tambah')
    @include('modal.modal_pilar_ubah')
    @include('modal.modal_pilar_hapus')

    {{-- kegiatan --}}
    @include('modal.modal_kegiatan_tambah')
    @include('modal.modal_kegiatan_ubah')
    @include('modal.modal_kegiatan_hapus')

</div>
