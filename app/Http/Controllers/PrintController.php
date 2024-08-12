<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use TCPDF;

use Carbon\Carbon;
use App\Models\Berita;

use App\Models\Laporan;
use App\Models\ArusDana;
use App\Models\Internal;
use App\Models\Pengguna;
use App\Models\Programs;
// use App\Models\Programs;
use App\Models\Rekening;
use App\Models\Pengajuan;
use Spatie\PdfToImage\Pdf;
use iio\libmergepdf\Merger;
use App\Helpers\BasicHelper;
use App\Models\ProgramPilar;
use Illuminate\Http\Request;
// use PDF;
// use Dompdf\Dompdf;
use App\Models\PengajuanDetail;
use App\Models\ProgramKegiatan;
use App\Models\PengajuanLampiran;
use App\Http\Controllers\Helper;
use App\Models\DetailBarang;
use App\Models\PengajuanPenerima;
use Illuminate\Support\Facades\DB;
use App\Models\PengajuanPenerimaLPJ;
use App\Models\lpjInternal;
use App\Models\PengajuanLPJ;
use App\Models\lpjUmum;
use Illuminate\Support\Str;

// use App\Http\Livewire\Program as LivewireProgram;

use Illuminate\Support\Facades\Auth;
use App\Models\SurveyPenerimaManfaat;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache; // Import Cache facade
use Maatwebsite\Excel\Facades\Excel;
use PDF as Dompdf; // Pastikan Anda telah memasang pustaka dompdf atau pustaka PDF lainnya yang sesuai


class MyPDF extends TCPDF
{
    // Override the Footer method
    public function Footer()
    {
        $this->SetFont('helvetica');

        // Footer code here
        $this->SetY(-15);
        $this->writeHTMLCell(0, 0, '', '', '<strong style="font-size: 10pt; clear: both; color: #9d9d9d"><em>*Setelah ditandatangani dan distempel, scan lalu upload melalui E-Tasyaruf.</em></strong><hr style="text-decoration: underline double; clear: both; color: #9d9d9d">', 0, 1, 0, true, 'top', true);
        $this->SetY(-13);
        $this->writeHTMLCell(0, 0, '', '', '', 0, 1, 0, true, 'L', true);
        $this->SetY(-9);
        $this->writeHTMLCell(0, 0, '', '', '<em style="margin-top: 10px; font-size: 10pt; clear: both; color: #9d9d9d">Dicetak ' . Carbon::parse(now())->isoFormat('D MMMM Y') . ' ' . Carbon::parse(now())->format('H:i:s') . ' </em>', 0, 1, 0, true, 'L', true);
        $this->SetY(-9);
        $this->writeHTMLCell(0, 0, '', '', '<strong style="font-size: 10pt; clear: both; color: #9d9d9d"><em>Sistem Informasi Filantropi Nahdlatul Ulama, E-Tasyaruf</em></strong>', 0, 1, 0, true, 'R', true);
    }
}

class MyPDFBerita extends TCPDF
{
    // Override the Footer method
    public function Footer()
    {
        $this->SetFont('helvetica');

        // Footer code here
        $this->SetY(-15);
        $this->writeHTMLCell(0, 0, '', '', '<strong style="font-size: 10pt; clear: both; color: #9d9d9d"><em></em></strong><hr style="text-decoration: underline double; clear: both; color: #9d9d9d">', 0, 1, 0, true, 'top', true);
        $this->SetY(-13);
        $this->writeHTMLCell(0, 0, '', '', '', 0, 1, 0, true, 'L', true);
        $this->SetY(-9);
        $this->writeHTMLCell(0, 0, '', '', '<em style="margin-top: 10px; font-size: 10pt; clear: both; color: #9d9d9d">Dicetak ' . Carbon::parse(now())->isoFormat('D MMMM Y') . ' ' . Carbon::parse(now())->format('H:i:s') . ' </em>', 0, 1, 0, true, 'L', true);
        $this->SetY(-9);
        $this->writeHTMLCell(0, 0, '', '', '<strong style="font-size: 10pt; clear: both; color: #9d9d9d"><em>Sistem Informasi Filantropi Nahdlatul Ulama, E-Tasyaruf</em></strong>', 0, 1, 0, true, 'R', true);
    }
}


class MyPDFRekomendasi extends TCPDF
{
    // Override the Footer method
    public function Footer()
    {
        $this->SetFont('helvetica');

        // Footer code here
        $this->SetY(-15);
        $this->writeHTMLCell(0, 0, '', '', '<strong style="font-size: 10pt; clear: both; color: #9d9d9d"><em>*Setelah ditandatangani dan distempel, scan lalu upload melalui E-Tasyaruf.</em></strong><hr style="text-decoration: underline double; clear: both; color: #9d9d9d">', 0, 1, 0, true, 'top', true);
        $this->SetY(-13);
        $this->writeHTMLCell(0, 0, '', '', '', 0, 1, 0, true, 'L', true);
        $this->SetY(-9);
        $this->writeHTMLCell(0, 0, '', '', '<em style="margin-top: 10px; font-size: 10pt; clear: both; color: #9d9d9d">Dicetak ' . Carbon::parse(now())->isoFormat('D MMMM Y') . ' ' . Carbon::parse(now())->format('H:i:s') . ' </em>', 0, 1, 0, true, 'L', true);
        $this->SetY(-9);
        $this->writeHTMLCell(0, 0, '', '', '<strong style="font-size: 10pt; clear: both; color: #9d9d9d"><em>Sistem Informasi Filantropi Nahdlatul Ulama, E-Tasyaruf</em></strong>', 0, 1, 0, true, 'R', true);
    }

    public function Stample($data)
    {
        if ($data->status_rekomendasi == 'Sudah Terbit') {
            if ($data->tingkat == 'Upzis MWCNU' || $data->tingkat == 'Ranting NU') {
                // Simpan posisi Y saat ini
                $currentY = $this->GetY();

                // Set posisi Y agar gambar stempel berada 20 unit di atas posisi Y saat ini
                $this->SetY($currentY + 220);

                // Set posisi X agar stempel berada di tengah
                $xPosition = ($this->getPageWidth() - 50) / 2;
                $this->setX($xPosition);

                // Tampilkan stempel
                $this->Image(public_path('images/ttd/stempel.png'), $this->GetX(), $this->GetY(), 50);

                // Kembalikan posisi Y ke nilai semula
                $this->SetY($currentY);
            }
        }
    }
}


class PrintController extends Controller
{

    protected $etasyaruf;
    protected $siftnu;
    protected $gocap;

    protected $id_program_a;
    protected $id_program_b;
    protected $id_program_c;


