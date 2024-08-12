<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Ranting;
use App\Models\Wilayah;
use App\Models\Upzis;
use App\Models\Internal;
use App\Models\PengajuanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GenerateNomorController extends Controller
{
    function bulanKeRomawi($bulan) {
        $romawi = ["", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        return $romawi[(int)$bulan];
    }
    
    public function GenerateKwitansi($tahun) 
    {
        $data = Pengajuan::join('pengajuan_detail', 'pengajuan_detail.id_pengajuan', '=', 'pengajuan.id_pengajuan')
                ->where('pengajuan.tingkat', 'PC')
                ->whereYear('pengajuan.created_at', $tahun)
                ->whereNotNull('pengajuan_detail.nomor_kwitansi_pencairan')
                ->orderBy('pengajuan.created_at', 'asc')
                ->select('pengajuan.nomor_surat', 'pengajuan_detail.id_pengajuan_detail')
                ->get();

        foreach ($data as $item) {
            $nomorSurat = $item->nomor_surat;
            $idPengajuanDetail = $item->id_pengajuan_detail;
    
            // Pecah nomor surat menjadi bagian-bagian
            $parts = explode('/', $nomorSurat);
                // Ambil bagian-bagian dari nomor surat
                $nomor = $parts[0]; // 358
                $bulan = $parts[3]; // VI
                $tahun = $parts[4]; // 2024
    
                // Format nomor kwitansi pencairan baru
                $nomor_kwitansi_pencairan = $nomor . '/' . 'keu_lazisnucilacap' . '/' . $bulan . '/' . $tahun;
    
                // Perbarui nomor_kwitansi_pencairan berdasarkan id_pengajuan_detail
                PengajuanDetail::where('id_pengajuan_detail', $idPengajuanDetail)
                    ->update([
                        'nomor_kwitansi_pencairan' => $nomor_kwitansi_pencairan
                    ]);
        }
    }
    
     public function GenerateKwitansiInternal($tahun) 
    {
        $data = Internal::whereYear('created_at', $tahun)
                ->whereNotNull('nomor_kwitansi_pencairan')
                ->orderBy('created_at', 'asc')
                ->select('nomor_surat', 'id_internal')
                ->get();

        foreach ($data as $item) {
            $nomorSurat = $item->nomor_surat;
            $idInternal = $item->id_internal;
    
            // Pecah nomor surat menjadi bagian-bagian
            $parts = explode('/', $nomorSurat);
                // Ambil bagian-bagian dari nomor surat
                $nomor = $parts[0]; // 358
                $bulan = $parts[3]; // VI
                $tahun = $parts[4]; // 2024
    
                // Format nomor kwitansi pencairan baru
                $nomor_kwitansi_pencairan = $nomor . '/' . 'keu_lazisnucilacap' . '/' . $bulan . '/' . $tahun;
    
                // Perbarui nomor_kwitansi_pencairan berdasarkan id_pengajuan_detail
                Internal::where('id_internal', $idInternal)
                    ->update([
                        'nomor_kwitansi_pencairan' => $nomor_kwitansi_pencairan
                    ]);
        }
    }
    


    public function GenerateNomor($upzis, $tahun)
    {
        $siftnu = config('app.database_siftnu');
        $dupzis = Wilayah::where('id_wilayah', $upzis)
                ->first();

            $data_ranting = Ranting::where('ranting.id_wilayah', 'like', $upzis.'%')
                            ->join($siftnu . '.wilayah', 'ranting.id_wilayah', '=', 'wilayah.id_wilayah')
                            ->get();

        foreach ($data_ranting as $d) {
            
            
            $data = Pengajuan::where('id_ranting', $d->id_ranting)
                    ->whereYear('created_at', $tahun)
                    ->orderBy('created_at', 'asc')
                    ->get();
            // dd($d);
    
            $no = 0;
            foreach ($data as $b) {

                $bulan = $b->created_at->format('m');
                $tahunan = $b->created_at->format('Y');

                $bulanan = $this->bulanKeRomawi($bulan);

                $no++;

                if ($no < 10) {
                    $format_no = '0' . $no . '/RANTING-NU/' . $dupzis->nama . '-' .$d->nama . '/' . $bulanan . '/' . $tahunan;
                    // dd($format_no);
                } else {
                    $format_no = $no . '/RANTING-NU/' . $dupzis->nama . '-' .$d->nama . '/' . $bulanan . '/' . $tahunan;
                }

                Pengajuan::where('id_pengajuan', $b->id_pengajuan)
                ->update([
                    'nomor_surat' => $format_no
                ]);

                $a[] = $no;
            }

            
            // dd('jadi');
        }
        
    }
    
    public function GenerateUpzis($upzis, $tahun)
    {
        $dupzis = Wilayah::where('id_wilayah', $upzis)
                ->first();

        $upzis = Upzis::where('id_wilayah', $dupzis->id_wilayah)
                ->get();

        if ($upzis !== null) {
            foreach ($upzis as $d) {
                    $data = Pengajuan::where('id_upzis', $d->id_upzis)
                            ->where('tingkat', 'Upzis MWCNU')
                            ->whereYear('created_at', $tahun)
                            ->orderby('created_at', 'asc')
                            ->get();
                    // dd($data);
            
                    $no = 0;
                    foreach ($data as $b) {

                        $bulan = $b->created_at->format('m');
                        $tahunan = $b->created_at->format('Y');

                        $bulanan = $this->bulanKeRomawi($bulan);

                        $no++;

                        if ($no < 10) {
                            $format_no = '0' . $no . '/UPZIS-MWCNU/' . $dupzis->nama . '/' . $bulanan . '/' . $tahunan;
                            // dd($format_no);
                        } else {
                            $format_no = $no . '/UPZIS-MWCNU/' . $dupzis->nama . '/' . $bulanan . '/' . $tahunan;
                        }

                        Pengajuan::where('id_pengajuan', $b->id_pengajuan)
                        ->update([
                            'nomor_surat' => $format_no
                        ]);

                        $a[] = $no;
                    }

                    
                    // dd('jadi');
            }
        }
        
    }

    public function GenerateUmum($tahun)
    {
        $umum = Pengajuan::where('tingkat', 'PC')->whereYear('created_at', $tahun)
                ->orderBy('created_at', 'asc')
                ->get();

        $nomor = 0;

        foreach ($umum as $u) {
            $nomor++;

            $bulan = $u->created_at->format('m');
            $tahunan = $u->created_at->format('Y');

            $bulanan = $this->bulanKeRomawi($bulan);

            if ($nomor < 10) {
                $format_no = '0' . $nomor . '/UMUM-PC/CILACAP/' . $bulanan . '/' . $tahunan;
                // dd($format_no);
            } else {
                $format_no = $nomor . '/UMUM-PC/CILACAP/' . $bulanan . '/' . $tahunan;
            }

            Pengajuan::where('id_pengajuan', $u->id_pengajuan)
            ->update([
                'nomor_surat' => $format_no
            ]);

            $a[] = $nomor;
        }
    }
    
    public function moveFilesToParentFolder()
    {
        $parentFolder = public_path('uploads/lampiran_berita');
        $subfolders = File::directories($parentFolder);

        foreach ($subfolders as $subfolder) {
            $files = File::files($subfolder);

            foreach ($files as $file) {
                $fileName = pathinfo($file, PATHINFO_BASENAME);
                File::move($file, $parentFolder . '/' . $fileName);
            }

            File::deleteDirectory($subfolder);
        }

        return 'Files moved successfully!';
    }
    
    public function GenerateKetua($tahun)
    {

    $pengajuanDetails = PengajuanDetail::where('approval_status', 'Disetujui')
    ->whereYear('created_at', $tahun)
    ->get();

    foreach ($pengajuanDetails as $detail) {
        // Update kolom yang diminta
        $detail->approval_date_ketua = $detail->approval_date;
        $detail->status_ketua = 'Disetujui';
        $detail->approver_ketua = '07bddefb-e3dc-4713-b3ac-82ae43f2326c';
        $detail->catatan_ketua = '-';

        // Simpan perubahan
        $detail->save();
    }

    return response()->json(['message' => 'Data pengajuan berhasil diperbarui.']);
    }
}
