<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helper;
// use App\Models\Helper;
use App\Models\Berita;
use App\Models\Pengajuan;
use App\Models\ProgramPilar;
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

class Api extends Controller
{
    private $helper;
    public function __construct()
    {
        $this->helper = app(Helper::class);
    }

    public function getPjByRanting(Request $request)
    {
        $selectedRanting = $request->input('rantingId');
        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $daftar_pj = DB::table($gocap . '.ranting_pengurus')
            ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_ranting_pengurus', '=', $gocap . '.ranting_pengurus.id_ranting_pengurus')
            ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.ranting_pengurus.id_pengurus_jabatan')
            ->select(
                $siftnu . '.pengguna.nama',
                $gocap . '.ranting_pengurus.id_ranting_pengurus',
                $gocap . '.pengurus_jabatan.jabatan',
            )
            ->where($gocap . '.ranting_pengurus.id_ranting', $selectedRanting)
            ->get();

        // dd($daftar_pj);

        return response()->json($daftar_pj);
    }

    public function getNomorPengajuan2(Request $request)
    {
        $selectedRanting = $request->input('rantingId');
        $upzisId = $request->input('upzisId');

        $pengajuan = Pengajuan::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->latest();

        if ($selectedRanting == NULL) {
            $data = $pengajuan->where('id_ranting', NULL)->first();
        } else {
            $data = $pengajuan->where('id_ranting', $selectedRanting)->first();
        }

        if ($data == NULL) {
            $urut = 0;
        } else {
            $string = $data->nomor_surat;
            $urut = (int)$string[0] . $string[1];
        }

        if (date('m') == '01') {
            $romawi = 'I';
        } elseif (date('m') == '02') {
            $romawi = 'II';
        } elseif (date('m') == '03') {
            $romawi = 'III';
        } elseif (date('m') == '04') {
            $romawi = 'IV';
        } elseif (date('m') == '05') {
            $romawi = 'V';
        } elseif (date('m') == '06') {
            $romawi = 'VI';
        } elseif (date('m') == '07') {
            $romawi = 'VII';
        } elseif (date('m') == '08') {
            $romawi = 'VIII';
        } elseif (date('m') == '09') {
            $romawi = 'IX';
        } elseif (date('m') == '10') {
            $romawi = 'X';
        } elseif (date('m') == '11') {
            $romawi = 'XI';
        } elseif (date('m') == '12') {
            $romawi = 'XII';
        }

        // Set ulang urutan menjadi 0 jika bulan dan tahun berbeda
        if ($data == NULL) {
            $urut = 0;
        }
        if ($selectedRanting == 'upzis') {
            if (($urut + 1) < 10) {
                $nomor_surat = '0' . ($urut + 1) . '/' . 'UPZIS-MWCNU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '/' . $romawi . '/' . date('Y');
            } else {
                $nomor_surat = ($urut + 1) . '/' . 'UPZIS-MWCNU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '/' . $romawi . '/' . date('Y');
            }
        } else {
            if (($urut + 1) < 10) {
                $nomor_surat = '0' . $urut + 1 . '/' . 'RANTING-NU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '-' . $this->helper->getNamaRanting($selectedRanting) . '/' . $romawi . '/' . date('Y');
            } else {
                $nomor_surat = $urut + 1 . '/' . 'RANTING-NU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '-' . $this->helper->getNamaRanting($selectedRanting) . '/' . $romawi . '/' . date('Y');
            }
        }

        return response()->json($nomor_surat);
    }



    public function getPilar($programId)
    {
        // Get the data pilar based on the selected programId
        $pilars = ProgramPilar::where('id_program', $programId)
            ->orWhere('id_program2', $programId)
            ->orderBy('pilar', 'ASC')
            ->get();

        // Return the data as JSON response
        return response()->json(['pilars' => $pilars]);
    }
}
