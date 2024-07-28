<div class="row">
    {{-- card konfirmasi pengajuan --}}
    <div class="col col-md-6 col-sm-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <b>KONFIRMASI PENGAJUAN
                    <p class="intro-detail-data-pengajuan-status-lembar-pengajuan d-inline">
                        @if ($data->tgl_konfirmasi == null)
                            <sup class="badge badge-danger text-white bg-secondary mb-2">Belum Dikonfirmasi</sup>
                        @else
                            <sup class="badge  text-white bg-success mb-2">Sudah Dikonfirmasi</sup>
                        @endif
                    </p>

                </b>
            </div>
        </div>
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
                                        Menunggu {{ $this->nama_upzis($data->id_upzis) }} konfirmasi lembar pengajuan
                                    @else
                                        {{ $this->nama_upzis($data->id_upzis) }} sudah mengonfirmasi lembar pengajuan
                                    @endif
                                @else
                                    @if ($data->scan == null)
                                        Setelah daftar rencana selesai diinput, wajib upload berkas bertanda tangan &
                                        berstempel
                                        sebagai
                                        bentuk konfirmasi pengajuan
                                    @else
                                        Sudah mengonfirmasi lembar pengajuan
                                    @endif

                                @endif


                            </div>
                        </div>
                    </div>
                </div>
                {{-- end info --}}



                {{-- alert --}}
                @if (session()->has('alert_konfirmasi'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('alert_konfirmasi') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- end alert --}}
                <div class="table-responsive">

                    <table class="table table-bordered">
                        <thead>

                            <tr class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                <td class="text-bold" style="width: 40%;">Format Berkas
                                </td>
                                <td>
                                    <a href="/upzis/print{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_PERMOHONAN' }}"
                                        target="_blank" class="btn btn-sm btn-outline-success float-left mr-2"
                                        role="button" style="border-radius:10px; ">Download
                                    </a>

                                </td>
                            </tr>


                            <tr class="intro-detail-data-pengajuan-konfirmasi-upload-berkas">
                                <td class="text-bold" style="width: 40%;"> Berkas ber TTD & Stampel
                                </td>
                                <td>
                                    @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                        {{-- @if (count($rencana_a) > 0 or count($rencana_b) > 0 or count($rencana_c) > 0) --}}
                                        <button data-toggle="modal" data-target="#modal_pengajuan_konfirmasi"
                                            class="btn btn-outline-primary btn-sm float-left"
                                            style="border-radius:10px; ">
                                            Upload</button>
                                        <br><br>
                                        {{-- @endif --}}
                                    @endif

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
                                        {{ Carbon\Carbon::parse($data->tgl_konfirmasi)->isoFormat('DD-MM-Y') }}
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
                                        {{ $this->nama_pengurus_upzis($data->dikonfirmasi_oleh_upzis) }}<br>
                                        <span style="font-size:11pt;">
                                            ({{ $this->jabatan_pengurus_upzis($data->dikonfirmasi_oleh_upzis) }})</span>
                                    @endif
                                </td>
                            </tr>

                        </thead>
                    </table>
                </div>
                <br>
                *Format berkas otomatis berdasarkan inputan rencana pentasyarufan yang telah diinputkan<br>
                &nbsp;&nbsp;Upload berkas dalam 1 file berformat .PDF

            </div>
        </div>
    </div>
    {{-- end konfirmasi pengajuan --}}
</div>
