<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

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
                                    <span>Menampilkan data pemohon di {{ $nama_pc }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- end info --}}

                        {{-- tombol tambah --}}
                        <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                            <button class="btn btn btn-success btn-block" class="btn btn-primary" data-toggle="modal"
                                wire:click="modal_pemohon_tambah" data-target="#modal_pemohon_tambah" type="button"><i
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
                    {{-- @forelse($data as $object)
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
                    @endforeach --}}
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


</div>
