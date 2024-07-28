<?php

namespace App\Http\Controllers;

use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
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

    public function index()
    {

        // pc
        if (Auth::user()->gocap_id_pc_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }

        // upzis
        if (Auth::user()->gocap_id_upzis_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }


        $filter_bulan = '';
        $filter_tahun = '';
        $filter_status = '';
        $filter_tingkat = '';
        $filter_id_upzis = '';
        $filter_id_ranting = '';
        $c_tingkat = '';

        return view(
            'dashboard',
            compact('title', 'filter_bulan', 'filter_tahun', 'filter_status', 'filter_tingkat', 'filter_id_upzis', 'filter_id_ranting', 'c_tingkat')
        );
    }

    public function filter_dashboard_post(Request $request)
    {

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

        if ($request->id_ranting_lv) {
            $id_ranting_lv = $request->id_ranting_lv;
        } else {
            $id_ranting_lv = 'Semua';
        }

        if ($request->id_upzis_lv) {
            $id_upzis_lv = $request->id_upzis_lv;
        } else {
            $id_upzis_lv = 'Semua';
        }

        if ($request->tujuan_lv) {
            $tujuan_lv = $request->tujuan_lv;
        } else {
            $tujuan_lv = 'Semua';
        }

        if ($request->pilar_lv) {
            $pilar_lv = $request->pilar_lv;
        } else {
            $pilar_lv = 'Semua';
        }

        if ($request->kategori_lv) {
            $kategori_lv = $request->kategori_lv;
        } else {
            $kategori_lv = 'Semua';
        }

        if ($request->pilih_tingkat == 'INTERNAL') {
            return Redirect::to($role . '/filter_dashboard_internal_pc/' . $request->bulan_lv . '/' . $request->tahun_lv . '/' . $status_lv . '/' .  $tujuan_lv);
        } elseif ($request->pilih_tingkat == 'UMUM') {
            return Redirect::to($role . '/filter_dashboard_pc_umum/' . $request->bulan_lv . '/' . $request->tahun_lv . '/' . $status_lv . '/' .  $kategori_lv . '/' . $pilar_lv);
        } elseif ($request->pilih_tingkat == 'UPZIS') {
            return Redirect::to($role . '/filter_dashboard_upzis/' . $request->bulan_lv . '/' . $request->tahun_lv . '/' . $status_lv . '/' . $id_upzis_lv);
        } elseif ($request->pilih_tingkat == 'RANTING') {
            return Redirect::to($role . '/filter_dashboard_ranting/' . $request->bulan_lv . '/' . $request->tahun_lv . '/' . $status_lv . '/' .  $id_upzis_lv . '/' . $id_ranting_lv);
        }
    }

    public function filter_upzis($c_filter_bulan, $c_filter_tahun, $c_filter_status, $c_filter_id_upzis, Request $request)
    {

        if (Auth::user()->gocap_id_pc_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }

        // upzis
        if (Auth::user()->gocap_id_upzis_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }
        $c_tingkat = 'UPZIS';
        $c_filter_bulan = $c_filter_bulan;
        $c_filter_tahun = $c_filter_tahun;
        $c_filter_status = $c_filter_status;
        $c_filter_id_upzis = $c_filter_id_upzis;

        return view(
            'dashboard',
            compact('title', 'c_filter_bulan', 'c_filter_tahun', 'c_filter_status', 'c_filter_id_upzis', 'c_tingkat')
        );
    }

    public function filter_ranting($c_filter_bulan, $c_filter_tahun, $c_filter_status, $c_filter_id_upzis, $c_filter_id_ranting, Request $request)
    {

        if (Auth::user()->gocap_id_pc_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }

        // upzis
        if (Auth::user()->gocap_id_upzis_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }
        $c_tingkat = 'RANTING';
        $c_filter_bulan = $c_filter_bulan;
        $c_filter_tahun = $c_filter_tahun;
        $c_filter_status = $c_filter_status;
        $c_filter_id_upzis = $c_filter_id_upzis;
        $c_filter_id_ranting = $c_filter_id_ranting;

        return view(
            'dashboard',
            compact('title', 'c_filter_bulan', 'c_filter_tahun', 'c_filter_status', 'c_filter_id_ranting', 'c_filter_id_upzis', 'c_tingkat')
        );
    }

    public function filter_pc_umum($c_filter_bulan, $c_filter_tahun, $c_filter_status, $c_filter_kategori, $c_filter_pilar, Request $request)
    {
        if (Auth::user()->gocap_id_pc_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }

        // upzis
        if (Auth::user()->gocap_id_upzis_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }

        $c_tingkat = 'UMUM';
        $c_filter_bulan = $c_filter_bulan;
        $c_filter_tahun = $c_filter_tahun;
        $c_filter_status = $c_filter_status;
        $c_filter_kategori = $c_filter_kategori;
        $c_filter_pilar = $c_filter_pilar;

        return view(
            'dashboard',
            compact('title', 'c_filter_bulan', 'c_filter_tahun', 'c_filter_status', 'c_filter_pilar', 'c_filter_kategori', 'c_tingkat')
        );
    }


    public function filter_internal_pc($c_filter_bulan, $c_filter_tahun, $c_filter_status, $c_filter_tujuan, Request $request)
    {

        if (Auth::user()->gocap_id_pc_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }

        // upzis
        if (Auth::user()->gocap_id_upzis_pengurus) {
            $title = "DASHBOARD e-Tasyaruf PC LAZISNU CILACAP";
        }
        $c_tingkat = 'INTERNAL';
        $c_filter_bulan = $c_filter_bulan;
        $c_filter_tahun = $c_filter_tahun;
        $c_filter_status = $c_filter_status;
        $c_filter_tujuan = $c_filter_tujuan;

        return view(
            'dashboard',
            compact('title', 'c_filter_bulan', 'c_filter_tahun', 'c_filter_status', 'c_filter_tujuan', 'c_tingkat')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
}
