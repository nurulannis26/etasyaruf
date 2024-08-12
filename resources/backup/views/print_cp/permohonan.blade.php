<!DOCTYPE html>
<html>

<head>
    <title>Form Rekomendasi Pencairan Pentasyarufan</title>
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
        <div style="clear:both;color:#9d9d9d" class="text-left">
            <p style="margin-top:48pt;font-size:10pt;">*Setelah ditandatangani dan distempel, scan lalu upload melalui
                E-Tasyaruf.</p>
        </div>
        <div style="clear:both;color:#9d9d9d">
            <p
                style="margin-top:-20pt; margin-bottom:0pt; text-align:right; line-height:normal; border-bottom:2.25pt double #000000; padding-bottom:1pt; font-size:10pt;">
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

<header>
    <table style="width:100%">
        <tr>
            <td style="width:33%" class="text-left"><img src="{{ public_path('/images/gocap.png') }}" width="76"
                    height="76" style="margin: 0 auto 0 0; display: block; "></td>
            <td style="width:33%" class="text-center"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                    width="146" height="76" style="margin: 0 auto; display: block; "></td>
            <td style="width:33%" class="text-right"><img src="{{ public_path('/images/siftnu.png') }}" width="146"
                    height="76" style="margin: 0 0 0 auto; display: block; "></td>
        </tr>
    </table>
</header>

