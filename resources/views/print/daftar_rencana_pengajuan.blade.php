<table style="width:100%">
    <tr>
        <td style="width:33%; text-align:left;"><img src="{{ public_path('/images/gocap.png') }}" width="76"
                height="76"></td>
        <td style="width:33%;text-align:center;"><img src="{{ public_path('/images/logo_lazisnu.png') }}" width="146"
                height="76"></td>
        <td style="width:33%;text-align:right;"><img src="{{ public_path('/images/siftnu.png') }}" width="146"
                height="76"></td>
    </tr>
</table>


<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;">
    <tbody>
        <tr>
            <td colspan="5" style="100%; padding-right:5.4pt; padding-left:5.4pt;">

                <p style=" text-align:center;  font-size:11pt;">
                    <strong><span>DAFTAR RENCANA PROGRAM PENTASYARUFAN TINGKAT @if ($data->tingkat == 'Upzis MWCNU')
                                UPZIS MWCNU {{ strtoupper($nama_upzis) }}
                            @endif
                            @if ($data->tingkat == 'Ranting NU')
                                PRNU {{ strtoupper($nama_ranting) }}
                            @endif
                        </span></strong>
                    <br>
                    <strong><span>
                            NO SURAT PENGAJUAN REKOMENDASI : {{ $data->nomor_surat }}
                        </span></strong>
                </p>


            </td>
        </tr>
    </tbody>
</table>

<div></div>

