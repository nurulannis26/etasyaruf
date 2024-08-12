<div class="row">

    <div class="col col-md-12 col-sm-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <b>KONFIRMASI PENGAJUAN</b>
                <p class="intro-detail-data-pengajuan-status-lembar-pengajuan d-inline">
                    @if ($data->tgl_konfirmasi == null)
                        <sup class="badge badge-danger text-white bg-secondary mb-2 hover">Belum Dikonfirmasi</sup>
                    @else
                        <sup class="badge  text-white bg-success mb-2 hover">Sudah Dikonfirmasi</sup>
                    @endif
                </p>

            </div>
        </div>
    </div>
    <div class="col col-md-6 col-sm-12">
        <div class="card mt-2">
            <div class="card-body">
                {{-- info --}}
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="d-flex  align-items-center">
                            <div>
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="ml-2">
                                @if (Auth::user()->gocap_id_pc_pengurus)
                                    @if ($data->scan == null)
                                        Menunggu Upzis MWCNU
                                        {{ \App\Http\Controllers\Helper::getNamaUpzis($data->id_upzis) }}
                                        konfirmasi lembar pengajuan
                                    @else
                                        Upzis MWCNU {{ \App\Http\Controllers\Helper::getNamaUpzis($data->id_upzis) }}
                                        sudah
                                        mengonfirmasi lembar pengajuan
                                    @endif
                                @else
                                    @if ($data->scan == null)
                                        <b style="  font-size: inherit;font-weight: bold;">Wajib</b> upload berkas bertanda tangan & berstempel sebagai bentuk
                                        konfirmasi pengajuan. <br>
                                        <b style="  font-size: inherit;font-weight: bold;">Jika belum konfirmasi,</b> data belum masuk ke PC Lazisnu Cilacap.
                                    @else
                                        Pengajuan terkonfirmasi. Menunggu respon PC Lazisnu
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- alert --}}
                @if (session()->has('konfirmasi'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('konfirmasi') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            {{-- @if (Auth::user()->gocap_id_upzis_pengurus != null) --}}
                            <tr class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                <td class="text-bold" style="width: 40%;">Format Berkas
                                </td>
                                <td>
                                    <span>Format berkas lembar pengajuan</span><br>
                                    <a href="/upzis/print{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_PERMOHONAN' }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-success hover float-left mr-2 mt-2" role="button"
                                        style="border-radius:10px; width:3cm;">Download
                                    </a>
                                </td>
                            </tr>
                            {{-- @endif --}}

                            @if (Auth::user()->gocap_id_upzis_pengurus != null and $data->status_rekomendasi == 'Belum Terbit')

                                <tr class="intro-detail-data-pengajuan-konfirmasi-upload-berkas">
                                    <td class="text-bold" style="width: 40%;"> Upload Berkas
                                    </td>
                                    <td>
                                        <div class="custom-file" id="customFileScan">
                                            <input type="file" wire:model="scan_konfirmasi"
                                                accept="application/pdf, image/png, image/jpg, image/jpeg"
                                                class="custom-file-input" name="file">
                                            <label class="custom-file-label" for="customFile">Pilih
                                                file</label>
                                        </div><br>
                                        @if ($scan_konfirmasi == null)
                                            <button class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                style="border-radius:10px; width:5cm;" disabled
                                                wire:loading.attr="disabled" data-toggle="tooltip" data-placement="top"
                                                title="Input Belum Lengkap">Upload Sekarang
                                            </button>
                                        @else
                                            <button wire:click="uploadKonfirmasi"
                                                class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                style="border-radius:10px; width:5cm;" id="UploadKonfirmasi"
                                                wire:loading.attr="disabled">Upload Sekarang
                                            </button>
                                        @endif
                                        <div wire:loading class="mt-3">
                                            Harap Tunggu...
                                        </div>

                                    </td>
                                </tr>
                            @endif
                            <tr class="intro-detail-data-pengajuan-konfirmasi-upload-berkas">
                                <td class="text-bold" style="width: 40%;"> Berkas ber TTD & Stampel
                                </td>
                                <td>
                                    @if ($data->scan == null)
                                        -
                                    @else
                                        <a href="{{ asset('uploads/pengajuan_konfirmasi/' . $data->scan) }}"
                                            target="_blank">{{ $data->scan }}</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 40%;">Tgl Konfirmasi
                                </td>
                                <td>
                                    @if ($data->tgl_konfirmasi == null)
                                        -
                                    @else
                                        {{ Carbon\Carbon::parse($data->tgl_konfirmasi)->isoFormat('dddd, D MMMM Y') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold" style="width: 40%;">Dikonfirmasi Oleh
                                </td>
                                <td>
                                    @if ($data->dikonfirmasi_oleh_upzis == null)
                                        -
                                    @else
                                        {{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $data->dikonfirmasi_oleh_upzis) }}<br>
                                        <span style="font-size:11pt;">
                                            ({{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data->dikonfirmasi_oleh_upzis) }})</span>
                                    @endif
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                {{-- <em>Format berkas otomatis berdasarkan inputan rencana pentasyarufan yang telah diinputkan</em><br> --}}
            </div>
        </div>
    </div>
    {{-- @if (Auth::user()->gocap_id_upzis_pengurus != null and $data->status_rekomendasi == 'Belum Terbit')
        <div class="col col-md-6 col-sm-12 ">
            <div class="collapse" id="uploadPengajuan" wire:ignore.self>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputHP">UPLOAD BERKAS BER-TTD & STAMPEL</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB
                                    (PDF/PNG/JPG/JPEG)</sup>
                                @if (session()->has('konfirmasi'))
                                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                        <i class="far fa-check-circle"></i>
                                        {{ session('konfirmasi') }}
                                    </div>
                                @endif
                                <div class="custom-file" id="customFileScan">
                                    <input type="file" wire:model="scan_konfirmasi"
                                        accept="application/pdf, image/png, image/jpg, image/jpeg"
                                        class="custom-file-input" name="file">
                                    <label class="custom-file-label" for="customFile">Pilih
                                        file</label>
                                </div>
                            </div>
                        </div>
                        Dengan klik tombol Upload, upzis memberikan konfirmasi pengajuan program yang telah direncanakan
                        <div class="d-flex mt-1">
                            <div class="mr-auto">
                                <div wire:loading>
                                    <button type="button" class="btn btn-outline-secondary noClick"
                                        data-dismiss="modal">
                                        Harap Tunggu ....</button>
                                </div>
                            </div>
                            <div class="float-right">
                                @if ($scan_konfirmasi == null)
                                    <button class="btn btn-success " data-toggle="tooltip" data-placement="top"
                                        title="Input Belum Lengkap" disabled wire:loading.attr="disabled"><i
                                            class="fas fa-cloud-upload-alt"></i>
                                        Upload</button>
                                @else
                                    <button wire:click="uploadKonfirmasi" class="btn btn-success hover"
                                        id="UploadKonfirmasi" wire:loading.attr="disabled"><i
                                            class="fas fa-cloud-upload-alt"></i>
                                        Upload</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}
</div>
