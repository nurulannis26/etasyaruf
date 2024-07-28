<?php

namespace App\Http\Controllers;

use TCPDF;
use Carbon\Carbon;
use App\Models\Upzis;
use App\Models\Ranting;
use App\Models\Wilayah;
use App\Models\Rekening;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use App\Models\PengajuanDetail;
use App\Models\ProgramKegiatan;
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




class PengajuanController extends Controller
{
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

    public static function get_nama_program($id_program_kegiatan)
    {
        $data = ProgramKegiatan::where('id_program_kegiatan', $id_program_kegiatan)->first();
        return $data->nama_program ?? '';
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
        $pengajuan = Pengajuan::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->latest();

        if ($role == 'upzis') {
            $data = $pengajuan->where('id_ranting', NULL)->first();
        } else {
            $data = $pengajuan->where('id_ranting', $id)->first();
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
            ->where('status_berita', 'Belum Dikonfirmasi')
            ->count();
        $d = PengajuanDetail::where('id_pengajuan', $id)
            ->where('status_berita', 'Revisi')
            ->count();

        return [
            'konfirmasi' => $a,
            'selesai' => $b,
            'belum' => $c,
            'revisi' => $d,
        ];
    }

    public static function get_nama_ranting($id_ranting)
    {
        // dd($id_ranting);
        $data = Ranting::where('id_ranting', $id_ranting)->first();
        $wilayah = Wilayah::where('id_wilayah', $data->id_wilayah)->first();
        return $wilayah->nama ?? '';
    }
}

class EksporPenerimaManfaat extends Controller
{
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
}

class EksporAllLaporanController extends Controller
{

    public function __construct()
    {


        view()->composer('*', function ($view) {

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $role = 'pc';
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $role = 'upzis';
            }
            $view->with('role', $role);
        });
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


