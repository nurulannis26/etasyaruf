<?php
// Contoh input tanggal dari $data->tgl_berita
$tanggal = $data->tgl_berita; // Misalnya '2023-08-22'

// Mendapatkan informasi hari, tanggal, bulan, dan tahun dari tanggal
$timestamp = strtotime($tanggal);
$hari = date('l', $timestamp); // Hari dalam bentuk kata (e.g., 'Tuesday')
$tgl = date('d', $timestamp); // Tanggal (e.g., '22')
$bulan = date('F', $timestamp); // Bulan dalam bentuk kata (e.g., 'August')
$tahun = date('Y', $timestamp); // Tahun (e.g., '2023')

// Konversi nama hari ke dalam bahasa Indonesia (opsional, bisa disesuaikan)
$namaHariIndonesia = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
];
$hari = $namaHariIndonesia[$hari];

// Konversi nama bulan ke dalam bahasa Indonesia (opsional, bisa disesuaikan)
$namaBulanIndonesia = [
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember',
];
$bulan = $namaBulanIndonesia[$bulan];

// Konversi tanggal ke dalam bentuk kata
function konversiTanggalKeKata($tanggal)
{
    $angka = (int) $tanggal;
    $kata = ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];

    if ($angka < 20) {
        return $kata[$angka];
    } else {
        $puluh = floor($angka / 10);
        $satuan = $angka % 10;
        if ($satuan === 0) {
            return $kata[$puluh] . ' puluh';
        } else {
            return $kata[$puluh] . ' puluh ' . $kata[$satuan];
        }
    }
}

$tgl = konversiTanggalKeKata($tgl);

// Konversi tahun ke dalam bentuk dua ribu...
$tahunDuaRibuan = '';
$digitPertama = substr($tahun, 0, 1);
if ($digitPertama === '2') {
    $tahunDuaRibuan = 'dua ribu';
    $tahunSisa = substr($tahun, 1);
    $tahunDuaRibuan .= ' ' . konversiAngkaKeKata($tahunSisa); // Konversi dua puluh tiga menjadi kata
}
$tahunDuaRibuan .= ' masehi';

// Fungsi untuk mengonversi angka menjadi kata
function konversiAngkaKeKata($angka)
{
    // Daftar kata-kata untuk angka 1-20
    $kata = [
        1 => 'satu',
        2 => 'dua',
        3 => 'tiga',
        4 => 'empat',
        5 => 'lima',
        6 => 'enam',
        7 => 'tujuh',
        8 => 'delapan',
        9 => 'sembilan',
        10 => 'sepuluh',
        11 => 'sebelas',
        12 => 'dua belas',
        13 => 'tiga belas',
        14 => 'empat belas',
        15 => 'lima belas',
        16 => 'enam belas',
        17 => 'tujuh belas',
        18 => 'delapan belas',
        19 => 'sembilan belas',
    ];

    if ($angka < 20) {
        return $kata[$angka];
    } elseif ($angka < 100) {
        return $kata[floor($angka / 10)] . ' puluh ' . $kata[$angka % 10];
    } else {
        return 'seratus atau lebih';
    }
}

// Output hasil konversi
echo "Pada hari ini $hari, tanggal $tgl bulan $bulan tahun $tahunDuaRibuan.";

