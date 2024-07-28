<?php

namespace App\Http\Controllers;

use TCPDF;
use Carbon\Carbon;
use App\Models\Upzis;
use App\Models\Berita;
use App\Models\Ranting;
use App\Models\Wilayah;
use App\Models\Rekening;
use App\Models\Pengajuan;
use App\Models\SurveyFoto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PengajuanDetail;
use App\Models\ProgramKegiatan;
use App\Models\PengajuanPenerima;
use Illuminate\Support\Facades\DB;

// use Session;
use App\Models\PengajuanDokumentasi;

use App\Models\PengajuanPenerimaLPJ;
use App\Models\PengajuanPengeluaran;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class MyPDF extends TCPDF
{
    // Override the Footer method
    public function Footer()
    {
        $this->SetFont('helvetica');

        // Footer code here
        $this->SetY(-15);
        $this->writeHTMLCell(0, 0, '', '', '<strong style="font-size: 10pt; clear: both; color: #9d9d9d"></strong><hr style="text-decoration: underline double; clear: both; color: #9d9d9d">', 0, 1, 0, true, 'top', true);
        $this->SetY(-13);
        $this->writeHTMLCell(0, 0, '', '', '', 0, 1, 0, true, 'L', true);
        $this->SetY(-9);
        $this->writeHTMLCell(0, 0, '', '', '<em style="margin-top: 10px; font-size: 10pt; clear: both; color: #9d9d9d">Dicetak ' . Carbon::parse(now())->isoFormat('D MMMM Y') . ' ' . Carbon::parse(now())->format('H:i:s') . ' </em>', 0, 1, 0, true, 'L', true);
        $this->SetY(-9);
        $this->writeHTMLCell(0, 0, '', '', '<strong style="font-size: 10pt; clear: both; color: #9d9d9d"><em>Sistem Informasi Filantropi Nahdlatul Ulama, E-Tasyaruf</em></strong>', 0, 1, 0, true, 'R', true);
    }
}


