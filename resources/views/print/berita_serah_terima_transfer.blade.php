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
                    <p style="text-align: center; margin-bottom: 0pt;margin-top: 5pt;"><strong>BERITA ACARA SERAH
                            TERIMA (BAST) PENYALURAN MELALUI TRANSFER</strong></p>
                    <p style="text-align: center; margin-bottom: 8pt;margin-top: 5pt;"><strong>Nomor :
                            {{ $data->nomor_surat }}</strong></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p style="text-align: left; margin-bottom: 5pt;margin-top: 5pt;padding-left:5.4pt;padding-right:5.4pt;">Pada hari
        ini {{ $namaHari }} tanggal {{ $hari }} bulan {{ $bulan }} tahun {{ $tahun }}, kami :
    </p>
    <p
        style="text-align: justify; margin-bottom: 5pt;margin-top: 5pt;line-height: 1.6;padding-right:25pt;padding-left:5.4pt;">
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
                        {{ $data->jabatan1 ?? '-' }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="text-align: left; margin-bottom: 5pt;margin-top: 5pt;padding-left:5.4pt;padding-right:5.4pt;">Dengan ini
        menyatakan dengan sebenar – benarnya telah menyerahkan kepada :</p>

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

    <p style="text-align: left; margin-bottom: 5pt;margin-top: 5pt;padding-left:5.4pt;padding-right:5.4pt;">Sebagai
        PIHAK KEDUA, Berupa {{ $data->berupa }} {{ $datas }}.</p>

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

    <p style="text-align: left; margin-bottom: 5pt;margin-top: 5pt;padding-left:5.4pt;padding-right:5.4pt;">Bantuan
        disalurkan melalui transfer ke :</p>
    <table style="width:460pt; border-collapse:collapse; padding-left:5.4pt; padding-right:5.4pt; border:none;">
        <tbody>
            <tr>
                <td style="width:85pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; border:none;">
                    <p class="BodyText" style="margin-top:0pt; margin-left:0pt; margin-bottom:0pt; line-height:125%;">
                        Nomor rekening
                    </p>
                </td>
                <td style="width:3.4pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; border:none;">
                    <p class="BodyText"
                        style="margin-top:0pt; margin-left:0pt; margin-bottom:0pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td style="width:353pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; border:none;">
                    <p class="BodyText" style="margin-top:0pt; margin-left:0pt; margin-bottom:0pt; line-height:125%;">
                        {{ $data->no_rek_penerima ?? '-' }}</p>
                </td>
            </tr>
            <tr>
                <td style="width:85pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; border:none;">
                    <p class="BodyText" style="margin-top:0pt; margin-left:0pt; margin-bottom:0pt; line-height:125%;">
                        Bank</p>
                </td>
                <td style="width:3.4pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; border:none;">
                    <p class="BodyText"
                        style="margin-top:0pt; margin-left:0pt; margin-bottom:0pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td style="width:353pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; border:none;">
                    <p class="BodyText" style="margin-top:0pt; margin-left:0pt; margin-bottom:0pt; line-height:125%;">
                        {{ $data->nama_bank_penerima ?? '-' }}</p>
                </td>
            </tr>
            <tr>
                <td style="width:85pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; border:none;">
                    <p class="BodyText" style="margin-top:0pt; margin-left:0pt; margin-bottom:0pt; line-height:125%;">
                        Atas nama</p>
                </td>
                <td style="width:3.4pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; border:none;">
                    <p class="BodyText"
                        style="margin-top:0pt; margin-left:0pt; margin-bottom:0pt; text-align:center; line-height:125%;">
                        :</p>
                </td>
                <td style="width:353pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; border:none;">
                    <p class="BodyText" style="margin-top:0pt; margin-left:0pt; margin-bottom:0pt; line-height:125%;">
                        {{ $data->atas_nama_penerima ?? '-' }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    @php
        $ttd_pihak = App\Http\Controllers\PrintController::ttd_ba($data->nama1);
        $pengguna = \App\Models\Pengguna::where('nama', $data->nama1)->value('gocap_id_pc_pengurus');
        $pengurus = \App\Models\PcPengurus::where('id_pc_pengurus', $pengguna)->value('id_pengurus_jabatan');
        $jabatan = \App\Models\JabatanPengurus::where('id_pengurus_jabatan', $pengurus)->value('jabatan');
        $bidang = \App\Models\JabatanPengurus::where('id_pengurus_jabatan', $pengurus)->value('divisi');
        $jab = $jabatan . ' Bidang ' . $bidang;
    @endphp

    <table cellspacing="0" cellpadding="0" style="margin-left:295.7pt; border-collapse:collapse; position:relative;">
    <tbody>
        <tr style="height:15.3pt;">
            <td style="width:250pt; vertical-align:top;">
                <p style="margin:0pt 8.9pt 8pt 9pt; text-align:center; font-size:7pt;">
                    <strong><span style="font-size:11pt;">PIHAK PERTAMA</span></strong>
                </p>
            </td>
        </tr>
        <tr style="height:57.85pt; position:relative;">
            <td style="width:250pt; vertical-align:top; position:relative;">
                <div style="position:relative; text-align:center;">
                    @if ($data->nama1)
                    <img src="{{ asset('images/ttd/stempel.png') }}" alt="Stempel" style="position:absolute; top:-10px; left:35%; transform:translateX(-50%); width:140px; height:90px;">
                    <img style="margin-left: 5px" src="https://gocapv2.nucarecilacap.id/uploads/ttd/{{ $ttd_pihak }}" alt="Tanda tangan" width="100" height="70">
                    @else
                    <p
                                    style="margin-top:3pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    &nbsp;</p>
                                <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    &nbsp;</p>
                    @endif
                </div>
                <p style="margin:0pt 9pt; text-align:center; line-height:12.2pt;">
                    {{ $data->nama1 ?? 'Nama' }}
                </p>
                <p style="margin:0pt 9pt; text-align:center; line-height:12.2pt;">
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '20f2ff4d-1596-48ab-b60d-8a4b75a9784d' or
                            Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3')
                        @if ($data->nama1 != null)
                            {{ $jab }}
                        @else
                            Jabatan
                        @endif
                </p>
            @else
                {{ $data->jabatan1 ?? '-' }}
                @endif
                </p>
            </td>
        </tr>
    </tbody>
</table>




    <ul type="disc" style="margin-top:3pt; padding-left:0pt;">
        <li style="margin-left:9.83pt; padding-left:8.17pt; font-family:serif; font-size:10.5pt; color:#3b3838;">
            <em><span style="font-family:Calibri;">Lampiran : 1.) bukti transfer 2.) surat permohonan / proposal
                    permohonan / memo internal</span></em>
        </li>
    </ul>

</body>

</html>
