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
    if ($tings == 'ranting' || $tings == 'keseluruhan') {
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
    <b>PENTASYARUFAN 
        @if($tings == 'ranting')
            @if ($id_ranting2)
            TINGKAT RANTING {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_ranting($id_ranting2)) }}
            @else
            TINGKAT RANTING
            @endif
        @elseif($tings == 'upzis')
            TINGKAT UPZIS {{ strtoupper($upziss) }}
        @elseif($tings == 'keseluruhan')
            PER WILAYAH KECAMATAN {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($id_upzis2)) }}
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
            <td style="border: 1px solid black;width: 6%; text-align:center;">NO</td>
            <td style="border: 1px solid black;width: 30%;text-align:center;">PILAR PROGRAM</td>
            <td style="border: 1px solid black;width: 30%;text-align:center; text-align:right;">NOMINAL DICAIRKAN</td>
            <td style="border: 1px solid black;width: 10%;text-align:center; text-align:right;">%</td>
            <td style="border: 1px solid black;width: 10%;text-align:center; text-align:right;">PM</td>
            <td style="border: 1px solid black;width: 10%;text-align:center; text-align:right;">%</td>
        </tr>

        {{-- <tr>
            <td style="border: 1px solid black;width: 6%; text-align:center;">1</td>
            <td style="border: 1px solid black;width: 30%">Hukum dan Keadilan</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($hukum, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_hukum }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ number_format($pm_hukum, 0, '.', '.') }}</td>
             <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_pm_hukum }}</td>
        </tr> --}}

        <tr>
            <td style="border: 1px solid black;width: 6%; text-align:center;">1</td>
            <td style="border: 1px solid black;width: 30%">NU Care Berdaya (Ekonomi)</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($ekonomi, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_ekonomi }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ number_format($pm_ekonomi, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_pm_ekonomi }}</td>


        </tr>

        <tr>
            <td style="border: 1px solid black;width: 6%; text-align:center;">2</td>
            <td style="border: 1px solid black;width: 30%">NU Care Cerdas (Pendidikan)</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($pendidikan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_pendidikan }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ number_format($pm_pendidikan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_pm_pendidikan }}</td>


        </tr>

        <tr>
            <td style="border: 1px solid black;width: 6%; text-align:center;">3</td>
            <td style="border: 1px solid black;width: 30%">NU Care Sehat (Kesehatan)</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($kesehatan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_kesehatan }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ number_format($pm_kesehatan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_pm_kesehatan }}</td>


        </tr>

        {{-- <tr>
            <td style="border: 1px solid black;width: 6%; text-align:center;">4</td>
            <td style="border: 1px solid black;width: 30%">Dakwah dan Advokasi</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($dakwah, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_dakwah }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ number_format($pm_dakwah, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_pm_dakwah }}</td>

        </tr> --}}

        <tr>
            <td style="border: 1px solid black;width: 6%; text-align:center;">4</td>
            <td style="border: 1px solid black;width: 30%">NU Care DAMAI (Dakwah & Kemanusiaan)</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($kemanusiaan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_kemanusiaan }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ number_format($pm_kemanusiaan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_pm_kemanusiaan }}</td>


        </tr>

        <tr>
            <td style="border: 1px solid black;width: 6%; text-align:center;">5</td>
            <td style="border: 1px solid black;width: 30%">NU Care Hijau (Lingkungan)</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($lingkungan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_lingkungan }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ number_format($pm_lingkungan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_pm_lingkungan }}</td>

        </tr>

        <tr>
            <td style="border: 1px solid black;width: 6%; text-align:center;">6</td>
            <td style="border: 1px solid black;width: 30%">Operasional/Amil</td>
            <td style="border: 1px solid black;width: 30%;text-align:right;">{{ number_format($kelembagaan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_kelembagaan }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ number_format($pm_kelembagaan, 0, '.', '.') }}</td>
            <td style="border: 1px solid black;width: 10%;text-align:right;">{{ $p_pm_kelembagaan }}</td>


        </tr>


        <tr>
            <td style="border-right: none;width: 6%; text-align:center;"></td>
            <td style="border-left: none;width: 30%;text-align:center;"><b>TOTAL</b></td>
            <td style="border: 1px solid black;width: 30%;text-align:right;"><b>Rp {{ number_format($total_jumlah, 0, '.', '.') }}</b></td>
            <td style="border: 1px solid black;width: 10%;text-align:right;"><b>{{ $total_persentase .'%' }}</b></td>
            <td style="border: 1px solid black;width: 10%;text-align:right;"><b>{{ number_format($pm_total_jumlah, 0, '.', '.') }}</b></td>
            <td style="border: 1px solid black;width: 10%;text-align:right;"><b>{{ $total_persentase_pm .'%' }}</b></td>


        </tr>

    </table>
