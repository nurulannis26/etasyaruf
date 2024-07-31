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


<head>
    <title>{{ str_replace('/', '_', $data->nomor_surat) . '_KWITANSI_PENCAIRAN_UMUM' }}</title>
</head>



<style>
    body {
        font-family: Arial, sans-serif;
        /* Gunakan Arial jika tidak tersedia, gunakan font sans-serif sebagai alternatif */
        font-size: 12pt;
    }
</style>

<br>
<br>


<body>
    {{-- kertas kwitansi --}}
    <div style="clear: both; ">




        <table
            style="width:100%; height: 6cm; background-color:#E2EFD9; font-size:10pt; position: relative;page-break-inside: avoid;">

            <tr>
                <td style="width:10%;vertical-align:top;text-align:center;padding-top:3mm">
                    <img src="{{ public_path('/images/logo_lazisnu2.png') }}" width="110" height="60"
                        style="margin: 0 auto; display: block; ">
                </td>
                <td style="width:55%;vertical-align:top;padding:2mm;text-align:left" colspan="3">
                    <span style="font-size:13pt">
                        <b> KUITANSI DIVISI KEUANGAN</b>
                    </span>
                    <br>
                    <span style="font-size:12pt">
                        NU CARE-LAZISNU CILACAP
                    </span>
                    <br>
                    <span style="font-size:8pt">
                        Alamat: Jalan Masjid No. 9 Kelurahan Sidanegara Kecamatan Cilacap Tengah Cp: 081228221010
                    </span>
                    <hr>
                </td>
                <td style="width: 5%;">
                </td>
            </tr>

            <tr>

                {{-- <td style="width:25%;vertical-align:top;padding-left:30pt">
                    No. Kwitansi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                </td> --}}
                <td style="width:20%;">

                </td>
                <td style="width:55%;vertical-align: top; text-align: right; position: relative; text-transform: uppercase;"
                    colspan="3"><span class="custom-text">
                        @if ($data_det->pencairan_status == 'Berhasil Dicairkan')
                            <b>{{ $data_det->nomor_kwitansi_pencairan }}</b>
                        @else
                            -
                        @endif
                    </span>

                </td>

            </tr>

            <tr>

                <td style="width:25%;vertical-align:top;padding-left:30pt">
                    Telah terima dari &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                </td>
                <td style="width:55%;vertical-align: top; text-align: left; position: relative;" colspan="3"><span
                        class="custom-text">
                        @if ($data_det->pencairan_status == 'Berhasil Dicairkan')
                            NU CARE LAZISNU CILACAP
                        @else
                            -
                        @endif
                    </span>

                </td>
                <td style="width:5%;">

                </td>
            </tr>


            <tr>

                <td style="width:25%;vertical-align:top;padding-left:30pt">
                    Uang sejumlah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                </td>
                <td id="custom-cell" style="vertical-align: top; text-align: left; position: relative;" colspan="3">
                    <span>
                        {{ terbilang($data_det->nominal_pencairan) }}
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
                    @if ($data_det->pencairan_status == 'Berhasil Dicairkan')
                        {{ $data_det->pengajuan_note }}
                    @else
                        -
                    @endif



                </td>


                <td style="width: 5%;">

                </td>
            </tr>
            <br>

            <tr>

                <td colspan="3" style="text-align:center;padding-right:50pt;">

                </td>
                <td style="text-align:center">
                    Cilacap,
                    {{ $data_det->tgl_pencairan ? Carbon\Carbon::parse($data_det->tgl_pencairan ?? null)->isoFormat('D MMM YYYY') : '...............' }}
                </td>
                <td></td>
            </tr>

            <tr>
                <td style="width:40%;vertical-align:top;padding-left:30pt" colspan="2">

                    <div style="padding-left:2mm; border-top: 1px solid black;border-bottom: 1px solid black; ">

                        @if ($data_det->pencairan_status == 'Berhasil Dicairkan')
                            Rp {{ number_format($data_det->nominal_pencairan ?? 0, 0, '.', '.') }}
                        @else
                            Rp 0
                        @endif
                    </div>

                </td>

                @php
                    $ttd_keuangan = App\Http\Controllers\PrintController::ttd($data_det->staf_keuangan_pc);
                    $ttd_pemohon = App\Http\Controllers\PrintController::ttd($data_det->dicairkan_kepada);
                @endphp

                <style>
                    .capitalized {
                        text-transform: capitalize;
                    }
                </style>

                <td style="width: 30%;text-align:center;vertical-align:top">
                    Yang menerima
                    <br>
                    {{-- {{ dd($ttd_keuangan) }} --}}

                    @if ($data_det->pencairan_status == 'Berhasil Dicairkan' and $data_det->terima_kwitansi == '1')
                        <div class="tanda-tangan">
                            <img style="margin-left: 5px"
                                src="https://gocapv2.nucarecilacap.id/uploads/user/{{ $ttd_pemohon }}"
                                alt="Tanda tangan" width="100" height="50">
                        </div>
                    @else
                        <br>
                        <br>
                        <br>
                    @endif

                    @if ($data_det->pencairan_status == 'Berhasil Dicairkan')
                       ({{ ucwords(strtolower(App\Http\Controllers\PrintController::nama_pengurus_pc($data_det->dicairkan_kepada))) }})
                    @else
                        (..............)
                    @endif
                </td>

                <style>
                    .tanda-tangan {
                        background-color: transparent;
                        mix-blend-mode: multiply;
                        /* atau gunakan 'screen' */
                    }
                </style>
                <td style="width: 20%;text-align:center;vertical-align:top">
                    Yang menyerahkan
                    <br>

                    @if ($data_det->pencairan_status == 'Berhasil Dicairkan')
                        <div class="tanda-tangan">
                            <img style="margin-left: 5px"
                                src="https://gocapv2.nucarecilacap.id/uploads/user/{{ $ttd_keuangan }}"
                                alt="Tanda tangan" width="100" height="50">
                             <img style="margin-left: 5px; position: absolute; margin-top: 0px; left:73%" src="{{ asset('images/stempel_keuangan.png') }}" alt="Stempel" width="100" height="50">
                            
                        </div>
                    @else
                        <br>
                        <br>
                        <br>
                    @endif

                    @if ($data_det->pencairan_status == 'Berhasil Dicairkan')
                        ({{ App\Http\Controllers\PrintController::nama_pengurus_pc($data_det->staf_keuangan_pc) }})
                    @else
                        (..............)
                    @endif
                    <br>
                    <br>

                </td>
            </tr>


        </table>
        <br>


    </div>


</body>