<table
    style="width:100%;border:0.75pt solid #000000;border-collapse:collapse;font-size:10pt; ">
    <tr style="text-align: center; background-color: #cbf2d6; border: 1px solid black;">
        <th style="width: 3%; vertical-align: middle; border: 1px solid black;"><b>NO</b></th>
        <th style="width: 20%; vertical-align: middle; border: 1px solid black;"><b>NAMA PROGRAM <br>(KETERANGAN JENIS BANTUAN)</b></th>
        <th style="width: 15%; vertical-align: middle; border: 1px solid black;"><b>TARGET PENERIMA <br>MANFAAT</b></th>
        <th style="width: 8%; vertical-align: middle; border: 1px solid black;"><b>JUMLAH<br>PENERIMA<br>MANFAAT </b>
        </th>
        <th style="width: 10%; vertical-align: middle; border: 1px solid black;"><b>NOMINAL<br>PER PENERIMA </b></th>
        <th style="width: 10%; vertical-align: middle; border: 1px solid black;"><b>NOMINAL <br> TOTAL</b></th>
        <th style="width: 14%; vertical-align: middle; border: 1px solid black;"><b>TGL PELAKSANAAN
                <br>PENTASYARUFAN</b></th>
        <th style="width: 15%; vertical-align: middle; border: 1px solid black;"><b>PETUGAS <br>PENTASYARUFAN</b></th>
        <th style="width: 8%; vertical-align: middle; border: 1px solid black;"><b>TGL <br> SETOR <br>LPJ</b></th>
    </tr>
    </thead>



    <tbody>

        {{-- PROGRAM PENGUATAN KELEMBAGAAN --}}
        <tr style="page-break-inside: avoid;background-color:#cbf2d6; border-bottom:1px solid black">
            <td
                style="border-bottom: 1px solid black;border-left: 1px solid black;width: 3%; vertical-align: middle; padding-left:3.0mm; text-align:center">
                <b>1</b></td>
            <td style="width: 53%; vertical-align: middle;border-bottom:1px solid black" colspan="4"><b> PROGRAM
                    PENGUATAN KELEMBAGAAN </b></td>
            <td style="width: 10%; vertical-align: middle;border-bottom:1px solid black" class="text-right">
                <b>Rp{{ number_format($jumlah_nominal_a, 0, '.', '.') }}</b>
            </td>
            <td style="width:37%; vertical-align: middle;border-right: 1px solid black; border-bottom:1px solid black"
                colspan="3" class="text-center"></td>
        </tr>

        @foreach ($rencana_a as $a)
            <tr style="page-break-inside: avoid;text-align: center;">
                <td
                    @if ($a->pengajuan_note) style="width: 3%; border: 1px solid black; vertical-align:top; padding-top:2mm"
                @else style="width: 3%;  border: 1px solid black; vertical-align:middle;text-align:justify;" @endif>
                    1.{{ $loop->iteration }}</td>

               <td style="width: 20%; text-align: left; border: 1px solid black; padding-left: 10px; border-spacing: 10px;"><b style="font-size: 10pt;">{{ $a->nama_program }}</b>
                        <br><span style="display: flex; text-align: left; padding-top: 10px;">{{ $a->pengajuan_note }}</span>
                </td>
                    
                    
                <td
                    @if ($a->pengajuan_note) style="width: 15%;vertical-align:top;padding-top:2mm;border: 1px solid black;padding:3mm"
                @else style="width: 15%;vertical-align:middle;border: 1px solid black;padding:3mm" @endif>
                    {{ $a->nama_penerima }}</td>
                <td
                    @if ($a->pengajuan_note) style="width: 8%;border: 1px solid black;vertical-align:top;padding-top:2mm"
                @else style="width: 8%;border: 1px solid black;vertical-align:middle" @endif>
                    {{ $a->jumlah_penerima }}</td>
                <td class="text-right"
                    @if ($a->pengajuan_note) style="width: 10%;border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm" @else
                style="width: 10%;border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                    Rp{{ number_format($a->satuan_pengajuan, 0, '.', '.') }}</td>
                <td class="text-right"
                    @if ($a->pengajuan_note) style="width: 10%;border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm"
                @else style="width: 10%;border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                    Rp{{ number_format($a->nominal_pengajuan, 0, '.', '.') }}</td>
                <td
                    @if ($a->pengajuan_note) style="width: 14%;border: 1px solid black;vertical-align:top;padding-top:2mm"
                @else style="width: 14%;border: 1px solid black;vertical-align:middle" @endif>
                    {{ Carbon\Carbon::parse($a->tgl_pelaksanaan)->isoFormat(' DD-MM-Y') }}
                </td>
                <td
                    @if ($a->pengajuan_note) style="width: 15%;border: 1px solid black;vertical-align:top;padding:3mm;padding-right:2mm;padding-bottom:1mm;padding-top:2mm"
                @else style="width: 15%;border: 1px solid black;vertical-align:middle;padding:3mm;padding-right:2mm;padding-bottom:1mm" @endif>
                    @if ($data->tingkat == 'Upzis MWCNU')
                        {{ App\Http\Controllers\PrintController::nama_pengurus_upzis($a->petugas_upzis) }}
                        ({{ App\Http\Controllers\PrintController::jabatan_pengurus_upzis($a->petugas_upzis) }})
                    @elseif($data->tingkat == 'Ranting NU')
                        {{ App\Http\Controllers\PrintController::nama_pengurus_upzis($a->petugas_ranting) }}
                        ({{ App\Http\Controllers\PrintController::jabatan_pengurus_upzis($a->petugas_ranting) }})
                    @endif
                </td>
                <td
                    @if ($a->pengajuan_note) style="width: 8%;border: 1px solid black;vertical-align:top;padding-top:2mm"
                @else style="width: 8%;border: 1px solid black;vertical-align:middle" @endif>
                    {{ $a->tgl_setor ? Carbon\Carbon::parse($a->tgl_setor)->isoFormat('DD-MM-Y') : '-' }}
                </td>
            </tr>
        @endforeach

        {{-- END PROGRAM PENGUATAN KELEMBAGAAN --}}

        {{-- PROGRAM SOSIAL --}}
        <tr style="page-break-inside: avoid;background-color:#cbf2d6;border-bottom: 1px solid black;">
            <td
                style="vertical-align:middle;padding-left:3.0mm; text-align:center;border-bottom: 1px solid black;border-left: 1px solid black;">
                <b>2</b></td>
            <td colspan="4" style="border-bottom: 1px solid black;"><b> PROGRAM SOSIAL </b></td>
            <td class="text-right" style="vertical-align:middle;padding-right:2mm;border-bottom: 1px solid black;">
                <b>Rp{{ number_format($jumlah_nominal_b, 0, '.', '.') }}</b>
            </td>
            <td colspan="3" style="border-right: 1px solid black; border-bottom:1px solid black"></td>
        </tr>

        @foreach ($rencana_b as $b)
            <tr style="page-break-inside: avoid;text-align: center;">
                <td
                    @if ($b->pengajuan_note) style=" width: 3%;border: 1px solid black; vertical-align:top; padding-top:2mm"
                @else
                style=" width: 3%;border: 1px solid black; vertical-align:middle;text-align:justify;" @endif>
                    2.{{ $loop->iteration }}</td>
                <td style="width: 20%;vertical-align:top; text-align:justify ;border: 1px solid black;margin: 100px;"><b
                        style="font-size: 10pt">{{ $b->nama_program }}</b>
                    <br><span style="display:flex;text-align: justify;">{{ $b->pengajuan_note }}
                    </span>
                </td>
                <td
                    @if ($b->pengajuan_note) style="width: 15%;vertical-align:top;padding-top:2mm;border: 1px solid black;padding:3mm"
                    @else
                style="width: 15%;vertical-align:middle;border: 1px solid black;padding:3mm" @endif>
                    {{ $b->nama_penerima }}</td>
                <td
                    @if ($b->pengajuan_note) style="width: 8%;border: 1px solid black;vertical-align:top;padding-top:2mm"
                @else
                style="width: 8%;border: 1px solid black;vertical-align:middle" @endif>
                    {{ $b->jumlah_penerima }}</td>
                <td class="text-right"
                    @if ($b->pengajuan_note) style="width: 10%;border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm" @else
                style="width: 10%;border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                    Rp{{ number_format($b->satuan_pengajuan, 0, '.', '.') }}</td>
                <td class="text-right"
                    @if ($b->pengajuan_note) style="width: 10%;border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm"
                @else
                style="width: 10%;border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                    Rp{{ number_format($b->nominal_pengajuan, 0, '.', '.') }}</td>
                <td
                    @if ($b->pengajuan_note) style="width: 14%;border: 1px solid black;vertical-align:top;padding-top:2mm"
                @else
                style="width: 14%;border: 1px solid black;vertical-align:middle;" @endif>
                    {{ Carbon\Carbon::parse($b->tgl_pelaksanaan)->isoFormat(' DD-MM-Y') }}
                </td>
                <td
                    @if ($b->pengajuan_note) style="width: 15%;border: 1px solid black;vertical-align:top;padding:3mm;padding-right:2mm;padding-bottom:1mm;padding-top:2mm"
                @else
                style="width: 15%;border: 1px solid black;vertical-align:middle;padding:3mm;padding-right:2mm;padding-bottom:1mm" @endif>
                    @if ($data->tingkat == 'Upzis MWCNU')
                        {{ App\Http\Controllers\PrintController::nama_pengurus_upzis($b->petugas_upzis) }}
                        ({{ App\Http\Controllers\PrintController::jabatan_pengurus_upzis($b->petugas_upzis) }})
                    @elseif($data->tingkat == 'Ranting NU')
                        {{ App\Http\Controllers\PrintController::nama_pengurus_upzis($b->petugas_ranting) }}
                        ({{ App\Http\Controllers\PrintController::jabatan_pengurus_upzis($b->petugas_ranting) }})
                    @endif
                </td>
                <td
                    @if ($b->pengajuan_note) style="width: 8%;border: 1px solid black;vertical-align:top;padding-top:2mm"
                @else
                style="width: 8%;border: 1px solid black;vertical-align:middle;" @endif>
                    {{ $b->tgl_setor ? Carbon\Carbon::parse($b->tgl_setor)->isoFormat('DD-MM-Y') : '-' }}
                </td>
            </tr>
        @endforeach
        {{-- END PROGRAM SOSIAL --}}


        @if ($data->tingkat == 'Upzis MWCNU')
            {{-- OPERASIONAL UPZIS --}}
            <tr style="page-break-inside: avoid;background-color:#cbf2d6;border-bottom: 1px solid black;">
                <td
                    style="text-align:center;vertical-align:middle;padding-left:3.0mm; border-left: 1px solid black; border-bottom:1px solid black">
                    <b>3</b></td>
                <td colspan="4" style=" border-bottom:1px solid black"><b> OPERASIONAL UPZIS </b></td>
                <td class="text-right" style="vertical-align:middle;padding-right:2mm; border-bottom:1px solid black">
                    <b>Rp{{ number_format($jumlah_nominal_c, 0, '.', '.') }}</b>
                </td>
                <td colspan="3" style="border-right: 1px solid black; border-bottom:1px solid black"></td>
            </tr>

            @foreach ($rencana_c as $c)
                <tr style="page-break-inside: avoid;text-align: center;">
                    <td
                        @if ($c->pengajuan_note) style=" width: 3%;border: 1px solid black; vertical-align:top; padding-top:2mm"
            @else
            style="width: 3%; border: 1px solid black; vertical-align:middle;text-align:justify;" @endif>
                        3.{{ $loop->iteration }}</td>
                    <td style="width: 20%;vertical-align:top; text-align:justify ;border: 1px solid black;margin: 100px; "><b
                            style="font-size: 10pt">{{ $c->nama_program }}</b>
                        <br><span style="display:flex;text-align: justify;">{{ $c->pengajuan_note }}
                        </span>
                    </td>
                    <td
                        @if ($c->pengajuan_note) style="width: 15%;vertical-align:top;padding-top:2mm;border: 1px solid black;padding:3mm"
                @else
            style="width: 15%;vertical-align:middle;border: 1px solid black;padding:3mm" @endif>
                        {{ $c->nama_penerima }}</td>
                    <td
                        @if ($c->pengajuan_note) style="width: 8%;border: 1px solid black;vertical-align:top;padding-top:2mm"
            @else
            style="width: 8%;border: 1px solid black;vertical-align:middle" @endif>
                        {{ $c->jumlah_penerima }}</td>
                    <td class="text-right"
                        @if ($c->pengajuan_note) style="width: 10%;border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm" @else
            style="width: 10%;border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                        Rp{{ number_format($c->satuan_pengajuan, 0, '.', '.') }}</td>
                    <td class="text-right"
                        @if ($c->pengajuan_note) style="width: 10%;border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm"
            @else
            style="width: 10%;border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                        Rp{{ number_format($c->nominal_pengajuan, 0, '.', '.') }}</td>
                    <td
                        @if ($c->pengajuan_note) style="width: 14%;border: 1px solid black;vertical-align:top;padding-top:2mm"
            @else
            style="width: 14%;border: 1px solid black;vertical-align:middle;" @endif>
                        {{ Carbon\Carbon::parse($c->tgl_pelaksanaan)->isoFormat(' DD-MM-Y') }}
                    </td>
                    <td
                        @if ($c->pengajuan_note) style="width: 15%;border: 1px solid black;vertical-align:top;padding:3mm;padding-right:2mm;padding-bottom:1mm;padding-top:2mm"
            @else
            style="width: 15%;border: 1px solid black;vertical-align:middle;padding:3mm;padding-right:2mm;padding-bottom:1mm" @endif>
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\PrintController::nama_pengurus_upzis($c->petugas_upzis) }}
                            ({{ App\Http\Controllers\PrintController::jabatan_pengurus_upzis($c->petugas_upzis) }})
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\PrintController::nama_pengurus_upzis($c->petugas_ranting) }}
                            ({{ App\Http\Controllers\PrintController::jabatan_pengurus_upzis($c->petugas_ranting) }})
                        @endif
                    </td>
                    <td
                        @if ($c->pengajuan_note) style="width: 8%;border: 1px solid black;vertical-align:top;padding-top:2mm"
            @else
            style="width: 8%;border: 1px solid black;vertical-align:middle;" @endif>
                        {{ $c->tgl_setor ? Carbon\Carbon::parse($c->tgl_setor)->isoFormat('DD-MM-Y') : '-' }}
                    </td>
                </tr>
            @endforeach
            {{-- END OPERASIONAL UPZIS --}}
        @endif


    </tbody>