    public function pdf_all_umum_laporan_upzis($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
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

        $datas2 = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.tgl_terbit_rekomendasi',

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


        $program = $datas2->get()->groupBy('pilar');

        $sum_pencairan = $datas2->sum('nominal_pencairan');
        $sum_penerima = $datas2->sum('jumlah_penerima');

        //nominal pencairan
        $hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->sum('nominal_pencairan') ?? 0;
        $ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan') ?? 0;
        $kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan') ?? 0;
        $kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan') ?? 0;
        $dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') ?? 0;
        $kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan') ?? 0;
        $lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan') ?? 0;
        $pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan') ?? 0;
        $total_jumlah = $hukum + $ekonomi + $kesehatan + $kelembagaan + $dakwah + $kemanusiaan + $lingkungan + $pendidikan;

        $program_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->count() ?? 0;
        $program_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count() ?? 0;
        $program_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count() ?? 0;
        $program_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->count() ?? 0;
        $program_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() ?? 0;
        $program_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() ?? 0;
        $program_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count() ?? 0;
        $program_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count() ?? 0;
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
        $pm_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->sum('jumlah_penerima') ?? 0;
        $pm_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima') ?? 0;
        $pm_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') ?? 0;
        $pm_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima') ?? 0;
        $pm_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') ?? 0;
        $pm_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') ?? 0;
        $pm_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima') ?? 0;
        $pm_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima') ?? 0;
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


        $datas = Pengajuan::orderBy('created_at', 'DESC')
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
            ->when($status_lpj == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
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


        $pdf->AddPage('L');


        // Load and render the first view
        $html2 = view('print.pdf_umum_upzis_realisasi_pengajuan', compact(
            'data',
            'id_upzis',
            'filter_daterange',
            'sub',
            'tings',
            'datas',
            'datas2'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html2, true, false, true, false, '');


        $pdf->AddPage('L');


        // Load and render the first view
        $html3 = view('print.pdf_umum_upzis_realisasi_penerima_manfaat', compact(
            'penerima_manfaat',
            'id_upzis',
            'filter_daterange',
            'sub',
            'tings',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html3, true, false, true, false, '');


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

    public function pdf_all_umum_laporan_ranting($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
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

        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        $id_upzis = $id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);

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

        $datas2 = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
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
        $ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan') ?? 0;
        $kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan') ?? 0;
        $kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan') ?? 0;
        $dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') ?? 0;
        $kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan') ?? 0;
        $lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan') ?? 0;
        $pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan') ?? 0;
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
        $pm_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima') ?? 0;
        $pm_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') ?? 0;
        $pm_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima') ?? 0;
        $pm_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') ?? 0;
        $pm_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') ?? 0;
        $pm_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima') ?? 0;
        $pm_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima') ?? 0;
        $pm_total_jumlah = $pm_hukum + $pm_ekonomi + $pm_kesehatan + $pm_kelembagaan + $pm_dakwah + $pm_kemanusiaan + $pm_lingkungan + $pm_pendidikan;

        $program_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->count() ?? 0;
        $program_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count() ?? 0;
        $program_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count() ?? 0;
        $program_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->count() ?? 0;
        $program_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() ?? 0;
        $program_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() ?? 0;
        $program_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count() ?? 0;
        $program_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count() ?? 0;
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

        $pdf->AddPage('L');
        // Load and render the first view
        $html2 = view('print.pdf_umum_upzis_realisasi_pengajuan', compact(
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
        $pdf->writeHTML($html2, true, false, true, false, '');

        $pdf->AddPage('L');


        // Load and render the first view
        $html3 = view('print.pdf_umum_upzis_realisasi_penerima_manfaat', compact(
            'penerima_manfaat',
            'id_upzis',
            'id_upzis2',
            'id_ranting2',
            'filter_daterange',
            'sub',
            'tings',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html3, true, false, true, false, '');

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

    public function pdf_all_umum_laporan_keseluruhan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        $tings = 'keseluruhan';
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

        $datas2 = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
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
        $ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan') ?? 0;
        $kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan') ?? 0;
        $kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan') ?? 0;
        $dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') ?? 0;
        $kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan') ?? 0;
        $lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan') ?? 0;
        $pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan') ?? 0;
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
        $pm_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima') ?? 0;
        $pm_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') ?? 0;
        $pm_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima') ?? 0;
        $pm_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') ?? 0;
        $pm_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') ?? 0;
        $pm_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima') ?? 0;
        $pm_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima') ?? 0;
        $pm_total_jumlah = $pm_hukum + $pm_ekonomi + $pm_kesehatan + $pm_kelembagaan + $pm_dakwah + $pm_kemanusiaan + $pm_lingkungan + $pm_pendidikan;

        $program_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->count() ?? 0;
        $program_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count() ?? 0;
        $program_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count() ?? 0;
        $program_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->count() ?? 0;
        $program_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() ?? 0;
        $program_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() ?? 0;
        $program_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count() ?? 0;
        $program_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count() ?? 0;
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


        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }

        //////////////// TabUpzis
        // request
        $id_upzis = $id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $status = $status;

        $datas = Pengajuan::orderBy('created_at', 'DESC')
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

        $pdf->AddPage('L');

        // Load and render the first view
        $html2 = view('print.pdf_umum_upzis_realisasi_pengajuan', compact(
            'data',
            'id_upzis',
            'id_upzis2',
            'filter_daterange',
            'sub',
            'tings',
            'datas'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html2, true, false, true, false, '');

        $pdf->AddPage('L');
        // Load and render the first view
        $html3 = view('print.pdf_umum_upzis_realisasi_penerima_manfaat', compact(
            'penerima_manfaat',
            'id_upzis',
            'id_upzis2',
            'filter_daterange',
            'sub',
            'tings',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html3, true, false, true, false, '');

        $nama_upzis = strtoupper(EksporPenerimaManfaat::get_nama_upzis($id_upzis2));
        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT RANTING BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = ' BERITA ACARA SERAH TERIMA LAPORAN AKHIR PENTASYARUFAN PER WILAYAH KECAMATAN ' . $nama_upzis .  ' PERIODE ' . $new_date_range . '.pdf';
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
    
    public function berita_acara_laporan_keseluruhan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        $tings = 'keseluruhan';
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

        $datas2 = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
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
        $ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan') ?? 0;
        $kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan') ?? 0;
        $kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan') ?? 0;
        $dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') ?? 0;
        $kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan') ?? 0;
        $lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan') ?? 0;
        $pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan') ?? 0;
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
        $pm_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima') ?? 0;
        $pm_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') ?? 0;
        $pm_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima') ?? 0;
        $pm_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') ?? 0;
        $pm_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') ?? 0;
        $pm_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima') ?? 0;
        $pm_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima') ?? 0;
        $pm_total_jumlah = $pm_hukum + $pm_ekonomi + $pm_kesehatan + $pm_kelembagaan + $pm_dakwah + $pm_kemanusiaan + $pm_lingkungan + $pm_pendidikan;

        $program_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->count() ?? 0;
        $program_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count() ?? 0;
        $program_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count() ?? 0;
        $program_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->count() ?? 0;
        $program_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() ?? 0;
        $program_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() ?? 0;
        $program_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count() ?? 0;
        $program_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count() ?? 0;
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

        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }

        //////////////// TabUpzis
        // request
        $id_upzis = $id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $status = $status;

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

        $nama_upzis = strtoupper(EksporPenerimaManfaat::get_nama_upzis($id_upzis2));
        if ($sub == 'pengajuan') {
            // Set the file name for the download
            $filename = 'DATA PENGAJUAN PENTASYARUFAN TINGKAT RANTING BERDASARKAN TGL KONFIRMASI PENGAJUAN PERIODE ' . $new_date_range . '.pdf';
        } elseif ($sub == 'laporan') {
            // Set the file name for the download
            $filename = ' BERITA ACARA SERAH TERIMA LAPORAN AKHIR PENTASYARUFAN PER WILAYAH KECAMATAN ' . $nama_upzis .  ' PERIODE ' . $new_date_range . '.pdf';
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
    
    public function berita_acara_laporan_upzis($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
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

        $datas2 = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.tgl_terbit_rekomendasi',

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


        $program = $datas2->get()->groupBy('pilar');

        $sum_pencairan = $datas2->sum('nominal_pencairan');
        $sum_penerima = $datas2->sum('jumlah_penerima');

        //nominal pencairan
        $hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->sum('nominal_pencairan') ?? 0;
        $ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan') ?? 0;
        $kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan') ?? 0;
        $kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan') ?? 0;
        $dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') ?? 0;
        $kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan') ?? 0;
        $lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan') ?? 0;
        $pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan') ?? 0;
        $total_jumlah = $hukum + $ekonomi + $kesehatan + $kelembagaan + $dakwah + $kemanusiaan + $lingkungan + $pendidikan;

        $program_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->count() ?? 0;
        $program_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count() ?? 0;
        $program_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count() ?? 0;
        $program_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->count() ?? 0;
        $program_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() ?? 0;
        $program_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() ?? 0;
        $program_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count() ?? 0;
        $program_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count() ?? 0;
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
        $pm_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->sum('jumlah_penerima') ?? 0;
        $pm_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima') ?? 0;
        $pm_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') ?? 0;
        $pm_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima') ?? 0;
        $pm_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') ?? 0;
        $pm_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') ?? 0;
        $pm_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima') ?? 0;
        $pm_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima') ?? 0;
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
    
    public function berita_acara_laporan_ranting($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
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

        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        $id_upzis = $id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);

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

        $datas2 = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
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
        $ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan') ?? 0;
        $kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan') ?? 0;
        $kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan') ?? 0;
        $dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') ?? 0;
        $kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan') ?? 0;
        $lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan') ?? 0;
        $pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan') ?? 0;
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
        $pm_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima') ?? 0;
        $pm_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') ?? 0;
        $pm_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima') ?? 0;
        $pm_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') ?? 0;
        $pm_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') ?? 0;
        $pm_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima') ?? 0;
        $pm_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima') ?? 0;
        $pm_total_jumlah = $pm_hukum + $pm_ekonomi + $pm_kesehatan + $pm_kelembagaan + $pm_dakwah + $pm_kemanusiaan + $pm_lingkungan + $pm_pendidikan;

        $program_hukum = $datas2->clone()->where('pilar', 'Hukum dan Keadilan')->count() ?? 0;
        $program_ekonomi = $datas2->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count() ?? 0;
        $program_kesehatan = $datas2->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count() ?? 0;
        $program_kelembagaan = $datas2->clone()->where('pilar', 'Operasional / Amil')->count() ?? 0;
        $program_dakwah = $datas2->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() ?? 0;
        $program_kemanusiaan = $datas2->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() ?? 0;
        $program_lingkungan = $datas2->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count() ?? 0;
        $program_pendidikan = $datas2->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count() ?? 0;
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

    public function pdf_all_umum_laporan_gabungan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        // dd('w');
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();

        if ($status == 'Semua') {
            $status = NULL;
        } else {
            $status = $status;
        }


        $tings = 'keseluruhan';
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



        $by_pilar = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.id_ranting',
                'pengajuan.tingkat',
            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
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
            })
            ->orWhereNotNull('pengajuan_detail.tgl_konfirmasi')->where('tingkat', 'PC')
            ->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                return $query->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                    if ($start_date2 == $end_date2) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date2);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date2)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date2);
                    }
                });
            })
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
            ->where('pencairan_status', 'Berhasil Dicairkan'); // Placed outside of the conditions related to LPJ and reporting