if ($tanggal == null) {
    $hari = '......';
    $tgl = '......';
    $bulan = '......';
    $tahunDuaRibuan = '......';
}

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

    <body>

        {{-- kertas 1 --}}
        <div>
            <header>
                <table style="width:100%;">
                    <tr>

                        <td style="width:20%;margin:0.4cm;border:1px  solid black ;" class="text-center"><img
                                src="{{ public_path('/images/logo_lazisnu.png') }}" width="126" height="66"
                                style="margin: 2 auto; display: block; "></td>
                        <td style="width:80%;margin:0.4cm;border:1px  solid black ;font-size:11pt;"
                            class="text-center "><b>BERITA ACARA PENTASARUFAN
                                <br>LEMBAGA AMIL ZAKAT INFAQ SHADAQAH NAHDLATUL ULAMA CILACAP</b></td>
                        {{-- <td style="width:20%;margin:0.4cm;border:1px  solid black ;" class="text-center"> --}}
                    </td>
                    </tr>
                </table>
            </header>

            <br>
            <table style="width: 100%;font-size:11pt;">
                <tr>
                    {{ Carbon\Carbon::parse($data->created_at)->isoFormat('dddd, D MMMM Y') }}

                    <td colspan="3" style="text-align: justify;">
                        Pada hari ini {{ $hari }}
                        tanggal {{ $tgl }} bulan
                        {{ $bulan }} tahun
                        dua ribu {{ $tahunDuaRibuan }} masehi
                        ({{ $data->tgl_berita ? Carbon\Carbon::parse($data->tgl_berita)->isoFormat('DD-MM-Y') : '.........' }})
                        yang bertanda
                        tangan di bawah
                        ini :
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 0.15cm;"></td>
                </tr>
                <tr>
                    <td style="width: 30%">Nama Petugas Pentasyarufan</td>
                    <td style="width: 2%">:</td>
                    <td>
                        {{ $data->nama1 ?? '..........................................................................................................' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%">Jabatan</td>
                    <td style="width: 2%">:</td>
                    <td>
                        {{ $data->jabatan1 ?? '..........................................................................................................' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%">
                        No. HP Petugas Pentasyarufan
                    </td>
                    <td style="width: 2%">:</td>
                    <td>
                        {{ $data->nohp1 ?? '..........................................................................................................' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%;vertical-align:top">
                        Alamat
                    </td>
                    <td style="width: 2%;vertical-align:top">:</td>
                    <td>
                        {{ $data->alamat1 ?? '..........................................................................................................' }}
                    </td>
                </tr>


                <tr>
                    <td colspan="3">Selanjutnya di sebut <b>PIHAK PERTAMA</b>
                    </td>
                </tr>



                <tr>
                    <td colspan="3" style="height: 0.15cm;"></td>
                </tr>
                <tr>
                    <td style="width: 30%">Nama Lengkap</td>
                    <td style="width: 2%">:</td>
                    <td>
                        {{ $data->nama2 ?? '..........................................................................................................' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%;vertical-align:top">
                        Alamat Lengkap Penerima
                    </td>
                    <td style="width: 2%;vertical-align:top">:</td>
                    <td>
                        {{ $data->alamat2 ?? '..........................................................................................................' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%">
                        No. HP Penerima Manfaat
                    </td>
                    <td style="width: 2%">:</td>
                    <td>
                        {{ $data->nohp2 ?? '..........................................................................................................' }}
                    </td>
                </tr>

                <tr>
                    <td style="width: 30%">Jabatan</td>
                    <td style="width: 2%">:</td>
                    <td>
                        {{ $data->jabatan2 ?? '..........................................................................................................' }}
                    </td>
                </tr>

                <tr>
                    <td colspan="3">Selanjutnya di sebut <b>PIHAK KEDUA</b>
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
                        {{-- {{ \App\Http\Controllers\Helper::getDataKegiatan($data->id_program_kegiatan ?? null)->pluck('nama_program')->first() }} --}}
                        {{ $data->pengajuan_note }}
                        berupa {{ $data->berupa ?? '………' }} senilai Rp
                        {{ $data->senilai ? number_format($data->senilai, 0, '.', '.') : '………' }}
                        dan
                        tugas pentasyarufan dana ZIS NU Care Lazisnu Cilacap kepada <b>PIHAK KEDUA</b>.</td>
                </tr>
                <tr>
                    <td style="width: 5%;vertical-align:top;">2.</td>
                    <td colspan="2" style="text-align: justify;"><b>PIHAK KEDUA</b> menyatakan telah menerima
                        bantuan
                        {{-- {{ \App\Http\Controllers\Helper::getDataKegiatan($data->id_program_kegiatan ?? null)->pluck('nama_program')->first() }} --}}
                        {{ $data->pengajuan_note }}
                        berupa {{ $data->berupa ?? '………' }} senilai Rp
                        {{ $data->senilai ? number_format($data->senilai, 0, '.', '.') : '………' }} dari
                        <b>PIHAK PERTAMA</b>.
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;vertical-align:top;">3.</td>
                    <td colspan="2" style="text-align: justify;">
                        <b>PIHAK PERTAMA</b> berkewajiban menyerahkan berita acara pentasarufan dilampiri : <b>( a.)</b>
                        proposal /
                        pengajuan / berita acara rapat pentasyarufan <b>( b.)</b> foto dokumentasi pentasyarufan
                        <b>(c.)</b> fotokopi
                        identitas penerima manfaat KK atau KTP <b>(d.)</b> nota pembelian barang jika bantuan berupa
                        barang <b>(
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
                <br>
                <table style="width: 100%;page-break-inside: avoid;font-size:11pt;">


                    <tr>
                        <td style="width: 30%;text-align: center;">
                            <b>PIHAK PERTAMA</b><br>
                            Yang menyerahkan<br>
                            {{-- (ttd + stempel) --}}

                        </td>
                        <td style="text-align: center;vertical-align:top">
                            <b>PIHAK KEDUA</b><br>
                            Penerima Manfaat <br>
                            {{-- (ttd) --}}
                        </td>
                        {{-- <td style="width: 33%;text-align: center;vertical-align:top">
                            Diperiksa dan di terima :<br>
                            Pada tanggal
                            {{ $data->tgl_diperiksa ? Carbon\Carbon::parse($data->tgl_diperiksa)->isoFormat('DD-MM-Y') : '........ - ........- 20......' }}

                        </td> --}}
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width:30%;text-align: center">
                            <span style=";text-decoration: underline;">
                                {{-- divisi progam dan aministrasi umum --}}
                                {{-- ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3') ?? '(.........................)' }}) --}}
                                ({{ $data->nama1 ?? '...............................' }})
                            </span>
                            <br>Jabatan : {{ $data->jabatan1 ?? '................' }}
                        </td>
                        <td style="text-align: center">
                            <span style=";text-decoration: underline;">
                                {{-- divisi pentasyarufan --}}
                                {{-- ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'bf9ed4c6-85c2-11ed-a0ac-040300000000') ?? '(.........................)' }}) --}}
                                ({{ $data->nama2 ?? '...............................' }})
                            </span>
                            <br>Jabatan : {{ $data->jabatan2 ?? '................' }}


                        </td>
                        {{-- <td style="width: 33%;text-align: center">
                            <br>

                            <span style=";text-decoration: underline;">
                            
                                ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3') ?? '(.........................)' }})


                            </span>
                            <br>
                            Jabatan : Staf Administrasi & Program
                            NU Care Lazisnu Cilacap
                           

                        </td> --}}
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
                    <td style="width: 30%">Nama Lengkap</td>
                    <td style="width: 2%">:</td>
                    <td>
                        {{ $data->nama2 ?? '..........................................................................................................' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%;vertical-align:top">
                        Alamat Lengkap Penerima
                    </td>
                    <td style="width: 2%;vertical-align:top">:</td>
                    <td>
                        {{ $data->alamat2 ?? '..........................................................................................................' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 30%">
                        No. HP Penerima Manfaat
                    </td>
                    <td style="width: 2%">:</td>
                    <td>
                        {{ $data->nohp2 ?? '..........................................................................................................' }}
                    </td>
                </tr>

                <tr>
                    <td style="width: 30%">Jabatan</td>
                    <td style="width: 2%">:</td>
                    <td>
                        {{ $data->jabatan2 ?? '..........................................................................................................' }}
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
                                        Cilacap,
                                        {{ $data->tgl_berita ? Carbon\Carbon::parse(now())->isoFormat('D MMMM Y') : '...................' }}
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
                                    <span style=";text-decoration: underline;">
                                        {{-- divisi progam dan aministrasi umum --}}
                                        {{-- ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3') ?? '(.........................)' }}) --}}
                                        ({{ $data->nama2 ?? '...............................' }})
                                    </span>

                                </p>

                            </td>
                        </tr>




                    </tbody>


                </table>


            </div>


        </div>



    </body>
</main>


</html>
