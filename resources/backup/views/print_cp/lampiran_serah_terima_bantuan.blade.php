<!DOCTYPE html>
<html>

<head>
    {{-- <title>Berita Acara Pentasyarufan</title> --}}
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

        <div style="clear: both; ">
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
            <table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;">
                <tbody>
                    <tr>
                        <td colspan="5" style="100%; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                            <p
                                style="margin-top:0pt; margin-bottom:0pt; text-align:justify; line-height:125%; font-size:11pt;">
                                <strong><span>&nbsp;</span></strong>
                            </p>
                            <p
                                style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                                <strong><span>LAMPIRAN TANDA SERAH TERIMA BANTUAN

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

            <div>

                <span style="font-size: 11pt;"><b>
                        {{ \App\Http\Controllers\Helper::getDataKegiatan($data->id_program_kegiatan ?? null)->pluck('nama_program')->first() }}</b></span>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 2.5cm;vertical-align:top;font-size:11pt;">Keterangan :
                        </td>
                        <td> <span style="font-size:11pt;text-align:justify">
                                {{ $data->pengajuan_note }}
                            </span></td>
                    </tr>
                </table>

                <table cellpadding="0" cellspacing="0"
                    style="width:100%;border:0.75pt solid #000000;border-collapse:collapse;font-size:10pt;padding-top:2mm">
                    <thead>
                        <tr class="text-center" style=" border: 1px solid black; background-color:#cbf2d6;">
                            <td style="width: 3%;vertical-align:middle; border: 1px solid black;"><b>
                                    NO</b></td>
                            <td style="width: 30%;vertical-align:middle; border: 1px solid black;"><b>
                                    PENERIMA MANFAAT
                                </b></td>
                            <td style="width: 30%;vertical-align:middle; border: 1px solid black;"><b>
                                    ALAMAT & NO.HP
                                </b></td>
                            <td style="width: 15%;vertical-align:middle; border: 1px solid black;"><b>
                                    NOMINAL & <br>JENIS BANTUAN </b></td>
                            <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>
                                    TGL BANTUAN & KETERANGAN</b></td>
                            <td style="width:10%;vertical-align:middle; border: 1px solid black;"><b>TTD</b></td>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $jumlah = 0;
                        @endphp

                        @forelse ($data_penerima_lpj as $a)
                            <tr style=" border: 1px solid black;font-size:11pt;">
                                <td class="text-center" style="vertical-align:middle; border: 1px solid black;">
                                    {{ $loop->iteration }}</td>
                                <td style="padding-left:2mm;vertical-align:middle; border: 1px solid black;">
                                    {{ $a->nama }} <br>
                                    <span style="font-size:11pt;text-align:justify">
                                        NIK : {{ $a->nik ?? '-' }}
                                    </span><br>
                                    <span style="font-size:11pt;text-align:justify">
                                        KK &nbsp;: {{ $a->nokk ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding-left:2mm;vertical-align:middle; border: 1px solid black;">
                                    {{ $a->alamat }}<br>
                                    <span style="font-size:11pt;text-align:justify">

                                        No.HP : {{ $a->nohp ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-center"
                                    style="padding-left:2mm;vertical-align:middle; border: 1px solid black;">
                                    Rp{{ number_format($a->nominal_bantuan, 0, '.', '.') }}<br>
                                    <span style="font-size: 11pt;">

                                        {{ $a->jenis_bantuan }}
                                    </span>
                                </td>
                                <td style="padding-left:2mm;vertical-align:middle; border: 1px solid black;">
                                    {{ Carbon\Carbon::parse($a->tgl_bantuan ?? null)->isoFormat('D MMMM Y') }}
                                    <br>
                                    <span style="font-size: 11pt;">
                                        {{ $a->keterangan }}
                                    </span>
                                </td>
                                <td style="padding-left:2mm;vertical-align:middle; border: 1px solid black;">
                                </td>
                            </tr>
                        @empty
                            <tr style=" border: 1px solid black;font-size:11pt;">
                                <td class="text-center" style="vertical-align:middle; border: 1px solid black;"
                                    colspan="6">
                                    Tidak Ada Data</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>


            {{-- <br>
            <br>

            <div>

                <table style="width: 100%;page-break-inside: avoid;">
                    <tr>
                        <td style="width: 33%;text-align: center;">
                            <b>PIHAK KEDUA</b>
                            <br>
                            Yang Menerima
                            <br>
                            ({{ $data->jabatan2 ?? '.............' }})
                        </td>
                        <td style="width: 33%;text-align: center;">
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
                        <td style="width: 25%;text-align: center;">
                            Diperiksa dan di terima oleh :
                            <br>
                            Staf Administrasi & Program
                            <br>
                            NUCARE-LAZISNU CILACAP

                        </td>
                        <td style="width: 33%;text-align: center;vertical-align:top">
                            Divisi Pentasyarufan
                            <br>
                            UPZIS MWCNU <br>{{ $nama_upzis }}
                            @if ($data->tingkat == 'Upzis MWCNU')
                            @elseif($data->tingkat == 'Ranting NU')
                                PRNU {{ $nama_ranting }}
                            @endif

                        </td>
                    </tr>
                    <br>
                    <br>
                    <tr>
                        <td style="width: 33%;text-align: center">
                            <span style=";text-decoration: underline;">
                                ({{ $data->nama2 ?? '...............................' }})
                            </span>

                        </td>
                        <td style="width: 33%;text-align: center">
                            <span style=";text-decoration: underline;">
                                ({{ $data->nama1 ?? '...............................' }})
                            </span>

                        </td>
                        <td style="width: 25%;text-align: center">
                            <span style=";text-decoration: underline;">
                               
                                ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('pc', $data->id_pc, '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3') ?? '(.........................)' }})
                            </span>
                        </td>
                        <td style="width: 33%;text-align: center">
                            <span style=";text-decoration: underline;">
                              
                                ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'bf9ed4c6-85c2-11ed-a0ac-040300000000') ?? '(.........................)' }})
                            </span>

                        </td>
                    </tr>
                    <br>

                </table>


            </div> --}}



        </div>

    </body>
</main>


</html>
