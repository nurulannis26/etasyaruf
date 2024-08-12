{{-- alert --}}
@if (session()->has('alert_penerima'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="far fa-check-circle"></i> {{ session('alert_penerima') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
{{-- end alert --}}

{{-- form --}}
@if (Auth::user()->gocap_id_upzis_pengurus != null)
    <form wire:submit.prevent="tambah_ubah_penerima">
        <div class="form-row modal-detail-persetujuan-penerima-manfaat-filter">

            {{-- NAMA PENERIMA MANFAAT --}}
            <div class="form-group col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bor-abu">Nama</span>
                    </div>
                    <input wire:model="nama" type="text" class="form-control" {{ $autofocus }}
                        placeholder="Masukan Nama Penerima Manfaat">
                </div>

            </div>
            {{-- end NAMA PENERIMA MANFAAT --}}


            {{-- ALAMAT LENGKAP --}}
            <div class="form-group col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bor-abu">Alamat</span>
                    </div>
                    <input wire:model="alamat" type="text" class="form-control"
                        placeholder="Masukan Alamat Penerima Manfaat">
                </div>
            </div>
            {{-- end ALAMAT LENGKAP --}}

            {{-- NOMINAL BANTUAN --}}
            <div class="form-group col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bor-abu">Rp</span>
                    </div>
                    <input wire:model="nominal_bantuan" type="text" class="form-control nominal_bantuan"
                        id="nominal_bantuan" placeholder="Nominal Bantuan">
                </div>
            </div>
            {{-- end NOMINAL BANTUAN --}}



            {{-- KETERANGAN --}}
            <div class="form-group col-md-5">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bor-abu">Keterangan</span>
                    </div>
                    <input wire:model="keterangan" type="text" class="form-control" placeholder="Masukan Keterangan">
                </div>
            </div>
            {{-- end KETERANGAN --}}


            <div class="form-group col-md-1 modal-detail-persetujuan-penerima-manfaat-clear-filter">
                <a wire:click="reset_penerima" class="btn btn-secondary btn-block" wire:loading.attr="disabled">
                    Clear</a>
            </div>

            @if ($id_pengajuan_penerima == null)
                <div class="form-group col-md-3 modal-detail-persetujuan-penerima-manfaat-tambah">
                    @if ($nama == '' or $alamat == '' or $nominal_bantuan == '' or $keterangan == '')
                        <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                    @else
                        <button type="submit" name="submit" class="btn btn-success btn-block"
                            wire:loading.attr="disabled">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                    @endif
                </div>
            @else
                <div class="form-group col-md-1">
                    <a wire:click="hapus_penerima" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                        Hapus
                    </a>
                </div>

                <div class="form-group col-md-2">
                    @if ($nama == '' or $alamat == '' or $nominal_bantuan == '' or $keterangan == '')
                        <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    @else
                        <button type="submit" name="submit" class="btn btn-success btn-block"
                            wire:loading.attr="disabled">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    @endif
                </div>
            @endif

        </div>
    </form>
@endif
{{-- end form --}}


<div class="m-3">
    {{-- info --}}
    <i class="fas fa-info-circle"></i> Inputkan data penerima manfaat sesuai jumlah
    penerima manfaat yang direncanakan
    <br>
</div>


{{-- tabel --}}
{{-- <div class="table-responsive"> --}}
<table class="table table-bordered table-hover modal-detail-persetujuan-penerima-manfaat-table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th style="width: 10px;vertical-align:middle;">No</th>
            <th style="width: 25%;vertical-align:middle;">Nama Penerima Manfaat</th>
            <th style="width: 35%;vertical-align:middle;">Alamat Lengkap</th>
            <th style="width: 20%;vertical-align:middle;">Nominal Bantuan <br>
                Yang Direncanakan</th>
            <th style="width: 20%;vertical-align:middle;">Keterangan</th>
        </tr>
    </thead>

    <tbody>
        @forelse($penerima as $a)
        @empty
            <tr>
                <td colspan="5" class="text-center"> Data
                    tidak ditemukan</td>
            </tr>
        @endforelse
        @foreach ($penerima as $a)
            <tr wire:click="detail_penerima('{{ $a->id_pengajuan_penerima }}')"
                style="cursor: pointer;
                    @if ($id_pengajuan_penerima == $a->id_pengajuan_penerima) background-color:#ECECEC; @endif">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $a->nama }}<br> <span style="font-size: 10pt">Diinput Oleh :
                        {{ $this->nama_pengurus_upzis($a->maker_tingkat_upzis) }}
                        ({{ $this->jabatan_pengurus_upzis($a->maker_tingkat_upzis) }})
                    </span></td>
                <td>{{ $a->alamat }}</td>
                <td class="text-center">
                    Rp{{ number_format($a->nominal_bantuan, 0, '.', '.') }},-</td>
                <td>{{ $a->keterangan }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
{{-- </div> --}}
