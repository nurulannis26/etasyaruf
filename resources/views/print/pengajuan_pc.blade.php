@php
    [$start, $end] = explode(' - ', $filter_daterange2);
    $startDate = \Carbon\Carbon::parse($start)->locale('id')->isoFormat('D MMMM Y');
    $endDate = \Carbon\Carbon::parse($end)->locale('id')->isoFormat('D MMMM Y');
@endphp



<table style="width:100%">
    <tr>
        <td style="width:33%; text-align:left;"><img src="{{ public_path('/images/gocap.png') }}" width="76"
                height="76"></td>
        <td style="width:33%;text-align:center;"><img src="{{ public_path('/images/logo_lazisnu.png') }}" width="146"
                height="76"></td>
        <td style="width:33%;text-align:right;"><img src="{{ public_path('/images/siftnu.png') }}" width="146"
                height="76"></td>
    </tr>
</table>

<p style="margin:0pt; text-align:center; font-size:11pt;">
    <b>REKAP PENGAJUAN PENTASYARUFAN TINGKAT UMUM LAZISNU CILACAP</b>
</p>


<table style="width: 100%; font-size: 11pt;">
    {{-- paragraf 1 --}}
    <tr>
        <td style="width: 19%"><b>Periode</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%">
            {{ $startDate }} - {{ $endDate }}
        </td>
    </tr>
    <tr>
        <td style="width: 19%"><b>Tingkat Pentasyarufan</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%">
            {{ $tingkat }}
        </td>
    </tr>

    <tr>
        <td style="width: 19%"><b>Status Pentasyarufan</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%">
            {{ $status }}
        </td>
    </tr>



</table>

<br>
<div></div>


