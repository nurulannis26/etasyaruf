<div>
    {{-- Be like water. --}}
    <div>
        {{-- Because she competes with no one, no one can compete with her. --}}

        {{-- filter --}}
        <div class="card">
            <div class="card-body">

                {{-- baris 1 --}}
                <div class="form-row">

                    {{-- tanggal mulai --}}
                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Tgl Mulai</span>
                            </div>
                            <input wire:model="tanggal_mulai" id="tanggal_mulai" wire:loading.attr="disabled"
                                type="date" class="form-control" placeholder="Tanggal Mulai" max="">
                        </div>
                    </div>
                    {{-- end tanggal mulai --}}

                    {{-- tanggal selesai --}}
                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Tgl Selesai</span>
                            </div>
                            <input wire:model="tanggal_selesai" id="tanggal_selesai" wire:loading.attr="disabled"
                                type="date" class="form-control" placeholder="Tanggal selesai" min="">
                        </div>
                    </div>
                    {{-- end tanggal selesai --}}

                    {{--  program  --}}
                    <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <select wire:model="id_program" wire:loading.attr="disabled" id="id_program"
                            class="form-control">
                            <option value="">Semua Program</option>
                            {{-- @foreach ($program as $a)
                                <option value="{{ $a->id_program }}">
                                    {{ $a->program }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    {{-- end program --}}

                    {{--  wilayah upzis  --}}
                    <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <select wire:model="id_program" wire:loading.attr="disabled" id="id_program"
                            class="form-control">
                            <option value="">Wilayah Upzis</option>
                            {{-- @foreach ($program as $a)
                                <option value="{{ $a->id_program }}">
                                    {{ $a->program }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    {{-- end wilayah upzis --}}

                    {{--  wilayah ranting  --}}
                    <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <select wire:model="id_program" wire:loading.attr="disabled" id="id_program"
                            class="form-control">
                            <option value="">Wilayah Ranting</option>
                            {{-- @foreach ($program as $a)
                                <option value="{{ $a->id_program }}">
                                    {{ $a->program }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    {{-- end wilayah ranting --}}

                    {{-- tombol tambah --}}
                    {{-- <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                        <button class="btn btn btn-success btn-block" class="btn btn-primary" data-toggle="modal"
                            wire:click="modal_tambah" data-target="#modal_tambah" type="button"><i
                                class="fas fa-plus-circle"></i>
                            Tambah</button>
                    </div> --}}
                    {{-- end tombol tambah --}}

                </div>
                {{-- end baris 1 --}}

                {{-- baris 2 --}}
                <div class="form-row mt-2">

                    {{-- info --}}
                    <div class="col-12 col-md-10 col-sm-12 mb-2 mb-xl-0">
                        <div class="d-flex flex-row bd-highlight align-items-center">
                            <div class="p-2 bd-highlight">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="p-1 bd-highlight">
                                <span>Menampilkan data pengajuan pentasyarufan umum TINGKAT RANTING NU pada rentang
                                    waktu, program, dan wilayah terpilih
                                </span>
                            </div>
                        </div>
                    </div>
                    {{-- end info --}}


                    {{-- tombol reset --}}
                    <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                        <button class="btn btn-secondary btn-block tombol-reset-pc"
                            wire:click="reset_filter_internal_pc"><i class="fas fa-sync-alt"></i>
                            Reset
                        </button>
                    </div>
                    {{-- end tombol reset --}}

                    {{-- tombol ekspor --}}
                    <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                        <button class="btn btn-block btn-outline-success" disabled>
                            <i class="fas fa-file-pdf"></i> Ekspor</button>
                    </div>
                    {{-- end tombol ekspor --}}

                </div>
                {{-- end baris 2 --}}

            </div>
        </div>
        {{-- end filter --}}

        {{-- tabel --}}
        <div class="table-responsive">
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 10px;">No</th>

                        <th>Wilayah</th>
                        <th>Pengajuan</th>
                        <th>Penerima Manfaat</th>
                        <th>Program</th>
                        <th style="width: 175px;">Status </th>
                        <th style="width: 175px;">Kegiatan & Penyaluran</th>
                        <th style="width: 175px;">Berita </th>
                        <th>Aksi</th>
                    </tr>
                </thead>


                <tbody>
                    {{-- jika tabel kosong --}}
                    <tr>
                        <td>1</td>
                        <td>A01-Adipala</td>
                        <td><b class="text-success">Rp5.000.000</b><br>
                            11 September 2001<br>
                            {{-- {{ Carbon\Carbon::parse($permohonan->created_at)->format('H:i:s') }} --}}
                        </td>
                        <td>

                            <b style="font-size: 16px">Surya Aji Sevyanto</b><br>
                            Jenis A<br>
                            Katgeoir A

                        </td>

                        <td>
                            <b style="font-size: 16px">Sosial</b><br>
                            Bentuk Program A
                        </td>

                        <td>
                            <div class='btn btn-light btn-block noClick'
                                style='border-radius:10px; background-color:#cccccc'>
                                Belum Disurvey
                            </div>
                            Divisi Program <br>
                            Raffi Riau Navallah
                        </td>

                        {{-- kegiatan --}}
                        <td>

                            <div class='btn btn-light btn-block noClick'
                                style='border-radius:10px;  background-color:#cccccc'>
                                Belum Diinput
                            </div>

                            Divisi Program <br>
                            Raffi Riau Navallah


                        </td>



                        <td>


                            <div class='btn btn-light btn-block noClick'
                                style='border-radius:10px; background-color:#cbf2d6'>
                                Terbit
                            </div>


                            {{-- judul berita --}}

                            Jduul Berita A


                            {{-- tanggal terbit --}}
                            <br>
                            9 September 2001
                        </td>

                        <td style="width: 10%;">

                            <!-- Example split danger button -->
                            <div class="btn-group">

                                <button type="button" class="btn btn-success" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Kelola</button>
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='black'"
                                        class="dropdown-item" href="/{{ $role }}/detail-pengajuan"
                                        type="button"><i class="fas fa-edit"></i>
                                        Detail</a>
                                    <a onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                        class="dropdown-item" wire:click="modal_hapus" data-toggle="modal"
                                        data-target="#modal_hapus" type="button"><i class="fas fa-trash"></i>
                                        Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        {{-- end tabel --}}

        {{-- modal tambah --}}
        {{-- @include('modal.modal_tambah_pengajuan_pc') --}}
        {{-- end modal tambah --}}


    </div>

</div>
