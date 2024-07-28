<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Laporan;
use App\Models\PengajuanDetail;
use App\Models\ArusDana;
use App\Models\ProgramPilar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\BasicHelper;
use Illuminate\Support\Str;

// use Session;

class LaporanController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $role = 'pc';
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $role = 'upzis';
            }
            $view->with('role', $role);
        });
    }

    public function getvalue(Request $request)
    {
        $value = "Nilai dari server123" . $request->input('id');
        $value2 = "Value 2";
        $data = array('value' => $value, 'value2' => $value2);
        return response()->json($data);
    }


    public function ubah_laporankeu(Request $request)
    {

        $cek =   Laporan::where('bulan', $request->bulan)->where('tahun', $request->tahun)->first();

        if ($cek == NULL) {
            Laporan::create([
                'id_laporan' => Str::uuid()->toString(),
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'sab_sosial' => isset($request->sab_sosial) ? str_replace('.', '', $request->sab_sosial) : null,
                'sab_kelembagaan' => isset($request->sab_kelembagaan) ? str_replace('.', '', $request->sab_kelembagaan) : null,
                'sab_operasional' => isset($request->sab_operasional) ? str_replace('.', '', $request->sab_operasional) : null,
                'sak_sosial' => isset($request->sak_sosial) ? str_replace('.', '', $request->sak_sosial) : null,
                'sak_kelembagaan' => isset($request->sak_kelembagaan) ? str_replace('.', '', $request->sak_kelembagaan) : null,
                'sak_operasional' => isset($request->sak_operasional) ? str_replace('.', '', $request->sak_operasional) : null,
                'keterangan' => $request->keterangan,

            ]);
        } else {
            Laporan::where('bulan', $request->bulan)->where('tahun', $request->tahun)->update([
                'sab_sosial' => isset($request->sab_sosial) ? str_replace('.', '', $request->sab_sosial) : null,
                'sab_kelembagaan' => isset($request->sab_kelembagaan) ? str_replace('.', '', $request->sab_kelembagaan) : null,
                'sab_operasional' => isset($request->sab_operasional) ? str_replace('.', '', $request->sab_operasional) : null,
                'sak_sosial' => isset($request->sak_sosial) ? str_replace('.', '', $request->sak_sosial) : null,
                'sak_kelembagaan' => isset($request->sak_kelembagaan) ? str_replace('.', '', $request->sak_kelembagaan) : null,
                'sak_operasional' => isset($request->sak_operasional) ? str_replace('.', '', $request->sak_operasional) : null,
                'keterangan' => $request->keterangan,

            ]);
        }

        session()->flash('toast');
        return redirect('/upzis/laporankeu');
    }


    public function laporankeu()
    {
        $title = "LAPORAN KEUANGAN";
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id_upzis = Auth::user()->UpzisPengurus->Upzis->id_upzis;

        $tahun = date('Y'); // Mendapatkan tahun saat ini
        $bulan = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);

        $dataLaporan = DB::table($etasyaruf . '.laporan')
            ->whereIn('bulan', $bulan)
            ->get();

        // dd($dataLaporan);

        $bul = array();

        foreach ($bulan as $value) {
            $filteredData = $dataLaporan->firstWhere('bulan', $value);
            $sab_sosial = $filteredData ? $filteredData->sab_sosial : '-';
            $sab_kelembagaan = $filteredData ? $filteredData->sab_kelembagaan : '-';
            $sab_operasional = $filteredData ? $filteredData->sab_operasional : '-';
            $sak_sosial = $filteredData ? $filteredData->sak_sosial : '-';
            $sak_kelembagaan = $filteredData ? $filteredData->sak_kelembagaan : '-';
            $sak_operasional = $filteredData ? $filteredData->sak_operasional : '-';
            $saldo_akhir = $filteredData ? $filteredData->saldo_akhir : '-';
            $keterangan = $filteredData ? $filteredData->keterangan : '-';

            $bul[] = [
                'bulan' => $value,
                'sab_sosial' => $sab_sosial,
                'sab_kelembagaan' => $sab_kelembagaan,
                'sab_operasional' => $sab_operasional,
                'sak_sosial' => $sak_sosial,
                'sak_kelembagaan' => $sak_kelembagaan,
                'sak_operasional' => $sak_operasional,
                'saldo_akhir' => $saldo_akhir,
                'keterangan' => $keterangan,

                // pilar
                'id_pilar_kesehatan' => '2a700a8d-dd49-46d3-9e25-2953266cf9a5',
                'id_pilar_ekonomi' => '30746c18-3f7a-4736-ae47-ea91154a5a00',
                'id_pilar_kelembagaan' => '9e2ea277-9550-4ff7-bd6a-5fb36ef30633',
                'id_pilar_dakwah' => 'cde8bd7b-7467-40c5-a92a-957a8176aed9',
                'id_pilar_kemanusiaan' => 'ce2ac72c-02bc-4d8c-b143-9d526b1edd2b',
                'id_pilar_lingkungan' => 'd578e2e4-23d4-4cc6-9657-2415ba633420',
                'id_pilar_pendidikan' => 'e47c6722-98b5-42b9-9b37-22f7b8437450',

            ];
        }

        return view(
            'laporan.laporankeu',
            compact('title', 'id_upzis', 'tahun', 'bul')
        );
    }

    public function laporanpenyaluran($bulan, $tahun, $id_upzis)
    {
        $title = "LAPORAN PENYALURAN";


        $id_upzis = strtolower($id_upzis);
        $id_program_sosial = 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_kelembagaan = 'ba84d782-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_operasional = 'c51700b1-81a8-11ed-b4ef-dc215c5aad51';


        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $letter_a = range('A', 'Z');
        $letter_b = range('A', 'Z');
        $letter_c = range('A', 'Z');

        $pilar_sosial = ProgramPilar::where('program_pilar.id_program', $id_program_sosial)->get();
        $pilar_kelembagaan = ProgramPilar::where('program_pilar.id_program', $id_program_kelembagaan)->get();
        $pilar_operasional = ProgramPilar::where('program_pilar.id_program2', $id_program_operasional)->get();
        // $pilar_sosial = ProgramPilar::where('program_pilar.id_program', $id_program_sosial)->leftjoin($etasyaruf . '.pengajuan_detail', $etasyaruf . '.pengajuan_detail.id_program_pilar', '=', $etasyaruf . '.program_pilar.id_program_pilar')->get();

        // $data_sosial = PengajuanDetail::whereMonth('created_at', '04')->whereYear('created_at', '2023')->where('id_program', $id_program_sosial)
        //     ->get();

        // dd($pilar_operasional);

        return view(
            'laporan.laporanpenyaluran',
            compact(
                'title',
                'bulan',
                'tahun',
                'id_upzis',
                'pilar_sosial',
                'pilar_kelembagaan',
                'pilar_operasional',
                'letter_a',
                'letter_b',
                'letter_c'

            )
        );
    }

    public function laporanperudana($bulan, $tahun, $id_upzis)
    {
        $title = "LAPORAN PERUBAHAN DANA";
        $pilar = ProgramPilar::get();
        $sab = Laporan::where('bulan', $bulan)->where('tahun', $tahun)->firstOrFail();
        $bank = $sab->sab_sosial + $sab->sab_kelembagaan + $sab->sab_operasional;
        $sak = Laporan::where('bulan', $bulan)->where('tahun', $tahun)->firstOrFail();
        $kas = $sak->sak_sosial + $sak->sak_kelembagaan + $sak->sak_operasional;
        $gocap = config('app.database_gocap');

        // SOSIAL
        $sosial = Rekening::where('id_upzis', $id_upzis)
            ->where('id_ranting', NULL)
            ->where('nama_rekening', 'PROGRAM SOSIAL UPZIS MWC NU ' . strtoupper(Auth::user()->UpzisPengurus->Upzis->Wilayah->nama))
            ->firstOrFail();
        $id_rekening_sosial = $sosial->id_rekening;
        // KELEMBAGAAN
        $kelembagaan = Rekening::where('id_upzis', $id_upzis)
            ->where('id_ranting', NULL)
            ->where('nama_rekening', 'DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper(Auth::user()->UpzisPengurus->Upzis->Wilayah->nama))
            ->firstOrFail();
        $id_rekening_kelembagaan = $kelembagaan->id_rekening;

        // OPERASIONAL
        $operasional = Rekening::where('id_upzis', $id_upzis)
            ->where('id_ranting', NULL)
            ->where('nama_rekening', 'DANA OPERASIONAL & UJROH UPZIS MWC NU ' . strtoupper(Auth::user()->UpzisPengurus->Upzis->Wilayah->nama))
            ->firstOrFail();
        $id_rekening_operasional = $operasional->id_rekening;

        // pengeluaran lainnya
        $pengeluaran_lainnya = ArusDana::where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Mutasi Rekening')
            ->whereYear($gocap . '.arus_dana.created_at', $tahun)
            ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
            // ->where('id_rekening', $id_rekening)
            ->get();

        return view(
            'laporan.laporanperudana',
            compact(
                'title',
                'bulan',
                'tahun',
                'id_upzis',
                'pilar',
                'id_rekening_sosial',
                'id_rekening_kelembagaan',
                'id_rekening_operasional',
                'bank',
                'kas',
                'pengeluaran_lainnya',
            )
        );
    }

    public static function getPenerimaanPerProgram($bulan, $tahun, $id_rekening)
    {
        $nama_upzis = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;

        $a = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening)
            ->sum('nominal');

        if ($a != 0) {
            return '<span style="float: left;">Rp</span>'
                . '<span style="float: right;">' . number_format($a, 0, '.', '.')  . ',-</span>';
        } else {
            return '<span style="float: left;"></span>'
                . '<span style="float: right;">-</span>';
        }
    }


    public static function getPenerimaanLainnya($bulan, $tahun)
    {
        $gocap = config('app.database_gocap');

        $a = ArusDana::where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Mutasi Rekening')
            ->whereYear($gocap . '.arus_dana.created_at', $tahun)
            ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
            // ->where('id_rekening', $id_rekening)
            ->sum('nominal');

        if ($a != 0) {
            return '<span style="float: left;">Rp</span>'
                . '<span style="float: right;">' . number_format($a, 0, '.', '.')  . ',-</span>';
        } else {
            return '<span style="float: left;"></span>'
                . '<span style="float: right;">-</span>';
        }
    }

    // public static function getPengeluaranLainnya($bulan, $tahun)
    // {
    //     $gocap = config('app.database_gocap');

    //     $a = ArusDana::where('jenis_dana', 'keluar')
    //         ->where('jenis_kas', 'Mutasi Rekening')
    //         ->whereYear($gocap . '.arus_dana.created_at', $tahun)
    //         ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
    //         // ->where('id_rekening', $id_rekening)
    //         ->sum('nominal');

    //     if ($a != 0) {
    //         return '<span style="float: left;">Rp</span>'
    //             . '<span style="float: right;">' . number_format($a, 0, '.', '.')  . ',-</span>';
    //     } else {
    //         return '<span style="float: left;"></span>'
    //             . '<span style="float: right;">-</span>';
    //     }
    // }



    public static function getJumlahPenerimaan($bulan, $tahun, $id_rekening_sosial, $id_rekening_kelembagaan, $id_rekening_operasional)
    {
        $nama_upzis = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
        $gocap = config('app.database_gocap');


        $a = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_sosial)
            ->sum('nominal');
        $b = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_kelembagaan)
            ->sum('nominal');
        $c = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_operasional)
            ->sum('nominal');

        // penerimaan lainnya
        $d = ArusDana::where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Mutasi Rekening')
            ->whereYear($gocap . '.arus_dana.created_at', $tahun)
            ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
            // ->where('id_rekening', $id_rekening)
            ->sum('nominal');

        if ($a + $b + $c + $d != 0) {
            return '<span style="float: left;">Rp</span>'
                . '<span style="float: right;">' . number_format($a + $b + $c  + $d, 0, '.', '.')  . ',-</span>';
        } else {
            return '<span style="float: left;"></span>'
                . '<span style="float: right;">-</span>';
        }
    }

    public static function getJumlahPerPilar($bulan, $tahun, $id_upzis, $id_program_pilar)
    {
        $etasyaruf = config('app.database_etasyaruf');

        $jumlah_per_pilar = PengajuanDetail::whereMonth($etasyaruf . '.pengajuan_detail.tgl_pelaksanaan', $bulan)
            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->whereYear($etasyaruf . '.pengajuan_detail.created_at', $tahun)->where('id_program_pilar', $id_program_pilar)
            ->whereNotNull('id_pc')
            ->where('id_upzis', $id_upzis)
            ->whereNull('id_ranting')
            ->sum('nominal_disetujui');


        return $jumlah_per_pilar;
    }

    // public static function getJumlahPilar($bulan, $tahun, $id_upzis, $id_pilar)
    // {
    //     $etasyaruf = config('app.database_etasyaruf');

    //     $jumlah_akhir = PengajuanDetail::whereMonth($etasyaruf . '.pengajuan_detail.created_at', $bulan)
    //         ->whereYear($etasyaruf . '.pengajuan_detail.created_at', $tahun)
    //         ->where('id_program_pilar', $id_pilar)
    //         ->where('approval_status', 'Disetujui')
    //         ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
    //         ->whereNotNull('id_pc')
    //         ->where('id_upzis', $id_upzis)
    //         ->whereNull('id_ranting')
    //         ->sum('nominal_disetujui');

    //     if ($jumlah_akhir != 0) {
    //         return '<span style="float: left;">Rp</span>'
    //             . '<span style="float: right;">' . number_format($jumlah_akhir, 0, '.', '.')  . ',-</span>';
    //     } else {
    //         return '<span style="float: left;"></span>'
    //             . '<span style="float: right;">-</span>';
    //     }
    // }

    // public static function getJumlahPenerimaManfaat($bulan, $tahun, $id_upzis, $id_pilar)
    // {
    //     $etasyaruf = config('app.database_etasyaruf');

    //     $jumlah_penerima_akhir = PengajuanDetail::whereMonth($etasyaruf . '.pengajuan_detail.created_at', $bulan)
    //         ->whereYear($etasyaruf . '.pengajuan_detail.created_at', $tahun)
    //         ->where('id_program_pilar', $id_pilar)
    //         ->where('approval_status', 'Disetujui')
    //         ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
    //         ->whereNotNull('id_pc')
    //         ->where('id_upzis', $id_upzis)
    //         ->whereNull('id_ranting')
    //         ->sum('jumlah_penerima');

    //     return $jumlah_penerima_akhir;
    // }

    // public static function getJumlahPenyaluranProgram($bulan, $tahun, $id_upzis)
    // {
    //     $etasyaruf = config('app.database_etasyaruf');
    //     $jumlah_akhir = PengajuanDetail::whereMonth($etasyaruf . '.pengajuan_detail.created_at', $bulan)
    //         ->whereYear($etasyaruf . '.pengajuan_detail.created_at', $tahun)
    //         ->where('approval_status', 'Disetujui')
    //         ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
    //         ->whereNotNull('id_pc')
    //         ->where('id_upzis', $id_upzis)
    //         ->whereNull('id_ranting')
    //         ->sum('nominal_disetujui');

    //     if ($jumlah_akhir != 0) {
    //         return '<span style="float: left;">Rp</span>'
    //             . '<span style="float: right;">' . number_format($jumlah_akhir, 0, '.', '.')  . ',-</span>';
    //     } else {
    //         return '<span style="float: left;"></span>'
    //             . '<span style="float: right;">-</span>';
    //     }
    // }

    // public static function getJumlahPenerimaManfaatTotal($bulan, $tahun, $id_upzis)
    // {
    //     $etasyaruf = config('app.database_etasyaruf');
    //     $jumlah_penerima_akhir = PengajuanDetail::whereMonth($etasyaruf . '.pengajuan_detail.created_at', $bulan)
    //         ->whereYear($etasyaruf . '.pengajuan_detail.created_at', $tahun)
    //         ->where('approval_status', 'Disetujui')
    //         ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
    //         ->whereNotNull('id_pc')
    //         ->where('id_upzis', $id_upzis)
    //         ->whereNull('id_ranting')
    //         ->sum('jumlah_penerima');

    //     return $jumlah_penerima_akhir;
    // }

    public static function getSaldoAkhir($bulan, $tahun, $id_upzis, $jumlah_saldo_awal, $id_rekening_sosial, $id_rekening_kelembagaan, $id_rekening_operasional)
    {
        $nama_upzis = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        // penerimaan
        $a = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_sosial)
            ->sum('nominal');
        $b = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_kelembagaan)
            ->sum('nominal');
        $c = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_operasional)
            ->sum('nominal');

        // penerimaan lainnya
        $d = ArusDana::where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Mutasi Rekening')
            ->whereYear($gocap . '.arus_dana.created_at', $tahun)
            ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
            // ->where('id_rekening', $id_rekening)
            ->sum('nominal');



        $hasil = $a + $b + $c + $d;

        // penyaluran
        $x = PengajuanDetail::whereMonth($etasyaruf . '.pengajuan_detail.tgl_pelaksanaan', $bulan)
            ->whereYear($etasyaruf . '.pengajuan_detail.tgl_pelaksanaan', $tahun)
            ->where('approval_status', 'Disetujui')
            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->whereNotNull('id_pc')
            ->where('id_upzis', $id_upzis)
            ->whereNull('id_ranting')
            ->sum('nominal_disetujui');

        // pengeluaran lainnya
        $y = ArusDana::where('jenis_dana', 'keluar')
            ->where('jenis_kas', 'Mutasi Rekening')
            ->whereYear($gocap . '.arus_dana.created_at', $tahun)
            ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
            // ->where('id_rekening', $id_rekening)
            ->sum('nominal');

        $jumlah_akhir_penyaluran = $x + $y;

        $laporan = Laporan::where('bulan', $bulan)->where('tahun', $tahun)->first();

        if ($laporan != null) {
            Laporan::where('bulan', $bulan)->where('tahun', $tahun)->update([
                'saldo_akhir' => $jumlah_saldo_awal + $hasil - $jumlah_akhir_penyaluran,
            ]);
        }


        if ($jumlah_saldo_awal + $hasil - $jumlah_akhir_penyaluran != 0) {
            return '<span style="float: left;">Rp</span>'
                . '<span style="float: right;">' . number_format($jumlah_saldo_awal + $hasil - $jumlah_akhir_penyaluran, 0, '.', '.')  . ',-</span>';
        } else {
            return '<span style="float: left;"></span>'
                . '<span style="float: right;">-</span>';
        }
    }
}
