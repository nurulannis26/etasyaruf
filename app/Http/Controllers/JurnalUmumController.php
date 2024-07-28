<?php

namespace App\Http\Controllers;

use App\Models\JabatanPengurus;
use App\Models\Pengguna;
use App\Models\Rekening;
use App\Models\JurnalUmum;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class JurnalUmumController extends Controller
{
    public function print_jurnal_umum($id)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $idss = $id;
        $detail_jurnal = JurnalUmum::where('id_jurnal_umum', $id)->first();
        $get_detail = JurnalUmum::join($gocap . '.rekening', 'rekening.id_rekening', '=', 'jurnal_umum.akun')->orderby('jurnal_umum.created_at', 'asc')
            ->where('nomor', $detail_jurnal->nomor)->get();
        $rekening = Rekening::whereNotNull('id_pc')->orderby('nomor_akun', 'asc')->get();

        $nama = Pengguna::join($gocap . '.pc_pengurus', 'pc_pengurus.id_pc_pengurus', '=', 'pengguna.gocap_id_pc_pengurus')
            ->where('id_pengguna', $detail_jurnal->id_pengguna)->first();

        $jabatan = JabatanPengurus::where('id_pengurus_jabatan', $nama->id_pengurus_jabatan)->first();

        $pdf = FacadePdf::loadView('print.jurnal_umum', compact('nama', 'rekening', 'idss', 'detail_jurnal', 'get_detail', 'nama', 'jabatan'));
        return $pdf->stream('Jurnal Umum Nomor' . $detail_jurnal->nomor . '.pdf');
    }
}
