<!DOCTYPE html>
<html>

<head>
    <title>{{ str_replace('/', '_', $pengajuan->nomor_surat) . '_PENGGUNAAN_DANA' }}</title>
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

            <p
                style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal; border-bottom:2.25pt double #000000; padding-bottom:1px; font-size:10pt;">
                <strong><em>&nbsp;</em></strong>
            </p>
            <p
                style="margin-top:3pt; margin-bottom:0pt; text-align:right; line-height:150%; widows:0; orphans:0; font-size:11px;">
            </p>
            <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal; font-size:10pt;">
                <strong><em>Sistem Informasi Filantropi Nahdlatul Ulama, E-Tasyaruf</em></strong>
            </p>

            <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal; font-size:10pt;">
                <em>Dicetak
                    {{ Carbon\Carbon::parse(now())->isoFormat('D MMMM Y') . ' ' . Carbon\Carbon::parse(now())->format('H:i:s') . ' ' }}

                </em>
            </p>

        </div>

    </div>
</footer>

<main>
    <div>
        <header>
            <table style="width:100%">
                <tr>
                    <td class="text-left" style="width: 10%;"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                            width="130" height="76" style="margin: 0 auto 0 0; display: block; "></td>
                    <td style="width:120%" class="text-center">
                        <p
                            style=" margin-right:45pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:13pt;">
                            <strong><span>REALISASI PENGGUNAAN DANA</span></strong>
                        </p>
                        <p
                            style="margin-top:0pt;  margin-right:45pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:13pt;">
                            <strong><span>
                                    MANAJEMEN EKSEKUTIF NUCARE LAZISNU CILACAP
                                </span></strong>
                        </p>

                    </td>
                    <td class="text-right" style="width: 10%;"><img src="{{ public_path('/images/siftnu.png') }}"
                            width="130" height="66" style="margin: 0 auto 0 0; display: block; "></td>
                </tr>
            </table>
        </header>
    </div>

    <body>

        <br>
        <br>

        <table cellpadding="0" cellspacing="0"
            style="width:100%;border:0.75pt solid #000000;border-collapse:collapse;font-size:11pt; margin-top: 20pt;">

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 30%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    No Pengajuan
                </td>
                <td colspan="2"
                    style="width: 40%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ $pengajuan->nomor_surat }}
                </td>

            </tr>

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Pemohon
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ App\Http\Controllers\PrintController::nama_pengurus_pc($pengajuan->maker_tingkat_pc) }}
                </td>
            </tr>

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Tgl Dicairkan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ Carbon\Carbon::parse($pengajuan->tgl_pencairan)->isoFormat('D MMMM Y') }}
                </td>
            </tr>

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Nominal Pencairan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    Rp {{ number_format($pengajuan->nominal_pencairan, 0, '.', '.') }},-
                </td>
            </tr>
            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Nominal Digunakan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    Rp {{ number_format($nominal_digunakan, 0, '.', '.') }},-
                </td>
            </tr>
            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Sisa Dana
                </td>
                @php
                    if ($sisa_dana < 0) {
                        $format_sisa_dana = '- Rp ' . number_format(abs($sisa_dana), 0, '.', '.') .',-';
                        $warna = 'danger';
                    } else {
                        $format_sisa_dana = 'Rp ' . number_format($sisa_dana, 0, '.', '.').',-';
                        $warna = 'black';
                    }
                @endphp
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid">
                    <span class="text-{{ $warna }}">{{ $format_sisa_dana }}</span>
                </td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0"
            style="width:100%; border:0.75pt solid #000000; border-collapse:collapse; margin-top:20pt">
            <tbody>
                {{-- <tr>
                    <td colspan="2"
                        style="width:16.5pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:left; background-color:#cbf2d6;" >
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                    style="y">Nominal Dicairkan: Rp 200.000</span></p>
                    </td>
                    <td colspan="2"
                        style="width:60pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:left; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                    style="y">Nominal Digunakan: Rp 200.000</span></p>
                    </td>
                    <td colspan="2"
                        style="width:60pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:left; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                    style="y">Sisa Dana: Rp 200.000</span></p>
                    </td>
                </tr> --}}
                <tr>
                    <td
                        style="width:16.5pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">No</span></p>
                    </td>
                    <td
                        style="width:40pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">Tgl Input</span></p>
                    </td>
                    <td
                        style="width:40pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">Tgl Penggunaan Dana</span></p>
                    </td>
                    <td
                        style="width:60pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">Dibayarkan Kepada</span></p>
                    </td>
                    <td
                        style="width:65pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">Nominal</span></p>
                    </td>
                    <td
                        style="width:65pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">Keterangan</span></p>
                    </td>
                </tr>
                @php
                    $noUrut = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td
                            style="width:16.5pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:11pt;"><span
                                    style="y">{{ $noUrut++ }}.</span></p>
                        </td>

                        <td
                            style="width:40pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:11pt;"><span
                                    style="y">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }} <br>
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}
                                </span>
                            </p>
                        </td>
                        <td
                            style="width:40pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:11pt;"><span
                                    style="y">{{ \Carbon\Carbon::parse($item->tgl_penggunaan_dana)->format('d/m/Y') }}<br>
                                    {{ \Carbon\Carbon::parse($item->tgl_penggunaan_dana)->format('H:i:s') }}</span>
                            </p>
                        </td>
                        <td
                            style="width:51.25pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:11pt;"><span
                                    style="y">{{ $item->dibayarkan_kepada ?? '-' }}</span>
                            </p>
                        </td>
                        <td
                            style="width:57pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:11pt;"><span
                                    style="y">Rp.
                                    {{ number_format($item->nominal, 0, ',', '.') }}</span></p>
                        </td>
                        <td
                            style="width:57pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:11pt;"><span
                                    style="y">{{ $item->keterangan ?? '-' }}</span></p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="page-break-before: always;"></div>

        <header>
            <table style="width:100%">
                <tr>
                    <td class="text-left" style="width: 10%;"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                            width="130" height="76" style="margin: 0 auto 0 0; display: block; "></td>
                    <td style="width:120%" class="text-center">
                        <p
                            style=" margin-right:45pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:13pt;">
                            <strong><span>REALISASI PENGGUNAAN DANA</span></strong>
                        </p>
                        <p
                            style="margin-top:0pt;  margin-right:45pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:13pt;">
                            <strong><span>
                                    MANAJEMEN EKSEKUTIF NUCARE LAZISNU CILACAP
                                </span></strong>
                        </p>

                    </td>
                    <td class="text-right" style="width: 10%;"><img src="{{ public_path('/images/siftnu.png') }}"
                            width="130" height="66" style="margin: 0 auto 0 0; display: block; "></td>
                </tr>
            </table>
        </header>

        {{-- <p style=" margin-right:20px;margin-bottom:0pt; text-align:left; font-size:13pt;">
            <strong><span>Nota : {{ $item->dibayarkan_kepada }}</span></strong>
        </p> --}}
        @foreach ($data as $item)
            <img style="width:45%; height:350px; margin-left:25px; margin-right:25px; margin-top:150px; margin-bottom:70px"
                src="{{ public_path('uploads/penggunaan_dana/') . $item->nota }}" alt="">
        @endforeach

    </body>
</main>
