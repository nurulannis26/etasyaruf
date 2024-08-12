<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\ProgramPilar;
use App\Models\ProgramKegiatan;
use App\Models\Berita;
use Illuminate\Http\Request;

class ProgramController extends Controller
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

    public function program()
    {

        $title = "PILAR & PROGRAM ";
        $page = "Program";

        return view(
            'program.program',
            compact('title', 'page')
        );
    }

    public function detail_program()
    {

        $title = "DETAIL PROGRAM";
        $page = "Detail Program";

        $data = ProgramPilar::latest()
            ->paginate(5);

        return view(
            'program.detail',
            compact('title', 'page', 'data')
        );
    }

    public function kegiatan($id)
    {
        $a = ProgramKegiatan::where('id_program_pilar', $id)->get();

        return  $a;
    }
}
