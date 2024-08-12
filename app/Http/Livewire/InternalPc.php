<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Internal;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Http\Controllers\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InternalPc extends Component
{
    // database
    public $gocap;
    public $etasyaruf;
    public $siftnu;
    public $filter_daterange;
    public $filter_status;
    public $tahun_pengajuan;
    public $cari;
    public $filter_tujuan;
    public $page_number = 5;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama_pc;
    public $nomor_surat;
    public $tgl_pengajuan;
    public $tgl_tenggat;
    public $tujuan;
    public $bentuk;
    public $atas_nama;
    public $bank_tujuan;
    public $no_rek_tujuan;
    public $note;
    public $nominal_pengajuan;

    public $c_filter_daterange;
    public $c_filter_status;
    public $c_filter_tujuan;
    public $filter_internal;

    public $sub;

    public function mount()
    {
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');
        $this->tgl_pengajuan = date('Y-m-d');


        if ($this->filter_internal == 'on') {

            $this->filter_daterange =  $this->c_filter_daterange;
            $this->filter_status =  $this->c_filter_status;
            $this->filter_tujuan =  $this->c_filter_tujuan;
        } else {
            $currentMonthStartDate = date('Y-m-01');
            $currentMonthEndDate = date('Y-m-t');
            
            $this->filter_daterange = $currentMonthStartDate . '+-+' . $currentMonthEndDate;
            
        }
    }


    public function render()
    {
      
        $date_range = $this->filter_daterange;
        // dd($date_range);    
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



        // dd($this->filter_bulan);
        // dd($this->sub);
        // nama pc
        $n = DB::table($this->gocap . '.pc')->where('id_pc', Auth::user()->PcPengurus->Pc->id_pc)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.pc.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_pc')
            ->first();
        $this->nama_pc = 'NU Care Lazisnu ' . str_replace('KAB.', '', $n->nama_pc);

        $this->tahun_pengajuan = Internal::
            // filter upzis
            selectRaw('YEAR(tgl_pengajuan) as tahun')->groupBy('tahun')->orderBy('tgl_pengajuan', 'ASC')->get();

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
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter tujuan
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            ->get();

        // cari 
        // ->when($this->cari, function ($query) {
        //     return $query->where(function ($subQuery) {
        //         $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%');

        //         if ($this->filter_bulan !== 'Semua') {
        //             $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
        //         }
        //     })->orWhere(function ($subQuery) {
        //         $subQuery->where('note', 'like', '%' . $this->cari . '%');

        //         if ($this->filter_bulan !== 'Semua') {
        //             $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
        //         }
        //     })->orWhere(function ($subQuery) {
        //         $subQuery->whereExists(function ($existsSubQuery) {
        //             $existsSubQuery->select(DB::raw(1))
        //                 ->from($this->siftnu . '.pengguna')
        //                 ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'internal.maker_tingkat_pc')
        //                 ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
        //         });

        //         if ($this->filter_bulan !== 'Semua') {
        //             $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
        //         }
        //     });
        // })
        // ->latest()
        // ->paginate($this->page_number);

        $this->updatingSearch();

        $pengajuan_total = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter tujuan
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            
            ->count();

        $total_nominal = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter tujuan
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            

            ->sum('nominal_pengajuan');

        $total_nominal_disetujui = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter tujuan
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            

            ->sum('nominal_disetujui');


        $detail_tujuan = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter tujuan
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            
            ->get();

        $uang_muka =  $detail_tujuan->where('tujuan', 'Uang Muka')->count();
        $reimbursement = $detail_tujuan->where('tujuan', 'Reimbursement')->count();
        $pembayaran = $detail_tujuan->where('tujuan', 'Pembayaran')->count();
        $lainnya = $detail_tujuan->where('tujuan', 'Lainnya')->count();

        $disetujui_direktur = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter tujuan
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            ->where('approval_status', 'Disetujui')
            ->sum('nominal_disetujui');

        $acc_direktur = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
           // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            ->where('approval_status', 'Disetujui')
            ->count();

        $belum_direktur = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter status
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            ->where('approval_status', 'Belum Direspon')
            ->count();

        $tolak_direktur = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter status
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            ->where('approval_status', 'Ditolak')
            ->count();

        $disetujui_keuangan = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter tujuan
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->sum('nominal_disetujui');

        $acc_keuangan = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter status
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->count();

        $belum_keuangan = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter status
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            ->where('pencairan_status', 'Belum Dicairkan')->where('approval_status', '!=', 'Ditolak')
            ->count();

        $tolak_keuangan = Internal::orderBy('created_at', 'DESC')
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
            ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                return $query->where('tujuan', $this->filter_tujuan);
            })
            // filter status
            ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    if ($this->filter_status == 'Berhasil Dicairkan') {
                        return $query->where('pencairan_status', $this->filter_status);
                    } else {
                        return $query->where('approval_status', $this->filter_status);
                    }
                })
            // filter berdasarkan peran pengguna
            ->when(!in_array(Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan, [
                '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3',
                '694f38af-5374-11ed-882e-e4a8df91d8b3',
                '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'
            ]), function ($query) {
                return $query->where('maker_tingkat_pc', Auth::user()->gocap_id_pc_pengurus);
            })
            ->where('pencairan_status', 'Ditolak Dicairkan')
            ->count();
        // dd($tolak_keuangan);

        return view('livewire.internal-pc', compact(
            'data',
            'pengajuan_total',
            'total_nominal',
            'total_nominal_disetujui',
            'detail_tujuan',
            'uang_muka',
            'reimbursement',
            'pembayaran',
            'lainnya',
            'disetujui_direktur',
            'disetujui_keuangan',
            'acc_direktur',
            'belum_direktur',
            'tolak_direktur',
            'acc_keuangan',
            'belum_keuangan',
            'tolak_keuangan',
            'start_date',
            'end_date',
            'filter_daterange'
        ));
    }

    public static function getTanggalTerakhir(int $bulan, int $tahun)
    {
        return date("d", strtotime('-1 second', strtotime('+1 month', strtotime($bulan . '/01/' . $tahun . ' 00:00:00'))));
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function reset_filter_internal_pc()
    {
    
        $this->filter_daterange = $this->filter_daterange;
        $this->filter_tujuan = NULL;
        $this->filter_status = NULL;
    }

    public function hydrate()
    {
        $this->emit('loadContactDeviceSelect2');
    }



    public function modal_internal_pc_tambah()
    {
        $b = Internal::where('id_pc', Auth::user()->PcPengurus->Pc->id_pc)
            ->whereYear('created_at', date('Y'))->latest()->first();

        if ($b == NULL) {
            $urut = 0;
        } else {
            $string = $b->nomor_surat;
            
            // Cari posisi dari karakter '/'
            $pos = strpos($string, '/INTERNAL-PC');

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

        if (($urut + 1) < 10) {
            $this->nomor_surat = '0' . $urut + 1 . '/' . 'INTERNAL-PC' . '/' . str_replace('KAB. ', '', Auth::user()->PcPengurus->Pc->Wilayah->nama) . '/' . $romawi . '/' . date('Y');
        } else {
            $this->nomor_surat = $urut + 1 . '/' . 'INTERNAL-PC' . '/' . str_replace('KAB. ', '', Auth::user()->PcPengurus->Pc->Wilayah->nama)  . '/' . $romawi . '/' . date('Y');
        }
    }

    public $redirectTo;
    // public function hapus_internal()
    // {
    //     // return redirect()->back();
    //     // return redirect('pc/internalpc-pc')
    //     //              ->with('success', 'Pengajuan Internal Berhasil Dihapus');
    //     $this->redirectTo = 'internalpc-pc';
    //     // $this->dispatchBrowserEvent('success', ['message' => 'Pengajuan Internal Berhasil Dihapus']);
    //     session()->flash('success_message', 'Pengajuan Internal Berhasil Dihapus');
    // }


    public $keterangan_ppd;

    public function tambah_internal_pc()
    {
        $id_internal = Str::uuid();
        Internal::create([
            'id_internal' => $id_internal,
            'nomor_surat' => $this->nomor_surat,
            'tgl_pengajuan' => $this->tgl_pengajuan,
            'tgl_tenggat' => $this->tgl_tenggat,
            'tujuan' => $this->tujuan,

            'nominal_pengajuan' => str_replace('.', '', $this->nominal_pengajuan),
            'note' => $this->note,
            'bentuk' => $this->bentuk,
            'atas_nama' => $this->atas_nama,
            'bank_tujuan' => $this->bank_tujuan,
            'no_rek_tujuan' => $this->no_rek_tujuan,
            'keterangan_ppd' => $this->keterangan_ppd,
            'approval_status' => 'Belum Direspon',
            'pencairan_status' => 'Belum Dicairkan',
            'id_pc' =>  Auth::user()->PcPengurus->Pc->id_pc,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-internal-pc/" . "$id_internal";
        // $url =  "https://e-tasyaruf.nucarecilacap.id";

        $this->notif(
             Helper::getNohpByIdJabatan('pc', '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3'),
            // '089639481199',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurusByIdJabatan('pc', Auth::user()->PcPengurus->Pc->id_pc, '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3') .  "*" . "\n" .
                Helper::getJabatanPengurusByIdJabatan('pc', '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')  . "\n" . "\n" .
                "*" .  "Mohon segera respon persetujuan divisi program"  . "*" .  "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $this->nomor_surat  . "\n" .
                "*" .  "Pemohon"  . "*" .  "\n" .
                Helper::getNamaPengurus('pc', Auth::user()->gocap_id_pc_pengurus)   . "\n"  .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" . "\n" .
                "=============================" .  "\n" .  "\n" .
                "*" .  "Tujuan Pengajuan"  . "*" .  "\n" .
                $this->tujuan  . "\n" .
                "*" .  "Keterangan PPD"  . "*" .  "\n" .
                $this->keterangan_ppd .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $this->note .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . $this->nominal_pengajuan . ',-' .  "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        // yang mengajukan
        $this->notif(
            Helper::getNohpPengurus('pc', Auth::user()->gocap_id_pc_pengurus),
            // '089639481199',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurus('pc', Auth::user()->gocap_id_pc_pengurus) .  "*" . "\n" .
                Helper::getJabatanPengurus('pc', Auth::user()->gocap_id_pc_pengurus)  . "\n" . "\n" .
                "Pengajuan INTERNAL PC Lazisnu Cilacap, " . "*" . "berhasil diajukan" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $this->nomor_surat  . "\n" .
                "*" .  "Pemohon"  . "*" .  "\n" .
                Helper::getNamaPengurus('pc', Auth::user()->gocap_id_pc_pengurus)   . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" . "\n" .
                "=============================" .  "\n" .  "\n" .
                "*" .  "Tujuan Pengajuan"  . "*" .  "\n" .
                $this->tujuan  . "\n" .
                "*" .  "Keterangan PPD"  . "*" .  "\n" .
                $this->keterangan_ppd .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $this->note .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . $this->nominal_pengajuan . ',-' .  "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        return redirect('/pc/detail-pengajuan-internal-pc/' . $id_internal);
    }

    public function notif($nomor, $pesan)
    {
        $url = "https://wa.nucarecilacap.id/api/send.php?key=f1f441eaf700fa1a85f32c8a3973401be87e3c6d";
        $post = [
            'nomor' => $nomor,
            'msg' => $pesan
        ];
        $post = json_encode($post);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);

        $responseInfo = curl_getinfo($ch);

        $httpResponseCode = $responseInfo['http_code'];
        curl_close($ch);
        return (int)$httpResponseCode;
    }

    public function detail($id_internal)
    {
        return redirect('/pc/detail-pengajuan-internal-pc/' . $id_internal);
    }

    public function nama_pengurus_pc($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)->first();
        return $a->nama ?? '';
    }

    public function jabatan_pengurus_pc($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pc_pengurus', '=', $this->siftnu . '.pengguna.gocap_id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->select(
                $this->gocap . '.pengurus_jabatan.jabatan'
            )
            ->first();
        return $a->jabatan;
    }

    public function nohp_pengurus_pc($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        return $a->nohp;
    }
}