    public function __construct()
    {

        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');

        $this->id_program_a = 'ba84d782-81a8-11ed-b4ef-dc215c5aad51';
        $this->id_program_b = 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51';
        $this->id_program_c = 'c51700b1-81a8-11ed-b4ef-dc215c5aad51';

        view()->composer('*', function ($view) {

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $role = 'pc';
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $role = 'upzis';
            }
            $view->with('role', $role);
        });
    }

    public static function nama_pengurus_upzis($id)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_upzis_pengurus', $id)
            ->first();

        if ($a == null) {
            $a = DB::table($siftnu . '.pengguna')->where('gocap_id_ranting_pengurus', $id)
                ->first();
        }
        return $a->nama ?? NULL;
    }

    public static function nama_pengurus_pc($id)
    {
        // dd($id);
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        if ($a == NULL) {
            return '-';
        } else {
            return $a->nama;
        }
    }
    
    public static function get_nama_program($id_program_kegiatan)
    {
        $data = ProgramKegiatan::where('id_program_kegiatan', $id_program_kegiatan)->first();
        return $data->nama_program ?? '';
    }
    
    public function get_nama_pilar($id_pilar)
    {
        $data = ProgramPilar::where('id_program_pilar', $id_pilar)->first();

        return  $data->pilar ?? '';
    }
    
    public function tampil_penerima_manfaat($id_pengajuan)
    {
        // dd('baba');
        $pengajuan = Pengajuan::where('id_pengajuan', $id_pengajuan)->first();
        $pengajuan_det = PengajuanDetail::where('id_pengajuan', $pengajuan->id_pengajuan)->first();
        $data = PengajuanPenerima::where('id_pengajuan', $id_pengajuan)
        ->orderBy('created_at', 'DESC')->get();
        $nama_pilar = $this->get_nama_pilar($pengajuan_det->id_program_pilar);
        $nama_program = $this->get_nama_program($pengajuan_det->id_program_kegiatan);
        $pdf = Dompdf::loadview('print.cetak_penerima_manfaat', compact('pengajuan', 'data', 'pengajuan_det', 'nama_pilar', 'nama_program'))->setPaper('a4', 'potrait');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $pengajuan->nomor_surat . 'PENERIMA_MANFAAT.pdf',
        ]);
    }

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


    public static function jabatan_pengurus_upzis($id)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($gocap . '.upzis_pengurus')->where('id_upzis_pengurus', $id)
            ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
            ->select(
                $gocap . '.pengurus_jabatan.jabatan'
            )->first();

        if ($a == NULL) {

            $a = DB::table($gocap . '.ranting_pengurus')->where('id_ranting_pengurus', $id)
                ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.ranting_pengurus.id_pengurus_jabatan')
                ->select(
                    $gocap . '.pengurus_jabatan.jabatan'
                )->first();
        }
        // dd($a->jabatan);
        return $a->jabatan ?? '-';
    }

    public static function jabatan_pengurus_pc($id)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
            ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->select(
                $gocap . '.pengurus_jabatan.jabatan'
            )
            ->first();
        if ($a == NULL) {
            return '-';
        } else {
            return $a->jabatan;
        }
    }

    public static function alamat_pengurus_upzis($id)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_upzis_pengurus', $id)
            ->first();
        if ($a == NULL) {
            $a = DB::table($siftnu . '.pengguna')->where('gocap_id_ranting_pengurus', $id)
                ->first();
        }
        return $a->alamat ?? '';
    }

    public static function alamat_pengurus_pc($id)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        if ($a == NULL) {
            return '-';
        } else {
            return $a->alamat;
        }
    }


    public  static function nohp_pengurus_upzis($id)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_upzis_pengurus', $id)
            ->first();
        if ($a == NULL) {
            $a = DB::table($siftnu . '.pengguna')->where('gocap_id_ranting_pengurus', $id)
                ->first();
        }
        return $a->nohp ?? '';
    }

    public  static function nohp_pengurus_pc($id)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        if ($a == NULL) {
            return '-';
        } else {
            return $a->nohp;
        }
    }
    
    public function cetak_lampiran($id_pengajuan_lampiran)
    {
        $lampiran = PengajuanLampiran::where('id_pengajuan_lampiran', $id_pengajuan_lampiran)->firstOrFail();
        $path = public_path('uploads/pengajuan_lampiran/' . $lampiran->file);

        return response()->download($path, $lampiran->judul . '.' . pathinfo($lampiran->file, PATHINFO_EXTENSION));
    }
    
    public function cetak_lpj($id_pengajuan_lpj)
    {
        $lpj = PengajuanLPJ::where('id_pengajuan_lpj', $id_pengajuan_lpj)->firstOrFail();
        $path = public_path('uploads/pengajuan_lpj/' . $lpj->file_lpj);

        return response()->download($path, $lpj->judul_lpj . '.' . pathinfo($lpj->file_lpj, PATHINFO_EXTENSION));
    }

    public function print($id_pengajuan)
    {
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $id_pengajuan)->first();
        $nama_pc = Helper::getNamaPc($data->id_pc);
        $nama_upzis = Helper::getNamaUpzis($data->id_upzis);
        $nama_ranting = Helper::getNamaRanting($data->id_ranting);
        // RENCANA
        // PROGRAM PENGUATAN KELEMBAGAAN
        $rencana_a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
            ->where('pengajuan_detail.id_program', $this->id_program_a)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $jumlah_nominal_a = $rencana_a->sum('nominal_pengajuan');
        // PROGRAM SOSIAL
        $rencana_b = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
            ->where('pengajuan_detail.id_program', $this->id_program_b)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $jumlah_nominal_b = $rencana_b->sum('nominal_pengajuan');
        // OPERASIONAL UPZIS
        $rencana_c = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
            ->where('pengajuan_detail.id_program', $this->id_program_c)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $jumlah_nominal_c = $rencana_c->sum('nominal_pengajuan');

        $pdf = new MyPDF();

        $pdf->SetHeaderMargin(30);

        $pdf->SetTopMargin(20);

        $pdf->setFooterMargin(20);

        $pdf->setPrintFooter(true);

        $pdf->setPrintHeader(false);

        $PDF_HEADER_LOGO_WIDTH = "0";

        $pdf->SetHeaderData(PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH);

        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(6 + 0, 6 + 5, 6 + 5);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();

        $pdf->AddPage();

        // Load and render the first view
        $html1 = view('print.permohonan', compact(
            'nama_pc',
            'nama_upzis',
            'nama_ranting',
            'data',
            'jumlah_nominal_a',
            'jumlah_nominal_b',
            'jumlah_nominal_c',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        // Add a new page for the second view
        $pdf->AddPage('L'); // 'L' for landscape orientation

        // Load and render the second view
        $html2 = view('print.daftar_rencana_pengajuan', compact(
            'nama_upzis',
            'nama_ranting',
            'data',
            'rencana_a',
            'jumlah_nominal_a',
            'rencana_b',
            'jumlah_nominal_b',
            'rencana_c',
            'jumlah_nominal_c',
        ))->render();


        // Output the HTML content to the PDF
        $pdf->writeHTML($html2, true, false, true, false, '');

        ob_end_clean();


        // Assuming $data->nomor_surat contains the string "06/UPZIS-MWCNU/Wanareja/XI/2023"
        $nomor_surat = str_replace('/', '_', $data->nomor_surat);

        // Set the file name for the download
        $filename = $nomor_surat . '_PERMOHONAN.pdf';

         // Set the title to be the same as the filename
         $pdf->SetTitle($filename);
         // Output the PDF and force a download
         header('Content-Type: application/pdf');
         header('Content-Disposition: attachment; filename="' . $filename . '"');
         header('Cache-Control: no-cache, no-store, must-revalidate');
         header('Pragma: no-cache');
         header('Expires: 0');
         $pdf->Output($filename, 'I');
         exit;
    }

    public function laporan($id_pengajuan)
    {

        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $id_pengajuan)->first();

        // nama pc
        $n = DB::table($this->gocap . '.pc')->where('id_pc', $data->id_pc)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.pc.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_pc')
            ->first();
        $nama_pc = 'NU Care Lazisnu ' . str_replace('KAB.', '', $n->nama_pc);
        // end nama pc

        if ($data->tingkat == 'Upzis MWCNU' or $data->tingkat == 'Ranting NU') {
            // nama upzis
            $n = DB::table($this->gocap . '.upzis')->where('id_upzis', $data->id_upzis)
                ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.upzis.id_wilayah')
                ->select($this->siftnu . '.wilayah.nama as nama_upzis')
                ->first();
            $nama_upzis = 'UPZIS MWCNU ' . $n->nama_upzis;

            $a = DB::table($this->gocap . '.ranting')->where('id_ranting', $data->id_ranting)
                ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.ranting.id_wilayah')
                ->select($this->siftnu . '.wilayah.nama as nama_ranting')
                ->first();
            if ($a != NULL) {
                $nama_ranting = 'PRNU ' . $a->nama_ranting;
            } else {
                $nama_ranting = NULL;
            }
        } else {
            $nama_upzis = NULL;
            $nama_ranting = NULL;
        }

        $datas = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
            ->join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
            );

        $program = $datas->get()->groupBy('pilar');
        $sum_pencairan = $datas->sum('nominal_pencairan');
        $sum_penerima = $datas->sum('jumlah_penerima');    

        $pdf = Dompdf::loadview('print.laporan',   compact(
            'nama_upzis',
            'nama_ranting',
            'data',
            'program',
            'sum_pencairan',
            'sum_penerima'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="LAPORAN_PENTASYARUFAN_' . ($data->tingkat == 'Upzis MWCNU' ? strtoupper($nama_upzis) :  strtoupper($nama_ranting)) . '_' . $data->nomor_surat . '.pdf"',
        ]);
    }

    public function laporan_excel($id_pengajuan)
    {

        $export = new LaporanExport($id_pengajuan);


        return Excel::download($export, 'Laporam E-Tasyaruf.xlsx');

        dd('sini dulu');
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $id_pengajuan)->first();

        // nama pc
        $n = DB::table($this->gocap . '.pc')->where('id_pc', $data->id_pc)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.pc.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_pc')
            ->first();
        $nama_pc = 'NU Care Lazisnu ' . str_replace('KAB.', '', $n->nama_pc);
        // end nama pc

        if ($data->tingkat == 'Upzis MWCNU' or $data->tingkat == 'Ranting NU') {
            // nama upzis
            $n = DB::table($this->gocap . '.upzis')->where('id_upzis', $data->id_upzis)
                ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.upzis.id_wilayah')
                ->select($this->siftnu . '.wilayah.nama as nama_upzis')
                ->first();
            $nama_upzis = 'UPZIS MWCNU ' . $n->nama_upzis;

            $a = DB::table($this->gocap . '.ranting')->where('id_ranting', $data->id_ranting)
                ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.ranting.id_wilayah')
                ->select($this->siftnu . '.wilayah.nama as nama_ranting')
                ->first();
            if ($a != NULL) {
                $nama_ranting = 'PRNU ' . $a->nama_ranting;
            } else {
                $nama_ranting = NULL;
            }
        } else {
            $nama_upzis = NULL;
            $nama_ranting = NULL;
        }

        $program = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
            ->join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
            )
            ->get()
            ->groupBy('pilar');

        $pdf = Dompdf::loadview('print.laporan',   compact(
            'nama_upzis',
            'nama_ranting',
            'data',
            'program',
        ))->setPaper('a4', 'landscape');

        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="LAPORAN_PENTASYARUFAN_' . ($data->tingkat == 'Upzis MWCNU' ? strtoupper($nama_upzis) :  strtoupper($nama_ranting)) . '_' . $data->nomor_surat . '.pdf"',
        ]);
    }


    

    public static function get_nama_bmt($id_rekening)
    {
        $gocap = config('app.database_gocap');

        $data = Rekening::where('id_rekening', $id_rekening)
            ->join($gocap . '.bmt', $gocap . '.bmt.id_bmt', '=', $gocap . '.rekening.id_bmt')
            ->first();
        return $data->nama_bmt ?? '-';
    }

    public static function sumTotalByProgram($tipe, $id_pengajuan, $value)
    {
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');
        $data = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
            ->join($gocap . '.rekening', $gocap . '.rekening.id_rekening', '=', $etasyaruf . '.pengajuan_detail.id_rekening')
            ->when($tipe == 'bri', function ($query) use ($gocap, $value) {
                return $query->where('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30'])
                    // ->where($etasyaruf . '.pengajuan_detail.id_program', $value);
                    ->whereRaw('LOWER(' . $gocap . '.rekening.nama_rekening) LIKE ?', ['%' . strtolower($value) . '%']);
            })
            ->when($tipe == 'bmt', function ($query) use ($gocap, $value) {
                return $query->whereNotIn('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30'])
                    // ->where($etasyaruf . '.pengajuan_detail.id_program', $value);
                    ->whereRaw('LOWER(' . $gocap . '.rekening.nama_rekening) LIKE ?', ['%' . strtolower($value) . '%']);
            })
            ->sum('nominal_pencairan');
        return $data;
    }

    public static function sumTotalByProgram2($tipe, $id_pengajuan, $value)
    {
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');
        $data = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
            ->join($gocap . '.rekening', $gocap . '.rekening.id_rekening', '=', $etasyaruf . '.pengajuan_detail.id_rekening')

            ->when($tipe == 'bmt', function ($query) use ($etasyaruf, $value) {
                return $query->whereNotIn('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30'])
                    ->where($etasyaruf . '.pengajuan_detail.id_program', $value);
            })
            ->sum('nominal_pencairan');
        return $data;
    }

    public static function getDataRekening3($role, $tipe, $id, $value)
    {
      
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');
        $data = DB::table($gocap . '.rekening')
            ->where($gocap . '.rekening.id_' . $role, $id)
             ->when($role == 'upzis', function ($query) {
                return $query->whereNotNull('id_upzis')->whereNull('id_ranting');
            })
            ->when($role == 'ranting', function ($query) {
                return $query->whereNotNull('id_ranting');
            })
            ->when($tipe == 'bri', function ($query) use ($gocap, $value) {
                return $query->where('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30'])
                    // ->where($etasyaruf . '.pengajuan_detail.id_program', $value);
                    ->whereRaw('LOWER(' . $gocap . '.rekening.nama_rekening) LIKE ?', ['%' . strtolower($value) . '%']);
            })
            ->when($tipe == 'bmt', function ($query) use ($gocap, $value) {
                return $query->whereNotIn('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30'])
                    // ->where($etasyaruf . '.pengajuan_detail.id_program', $value);
                    ->whereRaw('LOWER(' . $gocap . '.rekening.nama_rekening) LIKE ?', ['%' . strtolower($value) . '%']);
            })
            ->get();

        return $data;
    }

    public function getDataPengajuanByProgram($tipe, $id_pengajuan, $id_program)
    {
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');
        $data = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program)
            ->where('pengajuan_detail.pencairan_status', 'Berhasil Dicairkan')
            ->join($gocap . '.rekening', $gocap . '.rekening.id_rekening', '=', $etasyaruf . '.pengajuan_detail.id_rekening')
            ->join($etasyaruf . '.program_kegiatan', $etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->when($tipe == 'bri', function ($query) {
                return $query->where('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30']);
            })
            ->when($tipe == 'bmt', function ($query) {
                return $query->whereNotIn('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30']);
            })
            ->select(
                $etasyaruf . '.program_kegiatan.*',
                $etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();

        return $data;
    }

    public function rekomendasi($tipe, $id_pengajuan)
    {
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $id_pengajuan)->first();
        // dd($data->pj_ranting);
        if ($tipe == 'bmt') {
            $rekening = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
                ->groupby($this->etasyaruf . '.pengajuan_detail.id_rekening')
                ->join($this->gocap . '.rekening', $this->gocap . '.rekening.id_rekening', '=', $this->etasyaruf . '.pengajuan_detail.id_rekening')
                ->whereNotIn('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30'])
                ->get();
        }
        if ($tipe == 'bri') {
            $rekening = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
                ->groupby($this->etasyaruf . '.pengajuan_detail.id_rekening')
                ->join($this->gocap . '.rekening', $this->gocap . '.rekening.id_rekening', '=', $this->etasyaruf . '.pengajuan_detail.id_rekening')
                ->where('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30'])
                ->get();
        }

        $rencana_a = $this->getDataPengajuanByProgram($tipe, $data->id_pengajuan, $this->id_program_a);
        $jumlah_nominal_a = $this->getDataPengajuanByProgram($tipe, $data->id_pengajuan, $this->id_program_a)->sum('nominal_pencairan');
        $rencana_b = $this->getDataPengajuanByProgram($tipe, $data->id_pengajuan, $this->id_program_b);
        $jumlah_nominal_b = $this->getDataPengajuanByProgram($tipe, $data->id_pengajuan, $this->id_program_b)->sum('nominal_pencairan');
        $rencana_c = $this->getDataPengajuanByProgram($tipe, $data->id_pengajuan, $this->id_program_c);
        $jumlah_nominal_c = $this->getDataPengajuanByProgram($tipe, $data->id_pengajuan, $this->id_program_c)->sum('nominal_pencairan');

        $pdf = new MyPDFRekomendasi();

        $pdf->SetHeaderMargin(30);

        $pdf->SetTopMargin(20);

        $pdf->setFooterMargin(20);

        $pdf->setPrintFooter(true);

        $pdf->setPrintHeader(false);

        $PDF_HEADER_LOGO_WIDTH = "0";

        $pdf->SetHeaderData(PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH);

        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(6 + 0, 6 + 5, 6 + 5);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.8);

        ob_start();

        $pdf->AddPage();

        $html1 = view('print.rekomendasi', compact(
            'data',
            'tipe',
            'rekening',
            'pdf'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        // Add a new page for the second view
        $pdf->AddPage('L'); // 'L' for landscape orientation


        // Load and render the second view
        $html2 = view('print.daftar_rencana_rekom', compact(
            'data',
            'tipe',
            'rencana_a',
            'jumlah_nominal_a',
            'rencana_b',
            'jumlah_nominal_b',
            'rencana_c',
            'jumlah_nominal_c',
        ))->render();


        // Output the HTML content to the PDF
        $pdf->writeHTML($html2, true, false, true, false, '');

        ob_end_clean();

        // Assuming $data->nomor_surat contains the string "06/UPZIS-MWCNU/Wanareja/XI/2023"
        $nomor_surat = str_replace('/', '_', $data->nomor_surat);

        if ($data->status_rekomendasi == 'Sudah Terbit') {
            // Set the file name for the download
            $filename = $nomor_surat . '_REKOMENDASI.pdf';
        } else {
            $filename = $nomor_surat . '_REKOMENDASI(PREVIEW).pdf';
        }

         // Set the title to be the same as the filename
         $pdf->SetTitle($filename);
         // Output the PDF and force a download
         header('Content-Type: application/pdf');
         header('Content-Disposition: attachment; filename="' . $filename . '"');
         header('Cache-Control: no-cache, no-store, must-revalidate');
         header('Pragma: no-cache');
         header('Expires: 0');
         $pdf->Output($filename, 'I');
         exit;

        // Output the PDF as inline (in the browser) RENDER
        // $pdf->Output('output.pdf', 'I');


        // $m->addRaw($pdf2->output());
        // if ($data->status_rekomendasi == 'Sudah Terbit') {
        //     return response($m->merge())
        //         ->withHeaders([
        //             'Title' => 'Your meta title',
        //             'Content-Type' => 'application/pdf',
        //             'Cache-Control' => 'no-store, no-cache',
        //             'Content-Disposition' => 'filename="' . $data->nomor_surat . '_REKOMENDASI.pdf',
        //         ]);
        // } else {
        //     return response($m->merge())
        //         ->withHeaders([
        //             'Title' => 'Your meta title',
        //             'Content-Type' => 'application/pdf',
        //             'Cache-Control' => 'no-store, no-cache',
        //             'Content-Disposition' => 'filename="' . $data->nomor_surat . '_REKOMENDASI(PREVIEW).pdf',
        //         ]);
        // }
    }

    public function berita_pc()
    {
        $pdf = Dompdf::loadview('print.berita_acara_pc');
        return $pdf->stream();
    }
    
    public function berita_serah_terima($id_pengajuan_detail)
    {

        
        $etasyaruf = config('app.database_etasyaruf');
        $data = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)
            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->first();
        // dd($data);
        
        $tanggal = $data->tgl_berita;

        // Konversi tanggal ke objek Carbon
        $today = Carbon::parse($tanggal);
    
        // Ambil informasi yang dibutuhkan
        $namaHari = $today->isoFormat('dddd');
        $tahun = $today->year;
        $bulan = $today->isoFormat('MMMM');
        $hari = $today->day;
        
        $berupaa = strtolower($data->berupa);
        
        if (Str::contains($berupaa, 'uang')) {
            $datas = ' dengan nilai total bantuan sebesar Rp ' . number_format($data->senilai, 0, '.', '.');
        } else {
            $datas = ' dengan jumlah bantuan yaitu ' . $data->jumlah_bantuan . ' senilai ' . number_format($data->senilai, 0, '.', '.');
        }

        $barang = DetailBarang::where('id_pengajuan_detail', $id_pengajuan_detail)
        ->get();

        $data_penerima_lpj = PengajuanPenerima::where('id_pengajuan_detail', $id_pengajuan_detail)->get();

        $nama_pc = Helper::getNamaPc($data->id_pc);
        // Assuming $data->nomor_surat contains the string "06/UPZIS-MWCNU/Wanareja/XI/2023"
        $nomor_surat = str_replace('/', '_', $data->nomor_surat);
        // dd($nomor_surat);

        // Set the file name for the download
        $filename =  Helper::getDataKegiatan($data->id_program_kegiatan)->pluck('nama_program')->first();
        // dd($filename);
        $pdf = Dompdf::loadview('print.berita_serah_terima_umum', compact('datas', 'data', 'filename', 'nomor_surat', 'nama_pc', 'barang', 'tahun', 'bulan', 'hari', 'namaHari'))->setPaper('a4', 'potrait');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="LPJ - ' . Helper::getDataKegiatan($data->id_program_kegiatan)->pluck('nama_program')->first() . '-' . $nomor_surat . '.pdf"',
        ]);
    }
    
    public function berita_serah_terima_transfer($id_pengajuan_detail)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $data = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)
            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->first();
        // dd($data);
        
        $tanggal = $data->tgl_berita;

        // Konversi tanggal ke objek Carbon
        $today = Carbon::parse($tanggal);
    
        // Ambil informasi yang dibutuhkan
        $namaHari = $today->isoFormat('dddd');
        $tahun = $today->year;
        $bulan = $today->isoFormat('MMMM');
        $hari = $today->day;
        
        $berupaa = strtolower($data->berupa);
        
        if (Str::contains($berupaa, 'uang')) {
            $datas = ' dengan nilai total bantuan sebesar Rp ' . number_format($data->senilai, 0, '.', '.');
        } else {
            $datas = ' dengan jumlah bantuan yaitu ' . $data->jumlah_bantuan . ' senilai ' . number_format($data->senilai, 0, '.', '.');
        }

        $barang = DetailBarang::where('id_pengajuan_detail', $id_pengajuan_detail)
        ->get();

        $data_penerima_lpj = PengajuanPenerima::where('id_pengajuan_detail', $id_pengajuan_detail)->get();

        $nama_pc = Helper::getNamaPc($data->id_pc);
        // Assuming $data->nomor_surat contains the string "06/UPZIS-MWCNU/Wanareja/XI/2023"
        $nomor_surat = str_replace('/', '_', $data->nomor_surat);
        // dd($nomor_surat);

        // Set the file name for the download
        $filename =  Helper::getDataKegiatan($data->id_program_kegiatan)->pluck('nama_program')->first();
        // dd($filename);
        $pdf = Dompdf::loadview('print.berita_serah_terima_transfer', compact('datas', 'data', 'filename', 'nomor_surat', 'nama_pc', 'barang', 'tahun', 'bulan', 'hari', 'namaHari'))->setPaper('a4', 'potrait');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="LPJ - ' . Helper::getDataKegiatan($data->id_program_kegiatan)->pluck('nama_program')->first() . '-' . $nomor_surat . '.pdf"',
        ]);
    }
    
    public static function ttd_ba($nama)
    {
        // dd($id);
        $siftnu = config('app.database_siftnu');

        $a = DB::table($siftnu . '.pengguna')
        ->where('nama', $nama)
            ->first();
        // dd($a);
        if ($a == NULL) {
            return '-';
        } else {
            return $a->ttd;
        }
    }

    public function berita_upzis_ranting($id_pengajuan_detail)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $data = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)
            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->first();

        $data_penerima_lpj = PengajuanPenerimaLPJ::where('id_pengajuan_detail', $id_pengajuan_detail)->get();

        $nama_pc = Helper::getNamaPc($data->id_pc);
        $nama_upzis = Helper::getNamaUpzis($data->id_upzis);
        $nama_ranting = Helper::getNamaRanting($data->id_ranting);

        $pdf = new MyPDFBerita();

        $pdf->SetHeaderMargin(30);

        $pdf->SetTopMargin(20);

        $pdf->setFooterMargin(20);

        $pdf->setPrintFooter(true);

        $pdf->setPrintHeader(false);

        $PDF_HEADER_LOGO_WIDTH = "0";

        $pdf->SetHeaderData(PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH);

        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(6 + 0, 6 + 5, 6 + 5);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);


        ob_start();

        $pdf->AddPage('P');

        // Load and render the first view
        $html1 = view('print.berita_acara_upzis_ranting', compact(
            'data',
            'nama_pc',
            'nama_upzis',
            'nama_ranting',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $pdf->AddPage('L'); // 'L' for landscape orientation

        // Load and render the second view
        $html2 = view('print.lampiran_serah_terima_bantuan', compact(
            'data',
            'data_penerima_lpj',
            'nama_pc',
            'nama_upzis',
            'nama_ranting',
        ))->render();


        // Output the HTML content to the PDF
        $pdf->writeHTML($html2, true, false, true, false, '');

        $pdf->AddPage('P'); // 'L' for landscape orientation

        // Load and render the second view
        $html3 = view('print.kwitansi_lpj', compact(
            'data',
            'nama_pc',
            'nama_upzis',
            'nama_ranting',
            'pdf'
        ))->render();

        $pdf->writeHTML($html3, true, false, true, false, '');

        ob_end_clean();

        // Assuming $data->nomor_surat contains the string "06/UPZIS-MWCNU/Wanareja/XI/2023"
        $nomor_surat = str_replace('/', '_', $data->nomor_surat);
        $nam_prog =  str_replace('/', '_', Helper::getDataKegiatan($data->id_program_kegiatan)->pluck('nama_program')->first());
    
        // Set the file name for the download
        $filename =  'LPJ _ ' . $nam_prog . '_' . $nomor_surat . '.pdf';

        // Set the title to be the same as the filename
        $pdf->SetTitle($filename);
        // Output the PDF and force a download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        $pdf->Output($filename, 'I');
        exit;
    }

    public function berita_acara_umum_pc($id_pengajuan_detail)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $data = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)
            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->first();

        $data_penerima_lpj = PengajuanPenerima::where('id_pengajuan_detail', $id_pengajuan_detail)->get();

        $nama_pc = Helper::getNamaPc($data->id_pc);
        $nama_upzis = Helper::getNamaUpzis($data->id_upzis);
        $nama_ranting = Helper::getNamaRanting($data->id_ranting);

        $pdf = new MyPDFBerita();

        $pdf->SetHeaderMargin(30);

        $pdf->SetTopMargin(20);

        $pdf->setFooterMargin(20);

        $pdf->setPrintFooter(true);

        $pdf->setPrintHeader(false);

        $PDF_HEADER_LOGO_WIDTH = "0";

        $pdf->SetHeaderData(PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH);

        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(6 + 0, 6 + 5, 6 + 5);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();

        $pdf->AddPage('P');

        // Load and render the first view
        $html1 = view('print.berita_acara_upzis_ranting', compact(
            'data',
            'nama_pc',
            'nama_upzis',
            'nama_ranting',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $pdf->AddPage('P'); // 'L' for landscape orientation

        // Load and render the second view
        $html3 = view('print.kwitansi_lpj', compact(
            'data',
            'nama_pc',
            'nama_upzis',
            'nama_ranting',
            'pdf'
        ))->render();

        $pdf->writeHTML($html3, true, false, true, false, '');

        ob_end_clean();

        // Assuming $data->nomor_surat contains the string "06/UPZIS-MWCNU/Wanareja/XI/2023"
        $nomor_surat = str_replace('/', '_', $data->nomor_surat);

        // Set the file name for the download
        $filename =  'LPJ - ' . Helper::getDataKegiatan($data->id_program_kegiatan)->pluck('nama_program')->first() . '-' . $nomor_surat . '.pdf';

         // Set the title to be the same as the filename
         $pdf->SetTitle($filename);
         // Output the PDF and force a download
         header('Content-Type: application/pdf');
         header('Content-Disposition: attachment; filename="' . $filename . '"');
         header('Cache-Control: no-cache, no-store, must-revalidate');
         header('Pragma: no-cache');
         header('Expires: 0');
         $pdf->Output($filename, 'I');
         exit;
    }


    // public function berita_acara_umum_pc($id_pengajuan_detail)
    // {

    //     $etasyaruf = config('app.database_etasyaruf');
    //     $data = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)
    //         ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
    //         ->first();

    //     $data_penerima_lpj = PengajuanPenerima::where('id_pengajuan_detail', $id_pengajuan_detail)->get();

    //     $nama_pc = Helper::getNamaPc($data->id_pc);
    //     $nama_upzis = Helper::getNamaUpzis($data->id_upzis);
    //     $nama_ranting = Helper::getNamaRanting($data->id_ranting);
    //     // Check if the merged PDF is already in cache
    //     $cacheKey = 'merged_pdf_' . $data->id_program_kegiatan;
    //     if (Cache::has($cacheKey)) {
    //         return response(Cache::get($cacheKey))
    //             ->withHeaders([
    //                 'Title' => 'Your meta title',
    //                 'Content-Type' => 'application/pdf',
    //                 'Cache-Control' => 'no-store, no-cache',
    //                 'Content-Disposition' => 'filename=BA-' . Helper::getDataKegiatan($data->id_program_kegiatan)->pluck('nama_program')->first() . '-' . $data->nomor_surat . '.pdf',
    //             ]);
    //     }

    //     // If not in cache, merge the PDFs and store in cache
    //     $m = new Merger();
    //     $pdf = Dompdf::loadview('print.berita_acara_pc_umum', compact(
    //         'data',
    //         'nama_pc',
    //         'nama_upzis',
    //         'nama_ranting',
    //     ))->setPaper('a4', 'potrait');
    //     $m->addRaw($pdf->output());

    //     $pdf2 = Dompdf::loadview('print.lampiran_serah_terima_bantuan_umum_pc', compact(
    //         'data',
    //         'data_penerima_lpj',
    //         'nama_pc',
    //         'nama_upzis',
    //         'nama_ranting',
    //     ))->setPaper('a4', 'landscape');
    //     $m->addRaw($pdf2->output());

    //     $pdf3 = Dompdf::loadview('print.kwitansi', compact(
    //         'data',
    //         'nama_pc',
    //         'nama_upzis',
    //         'nama_ranting',
    //     ))->setPaper('a4', 'potrait');
    //     $m->addRaw($pdf3->output());

    //     $mergedPdf = $m->merge();

    //     // Store the merged PDF in cache for future use
    //     Cache::put($cacheKey, $mergedPdf, 60); // Cache for 60 minutes

    //     return response($mergedPdf)
    //         ->withHeaders([
    //             'Title' => 'Your meta title',
    //             'Content-Type' => 'application/pdf',
    //             'Cache-Control' => 'no-store, no-cache',
    //             'Content-Disposition' => 'filename=BA-' . Helper::getDataKegiatan($data->id_program_kegiatan)->pluck('nama_program')->first() . '-' . $data->nomor_surat . '.pdf',
    //         ]);
    // }


    public function survey($id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // dd($id);
        $a = SurveyPenerimaManfaat::join('pengajuan_penerima', 'pengajuan_penerima.id_pengajuan_penerima', '=', 'survey_penerima_manfaat.id_penerima_manfaat')
            ->where('id_penerima_manfaat', $id)->first();
        // dd($a);

        $nama = Pengguna::join($gocap . '.pc_pengurus', 'pc_pengurus.id_pc_pengurus', '=', 'pengguna.gocap_id_pc_pengurus')
            ->join($gocap . '.pengurus_jabatan', 'pengurus_jabatan.id_pengurus_jabatan', '=', 'pc_pengurus.id_pengurus_jabatan')
            ->where('pc_pengurus.id_pengurus_jabatan', '20f2ff4d-1596-48ab-b60d-8a4b75a9784d')->first()->nama;
        // dd($s);

        $nama_surveyor = $nama;
        $tgl_survey = $a->tanggal_survey;
        $nama_mustahik = $a->nama;
        $alamat_mustahik = $a->alamat;
        $jenis_permohonan = $a->jenis_permohonan;
        $jumlah_anak = $a->jumlah_anak;
        $jumlah_total = $a->jumlah_anggota_keluarga;
        $suami_istri = $a->punya_suami_istri;
        $perkerjaan_suami = $a->pekerjaan_suami;
        $pekerjaan_istri = $a->pekerjaan_istri;
        $pekerjaan_anak = $a->pekerjaan_anak;
        $penghasilan_suami = $a->penghasilan_suami;
        $penghasilan_istri = $a->penghasilan_istri;
        $penghasilan_anak = $a->penghasilan_anak;
        $kondisi_atap = $a->kondisi_atap_rumah;
        $kondisi_dinding = $a->kondisi_dinding_rumah;
        $kondisi_lantai = $a->kondisi_lantai_rumah;
        $kondisi_ukuran = $a->ukuran_rumah;
        $kepemilikan_rumah = $a->status_kepemilikan_rumah;
        $kepemilikan_tanah = $a->status_kepemilikan_tanah;
        $harta_aset_kekayaan = $a->aset_lainnya;
        $biaya_tanggungan_bulanan = $a->biaya_pengeluaran_bulanan;
        $kebutuhan_menedesak = $a->kebutuhan_saat_ini;
        $bantuan_yg_didapat = $a->bantuan_yang_pernah_didapat;
        $indeks_rumah = $a->indeks_rumah;
        $keterangan_rumah = $a->keterangan_indeks_rumah;
        $indeks_harta = $a->kepemilikan_harta;
        $keterangan_harta = $a->keterangan_kepemilikan_harta;
        $indeks_pendapatan = $a->pendapatan;
        $keterangan_pendapatan = $a->keterangan_pendapatan;
        $rekomendasi = $a->hasil_rekomendasi;
        $hasil = $a->hasil;

        $pdf = Dompdf::loadview('print.survey', compact(
            'nama_surveyor',
            'tgl_survey',
            'nama_mustahik',
            'alamat_mustahik',
            'jenis_permohonan',
            'jumlah_anak',
            'jumlah_total',
            'suami_istri',
            'perkerjaan_suami',
            'pekerjaan_istri',
            'pekerjaan_anak',
            'penghasilan_suami',
            'penghasilan_istri',
            'penghasilan_anak',
            'kondisi_atap',
            'kondisi_dinding',
            'kondisi_lantai',
            'kondisi_ukuran',
            'kepemilikan_rumah',
            'kepemilikan_tanah',
            'harta_aset_kekayaan',
            'biaya_tanggungan_bulanan',
            'kebutuhan_menedesak',
            'bantuan_yg_didapat',
            'indeks_rumah',
            'keterangan_rumah',
            'indeks_harta',
            'keterangan_harta',
            'indeks_pendapatan',
            'keterangan_pendapatan',
            'rekomendasi',
            'hasil',
        ));
        return $pdf->stream('FORM ISIAN SURVEY MUSTAHIK NU CARE LAZISNU CILACAP.pdf');
    }

    public function internal($id_internal)
    {

        // dd('wd');

        $data = Internal::where('id_internal', $id_internal)->first();

        // $jabatans = ['Kepala Cabang', 'Divisi Keuangan', 'Divisi Program dan Administrasi Umum'];
        $id_jabatan = ['694f38af-5374-11ed-882e-e4a8df91d8b3', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3', '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'];
        $data_pengurus = [];
        $data_jab = [];

        foreach ($id_jabatan as $jabatan) {
            $result = DB::table($this->gocap . '.pengurus_jabatan')
                    ->where($this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', $jabatan)
                    ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
                    ->join($this->siftnu . '.pengguna', $this->gocap . '.pc_pengurus.id_pc_pengurus', '=', $this->siftnu . '.pengguna.gocap_id_pc_pengurus')
                    ->select($this->siftnu . '.pengguna.*')
                    ->first();

            $data_pengurus[$jabatan] = $result ? $result->nama : null;

        
        }

        foreach ($id_jabatan as $j) {
            $result = DB::table($this->gocap . '.pengurus_jabatan')
                ->where('id_pengurus_jabatan', $j)
                ->select($this->gocap . '.pengurus_jabatan.*')
                ->first();

            $data_jab[$j] = $result ? $result->jabatan : null;
        }
        $div_keu = $data_jab['694f38af-5374-11ed-882e-e4a8df91d8b3'];
        $direktur = $data_jab['8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3'];
        $program = $data_jab['8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'];

        $nama_direktur = $data_pengurus['8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3'];
        $nama_keuangan = $data_pengurus['694f38af-5374-11ed-882e-e4a8df91d8b3'];
        $nama_program = $data_pengurus['8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'];

        $lampiran = Internal::join('pengajuan_lampiran', 'pengajuan_lampiran.id_internal', '=', 'internal.id_internal')
    ->where('pengajuan_lampiran.id_internal', $id_internal)
    ->get(['pengajuan_lampiran.judul']);

                // dd($lampiran);

        // dd($lampiran);


        $pdf = Dompdf::loadview('print.internal', compact(
            'data',
            'nama_direktur',
            'nama_keuangan',
            'nama_program',
            'lampiran',
            'program',
            'direktur',
            'div_keu',
        ))->setPaper('a4', 'landscape');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $data->nomor_surat . '_FPPD.pdf',
        ]);
    }

    public function print_penggunaan_dana($id_internal)
    {
        $internal = Internal::where('id_internal', $id_internal)->first();
        $data = lpjInternal::where('id_internal', $id_internal)->orderBy('tgl_penggunaan_dana', 'DESC')->get();
        // dd($internal);
        $nominal_digunakan = $data->sum('nominal');
        $sisa_dana = $internal->nominal_pencairan - $data->sum('nominal');
        // dd($nominal_digunakan);

        $pdf = Dompdf::loadview('print.penggunaan_dana', compact('data', 'internal', 'nominal_digunakan', 'sisa_dana'))->setPaper('a4', 'landscape');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $internal->nomor_surat . 'PENGGUNAAN_DANA.pdf',
        ]);
    }
    
    public function print_penggunaan_dana_umum($id_pengajuan_detail)
    {
        $pengajuan = Pengajuan::join('pengajuan_detail', 'pengajuan_detail.id_pengajuan', '=', 'pengajuan.id_pengajuan')
    ->where('pengajuan_detail.id_pengajuan_detail', $id_pengajuan_detail)
    ->select('pengajuan.*', 'pengajuan_detail.*')
    ->first();
    // dd($pengajuan);
        $data = lpjUmum::where('id_pengajuan_detail', $id_pengajuan_detail)->orderBy('tgl_penggunaan_dana', 'DESC')->get();
        // dd($internal);
        $nominal_digunakan = $data->sum('nominal');
        if ($pengajuan->nominal_pencairan == null || $pengajuan->nominal_pencairan == "")
        {
            $sisa_dana = $pengajuan->nominal_disetujui_pencairan_direktur - $nominal_digunakan;   
        } else {
            $sisa_dana = $pengajuan->nominal_pencairan - $nominal_digunakan; 
        }
        // dd($nominal_digunakan);

        $pdf = Dompdf::loadview('print.penggunaan_dana_umum', compact('data', 'pengajuan', 'nominal_digunakan', 'sisa_dana'))->setPaper('a4', 'landscape');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $pengajuan->nomor_surat . 'PENGGUNAAN_DANA.pdf',
        ]);
    }

    public function print_kwitansi($id_internal)
    {
        $internal = Internal::where('id_internal', $id_internal)->first();
        // $data = lpjInternal::where('id_internal', $id_internal)->orderBy('created_at', 'DESC')->get();

        // $nominal_digunakan = $data->sum('nominal');
        // $sisa_dana = $internal->nominal_pencairan - $data->sum('nominal');
        // dd($nominal_digunakan);

        $pdf = Dompdf::loadview('print.kwitansi2', compact('internal'))->setPaper('a4', 'potrait');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $internal->nomor_surat . '_KWITANSI_PENCAIRAN.pdf',
        ]);
    }
    
    public function print_kwitansi_umum($id_pengajuan_detail)
    {
        $data_det = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->first();
        $data = Pengajuan::where('id_pengajuan', $data_det->id_pengajuan)->first();

        $pdf = Dompdf::loadview('print.kwitansi3', compact('data_det', 'data'))->setPaper('a4', 'potrait');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $data->nomor_surat . '_KWITANSI_PENCAIRAN_UMUM.pdf',
        ]);
    }

    public static function nama_rekening($id)
    {
        $a = Rekening::where('id_rekening', $id)->first();
        return  $a->nama_rekening ?? '-';
    }

    public static function no_rekening($id)
    {
        $a = Rekening::where('id_rekening', $id)->first();
        return  $a->no_rekening ?? '-';
    }


    public function nama_wilayah($id)
    {
        $a = DB::table($this->gocap . '.upzis')->where('id_upzis', $id)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.upzis.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_upzis')
            ->first();
        return  $a->nama_upzis;
    }



    public static function getPenerimaanPerProgram($bulan, $tahun, $id_rekening)
    {
        $nama_upzis = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;

        $a = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening)
            ->sum('nominal');

        if ($a != 0) {
            return '<span style="float: left;">Rp</span>'
                . '<span style="float: right;">' . number_format($a, 0, '.', '.')  . ',-</span>';
        } else {
            return '<span style="float: left;"></span>'
                . '<span style="float: right;">-</span>';
        }
    }

    public static function getPenerimaanLainnya($bulan, $tahun)
    {
        $gocap = config('app.database_gocap');

        $a = ArusDana::where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Mutasi Rekening')
            ->whereYear($gocap . '.arus_dana.created_at', $tahun)
            ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
            // ->where('id_rekening', $id_rekening)
            ->sum('nominal');

        if ($a != 0) {
            return '<span style="float: left;">Rp</span>'
                . '<span style="float: right;">' . number_format($a, 0, '.', '.')  . ',-</span>';
        } else {
            return '<span style="float: left;"></span>'
                . '<span style="float: right;">-</span>';
        }
    }

    public static function getJumlahPenerimaan($bulan, $tahun, $id_rekening_sosial, $id_rekening_kelembagaan, $id_rekening_operasional)
    {
        $nama_upzis = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
        $gocap = config('app.database_gocap');


        $a = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_sosial)
            ->sum('nominal');
        $b = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_kelembagaan)
            ->sum('nominal');
        $c = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_operasional)
            ->sum('nominal');

        // penerimaan lainnya
        $d = ArusDana::where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Mutasi Rekening')
            ->whereYear($gocap . '.arus_dana.created_at', $tahun)
            ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
            // ->where('id_rekening', $id_rekening)
            ->sum('nominal');

        if ($a + $b + $c + $d != 0) {
            return '<span style="float: left;"><b>Rp</b></span>'
                . '<span style="float: right;"><b>' . number_format($a + $b + $c  + $d, 0, '.', '.')  . ',-</b></span>';
        } else {
            return '<span style="float: left;"><b></b></span>'
                . '<span style="float: right;"><b>-</b></span>';
        }
    }

    public static function getJumlahPerPilar($bulan, $tahun, $id_upzis, $id_program_pilar)
    {
        $etasyaruf = config('app.database_etasyaruf');

        $jumlah_per_pilar = PengajuanDetail::whereMonth($etasyaruf . '.pengajuan_detail.tgl_pelaksanaan', $bulan)
            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->whereYear($etasyaruf . '.pengajuan_detail.created_at', $tahun)->where('id_program_pilar', $id_program_pilar)
            ->whereNotNull('id_pc')
            ->where('id_upzis', $id_upzis)
            ->whereNull('id_ranting')
            ->sum('nominal_disetujui');


        return $jumlah_per_pilar;
    }

    public static function getSaldoAkhir($bulan, $tahun, $id_upzis, $jumlah_saldo_awal, $id_rekening_sosial, $id_rekening_kelembagaan, $id_rekening_operasional)
    {
        $nama_upzis = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        // penerimaan
        $a = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_sosial)
            ->sum('nominal');
        $b = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_kelembagaan)
            ->sum('nominal');
        $c = ArusDana::where('uraian', 'LIKE', '%' . strtoupper($nama_upzis) . '%')
            ->where('uraian', 'LIKE', '%' . BasicHelper::getNamaBulan($bulan) . '%')
            ->where('uraian', 'LIKE', '%' . $tahun . '%')
            ->where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Penghimpunan Koin NU')
            ->where('id_rekening', $id_rekening_operasional)
            ->sum('nominal');

        // penerimaan lainnya
        $d = ArusDana::where('jenis_dana', 'masuk')
            ->where('jenis_kas', 'Mutasi Rekening')
            ->whereYear($gocap . '.arus_dana.created_at', $tahun)
            ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
            // ->where('id_rekening', $id_rekening)
            ->sum('nominal');



        $hasil = $a + $b + $c + $d;

        // penyaluran
        $x = PengajuanDetail::whereMonth($etasyaruf . '.pengajuan_detail.tgl_pelaksanaan', $bulan)
            ->whereYear($etasyaruf . '.pengajuan_detail.tgl_pelaksanaan', $tahun)
            ->where('approval_status', 'Disetujui')
            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->whereNotNull('id_pc')
            ->where('id_upzis', $id_upzis)
            ->whereNull('id_ranting')
            ->sum('nominal_disetujui');

        // pengeluaran lainnya
        $y = ArusDana::where('jenis_dana', 'keluar')
            ->where('jenis_kas', 'Mutasi Rekening')
            ->whereYear($gocap . '.arus_dana.created_at', $tahun)
            ->whereMonth($gocap . '.arus_dana.created_at', $bulan)
            // ->where('id_rekening', $id_rekening)
            ->sum('nominal');

        $jumlah_akhir_penyaluran = $x + $y;

        $laporan = Laporan::where('bulan', $bulan)->where('tahun', $tahun)->first();

        if ($laporan != null) {
            Laporan::where('bulan', $bulan)->where('tahun', $tahun)->update([
                'saldo_akhir' => $jumlah_saldo_awal + $hasil - $jumlah_akhir_penyaluran,
            ]);
        }


        if ($jumlah_saldo_awal + $hasil - $jumlah_akhir_penyaluran != 0) {
            return '<span style="float: left;">Rp</span>'
                . '<span style="float: right;">' . number_format($jumlah_saldo_awal + $hasil - $jumlah_akhir_penyaluran, 0, '.', '.')  . ',-</span>';
        } else {
            return '<span style="float: left;"></span>'
                . '<span style="float: right;">-</span>';
        }
    }

    public static function getNamaPengurus($role, $jabatan, $id)
    {
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');

        $a = DB::table($gocap . '.pengurus_jabatan')
            ->where('tingkat', $role)
            ->where('jabatan', $jabatan)
            ->join($gocap . '.' . $role . '_pengurus', $gocap . '.' . $role . '_pengurus.id_pengurus_jabatan', '=', $gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_' . $role . '_pengurus', '=', $gocap . '.' . $role . '_pengurus.id_' . $role . '_pengurus')
            ->where($gocap . '.' . $role . '_pengurus.id_' . $role, $id)
            ->where($gocap . '.' . $role . '_pengurus.status', '1')
            ->select(
                $siftnu . '.pengguna.nama'
            )->first();

        return $a->nama ?? '..........................';
    }

    public static function getProgramKegiatan($id)
    {
        $a = ProgramKegiatan::where('id_program_kegiatan', $id)->first();
        return $a->nama_program ?? '..........................';
    }
}
