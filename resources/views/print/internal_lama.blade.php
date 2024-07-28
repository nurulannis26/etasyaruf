<!DOCTYPE html>
<html>

<head>
    <title>{{ str_replace('/', '_', $data->nomor_surat) . '_INTERNAL' }}</title>
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

    {{-- RENCANA --}}
    <div>
        <header>
            <table style="width:100%">
                <tr>
                    <td class="text-left" style="width: 10%;"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                            width="130" height="76" style="margin: 0 auto 0 0; display: block; "></td>
                    <td style="width:120%" class="text-left">
                        <p
                            style=" margin-right:95pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;">
                            <strong><span>FORMULIR PERMOHONAN PENGELUARAN DANA (FPPD)</span></strong>
                        </p>
                        <p
                            style="margin-top:0pt;  margin-right:95pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;">
                            <strong><span>
                                    MANAJEMEN EKSEKUTIF NUCARE LAZISNU CILACAP
                                </span></strong>
                        </p>
                        <p
                            style="margin-top:0pt;  margin-right:95pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;">
                            <strong><span>
                                    F-NUCARE/PYL-01
                                </span></strong>
                        </p>

                    </td>
                </tr>
            </table>
        </header>
    </div>

    <body>

        <br>
        <br>

        <table style="width: 100%;font-size:11pt;">
            {{-- paragraf 1 --}}
            <tr>
                <td style="width: 50%"> </td>
                <td style="width: 50%;text-align:right">No Pengajuan : {{ $data->nomor_surat }}</td>
            </tr>
        </table>

        <table cellpadding="0" cellspacing="0"
            style="width:100%;border:0.75pt solid #000000;border-collapse:collapse;font-size:11pt;">

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Pemohon
                </td>
                <td style="width: 40%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ App\Http\Controllers\PrintController::nama_pengurus_pc($data->maker_tingkat_pc) }}
                </td>
                <td style="width: 40%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    Tanggal Pengajuan : {{ \Carbon\Carbon::createFromFormat('Y-m-d', '2023-11-01')->format('d/m/Y') }}
                </td>

            </tr>

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Jabatan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ App\Http\Controllers\PrintController::jabatan_pengurus_pc($data->maker_tingkat_pc) }}
                </td>
            </tr>

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Jumlah Dana
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    Rp{{ number_format($data->nominal_pengajuan, 0, '.', '.') }},-
                </td>
            </tr>


            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;height:1.7cm;">
                    Keterangan Pengajuan Dana
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;">
                    -
                </td>
            </tr>
            {{-- <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;height:1.7cm;">
                    Tujuan Pengajuan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;">
                    {{ $data->tujuan }}
                </td>
            </tr> --}}

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Tenggat Pencairan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ Carbon\Carbon::parse($data->tgl_tenggat)->isoFormat('dddd, DD MMMM Y') }}
                </td>
            </tr>


            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;height:1.4cm;">
                    Pencairan Dana
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;">
                    {{ $data->bentuk }} <br>
                    @if ($data->bentuk == 'Transfer')
                        {{ $data->bank_tujuan }} - {{ $data->no_rek_tujuan }}
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;height:1.4cm;">
                    Keterangan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;">
                    {{ $data->note }}
                </td>
            </tr>
        </table>

        <br>


        <table cellpadding="0" cellspacing="0"
            style="width:100%; border:0.75pt solid #000000; border-collapse:collapse;font-size:11pt;">
            <tbody>
                <tr style="height:29.9pt;">
                    <td colspan="2"
                        style="width:376.7pt; border-right-style:solid; border-right-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">Status : {{ $data->approval_status }}</span>
                        </p>
                    </td>
                    <td
                        style="width:133.65pt; border-right-style:solid; border-right-width:1px; border-left-style:solid; border-left-width:1px; border-bottom-style:solid; border-bottom-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-left:6.15pt; margin-bottom:2pt; line-height:125%; ">
                            <span style="">Tanggal Disetujui</span>
                        </p>
                    </td>
                    <td
                        style="width:268.35pt; border-left-style:solid; border-left-width:1px; border-bottom-style:solid; border-bottom-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-left:6.15pt; margin-bottom:2pt; line-height:125%; ">
                            <span style="">
                                @if ($data->approval_date == null)
                                    -
                                @else
                                    {{ Carbon\Carbon::parse($data->approval_date)->isoFormat('dddd, DD MMMM Y') }}
                                @endif
                            </span>
                        </p>
                    </td>
                </tr>
                <tr style="height:29.9pt;">
                    <td rowspan="3"
                        style="width:188.25pt; border-top-style:solid; border-top-width:1px; border-right-style:solid; border-right-width:1px; border-bottom-style:solid; border-bottom-width:1px; vertical-align:top;">
                        <p
                            style="margin-top:2pt; margin-left:1.6pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">Diajukan Oleh</span>
                        </p>
                        <p
                            style="margin-top:2pt; margin-left:1.6pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">&nbsp;</span>
                        </p>
                        <p
                            style="margin-top:2pt; margin-left:1.6pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">&nbsp;</span>
                        </p>
                        <p
                            style="margin-top:2pt; margin-left:1.6pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">&nbsp;</span>
                        </p>
                        <p
                            style="margin-top:2pt; margin-left:1.6pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">&nbsp;</span>
                        </p>
                        <p
                            style="margin-top:2pt; margin-left:1.6pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">
                                {{ App\Http\Controllers\PrintController::nama_pengurus_pc($data->maker_tingkat_pc) }}</span>
                        </p>
                        <p
                            style="margin-top:2pt; margin-left:1.6pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">
                                {{ App\Http\Controllers\PrintController::jabatan_pengurus_pc($data->maker_tingkat_pc) }}</span>
                        </p>
                    </td>
                    <td rowspan="3"
                        style="width:187.45pt; border-style:solid; border-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">Disetujui Oleh</span>
                        </p>
                        <p style="margin-top:2pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">&nbsp;</span>
                        </p>
                        <p style="margin-top:2pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">&nbsp;</span>
                        </p>
                        <p style="margin-top:2pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">&nbsp;</span>
                        </p>
                        <p style="margin-top:2pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">&nbsp;</span>
                        </p>
                        <p style="margin-top:2pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">
                                {{ $nama_direktur }}</span>
                        </p>
                        <p style="margin-top:2pt; margin-bottom:2pt; text-align:center; line-height:125%; ">
                            <span style="">
                                Direktur Eksekutif</span>
                        </p>
                    </td>
                    <td style="width:133.65pt; border-style:solid; border-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-left:6.15pt; margin-bottom:2pt; line-height:125%; ">
                            <span style="">Nominal Disetujui</span>
                        </p>
                    </td>
                    <td
                        style="width:268.35pt; border-top-style:solid; border-top-width:1px; border-left-style:solid; border-left-width:1px; border-bottom-style:solid; border-bottom-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-left:6.15pt; margin-bottom:2pt; line-height:125%; ">
                            <span style="">
                                Rp{{ number_format($data->nominal_disetujui, 0, '.', '.') }},-</span>
                        </p>
                    </td>
                </tr>
                <tr style="height:57.05pt;">
                    <td style="width:133.65pt; border-style:solid; border-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-left:6.15pt; margin-bottom:2pt; line-height:125%; ">
                            <span style="">Asal Dana</span>
                        </p>
                    </td>
                    <td
                        style="width:268.35pt; border-top-style:solid; border-top-width:1px; border-left-style:solid; border-left-width:1px; border-bottom-style:solid; border-bottom-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-left:6.15pt; margin-bottom:2pt; line-height:125%; ">
                            <span style="">
                                {{ App\Http\Controllers\PrintController::nama_rekening($data->id_rekening) }}</span>
                        </p>
                    </td>
                </tr>
                <tr style="height:57.05pt;">
                    <td
                        style="width:133.65pt; border-top-style:solid; border-top-width:1px; border-right-style:solid; border-right-width:1px; border-left-style:solid; border-left-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-left:6.15pt; margin-bottom:2pt; line-height:125%; ">
                            <span style="">Catatan Persetujuan</span>
                        </p>
                    </td>
                    <td
                        style="width:268.35pt; border-top-style:solid; border-top-width:1px; border-left-style:solid; border-left-width:1px; vertical-align:top;">
                        <p style="margin-top:2pt; margin-left:6.15pt; margin-bottom:2pt; line-height:125%; ">
                            <span style="">{{ $data->approval_note }}</span>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

    </body>




</main>




</html>
