<?php

use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPengajuanController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\FilterBeritaController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\PrintPengajuanController;
use App\Http\Controllers\BeritaUmumController;
use App\Http\Controllers\Select2Controller;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportPenerimaManfaatController;
use App\Http\Controllers\WatermarkPDFController;
use App\Http\Controllers\PrintPenyaluranController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\LaporanGabunganController;
use App\Http\Controllers\EksporPenerimaManfaat;
use App\Http\Controllers\EksporAllLaporanController;
use App\Http\Controllers\JurnalUmumController;
use App\Http\Controllers\GenerateNomorController;


Route::get('data-pilar/{id}', [Select2Controller::class, 'munculPilar'])->name('munculPilar');
Route::get('jenis-program/{id}', [Select2Controller::class, 'jenis_program'])->name('jenis_program');
// Route::get('/test-error', function () {
//     throw new Exception('Ini adalah pesan error!');
// });

// landing page
Route::get('/', function () {
    return view('main');
});

// // login local
// Route::middleware('guest')->group(function () {
//     Route::get('/login', function () {
//         // dd('as');
//         return view('login.login');
//     })->name('login');
//     Route::get('/', function () {
//         return view('login.login');
//     })->name('login');
//     Route::post('/login_ver', [LoginController::class, 'verifikasi'])->name('login.action');
// });


// login
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        // dd('as');
        return view('login.login');
    })->name('login');
    Route::get('/', function () {
        return view('login.login');
    });
    Route::post('/login_ver', [LoginController::class, 'verifikasi'])->name('login.action');
});

Route::get('/home', [LoginController::class, 'logout']);
Route::get('/notif', [NotifController::class, 'notif'])->name('notifi');
Route::get('/cetak_dokumen_survey/{id_pengajuan_detail}', [PengajuanController::class, 'cetak_dokumen_survey'])->name('cetak_dokumen_survey');
Route::get('/print_jurnal_umum/{id}', [JurnalUmumController::class, 'print_jurnal_umum'])->name('print_jurnal_umum');
 
