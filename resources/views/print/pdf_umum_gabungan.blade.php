    @php
        [$start, $end] = explode(' - ', $filter_daterange2);
        $startDate = \Carbon\Carbon::parse($start)->locale('id')->isoFormat('D MMMM Y');
        $endDate = \Carbon\Carbon::parse($end)->locale('id')->isoFormat('D MMMM Y');
    @endphp


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

    @if ($tings == 'ranting')
        @php
            $tl = 'TINGKAT RANTING';
        @endphp
    @else
        @php
            $tl = 'KESELURUHAN (PC LAZISNU, UPZIS, RANTING)';
        @endphp
    @endif



    <p style="margin:0pt; text-align:center; font-size:11pt;">
        <b>DATA REALISASI PENTASYARUFAN BY PILAR & PROGRAM KESELURUHAN (PC LAZISNU, UPZIS,RANTING)</b>
        <br>
        <b> BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR</b>
    </p>


    @if ($sub == 'pengajuan')
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
            <td style="width: 19%"><b>Total Pencairan</b></td>
            <td style="width: 1%">:</td>
            <td style="width: 80%">
                Rp{{ number_format($sum_pencairan, 0, '.', '.') }},-
                {{-- ({{ $program->count() }} Pentasyarufan) --}}
            </td>
        </tr>

        <tr>
            <td style="width: 19%"><b>Total Penerima Manfaat</b></td>
            <td style="width: 1%">:</td>
            <td style="width: 80%">
                {{ $sum_penerima }}
            </td>
        </tr>


        <tr>
            <td style="width: 19%"><b>UPZIS MWCNU</b></td>
            <td style="width: 1%">:</td>
            <td style="width: 80%">
                @if ($tings == 'keseluruhan')
                    @if ($id_upzis2)
                        {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($id_upzis2)) }}
                    @else
                        Semua
                    @endif
                @elseif($tings == 'ranting')
                    @if ($id_upzis2)
                        {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($id_upzis2)) }}
                    @else
                        Semua
                    @endif
                @elseif($tings == 'upzis')
                    @if ($id_upzis)
                        {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($id_upzis)) }}
                    @else
                        Semua
                    @endif
                @else
                    Semua
                @endif
            </td>
        </tr>


        @if ($tings == 'ranting')
            <tr>
                <td style="width: 19%"><b>RANTING MWCNU</b></td>
                <td style="width: 1%">:</td>
                <td style="width: 80%">
                    @if ($id_ranting2)
                        {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_ranting($id_ranting2)) }}
                    @else
                        Semua
                    @endif
                </td>
            </tr>
        @endif

    </table>

    <br>
    <div></div>

    <table cellpadding="1" cellspacing="0" style="width:100%;border-collapse:collapse;font-size:10pt;">

        <thead>
            <tr style="text-align:center; background-color:#cbf2d6; border: 1px solid black;">
                <td style="width: 3%;vertical-align:middle; border: 1px solid black;"><b>NO</b></td>
                <td style="width: 20%;vertical-align:middle; border: 1px solid black;"><b>NAMA PROGRAM</b></td>
                <td style="width: 18%;vertical-align:middle; border: 1px solid black;"><b>SUMBER DANA</b></td>
                <td style="width: 13%;vertical-align:middle; border: 1px solid black;"><b>TGL <br> KONFIRMASI</b></td>
                <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>NOMINAL<br> PENGAJUAN </b>
                </td>
                <td style="width: 13%;vertical-align:middle; border: 1px solid black;"><b>TGL <br> REKOM / REALISASI</b></td>
                <td style="width: 12%;vertical-align:middle; border: 1px solid black;"><b>NOMINAL <br> PENCAIRAN</b>
                </td>
                <td style="width: 9%;vertical-align:middle; border: 1px solid black;"><b>PENERIMA MANFAAT</b></td>
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

                    <tr style="background-color:#cbf2d6; text-align: left; page-break-inside: avoid;">
                        <td style="width: 54%;vertical-align:middle;padding-left:3.0mm;border-left: 1px solid black;border-bottom: 1px solid black;"
                            colspan="4">
                            <b>{{ strtoupper(chr(64 + $loop->iteration)) }}. {{ $pilar }} </b>
                        </td>

                        <td
                            style="width: 12%;vertical-align:middle;border-bottom: 1px solid black; text-align:center; ">
                            <b>Rp{{ number_format($jumlah_nominal_pengajuan, 0, '.', '.') }},-</b>
                        </td>
                        <td style="width: 13%;border-bottom: 1px solid black; text-align:center; "></td>
                        <td
                            style="width: 12%;vertical-align:middle;border-bottom: 1px solid black; text-align:center; ">
                            <b>Rp{{ number_format($jumlah_nominal_pencairan, 0, '.', '.') }},-</b>
                        </td>
                        <td
                            style="width: 9%;vertical-align:middle;border-right: 1px solid black; text-align:center; border-bottom: 1px solid black;">
                            <b>{{ $jumlah_penerima_manfaat }}</b>
                        </td>
                    </tr>

                    @php
                        $uniquePrograms = $details->unique('nama_program');
                    @endphp

                    {{-- foreach data --}}
                    @foreach ($uniquePrograms as $a)
                        @php
                            // Anda mungkin perlu menyesuaikan ini tergantung pada struktur model dan propertinya
                            $firstDetail = $details->where('nama_program', $a->nama_program)->first();
                        @endphp

                        <tr style="background-color:#e6e6e6; text-align: left; page-break-inside: avoid;">
                            <td style="width: 54%;vertical-align:middle;padding-left:3.0mm;border-left: 1px solid black;border-bottom: 1px solid black;"
                                colspan="4">
                                <b>{{ $loop->iteration }}.
                                    {{ app\Http\Controllers\PengajuanController::get_nama_program($firstDetail->id_program_kegiatan) }}
                                </b>
                            </td>

                            <td
                                style="width: 12%;vertical-align:middle;border-bottom: 1px solid black;text-align:center;">
                                <b>Rp{{ number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pengajuan'), 0, '.', '.') }},-</b>
                            </td>
                            <td style="width: 13%;border-bottom: 1px solid black;text-align:center;"></td>
                            <td
                                style="width: 12%;vertical-align:middle;border-bottom: 1px solid black;text-align:center;">
                                <b>Rp{{ number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pencairan'), 0, '.', '.') }},-</b>
                            </td>
                            <td
                                style="width: 9%;vertical-align:middle;border-right: 1px solid black;text-align:center;border-bottom: 1px solid black;">
                                <b>{{ $details->where('nama_program', $a->nama_program)->sum('jumlah_penerima') }}</b>
                            </td>
                        </tr>



                        @foreach ($details->where('nama_program', $a->nama_program) as $b)
                            <tr style=" page-break-inside: avoid;">
                                <td
                                    style="width: 3%;border-bottom: 1px solid black;border-left: 1px solid black; vertical-align:top;padding-left:7mm;border-right:none;text-align:center;">
                                    {{ $loop->iteration }}</td>
                                <td
                                    style="width: 20%;vertical-align:middle; border-bottom: 1px solid black;border-right: 1px solid black; text-align:left;border-left:none;">
                                    {{ $b->pengajuan_note }}
                                </td>

                                <td
                                    style="width: 18%;vertical-align:middle; border: 1px solid black; text-align:center;">
                                    @if ($b->tingkat == 'Upzis MWCNU')
                                        <b>UPZ
                                            {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_upzis($b->id_upzis)) }}</b><br>{{ app\Http\Controllers\PengajuanController::get_nama_bmt($b->id_rekening) }}<br>({{ app\Http\Controllers\PengajuanController::no_rekening($b->id_rekening) }})
                                    @elseif($b->tingkat == 'Ranting NU')
                                        <b>RTG
                                            {{ strtoupper(app\Http\Controllers\PengajuanController::get_nama_ranting($b->id_ranting)) }}</b><br>{{ app\Http\Controllers\PengajuanController::get_nama_bmt($b->id_rekening) }}<br>({{ app\Http\Controllers\PengajuanController::no_rekening($b->id_rekening) }})
                                    @elseif($b->tingkat == 'PC')
                                        <b>PC LAZISNU</b><br>{{ $b->sumber_dana_opsi }} -
                                        {{ App\Models\Rekening::where('id_rekening', $b->id_rekening)->value('no_rekening') }}
                                    @endif
                                </td>

                                @php
                                    $tgl_konfirmasi = App\Models\Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_konfirmasi');
                                    $tgl_terbit_rekomendasi = App\Models\Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_terbit_rekomendasi');
                                @endphp
                                <td
                                    style="width: 13%;border: 1px solid black; vertical-align:middle;text-align:center;">
                                    {{ Carbon\Carbon::parse($tgl_konfirmasi)->isoFormat('D/M/Y') }}
                                </td>
                                <td
                                    style="width: 12%;border: 1px solid black; vertical-align:middle;text-align:center;">
                                    Rp{{ number_format($b->nominal_pengajuan, 0, '.', '.') }},-
                                </td>
                                <td
                                    style="width: 13%;border: 1px solid black; vertical-align:middle;text-align:center;">
                                    {{ Carbon\Carbon::parse($tgl_terbit_rekomendasi)->isoFormat('D/M/Y') }}
                                </td>
                                <td
                                    style="width: 12%;border: 1px solid black; vertical-align:middle;text-align:center;">
                                    Rp{{ number_format($b->nominal_pencairan, 0, '.', '.') }},-
                                </td>
                                <td style="width: 9%;border: 1px solid black; vertical-align:middle;text-align:center;">
                                    {{ $b->jumlah_penerima ?? '0' }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
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
