<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>


<style>
    @page {
        margin: 0.5cm;
        margin-top: 1cm;
        margin-bottom: 2cm;
        /* padding-bottom: 1.5cm; */
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
        bottom: -1cm;
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
                                <strong><span>PENGAJUAN PENTASYARUFAN UPZIS MWCNU
                                        @if ($data->tingkat == 'Upzis MWCNU')
                                            {{ strtoupper($nama_upzis) }}
                                        @endif
                                        @if ($data->tingkat == 'Ranting NU')
                                            {{ strtoupper($nama_ranting) }}
                                        @endif
                                     
                                    </span></strong>
                            </p>
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>
                                    NO PENGAJUAN : {{ $data->nomor_surat }}
                                    </span></strong>
                            </p>
                            {{-- <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p> --}}

                        </td>
                    </tr>
                </tbody>
            </table>

                            {{-- @foreach ($pilar as $a)
                                <strong>{{ $loop->iteration }}.{{ $a->pilar }}</strong>
                                <br>
                                @php
                                    $etasyaruf = config('app.database_etasyaruf');
                                    $siftnu = config('app.database_siftnu');
                                    $gocap = config('app.database_gocap');
                                    $program = DB::table($etasyaruf . '.program')
                                        ->where('id_program', $a->id_program)
                                        ->get();
                                @endphp
                                @foreach ($program as $b)
                                    {{ $b->program }}
                                    <br>
                                @endforeach
                            @endforeach
                --}}


                <br>

                <table style="width: 100%; font-size: 11pt;">
                    {{-- paragraf 1 --}}
                    <tr>
                        <td style="width: 19%"><b>Total Nominal </b></td>
                        <td style="width: 1%">:</td>
                        <td style="width: 80%">
                            Rp{{ number_format($sum_pencairan, 0, '.', '.') }},-
                        </td>
                    </tr>
        
                    <tr>
                        <td style="width: 19%"><b>Penerima Manfaat</b></td>
                        <td style="width: 1%">:</td>
                        <td style="width: 80%">
                            {{ $sum_penerima }}
                        </td>
                    </tr>
                </table>

            <div class="text-right">
                <span style="font-size: 10pt">{{ $data->nomor_surat }}</span>
            </div>
            <table cellpadding="0" cellspacing="0"
                style="width:100%;border:0.75pt solid #000000;border-collapse:collapse;font-size:10pt;">
                <thead>
                    <tr class="text-center" style="background-color:#cbf2d6; border: 1px solid black;">
                        <td style="width: 4%;vertical-align:middle; border: 1px solid black;"><b>
                                NO</b></td>
                        <td style="width: 24%;vertical-align:middle; border: 1px solid black;"><b>
                                NAMA PROGRAM
                            </b></td>
                        <td style="vertical-align:middle; border: 1px solid black;"><b>
                                SUMBER DANA
                            </b></td>
                        <td style="width: 13%;vertical-align:middle; border: 1px solid black;"><b>
                                TGL KONFIRMASI</td>

                        <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>
                                NOMINAL<br> PENGAJUAN </td>
                        <td style="width: 13%;vertical-align:middle; border: 1px solid black;"><b>
                            TGL TERBIT REKOMENDASI
                            </b></td>
                        <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>
                                NOMINAL <br> PENCAIRAN
                            </b></td>
                        <td style="width: 8%;vertical-align:middle; border: 1px solid black;"><b>
                                PENERIMA MANFAAT
                            </b></td>
                    </tr>
                </thead>




                <tbody>

                    @if (count($program) > 0)
                        @foreach ($program as $pilar => $details)
                            @php
                                $jumlah_nominal_pengajuan = 0;
                                $jumlah_nominal_pencairan = 0;
                                $jumlah_penerima_manfaat = 0;
                            @endphp
                            {{-- foreach menghitung total --}}
                            @foreach ($details as $x)
                                @php
                                    $jumlah_nominal_pengajuan += $x->nominal_pengajuan;
                                    $jumlah_nominal_pencairan += $x->nominal_pencairan;
                                    $jumlah_penerima_manfaat += $x->jumlah_penerima;
                                @endphp
                            @endforeach

                            <tr style="background-color:#cbf2d6;border-bottom: 1px solid black;">
                                <td style="vertical-align:middle;padding-left:3.0mm; " colspan="4">
                                    <b>{{ chr(64 + $loop->iteration) }}. {{ $pilar }} </b>
                                </td>

                                <td class="text-center" style="vertical-align:middle;">
                                    <b>Rp{{ number_format($jumlah_nominal_pengajuan, 0, '.', '.') }},-</b>
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <b>Rp{{ number_format($jumlah_nominal_pencairan, 0, '.', '.') }},-</b>
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <b>{{ $jumlah_penerima_manfaat }}</b>
                                </td>
                            </tr>

                            {{-- foreach data --}}
                            @foreach ($details as $a)
                                <tr>
                                    <td class="text-center"
                                        style=" border: 1px solid black; vertical-align:top;padding-left:7mm;border-right:none">
                                        {{ strtolower(chr(64 + $loop->iteration)) }}.</td>
                                    <td
                                        style="vertical-align:top;border: 1px solid black;padding-right:2mm;border-left:none">
                                        {{ app\Http\Controllers\PrintController::get_nama_program($a->id_program_kegiatan) }}
                                        ({{ $a->pengajuan_note }})
                                        {{-- <br>
                               <span style="display:flex;text-align: justify;">
                                   {{ $a->pengajuan_note }}
                               </span> --}}
                                    </td>
                                    <td style="vertical-align:middle;border: 1px solid black;text-align:center;">
                                        {{ app\Http\Controllers\PrintController::get_nama_bmt($a->id_rekening) }}<br>
                                        ({{ app\Http\Controllers\PrintController::no_rekening($a->id_rekening) }})
                                    </td>
                                    <td class="text-center" style="border: 1px solid black;vertical-align:middle">
                                        {{-- 10 September 2023 --}}

                                        @php
                                        $tgl_konfirmasi = App\Models\Pengajuan::where('id_pengajuan',$a->id_pengajuan)->value('tgl_konfirmasi');
                                        $tgl_terbit_rekomendasi = App\Models\Pengajuan::where('id_pengajuan',$a->id_pengajuan)->value('tgl_terbit_rekomendasi');
                                    @endphp
                                    {{ Carbon\Carbon::parse($tgl_konfirmasi)->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td class="text-center" style="border: 1px solid black;vertical-align:middle;">
                                        Rp{{ number_format($a->nominal_pengajuan, 0, '.', '.') }},-
                                    </td>
                                    <td class="text-center" style="border: 1px solid black;vertical-align:middle;">
                                        {{-- {{ $a->tgl_pencairan != null ? Carbon\Carbon::parse($a->tgl_pencairan)->isoFormat('D MMMM Y') : '-' }} --}}
                                        {{  Carbon\Carbon::parse($tgl_terbit_rekomendasi)->isoFormat('D MMMM Y') }}
                                    </td>
                                    <td class="text-center" style="border: 1px solid black;vertical-align:middle;">
                                        Rp{{ number_format($a->nominal_pencairan, 0, '.', '.') }},-
                                    </td>
                                    <td class="text-center" style="border: 1px solid black;vertical-align:middle;">
                                        {{ $a->jumlah_penerima ?? '0' }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="8"
                                style=" border: 1px solid black; vertical-align:top;padding-left:7mm;">
                                Tidak Ada Data</td>
                        </tr>
                    @endif


                </tbody>
            </table>

        </body>
    </div>
    {{-- end rencana --}}



</main>




</html>