</table>

{{-- TTD --}}

<p style="margin-top:0pt; margin-bottom:8pt;">&nbsp;</p>
<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse; page-break-inside: avoid;text-align:center;">
    <tbody>
        @if ($data->tingkat == 'Upzis MWCNU')
            <tr>
                {{-- ttd1 --}}
                <td style="width: 25%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                        class="text-center"><strong><span>Rois Syuriyah <div></div> MWCNU {{ $nama_upzis }}
                            </span>
                        </strong>
                    </p>
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                        <span>&nbsp;</span>
                    </p>
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                        class="text-center">
                        <span>
                            {{-- rois syuriah mwcnu --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'cde81b00-9641-11ed-a0ac-040300000000') }})

                        </span>
                    </p>
                </td>
                {{-- end ttd1 --}}

                {{-- ttd2 --}}
                <td style="width: 22%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                        class="text-center"><strong><span> Ketua <div></div>MWCNU {{ $nama_upzis }}
                            </span>
                        </strong>
                    </p>
                  
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                        <span>&nbsp;</span>
                    </p>

                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                        class="text-center">
                        <span>
                            {{-- ketua mwcnu --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'b15da826-9640-11ed-a0ac-040300000000') }})
                        </span>
                    </p>
                </td>
                {{-- end ttd2 --}}

                {{-- ttd3 --}}
                <td style="width: 25%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                        class="text-center"><strong><span>Ketua <div></div> UPZIS MWCNU {{ $nama_upzis }}
                            </span>
                        </strong>
                    </p>
                  
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                        <span>&nbsp;</span>
                    </p>

                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                        class="text-center">
                        <span>
                            {{-- ketua upzis mwcnu --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, 'c699f7c7-7791-11ed-97ee-e4a8df91d8b3') }})
                        </span>
                    </p>
                </td>
                {{-- end ttd3 --}}

                {{-- ttd4 --}}
                <td style="width: 27%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                        class="text-center"><strong><span> Anggota Bidang Keuangan <div></div> UPZIS MWCNU {{ $nama_upzis }}
                            </span>
                        </strong>
                    </p>
                  
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                        <span>&nbsp;</span>
                    </p>

                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;"
                        class="text-center">
                        <span>
                            {{-- bednahara upzis --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('upzis', $data->id_upzis, '8eb03fef-5a7c-11ed-9dd2-e4a8df91d8b3') }})

                        </span>
                    </p>
                </td>
                {{-- end ttd4 --}}

            </tr>
        @endif

        @if ($data->tingkat == 'Ranting NU')
            <tr>
                <td colspan="2" style="text-align: center;">Mengetahui, <div></div><b>
                        PENGURUS RANTING NAHDLATUL ULAMA
                        {{ strtoupper(str_replace('PRNU', '', $nama_ranting)) }}</b>
                </td>
                <td colspan="2" style="text-align: center;"><b>
                        GERAKAN KOIN NU CILACAP
                        RANTING {{ strtoupper(str_replace('PRNU', '', $nama_ranting)) }}</b>
                </td>
            </tr>

            <div></div>
            <tr>
                {{-- ttd1 --}}
                <td style="width: 25%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;"
                        class="text-center"><strong><span>Rois Syuriyah
                            </span>
                        </strong>
                    </p>
                  
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;">
                        <span>&nbsp;</span>
                    </p>

                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;"
                        class="text-center">
                        <span>
                            {{-- Rois Syuriyah PRNU --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('ranting', $data->id_ranting, '76dd62c6-96dd-11ed-a0ac-040300000000') }})
                        </span>
                    </p>
                </td>
                {{-- end ttd1 --}}

                {{-- ttd2 --}}
                <td style="width: 22%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;"
                        class="text-center"><strong><span>Ketua Tanfidziyah</span>
                        </strong>
                    </p>
                   
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;">
                        <span>&nbsp;</span>
                    </p>

                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;"
                        class="text-center">
                        <span>
                            {{-- Ktua Tanfidziniyah PRNU --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('ranting', $data->id_ranting, 'be847071-2aa1-11ee-b013-c97905ab4d7f') }})
                        </span>
                    </p>
                </td>
                {{-- end ttd2 --}}

                {{-- ttd3 --}}
                <td style="width: 25%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;"
                        class="text-center"><strong><span>Koordinator PLPK
                            </span>
                        </strong>
                    </p>
                  
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;">
                        <span>&nbsp;</span>
                    </p>

                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;"
                        class="text-center">
                        <span>
                            {{-- Ketua PRNU --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('ranting', $data->id_ranting, 'f3baf470-3a29-11ed-a757-e4a8df91d887') }})
                        </span>
                    </p>
                </td>
                {{-- end ttd3 --}}

                {{-- ttd4 --}}
                <td style="width: 27%; padding-right: 5.4pt; padding-left: 5.4pt; vertical-align: top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;"
                        class="text-center"><strong><span>Bendahara Koin NU
                            </span>
                        </strong>
                    </p>
                 
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;">
                        <span>&nbsp;</span>
                    </p>

                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:12pt;"
                        class="text-center">
                        <span>
                            {{-- bendahara nu --}}
                            ({{ App\Http\Controllers\Helper::getNamaPengurusByIdJabatan('ranting', $data->id_ranting, 'a979c8ab-2aa0-11ee-b013-c97905ab4d7f') }})

                        </span>
                    </p>
                </td>
                {{-- end ttd4 --}}

            </tr>
        @endif

    </tbody>


