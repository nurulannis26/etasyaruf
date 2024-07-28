@php
    [$start, $end] = explode(' - ', $filter_daterange);
    $startDate = \Carbon\Carbon::parse($start)
        ->locale('id')
        ->isoFormat('D MMMM Y');
    $endDate = \Carbon\Carbon::parse($end)
        ->locale('id')
        ->isoFormat('D MMMM Y');
@endphp


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

@if($sub == 'pengajuan')

    <p style="margin:0pt; text-align:center; font-size:11pt;">
        <b>DATA PENGAJUAN PENTASYARUFAN TINGKAT UPZIS</b>
        <br>
        <b> BERDASARKAN TGL KONFIRMASI PENGAJUAN</b>
    </p>

@elseif($sub == 'laporan')
    <p style="margin:0pt; text-align:center; font-size:11pt;">
        @if($tings == 'keseluruhan')
         <b>DATA REALISASI PENERIMA MANFAAT PER WILAYAH KECAMATAN {{ strtoupper(app\Http\Controllers\EksporPenerimaManfaat::get_nama_upzis($id_upzis2)) }}</b>
        @else
          <b>DATA REALISASI PENERIMA MANFAAT TINGKAT UPZIS</b>
        @endif

        <br>
        <b>BERDASARKAN INPUT PENERIMA MANFAAT SAAT PENGAJUAN DAN LPJ</b>
    </p>

@endif


@if($sub == 'pengajuan')

@php
    $not = 'Tgl Konfirmasi';
@endphp

@elseif($sub == 'laporan')

@php
    $not = 'Tgl Rekom';
@endphp

@endif

<table style="width: 100%; font-size: 11pt;">
    {{-- paragraf 1 --}}
    <tr>
        <td style="width: 19%"><b>Periode ({{ $not }})</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%">
            {{ $startDate }} - {{ $endDate }}
        </td>
    </tr>

    <tr>
        <td style="width: 19%"><b>UPZIS MWCNU</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%">
            @if($tings == 'keseluruhan')
                @if ($id_upzis2)
                    {{ strtoupper(app\Http\Controllers\EksporPenerimaManfaat::get_nama_upzis($id_upzis2)) }}
                @else
                    Semua
                @endif
            @elseif($tings == 'ranting')
                    @if ($id_upzis2)
                    {{ strtoupper(app\Http\Controllers\EksporPenerimaManfaat::get_nama_upzis($id_upzis2)) }}
                @else
                    Semua
                @endif
            @elseif($tings == 'upzis')
                @if ($id_upzis)
                    {{ strtoupper(app\Http\Controllers\EksporPenerimaManfaat::get_nama_upzis($id_upzis)) }}
                @else
                    Semua
                 @endif
            @else
                Semua
            @endif
        </td>
    </tr>

 
        @if($tings == 'ranting')
        <tr>
            <td style="width: 19%"><b>RANTING MWCNU</b></td>
            <td style="width: 1%">:</td>
            <td style="width: 80%">
                @if ($id_ranting2)
                    {{ strtoupper(app\Http\Controllers\EksporPenerimaManfaat::get_nama_ranting($id_ranting2)) }}
                @else
                    Semua
                @endif
            </td>
        </tr>
        @endif
</table>

<br>
<div></div>

<table cellpadding="2" cellspacing="0" style="width:100%;border-collapse:collapse;font-size:10pt;">

    <thead>
        <tr style="text-align:center; background-color:#cbf2d6; border: 1px solid black;">
            <td style="width: 3%;vertical-align:middle; border: 1px solid black;"><b>NO</b></td>
            <td style="width: 9%;vertical-align:middle; border: 1px solid black;"><b>TANGGAL</b></td>
            <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>NAMA</b></td>
            <td style="width: 15%;vertical-align:middle; border: 1px solid black;"><b>ALAMAT</b></td>
            <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>NOMINAL<br> BANTUAN </b></td>
            <td style="width: 8%;vertical-align:middle; border: 1px solid black;"><b>ASNAF</b></td>
            <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>JENIS <br> BANTUAN</b></td>
            <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>PILAR</b></td>
            <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>JENIS <br> PROGRAM</b></td>
        </tr>
    </thead>

    <tbody>
        @if (count($penerima_manfaat) > 0)
            @foreach($penerima_manfaat as $p_manfaat)
                <tr style="text-align: left; page-break-inside: avoid;">
                    <td style="width: 3%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                       {{ $loop->iteration }}
                    </td>
                    <td style="width: 9%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                       {{ Carbon\Carbon::parse($p_manfaat->tgl_bantuan)->isoFormat('D/M/Y') }}
                    </td>
                    <td style="width: 20%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:left;">
                        <b style="font-size:10pt;">{{ $p_manfaat->nama }} </b>
                        <br>
                           NIK : {{ $p_manfaat->nik }} <br> 
                           KK : {{ $p_manfaat->nokk }} <br>  
                           NO HP :  {{ $p_manfaat->nohp }} 
                    </td>
                    <td style="width: 15%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        {{ $p_manfaat->alamat }}
                    </td>
                    <td style="width: 12%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        Rp{{ number_format($p_manfaat->nominal_bantuan, 0, '.', '.') }},-
                    </td>
                    <td style="width: 8%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        {{ $p_manfaat->nama_asnaf }}
                    </td>
                    <td style="width: 12%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        {{ $p_manfaat->jenis_bantuan }}
                    </td>
                    <td style="width: 12%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        {{ $p_manfaat->pilar }}
                    </td>
                    <td style="width: 12%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        {{ $p_manfaat->nama_program }}
                    </td>
                    
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" style="border: 1px solid black; vertical-align:top;padding-left:7mm;">
                    Tidak Ada Data
                </td>
            </tr>
        @endif
    </tbody>

</table>
