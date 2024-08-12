@php

    function terbilang($number)
    {
        $bilangan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];

        $angka = abs((int) $number);
        $terbilang = '';

        if ($angka == 0) {
            $terbilang = 'nol';
        } else {
            $terbilang = terbilang_recursive($angka, $bilangan);
        }

        return $terbilang;
    }

    function terbilang_recursive($number, $bilangan)
    {
        if ($number < 10) {
            return $bilangan[$number];
        } elseif ($number < 20) {
            return $bilangan[$number - 10] . ' belas';
        } elseif ($number < 100) {
            return $bilangan[(int) ($number / 10)] . ' puluh ' . terbilang_recursive($number % 10, $bilangan);
        } elseif ($number < 1000) {
            return $bilangan[(int) ($number / 100)] . ' ratus ' . terbilang_recursive($number % 100, $bilangan);
        } elseif ($number < 1000000) {
            return terbilang_recursive((int) ($number / 1000), $bilangan) . ' ribu ' . terbilang_recursive($number % 1000, $bilangan);
        }
    }

@endphp

<!DOCTYPE html>
<html lang="id-ID">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>
    </title>
    <style>
        body {
            line-height: 115%;
            font-family: Calibri;
            font-size: 11pt;

            margin-left: 10px;
            margin-right: 10px;
        }

        p {
            margin: 0pt 0pt 10pt
        }

        li,
        table {
            margin-top: 0pt;
            margin-bottom: 10pt
        }

        .ListParagraph {
            margin-left: 36pt;
            margin-bottom: 10pt;
            line-height: 115%;
            font-size: 11pt
        }
    </style>
</head>


