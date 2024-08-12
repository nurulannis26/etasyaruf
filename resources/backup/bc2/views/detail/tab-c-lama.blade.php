<div class="row">

    {{-- card rekomendasi pengajuan --}}
    <div class="col col-md-6 col-sm-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <b>LEMBAR REKOMENDASI

                    @if ($data->status_rekomendasi == 'Belum Terbit')
                        <sup class="badge badge-danger text-white bg-secondary mb-2">Belum Terbit</sup>
                    @else
                        <sup class="badge  text-white bg-success mb-2">Sudah Terbit</sup>
                    @endif

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
                                <span>
                                    @if (Auth::user()->gocap_id_pc_pengurus)
                                        @if ($data->status_rekomendasi == 'Belum Terbit')
                                            Berikan respon pada semua data di daftar rencana program,
                                            lalu terbitkan rekomendasi
                                        @else
                                            Lembar Rekomendasi sudah diterbitkan
                                        @endif
                                    @else
                                        @if ($data->status_rekomendasi == 'Belum Terbit')
                                            Menunggu lembar rekomendasi diterbitkan oleh
                                            {{ $this->nama_pc($data->id_pc) }}
                                        @else
                                            Lembar Rekomendasi sudah diterbitkan, segera lakukan pencairan & penyaluran
                                            dana
                                        @endif
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end info --}}

                {{-- alert --}}
                @if (session()->has('alert_rekomendasi'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('alert_rekomendasi') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- end alert --}}
                <div class="table-responsive">

                    <table class="table table-bordered">
                        <thead>

                            @if (Auth::user()->gocap_id_pc_pengurus != null)
                                @if ($respon_a == $total_a and $respon_b == $total_b and $respon_c == $total_c and $data->tgl_konfirmasi != null)

                                    <tr>
                                        <td class="text-bold" style="width: 40%;">Format Berkas
                                        </td>
                                        <td>
                                            <a href="/upzis/rekomendasi{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                                target="_blank" class="btn btn-sm btn-outline-success float-left"
                                                role="button" style="border-radius:10px; ">Download
                                            </a>

                                        </td>
                                    </tr>


                                    {{-- <tr>
                                        <td class="text-bold" style="width: 40%;"> Berkas ber TTD & Stampel
                                        </td>
                                        <td>
                                            @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                
                                                <button data-toggle="modal" data-target="#modal_pengajuan_rekomendasi"
                                                    class="btn btn-outline-primary btn-sm float-left"
                                                    style="border-radius:10px; ">
                                                    Upload</button>
                                                <br><br>
                                              
                                            @endif

                                            @if ($data->scan_rekomendasi == null)
                                                -
                                            @else
                                                <a href="{{ asset('uploads/pengajuan_rekomendasi/' . $data->scan_rekomendasi) }}"
                                                    target="_blank">{{ $data->scan_rekomendasi }}</a>
                                            @endif

                                        </td>
                                    </tr> --}}
                                @else
                                    <tr>
                                        <td class="text-bold" style="width: 40%;">Format Berkas
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-success float-left"
                                                data-toggle="tooltip" data-placement="bottom"
                                                style="border-radius:10px; "
                                                title="Lembar Rekomendasi dapat diakses ketika {{ $this->nama_upzis($data->id_upzis) }} sudah melampirkan lembar pengajuan ber-TTD & Stampel dan {{ $this->nama_pc($data->id_pc) }} sudah merespon semua data di daftar rencana program"
                                                disabled>
                                                Download
                                            </button>


                                        </td>
                                    </tr>


                                    {{-- <tr>
                                        <td class="text-bold" style="width: 40%;"> Berkas ber TTD & Stampel
                                        </td>
                                        <td>
                                            @if (Auth::user()->gocap_id_pc_pengurus != null)
                                              
                                                <button type="button" class="btn btn-sm btn-outline-primary float-left"
                                                    data-toggle="tooltip" data-placement="bottom"
                                                    style="border-radius:10px; "
                                                    title="Lembar Rekomendasi dapat diakses ketika {{ $this->nama_upzis($data->id_upzis) }} sudah melampirkan lembar pengajuan ber-TTD & Stampel dan {{ $this->nama_pc($data->id_pc) }} sudah merespon semua data di daftar rencana program"
                                                    disabled>
                                                    Upload
                                                </button>
                                                <br><br>
                                               
                                            @endif

                                            @if ($data->scan_rekomendasi == null)
                                                -
                                            @else
                                                <a href="{{ asset('uploads/pengajuan_rekomendasi/' . $data->scan_rekomendasi) }}"
                                                    target="_blank">{{ $data->scan_rekomendasi }}</a>
                                            @endif

                                        </td>
                                    </tr> --}}
                                @endif
                            @endif

                            @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                <tr>
                                    <td class="text-bold" style="width: 40%;">Berkas ber TTD & Stampel
                                    </td>
                                    <td>
                                        @if ($data->scan_rekomendasi == null)
                                            -
                                        @else
                                            <a href="{{ asset('uploads/pengajuan_rekomendasi/' . $data->scan_rekomendasi) }}"
                                                target="_blank">{{ $data->scan_rekomendasi }}</a>
                                        @endif


                                    </td>
                                </tr>
                            @endif



                            <tr>
                                <td class="text-bold" style="width: 40%;">Direkomendasikan Oleh
                                </td>
                                <td>
                                    @if ($data->direkomendasikan_oleh_pc == null)
                                        -
                                    @else
                                        {{ $this->nama_pengurus_pc($data->direkomendasikan_oleh_pc) }}<br>
                                        <span style="font-size:11pt;">
                                            ({{ $this->jabatan_pengurus_pc($data->direkomendasikan_oleh_pc) }})</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold" style="width: 40%;">Status Rekomendasi
                                </td>
                                <td>
                                    @if ($data->status_rekomendasi == null)
                                        -
                                    @else
                                        {{ $data->status_rekomendasi }}
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold" style="width: 40%;">Tgl Terbit Rekomendasi
                                </td>
                                <td>
                                    @if ($data->tgl_terbit_rekomendasi == null)
                                        -
                                    @else
                                        {{ Carbon\Carbon::parse($data->tgl_terbit_rekomendasi)->isoFormat('DD-MM-Y') }}
                                    @endif
                                </td>
                            </tr>



                            <tr>
                                <td class="text-bold" style="width: 40%;">PJ Pengambilan Dana
                                </td>
                                <td>
                                    {{ $this->nama_pengurus_upzis($data->pj_upzis) }}<br>
                                    <span style="font-size:11pt;">
                                        ({{ $this->jabatan_pengurus_upzis($data->pj_upzis) }})</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold" style="width: 40%;">BMT Mitra
                                </td>
                                <td>
                                    {{ $nama_bmt2 }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 40%;">
                                    <span class="text-bold"> Kelembagaan </span><br>
                                    <span class="text-secondary">1122334</span>
                                </td>
                                <td>
                                    Rp{{ number_format($total_kelembagaan, 0, '.', '.') }},- <br>
                                    <span style="font-size:11pt;"> ({{ $respon_a }} dari {{ $total_a }}
                                        rencana
                                        telah direspon)</span>
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 40%;">
                                    <span class="text-bold"> Program Sosial </span><br>
                                    <span class="text-secondary">1122334</span>
                                </td>
                                <td>
                                    Rp{{ number_format($total_program_sosial, 0, '.', '.') }},- <br>
                                    <span style="font-size:11pt;"> ({{ $respon_b }} dari {{ $total_b }}
                                        rencana
                                        telah direspon)</span>
                                </td>
                            </tr>


                            <tr>
                                <td style="width: 40%;">
                                    <span class="text-bold"> Dana Operasional </span><br>
                                    <span class="text-secondary">1122334</span>
                                </td>
                                <td>
                                    Rp{{ number_format($total_operasional_upzis, 0, '.', '.') }},- <br>
                                    <span style="font-size:11pt;"> ({{ $respon_c }} dari {{ $total_c }}
                                        rencana
                                        telah direspon)</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold" style="width: 40%;">Total Dana Pentasyarufan Yang Direkomendasikan
                                </td>
                                <td>
                                    <b style="font-size:12pt;">
                                        Rp{{ number_format($total_kelembagaan + $total_program_sosial + $total_operasional_upzis, 0, '.', '.') }},-</b>
                                </td>
                            </tr>


                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    {{-- end rekomendasi pengajuan --}}


</div>
