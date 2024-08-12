<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Rekening;
use App\Models\Pengajuan;
use App\Models\ProgramPilar;
use App\Models\PengajuanDetail;
use App\Models\ProgramKegiatan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LampiranPencairan;
use Illuminate\Support\Facades\DB;

class PrintPenyaluranController extends Controller
{
    public static function ttd($id)
    {
        // dd($id);
        $siftnu = config('app.database_siftnu');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        // dd($a);
        if ($a == NULL) {
            return '-';
        } else {
            return $a->ttd;
        }
    }
    
    public function print_penyaluran_dana($id_pengajuan)
    {
        $id_pengajuan = $id_pengajuan;
        $pengajuan =  Pengajuan::where('id_pengajuan', $id_pengajuan)->first();
        $D_pengajuan =  PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        // dd($D_pengajuan);
        $asnaf = DB::table('asnaf')->where('id_asnaf', $D_pengajuan->id_asnaf)->value('nama_asnaf');

        $ttd_fo = Pengguna::where('gocap_id_pc_pengurus', $pengajuan->maker_tingkat_pc)->value('ttd');
        $ttd_div_program = Pengguna::where('gocap_id_pc_pengurus', $D_pengajuan->approver_divpro)->value('ttd');
        $ttd_direktur = Pengguna::where('gocap_id_pc_pengurus', $D_pengajuan->approval_pencairan_direktur_id)->value('ttd'); // ini waktu acc pengajuan apa pencairan ??

        $pengajuan_disetujui = $D_pengajuan->approval_status;
        $pengajuan_ditolak = $D_pengajuan->approval_status;

        $jenis_bantuan = $pengajuan->jenis_permohonan;
        $alasan_pengajuan_ditolak = $D_pengajuan->denial_note;

        $nominal_disetujui_direktur = $D_pengajuan->nominal_disetujui_pencairan_direktur;
        // dd($nominal_disetujui_direktur);

        $tgl_diserahkan_div_program = $D_pengajuan->tgl_diserahkan_div_program;
        $tgl_berkas_diterima_div_program = $D_pengajuan->approval_date_divpro;
        $tgl_diserahkan_direktur = $D_pengajuan->tgl_diserahkan_direktur;

        $tgl_disetujui_direktur = $D_pengajuan->approval_date;


        $gocap = config('app.database_gocap');


        $id_front = DB::table($gocap . '.pengurus_jabatan as pj')
    ->where('pj.id_pengurus_jabatan', '300ff4f3-725c-11ed-ad27-e4a8df91d8b3')
    ->join($gocap . '.pc_pengurus as pp', 'pp.id_pengurus_jabatan', '=', 'pj.id_pengurus_jabatan')
    ->where('pp.status', '1')
    ->select('pp.id_pc_pengurus')
    ->first();

        $id_program = DB::table($gocap . '.pengurus_jabatan as pj')
    ->where('pj.id_pengurus_jabatan', '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')
    ->join($gocap . '.pc_pengurus as pp', 'pp.id_pengurus_jabatan', '=', 'pj.id_pengurus_jabatan')
    ->where('pp.status', '1')
    ->select('pp.id_pc_pengurus')
    ->first();


        $id_direktur = DB::table($gocap . '.pengurus_jabatan')->where('jabatan', 'Kepala Cabang')
            ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($gocap . '.pc_pengurus.status', '1')
            ->select($gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $nama_fo = Pengguna::where('gocap_id_pc_pengurus', $id_front->id_pc_pengurus)->value('nama');
        $nama_div_pro = Pengguna::where('gocap_id_pc_pengurus', $id_program->id_pc_pengurus)->value('nama');
        $nama_direktur = Pengguna::where('gocap_id_pc_pengurus', $id_direktur->id_pc_pengurus)->value('nama');

        $na_program = ProgramPilar::where('id_program_pilar', $D_pengajuan->id_program_pilar)->value('pilar');
        // $na_program = strstr($nama_program, '(', true);
        // $na_program = substr($nama_program, 6);
        $nama_kegiatan = ProgramKegiatan::where('id_program_kegiatan', $D_pengajuan->id_program_kegiatan)->value('nama_program');

        $jenis_dana_digunakan = $D_pengajuan->sumber_dana_opsi;

        $status_survey = $D_pengajuan->pil_survey;
        // dd($front.$program.$direktur);
        $pdf = PDF::loadview(
            'disposisi_penyaluran.print_penyaluran_dana',
            compact(
                'status_survey',
                'jenis_dana_digunakan',
                'nama_kegiatan',
                // 'nama_program',
                'id_pengajuan',
                'D_pengajuan',
                'pengajuan',
                'asnaf',
                'jenis_bantuan',
                'ttd_fo',
                'ttd_div_program',
                'ttd_direktur',
                'pengajuan_disetujui',
                'pengajuan_ditolak',
                'alasan_pengajuan_ditolak',
                'nominal_disetujui_direktur',
                'tgl_diserahkan_div_program',
                'tgl_berkas_diterima_div_program',
                'tgl_diserahkan_direktur',
                'tgl_disetujui_direktur',
                'nama_fo',
                'nama_div_pro',
                'nama_direktur',
                'na_program'
            )
        )->setPaper('a4', 'portrait');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $pengajuan->nomor_surat . '_PENYALURAN_DANA_ZIS.pdf',
        ]);
    }

    public function print_pencairan_dana($id_pengajuan)
    {
        $lampiran_pencairan = LampiranPencairan::where('id_pengajuan',$id_pengajuan)->get();
        $id_pengajuan = $id_pengajuan;
        $pengajuan =  Pengajuan::where('id_pengajuan', $id_pengajuan)->first();
        $D_pengajuan =  PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        
        $nama_rek = $this->nama_rekening($D_pengajuan->id_rekening) ?? '';

        $nama_program = ProgramPilar::where('id_program_pilar', $D_pengajuan->id_program_pilar)->value('pilar');
        $nama_kegiatan = ProgramKegiatan::where('id_program_kegiatan', $D_pengajuan->id_program_kegiatan)->value('nama_program');
        $asnaf = DB::table('asnaf')->where('id_asnaf', $D_pengajuan->id_asnaf)->value('nama_asnaf');

        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id_jabatan = ['694f38af-5374-11ed-882e-e4a8df91d8b3', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3', '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'];
        $data_pengurus = [];
        foreach ($id_jabatan as $jabatan) {
            $result = DB::table($gocap . '.pengurus_jabatan')
                    ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', $jabatan)
                    ->join($gocap . '.pc_pengurus', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.pc_pengurus.id_pengurus_jabatan')
                    ->join($siftnu . '.pengguna', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                    ->select($siftnu . '.pengguna.*')
                    ->first();

            $data_pengurus[$jabatan] = $result ? $result->nama : null;

        
        }

        $nama_direktur = $data_pengurus['8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3'];
        $nama_keuangan = $data_pengurus['694f38af-5374-11ed-882e-e4a8df91d8b3'];
        // $nama_ketua = $data_pengurus['c0e0faee-3590-11ed-9a47-e4a8df91d887'];

        $pdf = PDF::loadview(
            'disposisi_penyaluran.print_pencairan_dana',
            compact(
                'id_pengajuan',
                'D_pengajuan',
                'pengajuan',
                'nama_rek',
                'nama_program',
                'nama_kegiatan',
                'asnaf',
                'lampiran_pencairan',
                'nama_direktur',
                'nama_keuangan',
                // 'nama_ketua',
            )
        )->setPaper('a4', 'portrait');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $pengajuan->nomor_surat . '_PENCAIRAN_PERMOHONAN_DANA.pdf',
        ]);
    }

    public function nama_rekening($id)
    {
        $a = Rekening::where('id_rekening', $id)->first();
       
        if($a){
            return  $a->nama_rekening  . " - " . $a->no_rekening ;
        }else{
            return '-';
        }
     
    }

    public function nama_pengurus_pc($id)
    {
        // dd($id);
        $siftnu = config('app.database_siftnu');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        if ($a == NULL) {
            return '-';
        } else {
            return $a->nama;
        }
    }

    public function nohp_pengurus_pc($id)
    {

        $siftnu = config('app.database_siftnu');
        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
            if ($a == NULL) {
                return '-';
            } else {
                return $a->nohp;
            }
    }

    public function alamat_pc($id)
    {
        $siftnu = config('app.database_siftnu');
        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
            if ($a == NULL) {
                return '-';
            } else {
                return $a->alamat;
            }
    }

    // public function print_tanda_terima_fo($id)
    // {
    //     $pengajuan = Pengajuan::where('id_pengajuan',$id)->first();
    //     $D_pengajuan = PengajuanDetail::where('id_pengajuan',$id)->first();
    //     $jenis_penerima = $D_pengajuan->jenis_tanda_terima;
    //     $pdf = PDF::loadview(
    //         'disposisi_penyaluran.print_tanda_terima_fo',compact('jenis_penerima','pengajuan','D_pengajuan')
    //     )->setPaper('a4', 'portrait');
    //     return $pdf->stream()->withHeaders([
    //         'Title' => 'Your meta title',
    //         'Content-Type' => 'application/pdf',
    //         'Cache-Control' => 'no-store, no-cache',
    //         'Content-Disposition' => 'filename="' . $pengajuan->nomor_surat . '_TANDA_TERIMA_FO.pdf',
    //     ]);
    // }
    public function print_tanda_terima_fo($id)
    {
        // dd($id);
        $data = Pengajuan::join('pengajuan_detail', 'pengajuan_detail.id_pengajuan', '=', 'pengajuan.id_pengajuan')
                    ->where('pengajuan.id_pengajuan', $id)
                    ->select('pengajuan.*', 'pengajuan_detail.*')
                    ->first();
        // dd($data);

        $dokumen = [];
        $dokumenPengajuan = $data->syarat_dokumen;
        if ($dokumenPengajuan) {
            $dokumen = explode(',', $dokumenPengajuan);
        }
        // dd($dokumen);

        $pdf = PDF::loadview(
            'disposisi_penyaluran.print_tanda_terima_fo2',compact('data', 'dokumen')
        )->setPaper('a4', 'portrait');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $data->nomor_surat . '_TANDA_TERIMA_FO.pdf',
        ]);
    }
}
