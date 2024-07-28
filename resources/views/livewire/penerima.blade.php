<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="card ijo-atas">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row ">
                <div class="col-4 pr-0 d-highlight pr-0 mr-0 ">
                    <h5 class="d-flex ">
                        <b class="text-success">DATA PEMOHON</b>
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
                                    <span>Menampilkan data penerima di {{ $nama_pc }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- end info --}}

                        {{-- tombol tambah --}}
                        <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                            <button class="btn btn btn-success btn-block" class="btn btn-primary" data-toggle="modal"
                                wire:click="modal_penerima_tambah" data-target="#modal_penerima_tambah"
                                type="button"><i class="fas fa-plus-circle"></i>
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
                        <th>Nama</th>
                        <th>No HP</th>
                        <th style="width: 20%;">Alamat</th>
                        <th style="width: 10%;">Golongan</th>
                        <th style="width: 10%;">Kategori</th>
                        <th style="width: 10%;">Pentasyarufan</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- jika tabel kosong --}}
                    @forelse($data as $object)
                    @empty
                        <tr>
                            <td colspan="8" class="text-center"> Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                    @foreach ($data as $a)
                        <tr @if ($id_program == $a->id_program) style="background-color:#ECECEC;" @endif>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $a->nama }}</td>
                            <td>{{ $a->nohp }}</td>
                            <td>{{ $a->alamat }}</td>
                            <td>{{ $a->golongan }}</td>
                            <td>{{ $a->kategori }}</td>
                            <td>20</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-right">
                {{-- pagination --}}
                {{-- {{ $data->links() }} --}}
            </div>
            {{-- end tabel --}}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    @include('modal.modal_penerima_tambah')

</div>
