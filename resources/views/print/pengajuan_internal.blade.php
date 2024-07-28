<!DOCTYPE html>
<html>

<head>
    <title>REKAP PENGAJUAN PENTASYARUFAN TINGKAT INTERNAL LAZISNU CILACAP {{ strtoupper($filter_daterange) }}
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>


<style>
    @page {
        margin: 0.5cm;
    }

    header {
        /* position: fixed; */
        margin-top: -0.1cm;
        left: 0cm;
        right: 0cm;
        height: 1cm;
        text-align: center;
    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 1cm;
        text-align: center;
    }

    footer .pagenum:before {
        content: counter(page);
    }
</style>

<footer>
    <div class="pagenum-container">
        <div style="clear:both;color:#9d9d9d">
            <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal;
            border-bottom:2.25pt double #000000; padding-bottom:1pt; font-size:10pt;">
                <strong><em>&nbsp;</em></strong>
            </p>
            <p
                style="margin-top:3pt; margin-bottom:0pt; text-align:right; line-height:150%; widows:0; orphans:0; font-size:11pt;">
            </p>
            <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal; font-size:10pt;">
                <strong><em>Sistem Informasi Filantropi Nahdlatul Ulama, E-Tasyaruf</em></strong>
            </p>
            <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal; font-size:10pt;">
                <em>Dicetak
                    {{ Carbon\Carbon::parse(now())->isoFormat('D MMMM Y') . ' ' .
                    Carbon\Carbon::parse(now())->format('H:i:s') . ' ' }}
                </em>
            </p>
        </div>
    </div>
</footer>