class PengajuanController extends Controller
{
    public $siftnu;
    public $gocap;
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
            }
            $view->with('role', $role);
        });
    }

    public static function cetak_dokumen_survey($id_pengajuan_detail)
    {

        $data_dokumentasi =  SurveyFoto::where('id_pengajuan_detail', $id_pengajuan_detail)->get();

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

        $pdf->SetMargins(3 + 0, 3 + 2, 3 + 2);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();
        $pdf->AddPage('P');


        // Load and render the first view
        $html1 = view('print.cetak_dokumentasi_survey', compact(
            'data_dokumentasi',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');


        $filename = 'DATA DOKUMENTASI SURVEY.pdf';

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


    public static function get_nama_program($id_program_kegiatan)
    {
        $data = ProgramKegiatan::where('id_program_kegiatan', $id_program_kegiatan)->first();
        return $data->nama_program ?? '';
    }

    public static function get_nama_upzis($id_upzis)
    {
        $data = Upzis::where('id_upzis', $id_upzis)->first();
        if ($data) {
            $wilayah = Wilayah::where('id_wilayah', $data->id_wilayah)->first();
            return $wilayah->nama ?? '';
        } else {
            return '';
        }
    }

    public static function get_nama_ranting($id_ranting)
    {
        // dd($id_ranting);
        $data = Ranting::where('id_ranting', $id_ranting)->first();
        $wilayah = Wilayah::where('id_wilayah', $data->id_wilayah)->first();
        return $wilayah->nama ?? '';
    }



    public static function get_nama_bmt($id_rekening)
    {
        $gocap = config('app.database_gocap');

        $data = Rekening::where('id_rekening', $id_rekening)
            ->join($gocap . '.bmt', $gocap . '.bmt.id_bmt', '=', $gocap . '.rekening.id_bmt')
            ->first();
        return $data->nama_bmt ?? '-';
    }

    public static function no_rekening($id)
    {
        $a = Rekening::where('id_rekening', $id)->first();
        return  $a->no_rekening ?? '-';
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
        $sub = 'pengajuan';
        return view(
            'pengajuan.internalpc_pc',
            compact('title', 'filter_pc_umum', 'filter_internal', 'sub')
        );
    }


    public function laporan_internal()
    {
        $title = "DATA LAPORAN";
        $filter_pc_umum = '';
        $filter_internal = '';
        $sub = 'laporan';
        return view(
            'laporan_internal_umum.laporan_internalpc_pc',
            compact('title', 'filter_pc_umum', 'filter_internal', 'sub')
        );
    }

    public function lap_internalpc_pc()
    {
        $title = "DATA LAPORAN";
        $filter_pc_umum = '';
        $filter_internal = '';
        $sub = 'laporan';
        return view(
            'pengajuan.internalpc_pc',
            compact('title', 'filter_pc_umum', 'filter_internal', 'sub')
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


    public function filter_pc_umum($c_filter_daterange2, $c_filter_status, $c_filter_kategori, $c_filter_pilar, $sub, Request $request)
    {

        $c_filter_daterange2 = $c_filter_daterange2;

        $filter_pc_umum = 'on';
        $filter_internal = '';
        if ($sub == 'pengajuan') {
            $title = "DATA PENGAJUAN";
        } else {
            $title = "DATA LAPORAN";
        }

        $c_filter_status = $c_filter_status;
        $c_filter_kategori = $c_filter_kategori;
        $c_filter_pilar = $c_filter_pilar;
        $sub = $sub;
        return view(
            'pengajuan.internalpc_pc',
            compact('title', 'c_filter_daterange2', 'c_filter_status', 'c_filter_pilar', 'c_filter_kategori', 'filter_pc_umum', 'filter_internal', 'sub')
        );


        return redirect()->back()->withInput(['tab' => 'ranting']);
    }

    public function laporan_filter_pc_umum($c_filter_daterange2, $c_filter_status, $c_filter_kategori, $c_filter_pilar, $sub, Request $request)
    {

        $c_filter_daterange2 = $c_filter_daterange2;

        $filter_pc_umum = 'on';
        $filter_internal = '';
        if ($sub == 'pengajuan') {
            $title = "DATA PENGAJUAN";
        } else {
            $title = "DATA LAPORAN";
        }

        $c_filter_status = $c_filter_status;
        $c_filter_kategori = $c_filter_kategori;
        $c_filter_pilar = $c_filter_pilar;
        $sub = $sub;
        return view(
            'laporan_internal_umum.laporan_internalpc_pc',
            compact('title', 'c_filter_daterange2', 'c_filter_status', 'c_filter_pilar', 'c_filter_kategori', 'filter_pc_umum', 'filter_internal', 'sub')
        );


        return redirect()->back()->withInput(['tab' => 'ranting']);
    }


    public function filter_pc_umum_post(Request $request)
    {

        $filter_daterange2 = $request->filter_daterange2;
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

        $sub = $request->sub;

        // dd($request->bulan_lv . $request->tahun_lv . $request->status_lv . $request->pilar_lv);
        // return redirect()->route('filter_rantings', ['c_filter_bulan' => $request->bulan_lv, 'c_filter_tahun' => $request->tahun_lv, 'c_filter_status' => $request->status_lv, 'c_filter_pilar' => $request->pilar_lv]);
        return Redirect::to($role . '/filter_pc_umum/' . $filter_daterange2 . '/' . $status_lv . '/' .  $kategori_lv . '/' . $pilar_lv . '/' . $sub);
        // return redirect()->route('filter_rantings');
    }

    public function laporan_filter_pc_umum_post(Request $request)
    {

        $filter_daterange2 = $request->filter_daterange2;
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

        $sub = $request->sub;

        // dd($request->bulan_lv . $request->tahun_lv . $request->status_lv . $request->pilar_lv);
        // return redirect()->route('filter_rantings', ['c_filter_bulan' => $request->bulan_lv, 'c_filter_tahun' => $request->tahun_lv, 'c_filter_status' => $request->status_lv, 'c_filter_pilar' => $request->pilar_lv]);
        return Redirect::to($role . '/laporan_filter_pc_umum/' . $filter_daterange2 . '/' . $status_lv . '/' .  $kategori_lv . '/' . $pilar_lv . '/' . $sub);
        // return redirect()->route('filter_rantings');
    }

    public function filter_internal_pc($c_filter_daterange, $c_filter_status, $c_filter_tujuan, $sub, Request $request)
    {

        $filter_pc_umum = '';
        $filter_internal = 'on';
        if ($sub == 'pengajuan') {
            $title = "DATA PENGAJUAN";
        } else {
            $title = "DATA LAPORAN";
        }

        $c_filter_daterange = $c_filter_daterange;
        $c_filter_status = $c_filter_status;
        $c_filter_tujuan = $c_filter_tujuan;
        $sub = $sub;
        return view(
            'pengajuan.internalpc_pc',
            compact('title', 'c_filter_daterange', 'c_filter_status', 'c_filter_tujuan', 'filter_pc_umum', 'filter_internal', 'sub')
        );


        return redirect()->back()->withInput(['tab' => 'ranting']);
    }

    public function laporan_filter_internal_pc($c_filter_daterange, $c_filter_status, $c_filter_tujuan, $sub, Request $request)
    {

        $filter_pc_umum = '';
        $filter_internal = 'on';
        if ($sub == 'pengajuan') {
            $title = "DATA PENGAJUAN";
        } else {
            $title = "DATA LAPORAN";
        }

        $c_filter_daterange = $c_filter_daterange;
        $c_filter_status = $c_filter_status;
        $c_filter_tujuan = $c_filter_tujuan;
        $sub = $sub;
        return view(
            'laporan_internal_umum.laporan_internalpc_pc',
            compact('title', 'c_filter_daterange', 'c_filter_status', 'c_filter_tujuan', 'filter_pc_umum', 'filter_internal', 'sub')
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

        $sub = $request->sub;

        // dd($request->bulan_lv . $request->tahun_lv . $request->status_lv . $request->pilar_lv);
        // return redirect()->route('filter_rantings', ['c_filter_bulan' => $request->bulan_lv, 'c_filter_tahun' => $request->tahun_lv, 'c_filter_status' => $request->status_lv, 'c_filter_pilar' => $request->pilar_lv]);
        return Redirect::to($role . '/filter_internal_pc/' . $request->filter_daterange . '/'  . $status_lv . '/' .  $tujuan_lv . '/' .  $sub);
        // return redirect()->route('filter_rantings');
    }


    public function laporan_filter_internal_pc_post(Request $request)
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

        $sub = $request->sub;

        // dd($request->bulan_lv . $request->tahun_lv . $request->status_lv . $request->pilar_lv);
        // return redirect()->route('filter_rantings', ['c_filter_bulan' => $request->bulan_lv, 'c_filter_tahun' => $request->tahun_lv, 'c_filter_status' => $request->status_lv, 'c_filter_pilar' => $request->pilar_lv]);
        return Redirect::to($role . '/laporan_filter_internal_pc/' . $request->filter_daterange . '/'  . $status_lv . '/' .  $tujuan_lv . '/' .  $sub);
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

    public $etasyaruf;

    public function laporan_upzis_ranting()
    {

        $status_lpj = 'semua';
        $status_lpj2 = 'semua';
        $title = "DATA LAPORAN";
        $sub = 'laporan';
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

        $datas_penerima_manfaat = PengajuanDetail::leftjoin($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->leftjoin($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->leftjoin($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',
                $this->etasyaruf . '.pengajuan_penerima_lpj.*',
                $this->etasyaruf . '.asnaf.*',

            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan_detail.created_at', '>=', $start_date)
                        ->whereDate('pengajuan_detail.created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan_detail.created_at', $start_date);
                    })->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', '>=', $start_date)
                        ->whereDate('pengajuan.tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', $start_date);
                    })->latest('tgl_terbit_rekomendasi');
            });


        $penerima_manfaat = $datas_penerima_manfaat->get();

        $data = Pengajuan::orderBy('tgl_terbit_rekomendasi', 'DESC')
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
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date)

            ->latest($etasyaruf . '.pengajuan.tgl_terbit_rekomendasi')
            ->get();
        $total_upzis = $data->count();

        $total_pengajuan = $data->where('status_pengajuan', '=', 'Diajukan')->count();
        // dd($data);

        $data_lap_upzis = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',

            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('created_at', $start_date);
                    })
                    ->latest('created_at');
            })
            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $program = $data_lap_upzis->get()->groupBy('pilar');




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


        $datas_penerima_manfaat_ranting = PengajuanDetail::leftjoin($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->leftjoin($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->leftjoin($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',
                $this->etasyaruf . '.pengajuan_penerima_lpj.*',
                $this->etasyaruf . '.asnaf.*',
                $this->etasyaruf . '.pengajuan.id_ranting',

            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });


        $penerima_manfaat_ranting = $datas_penerima_manfaat_ranting->get();


        $data2 = Pengajuan::orderBy('tgl_terbit_rekomendasi', 'DESC')
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
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2)
            ->latest($etasyaruf . '.pengajuan.tgl_terbit_rekomendasi')
            ->get();


        $data_lap_ranting = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.id_ranting',

            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $program2 = $data_lap_ranting->get()->groupBy('pilar');


        return view(
            'laporan_pengajuan.laporan_upzis_ranting',
            compact(
                'penerima_manfaat_ranting',
                'program',
                'program2',
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
                'sub',
                'penerima_manfaat',
                'status_lpj',
                'status_lpj2',
            )
        );
    }

    public function laporan_upzis_ranting_keseluruhan()
    {

        $status_lpj = 'semua';
        $status_lpj2 = 'semua';
        $title = "DATA LAPORAN";
        $sub = 'laporan';
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

        $id_upzis = NULL;
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }

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
        $data2 = Pengajuan::orderBy('tgl_terbit_rekomendasi', 'DESC')
            // ->where('tingkat', 'Ranting NU')
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
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2)
            ->latest($etasyaruf . '.pengajuan.tgl_terbit_rekomendasi')
            ->get();


        $data_lap_ranting = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.id_ranting',

            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            // ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $program2 = $data_lap_ranting->get()->groupBy('pilar');

        $datas_penerima_manfaat_keseluruhan = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftjoin('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftjoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.tgl_terbit_rekomendasi',
                'pengajuan_penerima_lpj.*',
                'asnaf.*',
                'pengajuan.id_ranting',

            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });


        $penerima_manfaat_keseluruhan = $datas_penerima_manfaat_keseluruhan->get();

        return view(
            'laporan_pengajuan.laporan_upzis_ranting_keseluruhan',
            compact(
                'penerima_manfaat_keseluruhan',
                'program2',
                'title',
                'daftar_upzis',
                'daftar_ranting2',
                'tab_upzis',
                'tab_ranting',
                // TabUpzis

                'id_upzis',
                'status',

                // TabRanting
                'data2',
                'id_upzis2',
                'id_ranting2',
                'status2',
                'start_date2',
                'end_date2',
                'filter_daterange2',
                'sub',
                'status_lpj',
                'status_lpj2',
            )
        );
    }

    public function upzis_ranting2()
    {
        $title = "DATA PENGAJUAN";
        $status_lpj = 'semua';
        $status_lpj2 = 'semua';
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();

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
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)

            ->latest($etasyaruf . '.pengajuan.created_at')
            ->get();
        $total_upzis = $data->count();

        $total_pengajuan = $data->where('status_pengajuan', '=', 'Diajukan')->count();
        // dd($data);

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
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
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
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2)
            ->latest($etasyaruf . '.pengajuan.created_at')
            ->get();
        $sub = 'pengajuan';
        return view(
            'pengajuan.upzis-ranting',
            compact(
                'status_lpj',
                'status_lpj2',
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
                'sub'
            )
        );
    }

    public function lap_upzis_ranting2()
    {
        $title = "DATA LAPORAN";

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
        $data = Pengajuan::orderBy('tgl_terbit_rekomendasi', 'DESC')
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
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date)

            ->latest($etasyaruf . '.pengajuan.tgl_terbit_rekomendasi')
            ->get();
        $total_upzis = $data->count();

        $total_pengajuan = $data->where('status_pengajuan', '=', 'Diajukan')->count();
        // dd($data);

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
        $data2 = Pengajuan::orderBy('tgl_terbit_rekomendasi', 'DESC')
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
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2)
            ->latest($etasyaruf . '.pengajuan.tgl_terbit_rekomendasi')
            ->get();

        $sub = 'laporan';
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
                'sub',
            )
        );
    }

    public function pdf_umum_upzis_realisasi_pengajuan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        $sub = $sub;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        // Memecah string tanggal menjadi dua bagian berdasarkan tanda "-"
        $date_parts = explode(" - ", $filter_daterange);

        // Menggunakan Carbon untuk mengonversi format tanggal
        $start_date = Carbon::parse($date_parts[0])->format('d-m-Y');
        $end_date = Carbon::parse($date_parts[1])->format('d-m-Y');

        // Menggabungkan kembali hasilnya
        $new_date_range = $start_date . " - " . $end_date;

        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }
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
        $id_upzis = $id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $status = $status;
        // daterange
        $date_range = $filter_daterange;
        $date_parts = explode(" - ", $date_range);
        $start_date = $date_parts[0];
        $end_date = $date_parts[1];
        $filter_daterange = $start_date . ' - ' . $end_date;

        $datas = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('created_at', $start_date);
                    })
                    ->latest('created_at');
            })
            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $data = $datas->get();




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

        $pdf->SetMargins(3 + 0, 3 + 2, 3 + 2);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();
        $pdf->AddPage('L');

        $tings = 'upzis';


        // Load and render the first view
        $html1 = view('print.pdf_umum_upzis_realisasi_pengajuan', compact(
            'data',
            'id_upzis',
            'filter_daterange',
            'sub',
            'tings',
            'datas'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');


        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = 'DATA REALISASI PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR PERIODE ' . $new_date_range . '.pdf';
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
    }


    public function pdf_umum_ranting_realisasi_pengajuan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        $sub = $sub;
        // Memecah string tanggal menjadi dua bagian berdasarkan tanda "-"
        $date_parts = explode(" - ", $filter_daterange2);

        // Menggunakan Carbon untuk mengonversi format tanggal
        $start_date = Carbon::parse($date_parts[0])->format('d-m-Y');
        $end_date = Carbon::parse($date_parts[1])->format('d-m-Y');

        // Menggabungkan kembali hasilnya
        $new_date_range = $start_date . " - " . $end_date;

        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }
        $title = "DATA PENGAJUAN";

        // tabbed
        $tab_upzis = 'show active';
        $tab_ranting = '';

        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        // TabRanting
        // request
        $id_upzis2 = $id_upzis2;
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $id_ranting2 = $id_ranting2;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $status2 = $status2;
        // daterange
        $date_range2 = $filter_daterange2;
        $date_parts2 = explode(" - ", $date_range2);
        $start_date2 = $date_parts2[0];
        $end_date2 = $date_parts2[1];
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;

        $datas = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Ranting NU')
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $data = $datas->get();




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

        $pdf->SetMargins(3 + 0, 3 + 2, 3 + 2);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();
        $pdf->AddPage('L');

        $tings = 'ranting';
        // Load and render the first view
        $html1 = view('print.pdf_umum_upzis_realisasi_pengajuan', compact(
            'data',
            'id_upzis',
            'id_upzis2',
            'id_ranting2',
            'filter_daterange',
            'sub',
            'tings',
            'datas'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');


        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = 'DATA REALISASI PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR PERIODE ' . $new_date_range . '.pdf';
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
    }


    public function pengajuan_pdf_umum_upzis_realisasi_pengajuan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        $status_lpj = $status_lpj;
        $status_lpj2 = $status_lpj2;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        $sub = $sub;
        // Memecah string tanggal menjadi dua bagian berdasarkan tanda "-"
        $date_parts = explode(" - ", $filter_daterange);

        // Menggunakan Carbon untuk mengonversi format tanggal
        $start_date = Carbon::parse($date_parts[0])->format('d-m-Y');
        $end_date = Carbon::parse($date_parts[1])->format('d-m-Y');

        // Menggabungkan kembali hasilnya
        $new_date_range = $start_date . " - " . $end_date;

        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }
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
        $id_upzis = $id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $status = $status;
        // daterange
        $date_range = $filter_daterange;
        $date_parts = explode(" - ", $date_range);
        $start_date = $date_parts[0];
        $end_date = $date_parts[1];
        $filter_daterange = $start_date . ' - ' . $end_date;

        $datas = Pengajuan::orderBy('pengajuan.created_at', 'DESC')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Ditolak', function ($query) use ($status) {
                return $query->where('status_rekomendasi', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan.created_at', '>=', $start_date)->whereDate('pengajuan.created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan.created_at', $start_date);
                    })
                    ->latest('pengajuan.created_at');
            })
            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $data = $datas->get();




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

        $pdf->SetMargins(3 + 0, 3 + 2, 3 + 2);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();
        $pdf->AddPage('L');

        $tings = 'upzis';
        // Load and render the first view
        $html1 = view('print.pdf_umum_upzis_realisasi_pengajuan', compact(
            'data',
            'id_upzis',
            'filter_daterange',
            'sub',
            'datas',
            'tings'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');


        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = 'DATA REALISASI PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR PERIODE ' . $new_date_range . '.pdf';
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
    }


    public function pengajuan_pdf_umum_ranting_realisasi_pengajuan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        $status_lpj = $status_lpj;
        $status_lpj2 = $status_lpj2;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        $sub = $sub;
        // Memecah string tanggal menjadi dua bagian berdasarkan tanda "-"
        $date_parts = explode(" - ", $filter_daterange2);

        // Menggunakan Carbon untuk mengonversi format tanggal
        $start_date = Carbon::parse($date_parts[0])->format('d-m-Y');
        $end_date = Carbon::parse($date_parts[1])->format('d-m-Y');

        // Menggabungkan kembali hasilnya
        $new_date_range = $start_date . " - " . $end_date;

        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }
        $title = "DATA PENGAJUAN";

        // tabbed
        $tab_upzis = 'show active';
        $tab_ranting = '';

        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        // TabRanting
        // request
        $id_upzis2 = $id_upzis2;
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $id_ranting2 = $id_ranting2;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $status2 = $status2;
        // daterange
        $date_range2 = $filter_daterange2;
        $date_parts2 = explode(" - ", $date_range2);
        $start_date2 = $date_parts2[0];
        $end_date2 = $date_parts2[1];
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;

        $datas = Pengajuan::orderBy('pengajuan.created_at', 'DESC')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Ditolak', function ($query) use ($status2) {
                return $query->where('status_rekomendasi', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan.created_at', '>=', $start_date2)->whereDate('pengajuan.created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan.created_at', $start_date2);
                    })
                    ->latest('pengajuan.created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $data = $datas->get();




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

        $pdf->SetMargins(3 + 0, 3 + 2, 3 + 2);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();
        $pdf->AddPage('L');

        $tings = 'ranting';
        // Load and render the first view
        $html1 = view('print.pdf_umum_upzis_realisasi_pengajuan', compact(
            'data',
            'id_upzis',
            'id_upzis2',
            'id_ranting2',
            'filter_daterange',
            'sub',
            'datas',
            'tings'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');


        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = 'DATA REALISASI PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR PERIODE ' . $new_date_range . '.pdf';
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
    }

    public function pdf_keseluruhan_realisasi_pengajuan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {

        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        $sub = $sub;
        // Memecah string tanggal menjadi dua bagian berdasarkan tanda "-"
        $date_parts = explode(" - ", $filter_daterange2);

        // Menggunakan Carbon untuk mengonversi format tanggal
        $start_date = Carbon::parse($date_parts[0])->format('d-m-Y');
        $end_date = Carbon::parse($date_parts[1])->format('d-m-Y');

        // Menggabungkan kembali hasilnya
        $new_date_range = $start_date . " - " . $end_date;

        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }
        $title = "DATA PENGAJUAN";

        // tabbed
        $tab_upzis = 'show active';
        $tab_ranting = '';

        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        //////////////// TabUpzis
        $id_upzis2 = $id_upzis2;
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $id_ranting2 = $id_ranting2;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $status2 = $status2;
        // daterange
        $date_range2 = $filter_daterange2;
        $date_parts2 = explode(" - ", $date_range2);
        $start_date2 = $date_parts2[0];
        $end_date2 = $date_parts2[1];
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;

        $datas = Pengajuan::orderBy('created_at', 'DESC')
            // filter status
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });
        $data = $datas->get();


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

        $pdf->SetMargins(3 + 0, 3 + 2, 3 + 2);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();
        $pdf->AddPage('L');

        $tings = 'keseluruhan';
        // Load and render the first view
        $html1 = view('print.pdf_umum_upzis_realisasi_pengajuan', compact(
            'data',
            'id_upzis',
            'id_upzis2',
            'filter_daterange',
            'sub',
            'tings',
            'datas'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $nama_upzis = strtoupper(PengajuanController::get_nama_upzis($id_upzis2));
        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = ' DATA REALISASI PENTASYARUFAN BY PENGAJUAN PER WILAYAH KECAMATAN ' . $nama_upzis . ' BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR PERIODE ' . $new_date_range . '.pdf';
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
    }

    public function pdf_umum_upzis($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        $sub = $sub;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        // Memecah string tanggal menjadi dua bagian berdasarkan tanda "-"
        $date_parts = explode(" - ", $filter_daterange2);

        // Menggunakan Carbon untuk mengonversi format tanggal
        $start_date = Carbon::parse($date_parts[0])->format('d-m-Y');
        $end_date = Carbon::parse($date_parts[1])->format('d-m-Y');

        // Menggabungkan kembali hasilnya
        $new_date_range = $start_date . " - " . $end_date;

        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }
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
        $id_upzis = $id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $status = $status;
        // daterange
        $date_range = $filter_daterange;
        $date_parts = explode(" - ", $date_range);
        $start_date = $date_parts[0];
        $end_date = $date_parts[1];
        $filter_daterange = $start_date . ' - ' . $end_date;

        $datas = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',

            )
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan_detail.created_at', '>=', $start_date)
                        ->whereDate('pengajuan_detail.created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan_detail.created_at', $start_date);
                    })->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', '>=', $start_date)
                        ->whereDate('pengajuan.tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', $start_date);
                    })->latest('tgl_terbit_rekomendasi');
            });


        $program = $datas->get()->groupBy('pilar');
        $sum_pencairan = $datas->sum('nominal_pencairan');
        $sum_penerima = $datas->sum('jumlah_penerima');

        //nominal pencairan
        $hukum = $datas->clone()->where('pilar', 'Hukum dan Keadilan')->sum('nominal_pencairan') ?? 0;
        $ekonomi = $datas->clone()->where('pilar', 'Pilar Ekonomi')->sum('nominal_pencairan') ?? 0;
        $kesehatan = $datas->clone()->where('pilar', 'Pilar Kesehatan')->sum('nominal_pencairan') ?? 0;
        $kelembagaan = $datas->clone()->where('pilar', 'Pilar Penguatan Kelembagaan')->sum('nominal_pencairan') ?? 0;
        $dakwah = $datas->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') ?? 0;
        $kemanusiaan = $datas->clone()->where('pilar', 'Pilar Kemanusiaan')->sum('nominal_pencairan') ?? 0;
        $lingkungan = $datas->clone()->where('pilar', 'Pilar Lingkungan')->sum('nominal_pencairan') ?? 0;
        $pendidikan = $datas->clone()->where('pilar', 'Pilar Pendidikan')->sum('nominal_pencairan') ?? 0;
        $total_jumlah = $hukum + $ekonomi + $kesehatan + $kelembagaan + $dakwah + $kemanusiaan + $lingkungan + $pendidikan;

        $program_hukum = $datas->clone()->where('pilar', 'Hukum dan Keadilan')->count() ?? 0;
        $program_ekonomi = $datas->clone()->where('pilar', 'Pilar Ekonomi')->count() ?? 0;
        $program_kesehatan = $datas->clone()->where('pilar', 'Pilar Kesehatan')->count() ?? 0;
        $program_kelembagaan = $datas->clone()->where('pilar', 'Pilar Penguatan Kelembagaan')->count() ?? 0;
        $program_dakwah = $datas->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() ?? 0;
        $program_kemanusiaan = $datas->clone()->where('pilar', 'Pilar Kemanusiaan')->count() ?? 0;
        $program_lingkungan = $datas->clone()->where('pilar', 'Pilar Lingkungan')->count() ?? 0;
        $program_pendidikan = $datas->clone()->where('pilar', 'Pilar Pendidikan')->count() ?? 0;
        $program_total_jumlah = $program_hukum + $program_ekonomi + $program_kesehatan + $program_kelembagaan + $program_dakwah + $program_kemanusiaan + $program_lingkungan + $program_pendidikan;


        //copy_persentase pencairan
        $cp_hukum = ($total_jumlah != 0) ? ($hukum / $total_jumlah) * 100 : 0;
        $cp_ekonomi = ($total_jumlah != 0) ? ($ekonomi / $total_jumlah) * 100 : 0;
        $cp_kesehatan = ($total_jumlah != 0) ? ($kesehatan / $total_jumlah) * 100 : 0;
        $cp_kelembagaan = ($total_jumlah != 0) ? ($kelembagaan / $total_jumlah) * 100 : 0;
        $cp_dakwah = ($total_jumlah != 0) ? ($dakwah / $total_jumlah) * 100 : 0;
        $cp_kemanusiaan = ($total_jumlah != 0) ? ($kemanusiaan / $total_jumlah) * 100 : 0;
        $cp_lingkungan = ($total_jumlah != 0) ? ($lingkungan / $total_jumlah) * 100 : 0;
        $cp_pendidikan = ($total_jumlah != 0) ? ($pendidikan / $total_jumlah) * 100 : 0;

        //persentase pencairan
        $p_hukum = number_format($cp_hukum, 2) . '%';
        $p_ekonomi = number_format($cp_ekonomi, 2) . '%';
        $p_kesehatan = number_format($cp_kesehatan, 2) . '%';
        $p_kelembagaan = number_format($cp_kelembagaan, 2) . '%';
        $p_dakwah = number_format($cp_dakwah, 2) . '%';
        $p_kemanusiaan = number_format($cp_kemanusiaan, 2) . '%';
        $p_lingkungan = number_format($cp_lingkungan, 2) . '%';
        $p_pendidikan = number_format($cp_pendidikan, 2) . '%';

        // Hitung total persentase
        $total_persentase = intval($cp_hukum + $cp_ekonomi + $cp_kesehatan + $cp_kelembagaan + $cp_dakwah + $cp_kemanusiaan + $cp_lingkungan + $cp_pendidikan);

        //penerima manfaat
        $pm_hukum = $datas->clone()->where('pilar', 'Hukum dan Keadilan')->sum('jumlah_penerima') ?? 0;
        $pm_ekonomi = $datas->clone()->where('pilar', 'Pilar Ekonomi')->sum('jumlah_penerima') ?? 0;
        $pm_kesehatan = $datas->clone()->where('pilar', 'Pilar Kesehatan')->sum('jumlah_penerima') ?? 0;
        $pm_kelembagaan = $datas->clone()->where('pilar', 'Pilar Penguatan Kelembagaan')->sum('jumlah_penerima') ?? 0;
        $pm_dakwah = $datas->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') ?? 0;
        $pm_kemanusiaan = $datas->clone()->where('pilar', 'Pilar Kemanusiaan')->sum('jumlah_penerima') ?? 0;
        $pm_lingkungan = $datas->clone()->where('pilar', 'Pilar Lingkungan')->sum('jumlah_penerima') ?? 0;
        $pm_pendidikan = $datas->clone()->where('pilar', 'Pilar Pendidikan')->sum('jumlah_penerima') ?? 0;
        $pm_total_jumlah = $pm_hukum + $pm_ekonomi + $pm_kesehatan + $pm_kelembagaan + $pm_dakwah + $pm_kemanusiaan + $pm_lingkungan + $pm_pendidikan;


        //copy_persentase penerima manfaat
        $cp_pm_hukum = ($pm_total_jumlah != 0) ? ($pm_hukum / $pm_total_jumlah) * 100 : 0;
        $cp_pm_ekonomi = ($pm_total_jumlah != 0) ? ($pm_ekonomi / $pm_total_jumlah) * 100 : 0;
        $cp_pm_kesehatan = ($pm_total_jumlah != 0) ? ($pm_kesehatan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_kelembagaan = ($pm_total_jumlah != 0) ? ($pm_kelembagaan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_dakwah = ($pm_total_jumlah != 0) ? ($pm_dakwah / $pm_total_jumlah) * 100 : 0;
        $cp_pm_kemanusiaan = ($pm_total_jumlah != 0) ? ($pm_kemanusiaan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_lingkungan = ($pm_total_jumlah != 0) ? ($pm_lingkungan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_pendidikan = ($pm_total_jumlah != 0) ? ($pm_pendidikan / $pm_total_jumlah) * 100 : 0;

        //persentase penerima manfaat
        $p_pm_hukum = number_format($cp_pm_hukum, 2) . '%';
        $p_pm_ekonomi = number_format($cp_pm_ekonomi, 2) . '%';
        $p_pm_kesehatan = number_format($cp_pm_kesehatan, 2) . '%';
        $p_pm_kelembagaan = number_format($cp_pm_kelembagaan, 2) . '%';
        $p_pm_dakwah = number_format($cp_pm_dakwah, 2) . '%';
        $p_pm_kemanusiaan = number_format($cp_pm_kemanusiaan, 2) . '%';
        $p_pm_lingkungan = number_format($cp_pm_lingkungan, 2) . '%';
        $p_pm_pendidikan = number_format($cp_pm_pendidikan, 2) . '%';

        // Hitung total persentase
        $total_persentase_pm = intval($cp_pm_hukum + $cp_pm_ekonomi + $cp_pm_kesehatan + $cp_pm_kelembagaan + $cp_pm_dakwah + $cp_pm_kemanusiaan + $cp_pm_lingkungan + $cp_pm_pendidikan);



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

        $pdf->SetMargins(8 + 0, 8 + 5, 8 + 5);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();



        $tings = 'upzis';
        if ($sub == 'laporan') {
            $pdf->AddPage('P');
            // Load and render the first view
            $html = view('print.serah_terima_laporan', compact(
                'datas',
                'program',
                'id_upzis',
                'filter_daterange',
                'sum_pencairan',
                'sum_penerima',
                'hukum',
                'ekonomi',
                'kesehatan',
                'kelembagaan',
                'dakwah',
                'kemanusiaan',
                'lingkungan',
                'pendidikan',
                'total_jumlah',
                'tings',
                'p_hukum',
                'p_ekonomi',
                'p_kesehatan',
                'p_kelembagaan',
                'p_dakwah',
                'p_kemanusiaan',
                'p_lingkungan',
                'p_pendidikan',
                'total_persentase',
                'pm_hukum',
                'pm_ekonomi',
                'pm_kesehatan',
                'pm_kelembagaan',
                'pm_dakwah',
                'pm_kemanusiaan',
                'pm_lingkungan',
                'pm_pendidikan',
                'pm_total_jumlah',
                'p_pm_hukum',
                'p_pm_ekonomi',
                'p_pm_kesehatan',
                'p_pm_kelembagaan',
                'p_pm_dakwah',
                'p_pm_kemanusiaan',
                'p_pm_lingkungan',
                'p_pm_pendidikan',
                'total_persentase_pm',
            ))->render();

            // Output the HTML content to the PDF
            $pdf->writeHTML($html, true, false, true, false, '');
        }

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

        $pdf->SetMargins(3 + 0, 3 + 2, 3 + 2);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();
        $pdf->AddPage('L');


        // Load and render the first view
        $html1 = view('print.pdf_umum_upzis', compact(
            'program',
            'id_upzis',
            'filter_daterange',
            'sum_pencairan',
            'sum_penerima',
            'sub',
            'tings',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');


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

        $pdf->SetMargins(8 + 0, 8 + 5, 8 + 5);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();



        // if ($sub == 'laporan') {
        //     $pdf->AddPage('P');
        //     // Load and render the first view
        //     $html2 = view('print.laporan_berdasarkan_grafik', compact(
        //         'program',
        //         'id_upzis',
        //         'filter_daterange',
        //         'sum_pencairan',
        //         'sum_penerima',
        //         'hukum',
        //         'ekonomi',
        //         'kesehatan',
        //         'kelembagaan',
        //         'dakwah',
        //         'kemanusiaan',
        //         'lingkungan',
        //         'pendidikan',
        //         'total_jumlah',
        //         'tings',
        //         'p_hukum',
        //         'p_ekonomi',
        //         'p_kesehatan',
        //         'p_kelembagaan',
        //         'p_dakwah',
        //         'p_kemanusiaan',
        //         'p_lingkungan',
        //         'p_pendidikan',
        //         'total_persentase',
        //         'pm_hukum',
        //         'pm_ekonomi',
        //         'pm_kesehatan',
        //         'pm_kelembagaan',
        //         'pm_dakwah',
        //         'pm_kemanusiaan',
        //         'pm_lingkungan',
        //         'pm_pendidikan',
        //         'pm_total_jumlah',
        //         'p_pm_hukum',
        //         'p_pm_ekonomi',
        //         'p_pm_kesehatan',
        //         'p_pm_kelembagaan',
        //         'p_pm_dakwah',
        //         'p_pm_kemanusiaan',
        //         'p_pm_lingkungan',
        //         'p_pm_pendidikan',
        //         'total_persentase_pm',
        //         'program_hukum',
        //         'program_ekonomi',
        //         'program_kesehatan',
        //         'program_kelembagaan',
        //         'program_dakwah',
        //         'program_kemanusiaan',
        //         'program_lingkungan',
        //         'program_pendidikan',
        //         'program_total_jumlah',
        //     ))->render();

        //     // Output the HTML content to the PDF
        //     $pdf->writeHTML($html2, true, false, true, false, '');
        // }

        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = 'DATA REALISASI PENTASYARUFAN TINGKAT UPZIS BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR PERIODE ' . $new_date_range . '.pdf';
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
    }

    public function pdf_umum_ranting($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        $sub = $sub;
        // Memecah string tanggal menjadi dua bagian berdasarkan tanda "-"
        $date_parts = explode(" - ", $filter_daterange2);

        // Menggunakan Carbon untuk mengonversi format tanggal
        $start_date = Carbon::parse($date_parts[0])->format('d-m-Y');
        $end_date = Carbon::parse($date_parts[1])->format('d-m-Y');

        // Menggabungkan kembali hasilnya
        $new_date_range = $start_date . " - " . $end_date;

        // dd($request->all());
        $title = "DATA PENGAJUAN";
        // tabbed
        $tab_upzis = NULL;
        $tab_ranting = 'show active';

        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        //////////////// TabRanting
        // request
        $id_upzis2 = $id_upzis2;

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $id_ranting2 = $id_ranting2;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $status2 = $status2;
        // daterange
        $date_range2 = $filter_daterange2;
        $date_parts2 = explode(" - ", $date_range2);
        $start_date2 = $date_parts2[0];
        $end_date2 = $date_parts2[1];
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;
        // dd($filter_daterange2);

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        // dd($id_upzis2);
        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }

        $datas2 = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.id_ranting',
            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })


            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan_detail.created_at', '>=', $start_date2)
                        ->whereDate('pengajuan_detail.created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan_detail.created_at', $start_date2);
                    })->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', '>=', $start_date2)
                        ->whereDate('pengajuan.tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', $start_date2);
                    })->latest('tgl_terbit_rekomendasi');
            });


        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas2->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $program = $datas2->get()->groupBy('pilar');

        $sum_pencairan = $datas2->sum('nominal_pencairan');
        $sum_penerima = $datas2->sum('jumlah_penerima');

        //nominal pencairan
        $hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->sum('nominal_pencairan') ?? 0;
        $ekonomi = $datas2->clone()->where('pilar', 'Pilar Ekonomi')->sum('nominal_pencairan') ?? 0;
        $kesehatan = $datas2->clone()->where('pilar', 'Pilar Kesehatan')->sum('nominal_pencairan') ?? 0;
        $kelembagaan = $datas2->clone()->where('pilar', 'Pilar Penguatan Kelembagaan')->sum('nominal_pencairan') ?? 0;
        $dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') ?? 0;
        $kemanusiaan = $datas2->clone()->where('pilar', 'Pilar Kemanusiaan')->sum('nominal_pencairan') ?? 0;
        $lingkungan = $datas2->clone()->where('pilar', 'Pilar Lingkungan')->sum('nominal_pencairan') ?? 0;
        $pendidikan = $datas2->clone()->where('pilar', 'Pilar Pendidikan')->sum('nominal_pencairan') ?? 0;
        $total_jumlah = $hukum + $ekonomi + $kesehatan + $kelembagaan + $dakwah + $kemanusiaan + $lingkungan + $pendidikan;

        //copy_persentase pencairan
        $cp_hukum = ($total_jumlah != 0) ? ($hukum / $total_jumlah) * 100 : 0;
        $cp_ekonomi = ($total_jumlah != 0) ? ($ekonomi / $total_jumlah) * 100 : 0;
        $cp_kesehatan = ($total_jumlah != 0) ? ($kesehatan / $total_jumlah) * 100 : 0;
        $cp_kelembagaan = ($total_jumlah != 0) ? ($kelembagaan / $total_jumlah) * 100 : 0;
        $cp_dakwah = ($total_jumlah != 0) ? ($dakwah / $total_jumlah) * 100 : 0;
        $cp_kemanusiaan = ($total_jumlah != 0) ? ($kemanusiaan / $total_jumlah) * 100 : 0;
        $cp_lingkungan = ($total_jumlah != 0) ? ($lingkungan / $total_jumlah) * 100 : 0;
        $cp_pendidikan = ($total_jumlah != 0) ? ($pendidikan / $total_jumlah) * 100 : 0;

        //persentase pencairan
        $p_hukum = number_format($cp_hukum, 2) . '%';
        $p_ekonomi = number_format($cp_ekonomi, 2) . '%';
        $p_kesehatan = number_format($cp_kesehatan, 2) . '%';
        $p_kelembagaan = number_format($cp_kelembagaan, 2) . '%';
        $p_dakwah = number_format($cp_dakwah, 2) . '%';
        $p_kemanusiaan = number_format($cp_kemanusiaan, 2) . '%';
        $p_lingkungan = number_format($cp_lingkungan, 2) . '%';
        $p_pendidikan = number_format($cp_pendidikan, 2) . '%';

        // Hitung total persentase
        $total_persentase = intval($cp_hukum + $cp_ekonomi + $cp_kesehatan + $cp_kelembagaan + $cp_dakwah + $cp_kemanusiaan + $cp_lingkungan + $cp_pendidikan);

        //penerima manfaat
        $pm_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->sum('jumlah_penerima') ?? 0;
        $pm_ekonomi = $datas2->clone()->where('pilar', 'Pilar Ekonomi')->sum('jumlah_penerima') ?? 0;
        $pm_kesehatan = $datas2->clone()->where('pilar', 'Pilar Kesehatan')->sum('jumlah_penerima') ?? 0;
        $pm_kelembagaan = $datas2->clone()->where('pilar', 'Pilar Penguatan Kelembagaan')->sum('jumlah_penerima') ?? 0;
        $pm_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') ?? 0;
        $pm_kemanusiaan = $datas2->clone()->where('pilar', 'Pilar Kemanusiaan')->sum('jumlah_penerima') ?? 0;
        $pm_lingkungan = $datas2->clone()->where('pilar', 'Pilar Lingkungan')->sum('jumlah_penerima') ?? 0;
        $pm_pendidikan = $datas2->clone()->where('pilar', 'Pilar Pendidikan')->sum('jumlah_penerima') ?? 0;
        $pm_total_jumlah = $pm_hukum + $pm_ekonomi + $pm_kesehatan + $pm_kelembagaan + $pm_dakwah + $pm_kemanusiaan + $pm_lingkungan + $pm_pendidikan;

        $program_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->count() ?? 0;
        $program_ekonomi = $datas2->clone()->where('pilar', 'Pilar Ekonomi')->count() ?? 0;
        $program_kesehatan = $datas2->clone()->where('pilar', 'Pilar Kesehatan')->count() ?? 0;
        $program_kelembagaan = $datas2->clone()->where('pilar', 'Pilar Penguatan Kelembagaan')->count() ?? 0;
        $program_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() ?? 0;
        $program_kemanusiaan = $datas2->clone()->where('pilar', 'Pilar Kemanusiaan')->count() ?? 0;
        $program_lingkungan = $datas2->clone()->where('pilar', 'Pilar Lingkungan')->count() ?? 0;
        $program_pendidikan = $datas2->clone()->where('pilar', 'Pilar Pendidikan')->count() ?? 0;
        $program_total_jumlah = $program_hukum + $program_ekonomi + $program_kesehatan + $program_kelembagaan + $program_dakwah + $program_kemanusiaan + $program_lingkungan + $program_pendidikan;

        //copy_persentase penerima manfaat
        $cp_pm_hukum = ($pm_total_jumlah != 0) ? ($pm_hukum / $pm_total_jumlah) * 100 : 0;
        $cp_pm_ekonomi = ($pm_total_jumlah != 0) ? ($pm_ekonomi / $pm_total_jumlah) * 100 : 0;
        $cp_pm_kesehatan = ($pm_total_jumlah != 0) ? ($pm_kesehatan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_kelembagaan = ($pm_total_jumlah != 0) ? ($pm_kelembagaan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_dakwah = ($pm_total_jumlah != 0) ? ($pm_dakwah / $pm_total_jumlah) * 100 : 0;
        $cp_pm_kemanusiaan = ($pm_total_jumlah != 0) ? ($pm_kemanusiaan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_lingkungan = ($pm_total_jumlah != 0) ? ($pm_lingkungan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_pendidikan = ($pm_total_jumlah != 0) ? ($pm_pendidikan / $pm_total_jumlah) * 100 : 0;

        //persentase penerima manfaat
        $p_pm_hukum = number_format($cp_pm_hukum, 2) . '%';
        $p_pm_ekonomi = number_format($cp_pm_ekonomi, 2) . '%';
        $p_pm_kesehatan = number_format($cp_pm_kesehatan, 2) . '%';
        $p_pm_kelembagaan = number_format($cp_pm_kelembagaan, 2) . '%';
        $p_pm_dakwah = number_format($cp_pm_dakwah, 2) . '%';
        $p_pm_kemanusiaan = number_format($cp_pm_kemanusiaan, 2) . '%';
        $p_pm_lingkungan = number_format($cp_pm_lingkungan, 2) . '%';
        $p_pm_pendidikan = number_format($cp_pm_pendidikan, 2) . '%';

        // Hitung total persentase
        $total_persentase_pm = intval($cp_pm_hukum + $cp_pm_ekonomi + $cp_pm_kesehatan + $cp_pm_kelembagaan + $cp_pm_dakwah + $cp_pm_kemanusiaan + $cp_pm_lingkungan + $cp_pm_pendidikan);


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

        $pdf->SetMargins(8 + 0, 8 + 5, 8 + 5);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();




        $tings = 'ranting';

        if ($sub == 'laporan') {
            $pdf->AddPage('P');
            // Load and render the first view
            $html = view('print.serah_terima_laporan', compact(
                'program',
                'id_upzis',
                'filter_daterange',
                'filter_daterange2',
                'sum_pencairan',
                'sum_penerima',
                'hukum',
                'ekonomi',
                'kesehatan',
                'kelembagaan',
                'dakwah',
                'kemanusiaan',
                'lingkungan',
                'pendidikan',
                'total_jumlah',
                'tings',
                'p_hukum',
                'p_ekonomi',
                'p_kesehatan',
                'p_kelembagaan',
                'p_dakwah',
                'p_kemanusiaan',
                'p_lingkungan',
                'p_pendidikan',
                'total_persentase',
                'pm_hukum',
                'pm_ekonomi',
                'pm_kesehatan',
                'pm_kelembagaan',
                'pm_dakwah',
                'pm_kemanusiaan',
                'pm_lingkungan',
                'pm_pendidikan',
                'pm_total_jumlah',
                'p_pm_hukum',
                'p_pm_ekonomi',
                'p_pm_kesehatan',
                'p_pm_kelembagaan',
                'p_pm_dakwah',
                'p_pm_kemanusiaan',
                'p_pm_lingkungan',
                'p_pm_pendidikan',
                'total_persentase_pm',
                'id_ranting2',
            ))->render();

            // Output the HTML content to the PDF
            $pdf->writeHTML($html, true, false, true, false, '');
        }

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

        $pdf->SetMargins(3 + 0, 3 + 2, 3 + 2);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();
        $pdf->AddPage('L');


        // Load and render the first view
        $html1 = view('print.pdf_umum_ranting', compact(
            'title',
            'daftar_upzis',
            'daftar_ranting2',
            'tab_upzis',
            'tab_ranting',
            // TabRanting
            'program',
            'id_upzis2',
            'id_ranting2',
            'status2',
            'start_date2',
            'end_date2',
            'filter_daterange2',
            'sum_pencairan',
            'sum_penerima',
            'sub',
            'tings',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');



        // if ($sub == 'laporan') {
        //     $pdf->AddPage('P');
        //     // Load and render the first view
        //     $html2 = view('print.laporan_berdasarkan_grafik', compact(
        //         'program',
        //         'id_upzis',
        //         'filter_daterange',
        //         'filter_daterange2',
        //         'sum_pencairan',
        //         'sum_penerima',
        //         'hukum',
        //         'ekonomi',
        //         'kesehatan',
        //         'kelembagaan',
        //         'dakwah',
        //         'kemanusiaan',
        //         'lingkungan',
        //         'pendidikan',
        //         'total_jumlah',
        //         'tings',
        //         'p_hukum',
        //         'p_ekonomi',
        //         'p_kesehatan',
        //         'p_kelembagaan',
        //         'p_dakwah',
        //         'p_kemanusiaan',
        //         'p_lingkungan',
        //         'p_pendidikan',
        //         'total_persentase',
        //         'pm_hukum',
        //         'pm_ekonomi',
        //         'pm_kesehatan',
        //         'pm_kelembagaan',
        //         'pm_dakwah',
        //         'pm_kemanusiaan',
        //         'pm_lingkungan',
        //         'pm_pendidikan',
        //         'pm_total_jumlah',
        //         'p_pm_hukum',
        //         'p_pm_ekonomi',
        //         'p_pm_kesehatan',
        //         'p_pm_kelembagaan',
        //         'p_pm_dakwah',
        //         'p_pm_kemanusiaan',
        //         'p_pm_lingkungan',
        //         'p_pm_pendidikan',
        //         'total_persentase_pm',
        //         'id_ranting2',
        //         'program_hukum',
        //         'program_ekonomi',
        //         'program_kesehatan',
        //         'program_kelembagaan',
        //         'program_dakwah',
        //         'program_kemanusiaan',
        //         'program_lingkungan',
        //         'program_pendidikan',
        //         'program_total_jumlah',
        //     ))->render();

        //     // Output the HTML content to the PDF
        //     $pdf->writeHTML($html2, true, false, true, false, '');
        // }


        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT RANTING BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = 'DATA REALISASI PENTASYARUFAN TINGKAT RANTING BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR PERIODE ' . $new_date_range . '.pdf';
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
    }

    public function pdf_umum_keseluruhan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {

        $sub = $sub;
        // Memecah string tanggal menjadi dua bagian berdasarkan tanda "-"
        $date_parts = explode(" - ", $filter_daterange2);
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();

        // Menggunakan Carbon untuk mengonversi format tanggal
        $start_date = Carbon::parse($date_parts[0])->format('d-m-Y');
        $end_date = Carbon::parse($date_parts[1])->format('d-m-Y');

        // Menggabungkan kembali hasilnya
        $new_date_range = $start_date . " - " . $end_date;

        // dd($request->all());
        $title = "DATA PENGAJUAN";
        // tabbed
        $tab_upzis = NULL;
        $tab_ranting = 'show active';

        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        //////////////// TabRanting
        // request
        $id_upzis2 = $id_upzis2;

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $id_ranting2 = $id_ranting2;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $status2 = $status2;
        // daterange
        $date_range2 = $filter_daterange2;
        $date_parts2 = explode(" - ", $date_range2);
        $start_date2 = $date_parts2[0];
        $end_date2 = $date_parts2[1];
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;
        // dd($filter_daterange2);

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        // dd($id_upzis2);
        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }

        $datas2 = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.id_ranting',
            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })


            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan_detail.created_at', '>=', $start_date2)
                        ->whereDate('pengajuan_detail.created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan_detail.created_at', $start_date2);
                    })->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', '>=', $start_date2)
                        ->whereDate('pengajuan.tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', $start_date2);
                    })->latest('tgl_terbit_rekomendasi');
            });


        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas2->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $program = $datas2->get()->groupBy('pilar');

        $sum_pencairan = $datas2->sum('nominal_pencairan');
        $sum_penerima = $datas2->sum('jumlah_penerima');

        //nominal pencairan
        $hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->sum('nominal_pencairan') ?? 0;
        $ekonomi = $datas2->clone()->where('pilar', 'Pilar Ekonomi')->sum('nominal_pencairan') ?? 0;
        $kesehatan = $datas2->clone()->where('pilar', 'Pilar Kesehatan')->sum('nominal_pencairan') ?? 0;
        $kelembagaan = $datas2->clone()->where('pilar', 'Pilar Penguatan Kelembagaan')->sum('nominal_pencairan') ?? 0;
        $dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') ?? 0;
        $kemanusiaan = $datas2->clone()->where('pilar', 'Pilar Kemanusiaan')->sum('nominal_pencairan') ?? 0;
        $lingkungan = $datas2->clone()->where('pilar', 'Pilar Lingkungan')->sum('nominal_pencairan') ?? 0;
        $pendidikan = $datas2->clone()->where('pilar', 'Pilar Pendidikan')->sum('nominal_pencairan') ?? 0;
        $total_jumlah = $hukum + $ekonomi + $kesehatan + $kelembagaan + $dakwah + $kemanusiaan + $lingkungan + $pendidikan;

        //copy_persentase pencairan
        $cp_hukum = ($total_jumlah != 0) ? ($hukum / $total_jumlah) * 100 : 0;
        $cp_ekonomi = ($total_jumlah != 0) ? ($ekonomi / $total_jumlah) * 100 : 0;
        $cp_kesehatan = ($total_jumlah != 0) ? ($kesehatan / $total_jumlah) * 100 : 0;
        $cp_kelembagaan = ($total_jumlah != 0) ? ($kelembagaan / $total_jumlah) * 100 : 0;
        $cp_dakwah = ($total_jumlah != 0) ? ($dakwah / $total_jumlah) * 100 : 0;
        $cp_kemanusiaan = ($total_jumlah != 0) ? ($kemanusiaan / $total_jumlah) * 100 : 0;
        $cp_lingkungan = ($total_jumlah != 0) ? ($lingkungan / $total_jumlah) * 100 : 0;
        $cp_pendidikan = ($total_jumlah != 0) ? ($pendidikan / $total_jumlah) * 100 : 0;

        //persentase pencairan
        $p_hukum = number_format($cp_hukum, 2) . '%';
        $p_ekonomi = number_format($cp_ekonomi, 2) . '%';
        $p_kesehatan = number_format($cp_kesehatan, 2) . '%';
        $p_kelembagaan = number_format($cp_kelembagaan, 2) . '%';
        $p_dakwah = number_format($cp_dakwah, 2) . '%';
        $p_kemanusiaan = number_format($cp_kemanusiaan, 2) . '%';
        $p_lingkungan = number_format($cp_lingkungan, 2) . '%';
        $p_pendidikan = number_format($cp_pendidikan, 2) . '%';

        // Hitung total persentase
        $total_persentase = intval($cp_hukum + $cp_ekonomi + $cp_kesehatan + $cp_kelembagaan + $cp_dakwah + $cp_kemanusiaan + $cp_lingkungan + $cp_pendidikan);

        //penerima manfaat
        $pm_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->sum('jumlah_penerima') ?? 0;
        $pm_ekonomi = $datas2->clone()->where('pilar', 'Pilar Ekonomi')->sum('jumlah_penerima') ?? 0;
        $pm_kesehatan = $datas2->clone()->where('pilar', 'Pilar Kesehatan')->sum('jumlah_penerima') ?? 0;
        $pm_kelembagaan = $datas2->clone()->where('pilar', 'Pilar Penguatan Kelembagaan')->sum('jumlah_penerima') ?? 0;
        $pm_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') ?? 0;
        $pm_kemanusiaan = $datas2->clone()->where('pilar', 'Pilar Kemanusiaan')->sum('jumlah_penerima') ?? 0;
        $pm_lingkungan = $datas2->clone()->where('pilar', 'Pilar Lingkungan')->sum('jumlah_penerima') ?? 0;
        $pm_pendidikan = $datas2->clone()->where('pilar', 'Pilar Pendidikan')->sum('jumlah_penerima') ?? 0;
        $pm_total_jumlah = $pm_hukum + $pm_ekonomi + $pm_kesehatan + $pm_kelembagaan + $pm_dakwah + $pm_kemanusiaan + $pm_lingkungan + $pm_pendidikan;

        $program_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->count() ?? 0;
        $program_ekonomi = $datas2->clone()->where('pilar', 'Pilar Ekonomi')->count() ?? 0;
        $program_kesehatan = $datas2->clone()->where('pilar', 'Pilar Kesehatan')->count() ?? 0;
        $program_kelembagaan = $datas2->clone()->where('pilar', 'Pilar Penguatan Kelembagaan')->count() ?? 0;
        $program_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() ?? 0;
        $program_kemanusiaan = $datas2->clone()->where('pilar', 'Pilar Kemanusiaan')->count() ?? 0;
        $program_lingkungan = $datas2->clone()->where('pilar', 'Pilar Lingkungan')->count() ?? 0;
        $program_pendidikan = $datas2->clone()->where('pilar', 'Pilar Pendidikan')->count() ?? 0;
        $program_total_jumlah = $program_hukum + $program_ekonomi + $program_kesehatan + $program_kelembagaan + $program_dakwah + $program_kemanusiaan + $program_lingkungan + $program_pendidikan;

        //copy_persentase penerima manfaat
        $cp_pm_hukum = ($pm_total_jumlah != 0) ? ($pm_hukum / $pm_total_jumlah) * 100 : 0;
        $cp_pm_ekonomi = ($pm_total_jumlah != 0) ? ($pm_ekonomi / $pm_total_jumlah) * 100 : 0;
        $cp_pm_kesehatan = ($pm_total_jumlah != 0) ? ($pm_kesehatan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_kelembagaan = ($pm_total_jumlah != 0) ? ($pm_kelembagaan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_dakwah = ($pm_total_jumlah != 0) ? ($pm_dakwah / $pm_total_jumlah) * 100 : 0;
        $cp_pm_kemanusiaan = ($pm_total_jumlah != 0) ? ($pm_kemanusiaan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_lingkungan = ($pm_total_jumlah != 0) ? ($pm_lingkungan / $pm_total_jumlah) * 100 : 0;
        $cp_pm_pendidikan = ($pm_total_jumlah != 0) ? ($pm_pendidikan / $pm_total_jumlah) * 100 : 0;

        //persentase penerima manfaat
        $p_pm_hukum = number_format($cp_pm_hukum, 2) . '%';
        $p_pm_ekonomi = number_format($cp_pm_ekonomi, 2) . '%';
        $p_pm_kesehatan = number_format($cp_pm_kesehatan, 2) . '%';
        $p_pm_kelembagaan = number_format($cp_pm_kelembagaan, 2) . '%';
        $p_pm_dakwah = number_format($cp_pm_dakwah, 2) . '%';
        $p_pm_kemanusiaan = number_format($cp_pm_kemanusiaan, 2) . '%';
        $p_pm_lingkungan = number_format($cp_pm_lingkungan, 2) . '%';
        $p_pm_pendidikan = number_format($cp_pm_pendidikan, 2) . '%';

        // Hitung total persentase
        $total_persentase_pm = intval($cp_pm_hukum + $cp_pm_ekonomi + $cp_pm_kesehatan + $cp_pm_kelembagaan + $cp_pm_dakwah + $cp_pm_kemanusiaan + $cp_pm_lingkungan + $cp_pm_pendidikan);


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

        $pdf->SetMargins(8 + 0, 8 + 5, 8 + 5);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();




        $tings = 'keseluruhan';

        if ($sub == 'laporan') {
            $pdf->AddPage('P');
            // Load and render the first view
            $html = view('print.serah_terima_laporan', compact(
                'program',
                'id_upzis',
                'id_upzis2',
                'filter_daterange',
                'filter_daterange2',
                'sum_pencairan',
                'sum_penerima',
                'hukum',
                'ekonomi',
                'kesehatan',
                'kelembagaan',
                'dakwah',
                'kemanusiaan',
                'lingkungan',
                'pendidikan',
                'total_jumlah',
                'tings',
                'p_hukum',
                'p_ekonomi',
                'p_kesehatan',
                'p_kelembagaan',
                'p_dakwah',
                'p_kemanusiaan',
                'p_lingkungan',
                'p_pendidikan',
                'total_persentase',
                'pm_hukum',
                'pm_ekonomi',
                'pm_kesehatan',
                'pm_kelembagaan',
                'pm_dakwah',
                'pm_kemanusiaan',
                'pm_lingkungan',
                'pm_pendidikan',
                'pm_total_jumlah',
                'p_pm_hukum',
                'p_pm_ekonomi',
                'p_pm_kesehatan',
                'p_pm_kelembagaan',
                'p_pm_dakwah',
                'p_pm_kemanusiaan',
                'p_pm_lingkungan',
                'p_pm_pendidikan',
                'total_persentase_pm',
                'id_ranting2',
            ))->render();

            // Output the HTML content to the PDF
            $pdf->writeHTML($html, true, false, true, false, '');
        }

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

        $pdf->SetMargins(3 + 0, 3 + 2, 3 + 2);

        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetLeftMargin(10);

        $pdf->SetCellPadding(0.7);

        ob_start();
        $pdf->AddPage('L');


        // Load and render the first view
        $html1 = view('print.pdf_umum_ranting', compact(
            'title',
            'tings',
            'daftar_upzis',
            'daftar_ranting2',
            'tab_upzis',
            'tab_ranting',
            // TabRanting
            'program',
            'id_upzis2',
            'id_ranting2',
            'status2',
            'start_date2',
            'end_date2',
            'filter_daterange2',
            'sum_pencairan',
            'sum_penerima',
            'sub'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');


        // if ($sub == 'laporan') {
        //     $pdf->AddPage('P');
        //     // Load and render the first view
        //     $html2 = view('print.laporan_berdasarkan_grafik', compact(
        //         'program',
        //         'id_upzis',
        //         'filter_daterange',
        //         'filter_daterange2',
        //         'sum_pencairan',
        //         'sum_penerima',
        //         'hukum',
        //         'ekonomi',
        //         'kesehatan',
        //         'kelembagaan',
        //         'dakwah',
        //         'kemanusiaan',
        //         'lingkungan',
        //         'pendidikan',
        //         'total_jumlah',
        //         'tings',
        //         'p_hukum',
        //         'p_ekonomi',
        //         'p_kesehatan',
        //         'p_kelembagaan',
        //         'p_dakwah',
        //         'p_kemanusiaan',
        //         'p_lingkungan',
        //         'p_pendidikan',
        //         'total_persentase',
        //         'pm_hukum',
        //         'pm_ekonomi',
        //         'pm_kesehatan',
        //         'pm_kelembagaan',
        //         'pm_dakwah',
        //         'pm_kemanusiaan',
        //         'pm_lingkungan',
        //         'pm_pendidikan',
        //         'pm_total_jumlah',
        //         'p_pm_hukum',
        //         'p_pm_ekonomi',
        //         'p_pm_kesehatan',
        //         'p_pm_kelembagaan',
        //         'p_pm_dakwah',
        //         'p_pm_kemanusiaan',
        //         'p_pm_lingkungan',
        //         'p_pm_pendidikan',
        //         'total_persentase_pm',
        //         'id_ranting2',
        //         'program_hukum',
        //         'program_ekonomi',
        //         'program_kesehatan',
        //         'program_kelembagaan',
        //         'program_dakwah',
        //         'program_kemanusiaan',
        //         'program_lingkungan',
        //         'program_pendidikan',
        //         'program_total_jumlah',
        //     ))->render();

        //     // Output the HTML content to the PDF
        //     $pdf->writeHTML($html2, true, false, true, false, '');
        // }

        $nama_upzis = strtoupper(PengajuanController::get_nama_upzis($id_upzis2));
        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT RANTING BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = 'DATA REALISASI PENTASYARUFAN BY PILAR & PROGRAM PER WILAYAH KECAMATAN ' . $nama_upzis . ' BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR PERIODE ' . $new_date_range . '.pdf';
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
    }


    public function excel_umum_ranting($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        // dd('baba');

        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }
        // dd($id_upzis);

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        // dd($id_upzis2);

        // dd($id_upzis2);
        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }
        // dd($id_ranting2);

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
        $id_upzis2 = $id_upzis2;

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $id_ranting2 = $id_ranting2;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $status2 = $status2;
        // daterange
        $date_range2 = $filter_daterange2;
        $date_parts2 = explode(" - ", $date_range2);
        $start_date2 = $date_parts2[0];
        $end_date2 = $date_parts2[1];
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;
        // dd($filter_daterange2);

        $startDate = \Carbon\Carbon::parse($start_date)
            ->locale('id')
            ->isoFormat('D MMMM Y');
        $endDate = \Carbon\Carbon::parse($end_date)
            ->locale('id')
            ->isoFormat('D MMMM Y');

        $nama_upzis = '';
        $nama_ranting = '';
        if ($id_upzis2) {
            $nama_upzis = strtoupper(PengajuanController::get_nama_upzis($id_upzis2));
        } else {
            $nama_upzis = 'Semua';
        }
        // dd($nama_upzis);

        if ($id_ranting2) {
            $nama_ranting = strtoupper(PengajuanController::get_nama_ranting($id_ranting2));
        } else {
            $nama_ranting = 'Semua';
        }
        // dd($nama_ranting);


        $program = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.id_ranting',


            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan_detail.created_at', '>=', $start_date2)
                        ->whereDate('pengajuan_detail.created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan_detail.created_at', $start_date2);
                    })->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', '>=', $start_date2)
                        ->whereDate('pengajuan.tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', $start_date2);
                    })->latest('tgl_terbit_rekomendasi');
            })
            ->get();

            $programs = $program->groupBy('pilar');
            $sum_pencairan = $program->sum('nominal_pencairan');
            $sum_penerima = $program->sum('jumlah_penerima');


        // Create a new Excel instance
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // Set cell values and merge cells
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'REALISASI PENTASYARUFAN TINGKAT RANTING');
        $sheet->getStyle('A2:H2')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'BERDASARKAN PERSETUJUAN DIREKTUR DAN DIV. KEUANGAN');
        $sheet->getStyle('A3:H3')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally


        $sheet->mergeCells('A5:B5');
        $sheet->setCellValue('A5', ' PERIODE');
        $sheet->getStyle('A5:B5')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A5:B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        
        $sheet->mergeCells('A6:B6');
        $sheet->setCellValue('A6', ' TOTAL PENCAIRAN');
        $sheet->getStyle('A6:B6')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A6:B6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        
        $sheet->mergeCells('A7:B7');
        $sheet->setCellValue('A7', ' TOTAL PENERIMA MANFAAT');
        $sheet->getStyle('A7:B7')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A7:B7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        
        $sheet->mergeCells('A8:B8');
        $sheet->setCellValue('A8', ' UPZIS MWCNU');
        $sheet->getStyle('A8:B8')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A8:B8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->mergeCells('A9:B9');
        $sheet->setCellValue('A9', ' RANTING MWCNU');
        $sheet->getStyle('A9:B9')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A9:B9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally

        $sheet->setCellValue('C5', $startDate . ' - ' . $endDate);
        $sheet->getStyle('C5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C6', number_format($sum_pencairan, 0, '.', '.'));
        $sheet->getStyle('C6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C7', $sum_penerima);
        $sheet->getStyle('C7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C8', $nama_upzis);
        $sheet->getStyle('C8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C9', $nama_ranting);
        $sheet->getStyle('C9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        // dd($nama_upzis);
        $sheet->setCellValue('A11', 'NO');
        $sheet->setCellValue('B11', 'NAMA PROGRAM');
        $sheet->setCellValue('C11', 'SUMBER DANA');
        $sheet->setCellValue('D11', 'TGL KONFIRMASI');
        $sheet->setCellValue('E11', 'NOMINAL PENGAJUAN ');
        $sheet->setCellValue('F11', 'TGL TERBIT REKOMENDASI');
        $sheet->setCellValue('G11', 'NOMINAL PENCAIRAN');
        $sheet->setCellValue('H11', 'PENERIMA MANFAAT');

        // Set column widths manually
        $columnWidths = [
            'A' => 5,
            'B' => 40,
            'C' => 25,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 10,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }



        // Set background color for header row (row 5)
        $headerStyle = $sheet->getStyle('A11:H11');
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $headerStyle->getFill()->getStartColor()->setARGB('FFFF00'); // Yellow color

        // Set border for the entire sheet
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A11:H11')->applyFromArray($borderStyle); // Apply border style to header row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A11:H' . $lastRow)->applyFromArray($borderStyle); // Apply border style to the rest of the rows



        $ur = 12; // Assuming you start from row 6
        $no = 1; // Assuming you start from number 1


        // Mulai isi tabel
        if (count($programs) > 0) {
            $abjd = 1;
            foreach ($programs as $pilar => $details) {
                $jumlah_nominal_pengajuan = 0;
                $jumlah_nominal_pencairan = 0;
                $jumlah_penerima_manfaat = 0;

                foreach ($details as $x) {
                    $jumlah_nominal_pengajuan += $x->nominal_pengajuan;
                    $jumlah_nominal_pencairan += $x->nominal_pencairan;
                    $jumlah_penerima_manfaat += $x->jumlah_penerima;
                }

                // Merge cells A to D and E to F for the main section
                $sheet->mergeCells('A' . $ur . ':D' . $ur);

                // Set gray background color for cells A to D
                $style = $sheet->getStyle('A' . $ur . ':D' . $ur);
                $style->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $style->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed


                // Set gray background color for cells G and H
                $styleG = $sheet->getStyle('E' . $ur);
                $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleG->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                // Set gray background color for cells G and H
                $styleG = $sheet->getStyle('F' . $ur);
                $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleG->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                // Set gray background color for cells G and H
                $styleG = $sheet->getStyle('G' . $ur);
                $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleG->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                $styleH = $sheet->getStyle('H' . $ur);
                $styleH->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleH->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed


                // Populate data for the main section
                $sheet->setCellValue('A' . $ur, strtoupper(chr(64 + $abjd++)) . '. ' . $pilar);
                $sheet->setCellValue('E' . $ur, ' ' . number_format($jumlah_nominal_pengajuan, 0, '.', '.') );
                $sheet->setCellValue('G' . $ur, ' ' . number_format($jumlah_nominal_pencairan, 0, '.', '.') );
                $sheet->setCellValue('H' . $ur, $jumlah_penerima_manfaat);

                // Increment $ur for the next row
                $ur++;

                // Apply outside border to the entire row
                $borderStyle = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $currentRow = $ur - 1; // The current row processed in the outer loop
                $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($borderStyle); // Apply outside border style to the entire row

                // Get unique programs within this section
                $uniquePrograms = $details->unique('nama_program');

                $no_main = 1;
                foreach ($uniquePrograms as $a) {
                    // Anda mungkin perlu menyesuaikan ini tergantung pada struktur model dan propertinya
                    $firstDetail = $details->where('nama_program', $a->nama_program)->first();

                    // Merge cells A to D and E to F for each unique program
                    $sheet->mergeCells('A' . $ur . ':D' . $ur);

                    // Set light green background color for cells A to D
                    $styleAtoD = $sheet->getStyle('A' . $ur . ':D' . $ur);
                    $styleAtoD->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleAtoD->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells G
                    $styleG = $sheet->getStyle('E' . $ur);
                    $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleG->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells G
                    $styleG = $sheet->getStyle('F' . $ur);
                    $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleG->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells G
                    $styleG = $sheet->getStyle('G' . $ur);
                    $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleG->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells H
                    $styleH = $sheet->getStyle('H' . $ur);
                    $styleH->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleH->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                   // Populate data for each unique program
                    $sheet->setCellValue('A' . $ur, $no_main++ . '. ' . PengajuanController::get_nama_program($firstDetail->id_program_kegiatan));
                    $sheet->setCellValue('E' . $ur, ' ' . number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pengajuan'), 0, '.', '.') );
                    $sheet->setCellValue('G' . $ur, ' ' . number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pencairan'), 0, '.', '.') );
                    $sheet->setCellValue('H' . $ur, $details->where('nama_program', $a->nama_program)->sum('jumlah_penerima'));


                    // Increment $ur for the next row
                    $ur++;

                    // Apply outside border to the entire row
                    $borderStyle = [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ];

                    $currentRow = $ur - 1; // The current row processed in the outer loop
                    $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($borderStyle); // Apply outside border style to the entire row


                    $no_sub = 1;
                    foreach ($details->where('nama_program', $a->nama_program) as $b) {
                        // Use a separate variable for the inner loop

                        $sheet->setCellValueExplicit('A' . $ur, $no_main - 1 . "." . $no_sub++, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->getStyle('A' . $ur)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Left-align the text

                        $sheet->setCellValue('B' . $ur, $b->pengajuan_note);
                        $sheet->setCellValue('C' . $ur, 'RTG ' . strtoupper(PengajuanController::get_nama_ranting($b->id_ranting)) . ' - ' . PengajuanController::get_nama_bmt($b->id_rekening) . ' - ' . PengajuanController::no_rekening($b->id_rekening));

                        $tgl_konfirmasi = Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_konfirmasi');
                        $tgl_terbit_rekomendasi = Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_terbit_rekomendasi');

                        $sheet->setCellValue('D' . $ur, Carbon::parse($tgl_konfirmasi)->isoFormat('D MMMM Y'));
                        $sheet->setCellValue('E' . $ur, ' ' . number_format($b->nominal_pengajuan, 0, '.', '.') );
                        $sheet->setCellValue('F' . $ur, Carbon::parse($tgl_terbit_rekomendasi)->isoFormat('D MMMM Y'));
                        $sheet->setCellValue('G' . $ur, ' ' . number_format($b->nominal_pencairan, 0, '.', '.') );
                        $sheet->setCellValue('H' . $ur, $b->jumlah_penerima ?? '0');

                        // Increment $urInner for the next row in the inner loop
                        $ur++;

                        $borderStyle = [
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ];

                        $startRow = $ur - 1; // The starting row for the current iteration
                        $sheet->getStyle('A' . $startRow . ':H' . $startRow)->applyFromArray($borderStyle); // Apply border style to the starting row

                    }



                    // Increment $no for the next iteration of the outer loop
                    $no++;
                }
            }
        }

        // Determine the last row in the sheet
        $lastRow = $sheet->getHighestRow();

        // Apply styles to each row individually
        for ($row = 1; $row <= $lastRow; $row++) {
            $range = 'C' . $row . ':H' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $sheet->getStyle($range)->applyFromArray($styleAll);
        }

        $range = 'A' . 11 . ':B' . 11;

        $styleAll = [
            'alignment' => [
                'wrapText' => true,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle($range)->applyFromArray($styleAll);


        // Apply styles to each row individually
        for ($row = 11; $row <= $lastRow; $row++) {
            $range = 'A' . $row . ':B' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Change to HORIZONTAL_LEFT
                ],
            ];

            $sheet->getStyle($range)->applyFromArray($styleAll);
        }


        $tgls = $filter_daterange;
        // Save the Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'REALISASI PENTASYARUFAN TINGKAT RANTING BERDASARKAN PERSETUJUAN DIREKTUR DAN DIV. KEUANGAN' . $tgls . '.xlsx';
        $writer->save($filename);

        // Download the Excel file
        return response()->download($filename)->deleteFileAfterSend(true);
    }


    public function excel_umum_upzis($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        // dd('baba');;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }
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
        $id_upzis = $id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $status = $status;
        // daterange
        $date_range = $filter_daterange;
        $date_parts = explode(" - ", $date_range);
        $start_date = $date_parts[0];
        $end_date = $date_parts[1];
        $filter_daterange = $start_date . ' - ' . $end_date;

        $startDate = \Carbon\Carbon::parse($start_date)
            ->locale('id')
            ->isoFormat('D MMMM Y');
        $endDate = \Carbon\Carbon::parse($end_date)
            ->locale('id')
            ->isoFormat('D MMMM Y');

            $nama_upzis = '';
            if ($id_upzis) {
                $nama_upzis = strtoupper(PengajuanController::get_nama_upzis($id_upzis));
            } else {
                $nama_upzis = 'Semua';
            }
            // dd($nama_upzis);

        $program = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',

            )
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan_detail.created_at', '>=', $start_date)
                        ->whereDate('pengajuan_detail.created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan_detail.created_at', $start_date);
                    })->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', '>=', $start_date)
                        ->whereDate('pengajuan.tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', $start_date);
                    })->latest('tgl_terbit_rekomendasi');
            })
            ->get();

            $programs = $program->groupBy('pilar');
            $sum_pencairan = $program->sum('nominal_pencairan');
            $sum_penerima = $program->sum('jumlah_penerima');


        // Create a new Excel instance
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // Set cell values and merge cells
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'REALISASI PENTASYARUFAN TINGKAT UPZIS');
        $sheet->getStyle('A2:H2')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'BERDASARKAN PERSETUJUAN DIREKTUR DAN DIV. KEUANGAN');
        $sheet->getStyle('A3:H3')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally


        $sheet->mergeCells('A5:B5');
        $sheet->setCellValue('A5', ' PERIODE');
        $sheet->getStyle('A5:B5')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A5:B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        
        $sheet->mergeCells('A6:B6');
        $sheet->setCellValue('A6', ' TOTAL PENCAIRAN');
        $sheet->getStyle('A6:B6')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A6:B6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        
        $sheet->mergeCells('A7:B7');
        $sheet->setCellValue('A7', ' TOTAL PENERIMA MANFAAT');
        $sheet->getStyle('A7:B7')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A7:B7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        
        $sheet->mergeCells('A8:B8');
        $sheet->setCellValue('A8', ' UPZIS MWCNU');
        $sheet->getStyle('A8:B8')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A8:B8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally

        $sheet->setCellValue('C5', $startDate . ' - ' . $endDate);
        $sheet->getStyle('C5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C6', number_format($sum_pencairan, 0, '.', '.'));
        $sheet->getStyle('C6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C7', $sum_penerima);
        $sheet->getStyle('C7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C8', $nama_upzis);
        $sheet->getStyle('C8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        // dd($nama_upzis);
        // Set cell value
        $sheet->setCellValue('A10', 'NO');
        $sheet->setCellValue('B10', 'NAMA PROGRAM');
        $sheet->setCellValue('C10', 'SUMBER DANA');
        $sheet->setCellValue('D10', 'TGL KONFIRMASI');
        $sheet->setCellValue('E10', 'NOMINAL PENGAJUAN ');
        $sheet->setCellValue('F10', 'TGL TERBIT REKOMENDASI');
        $sheet->setCellValue('G10', 'NOMINAL PENCAIRAN');
        $sheet->setCellValue('H10', 'PENERIMA MANFAAT');


        // Set column widths manually
        $columnWidths = [
            'A' => 5,
            'B' => 40,
            'C' => 25,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 10,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }



        // Set background color for header row (row 5)
        $headerStyle = $sheet->getStyle('A10:H10');
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $headerStyle->getFill()->getStartColor()->setARGB('FFFF00'); // Yellow color

        // Set border for the entire sheet
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A10:H10')->applyFromArray($borderStyle); // Apply border style to header row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A10:H' . $lastRow)->applyFromArray($borderStyle); // Apply border style to the rest of the rows



        $ur = 11; // Assuming you start from row 6
        $no = 1; // Assuming you start from number 1


        // Mulai isi tabel
        if (count($programs) > 0) {
            $abjd = 1;
            foreach ($programs as $pilar => $details) {
                $jumlah_nominal_pengajuan = 0;
                $jumlah_nominal_pencairan = 0;
                $jumlah_penerima_manfaat = 0;

                foreach ($details as $x) {
                    $jumlah_nominal_pengajuan += $x->nominal_pengajuan;
                    $jumlah_nominal_pencairan += $x->nominal_pencairan;
                    $jumlah_penerima_manfaat += $x->jumlah_penerima;
                }

                // Merge cells A to D and E to F for the main section
                $sheet->mergeCells('A' . $ur . ':D' . $ur);

                // Set gray background color for cells A to D
                $style = $sheet->getStyle('A' . $ur . ':D' . $ur);
                $style->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $style->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed


                // Set gray background color for cells G and H
                $styleG = $sheet->getStyle('E' . $ur);
                $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleG->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                // Set gray background color for cells G and H
                $styleG = $sheet->getStyle('F' . $ur);
                $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleG->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                // Set gray background color for cells G and H
                $styleG = $sheet->getStyle('G' . $ur);
                $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleG->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                $styleH = $sheet->getStyle('H' . $ur);
                $styleH->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleH->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                // dd($jumlah_nominal_pengajuan);
                $sheet->setCellValue('A' . $ur, strtoupper(chr(64 + $abjd++)) . '. ' . $pilar);
                $sheet->setCellValue('E' . $ur, '' . number_format($jumlah_nominal_pengajuan, 0, '.', '.') );
                $sheet->setCellValue('G' . $ur, '' . number_format($jumlah_nominal_pencairan, 0, '.', '.') );
                $sheet->setCellValue('H' . $ur, $jumlah_penerima_manfaat);

                // Increment $ur for the next row
                $ur++;

                // Apply outside border to the entire row
                $borderStyle = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $currentRow = $ur - 1; // The current row processed in the outer loop
                $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($borderStyle); // Apply outside border style to the entire row

                // Get unique programs within this section
                $uniquePrograms = $details->unique('nama_program');

                $no_main = 1;
                foreach ($uniquePrograms as $a) {
                    // Anda mungkin perlu menyesuaikan ini tergantung pada struktur model dan propertinya
                    $firstDetail = $details->where('nama_program', $a->nama_program)->first();

                    // Merge cells A to D and E to F for each unique program
                    $sheet->mergeCells('A' . $ur . ':D' . $ur);

                    // Set light green background color for cells A to D
                    $styleAtoD = $sheet->getStyle('A' . $ur . ':D' . $ur);
                    $styleAtoD->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleAtoD->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells G
                    $styleG = $sheet->getStyle('E' . $ur);
                    $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleG->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells G
                    $styleG = $sheet->getStyle('F' . $ur);
                    $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleG->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells G
                    $styleG = $sheet->getStyle('G' . $ur);
                    $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleG->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells H
                    $styleH = $sheet->getStyle('H' . $ur);
                    $styleH->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleH->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Populate data for each unique program
                    $sheet->setCellValue('A' . $ur, $no_main++ . '. ' . PengajuanController::get_nama_program($firstDetail->id_program_kegiatan));
                    $sheet->setCellValue('E' . $ur, '' . number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pengajuan'), 0, '.', '.') );
                    $sheet->setCellValue('G' . $ur, '' . number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pencairan'), 0, '.', '.') );
                    $sheet->setCellValue('H' . $ur, $details->where('nama_program', $a->nama_program)->sum('jumlah_penerima'));

                    // Increment $ur for the next row
                    $ur++;

                    // Apply outside border to the entire row
                    $borderStyle = [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ];

                    $currentRow = $ur - 1; // The current row processed in the outer loop
                    $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($borderStyle); // Apply outside border style to the entire row


                    $no_sub = 1;
                    foreach ($details->where('nama_program', $a->nama_program) as $b) {
                        // Use a separate variable for the inner loop

                        $sheet->setCellValueExplicit('A' . $ur, $no_main - 1 . "." . $no_sub++, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->getStyle('A' . $ur)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Left-align the text

                        $sheet->setCellValue('B' . $ur, $b->pengajuan_note);
                        $sheet->setCellValue('C' . $ur, 'UPZ ' . strtoupper(PengajuanController::get_nama_upzis($b->id_upzis)) . ' - ' . PengajuanController::get_nama_bmt($b->id_rekening) . ' - ' . PengajuanController::no_rekening($b->id_rekening));

                        $tgl_konfirmasi = Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_konfirmasi');
                        $tgl_terbit_rekomendasi = Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_terbit_rekomendasi');

                        $sheet->setCellValue('D' . $ur, Carbon::parse($tgl_konfirmasi)->isoFormat('D MMMM Y'));
                        $sheet->setCellValue('E' . $ur, ' ' . number_format($b->nominal_pengajuan, 0, '.', '.') );
                        $sheet->setCellValue('F' . $ur, Carbon::parse($tgl_terbit_rekomendasi)->isoFormat('D MMMM Y'));
                        $sheet->setCellValue('G' . $ur, ' ' . number_format($b->nominal_pencairan, 0, '.', '.') );
                        $sheet->setCellValue('H' . $ur, $b->jumlah_penerima ?? '0');
                        // dd(number_format($b->nominal_pencairan, 0, '.', '.'));
                        // Increment $urInner for the next row in the inner loop
                        $ur++;

                        $borderStyle = [
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ];

                        $startRow = $ur - 1; // The starting row for the current iteration
                        $sheet->getStyle('A' . $startRow . ':H' . $startRow)->applyFromArray($borderStyle); // Apply border style to the starting row

                    }

                    // Increment $no for the next iteration of the outer loop
                    $no++;
                }
            }
        }

        // Determine the last row in the sheet
        $lastRow = $sheet->getHighestRow();

        // Apply styles to each row individually
        for ($row = 1; $row <= $lastRow; $row++) {
            $range = 'C' . $row . ':H' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $sheet->getStyle($range)->applyFromArray($styleAll);
        }

        $range = 'A' . 10 . ':B' . 10;

        $styleAll = [
            'alignment' => [
                'wrapText' => true,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle($range)->applyFromArray($styleAll);


        // Apply styles to each row individually
        for ($row = 11; $row <= $lastRow; $row++) {
            $range = 'A' . $row . ':B' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Change to HORIZONTAL_LEFT
                ],
            ];

            $sheet->getStyle($range)->applyFromArray($styleAll);
        }


        $tgls = $filter_daterange;
        // Save the Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'REALISASI PENTASYARUFAN TINGKAT UPZIS BERDASARKAN PERSETUJUAN DIREKTUR DAN DIV. KEUANGAN' . $tgls . '.xlsx';
        $writer->save($filename);

        // Download the Excel file
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function excel_umum_keseluruhan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {

        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        // dd($id_upzis2);
        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }

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
        $id_upzis2 = $id_upzis2;
        // dd($id_upzis2);

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis2 = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $id_ranting2 = $id_ranting2;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $daftar_ranting2 = $this->getDaftarUpzisOrRanting('ranting', $id_upzis2);
        $status2 = $status2;
        // daterange
        $date_range2 = $filter_daterange2;
        $date_parts2 = explode(" - ", $date_range2);
        $start_date2 = $date_parts2[0];
        $end_date2 = $date_parts2[1];
        $filter_daterange2 = $start_date2 . ' - ' . $end_date2;
        // dd($filter_daterange2);

        $startDate = \Carbon\Carbon::parse($start_date)
            ->locale('id')
            ->isoFormat('D MMMM Y');
        $endDate = \Carbon\Carbon::parse($end_date)
            ->locale('id')
            ->isoFormat('D MMMM Y');

        $nama_upzis = '';
        if ($id_upzis) {
            $nama_upzis = strtoupper(PengajuanController::get_nama_upzis($id_upzis));
        } else {
            $nama_upzis = 'Semua';
        }
        // dd($nama_upzis);

        $program = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.id_ranting',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan_detail.created_at', '>=', $start_date2)
                        ->whereDate('pengajuan_detail.created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan_detail.created_at', $start_date2);
                    })->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', '>=', $start_date2)
                        ->whereDate('pengajuan.tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', $start_date2);
                    })->latest('tgl_terbit_rekomendasi');
            })
            ->get();

            $programs = $program->groupBy('pilar');
            $sum_pencairan = $program->sum('nominal_pencairan');
            $sum_penerima = $program->sum('jumlah_penerima');


        // Create a new Excel instance
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // $nama_upzis = strtoupper(PengajuanController::get_nama_upzis($id_upzis2));
        // Set cell values and merge cells
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', ' DATA REALISASI PENTASYARUFAN BY PILAR & PROGRAM PER WILAYAH KECAMATAN ' . $nama_upzis);
        $sheet->getStyle('A2:H2')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', ' BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR');
        $sheet->getStyle('A3:H3')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally
        
        $sheet->mergeCells('A5:B5');
        $sheet->setCellValue('A5', ' PERIODE');
        $sheet->getStyle('A5:B5')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A5:B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        
        $sheet->mergeCells('A6:B6');
        $sheet->setCellValue('A6', ' TOTAL PENCAIRAN');
        $sheet->getStyle('A6:B6')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A6:B6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        
        $sheet->mergeCells('A7:B7');
        $sheet->setCellValue('A7', ' TOTAL PENERIMA MANFAAT');
        $sheet->getStyle('A7:B7')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A7:B7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        
        $sheet->mergeCells('A8:B8');
        $sheet->setCellValue('A8', ' UPZIS MWCNU');
        $sheet->getStyle('A8:B8')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A8:B8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally

        $sheet->setCellValue('C5', $startDate . ' - ' . $endDate);
        $sheet->getStyle('C5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C6', number_format($sum_pencairan, 0, '.', '.'));
        $sheet->getStyle('C6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C7', $sum_penerima);
        $sheet->getStyle('C7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        $sheet->setCellValue('C8', $nama_upzis);
        $sheet->getStyle('C8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Center horizontally
        // dd($nama_upzis);
        // Set cell value
        $sheet->setCellValue('A10', 'NO');
        $sheet->setCellValue('B10', 'NAMA PROGRAM');
        $sheet->setCellValue('C10', 'SUMBER DANA');
        $sheet->setCellValue('D10', 'TGL KONFIRMASI');
        $sheet->setCellValue('E10', 'NOMINAL PENGAJUAN ');
        $sheet->setCellValue('F10', 'TGL TERBIT REKOMENDASI');
        $sheet->setCellValue('G10', 'NOMINAL PENCAIRAN');
        $sheet->setCellValue('H10', 'PENERIMA MANFAAT');


        // Set column widths manually
        $columnWidths = [
            'A' => 5,
            'B' => 40,
            'C' => 25,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 10,
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }



        // Set background color for header row (row 5)
        $headerStyle = $sheet->getStyle('A10:H10');
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $headerStyle->getFill()->getStartColor()->setARGB('FFFF00'); // Yellow color

        // Set border for the entire sheet
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A10:H10')->applyFromArray($borderStyle); // Apply border style to header row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A10:H' . $lastRow)->applyFromArray($borderStyle); // Apply border style to the rest of the rows



        $ur = 11; // Assuming you start from row 6
        $no = 1; // Assuming you start from number 1


        // Mulai isi tabel
        if (count($programs) > 0) {
            $abjd = 1;
            foreach ($programs as $pilar => $details) {
                $jumlah_nominal_pengajuan = 0;
                $jumlah_nominal_pencairan = 0;
                $jumlah_penerima_manfaat = 0;

                foreach ($details as $x) {
                    $jumlah_nominal_pengajuan += $x->nominal_pengajuan;
                    $jumlah_nominal_pencairan += $x->nominal_pencairan;
                    $jumlah_penerima_manfaat += $x->jumlah_penerima;
                }

                // Merge cells A to D and E to F for the main section
                $sheet->mergeCells('A' . $ur . ':D' . $ur);

                // Set gray background color for cells A to D
                $style = $sheet->getStyle('A' . $ur . ':D' . $ur);
                $style->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $style->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed


                // Set gray background color for cells G and H
                $styleG = $sheet->getStyle('E' . $ur);
                $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleG->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                // Set gray background color for cells G and H
                $styleG = $sheet->getStyle('F' . $ur);
                $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleG->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                // Set gray background color for cells G and H
                $styleG = $sheet->getStyle('G' . $ur);
                $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleG->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed

                $styleH = $sheet->getStyle('H' . $ur);
                $styleH->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                $styleH->getFill()->getStartColor()->setRGB('DDDDDD'); // Adjust color code as needed


                // Populate data for the main section
                $sheet->setCellValue('A' . $ur, strtoupper(chr(64 + $abjd++)) . '. ' . $pilar);
                $sheet->setCellValue('E' . $ur, ' ' . number_format($jumlah_nominal_pengajuan, 0, '.', '.') );
                $sheet->setCellValue('G' . $ur, ' ' . number_format($jumlah_nominal_pencairan, 0, '.', '.') );
                $sheet->setCellValue('H' . $ur, $jumlah_penerima_manfaat);

                // Increment $ur for the next row
                $ur++;

                // Apply outside border to the entire row
                $borderStyle = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $currentRow = $ur - 1; // The current row processed in the outer loop
                $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($borderStyle); // Apply outside border style to the entire row

                // Get unique programs within this section
                $uniquePrograms = $details->unique('nama_program');

                $no_main = 1;
                foreach ($uniquePrograms as $a) {
                    // Anda mungkin perlu menyesuaikan ini tergantung pada struktur model dan propertinya
                    $firstDetail = $details->where('nama_program', $a->nama_program)->first();

                    // Merge cells A to D and E to F for each unique program
                    $sheet->mergeCells('A' . $ur . ':D' . $ur);

                    // Set light green background color for cells A to D
                    $styleAtoD = $sheet->getStyle('A' . $ur . ':D' . $ur);
                    $styleAtoD->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleAtoD->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells G
                    $styleG = $sheet->getStyle('E' . $ur);
                    $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleG->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells G
                    $styleG = $sheet->getStyle('F' . $ur);
                    $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleG->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells G
                    $styleG = $sheet->getStyle('G' . $ur);
                    $styleG->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleG->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Set light green background color for cells H
                    $styleH = $sheet->getStyle('H' . $ur);
                    $styleH->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
                    $styleH->getFill()->getStartColor()->setRGB('C1E0C1'); // Adjust color code as needed

                    // Populate data for each unique program
                    $sheet->setCellValue('A' . $ur, $no_main++ . '. ' . PengajuanController::get_nama_program($firstDetail->id_program_kegiatan));
                    $sheet->setCellValue('E' . $ur, ' ' . number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pengajuan'), 0, '.', '.') );
                    $sheet->setCellValue('G' . $ur, ' ' . number_format($details->where('nama_program', $a->nama_program)->sum('nominal_pencairan'), 0, '.', '.') );
                    $sheet->setCellValue('H' . $ur, $details->where('nama_program', $a->nama_program)->sum('jumlah_penerima'));

                    // Increment $ur for the next row
                    $ur++;

                    // Apply outside border to the entire row
                    $borderStyle = [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ],
                    ];

                    $currentRow = $ur - 1; // The current row processed in the outer loop
                    $sheet->getStyle('A' . $currentRow . ':H' . $currentRow)->applyFromArray($borderStyle); // Apply outside border style to the entire row


                    $no_sub = 1;
                    foreach ($details->where('nama_program', $a->nama_program) as $b) {
                        // Use a separate variable for the inner loop
                        

                        $sheet->setCellValueExplicit('A' . $ur, $no_main - 1 . "." . $no_sub++, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                        $sheet->getStyle('A' . $ur)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); // Left-align the text

                        $sheet->setCellValue('B' . $ur, $b->pengajuan_note);
                        if ($b->id_ranting) {
                            $sheet->setCellValue('C' . $ur, 'RTG ' . strtoupper(PengajuanController::get_nama_ranting($b->id_ranting)) . ' - ' . PengajuanController::get_nama_bmt($b->id_rekening) . ' - ' . PengajuanController::no_rekening($b->id_rekening));
                        } else {
                            $sheet->setCellValue('C' . $ur, 'UPZ ' . strtoupper(PengajuanController::get_nama_upzis($b->id_upzis)) . ' - ' . PengajuanController::get_nama_bmt($b->id_rekening) . ' - ' . PengajuanController::no_rekening($b->id_rekening));
                        }
                        $tgl_konfirmasi = Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_konfirmasi');
                        $tgl_terbit_rekomendasi = Pengajuan::where('id_pengajuan', $b->id_pengajuan)->value('tgl_terbit_rekomendasi');

                        $sheet->setCellValue('D' . $ur, Carbon::parse($tgl_konfirmasi)->isoFormat('D MMMM Y'));
                        $sheet->setCellValue('E' . $ur, ' ' . number_format($b->nominal_pengajuan, 0, '.', '.') );
                        $sheet->setCellValue('F' . $ur, Carbon::parse($tgl_terbit_rekomendasi)->isoFormat('D MMMM Y'));
                        $sheet->setCellValue('G' . $ur, ' ' . number_format($b->nominal_pencairan, 0, '.', '.') );
                        $sheet->setCellValue('H' . $ur, $b->jumlah_penerima ?? '0');

                        // Increment $urInner for the next row in the inner loop
                        $ur++;

                        $borderStyle = [
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ],
                        ];

                        $startRow = $ur - 1; // The starting row for the current iteration
                        $sheet->getStyle('A' . $startRow . ':H' . $startRow)->applyFromArray($borderStyle); // Apply border style to the starting row

                    }



                    // Increment $no for the next iteration of the outer loop
                    $no++;
                }
            }
        }

        // Determine the last row in the sheet
        $lastRow = $sheet->getHighestRow();

        // Apply styles to each row individually
        for ($row = 1; $row <= $lastRow; $row++) {
            $range = 'C' . $row . ':H' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $sheet->getStyle($range)->applyFromArray($styleAll);
        }

        $range = 'A' . 10 . ':B' . 10;

        $styleAll = [
            'alignment' => [
                'wrapText' => true,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle($range)->applyFromArray($styleAll);


        // Apply styles to each row individually
        for ($row = 11; $row <= $lastRow; $row++) {
            $range = 'A' . $row . ':B' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Change to HORIZONTAL_LEFT
                ],
            ];

            $sheet->getStyle($range)->applyFromArray($styleAll);
        }


        $tgls = $filter_daterange;
        // Save the Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'DATA REALISASI PENTASYARUFAN BY PILAR & PROGRAM PER WILAYAH KECAMATAN ' . $nama_upzis . ' BERDASARKAN TGL TERBIT REKOMENDASI DIREKTUR' . $tgls . '.xlsx';
        $writer->save($filename);

        // Download the Excel file
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function filter_umum_upzis_laporan(Request $request)
    {

        $status_lpj = $request->status_lpj;
        $status_lpj2 = $request->status_lpj2;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        $sub = $request->sub;
        $title = "DATA LAPORAN";

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


        $datas_penerima_manfaat_upzis = PengajuanDetail::leftjoin($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->leftjoin($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->leftjoin($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',
                $this->etasyaruf . '.pengajuan_penerima_lpj.*',
                $this->etasyaruf . '.asnaf.*',

            )
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan_detail.created_at', '>=', $start_date)
                        ->whereDate('pengajuan_detail.created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan_detail.created_at', $start_date);
                    })->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', '>=', $start_date)
                        ->whereDate('pengajuan.tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', $start_date);
                    })->latest('tgl_terbit_rekomendasi');
            });


        $penerima_manfaat = $datas_penerima_manfaat_upzis->get();



        $datas = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('created_at', $start_date);
                    })
                    ->latest('created_at');
            })
            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $data = $datas->get();


        $data_lap = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',

            )
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('created_at', $start_date);
                    })
                    ->latest('created_at');
            })
            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $program = $data_lap->get()->groupBy('pilar');

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

        $datas_penerima_manfaat_ranting = PengajuanDetail::leftjoin($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->leftjoin($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->leftjoin($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',
                $this->etasyaruf . '.pengajuan_penerima_lpj.*',
                $this->etasyaruf . '.asnaf.*',
                $this->etasyaruf . '.pengajuan.id_ranting',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });


        $penerima_manfaat_ranting = $datas_penerima_manfaat_ranting->get();

        $datas2 = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Ranting NU')
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas2->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $data2 = $datas2->get();
        // dd($data2);

        $data_lap_ranting = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.id_ranting',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $program2 = $data_lap_ranting->get()->groupBy('pilar');

        return view(
            'laporan_pengajuan.laporan_upzis_ranting',
            compact(
                'program',
                'program2',
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
                'sub',
                'penerima_manfaat',
                'penerima_manfaat_ranting',
                'status_lpj',
                'status_lpj2',
            )
        );
    }

    public function filter_umum_laporan_upzis_ranting_keseluruhan(Request $request)
    {

        $sub = $request->sub;
        $status_lpj = $request->status_lpj;
        $status_lpj2 = $request->status_lpj2;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();

        $title = "DATA LAPORAN";

        // tabbed
        $tab_upzis = NULL;
        $tab_ranting = 'show active';

        // db
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');

        /////////////// TabUpzis
        // request

        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $id_upzis = NULL;
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_upzis = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
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
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });


        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas2->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $data2 = $datas2->get();


        $data_lap_ranting = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.id_ranting',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')

            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $program2 = $data_lap_ranting->get()->groupBy('pilar');


        $datas_penerima_manfaat_keseluruhan = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftjoin('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftjoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.tgl_terbit_rekomendasi',
                'pengajuan_penerima_lpj.*',
                'asnaf.*',
                'pengajuan.id_ranting',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });


        $penerima_manfaat_keseluruhan = $datas_penerima_manfaat_keseluruhan->get();

        return view(
            'laporan_pengajuan.laporan_upzis_ranting_keseluruhan',
            compact(
                'penerima_manfaat_keseluruhan',
                'program2',
                'title',
                'daftar_upzis',
                'daftar_ranting2',
                'tab_upzis',
                'tab_ranting',
                // TabRanting
                'data2',
                'id_upzis',
                'id_upzis2',
                'id_ranting2',
                'status2',
                'start_date2',
                'end_date2',
                'filter_daterange2',
                'sub',
                'status_lpj',
                'status_lpj2',
            )
        );
    }


    public function filter_umum_ranting_laporan(Request $request)
    {
        $sub = $request->sub;
        $status_lpj = $request->status_lpj;
        $status_lpj2 = $request->status_lpj2;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();
        $title = "DATA LAPORAN";

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

        $datas_penerima_manfaat = PengajuanDetail::leftjoin($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->leftjoin($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->leftjoin($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',
                $this->etasyaruf . '.pengajuan_penerima_lpj.*',
                $this->etasyaruf . '.asnaf.*',

            )
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan_detail.created_at', '>=', $start_date)
                        ->whereDate('pengajuan_detail.created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan_detail.created_at', $start_date);
                    })->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', '>=', $start_date)
                        ->whereDate('pengajuan.tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan.tgl_terbit_rekomendasi', $start_date);
                    })->latest('tgl_terbit_rekomendasi');
            });


        $penerima_manfaat = $datas_penerima_manfaat->get();

        $datas = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('created_at', $start_date);
                    })
                    ->latest('created_at');
            })
            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $data = $datas->get();

        $data_lap_upzis = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',

            )
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('created_at', $start_date);
                    })
                    ->latest('created_at');
            })
            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $program = $data_lap_upzis->get()->groupBy('pilar');

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

        $datas_penerima_manfaat_ranting = PengajuanDetail::leftjoin($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->leftjoin($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->leftjoin($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.tgl_terbit_rekomendasi',
                $this->etasyaruf . '.pengajuan_penerima_lpj.*',
                $this->etasyaruf . '.asnaf.*',
                $this->etasyaruf . '.pengajuan.id_ranting',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });


        $penerima_manfaat_ranting = $datas_penerima_manfaat_ranting->get();

        $datas2 = Pengajuan::orderBy('created_at', 'DESC')
            ->where('tingkat', 'Ranting NU')
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });


        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas2->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $data2 = $datas2->get();


        $data_lap_ranting = PengajuanDetail::join($this->etasyaruf . '.program_pilar', $this->etasyaruf . '.program_pilar.id_program_pilar', '=', $this->etasyaruf . '.pengajuan_detail.id_program_pilar')
            ->join($this->etasyaruf . '.pengajuan', $this->etasyaruf . '.pengajuan.id_pengajuan', '=', $this->etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.pengajuan_detail.*',
                $this->etasyaruf . '.program_pilar.pilar',
                $this->etasyaruf . '.program_kegiatan.nama_program',
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->etasyaruf . '.pengajuan.id_ranting',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('tingkat', 'Ranting NU')
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('created_at', '>=', $start_date2)->whereDate('created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('created_at', $start_date2);
                    })
                    ->latest('created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        $program2 = $data_lap_ranting->get()->groupBy('pilar');

        return view(
            'laporan_pengajuan.laporan_upzis_ranting',
            compact(
                'penerima_manfaat',
                'penerima_manfaat_ranting',
                'program',
                'program2',
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
                'sub',
                'status_lpj',
                'status_lpj2',
            )
        );
    }

    public function filter_umum_upzis(Request $request)
    {

        $status_lpj = $request->status_lpj;
        $status_lpj2 = $request->status_lpj2;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();

        $sub = $request->sub;
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



        $datas = Pengajuan::orderBy('pengajuan.created_at', 'DESC')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')

            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Ditolak', function ($query) use ($status) {
                return $query->where('status_rekomendasi', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan.created_at', '>=', $start_date)->whereDate('pengajuan.created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan.created_at', $start_date);
                    })
                    ->latest('pengajuan.created_at');
            })
            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $data = $datas->groupBy('pengajuan.id_pengajuan')->get();

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

        $datas2 = Pengajuan::orderBy('pengajuan.created_at', 'DESC')
            ->where('tingkat', 'Ranting NU')
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Ditolak', function ($query) use ($status2) {
                return $query->where('status_rekomendasi', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })
            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan.created_at', '>=', $start_date2)->whereDate('pengajuan.created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan.created_at', $start_date2);
                    })
                    ->latest('pengajuan.created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas2->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $data2 = $datas2->groupBy('pengajuan.id_pengajuan')->get();
        // dd($data2);


        return view(
            'pengajuan.upzis-ranting',
            compact(
                'status_lpj',
                'status_lpj2',
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
                'sub',
            )
        );
    }

    public function filter_umum_ranting(Request $request)
    {
        $status_lpj = $request->status_lpj;
        $status_lpj2 = $request->status_lpj2;
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();

        $sub = $request->sub;

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

        $datas = Pengajuan::orderBy('pengajuan.created_at', 'DESC')
            ->where('tingkat', 'Upzis MWCNU')
            ->whereNull('id_ranting')
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status == 'Direncanakan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Diajukan', function ($query) use ($status) {
                return $query->where('status_pengajuan', $status);
            })
            ->when($status == 'Ditolak', function ($query) use ($status) {
                return $query->where('status_rekomendasi', $status);
            })
            ->when($status == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis != NULL, function ($query) use ($id_upzis) {
                return $query->where('id_upzis', $id_upzis);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('pengajuan.created_at', '>=', $start_date)->whereDate('pengajuan.created_at', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('pengajuan.created_at', $start_date);
                    })
                    ->latest('pengajuan.created_at');
            })
            ->when($sub == 'laporan', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun
                return $query->when($start_date && $end_date && $start_date != $end_date, function ($query) use ($start_date, $end_date) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date);
                })
                    ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });

        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $data = $datas->groupBy('pengajuan.id_pengajuan')->get();

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



        // dd($status_lpj2);
        $datas2 = Pengajuan::orderBy('pengajuan.created_at', 'DESC')
            ->where('tingkat', 'Ranting NU')

            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            // filter status
            ->when($status2 == 'Direncanakan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Diajukan', function ($query) use ($status2) {
                return $query->where('status_pengajuan', $status2);
            })
            ->when($status2 == 'Ditolak', function ($query) use ($status2) {
                return $query->where('status_rekomendasi', $status2);
            })
            ->when($status2 == 'Belum Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Belum Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            ->when($status2 == 'Sudah Terbit', function ($query) {
                return $query->where('status_rekomendasi', 'Sudah Terbit')
                    ->when(Auth::user()->gocap_id_pc_pengurus != null, function ($query) {
                        return $query->where('status_pengajuan', '!=', 'Direncanakan');
                    });
            })
            // filter upzis
            ->when($id_upzis2 != NULL, function ($query) use ($id_upzis2) {
                return $query->where('id_upzis', $id_upzis2);
            })
            // filter ranting
            ->when($id_ranting2 != NULL, function ($query) use ($id_ranting2) {
                return $query->where('id_ranting', $id_ranting2);
            })

            ->when($sub == 'pengajuan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('pengajuan.created_at', '>=', $start_date2)->whereDate('pengajuan.created_at', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('pengajuan.created_at', $start_date2);
                    })
                    ->latest('pengajuan.created_at');
            })

            ->when($sub == 'laporan', function ($query) use ($start_date2, $end_date2) {
                // filter bulan dan tahun (updated variable names to start_date2 and end_date2)
                return $query->when($start_date2 && $end_date2 && $start_date2 != $end_date2, function ($query) use ($start_date2, $end_date2) {
                    return $query->whereDate('tgl_terbit_rekomendasi', '>=', $start_date2)->whereDate('tgl_terbit_rekomendasi', '<=', $end_date2);
                })
                    ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
                        return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
                    })
                    ->latest('tgl_terbit_rekomendasi');
            });


        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $datas2->where('status_pengajuan', '!=', 'Direncanakan');
        // }

        $data2 = $datas2->get();




        return view(
            'pengajuan.upzis-ranting',
            compact(
                'status_lpj',
                'status_lpj2',
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
                'sub',
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
            // ->where($gocap . '.' . $role . '_pengurus.status', '1')
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
        if ($role == 'upzis') {
            $pengajuan = Pengajuan::where('tingkat', 'Upzis MWCNU')
                ->where('id_upzis', $id)
                ->whereYear('created_at', date('Y'))
                ->orderBy('created_at', 'desc')
                ->first();
        } else {
            $pengajuan = Pengajuan::where('tingkat', 'Ranting NU')
            ->where('id_ranting', $id)
            ->whereYear('created_at', date('Y'))
            ->orderBy('created_at', 'desc')
            ->first();
        }

        if ($pengajuan == NULL) {
            $urut = 0;
        } else {
            $string = $pengajuan->nomor_surat;
            
            if ($role == 'upzis') {
                $pos = strpos($string, '/UPZIS-MWCNU');
            } else {
                $pos = strpos($string, '/RANTING-NU');
            }

            // Ambil bagian kiri string sampai posisi '/'
            $urutt = substr($string, 0, $pos);
            
            if (strlen($urutt) == 1 || strlen($urutt) == 2) {
                $urut = (int)$urutt;
            } elseif (strlen($urutt) == 3) {
                $urut1 = (int)$urutt[0] . $urutt[1];
                $urut = $urut1 . (int)$urutt[2];
            } else {
                $urut1 = (int)$urutt[0] . $urutt[1];
                $urut2 = $urut1 . (int)$urutt[2];
                $urut = $urut2 . (int)$urutt[3];
            }
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
        if ($pengajuan == NULL) {
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
            // ->where('status_berita', 'Sudah Dikonfirmasi')
            ->whereNot('status_berita', 'Sudah Diperiksa')
            ->whereNot('status_berita', 'Revisi')
            ->count();
        $d = PengajuanDetail::where('id_pengajuan', $id)
            ->where('status_berita', 'Revisi')
            ->count();
        $e = PengajuanDetail::where('id_pengajuan', $id)
            ->whereNull('file_berita')
            ->count();

        return [
            'konfirmasi' => $a,
            'selesai' => $b,
            'belum' => $c,
            'revisi' => $d,
            'blm_konfirmasi' => $e,
        ];
    }
}
