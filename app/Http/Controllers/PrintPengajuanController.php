<?php

namespace App\Http\Controllers;

use PDF;
use TCPDF;

use Carbon\Carbon;

use Dompdf\Dompdf;
use App\Models\Berita;
use App\Models\Program;
use App\Models\Internal;
use App\Models\Programs;
use App\Models\Rekening;
use App\Models\Pengajuan;
use iio\libmergepdf\Merger;
use App\Models\ProgramPilar;
use Illuminate\Http\Request;
// use App\Models\Program;
use App\Models\PengajuanDetail;
use App\Models\PengajuanPenerima;
use App\Models\ProgramKegiatan;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengajuanInternalExport;
use App\Models\Pengguna;

class MyPDFUmumPc extends TCPDF
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


class PrintPengajuanController extends Controller
{

    protected $etasyaruf;
    protected $siftnu;
    protected $gocap;

    protected $id_program_a;
    protected $id_program_b;
    protected $id_program_c;

    protected $bulan;
    protected $tahun;
    protected $status;
    protected $pilar;
    protected $kategori;
    protected $tujuan;



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


    public function print_upzis($bulan, $tahun, $status, $upzis)
    {
        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }
        $daftar_upzis = DB::table($this->etasyaruf . '.pengajuan')
            // ->leftjoin($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('status_pengajuan', $this->status);
            })
            ->whereMonth('tgl_pengajuan', $bulan)
            ->whereYear('tgl_pengajuan', $tahun)
            ->where('tingkat', 'Upzis MWCNU')
            ->leftJoin($this->gocap . '.upzis', $this->gocap . '.upzis.id_upzis', '=', $this->etasyaruf . '.pengajuan.id_upzis')
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.upzis.id_wilayah')
            ->select(
                $this->gocap . '.upzis.id_upzis',
                $this->siftnu . '.wilayah.*',
            )
            ->groupBy('nama')
            ->orderBy('nama', 'ASC')
            ->get();

        // dd($daftar_upzis);

        $this->bulan = $bulan;
        $this->tahun = $tahun;

        $datas = NULL;
        if ($upzis != 'Semua') {
            $datas = Pengajuan::orderBy('created_at', 'ASC')->where('tingkat', 'Upzis MWCNU')
                // filter status
                ->when($this->status, function ($query) {
                    return $query->where('status_pengajuan', $this->status);
                })
                ->whereNull('id_ranting')
                ->where('id_upzis', $upzis)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->orderBy('pengajuan.created_at', 'ASC')
                ->get();
            // dd($datas);
        }

        if ($bulan == '01') {
            $bulans = 'Januari';
        } elseif ($bulan == '02') {
            $bulans = 'Februari';
        } elseif ($bulan == '03') {
            $bulans = 'Maret';
        } elseif ($bulan == '04') {
            $bulans = 'April';
        } elseif ($bulan == '05') {
            $bulans = 'Mei';
        } elseif ($bulan == '06') {
            $bulans = 'Juni';
        } elseif ($bulan == '07') {
            $bulans = 'Juli';
        } elseif ($bulan == '08') {
            $bulans = 'Agustus';
        } elseif ($bulan == '09') {
            $bulans = 'September';
        } elseif ($bulan == '10') {
            $bulans = 'Oktober';
        } elseif ($bulan == '11') {
            $bulans = 'November';
        } elseif ($bulan == '12') {
            $bulans = 'Desember';
        }
        $tingkat = 'UPZIS MWCNU';

        $pdf = PDF::loadview('print.pengajuan_upzis', compact(
            'bulan',
            'datas',
            'bulans',
            'tahun',
            'upzis',
            'daftar_upzis',
            'tingkat',
            'status'

        ))
            ->setPaper('a4', 'landscape');
        if ($upzis == 'Semua') {
            return $pdf->stream()->withHeaders([
                'Title' => 'Your meta title',
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_UPZIS_MWCNU_PERIODE_' . strtoupper($bulans) . '_' . $tahun . '.pdf',
            ]);
        } else {
            return $pdf->stream()->withHeaders([
                'Title' => 'Your meta title',
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_UPZIS_MWCNU_' . strtoupper($this->nama_upzis($upzis)) . '_PERIODE_' . strtoupper($bulans) . '_' . $tahun . '.pdf',
            ]);
        }
    }



    public function print_pc($filter_daterange2, $status)
    {

        $date_range = $filter_daterange2;
        // dd($date_range);    
        // dd($this->filter_daterange2);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange2 = $start_date . ' - ' . $end_date;


        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }
        
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
            ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
            ->select(
                $this->etasyaruf . '.pengajuan.*',
                $this->etasyaruf . '.pengajuan_detail.*'
            )
            // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter periode
            ->when($filter_daterange2 != '', function ($query) use ($start_date, $end_date) {

                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('tgl_pengajuan', '=', $start_date);
                    } else {
                        return $query->whereDate('tgl_pengajuan', '>=', $start_date)
                            ->whereDate('tgl_pengajuan', '<=', $end_date);
                    }
                });
            })

            ->orderBy('pengajuan.created_at', 'ASC')
            ->get();
        
         $id_pengajuan = $data->pluck('id_pengajuan')->toArray();
            // dd($id_pengajuan);

        $mustahik = PengajuanPenerima::whereIn('id_pengajuan', $id_pengajuan)
            ->get();
        // dd($mustahik);


        $tingkat = 'Umum Lazisnu Cilacap';

        $pdf = PDF::loadview('print.pengajuan_pc', compact(
            'data',
            'filter_daterange2',
            'tingkat',
            'status',
            'mustahik'

        ))
            ->setPaper('a4', 'landscape');;
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_UMUM_LAZISNU_CILACAP_PERIODE"' . strtoupper($filter_daterange2) . '.pdf',
        ]);
    }

    public function print_pc_laporan($filter_daterange2, $status, $kategori, $pilar)
    {
        // dd('dq');

        $date_range = $filter_daterange2;
        // dd($date_range);    
        // dd($this->filter_daterange2);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange2 = $start_date . ' - ' . $end_date;


        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($pilar == 'Semua') {
            $this->pilar = NULL;
        } else {
            $this->pilar = $pilar;
        }

        if ($kategori == 'Semua') {
            $this->kategori = NULL;
        } else {
            $this->kategori = $kategori;
        }

        $data = DB::table($this->etasyaruf . '.pengajuan')
            ->where('pengajuan.tingkat', 'PC')
            ->leftJoin('pengajuan_detail', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftJoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftJoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->leftJoin('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftJoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.*',
                'asnaf.*'
            )
            // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
            ->whereNotNull('pengajuan_detail.tgl_konfirmasi')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter periode
            ->when($filter_daterange2 != '', function ($query) use ($start_date, $end_date) {

                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date);
                    }
                });
            })
            // filter kategori
            ->when($this->kategori, function ($query) {
                return $query->where('sumber_dana', $this->kategori);
            })
            // filter pilar
            ->when($this->pilar, function ($query) {
                return $query->where('id_program_pilar', $this->pilar);
            })

            ->orderBy('pengajuan.created_at', 'DESC')
            ->get();

        // dd($data);

        $id_pengajuan = $data->pluck('id_pengajuan')->toArray();
        
        $mustahik = DB::table($this->etasyaruf . '.pengajuan_penerima')
            ->whereIn('id_pengajuan', $id_pengajuan)
            ->get();

        $pdf = new MyPDFUmumPc();

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

        $pdf->AddPage('L');

        $tingkat = 'Umum Lazisnu Cilacap';
        
        $id_pengajuan = $data->pluck('id_pengajuan')->toArray();
            // dd($id_pengajuan);

        $mustahik = PengajuanPenerima::whereIn('id_pengajuan', $id_pengajuan)
            ->get();
        
        


        $html1 = view('print.pengajuan_pc', compact(
            'data',
            'filter_daterange2',
            'tingkat',
            'status',
            'kategori',
            'pilar',
            'mustahik'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $filename = 'REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_UMUM_LAZISNU_CILACAP_PERIODE"' . strtoupper($filter_daterange2) . '.pdf';
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


    public function print_pc_laporan_gabungan($filter_daterange2, $status, $kategori, $pilar, $status_lpj2, $status_lpj)
    {
        // dd('dq');

        $date_range = $filter_daterange2;
        // dd($date_range);    
        // dd($this->filter_daterange2);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange2 = $start_date . ' - ' . $end_date;


        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($pilar == 'Semua') {
            $this->pilar = NULL;
        } else {
            $this->pilar = $pilar;
        }

        if ($kategori == 'Semua') {
            $this->kategori = NULL;
        } else {
            $this->kategori = $kategori;
        }

        $data = DB::table($this->etasyaruf . '.pengajuan')
            ->where('pengajuan.tingkat', 'PC')
            ->leftJoin('pengajuan_detail', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftJoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftJoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->leftJoin('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftJoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.*',
                'asnaf.*'
            )
            ->where('pengajuan.tingkat', 'PC')
            ->whereNotNull('pengajuan_detail.tgl_konfirmasi')

            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query)  {
                return $query->WhereNull('pengajuan_detail.tgl_konfirmasi')->where('tingkat', 'PC');
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($start_date, $end_date) {
                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date);
                    }
                });
            })
            ->when($start_date && $end_date && $start_date == $end_date, function ($query) use ($start_date) {
                return $query->whereDate('tgl_terbit_rekomendasi', $start_date);
            })
            ->latest('tgl_terbit_rekomendasi')
            ->get();

        // dd($data);


        $pdf = new MyPDFUmumPc();

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

        $pdf->AddPage('L');

        $tingkat = 'Umum Lazisnu Cilacap';
        
        $id_pengajuan = $data->pluck('id_pengajuan')->toArray();
            // dd($id_pengajuan);

        $mustahik = PengajuanPenerima::whereIn('id_pengajuan', $id_pengajuan)
            ->get();


        $html1 = view('print.pengajuan_pc', compact(
            'data',
            'filter_daterange2',
            'tingkat',
            'status',
            'kategori',
            'pilar',
            'mustahik'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $filename = 'REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_UMUM_LAZISNU_CILACAP_PERIODE"' . strtoupper($filter_daterange2) . '.pdf';
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


    public function print_pc_laporan_realisasi_by_pilar_program($filter_daterange2, $status, $kategori, $pilar)
    {
        // dd('dw');
        $date_range = $filter_daterange2;
        // dd($date_range);    
        // dd($this->filter_daterange2);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange2 = $start_date . ' - ' . $end_date;
        $filter_daterange_new = $start_date . ' - ' . $end_date;



        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($pilar == 'Semua') {
            $this->pilar = NULL;
        } else {
            $this->pilar = $pilar;
        }

        if ($kategori == 'Semua') {
            $this->kategori = NULL;
        } else {
            $this->kategori = $kategori;
        }

        $datas = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.tgl_terbit_rekomendasi',

            )
            ->where('tingkat', 'PC')
            // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
            ->whereNotNull('pengajuan_detail.tgl_konfirmasi')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter periode
            ->when($filter_daterange2 != '', function ($query) use ($start_date, $end_date) {

                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date);
                    }
                });
            })
            // filter kategori
            ->when($this->kategori, function ($query) {
                return $query->where('sumber_dana', $this->kategori);
            })
            // filter pilar
            ->when($this->pilar, function ($query) {
                return $query->where('id_program_pilar', $this->pilar);
            });

        $programs = $datas->get()->groupBy('pilar');
        $sum_pencairan = $datas->sum('nominal_pencairan');
        $sum_penerima = $datas->sum('jumlah_penerima');
        // dd($programs);
        $tingkat = 'Umum Lazisnu Cilacap';

        $pdf = new MyPDFUmumPc();

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

        $pdf->AddPage('L');

        $sub = 'laporan';
        // Load and render the first view
        $html1 = view('print.print_pc_laporan_realisasi_by_pilar_program', compact(
            'programs',
            'filter_daterange2',
            'tingkat',
            'status',
            'kategori',
            'pilar',
            'sub',
            'sum_penerima',
            'sum_pencairan'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT PCNU LAZISNU CILACAP PERIODE ' . $filter_daterange_new . '.pdf';
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

    public function print_pc_laporan_penerima_manfaat($filter_daterange2, $status, $kategori, $pilar)
    {
        $date_range = $filter_daterange2;
        // dd($date_range);    
        // dd($this->filter_daterange2);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange2 = $start_date . ' - ' . $end_date;
        $filter_daterange_new = $start_date . ' - ' . $end_date;



        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($pilar == 'Semua') {
            $this->pilar = NULL;
        } else {
            $this->pilar = $pilar;
        }

        if ($kategori == 'Semua') {
            $this->kategori = NULL;
        } else {
            $this->kategori = $kategori;
        }

        $data_penerima_manfaat = DB::table($this->etasyaruf . '.pengajuan')
            ->where('pengajuan.tingkat', 'PC')
            ->leftJoin('pengajuan_detail', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftJoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftJoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->leftJoin('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftJoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.*',
                'asnaf.*'
            )
            ->where('tingkat', 'PC')
            // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
            ->whereNotNull('pengajuan_detail.tgl_konfirmasi')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter periode
            ->when($filter_daterange2 != '', function ($query) use ($start_date, $end_date) {

                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date);
                    }
                });
            })
            // filter kategori
            ->when($this->kategori, function ($query) {
                return $query->where('sumber_dana', $this->kategori);
            })
            // filter pilar
            ->when($this->pilar, function ($query) {
                return $query->where('id_program_pilar', $this->pilar);
            })
            ->orderBy('pengajuan.created_at', 'DESC');

        $penerima_manfaat = $data_penerima_manfaat->get();
        // dd($programs);
        $tingkat = 'Umum Lazisnu Cilacap';

        $pdf = new MyPDFUmumPc();

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

        $pdf->AddPage('L');

        $sub = 'laporan';
        // Load and render the first view
        $html1 = view('print.print_pc_laporan_penerima_manfaat', compact(
            'penerima_manfaat',
            'filter_daterange2',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT PCNU LAZISNU CILACAP PERIODE ' . $filter_daterange_new . '.pdf';
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


    public function print_pc_umum_laporan_keseluruhan($filter_daterange2, $status, $kategori, $pilar)
    {

        $date_range = $filter_daterange2;
        // dd($date_range);    
        // dd($this->filter_daterange2);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange2 = $start_date . ' - ' . $end_date;
        $filter_daterange_new = $start_date . ' - ' . $end_date;



        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($pilar == 'Semua') {
            $this->pilar = NULL;
        } else {
            $this->pilar = $pilar;
        }

        if ($kategori == 'Semua') {
            $this->kategori = NULL;
        } else {
            $this->kategori = $kategori;
        }


        $data = DB::table($this->etasyaruf . '.pengajuan')
            ->where('pengajuan.tingkat', 'PC')
            ->leftJoin('pengajuan_detail', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftJoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftJoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->leftJoin('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftJoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.*',
                'asnaf.*'
            )
            // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
            ->whereNotNull('pengajuan_detail.tgl_konfirmasi')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter periode
            ->when($filter_daterange2 != '', function ($query) use ($start_date, $end_date) {

                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date);
                    }
                });
            })
            // filter kategori
            ->when($this->kategori, function ($query) {
                return $query->where('sumber_dana', $this->kategori);
            })
            // filter pilar
            ->when($this->pilar, function ($query) {
                return $query->where('id_program_pilar', $this->pilar);
            })

            ->orderBy('pengajuan.created_at', 'DESC')
            ->get();


        $datas = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.tgl_terbit_rekomendasi',

            )
            ->where('tingkat', 'PC')
            // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
            ->whereNotNull('pengajuan_detail.tgl_konfirmasi')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter periode
            ->when($filter_daterange2 != '', function ($query) use ($start_date, $end_date) {

                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date);
                    }
                });
            })
            // filter kategori
            ->when($this->kategori, function ($query) {
                return $query->where('sumber_dana', $this->kategori);
            })
            // filter pilar
            ->when($this->pilar, function ($query) {
                return $query->where('id_program_pilar', $this->pilar);
            });

        $programs = $datas->get()->groupBy('pilar');


        $data_penerima_manfaat = DB::table($this->etasyaruf . '.pengajuan')
            ->where('pengajuan.tingkat', 'PC')
            ->leftJoin('pengajuan_detail', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftJoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftJoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->leftJoin('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftJoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.*',
                'asnaf.*'
            )
            ->where('tingkat', 'PC')
            // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
            ->whereNotNull('pengajuan_detail.tgl_konfirmasi')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter periode
            ->when($filter_daterange2 != '', function ($query) use ($start_date, $end_date) {

                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date);
                    }
                });
            })
            // filter kategori
            ->when($this->kategori, function ($query) {
                return $query->where('sumber_dana', $this->kategori);
            })
            // filter pilar
            ->when($this->pilar, function ($query) {
                return $query->where('id_program_pilar', $this->pilar);
            })->orderBy('pengajuan.created_at', 'DESC');

        $penerima_manfaat = $data_penerima_manfaat->get();
        $sum_pencairan = $datas->sum('nominal_pencairan');
        $sum_penerima = $datas->sum('jumlah_penerima');


        $pdf = new MyPDFUmumPc();

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


        $tingkat = 'Umum Lazisnu Cilacap';

        $pdf->AddPage('L');
        
        $id_pengajuan = $data->pluck('id_pengajuan')->toArray();
            // dd($id_pengajuan);

        $mustahik = PengajuanPenerima::whereIn('id_pengajuan', $id_pengajuan)
            ->get();

        $html1 = view('print.pengajuan_pc', compact(
            'data',
            'filter_daterange2',
            'tingkat',
            'status',
            'kategori',
            'pilar',
            'mustahik'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $pdf->AddPage('L');

        $sub = 'laporan';
        // Load and render the first view
        $html2 = view('print.print_pc_laporan_realisasi_by_pilar_program', compact(
            'programs',
            'filter_daterange2',
            'tingkat',
            'status',
            'kategori',
            'pilar',
            'sub',
            'sum_penerima',
            'sum_pencairan'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html2, true, false, true, false, '');

        $pdf->AddPage('L');

        // Load and render the first view
        $html3 = view('print.print_pc_laporan_penerima_manfaat', compact(
            'penerima_manfaat',
            'filter_daterange2',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html3, true, false, true, false, '');



        $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT PCNU LAZISNU CILACAP PERIODE ' . $filter_daterange_new . '.pdf';
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

    public function excel_pc_laporan_penerima_manfaat($filter_daterange2, $status, $kategori, $pilar)
    {

        $date_range = $filter_daterange2;
        // dd($date_range);    
        // dd($this->filter_daterange2);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange2 = $start_date . ' - ' . $end_date;
        $filter_daterange_new = $start_date . ' - ' . $end_date;



        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($pilar == 'Semua') {
            $this->pilar = NULL;
        } else {
            $this->pilar = $pilar;
        }

        if ($kategori == 'Semua') {
            $this->kategori = NULL;
        } else {
            $this->kategori = $kategori;
        }

        $datas_penerima_manfaat = DB::table($this->etasyaruf . '.pengajuan')
            ->where('pengajuan.tingkat', 'PC')
            ->leftJoin('pengajuan_detail', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftJoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftJoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->leftJoin('pengajuan_penerima_lpj', 'pengajuan_penerima_lpj.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftJoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.*',
                'asnaf.*'
            )
            ->where('tingkat', 'PC')
            // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
            ->whereNotNull('pengajuan_detail.tgl_konfirmasi')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter periode
            ->when($filter_daterange2 != '', function ($query) use ($start_date, $end_date) {

                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date);
                    }
                });
            })
            // filter kategori
            ->when($this->kategori, function ($query) {
                return $query->where('sumber_dana', $this->kategori);
            })
            // filter pilar
            ->when($this->pilar, function ($query) {
                return $query->where('id_program_pilar', $this->pilar);
            })->orderBy('pengajuan.created_at', 'DESC');

        $penerima_manfaat = $datas_penerima_manfaat->get();
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


        // Set cell value
        $sheet->setCellValue('A5', 'NO');
        $sheet->setCellValue('B5', 'TANGGAL');
        $sheet->setCellValue('C5', 'NAMA');
        $sheet->setCellValue('D5', 'No HP');
        $sheet->setCellValue('E5', 'ALAMAT');
        $sheet->setCellValue('F5', 'NOMINAL BANTUAN ');
        $sheet->setCellValue('G5', 'ASNAF');
        $sheet->setCellValue('H5', 'JENIS BANTUAN');
        $sheet->setCellValue('I5', 'PILAR');
        $sheet->setCellValue('J5', 'JENIS PROGRAM');


        // Set column widths manually
        $columnWidths = [
            'A' => 5,
            'B' => 18,
            'C' => 25,
            'D' => 20,
            'E' => 25,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
            'J' => 20,

        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Set background color for header row (row 5)
        $headerStyle = $sheet->getStyle('A5:J5');
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $headerStyle->getFill()->getStartColor()->setARGB('00ff00'); // Green Color

        // Set border for the entire sheet
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A5:J5')->applyFromArray($borderStyle); // Apply border style to header row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A5:J' . $lastRow)->applyFromArray($borderStyle); // Apply border style to the rest of the rows

        //container
        $ur = 6; // Assuming you start from row 6
        $no = 1; //start

        foreach ($penerima_manfaat as $pm) {

            $sheet->setCellValue('A' . $ur, $no++);
            $sheet->setCellValue('B' . $ur, Carbon::parse($pm->tgl_pengajuan)->isoFormat('D MMMM Y'));

            if ($pm->opsi_pemohon == 'Individu') {
                $nama = $pm->nama_pemohon;
            } elseif ($pm->opsi_pemohon == 'Internal') {
                $nama = Pengguna::where('gocap_id_pc_pengurus', $pm->pemohon_internal)->value('nama');
            } elseif ($pm->opsi_pemohon == 'Entitas') {
                $nama =  $pm->nama_entitas;
            }

            if ($pm->opsi_pemohon == 'Individu') {
                $nohp = $pm->nohp_pemohon;
            } elseif ($pm->opsi_pemohon == 'Internal') {
                $nohp = Pengguna::where('gocap_id_pc_pengurus', $pm->pemohon_internal)->value('nohp');
            } elseif ($pm->opsi_pemohon == 'Entitas') {
                $nohp =  $pm->no_hp_entitas;
            }


            $sheet->setCellValue('C' . $ur, $nama);
            $sheet->setCellValue('D' . $ur, $nohp);

            if ($pm->opsi_pemohon == 'Individu') {
                $alamat = $pm->alamat_pemohon;
            } elseif ($pm->opsi_pemohon == 'Internal') {
                $alamat = Pengguna::where('gocap_id_pc_pengurus', $pm->pemohon_internal)->value('alamat');
            } elseif ($pm->opsi_pemohon == 'Entitas') {
                $alamat =  $pm->alamat_entitas;
            }

            $sheet->setCellValue('E' . $ur, $alamat);
            $sheet->setCellValue('F' . $ur, 'Rp ' . number_format($pm->nominal_pengajuan, 0, '.', '.') . ',-');
            $sheet->setCellValue('G' . $ur, $pm->nama_asnaf);

            if ($pm->jenis_tanda_terima == 'lainnya') {
                $jenis_tanda_terima  = $pm->lainnya;
            } else {
                $jenis_tanda_terima  = $pm->jenis_tanda_terima;
            }

            $sheet->setCellValue('H' . $ur, $jenis_tanda_terima);
            $sheet->setCellValue('I' . $ur, $pm->pilar);
            $sheet->setCellValue('J' . $ur, $pm->nama_program);

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
            $sheet->getStyle('A' . $startRow . ':J' . $startRow)->applyFromArray($borderStyle); // Apply border style to the starting row
        }


        // Determine the last row in the sheet
        $lastRow = $sheet->getHighestRow();

        // Apply styles to each row individually
        for ($row = 1; $row <= $lastRow; $row++) {
            $range = 'A' . $row . ':J' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $sheet->getStyle($range)->applyFromArray($styleAll);
        }




        $tgls = $filter_daterange2;
        // Save the Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'REALISASI PENTASYARUFAN TINGKAT UPZIS BERDASARKAN PERSETUJUAN DIREKTUR DAN DIV. KEUANGAN' . $tgls . '.xlsx';
        $writer->save($filename);

        // Download the Excel file
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function excel_pc_laporan_realisasi_by_pilar_program($filter_daterange2, $status, $kategori, $pilar)
    {

        // dd('dw');
        $date_range = $filter_daterange2;
        // dd($date_range);    
        // dd($this->filter_daterange2);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange2 = $start_date . ' - ' . $end_date;
        $filter_daterange_new = $start_date . ' - ' . $end_date;



        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($pilar == 'Semua') {
            $this->pilar = NULL;
        } else {
            $this->pilar = $pilar;
        }

        if ($kategori == 'Semua') {
            $this->kategori = NULL;
        } else {
            $this->kategori = $kategori;
        }

        $datas = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.tgl_terbit_rekomendasi',

            )
            ->where('tingkat', 'PC')
            // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
            ->whereNotNull('pengajuan_detail.tgl_konfirmasi')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter periode
            ->when($filter_daterange2 != '', function ($query) use ($start_date, $end_date) {

                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date);
                    }
                });
            })
            // filter kategori
            ->when($this->kategori, function ($query) {
                return $query->where('sumber_dana', $this->kategori);
            })
            // filter pilar
            ->when($this->pilar, function ($query) {
                return $query->where('id_program_pilar', $this->pilar);
            })
            ->get();

            $programs = $datas->groupBy('pilar');
            $sum_pencairan = $datas->sum('nominal_pencairan');
            $sum_penerima = $datas->sum('jumlah_penerima');

        $startDate = \Carbon\Carbon::parse($start_date)
            ->locale('id')
            ->isoFormat('D MMMM Y');
        $endDate = \Carbon\Carbon::parse($end_date)
            ->locale('id')
            ->isoFormat('D MMMM Y');

        $nama_upzis = 'Semua';

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
                        $sheet->setCellValue('C' . $ur, $b->sumber_dana_opsi . ' - ' . Rekening::where('id_rekening', $b->id_rekening)->value('no_rekening'));
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


        $tgls = $filter_daterange2;
        // Save the Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'REALISASI PENTASYARUFAN TINGKAT PC BERDASARKAN PERSETUJUAN DIREKTUR DAN DIV. KEUANGAN' . $tgls . '.xlsx';
        $writer->save($filename);

        // Download the Excel file
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public static function get_nama_program($id_program_kegiatan)
    {
        $data = ProgramKegiatan::where('id_program_kegiatan', $id_program_kegiatan)->first();
        return $data->nama_program ?? '';
    }


    public function print_internal($filter_daterange, $status, $tujuan)
    {

        $date_range = $filter_daterange;
        // dd($this->filter_daterange);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange = $start_date . ' - ' . $end_date;


        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($tujuan == 'Semua') {
            $this->tujuan = NULL;
        } else {
            $this->tujuan = $tujuan;
        }


        $data = Internal::orderBy('created_at', 'DESC')
            // filter periode
            ->when($filter_daterange != '', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('tgl_pengajuan', '=', $start_date);
                    } else {
                        return $query->whereDate('tgl_pengajuan', '>=', $start_date)
                            ->whereDate('tgl_pengajuan', '<=', $end_date);
                    }
                });
            })

            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter tujuan
            ->when($this->tujuan, function ($query) {
                return $query->where('tujuan', $this->tujuan);
            })

            ->orderBy('created_at', 'ASC')
            ->get();

        // dd($data);


        $adaSetuju = count($data->where('approval_status', '=', 'Disetujui'));
        $adaCair = count($data->where('pencairan_status', '=', 'Berhasil Dicairkan'));
        $adaCount = count($data);

        $tingkat = 'Internal Lazisnu Cilacap';

        $pdf = PDF::loadview('print.pengajuan_internal', compact(
            'filter_daterange',
            'data',
            'tingkat',
            'status',
            'tujuan',
            'adaSetuju',
            'adaCair',
            'adaCount',

        ))
            ->setPaper('a4', 'landscape');;
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_INTERNAL_LAZISNU_CILACAP_PERIODE"' . strtoupper($filter_daterange) . '.pdf',
        ]);
    }

    public function print_internal_laporan($filter_daterange, $status, $tujuan)
    {

        $date_range = $filter_daterange;
        // dd($this->filter_daterange);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange = $start_date . ' - ' . $end_date;


        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($tujuan == 'Semua') {
            $this->tujuan = NULL;
        } else {
            $this->tujuan = $tujuan;
        }


        $data = Internal::orderBy('created_at', 'DESC')
            // filter periode
            ->when($filter_daterange != '', function ($query) use ($start_date, $end_date) {
                // filter bulan dan tahun for pengajuan_detail
                return $query->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    if ($start_date == $end_date) {
                        return $query->whereDate('tgl_pencairan', '=', $start_date);
                    } else {
                        return $query->whereDate('tgl_pencairan', '>=', $start_date)
                            ->whereDate('tgl_pencairan', '<=', $end_date);
                    }
                });
            })

            // filter status
            ->when($this->status, function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter tujuan
            ->when($this->tujuan, function ($query) {
                return $query->where('tujuan', $this->tujuan);
            })

            ->orderBy('created_at', 'ASC')
            ->get();

        // dd($data);


        $adaSetuju = count($data->where('approval_status', '=', 'Disetujui'));
        $adaCair = count($data->where('pencairan_status', '=', 'Berhasil Dicairkan'));
        $adaCount = count($data);

        $tingkat = 'Internal Lazisnu Cilacap';

        $pdf = PDF::loadview('print.pengajuan_internal', compact(
            'filter_daterange',
            'data',
            'tingkat',
            'status',
            'tujuan',
            'adaSetuju',
            'adaCair',
            'adaCount',

        ))
            ->setPaper('a4', 'landscape');;
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_INTERNAL_LAZISNU_CILACAP_PERIODE"' . strtoupper($filter_daterange) . '.pdf',
        ]);
    }

    public function print_internal_excel($filter_daterange, $status, $tujuan)
    {

        $date_range = $filter_daterange;
        // dd($this->filter_daterange);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange = $start_date . ' - ' . $end_date;


        $export = new PengajuanInternalExport($filter_daterange, $status, $tujuan);

        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($tujuan == 'Semua') {
            $this->tujuan = NULL;
        } else {
            $this->tujuan = $tujuan;
        }

        return Excel::download($export, 'Pengajuan Internal ' . $filter_daterange . ' | ' . $status . '| ' . $tujuan . '| .xlsx');


        // dd($status);

        // $this->bulan = $bulan;
        // $this->tahun = $tahun;



        // $data = Internal::orderBy('created_at', 'DESC')
        //     // filter periode
        //     ->when($this->bulan, function ($query) {
        //         return $query->whereMonth('tgl_pengajuan', $this->bulan);
        //     })
        //     // filter status
        //     ->when($this->status, function ($query) {
        //         return $query->where('approval_status', $this->status);
        //     })
        //     // filter tujuan
        //     ->when($this->tujuan, function ($query) {
        //         return $query->where('tujuan', $this->tujuan);
        //     })

        //     ->orderBy('created_at', 'ASC')
        //     ->get();

        // dd($data);



        // if ($bulan == '01') {
        //     $bulans = 'Januari';
        // } elseif ($bulan == '02') {
        //     $bulans = 'Februari';
        // } elseif ($bulan == '03') {
        //     $bulans = 'Maret';
        // } elseif ($bulan == '04') {
        //     $bulans = 'April';
        // } elseif ($bulan == '05') {
        //     $bulans = 'Mei';
        // } elseif ($bulan == '06') {
        //     $bulans = 'Juni';
        // } elseif ($bulan == '07') {
        //     $bulans = 'Juli';
        // } elseif ($bulan == '08') {
        //     $bulans = 'Agustus';
        // } elseif ($bulan == '09') {
        //     $bulans = 'September';
        // } elseif ($bulan == '10') {
        //     $bulans = 'Oktober';
        // } elseif ($bulan == '11') {
        //     $bulans = 'November';
        // } elseif ($bulan == '12') {
        //     $bulans = 'Desember';
        // }
        // $tingkat = 'Internal Lazisnu Cilacap';

        // $pdf = PDF::loadview('print.pengajuan_internal', compact(
        //     'bulan',
        //     'bulans',
        //     'data',
        //     'tahun',
        //     'tingkat',
        //     'status',
        //     'tujuan'

        // ))
        //     ->setPaper('a4', 'landscape');;
        // return $pdf->stream()->withHeaders([
        //     'Title' => 'Your meta title',
        //     'Content-Type' => 'application/pdf',
        //     'Cache-Control' => 'no-store, no-cache',
        //     'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_INTERNAL_LAZISNU_CILACAP_PERIODE"' . strtoupper($bulans) . '_' . $tahun . '.pdf',
        // ]);
    }


    public function print_internal_excel_laporan($filter_daterange, $status, $tujuan)
    {

        $date_range = $filter_daterange;
        // dd($this->filter_daterange);
        $start_date = null;
        $end_date = null;

        if (strpos($date_range, '+-+') !== false) {
            // Case where the date range is formatted with '+-+'
            $date_parts = explode("+-+", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        } else {
            // Case where the date range is formatted with ' - '
            $date_parts = explode(" - ", $date_range);
            $start_date = $date_parts[0];
            $end_date = $date_parts[1];
        }

        $filter_daterange = $start_date . ' - ' . $end_date;


        $export = new PengajuanInternalExport($filter_daterange, $status, $tujuan);

        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        if ($tujuan == 'Semua') {
            $this->tujuan = NULL;
        } else {
            $this->tujuan = $tujuan;
        }

        return Excel::download($export, 'Pengajuan Internal ' . $filter_daterange . ' | ' . $status . '| ' . $tujuan . '| .xlsx');


        // dd($status);

        // $this->bulan = $bulan;
        // $this->tahun = $tahun;



        // $data = Internal::orderBy('created_at', 'DESC')
        //     // filter periode
        //     ->when($this->bulan, function ($query) {
        //         return $query->whereMonth('tgl_pengajuan', $this->bulan);
        //     })
        //     // filter status
        //     ->when($this->status, function ($query) {
        //         return $query->where('approval_status', $this->status);
        //     })
        //     // filter tujuan
        //     ->when($this->tujuan, function ($query) {
        //         return $query->where('tujuan', $this->tujuan);
        //     })

        //     ->orderBy('created_at', 'ASC')
        //     ->get();

        // dd($data);



        // if ($bulan == '01') {
        //     $bulans = 'Januari';
        // } elseif ($bulan == '02') {
        //     $bulans = 'Februari';
        // } elseif ($bulan == '03') {
        //     $bulans = 'Maret';
        // } elseif ($bulan == '04') {
        //     $bulans = 'April';
        // } elseif ($bulan == '05') {
        //     $bulans = 'Mei';
        // } elseif ($bulan == '06') {
        //     $bulans = 'Juni';
        // } elseif ($bulan == '07') {
        //     $bulans = 'Juli';
        // } elseif ($bulan == '08') {
        //     $bulans = 'Agustus';
        // } elseif ($bulan == '09') {
        //     $bulans = 'September';
        // } elseif ($bulan == '10') {
        //     $bulans = 'Oktober';
        // } elseif ($bulan == '11') {
        //     $bulans = 'November';
        // } elseif ($bulan == '12') {
        //     $bulans = 'Desember';
        // }
        // $tingkat = 'Internal Lazisnu Cilacap';

        // $pdf = PDF::loadview('print.pengajuan_internal', compact(
        //     'bulan',
        //     'bulans',
        //     'data',
        //     'tahun',
        //     'tingkat',
        //     'status',
        //     'tujuan'

        // ))
        //     ->setPaper('a4', 'landscape');;
        // return $pdf->stream()->withHeaders([
        //     'Title' => 'Your meta title',
        //     'Content-Type' => 'application/pdf',
        //     'Cache-Control' => 'no-store, no-cache',
        //     'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_INTERNAL_LAZISNU_CILACAP_PERIODE"' . strtoupper($bulans) . '_' . $tahun . '.pdf',
        // ]);
    }


    public function print_ranting($bulan, $tahun, $status, $upzis, $ranting)
    {
        if ($status == 'Semua') {
            $this->status = NULL;
        } else {
            $this->status = $status;
        }

        $daftar_ranting = DB::table($this->etasyaruf . '.pengajuan')
            // ->leftjoin($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
            // filter status
            ->when($this->status, function ($query) {
                return $query->where('status_pengajuan', $this->status);
            })
            ->whereMonth('tgl_pengajuan', $bulan)
            ->whereYear('tgl_pengajuan', $tahun)
            ->where('tingkat', 'Ranting NU')
            ->where($this->etasyaruf . '.pengajuan.id_upzis', $upzis)
            ->leftJoin($this->gocap . '.ranting', $this->gocap . '.ranting.id_ranting', '=', $this->etasyaruf . '.pengajuan.id_ranting')
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.ranting.id_wilayah')
            ->select(
                $this->etasyaruf . '.pengajuan.id_upzis',
                $this->gocap . '.ranting.id_ranting',
                $this->siftnu . '.wilayah.*',
            )
            ->groupBy('nama')
            ->orderBy('nama', 'ASC')
            ->get();

        // dd($daftar_ranting);

        $this->bulan = $bulan;
        $this->tahun = $tahun;

        $datas = NULL;
        if ($ranting != 'Semua') {
            $datas = Pengajuan::orderBy('created_at', 'ASC')->where('tingkat', 'Ranting NU')
                // filter status
                ->when($this->status, function ($query) {
                    return $query->where('status_pengajuan', $this->status);
                })
                ->where('id_upzis', $upzis)
                ->where('id_ranting', $ranting)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->orderBy('pengajuan.created_at', 'ASC')
                ->get();
            // dd($datas);
        }

        if ($bulan == '01') {
            $bulans = 'Januari';
        } elseif ($bulan == '02') {
            $bulans = 'Februari';
        } elseif ($bulan == '03') {
            $bulans = 'Maret';
        } elseif ($bulan == '04') {
            $bulans = 'April';
        } elseif ($bulan == '05') {
            $bulans = 'Mei';
        } elseif ($bulan == '06') {
            $bulans = 'Juni';
        } elseif ($bulan == '07') {
            $bulans = 'Juli';
        } elseif ($bulan == '08') {
            $bulans = 'Agustus';
        } elseif ($bulan == '09') {
            $bulans = 'September';
        } elseif ($bulan == '10') {
            $bulans = 'Oktober';
        } elseif ($bulan == '11') {
            $bulans = 'November';
        } elseif ($bulan == '12') {
            $bulans = 'Desember';
        }
        $tingkat = 'PRNU';

        $pdf = PDF::loadview('print.pengajuan_ranting', compact(
            'bulan',
            'datas',
            'bulans',
            'tahun',
            'upzis',
            'daftar_ranting',
            'tingkat',
            'status',
            'ranting'

        ))
            ->setPaper('a4', 'landscape');;
        if ($ranting == 'Semua') {
            return $pdf->stream()->withHeaders([
                'Title' => 'Your meta title',
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_PRNU_PERIODE_' . strtoupper($bulans) . '_' . $tahun . '.pdf',
            ]);
        } else {
            return $pdf->stream()->withHeaders([
                'Title' => 'Your meta title',
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_PRNU_' . strtoupper($this->nama_ranting($ranting)) . '_PERIODE_' . strtoupper($bulans) . '_' . $tahun . '.pdf',
            ]);
        }
    }

    public static function nama_pengurus_pc($id)
    {
        $siftnu = config('app.database_siftnu');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)->first();
        return $a->nama;
    }
    
    public static function get_nama_pilar($id_pilar)
    {
        $data = ProgramPilar::where('id_program_pilar', $id_pilar)->first();

        return  $data->pilar ?? '';
    }

    public static function get_nama_kegiatan($id_kegiatan)
    {
        $data = ProgramKegiatan::where('id_program_kegiatan', $id_kegiatan)->first();

        return  $data->nama_program ?? '';
    }

    public static function nama_kategori($kategori)
    {
        // dd($kategori);
        $b = Programs::where('id_program', $kategori)->first();

        return  $b->program ?? '';
    }

    public static function nama_pilar($pilar)
    {
        // dd($pilar);
        $b = ProgramPilar::where('id_program_pilar', $pilar)->first();

        return  $b->pilar ?? '';
    }

    public static function nama_pilar2($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        $b = ProgramPilar::where('id_program_pilar', $a->id_program_pilar)->first();

        return  $b->pilar ?? '';
    }

    public static function nama_program($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        $b = ProgramKegiatan::where('id_program_kegiatan', $a->id_program_kegiatan)->first();

        return  $b->nama_program ?? '';
    }


    public static function hitung_jumlah_rencana($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->count();
        return $a;
    }

    public static function hitung_jumlah_rencana_per_upzis($upzis, $bulan, $tahun, $status)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($status == 'Semua') {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->whereNull('id_ranting')
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->count();
        } else {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->whereNull('id_ranting')
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->where('status_pengajuan', $status)
                ->count();
        }
        return $a;
    }

    public static function hitung_jumlah_rencana_per_ranting($upzis, $ranting, $bulan, $tahun, $status)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($status == 'Semua') {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->where('id_ranting', $ranting)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->count();
        } else {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->where('id_ranting', $ranting)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->where('status_pengajuan', $status)
                ->count();
        }
        return $a;
    }

    public static function hitung_nominal_pengajuan_per_upzis($upzis, $bulan, $tahun, $status)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($status == 'Semua') {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->whereNull('id_ranting')
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->sum('nominal_pengajuan');
        } else {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->whereNull('id_ranting')
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->where('status_pengajuan', $status)
                ->sum('nominal_pengajuan');
        }
        return $a;
    }

    public static function hitung_nominal_pengajuan_per_ranting($upzis, $ranting, $bulan, $tahun, $status)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($status == 'Semua') {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->where('id_ranting', $ranting)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->sum('nominal_pengajuan');
        } else {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->where('id_ranting', $ranting)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->where('status_pengajuan', $status)
                ->sum('nominal_pengajuan');
        }
        return $a;
    }

    public static function hitung_nominal_disetujui_per_upzis($upzis, $bulan, $tahun, $status)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($status == 'Semua') {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->whereNull('id_ranting')
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->sum('nominal_disetujui');
        } else {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->whereNull('id_ranting')
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->where('status_pengajuan', $status)
                ->sum('nominal_disetujui');
        }
        return $a;
    }

    public static function hitung_nominal_disetujui_per_ranting($upzis, $ranting, $bulan, $tahun, $status)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($status == 'Semua') {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->where('id_ranting', $ranting)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->sum('nominal_disetujui');
        } else {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->where('id_ranting', $ranting)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->where('status_pengajuan', $status)
                ->sum('nominal_disetujui');
        }
        return $a;
    }

    public static function hitung_nominal_pengajuan($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->sum('nominal_pengajuan');
        return $a;
    }

    public static function internal_hitung_nominal_pengajuan($id_internal)
    {
        $a = Internal::where('id_internal', $id_internal)->sum('nominal_pengajuan');
        return $a;
    }

    public static function hitung_nominal_pengajuan1($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('id_program', 'ba84d782-81a8-11ed-b4ef-dc215c5aad51')->sum('nominal_pengajuan');
        return $a;
    }
    public static function hitung_nominal_pengajuan2($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('id_program', 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51')->sum('nominal_pengajuan');
        return $a;
    }
    public static function hitung_nominal_pengajuan3($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('id_program', 'c51700b1-81a8-11ed-b4ef-dc215c5aad51')->sum('nominal_pengajuan');
        return $a;
    }

    public static function hitung_nominal_pengajuan_disetujui($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('approval_status', 'Disetujui')->sum('nominal_disetujui_pencairan_direktur');
        return $a;
    }

    public static function hitung_nominal_pengajuan_pencairan($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('approval_status', 'Disetujui')->sum('nominal_pencairan');
        return $a;
    }

    public static function internal_hitung_nominal_pengajuan_disetujui($id_internal)
    {
        $a = Internal::where('id_internal', $id_internal)->where('approval_status', 'Disetujui')->sum('nominal_disetujui');
        return $a;
    }

    public static function hitung_nominal_pengajuan_disetujui1($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('approval_status', 'Disetujui')->where('id_program', 'ba84d782-81a8-11ed-b4ef-dc215c5aad51')->sum('nominal_disetujui');
        return $a;
    }

    public static function hitung_nominal_pengajuan_disetujui2($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('approval_status', 'Disetujui')->where('id_program', 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51')->sum('nominal_disetujui');
        return $a;
    }

    public static function hitung_nominal_pengajuan_disetujui3($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('approval_status', 'Disetujui')->where('id_program', 'c51700b1-81a8-11ed-b4ef-dc215c5aad51')->sum('nominal_disetujui');
        return $a;
    }

    public static function hitung_jumlah_penerima($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->sum('jumlah_penerima');
        return $a;
    }

    public static function hitung_jumlah_penerima1($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('id_program', 'ba84d782-81a8-11ed-b4ef-dc215c5aad51')->sum('jumlah_penerima');
        return $a;
    }

    public static function hitung_jumlah_penerima2($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('id_program', 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51')->sum('jumlah_penerima');
        return $a;
    }

    public static function hitung_jumlah_penerima3($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('id_program', 'c51700b1-81a8-11ed-b4ef-dc215c5aad51')->sum('jumlah_penerima');
        return $a;
    }

    public static function hitung_jumlah_penerima_per_upzis($upzis, $bulan, $tahun, $status)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($status == 'Semua') {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->whereNull('id_ranting')
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->sum('jumlah_penerima');
        } else {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->whereNull('id_ranting')
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->where('status_pengajuan', $status)
                ->sum('jumlah_penerima');
        }
        return $a;
    }

    public static function hitung_jumlah_penerima_per_ranting($upzis, $ranting, $bulan, $tahun, $status)
    {
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($status == 'Semua') {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->where('id_ranting', $ranting)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->sum('jumlah_penerima');
        } else {
            $a = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('id_upzis', $upzis)
                ->where('id_ranting', $ranting)
                ->whereMonth('tgl_pengajuan', $bulan)
                ->whereYear('tgl_pengajuan', $tahun)
                ->where('status_pengajuan', $status)
                ->sum('jumlah_penerima');
        }
        return $a;
    }

    public static function nama_upzis($id)
    {

        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($gocap . '.upzis')->where('id_upzis', $id)
            ->join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
            ->select($siftnu . '.wilayah.nama as nama_upzis')
            ->first();
        return  $a->nama_upzis;
    }

    public static function nama_ranting($id)
    {

        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $a = DB::table($gocap . '.ranting')->where('id_ranting', $id)
            ->join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
            ->select($siftnu . '.wilayah.nama as nama_ranting')
            ->first();
        return  $a->nama_ranting;
    }
}