</table>





{{-- end rencana --}}

{{-- penerima manfaat --}}
<div style="clear: both; page-break-before: always;">
</div>


<table style="width:100%">
    <tr>
        <td style="width:33%; text-align:left;"><img src="{{ public_path('/images/gocap.png') }}" width="76"
                height="76"></td>
        <td style="width:33%;text-align:center;"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                width="146" height="76"></td>
        <td style="width:33%;text-align:right;"><img src="{{ public_path('/images/siftnu.png') }}" width="146"
                height="76"></td>
    </tr>
</table>

<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;">
    <tbody>
        <tr>
            <td colspan="5" style="100%; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">

                <p style="margin-bottom:0pt; text-align:center;font-size:11pt;">
                    <strong><span>DAFTAR PENERIMA MANFAAT PENTASYARUFAN TINGKAT @if ($data->tingkat == 'Upzis MWCNU')
                                UPZIS MWCNU {{ strtoupper($nama_upzis) }}
                            @endif
                            @if ($data->tingkat == 'Ranting NU')
                                PRNU {{ strtoupper($nama_ranting) }}
                            @endif
                        </span></strong>
                    <br>
                    <strong><span>
                            NO SURAT PENGAJUAN REKOMENDASI : {{ $data->nomor_surat }}
                        </span></strong>

                </p>

            </td>
        </tr>
    </tbody>
