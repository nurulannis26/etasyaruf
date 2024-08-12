a<div wire:ignore.self class="modal fade" id="lampiran" data-keyboard="true" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    DETAIL LAMPIRAN
                </h5>
                <div>
                    <button wire:click="batalLaporan" type="button" class="close" data-dismiss="modal"
                        onclick="batalLampiranBerita()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <div class="modal-body">
                <div class="card mt-2 p-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="text-bold">
                                Penerima Manfaat
                            </span>
                            <br>
                            <span>
                                {{ $penerima_lpj->nama ?? null }}
                            </span>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->gocap_id_upzis_pengurus != null and $data_detail and $data_detail->status_berita != 'Sudah Diperiksa')
                    <form wire:submit.prevent="uploadLampiranPenerimaLPJ">
                        <div class="form-row">
                            <div class="form-group col-md-12 ">
                                <label for="inputNama">JUDUL LAMPIRAN</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="judul_file" type="text" class="form-control"
                                    placeholder="Masukan Judul Lampiran">
                            </div>
                            {{-- lampiran --}}
                            <div class="form-group col-md-8">
                                <label for="inputHP">UPLOAD LAMPIRAN</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <div class="custom-file" id="customFileLampiran">
                                    <input type="file" wire:model="file"
                                        accept="application/pdf, image/png, image/jpg, image/jpeg"
                                        class="custom-file-input" name="file">
                                    <label class="custom-file-label" for="customFile">Pilih
                                        file</label>
                                </div>
                            </div>

                            <div class="form-group col-md-4 mt-2">
                                @if ($file == null)
                                    <label for="inputHP"></label>
                                    <button type="submit" class="btn btn-success btn-block hover" id="UploadLampiran"
                                        disabled wire:loading.attr="disabled">Upload
                                    </button>
                                @elseif ($judul_file == null)
                                    <label for="inputHP"></label>
                                    <button type="submit" class="btn btn-success btn-block hover" id="UploadLampiran"
                                        disabled wire:loading.attr="disabled">Upload
                                    </button>
                                @else
                                    <label for="inputHP"></label>
                                    <button type="submit" class="btn btn-success btn-block hover" id="UploadLampiran"
                                        wire:loading.attr="disabled">Upload
                                    </button>
                                @endif

                            </div>
                        </div>
                    </form>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="far fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <table class="table table-bordered  mt-1" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50%">
                                Judul Lampiran
                            </th>
                            <th class="text-center" style="width: 30%">
                                Tgl Upload
                            </th>

                            @if (Auth::user()->gocap_id_upzis_pengurus != null and $data_detail and $data_detail->status_berita != 'Sudah Diperiksa')
                                <th class="text-center">Aksi</th>
                            @else
                                <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_lampiran as $a)
                            <tr>
                                <td>

                                    {{ $a->judul_file }}
                                </td>
                                <td class="text-center">
                                    {{ Carbon\Carbon::parse($a->created_at)->isoFormat('DD-MM-Y') }}

                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Detail
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{ asset('uploads/lampiran_penerima_lpj/' . str_replace('/', '_', $data->nomor_surat ?? null) . '/' . $a->file) }}"
                                                download="{{ $a->judul_file }}" class="dropdown-item">Download</a>
                                            @if (Auth::user()->gocap_id_upzis_pengurus != null and $data_detail and $data_detail->status_berita != 'Sudah Diperiksa')
                                                <a class="dropdown-item"
                                                    wire:click="deleteLampiranLPJ('{{ $a->id_lampiran_lpj }}','{{ $a->file }}')"
                                                    data-toggle="modal" type="button">Hapus</a>
                                            @endif

                                        </div>
                                    </div>

                                </td>
                            </tr>

                        @empty
                            <tr>
                                @if (Auth::user()->gocap_id_upzis_pengurus != null and $data_detail and $data_detail->status_berita != 'Sudah Diperiksa')
                                    <td colspan="2" class="text-center">
                                        Belum
                                        ada lampiran</td>
                                @else
                                    <td colspan="2" class="text-center">
                                        Belum
                                        ada lampiran</td>
                                @endif

                            </tr>
                        @endforelse

                    </tbody>
                </table>


            </div>


            {{-- footer --}}
            <div class="modal-footer">
                <div class="float-right">
                    <button wire:click="batalLaporan" type="button" class="btn btn-secondary hover"
                        onclick="batalLampiranBerita()" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>

                </div>
            </div>


        </div>
    </div>
</div>
