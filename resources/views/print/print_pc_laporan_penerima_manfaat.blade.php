@php
    [$start, $end] = explode(' - ', $filter_daterange2);
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


    <p style="margin:0pt; text-align:center; font-size:11pt;">
        <b>DATA PENGAJUAN PENTASYARUFAN TINGKAT PC LAZISNU CILACAP</b>
    </p>



<table style="width: 100%; font-size: 11pt;">
    {{-- paragraf 1 --}}
    <tr>
        <td style="width: 19%"><b>Periode</b></td>
        <td style="width: 1%">:</td>
        <td style="width: 80%">
            {{ $startDate }} - {{ $endDate }}
        </td>
    </tr>
</table>

<br>
<div></div>

<table cellpadding="5" cellspacing="0" style="width:100%;border-collapse:collapse;font-size:10pt;">

    <thead>
        <tr style="text-align:center; background-color:#cbf2d6; border: 1px solid black;">
            <td style="width: 3%;vertical-align:middle; border: 1px solid black;"><b>NO</b></td>
            <td style="width: 9%;vertical-align:middle; border: 1px solid black;"><b>TANGGAL</b></td>
            <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>NAMA</b></td>
            <td style="width: 15%;vertical-align:middle; border: 1px solid black;"><b>ALAMAT</b></td>
            <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>NOMINAL<br> PENGAJUAN </b></td>
            <td style="width: 8%;vertical-align:middle; border: 1px solid black;"><b>ASNAF</b></td>
            <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>TANDA <br>TERIMA</b></td>
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
                       {{ Carbon\Carbon::parse($p_manfaat->tgl_pengajuan)->isoFormat('D/M/Y') }}
                    </td>
                    <td style="width: 20%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:left;"><b style="font-size:12px;">@if ($p_manfaat->opsi_pemohon == 'Individu'){{ $p_manfaat->nama_pemohon }}@elseif($p_manfaat->opsi_pemohon == 'Internal'){{ App\Models\Pengguna::where('gocap_id_pc_pengurus',$p_manfaat->pemohon_internal)->value('nama') }}@elseif($p_manfaat->opsi_pemohon == 'Entitas'){{ $p_manfaat->nama_entitas }}@endif</b>
                      <br>NoHp : @if ($p_manfaat->opsi_pemohon == 'Individu'){{ $p_manfaat->nohp_pemohon }}@elseif($p_manfaat->opsi_pemohon == 'Internal'){{ App\Models\Pengguna::where('gocap_id_pc_pengurus',$p_manfaat->pemohon_internal)->value('nohp') }}@elseif($p_manfaat->opsi_pemohon == 'Entitas'){{ $p_manfaat->no_hp_entitas }}@endif   
                    </td>
                    <td style="width: 15%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        @if ($p_manfaat->opsi_pemohon == 'Individu'){{ $p_manfaat->alamat_pemohon }}       
                        @elseif($p_manfaat->opsi_pemohon == 'Internal'){{ App\Models\Pengguna::where('gocap_id_pc_pengurus',$p_manfaat->pemohon_internal)->value('alamat') }}
                        @elseif($p_manfaat->opsi_pemohon == 'Entitas'){{ $p_manfaat->alamat_entitas }}   
                        @endif
                    </td>
                    <td style="width: 12%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        Rp{{ number_format($p_manfaat->nominal_pengajuan, 0, '.', '.') }},-
                    </td>
                    <td style="width: 8%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        {{ $p_manfaat->nama_asnaf }}
                    </td>
                    <td style="width: 12%;padding-left:3.0mm;border: 1px solid black; vertical-align:middle;text-align:center;">
                        @if($p_manfaat->jenis_tanda_terima == 'lainnya')
                        {{ $p_manfaat->lainnya }}
                      @else
                          {{ $p_manfaat->jenis_tanda_terima }}
                      @endif
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
