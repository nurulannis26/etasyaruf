<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pengajuan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PengajuanDetail;
use App\Models\PengajuanPenerimaLPJ;
use App\Models\PengajuanPenerima;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PengajuanPenerimaLPJImport;

class ImportPenerimaManfaatController extends Controller
{
    public function import_penerima_manfaat($id_pengajuan_detail)
    {
        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->first();
        $data = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();


        return view('import.import_penerima_manfaat', compact('data', 'data_detail'));
    }

    public function import_excel(Request $request)
    {
        // dd('dw');
        if ($request->file('file_penerima')) {
            if (preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file_penerima')->getClientOriginalName())) {
                // Alert::error('Error', 'Upload File Sesuai Extensi');
                // return back();
                $notification = array(
                    'message' => 'Upload File Sesuai Extensi !',
                    'alert-type' => 'error'
                );
                return redirect()->route('import_penerima_manfaat')->with($notification);
            }
        }

        // validasi
        $this->validate($request, [
            'file_penerima' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file_penerima');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_import_penerima_manfaat', $nama_file);

        // import data
        $import = new PengajuanPenerimaLPJImport();
        $rows = Excel::toCollection($import, public_path('/file_import_penerima_manfaat/' . $nama_file));

        $data_detail = $request->id_pengajuan_detail;
        $data = $request->id_pengajuan;
        // tampilkan preview
        return view('import.preview_import_penerima_manfaat', compact('rows', 'nama_file', 'data', 'data_detail'));
    }



    public function save(Request $request)
    {
        $nama_file = $request->input('nama_file');

        // Import data
        $import = new PengajuanPenerimaLPJImport();
        $rows = Excel::toCollection($import, public_path('/file_import_penerima_manfaat/' . $nama_file))->first();


        // Simpan data ke database
        foreach ($rows->toArray() as $row) {
            // Cek apakah baris kosong
            if (empty(array_filter($row))) {
                // Lewatkan baris kosong
                continue;
            }
            $tanggalExcel = $row[0];

            // Deteksi format
            if (is_numeric($tanggalExcel)) {
                // Jika formatnya numeric (serial number)
                $excelSerialDate = $tanggalExcel;
                $baseDate = Carbon::createFromDate(1900, 1, 1);
                $tanggalBantuan = $baseDate->addDays($excelSerialDate - 2)->format('Y-m-d');
                
                if (Auth::user()->gocap_id_upzis_pengurus) {
                    PengajuanPenerimaLPJ::create([
                        'id_pengajuan_penerima' => Str::uuid()->toString(),
                        'id_pengajuan' => $request->id_pengajuan,
                        'id_pengajuan_detail' => $request->id_pengajuan_detail,
                        'tgl_bantuan' => $tanggalBantuan,
                        'nama' => $row[1],
                        'nik' => $row[2],
                        'nokk' => $row[3],
                        'nohp' => $row[4],
                        'nominal_bantuan' => $row[5],
                        'jenis_bantuan' => $row[6],
                        'alamat' => $row[7],
                        'keterangan' => $row[8],
                        'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
                    ]);
                } elseif (Auth::user()->gocap_id_pc_pengurus) {
                    PengajuanPenerimaLPJ::create([
                        'id_pengajuan_penerima' => Str::uuid()->toString(),
                        'id_pengajuan' => $request->id_pengajuan,
                        'id_pengajuan_detail' => $request->id_pengajuan_detail,
                        'tgl_bantuan' => $tanggalBantuan,
                        'nama' => $row[1],
                        'nik' => $row[2],
                        'nokk' => $row[3],
                        'nohp' => $row[4],
                        'nominal_bantuan' => $row[5],
                        'jenis_bantuan' => $row[6],
                        'alamat' => $row[7],
                        'keterangan' => $row[8],
                        'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
                    ]);
                }                                                                                                                                                           
            } else {
                // Jika formatnya adalah tanggal (misalnya "01/04/2024")
                list($day, $month, $year) = explode('/', $tanggalExcel);
                $baseDate = Carbon::createFromDate($year, $month, $day);
                $tanggalBantuan = $baseDate->format('Y-m-d');
                
                if (Auth::user()->gocap_id_upzis_pengurus) {
                    PengajuanPenerimaLPJ::create([
                        'id_pengajuan_penerima' => Str::uuid()->toString(),
                        'id_pengajuan' => $request->id_pengajuan,
                        'id_pengajuan_detail' => $request->id_pengajuan_detail,
                        'tgl_bantuan' => $tanggalBantuan,
                        'nama' => $row[1],
                        'nik' => $row[2],
                        'nokk' => $row[3],
                        'nohp' => $row[4],
                        'nominal_bantuan' => $row[5],
                        'jenis_bantuan' => $row[6],
                        'alamat' => $row[7],
                        'keterangan' => $row[8],
                        'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
                    ]);
                } elseif (Auth::user()->gocap_id_pc_pengurus) {
                    PengajuanPenerimaLPJ::create([
                        'id_pengajuan_penerima' => Str::uuid()->toString(),
                        'id_pengajuan' => $request->id_pengajuan,
                        'id_pengajuan_detail' => $request->id_pengajuan_detail,
                        'tgl_bantuan' => $tanggalBantuan,
                        'nama' => $row[1],
                        'nik' => $row[2],
                        'nokk' => $row[3],
                        'nohp' => $row[4],
                        'nominal_bantuan' => $row[5],
                        'jenis_bantuan' => $row[6],
                        'alamat' => $row[7],
                        'keterangan' => $row[8],
                        'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
                    ]);
                }
            }
            
            
        }

        // Hapus file setelah berhasil mengimpor
        File::delete(public_path('/file_import_penerima_manfaat/' . $nama_file));


        $notification = array(
            'message' => 'Import Berhasil !',
            'alert-type' => 'success'
        );

        $data_detail = $request->id_pengajuan_detail;
        return redirect()->route('import_penerima_manfaat', ['id_pengajuan_detail' => $data_detail])->with($notification);
    }


    public function cancel(Request $request)
    {

        $notification = array(
            'message' => 'Import Dibatalkan !',
            'alert-type' => 'error'
        );

        $data_detail = $request->id_pengajuan_detail;
        return redirect()->route('import_penerima_manfaat', ['id_pengajuan_detail' => $data_detail])->with($notification);
    }
    
    public function import_penerima_manfaat_pc($id_pengajuan_detail)
    {
        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->first();
        $data = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();


        return view('import.import_penerima_manfaat_pc', compact('data', 'data_detail'));
    }
    
    public function cancel_pc(Request $request)
    {

        $notification = array(
            'message' => 'Import Dibatalkan !',
            'alert-type' => 'error'
        );

        $data_detail = $request->id_pengajuan_detail;
        return redirect()->route('import_penerima_manfaat_pc', ['id_pengajuan_detail' => $data_detail])->with($notification);
    }
    
    public function save_pc(Request $request)
    {
        $nama_file = $request->input('nama_file');

        // Import data
        $import = new PengajuanPenerimaLPJImport();
        $rows = Excel::toCollection($import, public_path('/file_import_penerima_manfaat_pc/' . $nama_file))->first();

        // Simpan data ke database
    foreach ($rows->toArray() as $row) {
        // Cek apakah baris kosong
        if (empty(array_filter($row))) {
            // Lewatkan baris kosong
            continue;
        }

    $tanggalExcel = $row[0];
    if (is_numeric($tanggalExcel)) {
        // Jika formatnya numeric (serial number)
        $excelSerialDate = $tanggalExcel;
        $baseDate = Carbon::createFromDate(1900, 1, 1);
        $tanggalBantuan = $baseDate->addDays($excelSerialDate - 2)->format('Y-m-d');

        if (Auth::user()->gocap_id_pc_pengurus) {
            PengajuanPenerima::create([
                'id_pengajuan_penerima' => Str::uuid()->toString(),
                'id_pengajuan' => $request->id_pengajuan,
                'id_pengajuan_detail' => $request->id_pengajuan_detail,
                'tgl_penyaluran' => $tanggalBantuan,
                'nama' => $row[1],
                'nik' => $row[2],
                'nokk' => $row[3],
                'nohp' => $row[4],
                'nominal_bantuan' => $row[5],
                'jenis_bantuan' => $row[6],
                'alamat' => $row[7],
                'keterangan' => $row[8],
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);
        }
    } else {
        // Jika formatnya adalah tanggal (misalnya "01/04/2024")
        list($day, $month, $year) = explode('/', $tanggalExcel);
        $baseDate = Carbon::createFromDate($year, $month, $day);
        $tanggalBantuan = $baseDate->format('Y-m-d');

        if (Auth::user()->gocap_id_pc_pengurus) {
            PengajuanPenerima::create([
                'id_pengajuan_penerima' => Str::uuid()->toString(),
                'id_pengajuan' => $request->id_pengajuan,
                'id_pengajuan_detail' => $request->id_pengajuan_detail,
                'tgl_penyaluran' => $tanggalBantuan,
                'nama' => $row[1],
                'nik' => $row[2],
                'nokk' => $row[3],
                'nohp' => $row[4],
                'nominal_bantuan' => $row[5],
                'jenis_bantuan' => $row[6],
                'alamat' => $row[7],
                'keterangan' => $row[8],
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);
        }
    }
}


        // Hapus file setelah berhasil mengimpor
        File::delete(public_path('/file_import_penerima_manfaat_pc/' . $nama_file));


        $notification = array(
            'message' => 'Import Berhasil !',
            'alert-type' => 'success'
        );

        $data_detail = $request->id_pengajuan_detail;
        return redirect()->route('import_penerima_manfaat_pc', ['id_pengajuan_detail' => $data_detail])->with($notification);
    }
    
    public function import_excel_pc(Request $request)
    {
        // dd('dw');
        if ($request->file('file_penerima')) {
            if (preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file_penerima')->getClientOriginalName())) {
                // Alert::error('Error', 'Upload File Sesuai Extensi');
                // return back();
                $notification = array(
                    'message' => 'Upload File Sesuai Extensi !',
                    'alert-type' => 'error'
                );
                return redirect()->route('import_penerima_manfaat_pc')->with($notification);
            }
        }

        // validasi
        $this->validate($request, [
            'file_penerima' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file_penerima');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_import_penerima_manfaat_pc', $nama_file);

        // import data
        $import = new PengajuanPenerimaLPJImport();
        $rows = Excel::toCollection($import, public_path('/file_import_penerima_manfaat_pc/' . $nama_file));

        $data_detail = $request->id_pengajuan_detail;
        $data = $request->id_pengajuan;
        // tampilkan preview
        return view('import.preview_import_penerima_manfaat_pc', compact('rows', 'nama_file', 'data', 'data_detail'));
    }
}
