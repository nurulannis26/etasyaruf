<!DOCTYPE html>
<html>

<head>
    <title>{{ str_replace('/', '_', $pengajuan->nomor_surat) . '_PENERIMA_MANFAAT' }}</title>
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
                            style=" margin-right:25pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:13pt;">
                            <strong><span>DAFTAR PENERIMA MANFAAT</span></strong>
                        </p>
                        <p
                            style="margin-top:0pt;  margin-right:25pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:13pt;">
                            <strong><span>
                                    {{$pengajuan->nomor_surat}}
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
        
        <table cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse;font-size:11pt; margin-top: 10pt;">
            <tr style="background-color:">
                <td style="width: 10%;vertical-align:middle;text-align:left; border: none;height:0.3cm;">
                    Pilar
                </td>
                <td style="width: 1%;padding-left:2mm;vertical-align:middle;text-align:left; border: none;height:0.3cm;">
                    :
                </td>
                <td style="width: 40%;padding-left:2mm;vertical-align:middle;text-align:left; border: none;">
                    {{$nama_pilar}}
                </td>
            </tr>
            <tr style="background-color:">
                <td style="width: 10%;vertical-align:middle;text-align:left; border: none;height:0.3cm;">
                    Program
                </td>
                <td style="width: 1%;padding-left:2mm;vertical-align:middle;text-align:left; border: none;height:0.3cm;">
                    :
                </td>
                <td style="width: 40%;padding-left:2mm;vertical-align:middle;text-align:left; border: none;">
                    {{$nama_program}}
                </td>
            </tr>
            <tr style="background-color:">
                <td style="width: 10%;vertical-align:bottom;text-align:left; border: none;height:0.3cm;">
                    Keterangan
                </td>
                <td style="width: 1%;padding-left:2mm;vertical-align:bottom;text-align:left; border: none;height:0.3cm;">
                    :
                </td>
                <td style="width: 100%;padding-left:2mm;vertical-align:bottom;text-align:left; border: none;height:0.3cm;">
                    {{$pengajuan_det->pengajuan_note}}
                </td>
            </tr>
        </table>



        <table cellspacing="0" cellpadding="0"
            style="width:100%; border:0.75pt solid #000000; border-collapse:collapse; margin-top:12pt">
            <tbody>
                <tr>
                    <td
                        style="width:16.5pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">No</span></p>
                    </td>
                    <td
                        style="width:30pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">Penerima Manfaat</span></p>
                    </td>
                    <td
                        style="width:70pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">Alamat & No HP</span></p>
                    </td>
                    <td
                        style="width:60pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">Nominal & Jenis Bantuan</span></p>
                    </td>
                    <td
                        style="width:65pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">Keterangan</span></p>
                    </td>
                    <td
                        style="width:45pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle; background-color:#cbf2d6;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="y">TTD</span></p>
                    </td>
                </tr>
                @php
                    $noUrut = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td
                            style="width:16.5pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:10pt;"><span
                                    style="y">{{ $noUrut++ }}.</span></p>
                        </td>

                        <td
                            style="width:30pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:10pt;"><span
                                    style="y"><b>{{ $item->nama ?? '-' }}</b><br>
                                    NIK&nbsp;: {{ $item->nik ?? '-' }} <br>
                                    KK&nbsp;&nbsp;: {{ $item->nokk ?? '-' }}
                                </span>
                            </p>
                        </td>
                        <td
                            style="width:70pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:10pt;"><span
                                    style="y"><b>{{ $item->alamat ?? '-' }}</b> <br>
                                    {{ $item->nohp ?? '-' }}</span>
                            </p>
                        </td>
                        <td
                            style="width:51.25pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:10pt;"><span
                                    style="y"><b>Rp{{ number_format($item->nominal_bantuan, 0, '.', '.') }},-</b><br>
                                    {{ $item->jenis_bantuan ?? '-' }}
                                </span>
                            </p>
                        </td>
                        <td
                            style="width:57pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:10pt;"><span
                                    style="y">{{ $item->keterangan ?? '-' }}</span></p>
                        </td>
                        <td
                            style="width:45pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:5pt; margin-bottom:5pt; line-height:115%; font-size:10pt;"><span
                                    style="y">&nbsp;</span></p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </body>
</main>
