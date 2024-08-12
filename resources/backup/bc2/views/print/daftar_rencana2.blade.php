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
                    <strong><span>DETAIL PROGRAM DISETUJUI & DAPAT DICAIRKAN PENTASYARUFAN TINGKAT @if ($data->tingkat == 'Upzis MWCNU')
                                UPZIS MWCNU
                                {{ strtoupper(App\Http\Controllers\Helper::getNamaUpzis($data->id_upzis)) }}
                            @else
                                PRNU {{ strtoupper(App\Http\Controllers\Helper::getNamaRanting($data->id_ranting)) }}
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

<table style="width:100%;border:0.75pt solid #000000;border-collapse:collapse;font-size:10pt; ">
    <tr style="text-align: center; background-color: #cbf2d6; border: 1px solid black;">
        <th style="width: 3%; vertical-align: middle; border: 1px solid black;"><b>NO</b></th>
        <th style="width: 20%; vertical-align: middle; border: 1px solid black;"><b>NAMA PROGRAM <br>(KETERANGAN JENIS
                BANTUAN)</b></th>
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
                <b>1</b>
            </td>
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

                <td
                    style="width: 20%; text-align: left; border: 1px solid black; padding-left: 10px; border-spacing: 10px;"><b style="font-size: 10pt;">{{ $a->nama_program }}</b><br><span style="display:flex;text-align: justify;"><em>{{ App\Http\Controllers\Helper::getDataRekening4($tipe, $a->id_rekening) }}</em>
                    </span>
                    <span style="display: flex; text-align: left; padding-top: 10px;">{{ $a->pengajuan_note }}</span>
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
                    Rp{{ number_format($a->satuan_pencairan, 0, '.', '.') }}</td>
                <td class="text-right"
                    @if ($a->pengajuan_note) style="width: 10%;border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm"
            @else style="width: 10%;border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                    Rp{{ number_format($a->nominal_pencairan, 0, '.', '.') }}</td>
                <td
                    @if ($a->pengajuan_note) style="width: 14%;border: 1px solid black;vertical-align:top;padding-top:2mm"
            @else style="width: 14%;border: 1px solid black;vertical-align:middle" @endif>
                    {{ Carbon\Carbon::parse($a->tgl_pelaksanaan)->isoFormat(' DD-MM-Y') }}
                </td>
                <td
                    @if ($a->pengajuan_note) style="width: 15%;border: 1px solid black;vertical-align:top;padding:3mm;padding-right:2mm;padding-bottom:1mm;padding-top:2mm"
            @else style="width: 15%;border: 1px solid black;vertical-align:middle;padding:3mm;padding-right:2mm;padding-bottom:1mm" @endif>
                    @if ($data->tingkat == 'Upzis MWCNU')
                        {{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $a->petugas_upzis) }}
                        ({{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $a->petugas_upzis) }})
                    @elseif($data->tingkat == 'Ranting NU')
                        {{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $a->petugas_ranting) }}
                        ({{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $a->petugas_ranting) }})
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
                <b>2</b>
            </td>
            <td colspan="4" style="border-bottom: 1px solid black;"><b> PROGRAM SOSIAL </b></td>
            <td class="text-right" style="vertical-align:middle;padding-right:2mm;border-bottom: 1px solid black;">
                <b>Rp{{ number_format($jumlah_nominal_b, 0, '.', '.') }}</b>
            </td>
            <td colspan="3" style="border-right: 1px solid black; border-bottom:1px solid black"></td>
        </tr>

        @foreach ($rencana_b as $b)
            <tr style="page-break-inside: avoid;text-align: center;">
                <td
                    @if ($b->pengajuan_note) style=" border: 1px solid black; vertical-align:top; padding-top:2mm"
            @else
            style=" border: 1px solid black; vertical-align:middle;text-align:justify;" @endif>
                    2.{{ $loop->iteration }}</td>
                <td style="vertical-align:top; text-align:justify ;border: 1px solid black;margin: 100px;"><b
                        style="font-size: 10pt">{{ $b->nama_program }}</b><br><span style="display:flex;text-align: justify;"><em>{{ App\Http\Controllers\Helper::getDataRekening4($tipe, $b->id_rekening) }}</em>
                    </span>
                    <span style="display:flex;text-align: justify;">{{ $b->pengajuan_note }}
                    </span>
                </td>
                <td
                    @if ($b->pengajuan_note) style="vertical-align:top;padding-top:2mm;border: 1px solid black;padding:3mm"
                @else
            style="vertical-align:middle;border: 1px solid black;padding:3mm" @endif>
                    {{ $b->nama_penerima }}</td>
                <td
                    @if ($b->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm"
            @else
            style="border: 1px solid black;vertical-align:middle" @endif>
                    {{ $b->jumlah_penerima }}</td>
                <td class="text-right"
                    @if ($b->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm" @else
            style="border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                    Rp{{ number_format($b->satuan_pencairan, 0, '.', '.') }}</td>
                <td class="text-right"
                    @if ($b->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm"
            @else
            style="border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                    Rp{{ number_format($b->nominal_pencairan, 0, '.', '.') }}</td>
                <td
                    @if ($b->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm"
            @else
            style="border: 1px solid black;vertical-align:middle;" @endif>
                    {{ Carbon\Carbon::parse($b->tgl_pelaksanaan)->isoFormat(' DD-MM-Y') }}
                </td>
                <td
                    @if ($b->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding:3mm;padding-right:2mm;padding-bottom:1mm;padding-top:2mm"
            @else
            style="border: 1px solid black;vertical-align:middle;padding:3mm;padding-right:2mm;padding-bottom:1mm" @endif>
                    @if ($data->tingkat == 'Upzis MWCNU')
                        {{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $b->petugas_upzis) }}
                        ({{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $b->petugas_upzis) }})
                    @elseif($data->tingkat == 'Ranting NU')
                        {{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $b->petugas_ranting) }}
                        ({{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $b->petugas_ranting) }})
                    @endif
                </td>
                <td
                    @if ($b->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm"
            @else
            style="border: 1px solid black;vertical-align:middle;" @endif>
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
                    <b>3</b>
                </td>
                <td colspan="4" style=" border-bottom:1px solid black"><b> OPERASIONAL UPZIS </b></td>
                <td class="text-right" style="vertical-align:middle;padding-right:2mm; border-bottom:1px solid black">
                    <b>Rp{{ number_format($jumlah_nominal_c, 0, '.', '.') }}</b>
                </td>
                <td colspan="3" style="border-right: 1px solid black; border-bottom:1px solid black"></td>
            </tr>

            @foreach ($rencana_c as $c)
                <tr style="page-break-inside: avoid;text-align: center;">
                    <td
                        @if ($c->pengajuan_note) style=" border: 1px solid black; vertical-align:top; padding-top:2mm"
        @else
        style=" border: 1px solid black; vertical-align:middle;text-align:justify;" @endif>
                        3.{{ $loop->iteration }}</td>
                    <td style="vertical-align:top; text-align:justify ;border: 1px solid black;margin: 100px; "><b
                            style="font-size: 10pt">{{ $c->nama_program }}</b><br><span style="display:flex;text-align: justify;"><em>{{ App\Http\Controllers\Helper::getDataRekening4($tipe, $c->id_rekening) }}</em>
                        </span>
                        <span style="display:flex;text-align: justify;">{{ $c->pengajuan_note }}
                        </span>
                    </td>
                    <td
                        @if ($c->pengajuan_note) style="vertical-align:top;padding-top:2mm;border: 1px solid black;padding:3mm"
            @else
        style="vertical-align:middle;border: 1px solid black;padding:3mm" @endif>
                        {{ $c->nama_penerima }}</td>
                    <td
                        @if ($c->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm"
        @else
        style="border: 1px solid black;vertical-align:middle" @endif>
                        {{ $c->jumlah_penerima }}</td>
                    <td class="text-right"
                        @if ($c->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm" @else
        style="border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                        Rp{{ number_format($c->satuan_pencairan, 0, '.', '.') }}</td>
                    <td class="text-right"
                        @if ($c->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm;padding-right:2mm"
        @else
        style="border: 1px solid black;vertical-align:middle;padding-right:2mm" @endif>
                        Rp{{ number_format($c->nominal_pencairan, 0, '.', '.') }}</td>
                    <td
                        @if ($c->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm"
        @else
        style="border: 1px solid black;vertical-align:middle;" @endif>
                        {{ Carbon\Carbon::parse($c->tgl_pelaksanaan)->isoFormat(' DD-MM-Y') }}
                    </td>
                    <td
                        @if ($c->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding:3mm;padding-right:2mm;padding-bottom:1mm;padding-top:2mm"
        @else
        style="border: 1px solid black;vertical-align:middle;padding:3mm;padding-right:2mm;padding-bottom:1mm" @endif>
                        @if ($data->tingkat == 'Upzis MWCNU')
                            {{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $c->petugas_upzis) }}
                            ({{ App\Http\Controllers\Helper::getNamaPengurus('upzis', $c->petugas_upzis) }})
                        @elseif($data->tingkat == 'Ranting NU')
                            {{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $c->petugas_ranting) }}
                            ({{ App\Http\Controllers\Helper::getNamaPengurus('ranting', $c->petugas_ranting) }})
                        @endif
                    </td>
                    <td
                        @if ($c->pengajuan_note) style="border: 1px solid black;vertical-align:top;padding-top:2mm"
        @else
        style="border: 1px solid black;vertical-align:middle;" @endif>
                        {{ $c->tgl_setor ? Carbon\Carbon::parse($c->tgl_setor)->isoFormat('DD-MM-Y') : '-' }}
                    </td>
                </tr>
            @endforeach
            {{-- END OPERASIONAL UPZIS --}}
        @endif


    </tbody>
</table>



</body>
</div>
{{-- end rencana --}}



</main>




</html>
