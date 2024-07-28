<?php

namespace app\Helpers;

use Illuminate\Support\Facades\DB;

class BasicHelper
{
    public static $etasyaruf;
    public static $siftnu;
    public static $gocap;

    public static function initialize()
    {
        self::$etasyaruf = config('app.database_etasyaruf');
        self::$siftnu = config('app.database_siftnu');
        self::$gocap = config('app.database_gocap');
    }

    public static function formatRupiah($nominal)
    { 
        $result = number_format($nominal, 0, ',', '.');
        return $result;
    }

    public static function getNamaBulan(int $bulan)
    {
        $daftar_bulan = array(
            1 => "Januari",
            2 => "Februari",
            3 => "Maret",
            4 => "April",
            5 => "Mei",
            6 => "Juni",
            7 => "Juli",
            8 => "Agustus",
            9 => "September",
            10 => "Oktober",
            11 => "November",
            12 => "Desember"
        );

        return $daftar_bulan[(int)$bulan];
    }

    public static function getTanggalTerakhir(int $bulan, int $tahun)
    {
        return date("d", strtotime('-1 second', strtotime('+1 month', strtotime($bulan . '/01/' . $tahun . ' 00:00:00'))));
    }

    public static function getNamaKetuaUpzis($id_upzis)
    {
        self::initialize();

        $data = DB::table(self::$gocap . '.pengurus_jabatan')
            ->where('tingkat', 'upzis')
            // ->where('jabatan', 'Ketua UPZIS')
            ->where('jabatan', 'Ketua Upzis')
            // ->where('jabatan', 'Ketua Upzis')
            ->join(self::$gocap . '.upzis_pengurus', self::$gocap . '.upzis_pengurus.id_pengurus_jabatan', '=', self::$gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->join(self::$siftnu . '.pengguna', self::$siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', self::$gocap . '.upzis_pengurus.id_upzis_pengurus')
            ->where(self::$gocap . '.upzis_pengurus.id_upzis', $id_upzis)
            ->where(self::$gocap . '.upzis_pengurus.status', '1')

            ->select(
                self::$siftnu . '.pengguna.nama as ketua_upzis'
            )->first();

        if ($data) {
            $ketua_upzis = $data->ketua_upzis;
        } else {
            $ketua_upzis = '-';
        }
        return $ketua_upzis;
    }

    public static function getNamaBendaharaUpzis($id_upzis)
    {
        self::initialize();

        $data = DB::table(self::$gocap . '.pengurus_jabatan')
            ->where('tingkat', 'upzis')
            // ->where('jabatan', 'Ketua UPZIS')
            ->where('jabatan', 'Bendahara Upzis')
            // ->where('jabatan', 'Ketua Upzis')
            ->join(self::$gocap . '.upzis_pengurus', self::$gocap . '.upzis_pengurus.id_pengurus_jabatan', '=', self::$gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->join(self::$siftnu . '.pengguna', self::$siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', self::$gocap . '.upzis_pengurus.id_upzis_pengurus')
            ->where(self::$gocap . '.upzis_pengurus.id_upzis', $id_upzis)
            ->where(self::$gocap . '.upzis_pengurus.status', '1')

            ->select(
                self::$siftnu . '.pengguna.nama as bendahara_upzis'
            )->first();


        if ($data) {
            $bendahara_upzis = $data->bendahara_upzis;
        } else {
            $bendahara_upzis = '-';
        }
        return $bendahara_upzis;
    }
}
