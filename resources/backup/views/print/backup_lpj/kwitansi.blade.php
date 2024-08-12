<?php
function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
    $temp = '';
    if ($nilai < 12) {
        $temp = ' ' . $huruf[$nilai];
    } elseif ($nilai < 20) {
        $temp = penyebut($nilai - 10) . ' Belas';
    } elseif ($nilai < 100) {
        $temp = penyebut($nilai / 10) . ' Puluh' . penyebut($nilai % 10);
    } elseif ($nilai < 200) {
        $temp = ' Seratus' . penyebut($nilai - 100);
    } elseif ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . ' Ratus' . penyebut($nilai % 100);
    } elseif ($nilai < 2000) {
        $temp = ' Seribu' . penyebut($nilai - 1000);
    } elseif ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . ' Ribu' . penyebut($nilai % 1000);
    } elseif ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . ' Juta' . penyebut($nilai % 1000000);
    } elseif ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . ' Milyar' . penyebut(fmod($nilai, 1000000000));
    } elseif ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . ' Trilyun' . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = 'Minus ' . trim(penyebut($nilai));
    } elseif ($nilai == 0) {
        $hasil = 'Nol ' . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil . ' Rupiah';
}

?>

<!DOCTYPE html>
<html>

<head>
    {{-- <title>Berita Acara Pentasyarufan</title> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2.5cm;
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
                style="margin-top:48pt; margin-bottom:0pt; text-align:right; line-height:normal; border-bottom:2.25pt double #000000; padding-bottom:1pt; font-size:10pt;">
                <strong><em>&nbsp;</em></strong>
            </p>
            <p
                style="margin-top:3pt; margin-bottom:0pt; text-align:right; line-height:150%; widows:0; orphans:0; font-size:11pt;">
            </p>
            <table style="width: 100%;font-size:11pt;">
                <tr>
                    <td style="width: 40%"> <em>Dicetak
                            {{ Carbon\Carbon::parse(now())->isoFormat('D MMMM Y') . ' ' . Carbon\Carbon::parse(now())->format('H:i:s') . ' ' }}</em>
                    </td>
                    <td class="text-right">
                        <strong><em>Sistem Informasi Filantropi Nahdlatul Ulama,
                                E-Tasyaruf</em></strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</footer>
<main>


    <header>

        <table style="width:100%">
            <tr>
                <td style="width:33%" class="text-left"><img src="{{ public_path('/images/gocap.png') }}"
                        width="76" height="76" style="margin: 0 auto 0 0; display: block; "></td>
                <td style="width:33%" class="text-center"><img
                        src="{{ public_path('/images/logo_lazisnu.png') }}" width="146" height="76"
                        style="margin: 0 auto; display: block; "></td>
                <td style="width:33%" class="text-right"><img src="{{ public_path('/images/siftnu.png') }}"
                        width="146" height="76" style="margin: 0 0 0 auto; display: block; "></td>
            </tr>
        </table>

    </header>

    <table cellpadding="0" cellspacing="0" style="width:531.6pt; border-collapse:collapse;">
        <tbody>
            <tr>
                <td colspan="5"
                    style="width:520.8pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                 
                    <p
                    style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                    <strong><span>&nbsp;</span></strong>
                </p>
                    <p
                        style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                        <strong><span>KWITANSI PENERIMA MANFAAT</span></strong>
                    </p>

                    <p
                        style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                        <strong><span>&nbsp;</span></strong>
                    </p>
                   
                </td>
            </tr>
        </tbody>
    </table>

    <body>
        {{-- kertas kwitansi --}}
        <div style="clear: both; ">
           
                <table
                    style="width:100%; height: 6cm; background-color:#E2EFD9; font-size:9pt; position: relative;page-break-inside: avoid;">
                    <style>
                        .watermark {
                            position: absolute;
                            top: 1.1cm;
                            left: 1.8cm;
                            opacity: 0.15;
                            z-index: -1;
                            background-image: url('{{ public_path('/images/logo_lazisnu2.png') }}');
                            background-repeat: no-repeat;
                            background-position: center center;
                            background-size: 45%;
                            width: 100%;
                            height: 100%;
                        }
                    </style>
                    <div class="watermark"></div>
                    <!-- Isi tabel -->

                    <tr>
                        <td
                            style="width:21%;border-right:1px dashed  black;vertical-align:top;text-align:center;padding-top:3mm;position: relative">
                            Telah terima dari
                            <br>

                            @if ($data->tingkat == 'Upzis MWCNU')
                                <style>
                                    .a-custom-text::before {
                                        content: "UPZIS MWCNU";
                                        position: absolute;
                                        top: 0.65cm;
                                        text-align: left;
                                        left: 0.4cm;
                                    }

                                    .a2-custom-text::before {
                                        content: "{{ strtoupper($nama_upzis) }}";
                                        position: absolute;
                                        top: 1.15cm;
                                        text-align: left;
                                        left: 0.4cm;
                                    }
                                </style>
                            @endif
                            @if ($data->tingkat == 'Ranting NU')
                                <style>
                                    .a-custom-text::before {
                                        content: "PRNU";
                                        position: absolute;
                                        top: 0.65cm;
                                        text-align: left;
                                        left: 0.4cm;
                                    }

                                    .a2-custom-text::before {
                                        content: "{{ strtoupper($nama_ranting) }}";
                                        position: absolute;
                                        top: 1.15cm;
                                        text-align: left;
                                        left: 0.4cm;
                                    }
                                </style>
                            @endif
                            <span class="a-custom-text">
                                ...................................
                            </span>
                            <br>
                            <span class="a2-custom-text">
                                ...................................
                            </span>
                        </td>
                        <td style="width:21%;vertical-align:top;text-align:center;padding-top:3mm">
                            <img src="{{ public_path('/images/logo_lazisnu2.png') }}" width="110" height="60"
                                style="margin: 0 auto; display: block; ">
                        </td>
                        <td style="vertical-align:top;padding:2mm;text-align:center" colspan="3">
                            <span style="color:#008000;font-size:10pt">
                                <b> KWITANSI PENTASYARUFAN</b>
                            </span>
                            <br>
                            <span style="font-size:8pt">
                                NU CARE-LAZISNU CILACAP
                            </span>
                            <br>
                            <span style="font-size:8pt">
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    UPZIS MWCNU {{ strtoupper($nama_upzis) }}
                                @elseif ($data->tingkat == 'Ranting NU')
                                    PRNU {{ strtoupper($nama_ranting) }}
                                @endif
                            </span>
                        </td>
                        <td style="width: 5%;">
                        </td>
                    </tr>

                    <tr>
                        <td style="border-right:1px dashed  black;vertical-align:top;text-align:center;position: relative;"
                            rowspan="3">
                            Digunakan Untuk
                            <br>
                            <style>
                                .b-custom-text::before {
                                    content: "{{ $data->pengajuan_note }}";
                                    position: absolute;
                                    top: 0.4cm;
                                    /* Sesuaikan posisi sesuai kebutuhan */
                                    text-align: left;
                                    left: 0.4cm;
                                    margin-right: 4mm;
                                }
                            </style>

                            <span class="b-custom-text">
                                ...................................
                            </span>
                            <br>
                            <span>
                                ...................................
                            </span>
                            <br>
                            <span>
                                ...................................
                            </span>
                            <br>
                            <span>
                                ...................................
                            </span>
                            <br>
                            <span>
                                ...................................
                            </span>
                            <br>
                            <span>
                                ...................................
                            </span>
                        </td>
                        <td style=";vertical-align:top;padding-left:4mm">
                            Telah terima dari &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        </td>
                        <td style="vertical-align: top; text-align: left; position: relative;padding-top:1.5mm;"
                            colspan="3">
                            @if ($data->tingkat == 'Upzis MWCNU')
                                <style>
                                    .custom-text::before {
                                        content: "UPZIS MWCNU {{ strtoupper($nama_upzis) }}";
                                        position: absolute;
                                        top: 0px;
                                        /* Sesuaikan posisi sesuai kebutuhan */
                                        left: 0;
                                    }
                                </style>
                            @endif
                            @if ($data->tingkat == 'Ranting NU')
                                <style>
                                    .custom-text::before {
                                        content: "PRNU {{ strtoupper($nama_ranting) }}";
                                        position: absolute;
                                        top: 0px;
                                        /* Sesuaikan posisi sesuai kebutuhan */
                                        left: 0;
                                    }
                                </style>
                            @endif
                            <span class="custom-text">
                                .............................................................................................................
                            </span>
                            <br>
                            <span>
                                .............................................................................................................
                            </span>
                        </td>
                        <td>

                        </td>




                    </tr>


                    <tr>
                        {{-- <td style="border-right:1px dashed  black;vertical-align:top;text-align:center">

                        <span>
                            ...................................
                        </span>
                    </td> --}}
                        <td style=";vertical-align:top;padding-left:4mm">
                            Uang sejumlah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        </td>
                        <td id="custom-cell"
                            style="vertical-align: top; text-align: left; position: relative;padding-top:1.5mm;"colspan="3">

                            <style>
                                .custom-text2::before {
                                    content: "{{ terbilang($data->senilai) }}";
                                    position: absolute;
                                    top: 0px;
                                    /* Sesuaikan posisi sesuai kebutuhan */
                                    left: 0;
                                }
                            </style>

                            <span class="custom-text2">
                                .............................................................................................................
                            </span>
                            <br>
                            <span>
                                .............................................................................................................
                            </span>
                        </td>
                        <td>

                        </td>




                    </tr>

                    <tr>

                        <td style=";vertical-align:top;padding-left:4mm">
                            Digunakan untuk &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        </td>
                        <td id="custom-cell"
                            style="vertical-align: top; text-align: left; position: relative;padding-top:1.5mm;"colspan="3">
                            <style>
                                .custom-text3::before {
                                    content: " {{ $data->pengajuan_note }}";
                                    position: absolute;
                                    top: 0px;
                                    /* Sesuaikan posisi sesuai kebutuhan */
                                    left: 0;
                                }
                            </style>
                            <span class="custom-text3">
                                .............................................................................................................
                            </span>
                            <br>
                            <span>
                                .............................................................................................................
                            </span>
                        </td>
                        <td>

                        </td>
                    </tr>

                    <tr>
                        <td style="border-right:1px dashed  black;vertical-align:top;text-align:center">

                        </td>
                        <td colspan="3" style="text-align:right;padding-right:6mm;">

                        </td>
                        <td style="text-align:center;">
                            {{ $data->tgl_berita ? Carbon\Carbon::parse($data->tgl_berita ?? null)->isoFormat('dddd,D MMMM Y') : '(............)' }}
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td
                            style="border-right:1px dashed  black;vertical-align:top;text-align:left;padding-left:4mm;padding-right:4mm;">
                            <div style="border-top: 1px solid black;"></div>
                            <div style="padding-top:1mm;padding-bottom:1mm;padding-left:2mm;">
                                Rp{{ number_format($data->senilai ?? 0, 0, '.', '.') }}
                            </div>
                            <div style="border-top: 1px solid black;"></div>
                            <br>
                        </td>
                        <td style="vertical-align:top;padding-left:4mm" colspan="2">
                            <div style="border-top: 1px solid black;"></div> 
                            <div style="padding-top:1mm;padding-bottom:1mm;padding-left:2mm;">
                                Rp{{ number_format($data->senilai ?? 0, 0, '.', '.') }}
                            </div>
                            <div style="border-top: 1px solid black;"></div>
                        </td>
                        <td style="width: 20%;text-align:center;vertical-align:top">
                            Yang menerima
                            <br>
                            <br>

                            ({{ $data->nama2 ?? '..............' }})
                        </td>
                        <td style="width: 20%;text-align:center;vertical-align:top">
                            Yang menyalurkan
                            <br>
                            <br>

                            ({{ $data->nama1 ?? '..............' }})
                            <br>
                            <br>

                        </td>

                        <td style="width: 5%;">

                        </td>
                    </tr>


                </table>
                <br>
          

        </div>


    </body>
</main>


</html>
