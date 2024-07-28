<?php

namespace App\Http\Controllers;

use App\Models\Pc;
use App\Models\Notif;
use App\Models\Upzis;
use App\Models\Berita;
use App\Models\Ranting;
use App\Models\Pengguna;
use App\Models\FileBerita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BeritaUmumController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {

            $earsip = config('app.database_earsip');
            $siftnu = config('app.database_siftnu');
            $gocap = config('app.database_gocap');

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $ketua_upzis = Upzis::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis', '=', $gocap . '.upzis.id_upzis')
                    ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
                    ->get();

                // dd(Auth::user()->PcPengurus->Pc->id_pc);
                $id = Auth::user()->gocap_id_pc_pengurus;
                $role = 'pc';
                $nama = 'PC';
                $upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                    ->get();
                $ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                    ->get();


                $pengurus =  Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                    ->where($gocap . '.pc_pengurus.id_pc', Auth::user()->PcPengurus->id_pc)->where('id_pengguna', '!=', Auth::user()->id_pengguna)
                    ->get();
                $wilayah = Auth::user()->PcPengurus->Pc->Wilayah->nama;
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $ketua_upzis = Upzis::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis', '=', $gocap . '.upzis.id_upzis')
                    ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
                    ->get();
                $id = Auth::user()->gocap_id_upzis_pengurus;
                $role = 'upzis';
                $nama = 'UPZIS';
                $upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')->where('id_upzis', '!=', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                    ->get();
                $ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                    ->join($gocap . '.upzis', $gocap . '.upzis.id_upzis', '=', $gocap . '.ranting.id_upzis')->where($gocap . '.upzis.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                    ->get();


                $pengurus =  Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                    ->where($gocap . '.upzis_pengurus.id_upzis', Auth::user()->UpzisPengurus->id_upzis)->where('id_pengguna', '!=', Auth::user()->id_pengguna)
                    ->get();
                $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            } elseif (Auth::user()->gocap_id_ranting_pengurus != NULL) {
                $id = Auth::user()->gocap_id_ranting_pengurus;
                $role = 'ranting';
                $ranting = '';
                $nama = 'RANTING';
                $upzis = '';

                $pengurus = '';

                $wilayah = Auth::user()->RantingPengurus->Ranting->Wilayah->nama;
            }

            $akses = ['Semua Pengurus Internal', 'Semua UPZIS MWCNU', 'Semua Ranting NU'];

            $pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->get();

            $view->with('role', $role)


                ->with('nama', $nama)
                ->with('upzis', $upzis)
                ->with('pc', $pc)
                ->with('akses', $akses)
                ->with('ranting', $ranting)
                ->with('wilayah', $wilayah)
                ->with('ketua_upzis', $ketua_upzis)
                ->with('pengurus', $pengurus);
        });
    }

    public function berita()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'BERITA PENTASYARUFAN';
        $page = "Berita Pentasyarufan";
        $tahuns = '';
        $bulans = '';
        $kategoris = '';
        $tahun_berita = Berita::select(DB::raw('YEAR(tanggal_terbit) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $berita = DB::table('berita')->where('status', 'Sudah Terbit')->orderby('created_at', 'desc')->get();
        }

        return view('berita.berita', compact('tahun_berita', 'page', 'title', 'berita', 'tahuns', 'bulans', 'kategoris'));
    }

    public function tambah_berita()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'BERITA PENTASYARUFAN';
        $page = "Tambah Berita Pentasyarufan";

        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     $berita = DB::table('berita')->orderby('created_at', 'desc')->get();


        //     $berita = DB::table('berita')->orderby('created_at', 'desc')->get();
        // } elseif (Auth::user()->gocap_id_upzis_pengurus) {

        //     $berita = DB::table('berita')->orderby('created_at', 'desc')->get();
        // }

        return view('berita.tambah_berita', compact('page', 'title'));
    }

    function sendGCM($message, $title, $foto)
    {


        $url = 'https://fcm.googleapis.com/fcm/send';
        if ($foto) {

            $fields = array(
                'to' => "/topics/news",
                'notification' => array(
                    "image" => $foto,
                    "body" => $message,
                    'title' => $title
                )
            );
        } else {
            $fields = array(
                'to' => "/topics/news",
                'notification' => array(
                    "body" => $message,
                    'title' => $title
                )
            );
        }
        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAA24JcgU8:APA91bGwA9b6QzB3-_LFrwGNa45rJ0vuYGMFnT0wV9HK9OF0bts39KAx0Kikl2JL5V7fVXkvksQU4Bs1AKWiSwRklFL-UqR-KCMjTulytpp0yW0XM9tUqI7eYn30e5xVj5c07iK_KyTQ",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);
    }

    public function aksi_tambah_berita(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        if ($request->file('foto_background_berita')) {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('foto_background_berita')->getClientOriginalName())
            ) {

                return back()->with('error', 'File Upload Tidak Sesuai');
            }
        }

        if ($request->file('foto_dokumentasi_berita')) {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('foto_dokumentasi_berita')->getClientOriginalName())
            ) {

                return back()->with('error', 'File Upload Tidak Sesuai');
            }
        }

        $request->validate([
            'tanggal_terbit' => 'required',
            'kategori_berita' => 'required',
            'judul_berita' => 'required',
            'narasi_berita' => 'required',
            'judul_file_bg' =>  'required',
            'foto_background_berita' => 'required|max:10000|mimes:jpg,jpeg,png',
        ], [
            'tanggal_terbit.required' => 'Tanggal Terbit harus diisi',
            'kategori_berita.required' => 'Kategori Berita harus diisi',
            'judul_berita.required' => 'Judul Berita harus diisi',
            'judul_file_bg' => 'Judul File Berita harus diisi',
            'foto_background_berita' => 'Foto Background Berita harus diisi',
        ]);


        // dd($request->id_upzis);

        $id_notif = Str::uuid()->toString();
        $id_berita_umum = uniqid();

        $id_pc = Auth::user()->PcPengurus->Pc->id_pc;
        $id_upzis = $request->id_upzis;
        $id_ranting = $request->id_ranting;

        // dd($request->kategori_berita);
        if ($request->kategori_berita == 'Lazisnu Cilacap') {
            $id_pc = Auth::user()->PcPengurus->Pc->id_pc;
            $id_upzis = NULL;
            $id_ranting = NULL;
        }

        if (Auth::user()->gocap_id_pc_pengurus != null) {

            if ($request->foto_background_berita != null) {
                $file = $request->file('foto_background_berita');
                $ext_logo = $file->extension();
                $filename_bg = $file->storeAs('', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_background_berita']);



                Berita::create([
                    'id_berita_umum' => $id_berita_umum,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'kategori_berita' => $request->kategori_berita,
                    'hastag_berita' => implode(' , ', $request->hastag_berita),
                    'id_notif' => $id_notif,
                    'judul_berita' => $request->judul_berita,
                    'narasi_berita' => $request->narasi_berita,
                    'tanggal_terbit' => $request->tanggal_terbit,
                    'foto_background_berita' => $filename_bg,
                    'status' => 'Sudah Terbit',
                    // 'id_wilayah' => Auth::user()->PcPengurus->Pc->Wilayah->id_wilayah,
                    'id_pc' => $id_pc,
                    'id_upzis' => $id_upzis,
                    'id_ranting' => $id_ranting,
                ]);
                FileBerita::create([
                    'id_file_berita' => uniqid(),
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'id_berita_umum' => $id_berita_umum,
                    'judul_file' => $request->judul_file_bg,
                    'foto_background_berita' => $filename_bg,
                ]);

                if (strlen($request->judul_berita) >= 50) {
                    $int = 50;
                    $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s1 = strlen(substr($request->judul_berita, 0, $num_char));
                    $s2 = strlen($request->judul_berita);
                    $dot = '...';
                } else {
                    $num_char = 50;
                    $dot = '';
                }



                if (strlen($request->narasi_berita) >= 150) {
                    $agr = 150;
                    $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
                    $s22 = strlen($request->narasi_berita);
                    $dot2 = '...';
                } else {
                    $num_char2 = 150;
                    $dot2 = '';
                }


                Notif::create([
                    'id' => $id_notif,
                    'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
                    'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
                    'foto' => 'https://e-tasyaruf.nucarecilacap.id/uploads/foto_background_berita/' . $filename_bg,
                    'untuk' => 'semua',
                    'tentang' => 'penjemputan',
                ]);
            } else {

                Berita::create([
                    'id_berita_umum' => $id_berita_umum,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'kategori_berita' => $request->kategori_berita,
                    'hastag_berita' => implode(' , ', $request->hastag_berita),
                    'id_notif' => $id_notif,
                    'judul_berita' => $request->judul_berita,
                    'narasi_berita' => $request->narasi_berita,
                    'tanggal_terbit' => $request->tanggal_terbit,
                    'status' => 'Sudah Terbit',

                    // 'id_wilayah' => Auth::user()->PcPengurus->Pc->Wilayah->id_wilayah,
                    'id_pc' => $id_pc,
                    'id_upzis' => $id_upzis,
                    'id_ranting' => $id_ranting,
                ]);

                if (strlen($request->judul_berita) >= 50) {
                    $int = 50;
                    $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s1 = strlen(substr($request->judul_berita, 0, $num_char));
                    $s2 = strlen($request->judul_berita);
                    $dot = '...';
                } else {
                    $num_char = 50;
                    $dot = '';
                }



                if (strlen($request->narasi_berita) >= 150) {
                    $agr = 150;
                    $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
                    $s22 = strlen($request->narasi_berita);
                    $dot2 = '...';
                } else {
                    $num_char2 = 150;
                    $dot2 = '';
                }



                Notif::create([
                    'id' => $id_notif,
                    'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
                    'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
                    'foto' => null,
                    'untuk' => 'semua',
                    'tentang' => 'penjemputan',
                ]);
            }
        }

        if (Auth::user()->gocap_id_upzis_pengurus != null) {

            if ($request->foto_background_berita != null) {
                $file = $request->file('foto_background_berita');
                $ext_logo = $file->extension();
                $filename_bg = $file->storeAs('', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_background_berita']);

                Berita::create([
                    'id_berita_umum' => $id_berita_umum,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'kategori_berita' => $request->kategori_berita,
                    'hastag_berita' => implode(' , ', $request->hastag_berita),
                    'id_notif' => $id_notif,
                    'judul_berita' => $request->judul_berita,
                    'narasi_berita' => $request->narasi_berita,
                    'tanggal_terbit' => $request->tanggal_terbit,
                    'foto_background_berita' => $filename_bg,
                    // 'id_wilayah' =>  Auth::user()->PcPengurus->Pc->Wilayah->id_wilayah,
                ]);
                FileBerita::create([
                    'id_file_berita' => uniqid(),
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'id_berita_umum' => $id_berita_umum,
                    'judul_file' => $request->judul_file_bg,
                    'foto_background_berita' => $filename_bg,
                ]);

                if (strlen($request->judul_berita) >= 50) {
                    $int = 50;
                    $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s1 = strlen(substr($request->judul_berita, 0, $num_char));
                    $s2 = strlen($request->judul_berita);
                    $dot = '...';
                } else {
                    $num_char = 50;
                    $dot = '';
                }



                if (strlen($request->narasi_berita) >= 150) {
                    $agr = 150;
                    $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
                    $s22 = strlen($request->narasi_berita);
                    $dot2 = '...';
                } else {
                    $num_char2 = 150;
                    $dot2 = '';
                }



                Notif::create([
                    'id' => $id_notif,
                    'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
                    'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
                    'foto' => 'https://e-tasyaruf.nucarecilacap.id/uploads/foto_background_berita/' . $filename_bg,
                    'untuk' => 'semua',
                    'tentang' => 'penjemputan',
                ]);
            } else {

                if (strlen($request->judul_berita) >= 50) {
                    $int = 50;
                    $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s1 = strlen(substr($request->judul_berita, 0, $num_char));
                    $s2 = strlen($request->judul_berita);
                    $dot = '...';
                } else {
                    $num_char = 50;
                    $dot = '';
                }



                if (strlen($request->narasi_berita) >= 150) {
                    $agr = 150;
                    $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
                    $s22 = strlen($request->narasi_berita);
                    $dot2 = '...';
                } else {
                    $num_char2 = 150;
                    $dot2 = '';
                }



                Berita::create([
                    'id_berita_umum' => $id_berita_umum,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'kategori_berita' => $request->kategori_berita,
                    'hastag_berita' => implode(' , ', $request->hastag_berita),
                    'id_notif' => $id_notif,
                    'judul_berita' => $request->judul_berita,
                    'narasi_berita' => $request->narasi_berita,
                    'tanggal_terbit' => $request->tanggal_terbit,
                    // 'id_wilayah' =>  Auth::user()->PcPengurus->Pc->Wilayah->id_wilayah,
                ]);

                Notif::create([
                    'id' => $id_notif,
                    'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
                    'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
                    'foto' => null,
                    'untuk' => 'semua',
                    'tentang' => 'penjemputan',
                ]);
            }
        }


        if ($request->foto_dokumentasi_berita != null) {
            $file = $request->file('foto_dokumentasi_berita');
            $ext_logo2 = $file->extension();
            $filename_doc = $file->storeAs('', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo2, ['disk' => 'foto_dokumentasi_berita']);
            FileBerita::create([
                'id_file_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_berita_umum' => $id_berita_umum,
                'judul_file' => $request->judul_file_doc,
                'foto_dokumentasi_berita' => $filename_doc,
            ]);
        }

        if ($request->judul_files != null && $request->file('foto_dokumentasi_beritas') != null) {
            if ($request->judul_files && count($request->judul_files) > 0) {
                $a = 0;
                foreach ($request->file('foto_dokumentasi_beritas') as $index) {

                    $file = $index;
                    $ext_logo2 = $file->extension();
                    $filename_doc = $file->storeAs('', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo2, ['disk' => 'foto_dokumentasi_berita']);
                    $validatedData['id_file_berita'] = uniqid();
                    $validatedData['id_pengguna'] = Auth::user()->id_pengguna;
                    $validatedData['id_berita_umum'] = $id_berita_umum;
                    $validatedData['judul_file'] = $request->judul_files[$a];
                    $validatedData['foto_dokumentasi_berita'] = $filename_doc;
                    FileBerita::create($validatedData);

                    $a++;
                }
            }
        }

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        // alert()->success('Arsip Berita' . $cek . ' Berhasil Ditambahkan');



        if ($request->foto_background_berita != null) {
            $this->sendGCM("$request->judul_berita", "Berita Terbaru", "https://e-tasyaruf.nucarecilacap.id/uploads/foto_background_berita/$filename_bg");
        } else {
            $this->sendGCM("$request->judul_berita", "Berita Terbaru", null);
        }

        // alert()->success('Arsip Berita' . $cek . ' Berhasil Ditambahkan');

        return redirect('/' . $request->role . '/arsip/detail_berita/' . $id_berita_umum)->with('success', 'Data berhasil ditambahkan');
    }

    public function aksi_hapus_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $id_notif_berita =  Berita::where('id_berita_umum', $id)->first();
        $id_notif = $id_notif_berita->id_notif;
        Notif::where('id', $id_notif)->delete();

        $file_berita = FileBerita::where('id_berita_umum', $id)->whereNotNull('foto_dokumentasi_berita')->get();
        if ($file_berita != NULL) {
            foreach ($file_berita as $a) {
                $path = public_path() . "/uploads/foto_dokumentasi_berita/" .  $a->foto_dokumentasi_berita;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        $a =  Berita::where('id_berita_umum', $id)->first();
        if ($a->foto_background_berita != NULL) {
            $path = public_path() . "/uploads/foto_background_berita/" .  $a->foto_background_berita;
            if (file_exists($path)) {
                unlink($path);
            }
        }


        Berita::where('id_berita_umum', $id)->delete();


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }

        // alert()->success('Arsip Berita' . $cek . ' Berhasil Dihapus');
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/pc/arsip/berita');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/upzis/arsip/berita');
        }
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
        return 'Upzis MWCNU ' .  $a->nama_upzis;
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
        return 'PRNU ' . $a->nama_ranting;
    }

    public function detail_berita($id)
    {

        $ids = $id;
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $foto = DB::table('file_berita')->where('id_berita_umum', $id)->first();
        $foto_bg = DB::table('file_berita')->where('id_berita_umum', $id)->where('foto_background_berita', '!=', null)->first();
        $title = 'BERITA PENTASYARUFAN';
        $page = 'Detail Berita Pentasyarufan';

        $lampiran = DB::table('berita')->join('file_berita', 'file_berita.id_berita_umum', '=', 'berita.id_berita_umum')->where('berita.id_berita_umum', $id)->orderby('file_berita.created_at', 'desc')->get();
        $berita = DB::table('berita')->where('id_berita_umum', $id)->first();
        $id_berita_umum = $id;
        // dd($berita);
        return view('berita.detail_berita', compact('foto', 'title', 'page', 'lampiran', 'id_berita_umum', 'berita',  'ids', 'foto_bg'));
    }

    public function aksi_tambah_file_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($request->file('file') && $request->jenis == 'background') {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file')->getClientOriginalName())
            ) {

                return back()->with('error', 'File Upload Tidak Sesuai');
            }
        }

        if ($request->file('file') && $request->jenis == 'dokumentasi') {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file')->getClientOriginalName())
            ) {

                return back()->with('error', 'File Upload Tidak Sesuai');
            }
        }

        $request->validate([
            'file' => 'max:10000|mimes:jpg,jpeg,png',
        ], [

            'file' => 'Foto Background Berita harus diisi dan maximal size 10 MB',
        ]);


        if ($request->jenis == 'background') {
            $file = $request->file('file');
            $ext_logo = $file->extension();
            $filename_berita = $file->storeAs('', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_background_berita']);
            Fileberita::create([
                'id_file_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_berita_umum' => $id,
                'judul_file' => $request->judul_file,
                'foto_background_berita' => $filename_berita,
            ]);

            Berita::where('id_berita_umum', $id)->update([
                'foto_background_berita' => $filename_berita,
            ]);

            $id_notif_berita =  Berita::where('id_berita_umum',  $id)->first();
            $id_notif = $id_notif_berita->id_notif;
            Notif::where('id', $id_notif)->update([
                'foto' => $filename_berita,
            ]);
        } else {


            $file = $request->file('file');
            $ext_logo = $file->extension();
            $filename_berita = $file->storeAs('', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_dokumentasi_berita']);
            Fileberita::create([
                'id_file_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_berita_umum' => $id,
                'judul_file' => $request->judul_file,
                'foto_dokumentasi_berita' => $filename_berita,
            ]);
        }


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        // alert()->success('File Berita ' . $cek . ' Berhasil Ditambahkan');
        return back()->withInput(['tab' => 'lampiran_berita']);
    }

    public function aksi_edit_file_berita(Request $request, $id)
    {
        // dd($request->file_lama);



        if ($request->file('file') && $request->jenis == 'background') {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file')->getClientOriginalName())
            ) {

                return back()->with('error', 'File Upload Tidak Sesuai');
            }
        }

        if ($request->file('file') && $request->jenis == 'dokumentasi') {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file')->getClientOriginalName())
            ) {

                return back()->with('error', 'File Upload Tidak Sesuai');
            }
        }

        $request->validate([
            'file' => 'max:10000|mimes:jpg,jpeg,png',
        ], [

            'file' => 'Foto Background Berita harus diisi dan maximal size 10 MB',
        ]);


        if ($request->jenis == 'background') {
            if ($request->file) {
                $file = $request->file('file');
                $ext = $file->extension();
                $filename = $file->storeAs('', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'foto_background_berita']);

                $path = public_path() . "/uploads/foto_background_berita/" .  $request->file_lama;
                // dd($path);
                if (file_exists($path)) {
                    unlink($path);
                }

                $a =  FileBerita::where('id_file_berita', $id)->first();
                Berita::where('id_berita_umum', $a->id_berita_umum)->update([
                    'foto_background_berita' => $filename,
                ]);

                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                    'foto_background_berita' => $filename,
                ]);

                $id_notif_berita =  Berita::where('id_berita_umum',  $a->id_berita_umum)->first();
                $id_notif = $id_notif_berita->id_notif;
                Notif::where('id', $id_notif)->update([
                    'foto' => $filename,
                ]);
            } else {
                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                ]);
            }
        } else {
            if ($request->file) {
                $file = $request->file('file');
                $ext = $file->extension();
                $filename = $file->storeAs('', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'foto_dokumentasi_berita']);

                $path = public_path() . "/uploads/foto_dokumentasi_berita/" .  $request->file_lama;
                if (file_exists($path)) {
                    unlink($path);
                }

                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                    'foto_dokumentasi_berita' => $filename,
                ]);
            } else {
                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                ]);
            }
        }

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        // alert()->success('File Arsip Berita ' . $cek . ' Berhasil Diubah');



        return back()->withInput(['tab' => 'lampiran_berita']);
    }

    public function aksi_hapus_file_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // dd('wdwd_');

        $fil = FileBerita::where('id_file_berita', $id)->first();
        // $a =  FileBerita::where('id_file_berita', $id)->first();
        // Berita::where('id_berita_umum', $a->id_berita_umum)->update([
        //     'foto_background_berita' => $filename,
        // ]);

        if ($fil->foto_background_berita != null) {
            $a = FileBerita::where('id_file_berita', $id)->first();
            $path = public_path() . "/uploads/foto_background_berita/" .  $a->foto_background_berita;
            if (file_exists($path)) {
                unlink($path);
            }

            $b = Berita::where('foto_background_berita', $fil->foto_background_berita)->first();
            $path = public_path() . "/uploads/foto_background_berita/" .  $b->foto_background_berita;
            if (file_exists($path)) {
                unlink($path);
            }

            FileBerita::where('id_file_berita', $id)->delete();
            Berita::where('foto_background_berita', $fil->foto_background_berita)->update([
                'foto_background_berita' => null,
            ]);
        } else {
            $a = FileBerita::where('id_file_berita', $id)->first();
            $path = public_path() . "/uploads/foto_dokumentasi_berita/" .  $a->foto_dokumentasi_berita;
            if (file_exists($path)) {
                unlink($path);
            }
            FileBerita::where('id_file_berita', $id)->delete();
        }

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        // alert()->success('File Arsip Berita ' . $cek . ' Berhasil Dihapus');

        return back()->withInput(['tab' => 'lampiran_berita']);
    }

    public function aksi_edit_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // $request->validate([
        //     'tanggal_arsip' => 'required',
        //     'nama_dokumen' => 'required',
        //     'klasifikasi_dokumen' => 'required',
        //     'tujuan_arsip' => 'required',
        // ]);

        $id_notif_berita =  Berita::where('id_berita_umum', $id)->first();
        $id_notif = $id_notif_berita->id_notif;

        DB::table('berita')->where('id_berita_umum', $id)->update([
            'kategori_berita' => $request->kategori_berita,
            'hastag_berita' => implode(' , ', $request->hastag_berita),
            'judul_berita' => $request->judul_berita,
            'narasi_berita' => $request->narasi_berita,
            'id_pengguna' => Auth::user()->id_pengguna,
        ]);

        if (strlen($request->judul_berita) >= 50) {
            $int = 50;
            $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
            $s1 = strlen(substr($request->judul_berita, 0, $num_char));
            $s2 = strlen($request->judul_berita);
            $dot = '...';
        } else {
            $num_char = 50;
            $dot = '';
        }



        if (strlen($request->narasi_berita) >= 150) {
            $agr = 150;
            $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
            $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
            $s22 = strlen($request->narasi_berita);
            $dot2 = '...';
        } else {
            $num_char2 = 150;
            $dot2 = '';
        }


        Notif::where('id', $id_notif)->update([
            'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
            'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
        ]);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        // alert()->success('Arsip Berita ' . $cek . ' Berhasil Diubah');


        return Redirect()->back()->with('success', 'Data berhasil diubah');
    }
}