        $program = $by_pilar->get()->groupBy('pilar');



        $by_pilar_khusus_upran = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.id_ranting',
                'pengajuan.tingkat',
            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
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


        $by_pilar_khusus_pc = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.id_ranting',
                'pengajuan.tingkat',
            )
            ->WhereNotNull('pengajuan_detail.tgl_konfirmasi')->where('tingkat', 'PC')
            ->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                return $query->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                    if ($start_date2 == $end_date2) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date2);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date2)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date2);
                    }
                });
            })
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
            ->where('pencairan_status', 'Berhasil Dicairkan'); // Placed outside of the conditions related to LPJ and reporting


        $sum_pencairan = $by_pilar_khusus_upran->sum('nominal_pencairan') + $by_pilar_khusus_pc->sum('nominal_pencairan');
        $sum_penerima = $by_pilar_khusus_upran->sum('jumlah_penerima') + $by_pilar_khusus_pc->sum('jumlah_penerima');

        //nominal pencairan
        $hukum = $by_pilar_khusus_upran->clone()->where('pilar', 'Hukum dan Keadilan')->sum('nominal_pencairan')  + $by_pilar_khusus_pc->clone()->where('pilar', 'Hukum dan Keadilan')->sum('nominal_pencairan');
        $ekonomi = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan')  + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan');

        $kesehatan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan');
        $kelembagaan = $by_pilar_khusus_upran->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan');
        $dakwah = $by_pilar_khusus_upran->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan');
        $kemanusiaan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan');
        $lingkungan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan');
        $pendidikan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan');
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
        $pm_hukum = $by_pilar_khusus_upran->clone()->where('pilar', 'Hukum dan Keadilan')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'Hukum dan Keadilan')->sum('jumlah_penerima') ;
        $pm_ekonomi = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima') +  $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima')  ;
        $pm_kesehatan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') ;
        $pm_kelembagaan = $by_pilar_khusus_upran->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima') +  $by_pilar_khusus_pc->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima');
        $pm_dakwah = $by_pilar_khusus_upran->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') +  $by_pilar_khusus_pc->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima');
        $pm_kemanusiaan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') ;
        $pm_lingkungan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima')  ;
        $pm_pendidikan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima')  ;
        $pm_total_jumlah = $pm_hukum + $pm_ekonomi + $pm_kesehatan + $pm_kelembagaan + $pm_dakwah + $pm_kemanusiaan + $pm_lingkungan + $pm_pendidikan;

        $program_hukum = $by_pilar_khusus_upran->clone()->where('pilar', 'Hukum dan Keadilan')->count() +  $by_pilar_khusus_pc->clone()->where('pilar', 'Hukum dan Keadilan')->count()  ;
        $program_ekonomi = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count() +  $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count();
        $program_kesehatan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count();
        $program_kelembagaan = $by_pilar_khusus_upran->clone()->where('pilar', 'Operasional / Amil')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'Operasional / Amil')->count() ;
        $program_dakwah = $by_pilar_khusus_upran->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() +  $by_pilar_khusus_pc->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count();
        $program_kemanusiaan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() ;
        $program_lingkungan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count();
        $program_pendidikan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count();
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


        if ($id_upzis == 'semua') {
            $id_upzis = null;
        }

        if ($id_upzis2 == 'semua') {
            $id_upzis2 = null;
        }

        if ($id_ranting2  == 'semua') {
            $id_ranting2 = null;
        }

        //////////////// TabUpzis
        // request
        $id_upzis = $id_upzis;
        $daftar_upzis = $this->getDaftarUpzisOrRanting('upzis', NULL);
        $status = $status;

        $datas = Pengajuan::orderBy('created_at', 'DESC')
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


        if ($sub == 'laporan') {
            $pdf->AddPage('P');
            // Load and render the first view
            $html = view('print.serah_terima_laporan_gabungan', compact(
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

        $pdf->AddPage('L');


        // Load and render the first view
        $html1 = view('print.pdf_umum_gabungan', compact(
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

        $pdf->AddPage('L');

        // Load and render the first view
        $html2 = view('print.pdf_umum_upzis_realisasi_pengajuan', compact(
            'data',
            'id_upzis',
            'id_upzis2',
            'filter_daterange',
            'sub',
            'tings',
            'datas'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html2, true, false, true, false, '');



        $datas2_pc_umum = DB::table('pengajuan')
        ->join('pengajuan_detail', 'pengajuan_detail.id_pengajuan', '=', 'pengajuan.id_pengajuan')
        ->select(
            'pengajuan.*',
            'pengajuan_detail.*'
        )
        ->where('pengajuan.tingkat', 'PC')
        ->whereNotNull('pengajuan_detail.tgl_konfirmasi')

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
        ->when($start_date2 && $end_date2 && $start_date2 == $end_date2, function ($query) use ($start_date2) {
            return $query->whereDate('tgl_terbit_rekomendasi', $start_date2);
        })
        ->latest('tgl_terbit_rekomendasi');


    $data = $datas2_pc_umum->get();
    
    $id_pengajuan = $data->pluck('id_pengajuan')->toArray();
    // dd($id_pengajuan);

    $mustahik = DB::table($etasyaruf . '.pengajuan_penerima')
        ->whereIn('id_pengajuan', $id_pengajuan)
        ->get();
    
        $pdf->AddPage('L');

        $tingkat = 'Umum Lazisnu Cilacap';
        $html4 = view('print.pengajuan_pc', compact(
            'data',
            'filter_daterange2',
            'tingkat',
            'status',
            'mustahik'
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html4, true, false, true, false, '');

        $pdf->AddPage('L');
        // Load and render the first view
        $html3 = view('print.pdf_umum_gabungan_realisasi_penerima_manfaat', compact(
            'penerima_manfaat',
            'penerima_manfaat2',
            'id_upzis',
            'id_upzis2',
            'filter_daterange',
            'sub',
            'tings',
        ))->render();

        // Output the HTML content to the PDF
        $pdf->writeHTML($html3, true, false, true, false, '');

        $nama_upzis = strtoupper(EksporPenerimaManfaat::get_nama_upzis($id_upzis2));
    
            // Set the file name for the download
            $filename = ' BERITA ACARA SERAH TERIMA LAPORAN AKHIR PENTASYARUFAN KESELURUHAN (PC LAZISNU, UPZIS,RANTING) PERIODE ' . $new_date_range . '.pdf';
    
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
    
    public function berita_acara_laporan_gabungan($role, $status, $start_date, $end_date, $filter_daterange, $id_upzis, $id_upzis2, $id_ranting2, $status2, $filter_daterange2, $sub, $status_lpj, $status_lpj2)
    {
        // dd('w');
        $cek_status_berita = PengajuanDetail::where('status_berita', '!=', 'Sudah Diperiksa')->get();

        if ($status == 'Semua') {
            $status = NULL;
        } else {
            $status = $status;
        }


        $tings = 'keseluruhan';
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



        $by_pilar = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.id_ranting',
                'pengajuan.tingkat',
            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
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
            })
            ->orWhereNotNull('pengajuan_detail.tgl_konfirmasi')->where('tingkat', 'PC')
            ->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                return $query->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                    if ($start_date2 == $end_date2) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date2);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date2)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date2);
                    }
                });
            })
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
            ->where('pencairan_status', 'Berhasil Dicairkan'); // Placed outside of the conditions related to LPJ and reporting

        $program = $by_pilar->get()->groupBy('pilar');



        $by_pilar_khusus_upran = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.id_ranting',
                'pengajuan.tingkat',
            )
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->when($status_lpj2 == 'Belum Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
            })
            ->when($status_lpj2 == 'Selesai LPJ', function ($query) use ($cek_status_berita) {
                return $query->whereNotIn('pengajuan.id_pengajuan', $cek_status_berita->pluck('id_pengajuan')->toArray());
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


        $by_pilar_khusus_pc = PengajuanDetail::join('program_pilar', 'program_pilar.id_program_pilar', '=', 'pengajuan_detail.id_program_pilar')
            ->join('pengajuan', 'pengajuan.id_pengajuan', '=', 'pengajuan_detail.id_pengajuan')
            ->join('program_kegiatan', 'program_kegiatan.id_program_kegiatan', '=', 'pengajuan_detail.id_program_kegiatan')
            ->select(
                'pengajuan_detail.*',
                'program_pilar.pilar',
                'program_kegiatan.nama_program',
                'pengajuan.id_upzis',
                'pengajuan.id_ranting',
                'pengajuan.tingkat',
            )
            ->WhereNotNull('pengajuan_detail.tgl_konfirmasi')->where('tingkat', 'PC')
            ->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                return $query->when($start_date2 && $end_date2, function ($query) use ($start_date2, $end_date2) {
                    if ($start_date2 == $end_date2) {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '=', $start_date2);
                    } else {
                        return $query->whereDate('pengajuan_detail.tgl_konfirmasi', '>=', $start_date2)
                            ->whereDate('pengajuan_detail.tgl_konfirmasi', '<=', $end_date2);
                    }
                });
            })
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
            ->where('pencairan_status', 'Berhasil Dicairkan'); // Placed outside of the conditions related to LPJ and reporting


        $sum_pencairan = $by_pilar_khusus_upran->sum('nominal_pencairan') + $by_pilar_khusus_pc->sum('nominal_pencairan');
        $sum_penerima = $by_pilar_khusus_upran->sum('jumlah_penerima') + $by_pilar_khusus_pc->sum('jumlah_penerima');

        //nominal pencairan
        $hukum = $by_pilar_khusus_upran->clone()->where('pilar', 'Hukum dan Keadilan')->sum('nominal_pencairan')  + $by_pilar_khusus_pc->clone()->where('pilar', 'Hukum dan Keadilan')->sum('nominal_pencairan');
        $ekonomi = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan')  + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('nominal_pencairan');

        $kesehatan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('nominal_pencairan');
        $kelembagaan = $by_pilar_khusus_upran->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'Operasional / Amil')->sum('nominal_pencairan');
        $dakwah = $by_pilar_khusus_upran->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('nominal_pencairan');
        $kemanusiaan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('nominal_pencairan');
        $lingkungan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('nominal_pencairan');
        $pendidikan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('nominal_pencairan');
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
        $pm_hukum = $by_pilar_khusus_upran->clone()->where('pilar', 'Hukum dan Keadilan')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'Hukum dan Keadilan')->sum('jumlah_penerima') ;
        $pm_ekonomi = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima') +  $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->sum('jumlah_penerima')  ;
        $pm_kesehatan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->sum('jumlah_penerima') ;
        $pm_kelembagaan = $by_pilar_khusus_upran->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima') +  $by_pilar_khusus_pc->clone()->where('pilar', 'Operasional / Amil')->sum('jumlah_penerima');
        $pm_dakwah = $by_pilar_khusus_upran->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima') +  $by_pilar_khusus_pc->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->sum('jumlah_penerima');
        $pm_kemanusiaan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->sum('jumlah_penerima') ;
        $pm_lingkungan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->sum('jumlah_penerima')  ;
        $pm_pendidikan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima') + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->sum('jumlah_penerima')  ;
        $pm_total_jumlah = $pm_hukum + $pm_ekonomi + $pm_kesehatan + $pm_kelembagaan + $pm_dakwah + $pm_kemanusiaan + $pm_lingkungan + $pm_pendidikan;

        $program_hukum = $by_pilar_khusus_upran->clone()->where('pilar', 'Hukum dan Keadilan')->count() +  $by_pilar_khusus_pc->clone()->where('pilar', 'Hukum dan Keadilan')->count()  ;
        $program_ekonomi = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count() +  $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Berdaya (Ekonomi)')->count();
        $program_kesehatan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Sehat (Kesehatan)')->count();
        $program_kelembagaan = $by_pilar_khusus_upran->clone()->where('pilar', 'Operasional / Amil')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'Operasional / Amil')->count() ;
        $program_dakwah = $by_pilar_khusus_upran->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count() +  $by_pilar_khusus_pc->clone()->where('pilar', 'Pilar Dakwah dan Advokasi')->count();
        $program_kemanusiaan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care DAMAI (Dakwah & Kemanusiaan)')->count() ;
        $program_lingkungan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Hijau (Lingkungan)')->count();
        $program_pendidikan = $by_pilar_khusus_upran->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count() + $by_pilar_khusus_pc->clone()->where('pilar', 'NU Care Cerdas (Pendidikan)')->count();
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


        if ($sub == 'laporan') {
            $pdf->AddPage('P');
            // Load and render the first view
            $html = view('print.serah_terima_laporan_gabungan', compact(
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
    
            // Set the file name for the download
            $filename = ' BERITA ACARA SERAH TERIMA LAPORAN AKHIR PENTASYARUFAN KESELURUHAN (PC LAZISNU, UPZIS,RANTING) PERIODE ' . $new_date_range . '.pdf';
    
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
