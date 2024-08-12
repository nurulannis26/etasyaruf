<?php

namespace App\Http\Controllers;

use App\Models\ProgramKegiatan;
use App\Models\ProgramPilar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Controller extends Controller
{
    public function munculPilar($id)
    {
        // dd($id);
        // id_program
        if ($id) {
            
        $items = ProgramPilar::where('id_program', $id)
        ->orwhere('id_program2', $id)->orderBy('pilar', 'ASC')
        ->select(
            'id_program_pilar as id',
            'pilar as text',
            )
        ->get();

        $result['status']=1;
        $result['items']=$items;

        }else{
            // Pilih Kategori Terlebih Dahulu
            $result=[
                'status'=>0,
                'items'=>['Pilih Kategori Terlebih Dahulu'],
            ];
        }

        echo json_encode($result);
    }

    public function jenis_program($id)
    {
        // dd($id); //30746c18-3f7a-4736-ae47-ea91154a5a00
        // id_program
        if ($id) {
            
            $daftar_kegiatan = DB::table('program_kegiatan')->where('id_program_pilar', $id)
                ->whereRaw('LENGTH(no_urut) = 3')
                ->select(
                    'id_program_kegiatan as id',
                    DB::raw(' CONCAT( no_urut, " ", nama_program ) AS text ')
                    )
                ->orderBy('no_urut', 'ASC')->get()->toArray();
            $daftar_kegiatan2 = DB::table('program_kegiatan')->where('id_program_pilar', $id)
                ->whereRaw('LENGTH(no_urut) = 4')
                ->select(
                    'id_program_kegiatan as id',
                    DB::raw(' CONCAT( no_urut, " ", nama_program ) AS text ')
                    )
                ->orderBy('no_urut', 'ASC')->get()->toArray();


               $items = array_merge($daftar_kegiatan,$daftar_kegiatan2);

        $result['status']=1;
        $result['items']=$items;

        }else{
            // Pilih Kategori Terlebih Dahulu
            $result=[
                'status'=>0,
                'items'=>['Pilih Pilar Terlebih Dahulu'],
            ];
        }

        echo json_encode($result);
    }
}
