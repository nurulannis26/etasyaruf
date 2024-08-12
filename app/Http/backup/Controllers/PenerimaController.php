<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenerimaController extends Controller
{
    public function __construct()
    {
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');

        view()->composer('*', function ($view) {

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $role = 'pc';
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $role = 'upzis';
                $pengurus = DB::table($this->gocap . '.upzis_pengurus')->where('id_upzis_pengurus', Auth::user()->gocap_id_upzis_pengurus)->first();
                $id_upzis = $pengurus->id_upzis;
                $upzis = DB::table($this->gocap . '.upzis')->where('id_upzis', $id_upzis)->first();
            }
            $view->with('role', $role);
        });
    }

    public function penerima()
    {

        $title = "PENERIMA";
        $page = "Penerima";

        return view(
            'penerima.penerima',
            compact('title', 'page')
        );
    }
}
