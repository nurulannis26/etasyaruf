<div>
    {{-- Do your work, then step back. --}}
    <div>
        {{-- Be like water. --}}
        <div>
            {{-- Because she competes with no one, no one can compete with her. --}}

            {{-- filter --}}
            <div class="card">
                <div class="card-body">

                    {{-- baris 1 --}}
                    <div class="form-row">

                        {{-- periode --}}
                        <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Periode</span>
                                </div>
                                <select wire:loading.attr="disabled" class="form-control">
                                    <option value="">Oktober 2022</option>
                                    <option value="">November 2022</option>
                                    <option value="" selected>Desember 2022</option>
                                </select>
                            </div>
                        </div>
                        {{-- end periode --}}

                        {{-- status --}}
                        <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Status</span>
                                </div>
                                <select wire:loading.attr="disabled" class="form-control">
                                    <option value="">??</option>
                                </select>
                            </div>
                        </div>
                        {{-- end status --}}

                        {{--  upzis  --}}
                        <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">UPZIS</span>
                                </div>
                                <input type="text" class="form-control" value="33.01 Kesugihan">
                            </div>
                            </select>
                        </div>
                        {{-- end upzis --}}

                        {{-- tombol reset --}}
                        <div class="col-12 col-md-1 col-sm-12 mb-2 mb-xl-0">
                            <button class="btn btn-secondary btn-block tombol-reset-pc"
                                wire:click="reset_filter_internal_pc"><i class="fas fa-sync-alt"></i>
                                Reset
                            </button>
                        </div>
                        {{-- end tombol reset --}}

                        {{-- tombol tambah --}}
                        <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                            <button class="btn btn btn-success btn-block" class="btn btn-primary" data-toggle="modal"
                                wire:click="modal_upzis_tambah" data-target="#modal_upzis_tambah" type="button"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah</button>
                        </div>
                        {{-- end tombol tambah --}}

                    </div>
                    {{-- end baris 1 --}}

                    {{-- baris 2 --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        {{-- info --}}
                        <div>
                            <i class="fas fa-info-circle"></i>
                            <span>Menampilkan data pengajuan umum tingkat <b style="font-size: 12pt;">UPZIS MWCNU</b>
                                pada rentang waktu dan tipe
                                transaksi terpilih
                            </span>
                        </div>
                        {{-- end info --}}
                        {{-- ekspor --}}
                        <div>

                            <button class="btn btn-outline-success" disabled>
                                <i class="fas fa-file-pdf"></i> Ekspor</button>
                        </div>
                        {{-- end ekspor --}}
                    </div>
                    {{-- end baris 2 --}}

                </div>
            </div>
            {{-- end filter --}}

            {{-- tabel --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr class="text-center ">
                            <th style="width: 10px;vertical-align:middle;">No</th>
                            <th style="vertical-align:middle;">Nomor Pengajuan</th>
                            <th style="width: 8%;">
                                Jumlah<br>
                                Rencana Kegiatan
                            </th>
                            <th style="width: 8%;vertical-align:middle;">
                                Jumlah<br>
                                Penerima Manfaat
                            </th>
                            <th style="width: 10%;vertical-align:middle;">
                                Jumlah<br>
                                Nominal Diajukan
                            </th>
                            <th style="width: 13%;vertical-align:middle;">Status Pengajuan</th>
                            <th style="width: 13%;vertical-align:middle;">Status Rekomendasi</th>
                            <th style="width: 15%;vertical-align:middle;">PJ <br>Pengambilan Dana</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $a)
                        @empty
                            <tr>
                                <td colspan="8" class="text-center"> Data
                                    tidak ditemukan</td>
                            </tr>
                        @endforelse
                        @foreach ($data as $a)
                            <tr wire:click="detail('{{ $a->id_pengajuan }}')" style=" cursor: pointer;">
                                <td>{{ $loop->iteration }}</td>

                                {{-- nomor pengajuan --}}
                                <td>
                                    <b style="font-size: 12pt;">{{ $a->nomor_surat }}</b> <br>
                                    <span style="font-size: 11pt;">
                                        {{ Carbon\Carbon::parse($a->tgl_pengajuan)->isoFormat('D MMMM Y') }}</span>
                                </td>
                                {{-- end nomor pengajuan --}}

                                {{-- jumlah rencana kegiatan --}}
                                <td>
                                    5
                                </td>
                                {{-- end jumlah rencana kegiatan --}}

                                {{-- jumlah penerima manfaat --}}
                                <td>
                                    40
                                </td>
                                {{-- end jumlah penerima manfaat --}}

                                {{-- jumlah nominal diajukan --}}
                                <td>
                                    Rp,-
                                </td>
                                {{-- end jumlah nominal diajukan --}}

                                {{-- status pengajuan --}}
                                <td>
                                    <div class='btn btn-light btn-block noClick'
                                        style='border-radius:10px; background-color:#cbf2d6'>
                                        {{ $a->status_pengajuan }}
                                    </div>
                                </td>
                                {{-- status pengajuan --}}

                                {{-- status persetujuan --}}
                                <td>
                                    <div class='btn btn-light btn-block noClick'
                                        style='border-radius:10px; background-color:#cbf2d6'>
                                        {{ $a->status_rekomendasi }}
                                    </div>
                                </td>
                                {{-- status persetujuan --}}

                                {{-- pj pengambila dana --}}
                                <td>
                                    {{ $this->nama_pengurus($a->pj) }}<br>
                                    ({{ $this->jabatan_pengurus($a->pj) }})
                                </td>
                                {{-- end pj pengambilan dana --}}

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            {{-- end tabel --}}

            {{-- modal tambah --}}
            @include('modal.modal_upzis_tambah')
            {{-- end modal tambah --}}


        </div>

    </div>

</div>