<main>

    {{-- RENCANA --}}
    <div>
        <header>
            <table style="width:100%">
                <tr>
                    <td style="width:33%" class="text-left"><img src="{{ public_path('/images/gocap.png') }}" width="76"
                            height="76" style="margin: 0 auto 0 0; display: block; "></td>
                    <td style="width:33%" class="text-center"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                            width="146" height="76" style="margin: 0 auto; display: block; "></td>
                    <td style="width:33%" class="text-right"><img src="{{ public_path('/images/siftnu.png') }}"
                            width="146" height="76" style="margin: 0 0 0 auto; display: block; "></td>
                </tr>
            </table>
        </header>

        <body>
            <table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;">
                <tbody>
                    <tr>
                        <td colspan="5" style="100%; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0.8cm; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>REKAP PENGAJUAN PENTASYARUFAN TINGKAT INTERNAL LAZISNU CILACAP
                                    </span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>
                                        PERIODE {{ strtoupper($filter_daterange) }}
                                    </span></strong>
                            </p>

                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <style>
                .pengajuan tr th,
                .pengajuan tr td {
                    border: 1pt solid #000000;
                    border-collapse: collapse;
                    font-size: 10pt;
                }

                .text-right {
                    text-align: right !important;
                }

                .my-bold {
                    font-weight: bold;
                }

                .kanan {
                    padding-top: -1000rem !important;
                    width: 50%;
                    float: right;
                }

                .kiri {
                    width: 50%;
                    float: left;
                }

                td {
                    vertical-align: top;
                }
            </style>
            <span></span>

            <table class="pb-2" style="width:100%">
                <tr>
                    <td style="text-align: center">
                        Total Pengajuan : <b>{{ $adaCount }}</b>
                    </td>
                    <td style="text-align: center">
                        Pengajuan Disetujui : <b>{{ $adaSetuju }}</b>
                    </td>
                    <td style="text-align: center">
                        Pengajuan Dicairkan : <b>{{ $adaCair }}</b>
                    </td>
                </tr>
            </table>
            <table class="pengajuan" cellpadding="5">

                <thead>
                    <tr class="text-center">
                        <th style="width: 3%;">No</th>
                        <th style="width: 30%;">Nomor
                            &amp; Nominal Pengajuan</th>
                        <th style="width: 30%;">Tujuan
                            &amp; Keterangan</th>
                        <th style="width: 15%;">Persetujuan
                        </th>
                        <th style="width: 15%;">Pencairan
                        </th>
                    </tr>
                </thead>

                <tbody style="border: #000000">
                    @forelse($data as $a)
                    @empty
                    <tr>
                        {{-- jika tabel kosong --}}
                        <td colspan="6" class="text-center"> Data
                            tidak ditemukan</td>
                    </tr>
                    @endforelse
                    @foreach ($data as $a)
                    <tr style="align-items: top">
                        <td class="text-center text-bold">{{ $loop->iteration }}</td>
                        <td>
                            <div>
                                @if ($a->tgl_pengajuan != null)
                                <span class="badge badge-success text-white">FPPD berhasil diajukan</span>
                                <br>
                                @else
                                <span class="badge badge-warning text-white">FPPD belum selesai diajukan</span>
                                <br>
                                @endif
                            </div>
                            <div>
                                <b style="font-size: 13px">
                                    {{ $a->nomor_surat }}
                                </b>
                            </div>
                            <div style="width: 100%;">
                                <div class="text-left" style="width:100%;float: inline-start;">
                                    Pengajuan
                                    <div class="text-right my-bold" style="width:50%;float: right">
                                        Rp<span id="nominal">{{ number_format($a->nominal_pengajuan), 0, '.', '.'
                                            }}</span>,-
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div style="width: 100%;">
                                <div class="text-left" style="width:100%;float: inline-start;">Tgl Pengajuan
                                    <div class="text-right my-bold" style="width:50%;float: right">
                                        {{ Carbon\Carbon::parse($a->tgl_pengajuan)->isoFormat('D MMMM Y') }}
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div style="width: 100%;">
                                <div class="text-left" style="width:100%;float: inline-start;">Tgl Input
                                    <div class="text-right my-bold" style="width:50%;float: right">
                                        {{ Carbon\Carbon::parse($a->created_at)->isoFormat('D MMMM Y') }}
                                    </div>
                                </div>
                            </div>
                            <br>
                            {{-- <div class=" text-right">
                                <div class="text-left" style="width:100%;float: inline-start;">Diajukan Oleh
                                    <div class="text-right my-bold" style="width:50%;float: right">
                                        @php
                                        $siftnu="n1651709_siftnu";
                                        @endphp
                                        {{ DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus',
                                        $a->maker_tingkat_pc)->first()->nama; }}
                                    </div>
                                </div>
                            </div><br> --}}

                            <div style="width: 100%;">
                                <div class="text-left" style="width:100%;float: inline-start;">Diajukan Oleh
                                    <div class="text-right my-bold" style="width:50%;float: right">
                                        @php
                                        $siftnu="n1651709_siftnu";
                                        @endphp
                                        {{ DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus',
                                        $a->maker_tingkat_pc)->first()->nama; }}
                                    </div>
                                </div>
                            </div>
                            <div class=" text-right">
                                <div class="  text-left" style="font-size: 13px;">
                                    &nbsp;
                                </div>
                                <div class=" -bottom-3 text-right" style="font-size: 13px;">
                                    <b style="font-size: 13px;">
                                        &nbsp;
                                    </b>
                                </div>
                            </div>

                        </td>
                        <td>
                            <div>
                                @if ($a->approval_status_divpro == 'Disetujui')
                                <span class="text-light badge badge-success">
                                    Disposisi Diterima Div. Program</span>
                                <br>
                                @else
                                <span class="text-light badge badge-warning">
                                    Disposisi Blm Diterima Div. Program
                                </span>
                            </div>
                            <br>
                            @endif
                            <div class="" style="font-size: 13px;">
                                <div class="my-bold" style="width: 100%;float: inline-start;">
                                    <span>Sebelum</span>
                                    <div class="text-right my-bold" style="width:50%;float: right">
                                        {{ Carbon\Carbon::parse($a->tgl_tenggat)->isoFormat('D MMMM Y') }}
                                    </div>
                                </div><br>
                                <span class="my-bold" style="font-size: 13px;">
                                    {{ $a->tujuan }}
                                </span>

                            </div>
                            <div class="text-left" style="font-size: 13px;">
                                <em class="text-secondary">
                                    {{ $a->note }}
                                </em>
                            </div>
                        </td>
                        <td>
                            @if ($a->approval_status_divpro == 'Disetujui')
                            @if ($a->approval_status == 'Belum Direspon')
                            <span class="badge badge-warning text-white">Pengajuan blm disetujui
                                Direktur</span>
                            <br>
                            @elseif($a->approval_status == 'Disetujui')
                            <span class="badge badge-success text-white">Pengajuan disetujui Direktur</span>
                            <br>
                            @else
                            <span class="badge badge-danger text-white">Pengajuan ditolak Direktur</span>
                            <br>
                            @endif
                            @else
                            <span class="text-secondary" style="font-size: 13px;">Blm Disetujui</span>
                            <br>
                            @endif
                            <div class="text-left" style="font-size: 13px;">
                                <span class="text-secondary">
                                    @if ($a->approval_status == 'Disetujui')
                                    {{ Carbon\Carbon::parse($a->approval_date)->isoFormat('D MMMM Y') }}
                                    @endif
                                </span>
                            </div>
                            <div class=" text-right">
                                <div class=" text-bold  text-left"
                                    style="font-size: 10pt;width:100%;float:inline-start;">
                                    Nominal
                                    <b class="text-bold text-right text-success"
                                        style="font-size: 10pt; width:50%;float:right;">
                                        Rp{{ number_format($a->nominal_disetujui), 0, '.', '.' }},-
                                    </b>
                                </div>
                            </div><br>
                            <div class=" text-right">
                                <div class="  text-left" style="font-size: 13px;">
                                    Catatan
                                </div>
                                <div class=" -bottom-3text-right" style="font-size: 13px;">
                                    <em style="font-size: 13px;">
                                        {{ $a->approval_note ?? '-' }}
                                    </em>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($a->approval_status == 'Disetujui')
                            @if ($a->pencairan_status == 'Belum Dicairkan')
                            <span class="badge badge-warning text-white">Pencairan blm disetujui Div.
                                Keuangan</span>
                            @elseif ($a->pencairan_status == 'Berhasil Dicairkan')
                            <span class="badge badge-success text-white">Pencairan disetujui Div.
                                Keuangan</span>
                            @endif
                            <br>
                            @else
                            <span class="badge badge-secondary text-white">Blm Disetujui</span>
                            <br>
                            @endif

                            <div class="text-left" style="font-size: 13px;">
                                <span class="text-secondary">
                                    @if ($a->pencairan_status == 'Berhasil Dicairkan')
                                    {{ Carbon\Carbon::parse($a->approval_date)->isoFormat('D MMMM Y') }}
                                    @endif
                                </span>
                            </div>
                            <div class="">
                                <div class=" text-bold  text-left"
                                    style="font-size: 10pt; width:100%;float:inline-start">
                                    Nominal
                                    <b class="text-success text-right" style="font-size: 10pt;width:50%;float:right">
                                        Rp{{ number_format($a->nominal_pencairan), 0, '.', '.' }},-
                                    </b>
                                </div>
                            </div><br>
                            <div class=" text-right">
                                <div class="  text-left" style="font-size: 13px;">
                                    Catatan
                                </div>
                                <div class=" text-right" style="font-size: 13px;">
                                    <em style="font-size: 13px;">
                                        {{ $a->pencairan_note ?? '-' }}
                                    </em>
                                </div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
                {{-- <tbody>


                    @php
                    $total_nominal_pengajuan = 0;
                    $total_nominal_disetujui = 0;

                    @endphp

                    @foreach ($data as $b)
                    @php

                    $nominal_pengajuan =
                    App\Http\Controllers\PrintPengajuanController::internal_hitung_nominal_pengajuan($b->id_internal);
                    $nominal_disetujui =
                    App\Http\Controllers\PrintPengajuanController::internal_hitung_nominal_pengajuan_disetujui($b->id_internal);
                    $total_nominal_pengajuan += $nominal_pengajuan;
                    $total_nominal_disetujui += $nominal_disetujui;

                    @endphp

                    <tr>
                        <td class="text-center" style="vertical-align:top; border: 1px solid black;">
                            {{ $loop->iteration }}</td>
                        <td style="vertical-align:top;border: 1px solid black;padding-left:2mm">
                            {{ $b->nomor_surat }}
                        </td>
                        <td style="vertical-align:top;border: 1px solid black;padding-left:1mm;text-align:center">
                            {{ $b->bentuk }}
                        </td>


                        <td style="border: 1px solid black;padding-left:1mm;padding-right:1mm;vertical-align: top;">
                            <span>Rp</span>
                            <span style="float:right;">
                                {{ number_format($nominal_pengajuan, 0, '.', '.') }},-</span>

                        </td>
                        <td style="border: 1px solid black;padding-left:1mm;padding-right:1mm;vertical-align: top;">
                            <span>Rp</span>
                            <span style="float:right;">
                                {{ number_format($nominal_disetujui, 0, '.', '.') }},-</span>
                        </td>
                        <td class="text-center" style="border: 1px solid black;vertical-align:top;">
                            {{ Carbon\Carbon::parse($b->tgl_tenggat)->isoFormat('D MMMM Y') }}
                        </td>

                        <td class="text-center" style="border: 1px solid black;vertical-align:top;">
                            {{ Carbon\Carbon::parse($b->tgl_pengajuan)->isoFormat('D MMMM Y') }}
                        </td>
                        <td class="text-center" style="border: 1px solid black;vertical-align:top;">
                            {{ App\Http\Controllers\PrintPengajuanController::nama_pengurus_pc($b->maker_tingkat_pc) }}
                        </td>
                    </tr>
                    @endforeach





                    <tr style="background-color:#cbf2d6;border-bottom: 1px solid black;">
                        <td colspan="2" style="padding-left: 2mm;"><b> TOTAL </b></td>
                        <td style="padding-left: 1mm;text-align:center"><b> </b></td>

                        <td style="padding-left: 1mm;vertical-align: top;">
                            <span><b>Rp</b></span>
                            <span style="float:right;">
                                <b>
                                    {{ number_format($total_nominal_pengajuan, 0, '.', '.') }},-</b></span>
                        </td>
                        <td style="padding-left: 1mm;vertical-align: top;">
                            <span><b>Rp</b></span>
                            <span style="float:right;">
                                <b>
                                    {{ number_format($total_nominal_disetujui, 0, '.', '.') }},-</b></span>

                        </td>
                        <td colspan="3" style="padding-left: 2mm;"><b> </b></td>

                    </tr>



                </tbody> --}}

            </table>







        </body>
    </div>
    {{-- end rencana --}}


</main>




</html>