<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengajuan;
use App\Models\Rekening;
use App\Models\Programs;
use App\Models\ProgramPilar;
use App\Models\ProgramKegiatan;
use App\Models\PengajuanDetail;
use App\Models\PengajuanDokumentasi;
use App\Models\PengajuanPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
// use Session;
use Illuminate\Support\Str;

class ChartLaporanKeseluruhan extends Controller
{
    private static $etasyaruf;
    private static $siftnu;
    private static $gocap;

    private static function initConfig()
    {
        self::$etasyaruf = config('app.database_etasyaruf');
        self::$siftnu = config('app.database_siftnu');
        self::$gocap = config('app.database_gocap');
    }

    public static function getStatisticPengajuan($tipe, $tingkat, $id, $id2, $start_date, $end_date, $status)
    {
        self::initConfig();
        $data = DB::table(self::$etasyaruf . '.pengajuan')
            // ->when($status != 'Semua', function ($query) use ($status) {
            //     return $query->where('status_pengajuan', $status);
            // })

            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit');
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit');
            })

            ->when($id != NULL, function ($query) use ($id) {
                return $query->where('id_upzis', $id);
            })
            ->when( $id2 != NULL, function ($query) use ($id2) {
                return $query->where('id_ranting', $id2);
            })
            ->whereBetween(self::$etasyaruf . '.pengajuan.tgl_terbit_rekomendasi', [$start_date, $end_date]);

        if ($tipe == 'total') {
            $data = $data->count();
        } elseif ($tipe == 'program') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')->count();
        } elseif ($tipe == 'penerima') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')->sum('jumlah_penerima');
        } elseif ($tipe == 'dicairkan') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
                ->where('pencairan_status', 'Berhasil Dicairkan')
                ->sum('nominal_pencairan');
        } elseif ($tipe == 'program_total') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->rightJoin(self::$etasyaruf . '.program_kegiatan', self::$etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', self::$etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->count();
        } elseif ($tipe == 'nominal_total') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->sum('nominal_pengajuan');
        } elseif ($tipe == 'total_terbit_rekom') {
            $data = $data->where('status_pengajuan', 'Diajukan')->where('status_rekomendasi', 'Sudah Terbit')
            ->count();
        } elseif ($tipe == 'program_terbit_rekom') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->rightJoin(self::$etasyaruf . '.program_kegiatan', self::$etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', self::$etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->where('status_pengajuan', 'Diajukan')->where('status_rekomendasi', 'Sudah Terbit')
            ->count();
        } elseif ($tipe == 'nominal_terbit_rekom') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->where('status_pengajuan', 'Diajukan')->where('status_rekomendasi', 'Sudah Terbit')->where('pencairan_status','Berhasil Dicairkan')->where('status_pengajuan', '!=', 'Direncanakan')
            ->sum('nominal_pengajuan');
        } elseif ($tipe == 'total_dalam_proses') {
            $data = $data->where('status_pengajuan', 'Diajukan')->where('status_rekomendasi', 'Belum Terbit')
            ->count();
        } elseif ($tipe == 'program_dalam_proses') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->rightJoin(self::$etasyaruf . '.program_kegiatan', self::$etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', self::$etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->where('status_pengajuan', 'Diajukan')->where('status_rekomendasi', 'Belum Terbit')
            ->count();
        } elseif ($tipe == 'nominal_dalam_proses') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->where('status_pengajuan', 'Diajukan')->where('status_rekomendasi', 'Belum Terbit')
            ->sum('nominal_pengajuan');
        } elseif ($tipe == 'sudah_lpj') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->whereNotNull('file_berita')->count();
        } elseif ($tipe == 'nominal_sudah_lpj') {
            $data = $data->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->rightJoin(self::$etasyaruf . '.pengajuan_penerima_lpj', self::$etasyaruf . '.pengajuan_penerima_lpj.id_pengajuan_detail', '=', self::$etasyaruf . '.pengajuan_detail.id_pengajuan_detail')
            ->where('pencairan_status', 'Berhasil Dicairkan')->whereNotNull('file_berita')->sum('nominal_bantuan');
        } 

        // dd($data);
        return $data ?? NULL;

    }

    public static function getTotalByPilar($tingkat, $id_upzis, $id_ranting, $id_pilar, $start_date, $end_date, $status_lpj2)
    {
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        self::initConfig();
        $data = DB::table(self::$etasyaruf . '.pengajuan')
        ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
            return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
        })
        ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
            return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
        })
            ->when($id_upzis, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($id_ranting, function ($query) use ($id_ranting) {
                return $query->where('id_ranting', $id_ranting);
            })
         
            ->whereBetween(self::$etasyaruf . '.pengajuan.tgl_terbit_rekomendasi', [$start_date, $end_date])
            ->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->where('id_program_pilar', $id_pilar)
            ->count();

        return $data ?? NULL;
    }


    public static function getTotalByNominal($tingkat, $id_upzis, $id_ranting, $id_pilar, $start_date, $end_date, $status_lpj2)
    {
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        self::initConfig();
        $data = DB::table(self::$etasyaruf . '.pengajuan')
        ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
            return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
        })
        ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
            return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
        })
            ->when($id_upzis, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($id_ranting, function ($query) use ($id_ranting) {
                return $query->where('id_ranting', $id_ranting);
            })
         
            ->whereBetween(self::$etasyaruf . '.pengajuan.tgl_terbit_rekomendasi', [$start_date, $end_date])
            ->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->where('id_program_pilar', $id_pilar)
            ->sum('nominal_pencairan');

        return $data ?? NULL;
    }


    public static function getTotalPengajuan2($tingkat, $id)
    {
        self::initConfig();
        $data = DB::table(self::$etasyaruf . '.pengajuan')->where('id_upzis', $id)
            ->count();

        return $data ?? NULL;
    }
}
