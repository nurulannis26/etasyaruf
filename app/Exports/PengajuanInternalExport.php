<?php

namespace App\Exports;

use App\Models\Internal;
use App\Models\Pengguna;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;

class PengajuanInternalExport implements FromCollection,  WithColumnFormatting,  WithCustomStartCell, WithDrawings, ShouldAutoSize, WithStyles
{
    use Exportable;
    protected $filter_daterange;
    protected $status;
    protected $tujuan;
    
    public function __construct($filter_daterange, $status, $tujuan)
    {

        $this->filter_daterange = $filter_daterange;
        $this->status = $status;
        $this->tujuan = $tujuan;
        
    }
    // public function styles(Worksheet $sheet)
    // {
    //     return [
    //         'borders' => [
    //             'outline' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
    //                 'color' => ['argb' => 'FFFF0000'],
    //             ],
    //         ],
    //     ];
    // }
    public $sheet;

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('C2:D2');
        $sheet->mergeCells('C3:D3');

        $anu = 9 + $this->adaCount;
        $kolom = 'A9:S' . $anu;
        return [
            // Merge sel D4:G4
            // 'D4:G4' => [
            //     'merge' => true,
            // ],

            '4:4' => [
                'merge' => ['columns' => ['D', 'G']],
            ],
            // Contoh pengaturan border pada sel D4:G4
            $kolom => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('lazisnu');
        $drawing->setPath(public_path('images/logo_lazisnu.png'));
        $drawing->setHeight(70);
        $drawing->setCoordinates('A1');

        $drawing2 = new Drawing();
        $drawing2->setName('Other image');
        $drawing2->setDescription('siftnu');
        $drawing2->setPath(public_path('images/siftnu.png'));
        $drawing2->setHeight(70);
        $drawing2->setCoordinates('F1');

        return [$drawing, $drawing2];
    }
    public function startCell(): string
    {
        return 'A1';
    }

    public function dateTime($date)
    {
        $dateValue = new \DateTime($date);
        return $dateValue;
    }

    public $adaCair;
    public $adaSetuju;

    public function collection()
    {
    
        $date_range = $this->filter_daterange;
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
            ->when($this->status != 'Semua', function ($query) {
                return $query->where('approval_status', $this->status);
            })
            // filter tujuan
            ->when($this->tujuan != 'Semua', function ($query) {
                return $query->where('tujuan', $this->tujuan);
            })

            ->orderBy('created_at', 'ASC')
            ->get();

        // dd();

        $datas = [];
        foreach ($data as  $key => $d) {
            $datas[] = [
                $key + 1,
                $d->nomor_surat,
                $d->tgl_pencairan != null ? 'FPPD berhasil diajukan' : 'FPPD belum selesai diajukan',
                $d->nominal_pengajuan,
                Date::dateTimeToExcel($this->dateTime($d->tgl_pencairan)),
                Pengguna::where('gocap_id_pc_pengurus', $d->maker_tingkat_pc)->first()->nama,
                $d->approval_status_divpro == 'Disetujui' ?
                    'Disposisi Diterima Div. Program' :
                    'Disposisi Blm Diterima Div. Program',
                Date::dateTimeToExcel($this->dateTime($d->tgl_tenggat)),
                $d->tujuan,
                $d->note,


                $d->approval_status_divpro == 'Disetujui' ?
                    (
                        $d->approval_status == 'Belum Direspon' ?
                        'Pengajuan blm disetujuiDirektur' : (
                            $d->approval_status == 'Disetujui' ?
                            'Pengajuan disetujui Direktur' :
                            'Pengajuan ditolak Direktur'
                        )
                    ) : 'Blm Disetujui',
                $d->approval_status == 'Disetujui' ? Date::dateTimeToExcel($this->dateTime($d->approval_date)) : '',
                $d->nominal_disetujui,
                $d->approval_note ?? '-',

                $d->approval_status == 'Disetujui' ?
                    (
                        $d->pencairan_status == 'Belum Dicairkan' ?
                        'Pencairan blm disetujui Div. Keuangan' :
                        'Pencairan disetujui Div. Keuangan'
                    ) : 'Blm Disetujui',
                $d->pencairan_status == 'Berhasil Dicairkan' ?
                    Date::dateTimeToExcel($this->dateTime($d->approval_date)) : '',
                $d->nominal_pencairan,
                $d->pencairan_note,
            ];
        }

        // dd($datas[0][11]);
        $this->adaSetuju = count($data->where('approval_status', '=', 'Disetujui'));
        $this->adaCair = count($data->where('pencairan_status', '=', 'Berhasil Dicairkan'));

        $this->adaCount = count($datas);
        // dd(count($datas));

        // Retrieve your data and return it as a collection
        return collect([
            [''],
            ['', '', 'PENGAJUAN INTERNAL LAZISNU CILACAP'],
            ['', '', 'PERIODE ' . $filter_daterange],
            [''],
            ['', 'Total Diajukan : ' . $this->adaCount],
            ['', 'Total Disetujui : ' . $this->adaSetuju],
            ['', 'Total Dicairkan : ' . $this->adaCair],
            [''],
            [
                'NO',
                'Nomor Pengajuan',
                'Status Pengajuan',
                'Nominal Pengajuan',
                'Tgl Pengajuan',
                'Diajukan Oleh',

                'Status Aproval Div. Program',
                'Tgl Tenggat',
                'Tujuan',
                'Note',

                'Status Persetujuan',
                'Tgl Persetujuan',
                'Nominal Disetujui',
                'Catatan Persetujuan Pengajuan',

                'Status Pencairan',
                'Tgl Pencairan',
                'Nominal Pencairan',
                'Catatan Pencairan'
            ],
            $datas
            // Add more rows as needed
        ]);
    }

    public $adaCount;

    // public function headings(): array
    // {
    //     return [
    //         'NO',
    //         'Nomor Pengajuan',
    //         'Status Pengajuan',
    //         'Nominal Pengajuan',
    //         'Tgl Pengajuan',
    //         'Diajukan Oleh',

    //         'Status Aproval Div. Program',
    //         'Tgl Tenggat',
    //         'Tujuan',
    //         'Note',

    //         'Status Persetujuan',
    //         'Tgl Persetujuan',
    //         'Nominal Disetujui',
    //         'Catatan Persetujuan Pengajuan',

    //         'Status Pencairan',
    //         'Tgl Pencairan',
    //         'Nominal Pencairan',
    //         'Catatan Pencairan'
    //     ];
    // }
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'P' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'M' => NumberFormat::FORMAT_ACCOUNTING_IDR,
            'Q' => NumberFormat::FORMAT_ACCOUNTING_IDR,
        ];
    }
}
