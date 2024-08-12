<div class="row">

    {{-- card rekomendasi pengajuan --}}
    <div class="col col-md-6 col-sm-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <b>LEMBAR REKOMENDASI
                    <p class="intro-detail-data-pengajuan-status-lembar-rekomendasi d-inline">
                        @if ($data->status_rekomendasi == 'Belum Terbit')
                            <sup class="badge badge-danger text-white bg-secondary mb-2">Belum Terbit</sup>
                        @else
                            <sup class="badge  text-white bg-success mb-2">Sudah Terbit</sup>
                        @endif
                    </p>
                </b>
            </div>
            @if (Auth::user()->gocap_id_pc_pengurus != null and
                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
                @if ($data->status_rekomendasi == 'Belum Terbit')
                    @if ($data->tingkat == 'Upzis MWCNU')
                        @if ($respon_a == $total_a and $respon_b == $total_b and $respon_c == $total_c and $data->tgl_konfirmasi != null)
                            <button wire:click="modal_pengajuan_rekomendasi('{{ $data->id_pengajuan }}')"
                                data-toggle="modal" data-target="#modal_pengajuan_rekomendasi"
                                class="btn btn-success btn-sm intro-tombol-rekomendasi">
                                <i class="fas fa-edit"></i>
                                Terbitkan Rekomendasi</button>
                        @else
                            <button class="btn btn-success btn-sm intro-tombol-rekomendasi" data-toggle="tooltip"
                                data-placement="bottom"
                                title="Penerbitan Lembar Rekomendasi dapat diakses ketika {{ $this->nama_pc($data->id_pc) }} sudah merespon semua data di daftar rencana program"
                                disabled>
                                <i class="fas fa-edit"></i>
                                Terbitkan Rekomendasi</button>
                        @endif
                    @endif
                    @if ($data->tingkat == 'Ranting NU')
                        @if ($respon_a == $total_a and $respon_b == $total_b and $data->tgl_konfirmasi != null)
                            <button wire:click="modal_pengajuan_rekomendasi('{{ $data->id_pengajuan }}')"
                                data-toggle="modal" data-target="#modal_pengajuan_rekomendasi"
                                class="btn btn-success btn-sm intro-tombol-rekomendasi">
                                <i class="fas fa-edit"></i>
                                Terbitkan Rekomendasi</button>
                        @else
                            <button class="btn btn-success btn-sm intro-tombol-rekomendasi" data-toggle="tooltip"
                                data-placement="bottom"
                                title="Penerbitan Lembar Rekomendasi dapat diakses ketika {{ $this->nama_pc($data->id_pc) }} sudah merespon semua data di daftar rencana program"
                                disabled>
                                <i class="fas fa-edit"></i>
                                Terbitkan Rekomendasi</button>
                        @endif
                    @endif
                @endif
            @endif
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
                                        Berikan respon pada semua data pada daftar rencana program,
                                        lalu terbitkan rekomendasi.
                                    @else
                                        @if ($data->status_rekomendasi == 'Belum Terbit')
                                            Harap tunggu PC Lazisnu Cilacap merespon semua rencana & menerbitkan
                                            lembar rekomendasi
                                        @elseif($data->status_rekomendasi == 'Sudah Terbit')
                                            Lembar Rekomendasi sudah diterbitkan
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

                <table class="table table-bordered">
                    <thead>

                        {{-- @if (Auth::user()->gocap_id_pc_pengurus != null) --}}
                        {{-- @if ($respon_a == $total_a and $respon_b == $total_b and $respon_c == $total_c and $data->tgl_konfirmasi != null) --}}
                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                            <tr class="intro-detail-data-pengajuan-lembar-rekomendasi-preview">
                                <td class="text-bold" style="width: 40%;">Lembar Rekomendasi
                                </td>
                                <td>
                                    @if ($data->status_rekomendasi == 'Sudah Terbit')
                                        <a href="/upzis/rekomendasi{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                            target="_blank" class="btn btn-sm btn-outline-success float-left"
                                            role="button" style="border-radius:10px; ">
                                            Download
                                        </a>
                                    @else
                                        <a href="/upzis/rekomendasi{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                            target="_blank" class="btn btn-sm btn-outline-primary float-left"
                                            role="button" style="border-radius:10px; ">Preview
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endif

                        @if (Auth::user()->gocap_id_upzis_pengurus != null)
                            <tr class="intro-detail-data-pengajuan-lembar-rekomendasi-preview">
                                <td class="text-bold" style="width: 40%;">Lembar Rekomendasi
                                </td>
                                <td>
                                    @if ($data->status_rekomendasi == 'Sudah Terbit')
                                        <a href="/upzis/rekomendasi{{ $id_pengajuan }}/{{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}"
                                            target="_blank" class="btn btn-sm btn-outline-success float-left"
                                            role="button" style="border-radius:10px; ">Download
                                        </a>
                                    @else
                                        -
                                    @endif

                                </td>
                            </tr>
                        @endif



                        {{-- @endif --}}



                        <tr>
                            <td class="text-bold" style="width: 40%;">Direkomendasikan Oleh
                            </td>
                            <td>
                                @if ($data->direkomendasikan_oleh_pc == null)
                                    -
                                @else
                                    {{ $this->nama_pengurus_pc($data->direkomendasikan_oleh_pc) }}<br>
                                    <span style="font-size:11pt;">
                                        ( {{ $this->jabatan_pengurus_pc($data->direkomendasikan_oleh_pc) }} )</span>
                                @endif
                            </td>
                        </tr>

                        {{-- <tr>
                            <td class="text-bold" style="width: 40%;">Status Rekomendasi
                            </td>
                            <td>
                                @if ($data->status_rekomendasi == null)
                                    -
                                @else
                                    {{ $data->status_rekomendasi }}
                                @endif
                            </td>
                        </tr> --}}

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
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    {{ $this->nama_pengurus_upzis($data->pj_upzis) }}<br>
                                    <span style="font-size:11pt;">
                                        ({{ $this->jabatan_pengurus_upzis($data->pj_upzis) }})</span>
                                @endif
                                @if ($data->tingkat == 'Ranting NU')
                                    {{ $this->nama_pengurus_upzis($data->pj_ranting) }}<br>
                                    <span style="font-size:11pt;">
                                        ({{ $this->jabatan_pengurus_upzis($data->pj_ranting) }})</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td class="text-bold" style="width: 40%;">BMT Mitra
                            </td>
                            <td>
                                @if ($bmts->isEmpty())
                                    -
                                @else
                                    @foreach ($bmts as $a)
                                        <span class="text-bold">
                                            {{ $this->getNamaBmtByIdRekening($a->id_rekening) }}</span>
                                        <br>
                                        {{ $this->countProgramByIdRekening($a->id_rekening) }} Program

                                        <br>
                                    @endforeach
                                @endif

                            </td>
                        </tr>

                        <tr>
                            <td style="width: 40%;">
                                <span class="text-bold">KELEMBAGAAN </span><br>
                                {{-- <span class="text-secondary">1122334</span> --}}
                            </td>
                            <td>
                                Rp{{ number_format($total_kelembagaan, 0, '.', '.') }},- <br>
                                <span style="font-size:11pt;"> ({{ $respon_a }} dari {{ $total_a }} rencana
                                    telah direspon)</span>
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 40%;">
                                <span class="text-bold">PROGRAM SOSIAL</span><br>
                                {{-- <span class="text-secondary">1122334</span> --}}
                            </td>
                            <td>
                                Rp{{ number_format($total_program_sosial, 0, '.', '.') }},- <br>
                                <span style="font-size:11pt;"> ({{ $respon_b }} dari {{ $total_b }} rencana
                                    telah direspon)</span>
                            </td>
                        </tr>

                        @if ($data->tingkat == 'Upzis MWCNU')
                            <tr>
                                <td style="width: 40%;">
                                    <span class="text-bold">DANA OPERASIONAL</span><br>
                                    {{-- <span class="text-secondary">1122334</span> --}}
                                </td>
                                <td>
                                    Rp{{ number_format($total_operasional_upzis, 0, '.', '.') }},- <br>
                                    <span style="font-size:11pt;"> ({{ $respon_c }} dari {{ $total_c }}
                                        rencana
                                        telah direspon)</span>
                                </td>
                            </tr>
                        @endif

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
    {{-- end rekomendasi pengajuan --}}


</div>
