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

@php
    // Set timezone to Asia/Jakarta
    date_default_timezone_set('Asia/Jakarta');

    // Import Carbon namespace
    use Carbon\Carbon;

    // Get the current date in Carbon format
    $currentDate = Carbon::now();

    // Format the month in Bahasa Indonesia
    $formattedMonths = ucfirst(trans($currentDate->isoFormat('MMMM')));

    // Format the date in the desired format
    $formattedDates = "{$formattedMonths} {$currentDate->format('Y')}";

@endphp

@php
    date_default_timezone_set('Asia/Jakarta');
    if ($tings == 'ranting' || $tings == 'keseluruhan' ) {
        [$start, $end] = explode(' - ', $filter_daterange2);
    } else {
        [$start, $end] = explode(' - ', $filter_daterange);
    }
    $startDate = \Carbon\Carbon::parse($start)
        ->locale('id')
        ->isoFormat('D MMMM Y');
    $endDate = \Carbon\Carbon::parse($end)
        ->locale('id')
        ->isoFormat('D MMMM Y');
@endphp

@if(Auth::user()->gocap_id_upzis_pengurus)
    @php
        $upziss = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
    @endphp
@else
    @php
        $upziss = '';
    @endphp
@endif



<p style="margin:0pt; text-align:center; font-size:11pt;">
    <b>BERITA ACARA SERAH TERIMA LAPORAN AKHIR</b>
    <br>
    <b>PENTASYARUFAN TINGKAT
        @if($tings == 'ranting')
            @if ($id_ranting2)
                RANTING {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_ranting($id_ranting2)) }}
            @else
              RANTING
            @endif
        @elseif($tings == 'upzis')
            UPZIS {{ $upziss }}
       @elseif($tings == 'keseluruhan')
           KESELURUHAN (PC LAZISNU, UPZIS, RANTING)
       @endif
    </b>
    <br>
    <b>PERIODE {{ strtoupper($startDate . ' - ' . $endDate) }}
    </b>
</p>

@php
    // Format the date in the desired format
    $formattedDate = 'Pada hari ini ' . ucfirst(trans($currentDate->isoFormat('dddd'))) . ' tanggal ' . $currentDate->isoFormat('D [bulan] MMMM [tahun] YYYY') . ' (' . $currentDate->format('d/m/Y') . ')';
@endphp


<br>
<p style="text-align: justify ;  width: 100%;">Pada hari ini .......... tanggal .... bulan .......... tahun .......... (...../...../.......) bertempat di kantor 
    @if(Auth::user()->gocap_id_pc_pengurus)
      NU Care LAZISNU Cilacap
    @else
    UPZIS MWCNU {{ strtoupper($upziss) }}
    @endif
    telah
    dilaksanakan serah terima laporan closing Divisi Program untuk periode {{ $startDate . ' - ' . $endDate }} dengan rincian sebagai berikut :
</p>


<div>
    <table style="width: 100%; font-size: 11pt; border: 1px solid black; margin: auto;">
        <tr>
            <td style="border: 1px solid black;width: 10%; text-align:center;">NO</td>
            <td style="border: 1px solid black;width: 30%;text-align:center;">PILAR PROGRAM</td>
            <td style="border: 1px solid black;width: 30%;text-align:center; text-align:right;">Grafik By Pilar</td>
            <td style="border: 1px solid black;width: 30%;text-align:center; text-align:right;">Grafik By Nominal</td>
      
        </tr>

        <tr>
            <td style="border: 1px solid black;width: 10%; text-align:center;">1</td>
            <td style="border: 1px solid black;width: 30%">Ekonomi</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ $program_ekonomi }} Pilar</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($ekonomi, 0, '.', '.') }}</td>
           



        </tr>

        <tr>
            <td style="border: 1px solid black;width: 10%; text-align:center;">2</td>
            <td style="border: 1px solid black;width: 30%">Pendidikan</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ $program_pendidikan }} Pilar</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($pendidikan, 0, '.', '.') }}</td>
    
    


        </tr>

        <tr>
            <td style="border: 1px solid black;width: 10%; text-align:center;">3</td>
            <td style="border: 1px solid black;width: 30%">Kesehatan</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ $program_kesehatan }} Pilar</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($kesehatan, 0, '.', '.') }}</td>
   
    


        </tr>

        <tr>
            <td style="border: 1px solid black;width: 10%; text-align:center;">4</td>
            <td style="border: 1px solid black;width: 30%">Dakwah dan Advokasi</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ $program_dakwah }} Pilar</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($dakwah, 0, '.', '.') }}</td>
  
    

        </tr>

        <tr>
            <td style="border: 1px solid black;width: 10%; text-align:center;">5</td>
            <td style="border: 1px solid black;width: 30%">Kemanusiaan</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ $program_kemanusiaan }} Pilar</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($kemanusiaan, 0, '.', '.') }}</td>

          


        </tr>

        <tr>
            <td style="border: 1px solid black;width: 10%; text-align:center;">6</td>
            <td style="border: 1px solid black;width: 30%">Lingkungan</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ $program_lingkungan }} Pilar</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($lingkungan, 0, '.', '.') }}</td>
          
        

        </tr>

        <tr>
            <td style="border: 1px solid black;width: 10%; text-align:center;">7</td>
            <td style="border: 1px solid black;width: 30%">Kelembagaan</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ $program_kelembagaan }} Pilar</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($kelembagaan, 0, '.', '.') }}</td>
          
          


        </tr>


        <tr>
            <td style="border-right: none;width: 10%; text-align:center;"></td>
            <td style="border-left: none;width: 30%;text-align:center;"><b>TOTAL</b></td>
            <td style="border: 1px solid black;width: 30%;text-align:right;"><b>{{ $program_total_jumlah }} Pilar</b></td>
            <td style="border: 1px solid black;width: 30%;text-align:right;"><b>Rp {{ number_format($total_jumlah, 0, '.', '.') }}</b></td>
      


        </tr>

    </table>
</div>
