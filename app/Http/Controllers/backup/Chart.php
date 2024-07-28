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

class Chart extends Controller
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
            ->when($status != 'Semua', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($tingkat == 'upzis', function ($query) {
                return $query->where('tingkat', 'Upzis MWCNU')->whereNull('id_ranting');
            })
            ->when($tingkat == 'ranting', function ($query) {
                return $query->where('tingkat', 'Ranting NU');
            })
            ->when($id != NULL and $tingkat == 'upzis', function ($query) use ($id) {
                return $query->where('id_upzis', $id);
            })
            ->when($id != NULL and $tingkat == 'ranting', function ($query) use ($id) {
                return $query->where('id_upzis', $id);
            })
            ->when($id != NULL and $id2 != NULL and $tingkat == 'ranting', function ($query) use ($id2) {
                return $query->where('id_ranting', $id2);
            })
            ->when($start_date && $end_date and $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereDate(self::$etasyaruf . '.pengajuan.created_at', '>=', $start_date)->whereDate(self::$etasyaruf . '.pengajuan.created_at', '<=', $end_date);
            })
            ->when($start_date && $end_date and $start_date == $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereDate(self::$etasyaruf . '.pengajuan.created_at', $start_date);
            });
            //->whereBetween(self::$etasyaruf . '.pengajuan.created_at', [$start_date, $end_date]);

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
        } 

        return $data ?? NULL;
    }

    public static function getTotalByPilar($tingkat, $id_upzis, $id_ranting, $id_pilar, $start_date, $end_date, $status)
    {
        self::initConfig();
        $data = DB::table(self::$etasyaruf . '.pengajuan')
            ->when($tingkat == 'upzis', function ($query) {
                return $query->where('tingkat', 'Upzis MWCNU')->whereNull('id_ranting');
            })
            ->when($status != 'Semua', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($tingkat == 'ranting', function ($query) {
                return $query->where('tingkat', 'Ranting NU');
            })
            ->when($id_upzis and $id_ranting, function ($query) use ($id_upzis, $id_ranting) {
                return $query->where('id_upzis', $id_upzis)->where('id_ranting', $id_ranting);
            })
            ->when($id_upzis and $id_ranting == NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->whereBetween(self::$etasyaruf . '.pengajuan.created_at', [$start_date, $end_date])
            ->rightJoin(self::$etasyaruf . '.pengajuan_detail', self::$etasyaruf . '.pengajuan_detail.id_pengajuan', '=', self::$etasyaruf . '.pengajuan.id_pengajuan')
            ->where('id_program_pilar', $id_pilar)
            ->count();

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
