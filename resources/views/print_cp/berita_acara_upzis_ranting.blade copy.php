<?php
function formatTahun($tahun)
{
    if ($tahun >= 2000 && $tahun <= 9999) {
        $tahunDuaRibuan = (int) ($tahun / 1000);
        $tahunRatusan = (int) (($tahun % 1000) / 100);
        $tahunPuluhan = (int) (($tahun % 100) / 10);
        $tahunSatuan = $tahun % 10;

        $tahunDuaRibuanText = $tahunDuaRibuan == 1 ? 'seribu' : 'dua ribu';
        $tahunRatusanText = $tahunRatusan > 0 ? formatSatuan($tahunRatusan) . ' ratus' : '';
        $tahunPuluhanText = formatPuluhan($tahunPuluhan, $tahunSatuan);
        $tahunSatuanText = formatSatuan($tahunSatuan);

        return trim("$tahunDuaRibuanText $tahunRatusanText $tahunPuluhanText $tahunSatuanText");
    } else {
        return 'Tahun tidak valid';
    }
}

function formatSatuan($angka)
{
    $satuan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
    return $satuan[$angka];
}

function formatPuluhan($puluhan, $satuan)
{
    if ($puluhan == 1) {
        $belasan = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
        return $belasan[$satuan];
    } else {
        $puluhanText = ['', 'sepuluh', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
        return $puluhanText[$puluhan];
    }
}

$tahunSekarang = date('Y'); // Mendapatkan tahun sekarang dalam format empat digit (contoh: 2023)
$formatTahun = formatTahun($tahunSekarang);
// echo "Tahun sekarang: " . $formatTahun;
?>




<!DOCTYPE html>
<html>

<head>
    <title>Berita Acara Pentasyarufan</title>
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
                    <td  class="text-right">
                        <strong><em>Sistem Informasi Filantropi Nahdlatul Ulama,
                                E-Tasyaruf</em></strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</footer>



<main>

    <body>

        {{-- kertas 1 --}}
        <div>
            <header>
                <table style="width:100%;">
                    <tr>

                        <td style="width:20%;margin:0.4cm;border:#000000 solid black;" class="text-center"><img
                                src="{{ public_path('/images/logo_lazisnu.png') }}" width="126" height="66"
                                style="margin: 2 auto; display: block; "></td>
                        <td style="width:80%;margin:0.4cm;border:#000000 solid black;font-size:11pt;" class="text-center "><b>BERITA ACARA PENTASARUFAN
                            <br>LEMBAGA AMIL ZAKAT INFAQ SHADAQAH NAHDLATUL ULAMA CILACAP</b></td>
                    </tr>
                </table>
            </header>

           <br>
            <table style="width: 100%;font-size:11pt;">
                <tr>
                    {{ Carbon\Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM Y') }}

                    <td colspan="3" style="text-align: justify;">
                        Pada hari ini {{ Carbon\Carbon::parse(now())->isoFormat('dddd') }}
                        tanggal {{ Carbon\Carbon::parse(now())->isoFormat('D') }} bulan
                        {{ Carbon\Carbon::parse(now())->isoFormat('MMMM') }} tahun
                        dua ribu {{ $formatTahun }} masehi
                        ({{ Carbon\Carbon::parse(now())->isoFormat('DD') }}-{{ Carbon\Carbon::parse(now())->isoFormat('MM') }}-{{ date('Y') }})
                        yang bertanda
                        tangan di bawah
                        ini :
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 0.15cm;"></td>
                </tr>
                <tr>
                    <td style="width: 30%">Nama</td>
                    <td style="width: 2%">:</td>
                    <td >
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'c699f7c7-7791-11ed-97ee-e4a8df91d8b3') }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('ranting', $data->id_ranting, 'f3baf470-3a29-11ed-a757-e4a8df91d887') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%">Jabatan</td>
                    <td style="width: 2%">:</td>
                    <td >
                        @if ($data->tingkat == 'Upzis MWCNU')
                            Ketua UPZIS MWCNU {{ $nama_upzis }}
                        @elseif($data->tingkat == 'Ranting NU')
                            Koordinator
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%">
                        @if ($data->tingkat == 'Upzis MWCNU')
                            UPZIS MWCNU
                        @elseif($data->tingkat == 'Ranting NU')
                            PRNU
                        @endif
                    </td>
                    <td style="width: 2%">:</td>
                    <td >
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ $nama_upzis }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ $nama_ranting }}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="height: 0.15cm;"></td>
                </tr>
                <tr>
                    <td colspan="3">Saya yang bertindak sebagai <b>PIHAK KEDUA</b> sebagai petugas pentasyarufan :
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 0.15cm;"></td>
                </tr>


                <tr>
                    <td style="width: 30%">Nama Lengkap</td>
                    <td style="width: 2%">:</td>
                    <td >
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $data->petugas_upzis) }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $data->petugas_ranting) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%">Alamat Lengkap</td>
                    <td style="width: 2%">:</td>
                    <td >
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getAlamatPengurus('upzis', $data->petugas_upzis) }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getAlamatPengurus('ranting', $data->petugas_ranting) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%">No. Telp</td>
                    <td style="width: 2%">:</td>
                    <td >
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getNohpPengurus('upzis', $data->petugas_upzis) }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getNohpPengurus('ranting', $data->petugas_ranting) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%">Jabatan </td>
                    <td style="width: 2%">:</td>
                    <td >
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data->petugas_upzis) }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getJabatanPengurus('ranting', $data->petugas_ranting) }}
                        @endif
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="height: 0.15cm;"></td>
                </tr>

            </table>

            <table style="width: 100%;font-size:11pt;">
                <tr>
                    <td colspan="3" style="text-align: justify;">
                        Bahwa PIHAK PERTAMA dan PIHAK KEDUA sepakat untuk :
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;vertical-align:top;">1.</td>
                    <td colspan="2" style="text-align: justify;"><b>PIHAK PERTAMA</b> menyerahkan bantuan
                        {{ \App\Http\Controllers\Helper::getDataKegiatan($data->id_program_kegiatan ?? null)->pluck('nama_program')->first() }}

                        berupa……………………………senilai Rp. …………………… dan
                        tugas pentasyarufan dana ZIS NU Care Lazisnu Cilacap kepada <b>PIHAK KEDUA</b>.</td>
                </tr>
                <tr>
                    <td style="width: 5%;vertical-align:top;">2.</td>
                    <td colspan="2" style="text-align: justify;"><b>PIHAK KEDUA</b> menyatakan telah menerima
                        bantuan
                        {{ \App\Http\Controllers\Helper::getDataKegiatan($data->id_program_kegiatan ?? null)->pluck('nama_program')->first() }}

                        berupa……………………senilai Rp. ……….…….dari <b>PIHAK PERTAMA</b>.</td>
                </tr>
                <tr>
                    <td style="width: 5%;vertical-align:top;">3.</td>
                    <td colspan="2" style="text-align: justify;">
                        <b>PIHAK PERTAMA</b> berkewajiban menyerahkan berita acara pentasarufan dilampiri : <b>( a.)</b>
                        proposal /
                        pengajuan / berita acara rapat pentasyarufan <b>( b.)</b> foto dokumentasi pentasyarufan
                        <b>(c.)</b> fotokopi
                        identitas penerima manfaat KK atau KTP <b>(d.)</b> nota pembelian barang <b>(jika bantuan berupa
                            barang)</b> <b>(
                            e.)</b> kwitansi pentasyarufan (bantuan nominal Rp.1.000.000 ke atas ber materai
                        10.000) <b>( f.)</b> SPTJM
                        <b>( g.)</b> Slip penarikan / pengambilan dana dari Bank / BMT kepada NU Care Lazisnu Cilacap
                        setiap
                        selesai melakukan pentasarufan.
                    </td>
                </tr>

                <tr>
                    <td colspan="3" style="height: 0.15cm;">Demikian berita acara penyerahan bantuan NU Care Lazisnu
                        Cilacap ini dibuat, untuk dapat digunakan dalam rangka kepedulian dan memaksimalkan fungsi ZIS
                        bagi masyarakat.</td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 0.15cm;"></td>
                </tr>
            </table>


            <div>

                <table style="width: 100%;page-break-inside: avoid;font-size:11pt;">


                    <tr>
                        <td style="width: 33%;text-align: center;">
                            <b>PIHAK PERTAMA</b><br>
                            Yang menyerahkan<br>
                            (ttd + stempel)

                        </td>
                        <td style="width: 33%;text-align: center;vertical-align:top">
                            <b>PIHAK KEDUA</b><br>
                            Penerima Manfaat <br>
                            (ttd)
                        </td>
                        <td style="width: 33%;text-align: center;vertical-align:top">
                            Diperiksa dan di terima :<br>
                            Pada tanggal ........ - ........- 20......

                        </td>
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width: 33%;text-align: center">
                            <span style=";text-decoration: underline;">
                                {{-- divisi progam dan aministrasi umum --}}
                                ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3') ?? '(.........................)' }})

                            </span>
                            <br>Jabatan : ................
                        </td>
                        <td style="width: 33%;text-align: center">
                            <span style=";text-decoration: underline;">
                                {{-- divisi pentasyarufan --}}
                                ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'bf9ed4c6-85c2-11ed-a0ac-040300000000') ?? '(.........................)' }})


                            </span>
                            <br>Jabatan : ................

                        </td>
                        <td style="width: 33%;text-align: center">
                            <span style=";text-decoration: underline;">
                                {{-- divisi pentasyarufan --}}
                                ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'bf9ed4c6-85c2-11ed-a0ac-040300000000') ?? '(.........................)' }})


                            </span>
                            <br>Jabatan : ................

                        </td>
                    </tr>
                    <br>
                    <tr>
                        <td colspan="3" style="height: 0.15cm;">Keterangan : <b><em>apabila penerima manfaat adalah
                                    lembaga/organisasi/tempat ibadah wajib berstempel </em></b> </td>
                    </tr>
                </table>


            </div>

        </div>

        {{-- kertas 2 --}}
        <div style="clear: both; page-break-before: always;">

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
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>SURAT PERNYATAAN TANGGUNGJAWAB MUTLAK (SPTJM) </span></strong>
                            </p>

                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="width: 100%;font-size:11pt;">
                {{-- paragraf 1 --}}
                <tr>
                    <td colspan="3">Yang bertanda tangan di bawah ini :</td>

                </tr>
                <tr>
                    <td style="width: 20%">Nama</td>
                    <td style="width: 2%"> :</td>
                    <td>
                        ........................................
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%">NIK</td>
                    <td style="width: 2%"> :</td>
                    <td>
                        ........................................
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%">Alamat</td>
                    <td style="width: 2%"> :</td>
                    <td>
                        ........................................
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%">No HP</td>
                    <td style="width: 2%"> :</td>
                    <td>
                        ........................................
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%">Jabatan</td>
                    <td style="width: 2%"> :</td>
                    <td>
                        ........................................
                    </td>
                </tr>



            </table>

            <br>
            {{-- paragraf 2 --}}
            <table style="width: 100%;font-size:11pt;">
                <tr>
                    <td colspan="2">Dengan ini menyatakan bahwa :</td>
                </tr>
                <br>
                <tr>
                    <td style="width: 5%;vertical-align:top;text-align:center;">1.</td>
                    <td style="width: 95%;text-align:justify;">Bertanggungjawab mutlak terhadap penggunaan dana yang
                        saya terima sesuai dengan ketentuan syariat, ketetapan Nucare Lazisnu Cilacap dan
                        perundang-undangan yang berlaku.</td>
                </tr>
                <tr>
                    <td style="width: 5%;vertical-align:top;text-align:center;">2.</td>
                    <td style="width: 95%;text-align:justify;">Berkomitmen memberikan laporan penggunaan dana dengan
                        melampirkan bukti-bukti pendukung (kwitansi atau nota, dokumentasi ).</td>
                </tr>
                <tr>
                    <td style="width: 5%;vertical-align:top;text-align:center;">3.</td>
                    <td style="width: 95%;text-align:justify;">Berkomitmen turut serta dalam mengkampanyekan zakat,
                        Infaq, Shodaqoh.</td>
                </tr>
                <tr>
                    <td style="width: 5%;vertical-align:top;text-align:center;">4.</td>
                    <td style="width: 95%;text-align:justify;">Apabila dikemudian hari diketahui terjadi
                        penyimpangan dalam penggunaan dan/atau tidak sesuai dengan rencana penggunaan, maka saya
                        bersedia menerima sanksi sesuai dengan peraturan NU Care Lazisnu Cilacap dan perundang-undangan
                        yang berlaku</td>
                </tr>
                <br>
                <tr>
                    <td colspan="2">Demikian surat pernyataan ini dibuat dengan sebenarnya dan bermaterai cukup
                        untuk dipergunakan sebagaimana mestinya.</td>
                </tr>

            </table>
            {{-- end paragraf 2 --}}

            <br>
            <br>
            <br>
            {{-- ttd kertas 4 --}}
            <div>
                <table cellpadding="0" cellspacing="0" style="width:531.6pt; border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td
                                style="width: 45.3566%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">

                            </td>
                            <td
                                style="width: 5.5844%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:125%; font-size:11pt;">
                                    <span>&nbsp;</span>
                                </p>
                            </td>
                            <td
                                style="width: 48.8585%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                                    class="text-center">
                                    <span>
                                        Cilacap, ...................
                                    </span>
                                </p>

                                <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    <span>&nbsp;</span>
                                </p>
                                <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    <span>&nbsp;</span>
                                </p>
                                <p
                                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                    <span>&nbsp;</span>
                                </p>
                                <p style="margin-top:0pt; margin-bottom:0pt; line-height:125%; font-size:11pt;">
                                    <span>&nbsp;</span>
                                </p>


                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                                    class="text-center">
                                    <span>(...............................)</span>
                                </p>

                            </td>
                        </tr>




                    </tbody>


                </table>


            </div>


        </div>

        {{-- kertas 3 --}}
        <div style="clear: both; page-break-before: always;">
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
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>LAMPIRAN BERITA SERAH TERIMA BANTUAN </span></strong>
                            </p>

                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table cellpadding="0" cellspacing="0"
                style="width:525.25pt; border:0.75pt solid #000000; border-collapse:collapse;">
                <tbody>
                    <tr>
                        <td
                            style="width:5%; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle;text-align:center">
                            <p
                                style="margin-top:6pt; margin-bottom:6pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                <span style=""><strong>NO</strong></span>
                            </p>
                        </td>
                        <td
                            style="width:30%; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle;text-align:center">
                            <p
                                style="margin-top:6pt; margin-bottom:6pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                <span style=""><strong>KETERANGAN</strong></span>

                            </p>
                        </td>
                        <td
                            style="width:20%; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle;text-align:center">
                            <p
                                style="margin-top:6pt; margin-bottom:6pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                <span style=""><strong>NAMA</strong></span>

                            </p>
                        </td>
                        <td
                            style="width:25%; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle;text-align:center">
                            <p
                                style="margin-top:6pt; margin-bottom:6pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                <span style=""><strong>ALAMAT</strong></span>

                            </p>
                        </td>
                        <td
                            style="width:20%; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;text-align:center">
                            <p
                                style="margin-top:6pt; margin-bottom:6pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                <span style=""><strong>NOMINAL BANTUAN</strong></span>

                            </p>
                        </td>
                    </tr>
                </tbody>

                <tbody>
                    @php
                        $jumlah = 0;
                    @endphp
                    @foreach ($data_penerima_lpj as $a)
                        <tr>
                            <td
                                style="border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                <p class="text-center"
                                    style="margin-top:2pt; margin-bottom:4pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                    <span style="">{{ $loop->iteration }}
                                    </span>
                                </p>
                            </td>
                            <td
                                style=" border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                <p
                                    style="margin-top:2pt; margin-bottom:4pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                    <span style="">{{ $a->keterangan }}
                                    </span>
                                </p>

                            </td>

                            <td
                                style="border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                <p
                                    style="margin-top:2pt; margin-bottom:4pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                    <span style="">{{ $a->nama }}
                                    </span>
                                </p>
                            </td>
                            <td
                                style="border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                <p
                                    style="margin-top:2pt; margin-bottom:4pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                    <span style="">
                                        {{ $a->alamat }}
                                    </span>
                                </p>

                            </td>
                            <td
                                style="border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;text-align:center">
                                <p
                                    style="margin-top:2pt; margin-bottom:4pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                    <span style="">
                                        Rp{{ number_format($a->nominal_bantuan, 0, '.', '.') }}

                                    </span>
                                </p>

                            </td>
                        </tr>
                        @php
                            $jumlah += $a->nominal_bantuan;
                        @endphp
                    @endforeach


                    <tr>
                        <td
                            style="border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p class="text-center"
                                style="margin-top:2pt; margin-bottom:4pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                <span style="">
                                </span>
                            </p>
                        </td>
                        <td colspan="3"
                            style=" border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                            <p
                                style="margin-top:2pt; margin-bottom:4pt; line-height:150%; widows:0; orphans:0; font-size:11pt;text-align:right">
                                <span style=""><strong>Jumlah</strong>
                                </span>
                            </p>

                        </td>


                        <td
                            style="border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;text-align:center">
                            <p
                                style="margin-top:2pt; margin-bottom:4pt; line-height:150%; widows:0; orphans:0; font-size:11pt;">
                                <span><b>
                                        Rp{{ number_format($jumlah, 0, '.', '.') }}
                                    </b>
                                </span>
                            </p>

                        </td>
                    </tr>

                </tbody>
            </table>

            <br>
            <br>

            <div>

                <table style="width: 100%;page-break-inside: avoid;">
                    <tr>
                        <td style="width: 50%;text-align: center;">
                            <b>PIHAK KEDUA</b>
                            <br>
                            Yang Menerima
                            <br>
                            (Petugas Pentasyarufan)
                        </td>
                        <td style="width: 50%;text-align: center;">
                            <b>PIHAK PERTAMA</b>
                            <br>
                            Yang Menyerahkan
                            <br>
                            @if ($data->tingkat == 'Upzis MWCNU')
                                UPZIS MWCNU {{ $nama_upzis }}
                            @elseif($data->tingkat == 'Ranting NU')
                                PRNU {{ $nama_ranting }}
                            @endif
                        </td>
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width: 50%;text-align: center">
                            <span style=";text-decoration: underline;">
                                {{-- pj --}}
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    ({{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $data->petugas_upzis) ?? '(.........................)' }})
                                @elseif($data->tingkat == 'Ranting NU')
                                    ({{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $data->petugas_ranting) ?? '(.........................)' }})
                                @endif
                            </span>
                            {{-- <br>
                            <span> Jabatan :
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    {{ App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data->pj_upzis) }}
                                @elseif($data->tingkat == 'Ranting NU')
                                    {{ App\Http\Controllers\Helper::getJabatanPengurus('ranting', $data->pj_ranting) }}
                                @endif
                            </span> --}}
                        </td>
                        <td style="width: 50%;text-align: center">
                            <span style=";text-decoration: underline;">
                                {{-- ketua upzis mwcnu/koordinator prnu --}}
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'c699f7c7-7791-11ed-97ee-e4a8df91d8b3') ?? '(.........................)' }})
                                @elseif($data->tingkat == 'Ranting NU')
                                    ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('ranting', $data->id_ranting, 'f3baf470-3a29-11ed-a757-e4a8df91d887') ?? '(.........................)' }})
                                @endif
                            </span>
                            {{-- <br>
                            <span>Jabatan :
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    Ketua UPZIS MWCNU {{ $nama_upzis }}
                                @elseif($data->tingkat == 'Ranting NU')
                                    Koordinator
                                @endif
                            </span> --}}
                        </td>
                    </tr>
                    <br>
                    <tr>
                        <td style="width: 50%;text-align: center;">
                            Diperiksa dan di terima oleh :
                            <br>
                            Staf Administrasi & Program
                            <br>
                            NUCARE-LAZISNU CILACAP

                        </td>
                        <td style="width: 50%;text-align: center;vertical-align:top">
                            Divisi Pentasarufan
                            <br>
                            UPZIS MWCNU Kesugihan

                        </td>
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width: 50%;text-align: center">
                            <span style=";text-decoration: underline;">
                                {{-- divisi progam dan aministrasi umum --}}
                                ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3') ?? '(.........................)' }})
                            </span>
                        </td>
                        <td style="width: 50%;text-align: center">
                            <span style=";text-decoration: underline;">
                                {{-- divisi pentasyarufan --}}
                                ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'bf9ed4c6-85c2-11ed-a0ac-040300000000') ?? '(.........................)' }})
                            </span>

                        </td>
                    </tr>
                </table>


            </div>



        </div>

        {{-- kertas 4 kwitansi --}}
        <div style="clear: both; page-break-before: always;">

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
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>KWITANSI PENTASARUFAN </span></strong>
                            </p>

                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <img src="{{ public_path('/images/kwitansi.jpg') }}" width="700" height="220"
                style="margin: 0 auto 0 0; display: block; ">



        </div>


    </body>
</main>


</html>
