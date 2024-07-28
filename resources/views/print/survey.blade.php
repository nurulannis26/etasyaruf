<!DOCTYPE html>
<html>

<head>
    <title>FORM ISIAN SURVEY MUSTAHIK NU CARE LAZISNU CILACAP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 1.15cm;

        text-align: center;
    }

    .checkbox {
        border: 1px solid #000000;
        width: 15px;
        height: 15px;
        display: inline-block;
        text-align: center;
    }

    .checkbox.checked:before {
        content: "V";
        font-family: Wingdings;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        padding-bottom: 10pt;
    }
</style>



<footer>
    <div class="pagenum-container">


        <div style="clear:both;color:#9d9d9d">

            <p
                style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal; border-bottom:2.25pt double #000000; padding-bottom:1pt; font-size:10pt;">
                <strong><em>&nbsp;</em></strong>
            </p>
            <p
                style="margin-top:3pt; margin-bottom:0pt; text-align:right; line-height:150%; widows:0; orphans:0; font-size:11pt;">
            </p>
            <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal; font-size:10pt;">
                <strong><em>Sistem Informasi Filantropi Nahdlatul Ulama, E-Tasyaruf</em></strong>
            </p>
            <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal; font-size:10pt;">
                <em>Dicetak, {{ date('d M Y') }}
                </em>
            </p>

        </div>

    </div>
</footer>



