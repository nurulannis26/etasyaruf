kam<?php
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
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <head>
        <title>{{ 'LPJ_' . $filename . '_' . $nomor_surat . '.pdf' }}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>
    <style>
        body {
            widows: 0;
            orphans: 0;
            font-family: Calibri;
            font-size: 11pt;
            margin-left: 25pt;
        }

        p {
            margin: 0pt
        }

        li,
        table {
            margin-top: 0pt;
            margin-bottom: 0pt
        }

        .BodyText {
            margin-left: 119.05pt;
            margin-bottom: 0pt;
            line-height: normal;
            widows: 0;
            orphans: 0;
            font-family: Calibri;
            font-size: 11pt
        }

        .ListParagraph {
            margin-left: 36pt;
            margin-bottom: 0pt;
            line-height: normal;
            widows: 0;
            orphans: 0;
            font-family: Calibri;
            font-size: 11pt
        }

        span.BodyTextChar {
            font-family: Calibri
        }
    </style>
</head>

<body spellcheck="false">
    @php
        $pengguna = \App\Models\Pengguna::where('nama', $data->nama1)->value('gocap_id_pc_pengurus');
        $pengurus = \App\Models\PcPengurus::where('id_pc_pengurus', $pengguna)->value('id_pengurus_jabatan');
        $jabatan = \App\Models\JabatanPengurus::where('id_pengurus_jabatan', $pengurus)->value('jabatan');
        $bidang = \App\Models\JabatanPengurus::where('id_pengurus_jabatan', $pengurus)->value('divisi');
        $jab = $jabatan . ' Bidang ' . $bidang;
     @endphp
    <table style="width:460.5pt; border-collapse:collapse;">
        <tbody>
            <tr>
                <td style="width:100pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top; margin:3pt;">
                    <p class="BodyText" style="margin-left:0pt;"><img src="{{ public_path('images/logo_lazisnu.png') }}"
                            width="133" height="76" alt=""></p>
                    <p class="BodyText" style="margin-left:0pt;"><span style="color:#005023;">&nbsp;</span></p>
                </td>
                <td
                    style="width:364pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top; margin-bottom:0pt;">
                    <table style="width:364pt; border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td colspan="3"
                                    style="width:330pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span style="color:#005023;">Jl. Masjid
                                            No.09 Kelurahan Sidanegara, Kec. Cilacap Tengah, Kab. Cilacap</span></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"
                                    style="width:330pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span style="color:#00b050;">Ijin
                                            Operasional Nomor : 062/SKA.II/LAZISNU-PBNU/IX/2022</span></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:51.8pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span
                                            style="color:#005023;">Email</span></p>
                                </td>
                                <td style="width:3.4pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span style="color:#005023;">:</span>
                                    </p>
                                </td>
                                <td
                                    style="width:251.05pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span
                                            style="color:#005023;">nucarelazisnukabupatencilacap@gmail.com</span></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:51.8pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span style="color:#005023;">Call
                                            Center</span></p>
                                </td>
                                <td style="width:3.4pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span style="color:#005023;">:</span>
                                    </p>
                                </td>
                                <td
                                    style="width:251.05pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span
                                            style="color:#005023;">081228221010 Telp. (0282) 539 5195</span></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:51.8pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span
                                            style="color:#005023;">Website</span></p>
                                </td>
                                <td style="width:3.4pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span style="color:#005023;">:</span>
                                    </p>
                                </td>
                                <td
                                    style="width:251.05pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                    <p class="BodyText" style="margin-left:0pt;"><span
                                            style="color:#005023;">lazisnucilacap.com</span></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width:364pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                    <p class="BodyText"
                        style="margin-top:0pt; margin-left:0pt; margin-bottom:3pt; margin-right:3pt; text-align:center; line-height:125%;">
                        <hr
                            style="border: 0; height: 4px; background-color: #005023; box-shadow: rgba(17, 12, 46, 0.15) 0px 48px 100px 0px;">
                    </p>
                    <p style="text-align: center; margin-bottom: 5pt;margin-top: 10pt;"><strong>BERITA ACARA SERAH
                            TERIMA (BAST)</strong></p>
                    <p style="text-align: center; margin-bottom: 8pt;margin-top: 10pt;"><strong>Nomor :
                            {{ $data->nomor_surat }}</strong></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p style="text-align: left; margin-bottom: 5pt;margin-top: 10pt;padding-left:5.4pt;padding-right:5.4pt;">Pada hari
        ini {{$namaHari}} tanggal {{$hari}} bulan {{$bulan}} tahun {{$tahun}}, kami :</p>
    <p
        style="text-align: justify; margin-bottom: 12pt;margin-top: 10pt;line-height: 1.6;padding-right:25pt;padding-left:5.4pt;">
        Bertindak sebagai PIHAK PERTAMA, atas nama NU Care LAZISNU yang dibentuk atas dasar AKTA NOTARIS Nomor 08 -
        tanggal 25 Mei 2022 dan izin KEMENAG RI Nomor 89 Tahun 2022 yang berkedudukan di Jakarta.</p>

    <table style="width:460pt; border-collapse:collapse;padding-left:5.4pt;padding-right:5.4pt;">
        <tbody>
            <tr>
                <td
                    style="width:85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        <strong>Nama</strong>
                    </p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText"
                        style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td
                    style="width:353pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        {{ $data->nama1 ?? '-' }}</p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        <strong>NIK</strong>
                    </p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText"
                        style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td
                    style="width:353pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        {{ $data->nik1 ?? '-' }}</p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        <strong>Jabatan</strong>
                    </p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText"
                        style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td
                    style="width:353pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        {{$data->jabatan1 ?? '-'}}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="text-align: left; margin-bottom: 5pt;margin-top: 15pt;padding-left:5.4pt;padding-right:5.4pt;">Bersama
        ini menyerahkan Kepada :</p>

    <table style="width:460pt; border-collapse:collapse;padding-left:5.4pt;padding-right:5.4pt;">
        <tbody>
            <tr>
                <td
                    style="width:85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        <strong>Nama</strong>
                    </p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText"
                        style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td
                    style="width:353pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        {{ $data->nama2 ?? '-' }}</p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        <strong>NIK</strong>
                    </p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText"
                        style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td
                    style="width:353pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        {{ $data->nik2 ?? '-' }}</p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        <strong>Jabatan</strong>
                    </p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText"
                        style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td
                    style="width:353pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        {{ $data->jabatan2 ?? '-' }}
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        <strong>Nama Lembaga</strong>
                    </p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText"
                        style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td
                    style="width:353pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        @if ($data->opsi_pemohon == 'Entitas')
                            {{ $data->nama_entitas }}
                        @else
                            -
                        @endif
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        <strong>Kontak Person</strong>
                    </p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText"
                        style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td
                    style="width:353pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p class="BodyText" style="margin-top:3pt; margin-left:0pt; margin-bottom:3pt; line-height:125%;">
                        {{ $data->nohp2 ?? '-' }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="text-align: left; margin-bottom: 5pt;margin-top: 15pt;padding-left:5.4pt;padding-right:5.4pt;">Sebagai
        PIHAK KEDUA, Berupa {{ $data->berupa }} {{$datas}}.</p>

    <table style="width:485pt; border-collapse:collapse; padding-left:5.4pt; padding-right:5.4pt;">
        <tbody>
            <tr>
                <td
                    style="width:19.05pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:3pt; margin-bottom:3pt; line-height:125%; font-size:11pt;">
                        <strong>No</strong>
                    </p>
                </td>
                <td
                    style="width:60.1pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:3pt; margin-bottom:3pt; text-align:center; line-height:125%; font-size:11pt;">
                        <strong>Qty</strong>
                    </p>
                </td>
                <td
                    style="width:216.35pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:3pt; margin-bottom:3pt; line-height:125%; font-size:11pt;">
                        <strong>URAIAN / JENIS BARANG</strong>
                    </p>
                </td>
                <td
                    style="width:116.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:3pt; margin-bottom:3pt; line-height:125%; font-size:11pt;">
                        <strong>NILAI (Rp)</strong>
                    </p>
                </td>
            </tr>
            @php
                $noUrut = 1;
                $ttd_pihak = App\Http\Controllers\PrintController::ttd_ba($data->nama1);
            @endphp
            @forelse ($barang as $item)
                <tr>
                    <td
                        style="width:19.05pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:3pt; margin-bottom:3pt; line-height:125%; font-size:11pt;">
                            {{ $noUrut++ }}.
                        </p>
                    </td>
                    <td
                        style="width:60.1pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:3pt; margin-bottom:3pt; line-height:125%; font-size:11pt;">
                            {{ $item->jumlah_barang }}</p>
                    </td>
                    <td
                        style="width:216.35pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:3pt; margin-bottom:3pt; line-height:125%; font-size:11pt;">
                            {{ $item->jenis_barang }}</p>
                    </td>
                    <td
                        style="width:116.4pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:3pt; margin-bottom:3pt; line-height:125%; font-size:11pt;">
                            {{ number_format($item->nominal_barang, 0, ',', '.') }}</p>
                    </td>
                </tr>
            @empty
                <tr>
                    <td style="width:216.35pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;"
                        colspan="4" class="text-center"> Belum ada data</td>
                </tr>
            @endforelse

        </tbody>
    </table>

    <table style="width:485pt; border-collapse:collapse; padding-left:5.4pt; padding-right:5.4pt;margin-top:5pt">
        <tr>
            <td colspan="2" style="width:465.25pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;">&nbsp;</p>
                <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td style="width:224.6pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                <p
                                    style="margin-top:3pt; margin-bottom:3pt; text-align:center; line-height:125%; font-size:11pt;">
                                    <strong>PIHAK KEDUA</strong>
                                </p>
                            </td>
                            <td style="width:209.2pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                <p
                                    style="margin-top:3pt; margin-bottom:3pt; text-align:center; line-height:125%; font-size:11pt;">
                                    <strong>PIHAK PERTAMA</strong>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:224.6pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                <p
                                    style="margin-top:3pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    &nbsp;</p>
                                <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    &nbsp;</p>
                                <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    &nbsp;</p>
                                <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:150%; font-size:11pt;">
                                    {{ $data->nama2 ?? 'Nama' }}</p>
                                <p
                                    style="margin-top:0pt; margin-bottom:3pt; text-align:center; line-height:150%; font-size:11pt;">
                                    {{ $data->jabatan2 ?? 'Jabatan' }}</p>
                            </td>
                            <td style="width:209.2pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                                @if ($data->nama1)
                                <p
                                    style="margin-top:3pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    <img style="margin-left: 5px" src="https://gocapv2.nucarecilacap.id/uploads/ttd/{{ $ttd_pihak }}" alt="Tanda tangan" width="100" height="70"></p>
                                @else
                                 <p
                                    style="margin-top:3pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    &nbsp;</p>
                                <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    &nbsp;</p>
                                     <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    &nbsp;</p>
                                @endif
                                <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:150%; font-size:11pt;">
                                    {{ $data->nama1 ?? 'Nama' }}</p>
                                <p
                                    style="margin-top:0pt; margin-bottom:3pt; text-align:center; line-height:150%; font-size:11pt;">
                                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '20f2ff4d-1596-48ab-b60d-8a4b75a9784d' or 
                                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3') 
                                     @if ($data->nama1 != null)
                                        {{ $jab }}
                                    @else 
                                        Jabatan
                                    @endif</p>
                                @else
                                    {{$data->jabatan1 ?? '-'}}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p style="margin-top:3pt; margin-bottom:3pt; text-align:center; line-height:125%; font-size:11pt;">
                    <br>
                </p>
            </td>
        </tr>
    </table>

    <ul type="disc" style="margin:0pt; padding-left:0pt;">
        <li style="margin-left:9.83pt; padding-left:8.17pt; font-family:serif; font-size:10.5pt; color:#3b3838;">
            <em><span style="font-family:Calibri;">Lampiran : 1.) dokumentasi serah terima 2.) identitas penerima
                    manfaat
                    3.) kwitansi 4.) surat permohonan / memo internal</span></em>
        </li>
    </ul>

    <p style="font-size:10.5pt;"><em><span style="color:#3b3838;">&nbsp;</span></em></p>

    <div style="page-break-before: always;"></div>
    <div style="clear: both; ">