<main>

    <body>
        <div>
            <table cellpadding="0" cellspacing="0" style="width:531.6pt; border-collapse:collapse;">
                <tbody>
                    <tr>
                        <td colspan="5"
                            style="width:520.8pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>PERMOHONAN REKOMENDASI PENCAIRAN PENTASYARUFAN GERAKAN KOIN
                                        NU</span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>
                                        DITUJUKAN
                                        KEPADA NU CARE LAZISNU {{ $nama_pc }}</span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>TINGKAT
                                        {{ $data->tingkat == 'Upzis MWCNU'
                                            ? 'UPZIS MWCNU ' . strtoupper($nama_upzis)
                                            : ($data->tingkat == 'Ranting NU'
                                                ? 'PRNU ' . strtoupper($nama_ranting)
                                                : '') }}

                                    </span></strong>
                            </p>
                        </td>
                    </tr>
                    <br>
                </tbody>
            </table>

            <table style="width: 100%;font-size:11pt;">
                <tr>
                    <td style="width: 50%"> <b>Permohonan Untuk</b></td>
                    <td style="width: 2%"> :</td>
                    <td style="width: 60%">
                        {{ $data->tingkat == 'Upzis MWCNU'
                            ? 'UPZIS MWCNU ' . $nama_upzis
                            : ($data->tingkat == 'Ranting NU'
                                ? 'PRNU ' . $nama_ranting
                                : '') }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%"> <b>Tanggal Input Pengajuan</b></td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%"> {{ Carbon\Carbon::parse($data->created_at)->isoFormat('D MMMM Y') }}
                    </td>
                </tr>

                <tr style="vertical-align: top;">
                    <td style="width: 50%"> <b>Nomor Surat Permohonan Rekomendasi</b></td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">{{ $data->nomor_surat }}</td>
                </tr>

                <tr>
                    <td colspan="3" style="height: 0.15cm;"></td>
                </tr>
                <tr>
                    <td colspan="3">Yang bertandatangan dibawah ini</td>
                </tr>
                @if ($data->tingkat == 'Upzis MWCNU')
                    <tr>
                        <td style="width: 50%">Nama</td>
                        <td style="width: 2%">:</td>
                        <td style="width: 60%">
                            {{-- ketua upzis --}}
                            {{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'c699f7c7-7791-11ed-97ee-e4a8df91d8b3') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%">Jabatan</td>
                        <td style="width: 2%">:</td>
                        <td style="width: 60%"> Ketua UPZIS MWCNU {{ $nama_upzis }}
                        </td>
                    </tr>
                @endif
                @if ($data->tingkat == 'Ranting NU')
                    <tr>
                        <td style="width: 50%">Nama</td>
                        <td style="width: 2%">:</td>
                        <td style="width: 60%">
                            {{-- koordinator --}}
                            {{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('ranting', $data->id_ranting, 'f3baf470-3a29-11ed-a757-e4a8df91d887') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%">Jabatan</td>
                        <td style="width: 2%">:</td>
                        {{-- <td style="width: 60%"> Ketua PRNU {{ $nama_ranting }} --}}
                        <td style="width: 60%"> Koordinator PLPK
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3">Dengan ini bermaksud memohon rekomendasi pencairan pentasyarufan Koin NU untuk :
                    </td>
                </tr>
                @if ($data->tingkat == 'Upzis MWCNU')
                    <tr>
                        <td style="width: 50%">UPZIS MWCNU</td>
                        <td style="width: 2%">:</td>
                        <td style="width: 60%"><b>{{ $nama_upzis }}</b></td>
                    </tr>
                @endif
                @if ($data->tingkat == 'Ranting NU')
                    <tr>
                        <td style="width: 50%">PRNU</td>
                        <td style="width: 2%">:</td>
                        <td style="width: 60%"><b>{{ $nama_ranting }}</b></td>
                    </tr>
                @endif
                <tr>
                    <td style="width: 50%">Sebesar</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        <b>
                            Rp{{ number_format($jumlah_nominal_a + $jumlah_nominal_b + $jumlah_nominal_c, 0, '.', '.') }}</b>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;vertical-align: up;">Penggunaan dana untuk</td>
                    <td style="width: 2%;vertical-align: up;">:</td>
                    <td style="width: 60%">
                        @if ($data->tingkat == 'Upzis MWCNU')
                            1. Kelembagaan (Rp{{ number_format($jumlah_nominal_a, 0, '.', '.') }}) <br>
                            2. Sosial (Rp{{ number_format($jumlah_nominal_b, 0, '.', '.') }})<br>
                            3. Operasional UPZIS (Rp{{ number_format($jumlah_nominal_c, 0, '.', '.') }})
                        @endif
                        @if ($data->tingkat == 'Ranting NU')
                            1. Kelembagaan (Rp{{ number_format($jumlah_nominal_a, 0, '.', '.') }}) <br>
                            2. Sosial (Rp{{ number_format($jumlah_nominal_b, 0, '.', '.') }})<br>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3">Dengan penanggung jawab pengambilan dana
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">Nama Lengkap</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $data->pj_upzis) }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $data->pj_ranting) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">Alamat Lengkap</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getAlamatPengurus('upzis', $data->pj_upzis) }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getAlamatPengurus('ranting', $data->pj_ranting) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">No. Telp</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getNohpPengurus('upzis', $data->pj_upzis) }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getNohpPengurus('ranting', $data->pj_ranting) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">Jabatan</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getJabatanPengurus('upzis', $data->pj_upzis) }}
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getJabatanPengurus('ranting', $data->pj_ranting) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: justify;">

                        @if ($data->tingkat == 'Upzis MWCNU')
                            Penanggung jawab pengambilan dana ini merupakan
                            pengelola rekening Koin NU untuk
                            {{ $nama_upzis }}, untuk selanjutnya penanggungjawab pengelolaan dan pelaporan penggunaan
                            dana Koin NU yang diambil menjadi tanggung jawab yang bersangkutan dan {{ $nama_upzis }}.
                        @endif
                        @if ($data->tingkat == 'Ranting NU')
                            Penanggung jawab pengambilan dana ini merupakan
                            pengelola rekening Koin NU untuk
                            {{ $nama_ranting }}, untuk selanjutnya penanggungjawab pengelolaan dan pelaporan penggunaan
                            dana Koin NU yang diambil menjadi tanggung jawab yang bersangkutan dan {{ $nama_ranting }}
                            dengan pembinaan dari {{ $nama_upzis }}.
                        @endif
                    </td>
                </tr>
            </table>

            <br>

            {{-- ttd --}}
            <table style="width: 100%">
                @if ($data->tingkat == 'Upzis MWCNU')
                    <tr>
                        <td colspan="3" style="text-align: center;">
                            <b>UPZIS MWCNU {{ strtoupper($nama_upzis) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;text-align: center;"><b>Ketua </b></td>
                        <td style="width: 50%;text-align: center;"><b>Anggota Bidang Keuangan</b></td>
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width: 50%;text-align: center;">
                            {{-- ketua upzis --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'c699f7c7-7791-11ed-97ee-e4a8df91d8b3') }})
                        </td>
                        <td style="width: 50%;text-align: center;">
                            {{-- bednahara upzis --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, '8eb03fef-5a7c-11ed-9dd2-e4a8df91d8b3') }})
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;">Mengetahui,
                            <br>
                            <b>
                                MWCNU {{ strtoupper($nama_upzis) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;text-align: center;"><b>Rois Syuriyah
                            </b></td>
                        <td style="width: 50%;text-align: center;"><b>Ketua Tanfidziniyah
                            </b></td>
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width: 50%;text-align: center;">
                            {{-- rois syuriah mwcnu --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'cde81b00-9641-11ed-a0ac-040300000000') }})

                        </td>
                        <td style="width: 50%;text-align: center;">
                            {{-- Ketua Tanfidziyah MWCNU --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'd3c6a73c-9641-11ed-a0ac-040300000000') }})

                        </td>
                    </tr>
                @endif


                @if ($data->tingkat == 'Ranting NU')
                    <tr>
                        <td colspan="3" style="text-align: center;"><b>GERAKAN KOTAK INFAQ NAHDLATUL ULAMA CILACAP
                                <br>
                                RANTING {{ strtoupper($nama_ranting) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;text-align: center;"><b>Koordinator PLPK</b></td>
                        <td style="width: 50%;text-align: center;"><b>Bendahara Koin NU</b></td>
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width: 50%;text-align: center;">
                            {{-- koordinator plpk --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('ranting', $data->id_ranting, 'f3baf470-3a29-11ed-a757-e4a8df91d887') }})
                        </td>
                        <td style="width: 50%;text-align: center;">
                            {{-- bendahara koin nu --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('ranting', $data->id_ranting, 'a979c8ab-2aa0-11ee-b013-c97905ab4d7f') }})
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;">Mengetahui,<br>
                            <b>
                                MAJELIS WAKIL CABANG NAHDLATUL ULAMA MWCNU
                                {{ strtoupper($nama_upzis) }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%;text-align: center;"><b>Ketua Tanfidziyah</b></td>
                        <td style="width: 50%;text-align: center;"><b>Ketua UPZIS MWCNU</b></td>
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width: 50%;text-align: center;">
                            {{-- Ketua Tanfidziyah --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'd3c6a73c-9641-11ed-a0ac-040300000000') }})
                        </td>

                        <td style="width: 50%;text-align: center;">
                            {{-- Ketua UPZIS MWCNU  --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'c699f7c7-7791-11ed-97ee-e4a8df91d8b3') }})
                        </td>
                    </tr>
                @endif
            </table>

        </div>
    </body>
</main>


</html>
