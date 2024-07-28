@php
    [$start, $end] = explode(' - ', $filter_daterange);
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

@if ($sub == 'pengajuan')
    <p style="margin:0pt; text-align:center; font-size:11pt;">
        @if ($tings == 'keseluruhan')
            <b>DATA REALISASI PENTASYARUFAN PER WILAYAH KECAMATAN</b>
            <br>
        @elseif($tings == 'ranting')
            <b>DATA REALISASI PENTASYARUFAN TINGKAT RANTING</b>
            <br>
        @elseif($tings == 'upzis')
            <b>DATA REALISASI PENTASYARUFAN TINGKAT UPZIS</b>
            <br>
        @endif

        <b> BERDASARKAN TGL KONFIRMASI PENGAJUAN</b>
    </p>
@elseif($sub == 'laporan')
    <p style="margin:0pt; text-align:center; font-size:11pt;">
        @if ($tings == 'keseluruhan')
            <b>DATA REALISASI PENTASYARUFAN BY PENGAJUAN PER WILAYAH KECAMATAN
                {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($id_upzis2)) }} </b>
        @elseif($tings == 'ranting')
            <b>DATA REALISASI PENTASYARUFAN TINGKAT RANTING </b>
        @elseif($tings == 'upzis')
            <b>DATA REALISASI PENTASYARUFAN BY PENGAJUAN TINGKAT UPZIS</b>
        @endif
        <br>
        <b> BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR</b>
    </p>
@endif


@if ($sub == 'pengajuan')
    @php
        $not = 'Tgl Konfirmasi';
    @endphp
@elseif($sub == 'laporan')
    @php
        $not = 'Tgl Rekom';
    @endphp
@endif

