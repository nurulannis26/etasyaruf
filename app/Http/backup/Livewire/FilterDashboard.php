<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Internal;
use App\Models\Pengajuan;
use App\Models\ProgramPilar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FilterDashboard extends Component
{
    public $filter_bulan;
    public $filter_tahun;
    public $filter_status = "Semua";
    public $filter_tingkat;
    public $filter_id_upzis;
    public $filter_id_ranting;
    public $pilih_tingkat;
    public $daftar_pilar2;
    public $filter_kategori;
    public $daftar_upzis;
    public $daftar_ranting;
    public $etasyaruf;
    public $gocap;
    public $siftnu;
    public $tahun_pengajuan;
    public $filter_tujuan;
    public $filter_pilar;

    public  $c_tingkat;
    public  $c_filter_bulan;
    public  $c_filter_tahun;
    public  $c_filter_status;
    public  $c_filter_tujuan;
    public  $c_filter_kategori;
    public  $c_filter_pilar;
    public  $c_filter_id_upzis;
    public  $c_filter_id_ranting;




    public function mount()
    {
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');

        if ($this->c_tingkat == 'INTERNAL') {
            $this->pilih_tingkat =  $this->c_tingkat;
            $this->filter_bulan =  $this->c_filter_bulan;
            $this->filter_tahun =  $this->c_filter_tahun;
            $this->filter_status =  $this->c_filter_status;
            $this->filter_tujuan =  $this->c_filter_tujuan;
        } elseif ($this->c_tingkat == 'UMUM') {
            $this->pilih_tingkat =  $this->c_tingkat;
            $this->filter_bulan =  $this->c_filter_bulan;
            $this->filter_tahun =  $this->c_filter_tahun;
            $this->filter_status =  $this->c_filter_status;
            $this->filter_kategori =  $this->c_filter_kategori;
            $this->filter_pilar =  $this->c_filter_pilar;
        } elseif ($this->c_tingkat == 'UPZIS') {
            $this->pilih_tingkat =  $this->c_tingkat;
            $this->filter_bulan =  $this->c_filter_bulan;
            $this->filter_tahun =  $this->c_filter_tahun;
            $this->filter_status =  $this->c_filter_status;
            $this->filter_id_upzis =  $this->c_filter_id_upzis;
        } elseif ($this->c_tingkat == 'RANTING') {
            $this->pilih_tingkat =  $this->c_tingkat;
            $this->filter_bulan =  $this->c_filter_bulan;
            $this->filter_tahun =  $this->c_filter_tahun;
            $this->filter_status =  $this->c_filter_status;
            $this->filter_id_upzis =  $this->c_filter_id_upzis;
            $this->filter_id_ranting =  $this->c_filter_id_ranting;
        } else {
            $this->filter_bulan = date('m');
            $this->filter_tahun = date('Y');

            if (Auth::user()->gocap_id_pc_pengurus != null) {
                $this->pilih_tingkat = 'UMUM';
            } else {
                $this->pilih_tingkat = 'UPZIS';
            }
        }
    }

    public function render()
    {
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $this->filter_id_upzis = Auth::user()->UpzisPengurus->Upzis->id_upzis;
        }
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $bulan = '';
        $belum_direspon_internal = '';
        $disetujui_internal = '';
        $ditolak_internal = '';
        $belum_direspon_umum = '';
        $disetujui_umum = '';
        $ditolak_umum = '';
        $nominal_belum_direspon_internal = '';
        $nominal_disetujui_internal = '';
        $nominal_ditolak_internal = '';
        $nominal_belum_direspon_umum = '';
        $nominal_disetujui_umum = '';
        $nominal_ditolak_umum = '';
        $direncanakan_upzis = '';
        $diajukan_upzis = '';
        $direncanakan_ranting = '';
        $diajukan_ranting = '';
        $terbit_upzis = '';
        $terbit_ranting = '';
        $nominal_direncanakan_upzis = '';
        $nominal_diajukan_upzis = '';
        $nominal_sudah_terbit_upzis = '';
        $nominal_direncanakan_ranting = '';
        $nominal_diajukan_ranting = '';
        $nominal_sudah_terbit_ranting = '';
        $pengajuan_total = '';
        $total_nominal = '';
        $total_nominal_disetujui = '';
        $jumlah_pengajuan = '';
        $total_nominal_pengajuan = '';
        $penerima_total = '';
        $nominal_disetujui = '';
        $pengajuan_total_upzis = '';
        $nominal_disetujui_upzis = '';
        $jumlah_penerima_upzis = '';
        $jumlah_rencana_kegiatan_upzis = '';
        $nominal_pengajuan_ranting = '';
        $nominal_disetujui_ranting = '';
        $jumlah_penerima_ranting = '';
        $jumlah_rencana_kegiatan_ranting = '';
        $detail_pilar = '';
        $detail_pilar_penguat_kelembagaan = '';
        $detail_pilar_ekonomi = '';
        $detail_pilar_pendidikan = '';
        $detail_pilar_kesehatan = '';
        $detail_pilar_dakwah_dan_kemanusiaan = '';
        $detail_pilar_kemanusiaan = '';
        $detail_pilar_lingkungan = '';
        $detail_tujuan = '';
        $uang_muka = '';
        $reimbursement = '';
        $pembayaran = '';
        $lainnya = '';

        //START FILTER CODE

        $this->daftar_pilar2 = ProgramPilar::where('id_program', $this->filter_kategori)->orwhere('id_program2', $this->filter_kategori)->orderBy('pilar', 'ASC')->get();

        $this->daftar_upzis = DB::table($this->gocap . '.upzis')
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.upzis.id_wilayah')
            ->select(
                $this->gocap . '.upzis.id_upzis',
                $this->siftnu . '.wilayah.*',
            )
            ->orderBy('nama', 'ASC')
            ->get();

        $this->daftar_ranting = DB::table($this->gocap . '.ranting')->where('id_upzis', $this->filter_id_upzis)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.ranting.id_wilayah')
            ->select(
                $this->gocap . '.ranting.id_ranting',
                $this->siftnu . '.wilayah.*',
            )
            ->orderBy('nama', 'ASC')
            ->get();

        if ($this->pilih_tingkat != 'INTERNAL') {
            $this->tahun_pengajuan = Pengajuan::whereNotNull('id_pc')->whereNotNull('id_upzis')->whereNull('id_ranting')
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })->selectRaw('YEAR(tgl_pengajuan) as tahun')->groupBy('tahun')->orderBy('tgl_pengajuan', 'ASC')->get();
        } else {
            $this->tahun_pengajuan = Internal::
                // filter upzis
                selectRaw('YEAR(tgl_pengajuan) as tahun')->groupBy('tahun')->orderBy('tgl_pengajuan', 'ASC')->get();
        }

        if ($this->filter_bulan == '01') {
            $bulan = 'Januari';
        } elseif ($this->filter_bulan == '02') {
            $bulan = 'Februari';
        } elseif ($this->filter_bulan == '03') {
            $bulan = 'Maret';
        } elseif ($this->filter_bulan == '04') {
            $bulan = 'April';
        } elseif ($this->filter_bulan == '05') {
            $bulan = 'Mei';
        } elseif ($this->filter_bulan == '06') {
            $bulan = 'Juni';
        } elseif ($this->filter_bulan == '07') {
            $bulan = 'Juli';
        } elseif ($this->filter_bulan == '08') {
            $bulan = 'Agustus';
        } elseif ($this->filter_bulan == '09') {
            $bulan = 'September';
        } elseif ($this->filter_bulan == '10') {
            $bulan = 'Oktober';
        } elseif ($this->filter_bulan == '11') {
            $bulan = 'November';
        } elseif ($this->filter_bulan == '12') {
            $bulan = 'Desember';
        }

        //END CODE FILTER

        if ($this->pilih_tingkat == 'INTERNAL') {
            $data_internal =  Internal::orderBy('created_at', 'DESC')
                // filter periode
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter tujuan
                ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                    return $query->where('tujuan', $this->filter_tujuan);
                })->get();

            $belum_direspon_internal = $data_internal->where('approval_status', 'Belum Direspon')->count();
            $disetujui_internal = $data_internal->where('approval_status', 'Disetujui')->count();
            $ditolak_internal = $data_internal->where('approval_status', 'Ditolak')->count();

            $nominal_belum_direspon_internal = $data_internal->where('approval_status', 'Belum Direspon')->sum('nominal_pengajuan');
            $nominal_disetujui_internal = $data_internal->where('approval_status', 'Disetujui')->sum('nominal_pengajuan');
            $nominal_ditolak_internal = $data_internal->where('approval_status', 'Ditolak')->sum('nominal_pengajuan');

            $pengajuan_total = Internal::orderBy('created_at', 'DESC')
                // filter periode
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter tujuan
                ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                    return $query->where('tujuan', $this->filter_tujuan);
                })
                ->count();

            $total_nominal = Internal::orderBy('created_at', 'DESC')
                // filter periode
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter tujuan
                ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                    return $query->where('tujuan', $this->filter_tujuan);
                })
                ->sum('nominal_pengajuan');

            $total_nominal_disetujui = Internal::orderBy('created_at', 'DESC')
                // filter periode
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter tujuan
                ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                    return $query->where('tujuan', $this->filter_tujuan);
                })
                ->sum('nominal_disetujui');

            $detail_tujuan = Internal::orderBy('created_at', 'DESC')
                // filter periode
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter tujuan
                ->when($this->filter_tujuan != 'Semua' && $this->filter_tujuan != '', function ($query) {
                    return $query->where('tujuan', $this->filter_tujuan);
                })
                ->get();

            $uang_muka =  $detail_tujuan->where('tujuan', 'Uang Muka')->count();
            $reimbursement = $detail_tujuan->where('tujuan', 'Reimbursement')->count();
            $pembayaran = $detail_tujuan->where('tujuan', 'Pembayaran')->count();
            $lainnya = $detail_tujuan->where('tujuan', 'Lainnya')->count();
        }

        if ($this->pilih_tingkat == 'UMUM') {
            $data_umum_pc = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
                ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
                ->select(
                    $this->etasyaruf . '.pengajuan.*',
                    $this->etasyaruf . '.pengajuan_detail.*'
                )
                // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })
                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('id_program', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })
                ->get();

            $belum_direspon_umum = $data_umum_pc->where('approval_status', 'Belum Direspon')->count();
            $disetujui_umum = $data_umum_pc->where('approval_status', 'Disetujui')->count();
            $ditolak_umum = $data_umum_pc->where('approval_status', 'Ditolak')->count();

            $nominal_belum_direspon_umum = $data_umum_pc->where('approval_status', 'Belum Direspon')->sum('nominal_pengajuan');
            $nominal_disetujui_umum = $data_umum_pc->where('approval_status', 'Disetujui')->sum('nominal_pengajuan');
            $nominal_ditolak_umum = $data_umum_pc->where('approval_status', 'Ditolak')->sum('nominal_pengajuan');

            $jumlah_pengajuan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
                ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
                ->select(
                    $this->etasyaruf . '.pengajuan.*',
                    $this->etasyaruf . '.pengajuan_detail.*'
                )
                // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('id_program', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })
                ->count();

            $total_nominal_pengajuan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
                ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
                ->select(
                    $this->etasyaruf . '.pengajuan.*',
                    $this->etasyaruf . '.pengajuan_detail.*'
                )
                // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('id_program', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })
                ->sum('nominal_pengajuan');


            $penerima_total = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
                ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
                ->select(
                    $this->etasyaruf . '.pengajuan.*',
                    $this->etasyaruf . '.pengajuan_detail.*'
                )
                // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('id_program', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })
                ->sum('jumlah_penerima');

            $nominal_disetujui = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
                ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
                ->select(
                    $this->etasyaruf . '.pengajuan.*',
                    $this->etasyaruf . '.pengajuan_detail.*'
                )
                // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('id_program', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })
                ->sum('nominal_disetujui');

            $detail_pilar =  DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
                ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
                ->join($etasyaruf . '.program_pilar', $etasyaruf . '.program_pilar.id_program_pilar', '=', $etasyaruf . '.pengajuan_detail.id_program_pilar')
                // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('program_pilar.id_program', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('program_pilar.id_program_pilar', $this->filter_pilar);
                })
                ->get();

            $detail_pilar_penguat_kelembagaan = $detail_pilar->where('pilar', 'Pilar Penguatan Kelembagaan')->count();
            $detail_pilar_ekonomi = $detail_pilar->where('pilar', 'Pilar Ekonomi ')->count();
            $detail_pilar_pendidikan = $detail_pilar->where('pilar', 'Pilar Pendidikan')->count();
            $detail_pilar_kesehatan = $detail_pilar->where('pilar', 'Pilar Kesehatan')->count();
            $detail_pilar_dakwah_dan_kemanusiaan = $detail_pilar->where('pilar', 'Pilar Dakwah dan Kemanusiaan')->count();
            $detail_pilar_kemanusiaan = $detail_pilar->where('pilar', 'Pilar Kemanusiaan')->count();
            $detail_pilar_lingkungan = $detail_pilar->where('pilar', 'Pilar Lingkungan')->count();
        }

        if ($this->pilih_tingkat == 'UPZIS') {
            $data_upzis = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('tingkat', 'Upzis MWCNU')
                ->whereNull('id_ranting')
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })
                ->get();

            $direncanakan_upzis = $data_upzis->where('status_pengajuan', 'Direncanakan')->count();
            $diajukan_upzis = $data_upzis->where('status_pengajuan', 'Diajukan')->count();
            $terbit_upzis = $data_upzis->where('status_rekomendasi', 'Sudah Terbit')->count();

            $nominal_direncanakan_upzis = $data_upzis->where('status_pengajuan', 'Direncanakan')->sum('nominal_pengajuan');
            $nominal_diajukan_upzis = $data_upzis->where('status_pengajuan', 'Diajukan')->sum('nominal_pengajuan');
            $nominal_sudah_terbit_upzis = $data_upzis->where('status_rekomendasi', 'Sudah Terbit')->sum('nominal_disetujui');


            $pengajuan_total_upzis = Pengajuan::orderBy('created_at', 'DESC')->where('tingkat', 'Upzis MWCNU')
                ->whereNull('id_ranting')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })
                ->count();

            $jumlah_rencana_kegiatan_upzis = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->whereNull('id_ranting')
                ->where('tingkat', 'like', '%Upzis%')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                ->count();

            $jumlah_penerima_upzis = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->whereNull('id_ranting')
                ->where('tingkat', 'like', '%Upzis%')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                ->sum('jumlah_penerima');

            $nominal_disetujui_upzis = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->whereNull('id_ranting')
                ->where('tingkat', 'like', '%Upzis%')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                ->sum('nominal_disetujui');

            $detail_pilar =  DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->join($etasyaruf . '.program_pilar', $etasyaruf . '.program_pilar.id_program_pilar', '=', $etasyaruf . '.pengajuan_detail.id_program_pilar')
                ->whereNull('id_ranting')
                ->where('tingkat', 'like', '%Upzis%')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter status
                ->when($this->filter_id_ranting != 'Semua' && $this->filter_id_ranting != '', function ($query) {
                    return $query->where('id_ranting', $this->filter_id_ranting);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })
                ->get();


            $detail_pilar_penguat_kelembagaan = $detail_pilar->where('pilar', 'Pilar Penguatan Kelembagaan')->count();
            $detail_pilar_ekonomi = $detail_pilar->where('pilar', 'Pilar Ekonomi ')->count();
            $detail_pilar_pendidikan = $detail_pilar->where('pilar', 'Pilar Pendidikan')->count();
            $detail_pilar_kesehatan = $detail_pilar->where('pilar', 'Pilar Kesehatan')->count();
            $detail_pilar_dakwah_dan_kemanusiaan = $detail_pilar->where('pilar', 'Pilar Dakwah dan Kemanusiaan')->count();
            $detail_pilar_kemanusiaan = $detail_pilar->where('pilar', 'Pilar Kemanusiaan')->count();
            $detail_pilar_lingkungan = $detail_pilar->where('pilar', 'Pilar Lingkungan')->count();
        }

        if ($this->pilih_tingkat == 'RANTING') {
            $data_ranting =  DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->where('tingkat', 'Ranting NU')

                ->whereNotNull('id_ranting')
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter ranting
                ->when($this->filter_id_ranting != 'Semua' && $this->filter_id_ranting != '', function ($query) {
                    return $query->where('id_ranting', $this->filter_id_ranting);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })->get();

            $direncanakan_ranting = $data_ranting->where('status_pengajuan', 'Direncanakan')->count();
            $diajukan_ranting = $data_ranting->where('status_pengajuan', 'Diajukan')->count();
            $terbit_ranting = $data_ranting->where('status_rekomendasi', 'Sudah Terbit')->count();

            $nominal_direncanakan_ranting = $data_ranting->where('status_pengajuan', 'Direncanakan')->sum('nominal_pengajuan');
            $nominal_diajukan_ranting = $data_ranting->where('status_pengajuan', 'Diajukan')->sum('nominal_pengajuan');
            $nominal_sudah_terbit_ranting = $data_ranting->where('status_rekomendasi', 'Sudah Terbit')->sum('nominal_disetujui');

            $nominal_pengajuan_ranting = Pengajuan::orderBy('created_at', 'DESC')->where('tingkat', 'Ranting NU')
                ->whereNotNull('id_ranting')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter ranting
                ->when($this->filter_id_ranting != 'Semua' && $this->filter_id_ranting != '', function ($query) {
                    return $query->where('id_ranting', $this->filter_id_ranting);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })
                ->count();


            $jumlah_rencana_kegiatan_ranting = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->whereNotNull('id_ranting')
                ->where('tingkat', 'like', '%Ranting%')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter status
                ->when($this->filter_id_ranting != 'Semua' && $this->filter_id_ranting != '', function ($query) {
                    return $query->where('id_ranting', $this->filter_id_ranting);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                ->count();

            $jumlah_penerima_ranting = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->whereNotNull('id_ranting')
                ->where('tingkat', 'like', '%Ranting%')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter status
                ->when($this->filter_id_ranting != 'Semua' && $this->filter_id_ranting != '', function ($query) {
                    return $query->where('id_ranting', $this->filter_id_ranting);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                ->sum('jumlah_penerima');

            $nominal_disetujui_ranting = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->whereNotNull('id_ranting')
                ->where('tingkat', 'like', '%Ranting%')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter status
                ->when($this->filter_id_ranting != 'Semua' && $this->filter_id_ranting != '', function ($query) {
                    return $query->where('id_ranting', $this->filter_id_ranting);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                ->sum('nominal_disetujui');


            $detail_pilar = DB::table($etasyaruf . '.pengajuan_detail')
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->join($etasyaruf . '.program_pilar', $etasyaruf . '.program_pilar.id_program_pilar', '=', $etasyaruf . '.pengajuan_detail.id_program_pilar')
                ->whereNotNull('id_ranting')
                ->where('tingkat', 'like', '%Ranting%')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('status_pengajuan', $this->filter_status);
                })
                // filter status
                ->when($this->filter_id_ranting != 'Semua' && $this->filter_id_ranting != '', function ($query) {
                    return $query->where('id_ranting', $this->filter_id_ranting);
                })
                // filter upzis
                ->when($this->filter_id_upzis != 'Semua' && $this->filter_id_upzis != '', function ($query) {
                    return $query->where('id_upzis', $this->filter_id_upzis);
                })
                // filter bulan
                ->when($this->filter_bulan, function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })
                ->get();


            $detail_pilar_penguat_kelembagaan = $detail_pilar->where('pilar', 'Pilar Penguatan Kelembagaan')->count();
            $detail_pilar_ekonomi = $detail_pilar->where('pilar', 'Pilar Ekonomi ')->count();
            $detail_pilar_pendidikan = $detail_pilar->where('pilar', 'Pilar Pendidikan')->count();
            $detail_pilar_kesehatan = $detail_pilar->where('pilar', 'Pilar Kesehatan')->count();
            $detail_pilar_dakwah_dan_kemanusiaan = $detail_pilar->where('pilar', 'Pilar Dakwah dan Kemanusiaan')->count();
            $detail_pilar_kemanusiaan = $detail_pilar->where('pilar', 'Pilar Kemanusiaan')->count();
            $detail_pilar_lingkungan = $detail_pilar->where('pilar', 'Pilar Lingkungan')->count();
        }

        return view('livewire.filter-dashboard', compact(
            'bulan',
            'belum_direspon_internal',
            'disetujui_internal',
            'ditolak_internal',
            'belum_direspon_umum',
            'disetujui_umum',
            'ditolak_umum',
            'nominal_belum_direspon_internal',
            'nominal_disetujui_internal',
            'nominal_ditolak_internal',
            'nominal_belum_direspon_umum',
            'nominal_disetujui_umum',
            'nominal_ditolak_umum',
            'direncanakan_upzis',
            'diajukan_upzis',
            'direncanakan_ranting',
            'diajukan_ranting',
            'terbit_upzis',
            'terbit_ranting',
            'nominal_direncanakan_upzis',
            'nominal_diajukan_upzis',
            'nominal_sudah_terbit_upzis',
            'nominal_direncanakan_ranting',
            'nominal_diajukan_ranting',
            'nominal_sudah_terbit_ranting',
            'pengajuan_total',
            'total_nominal',
            'total_nominal_disetujui',
            'jumlah_pengajuan',
            'total_nominal_pengajuan',
            'penerima_total',
            'nominal_disetujui',
            'pengajuan_total_upzis',
            'nominal_disetujui_upzis',
            'jumlah_penerima_upzis',
            'jumlah_rencana_kegiatan_upzis',
            'nominal_pengajuan_ranting',
            'nominal_disetujui_ranting',
            'jumlah_penerima_ranting',
            'jumlah_rencana_kegiatan_ranting',
            'detail_pilar',
            'detail_pilar_penguat_kelembagaan',
            'detail_pilar_ekonomi',
            'detail_pilar_pendidikan',
            'detail_pilar_kesehatan',
            'detail_pilar_dakwah_dan_kemanusiaan',
            'detail_pilar_kemanusiaan',
            'detail_pilar_lingkungan',
            'detail_tujuan',
            'uang_muka',
            'reimbursement',
            'pembayaran',
            'lainnya',
        ));
    }
}