<br>


        <table
            style="width:100%; height: 6cm; background-color:#E2EFD9; font-size:10pt; position: relative;page-break-inside: avoid;">

            <tr>
                <td style="width:10%;vertical-align:top;text-align:center;padding-top:3mm">
                    <img src="{{ public_path('/images/logo_lazisnu2.png') }}" width="110" height="60"
                        style="margin: 0 auto; display: block; ">
                </td>
                <td style="width:55%;vertical-align:top;padding:2mm;text-align:left" colspan="3">
                    <span style="font-size:13pt">
                        <b> KUITANSI PENTASYAARUFAN</b>
                    </span>
                    <br>
                    <span style="font-size:12pt">
                        NU CARE-LAZISNU CILACAP
                    </span>
                    <br>
                    <span style="font-size:8pt">
                        Alamat: Jalan Masjid No. 9 Kelurahan Sidanegara Kecamatan Cilacap Tengah Cp: 081228221010
                    </span>
                    <u><hr style="text-decoration: underline; border-bottom: 1px solid #000;"></u>
                </td>
                <td style="width: 5%;">
                </td>
            </tr>

            <tr>

                <td style="width:25%;vertical-align:top;padding-left:30pt">
                    Telah terima dari &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                </td>
                <td style="width:55%;vertical-align: top; text-align: left; position: relative;" colspan="3"><span
                        class="custom-text">
                            NU CARE LAZISNU CILACAP
                    </span>

                </td>
                <td style="width:5%;">

                </td>
            </tr>


            <tr>

                <td style="width:25%;vertical-align:top;padding-left:30pt">
                    Uang sejumlah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                </td>
                <td id="custom-cell" style="vertical-align: top; text-align: left; position: relative;"
                    colspan="3">
                    <span>
                        {{ terbilang($data->senilai) }}
                    </span>

                </td>
                <td>

                </td>




            </tr>

            <tr>
                <td style="width:25%;vertical-align:top;padding-left:30pt;">
                    Digunakan untuk &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                </td>
                <td style="vertical-align: top; text-align: left;width: 50%;" colspan="3">
                        {{ $data->pengajuan_note }}



                </td>


                <td style="width: 5%;">

                </td>
            </tr>
            <br>

            <tr>

                <td colspan="3" style="text-align:center;padding-right:50pt;">

                </td>
                <td style="text-align:center">
                    {{ $data->tgl_berita ? Carbon\Carbon::parse($data->tgl_berita ?? null)->isoFormat('dddd, D MMMM Y') : '(............)' }}
                </td>
                <td></td>
            </tr>


            <tr>
                <td style="width:40%;vertical-align:top;padding-left:30pt" colspan="2">

                    <div style="padding-left:2mm; border-top: 1px solid black;border-bottom: 1px solid black; ">
                            Rp {{ number_format($data->senilai ?? 0, 0, '.', '.') }}
                    </div>

                </td>

                <style>
                    .capitalized {
                        text-transform: capitalize;
                    }
                </style>

                <td style="width: 30%;text-align:center;vertical-align:top">
                    Yang menerima
                    <br>
                    {{-- {{ dd($ttd_keuangan) }} --}}

                        <div class="tanda-tangan">
                            <br>
                            <br>
                            <br>
                        </div>

                        ({{ $data->nama2 ?? '..............' }})

                </td>

                <style>
                    .tanda-tangan {
                        background-color: transparent;
                        mix-blend-mode: multiply;
                        /* atau gunakan 'screen' */
                    }
                </style>
                <td style="width: 20%;text-align:center;vertical-align:top">
                    Yang menyalurkan
                    <br>

                        <div class="tanda-tangan">
                            <img style="margin-left: 5px" src="https://gocapv2.nucarecilacap.id/uploads/ttd/{{ $ttd_pihak }}" alt="Tanda tangan" width="70" height="58">
                        </div>

                        ({{ $data->nama1 ?? '..............' }})

                    <br>
                    <br>

                </td>
            </tr>


        </table>
        <br>


    </div>
</body>

</html>