<main>

    <body>

        {{-- kertas 1 --}}
        <div>
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
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:50%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>FORM ISIAN SURVEY MUSTAHIK NU CARE LAZISNU CILACAP</span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>
                                        {{-- @if ($tingkat == 'Upzis MWCNU')
                                            TINGKAT UPZIS MWCNU
                                        @endif
                                        @if ($tingkat == 'Ranting NU')
                                            TINGKAT RANTING NU
                                        @endif --}}
                                    </span>
                                </strong>
                            </p>
                        </td>
                    </tr>


                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:50%; font-size:11pt;">
                        <strong><span>&nbsp;</span></strong>
                    </p>


                    <tr>
                        <td style="width:145pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt; line-height:125%; font-size:11pt;">
                                <span>Nama Surveyor</span>
                            </p>
                        </td>
                        <td style="width:3.25pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <span>:</span>
                            </p>
                        </td>
                        <td colspan="3"
                            style="width:350.95pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <span>
                                    {{ $nama_surveyor }}
                                </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:145pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt; line-height:125%; font-size:11pt;">
                                <span>Tanggal pelaksanaan survey</span>
                            </p>
                        </td>
                        <td style="width:3.25pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <span>:</span>
                            </p>
                        </td>
                        <td colspan="3"
                            style="width:350.95pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <span>
                                    {{ $tgl_survey }}
                                </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:145pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt; line-height:125%; font-size:11pt;">
                                <span>Nama mustahik</span>
                            </p>
                        </td>
                        <td style="width:3.25pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <span>:</span>
                            </p>
                        </td>
                        <td colspan="3"
                            style="width:350.95pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <span>
                                    {{ $nama_mustahik }}
                                </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:145pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt; line-height:125%; font-size:11pt;">
                                <span>Alamat mustahik</span>
                            </p>
                        </td>
                        <td style="width:3.25pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <span>:</span>
                            </p>
                        </td>
                        <td colspan="3"
                            style="width:350.95pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <span>
                                    {{ $alamat_mustahik }}
                                </span>
                            </p>
                        </td>
                    </tr>

                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:50%; font-size:11pt;">
                        <strong><span>&nbsp;</span></strong>
                    </p>
                    <tr>
                        <td colspan="5" style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; line-height:50%; font-size:11pt;">
                                Jenis permohonan bantuan ke Lazisnu Cilacap : {{ $jenis_permohonan }}
                            </span>
                        </td>

                    </tr>

                </tbody>
            </table>
            <table style="width: 100%">
                <tbody>
                    <p style="line-height:15%; font-size:11pt;">
                        <strong><span>&nbsp;</span></strong>
                    </p>

                    {{-- A --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>A. Berapa jumlah anggota keluarga ?</strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40pt; padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Jumlah anak
                            </span>
                        </td>
                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $jumlah_anak }}
                            </span>
                        </td>
                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                Orang
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">

                            </span>
                        </td>
                        <td style="width:160pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Jumlah total anggota keluarga
                            </span>
                        </td>
                        <td style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $jumlah_total }}
                            </span>
                        </td>
                        <td style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                Orang
                            </span>
                        </td>
                    </tr>

                    {{-- B --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>B. Apakah Masih mempunyai suami / istri ?</strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td colspan="3" style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $suami_istri }}
                            </span>
                        </td>
                    </tr>


                    {{-- C --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>C. Apa pekerjaan anggota keluarga ?</strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Pekerjaan Suami
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $perkerjaan_suami }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">

                            </span>
                        </td>

                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Pekerjaan Istri
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $pekerjaan_istri }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">

                            </span>
                        </td>

                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Pekerjaan Anak
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $pekerjaan_anak }}
                            </span>
                        </td>
                    </tr>

                    {{-- D --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>D. Berapa penghasilan keluarga ?</strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Penghasilan Suami
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $penghasilan_suami }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">

                            </span>
                        </td>

                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Penghasilan Istri
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $penghasilan_istri }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">

                            </span>
                        </td>

                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Penghasilan Anak
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $penghasilan_anak }}
                            </span>
                        </td>
                    </tr>

                    {{-- E --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>E. Bagaimana kondisi rumah ?</strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Atap
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $kondisi_atap }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">

                            </span>
                        </td>

                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Dinding
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $kondisi_dinding }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">

                            </span>
                        </td>

                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Lantai
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $kondisi_lantai }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">

                            </span>
                        </td>

                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Ukuran Rumah
                            </span>
                        </td>
                        <td style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $kondisi_ukuran }}
                            </span>
                        </td>
                        <td style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                m<sup>2</sup>
                            </span>
                        </td>
                    </tr>

                    {{-- F --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>F. Status kepemilikan rumah dan tanah ?</strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Rumah
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $kepemilikan_rumah }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">

                            </span>
                        </td>

                        <td style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                - Tanah
                            </span>
                        </td>
                        <td colspan="2" style="padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $kepemilikan_tanah }}
                            </span>
                        </td>
                    </tr>



                    {{-- G --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>G. Sebutkan harta / aset / kekayaan yang dimiliki ?</strong><br>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:18pt;">
                            <span style=" font-size:11pt;">
                                <span>
                                    (missal sawah,kebun, ternak, perabotan elektronik, kendaraan dll.)
                                </span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td colspan="3" style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $harta_aset_kekayaan }}
                            </span>
                        </td>
                    </tr>





                </tbody>
            </table>


            <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:250%; font-size:11pt;">
                <strong><span>&nbsp;</span></strong>
            </p>
            <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:250%; font-size:11pt;">
                <strong><span>&nbsp;</span></strong>
            </p>
            <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:250%; font-size:11pt;">
                <strong><span>&nbsp;</span></strong>
            </p>
            <p style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:250%; font-size:11pt;">
                <strong><span>&nbsp;</span></strong>
            </p>

            <table style="width:100%">
                <tbody>

                    {{-- H --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>H. Berapa biaya / tanggungan / pengeluaran rutin setiap bulan dan untuk apa
                                    saja, jelaskan ?</strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td colspan="3" style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $biaya_tanggungan_bulanan }}
                            </span>
                        </td>
                    </tr>

                    {{-- I --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>I. Apa saja kebutuhan yang sangat dibutuhkan untuk saat ini?</strong>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:18pt;">
                            <span style=" font-size:11pt;">
                                <span>
                                    (berdasarkan pengajuan permohonan ke LAZISNU)
                                </span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=" padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td colspan="3" style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $kebutuhan_menedesak }}
                            </span>
                        </td>
                    </tr>


                    {{-- J --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>J. Bantuan apa saja yang sudah pernah di dapatkan, kapan dan dari mana / siapa
                                    ?</strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40pt; padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td colspan="3" style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $bantuan_yg_didapat }}
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>

            <p style="line-height:15%; font-size:11pt;">
                <strong><span>&nbsp;</span></strong>
            </p>
            <b style="text-align: center">REKAPITULASI KELAYAKAN </b>
            <table style="width: 100%" border="1">
                <tbody>
                    <tr style="color:white;background-color:#000000;text-align: center;font-weight: bold;">
                        <td>
                            PARAMETER
                        </td>
                        <td>
                            KELAYAKAN
                        </td>
                        <td>
                            KETERANGAN
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:5.4pt;">
                            Indeks Rumah
                        </td>
                        <td style="padding-left:5.4pt;">
                            <div>
                                <div class="checkbox {{ $indeks_rumah == 'layak' ? 'checked' : '' }}"></div> Layak
                            </div>
                            <div>
                                <div class="checkbox {{ $indeks_rumah == 'layak' ? '' : 'checked' }}"></div> Tidak Layak
                            </div>
                        </td>
                        <td style="padding-left:5.4pt;">
                            {{ $keterangan_rumah }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:5.4pt;">
                            Kepemilikan Harta
                        </td>
                        <td style="padding-left:5.4pt;">
                            <div><span>
                                    <div class="checkbox {{ $indeks_harta == 'layak' ? 'checked' : '' }}"></div> Layak
                                </span>
                            </div>
                            <div>
                                <div class="checkbox {{ $indeks_harta == 'layak' ? '' : 'checked' }}"></div> Tidak Layak
                            </div>
                        </td>
                        <td style="padding-left:5.4pt;">
                            {{ $keterangan_harta }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:5.4pt;">
                            Pendapatan
                        </td>
                        <td style="padding-left:5.4pt;">
                            <div><span>
                                    <div class="checkbox {{ $indeks_pendapatan == 'layak' ? 'checked' : '' }}"></div> Layak
                                </span>
                            </div>
                            <div>
                                <div class="checkbox {{ $indeks_pendapatan == 'layak' ? '' : 'checked' }}"></div> Tidak
                                Layak
                            </div>
                        </td>
                        <td style="padding-left:5.4pt;">
                            {{ $keterangan_pendapatan }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <p style="line-height:15%; font-size:11pt;">
                <strong><span>&nbsp;</span></strong>
            </p>

            <table>
                <tbody>
                    {{-- K --}}
                    {{-- {{ Title }} --}}
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>K. Rekomendasi dari surveyor beserta alasan tentang kelayakan dalam penerimaan
                                    bantuan dari LAZISNU </strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40pt; padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td colspan="3" style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ $rekomendasi }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>K. Rekomendasi dari surveyor beserta alasan tentang kelayakan dalam penerimaan
                                    bantuan dari LAZISNU </strong>
                            </span>
                        </td>
                    </tr>

                    <p style="line-height:15%; font-size:11pt;">
                        <strong><span>&nbsp;</span></strong>
                    </p>

                    <tr>
                        <td colspan="4" style="padding-right:5.4pt; padding-left:5.4pt;">
                            <span style=" font-size:11pt;">
                                <strong>Hasil Akhir </strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 40pt; padding-right:5.4pt; padding-left:18pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:0pt;  font-size:11pt;">
                                <span>Jawab</span>
                            </p>
                        </td>
                        <td colspan="3" style=" padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <span style="margin-top:0pt; margin-bottom:0pt; text-align:justify;  font-size:11pt;">
                                : {{ strtoupper($hasil) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p style="line-height:100%; font-size:11pt;">
                <strong><span>&nbsp;</span></strong>
            </p>

    <div style="text-align: center;">
  <div style="float: right; width: 50%; margin-right: 20px;">
    <table style="width: 100%" >
      <tbody>
        <tr>
          <td></td>
          <td></td>
          <td style="text-align: right;"><span style="font-size: 11pt;">Petugas Survey</span></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td style="text-align: right;">
            @if($hasil == 'disetujui')
            <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697785240.M.%20Ngizzudin%20Abdul%20Aziz.jpg" width="100px" style="margin-bottom: 10px;">
            @endif
          </td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td style="text-align: right;"><span>{{ $nama_surveyor }}</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

              
            
        </div>

        </div>






    </body>
</main>


</html>
