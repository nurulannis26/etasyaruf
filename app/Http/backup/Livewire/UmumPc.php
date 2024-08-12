<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Helper;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Internal;
use App\Models\Pengajuan;
use App\Models\Berita;
use App\Models\PcPengurus;
use App\Models\PengajuanDetail;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Programs;
use App\Models\ProgramPilar;
use App\Models\ProgramKegiatan;
use App\Models\SurveyPenerimaManfaat;
use Livewire\WithPagination;


class UmumPc extends Component
{
    public $lol;
    // database
    public $gocap;
    public $etasyaruf;
    public $siftnu;
    public $filter_bulan;
    public $filter_status;
    public $filter_tahun;
    public $filter_kategori;
    public $filter_pilar;
    public $tahun_pengajuan = [];
    public $alert_wa;
    public $cari;
    public $id_asnaf;
    public $page_number = 5;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $tab_p1_show_active = "show active";
    public $tab_p2_show_active = 'disabled';


    public $survey = 'Perlu';
    public $nama_pc;
    public $nomor_surat;
    public $tgl_pengajuan;
    public $tgl_tenggat;
    public $tujuan;
    public $bentuk;
    public $atas_nama_pencairan;
    public $bank_tujuan_pencairan;
    public $no_rek_tujuan_pencairan;
    public $note;
    public $nominal_pengajuan;
    public $daftar_petugas = [];
    public $daftar_program = [];
    public $daftar_pilar = [];
    public $daftar_pilar2 = [];
    public $daftar_kegiatan = [];
    public $daftar_kegiatan2 = [];
    public $jumlah_penerima;
    public $satuan_pengajuan;
    public $sumber_dana;
    public $id_program_pilar;
    public $id_program_kegiatan;
    public $petugas;
    public $tgl_pelaksanaan;
    public $tgl_setor;
    public $nama_penerima;
    public $nama_pemohon;
    public $nohp_pemohon;
    public $alamat_pemohon;
    public $pengajuan_note;
    public $pc_petugas= [];

    public $c_filter_bulan;
    public $c_filter_tahun;
    public $c_filter_status;
    public $c_filter_kategori;
    public $c_filter_pilar;
    public $filter_pc_umum;

    public $selectedProgram;
    public $filter_asnaf;
    public $opsi_pemohon;

    public function updatedSelectedProgram($value)
    {
        $this->id_program_kegiatan = $value;
    }



    public function mount()
    {
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');
        $this->tgl_pengajuan = date('Y-m-d');

        // filter
        // filter 
        if ($this->filter_pc_umum == 'on') {

            $this->filter_bulan =  $this->c_filter_bulan;
            $this->filter_tahun =  $this->c_filter_tahun;
            $this->filter_status =  $this->c_filter_status;
            $this->filter_kategori =  $this->c_filter_kategori;
            $this->filter_pilar =  $this->c_filter_pilar;
            $this->filter_asnaf =  $this->c_filter_pilar;
        } else {
            $this->filter_bulan = date('m');
            $this->filter_tahun = date('Y');
        }
    }


    public function render()
    {
        
        // dd($petugas_pc);
        // nama pc
        $n = DB::table($this->gocap . '.pc')->where('id_pc', Auth::user()->PcPengurus->Pc->id_pc)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.pc.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_pc')
            ->first();
        $this->nama_pc = 'NU Care Lazisnu ' . str_replace('KAB.', '', $n->nama_pc);

        $this->tahun_pengajuan = Pengajuan::whereNotNull('id_pc')->whereNull('id_upzis')->whereNull('id_ranting')
            // filter upzis
            ->selectRaw('YEAR(tgl_pengajuan) as tahun')->groupBy('tahun')->orderBy('tgl_pengajuan', 'ASC')->get();

        // if ($this->filter_kategori == '') {
        //     $this->filter_pilar = NULL;
        // }

        if ($this->filter_kategori == 'Dana Infak') {
            

            $data = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })


                ->latest($this->etasyaruf . '.pengajuan.created_at')
                ->paginate($this->page_number);
        } elseif ($this->filter_kategori == 'Dana Zakat') {
            $data = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->latest($this->etasyaruf . '.pengajuan.created_at')
                ->paginate($this->page_number);
        } else {
            $data = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })



                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->latest($this->etasyaruf . '.pengajuan.created_at')
                ->paginate($this->page_number);
        }

        // dd($this->filter_pilar);


        // if ($this->id_program_pilar) {
        //     dd($this->id_program_pilar);
        // }
        // $this->modal_umum_pc_tambah();
        $daftar_petugas = DB::table($this->gocap . '.pc_pengurus')
            ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where($this->gocap . '.pengurus_jabatan.jabatan', 'Divisi Penyaluran')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select(
                $this->siftnu . '.pengguna.nama',
                $this->gocap . '.pc_pengurus.id_pc_pengurus',
                $this->gocap . '.pengurus_jabatan.jabatan',
            )
            ->where($this->gocap . '.pc_pengurus.id_pc',  Auth::user()->PcPengurus->Pc->id_pc)
            ->first();

        $this->daftar_petugas = DB::table($this->gocap . '.pc_pengurus')
            ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where($this->gocap . '.pengurus_jabatan.jabatan', 'Divisi Penyaluran')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select(
                $this->siftnu . '.pengguna.nama',
                $this->gocap . '.pc_pengurus.id_pc_pengurus',
                $this->gocap . '.pengurus_jabatan.jabatan',
            )
            ->where($this->gocap . '.pc_pengurus.id_pc',  Auth::user()->PcPengurus->Pc->id_pc)
            ->get();

        $this->petugas = $daftar_petugas->id_pc_pengurus;
        // dd($this->petugas);

        $this->daftar_program = Programs::orderBy('created_at', 'DESC')->get();
        // $this->daftar_pilar = ProgramPilar::where('id_program', $this->id_program)->orwhere('id_program2', $this->id_program)->orderBy('pilar', 'ASC')->get();
        $this->daftar_pilar = ProgramPilar::orderBy('pilar', 'ASC')->get();
        // $this->daftar_pilar2 = ProgramPilar::where('id_program', $this->filter_kategori)->orwhere('id_program2', $this->filter_kategori)->orderBy('pilar', 'ASC')->get();
        $this->daftar_pilar2 = ProgramPilar::orderBy('pilar', 'ASC')->get();

        $this->daftar_kegiatan = ProgramKegiatan::where('id_program_pilar', $this->id_program_pilar)
            ->whereRaw('LENGTH(no_urut) = 3')
            ->orderBy('no_urut', 'ASC')->get();
        // dd($this->daftar_kegiatan);lah 
        $this->daftar_kegiatan2 = ProgramKegiatan::where('id_program_pilar', $this->id_program_pilar)
            ->whereRaw('LENGTH(no_urut) = 4')
            ->orderBy('no_urut', 'ASC')->get();

        // perhitungan nominal total
        if ($this->jumlah_penerima == '') {
            $this->jumlah_penerima = NULL;
        }
        if ($this->satuan_pengajuan == '') {
            $this->satuan_pengajuan = NULL;
        }
        if ($this->jumlah_penerima != NULL or $this->satuan_pengajuan != NULL) {
            $a = str_replace('.', '', $this->jumlah_penerima);
            $b = str_replace('.', '', $this->satuan_pengajuan);
            $this->nominal_pengajuan = (int)$a * (int)$b;
        }

        $this->updatingSearch();

        if ($this->filter_kategori == 'Dana Infak') {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->count();

            $jumlah_disetujui_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Disetujui')->sum('nominal_disetujui');

            $jumlah_disetujui_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Berhasil Dicairkan')->sum('nominal_pencairan');

            $acc_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Disetujui')->count();

            $tolak_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Ditolak')->count();

            $belum_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Belum Direspon')->count();
            $acc_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Berhasil Dicairkan')->count();

            $tolak_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Ditolak')->count();

            $belum_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Belum Dicairkan')->count();

        } elseif ($this->filter_kategori == 'Dana Zakat') {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->count();

            $acc_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Disetujui')->count();
            $belum_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Belum Direspon')->count();
            $tolak_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Ditolak')->count();
            $acc_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Berhasil Dicairkan')->count();
            $belum_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Belum Dicairkan')->count();
            $tolak_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Ditolak')->count();

            $jumlah_disetujui_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Disetujui')->sum('nominal_disetujui');

            $jumlah_disetujui_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Berhasil Dicairkan')->sum('nominal_pencairan');
        } else {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->count();

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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->count();

            $acc_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Disetujui')->count();
            $belum_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Belum Direspon')->count();
            $tolak_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Ditolak')->count();
            $acc_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Berhasil Dicairkan')->count();
            $belum_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Belum Dicairkan')->count();
            $tolak_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Ditolak')->count();

            $jumlah_disetujui_direktur = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('approval_status', 'Disetujui')->sum('nominal_disetujui');

            $jumlah_disetujui_keuangan = DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->where('pencairan_status', 'Berhasil Dicairkan')->sum('nominal_pencairan');
        }

        if ($this->filter_kategori == 'Dana Infak') {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->sum('nominal_pengajuan');
        } elseif ($this->filter_kategori == 'Dana Zakat') {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari 
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->sum('nominal_pengajuan');
        } else {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })->sum('nominal_pengajuan');
        }


        if ($this->filter_kategori == 'Dana Infak') {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })
               // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->sum('jumlah_penerima');
        } elseif ($this->filter_kategori == 'Dana Zakat') {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
               // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->sum('jumlah_penerima');
        } else {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

               // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->sum('jumlah_penerima');
        }

        if ($this->filter_kategori == 'Dana Infak') {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->sum('nominal_disetujui');
        } elseif ($this->filter_kategori == 'Dana Zakat') {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->sum('nominal_disetujui');
        } else {
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
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })


                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->sum('nominal_disetujui');
        }
        $etasyaruf = config('app.database_etasyaruf');

        if ($this->filter_kategori == 'Dana Infak') {
            $detail_pilar =  DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
                ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
                ->join($etasyaruf . '.program_pilar', $etasyaruf . '.program_pilar.id_program_pilar', '=', $etasyaruf . '.pengajuan_detail.id_program_pilar')
                // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter bulan
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })
                // filter pilar
                ->when($this->filter_pilar != 'Semua' && $this->filter_pilar != '', function ($query) {
                    return $query->where('program_pilar.id_program_pilar', $this->filter_pilar);
                })

                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->get();
        } elseif ($this->filter_kategori == 'Dana Zakat') {
            $detail_pilar =  DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
                ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
                ->join($etasyaruf . '.program_pilar', $etasyaruf . '.program_pilar.id_program_pilar', '=', $etasyaruf . '.pengajuan_detail.id_program_pilar')
                // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter bulan
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })

                // filter asnaf
                ->when($this->filter_asnaf != 'Semua' && $this->filter_asnaf != '', function ($query) {
                    return $query->where('id_asnaf', $this->filter_asnaf);
                })
                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->get();
        } else {
            $detail_pilar =  DB::table($this->etasyaruf . '.pengajuan')->where('tingkat', 'PC')
                ->join($this->etasyaruf . '.pengajuan_detail', $this->etasyaruf . '.pengajuan_detail.id_pengajuan', '=', $this->etasyaruf . '.pengajuan.id_pengajuan')
                ->join($etasyaruf . '.program_pilar', $etasyaruf . '.program_pilar.id_program_pilar', '=', $etasyaruf . '.pengajuan_detail.id_program_pilar')
                // ->orderBy($this->etasyaruf . '.pengajuan.created_at', 'DESC')
                // filter status
                ->when($this->filter_status != 'Semua' && $this->filter_status != '', function ($query) {
                    return $query->where('approval_status', $this->filter_status);
                })
                // filter bulan
                ->when($this->filter_bulan != 'Semua' && $this->filter_bulan != '', function ($query) {
                    return $query->whereMonth('tgl_pengajuan', $this->filter_bulan);
                })
                // filter tahun
                ->when($this->filter_tahun, function ($query) {
                    return $query->whereYear('tgl_pengajuan', $this->filter_tahun);
                })

                // filter kategori
                ->when($this->filter_kategori != 'Semua' && $this->filter_kategori != '', function ($query) {
                    return $query->where('sumber_dana', $this->filter_kategori);
                })


                // cari
                ->when($this->cari, function ($query) {
                return $query->where(function ($subQuery) {
                    $subQuery->where('nomor_surat', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('pengajuan_note', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_entitas', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->where('nama_pemohon', 'like', '%' . $this->cari . '%')
                        ->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                })->orWhere(function ($subQuery) {
                    $subQuery->whereExists(function ($existsSubQuery) {
                        $existsSubQuery->select(DB::raw(1))
                            ->from($this->siftnu . '.pengguna')
                            ->whereColumn('pengguna.gocap_id_pc_pengurus', '=', 'pengajuan.pemohon_internal')
                            ->where('pengguna.nama', 'like', '%' . $this->cari . '%');
                    })->where('tingkat', 'PC'); // Added condition for 'tingkat'

                    if ($this->filter_bulan !== 'Semua') {
                        $subQuery->whereMonth('tgl_pengajuan', $this->filter_bulan);
                    }
                });
            })

                ->get();
        }

        $this->pc_petugas = DB::table($this->gocap . '.pc_pengurus')
            ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select(
                $this->siftnu . '.pengguna.nama',
                $this->gocap . '.pc_pengurus.id_pc_pengurus',
                $this->gocap . '.pengurus_jabatan.jabatan',
            )
            ->get();

        $detail_pilar_penguat_kelembagaan = $detail_pilar->where('pilar', 'Pilar Penguatan Kelembagaan')->count();
        $detail_pilar_ekonomi = $detail_pilar->where('pilar', 'Pilar Ekonomi ')->count();
        $detail_pilar_pendidikan = $detail_pilar->where('pilar', 'Pilar Pendidikan')->count();
        $detail_pilar_kesehatan = $detail_pilar->where('pilar', 'Pilar Kesehatan')->count();
        $detail_pilar_dakwah_dan_kemanusiaan = $detail_pilar->where('pilar', 'Pilar Dakwah dan Kemanusiaan')->count();
        $detail_pilar_kemanusiaan = $detail_pilar->where('pilar', 'Pilar Kemanusiaan')->count();
        $detail_pilar_lingkungan = $detail_pilar->where('pilar', 'Pilar Lingkungan')->count();

        
            // dd($acc_direktur);
        
        return view('livewire.umum-pc', compact(
            'acc_direktur',
            'belum_direktur',
            'tolak_direktur',
            'tolak_keuangan',
            'acc_keuangan',
            'belum_keuangan',
            'data',
            'jumlah_pengajuan',
            'total_nominal_pengajuan',
            'penerima_total',
            'nominal_disetujui',
            'detail_pilar_kesehatan',
            'detail_pilar_penguat_kelembagaan',
            'detail_pilar_ekonomi',
            'detail_pilar_pendidikan',
            'detail_pilar_kesehatan',
            'detail_pilar_dakwah_dan_kemanusiaan',
            'detail_pilar_kemanusiaan',
            'detail_pilar_lingkungan',
            'detail_pilar',
            'jumlah_disetujui_keuangan',
            'jumlah_disetujui_direktur',
        ));
    }

    public function hydrate()
    {
        $this->emit('loadContactDeviceSelect2');
        $this->emit('select2');
    }




    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function reset_filter_umum_pc()
    {
        $this->filter_bulan = date('m');
        $this->filter_tahun = date('Y');
        $this->filter_status = NULL;
        $this->filter_kategori = NULL;
        $this->filter_pilar = NULL;
        $this->filter_asnaf = NULL;
    }

    public static function hitung_jumlah_penerima($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->sum('jumlah_penerima');
        return $a;
    }

    public static function status_pencairan($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        return $a->pencairan_status;
    }

    public static function status_survey($id_pengajuan)
    {
        $data = Pengajuan::where('id_pengajuan', $id_pengajuan)->first();

        if ($data->survey_pc == 'Perlu') {

            $hitungpenerima = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first()->jumlah_penerima;
            $cekada = SurveyPenerimaManfaat::where('id_pengajuan', $id_pengajuan)->first();
            $hitungsurvey = SurveyPenerimaManfaat::where('id_pengajuan', $id_pengajuan)->count();

            $hitungsurveysetuju = SurveyPenerimaManfaat::where('id_pengajuan', $id_pengajuan)
                ->where('hasil', 'disetujui')->count();

            // dd($apaja);
            if ($cekada == null) { //belum survey samsek
                return  'Belum Survey';
            } else {
                if ($hitungsurvey != $hitungpenerima) { //baru survey sebagian
                    return 'Sebagian';
                } else { //sudah survey semua
                    if ($hitungsurveysetuju != $hitungsurvey) { //ada yang tidak setuju
                        return 'Ditolak';
                    } elseif ($hitungsurveysetuju == $hitungsurvey) { //semua survey disetujui
                        return 'Disetujui';
                    }
                }
            }
        } else {
            // dd('1212');
            return 'Tidak Survey';
        }

        // return $a->pencairan_status;
    }

    public static function pengajuan_note($id_pengajuan)
    {
        $data = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        return $data->pengajuan_note;
    }

    public static function status_berita($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        $b = Berita::where('id_pengajuan_detail', $a->id_pengajuan_detail)->first();
        if ($b == NULL) {
            return 'Belum Diinput';
        } else {
            return $b->status;
        }
    }

    public function nama_pilar($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        $b = ProgramPilar::where('id_program_pilar', $a->id_program_pilar)->first();

        return  $b->pilar ?? '';
    }

    public function nama_program($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        $b = ProgramKegiatan::where('id_program_kegiatan', $a->id_program_kegiatan)->first();

        return  $b->nama_program ?? '';
    }

    public function selanjutnya()
    {
        $this->tab_p1_show_active = 'noClick';
        $this->tab_p2_show_active = 'show active';
    }

    public function kembali()
    {
        $this->tab_p1_show_active = 'show active';
        $this->tab_p2_show_active = 'noClick';
    }



    public function modal_umum_pc_tambah()
    {

        $this->tab_p1_show_active = 'show active';
        $this->tab_p2_show_active = 'noClick';

        $b = Pengajuan::where('id_pc', Auth::user()->PcPengurus->Pc->id_pc)->where('id_upzis', NULL)->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))->latest()->first();

        if ($b == NULL) {
            $urut = 0;
        } else {
            $string = $b->nomor_surat;
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

        if (($urut + 1) < 10) {
            $this->nomor_surat = '0' . $urut + 1 . '/' . 'UMUM-PC' . '/' . str_replace('KAB. ', '', Auth::user()->PcPengurus->Pc->Wilayah->nama) . '/' . $romawi . '/' . date('Y');
        } else {
            $this->nomor_surat = $urut + 1 . '/' . 'UMUM-PC' . '/' . str_replace('KAB. ', '', Auth::user()->PcPengurus->Pc->Wilayah->nama)  . '/' . $romawi . '/' . date('Y');
        }
    }


    public $jenis_permohonan;
    public $no_hp_entitas;
    public $pj_entitas;
    public $alamat_entitas;
    public $no_perijinan_entitas;
    public $nama_entitas;

    public $tgl_surat;
    public $no_surat;
    public $jenis_tanda_terima;
    public $lainnya;

    public $pemohon_internal;


    public function tambah_pengajuan_pc()
    {
        // dd($this);
        // dd('dw');
        // dd('TAMBAH PENGAJUAN PC');
        // dd($this->id_asnaf);
        // return;
        $id_pengajuan = Str::uuid();
        $id_pengajuan_detail = Str::uuid()->toString();

        // if ($this->survey == 'Tidak Perlu') {
        //     $survey = 'Tidak Perlu';
        // } else {
        //     $survey = 'Perlu';
        // }

        $front = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Front Office')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        Pengajuan::create([
            'id_pengajuan' => $id_pengajuan,
            'tingkat' => 'PC',
            'status_survey' => 'Direncanakan',
            'nomor_surat' => $this->nomor_surat,
            'tgl_pengajuan' => $this->tgl_pengajuan,
            'status_pengajuan' => 'Direncanakan',
            'status_rekomendasi' => 'Belum Terbit',
            'jenis_permohonan' => $this->jenis_permohonan,
            // 'survey_pc' => $survey,
            'opsi_pemohon' => $this->opsi_pemohon,
            'pj_pc' => $this->petugas,
            'id_pc' =>  Auth::user()->PcPengurus->Pc->id_pc,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            'pemohon_internal' => $this->pemohon_internal,
        ]);


        if ($this->sumber_dana == "Dana Zakat") {
            PengajuanDetail::create([
                'id_pengajuan_detail' =>  $id_pengajuan_detail,
                'id_pengajuan' => $id_pengajuan,
                'petugas_pc' => $this->petugas,
                'nama_pemohon' => $this->nama_pemohon,
                'nohp_pemohon' => $this->nohp_pemohon,
                'alamat_pemohon' => $this->alamat_pemohon,
                'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
                // 'tgl_setor' => $this->tgl_setor,
                'pengajuan_note' => $this->pengajuan_note,
                // 'id_program' => $this->id_program,
                'sumber_dana' => $this->sumber_dana,
                'id_asnaf' => $this->id_asnaf,
                // 'id_program_pilar' => $this->id_program_pilar,
                // 'id_program_kegiatan' => $this->id_program_kegiatan,
                'nama_penerima' => $this->nama_penerima,
                'jumlah_penerima' => $this->jumlah_penerima,
                'satuan_pengajuan' => str_replace('.', '', $this->satuan_pengajuan),
                // 'satuan_disetujui' => str_replace('.', '', $this->satuan_pengajuan),
                'nominal_pengajuan' => $this->nominal_pengajuan,
                'pencairan_status' => 'Belum Dicairkan',
                // 'nominal_disetujui' => $this->nominal_pengajuan,
                'approval_status' => 'Belum Direspon',
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
                'nama_entitas' => $this->nama_entitas,
                'no_perijinan_entitas' => $this->no_perijinan_entitas,
                'alamat_entitas' => $this->alamat_entitas,
                'nama_pj_permohonan_entitas' => $this->pj_entitas,
                'no_hp_entitas' => $this->no_hp_entitas,
                'tgl_surat' => $this->tgl_surat,
                'no_surat' => $this->no_surat,
                'jenis_tanda_terima' => $this->jenis_tanda_terima,
                'lainnya' => $this->lainnya,
            ]);

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            $asnaf = DB::table('asnaf')->where('id_asnaf', $this->id_asnaf)->value('nama_asnaf');
            $id_direk = PcPengurus::where('id_pengurus_jabatan', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')->value('id_pc_pengurus');
            $nama_direk = Pengguna::where('gocap_id_pc_pengurus', $id_direk)->value('nama');

            // petugas penyaluran
            $this->notif(
                 Helper::getNohpPengurus('pc', $front->id_pc_pengurus),
                // '089639481199',

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                    // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                    "Yth. " . "*" . $this->nama_pengurus_pc($front->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($front->id_pc_pengurus) . "\n" . "\n" .

                    "*Pengajuan berhasil diinputkan*" . "\n" . "*Lengkapi lampiran & penerima manfaat lalu konfirmasi selesai input.*" . "\n" . "\n" .

                    "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $this->nomor_surat  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($this->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($this->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($this->nominal_pengajuan * $this->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $this->nominal_pengajuan . "x" . $this->jumlah_penerima . "penerima )" . "\n" .

                    "*" .  "Asnaf"  . "*" .  "\n" .
                    $asnaf .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        } else {
            PengajuanDetail::create([
                'id_pengajuan_detail' =>  $id_pengajuan_detail,
                'id_pengajuan' => $id_pengajuan,
                'petugas_pc' => $this->petugas,
                'nama_pemohon' => $this->nama_pemohon,
                'nohp_pemohon' => $this->nohp_pemohon,
                'alamat_pemohon' => $this->alamat_pemohon,
                'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
                // 'tgl_setor' => $this->tgl_setor,
                'pengajuan_note' => $this->pengajuan_note,
                // 'id_program' => $this->id_program,
                // 'id_asnaf' => $this->id_asnaf,
                'sumber_dana' => $this->sumber_dana,
                'id_program_pilar' => $this->id_program_pilar,
                'id_program_kegiatan' => $this->id_program_kegiatan,
                'nama_penerima' => $this->nama_penerima,
                'jumlah_penerima' => $this->jumlah_penerima,
                'satuan_pengajuan' => str_replace('.', '', $this->satuan_pengajuan),
                // 'satuan_disetujui' => str_replace('.', '', $this->satuan_pengajuan),
                'nominal_pengajuan' => $this->nominal_pengajuan,
                'pencairan_status' => 'Belum Dicairkan',
                // 'nominal_disetujui' => $this->nominal_pengajuan,
                'approval_status' => 'Belum Direspon',
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
                'nama_entitas' => $this->nama_entitas,
                'no_perijinan_entitas' => $this->no_perijinan_entitas,
                'alamat_entitas' => $this->alamat_entitas,
                'nama_pj_permohonan_entitas' => $this->pj_entitas,
                'no_hp_entitas' => $this->no_hp_entitas,
                'tgl_surat' => $this->tgl_surat,
                'no_surat' => $this->no_surat,
                'jenis_tanda_terima' => $this->jenis_tanda_terima,
                'lainnya' => $this->lainnya,
            ]);

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            // petugas penyaluran
            $this->notif(
                 Helper::getNohpPengurus('pc', $front->id_pc_pengurus),
                // '081578447350',

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                    // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                    "Yth. " . "*" . $this->nama_pengurus_pc($front->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($front->id_pc_pengurus) . "\n" . "\n" .

                    "*Pengajuan berhasil diinputkan*" . "\n" . "*Lengkapi lampiran & penerima manfaat lalu konfirmasi selesai input.*" . "\n" . "\n" .

                    "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $this->nomor_surat  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($this->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($this->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($this->nominal_pengajuan * $this->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $this->nominal_pengajuan . "x" . $this->jumlah_penerima . "penerima )" . "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($this->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($this->id_program_kegiatan) .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }



        return redirect('/pc/detail-pengajuan-pc/' . $id_pengajuan);
    }

    public function nama_kegiatan($id)
    {
        $a = ProgramKegiatan::where('id_program_kegiatan', $id)->first();

        return  $a->nama_program ?? '';
    }

    public function nama_pilars($id)
    {
        $a = ProgramPilar::where('id_program_pilar', $id)->first();

        return  $a->pilar ?? '';
    }

    public function nohp_pengurus_pc($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        return $a->nohp;
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

        // $httpResponseCode = 200;
        if ($httpResponseCode == 200) {
            return null;
        } else {
            session()->flash('alert_notif', 'Tidak Terkirim, Notifikasi WA Sedang Sibuk, Coba Lagi Nanti');
        }
    }

    public function reset_filter()
    {
        $this->filter_bulan = NULL;
        $this->filter_status = NULL;
    }

    public function detail($id_pengajuan)
    {
        return redirect('/pc/detail-pengajuan-pc/' . $id_pengajuan);
    }

    public function nama_pengurus_pc($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)->first();
        return $a->nama;
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

    public function nama_fo()
    {
        $a = DB::table($this->siftnu . '.pengguna')->whereNotNull('gocap_id_pc_pengurus')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pc_pengurus', '=', $this->siftnu . '.pengguna.gocap_id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where($this->gocap . '.pengurus_jabatan.jabatan', 'Front Office')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select(
                $this->siftnu . '.pengguna.nama'
            )
            ->first();

        return $a->nama ?? '';
    }
}
