<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use App\Models\PengajuanPenerima;
use App\Models\PengajuanDokumentasi;
use App\Models\PengajuanPenerimaLPJ;
use App\Models\PengajuanPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
// use Session;
use Illuminate\Support\Str;

class PengajuanController extends Controller
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

    public static function getNamaUpzis($id)
    {
        //   db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // data
        $data = DB::table($gocap . '.upzis')->where('id_upzis', $id)
            ->join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
            ->select($siftnu . '.wilayah.nama as nama_upzis')
            ->first();
        return  $data->nama_upzis;
    }

    public function internalpc_pc()
    {
        $title = "DATA PENGAJUAN";
        $filter_pc_umum = '';
        $filter_internal = '';
        return view(
            'pengajuan.internalpc_pc',
            compact('title', 'filter_pc_umum', 'filter_internal')
        );
    }

    public function getDaftarUpzisOrRanting($role, $id_upzis_filter)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id_upzis = NULL;

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }

        $data = DB::table($gocap . '.' . $role)
            ->join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.' . $role . '.id_wilayah')
            ->select(
                $gocap . '.' . $role . '.id_' . $role,
                $siftnu . '.wilayah.*',
            )
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($id_upzis_filter != NULL, function ($query) use ($id_upzis_filter) {
                return $query->where('id_upzis', $id_upzis_filter);
            })
            ->orderBy('nama', 'ASC')
            ->get();

        return $data ?? NULL;
    }











    public function filter_pc_umum($c_filter_bulan, $c_filter_tahun, $c_filter_status, $c_filter_kategori, $c_filter_pilar, Request $request)
    {

        $filter_pc_umum = 'on';
        $filter_internal = '';
        $title = "DATA PENGAJUAN";
        $c_filter_bulan = $c_filter_bulan;
        $c_filter_tahun = $c_filter_tahun;
        $c_filter_status = $c_filter_status;
        $c_filter_kategori = $c_filter_kategori;
        $c_filter_pilar = $c_filter_pilar;

        return view(
            'pengajuan.internalpc_pc',
            compact('title', 'c_filter_bulan', 'c_filter_tahun', 'c_filter_status', 'c_filter_pilar', 'c_filter_kategori', 'filter_pc_umum', 'filter_internal')
        );


        return redirect()->back()->withInput(['tab' => 'ranting']);
    }

    public function filter_pc_umum_post(Request $request)
    {
        // dd($request->bulans_lv . $request->tahun_lv . $request->status_lv .  $request->kategori_lv . $request->pilar_lv);
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $role = 'pc';
        } else {
            $role = 'upzis';
        }

        if ($request->status_lv) {
            $status_lv = $request->status_lv;
        } else {
            $status_lv = 'Semua';
        }

        if ($request->kategori_lv == 'Dana Infak') {


            if ($request->pilar_lv) {
                $pilar_lv = $request->pilar_lv;
            } else {
                $pilar_lv = 'Semua';
            }
        } elseif ($request->kategori_lv == 'Dana Zakat') {
            if ($request->asnaf_lv) {
                $pilar_lv = $request->asnaf_lv;
            } else {
                $pilar_lv = 'Semua';
            }
        } else {
            $pilar_lv = 'Semua';
        }

        if ($request->kategori_lv) {
            $kategori_lv = $request->kategori_lv;
        } else {
            $kategori_lv = 'Semua';
        }

        // dd($request->bulan_lv . $request->tahun_lv . $request->status_lv . $request->pilar_lv);
        // return redirect()->route('filter_rantings', ['c_filter_bulan' => $request->bulan_lv, 'c_filter_tahun' => $request->tahun_lv, 'c_filter_status' => $request->status_lv, 'c_filter_pilar' => $request->pilar_lv]);
        return Redirect::to($role . '/filter_pc_umum/' . $request->bulan_lv . '/' . $request->tahun_lv . '/' . $status_lv . '/' .  $kategori_lv . '/' . $pilar_lv);
        // return redirect()->route('filter_rantings');
    }

    public function filter_internal_pc($c_filter_bulan, $c_filter_tahun, $c_filter_status, $c_filter_tujuan, Request $request)
    {

        $filter_pc_umum = '';
        $filter_internal = 'on';
        $title = "DATA PENGAJUAN";
        $c_filter_bulan = $c_filter_bulan;
        $c_filter_tahun = $c_filter_tahun;
        $c_filter_status = $c_filter_status;
        $c_filter_tujuan = $c_filter_tujuan;

        return view(
            'pengajuan.internalpc_pc',
            compact('title', 'c_filter_bulan', 'c_filter_tahun', 'c_filter_status', 'c_filter_tujuan', 'filter_pc_umum', 'filter_internal')
        );


        return redirect()->back()->withInput(['tab' => 'ranting']);
    }

    public function filter_internal_pc_post(Request $request)
    {
        // dd($request->bulans_lv . $request->tahun_lv . $request->status_lv .  $request->kategori_lv . $request->pilar_lv);
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $role = 'pc';
        } else {
            $role = 'upzis';
        }

        if ($request->status_lv) {
            $status_lv = $request->status_lv;
        } else {
            $status_lv = 'Semua';
        }

        if ($request->tujuan_lv) {
            $tujuan_lv = $request->tujuan_lv;
        } else {
            $tujuan_lv = 'Semua';
        }

        // dd($request->bulan_lv . $request->tahun_lv . $request->status_lv . $request->pilar_lv);
        // return redirect()->route('filter_rantings', ['c_filter_bulan' => $request->bulan_lv, 'c_filter_tahun' => $request->tahun_lv, 'c_filter_status' => $request->status_lv, 'c_filter_pilar' => $request->pilar_lv]);
        return Redirect::to($role . '/filter_internal_pc/' . $request->bulan_lv . '/' . $request->tahun_lv . '/' . $status_lv . '/' .  $tujuan_lv);
        // return redirect()->route('filter_rantings');
    }


    public function detail_pengajuan_ranting($id_pengajuan)
    {
        $etasyaruf = config('app.database_etasyaruf');

        $title = "DETAIL PENGAJUAN RANTING";
        $title2 = "Detail Pengajuan Ranting";
        $datas = DB::table($etasyaruf . '.pengajuan')->where('id_pengajuan', $id_pengajuan)->first();

        return view(
            'pengajuan.detail_upzis',
            compact('title', 'title2', 'id_pengajuan', 'datas')

        );
    }

    public function detail_pengajuan_pc($id_pengajuan)
    {

        $title = "DETAIL PENGAJUAN PC LAZISNU";
        return view(
            'pengajuan.detail_pc',
            compact('title', 'id_pengajuan')
        );
    }

    public function detail_pengajuan_upzis($id_pengajuan)
    {

        $etasyaruf = config('app.database_etasyaruf');

        $datas = DB::table($etasyaruf . '.pengajuan')->where('id_pengajuan', $id_pengajuan)->first();

        if ($datas->tingkat == 'Upzis MWCNU') {
            $title = "DETAIL PENGAJUAN UPZIS";
            $title2 = "Detail Pengajuan UPZIS";
        } else {
            $title = "DETAIL PENGAJUAN RANTING";
            $title2 = "Detail Pengajuan Ranting";
        }
        return view(
            'pengajuan.detail_upzis',
            compact('title', 'title2', 'id_pengajuan', 'datas')
        );
    }
    public function detail_pengajuan_internal_pc($id_internal)
    {
        //dd('baba');
        $title = "DETAIL PENGAJUAN INTERNAL PC";
        return view(
            'pengajuan.detail_internal_pc',
            compact('title', 'id_internal')
        );
       
    }

    public static function getTanggalTerakhir(int $bulan, int $tahun)
    {
        return date("d", strtotime('-1 second', strtotime('+1 month', strtotime($bulan . '/01/' . $tahun . ' 00:00:00'))));
    }

    public function upzis_ranting2()
    {
        $title = "DATA PENGAJUAN";

        // tabbed
        $tab_upzis = session('tab_upzis', 'show active'); // Mengambil nilai dari session flash data, default: ''
        $tab_ranting = session('tab_ranting', ''); // Mengambil nilai dari session flash data, default: ''

        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        // TabUpzis
        $id_upzis = NULL;
        $status = 'Semua';
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $status = 'Diajukan';
        }
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $start_date = date('Y-m') . '-01';
        $end_date = date('Y-m') . '-' . $this->getTanggalTerakhir(date('m'), date('Y'));
        $filter_daterange = $start_date . ' - ' . $end_date;
        $id_upzis = NULL;
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $data = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Upzis MWCNU')
            // ->whereNull('id_ranting')
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit');
            })
            ->when($status == 'Sudah Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit');
            })
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)

            ->latest($etasyaruf . '.pengajuan.created_at')
            ->get();
        $total_upzis = $data->count();

        // TabRanting
        $id_upzis2 = NULL;
        $id_ranting2 = NULL;
        $status2 = 'Semua';
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $status2 = 'Diajukan';
        }
        $daftar_upzis2 = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $start_date2 = date('Y-m') . '-01';
        $end_date2 = date('Y-m') . '-' . $this->getTanggalTerakhir(date('m'), date('Y'));
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;
        $id_upzis2 = NULL;
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $data2 = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Ranting NU')
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit');
            })
            ->when($status2 == 'Sudah Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit');
            })
            ->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2)
            ->latest($etasyaruf . '.pengajuan.created_at')
            ->get();

        return view(
            'pengajuan.upzis-ranting',
            compact(
                'title',
                'daftar_upzis',
                'daftar_ranting2',
                'tab_upzis',
                'tab_ranting',
                // TabUpzis
                'data',
                'id_upzis',
                'status',
                'start_date',
                'end_date',
                'filter_daterange',
                'total_upzis',
                // TabRanting
                'data2',
                'id_upzis2',
                'id_ranting2',
                'status2',
                'start_date2',
                'end_date2',
                'filter_daterange2',
            )
        );
    }

    public function filter_umum_upzis(Request $request)
    {
        $title = "DATA PENGAJUAN";

        // tabbed
        $tab_upzis = 'show active';
        $tab_ranting = '';

        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        //////////////// TabUpzis
        // request
        $id_upzis = $request->id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $status = $request->status;
        // daterange
        $date_range = $request->filter_daterange;
        $date_parts = explode(" - ", $date_range);
        $start_date = $date_parts[0];
        $end_date = $date_parts[1];
        $filter_daterange = $start_date . ' - ' . $end_date;

        $datas = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit');
            })
            ->when($status == 'Sudah Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit');
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            // // filter bulan dan tahun
            ->when($start_date && $end_date and $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            })
            ->when($start_date && $end_date and $start_date == $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereDate('created_at', $start_date);
            })
            ->latest('created_at');

            if (Auth::user()->gocap_id_pc_pengurus != null) {
                $datas->where('status_pengajuan', '!=', 'Direncanakan');
            }
            
            $data = $datas->get();

        //////////////// TabRanting
        // request
        $id_upzis2 = $request->id_upzis2;

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $id_ranting2 = $request->id_ranting2;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $status2 = $request->status2;
        // daterange
        $date_range2 = $request->filter_daterange2;
        $date_parts2 = explode(" - ", $date_range2);
        $start_date2 = $date_parts2[0];
        $end_date2 = $date_parts2[1];
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;

        $datas2 = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit');
            })
            ->when($status2 == 'Sudah Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit');
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            // // filter bulan dan tahun
            ->when($start_date2 && $end_date2 and $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
            })
            ->when($start_date2 && $end_date2 and $start_date2 == $end_date2, function ($query) use ($start_date2, $end_date2) {
                return $query->whereDate('created_at', $start_date2);
            })
            ->latest('created_at');

            if (Auth::user()->gocap_id_pc_pengurus != null) {
                $datas2->where('status_pengajuan', '!=', 'Direncanakan');
            }

        $data2 = $datas2->get();

        return view(
            'pengajuan.upzis-ranting',
            compact(
                'title',
                'daftar_upzis',
                'daftar_ranting2',
                'tab_upzis',
                'tab_ranting',
                // TabUpzis
                'data',
                'id_upzis',
                'status',
                'start_date',
                'end_date',
                'filter_daterange',
                // TabRanting
                'data2',
                'id_upzis2',
                'id_ranting2',
                'status2',
                'start_date2',
                'end_date2',
                'filter_daterange2',
            )
        );
    }

    public function filter_umum_ranting(Request $request)
    {
        // dd($request->all());
        $title = "DATA PENGAJUAN";

        // tabbed
        $tab_upzis = NULL;
        $tab_ranting = 'show active';

        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        /////////////// TabUpzis
        // request
        $id_upzis = $request->id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $status = $request->status;
        // daterange
        $date_range = $request->filter_daterange;
        $date_parts = explode(" - ", $date_range);
        $start_date = $date_parts[0];
        $end_date = $date_parts[1];
        $filter_daterange = $start_date . ' - ' . $end_date;

        $datas = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit');
            })
            ->when($status == 'Sudah Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit');
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            // // filter bulan dan tahun
            ->when($start_date && $end_date and $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            })
            ->when($start_date && $end_date and $start_date == $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereDate('created_at', $start_date);
            })
            ->latest('created_at');

            if (Auth::user()->gocap_id_pc_pengurus != null) {
                $datas->where('status_pengajuan', '!=', 'Direncanakan');
            }
            
        $data = $datas->get();

        //////////////// TabRanting
        // request
        $id_upzis2 = $request->id_upzis2;
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $id_ranting2 = $request->id_ranting2;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $status2 = $request->status2;
        // daterange
        $date_range2 = $request->filter_daterange2;
        $date_parts2 = explode(" - ", $date_range2);
        $start_date2 = $date_parts2[0];
        $end_date2 = $date_parts2[1];
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;

        $datas2 = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit');
            })
            ->when($status2 == 'Sudah Terbit Rekom', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit');
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            // // filter bulan dan tahun
            ->when($start_date2 && $end_date2 and $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
            })
            ->when($start_date2 && $end_date2 and $start_date2 == $end_date2, function ($query) use ($start_date2, $end_date2) {
                return $query->whereDate('created_at', $start_date2);
            })
            ->latest('created_at');

            if (Auth::user()->gocap_id_pc_pengurus != null) {
                $datas2->where('status_pengajuan', '!=', 'Direncanakan');
            }

        $data2 = $datas2->get();


        return view(
            'pengajuan.upzis-ranting',
            compact(
                'title',
                'daftar_upzis',
                'daftar_ranting2',
                'tab_upzis',
                'tab_ranting',
                // TabUpzis
                'data',
                'id_upzis',
                'status',
                'start_date',
                'end_date',
                'filter_daterange',
                // TabRanting
                'data2',
                'id_upzis2',
                'id_ranting2',
                'status2',
                'start_date2',
                'end_date2',
                'filter_daterange2',

            )
        );
    }

    public function delete($id_pengajuan)
    {

        // $dokumentasi_array = PengajuanDokumentasi::where('id_pengajuan', $id_pengajuan)->get();
        // if ($dokumentasi_array != NULL) {
        //     foreach ($dokumentasi_array as $a) {
        //         $path = public_path() . "/uploads/pengajuan_dokumentasi/" . $a->file;
        //         if (file_exists($path)) {
        //             unlink($path);
        //         };
        //     }
        // }
        // PengajuanDokumentasi::where('id_pengajuan', $id_pengajuan)->delete();

        // // pengeluaran
        // $pengeluaran_array = PengajuanPengeluaran::where('id_pengajuan', $id_pengajuan)->get();
        // if ($pengeluaran_array != NULL) {
        //     foreach ($pengeluaran_array as $a) {
        //         $path = public_path() . "/uploads/nota_pengeluaran/" . $a->file;
        //         if (file_exists($path)) {
        //             unlink($path);
        //         };
        //     }
        // }
        // PengajuanPengeluaran::where('id_pengajuan', $id_pengajuan)->delete();

        // $pengajuan = Pengajuan::where('id_pengajuan', $id_pengajuan)->first();
        // // konfirmasi
        // if ($pengajuan->scan != NULL) {
        //     $path = public_path() . "/uploads/pengajuan_konfirmasi/" . $pengajuan->scan;
        //     if (file_exists($path)) {
        //         unlink($path);
        //     }
        // }

        // // konfirmasi
        // if ($pengajuan->scan_rekomendasi != NULL) {
        //     $path = public_path() . "/uploads/pengajuan_rekomendasi/" . $pengajuan->scan_rekomendasi;
        //     if (file_exists($path)) {
        //         unlink($path);
        //     }
        // }


        $data = Pengajuan::where('id_pengajuan', $id_pengajuan)->first();

        if ($data->tingkat == 'Upzis MWCNU') {
            $tab_upzis = 'show active';
            $tab_ranting = '';
        }
        if ($data->tingkat == 'Ranting NU') {
            $tab_upzis = '';
            $tab_ranting = 'show active';
            // dd('dwd');
        }

        PengajuanPenerima::where('id_pengajuan', $id_pengajuan)->delete();
        PengajuanDetail::where('id_pengajuan', $id_pengajuan)->delete();
        Pengajuan::where('id_pengajuan', $id_pengajuan)->delete();
        return redirect('/upzis/upzis-ranting')->with([
            'tab_ranting' => $tab_ranting,
            'tab_upzis' => $tab_upzis,
        ])->with('success', 'Data Pengajuan Berhasil Dihapus');
    }

    public static function hitung_nominal_pengajuan($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->sum('nominal_pengajuan');
        return $a ?? NULL;
    }

    public static function hitung_jumlah_rencana($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->count();
        return $a ?? NULL;
    }
    public static function hitung_jumlah_penerima($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->sum('jumlah_penerima');
        return $a ?? NULL;
    }
    public static function hitung_nominal_pengajuan_disetujui($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('approval_status', 'Disetujui')->sum('nominal_disetujui');
        return $a ?? NULL;
    }
    public static function hitung_nominal_penyaluran($id_pengajuan)
    {
        $a = PengajuanDetail::where('pengajuan_detail.id_pengajuan', $id_pengajuan)
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->where('pencairan_status', 'Berhasil Dicairkan')->whereNotNull('file_berita')->sum('nominal_bantuan');
        return $a ?? NULL;
    }

    public static function hitung_nominal_penyaluran2($id_pengajuan)
    {
        $a = PengajuanDetail::where('pengajuan_detail.id_pengajuan', $id_pengajuan)
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->where('pencairan_status', 'Berhasil Dicairkan')->where('status_berita', 'Sudah Diperiksa')->sum('nominal_bantuan');
        return $a ?? NULL;
    }



    public static function hitung_nominal_pencairan($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('pencairan_status', 'Berhasil Dicairkan')->sum('nominal_pencairan');
        return $a ?? NULL;
    }
    public static function getNamaPengurus($role, $id)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $a = DB::table($siftnu . '.pengguna')
            ->join($gocap . '.' . $role . '_pengurus', $gocap . '.' . $role . '_pengurus.id_' . $role . '_pengurus', '=', $siftnu . '.pengguna.gocap_id_' . $role . '_pengurus')
            ->where($gocap . '.' . $role . '_pengurus.status', '1')
            ->where('gocap_id_' . $role . '_pengurus', $id)
            ->first();
        return $a->nama ?? NULL;
    }
    public static function getJabatanPengurus($role, $id)
    {
        $gocap = config('app.database_gocap');
        $a = DB::table($gocap . '.' . $role . '_pengurus')
            ->where($gocap . '.' . $role . '_pengurus.id_' . $role . '_pengurus', $id)
            ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.' . $role . '_pengurus.id_pengurus_jabatan')
            ->first();
        return $a->jabatan ?? NULL;
    }

    public static function getNomorPengajuan($role, $id)
    {
        $pengajuan = Pengajuan::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->latest();

        if ($role == 'upzis') {
            $data = $pengajuan->where('id_ranting', NULL)->first();
        } else {
            $data = $pengajuan->where('id_ranting', $id)->first();
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
        if ($role == 'upzis') {
            if (($urut + 1) < 10) {
                $nomor_surat = '0' . ($urut + 1) . '/' . 'UPZIS-MWCNU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '/' . $romawi . '/' . date('Y');
            } else {
                $nomor_surat = ($urut + 1) . '/' . 'UPZIS-MWCNU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '/' . $romawi . '/' . date('Y');
            }
        } else {
            if (($urut + 1) < 10) {
                $nomor_surat = '0' . $urut + 1 . '/' . 'RANTING-NU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '-' . $id . '/' . $romawi . '/' . date('Y');
            } else {
                $nomor_surat = $urut + 1 . '/' . 'RANTING-NU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '-' . $id . '/' . $romawi . '/' . date('Y');
            }
        }

        return $nomor_surat ?? NULL;
    }

    public static function getDaftarPengurus($role, $id)
    {
        $gocap = config('app.database_gocap');
        $siftnu = config('app.database_siftnu');

        $pengurus = DB::table($gocap . '.' . $role . '_pengurus')
            ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_' . $role . '_pengurus', '=', $gocap . '.' . $role . '_pengurus.id_' . $role . '_pengurus')
            ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.' . $role . '_pengurus.id_pengurus_jabatan')
            ->where($gocap . '.' . $role . '_pengurus.status', '1')
            ->select(
                $siftnu . '.pengguna.nama',
                $gocap . '.' . $role . '_pengurus.id_' . $role . '_pengurus',
                $gocap . '.pengurus_jabatan.jabatan',
            )
            ->where($gocap . '.' . $role . '_pengurus.id_' . $role,  $id)
            ->get();
        // dd($pengurus);
        return $pengurus ?? NULL;
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
                $nomor_surat = '0' . $urut + 1 . '/' . 'RANTING-NU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '-' . 'nama-rantinge' . '/' . $romawi . '/' . date('Y');
            } else {
                $nomor_surat = $urut + 1 . '/' . 'RANTING-NU' . '/' . Auth::user()->UpzisPengurus->Upzis->Wilayah->nama . '-' . 'nama-rantinge' . '/' . $romawi . '/' . date('Y');
            }
        }

        return response()->json($nomor_surat);
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $id_pengajuan = Str::uuid();
        Pengajuan::create([
            'id_pengajuan' => $id_pengajuan,
            'tingkat' => $request->tingkat,
            'nomor_surat' => $request->nomor_surat,
            'tgl_pengajuan' => $request->tgl_pengajuan,
            'status_pengajuan' => 'Direncanakan',
            'status_rekomendasi' => 'Belum Terbit',
            'pj_upzis' => $request->pj_upzis,
            'pj_ranting' => $request->pj_ranting,
            'id_pc' =>  Auth::user()->UpzisPengurus->Upzis->id_pc,
            'id_upzis' =>  Auth::user()->UpzisPengurus->Upzis->id_upzis,
            'id_ranting' =>  $request->id_ranting2,
            'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
        ]);
        return redirect('/upzis/detail-pengajuan/' . $id_pengajuan)->with('success', 'Data Pengajuan Berhasil Ditambahkan');
    }

    public static function detailSetujui($id)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id)
            ->where('approval_status', 'Disetujui')
            ->count();
        $b = PengajuanDetail::where('id_pengajuan', $id)
            ->where('approval_status', 'Ditolak')
            ->count();
        $c = PengajuanDetail::where('id_pengajuan', $id)
            ->where('approval_status', 'Belum Direspon')
            ->count();

        return [
            'acc' => $a,
            'tolak' => $b,
            'belum' => $c,
        ];
    }
    public static function detailPencairan($id)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id)
            ->where('approval_status', 'Disetujui')
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->count();
        $b = PengajuanDetail::where('id_pengajuan', $id)
            ->where('approval_status', 'Disetujui')
            ->where('pencairan_status', 'Ditolak')
            ->count();
        $c = PengajuanDetail::where('id_pengajuan', $id)
            ->where('approval_status', 'Disetujui')
            ->where('pencairan_status', 'Belum Dicairkan')
            ->count();

        return [
            'acc' => $a,
            'tolak' => $b,
            'belum' => $c,
        ];
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