<table style="width: 100%; font-size: 11pt;">
    {{-- paragraf 1 --}}
    <tr>
        <td style="width: 19%"><b>Periode ({{ $not }})</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%">
            {{ $startDate }} - {{ $endDate }}
        </td>
    </tr>


    <tr>
        <td style="width: 19%"><b>UPZIS MWCNU</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%">
            @if ($tings == 'keseluruhan')
                @if ($id_upzis2)
                    {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($id_upzis2)) }}
                @else
                    Semua
                @endif
            @elseif($tings == 'ranting')
                @if ($id_upzis2)
                    {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($id_upzis2)) }}
                @else
                    Semua
                @endif
            @elseif($tings == 'upzis')
                @if ($id_upzis)
                    {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($id_upzis)) }}
                @else
                    Semua
                @endif
            @else
                Semua
            @endif
        </td>
    </tr>


    @if ($tings == 'ranting')
        <tr>
            <td style="width: 19%"><b>RANTING MWCNU</b></td>
            <td style="width: 1%">:</td>
            <td style="width: 80%">
                @if ($id_ranting2)
                    {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_ranting($id_ranting2)) }}
                @else
                    Semua
                @endif
            </td>
        </tr>
    @endif


    <tr>
        <td style="width: 19%"><b>Total Pencairan</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%"> {{ $data->count() }} Pengajuan -
            {{ $datas->clone()->rightjoin('pengajuan_detail', 'pengajuan_detail.id_pengajuan', '=', 'pengajuan.id_pengajuan')->rightJoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')->count() }}
            Program
            - Rp
            {{ number_format($datas->clone()->rightjoin('pengajuan_detail', 'pengajuan_detail.id_pengajuan', '=', 'pengajuan.id_pengajuan')->sum('nominal_pencairan'), 0, '.', '.') }}
        </td>
    </tr>

    <tr>
        <td style="width: 19%"><b>Total Sudah LPJ</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%">
            {{ $datas->clone()->rightJoin('pengajuan_detail', 'pengajuan_detail.id_pengajuan', '=', 'pengajuan.id_pengajuan')->whereNotNull('file_berita')->count() }}
            Program
            - Rp
            {{ number_format($datas->clone()->rightJoin('pengajuan_detail', 'pengajuan_detail.id_pengajuan', '=', 'pengajuan.id_pengajuan')->rightJoin('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')->where('pencairan_status', 'Berhasil Dicairkan')->whereNotNull('file_berita')->sum('nominal_bantuan'), 0, '.', '.') }}
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
            <th style="border: 1px solid #000;width: 28%; vertical-align:middle;text-align:center">Nomor & Nominal
                Pengajuan</th>

            <th style="border: 1px solid #000; width: 18%;vertical-align:middle;text-align:center">Status Pengajuan</th>
            <th style="border: 1px solid #000; width: 18%;vertical-align:middle;text-align:center">Status Rekomendasi
            </th>
            <th style="border: 1px solid #000; width: 11%;vertical-align:middle;text-align:center">
                Nominal
                <br>
                Disetujui
            </th>
            <th style="border: 1px solid #000; width: 11%;vertical-align:middle;text-align:center">
                Nominal Dapat<br>
                Dicairkan
            </th>
            <th style="border: 1px solid #000; width: 11%;vertical-align:middle;text-align:center">Penyaluran &
                <br>Status LPJ
            </th>

        </tr>
    </thead>
    <tbody>

        @foreach ($data as $a)
            <tr style="page-break-inside: avoid;border: 1px solid #000;">
                {{-- row1 --}}
                <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                    style=" cursor: pointer;border: 1px solid #000; width: 3%;vertical-align:middle;text-align:center">
                    <b>{{ $loop->iteration }}</b>
                </td>
                {{-- row2 --}}
                <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                    style="border: 1px solid #000; width: 28%; vertical-align: middle; text-align: left;"><span
                        style="font-size: 13px; font-weight: bold; ">{{ $a->nomor_surat }}
                    </span>
                    <br><span style="font-size: 13px; font-weight: normal;">Pengajuan
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span
                            style="font-weight: bold;text-align: right;">Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_pengajuan($a->id_pengajuan), 0, '.', '.') }},-
                        </span>
                    </span>
                    <br><span style="font-size: 13px; text-align: left;">Tgl Input
                        <span
                            style="font-weight: bold;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            {{ Carbon\Carbon::parse($a->created_at)->isoFormat('D MMMM Y') }}
                        </span>
                    </span>
                    <br><span style="font-size: 13px; text-align: left;">Jml.Rencana Kegiatan
                        <span
                            style="font-weight: bold;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ app\Http\Controllers\PengajuanController::hitung_jumlah_rencana($a->id_pengajuan) }}
                        </span>
                    </span>
                    <br><span style="font-size: 13px; text-align: left;">Jml.Penerima Manfaat
                        <span
                            style="font-weight: bold;text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ app\Http\Controllers\PengajuanController::hitung_jumlah_penerima($a->id_pengajuan) }}
                        </span>
                    </span>
                </td>

                {{-- status pengajuan --}}
                <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                    style=" cursor: pointer;border: 1px solid #000; width: 18%;vertical-align:middle;text-align:left">
                    @if ($a->status_pengajuan == 'Diajukan')
                        <p
                            style="vertical-align:middle; display: inline-block; padding: 2px ; border-radius: 3px; background-color: #28a745; color: #fff; font-weight: bold; font-size: 13px; text-align: center;">
                            Diajukan
                        </p>
                    @else
                        <p
                            style="vertical-align:middle; display: inline-block; padding: 2px ; border-radius: 3px; background-color: #6c757d; color: #dcdcdc; font-weight: bold; font-size: 13px; text-align: center;">
                            Direncanakan
                        </p>
                    @endif

                    <p style="font-size: 10pt;text-align:left;"><em
                            style="color: #6c757d">{{ $a->tgl_konfirmasi ? Carbon\Carbon::parse($a->tgl_konfirmasi)->isoFormat('D MMMM Y') : '-' }}</em><br>Dikonfirmasi
                        Oleh
                        <br><span
                            style="font-size: 10pt;"><b>{{ $a->dikonfirmasi_oleh_upzis ? app\Http\Controllers\PengajuanController::getNamaPengurus('upzis', $a->dikonfirmasi_oleh_upzis) : '-' }}
                            </b>
                        </span>
                        <br><span
                            style="font-size: 10pt;">{{ $a->dikonfirmasi_oleh_upzis ? app\Http\Controllers\PengajuanController::getJabatanPengurus('upzis', $a->dikonfirmasi_oleh_upzis) : '-' }}
                        </span>
                    </p>
                </td>
                {{-- status pengajuan --}}

                {{-- status rekomendasi --}}
                <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                    style=" cursor: pointer;border: 1px solid #000; width: 18%;vertical-align:middle;text-align:left">
                    @if ($a->status_rekomendasi == 'Sudah Terbit')
                        <p
                            style="display: inline-block; width: 100%; border: 1px solid #ced4da; border-radius: 10px; background-color: #cbf2d6; padding: 5px; text-align: center; font-weight: bold; font-size: 13px; color: #28a745;">
                            Sudah Terbit
                        </p>
                    @elseif ($a->status_rekomendasi == 'Ditolak')
                        <p
                            style="display: inline-block; width: 100%; border: 1px solid #ced4da; border-radius: 10px; background-color: #f2cbcb; padding: 5px; text-align: center; font-weight: bold; font-size: 13px; color: #a72831;">
                            Ditolak
                        </p>
                    @else
                        <p
                            style="display: inline-block; width: 100%; border: 1px solid #6c757d; border-radius: 10px; background-color: #dcdcdc; padding: 5px; text-align: center; font-weight: bold; font-size: 13px; color: #6c757d;">
                            Belum Terbit
                        </p>
                    @endif
                    @if ($a->pj_upzis)
                        <p style="font-size: 10pt;text-align:left;"><em
                                style="color: #6c757d;">{{ $a->tgl_terbit_rekomendasi ? Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('D MMMM Y') : '-' }}</em>
                            <br>PJ Pengambilan Dana<br><span
                                style="font-size: 10pt;"><b>{{ $a->pj_upzis ? app\Http\Controllers\PengajuanController::getNamaPengurus('upzis', $a->pj_upzis) : '-' }}</b>
                            </span><br><span
                                style="font-size: 10pt;">{{ $a->pj_upzis ? app\Http\Controllers\PengajuanController::getJabatanPengurus('upzis', $a->pj_upzis) : '-' }}
                            </span>
                        </p>
                    @else
                        <p style="font-size: 10pt;text-align:left;"><em
                                style="color: #6c757d;">{{ $a->tgl_terbit_rekomendasi ? Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('D MMMM Y') : '-' }}</em>
                            <br>PJ Pengambilan Dana<br><span
                                style="font-size: 10pt;"><b>{{ $a->pj_ranting ? app\Http\Controllers\PengajuanController::getNamaPengurus('ranting', $a->pj_ranting) : '-' }}</b>
                            </span><br><span
                                style="font-size: 10pt;">{{ $a->pj_ranting ? app\Http\Controllers\PengajuanController::getJabatanPengurus('ranting', $a->pj_ranting) : '-' }}
                            </span>
                        </p>
                    @endif

                </td>
                {{-- status rekomendasi --}}

                {{-- row3 --}}
                <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                    style=" cursor: pointer;border: 1px solid #000; width: 11%;vertical-align:middle;text-align:right">
                    <b
                        style="color:#28a745;font-size: 10pt;">Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_pengajuan_disetujui($a->id_pengajuan), 0, '.', '.') }},-</b>
                    <br><em
                        style="font-size: 10pt; text-align:right;color: #28a745">{{ app\Http\Controllers\PengajuanController::detailSetujui($a->id_pengajuan)['acc'] }}
                        ACC</em>
                    <br><em
                        style="font-size: 10pt; text-align:right;color: #6c757d">{{ app\Http\Controllers\PengajuanController::detailSetujui($a->id_pengajuan)['belum'] }}
                        Belum</em>
                    <br><em
                        style="font-size: 10pt; text-align:right;color: #dc3545">{{ app\Http\Controllers\PengajuanController::detailSetujui($a->id_pengajuan)['tolak'] }}
                        Ditolak</em>

                </td>
                {{-- end jumlah nominal diajukan --}}

                {{-- jumlah nominal pencairan --}}
                <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                    style=" cursor: pointer;border: 1px solid #000; width: 11%;vertical-align:middle;text-align:right">
                    <b style="color:#ffc107"
                        style="font-size: 10pt;">Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_pencairan($a->id_pengajuan), 0, '.', '.') }},-</b>
                    <br><em
                        style="font-size: 10pt;text-align:right;color:#ffc107">{{ app\Http\Controllers\PengajuanController::detailPencairan($a->id_pengajuan)['acc'] }}
                        ACC</em>
                    <br><em
                        style="font-size: 10pt;text-align:right;color: #6c757d">{{ app\Http\Controllers\PengajuanController::detailPencairan($a->id_pengajuan)['belum'] }}
                        Belum</em>
                    <br><em
                        style="font-size: 10pt;text-align:right;color: #dc3545">{{ app\Http\Controllers\PengajuanController::detailPencairan($a->id_pengajuan)['tolak'] }}
                        Ditolak</em>

                </td>
                {{-- end jumlah nominal pencairan --}}

                {{-- lpj --}}
                <td onclick="window.open('/{{ $role }}/detail-pengajuan/{{ $a->id_pengajuan }}', '_blank');"
                    style=" cursor: pointer;border: 1px solid #000; width: 11%;vertical-align:middle;text-align:right">
                    <b style="color: #007bff"
                        style="font-size: 10pt;">Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_penyaluran($a->id_pengajuan), 0, '.', '.') }},-</b>
                    <br><em
                        style="font-size: 10pt;text-align:right;color: #007bff">{{ app\Http\Controllers\PengajuanController::detailPenyaluran($a->id_pengajuan)['konfirmasi'] }}
                        Sudah LPJ</em>
                    <br><b
                        style="font-size: 10pt;text-align:right;color: #28a745;">Rp{{ number_format(app\Http\Controllers\PengajuanController::hitung_nominal_penyaluran2($a->id_pengajuan), 0, '.', '.') }},-</b>
                    <br><em
                        style="font-size: 10pt;text-align:right;color: #28a745;">{{ app\Http\Controllers\PengajuanController::detailPenyaluran($a->id_pengajuan)['selesai'] }}
                        ACC</em>
                    <br><em
                        style="font-size: 10pt;text-align:right;color: #6c757d">{{ app\Http\Controllers\PengajuanController::detailPenyaluran($a->id_pengajuan)['belum'] }}
                        Belum</em>
                    <br><em
                        style="font-size: 10pt;text-align:right;color: #dc3545">{{ app\Http\Controllers\PengajuanController::detailPenyaluran($a->id_pengajuan)['revisi'] }}
                        Ditolak</em>

                </td>

            </tr>
        @endforeach
    </tbody>
</table>