<table style="width:100%; border-collapse: collapse; " cellpadding="2" cellspacing="0 page-break-inside: avoid;">
    <thead>
        <tr>
            <th style="border: 1px solid #000; width: 3%;vertical-align:middle;text-align:center"> No
            </th>
            <th style="border: 1px solid #000;width: 28%; vertical-align:middle;text-align:center">Pengajuan</th>

            <th style="border: 1px solid #000; width: 18%;vertical-align:middle;text-align:center">Pilar & Program</th>
            <th style="border: 1px solid #000; width: 18%;vertical-align:middle;text-align:center">Penerima <br>Manfaat
            </th>
            <th style="border: 1px solid #000; width: 11%;vertical-align:middle;text-align:center">Mustahik</th>
            <th style="border: 1px solid #000; width: 11%;vertical-align:middle;text-align:center">Nominal <br>Disetujui
            </th>
            <th style="border: 1px solid #000; width: 11%;vertical-align:middle;text-align:center">Nominal <br>Pencairan
            </th>

        </tr>
    </thead>
    <tbody>
        @php
            $total_nominal_pengajuan = 0;
            $total_nominal_disetujui = 0;
            $total_nominal_pencairan = 0;

            $total_penerima = 0;
        @endphp



        @foreach ($data as $b)
            @php

                $jumlah_penerima = App\Http\Controllers\PrintPengajuanController::hitung_jumlah_penerima(
                    $b->id_pengajuan,
                );
                $nominal_pengajuan = App\Http\Controllers\PrintPengajuanController::hitung_nominal_pengajuan(
                    $b->id_pengajuan,
                );
                $nominal_disetujui = App\Http\Controllers\PrintPengajuanController::hitung_nominal_pengajuan_disetujui(
                    $b->id_pengajuan,
                );
                $nominal_pencairan = App\Http\Controllers\PrintPengajuanController::hitung_nominal_pengajuan_pencairan(
                    $b->id_pengajuan,
                );
                $nama_pengurus = App\Http\Controllers\PrintPengajuanController::nama_pengurus_pc($b->pemohon_internal);
                $nama_pilar = App\Http\Controllers\PrintPengajuanController::get_nama_pilar($b->id_program_pilar);
                $nama_kegiatan = App\Http\Controllers\PrintPengajuanController::get_nama_kegiatan(
                    $b->id_program_kegiatan,
                );
                $total_nominal_pengajuan += $nominal_pengajuan;
                $total_nominal_disetujui += $nominal_disetujui;
                $total_nominal_pencairan += $nominal_pencairan;

                $total_penerima += $jumlah_penerima;
            @endphp

            <tr style="page-break-inside: avoid;border: 1px solid #000;">
                {{-- row1 --}}
                <td  style=" cursor: pointer;border: 1px solid #000; width: 3%;vertical-align:middle;text-align:center">
                    <b>{{ $loop->iteration }}</b>
                </td>
                {{-- row2 --}}
                <td  style="border: 1px solid #000; width: 28%; vertical-align: middle; text-align: left;"><span
                        style="font-size: 13px; font-weight: bold; ">{{ $b->nomor_surat }}
                    </span>
                    <br><span style="font-size: 13px; font-weight: normal;">Pengajuan
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span
                            style="font-weight: bold;text-align: right;">Rp{{ number_format($b->nominal_pengajuan, 0, ',', '.') }},-
                        </span>
                    </span>
                    <br><span style="font-size: 13px; text-align: left;">Tgl Pengajuan
                        <span
                            style="font-weight: bold;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ Carbon\Carbon::parse($b->tgl_pengajuan)->isoFormat('D MMMM Y') }}
                        </span>
                    </span>
                    <br><span style="font-size: 13px; text-align: left;">Tgl Pengajuan
                        <span
                            style="font-weight: bold;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ Carbon\Carbon::parse($b->created_at)->isoFormat('D MMMM Y') }}
                        </span>
                    </span>
                    <br><span style="font-size: 13px; text-align: left;">Pemohon
                        <span
                            style="font-weight: bold;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @if ($b->opsi_pemohon == 'Entitas')
                                {{ $b->nama_entitas }}
                            @elseif($b->opsi_pemohon == 'Individu')
                                {{ $b->nama_pemohon }}
                            @elseif($b->opsi_pemohon == 'Internal')
                                {{ $nama_pengurus }}
                            @endif
                        </span>
                    </span>
                </td>

                {{-- status pengajuan --}}
                <td  style=" cursor: pointer;border: 1px solid #000; width: 18%;vertical-align:middle;text-align:left">
                    <span style="font-size: 12px; font-weight: bold; ">{{ $nama_pilar ?? '-' }}
                    </span> <br>
                    <span style="font-size: 12px; font-weight: bold; ">{{ $nama_kegiatan ?? '-' }}
                    </span> <br>
                    <span style="font-size: 12px;">{{ $b->pengajuan_note }}
                    </span>
                    <br>
                    <table style="width: 100%;font-size:12px;margin-top:10px;">
                        <tr>
                            <td>Disposisi Program</td>
                            <td>
                                <div style="text-align:left">
                                    {{ Carbon\Carbon::parse($b->tgl_diserahkan_div_program)->isoFormat('D MMMM Y') }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Diserahkan ke Direktur</td>
                            <td>
                                <div style="text-align:left">
                                    {{ Carbon\Carbon::parse($b->tgl_diserahkan_direktur)->isoFormat('D MMMM Y') }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                {{-- status pengajuan --}}

                {{-- status rekomendasi --}}
                <td style="border: 1px solid black;text-align:center;vertical-align:top;text-align:center;width: 18%;">
                    <span style="font-size: 12px; font-weight: bold; ">{{ $jumlah_penerima }}
                    </span> <br>
                    @if ($b->approval_status == 'Disetujui')
                        @if ($b->pil_survey == 'Perlu')
                            @if ($b->status_survey == 'Direncanakan')
                                <span style="font-size: 12px;" class="text-light badge badge-warning">Survey Blm Selesai</span>
                            @elseif($b->status_survey == 'Diajukan')
                                <span style="font-size: 12px;" class="text-light badge badge-success">Survey Selesai
                                </span>
                            @endif
                        @elseif($b->pil_survey == 'Tidak Perlu')
                            <span style="font-size: 12px;" class="text-light badge badge-secondary">Tanpa Survey
                            </span>
                        @else
                            <span style="font-size: 12px;" class="text-light badge badge-warning">Survey Blm Selesai</span>
                        @endif
                    @else
                        <div class="text-center" style="font-size: 12px;">
                            <span>
                                Blm Dipilih
                            </span>
                        </div>
                    @endif
                </td>
                {{-- status rekomendasi --}}

                {{-- row3 --}}
                <td style="border: 1px solid black;text-align:left;vertical-align:top;width: 11%;">
                    @forelse ($mustahik->where('id_pengajuan', $b->id_pengajuan) as $mu)
                        <span
                            style="text-align:left;vertical-align:top;font-size: 12px;">({{ $loop->iteration }}.)</span><br>
                        <span
                            style="text-align:left;vertical-align:top;font-size: 12px;">{{ $mu->nama ?? '-' }}</span><br>
                        <span style="text-align:left;vertical-align:top;font-size: 12px;">No HP&nbsp;&nbsp;:
                            {{ $mu->nohp ?? '-' }}</span><br>
                        <span
                            style="text-align:left;vertical-align:top;font-size: 12px;">NIK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                            {{ $mu->nik ?? '-' }}</span><br>
                        <span style="text-align:left;vertical-align:top;font-size: 12px;">Alamat&nbsp;:
                            {{ $mu->alamat ?? '-' }}</span><br>
                    @empty
                        <div style="text-align:center;font-size:12px;">Blm diinput</div>
                    @endforelse
                </td>
                {{-- end jumlah nominal diajukan --}}

                {{-- lpj --}}
                <td  style=" cursor: pointer;border: 1px solid #000; width: 11%;vertical-align:middle;text-align:right">
                    <b style="color: #007bff"
                        style="font-size: 10pt;">Rp{{ isset($b->nominal_disetujui_pencairan_direktur) ? number_format($b->nominal_disetujui_pencairan_direktur, 0, ',', '.') . ',-' : '-' }},-</b>
                    <br><em
                        style="font-size: 10pt;text-align:right;color: #6c757d">{{ isset($b->approval_date_pencairan_direktur) ? Carbon\Carbon::parse($b->approval_date_pencairan_direktur)->isoFormat('D MMMM Y') : '-' }}</em>
                </td>

                <td  style=" cursor: pointer;border: 1px solid #000; width: 11%;vertical-align:middle;text-align:right">
                    <b style="color: #007bff"
                        style="font-size: 10pt;">Rp{{ isset($b->nominal_pencairan) ? number_format($b->nominal_pencairan, 0, ',', '.') . ',-' : '-' }},-</b>
                    <br><em
                        style="font-size: 10pt;text-align:right;color: #6c757d">{{ isset($b->tgl_pencairan) ? Carbon\Carbon::parse($b->tgl_pencairan)->isoFormat('D MMMM Y') : '-' }}</em>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
