<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengajuan;
use App\Models\Rekening;
use App\Models\Programs;
use App\Models\ProgramPilar;
use App\Models\ProgramKegiatan;
use App\Models\PengajuanDetail;
use App\Models\PengajuanDokumentasi;
use App\Models\PengajuanPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
// use Session;
use Illuminate\Support\Str;

class Helper extends Controller
{
    public static function getNamaPc($id)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $data = DB::table($gocap . '.pc')->where('id_pc', $id)
            ->join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
            ->select($siftnu . '.wilayah.nama as nama_pc')
            ->first();
        return str_replace('KAB. ', '', $data->nama_pc ?? null);
    }

    public static function getNamaRanting($id)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $data = DB::table($gocap . '.ranting')->where('id_ranting', $id)
            ->join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
            ->select($siftnu . '.wilayah.nama as nama_ranting')
            ->first();
        return  $data->nama_ranting ?? null;
    }

    public static function getNamaUpzis($id)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $data = DB::table($gocap . '.upzis')->where('id_upzis', $id)
            ->join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
            ->select($siftnu . '.wilayah.nama as nama_upzis')
            ->first();
        return $data->nama_upzis ?? null;
    }

    public static function getNamaPengurus($role, $id)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $a = DB::table($siftnu . '.pengguna')
            ->join($gocap . '.' . $role . '_pengurus', $gocap . '.' . $role . '_pengurus.id_' . $role . '_pengurus', '=', $siftnu . '.pengguna.gocap_id_' . $role . '_pengurus')
            ->where($gocap . '.' . $role . '_pengurus.status', '1')
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

    public static function getAlamatPengurus($role, $id)
    {
        $siftnu = config('app.database_siftnu');
        $a = DB::table($siftnu . '.pengguna')
            ->where('gocap_id_' . $role . '_pengurus', $id)
            ->first();
        return $a->alamat ?? NULL;
    }

    public static function getNohpPengurus($role, $id)
    {
        $siftnu = config('app.database_siftnu');
        $a = DB::table($siftnu . '.pengguna')
            ->where('gocap_id_' . $role . '_pengurus', $id)
            ->first();
        return $a->nohp ?? NULL;
        // return '085156916610';
    }

    public static function getNohpByIdJabatan($role, $id)
    {
        $gocap = config('app.database_gocap');
        $siftnu = config('app.database_siftnu');
        $a = DB::table($gocap . '.pengurus_jabatan')
            ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', $id)
            ->join($gocap . '.' . $role . '_pengurus', $gocap . '.' . $role . '_pengurus.id_pengurus_jabatan', '=', $gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_' . $role . '_pengurus', '=', $gocap . '.' . $role . '_pengurus.id_' . $role . '_pengurus')
            ->first();
            
        return $a->nohp ?? NULL;
        // return '085156916610';
    }

    public static function getNamaPengurusByIdJabatan($role, $id_upzis_ranting, $id_jabatan)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // dd($id_jabatan);
        $a = DB::table($gocap . '.pengurus_jabatan')
            ->where('tingkat', $role)
            ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', $id_jabatan)
            ->join($gocap . '.' . $role . '_pengurus', $gocap . '.' . $role . '_pengurus.id_pengurus_jabatan', '=', $gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_' . $role . '_pengurus', '=', $gocap . '.' . $role . '_pengurus.id_' . $role . '_pengurus')
            ->where($gocap . '.' . $role . '_pengurus.id_' . $role, $id_upzis_ranting)
            ->where($gocap . '.' . $role . '_pengurus.status', '1')
            ->select(
                $siftnu . '.pengguna.nama'
            )
            ->first();

        // dd($role);
        return $a->nama ?? '.........................';
    }
    public static function getJabatanPengurusByIdJabatan($role, $id_jabatan)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $a = DB::table($gocap . '.pengurus_jabatan')
            ->where('tingkat', $role)
            ->where('id_pengurus_jabatan', $id_jabatan)
            ->first();

        return $a->jabatan ?? '.........................';
    }
    public static function getDataPengurusByJabatan($role, $jabatan)
    {
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $a = DB::table($siftnu . '.pengguna')
            ->join($gocap . '.' . $role . '_pengurus', $gocap . '.' . $role . '_pengurus.id_' . $role . '_pengurus', '=', $siftnu . '.pengguna.gocap_id_' . $role . '_pengurus')
            ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.' . $role . '_pengurus.id_pengurus_jabatan')
            ->where($gocap . '.' . $role . '_pengurus.status', '1')
            ->where('jabatan', $jabatan)
            ->first();
        return $a ?? NULL;
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

    public static function getNamaBmtByIdRekening($id)
    {
        $gocap = config('app.database_gocap');
        $data = Rekening::where('id_rekening', $id)
            ->join($gocap . '.bmt', $gocap . '.bmt.id_bmt', '=', $gocap . '.rekening.id_bmt')
            ->first();
        return $data->nama_bmt ?? null;
    }

    public static function getDaftarPengurus($role, $id)
    {
        $gocap = config('app.database_gocap');
        $siftnu = config('app.database_siftnu');

        $daftar_pj = DB::table($gocap . '.upzis_pengurus')
            ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $gocap . '.upzis_pengurus.id_upzis_pengurus')
            ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
            ->select(
                $siftnu . '.pengguna.nama',
                $gocap . '.upzis_pengurus.id_upzis_pengurus',
                $gocap . '.pengurus_jabatan.jabatan',
            )
            ->where($gocap . '.upzis_pengurus.id_upzis',  $id)
            ->get();

        return $daftar_pj ?? NULL;
    }

    public static function getDataRekening($tingkat, $id)
    {
        if ($tingkat == 'Upzis MWCNU') {
            $data = Rekening::where('id_upzis', $id)
                ->where('id_ranting', NULL)
                ->where('nama_rekening', 'not like', '%GIRO%')
                ->get();
        } elseif ($tingkat == 'Ranting NU') {
            $data = Rekening::where('id_ranting', $id)
                ->get();
        }
        return $data ?? NULL;
    }

    public static function getDaftarProgram($tingkat)
    {
        if ($tingkat == 'Ranting NU') {
            $data = Programs::orderBy('created_at', 'DESC')
                ->whereNotIn('id_program', ['c51700b1-81a8-11ed-b4ef-dc215c5aad51'])
                ->get();
        } else {
            $data = Programs::orderBy('created_at', 'DESC')->get();
        }
        return $data ?? NULL;
    }

    public static function getDaftarPilarByProgram($id)
    {
        $data = ProgramPilar::where('id_program', $id)->orwhere('id_program2', $id)->orderBy('pilar', 'ASC')->get();
        return $data ?? NULL;
    }

    public static function getDaftarKegiatanByPilar($id)
    {
        $data = ProgramKegiatan::where('id_program_pilar', $id)
            ->whereRaw('LENGTH(no_urut) = 3')
            ->orderBy('no_urut', 'ASC')->get()->toArray();
        $data2 = ProgramKegiatan::where('id_program_pilar', $id)
            ->whereRaw('LENGTH(no_urut) = 4')
            ->orderBy('no_urut', 'ASC')->get()->toArray();

        return array_merge($data, $data2);
    }

    public static function getDataPilar($id)
    {
        $data = ProgramPilar::where('id_program_pilar', $id);
        return $data ?? NULL;
    }

    public static function getDataKegiatan($id)
    {
        $data = ProgramKegiatan::where('id_program_kegiatan', $id);
        return $data ?? NULL;
    }

    public static function getDataRekening2($id)
    {
        $gocap = config('app.database_gocap');
        $data = Rekening::where('id_rekening', $id)
            ->join($gocap . '.bmt', $gocap . '.bmt.id_bmt', '=', $gocap . '.rekening.id_bmt');
        return $data ?? NULL;
    }
    public static function getDataRekening4($tipe, $id)
    {
        $gocap = config('app.database_gocap');
        $data = Rekening::where('id_rekening', $id)
            ->join($gocap . '.bmt', $gocap . '.bmt.id_bmt', '=', $gocap . '.rekening.id_bmt');

        $nama_rek = $data->pluck('nama_rekening')->first() ?? null;
        $no_rek = $data->pluck('no_rekening')->first() ?? null;



        if ($tipe == 'bri') {
            if (str_contains($nama_rek, 'LEMBAGA')) {
                $nama_rek = 'Rek.Lembaga';
            } elseif (str_contains($nama_rek, 'SOSIAL')) {
                $nama_rek = 'Rek.Sosial';
            } elseif (str_contains($nama_rek, 'OPS')) {
                $nama_rek = 'Rek.Operasional';
            }
        } elseif ($tipe == 'bmt') {
            if (str_contains($nama_rek, 'LEMBAGA')) {
                $nama_rek = 'Rek.Lembaga';
            } elseif (str_contains($nama_rek, 'SOSIAL')) {
                $nama_rek = 'Rek.Sosial';
            } elseif (str_contains($nama_rek, 'OPERASIONAL')) {
                $nama_rek = 'Rek.Operasional';
            }
        }

        return $nama_rek . ' (' . $no_rek . ')';
    }

    public static function getDataRekening5($tingkat, $tipe, $id)
    {
        $gocap = config('app.database_gocap');
        $data = Rekening::where('id_ranting', $id)
            ->when($tipe == 'bri', function ($query) use ($gocap) {
                return $query->where($gocap . '.bmt.id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30']);
            })
            ->when($tipe == 'bmt', function ($query) use ($gocap) {
                return $query->whereNotIn($gocap . '.bmt.id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30']);
            })
            ->join($gocap . '.bmt', $gocap . '.bmt.id_bmt', '=', $gocap . '.rekening.id_bmt');

        return $data ?? null;
    }

    public static function getArrayRekening($id_pengajuan)
    {
        $a = PengajuanDetail::where('id_pengajuan', $id_pengajuan)
            ->whereNotNull('id_rekening')
            ->groupBy('id_rekening')->get();

        return $a ?? NULL;
    }

    public static function getNoRekening($id_rekening)
    {
        $a = Rekening::where('id_rekening', $id_rekening)->first();

        return $a->no_rekening ?? NULL;
    }

    public static function numberFormat($data)
    {
        $amount = $data;
        $formatted_amount = number_format(abs($amount), 0, '.', '.');
        $prefix = ($amount < 0) ? '-Rp' : 'Rp';
        return $prefix . $formatted_amount;
    }
}