</table>

<div></div>

{{-- PROGRAM PENGUATAN KELEMBAGAAN --}}
@foreach ($rencana_a as $a)
    @php
        $etasyaruf = config('app.database_etasyaruf');
        $detail = DB::table($etasyaruf . '.pengajuan_penerima')
            ->where('id_pengajuan_detail', $a->id_pengajuan_detail)
            ->get();
    @endphp

    @if (count($detail) > 0)
        <span style="font-size: 10pt;"><b>1.{{ $loop->iteration }} {{ $a->nama_program }}</b></span>

        <div>
            <table cellpadding="0" cellspacing="0">
                <tr>

                    <td style="width: 2.5cm;vertical-align:top;font-size:10pt;">Keterangan : </td>
                    <td> <span style="font-size:10pt;text-align:justify">
                            {{ $a->pengajuan_note ? $a->pengajuan_note : '-' }}
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
                            NAMA PENERIMA MANFAAT
                        </b></td>
                    <td style="width: 30%;vertical-align:middle; border: 1px solid black;"><b>
                            ALAMAT LENGKAP
                        </b></td>
                    <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>
                            NOMINAL BANTUAN </b></td>
                    <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>
                            KETERANGAN </b></td>
                </tr>
            </thead>
            <tbody>

                @foreach ($detail as $a1)
                    <tr style=" border: 1px solid black;page-break-inside: avoid;">
                        <td class="text-center" style="width: 3%;vertical-align:middle; border: 1px solid black;">
                            {{ $loop->iteration }}</td>
                        <td style="padding:3mm;width: 30%;vertical-align:middle; border: 1px solid black;">
                            {{ $a1->nama }}
                        </td>
                        <td style="padding:3mm;width: 30%;vertical-align:middle; border: 1px solid black;">
                            {{ $a1->alamat }}
                        </td>
                        <td class="text-center"
                            style="padding:3mm;width: 20%;vertical-align:middle; border: 1px solid black;">
                            Rp{{ number_format($a1->nominal_bantuan, 0, '.', '.') }}</td>
                        <td style="padding:3mm;width: 20%;vertical-align:middle; border: 1px solid black;">
                            {{ $a1->keterangan }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    @endif
@endforeach
{{-- END PROGRAM PENGUATAN KELEMBAGAAN --}}

{{-- PROGRAM SOSIAL --}}
@foreach ($rencana_b as $b)
    @php
        $etasyaruf = config('app.database_etasyaruf');
        $detail = DB::table($etasyaruf . '.pengajuan_penerima')
            ->where('id_pengajuan_detail', $b->id_pengajuan_detail)
            ->get();
    @endphp

    @if (count($detail) > 0)
        <span style="font-size: 10pt;"><b>2.{{ $loop->iteration }} {{ $b->nama_program }}</b></span>

        <div>
            <table>

                <tr>

                    <td style="width: 2.5cm;vertical-align:top;font-size:10pt;">Keterangan : </td>
                    <td> <span style="font-size:10pt;text-align:justify">
                            {{ $b->pengajuan_note ? $b->pengajuan_note : '-' }}

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
                            NAMA PENERIMA MANFAAT
                        </b></td>
                    <td style="width: 30%;vertical-align:middle; border: 1px solid black;"><b>
                            ALAMAT LENGKAP
                        </b></td>
                    <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>
                            NOMINAL BANTUAN </b></td>
                    <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>
                            KETERANGAN </b></td>
                </tr>
            </thead>
            <tbody>

                @foreach ($detail as $b1)
                    <tr style=" border: 1px solid black;page-break-inside: avoid;">
                        <td class="text-center" style="width: 3%;vertical-align:middle; border: 1px solid black;">
                            {{ $loop->iteration }}</td>
                        <td style="padding:3mm;width: 30%;vertical-align:middle; border: 1px solid black;">
                            {{ $b1->nama }}
                        </td>
                        <td style="padding:3mm;width: 30%;vertical-align:middle; border: 1px solid black;">
                            {{ $b1->alamat }}
                        </td>
                        <td class="text-center"
                            style="padding:3mm;width: 20%;vertical-align:middle; border: 1px solid black;">
                            Rp{{ number_format($b1->nominal_bantuan, 0, '.', '.') }}</td>
                        <td style="padding:3mm;width: 20%;vertical-align:middle; border: 1px solid black;">
                            {{ $b1->keterangan }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    @endif
@endforeach
{{-- END PROGRAM SOSIAL --}}

@if ($data->tingkat == 'Upzis MWCNU')
    {{-- OPERASIONAL UPZIS --}}
    @foreach ($rencana_c as $c)
        @php
            $etasyaruf = config('app.database_etasyaruf');
            $detail = DB::table($etasyaruf . '.pengajuan_penerima')
                ->where('id_pengajuan_detail', $c->id_pengajuan_detail)
                ->get();
        @endphp

        @if (count($detail) > 0)
            <span style="font-size: 10pt;"><b>3.{{ $loop->iteration }}
                    {{ $c->nama_program }}</b></span>
            <div>
                <table>

                    <tr>
                        <td style="width: 2.5cm;vertical-align:top;font-size:10pt;">Keterangan : </td>
                        <td> <span
                                style="font-size:10pt;text-align:justify">{{ $c->pengajuan_note ? $c->pengajuan_note : '-' }}
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
                                NAMA PENERIMA MANFAAT
                            </b></td>
                        <td style="width: 30%;vertical-align:middle; border: 1px solid black;"><b>
                                ALAMAT LENGKAP
                            </b></td>
                        <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>
                                NOMINAL BANTUAN </b></td>
                        <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>
                                KETERANGAN </b></td>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($detail as $c1)
                        <tr style=" border: 1px solid black;page-break-inside: avoid;">
                            <td class="text-center" style="width: 3%;vertical-align:middle; border: 1px solid black;">
                                {{ $loop->iteration }}</td>
                            <td style="padding:3mm;width: 30%;vertical-align:middle; border: 1px solid black;">
                                {{ $c1->nama }}
                            </td>
                            <td style="padding:3mm;width: 30%;vertical-align:middle; border: 1px solid black;">
                                {{ $c1->alamat }}
                            </td>
                            <td class="text-center"
                                style="padding:3mm;width: 20%;vertical-align:middle; border: 1px solid black;">
                                Rp{{ number_format($c1->nominal_bantuan, 0, '.', '.') }}</td>
                            <td style="padding:3mm;width: 20%;vertical-align:middle; border: 1px solid black;">
                                {{ $c1->keterangan }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        @endif
    @endforeach
    {{-- END OPSERASIONAL UPZIS --}}
@endif
