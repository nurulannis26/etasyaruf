<!DOCTYPE html>
<html>

<head>
    <title>REKAP PENGAJUAN PENTASYARUFAN TINGKAT INTERNAL LAZISNU CILACAP {{ strtoupper($bulans) }} {{ $tahun }}
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>


<style>
    @page {
        margin: 0.5cm;
    }

    header {
        /* position: fixed; */
        margin-top: -0.1cm;
        left: 0cm;
        right: 0cm;
        height: 1cm;
        text-align: center;
    }

    footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 1cm;
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
                <em>Dicetak
                    {{ Carbon\Carbon::parse(now())->isoFormat('D MMMM Y') . ' ' . Carbon\Carbon::parse(now())->format('H:i:s') . ' ' }}

                </em>
            </p>

        </div>

    </div>
</footer>

<main>

    {{-- RENCANA --}}
    <div>
        <header>
            <table style="width:100%">
                <tr>
                    <td style="width:33%" class="text-left"><img src="{{ public_path('/images/gocap.png') }}"
                            width="76" height="76" style="margin: 0 auto 0 0; display: block; "></td>
                    <td style="width:33%" class="text-center"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                            width="146" height="76" style="margin: 0 auto; display: block; "></td>
                    <td style="width:33%" class="text-right"><img src="{{ public_path('/images/siftnu.png') }}"
                            width="146" height="76" style="margin: 0 0 0 auto; display: block; "></td>
                </tr>
            </table>
        </header>

        <body>
            <table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;">
                <tbody>
                    <tr>
                        <td colspan="5" style="100%; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0.8cm; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>REKAP PENGAJUAN PENTASYARUFAN TINGKAT INTERNAL LAZISNU CILACAP
                                    </span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>
                                        PERIODE {{ strtoupper($bulans) }} {{ $tahun }}
                                    </span></strong>
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
                    <td style="width: 12%"> <b>Tingkat Pentasyarufan</b></td>
                    <td style="width: 1%"> :</td>
                    <td style="width: 60%">
                        {{ $tingkat }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 12%"> <b>Status Pentasyarufan</b></td>
                    <td style="width: 1%">:</td>
                    <td style="width: 60%">
                        {{ $status }}
                    </td>
                </tr>


                <tr>
                    <td style="width: 12%"> <b>Tujuan</b></td>
                    <td style="width: 1%">:</td>
                    <td style="width: 60%">
                        @if ($tujuan == 'Semua')
                            Semua
                        @else
                            {{ $tujuan }}
                        @endif
                    </td>
                </tr>


            </table>

            <br>

            <table cellpadding="0" cellspacing="0"
                style="width:100%;border:0.75pt solid #000000;border-collapse:collapse;font-size:10pt;">
                <thead>
                    <tr class="text-center" style=" border: 1px solid black;font-weight:bold;background-color:#cbf2d6">
                        <td style="width: 3%;vertical-align:middle; border: 1px solid black;">
                            NO</td>
                        <td style="width: 23%;vertical-align:middle; border: 1px solid black;">
                            PENGAJUAN
                        </td>
                        <td style="width: 8%;vertical-align:middle; border: 1px solid black;">
                            BENTUK <br> PENCAIRAN
                        </td>

                        <td style="width: 11%;vertical-align:middle; border: 1px solid black;">
                            NOMINAL PENGAJUAN</td>
                        <td style="width: 11%;vertical-align:middle; border: 1px solid black;">
                            NOMINAL DISETUJUI</td>
                        <td style="width: 10%;vertical-align:middle; border: 1px solid black;">
                            TGL <br> TENGGAT <br>
                        </td>
                        <td style="width: 10%;vertical-align:middle; border: 1px solid black;">
                            TGL <br> PENGAJUAN <br>
                        </td>
                        <td style="width: 20%;vertical-align:middle; border: 1px solid black;">
                            YANG MENGAJUKAN<br>
                        </td>

                    </tr>
                </thead>

                <tbody>


                    @php
                        $total_nominal_pengajuan = 0;
                        $total_nominal_disetujui = 0;
                        
                    @endphp

                    @foreach ($data as $b)
                        @php
                            
                            $nominal_pengajuan = App\Http\Controllers\PrintPengajuanController::internal_hitung_nominal_pengajuan($b->id_internal);
                            $nominal_disetujui = App\Http\Controllers\PrintPengajuanController::internal_hitung_nominal_pengajuan_disetujui($b->id_internal);
                            $total_nominal_pengajuan += $nominal_pengajuan;
                            $total_nominal_disetujui += $nominal_disetujui;
                            
                        @endphp

                        <tr>
                            <td class="text-center" style="vertical-align:top; border: 1px solid black;">
                                {{ $loop->iteration }}</td>
                            <td style="vertical-align:top;border: 1px solid black;padding-left:2mm">
                                {{ $b->nomor_surat }}
                            </td>
                            <td style="vertical-align:top;border: 1px solid black;padding-left:1mm;text-align:center">
                                {{ $b->bentuk }}
                            </td>


                            <td style="border: 1px solid black;padding-left:1mm;padding-right:1mm;vertical-align: top;">
                                <span>Rp</span>
                                <span style="float:right;">
                                    {{ number_format($nominal_pengajuan, 0, '.', '.') }},-</span>

                            </td>
                            <td style="border: 1px solid black;padding-left:1mm;padding-right:1mm;vertical-align: top;">
                                <span>Rp</span>
                                <span style="float:right;">
                                    {{ number_format($nominal_disetujui, 0, '.', '.') }},-</span>
                            </td>
                            <td class="text-center" style="border: 1px solid black;vertical-align:top;">
                                {{ Carbon\Carbon::parse($b->tgl_tenggat)->isoFormat('D MMMM Y') }}
                            </td>

                            <td class="text-center" style="border: 1px solid black;vertical-align:top;">
                                {{ Carbon\Carbon::parse($b->tgl_pengajuan)->isoFormat('D MMMM Y') }}
                            </td>
                            <td class="text-center" style="border: 1px solid black;vertical-align:top;">
                                {{ App\Http\Controllers\PrintPengajuanController::nama_pengurus_pc($b->maker_tingkat_pc) }}
                            </td>
                        </tr>
                    @endforeach





                    <tr style="background-color:#cbf2d6;border-bottom: 1px solid black;">
                        <td colspan="2" style="padding-left: 2mm;"><b> TOTAL </b></td>
                        <td style="padding-left: 1mm;text-align:center"><b> </b></td>

                        <td style="padding-left: 1mm;vertical-align: top;">
                            <span><b>Rp</b></span>
                            <span style="float:right;">
                                <b>
                                    {{ number_format($total_nominal_pengajuan, 0, '.', '.') }},-</b></span>
                        </td>
                        <td style="padding-left: 1mm;vertical-align: top;">
                            <span><b>Rp</b></span>
                            <span style="float:right;">
                                <b>
                                    {{ number_format($total_nominal_disetujui, 0, '.', '.') }},-</b></span>

                        </td>
                        <td colspan="3" style="padding-left: 2mm;"><b> </b></td>

                    </tr>



                </tbody>

            </table>







        </body>
    </div>
    {{-- end rencana --}}


</main>




</html>
