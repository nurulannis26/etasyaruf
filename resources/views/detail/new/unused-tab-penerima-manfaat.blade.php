<div class="row">
    <div class="col col-md-12 col-sm-12">
        <div class="card">
            <div class="m-3">
                <i class="fas fa-info-circle"></i> Inputkan data penerima manfaat sesuai jumlah
                penerima manfaat yang direncanakan
            </div>
        </div>
        <div class="card">
            <div class="card-body modal-detail-rencana-pentasyarufan">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fas fa-clipboard-list"></i><b class="ml-2">DAFTAR PENERIMA MANFAAT</b>
                    </div>
                    @if ($data_detail and Auth::user()->gocap_id_upzis_pengurus != null and $data_detail->approval_status != 'Disetujui')
                        <div>
                            <button wire:click="modal_tambah_penerima" data-toggle="modal"
                                data-target="#tambah-penerima" class="btn btn-sm btn-outline-success hover "><i
                                    class="fas fa-plus-circle"></i>
                                Tambah </button>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col col-md-12 col-sm-12">
                        <table class="table table-bordered table-hover mt-3" style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10px;vertical-align:middle;">No</th>
                                    <th style="width: 25%;vertical-align:middle;">Nama Penerima Manfaat</th>
                                    <th style="width: 25%;vertical-align:middle;">Alamat Lengkap</th>
                                    <th style="width: 20%;vertical-align:middle;">Nominal Bantuan <br>
                                        Yang Direncanakan</th>
                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                        <th style="width: 30%;vertical-align:middle;">Keterangan</th>
                                    @endif
                                    @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                        @if ($data_detail and $data_detail->approval_status != 'Disetujui')
                                            <th style="width: 20%;vertical-align:middle;">Keterangan</th>
                                            <th style="width: 10%;vertical-align:middle;">Aksi</th>
                                        @else
                                            <th style="width: 30%;vertical-align:middle;">Keterangan</th>
                                        @endif
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($data_penerima as $a)
                                @empty
                                    <tr>
                                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                                            <td colspan="5" class="text-center"> Data tidak ditemukan</td>
                                        @endif
                                        @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                            @if ($data_detail and $data_detail->approval_status != 'Disetujui')
                                                <td colspan="6" class="text-center"> Data tidak ditemukan</td>
                                            @else
                                                <td colspan="5" class="text-center"> Data tidak ditemukan</td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforelse
                                @foreach ($data_penerima as $a)
                                    <tr style="cursor: pointer;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $a->nama }}<br>
                                            </span></td>
                                        <td>{{ $a->alamat }}</td>
                                        <td class="text-center">
                                            {{ $this->numberFormat($a->nominal_bantuan) }}</td>
                                        <td>{{ $a->keterangan }}</td>
                                        @if ($data_detail and Auth::user()->gocap_id_upzis_pengurus != null and $data->status_rekomendasi == 'Belum Terbit')
                                            <td class="text-center">
                                                <button
                                                    wire:click="modal_edit_penerima('{{ $a->id_pengajuan_penerima }}','{{ $a->nama }}','{{ $a->nominal_bantuan }}','{{ $a->alamat }}','{{ $a->keterangan }}')"
                                                    data-toggle="modal" data-target="#create-edit-penerima"
                                                    class="btn btn-sm btn-outline-secondary hover "><i
                                                        class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click="delete_penerima('{{ $a->id_pengajuan_penerima }}')"
                                                    class="btn btn-sm btn-outline-danger hover "><i
                                                        class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{-- </div> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