Route::middleware('auth')->group(function () {

    // lazisnu
    Route::prefix('pc')->name('pc.')->middleware('pc')->group(function () {

        Route::get('/berita_acara_umum_pc/{id_pengajuan_detail}', [PrintController::class, 'berita_acara_umum_pc']);

        //filter bantuan untuk diagram dashboard umum
        Route::post('/filter_dashboard_post', [DashboardController::class, 'filter_dashboard_post']);
        //untuk upzis
        Route::get('/filter_dashboard_upzis/{c_filter_bulan}/{c_filter_tahun}/{c_filter_status}/{c_filter_id_upzis}', [DashboardController::class, 'filter_upzis'])->name('filter_dashboard_upziss');
        //untuk ranting
        Route::get('/filter_dashboard_ranting/{c_filter_bulan}/{c_filter_tahun}/{c_filter_status}/{c_filter_id_upzis}/{c_filter_id_ranting}', [DashboardController::class, 'filter_ranting'])->name('filter_dashboard_rantings');
        //untuk pc umum
        Route::get('/filter_dashboard_pc_umum/{c_filter_bulan}/{c_filter_tahun}/{c_filter_status}/{c_filter_kategori}/{c_filter_pilar}', [DashboardController::class, 'filter_pc_umum']);
        //internal pc
        Route::get('/filter_dashboard_internal_pc/{c_filter_bulan}/{c_filter_tahun}/{c_filter_status}/{c_filter_tujuan}', [DashboardController::class, 'filter_internal_pc']);

        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/detail-program', [ProgramController::class, 'detail_program']);
        Route::get('/internalpc-pc', [PengajuanController::class, 'internalpc_pc'])->name('internal');
         Route::get('/laporan-internalpc-pc', [PengajuanController::class, 'laporan_internal'])->name('laporan_internal');

        Route::get('/lap-internalpc-pc', [PengajuanController::class, 'lap_internalpc_pc'])->name('lap_internal');

        Route::get('/detail-pengajuan-internal-pc/{id_internal}', [PengajuanController::class, 'detail_pengajuan_internal_pc']);
        Route::get('/detail-pengajuan-pc/{id_pengajuan}', [PengajuanController::class, 'detail_pengajuan_pc']);
        Route::get('/detail-pengajuan-upzis/{id_pengajuan}', [PengajuanController::class, 'detail_pengajuan_upzis']);
        Route::get('/detail-pengajuan-ranting', [PengajuanController::class, 'detail_pengajuan_ranting']);
        Route::get('/program', [ProgramController::class, 'program']);
        Route::get('/internal{id_internal}/{nomor_surat}', [PrintController::class, 'internal']);
        Route::get('/internal/pdf', [PrintController::class, 'pdf']);
        Route::get('/berita_print', [PrintController::class, 'berita']);
        Route::get('/survey/{id}', [PrintController::class, 'survey']);
        Route::get('/print_penggunaan_dana/{id_internal}', [PrintController::class, 'print_penggunaan_dana']);
        Route::get('/print_penggunaan_dana_umum/{id_pengajuan_detail}', [PrintController::class, 'print_penggunaan_dana_umum']);
        Route::get('/tampil_penerima_manfaat/{id_pengajuan}', [PrintController::class, 'tampil_penerima_manfaat']);

        //Berita
        Route::get('/arsip/berita', [BeritaUmumController::class, 'berita'])->name('berita');
        // Route::get('/arsip/kategori_berita', [BeritaUmumController::class, 'kategori_berita'])->name('kategori_berita');
        Route::get('/arsip/tambah_berita', [BeritaUmumController::class, 'tambah_berita'])->name('tambah_berita');
        // Route::post('/aksi_tambah_kategori_berita', [BeritaUmumController::class, 'aksi_tambah_kategori_berita'])->name('aksi_tambah_kategori_berita');
        // Route::put('/aksi_edit_kategori_berita/{id}', [BeritaUmumController::class, 'aksi_edit_kategori_berita'])->name('aksi_edit_kategori_berita');
        // Route::post('/aksi_hapus_kategori_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_kategori_berita'])->name('aksi_hapus_kategori_berita');
        Route::post('/aksi_tambah_berita', [BeritaUmumController::class, 'aksi_tambah_berita'])->name('aksi_tambah_berita');
        Route::post('/aksi_hapus_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_berita'])->name('aksi_hapus_berita');
        Route::get('/arsip/detail_berita/{id}', [BeritaUmumController::class, 'detail_berita'])->name('detail_berita');
        Route::put('/arsip/aksi_edit_berita/{id}', [BeritaUmumController::class, 'aksi_edit_berita'])->name('aksi_edit_berita');
        Route::post('/filter/berita', [FilterBeritaController::class, 'filter_berita'])->name('filter_berita');
        
        Route::get('/unduh-lampiran/{id_pengajuan_lampiran}', [PrintController::class, 'cetak_lampiran']);
        Route::get('/unduh-lpj/{id_pengajuan_lpj}', [PrintController::class, 'cetak_lpj']);

        //FILE BERITA
        Route::post('/arsip/aksi_edit_file_berita/{id}', [BeritaUmumController::class, 'aksi_edit_file_berita'])->name('aksi_edit_file_berita');
        Route::post('/arsip/aksi_tambah_file_berita/{id}', [BeritaUmumController::class, 'aksi_tambah_file_berita'])->name('aksi_tambah_file_berita');
        Route::post('/arsip/aksi_hapus_file_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_file_berita'])->name('aksi_hapus_file_berita');

        Route::get('/kwitansi_pencairan/{id_internal}', [PrintController::class, 'print_kwitansi']);
         Route::get('/kwitansi_pencairan_umum/{id_pengajuan_detail}', [PrintController::class, 'print_kwitansi_umum']);
        // //filter bantuan untuk diagram upzis umum
        // Route::post('/filter_upzis_post', [PengajuanController::class, 'filter_upzis_post']);
        // Route::get('/filter_upzis/{c_start_date}/{c_end_date}/{c_filter_status}/{c_filter_id_upzis}', [PengajuanController::class, 'filter_upzis'])->name('filter_upziss');
        // //filter bantuan untuk diagram ranting umum
        // Route::post('/filter_ranting_post', [PengajuanController::class, 'filter_ranting_post']);
        // Route::get('/filter_ranting/{c_start_date2}/{c_end_date2}/{c_filter_status}/{c_filter_id_upzis}/{c_filter_id_ranting}', [PengajuanController::class, 'filter_ranting'])->name('filter_rantings');

        //filter bantuan untuk diagram pc umum
        Route::post('/filter_pc_umum_post', [PengajuanController::class, 'filter_pc_umum_post']);
        Route::get('/filter_pc_umum/{c_filter_daterange2}/{c_filter_status}/{c_filter_kategori}/{c_filter_pilar}/{sub}', [PengajuanController::class, 'filter_pc_umum']);

        //filter bantuan untuk diagram pc umum laporan
        Route::post('/laporan_filter_pc_umum_post', [PengajuanController::class, 'laporan_filter_pc_umum_post']);
        Route::get('/laporan_filter_pc_umum/{c_filter_daterange2}/{c_filter_status}/{c_filter_kategori}/{c_filter_pilar}/{sub}', [PengajuanController::class, 'laporan_filter_pc_umum']);
        
        //filter bantuan untuk diagram internal pc
        Route::post('/filter_internal_pc_post', [PengajuanController::class, 'filter_internal_pc_post']);
        Route::get('/filter_internal_pc/{c_filter_daterange}/{c_filter_status}/{c_filter_tujuan}/{sub}', [PengajuanController::class, 'filter_internal_pc']);
        
        //filter bantuan untuk diagram internal pc LAPORAN
        Route::post('/laporan_filter_internal_pc_post', [PengajuanController::class, 'laporan_filter_internal_pc_post']);
        Route::get('/laporan_filter_internal_pc/{c_filter_daterange}/{c_filter_status}/{c_filter_tujuan}/{sub}', [PengajuanController::class, 'laporan_filter_internal_pc']);
        
        // cetak pdf
        Route::get('/print_daftar_pengajuan/{tingkat}/{tanggal_mulai}/{tanggal_selesai}/{id_program}/{id_wilayah}', [PrintController::class, 'print_daftar_pengajuan']);
        Route::get('/print_upzis/{bulan}/{tahun}/{status}/{upzis}', [PrintPengajuanController::class, 'print_upzis']);
        Route::get('/print_ranting/{bulan}/{tahun}/{status}/{upzis}/{ranting}', [PrintPengajuanController::class, 'print_ranting']);
        Route::get('/print_pc/{filter_daterange2}/{status}', [PrintPengajuanController::class, 'print_pc']);
        // Route::get('/print_pc_laporan/{filter_daterange2}/{status}/{kategori}/{pilar}', [PrintPengajuanController::class, 'print_pc_laporan']);
        Route::get('/print_internal/{filter_daterange}/{status}/{tujuan}', [PrintPengajuanController::class, 'print_internal']);
        Route::get('/print_internal_laporan/{filter_daterange}/{status}/{tujuan}', [PrintPengajuanController::class, 'print_internal_laporan']);
        Route::get('/laporan/{id_pengajuan}', [PrintController::class, 'laporan']);

        Route::get('/laporan-excel/{id_pengajuan}', [PrintController::class, 'laporan_excel']);

        Route::get('/print_internal_excel/{filter_daterange}/{status}/{tujuan}', [PrintPengajuanController::class, 'print_internal_excel']);
        Route::get('/print_internal_excel_laporan/{filter_daterange}/{status}/{tujuan}', [PrintPengajuanController::class, 'print_internal_excel_laporan']);

        // on working
        Route::get('/print_berita_acara_pc', [PrintController::class, 'berita_pc']);
        Route::get('/berita_acara/{id_pengajuan_detail}', [PrintController::class, 'berita_upzis_ranting']);
        Route::get('/berita_serah_terima/{id_pengajuan_detail}', [PrintController::class, 'berita_serah_terima']);


        // update
        Route::get('/upzis-ranting', [PengajuanController::class, 'upzis_ranting2']);
        Route::get('/lap-upzis-ranting', [PengajuanController::class, 'lap_upzis_ranting2']);
        Route::get('/laporan_upzis_ranting', [PengajuanController::class, 'laporan_upzis_ranting']);
        Route::get('/laporan_upzis_ranting_keseluruhan', [PengajuanController::class, 'laporan_upzis_ranting_keseluruhan']);
          Route::get('/laporan_gabungan', [LaporanGabunganController::class, 'laporan_gabungan']);
        Route::post('/filter_umum_upzis', [PengajuanController::class, 'filter_umum_upzis']);
        Route::post('/filter_umum_upzis_laporan', [PengajuanController::class, 'filter_umum_upzis_laporan']);
        Route::post('/filter_umum_ranting', [PengajuanController::class, 'filter_umum_ranting']);
        Route::post('/filter_umum_ranting_laporan', [PengajuanController::class, 'filter_umum_ranting_laporan']);
        Route::post('/filter_umum_laporan_upzis_ranting_keseluruhan', [PengajuanController::class, 'filter_umum_laporan_upzis_ranting_keseluruhan']);
        Route::post('/filter_laporan_gabungan_keseluruhan', [LaporanGabunganController::class, 'filter_laporan_gabungan_keseluruhan']);
        Route::get('/detail-pengajuan/{id_pengajuan}', [DetailPengajuanController::class, 'index']);

        Route::get('/pengajuan_hapus/{id_pengajuan}', [PengajuanController::class, 'delete']);
        Route::get('/upzis-ranting/{upzis}/{tahun}', [GenerateNomorController::class, 'GenerateNomor']);
        Route::get('/generate-upzis/{upzis}/{tahun}', [GenerateNomorController::class, 'GenerateUpzis']);
        Route::get('/generate-kwitansi/{tahun}', [GenerateNomorController::class, 'GenerateKwitansi']);
        Route::get('/generate-kwitansi-internal/{tahun}', [GenerateNomorController::class, 'GenerateKwitansiInternal']);
        Route::get('/ketua/{tahun}', [GenerateNomorController::class, 'GenerateKetua']);
        Route::get('/umum-pc/{tahun}', [GenerateNomorController::class, 'GenerateUmum']);
        Route::get('/move-files', [GenerateNomorController::class, 'moveFilesToParentFolder']);
    });

    // upzis
    Route::prefix('upzis')->name('upzis.')->middleware('upzis')->group(function () {

        //filter bantuan untuk diagram dashboard umum
        Route::post('/filter_dashboard_post', [DashboardController::class, 'filter_dashboard_post']);
        //untuk upzis
        Route::get('/filter_dashboard_upzis/{c_filter_bulan}/{c_filter_tahun}/{c_filter_status}/{c_filter_id_upzis}', [DashboardController::class, 'filter_upzis'])->name('filter_dashboard_upziss');
        //untuk ranting
        Route::get('/filter_dashboard_ranting/{c_filter_bulan}/{c_filter_tahun}/{c_filter_status}/{c_filter_id_upzis}/{c_filter_id_ranting}', [DashboardController::class, 'filter_ranting'])->name('filter_dashboard_rantings');
        //untuk pc umum
        Route::get('/filter_dashboard_pc_umum/{c_filter_bulan}/{c_filter_tahun}/{c_filter_status}/{c_filter_kategori}/{c_filter_pilar}', [DashboardController::class, 'filter_pc_umum']);
        //internal pc
        Route::get('/filter_dashboard_internal_pc/{c_filter_bulan}/{c_filter_tahun}/{c_filter_status}/{c_filter_tujuan}', [DashboardController::class, 'filter_internal_pc']);

        //filter bantuan untuk diagram pc umum
        Route::post('/filter_pc_umum_post', [PengajuanController::class, 'filter_pc_umum_post']);
        Route::get('/filter_pc_umum/{c_filter_daterange2}/{c_filter_status}/{c_filter_kategori}/{c_filter_pilar}/{sub}', [PengajuanController::class, 'filter_pc_umum']);
        //filter bantuan untuk diagram pc umum laporan
        Route::post('/laporan_filter_pc_umum_post', [PengajuanController::class, 'laporan_filter_pc_umum_post']);
        Route::get('/laporan_filter_pc_umum/{c_filter_daterange2}/{c_filter_status}/{c_filter_kategori}/{c_filter_pilar}/{sub}', [PengajuanController::class, 'laporan_filter_pc_umum']);
        
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/detail-pengajuan-upzis/{id_pengajuan}', [PengajuanController::class, 'detail_pengajuan_upzis']);
        Route::get('/detail-pengajuan-ranting/{id_pengajuan}', [PengajuanController::class, 'detail_pengajuan_ranting']);
        Route::get('/print{id_pengajuan}/{nomor_surat}', [PrintController::class, 'print']);
        Route::get('/rekomendasi/{tipe}/{id_pengajuan}/{nomor_surat}', [PrintController::class, 'rekomendasi']);
        Route::get('/perorangan-entitas', [PenerimaController::class, 'perorangan_entitas']);
        Route::get('/kategori', [KategoriController::class, 'kategori']);
        Route::get('/program', [ProgramController::class, 'program']);
        Route::get('/permohonan', [PermohonanController::class, 'index']);
        Route::get('/detail_permohonan/{id_permohonan}', [PermohonanController::class, 'detail']);

        Route::get('/print_daftar_pengajuan/{tingkat}/{tanggal_mulai}/{tanggal_selesai}/{id_program}/{id_upzis_or_ranting}', [PrintController::class, 'print_daftar_pengajuan']);
        Route::get('/print_rekomendasi_pencairan/{id_permohonan}', [PrintController::class, 'print_rekomendasi_pencairan']);
        Route::get('/print_bmt/{id_permohonan}', [PrintController::class, 'print_bmt']);
        Route::get('/print_upzis/{bulan}/{tahun}/{status}/{upzis}', [PrintPengajuanController::class, 'print_upzis']);
        Route::get('/print_ranting/{bulan}/{tahun}/{status}/{upzis}/{ranting}', [PrintPengajuanController::class, 'print_ranting']);


        Route::get('/print_berita_acara_pc', [PrintController::class, 'berita_pc']);
        Route::get('/berita_acara/{id_pengajuan_detail}', [PrintController::class, 'berita_upzis_ranting']);





        // berita
        Route::post('/aksi_tambah_berita', [BeritaUmumController::class, 'aksi_tambah_berita'])->name('aksi_tambah_berita');
        Route::post('/aksi_hapus_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_berita'])->name('aksi_hapus_berita');
        Route::get('/arsip/detail_berita/{id}', [BeritaUmumController::class, 'detail_berita'])->name('detail_berita');
        Route::put('/arsip/aksi_edit_berita/{id}', [BeritaUmumController::class, 'aksi_edit_berita'])->name('aksi_edit_berita');
        Route::post('/filter/berita', [FilterBeritaController::class, 'filter_berita'])->name('filter_berita');

        //FILE BERITA
        Route::post('/arsip/aksi_edit_file_berita/{id}', [BeritaUmumController::class, 'aksi_edit_file_berita'])->name('aksi_edit_file_berita');
        Route::post('/arsip/aksi_tambah_file_berita/{id}', [BeritaUmumController::class, 'aksi_tambah_file_berita'])->name('aksi_tambah_file_berita');
        Route::post('/arsip/aksi_hapus_file_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_file_berita'])->name('aksi_hapus_file_berita');


        // LAPORAN KEUANGAN
        // Route::get('/laporankeu', [LaporanController::class, 'laporankeu']);
        // Route::post('/laporan/ubah_laporankeu', [LaporanController::class, 'ubah_laporankeu']);

        // // LAPORAN PENYALURAN
        // Route::get('/laporanpenyaluran/{bulan}/{tahun}/{id_upzis}', [LaporanController::class, 'laporanpenyaluran']);
        // Route::get('/print_penyaluran/{bulan}/{tahun}/{id_upzis}', [PrintController::class, 'print_penyaluran']);
        // // LAPORAN PERUBAHAN DANA
        // Route::get('/laporanperudana/{bulan}/{tahun}/{id_upzis}', [LaporanController::class, 'laporanperudana']);
        // Route::get('/print_perudana/{bulan}/{tahun}/{id_upzis}', [PrintController::class, 'print_perudana']);
        // Route::get('/laporan/{id_pengajuan}', [PrintController::class, 'laporan']);

        // update
        Route::get('/upzis-ranting', [PengajuanController::class, 'upzis_ranting2']);
        Route::get('/lap-upzis-ranting', [PengajuanController::class, 'lap_upzis_ranting2']);
          Route::get('/laporan_upzis_ranting', [PengajuanController::class, 'laporan_upzis_ranting']);
        Route::get('/laporan_upzis_ranting_keseluruhan', [PengajuanController::class, 'laporan_upzis_ranting_keseluruhan']);
        Route::post('/filter_umum_ranting_laporan', [PengajuanController::class, 'filter_umum_ranting_laporan']);
        Route::post('/filter_umum_upzis_laporan', [PengajuanController::class, 'filter_umum_upzis_laporan']);
        Route::post('/filter_umum_upzis', [PengajuanController::class, 'filter_umum_upzis']);
        Route::post('/filter_umum_ranting', [PengajuanController::class, 'filter_umum_ranting']);
         Route::post('/filter_umum_laporan_upzis_ranting_keseluruhan', [PengajuanController::class, 'filter_umum_laporan_upzis_ranting_keseluruhan']);
        Route::get('/pengajuan_hapus/{id_pengajuan}', [PengajuanController::class, 'delete']);
        Route::post('/tambah-pengajuan', [PengajuanController::class, 'create']);
        Route::get('/detail-pengajuan/{id_pengajuan}', [DetailPengajuanController::class, 'index']);
        // Route::get('/delete-pengajuan/{id_pengajuan}', [PengajuanController::class, 'delete']);

        Route::get('/server', [LaporanController::class, 'getvalue']);
    });

    Route::get('/print_penyaluran_dana/{id_pengajuan}', [PrintPenyaluranController::class, 'print_penyaluran_dana'])->name('print_penyaluran_dana');
    Route::get('/print_pencairan_dana/{id_pengajuan}', [PrintPenyaluranController::class, 'print_pencairan_dana'])->name('print_pencairan_dana');
    Route::get('/print_tanda_terima_fo/{id_pengajuan}', [PrintPenyaluranController::class, 'print_tanda_terima_fo'])->name('print_tanda_terima_fo');

    Route::get('/import_penerima_manfaat/{id_pengajuan_detail}', [ImportPenerimaManfaatController::class, 'import_penerima_manfaat'])->name('import_penerima_manfaat');
    Route::post('/import_excel',  [ImportPenerimaManfaatController::class, 'import_excel'])->name('import_excel_arsip');
    Route::post('/import_save', [ImportPenerimaManfaatController::class, 'save'])->name('import_save');
    Route::post('/import_cancel', [ImportPenerimaManfaatController::class, 'cancel'])->name('import_cancel');
    Route::post('/import_excel_pc',  [ImportPenerimaManfaatController::class, 'import_excel_pc'])->name('import_excel_arsip_pc');
        Route::get('/import_penerima_manfaat_pc/{id_pengajuan_detail}', [ImportPenerimaManfaatController::class, 'import_penerima_manfaat_pc'])->name('import_penerima_manfaat_pc');
    Route::post('/import_save_pc', [ImportPenerimaManfaatController::class, 'save_pc'])->name('import_save_pc');
    Route::post('/import_cancel_pc', [ImportPenerimaManfaatController::class, 'cancel_pc'])->name('import_cancel_pc');

    Route::get('/print-pdf/{id_pengajuan_detail}', [WatermarkPDFController::class, 'generateWatermarkedPDF']);


    Route::post('/get-pj-by-ranting', [Api::class, 'getPjByRanting']);
    Route::post('/get-nomor-pengajuan', [Api::class, 'getNomorPengajuan2']);

    Route::get('/export/excel', [ExportController::class, 'exportToExcel'])->name('exportToExcel');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::get('/get-pilar/{program}', [Api::class, 'getPilar']);
    Route::get('/get-kegiatan/{pilar}', [Api::class, 'getPjByRanting']);

    
   
   //PDF & EXCEL GABUNGA UMUM PC
    Route::get('/print_pc_laporan_gabungan/{filter_daterange2}/{status}/{kategori}/{pilar}/{status_lpj}/{status_lpj2}', [PrintPengajuanController::class, 'print_pc_laporan_gabungan'])->name('print_pc_laporan_gabungan');
    Route::get('/pdf_umum_gabungan_realisasi_penerima_manfaat/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporPenerimaManfaat::class, 'pdf_umum_gabungan_realisasi_penerima_manfaat'])->name('pdf_umum_gabungan_realisasi_penerima_manfaat');
    Route::get('/excel_umum_gabungan_realisasi_penerima_manfaat/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporPenerimaManfaat::class, 'excel_umum_gabungan_realisasi_penerima_manfaat'])->name('excel_umum_gabungan_realisasi_penerima_manfaat');
    Route::get('/pdf_umum_gabungan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [LaporanGabunganController::class, 'pdf_umum_gabungan'])->name('pdf_umum_gabungan');
    Route::get('/excel_umum_gabungan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [LaporanGabunganController::class, 'excel_umum_gabungan'])->name('excel_umum_gabungan');
    Route::get('/pdf_all_umum_laporan_gabungan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporAllLaporanController::class, 'pdf_all_umum_laporan_gabungan'])->name('pdf_all_umum_laporan_gabungan');
    Route::get('/berita_acara_laporan_gabungan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporAllLaporanController::class, 'berita_acara_laporan_gabungan'])->name('berita_acara_laporan_gabungan');


    //PDF UMUM PC
    Route::get('/print_pc_laporan/{filter_daterange2}/{status}/{kategori}/{pilar}', [PrintPengajuanController::class, 'print_pc_laporan'])->name('print_pc_laporan');
    Route::get('/print_pc_laporan_realisasi_by_pilar_program/{filter_daterange2}/{status}/{kategori}/{pilar}', [PrintPengajuanController::class, 'print_pc_laporan_realisasi_by_pilar_program'])->name('print_pc_laporan_realisasi_by_pilar_program');
    Route::get('/print_pc_laporan_penerima_manfaat/{filter_daterange2}/{status}/{kategori}/{pilar}', [PrintPengajuanController::class, 'print_pc_laporan_penerima_manfaat'])->name('print_pc_laporan_penerima_manfaat');
    Route::get('/print_pc_umum_laporan_keseluruhan/{filter_daterange2}/{status}/{kategori}/{pilar}', [PrintPengajuanController::class, 'print_pc_umum_laporan_keseluruhan'])->name('print_pc_umum_laporan_keseluruhan');

    //EXCEL UMUM PC    
    Route::get('/excel_pc_laporan_penerima_manfaat/{filter_daterange2}/{status}/{kategori}/{pilar}', [PrintPengajuanController::class, 'excel_pc_laporan_penerima_manfaat'])->name('excel_pc_laporan_penerima_manfaat');
    Route::get('/excel_pc_laporan_realisasi_by_pilar_program/{filter_daterange2}/{status}/{kategori}/{pilar}', [PrintPengajuanController::class, 'excel_pc_laporan_realisasi_by_pilar_program'])->name('excel_pc_laporan_realisasi_by_pilar_program');


    //PDF PENGAJUAN  
    Route::get('/pengajuan_pdf_umum_upzis_realisasi_pengajuan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'pengajuan_pdf_umum_upzis_realisasi_pengajuan'])->name('pengajuan_pdf_umum_upzis_realisasi_pengajuan');
    Route::get('/pengajuan_pdf_umum_ranting_realisasi_pengajuan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'pengajuan_pdf_umum_ranting_realisasi_pengajuan'])->name('pengajuan_pdf_umum_ranting_realisasi_pengajuan');


    //PDF
    Route::get('/pdf_umum_upzis/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'pdf_umum_upzis'])->name('pdf_umum_upzis');
    Route::get('/pdf_umum_ranting/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'pdf_umum_ranting'])->name('pdf_umum_ranting');
    Route::get('/pdf_umum_keseluruhan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'pdf_umum_keseluruhan'])->name('pdf_umum_keseluruhan');

    Route::get('/pdf_umum_upzis_realisasi_pengajuan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'pdf_umum_upzis_realisasi_pengajuan'])->name('pdf_umum_upzis_realisasi_pengajuan');
    Route::get('/pdf_umum_ranting_realisasi_pengajuan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'pdf_umum_ranting_realisasi_pengajuan'])->name('pdf_umum_ranting_realisasi_pengajuan');
    Route::get('/pdf_keseluruhan_realisasi_pengajuan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'pdf_keseluruhan_realisasi_pengajuan'])->name('pdf_keseluruhan_realisasi_pengajuan');

    Route::get('/pdf_umum_upzis_realisasi_penerima_manfaat/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporPenerimaManfaat::class, 'pdf_umum_upzis_realisasi_penerima_manfaat'])->name('pdf_umum_upzis_realisasi_penerima_manfaat');
    Route::get('/pdf_umum_ranting_realisasi_penerima_manfaat/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporPenerimaManfaat::class, 'pdf_umum_ranting_realisasi_penerima_manfaat'])->name('pdf_umum_ranting_realisasi_penerima_manfaat');
    Route::get('/pdf_umum_keseluruhan_realisasi_penerima_manfaat/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporPenerimaManfaat::class, 'pdf_umum_keseluruhan_realisasi_penerima_manfaat'])->name('pdf_umum_keseluruhan_realisasi_penerima_manfaat');

    Route::get('/pdf_all_umum_laporan_upzis/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporAllLaporanController::class, 'pdf_all_umum_laporan_upzis'])->name('pdf_all_umum_laporan_upzis');
    Route::get('/pdf_all_umum_laporan_ranting/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporAllLaporanController::class, 'pdf_all_umum_laporan_ranting'])->name('pdf_all_umum_laporan_ranting');
    Route::get('/pdf_all_umum_laporan_keseluruhan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporAllLaporanController::class, 'pdf_all_umum_laporan_keseluruhan'])->name('pdf_all_umum_laporan_keseluruhan');
    Route::get('/berita_acara_laporan_upzis/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporAllLaporanController::class, 'berita_acara_laporan_upzis'])->name('berita_acara_laporan_upzis');
    Route::get('/berita_acara_laporan_ranting/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporAllLaporanController::class, 'berita_acara_laporan_ranting'])->name('berita_acara_laporan_ranting');
    Route::get('/berita_acara_laporan_keseluruhan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporAllLaporanController::class, 'berita_acara_laporan_keseluruhan'])->name('berita_acara_laporan_keseluruhan');

    //EXCEL
    Route::get('/excel_umum_upzis/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'excel_umum_upzis'])->name('excel_umum_upzis');
    Route::get('/excel_umum_ranting/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'excel_umum_ranting'])->name('excel_umum_ranting');
    Route::get('/excel_umum_keseluruhan/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [PengajuanController::class, 'excel_umum_keseluruhan'])->name('excel_umum_keseluruhan');

    Route::get('/excel_umum_upzis_realisasi_penerima_manfaat/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporPenerimaManfaat::class, 'excel_umum_upzis_realisasi_penerima_manfaat'])->name('excel_umum_upzis_realisasi_penerima_manfaat');
    Route::get('/excel_umum_ranting_realisasi_penerima_manfaat/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporPenerimaManfaat::class, 'excel_umum_ranting_realisasi_penerima_manfaat'])->name('excel_umum_ranting_realisasi_penerima_manfaat');
    Route::get('/excel_umum_keseluruhan_realisasi_penerima_manfaat/{role}/{status}/{start_date}/{end_date}/{filter_daterange}/{id_upzis}/{id_upzis2}/{id_ranting2}/{status2}/{filter_daterange2}/{sub}/{status_lpj}/{status_lpj2}', [EksporPenerimaManfaat::class, 'excel_umum_keseluruhan_realisasi_penerima_manfaat'])->name('excel_umum_keseluruhan_realisasi_penerima_manfaat');
    
});

