@if (session()->has('alert_kegiatan'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="far fa-check-circle"></i>
        {{ session('alert_kegiatan') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (Auth::user()->gocap_id_upzis_pengurus != null)
    @if ($status_rekomendasi == 'Belum Terbit')
        {{-- alert --}}
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-minus-circle"></i> Tidak bisa membuat laporan kegiatan, karena lembar rekomendasi belum
            terbit
        </div>
        {{-- end alert --}}
    @endif
@endif

<div class="row">


    <div class="col col-md-12 col-sm-12">
        <div class="card card-body">
            <div class="row">

                {{-- card detail kegiatan --}}
                <div class="col col-md-8 col-sm-12">
                    {{-- detail --}}

                    {{-- form --}}
                    <form wire:submit.prevent="ubah_kegiatan">

                        <div class="modal-detail-kegiatan-dokumentasi_panduan">
                            <div class="form-row ">
                                <div
                                    class="col-12 @if ($none_block_kegiatan == 'none') col-md-10 @else col-md-8 @endif col-sm-12 mb-2 mb-xl-0">
                                    <div class="d-flex flex-row bd-highlight align-items-center">
                                        <div class="p-2 bd-highlight mb-1">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                        <div class="p-1 bd-highlight mb-1">
                                            <b> DETAIL
                                                KEGIATAN </b>
                                        </div>
                                    </div>
                                </div>

                                @if ($status_rekomendasi == 'Belum Terbit')
                                    @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                        <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                            <button class="btn btn-outline-secondary btn-sm btn-block"
                                                data-toggle="tooltip" data-placement="bottom"
                                                title="Laporan kegiatan dapat diakses ketika lembar rekomendasi sudah terbit"
                                                disabled>
                                                <i class="fas fa-edit"></i>
                                                Ubah
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                        @if ($none_block_kegiatan == 'none')
                                            <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                <a wire:click="tombol_ubah_detail_kegiatan"
                                                    class="btn btn-outline-secondary btn-sm btn-block">
                                                    <i class="fas fa-edit"></i>
                                                    Ubah
                                                </a>
                                            </div>
                                        @else
                                            <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                <a wire:click="tombol_batal_detail_kegiatan "
                                                    class="btn btn-secondary btn-sm btn-block">
                                                    <i class="fas fa-ban"></i>
                                                    Batal </a>
                                            </div>

                                            <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                @if (
                                                    $tgl_kegiatan == '' or
                                                        $lokasi == '' or
                                                        $judul == '' or
                                                        $jumlah_kehadiran == '' or
                                                        $kendala == '' or
                                                        $ringkasan == '')
                                                    <button class="btn btn-success btn-sm btn-block" disabled
                                                        wire:loading.attr="disabled"> <i class="fas fa-save"></i>
                                                        Simpan </button>
                                                @else
                                                    <button type="submit" name="submit"
                                                        class="btn btn-success btn-sm btn-block"
                                                        wire:loading.attr="disabled">
                                                        <i class="fas fa-save"></i>
                                                        Simpan </button>
                                                @endif
                                            </div>



                                        @endif
                                    @endif
                                @endif

                            </div>



                            <table class="table table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <td class="text-bold" style="width: 30%;">Tanggal
                                        </td>
                                        <td>
                                            @if ($none_block_kegiatan == 'none')
                                                @if ($kegiatan == null)
                                                    -
                                                @else
                                                    {{ Carbon\Carbon::parse($kegiatan->tgl_kegiatan)->isoFormat('dddd, D MMMM Y') }}
                                                @endif
                                            @else
                                                <input wire:model="tgl_kegiatan" type="date" class="form-control">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold" style="width: 30%;">Lokasi
                                        </td>
                                        <td>
                                            @if ($none_block_kegiatan == 'none')
                                                @if ($kegiatan == null)
                                                    -
                                                @else
                                                    {{ $kegiatan->lokasi }}
                                                @endif
                                            @else
                                                <input wire:model="lokasi" type="text" class="form-control"
                                                    placeholder="Masukan Lokasi Kegiatan">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold" style="width: 30%;">Judul Kegiatan
                                        </td>
                                        <td>
                                            @if ($none_block_kegiatan == 'none')
                                                @if ($kegiatan == null)
                                                    -
                                                @else
                                                    {{ $kegiatan->judul }}
                                                @endif
                                            @else
                                                <input wire:model="judul" type="text" class="form-control"
                                                    placeholder="Masukan Judul Kegiatan">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold" style="width: 30%;">Jumlah Kehadiran
                                        </td>
                                        <td>
                                            @if ($none_block_kegiatan == 'none')
                                                @if ($kegiatan == null)
                                                    -
                                                @else
                                                    {{ $kegiatan->jumlah_kehadiran }}
                                                @endif
                                            @else
                                                <input wire:model="jumlah_kehadiran" type="text" class="form-control"
                                                    placeholder="Masukan Jumlah Kehadiran">
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-bold" style="width: 30%;">Kendala Kegiatan
                                        </td>
                                        <td>
                                            @if ($none_block_kegiatan == 'none')
                                                @if ($kegiatan == null)
                                                    -
                                                @else
                                                    {{ $kegiatan->kendala }}
                                                @endif
                                            @else
                                                <input wire:model="kendala" type="text" class="form-control"
                                                    placeholder="Masukan Kendala Kegiatan">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold" style="width: 30%;">Ringkasan Kegiatan
                                        </td>
                                        <td>
                                            @if ($none_block_kegiatan == 'none')
                                                @if ($kegiatan == null)
                                                    -
                                                @else
                                                    {{ $kegiatan->ringkasan }}
                                                @endif
                                            @else
                                                <input wire:model="ringkasan" type="text" class="form-control"
                                                    placeholder="Masukan Ringkasan">
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-bold" style="width: 30%;">Diinput Oleh
                                        </td>
                                        <td>
                                            @if ($kegiatan == null)
                                                -
                                            @else
                                                {{ $this->nama_pengurus_upzis($kegiatan->maker_tingkat_upzis) }}<br>
                                                <span
                                                    style="font-size: 10pt">({{ $this->jabatan_pengurus_upzis($kegiatan->maker_tingkat_upzis) }})</span>
                                            @endif
                                        </td>
                                    </tr>

                                </thead>
                            </table>
                        </div>

                    </form>


                    {{-- end detail --}}

                </div>
                {{-- end detail kegiatan --}}

                {{-- card dokumentasi --}}
                <div class="col col-md-4 col-sm-12">


                    <div class="modal-detail-kegiatan-dokumentasi_foto_panduan">
                        {{-- judul --}}
                        <div class="d-flex align-items-center mt-1">
                            <i class="fas fa-images"></i><b class="ml-2"> DOKUMENTASI
                                KEGIATAN</b>
                        </div>
                        {{-- end judul --}}
                        {{-- foto --}}
                        <div class="mt-3 ">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @php
                                        $b = 1;
                                        $active = 'active';
                                    @endphp
                                    @forelse($dokumentasi as $a)
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
                                                {{ $a->judul }}
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
                        {{-- end foto --}}
                    </div>
                </div>
                {{-- end dokumentasi --}}

                {{-- tabel dokumenhtasi kegiatan --}}
                @if (Auth::user()->gocap_id_upzis_pengurus != null)
                    @if ($status_rekomendasi == 'Sudah Terbit')

                        <div class="col col-md-12 col-sm-12">
                            <form wire:submit.prevent="tambah_ubah_dokumentasi">
                                <div class="form-row">

                                    {{-- judul dokumentasi --}}
                                    <div class="form-group col-md-3">
                                        <label for="inputNama">JUDUL DOKUMENTASI &nbsp;</label>
                                        <span style="color:rgba(230, 82, 82)">*</span>
                                        <input wire:model="judul_dokumentasi" type="text" class="form-control "
                                            placeholder="Nama Judul Dokumentasi">
                                    </div>
                                    {{-- end judul --}}

                                    {{-- foto dokumentasi --}}
                                    <div class="form-group col-md-5">
                                        <label for="inputHP">DOKUMENTASI</label>
                                        @if ($id_pengajuan_dokumentasi == null)
                                            <sup class="badge badge-danger text-white mb-2"
                                                style="background-color:rgba(230,82,82)">WAJIB
                                                (JPG/JPEG/PNG)</sup>
                                        @else
                                            <sup class="badge badge-danger text-white mb-2"
                                                style="background-color:rgb(82, 166, 230)">ABAIKAN JIKA TIDAK
                                                ADA
                                                PERUBAHAN (JPG/JPEG/PNG)</sup>
                                        @endif

                                        <div class="custom-file custom-tambah-dokumentasi">
                                            <input type="file" wire:model="file_dokumentasi"
                                                accept="image/png, image/jpg, image/jpeg" class="custom-file-input"
                                                id="file" name="file">
                                            <label class="custom-file-label" for="customFile">Pilih
                                                file</label>
                                        </div>
                                    </div>
                                    {{-- end foto dokumentasi --}}
                                    <div class="form-group col-md-1 mt-2">
                                        <br>
                                        <a wire:click="reset_dokumentasi"
                                            class="btn btn-secondary btn-block tombol-reset"
                                            wire:loading.attr="disabled">
                                            Clear</a>
                                    </div>
                                    @if ($id_pengajuan_dokumentasi == null)
                                        <div class="form-group col-md-3 mt-2">
                                            <br>
                                            @if ($judul_dokumentasi == '' or $file_dokumentasi == '')
                                                <button class="btn btn-success btn-block" disabled
                                                    wire:loading.attr="disabled">
                                                    <i class="fas fa-plus-circle"></i> Tambah
                                                </button>
                                            @else
                                                <button type="submit" name="submit"
                                                    class="btn btn-success btn-block tombol-tambah"
                                                    wire:loading.attr="disabled">
                                                    <i class="fas fa-plus-circle"></i> Tambah
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <div class="form-group col-md-1 mt-2">
                                            <br>
                                            <a wire:click="hapus_dokumentasi"
                                                class="btn btn-danger btn-block tombol-reset"
                                                wire:loading.attr="disabled">
                                                Hapus
                                            </a>
                                        </div>

                                        <div class="form-group col-md-2 mt-2">
                                            <br>
                                            @if ($judul_dokumentasi == '')
                                                <button class="btn btn-success btn-block" disabled
                                                    wire:loading.attr="disabled">
                                                    <i class="fas fa-save"></i> Simpan
                                                </button>
                                            @else
                                                <button type="submit" name="submit"
                                                    class="btn btn-success btn-block tombol-reset"
                                                    wire:loading.attr="disabled">
                                                    <i class="fas fa-save"></i> Simpan
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered mt-2" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No</th>
                                            <th style="width: 70%;">Judul</th>
                                            <th style="width: 25%;">File</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($dokumentasi as $a)
                                            <tr wire:click="detail_dokumentasi('{{ $a->id_pengajuan_dokumentasi }}')"
                                                style="cursor: pointer;
                                            @if ($id_pengajuan_dokumentasi == $a->id_pengajuan_dokumentasi) background-color:#ECECEC; @endif">
                                                <td
                                                    wire:click="detail_dokumentasi('{{ $a->id_pengajuan_dokumentasi }}')">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td
                                                    wire:click="detail_dokumentasi('{{ $a->id_pengajuan_dokumentasi }}')">
                                                    {{ $a->judul }} <br>
                                                    <span style="font-size: 10pt">Diinput Oleh :
                                                        {{ $this->nama_pengurus_upzis($a->maker_tingkat_upzis) }}
                                                        ({{ $this->jabatan_pengurus_upzis($a->maker_tingkat_upzis) }})
                                                    </span>
                                                </td>
                                                <td class="text-center"
                                                    wire:click="detail_dokumentasi('{{ $a->id_pengajuan_dokumentasi }}')">
                                                    <a href="{{ asset('uploads/pengajuan_dokumentasi/' . $a->file) }}"
                                                        target="_blank">
                                                        <img style="border-radius:10px; height: 100px; "
                                                            src="{{ asset('uploads/pengajuan_dokumentasi/' . $a->file) }}"></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    Belum
                                                    ada dokumentasi kegiatan</td>
                                            </tr>
                                        @endforelse


                                    </tbody>

                                </table>
                            </div>

                        </div>
                    @endif
                @endif
                {{-- end tabel dokumenrasi kegiatan --}}


            </div>
        </div>
    </div>





</div>
