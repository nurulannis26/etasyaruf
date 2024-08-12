<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengajuan;
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

class DetailPengajuanController extends Controller
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


    public function index($id_pengajuan)
    {
        $data = Pengajuan::where('id_pengajuan', $id_pengajuan)->first();
        if ($data->tingkat == 'Upzis MWCNU') {
            $title = "DETAIL PENGAJUAN UPZIS";
        } else {
            $title = "DETAIL PENGAJUAN RANTING";
        }

        if (Auth::user()->gocap_id_upzis_pengurus)
            if (Auth::user()->UpzisPengurus->id_upzis == $data->id_upzis) {
                return view(
                    'pengajuan.detail-pengajuan',
                    compact('title', 'data')
                );
            } else {
                return view(
                    'error.minimal419',
                    compact('title', 'data')
                );
            }
        else {
            return view(
                'pengajuan.detail-pengajuan',
                compact('title', 'data')
            );
        }
    }
    
    public static function detailPenyaluran($id)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id)
            ->whereNotNull('file_berita')
            ->count();
        $b = PengajuanDetail::where('id_pengajuan', $id)
            ->where('status_berita', 'Sudah Diperiksa')
            ->count();
        $c = PengajuanDetail::where('id_pengajuan', $id)
            ->where('status_berita', 'Belum Dikonfirmasi')
            ->count();
        $d = PengajuanDetail::where('id_pengajuan', $id)
            ->where('status_berita', 'Revisi')
            ->count();

        return [
            'konfirmasi' => $a,
            'selesai' => $b,
            'belum' => $c,
            'revisi' => $d,
        ];
    }
}