</div>

<div></div>
@if(Auth::user()->gocap_id_pc_pengurus)
<table>

    <tr>
        <td colspan="2" style="text-align: center; widht:100%;">Di laporkan dan di serahkan oleh:</td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center; widht:100%;">DIVISI ADMINISTASI PROGRAM:</td>
    </tr>

    <tr>
        <td colspan="2" style="text-align: center; widht:100%;"><img height="70vh;"
            src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697182882.Mu'afah,%20S.E.jpg" alt=""></td>
    </tr>


    <tr>
        <td colspan="2" style="text-align: center; widht:100%;">MU'AFAH, S.E</td>
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
    </tr>


    <tr>
        <td style="text-align: center;width:50%;">Di terima dan di setujui oleh:</td>
           <td style="text-align: center;width:50%;">Di terima dan di periksa oleh</td>
       </tr>

       <tr>
        <td style="text-align: center;width:50%;">Ketua NU Care LAZISNU Cilacap :</td>
           <td style="text-align: center;width:50%;">Direktur Manajemen Eksekutif</td>
       </tr>

    <tr>
        <td style="text-align: center;width:50%;"><img height="70vh;"
            src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697426218.H.%20Wasbah%20Samudra%20Fawaid,%20S.E.jpg"
            alt=""></td>
        <td style="text-align: center;width:50%;"><img height="70vh;"
                src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697426100.Ahmad%20Fauzi,%20S.Pd.I.jpg"
                alt=""></td>
     
    </tr>

    <tr>
        <td style="text-align: center;width:50%;">H. WASBAH SAMUDRA FAWAID, S.E</td>
        <td style="text-align: center;width:50%;">AHMAD FAUZI, S.Pd. I</td>
    </tr>

  


</table>
@else

@php
    $admin_upzis = \App\Models\UpzisPengurus::where('id_upzis',Auth::user()->UpzisPengurus->Upzis->id_upzis)->where('id_pengurus_jabatan','c2a4bbd8-85c2-11ed-a0ac-040300000000')->value('id_upzis_pengurus');
    $nama_admin_upzis = \App\Models\Pengguna::where('gocap_id_upzis_pengurus',$admin_upzis)->value('nama');

    $ketua_upzis = \App\Models\UpzisPengurus::where('id_upzis',Auth::user()->UpzisPengurus->Upzis->id_upzis)->where('id_pengurus_jabatan','c699f7c7-7791-11ed-97ee-e4a8df91d8b3')->value('id_upzis_pengurus');
    $nama_ketua_upzis = \App\Models\Pengguna::where('gocap_id_upzis_pengurus',$ketua_upzis)->value('nama');

    $bendahara_upzis = \App\Models\UpzisPengurus::where('id_upzis',Auth::user()->UpzisPengurus->Upzis->id_upzis)->where('id_pengurus_jabatan','8eb03fef-5a7c-11ed-9dd2-e4a8df91d8b3')->value('id_upzis_pengurus');
    $nama_bendahara_upzis = \App\Models\Pengguna::where('gocap_id_upzis_pengurus',$bendahara_upzis)->value('nama');
@endphp

<table>
    <tr>
        <td style="text-align: center;width:50%;"><br><br><br></td>
        <td style="text-align: center;width:50%;"><br><br><br></td>
    </tr>

    <tr>
        <td style="text-align: center;width:50%;"><u>{{ $nama_admin_upzis ?? '' }}</u></td>
        <td style="text-align: center;width:50%;"><u>{{ $nama_bendahara_upzis ?? '' }}</u></td>
    </tr>

    <tr>
        <td style="text-align: center;width:50%;">Admin Upzis</td>
        <td style="text-align: center;width:50%;">Bendahara</td>
    </tr>

    <tr>
        <td><br></td>
        <td><br></td>
    </tr>

    <tr>
        <td colspan="2" style="text-align: center; widht:100%;">Mengetahui,</td>
    </tr>

    <tr>
        <td colspan="2" style="text-align: center; widht:100%;"><br><br><br></td>
    </tr>


    <tr>
        <td colspan="2" style="text-align: center; widht:100%;"><u>{{ $nama_ketua_upzis ?? '' }}</u></td>
    </tr>


    <tr>
        <td colspan="2" style="text-align: center; widht:100%;">Ketua Upzis </td>
    </tr>

</table>
@endif
