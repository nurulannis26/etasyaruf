<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\Models\Pengajuan;
use App\Models\ProgramKegiatan;
use App\Models\Rekening;
use App\Models\Internal;
use App\Models\Program;
use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\PengajuanDetail;
use App\Models\ProgramPilar;
use App\Models\Programs;
// use App\Models\Program;
use PDF;
use Dompdf\Dompdf;
use iio\libmergepdf\Merger;

use App\Exports\PengajuanInternalExport;
use Maatwebsite\Excel\Facades\Excel;


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



    public function print_pc($bulan, $tahun, $status, $kategori, $pilar)
    {
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




        // dd($daftar_ranting);

        $this->bulan = $bulan;
        $this->tahun = $tahun;


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
            // filter bulan
            ->when($this->bulan, function ($query) {
                return $query->whereMonth('tgl_pengajuan', $this->bulan);
            })
            // filter tahun
            ->when($this->tahun, function ($query) {
                return $query->whereYear('tgl_pengajuan', $this->tahun);
            })
            // filter kategori
            ->when($this->kategori, function ($query) {
                return $query->where('sumber_dana', $this->kategori);
            })
            // filter pilar
            ->when($this->pilar, function ($query) {
                return $query->where('id_program_pilar', $this->pilar);
            })

            ->orderBy('pengajuan.created_at', 'ASC')
            ->get();

        // dd($data);



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
        $tingkat = 'Umum Lazisnu Cilacap';

        $pdf = PDF::loadview('print.pengajuan_pc', compact(
            'bulan',
            'bulans',
            'data',
            'tahun',
            'tingkat',
            'status',
            'kategori',
            'pilar'

        ))
            ->setPaper('a4', 'landscape');;
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_UMUM_LAZISNU_CILACAP_PERIODE"' . strtoupper($bulans) . '_' . $tahun . '.pdf',
        ]);
    }


    public function print_internal($bulan, $tahun, $status, $tujuan)
    {
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

        // dd($daftar_ranting);

        $this->bulan = $bulan;
        $this->tahun = $tahun;



        $data = Internal::orderBy('created_at', 'DESC')
            // filter periode
            ->when($this->bulan != 'Semua' && $this->bulan != '', function ($query) {
                return $query->whereMonth('tgl_pengajuan', $this->bulan);
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
        } else {
            $bulans = 'Semua';
        }
        $tingkat = 'Internal Lazisnu Cilacap';

        $pdf = PDF::loadview('print.pengajuan_internal', compact(
            'bulan',
            'bulans',
            'data',
            'tahun',
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
            'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_INTERNAL_LAZISNU_CILACAP_PERIODE"' . strtoupper($bulans) . '_' . $tahun . '.pdf',
        ]);
    }

    public function print_internals($bulan, $tahun, $status, $tujuan)
    {
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

        // dd($daftar_ranting);

        $this->bulan = $bulan;
        $this->tahun = $tahun;



        $data = Internal::orderBy('created_at', 'DESC')
            // filter periode
            ->when($this->bulan, function ($query) {
                return $query->whereMonth('tgl_pengajuan', $this->bulan);
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
        }elseif ($bulan == 'Semua') {
            $bulans = 'SEMUA BULAN';
        }
        $tingkat = 'Internal Lazisnu Cilacap';

        $pdf = PDF::loadview('print.pengajuan_internal', compact(
            'bulan',
            'bulans',
            'data',
            'tahun',
            'tingkat',
            'status',
            'tujuan'

        ))
            ->setPaper('a4', 'landscape');;
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="REKAP_PENGAJUAN_PENTASYARUFAN_TINGKAT_INTERNAL_LAZISNU_CILACAP_PERIODE"' . strtoupper($bulans) . '_' . $tahun . '.pdf',
        ]);
    }
    
    
    public function print_internal_excel($bulan, $tahun, $status, $tujuan)
    {
        $export = new PengajuanInternalExport($bulan, $tahun, $status, $tujuan);
        
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

        return Excel::download($export, 'Pengajuan Internal ' . $bulan . ' - ' . $tahun . ' | ' . $status . '| ' . $tujuan . '| .xlsx');


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
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('approval_status', 'Disetujui')->sum('nominal_disetujui');
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
