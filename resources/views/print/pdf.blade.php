<!DOCTYPE html>
<html>

<head>
    <title>Pengajuan</title>
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

        <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;font-size:11pt;">
            <tbody>
                <tr style="height:20.8pt;">
                    <td colspan="2" style="width:143.45pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:'Times New Roman';">Pemohon</span></p>
                    </td>
                    <td style="width:118.35pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:'Times New Roman';">Diterima Oleh</span></p>
                    </td>
                    <td colspan="2" style="width:122.25pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:'Times New Roman';">Disetujui Oleh</span></p>
                    </td>
                    <td style="width:159.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:'Times New Roman';">Divisi Keuangan</span></p>
                    </td>
                    <td style="width:102.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:'Times New Roman';">Lampiran :</span></p>
                    </td>
                </tr>
                <tr style="height:21.1pt;">
                    <td colspan="2" style="width:143.45pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                    <td style="width:118.35pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                    <td colspan="2" style="width:122.25pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                    <td style="width:159.2pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span style="font-family:'Times New Roman';">Diperiksa dan Disetujui Oleh</span></p>
                    </td>
                    <td style="width:102.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <ol type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:14pt; padding-left:2pt; font-family:'Times New Roman'; font-size:12pt;">RAB</li>
                            <li style="margin-left:14pt; padding-left:2pt; font-family:'Times New Roman'; font-size:12pt;">T.O.R Program</li>
                        </ol>
                    </td>
                </tr>
                <tr style="height:49.15pt;">
                    <td style="width:65.5pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle;">
                        <p style="margin-top:15pt; margin-bottom:15pt; text-align:left; font-size:11pt;"><span style="font-family:'Times New Roman';">Tanda Tangan</span></p>
                    </td>
                    <td style="width:67.15pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:15pt; margin-bottom:15pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                    <td style="width:118.35pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:15pt; margin-bottom:15pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                    <td style="width:121.9pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:15pt; margin-bottom:15pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                    <td colspan="2" style="width:159.55pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:15pt; margin-bottom:15pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                    <td style="width:102.75pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:'Times New Roman';">Keterangan PPD :</span></p>
                        <ol type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:13.25pt; padding-left:2.75pt; font-family:'Times New Roman'; font-size:11pt;">Segera</li>
                        </ol>
                    </td>
                </tr>
                <tr style="height:20.8pt;">
                    <td style="width:65.5pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:left; font-size:11pt;"><span style="font-family:'Times New Roman';">Nama</span></p>
                    </td>
                    <td style="width:67.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                    <td style="width:118.35pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span style="font-family:'Times New Roman';">MUAFAH</span></strong></p>
                    </td>
                    <td style="width:121.9pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span style="font-family:'Times New Roman';">ABATA</span></strong></p>
                    </td>
                    <td colspan="2" style="width:159.55pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span style="font-family:'Times New Roman';">BABA</span></strong></p>
                    </td>
                    <td style="width:102.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                </tr>
                <tr style="height:20.8pt;">
                    <td style="width:65.5pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:left; font-size:11pt;"><span style="font-family:'Times New Roman';">Jabatan</span></p>
                    </td>
                    <td style="width:67.15pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                    <td style="width:118.35pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">Staff</span></p>
                    </td>
                    <td style="width:121.9pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">Direktur</span></p>
                    </td>
                    <td colspan="2" style="width:159.55pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">Keuangan</span></p>
                    </td>
                    <td style="width:102.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
                    </td>
                </tr>
                <tr style="height:0pt;">
                    <td style="width:76.3pt;"><br></td>
                    <td style="width:77.95pt;"><br></td>
                    <td style="width:129.15pt;"><br></td>
                    <td style="width:132.7pt;"><br></td>
                    <td style="width:0.35pt;"><br></td>
                    <td style="width:170pt;"><br></td>
                    <td style="width:113.55pt;"><br></td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top:0pt; margin-bottom:8pt; text-align:center;"><span style="font-family:'Times New Roman';">&nbsp;</span></p>
        <p style="bottom: 10px; right: 10px; position: absolute;"><a href="https://wordtohtml.net" target="_blank" style="font-size:11px; color: #d0d0d0;">Converted to HTML with WordToHTML.net</a></p>

    </body>




</main>




</html>