<body>


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
                        <td style="width: 60%" class="text-right">
                            <strong><em>Sistem Informasi Filantropi Nahdlatul Ulama,
                                    E-Tasyaruf</em></strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <table style="width:436.75pt; margin-bottom:0pt; border:0.75pt solid #000000; border-collapse:collapse;">
        <tbody>
            <tr style="height:30.65pt;">
                <td
                    style="width:135.75pt; border-right:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><br><strong><span
                                style="font-family:'Arial Narrow';"><img width="80px;" height="50px;"
                                    src="{{ public_path('/disposisi_penyaluran/nucare.png') }}"></span></strong></p>
                </td>
                <td
                    style="width:230.4pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><br><strong><span
                                style="font-family:'Arial Narrow';">LEMBAR PENYALURAN DANA ZIS</span></strong></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">NUCARE LAZISNU CILACAP&nbsp;</span></strong></p>
                </td>
                <td
                    style="width:137.45pt; border-left:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><br><strong><span
                                style="font-family:'Arial Narrow';"><img width="80px;" height="50px;"
                                    src="{{ public_path('/disposisi_penyaluran/gerakan_nu.png') }}"</span></strong></p>
                    <p style="margin-bottom:0pt; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p style="margin-bottom:0pt; line-height:normal;"><span
            style="height:0pt; display:block; position:absolute; z-index:0;"></span><span
            style="font-family:Arial;">&nbsp;</span></p>
    <table style="width:534.05pt; margin-bottom:0pt; border:0.75pt solid #FFFFFF; border-collapse:collapse;">
        <tbody>
            <tr style="height:12.25pt;">
                <td
                    style="width:50.1pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">No
                            Pengajuan</span></p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:131.55pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span
                            style="font-family:Arial;">{{ $pengajuan->nomor_surat }}</span></p>
                </td>
                <td
                    style="width:50.1pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Pemohon</span>
                    </p>
                </td>
                <td
                    style="width:3.45pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                @if ($pengajuan->opsi_pemohon == 'Entitas')
                    <td
                        style="width:109.9pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;"><span
                                style="font-family:Arial;">{{ $D_pengajuan->nama_entitas }}</span></p>
                    </td>
                @elseif ($pengajuan->opsi_pemohon == 'Individu')
                    <td
                        style="width:109.9pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;"><span
                                style="font-family:Arial;">{{ $D_pengajuan->nama_pemohon }}</span></p>
                    </td>
                @else
                    <td
                        style="width:109.9pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;"><span
                                style="font-family:Arial;">{{ app('App\Http\Controllers\PrintPenyaluranController')->nama_pengurus_pc($pengajuan->pemohon_internal) }}</span>
                        </p>
                    </td>
                @endif
            </tr>
            <tr style="height:12.25pt;">
                <td
                    style="width:50.1pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Tgl
                            Pengajuan</span></p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:131.55pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                            {{ Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->isoFormat('dddd, D MMMM Y') }}</span>
                    </p>
                </td>
                <td
                    style="width:50.1pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">No HP</span></p>
                </td>
                <td
                    style="width:3.45pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:109.9pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                            @if ($pengajuan->opsi_pemohon == 'Entitas')
                                {{ $D_pengajuan->no_hp_entitas }}
                            @elseif($pengajuan->opsi_pemohon == 'Individu')
                                {{ $D_pengajuan->nohp_pemohon }}
                            @elseif($pengajuan->opsi_pemohon == 'Internal')
                                {{ app('App\Http\Controllers\PrintPenyaluranController')->nohp_pengurus_pc($pengajuan->pemohon_internal) }}
                            @endif
                        </span></p>
                </td>
            </tr>
            <tr style="height:12.1pt;">
                <td
                    style="width:50.1pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Tgl
                            Pelaksanaan</span></p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:131.55pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                            {{ Carbon\Carbon::parse($D_pengajuan->tgl_pelaksanaan)->isoFormat('dddd, D MMMM Y') }}</span>
                    </p>
                </td>
                <td
                    style="width:50.1pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Alamat</span></p>
                </td>
                <td
                    style="width:3.45pt; border:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:109.9pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                            @if ($pengajuan->opsi_pemohon == 'Entitas')
                                {{ $D_pengajuan->alamat_entitas }}
                            @elseif($pengajuan->opsi_pemohon == 'Individu')
                                {{ $D_pengajuan->alamat_pemohon }}
                            @else
                                {{ app('App\Http\Controllers\PrintPenyaluranController')->alamat_pc($pengajuan->pemohon_internal) }}
                            @endif
                        </span></p>
                </td>
            </tr>
            <tr style="height:15.05pt;">
                <td
                    style="width:50.1pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Keterangan</span>
                    </p>
                </td>
                <td
                    style="width:3.4pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td colspan="4"
                    style="width:131.55pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:3.03pt; padding-left:3.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span
                            style="font-family:Arial;">{{ $D_pengajuan->pengajuan_note }}</span></p>
                </td>

            </tr>
        </tbody>
    </table>
    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p>
    <table style="margin-bottom:0pt; border:0.75pt solid #FFFFFF; border-collapse:collapse;">
        <tbody>
            <tr>
                <td
                    style="width:77.7pt; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Jenis
                            Bantuan</span><span
                            style="width:2.28pt; font-family:Arial; display:inline-block;">&nbsp;</span></p>
                </td>
                <td
                    style="width:3.1pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>

                <td
                    style="width:152.3pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="pendidikanCheckbox" name="pendidikanCheckbox" value="Pendidikan"
                            style="vertical-align: middle;" @if ($jenis_bantuan == 'Pendidikan') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="pendidikanCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Pendidikan')
                                <b>Pendidikan</b>
                            @else
                                Pendidikan
                            @endif
                        </label>
                    </div>
                </td>

                <td colspan="3"
                    style="width:254.75pt; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Jenis Dana yang
                            digunakan:</span></p>
                </td>
            </tr>
            <tr style="height:4.5pt;">
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="kesehatanCheckbox" name="kesehatanCheckbox" value="Kesehatan"
                            style="vertical-align: middle;" @if ($jenis_bantuan == 'Kesehatan') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="kesehatanCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Kesehatan')
                                <b>Kesehatan</b>
                            @else
                                Kesehatan
                            @endif
                        </label>
                    </div>
                </td>
                <td
                    style="width:84.95pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="zakatCheckbox" name="zakatCheckbox" value="Zakat"
                            style="vertical-align: middle;" @if ($jenis_dana_digunakan == 'Dana Zakat') checked @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="zakatCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_dana_digunakan == 'Dana Zakat')
                                <b>Zakat</b>
                            @else
                                Zakat
                            @endif
                        </label>
                    </div>
                </td>
                <td
                    style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="ekonomiCheckbox" name="ekonomiCheckbox" value="Ekonomi"
                            style="vertical-align: middle;" @if ($jenis_bantuan == 'Ekonomi') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="ekonomiCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Ekonomi')
                                <b>Ekonomi</b>
                            @else
                                Ekonomi
                            @endif
                        </label>
                    </div>
                </td>
                <td
                    style="width:84.95pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="infakTerikatCheckbox" name="infakTerikatCheckbox"
                            value="Infak Terikat" style="vertical-align: middle;"
                            @if ($jenis_dana_digunakan == 'Dana Infak Terikat') checked @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="infakTerikatCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_dana_digunakan == 'Dana Infak Terikat')
                                <b>Infak Terikat</b>
                            @else
                                Infak Terikat
                            @endif
                        </label>
                    </div>
                </td>
                <td
                    style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="siagaBencanaCheckbox" name="siagaBencanaCheckbox"
                            value="Siaga Bencana" style="vertical-align: middle;"
                            @if ($jenis_bantuan == 'Siaga Bencana') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="siagaBencanaCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Siaga Bencana')
                                <b>Siaga Bencana</b>
                            @else
                                Siaga Bencana
                            @endif
                        </label>
                    </div>
                </td>
                <td colspan="3"
                    style="width:254.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Keterangan
                            Infaq Terikat : &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.</span><span
                            style="font-family:Arial;">&nbsp;&nbsp;&nbsp;</span></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="bantuanKegiatanCheckbox" name="bantuanKegiatanCheckbox"
                            value="Bantuan Kegiatan" style="vertical-align: middle;"
                            @if ($jenis_bantuan == 'Bantuan Kegiatan') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="bantuanKegiatanCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Bantuan Kegiatan')
                                <b>Bantuan Kegiatan</b>
                            @else
                                Bantuan Kegiatan
                            @endif
                        </label>
                    </div>
                </td>
                <td
                    style="width:84.95pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="infakUmumCheckbox" name="infakUmumCheckbox" value="Infak Umum"
                            style="vertical-align: middle;" @if ($jenis_dana_digunakan == 'Dana Infak Umum') checked @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="infakUmumCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_dana_digunakan == 'Dana Infak Umum')
                                <b>Infak Umum</b>
                            @else
                                Infak Umum
                            @endif
                        </label>
                    </div>
                </td>
                <td
                    style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="sosialKemanusiaanCheckbox" name="sosialKemanusiaanCheckbox"
                            value="Sosial Kemanusiaan" style="vertical-align: middle;"
                            @if ($jenis_bantuan == 'Sosial Kemanusiaan') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="sosialKemanusiaanCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Sosial Kemanusiaan')
                                <b>Sosial Kemanusiaan</b>
                            @else
                                Sosial Kemanusiaan
                            @endif
                        </label>
                    </div>
                </td>
                <td
                    style="width:84.95pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                {{-- <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <input type="checkbox" id="keagamaanCheckbox" name="keagamaanCheckbox" value="Keagamaan"
                        style="vertical-align: middle;" @if ($jenis_bantuan == 'Keagamaan') checked @else @endif>
                    <label for="keagamaanCheckbox" style="vertical-align: middle;">&nbsp;Keagamaan</label>
                </td> --}}

                <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="santunanCheckbox" name="santunanCheckbox" value="Santunan"
                            style="vertical-align: middle;" @if ($jenis_bantuan == 'Santunan') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="santunanCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Santunan')
                                <b>Santunan</b>
                            @else
                                Santunan
                            @endif
                        </label>
                    </div>
                </td>
                <td
                    style="width:84.95pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                @if ($D_pengajuan->sumber_dana == 'Dana Zakat')
                    <td
                        style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;"><strong><span
                                    style="font-family:Arial;">Asnaf
                                    Zakat:</span></strong></p>
                    </td>
                @elseif($D_pengajuan->sumber_dana == 'Dana Infak')
                    <td colspan="2"
                        style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;"><strong><span
                                    style="font-family:Arial;">Pilar & Program:</span></strong></p>
                    </td>
                @endif
                <td
                    style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                {{-- <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <input type="checkbox" id="santunanCheckbox" name="santunanCheckbox" value="Santunan"
                        style="vertical-align: middle;" @if ($jenis_bantuan == 'Santunan') checked @else @endif>
                    <label for="santunanCheckbox" style="vertical-align: middle;">&nbsp;Santunan</label>
                </td> --}}
                <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="keagamaanCheckbox" name="keagamaanCheckbox" value="Keagamaan"
                            style="vertical-align: middle;" @if ($jenis_bantuan == 'Keagamaan') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="keagamaanCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Keagamaan')
                                <b>Keagamaan</b>
                            @else
                                Keagamaan
                            @endif
                        </label>
                    </div>
                </td>
                @if ($D_pengajuan->sumber_dana == 'Dana Zakat')
                    <td
                        style="width:84.95pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" id="fakirCheckbox" name="fakirCheckbox" value="Fakir"
                                style="vertical-align: middle;"
                                @if ($asnaf == 'Fakir') checked @else @endif>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            <label for="fakirCheckbox" style="vertical-align: middle;">&nbsp;@if ($asnaf == 'Fakir')
                                    <b>Fakir</b>
                                @else
                                    Fakir
                                @endif
                            </label>
                        </div>
                    </td>
                    <td
                        style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" id="ghorimCheckbox" name="ghorimCheckbox" value="Ghorim"
                                style="vertical-align: middle;"
                                @if ($asnaf == 'Ghorim') checked @else @endif>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            <label for="ghorimCheckbox" style="vertical-align: middle;">&nbsp;@if ($asnaf == 'Ghorim')
                                    <b>Fakir</b>
                                @else
                                    Fakir
                                @endif
                            </label>
                        </div>
                    </td>
                    <td
                        style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" id="fisabilillahCheckbox" name="fisabilillahCheckbox"
                                value="Fisabilillah" style="vertical-align: middle;"
                                @if ($asnaf == 'Fisabilillah') checked @else @endif>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            <label for="fisabilillahCheckbox" style="vertical-align: middle;">&nbsp;@if ($asnaf == 'Fisabilillah')
                                    <b>Fisabilillah</b>
                                @else
                                    Fisabilillah
                                @endif
                            </label>
                        </div>
                    </td>
                @elseif($D_pengajuan->sumber_dana == 'Dana Infak')
                    <td colspan="3">
                        <b>{{ $nama_program }}</b>
                    </td>
                @endif
            </tr>
            <tr>
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                {{-- <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <input type="checkbox" id="keagamaanCheckbox" name="keagamaanCheckbox" value="Keagamaan"
                        style="vertical-align: middle;" @if ($jenis_bantuan == 'Keagamaan') checked @else @endif>
                    <label for="keagamaanCheckbox" style="vertical-align: middle;">&nbsp;Keagamaan</label>
                </td> --}}
                <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="pembangunanCheckbox" name="pembangunanCheckbox"
                            value="Pembangunan" style="vertical-align: middle;"
                            @if ($jenis_bantuan == 'Pembangunan') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="pembangunanCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Pembangunan')
                                <b>Pembangunan</b>
                            @else
                                Pembangunan
                            @endif
                        </label>
                    </div>
                </td>
                @if ($D_pengajuan->sumber_dana == 'Dana Zakat')
                    <td
                        style="width:84.95pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" id="miskinCheckbox" name="miskinCheckbox" value="Miskin"
                                style="vertical-align: middle;"
                                @if ($asnaf == 'Miskin') checked @else @endif>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            <label for="miskinCheckbox" style="vertical-align: middle;">&nbsp;@if ($asnaf == 'Miskin')
                                    <b>Miskin</b>
                                @else
                                    Miskin
                                @endif
                            </label>
                        </div>
                    </td>
                    <td
                        style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" id="muallafCheckbox" name="muallafCheckbox" value="Muallaf"
                                style="vertical-align: middle;"
                                @if ($asnaf == 'Muallaf') checked @else @endif>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            <label for="muallafCheckbox" style="vertical-align: middle;">&nbsp;@if ($asnaf == 'Muallaf')
                                    <b>Muallaf</b>
                                @else
                                    Muallaf
                                @endif
                            </label>
                        </div>
                    </td>
                    <td
                        style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" id="IbnuSabilCheckbox" name="IbnuSabilCheckbox"
                                value="Ibnussabil" style="vertical-align: middle;"
                                @if ($asnaf == 'Ibnussabil') checked @else @endif>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;"><label for="IbnuSabilCheckbox"
                                style="vertical-align: middle;">&nbsp;@if ($asnaf == 'Ibnussabil')
                                    <b>Ibnussabil</b>
                                @else
                                    Ibnussabil
                                @endif
                            </label>
                        </div>
                    </td>
                @elseif($D_pengajuan->sumber_dana == 'Dana Infak')
                    <td colspan="3">
                        {{ $nama_kegiatan }}
                    </td>
                @endif
            </tr>
            <tr>
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                {{-- <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <input type="checkbox" id="pembangunanCheckbox" name="pembangunanCheckbox" value="Pembangunan"
                        style="vertical-align: middle;" @if ($jenis_bantuan == 'Pembangunan') checked @else @endif>
                    <label for="pembangunanCheckbox" style="vertical-align: middle;">&nbsp;Pembangunan</label>
                </td> --}}
                <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="lainnyaCheckbox" name="lainnyaCheckbox" value="Lainnya"
                            style="vertical-align: middle;" @if ($jenis_bantuan == 'Lainnya') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="lainnyaCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_bantuan == 'Lainnya')
                                <b>Lainnya</b>
                            @else
                                Lainnya
                            @endif
                        </label>
                    </div>
                </td>
                @if ($D_pengajuan->sumber_dana == 'Dana Zakat')
                    <td
                        style="width:84.95pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" id="amilCheckbox" name="amilCheckbox" value="Amil"
                                style="vertical-align: middle;"
                                @if ($asnaf == 'Amil') checked @else @endif>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            <label for="amilCheckbox" style="vertical-align: middle;">&nbsp;@if ($asnaf == 'Amil')
                                    <b>Amil</b>
                                @else
                                    Amil
                                @endif
                            </label>
                        </div>
                    </td>
                    <td
                        style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <div style="display: inline-block; vertical-align: middle;">
                            <input type="checkbox" id="riqabCheckbox" name="riqabCheckbox" value="Riqab"
                                style="vertical-align: middle;"
                                @if ($asnaf == 'Riqab') checked @else @endif>
                        </div>
                        <div style="display: inline-block; vertical-align: middle;">
                            <label for="riqabCheckbox" style="vertical-align: middle;">&nbsp;@if ($asnaf == 'Riqab')
                                    <b>Riqab</b>
                                @else
                                    Riqab
                                @endif
                            </label>
                        </div>
                    </td>
                    <td
                        style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;"><span
                                style="font-family:Arial;">&nbsp;</span>
                        </p>
                    </td>
                @endif
            </tr>
            {{-- <tr>
                <td
                    style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.1pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td> --}}
            {{-- <td
                    style="width:152.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <input type="checkbox" id="lainnyaCheckbox" name="lainnyaCheckbox" value="Lainnya"
                        style="vertical-align: middle;" @if ($jenis_bantuan == 'Lainnya') checked @else @endif>
                    <label for="lainnyaCheckbox" style="vertical-align: middle;">&nbsp;Lainnya</label>
                </td> --}}
            {{-- <td
                    style="width:84.95pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:70.45pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
            </tr> --}}
            {{-- <tr>
                <td style="width:77.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:3.1pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td colspan="2" style="width:248.05pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">*</span><em><span style="font-family:Arial;">beri tanda pada(v) pada program yang dipilih</span></em></p>
                </td>
                <td style="width:70.45pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:77.75pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p>
                </td>
            </tr> --}}
        </tbody>
    </table>

    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p>
    <table style="margin-bottom:0pt; border:0.75pt solid #FFFFFF; border-collapse:collapse;">
        <tbody>
            <tr>
                <td
                    style="width:208.7pt; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Menyatakan
                            bahwa permohonan tersebut</span></p>
                </td>
                <td
                    style="width:3.35pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:286.6pt; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                            {{-- &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.. --}}
                        </span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:208.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Nama Penerima
                            Manfaat</span></p>
                </td>
                <td
                    style="width:3.35pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:286.6pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span
                            style="font-family:Arial;">{{ $D_pengajuan->nama_penerima }}</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:208.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.35pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>

                <td
                    style="width: 286.6pt; border-top: 0.75pt solid #FFFFFF; border-left: 0.75pt solid #FFFFFF; border-bottom: 0.75pt solid #FFFFFF; padding: 0; vertical-align: middle;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="disetujuiCheckbox" name="disetujuiCheckbox" value="Disetujui"
                            style="vertical-align: middle;" @if ($pengajuan_disetujui == 'Disetujui') checked @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="disetujuiCheckbox" style="vertical-align: middle;">&nbsp;@if ($pengajuan_disetujui == 'Disetujui')
                                <b>Disetujui</b>
                            @else
                                Disetujui
                            @endif
                        </label>
                    </div>
                </td>

            </tr>
            <tr>
                <td
                    style="width:208.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:3.35pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>

                <td
                    style="width: 286.6pt; border-top: 0.75pt solid #FFFFFF; border-left: 0.75pt solid #FFFFFF; border-bottom: 0.75pt solid #FFFFFF; padding: 0; vertical-align: middle;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="tidakdisetujuiCheckbox" name="tidakdisetujuiCheckbox"
                            value="Tidak Disetuju" style="vertical-align: middle;"
                            @if ($pengajuan_disetujui == 'Tidak Disetuju') checked @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="tidakdisetujuiCheckbox" style="vertical-align: middle;">&nbsp; @if ($pengajuan_ditolak == 'Ditolak')
                                <b>Tidak Disetujui</b>
                            @else
                                Tidak Disetujui
                            @endif
                        </label>
                    </div>
                </td>

            </tr>

            <tr>
                <td
                    style="width:208.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Status
                            Survey</span></p>
                </td>
                <td
                    style="width:3.35pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:286.6pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                            @if ($status_survey)
                                {{ $status_survey . ' Survey' }}
                            @else
                                -
                            @endif
                        </span>
                    </p>
                </td>
            </tr>

            <tr>
                <td
                    style="width:208.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Nominal yang di
                            setujui</span></p>
                </td>
                <td
                    style="width:3.35pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:286.6pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    @if (
                        ($D_pengajuan->approval_status_pencairan_direktur == 'Disetujui' && $D_pengajuan->pil_survey == 'Perlu') ||
                            ($D_pengajuan->approval_status_pencairan_direktur == 'Disetujui' && $D_pengajuan->pil_survey == 'Tidak Perlu'))
                        <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                                <b> {{ 'Rp. ' . number_format($nominal_disetujui_direktur, 0, ',', '.') }} </b>
                                ({{ $D_pengajuan->jumlah_penerima . ' Penerima' }} x
                                Rp{{ number_format($D_pengajuan->satuan_pencairan, 0, '.', '.') }})</span>
                        </p>

                        {{-- <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                            style="font-family:'Arial Narrow';"></span> ({{ $D_pengajuan->jumlah_penerima }} x
                        Rp{{ number_format($D_pengajuan->satuan_pencairan, 0, '.', '.') }})</p> --}}
                    @elseif(empty($D_pengajuan->approval_status_pencairan_direktur) && $D_pengajuan->pil_survey == 'Tidak Perlu')
                        <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                                Menunggu ACC Pencairan Direktur</span>
                        </p>
                    @elseif(empty($D_pengajuan->approval_status_pencairan_direktur) && $D_pengajuan->pil_survey == 'Perlu')
                        <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                                Menunggu Survey</span>
                        </p>
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr>
                <td
                    style="width:208.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Nominal
                            Terbilang</span></p>
                </td>
                <td
                    style="width:3.35pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:286.6pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    @if (
                        ($D_pengajuan->approval_status_pencairan_direktur == 'Disetujui' && $D_pengajuan->pil_survey == 'Perlu') ||
                            ($D_pengajuan->approval_status_pencairan_direktur == 'Disetujui' && $D_pengajuan->pil_survey == 'Tidak Perlu'))
                        <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                                {{ ucwords(terbilang($nominal_disetujui_direktur)) . ' Rupiah' }}</span>
                        </p>
                    @elseif(empty($D_pengajuan->approval_status_pencairan_direktur) && $D_pengajuan->pil_survey == 'Tidak Perlu')
                        <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                                -</span>
                        </p>
                    @elseif(empty($D_pengajuan->approval_status_pencairan_direktur) && $D_pengajuan->pil_survey == 'Perlu')
                        <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                                -</span>
                        </p>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td
                    style="width:208.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">Alasan
                            Persetujuan / Ditolak</span></p>
                </td>
                <td
                    style="width:3.35pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:286.6pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">

                    @if (
                        ($D_pengajuan->approval_status_pencairan_direktur == 'Disetujui' && $D_pengajuan->pil_survey == 'Perlu') ||
                            ($D_pengajuan->approval_status_pencairan_direktur == 'Disetujui' && $D_pengajuan->pil_survey == 'Tidak Perlu'))
                        <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">

                                @if ($D_pengajuan->approval_status == 'Disetujui')
                                    {{ $D_pengajuan->keterangan_acc }}
                                @elseif($D_pengajuan->approval_status == 'Ditolak')
                                    {{ $D_pengajuan->alasan_pengajuan_ditolak }}
                                @endif
                            </span>
                        </p>
                    @elseif(empty($D_pengajuan->approval_status_pencairan_direktur) && $D_pengajuan->pil_survey == 'Tidak Perlu')
                        <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                                -</span>
                        </p>
                    @elseif(empty($D_pengajuan->approval_status_pencairan_direktur) && $D_pengajuan->pil_survey == 'Perlu')
                        <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">
                                -</span>
                        </p>
                    @else
                        -
                    @endif


                </td>
            </tr>
        </tbody>
    </table>
    {{-- <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p>
    <p style="margin-bottom:0pt; line-height:normal;"><img
            src="https://myfiles.space/user_files/131040_6729bcdbbed1f87f/1695617878_penyaluran-dana/1695617878_penyaluran-dana-4.png"
            width="710" height="46" alt=""></p>
             --}}
    {{-- <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p> --}}
    {{-- <br  style="padding-top:100"> --}}
    <br>
    <table style="margin-bottom:0pt; border:0.75pt solid #FFFFFF; border-collapse:collapse;">
        <tbody>
            <tr>
                <td
                    style="width:166.2pt; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;"><b>Tanggal penyerahan berkas</b>&nbsp;</span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">ke Divisi Program :</span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">
                            @if ($tgl_diserahkan_div_program)
                                {{ Carbon\Carbon::parse($tgl_diserahkan_div_program)->isoFormat('dddd, D MMMM Y') }}
                            @else
                                -
                            @endif
                        </span></p>
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:166.2pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;"><b>Tanggal berkas Diterima</b></span><span
                            style="font-family:Arial;">&nbsp;&nbsp;</span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">oleh Divisi Program :</span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">
                            @if ($tgl_berkas_diterima_div_program)
                                {{ Carbon\Carbon::parse($tgl_berkas_diterima_div_program)->isoFormat('dddd, D MMMM Y') }}
                            @else
                                -
                            @endif
                        </span></p>
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
                <td
                    style="width:166.25pt; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;"><b>Tanggal disetujui</b></span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">oleh Direktur</span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">
                            @if ($tgl_disetujui_direktur)
                                {{ Carbon\Carbon::parse($tgl_disetujui_direktur)->isoFormat('dddd, D MMMM Y') }}
                            @else
                                -
                            @endif
                        </span></p>
                    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td
                    style="width:166.2pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;"><b>Tanggal berkas di serahkan</b></span><span
                            style="font-family:Arial;">&nbsp;&nbsp;&nbsp;</span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">Ke Direktur :</span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">
                            @if ($tgl_diserahkan_direktur)
                                {{ Carbon\Carbon::parse($tgl_diserahkan_direktur)->isoFormat('dddd, D MMMM Y') }}
                                @else
                                -
                            @endif
                        </span></p>
                </td>
                <td
                    style="width:166.25pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
            </tr>

            <br>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">Front Office</span></p>
                </td>
                <td
                    style="width:166.2pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">Divisi Program</span></p>
                </td>
                <td
                    style="width:166.25pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">Direktur</span></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">NU CARE LAZISNU CILACAP</span></p>
                </td>
                <td
                    style="width:166.2pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">NU CARE LAZISNU CILACAP</span></p>
                </td>
                <td
                    style="width:166.25pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:Arial;">NU CARE LAZISNU CILACAP</span></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; text-align: center;">
                    @if ($D_pengajuan->tgl_diserahkan_div_program)
                        <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697185584.ACHMAD%20MUTOHAR.jpg"
                            width="100px" height="80px">
                    @endif
                    <br>

                </td>

                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; text-align: center;">
                    @if ($D_pengajuan->approval_status_divpro == 'Disetujui')
                        <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697182882.Mu'afah,%20S.E.jpg"
                            width="100px">
                    @endif
                    <br>
                </td>

                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; text-align: center;">
                    @if ($D_pengajuan->approval_status == 'Disetujui')
                        <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697426100.Ahmad%20Fauzi,%20S.Pd.I.jpg"
                            width="100px">
                    @endif
                    <br>
                </td>
            </tr>

            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:Arial;">{{ $nama_fo }}</span></strong></p>
                </td>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:Arial;">{{ $nama_div_pro }}</span></strong></p>
                </td>
                <td
                    style="width:166.25pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:Arial;">{{ $nama_direktur }}</span></strong></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p style="margin-bottom:0pt; line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p>

</body>

</html>
