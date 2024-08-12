<!DOCTYPE html>
<html>

<head>
    <title>{{ str_replace('/', '_', $data->nomor_surat) . '_FPPD' }}</title>
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
                style="margin-top:0pt; margin-bottom:0pt; text-align:right; line-height:normal; border-bottom:2.25pt double #000000; padding-bottom:1px; font-size:10pt;">
                <strong><em>&nbsp;</em></strong>
            </p>
            <p
                style="margin-top:3pt; margin-bottom:0pt; text-align:right; line-height:150%; widows:0; orphans:0; font-size:11px;">
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
                    <td class="text-left" style="width: 10%;"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                            width="130" height="76" style="margin: 0 auto 0 0; display: block; "></td>
                    <td style="width:120%" class="text-center">
                        <p
                            style=" margin-right:45pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                            <strong><span>FORMULIR PERMOHONAN PENGELUARAN DANA (FPPD)</span></strong>
                        </p>
                        <p
                            style="margin-top:0pt;  margin-right:45pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                            <strong><span>
                                    MANAJEMEN EKSEKUTIF NUCARE LAZISNU CILACAP
                                </span></strong>
                        </p>
                        <p
                            style="margin-top:0pt;  margin-right:45pt;margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                            <strong><span>
                                    F-NUCARE/PYL-01
                                </span></strong>
                        </p>

                    </td>
                    <td class="text-right" style="width: 10%;"><img src="{{ public_path('/images/siftnu.png') }}"
                            width="130" height="66" style="margin: 0 auto 0 0; display: block; "></td>
                </tr>
            </table>
        </header>
    </div>

    <body>

        <br>
        <br>

        <table style="width: 100%;font-size:10pt;">
            {{-- paragraf 1 --}}
            <tr>
                <td style="width: 50%"> </td>
                <td style="width: 50%;text-align:right">No Pengajuan : {{ $data->nomor_surat }}</td>
            </tr>
        </table>

        <table cellpadding="0" cellspacing="0"
            style="width:100%;border:0.75pt solid #000000;border-collapse:collapse;font-size:10pt;">

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 30%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Pemohon
                </td>
                <td colspan="2"
                    style="width: 40%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ App\Http\Controllers\PrintController::nama_pengurus_pc($data->maker_tingkat_pc) }}
                </td>

            </tr>

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Jabatan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ App\Http\Controllers\PrintController::jabatan_pengurus_pc($data->maker_tingkat_pc) }}
                </td>
            </tr>

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Jumlah Dana
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    Rp{{ number_format($data->nominal_pengajuan, 0, '.', '.') }},-
                </td>
            </tr>

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Tujuan Pengajuan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ $data->tujuan ?? '-' }}
                </td>
            </tr>


            <tr style=" border: 1px solid black;background-color:">
                <td style="width: 20%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;">
                    Keterangan Pengajuan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;">
                    {{ $data->note ?? '-' }}
                </td>
            </tr>
            {{-- <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;height:1.7cm;">
                    Tujuan Pengajuan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;">
                    {{ $data->tujuan }}
                </td>
            </tr> --}}

            {{-- {{ dd($data) }} --}}

            <tr style=" border: 1px solid black;background-color:">
                <td
                    style="width: 20%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;height:0.7cm;">
                    Dibayarkan Kepada
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:middle;text-align:left; border: 1px solid black;">
                    {{ $data->atas_nama ?? '-' }}
                </td>
            </tr>


            <tr style=" border: 1px solid black;background-color:">
                <td style="width: 20%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;">
                    Mohon Dana Dikeluarkan
                </td>
                <td colspan="2"
                    style="width: 80%;padding-left:2mm;vertical-align:top;text-align:left; border: 1px solid black;">
                    @if ($data->bentuk == 'Cash')
                        <span>Tunai</span>
                    @elseif($data->bentuk == 'Transfer')
                        <span>
                            Transfer <br> {{ $data->no_rek_tujuan }} - {{ $data->bank_tujuan }}
                        </span>
                    @endif
                </td>
            </tr>
        </table>

        <br>
        {{-- <style>
            form {
                display: flex;
                flex-direction: row;
                gap: 10px;
                /* Adjust the gap between checkboxes and labels */
            }

            label {
                display: inline-block;
            }
        </style>

        <form>
            <input type="checkbox" id="paymentOptionA" name="paymentOption" value="a">
            <label for="paymentOptionA">Option A</label>

            <input type="checkbox" id="paymentOptionB" name="paymentOption" value="b">
            <label for="paymentOptionB">Option B</label>

            <input type="checkbox" id="paymentOptionC" name="paymentOption" value="c">
            <label for="paymentOptionC">Option C</label>

            <input type="checkbox" id="paymentOptionD" name="paymentOption" value="d">
            <label for="paymentOptionD">Option D</label>
        </form> --}}
        {{-- {{ dd($data) }} --}}

        <table cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse;font-size:10pt;">
            <tbody>
                <tr style="height:20.8pt;">
                    <td colspan="3"
                        style="width:237.05pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span>Tgl Pengajuan :
                                {{ Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('DD/MM/Y') }}</span></p>
                    </td>
                    <td
                        style="width:130.95pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;">
                            @if ($data->approval_status_divpro == 'Disetujui')
                                <span>Tgl
                                    Diterima :
                                    {{ Carbon\Carbon::parse($data->approval_date_divpro)->isoFormat('DD/MM/Y') }}</span>
                            @else
                                <span>Tgl
                                    Diterima : - </span>
                            @endif
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;">
                            @if ($data->approval_status == 'Disetujui')
                                <span>Tgl
                                    Disetujui :
                                    {{ Carbon\Carbon::parse($data->approval_date)->isoFormat('DD/MM/Y') }}
                                </span>
                            @else
                                <span>Tgl
                                    Disetujui : - </span>
                            @endif
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;">
                            @if ($data->pencairan_status == 'Berhasil Dicairkan')
                                <span>Tgl Pencairan :
                                    {{ Carbon\Carbon::parse($data->tgl_pencairan)->isoFormat('DD/MM/Y') }}</span>
                            @else
                                <span>Tgl Pencairan : - </span>
                            @endif
                        </p>
                    </td>
                </tr>
                <tr style="height:21.1pt;">
                    <td colspan="3"
                        style="width:237.05pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span>&nbsp;</span></p>
                    </td>
                    <td
                        style="width:130.95pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span>&nbsp;</span>
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;">
                            @if ($data->approval_status == 'Disetujui')
                                <span>Nominal :
                                    Rp{{ number_format($data->nominal_disetujui, 0, '.', '.') }},-</span>
                            @else
                                <span>Nominal : - </span>
                            @endif
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;">
                            @if ($data->pencairan_status == 'Berhasil Dicairkan')
                                <span>Nominal :
                                    Rp{{ number_format($data->nominal_pencairan, 0, '.', '.') }},-</span>
                            @else
                                <span>Nominal : - </span>
                            @endif
                        </p>
                    </td>
                </tr>
                <tr style="height:21.1pt;">
                    <td colspan="2"
                        style="width:137.8pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span>Pemohon</span>
                        </p>
                    </td>
                    <td
                        style="width:88.45pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;;"><span>Keterangan PPD :</span></p>
                    </td>
                    <td
                        style="width:130.95pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;;"><span>Diterima
                                Oleh</span></p>
                    </td>
                    <td
                        style="width:152.2pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;;"><span>Disetujui
                                Oleh</span></p>
                    </td>
                    <td
                        style="width:152.2pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;;"><span>Divisi
                                Keuangan</span></p>
                    </td>
                </tr>
                <tr style="height:21.1pt;">
                    <td colspan="2"
                        style="width:137.8pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;;">
                            <span>&nbsp;</span>
                        </p>
                    </td>
                    <td
                        style="width:88.45pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                <span style="margin-left:0pt; margin-bottom:5pt;  font-size:10pt;">{{ $data->keterangan_ppd ?? '-'}}
                                </span>
                    </td>
                    <td
                        style="width:130.95pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span>&nbsp;</span>
                        </p>
                    </td>tra
                    <td
                        style="width:152.2pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span>&nbsp;</span>
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span>Diperiksa dan Disetujui Oleh</span>
                        </p>
                    </td>
                </tr>
                <tr style="height:49.15pt;">
                    @php
                        $ttd_pemohon = App\Http\Controllers\PrintController::ttd($data->maker_tingkat_pc);
                        $ttd_program = App\Http\Controllers\PrintController::ttd($data->approver_divpro);
                        $ttd_direktur = App\Http\Controllers\PrintController::ttd($data->approver_tingkat_pc);
                        $ttd_keuangan = App\Http\Controllers\PrintController::ttd($data->staf_keuangan_pc);
                        // dd($ttd_program);
                    @endphp
                    <td
                        style="width:65.5pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle;">
                        <p style="margin-top:15pt; margin-bottom:15pt; font-size:10pt;;"><span>Tanda<br> Tangan</span></p>
                    </td>
                    <td
                        style="width:61.5pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:15pt; margin-bottom:15pt; text-align:center; font-size:10pt;">
                            @if ($ttd_pemohon != '' || $ttd_pemohon != null)
                                <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/{{ $ttd_pemohon }}"
                                    alt="Tanda tangan" width="100" height="50">
                            @endif
                        </p>
                    </td>
                    <td rowspan="3"
                        style="width:88.45pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span>Lampiran :</span>
                        </p>
                        <ol type="1" style="margin:0pt; padding-left:0pt;">
                            @forelse ($lampiran as $item)
                                <li style="margin-left:14pt; padding-left:2pt; font-size:10pt;;">{{ $item->judul }}
                                </li>
                            @empty
                                <span style="margin-left:0pt; padding-left:2pt; font-size:10pt;">- </span>
                            @endforelse
                        </ol>
                    </td>
                    <td
                        style="width:130.95pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:15pt; margin-bottom:15pt; text-align:center; font-size:10pt;">
                            @if ($data->approval_status_divpro == 'Disetujui')
                                @if ($ttd_program != '' || $ttd_program != null)
                                    <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/{{ $ttd_program }}"
                                        alt="Tanda tangan" width="100" height="50">
                                @endif
                            @endif
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:15pt; margin-bottom:15pt; text-align:center; font-size:10pt;">
                            @if ($data->approval_status == 'Disetujui')
                                @if ($ttd_direktur != '' || $ttd_direktur != null)
                                    <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/{{ $ttd_direktur }}"
                                        alt="Tanda tangan" width="100" height="50">
                                @endif
                            @endif
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:15pt; margin-bottom:15pt; text-align:center; font-size:10pt;">
                            @if ($data->pencairan_status == 'Berhasil Dicairkan')
                                @if ($ttd_keuangan != '' || $ttd_keuangan != null)
                                    <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/{{ $ttd_keuangan }}"
                                        alt="Tanda tangan" width="100" height="50">
                                @endif
                            @endif
                        </p>
                    </td>
                </tr>
                <tr style="height:20.8pt;">
                    <td
                        style="width:65.5pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span>Nama</span></p>
                    </td>
                    <td
                        style="width:61.5pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span><strong>{{ App\Http\Controllers\PrintController::nama_pengurus_pc($data->maker_tingkat_pc) }}</strong></span>
                        </p>
                    </td>
                    <td
                        style="width:130.95pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <strong><span>{{ $nama_program }}</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <strong><span>{{ $nama_direktur }}</span></strong>
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <strong><span>{{ $nama_keuangan }}</span></strong>
                        </p>
                    </td>
                </tr>
                <tr style="height:20.8pt;">
                    <td
                        style="width:65.5pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:10pt;"><span>Jabatan</span></p>
                    </td>
                    <td
                        style="width:61.5pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span>{{ App\Http\Controllers\PrintController::jabatan_pengurus_pc($data->maker_tingkat_pc) }}</span>
                        </p>
                    </td>
                    <td
                        style="width:130.95pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span>{{$program}}</span>
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span>{{$direktur}}</span>
                        </p>
                    </td>
                    <td
                        style="width:152.2pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:10pt;">
                            <span>{{$div_keu}}</span>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <span  style="font-size:10pt;">Catatan Direktur : {{ $data->approval_note ?? '-' }}</span>

    </body>




</main>




</html>
