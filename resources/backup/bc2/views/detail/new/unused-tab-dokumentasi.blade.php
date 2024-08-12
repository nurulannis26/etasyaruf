<div class="row">
    <div class="col col-md-7 col-sm-12">
        <div class="card">
            <div class="card-body modal-detail-rencana-pentasyarufan">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fas fa-clipboard-list"></i><b class="ml-2"> DETAIL KEGIATAN</b>
                    </div>
                    <div>
                        <button wire:click="modal_kegiatan('{{ $kegiatan->id_pengajuan_kegiatan ?? null }}')"
                            id="createEditKegiatan" class="btn btn-outline-secondary btn-sm hover">
                            <i class="fas fa-edit"></i>
                            Ubah
                        </button>
                    </div>
                </div>
                <div class="card mt-3 p-4 ">
                    <div class="row">
                        <div class="mt-1 col-md-8">
                            <em>Judul Kegiatan</em><br>
                            <span class="text-bold">{{ $kegiatan->judul ?? '-' }}</span><br>
                        </div>
                        <div class="mt-1 col-md-4">
                            <em>Tgl Kegiatan</em><br>
                            <span
                                class="text-bold">{{ $kegiatan->tgl_kegiatan ?? null != null ? Carbon\Carbon::parse($kegiatan->tgl_kegiatan ?? null)->isoFormat('dddd, D MMMM Y') : '-' }}</span>
                        </div>
                        <div class="mt-1 col-md-8">
                            <em>Lokasi</em><br>
                            <span class="text-bold">{{ $kegiatan->lokasi ?? '-' }}</span><br>
                        </div>
                        <div class="mt-1 col-md-4">
                            <em>Jumlah Kehadiran</em><br>
                            <span class="text-bold">{{ $kegiatan->jumlah_kehadiran ?? '-' }}</span>
                        </div>
                        <div class="mt-1 col-md-12">
                            <em>Kendala Kegiatan</em><br>
                            <span class="text-bold">{{ $kegiatan->kendala ?? '-' }}</span>
                        </div>
                        <div class="mt-1 col-md-12">
                            <em>Ringkasan Kegiatan</em><br>
                            <span class="text-bold">{{ $kegiatan->ringkasan ?? '-' }}</span>
                        </div>
                        <div class="mt-1 col-md-12">
                            <em>Diinput Oleh</em><br>
                            <span
                                class="text-bold">{{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $kegiatan->maker_tingkat_upzis ?? null) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-md-5 col-sm-12">
        <div class="card">
            <div class="card-body modal-detail-rencana-pentasyarufan">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fas fa-clipboard-list"></i><b class="ml-2"> FOTO KEGIATAN</b>
                    </div>
                    <button class="btn btn-outline-success hover btn-sm" data-toggle="collapse"
                        data-target="#showUploadFoto" aria-expanded="false" aria-controls="showUploadFoto">
                        <i class="fas fa-images"></i>
                        Tambah Foto
                    </button>
                </div>
                <div class="mt-3 ">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" wire:ignore.self>
                        <div class="carousel-inner">
                            @php
                                $b = 1;
                                $active = 'active';
                            @endphp
                            @forelse($dataDokumentasi as $a)
                                @if ($b > 1)
                                    @php
                                        $active = '';
                                    @endphp
                                @endif
                                @php
                                    $b++;
                                @endphp
                                <div class="carousel-item {{ $active }}">
                                    <img class="d-block w-100" style="border-radius:10px; "
                                        src="{{ asset('uploads/pengajuan_dokumentasi/' . $a->file) }}"
                                        alt="First slide">
                                    <p class="text-center mt-2">
                                        (<em>{{ $a->judul }}</em>)
                                    </p>
                                </div>
                            @empty
                                <div class="carousel-item active">
                                    <img class="d-block w-100" style="border-radius:10px; "
                                        src="{{ asset('default/no-image.png') }}" alt="First slide">

                                </div>
                            @endforelse
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                @if (session()->has('foto'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('foto') }}
                    </div>
                @endif
                <div class="collapse" id="showUploadFoto" wire:ignore.self>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="form-row">
                                {{-- judul --}}
                                <div class="form-group col-md-12">
                                    <label for="inputNama">JUDUL FOTO &nbsp;</label>
                                    <sup class="badge badge-danger text-white mb-2"
                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                    <input wire:model="judul_foto" type="text" class="form-control"
                                        placeholder="Masukan Judul Foto">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputHP">UPLOAD FOTO KEGIATAN</label>
                                    <sup class="badge badge-danger text-white mb-2"
                                        style="background-color:rgba(230,82,82)">WAJIB
                                        (PNG/JPG/JPEG)</sup>
                                    <div class="custom-file" id="customFileFotoKegiatan">
                                        <input type="file" wire:model="foto_kegiatan"
                                            accept="image/png, image/jpg, image/jpeg" class="custom-file-input"
                                            name="file">
                                        <label class="custom-file-label" for="customFile">Pilih
                                            file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="mr-auto">
                                    <div wire:loading>
                                        <button type="button" class="btn btn-outline-secondary noClick"
                                            data-dismiss="modal">
                                            Harap Tunggu ....</button>
                                    </div>
                                </div>
                                <div class="float-right">
                                    @if ($foto_kegiatan == null)
                                        <button class="btn btn-success " data-toggle="tooltip" data-placement="top"
                                            title="Input Belum Lengkap" disabled wire:loading.attr="disabled"><i
                                                class="fas fa-cloud-upload-alt"></i>
                                            Upload</button>
                                    @else
                                        <button wire:click="uploadFotoKegiatan" class="btn btn-success hover"
                                            id="uploadFotoKegiatan" wire:loading.attr="disabled"><i
                                                class="fas fa-cloud-upload-alt"></i>
                                            Upload</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered mt-2" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 75%;">Judul</th>
                            <th style="width: 25%;text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataDokumentasi as $a)
                        @empty
                            <tr>
                                <td colspan="2" class="text-center"> Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                        @foreach ($dataDokumentasi as $a)
                            <tr>
                                <td>{{ $a->judul }}</td>
                                <td class="text-center">
                                    <button
                                        wire:click="deleteFotoKegiatan('{{ $a->id_pengajuan_dokumentasi }}','{{ $a->file }}')"
                                        class="btn btn-sm btn-outline-danger hover "><i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
