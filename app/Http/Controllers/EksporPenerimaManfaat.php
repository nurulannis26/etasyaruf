<?php

namespace App\Http\Controllers;

use TCPDF;
use Carbon\Carbon;
use App\Models\Upzis;
use App\Models\Ranting;
use App\Models\Wilayah;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\PengajuanDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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


class EksporPenerimaManfaat extends Controller
{

    public static function get_nama_ranting($id_ranting)
    {
        // dd($id_ranting);
        $data = Ranting::where('id_ranting', $id_ranting)->first();
        $wilayah = Wilayah::where('id_wilayah', $data->id_wilayah)->first();
        return $wilayah->nama ?? '';
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

    public function excel_umum_upzis_realisasi_penerima_manfaat($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {

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

        $datas_penerima_manfaat = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
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
        $sheet->setCellValue('D5', 'ALAMAT');
        $sheet->setCellValue('E5', 'NOMINAL BANTUAN ');
        $sheet->setCellValue('F5', 'ASNAF');
        $sheet->setCellValue('G5', 'JENIS BANTUAN');
        $sheet->setCellValue('H5', 'PILAR');
        $sheet->setCellValue('I5', 'JENIS PROGRAM');
        $sheet->setCellValue('J5', 'NIK');
        $sheet->setCellValue('K5', 'NO KK');
        $sheet->setCellValue('L5', 'NO HP');


        // Set column widths manually
        $columnWidths = [
            'A' => 5,
            'B' => 18,
            'C' => 25,
            'D' => 25,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 15,

        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Set background color for header row (row 5)
        $headerStyle = $sheet->getStyle('A5:L5');
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

        $sheet->getStyle('A5:L5')->applyFromArray($borderStyle); // Apply border style to header row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A5:L' . $lastRow)->applyFromArray($borderStyle); // Apply border style to the rest of the rows

        //container
        $ur = 6; // Assuming you start from row 6
        $no = 1; //start

        foreach ($penerima_manfaat as $pm) {

            $sheet->setCellValue('A' . $ur, $no++);
            $sheet->setCellValue('B' . $ur, Carbon::parse($pm->tgl_bantuan)->isoFormat('D MMMM Y'));
            $sheet->setCellValue('C' . $ur, $pm->nama);
            $sheet->setCellValue('D' . $ur, $pm->alamat);
            $sheet->setCellValue('E' . $ur, 'Rp ' . number_format($pm->nominal_bantuan, 0, '.', '.') . ',-');
            $sheet->setCellValue('F' . $ur, $pm->asnaf);
            $sheet->setCellValue('G' . $ur, $pm->jenis_bantuan);
            $sheet->setCellValue('H' . $ur, $pm->pilar);
            $sheet->setCellValue('I' . $ur, $pm->nama_program);
            $sheet->setCellValueExplicit('J' . $ur, $pm->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('K' . $ur, $pm->nokk, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('L' . $ur, $pm->nohp);

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
            $sheet->getStyle('A' . $startRow . ':L' . $startRow)->applyFromArray($borderStyle); // Apply border style to the starting row
        }


        // Determine the last row in the sheet
        $lastRow = $sheet->getHighestRow();

        // Apply styles to each row individually
        for ($row = 1; $row <= $lastRow; $row++) {
            $range = 'A' . $row . ':L' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
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

    public function pdf_umum_upzis_realisasi_penerima_manfaat($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
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

        // TabUpzis
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

        $datas_penerima_manfaat = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
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

        $pdf->AddPage('L');


        // Load and render the first view
        $html1 = view('print.pdf_umum_upzis_realisasi_penerima_manfaat', compact(
            'penerima_manfaat',
            'id_upzis',
            'id_upzis2',
            'id_ranting2',
            'filter_daterange',
            'sub',
            'tings',
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

    public function excel_umum_ranting_realisasi_penerima_manfaat($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {

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

        // TabRanting
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

        $datas_penerima_manfaat_ranting = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
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


        $penerima_manfaat = $datas_penerima_manfaat_ranting->get();

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


        // Set cell value
        $sheet->setCellValue('A5', 'NO');
        $sheet->setCellValue('B5', 'TANGGAL');
        $sheet->setCellValue('C5', 'NAMA');
        $sheet->setCellValue('D5', 'ALAMAT');
        $sheet->setCellValue('E5', 'NOMINAL BANTUAN ');
        $sheet->setCellValue('F5', 'ASNAF');
        $sheet->setCellValue('G5', 'JENIS BANTUAN');
        $sheet->setCellValue('H5', 'PILAR');
        $sheet->setCellValue('I5', 'JENIS PROGRAM');
        $sheet->setCellValue('J5', 'NIK');
        $sheet->setCellValue('K5', 'NO KK');
        $sheet->setCellValue('L5', 'NO HP');


        // Set column widths manually
        $columnWidths = [
            'A' => 5,
            'B' => 18,
            'C' => 25,
            'D' => 25,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 15,

        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Set background color for header row (row 5)
        $headerStyle = $sheet->getStyle('A5:L5');
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

        $sheet->getStyle('A5:L5')->applyFromArray($borderStyle); // Apply border style to header row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A5:L' . $lastRow)->applyFromArray($borderStyle); // Apply border style to the rest of the rows

        //container
        $ur = 6; // Assuming you start from row 6
        $no = 1; //start

        foreach ($penerima_manfaat as $pm) {

            $sheet->setCellValue('A' . $ur, $no++);
            $sheet->setCellValue('B' . $ur, Carbon::parse($pm->tgl_bantuan)->isoFormat('D MMMM Y'));
            $sheet->setCellValue('C' . $ur, $pm->nama);
            $sheet->setCellValue('D' . $ur, $pm->alamat);
            $sheet->setCellValue('E' . $ur, 'Rp ' . number_format($pm->nominal_bantuan, 0, '.', '.') . ',-');
            $sheet->setCellValue('F' . $ur, $pm->asnaf);
            $sheet->setCellValue('G' . $ur, $pm->jenis_bantuan);
            $sheet->setCellValue('H' . $ur, $pm->pilar);
            $sheet->setCellValue('I' . $ur, $pm->nama_program);
            $sheet->setCellValueExplicit('J' . $ur, $pm->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('K' . $ur, $pm->nokk, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('L' . $ur, $pm->nohp);

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
            $sheet->getStyle('A' . $startRow . ':L' . $startRow)->applyFromArray($borderStyle); // Apply border style to the starting row
        }


        // Determine the last row in the sheet
        $lastRow = $sheet->getHighestRow();

        // Apply styles to each row individually
        for ($row = 1; $row <= $lastRow; $row++) {
            $range = 'A' . $row . ':L' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
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

    public function pdf_umum_ranting_realisasi_penerima_manfaat($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
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

        $datas_penerima_manfaat_ranting = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
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


        $penerima_manfaat = $datas_penerima_manfaat_ranting->get();

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

        $pdf->AddPage('L');


        // Load and render the first view
        $html1 = view('print.pdf_umum_upzis_realisasi_penerima_manfaat', compact(
            'penerima_manfaat',
            'id_upzis',
            'id_upzis2',
            'id_ranting2',
            'filter_daterange',
            'sub',
            'tings',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');


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


    public function excel_umum_keseluruhan_realisasi_penerima_manfaat($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {

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

        // TabRanting
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

        $datas_penerima_manfaat_ranting = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
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


        $penerima_manfaat = $datas_penerima_manfaat_ranting->get();

        // Create a new Excel instance
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $nama_upzis = strtoupper(EksporPenerimaManfaat::get_nama_upzis($id_upzis2));
        // Set cell values and merge cells
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'DATA REALISASI PENERIMA MANFAAT PER WILAYAH KECAMATAN ' . $nama_upzis);
        $sheet->getStyle('A2:H2')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', ' BERDASARKAN INPUT PENERIMA MANFAAT SAAT PENGAJUAN DAN LPJ');
        $sheet->getStyle('A3:H3')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally


        // Set cell value
        $sheet->setCellValue('A5', 'NO');
        $sheet->setCellValue('B5', 'TANGGAL');
        $sheet->setCellValue('C5', 'NAMA');
        $sheet->setCellValue('D5', 'ALAMAT');
        $sheet->setCellValue('E5', 'NOMINAL BANTUAN ');
        $sheet->setCellValue('F5', 'ASNAF');
        $sheet->setCellValue('G5', 'JENIS BANTUAN');
        $sheet->setCellValue('H5', 'PILAR');
        $sheet->setCellValue('I5', 'JENIS PROGRAM');
        $sheet->setCellValue('J5', 'NIK');
        $sheet->setCellValue('K5', 'NO KK');
        $sheet->setCellValue('L5', 'NO HP');


        // Set column widths manually
        $columnWidths = [
            'A' => 5,
            'B' => 18,
            'C' => 25,
            'D' => 25,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 15,

        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Set background color for header row (row 5)
        $headerStyle = $sheet->getStyle('A5:L5');
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

        $sheet->getStyle('A5:L5')->applyFromArray($borderStyle); // Apply border style to header row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A5:L' . $lastRow)->applyFromArray($borderStyle); // Apply border style to the rest of the rows

        //container
        $ur = 6; // Assuming you start from row 6
        $no = 1; //start

        foreach ($penerima_manfaat as $pm) {

            $sheet->setCellValue('A' . $ur, $no++);
            $sheet->setCellValue('B' . $ur, Carbon::parse($pm->tgl_bantuan)->isoFormat('D MMMM Y'));
            $sheet->setCellValue('C' . $ur, $pm->nama);
            $sheet->setCellValue('D' . $ur, $pm->alamat);
            $sheet->setCellValue('E' . $ur, 'Rp ' . number_format($pm->nominal_bantuan, 0, '.', '.') . ',-');
            $sheet->setCellValue('F' . $ur, $pm->asnaf);
            $sheet->setCellValue('G' . $ur, $pm->jenis_bantuan);
            $sheet->setCellValue('H' . $ur, $pm->pilar);
            $sheet->setCellValue('I' . $ur, $pm->nama_program);
            $sheet->setCellValueExplicit('J' . $ur, $pm->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('K' . $ur, $pm->nokk, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('L' . $ur, $pm->nohp);

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
            $sheet->getStyle('A' . $startRow . ':L' . $startRow)->applyFromArray($borderStyle); // Apply border style to the starting row
        }


        // Determine the last row in the sheet
        $lastRow = $sheet->getHighestRow();

        // Apply styles to each row individually
        for ($row = 1; $row <= $lastRow; $row++) {
            $range = 'A' . $row . ':L' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $sheet->getStyle($range)->applyFromArray($styleAll);
        }




        $tgls = $filter_daterange;
        $nama_upzis = strtoupper(EksporPenerimaManfaat::get_nama_upzis($id_upzis2));
        // Save the Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'DATA REALISASI PENERIMA MANFAAT PER WILAYAH KECAMATAN ' . $nama_upzis . ' BERDASARKAN INPUT PENERIMA MANFAAT SAAT PENGAJUAN DAN LPJ PERIODE' . $tgls . '.xlsx';
        $writer->save($filename);

        // Download the Excel file
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function excel_umum_gabungan_realisasi_penerima_manfaat($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {

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

        // TabRanting
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
                'pengajuan.tingkat',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
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


        $penerima_manfaat = $datas_penerima_manfaat_keseluruhan->get();


        $datas_penerima_manfaat_keseluruhan2 = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftjoin('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftjoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima', 'pengajuan_penerima.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.tgl_terbit_rekomendasi',
                'pengajuan_penerima.*',
                'asnaf.*',
                'pengajuan.id_ranting',
                'pengajuan.tingkat',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->WhereNull('pengajuan_detail.tgl_konfirmasi')->where('tingkat', 'PC');
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($start_date2, $end_date2) {
                return $query->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                    if ($start_date2 == $end_date2) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date2);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date2)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date2);
                    }
                });
            })

            ->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {

                return $query->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                    if ($start_date2 == $end_date2) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date2);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date2)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date2);
                    }
                })->latest('tgl_terbit_rekomendasi');
            })
            ->WhereNotNull('pengajuan_detail.tgl_konfirmasi')->where('tingkat', 'PC');


        $penerima_manfaat2 = $datas_penerima_manfaat_keseluruhan2->get();

        // Create a new Excel instance
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $nama_upzis = strtoupper(EksporPenerimaManfaat::get_nama_upzis($id_upzis2));
        // Set cell values and merge cells
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'DATA REALISASI PENERIMA MANFAAT KESELURUHAN (PC LAZISNU, UPZIS,RANTING)');
        $sheet->getStyle('A2:H2')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', ' BERDASARKAN INPUT PENERIMA MANFAAT SAAT PENGAJUAN DAN LPJ');
        $sheet->getStyle('A3:H3')->getFont()->setBold(true); // Make text bold
        $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Center horizontally


        // Set cell value
        $sheet->setCellValue('A5', 'NO');
        $sheet->setCellValue('B5', 'TANGGAL');
        $sheet->setCellValue('C5', 'NAMA');
        $sheet->setCellValue('D5', 'ALAMAT');
        $sheet->setCellValue('E5', 'NOMINAL BANTUAN ');
        $sheet->setCellValue('F5', 'ASNAF');
        $sheet->setCellValue('G5', 'JENIS BANTUAN');
        $sheet->setCellValue('H5', 'PILAR');
        $sheet->setCellValue('I5', 'JENIS PROGRAM');
        $sheet->setCellValue('J5', 'NIK');
        $sheet->setCellValue('K5', 'NO KK');
        $sheet->setCellValue('L5', 'NO HP');


        // Set column widths manually
        $columnWidths = [
            'A' => 5,
            'B' => 18,
            'C' => 25,
            'D' => 25,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 15,

        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Set background color for header row (row 5)
        $headerStyle = $sheet->getStyle('A5:L5');
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

        $sheet->getStyle('A5:L5')->applyFromArray($borderStyle); // Apply border style to header row
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A5:L' . $lastRow)->applyFromArray($borderStyle); // Apply border style to the rest of the rows

        //container
        $ur = 6; // Assuming you start from row 6
        $no = 1; //start

        foreach ($penerima_manfaat as $pm) {

            $sheet->setCellValue('A' . $ur, $no++);
            $sheet->setCellValue('B' . $ur, Carbon::parse($pm->tgl_bantuan)->isoFormat('D MMMM Y'));
            $sheet->setCellValue('C' . $ur, $pm->nama);
            $sheet->setCellValue('D' . $ur, $pm->alamat);
            $sheet->setCellValue('E' . $ur, 'Rp ' . number_format($pm->nominal_bantuan, 0, '.', '.') . ',-');
            $sheet->setCellValue('F' . $ur, $pm->asnaf);
            $sheet->setCellValue('G' . $ur, $pm->jenis_bantuan);
            $sheet->setCellValue('H' . $ur, $pm->pilar);
            $sheet->setCellValue('I' . $ur, $pm->nama_program);
            $sheet->setCellValueExplicit('J' . $ur, $pm->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('K' . $ur, $pm->nokk, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('L' . $ur, $pm->nohp);

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
            $sheet->getStyle('A' . $startRow . ':L' . $startRow)->applyFromArray($borderStyle); // Apply border style to the starting row
        }

        $ur = $penerima_manfaat->count() + 6;
        $no = $penerima_manfaat->count();

        foreach ($penerima_manfaat2 as $pm2) {

            $sheet->setCellValue('A' . $ur, $no++);
            $sheet->setCellValue('B' . $ur, Carbon::parse($pm2->tgl_bantuan)->isoFormat('D MMMM Y'));
            $sheet->setCellValue('C' . $ur, $pm2->nama);
            $sheet->setCellValue('D' . $ur, $pm2->alamat);
            $sheet->setCellValue('E' . $ur, 'Rp ' . number_format($pm2->nominal_bantuan, 0, '.', '.') . ',-');
            $sheet->setCellValue('F' . $ur, $pm2->asnaf);
            $sheet->setCellValue('G' . $ur, $pm2->jenis_bantuan);
            $sheet->setCellValue('H' . $ur, $pm2->pilar);
            $sheet->setCellValue('I' . $ur, $pm2->nama_program);
            $sheet->setCellValueExplicit('J' . $ur, $pm2->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('K' . $ur, $pm2->nokk, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('L' . $ur, $pm2->nohp);

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
            $sheet->getStyle('A' . $startRow . ':L' . $startRow)->applyFromArray($borderStyle); // Apply border style to the starting row
        }



        // Determine the last row in the sheet
        $lastRow = $sheet->getHighestRow();

        // Apply styles to each row individually
        for ($row = 1; $row <= $lastRow; $row++) {
            $range = 'A' . $row . ':L' . $row;

            $styleAll = [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $sheet->getStyle($range)->applyFromArray($styleAll);
        }




        $tgls = $filter_daterange;
        $nama_upzis = strtoupper(EksporPenerimaManfaat::get_nama_upzis($id_upzis2));
        // Save the Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'DATA REALISASI PENERIMA MANFAAT KESELURUHAN (PC LAZISNU, UPZIS,RANTING) BERDASARKAN INPUT PENERIMA MANFAAT SAAT PENGAJUAN DAN LPJ PERIODE' . $tgls . '.xlsx';
        $writer->save($filename);

        // Download the Excel file
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function pdf_umum_keseluruhan_realisasi_penerima_manfaat($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
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

        $datas_penerima_manfaat_ranting = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
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


        $penerima_manfaat = $datas_penerima_manfaat_ranting->get();

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

        $pdf->AddPage('L');


        // Load and render the first view
        $html1 = view('print.pdf_umum_upzis_realisasi_penerima_manfaat', compact(
            'penerima_manfaat',
            'id_upzis',
            'id_upzis2',
            'filter_daterange',
            'sub',
            'tings',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $nama_upzis = strtoupper(EksporPenerimaManfaat::get_nama_upzis($id_upzis2));
        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT KESELURUHAN (PC LAZISNU, UPZIS,RANTING) BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = 'DATA REALISASI PENERIMA MANFAAT PER WILAYAH KECAMATAN ' . $nama_upzis . ' BERDASARKAN INPUT PENERIMA MANFAAT SAAT PENGAJUAN DAN LPJ PERIODE ' . $new_date_range . '.pdf';
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

    public function pdf_umum_gabungan_realisasi_penerima_manfaat($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
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
                'pengajuan.tingkat',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
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


        $penerima_manfaat = $datas_penerima_manfaat_keseluruhan->get();


        $datas_penerima_manfaat_keseluruhan2 = PengajuanDetail::leftjoin('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->leftjoin('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->leftjoin('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->join('pengajuan_penerima', 'pengajuan_penerima.id_pengajuan_detail', '=', 'pengajuan_detail.id_pengajuan_detail')
            ->leftjoin('asnaf', 'asnaf.id_asnaf', '=', 'pengajuan_detail.id_asnaf')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.tgl_terbit_rekomendasi',
                'pengajuan_penerima.*',
                'asnaf.*',
                'pengajuan.id_ranting',
                'pengajuan.tingkat',

            )
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->WhereNull('pengajuan_detail.tgl_konfirmasi')->where('tingkat', 'PC');
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($start_date2, $end_date2) {
                return $query->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                    if ($start_date2 == $end_date2) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date2);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date2)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date2);
                    }
                });
            })

            ->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {

                return $query->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                    if ($start_date2 == $end_date2) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date2);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date2)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date2);
                    }
                })->latest('tgl_terbit_rekomendasi');
            })
            ->WhereNotNull('pengajuan_detail.tgl_konfirmasi')->where('tingkat', 'PC');


        $penerima_manfaat2 = $datas_penerima_manfaat_keseluruhan2->get();


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

        $pdf->AddPage('L');


        // Load and render the first view
        $html1 = view('print.pdf_umum_gabungan_realisasi_penerima_manfaat', compact(
            'penerima_manfaat',
            'penerima_manfaat2',
            'id_upzis',
            'id_upzis2',
            'filter_daterange',
            'sub',
            'tings',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html1, true, false, true, false, '');

        $nama_upzis = strtoupper(EksporPenerimaManfaat::get_nama_upzis($id_upzis2));
        $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT KESELURUHAN (PC LAZISNU, UPZIS,RANTING) BERDASARKAN INPUT PENERIMA MANFAAT SAAT PENGAJUAN DAN LPJ PERIODE ' . $new_date_range . '.pdf';
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
}
