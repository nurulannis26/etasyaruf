<!DOCTYPE html>
<html>

<head>
    <title>
        @if ($data->status_rekomendasi == 'Sudah Terbit')
            {{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI' }}
        @else
            {{ str_replace('/', '_', $data->nomor_surat) . '_REKOMENDASI(PREVIEW)' }}
        @endif
    </title>
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
                                <strong><span>REKOMENDASI PENCAIRAN PENTASYARUFAN GERAKAN KOIN
                                        NU</span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>
                                        DITUJUKAN
                                        KEPADA MITRA {{ $tipe == 'bmt' ? 'BMT' : 'BANK' }}
                                    </span></strong>
                            </p>
                        </td>
                    </tr>
                    <br>
                </tbody>
            </table>

            <table style="width: 100%;font-size:11pt;">
                {{-- paragraf 1 --}}
                <tr>
                    <td style="width: 50%"> <b>Rekomendasi Untuk</b></td>
                    <td style="width: 2%"> :</td>
                    <td style="width: 60%">
                        @if ($data->tingkat == 'Upzis MWCNU')
                            UPZIS MWCNU {{ App\Http\Controllers\Helper::getNamaUpzis($data->id_upzis) }}
                        @else
                            RANTING NU {{ App\Http\Controllers\Helper::getNamaRanting($data->id_ranting) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%"> <b>Tanggal Input Pengajuan</b></td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        {{ Carbon\Carbon::parse($data->created_at)->isoFormat('D MMMM Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%"> <b>Tanggal Dikeluarkan Rekomendasi</b></td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        {{ $data->tgl_terbit_rekomendasi ? Carbon\Carbon::parse($data->tgl_terbit_rekomendasi)->isoFormat('D MMMM Y') : '-' }}
                    </td>
                </tr>
                <tr style="vertical-align: top;">
                    <td style="width: 50%"> <b>Nomor Surat Rekomendasi</b></td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        @if ($tipe == 'bmt')
                            {{ $data->no_rekom_bmt ?? '-' }}
                        @elseif($tipe == 'bri')
                            {{ $data->no_rekom_bri ?? '-' }}
                        @endif
                    </td>
                </tr>

            </table>


            {{-- paragraf 2 --}}
            <table style="width: 100%;font-size:11pt;">
                <tr>
                    <td colspan="3">Yang bertandatangan dibawah ini</td>
                </tr>
                <tr>
                    <td style="width: 5%;text-align:center;">1.</td>
                    <td style="width: 45%">Nama</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        {{-- ketua pengurus harian --}}
                        {{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, 'c0e0faee-3590-11ed-9a47-e4a8df91d887') }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;text-align:center;"></td>
                    <td style="width: 45%">Jabatan</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%"> Ketua Pengurus Harian

                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;text-align:center;">2.</td>
                    <td style="width: 45%">Nama</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        {{-- direktur --}}
                        {{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3') }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;text-align:center;"></td>
                    <td style="width: 45%">Jabatan</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%"> Direktur Eksekutif
                    </td>
                </tr>

            </table>
            {{-- end paragraf 2 --}}

            {{-- paragraf 3 --}}
            <table style="width: 100%;font-size:11pt;">
                <tr>
                    <td colspan="3">Dengan ini menyetujui dan memberikan rekomendasi pencairan pentasyarufan untuk :
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%">Pemohon</td>
                    <td style="width: 2%">:</td>
                    <td style="width: 60%">
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $data->pj_upzis) }}
                        @endif
                        @if ($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $data->pj_ranting) }}
                        @endif
                    </td>
                </tr>
                @if ($tipe == 'bmt')
                    <tr>
                        <td style="width: 50%;vertical-align:top;"> Sumber Dana </td>
                        <td style="width: 2%;vertical-align:top;">:</td>
                        <td style="width: 60%"><b>
                                {{-- @foreach ($rekening as $a)
                                    {{ App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('nama_rekening')->first() ?? null }}
                                    <br>
                                    {{ App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('no_rekening')->first() ?? null }}
                                    {{ App\Http\Controllers\Helper::getDataRekening2($a->id_rekening ?? null)->pluck('nama_bmt')->first() ?? null }}<br>
                                @endforeach --}}
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    BMT - UPZIS MWCNU
                                    {{ App\Http\Controllers\Helper::getNamaUpzis($data->id_upzis) }}
                                @elseif($data->tingkat == 'Ranting NU')
                                    BMT - PRNU
                                    @foreach (App\Http\Controllers\Helper::getArrayRekening($data->id_pengajuan) as $a)
                                        {{ App\Http\Controllers\Helper::getNamaRanting($data->id_ranting) }}
                                        ({{ App\Http\Controllers\Helper::getNoRekening($a->id_rekening) }})
                                    @endforeach
                                @endif
                            </b></td>
                    </tr>
                @endif
                @if ($tipe == 'bri')
                    <tr>
                        <td style="width: 50%;vertical-align:top;"> Sumber Dana </td>
                        <td style="width: 2%;vertical-align:top;">:</td>
                        <td style="width: 60%"><b>
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    BRI - UPZIS MWCNU
                                    {{ App\Http\Controllers\Helper::getNamaUpzis($data->id_upzis) }}
                                @elseif($data->tingkat == 'Ranting NU')
                                    BRI - PRNU
                                    {{ App\Http\Controllers\Helper::getNamaRanting($data->id_ranting) }}
                                @endif
                            </b>
                        </td>
                    </tr>
                @endif


                <tr>
                    <td style="width: 50%;vertical-align: up;"></td>
                    <td style="width: 2%;vertical-align: up;"></td>
                    <td style="width: 60%">
                        @if ($data->tingkat == 'Upzis MWCNU')
                            @if ($tipe == 'bmt')
                                Kelembagaan
                                ({{ App\Http\Controllers\PrintController::getDataRekening3('upzis', $tipe, $data->id_upzis, 'LEMBAGA')->pluck('no_rekening')->first() ?? null }})
                                <br>
                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram($tipe, $data->id_pengajuan, 'LEMBAGA'), 0, '.', '.') }}
                                </b>
                                <br>
                                Sosial
                                ({{ App\Http\Controllers\PrintController::getDataRekening3('upzis', $tipe, $data->id_upzis, 'SOSIAL')->pluck('no_rekening')->first() ?? null }})<br>
                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram($tipe, $data->id_pengajuan, 'SOSIAL'), 0, '.', '.') }}</b>
                                <br>
                                Operasional
                                ({{ App\Http\Controllers\PrintController::getDataRekening3('upzis', $tipe, $data->id_upzis, 'OPERASIONAL')->pluck('no_rekening')->first() ?? null }})<br>
                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram($tipe, $data->id_pengajuan, 'OPERASIONAL'), 0, '.', '.') }}</b><br>
                            @elseif($tipe == 'bri')
                                Kelembagaan
                                ({{ App\Http\Controllers\PrintController::getDataRekening3('upzis', $tipe, $data->id_upzis, 'LEMBAGA')->pluck('no_rekening')->first() ?? null }})
                                <br>
                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram($tipe, $data->id_pengajuan, 'LEMBAGA'), 0, '.', '.') }}
                                </b>
                                <br>
                                Sosial
                                ({{ App\Http\Controllers\PrintController::getDataRekening3('upzis', $tipe, $data->id_upzis, 'SOSIAL')->pluck('no_rekening')->first() ?? null }})<br>
                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram($tipe, $data->id_pengajuan, 'SOSIAL'), 0, '.', '.') }}</b>
                                <br>
                                Operasional
                                ({{ App\Http\Controllers\PrintController::getDataRekening3('upzis', $tipe, $data->id_upzis, 'OPS')->pluck('no_rekening')->first() ?? null }})<br>
                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram($tipe, $data->id_pengajuan, 'OPS'), 0, '.', '.') }}</b><br>
                            @endif
                            {{-- @endif --}}
                        @endif
                        @if ($data->tingkat == 'Ranting NU')
                            @if ($tipe == 'bmt')
                                Kelembagaan
                                <br>
                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram2($tipe, $data->id_pengajuan, 'ba84d782-81a8-11ed-b4ef-dc215c5aad51'), 0, '.', '.') }}
                                </b>
                                <br>
                                Sosial
                                <br>
                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram2($tipe, $data->id_pengajuan, 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51'), 0, '.', '.') }}</b>
                                <br>
                            @elseif($tipe == 'bri')
                                Kelembagaan
                                ({{ App\Http\Controllers\PrintController::getDataRekening3('ranting', $tipe, $data->id_ranting, 'LEMBAGA')->pluck('no_rekening')->first() ?? null }})
                                <br>
                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram($tipe, $data->id_pengajuan, 'LEMBAGA'), 0, '.', '.') }}
                                </b>
                                <br>
                                Sosial
                                ({{ App\Http\Controllers\PrintController::getDataRekening3('ranting', $tipe, $data->id_ranting, 'SOSIAL')->pluck('no_rekening')->first() ?? null }})<br>

                                <b>
                                    Rp{{ number_format(App\Http\Controllers\PrintController::sumTotalByProgram($tipe, $data->id_pengajuan, 'SOSIAL'), 0, '.', '.') }}</b>
                                <br>
                            @endif
                        @endif

                    </td>
                </tr>

            </table>
            {{-- end paragraf 3 --}}

            {{-- paragraf 4 --}}
            <table style="width: 100%;font-size:11pt;">
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
                        @endif
                        @if ($data->tingkat == 'Ranting NU')
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
                        @endif
                        @if ($data->tingkat == 'Ranting NU')
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
                        @endif
                        @if ($data->tingkat == 'Ranting NU')
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
                        @endif
                        @if ($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getJabatanPengurus('ranting', $data->pj_ranting) }}
                        @endif

                    </td>
                </tr>

            </table>
            {{-- end paragraf 4 --}}

            {{-- paragraf 2 --}}
            <table style="width: 100%;font-size:11pt;">

                <tr>
                    <td style="width: 5%;vertical-align:top;text-align:center;">I.</td>
                    <td style="width: 95%;text-align:justify;">Berdasarkan surat pengajuan rekomendasi, penanggung
                        jawab
                        pengambilan dana
                        ini merupakan pengelola rekening Koin NU pada UPZIS MWCNU tersebut, untuk selanjutnya
                        tanggungjawab pengelolaan dan pelaporan penggunaan dana Koin NU yang diambil menjadi kewajiban
                        dan tanggung jawab yang bersangkutan dan UPZIS MWCNU tersebut</td>
                </tr>
                <tr>
                    <td style="width: 5%;vertical-align:top;text-align:center;">II.</td>
                    <td style="width: 95%;text-align:justify;">Rekomendasi ini menjadi dasar mitra NU CARE LAZISNU
                        Cilacap untuk mencairkan dana pentasrufan Koin NU hak UPZIS MWCNU yang sudah melaksanakan
                        program Koin NU.</td>
                </tr>


            </table>
            {{-- end paragraf 2 --}}
            <br>

            {{-- ttd --}}
            <div>

                <table style="width: 100%">

                    <tr>
                        <td style="width: 50%;text-align: center;">Mengetahui</td>
                        <td style="width: 50%;text-align: center;">Menyetujui</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;text-align: center;"><b>Ketua NU Care Lazisnu Cilacap</b></td>
                        <td style="width: 50%;text-align: center;"><b>Direktur NU Care Lazisnu Cilacap</b></td>
                    </tr>

                    @if ($data->status_rekomendasi == 'Sudah Terbit')
                        <tr>
                            <td style="width: 50%;text-align: center;"><img
                                    src="{{ public_path('images/ttd/wasbah.jpg') }}" alt="" width="100px">
                            </td>
                            <td style="width: 50%;text-align: center;"><img
                                    src="{{ public_path('images/ttd/fauzi.jpg') }}" alt="" width="100px">
                            </td>
                        </tr>
                    @else
                        <br>
                        <br>
                        <br>
                    @endif

                    <tr>
                        <td style="width: 50%;text-align: center;">
                            {{-- ketua pengurus harian --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, 'c0e0faee-3590-11ed-9a47-e4a8df91d887') }})

                        </td>
                        <td style="width: 50%;text-align: center;">
                            {{-- direktur --}}
                            (
                            {{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3') }})

                        </td>
                    </tr>

                    @if ($data->status_rekomendasi == 'Sudah Terbit')
                        @if ($data->tingkat == 'Upzis MWCNU')
                            <div
                                style=" position: absolute;
                    padding-top:11.5cm;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);">
                                <img src="{{ public_path('images/ttd/stempel.png') }}" alt=""
                                    width="180px">
                            </div>
                        @elseif($data->tingkat == 'Ranting NU')
                            <div
                                style=" position: absolute;
                padding-top:10.5cm;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);">
                                <img src="{{ public_path('images/ttd/stempel.png') }}" alt=""
                                    width="180px">
                            </div>
                        @endif
                    @endif




                </table>
                {{-- end ttd --}}

            </div>

        </div>
    </body>
</main>


</html>
