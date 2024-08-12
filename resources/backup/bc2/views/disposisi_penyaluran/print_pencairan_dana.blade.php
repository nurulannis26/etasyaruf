<?php
function terbilang($angka)
{
    $bilangan = ['', 'seribu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

    if ($angka < 12) {
        return $bilangan[$angka];
    } elseif ($angka < 20) {
        return terbilang($angka - 10) . ' belas';
    } elseif ($angka < 100) {
        return terbilang(floor($angka / 10)) . ' puluh ' . terbilang($angka % 10);
    } elseif ($angka < 200) {
        return 'seratus ' . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return terbilang(floor($angka / 100)) . ' ratus ' . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return 'seribu ' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang(floor($angka / 1000)) . ' ribu ' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        return terbilang(floor($angka / 1000000)) . ' juta ' . terbilang($angka % 1000000);
    } else {
        return 'Angka terlalu besar';
    }
}

// $angka = 123456; // Ganti dengan angka yang ingin diubah ke terbilang
// echo terbilang($angka);

?>
<!DOCTYPE html>
<html lang="id-ID">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>
    </title>


    {{-- <style>
    body {
        line-height: 115%;
      font-family: Calibri;
      font-size: 11pt;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    p {
        margin: 0pt 0pt 10pt
    }
    
    li,
    table {
        margin-top: 0pt;
        margin-bottom: 10pt;
        max-width: 100%;
    }
    
    .ListParagraph {
        margin-left: 36pt;
        margin-bottom: 10pt;
        line-height: 115%;
        font-size: 11pt
    }
    </style> --}}

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


<body>
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
                                style="font-family:'Arial Narrow';">FORM PENCAIRAN PERMOHONAN DANA</span></strong></p>
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
    <p style="margin-bottom:0px;"><strong><span style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
    <p style="margin-bottom:0px;"><strong><span style="font-family:'Arial Narrow';">Hari, Tanggal
                : {{ Carbon\Carbon::parse($D_pengajuan->tgl_pencairan)->isoFormat('dddd, D MMMM Y') }}</span></strong>
    </p>
    <p style="margin-bottom:0px;"><strong><span style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
    <table style="width:100%; margin-bottom:0px; border:0.75px solid #000000; border-collapse:collapse;">
        <tbody>
            <tr style="height:14.5px;">
                <td
                    style="width:10%; border-right:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">NO</span></strong></p>
                </td>
                <td
                    style="width:12%; border-right:0.75px solid #000000; border-left:0.75px solid #000000; border-bottom:0.75px solid #000000; vertical-align:top;">
                    <p style="margin-bottom:0px; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">NO. PENGAJUAN</span></strong></p>
                </td>
                <td
                    style="width:12%; border-right:0.75px solid #000000; border-left:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">NAMA PEMOHON</span></strong></p>
                </td>
                <td
                    style="width:12%; border-right:0.75px solid #000000; border-left:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">PERIHAL PEMOHON</span></strong></p>
                </td>
                <td
                    style="width:12%; border-right:0.75px solid #000000; border-left:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">SUMBER DANA YANG DIGUNAKAN</span></strong></p>
                </td>
                @if ($D_pengajuan->sumber_dana == 'Dana Zakat')
                    <td
                        style="width:12%; border-right:0.75px solid #000000; border-left:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                        <p style="margin-bottom:0px; text-align:center; line-height:normal;"><strong><span
                                    style="font-family:'Arial Narrow';">ASNAF</span></strong></p>
                    </td>
                @elseif($D_pengajuan->sumber_dana == 'Dana Infak')
                    <td
                        style="width:12%; border-right:0.75px solid #000000; border-left:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                        <p style="margin-bottom:0px; text-align:center; line-height:normal;"><strong><span
                                    style="font-family:'Arial Narrow';">PILAR & PROGRAM</span></strong></p>
                    </td>
                @endif
                <td
                    style="width:12%; border-right:0.75px solid #000000; border-left:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">BANK / KAS</span></strong></p>
                </td>
                <td
                    style="width:12%; border-left:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">JUMLAH (Rp)</span></strong></p>
                </td>
            </tr>
            <tr style="height:11.4px;">
                <td
                    style="width:12%; border-top:0.75px solid #000000; border-right:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; line-height:normal;text-align:center"><span
                            style="font-family:'Arial Narrow';">1</span></p>
                </td>
                <td
                    style="width:12%; border:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                            style="font-family:'Arial Narrow';">{{ $pengajuan->nomor_surat }}</span></p>
                </td>
                <td
                    style="width:12%; border:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                            style="font-family:'Arial Narrow';">
                            @if ($pengajuan->opsi_pemohon == 'Entitas')
                                {{ $D_pengajuan->nama_entitas }}
                            @elseif ($pengajuan->opsi_pemohon == 'Individu')
                                {{ $D_pengajuan->nama_pemohon }}
                            @else
                                {{ app('App\Http\Controllers\PrintPenyaluranController')->nama_pengurus_pc($pengajuan->pemohon_internal) }}
                            @endif
                        </span></p>
                </td>
                <td
                    style="width:12%; border:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                            style="font-family:'Arial Narrow';">{{ $D_pengajuan->pengajuan_note }}</span></p>
                </td>
                <td
                    style="width:12%; border:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                            style="font-family:'Arial Narrow';">{{ $D_pengajuan->sumber_dana_opsi }}</span></p>
                </td>

                @if ($D_pengajuan->sumber_dana == 'Dana Zakat')
                    <td
                        style="width:12%; border:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                        <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                                style="font-family:'Arial Narrow';">{{ $asnaf }}</span></p>
                    </td>
                @elseif($D_pengajuan->sumber_dana == 'Dana Infak')
                    <td
                        style="width:12%; border:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                        <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                                style="font-family:'Arial Narrow';"><b>{{ $nama_program }}</b></span></p> <br>
                        <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                                style="font-family:'Arial Narrow';">{{ $nama_kegiatan }}</span></p>
                    </td>
                @endif

                <td
                    style="width:12%; border:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                            style="font-family:'Arial Narrow';">{{ $nama_rek }}</span></p>
                </td>
                <td
                    style="width:12%; border-top:0.75px solid #000000; border-left:0.75px solid #000000; border-bottom:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; line-height:normal text-align:center;"><span
                            style="font-family:'Arial Narrow';"></span>
                        Rp{{ number_format($D_pengajuan->satuan_pencairan, 0, '.', '.') }}</p>
                </td>
            </tr>

            <tr style="height:12.1px;">
                <td colspan="5"
                    style="width:12%; border-top:0.75px  padding-right:5.03px; padding-left:5.03px; vertical-align:middle;">
                    <p style="margin-bottom:0px; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                    <p style="margin-bottom:0px; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">TOTAL</span></strong></p>
                </td>
                <td colspan="2"
                    style="width:12%;padding-right:5.03px; padding-left:5.03px; vertical-align:top;text-align: right;">
                    <p style="margin-bottom:0px; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">({{ $D_pengajuan->jumlah_penerima }} x
                                Rp{{ number_format($D_pengajuan->satuan_pencairan, 0, '.', '.') }})</span></strong></p>
                </td>
                <td
                    style="width:12%; border-top:0.75px solid #000000; border-left:0.75px solid #000000; padding-right:5.03px; padding-left:5.03px; vertical-align:top;">
                    <p style="margin-bottom:0px; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">
                                Rp{{ number_format($D_pengajuan->nominal_pencairan, 0, '.', '.') }},-</span></strong>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <p style="margin-bottom:0pt;"><strong><span style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
    @if ($D_pengajuan->nominal_pencairan)
        <p style="margin-bottom:0pt; line-height:normal;"><strong><span style="font-family:'Arial Narrow';">Terbilang:
                    {{ ucwords(terbilang($D_pengajuan->nominal_pencairan)) . ' Rupiah' }}</span></strong></p>
    @endif
    <p style="margin-bottom:0pt;"><strong><span style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
    <table style="margin-bottom:0pt; border:0.75pt solid #FFFFFF; border-collapse:collapse;">
        <tbody>
            <tr>
                <td
                    style="width:166.2pt; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                </td>
                <td
                    style="width:166.2pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">Mengetahui,</span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">Divisi Keuangan</span></p>
                </td>
                <td
                    style="width:166.25pt; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                </td>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; text-align: center;">
                    {{-- <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p> --}}
                    @if ($D_pengajuan->pencairan_status == 'Berhasil Dicairkan')
                        <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697254224.Veni%20Mutia%20Sari.jpg"
                            width="100px">
                    @endif
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">VENI MUTIA SARI, S.Ak.</span></strong></p>
                </td>
                <td
                    style="width:166.25pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                </td>
                <td
                    style="width:166.2pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">&nbsp;</span></p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">Disetujui oleh :</span></p>
                </td>
                <td
                    style="width:166.25pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">Direktur</span></p>
                </td>
                <td
                    style="width:166.2pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">&nbsp;</span></p>
                </td>
                <td
                    style="width:166.25pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">Ketua NUCARE LAZISNU Cilacap</span></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; text-align: center;">
                    @if ($D_pengajuan->approval_status_pencairan_direktur == 'Disetujui')
                        <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697426100.Ahmad%20Fauzi,%20S.Pd.I.jpg"
                            width="100px">
                    @endif

                </td>
                <td
                    style="width:166.2pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">&nbsp;</span></p>
                </td>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; text-align: center;">
                    @if (
                        $D_pengajuan->approval_status_pencairan_direktur == 'Disetujui' &&
                            $D_pengajuan->pencairan_status == 'Berhasil Dicairkan')
                        <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697426218.H.%20Wasbah%20Samudra%20Fawaid,%20S.E.jpg"
                            width="100px">
                    @endif
                </td>
            </tr>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">AHMAD FAUZI,S.Pd.I</span></strong></p>
                </td>
                <td
                    style="width:166.2pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">&nbsp;</span></p>
                </td>
                <td
                    style="width:166.25pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">H. WASBAH SAMUDRA FAWAID, SE</span></strong></p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    {{-- <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">Ttd &amp; stempel</span></p> --}}
                </td>
                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">&nbsp;</span></p>
                </td>
                <td
                    style="width:166.25pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    {{-- <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><span
                            style="font-family:'Arial Narrow';">Ttd &amp; stempel</span></p> --}}
                </td>
            </tr>
        </tbody>
    </table>

    <br><br>
    <p style="margin-bottom:0pt;"><strong><span style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>


    <table style="width:532.85pt; margin-bottom:0pt; border:0.75pt solid #FFFFFF; border-collapse:collapse;">
        <tbody>
            <tr style="height:17.25pt;">
                <td
                    style="width:166.55pt; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt;"><strong><span
                                style="font-family:'Arial Narrow';">Lampiran:</span></strong></p>
                    <br>

                    <ol style="margin:0pt; padding-left:0pt; list-style-type:lower-latin;">
                        @foreach ($lampiran_pencairan as $it)
                            <li class="ListParagraph"
                                style="margin-left:14.17pt; margin-bottom:0pt; line-height:normal; padding-left:8.78pt; font-family:'Arial Narrow';">
                                {{ $it->judul }}</li>
                        @endforeach
                    </ol>
                    @if (count($lampiran_pencairan) == 0)
                        <p style="margin-bottom:0pt;"><strong><span
                                    style="font-family:'Arial Narrow';">-</span></strong></p>
                        <br>
                    @endif
                    {{-- <ol style="margin:0pt; padding-left:0pt; list-style-type:lower-latin;">
                        <li class="ListParagraph"
                            style="margin-left:14.17pt; margin-bottom:0pt; line-height:normal; padding-left:8.78pt; font-family:'Arial Narrow';">
                            T.O.R</li>
                    </ol>

                    <ol start="2" style="margin:0pt; padding-left:0pt; list-style-type:lower-latin;">
                        <li class="ListParagraph"
                            style="margin-left:14.17pt; margin-bottom:0pt; line-height:normal; padding-left:8.78pt; font-family:'Arial Narrow';">
                            Budget</li>
                    </ol>
                    <ol start="3" style="margin:0pt; padding-left:0pt; list-style-type:lower-latin;">
                        <li class="ListParagraph"
                            style="margin-left:13.67pt; margin-bottom:0pt; line-height:normal; padding-left:9.28pt; font-family:'Arial Narrow';">
                            Dokumen Perencanaan</li>
                    </ol>

                    <ol start="4" style="margin:0pt; padding-left:0pt; list-style-type:lower-latin;">
                        <li class="ListParagraph"
                            style="margin-left:14.17pt; margin-bottom:0pt; line-height:normal; padding-left:8.78pt; font-family:'Arial Narrow';">
                            Bukti Transfer</li>
                    </ol>


                    <ol start="5" style="margin:0pt; padding-left:0pt; list-style-type:lower-latin;">
                        <li class="ListParagraph"
                            style="margin-left:14.17pt; margin-bottom:0pt; line-height:normal; padding-left:8.78pt; font-family:'Arial Narrow';">
                            Dokumen Pengajuan</li>
                    </ol>

                    <ol start="6" style="margin:0pt; padding-left:0pt; list-style-type:lower-latin;">
                        <li class="ListParagraph"
                            style="margin-left:11.67pt; margin-bottom:0pt; line-height:normal; padding-left:11.28pt; font-family:'Arial Narrow';">
                            Lainnya</li>
                    </ol> --}}
                </td>

                <td
                    style="width:166.55pt; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt;"><strong><span style="font-family:'Arial Narrow';"></span></strong>
                    </p>
                    <br>
                    <p style="margin-bottom:0pt;"><strong><span style="font-family:'Arial Narrow';">
                                Catatan Direktur :
                            </span></strong><br>{{ $D_pengajuan->keterangan_acc_pencairan_direktur ?? '-' }} <br><br>
                        <strong>Catatan Div. Keuangan :
                        </strong><br>{{ $D_pengajuan->keterangan_pencairan ?? '-' }}<br><br>
                    </p>
                </td>
            </tr>

        </tbody>
    </table>

</body>

</html>
