<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Berita;
use Livewire\Component;
use App\Models\ArusDana;
use App\Models\Internal;
use App\Models\Pengguna;
use App\Models\Programs;
use App\Models\Rekening;
use App\Models\Pengajuan;
use App\Models\JurnalUmum;
use App\Models\PcPengurus;
use App\Models\SurveyFoto;
use Illuminate\Support\Str;
use App\Models\ProgramPilar;
use Livewire\WithFileUploads;
use PhpParser\Node\Stmt\Else_;
use App\Models\PengajuanBerita;
use App\Models\PengajuanDetail;
use App\Models\PengajuanSurvey;
use App\Models\ProgramKegiatan;
use App\Http\Controllers\Helper;
use App\Models\LampiranPencairan;
use App\Models\PengajuanKegiatan;
use App\Models\PengajuanLampiran;
use App\Models\PengajuanPenerima;
use Illuminate\Support\Facades\DB;
use App\Models\PengajuanDokumentasi;
use App\Models\PengajuanPengeluaran;
use Illuminate\Support\Facades\Auth;
use App\Models\SurveyPenerimaManfaat;
use App\Models\ArsipMasuk;
use App\Models\LampiranArsipMasuk;
use App\Models\PengajuanLPJ;
use App\Models\DetailBarang;
use App\Models\lpjUmum;
use Livewire\WithPagination;

class DetailPc extends Component
{
    use WithFileUploads;
    public $opsi_pemohon;
    public $sumber_dana;
    public $jenis_tanda_terima;
    public $jumlah_penerima;
    public $judul_file_pencairan;
    public $file_lampiran_pencairan;

    public $id_pengajuan;
    public $id_pengajuan_detail;
    public $gocap;
    public $etasyaruf;
    public $siftnu;
    public $earsip;

    // pengajuan
    public $penerima = [];
    public $lampiran = [];
    public $id_front_office;
    public $id_pengajuan_penerima;
    public $nama;
    public $alamat;
    public $nominal_bantuan;
    public $keterangan;

    // survey
    public $survey;
    public $none_block_survey;
    // public $id_pengajuan_survey;
    // public $tgl_survey;
    public $survey_hasil = 'disetujui';
    public $survey_lokasi;
    public $survey_catatan;
    public $id_staf_program;

    public $idsurveyini;
    public $idsurveypenerima;
    public $konfirmasi_upload_kwitansi;

    public $tgl_survey;
    public $nama_mustahik;
    public $alamat_mustahik;
    public $jenis_permohonan;
    public $jumlah_anak;
    public $jumlah_total;
    public $punya_pasangan = 'ya';
    public $pekerjaan_suami;
    public $pekerjaan_istri;
    public $pekerjaan_anak;
    public $penghasilan_suami;
    public $penghasilan_istri;
    public $penghasilan_anak;
    public $kondisi_atap;
    public $kondisi_dinding;
    public $kondisi_lantai;
    public $kondisi_ukuran_rumah;
    public $kepemilikan_rumah;
    public $kepemilikan_tanah;
    public $harta_aset_kekayaan;
    public $tanggungan_rutin_bulan;
    public $kebutuhan_yg_dibutuhkan;
    public $bantuan_yg_pernah_didapat;
    public $indeks_rumah = 'layak';
    public $indeks_rumah_keterangan;
    public $indeks_harta = 'layak';
    public $indeks_harta_keterangan;
    public $indeks_pendapatan = 'layak';
    public $indeks_pendapatan_keterangan;
    public $rokemendasi_surveyor;
    public $nomor_kwitansi_pencairan;
    public $scan_kwitansi;
    
    // detail barang
    public $id_lpj_uraian_barang;
    public $jumlah_barang;
    public $jenis_barang;
    public $nominal_barang;
    public $barang = [];


    // direktur
    public $id_direktur;
    public $none_block_acc;
    public $none_block_tolak;
    public $rekening = [];
    public $id_rekening;
    public $saldo;
    public $nama_bmt;
    public $satuan_disetujui;
    public $satuan_pengajuan;

    // card tombol jenis data
    public $bg_card_pengajuan;
    public $pengurus_keuangan = [];
    public $staf_keuangan;
    public $nominal_disetujui;
    public $denial_note;
    public $denial_date;
    public $approval_date;

    // pencairan
    public $tgl_pencairan;
    public $kwitansi;
    public $dicairkan_kepada;
    public $nominal_pencairan_tab;
    public $total_pencairan;
    public $id_rekening2;
    public $satuan_disetujui2;


    // kegiatan
    public $bg_card_kegiatan;
    public $kegiatan = [];
    public $tgl_kegiatan;
    public $lokasi;
    public $judul;
    public $jumlah_kehadiran;
    public $kendala;
    public $ringkasan;
    
    public $none_block_acc_ketua = 'none';
    public $approval_date_ketua;
    public $catatan_ketua;
    public $status_ketua;
    public $approver_ketua;

    // dokumentasi kegiatan
    public $dokumentasi = [];
    public $id_pengajuan_dokumentasi;
    public $judul_dokumentasi;
    public $file_dokumentasi;

    // pengeluaran

    public $id_pengajuan_pengeluaran;
    public $judul_pengeluaran;
    public $tgl_pengeluaran;
    public $jumlah_pengeluaran;
    public $nominal_pengeluaran;
    public $nominal_pencairan;
    public $nota_pengeluaran;
    public $dana_digunakan;

    // berita
    public $bg_card_berita;
    public $none_block_terbit;
    public $id_pengajuan_berita;
    public $berita = [];
    public $file_berita;
    public $file_berita_baru;
    public $tgl_terbit_berita;
    public $tanggal_terbit;
    public $judul_berita;
    public $narasi_berita;
    public $narasi_berita2;
    public $pewarta_pc;
    public $id_staf_media;

    // lampiran
    public $id_pengajuan_lampiran;
    // public $judul;
    public $file_lampiran;

    // ubah pengajuan
    public $jumlah_penerima_edit = 0;
    public $satuan_pengajuan_edit = 0;
    public $total_edit;

    public $rekening_keuangan;

    public $none_block_tolak_program = 'none';
    public $none_block_acc_program = 'none';

    public $tgl_penyaluran;
    public $rek_cek;
    public $sumber_dana_opsi_keuangan;
    public $nominal_disetujui2;

    public $nomor_surat_edit;
    public $opsi_pemohon_edit;
    public $nama_pemohon_edit;
    public $nohp_pemohon_edit;
    public $alamat_pemohon_edit;
    public $nama_entitas_edit;
    public $no_perijinan_entitas_edit;
    public $alamat_entitas_edit;
    public $pj_entitas_edit;
    public $no_hp_entitas_edit;
    public $jenis_tanda_terima_edit;
    public $lainnya_edit;
    public $tgl_surat_edit;
    public $no_surat_edit;
    public $tgl_pengajuan_edit;
    public $tgl_pelaksanaan_edit;

    public $sumber_dana_edit;

    public $daftar_pilar_edit = [];
    public $pemohon_internal_edit = [];
    public $pc_petugas_edit = [];
    public $id_program_pilar_edit;
    public $daftar_kegiatan_edit = [];
    public $daftar_kegiatan2_edit = [];
    public $id_program_kegiatan_edit;
    public $id_asnaf_edit;
    public $nama_penerima_edit;
    public $jenis_permohonan_edit;
    public $jabatan_entitas_edit;
    public $nik_entitas_edit;
    public $pengajuan_note_edit;
    public $rekening_direktur;
    public $id_lampiran_pencairan;
    public $keterangan_acc;
    public $pil_survey;
    public $approval_date_pencairan_direktur;
    public $keterangan_acc_pencairan_direktur;
    public $sumber_dana_opsi;
    public $keterangan_acc_divpro;
    public $tgl_diserahkan_direktur;
    public $denial_date_pencairan_direktur;
    public $denial_note_pencairan_direktur;
    public $denial_date_divpro;
    public $denial_note_divpro;
    public $approval_date_divpro;
    public $none_block_tolak_direktur_keuangan = 'none';
    public $none_block_acc_direktur_keuangan = 'none';
    public $jenis_bantuan;
    public $jns_bantuan;
    public $nokk;
    public $nik;
    public $nohp;
    public $keterangan_tolak_pencairan;
    public $tgl_tolak_pencairan;
    public $keterangan_pencairan;
    public $metode_penyaluran;
    public $nama_bank_penerima;
    public $cabang;
    public $atas_nama_penerima;
    public $no_rek_penerima;


    public $tgl_berita;
    public $senilai;
    public $jabatan1;
    public $nama1;
    public $alamat1;
    public $nohp1;
    public $berupa;
    public $jabatan2;
    public $nama2;
    public $alamat2;
    public $nohp2;
    public $respon_ketua;

    public $scan_berita;
    public $konfirmasi_note;

    public $metode_pencairan;
    
    public $jumlah_bantuan;
    public $nik1;
    public $nik2;
    public $nik_individu_edit;
    
    public $tgl_penggunaan_dana;
    public $dibayarkan_kepada;
    public $nominal;
    public $keterangan_lpj;
    public $nota;
    public $id_lpj_umum;
    public $opsi_dana;
    public $foto_kegiatan;
    public $tgl_penggunaan_dana_edit;
    // public $tgl_input_edit;
    public $dibayarkan_kepada_edit;
    public $nominal_edit;
    public $keterangan_edit;
    public $nota_edit;
    public $opsi_dana_edit;
    public $cari;
    public $page_number = 5;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');
        $this->earsip = config('app.database_earsip');
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan', $this->id_pengajuan)->first();
        $this->rek_cek = Rekening::where('id_rekening', $data_detail->id_rekening_pencairan_direktur)->first();
        $this->id_pengajuan_detail = $data_detail->id_pengajuan_detail;
        $this->none_block_survey = 'none';
        $this->none_block_acc = 'none';
        $this->none_block_tolak = 'none';
        $this->tgl_survey = date('Y-m-d');
        $this->tgl_penyaluran = now()->timezone('Asia/Jakarta')->format('Y-m-d');

        $this->tombol_pengajuan();
    }


    public static function cek_survey($id_pengajuan)
    {

        $data_detail = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first();
        $data = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        return $data->survey_pc;
    }

    public function modal_ubah_nominal_pengajuan($id_pengajuan_detail)
    {
        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->first();
        $pengajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $this->daftar_pilar_edit = ProgramPilar::orderBy('pilar', 'ASC')->get();

        $this->pc_petugas_edit = DB::table($this->gocap . '.pc_pengurus')
            ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select(
                $this->siftnu . '.pengguna.nama',
                $this->gocap . '.pc_pengurus.id_pc_pengurus',
                $this->gocap . '.pengurus_jabatan.jabatan',
            )
            ->get();

        $this->nomor_surat_edit = $pengajuan->nomor_surat;
        $this->opsi_pemohon_edit = $pengajuan->opsi_pemohon;
        $this->tgl_pengajuan_edit = $pengajuan->tgl_pengajuan;
        $this->pemohon_internal_edit = $pengajuan->pemohon_internal;

        $this->satuan_pengajuan_edit = number_format($data_detail->satuan_pengajuan, 0, '.', '.');
        $this->jumlah_penerima_edit = $data_detail->jumlah_penerima;


        $this->nama_pemohon_edit = $data_detail->nama_pemohon;
        $this->nohp_pemohon_edit = $data_detail->nohp_pemohon;
        $this->alamat_pemohon_edit = $data_detail->alamat_pemohon;
        $this->nama_entitas_edit = $data_detail->nama_entitas;
        $this->no_perijinan_entitas_edit = $data_detail->no_perijinan_entitas;
        $this->alamat_entitas_edit = $data_detail->alamat_entitas;
        $this->pj_entitas_edit = $data_detail->nama_pj_permohonan_entitas;
        $this->no_hp_entitas_edit = $data_detail->no_hp_entitas;
        $this->jenis_tanda_terima_edit = $data_detail->jenis_tanda_terima;
        $this->lainnya_edit = $data_detail->lainnya;
        $this->tgl_surat_edit = $data_detail->tgl_surat;
        $this->no_surat_edit = $data_detail->no_surat;
        $this->tgl_pelaksanaan_edit = $data_detail->tgl_pelaksanaan;
        $this->id_program_pilar_edit = $data_detail->id_program_pilar;
        $this->id_program_kegiatan_edit = $data_detail->id_program_kegiatan;
        $this->id_asnaf_edit = $data_detail->id_asnaf;
        $this->nama_penerima_edit = $data_detail->nama_penerima;
        $this->pengajuan_note_edit = $data_detail->pengajuan_note;
        $this->jabatan_entitas_edit = $data_detail->jabatan_entitas;
        $this->nik_entitas_edit = $data_detail->nik_entitas;
        $this->nik_individu_edit = $data_detail->nik_individu;
    }

    public function ubah_nominal_pengajuan()
    {
        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $pengajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        $pengajuan = Pengajuan::where('id_pengajuan', $pengajuan->id_pengajuan)->update([
            'tgl_pengajuan' => $this->tgl_pengajuan_edit,
            'opsi_pemohon' => $this->opsi_pemohon_edit,
            'pemohon_internal' => $this->pemohon_internal_edit,
        ]);

        // dd($pengajuan);

        $detail = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'jumlah_penerima' => $this->jumlah_penerima_edit,
            'satuan_pengajuan' => str_replace('.', '', $this->satuan_pengajuan_edit),
            'nominal_pengajuan' => str_replace('.', '', $this->satuan_pengajuan_edit) * $this->jumlah_penerima_edit,

            'nama_pemohon' => $this->nama_pemohon_edit,
            'nohp_pemohon' => $this->nohp_pemohon_edit,
            'alamat_pemohon' => $this->alamat_pemohon_edit,
            'nama_entitas' => $this->nama_entitas_edit,
            'no_perijinan_entitas' => $this->no_perijinan_entitas_edit,
            'alamat_entitas' => $this->alamat_entitas_edit,
            'nama_pj_permohonan_entitas' => $this->pj_entitas_edit,
            'no_hp_entitas' => $this->no_hp_entitas_edit,
            'jenis_tanda_terima' => $this->jenis_tanda_terima_edit,
            'lainnya' => $this->lainnya_edit,
            'tgl_surat' => $this->tgl_surat_edit,
            'no_surat' => $this->no_surat_edit,
            'tgl_pelaksanaan' => $this->tgl_pelaksanaan_edit,
            'id_program_pilar' => $this->id_program_pilar_edit,
            'id_program_kegiatan' => $this->id_program_kegiatan_edit,
            'id_asnaf' => $this->id_asnaf_edit,
            'nama_penerima' => $this->nama_penerima_edit,
            'pengajuan_note' => $this->pengajuan_note_edit,
            'jabatan_entitas' => $this->jabatan_entitas_edit,
            'nik_entitas' => $this->nik_entitas_edit,
            'nik_individu' => $this->nik_individu_edit,

        ]);

        // dd($detail);

        session()->flash('alert_nominal', 'Nominal Pengajuan Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
        $this->reset_edit();

        // $this->modal_rencana_kegiatan($this->id_pengajuan_detail);
    }
    
    public function modal_hapus_penerima_manfaat_pc($id_pengajuan_detail)
    {
        $this->id_pengajuan_detail = $id_pengajuan_detail;
        // dd($id_lpj_internal);
    }

    public function hapus_penerima_pc()
    {
        $data = Pengajuan::where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = PengajuanDetail::where('id_pengajuan', $data->id_pengajuan)->first();
        $penerima = PengajuanPenerima::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->delete();

        session()->flash('alert_penerima', 'Penerima Manfaat Berhasil Dihapus');
        $this->emit('waktu_alert');
    }
    
    public function konfirmasiPemohon()
    {
        $url =  "https://e-tasyaruf.nucarecilacap.id";
        $link = "https://wa.link/o93jqd";
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        if ($data->opsi_pemohon == 'Entitas') {
            $no_hp = $data_detail->no_hp_entitas;
            $nama_pemohon = $data_detail->nama_pj_permohonan_entitas . " (" . $data_detail->nama_entitas . ")";
        } else if ($data->opsi_pemohon == 'Individu') {
            $no_hp = $data_detail->nohp_pemohon;
            $nama_pemohon = $data_detail->nama_pemohon;
        } else {
            $no_hp = $this->nohp_pengurus_pc($data->pemohon_internal);
            $nama_pemohon = $this->nama_pengurus_pc($data->pemohon_internal);
        }

        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'konfirmasi_pemohon' => '1',
        ]);
        $this->mount();

        $nama_program = ProgramPilar::where('id_program_pilar', $data_detail->id_program_pilar)->value('pilar');
        $na_program = substr($nama_program, 6);

        $this->notif(
            $no_hp,
            //'089639481199',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. Bapak/Ibu" . "\n" .
                "Dengan senang hati kami informasikan terkait pengajuan yang dikirimkan ke kantor NU Care LAZISNU Cilacap," . "\n" . "\n" .
                "*" .  "Nama Pemohon"  . "*" .  "\n" .
                $nama_pemohon .  "\n" .
                "*" .  "Jenis Pengajuan"  . "*" .  "\n" .
                $data_detail->pengajuan_note .  "\n" .
                "*" .  "Program"  . "*" .  "\n" .
                $na_program .  "\n" .  "\n" .
                "Alhamdulillah sudah mendapat persetujuan. Oleh karena itu, kami meminta pengisian form penerimaan dana pentasyarufan untuk proses serah terima dana." . "\n" . "\n" .
                "Untuk pengisian form silahkan dapat klik link dibawah ini:" . "\n" .
                url($link) . "\n" . "\n" .
                "Ketentuan lainnya akan kami sampaikan setelah form terisi dan dana siap untuk diambil." . "\n" . "\n" .
                

                "Terima Kasih." . "\n" .
                "Wassalamu'alaikum Wr.Wb." . "\n" . "\n" . "\n" .
                "Ttd." . "\n" . 
                "Administrasi & Program Lazisnu Cilacap" . "\n" . "\n" .

                url($url)
        );
        $this->dispatchBrowserEvent('success', [
            'message' => 'Konfirmasi Pemohon Terkirim ke <strong><br>' . $nama_pemohon . '</strong><br>' . $no_hp . '<br>' 
        ]);
    }
    
    public function sendNotifKwitansiUmum()
    {
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'terima_kwitansi' => '1',
            'tgl_terima_kwitansi' => date("Y-m-d H:i:s")
        ]);
        
        session()->flash('alert_keuangan', 'Kwitansi telah berhasil diterima');
        $this->emit('waktu_alert');
    }
    
    public function uploadKwitansiPencairan()
    {
        $detail = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        if ($this->scan_kwitansi) {
            if ($detail->scan_kwitansi != null) {
                $path = public_path() . "/uploads/kwitansi_pencairan_umum/" . $detail->scan_kwitansi;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $ext = $this->scan_kwitansi->extension();
            $file_scan_name = Str::uuid()->toString() . '.' . $ext;
            $this->scan_kwitansi->storeAs('kwitansi_pencairan_umum', $file_scan_name);

            PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
                'scan_kwitansi' => $file_scan_name,
                'konfirmasi_upload_kwitansi' => $this->konfirmasi_upload_kwitansi,
                'tgl_upload' => date('Y-m-d'),
                'kwitansi_konfirmasi_pc' => Auth::user()->gocap_id_pc_pengurus
            ]);

            $this->dispatchBrowserEvent('success', [
                'message' => 'Kwitansi berhasil diupload!'
            ]);
            $this->emit('waktu_alert');
            $this->emit('resetKuitansi');
        } else {
            $this->dispatchBrowserEvent('error', [
                'message' => 'Kwitansi gagal diupload!'
            ]);
            $this->emit('waktu_alert');
            $this->emit('resetKuitansi');
        }
    }
    
    public function cetak_dokumentasi()
    {
        $dokumentasi = PengajuanDokumentasi::where('id_pengajuan_dokumentasi', $this->id_pengajuan_dokumentasi)->first();
        $path = public_path() . "/uploads/pengajuan_dokumentasi/" . $dokumentasi->file;

        return response()->download($path, $dokumentasi->judul . '.' . pathinfo($dokumentasi->file, PATHINFO_EXTENSION));
    }
   
    
    public function arsip_masuk($id_pengajuan_detail)
    {
        
        
        $detail = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->first();
        $data = Pengajuan::where('id_pengajuan', $detail->id_pengajuan)->first();

        $arsip = DB::table($this->earsip . '.arsip_digital')
            ->where('nomor_surat', $data->nomor_surat)
            ->first();
        
        if ($data->opsi_pemohon == 'Entitas') {
            $tujuan = $detail->nama_entitas;
            $alamat = $detail->alamat_entitas;
        } elseif ($data->opsi_pemohon == 'Individu') {
            $tujuan = $detail->nama_pemohon;
            $alamat = $detail->alamat_pemohon;
        } else {
            $tujuan = $this->nama_pengurus_pc($data->pemohon_internal);
            $alamat = $this->alamat_pc($data->pemohon_internal);
        }

            $lampiran = PengajuanLampiran::where('id_pengajuan_detail', $id_pengajuan_detail)->get();
            // dd($lampiran);

        if ($arsip == null || '') {
            $arsip_digital_id = Str::uuid()->toString();
            $lampiran_digital_id = Str::uuid()->toString();
            ArsipMasuk::create([
                'arsip_digital_id' => $arsip_digital_id,
                'id_pengguna' => Auth::user()->id_pengguna,
                'tanggal_arsip' => $detail->tgl_surat,
                'jenis_arsip' => 'Surat Masuk',
                'jenis_disposisi' => 'Tidak Ada',
                'nomor_surat' => $data->nomor_surat,
                'klasifikasi_surat' => 'Biasa',
                'tujuan_arsip' => 'PC Lazisnu Cilacap',
                'pengirim_sumber' => $tujuan,
                'perihal_isi_deskripsi' => 'Pengajuan Umum PC',
                'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                'alamat_pengirim' => $alamat,
                'keterangan_surat_masuk' => $detail->pengajuan_note,
            ]);
    
            foreach ($lampiran as $item) {
                LampiranArsipMasuk::create([
                    'lampiran_arsip_id' => $lampiran_digital_id,
                    'arsip_digital_id' => $arsip_digital_id,
                    'file' => $item->file,
                    'nama' => $item->judul,
                    'jenis' => 'Lampiran'
                ]);
            }
        } else {
            $data_arsip = DB::table($this->earsip . '.arsip_digital')
            ->where('nomor_surat', $data->nomor_surat)
            ->first();

            ArsipMasuk::where('nomor_surat', $data->nomor_surat)->update([
                'tanggal_arsip' => $detail->tgl_surat,
                'jenis_arsip' => 'Surat Masuk',
                'jenis_disposisi' => 'Tidak Ada',
                'nomor_surat' => $data->nomor_surat,
                'klasifikasi_surat' => 'Biasa',
                'tujuan_arsip' => 'PC Lazisnu Cilacap',
                'pengirim_sumber' => $tujuan,
                'perihal_isi_deskripsi' => 'Pengajuan Umum PC',
                'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                'alamat_pengirim' => $alamat,
                'keterangan_surat_masuk' => $detail->pengajuan_note,
            ]);

            foreach ($lampiran as $item) {
                $lampiran_masuk = LampiranArsipMasuk::where('arsip_digital_id', $data_arsip->arsip_digital_id)
                ->where('file', $item->file)
                ->first();

                    if (!$lampiran_masuk) {
                        $lampiran_digital = Str::uuid()->toString();
                        LampiranArsipMasuk::create([
                            'lampiran_arsip_id' => $lampiran_digital,
                            'arsip_digital_id' => $data_arsip->arsip_digital_id,
                            'file' => $item->file,
                            'nama' => $item->judul,
                            'jenis' => 'Lampiran'
                        ]);
                    }
            }
        }

        $this->dispatchBrowserEvent('success', ['message' => 'Sinkronisasi Surat Masuk Telah Berhasil.']);
    }
    
    public $judul_lpj;
    public $id_pengajuan_lpj;
    public $file_lpj;
    public function modal_umum_lpj_tambah()
    {
        $this->judul_lpj = NULL;
    }

    public function modal_umum_lpj_hapus($id_pengajuan_lpj)
    {
        $this->id_pengajuan_lpj = $id_pengajuan_lpj;
    }

    public function modal_umum_lpj_ubah($id_pengajuan_lpj)
    {
        $a = PengajuanLPJ::where('id_pengajuan_lpj', $id_pengajuan_lpj)->first();
        $this->judul_lpj = $a->judul_lpj;
        $this->id_pengajuan_lpj = $id_pengajuan_lpj;
    }

    public function tambah_lampiran_lpj()
    {
        $id_pengajuan_lpj = Str::uuid()->toString();
        $ext = $this->file_lpj->extension();
        $file_lpj_name = 'LPJ-UMUMPC-' . Str::random(10) . '.' . $ext;
        $this->file_lpj->storeAs('pengajuan_lpj', $file_lpj_name);

        PengajuanLPJ::create([
            'id_pengajuan_lpj' => $id_pengajuan_lpj,
            'id_pengajuan_detail' => $this->id_pengajuan_detail,
            'judul_lpj' => $this->judul_lpj,
            'file_lpj' => $file_lpj_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul_lpj = NULL;
        $this->file_lpj = NULL;
        session()->flash('alert_lpj', 'Lampiran Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->emit('dataTersimpanTambahLPJ');
    }

    public function hapus_lampiran_lpj()
    {
        $a = PengajuanLPJ::where('id_pengajuan_lpj', $this->id_pengajuan_lpj)->first();

        if ($a->file != null) {
            $path = public_path() . "/uploads/pengajuan_lpj/" . $a->file;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        PengajuanLPJ::where('id_pengajuan_lpj', $this->id_pengajuan_lpj)->delete();

        session()->flash('alert_lpj', 'Lampiran Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->emit('dataTersimpanHapusLPJ');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function ubah_lampiran_lpj()
    {
        $a = PengajuanLPJ::where('id_pengajuan_lpj', $this->id_pengajuan_lpj)->first();
        if ($this->file_lpj != NULL) {
            if ($a->file_lpj != null) {
                $path = public_path() . "/uploads/pengajuan_lpj/" . $a->file_lpj;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $ext = $this->file_lpj->extension();
            $file_lpj_name = 'LPJ-UMUMPC-' . Str::random(10) . '.' . $ext;
            $this->file_lpj->storeAs('lampiran_lpj', $file_lpj_name);
        } else {
            $file_lpj_name = $a->file_lpj;
        }

        PengajuanLPJ::where('id_pengajuan_lpj', $this->id_pengajuan_lpj)->update([
            'judul_lpj' => $this->judul_lpj,
            'file_lpj' => $file_lpj_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul_lpj = NULL;
        $this->file_lpj = NULL;
        session()->flash('alert_lpj', 'Lampiran Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->emit('dataTersimpanUbahLPJ');
    }


    public function reset_edit()
    {
        $this->satuan_pengajuan_edit = NULL;
        $this->jumlah_penerima_edit = NULL;
        $this->nomor_surat_edit = NULL;
        $this->opsi_pemohon_edit = NULL;
        $this->nama_pemohon_edit = NULL;
        $this->nohp_pemohon_edit = NULL;
        $this->alamat_pemohon_edit = NULL;
        $this->nama_entitas_edit = NULL;
        $this->no_perijinan_entitas_edit = NULL;
        $this->alamat_entitas_edit = NULL;
        $this->pj_entitas_edit = NULL;
        $this->no_hp_entitas_edit =
            $this->jenis_tanda_terima_edit = NULL;
        $this->lainnya_edit = NULL;
        $this->tgl_surat_edit = NULL;
        $this->no_surat_edit = NULL;
        $this->tgl_pengajuan_edit = NULL;
        $this->tgl_pelaksanaan_edit = NULL;

        $this->sumber_dana_edit = NULL;
        $this->id_program_pilar_edit = NULL;
        $this->id_program_kegiatan_edit = NULL;
        $this->id_asnaf_edit = NULL;

        $this->nama_penerima_edit = NULL;
        $this->jenis_permohonan_edit = NULL;
        $this->pengajuan_note_edit = NULL;
        $this->pemohon_internal_edit = NULL;
    }

    public function render()
    {

      

        // dd($this->jumlah_penerima_edit);
    
        // 'pencairan_status' => 'Berhasil Dicairkan',

        $lampiran_pencairan = LampiranPencairan::where('id_pengajuan', $this->id_pengajuan)->get();
        if ($this->satuan_pengajuan_edit == '') {
            $this->satuan_pengajuan_edit = NULL;
        }
        if ($this->jumlah_penerima_edit == '') {
            $this->jumlah_penerima_edit = NULL;
        }
        if ($this->jumlah_penerima_edit != NULL or $this->satuan_pengajuan_edit != NULL) {

            $a = str_replace('.', '', $this->satuan_pengajuan_edit);
            $b = str_replace('.', '', $this->jumlah_penerima_edit);
            $this->total_edit = number_format((int)$a * (int)$b, 0, '.', '.');
        }

         


        $this->survey = SurveyPenerimaManfaat::where('id_pengajuan', $this->id_pengajuan)->where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->first() ?? null;
        // dd($this->survey);

        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan', $this->id_pengajuan)->first();

        $cek_jurnal_tersedia = JurnalUmum::where('id_pengajuan_detail',$data_detail->id_pengajuan_detail)->count();
          //untuk tampil jurnal
        $id_pengajuan_details =  $data_detail->id_pengajuan_detail;
        $lpj = PengajuanLPJ::where('id_pengajuan_detail', $this->id_pengajuan_detail)->orderBy('created_at', 'desc')->get();
     
        
          $siftnu = config('app.database_siftnu');
          $gocap = config('app.database_gocap');
          
            if ($cek_jurnal_tersedia > 0) {
              $detail_jurnal_id = JurnalUmum::where('id_pengajuan_detail', $id_pengajuan_details)->value('id_jurnal_umum');
              $ids = $detail_jurnal_id;
              $detail_jurnal = JurnalUmum::where('id_jurnal_umum', $detail_jurnal_id)->first();
              
              if($detail_jurnal){
                    $get_detail = JurnalUmum::join($gocap . '.rekening', 'rekening.id_rekening', '=', 'jurnal_umum.akun')
                  ->where('nomor', $detail_jurnal->nomor)->orderby('jurnal_umum.created_at', 'desc')->get();
              $rekenings = Rekening::whereNotNull('id_pc')->orderby('nomor_akun', 'asc')->get();
              }else{
                  $get_detail= [];
              $rekenings = '';
              }
            
          } else {
              $detail_jurnal_id = '';
              $ids = '';
              $detail_jurnal = '';
              $get_detail= [];
              $rekenings = '';
          }


        $dokumentasi_survey = SurveyFoto::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->get();
        // $this->id_pilar_d = $data_detail->id_program_pilar;
        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');
        $pengeluaran = PengajuanPengeluaran::where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->orderBy('created_at', 'DESC')->get();
        // PENGELUARAN
        $b = PengajuanPengeluaran::where('id_pengajuan_detail', $this->id_pengajuan_detail)->sum('nominal_pengeluaran');

        $this->dana_digunakan = $b;
        $this->nominal_pencairan = $data_detail->nominal_pencairan;

        $this->tab_v1();
        // $this->tab_v3();
        $c = DB::table($this->gocap . '.pengurus_jabatan')
            ->where('tingkat', 'pc')
            ->where('jabatan', 'Kepala Cabang')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();
        $this->id_direktur = $c->id_pc_pengurus;
        // pengurus keuangan
        $pengurus_keuangan = DB::table($this->gocap . '.pc_pengurus')
            ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where($this->siftnu . '.pengguna.status', '1')
            ->select(
                $this->siftnu . '.pengguna.nama',
                $this->gocap . '.pc_pengurus.id_pc_pengurus',
                $this->gocap . '.pengurus_jabatan.jabatan',
            )
            ->where($this->gocap . '.pc_pengurus.id_pc',  Auth::user()->PcPengurus->Pc->id_pc)
            ->where($this->gocap . '.pengurus_jabatan.id_pengurus_jabatan',  '694f38af-5374-11ed-882e-e4a8df91d8b3')
            ->first();
        $this->pengurus_keuangan = DB::table($this->gocap . '.pc_pengurus')
            ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where($this->siftnu . '.pengguna.status', '1')
            ->select(
                $this->siftnu . '.pengguna.nama',
                $this->gocap . '.pc_pengurus.id_pc_pengurus',
                $this->gocap . '.pengurus_jabatan.jabatan',
            )
            ->where($this->gocap . '.pc_pengurus.id_pc',  Auth::user()->PcPengurus->Pc->id_pc)
            ->where($this->gocap . '.pengurus_jabatan.id_pengurus_jabatan',  '694f38af-5374-11ed-882e-e4a8df91d8b3')
            ->get();
        $this->staf_keuangan = $pengurus_keuangan->id_pc_pengurus;
        // dd($c);

        $this->satuan_pengajuan =  number_format($data_detail->satuan_pengajuan, 0, '.', '.');

        if ($data_detail->satuan_disetujui_pencairan_direktur) {
            $this->nominal_disetujui2 = number_format((int)str_replace('.', '', $this->satuan_disetujui2) * $data_detail->jumlah_penerima, 0, '.', '.');
        } else {
            if ($this->nominal_disetujui2) {
                $this->nominal_disetujui2 = number_format($data_detail->nominal_disetujui2, 0, '.', '.');
            } else {
                $this->nominal_disetujui2 = '';
            }
        }

        if ($data_detail->nominal_disetujui == NULL) {
            $this->nominal_disetujui = number_format((int)str_replace('.', '', $this->satuan_disetujui) * $data_detail->jumlah_penerima, 0, '.', '.');
        } else {
            $this->nominal_disetujui = number_format($data_detail->nominal_disetujui, 0, '.', '.');
        }
        if ($data_detail->staf_keuangan_pc) {
            $this->total_pencairan = number_format((int)str_replace('.', '', $this->satuan_disetujui2) * $data_detail->jumlah_penerima, 0, '.', '.');
        } else {
            $this->total_pencairan = number_format($data_detail->nominal_disetujui, 0, '.', '.');
        }

        if ($this->id_rekening != null) {
            $rekening = Rekening::where('id_rekening', $this->id_rekening)
                // ->where('nama_rekening', 'PC LAZISNU CILACAP')
                ->first();
            $this->saldo =  number_format($rekening->saldo, 0, '.', '.');

            // NAMA BMT
            $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();
            if ($bmt == NULL) {
                $this->nama_bmt = 'BMT Belum Ada';
            } else {
                $this->nama_bmt = $bmt->nama_bmt;
            }
        } else {
            $this->id_rekening = NULL;
            $this->saldo = 'Pilih Rekening Terlebih Dahulu';
        }

        if ($this->id_rekening2 != null) {
            $rekening = Rekening::where('id_rekening', $this->id_rekening2)
                // ->where('nama_rekening', 'PC LAZISNU CILACAP')
                ->first();
            $this->saldo =  number_format($rekening->saldo, 0, '.', '.');
        }
        
        


       

        $this->rekening_direktur = Rekening::where('id_pc', $data->id_pc)
            // ->join($this->gocap . '.bmt', $this->gocap . '.bmt.id_bmt', '=', $this->gocap . '.rekening.id_bmt')
            ->whereNull('id_upzis')->whereNull('id_ranting')
            // ->whereNotNull('id_pc')
            ->whereNotNull('no_rekening')
            ->select(
                $this->gocap . '.rekening.*',
                // $this->gocap . '.bmt.nama_bmt',
            )
            // ->where('nama_rekening', 'PC LAZISNU CILACAP')
            ->get();

        
        
          if($this->metode_pencairan == 'Langsung') {
            //  dd('baba');
            $this->rekeningKeuanganList = Rekening::where('id_pc', $data->id_pc)
                    // ->join($this->gocap . '.bmt', $this->gocap . '.bmt.id_bmt', '=', $this->gocap . '.rekening.id_bmt')
                    ->whereNull('id_upzis')->whereNull('id_ranting')
                    // ->whereNotNull('id_pc')
                    ->whereNotNull('no_rekening')
                    ->whereNotNull('id_pc')
                    ->orderBy('nama_rekening','asc')
                    ->where('id_bmt', 'aac9da12-e38a-4437-9476-2cb90ee59428')
                    ->where('id_rekening', '!=', '0377f1a6-e11c-42c3-b1d2-48d73a677345')
                    ->whereNotIn('nama_rekening', ['KAS BENDA', 'KAS UANG'])
                    ->get();
                
         }else{
            //   dd('babi');
            $this->rekeningKeuanganList = Rekening::where('id_pc', $data->id_pc)
                    // ->join($this->gocap . '.bmt', $this->gocap . '.bmt.id_bmt', '=', $this->gocap . '.rekening.id_bmt')
                    ->whereNull('id_upzis')->whereNull('id_ranting')
                    // ->whereNotNull('id_pc')
                    ->whereNotNull('no_rekening')
                    ->orderBy('nama_rekening','asc')
                    ->select(
                        $this->gocap . '.rekening.*',
                        // $this->gocap . '.bmt.nama_bmt',
                    )
                    // ->where('nama_rekening', 'PC LAZISNU CILACAP')
                    ->get();
            
         } 
         
         
        //  $this->rekening_keuangan = Rekening::where('id_pc', $data->id_pc)
        //             ->when($this->rek_cek,function($q){
        //                 $q->whereNull('id_upzis')->whereNull('id_ranting')
        //                 ->whereNotNull('no_rekening')
        //                 ->where('id_rekening', '!=', $this->rek_cek->id_rekening)
        //                 ->select(
        //                     $this->gocap . '.rekening.*',
        //                 );
        //             })
        //             ->when($this->rek_cek,function($q){
        //                 $q->whereNull('id_upzis')->whereNull('id_ranting')
        //                 ->whereNotNull('no_rekening')
        //                 ->select(
        //                     $this->gocap . '.rekening.*',
        //                 );
        //             })
        //             ->when($this->metode_pencairan == 'Langsung',function($q){
        //                 $q->whereNull('id_upzis')->whereNull('id_ranting')
        //                 ->whereNotNull('no_rekening')
        //                 ->whereNotNull('id_pc')
        //                 ->where('id_bmt', 'aac9da12-e38a-4437-9476-2cb90ee59428')
        //                 ->where('id_rekening', '!=', '0377f1a6-e11c-42c3-b1d2-48d73a677345')
        //                 ->whereNotIn('nama_rekening', ['KAS BENDA', 'KAS UANG']);
        //             })
        //             ->get();
         
        //   dd($this->rekening_keuangan);
        

        $c = DB::table($this->gocap . '.pengurus_jabatan as pj')
    ->where('pj.tingkat', 'pc')
    ->where('pj.id_pengurus_jabatan', 'ef77ea4b-725b-11ed-ad27-e4a8df91d8b3')
    ->join($this->gocap . '.pc_pengurus as pp', 'pp.id_pengurus_jabatan', '=', 'pj.id_pengurus_jabatan')
    ->where('pp.status', '1')
    ->select('pp.id_pc_pengurus')
    ->first();

        // dd($c);
        $this->id_staf_media = $c->id_pc_pengurus;

        // $this->modal_pengajuan_berita();
        
        //  dd($this->rekening_keuangans);

        $this->berita = Berita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        
        $datas = lpjUmum::where('id_pengajuan_detail', $this->id_pengajuan_detail)->orderBy('created_at', 'DESC')
                ->when($this->cari, function ($query) {
                    return $query->where(function ($subQuery) {
                        $subQuery->where('dibayarkan_kepada', 'like', '%' . $this->cari . '%');
                    })->orWhere(function ($subQuery) {
                        $subQuery->where('keterangan', 'like', '%' . $this->cari . '%');
                    });
                })
                ->latest()
                ->paginate($this->page_number);
        // dd($datas);

        $this->updatingSearch();

        $dana_digunakan_umum = lpjUmum::where('id_pengajuan_detail', $this->id_pengajuan_detail)->sum('nominal');

        if ($data_detail->nominal_pencairan == null || $data_detail->nominal_pencairan == "")
        {
            $sisa_dana = $data_detail->nominal_disetujui_pencairan_direktur - $dana_digunakan_umum;   
        } else {
            $sisa_dana = $data_detail->nominal_pencairan - $dana_digunakan_umum; 
        }

        // dd($berita);
        return view('livewire.detail-pc', compact(
            'data',
            // 'berita',
            'data_detail',
            'pengeluaran',
            'lampiran_pencairan',
            'asnaf',
            'dokumentasi_survey',
            'cek_jurnal_tersedia',
            'rekenings', 
            'ids',
            'detail_jurnal',
            'get_detail',
            'lpj',
            'dana_digunakan_umum',
            'sisa_dana',
            'datas'
        ));
    }
    
    public $rekeningKeuanganList;
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function modal_umum_penggunaan_dana()
    {
        $this->id_lpj_umum = NULL;
        $this->tgl_penggunaan_dana = NULL;
        // $this->tgl_input = NULL;
        $this->dibayarkan_kepada = NULL;
        $this->nominal = NULL;
        $this->keterangan_lpj = NULL;
        $this->nota = NULL;
        $this->opsi_dana = NULL;
        $this->foto_kegiatan = NULL;
        // dd($this->nota);
    }

    public function tambah_umum_penggunaan_dana()
    {
        $id_lpj_umum = Str::uuid()->toString();
        $ext = $this->nota->extension();
        $file_nota_name = 'LPJ-UMUM-' . Str::random(10) . '.' . $ext;
        $this->nota->storeAs('penggunaan_dana_umum', $file_nota_name);

        $ext_keg = $this->foto_kegiatan->extension();
        $file_keg_name = 'LPJ-UMUM-' . Str::random(10) . '_FOTO-KEGIATAN' . '.' . $ext_keg;
        $this->foto_kegiatan->storeAs('foto_kegiatan_umum', $file_keg_name);

        lpjUmum::create([
            'id_pengajuan_detail' => $this->id_pengajuan_detail,
            'id_lpj_umum' => $id_lpj_umum,
            'tgl_penggunaan_dana' => $this->tgl_penggunaan_dana . ' ' . now()->timezone('Asia/Jakarta')->format('H:i:s'),
            'keterangan' => $this->keterangan_lpj,
            'dibayarkan_kepada' => $this->dibayarkan_kepada,
            'opsi_dana' => $this->opsi_dana,
            'nominal' => str_replace('.', '', $this->nominal),
            'nota' => $file_nota_name,
            'foto_kegiatan' => $file_keg_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->nota = NULL;
        $this->foto_kegiatan = NULL;
        session()->flash('alert_lampiran', 'Penggunaan Dana Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function modal_ubah_lpj_umum($id_lpj_umum)
    {
        // Pisahkan tanggal dan waktu
        $lpj = lpjUmum::where('id_lpj_umum', $id_lpj_umum)->first();
        // dd($lpj);
        list($tanggal, $waktu) = explode(' ', $lpj->tgl_penggunaan_dana);

        $this->tgl_penggunaan_dana_edit = $tanggal;
        // $this->tgl_input_edit = $lpj->tgl_input;
        $this->dibayarkan_kepada_edit = $lpj->dibayarkan_kepada;
        $this->nominal_edit = number_format($lpj->nominal, 0, '.', '.');
        $this->keterangan_edit = $lpj->keterangan;
        $this->nota = $lpj->nota;
        $this->opsi_dana_edit = $lpj->opsi_dana;
        $this->foto_kegiatan = $lpj->foto_kegiatan;

        $this->id_lpj_umum = $id_lpj_umum;
    }

    public function ubah_umum_penggunaan_dana()
    {
        $a = lpjUmum::where('id_lpj_umum', $this->id_lpj_umum)->first();
        // dd($this->nota);
        if ($this->nota != null && $this->nota != $a->nota) {
            if ($a->nota != null) {
                $path = public_path() . "/uploads/penggunaan_dana_umum/" . $a->nota;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $ext = $this->nota->extension();
            $nota_name = 'LPJ-INTERNAL-' . Str::random(10) . '.' . $ext;
            $this->nota->storeAs('penggunaan_dana_umum', $nota_name);
        } else {
            $nota_name = $a->nota;
        }

        if ($this->foto_kegiatan != null && $this->foto_kegiatan != $a->foto_kegiatan) {
            if ($a->foto_kegiatan != null) {
                $path_keg = public_path() . "/uploads/foto_kegiatan_umum/" . $a->foto_kegiatan;
                if (file_exists($path_keg)) {
                    unlink($path_keg);
                }
            }
            $ext_keg = $this->foto_kegiatan->extension();
            $keg_name = 'LPJ-UMUM-' . Str::random(10) . '_FOTO-KEGIATAN' . '.' . $ext_keg;
            $this->foto_kegiatan->storeAs('foto_kegiatan_umum', $keg_name);
        } else {
            $keg_name = $a->foto_kegiatan;
        }

        lpjUmum::where('id_lpj_umum', $this->id_lpj_umum)->update([
            // 'tgl_input' => $this->tgl_input_edit,
            'tgl_penggunaan_dana' => $this->tgl_penggunaan_dana_edit . ' ' . now()->timezone('Asia/Jakarta')->format('H:i:s'),
            'keterangan' => $this->keterangan_edit,
            'dibayarkan_kepada' => $this->dibayarkan_kepada_edit,
            'opsi_dana' => $this->opsi_dana_edit,
            'nominal' => str_replace('.', '', $this->nominal_edit),
            'nota' => $nota_name,
            'foto_kegiatan' => $keg_name
        ]);
        // dd($datax);

        session()->flash('alert_lampiran', 'Penggunaan Dana Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('close-modal');
        $this->reset_ubah();
    }

    public function reset_ubah()
    {
        $this->tgl_penggunaan_dana = NULL;
        $this->keterangan_lpj = NULL;
        $this->dibayarkan_kepada = NULL;
        $this->nominal = NULL;
        $this->nota = NULL;
        $this->opsi_dana = NULL;
        $this->foto_kegiatan = NULL;
    }

    public function modal_hapus_lpj_umum($id_lpj_umum)
    {
        $this->id_lpj_umum = $id_lpj_umum;
        // dd($id_lpj_umum);
    }

    public function hapus_lpj_umum()
    {
        // dd($this->id_lpj_umum);
        $a = lpjUmum::where('id_lpj_umum', $this->id_lpj_umum)->first();
        // dd($a);
        if ($a->nota != null) {
            $path = public_path() . "/uploads/penggunaan_dana_umum/" . $a->nota;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        lpjUmum::where('id_lpj_umum', $this->id_lpj_umum)->delete();

        session()->flash('alert_lampiran', 'Penggunaan Dana Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('tutupModal');
    }
    
    public function updatedMetode_pencairan(){
         dd($this->metode_pencairan);
        
    }

    public function nama_rekening($id)
    {
        $a = Rekening::where('id_rekening', $id)->first();
        // dd($a);

        if ($a != null) {
            return  $a->nama_rekening . " - " . $a->no_rekening ?? '-';
        }
        
    }

    public function modal_internal_lampiran_hapus($id_pengajuan_lampiran)
    {
        $this->id_pengajuan_lampiran = $id_pengajuan_lampiran;
    }


    public function modal_lampiran_pencairan_hapus($id_lampiran_pencairan)
    {
        $this->id_lampiran_pencairan  = $id_lampiran_pencairan;
    }

    public function hapus_lampiran_pencairan()
    {
        $a = LampiranPencairan::where('id_lampiran_pencairan', $this->id_lampiran_pencairan)->first();

        if ($a->file != null) {
            $path = public_path() . "/uploads/lampiran_pencairan/" . $a->file;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        LampiranPencairan::where('id_lampiran_pencairan', $this->id_lampiran_pencairan)->delete();

        session()->flash('alert_lampiran_pencairan_hapus', 'Lampiran Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->emit('dataTersimpanHapus');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function hapus_lampiran()
    {
        $a = PengajuanLampiran::where('id_pengajuan_lampiran', $this->id_pengajuan_lampiran)->first();

        if ($a->file != null) {
            $path = public_path() . "/uploads/pengajuan_lampiran/" . $a->file;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        PengajuanLampiran::where('id_pengajuan_lampiran', $this->id_pengajuan_lampiran)->delete();

        session()->flash('alert_lampiran', 'Lampiran Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function modal_pengeluaran_tambah()
    {
        $this->id_pengajuan_pengeluaran = NULL;
        $this->judul_pengeluaran = NULL;
        $this->nominal_pengeluaran = NULL;
        $this->tgl_pengeluaran = NULL;
        $this->jumlah_pengeluaran = NULL;
        $this->nota_pengeluaran = NULL;
    }

    public function modal_pengeluaran_ubah($id_pengajuan_pengeluaran)
    {
        $a = PengajuanPengeluaran::where('id_pengajuan_pengeluaran', $id_pengajuan_pengeluaran)->first();
        $this->id_pengajuan_pengeluaran = $id_pengajuan_pengeluaran;
        $this->judul_pengeluaran = $a->judul;
        $this->nominal_pengeluaran = number_format($a->nominal_pengeluaran, 0, '.', '.');
        $this->tgl_pengeluaran = $a->tgl_pengeluaran;
        $this->jumlah_pengeluaran = $a->jumlah;
    }

    public function ubah_pengeluaran()
    {
        $pengeluaran = PengajuanPengeluaran::where('id_pengajuan_pengeluaran', $this->id_pengajuan_pengeluaran)->first();
        if ($this->nota_pengeluaran != NULL) {
            if ($pengeluaran->nota != null) {
                $path = public_path() . "/uploads/nota_pengeluaran/" . $pengeluaran->nota;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $ext = $this->nota_pengeluaran->extension();
            $nota_pengeluaran_name = 'NP-UMUMPC-' . Str::random(10) . '.' . $ext;
            $this->nota_pengeluaran->storeAs('nota_pengeluaran', $nota_pengeluaran_name);
        } else {
            $nota_pengeluaran_name = $pengeluaran->nota;
        }

        PengajuanPengeluaran::where('id_pengajuan_pengeluaran', $this->id_pengajuan_pengeluaran)->update([
            'judul' => $this->judul_pengeluaran,
            'jumlah' => $this->jumlah_pengeluaran,
            'nominal_pengeluaran' =>  str_replace('.', '', $this->nominal_pengeluaran),
            'tgl_pengeluaran' => $this->tgl_pengeluaran,
            'nota' => $nota_pengeluaran_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        session()->flash('alert_pengeluaran', 'Pengeluaran Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function hapus_pengeluaran()
    {
        $pengeluaran = PengajuanPengeluaran::where('id_pengajuan_pengeluaran', $this->id_pengajuan_pengeluaran)->first();

        if ($pengeluaran->nota != null) {
            $path = public_path() . "/uploads/nota_pengeluaran/" . $pengeluaran->nota;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        PengajuanPengeluaran::where('id_pengajuan_pengeluaran', $this->id_pengajuan_pengeluaran)->delete();
        session()->flash('alert_pengeluaran', 'Pengeluaran Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function modal_pengeluaran_hapus($id_pengajuan_pengeluaran)
    {
        $this->id_pengajuan_pengeluaran = $id_pengajuan_pengeluaran;
    }

    public $judul_dokumentasi_survey;
    public $file_dokumentasi_survey;
    public $id_survey_foto;
    public function modal_dokumentasi_survey_tambah()
    {
        $this->judul_dokumentasi_survey = NULL;
        $this->file_dokumentasi_survey = NULL;
    }

    public function modal_dokumentasi_survey_hapus($id_survey_foto)
    {
        $this->id_survey_foto  = $id_survey_foto;
    }

    public $file_dokumentasi_survey_edit;
    public $judul_dokumentasi_survey_edit;
    public function modal_dokumentasi_survey_ubah($id_survey_foto)
    {
        // dd($id_lampiran_pencairan);
        $a = SurveyFoto::where('id_survey_foto', $id_survey_foto)->first();
        $this->file_dokumentasi_survey_edit  = $a->foto;
        $this->judul_dokumentasi_survey_edit = $a->judul;
        $this->id_survey_foto = $id_survey_foto;
    }

    public function tambah_dokumentasi_survey()
    {
        $id_survey_foto = Str::uuid()->toString();
        $ext = $this->file_dokumentasi_survey->extension();
        $file_dokumentasi_name = 'DOK-UMUMPC-' . Str::random(10) . '.' . $ext;
        $this->file_dokumentasi_survey->storeAs('dokumentasi_survey', $file_dokumentasi_name);

        SurveyFoto::create([
            'id_survey_foto' => $id_survey_foto,
            'id_pengajuan_detail' => $this->id_pengajuan_detail,
            'judul' => $this->judul_dokumentasi_survey,
            'foto' => $file_dokumentasi_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul_dokumentasi_survey = NULL;
        $this->file_dokumentasi_survey = NULL;
        session()->flash('alert_dokumentasi_survey', 'Dokumentasi Survey Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->emit('surveyFotoTambah');
        $this->dispatchBrowserEvent('close-modal1');
    }

    public function ubah_dokumentasi_survey()
    {

        $a = SurveyFoto::where('id_survey_foto', $this->id_survey_foto)->first();
        if ($this->file_dokumentasi_survey_edit != null && $this->file_dokumentasi_survey_edit != $a->foto) {
            if ($a->foto != null) {
                $path = public_path() . "/uploads/dokumentasi_survey/" . $a->foto;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $ext = $this->file_dokumentasi_survey_edit->extension();
            $foto_name = 'DOK-UMUMPC-' . Str::random(10) . '.' . $ext;
            $this->file_dokumentasi_survey_edit->storeAs('dokumentasi_survey', $foto_name);
        } else {
            $foto_name = $a->foto;
        }

        SurveyFoto::where('id_survey_foto', $this->id_survey_foto)->update([
            'judul' => $this->judul_dokumentasi_survey_edit,
            'foto' => $foto_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul_dokumentasi_survey_edit = NULL;
        $this->file_dokumentasi_survey_edit = NULL;
        session()->flash('alert_dokumentasi_survey_ubah', 'Dokumentasi Survey Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('close-modal2');
        // $this->dispatchBrowserEvent('closeModal');
        $this->emit('surveyFotoUbah');
    }

    public function hapus_dokumentasi_survey()
    {
        $a = SurveyFoto::where('id_survey_foto', $this->id_survey_foto)->first();

        if ($a->foto != null) {
            $path = public_path() . "/uploads/dokumentasi_survey/" . $a->foto;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        SurveyFoto::where('id_survey_foto', $this->id_survey_foto)->delete();

        session()->flash('alert_dokumentasi_survey_hapus', 'Dokumentasi Survey Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('close-modal3');
        $this->emit('surveyFotoHapus');
    }

    public function tambah_lampiran()
    {
        $id_pengajuan_lampiran = Str::uuid()->toString();
        $ext = $this->file_lampiran->extension();
        $file_lampiran_name = 'LMP-UMUMPC-' . Str::random(10) . '.' . $ext;
        $this->file_lampiran->storeAs('pengajuan_lampiran', $file_lampiran_name);

        PengajuanLampiran::create([
            'id_pengajuan_lampiran' => $id_pengajuan_lampiran,
            'id_pengajuan_detail' => $this->id_pengajuan_detail,
            'judul' => $this->judul,
            'file' => $file_lampiran_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul = NULL;
        $this->file_lampiran = NULL;
        session()->flash('alert_lampiran', 'Lampiran Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function tambah_lampiran_pencairan()
    {
        //  dd('qwd');
        $ext = $this->file_lampiran_pencairan->extension();
        $file_lampiran_name = 'LMP-PENCAIRAN-DANA-' . Str::random(10) . '.' . $ext;
        $this->file_lampiran_pencairan->storeAs('lampiran_pencairan', $file_lampiran_name);

        LampiranPencairan::create([
            'id_lampiran_pencairan' => Str::uuid()->toString(),
            'id_pengajuan' => $this->id_pengajuan,
            'judul' => $this->judul_file_pencairan,
            'file' => $file_lampiran_name,
            'id_pengurus_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul_file_pencairan = NULL;
        $this->file_lampiran_pencairan = NULL;
        session()->flash('alert_lampiran_pencairan', 'Lampiran Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->emit('dataTersimpanTambah');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function ubah_lampiran_pencairan()
    {

        $a = LampiranPencairan::where('id_lampiran_pencairan', $this->id_lampiran_pencairan)->first();
        if ($this->file_lampiran_pencairan != NULL) {
            if ($a->file != null) {
                $path = public_path() . "/uploads/lampiran_pencairan/" . $a->file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $ext = $this->file_lampiran_pencairan->extension();
            $file_lampiran_name = 'LMP-PENCAIRAN-DANA-' . Str::random(10) . '.' . $ext;
            $this->file_lampiran_pencairan->storeAs('lampiran_pencairan', $file_lampiran_name);
        } else {
            // dd($a->file);
            $file_lampiran_name = $a->file;
        }

        LampiranPencairan::where('id_lampiran_pencairan', $this->id_lampiran_pencairan)->update([
            'judul' => $this->judul_file_pencairan,
            'file' => $file_lampiran_name,
            'id_pengurus_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul_file_pencairan = NULL;
        $this->file_lampiran_pencairan = NULL;
        session()->flash('alert_lampiran_pencairan_ubah', 'Lampiran Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->emit('dataTersimpanPerubahan');
        $this->dispatchBrowserEvent('close-modal');
        // $this->dispatchBrowserEvent('closeModal');
    }

    public function ubah_lampiran()
    {
        $a = PengajuanLampiran::where('id_pengajuan_lampiran', $this->id_pengajuan_lampiran)->first();
        if ($this->file_lampiran != NULL) {
            if ($a->file != null) {
                $path = public_path() . "/uploads/pengajuan_lampiran/" . $a->file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $ext = $this->file_lampiran->extension();
            $file_lampiran_name = 'LMP-UMUMPC-' . Str::random(10) . '.' . $ext;
            $this->file_lampiran->storeAs('pengajuan_lampiran', $file_lampiran_name);
        } else {
            $file_lampiran_name = $a->file;
        }

        PengajuanLampiran::where('id_pengajuan_lampiran', $this->id_pengajuan_lampiran)->update([
            'judul' => $this->judul,
            'file' => $file_lampiran_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul = NULL;
        $this->file_lampiran = NULL;
        session()->flash('alert_lampiran', 'Lampiran Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function modal_internal_lampiran_ubah($id_pengajuan_lampiran)
    {
        $a = PengajuanLampiran::where('id_pengajuan_lampiran', $id_pengajuan_lampiran)->first();
        $this->judul = $a->judul;
        $this->id_pengajuan_lampiran = $id_pengajuan_lampiran;
    }

    public function tambah_pengeluaran()
    {
        $id_pengajuan_pengeluaran = Str::uuid()->toString();
        $ext = $this->nota_pengeluaran->extension();
        $nota_pengeluaran_name = 'NP-UMUMPC-' . Str::random(10) . '.' . $ext;
        $this->nota_pengeluaran->storeAs('nota_pengeluaran', $nota_pengeluaran_name);

        PengajuanPengeluaran::create([
            'id_pengajuan_pengeluaran' => $id_pengajuan_pengeluaran,
            'id_pengajuan_detail' => $this->id_pengajuan_detail,
            'judul' => $this->judul_pengeluaran,
            'jumlah' => $this->jumlah_pengeluaran,
            'nominal_pengeluaran' =>  str_replace('.', '', $this->nominal_pengeluaran),
            'tgl_pengeluaran' => $this->tgl_pengeluaran,
            'nota' => $nota_pengeluaran_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul_pengeluaran = NULL;
        $this->jumlah_pengeluaran = NULL;
        $this->nominal_pengeluaran = NULL;
        $this->tgl_pengeluaran = NULL;
        $this->nota_pengeluaran = NULL;

        session()->flash('alert_pengeluaran', 'Pengeluaran Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function modal_lampiran_pencairan_tambah()
    {
        $this->judul_file_pencairan = NULL;
    }

    public function modal_internal_lampiran_tambah()
    {
        $this->judul = NULL;
    }

    public function tab_v1()
    {
        // fo
      $b = DB::table($this->gocap . '.pengurus_jabatan as pj')
    ->where('pj.id_pengurus_jabatan', '300ff4f3-725c-11ed-ad27-e4a8df91d8b3')
    ->join($this->gocap . '.pc_pengurus as pp', 'pp.id_pengurus_jabatan', '=', 'pj.id_pengurus_jabatan')
    ->join($this->siftnu . '.pengguna as p', 'p.gocap_id_pc_pengurus', '=', 'pp.id_pc_pengurus')
    ->where('pp.status', '1')
    ->select('p.*')
    ->first();
        // dd($b);

        $this->id_front_office = $b->gocap_id_pc_pengurus;


        $this->id_front_office = $b->gocap_id_pc_pengurus;

        $this->penerima = PengajuanPenerima::where('id_pengajuan', $this->id_pengajuan)->where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->orderBy('created_at', 'DESC')->get();

        $this->lampiran = PengajuanLampiran::where('id_pengajuan_detail', $this->id_pengajuan_detail)->orderBy('created_at', 'DESC')->get();
    }

    public function tab_v2()
    {
        // $survey = PengajuanSurvey::where('id_pengajuan', $this->id_pengajuan)->where('id_pengajuan_detail', $this->id_pengajuan_detail)
        //     ->first();
        // $this->survey = PengajuanSurvey::where('id_pengajuan', $this->id_pengajuan)->where('id_pengajuan_detail', $this->id_pengajuan_detail)
        //     ->first();
        // if ($survey != null) {
        //     $this->tgl_survey = $survey->tgl_survey;
        //     $this->survey_hasil = $survey->survey_hasil;
        //     $this->survey_lokasi = $survey->survey_lokasi;
        //     $this->survey_catatan = $survey->survey_catatan;
        // }

        // $c = DB::table($this->gocap . '.pengurus_jabatan')
        //     ->where('tingkat', 'pc')
        //     ->where('jabatan', 'Divisi Program dan Administrasi Umum')
        //     ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
        //     ->where($this->gocap . '.pc_pengurus.status', '1')
        //     ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
        //     ->first();
        // // dd($c);
        // $this->id_staf_program = $c->id_pc_pengurus;
    }

    public function tab_v3()
    {

        // rekening
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $this->satuan_disetujui = number_format($data_detail->satuan_pengajuan, 0, '.', '.');

        $this->rekening = Rekening::where('id_pc', $data->id_pc)
            // ->join($this->gocap . '.bmt', $this->gocap . '.bmt.id_bmt', '=', $this->gocap . '.rekening.id_bmt')
            ->whereNull('id_upzis')->whereNull('id_ranting')
            // ->whereNotNull('id_pc')
            ->whereNotNull('no_rekening')
            ->select(
                $this->gocap . '.rekening.*',
                // $this->gocap . '.bmt.nama_bmt',
            )
            // ->where('nama_rekening', 'PC LAZISNU CILACAP')
            ->get();
        $rekening = Rekening::where('id_pc', $data->id_pc)->whereNull('id_upzis')->whereNull('id_ranting')
            // ->where('nama_rekening', 'PC LAZISNU CILACAP')
            ->get();
    }

    

    public function tombol_survey()
    {
        if ($this->none_block_survey == 'none') {
            $this->none_block_survey = 'block';
        } elseif ($this->none_block_survey == 'block') {
            $this->none_block_survey = 'none';
        }
    }

    public function survey()
    {
        // dd('wdwd');
        // Atau, jika Anda ingin menutup modal secara langsung, Anda bisa menggunakan kode berikut:

        $this->emit('waktu_alert');
        session()->flash('alert_penerima', 'Berhasil Melakukan Survey');
        $id_pengajuan_survey = Str::uuid()->toString();
        PengajuanSurvey::where('id_pengajuan_detail', $this->id_pengajuan_detail)->delete();

        if ($this->idsurveyini) {


            SurveyPenerimaManfaat::where('id_survey_penerima_manfaat', $this->idsurveyini)->update([
                'tanggal_survey' => $this->tgl_survey,
                'jenis_permohonan' => $this->jenis_permohonan,
                'lokasi_survey' => $this->survey_lokasi,
                'jumlah_anak' => $this->jumlah_anak,
                'jumlah_anggota_keluarga' => $this->jumlah_total,
                'punya_suami_istri' => $this->punya_pasangan,
                'pekerjaan_suami' => $this->pekerjaan_suami,
                'pekerjaan_istri' => $this->pekerjaan_istri,
                'pekerjaan_anak' => $this->pekerjaan_anak,
                'penghasilan_suami' => $this->penghasilan_suami,
                'penghasilan_istri' => $this->penghasilan_istri,
                'penghasilan_anak' => $this->penghasilan_anak,
                'kondisi_atap_rumah' => $this->kondisi_atap,
                'kondisi_dinding_rumah' => $this->kondisi_dinding,
                'kondisi_lantai_rumah' => $this->kondisi_lantai,
                'ukuran_rumah' => $this->kondisi_ukuran_rumah,
                'status_kepemilikan_rumah' => $this->kepemilikan_rumah,
                'status_kepemilikan_tanah' => $this->kepemilikan_tanah,
                'aset_lainnya' => $this->harta_aset_kekayaan,
                'biaya_pengeluaran_bulanan' => $this->tanggungan_rutin_bulan,
                'kebutuhan_saat_ini' => $this->kebutuhan_yg_dibutuhkan,
                'bantuan_yang_pernah_didapat' => $this->bantuan_yg_pernah_didapat,
                'indeks_rumah' => $this->indeks_rumah,
                'keterangan_indeks_rumah' => $this->indeks_rumah_keterangan,
                'kepemilikan_harta' => $this->indeks_harta,
                'keterangan_kepemilikan_harta' => $this->indeks_harta_keterangan,
                'pendapatan' => $this->indeks_pendapatan,
                'keterangan_pendapatan' => $this->indeks_pendapatan_keterangan,
                'hasil_rekomendasi' => $this->rokemendasi_surveyor,
                'hasil' => $this->survey_hasil,
            ]);
        } else {
            SurveyPenerimaManfaat::create([
                'id_survey_penerima_manfaat' => $id_pengajuan_survey,
                'id_penerima_manfaat' => $this->id_pengajuan_penerima,
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'id_pc_pengurus' => Auth::user()->gocap_id_pc_pengurus,
                'tanggal_survey' => $this->tgl_survey,
                'jenis_permohonan' => $this->jenis_permohonan,
                'lokasi_survey' => $this->survey_lokasi,
                'jumlah_anak' => $this->jumlah_anak,
                'jumlah_anggota_keluarga' => $this->jumlah_total,
                'punya_suami_istri' => $this->punya_pasangan,
                'pekerjaan_suami' => $this->pekerjaan_suami,
                'pekerjaan_istri' => $this->pekerjaan_istri,
                'pekerjaan_anak' => $this->pekerjaan_anak,
                'penghasilan_suami' => $this->penghasilan_suami,
                'penghasilan_istri' => $this->penghasilan_istri,
                'penghasilan_anak' => $this->penghasilan_anak,
                'kondisi_atap_rumah' => $this->kondisi_atap,
                'kondisi_dinding_rumah' => $this->kondisi_dinding,
                'kondisi_lantai_rumah' => $this->kondisi_lantai,
                'ukuran_rumah' => $this->kondisi_ukuran_rumah,
                'status_kepemilikan_rumah' => $this->kepemilikan_rumah,
                'status_kepemilikan_tanah' => $this->kepemilikan_tanah,
                'aset_lainnya' => $this->harta_aset_kekayaan,
                'biaya_pengeluaran_bulanan' => $this->tanggungan_rutin_bulan,
                'kebutuhan_saat_ini' => $this->kebutuhan_yg_dibutuhkan,
                'bantuan_yang_pernah_didapat' => $this->bantuan_yg_pernah_didapat,
                'indeks_rumah' => $this->indeks_rumah,
                'keterangan_indeks_rumah' => $this->indeks_rumah_keterangan,
                'kepemilikan_harta' => $this->indeks_harta,
                'keterangan_kepemilikan_harta' => $this->indeks_harta_keterangan,
                'pendapatan' => $this->indeks_pendapatan,
                'keterangan_pendapatan' => $this->indeks_pendapatan_keterangan,
                'hasil_rekomendasi' => $this->rokemendasi_surveyor,
                'hasil' => $this->survey_hasil,
            ]);
        }

        // $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan_detail;

        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan_detail;
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');

        $id_direk = PcPengurus::where('id_pengurus_jabatan', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')->value('id_pc_pengurus');
        $nama_direk = Pengguna::where('gocap_id_pc_pengurus', $id_direk)->value('nama');

        //mengosongkan inputan
        $this->tgl_survey = '';
        $this->nama_mustahik = '';
        $this->alamat_mustahik = '';
        $this->jenis_permohonan = '';
        $this->jumlah_anak = '';
        $this->jumlah_total = '';
        // $this->punya_pasangan='';
        $this->pekerjaan_suami = '';
        $this->pekerjaan_istri = '';
        $this->pekerjaan_anak = '';
        $this->penghasilan_suami = '';
        $this->penghasilan_istri = '';
        $this->penghasilan_anak = '';
        $this->kondisi_atap = '';
        $this->kondisi_dinding = '';
        $this->kondisi_ukuran_rumah = '';
        $this->kondisi_lantai = '';
        $this->kepemilikan_rumah = '';
        $this->kepemilikan_tanah = '';
        $this->harta_aset_kekayaan = '';
        $this->tanggungan_rutin_bulan = '';
        $this->kebutuhan_yg_dibutuhkan = '';
        $this->bantuan_yg_pernah_didapat = '';
        // $this->indeks_rumah='';
        $this->indeks_rumah_keterangan = '';
        // $this->indeks_harta='';
        $this->indeks_harta_keterangan = '';
        // $this->indeks_pendapatan='';
        $this->indeks_pendapatan_keterangan = '';
        $this->rokemendasi_surveyor = '';


        $this->none_block_survey = 'none';

        $this->emit('dataTersimpan');
        $this->dispatchBrowserEvent('closeModal');


        session()->flash('alert_survey', 'Berhasil Melakukan Survey');
        $this->emit('waktu_alert');

        // $this->tab_v2();
        // dd('terr');
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

    public function nama_pilars($id)
    {
        $a = ProgramPilar::where('id_program_pilar', $id)->first();

        return  $a->pilar ?? '';
    }

    public function tombol_tolak_keuangan()
    {
        $this->none_block_tolak = '';
        $this->none_block_acc = 'none';
        $data = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $this->denial_date = date('Y-m-d');
        $this->tgl_tolak_pencairan = date('Y-m-d');
    }

    public function acc()
    {
        // dd($this->id_rekening);

        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

        //     $rekening = Rekening::where('id_rekening',$this->id_rekening)
        //         ->first();
        //    $saldo_sisa = $rekening->saldo - (str_replace('.', '', $this->nominal_disetujui));
        //     Rekening::where('id_rekening',$this->id_rekening)
        //         ->update([
        //             'saldo' => $saldo_sisa
        //         ]);
        $rekening = Rekening::where('id_rekening', $this->id_rekening)
            ->first();


        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'approval_date' => $this->approval_date,
            'approval_status' => 'Disetujui',
            'approver_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            // 'satuan_disetujui' => str_replace('.', '', $this->satuan_disetujui),
            // 'nominal_disetujui' => str_replace('.', '', $this->nominal_disetujui),
            'keterangan_acc' => $this->keterangan_acc,
            // 'id_rekening' => $this->id_rekening,
            'pil_survey' => $this->pil_survey,
            'staf_keuangan_pc' => $this->staf_keuangan,
            'respon_ketua' => $this->respon_ketua,
        ]);


        // $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan_detail;
        // $url =  "https://e-tasyaruf.nucarecilacap.id";
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        // $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');

        $direktur = DB::table($this->gocap . '.pengurus_jabatan')
            ->where($this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();
            
        $ketua = DB::table($this->gocap . '.pengurus_jabatan')->where($this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', 'c0e0faee-3590-11ed-9a47-e4a8df91d887')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $d_penyaluran = DB::table($this->gocap . '.pengurus_jabatan')
        ->where($this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '20f2ff4d-1596-48ab-b60d-8a4b75a9784d')
        ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
        ->where($this->gocap . '.pc_pengurus.status', '1')
        ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
        ->first();


        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        if ($ajuan->opsi_pemohon == "Individu") {
            $pemohon = $D_ajuan->nama_pemohon;
        } elseif ($ajuan->opsi_pemohon == "Entitas") {
            $pemohon = $D_ajuan->nama_entitas;
        } elseif ($ajuan->opsi_pemohon == "Internal") {
            $pemohon = $this->nama_pengurus_pc($ajuan->pemohon_internal);
        }


        // dd($D_ajuan->sumber_dana . '\\'. $this->nama_pengurus_pc($program->id_pc_pengurus) . '\\'. $this->jabatan_pengurus_pc($program->id_pc_pengurus) );
        if ($this->pil_survey == 'Tidak Perlu') {

            if ($this->respon_ketua == 'Perlu') {
                // kirim notif wa
                $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

                $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
                // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
                // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

                // ketua
                $this->notif(
                    // Helper::getNohpPengurus('pc', $ketua->id_pc_pengurus),
                    '089639481199',

                    "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                        "Yth. " . "*" . $this->nama_pengurus_pc($ketua->id_pc_pengurus) .  "*" . "\n" .
                        $this->jabatan_pengurus_pc($ketua->id_pc_pengurus) . "\n" . "\n" .

                        "*Pengajuan Umum Tingkat PC disetujui Kepala Cabang (tanpa survey).*" . "\n" . "*Segera berikan respon persetujuan ketua.*" . "\n" . "\n" .

                        "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                        "*" .  "Nomor"  . "*" .  "\n" .
                        $ajuan->nomor_surat  . "\n" .
                        "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Nama Pemohon"  . "*" .  "\n" .
                        $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                        "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                        'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" . "\n" .
                        "========================" . "\n" . "\n" .
                        "*" .  "Asnaf"  . "*" .  "\n" .
                        $asnaf .  "\n" .
                        "*" .  "Pilar"  . "*" .  "\n" .
                        $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                        $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                        "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                        $D_ajuan->pengajuan_note .  "\n" . "\n" .

                        "Terima Kasih." . "\n" . "\n" .
                        url($url)
                );
            } else {
                // kirim notif wa
                $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

                $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
                // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
                // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

                // ketua
                $this->notif(
                    // Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
                    '089639481199',

                    "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                        "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                        $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                        "*Pengajuan Umum Tingkat PC disetujui Kepala Cabang (tanpa survey).*" . "\n" . "\n" .

                        "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                        "*" .  "Nomor"  . "*" .  "\n" .
                        $ajuan->nomor_surat  . "\n" .
                        "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Nama Pemohon"  . "*" .  "\n" .
                        $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                        "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                        'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" . "\n" .
                        "========================" . "\n" . "\n" .
                        "*" .  "Asnaf"  . "*" .  "\n" .
                        $asnaf .  "\n" .
                        "*" .  "Pilar"  . "*" .  "\n" .
                        $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                        $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                        "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                        $D_ajuan->pengajuan_note .  "\n" . "\n" .

                        "Terima Kasih." . "\n" . "\n" .
                        url($url)
                );
            }
        }


        if ($this->pil_survey == 'Perlu') {
            

                // kirim notif wa
                $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

                $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
                // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
                // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

                // petugas penyaluran
                $this->notif(
                    // Helper::getNohpPengurus('pc', $d_penyaluran->id_pc_pengurus),
                    '089639481199',


                    "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                        // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                        // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                        "Yth. " . "*" . $this->nama_pengurus_pc($d_penyaluran->id_pc_pengurus) .  "*" . "\n" .
                        $this->jabatan_pengurus_pc($d_penyaluran->id_pc_pengurus) . "\n" . "\n" .

                        "*Pengajuan Umum Tingkat PC disetujui Kepala Cabang.*" . "\n" . "*Segera input penerima manfaat, dokumentasi & hasil survey*" . "\n" . "\n" .
                        "*Konfirmasi jika telah selesai survey.*" . "\n" . "\n" .

                        "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                        "*" .  "Nomor"  . "*" .  "\n" .
                        $ajuan->nomor_surat  . "\n" .
                        "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Nama Pemohon"  . "*" .  "\n" .
                        $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                        "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                        'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" . "\n" .
                        "========================" . "\n" . "\n" .
                        "*" .  "Asnaf"  . "*" .  "\n" .
                        $asnaf .  "\n" .
                        "*" .  "Pilar"  . "*" .  "\n" .
                        $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                        $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                        "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                        $D_ajuan->pengajuan_note .  "\n" . "\n" .

                        "Terima Kasih." . "\n" . "\n" .
                        url($url)
                );

                if ($this->respon_ketua == 'Perlu') {
                    // kirim notif wa
                    $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;
    
                    $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
                    // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
                    // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');
    
                    // ketua
                    $this->notif(
                        // Helper::getNohpPengurus('pc', $ketua->id_pc_pengurus),
                        '089639481199',
    
                        "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
    
                            "Yth. " . "*" . $this->nama_pengurus_pc($ketua->id_pc_pengurus) .  "*" . "\n" .
                            $this->jabatan_pengurus_pc($ketua->id_pc_pengurus) . "\n" . "\n" .
    
                            "*Pengajuan Umum Tingkat PC disetujui Kepala Cabang (tanpa survey).*" . "\n" . "*Segera berikan respon persetujuan ketua.*" . "\n" . "\n" .
    
                            "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                            "*" .  "Nomor"  . "*" .  "\n" .
                            $ajuan->nomor_surat  . "\n" .
                            "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                            \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                            "*" .  "Nama Pemohon"  . "*" .  "\n" .
                            $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                            "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                            'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" . "\n" .
                            "========================" . "\n" . "\n" .
                            "*" .  "Asnaf"  . "*" .  "\n" .
                            $asnaf .  "\n" .
                            "*" .  "Pilar"  . "*" .  "\n" .
                            $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                            $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                            "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                            $D_ajuan->pengajuan_note .  "\n" . "\n" .
    
                            "Terima Kasih." . "\n" . "\n" .
                            url($url)
                    );
                } else {
                    // kirim notif wa
                    $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;
    
                    $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
                    // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
                    // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');
    
                    // ketua
                    $this->notif(
                        // Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
                        '089639481199',
    
                        "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
    
                            "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                            $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .
    
                            "*Pengajuan Umum Tingkat PC disetujui Kepala Cabang (tanpa survey).*" . "\n" .  "\n" .
    
                            "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                            "*" .  "Nomor"  . "*" .  "\n" .
                            $ajuan->nomor_surat  . "\n" .
                            "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                            \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                            "*" .  "Nama Pemohon"  . "*" .  "\n" .
                            $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                            "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                            'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" . "\n" .
                            "========================" . "\n" . "\n" .
                            "*" .  "Asnaf"  . "*" .  "\n" .
                            $asnaf .  "\n" .
                            "*" .  "Pilar"  . "*" .  "\n" .
                            $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                            $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                            "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                            $D_ajuan->pengajuan_note .  "\n" . "\n" .
    
                            "Terima Kasih." . "\n" . "\n" .
                            url($url)
                    );
                }

        }


        $this->none_block_acc = 'none';
        session()->flash('alert_direktur', 'Pengajuan Berhasil Disetujui');
        $this->emit('waktu_alert');
    }

    public function acc_direktur_keuangan()
    {
        // dd('testing acc direktur keuangan');
        // dd($this->id_rekening);

        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

        //     $rekening = Rekening::where('id_rekening',$this->id_rekening)
        //         ->first();
        //    $saldo_sisa = $rekening->saldo - (str_replace('.', '', $this->nominal_disetujui));
        //     Rekening::where('id_rekening',$this->id_rekening)
        //         ->update([
        //             'saldo' => $saldo_sisa
        //         ]);
        $rekening = Rekening::where('id_rekening', $this->id_rekening)
            ->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();


        // dd($this->satuan_disetujui . $this->nominal_disetujui);
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'approval_date_pencairan_direktur' => $this->approval_date_pencairan_direktur,
            'approval_status_pencairan_direktur' => 'Disetujui',
            'approval_pencairan_direktur_id' => Auth::user()->gocap_id_pc_pengurus,
            'satuan_disetujui_pencairan_direktur' => str_replace('.', '', $this->satuan_disetujui),
            'nominal_disetujui_pencairan_direktur' => str_replace('.', '', $this->nominal_disetujui),
            'keterangan_acc_pencairan_direktur' => $this->keterangan_acc_pencairan_direktur,
            // 'id_rekening_pencairan_direktur' => $this->id_rekening,
            'sumber_dana_opsi' => $this->sumber_dana_opsi,
            // 'pil_survey' => $this->pil_survey,
            'staf_keuangan_pc' => $this->staf_keuangan,
            'id_asnaf' => $this->id_asnaf_d,
            'id_program_pilar' => $this->id_pilar_d,
            'id_program_kegiatan' => $this->id_program_kegiatan_d,
        ]);


        // $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan_detail;
        // $url =  "https://e-tasyaruf.nucarecilacap.id";
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        // $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();


        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');

        $keuangan = DB::table($this->gocap . '.pengurus_jabatan as pj')
                ->where('pj.tingkat', 'pc')
                ->where('pj.id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')
                ->join($this->gocap . '.pc_pengurus as pp', 'pp.id_pengurus_jabatan', '=', 'pj.id_pengurus_jabatan')
                ->where('pp.status', '1')
                ->select('pp.id_pc_pengurus')
                ->first();

        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        if ($ajuan->opsi_pemohon == "Individu") {
            $pemohon = $D_ajuan->nama_pemohon;
        } elseif ($ajuan->opsi_pemohon == "Entitas") {
            $pemohon = $D_ajuan->nama_entitas;
        } elseif ($ajuan->opsi_pemohon == "Internal") {
            $pemohon = $this->nama_pengurus_pc($ajuan->pemohon_internal);
        }



        // kirim notif wa
        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

        $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
        // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
        // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

        // petugas penyaluran
        $this->notif(
            // Helper::getNohpPengurus('pc', $keuangan->id_pc_pengurus),
            '089639481199',

            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                "Yth. " . "*" . $this->nama_pengurus_pc($keuangan->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($keuangan->id_pc_pengurus) . "\n" . "\n" .

                "*Pencairan dana untuk Pengajuan Umum Tingkat PC telah disetujui Direktur.*" . "\n" . "*Segera berikan respon persetujuan Div. Keuangan.*" . "\n" . "\n" .

                "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $ajuan->nomor_surat  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nama Pemohon"  . "*" .  "\n" .
                $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($D_ajuan->satuan_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                "*" .  "Survey"  . "*" .  "\n" .
                $D_ajuan->pil_survey  . "\n" .
                "*" .  "Sumber Dana"  . "*" .  "\n" .
                $this->sumber_dana_opsi .  "\n" . "\n" .
                "========================" . "\n" . "\n" .
                "*" .  "Asnaf"  . "*" .  "\n" .
                $asnaf .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $D_ajuan->pengajuan_note .  "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        $this->none_block_acc_direktur_keuangan = 'none';
        session()->flash('alert_keuangan', 'Pengajuan Berhasil Disetujui');
        $this->emit('waktu_alert');
    }

    public function acc_program()
    {
        // dd($this->id_rekening);

        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

        //     $rekening = Rekening::where('id_rekening',$this->id_rekening)
        //         ->first();
        //    $saldo_sisa = $rekening->saldo - (str_replace('.', '', $this->nominal_disetujui));
        //     Rekening::where('id_rekening',$this->id_rekening)
        //         ->update([
        //             'saldo' => $saldo_sisa
        //         ]);
        // $rekening = Rekening::where('id_rekening', $this->id_rekening)
        //     ->first();


        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'approval_date_divpro' => $this->approval_date_divpro,
            'approval_status_divpro' => 'Disetujui',
            'approver_divpro' => Auth::user()->gocap_id_pc_pengurus,
            // 'satuan_disetujui' => str_replace('.', '', $this->satuan_disetujui),
            // 'nominal_disetujui' => str_replace('.', '', $this->nominal_disetujui),
            'status_divpro' => 'Diterima',
            'tgl_diserahkan_direktur' => $this->tgl_diserahkan_direktur,
            'keterangan_acc_divpro' => $this->keterangan_acc_divpro,
            // 'id_rekening' => $this->id_rekening,
            // 'staf_keuangan_pc' => $this->staf_keuangan,
        ]);


        // $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan_detail;
        // $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        // $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');

        // if ($bmt == NULL) {
        //     $nama_bmt = "BMT Belum Ada";
        // } else {
        //     $nama_bmt = $bmt->nama_bmt;
        // }

        $id_direk = PcPengurus::where('id_pengurus_jabatan', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')->value('id_pc_pengurus');
        $nama_direk = Pengguna::where('gocap_id_pc_pengurus', $id_direk)->value('nama');


        $direktur = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Kepala Cabang')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        if ($ajuan->opsi_pemohon == "Individu") {
            $pemohon = $D_ajuan->nama_pemohon;
        } elseif ($ajuan->opsi_pemohon == "Entitas") {
            $pemohon = $D_ajuan->nama_entitas;
        } elseif ($ajuan->opsi_pemohon == "Internal") {
            $pemohon = $this->nama_pengurus_pc($ajuan->pemohon_internal);
        }

        // dd($D_ajuan->sumber_dana . '\\'. $this->nama_pengurus_pc($program->id_pc_pengurus) . '\\'. $this->jabatan_pengurus_pc($program->id_pc_pengurus) );


        // kirim notif wa
        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

        $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
        // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
        // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

        // petugas penyaluran
        $this->notif(
            // Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
            '089639481199',

            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                "*Pengajuan diterima Div. Program & diteruskan kepada Direktur.*" . "\n" . "\n" . "*Segera berikan respon persetujuan & kebutuhan survey (perlu survey / tanpa survey)*" . "\n" . "\n" .

                "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $ajuan->nomor_surat  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nama Pemohon"  . "*" .  "\n" .
                $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" . "\n" .
                "========================" . "\n" . "\n" .
                "*" .  "Asnaf"  . "*" .  "\n" .
                $asnaf .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $D_ajuan->pengajuan_note .  "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        $this->none_block_acc_program = 'none';
        session()->flash('alert_direktur', 'Pengajuan Berhasil Disetujui');
        $this->emit('waktu_alert');
    }


    public function tolak()
    {
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'denial_date' => $this->denial_date,
            'denial_note' => $this->denial_note,
            'approval_status' => 'Ditolak',
            'denial_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        // fo
        $front = DB::table($this->gocap . '.pengurus_jabatan as pj')
    ->where('pj.tingkat', 'pc')
    ->where('pj.id_pengurus_jabatan', '300ff4f3-725c-11ed-ad27-e4a8df91d8b3')
    ->join($this->gocap . '.pc_pengurus as pp', 'pp.id_pengurus_jabatan', '=', 'pj.id_pengurus_jabatan')
    ->where('pp.status', '1')
    ->select('pp.id_pc_pengurus')
    ->first();
    // dd($front);

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');
        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();


        $this->notif(
            // nomor fo
            // $this->nohp_pengurus_pc($front->id_pc_pengurus),
            '089639481199',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                "Yth. " . "*" . $this->nama_pengurus_pc($front->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($front->id_pc_pengurus) . "\n" . "\n" .

                "*" .  "Mohon segera ditinjau kembali"  . "*" .  "\n" .
                "Pengajuan UMUM PC Lazisnu Cilacap telah " . "*" . "di-tolak" . "*" . " oleh Direktur PC Lazisnu Cilacap, dengan detail sebagai berikut :" . "\n" . "\n" .

                // "*" .  "Nomor"  . "*" .  "\n" .
                // $data->nomor_surat  . "\n" .
                // "*" .  "Pemohon"  . "*" .  "\n" .
                // $data_detail->nama_pemohon .  "\n" .
                // "*" .  "Target Penerima Manfaat"  . "*" .  "\n" .
                // $data_detail->nama_penerima .  "\n" .
                // "*" .  "Petugas Pentasyarufan"  . "*" .  "\n" .
                // $this->nama_pengurus_pc($data_detail->petugas_pc) . "\n" .
                // "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                // \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                // "*" .  "Tanggal Ditolak"  . "*" .  "\n" .
                // \Carbon\Carbon::parse($this->denial_date)->isoFormat('D MMMM Y')  .  "\n" .
                // "*" .  "Catatan"  . "*" .  "\n" .
                // $this->denial_note  . "\n" . "\n" .

                "*" .  "Nomor"  . "*" .  "\n" .
                $data->nomor_surat  . "\n" .
                "*" .  "Pemohon"  . "*" .  "\n" .
                $data_detail->nama_pemohon .  "\n" .
                "*" .  "Target Penerima Manfaat"  . "*" .  "\n" .
                $data_detail->nama_penerima .  "\n" .

                "*" .  "Jumlah Penerima Manfaat"  . "*" .  "\n" .
                $data_detail->jumlah_penerima .  "\n" .

                "*" .  "Survey"  . "*" .  "\n" .
                $data->survey_pc .  "\n" .


                "*" .  "Petugas Pentasyarufan"  . "*" .  "\n" .
                $this->nama_pengurus_pc($data_detail->petugas_pc) . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($data_detail->nominal_pengajuan, 0, '.', '.') . ',-' .  "\n" .

                "*" .  "Asnaf"  . "*" .  "\n" .
                $asnaf .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $D_ajuan->pengajuan_note .  "\n" .

                "*" .  "Alasan"  . "*" .  "\n" .
                $this->denial_note .  "\n" . "\n" .


                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        $this->none_block_tolak = 'none';
        session()->flash('alert_direktur', 'Pengajuan Berhasil Ditolak');
        $this->emit('waktu_alert');
    }

    public function tolak_direktur_keuangan()
    {
        // dd('TESTING PENOLAKAN PENCAIRAN DANA DIREKTUR');
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'denial_date_pencairan_direktur' => $this->denial_date_pencairan_direktur,
            'denial_note_pencairan_direktur' => $this->denial_note_pencairan_direktur,
            'approval_status_pencairan_direktur' => 'Ditolak',
            'denial_pencairan_direktur_id' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        // fo
        $front = DB::table($this->gocap . '.pengurus_jabatan as pj')
    ->where('pj.tingkat', 'pc')
    ->where('pj.id_pengurus_jabatan', '300ff4f3-725c-11ed-ad27-e4a8df91d8b3')
    ->join($this->gocap . '.pc_pengurus as pp', 'pp.id_pengurus_jabatan', '=', 'pj.id_pengurus_jabatan')
    ->where('pp.status', '1')
    ->select('pp.id_pc_pengurus')
    ->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');
        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        $this->notif(
            // nomor fo
            // $this->nohp_pengurus_pc($front->id_pc_pengurus),
            '089639481199',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                "Yth. " . "*" . $this->nama_pengurus_pc($front->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($front->id_pc_pengurus) . "\n" . "\n" .

                "*" .  "Mohon segera ditinjau kembali"  . "*" .  "\n" .
                "Pengajuan UMUM PC Lazisnu Cilacap telah " . "*" . "di-tolak" . "*" . " oleh Direktur PC Lazisnu Cilacap, dengan detail sebagai berikut :" . "\n" . "\n" .

                // "*" .  "Nomor"  . "*" .  "\n" .
                // $data->nomor_surat  . "\n" .
                // "*" .  "Pemohon"  . "*" .  "\n" .
                // $data_detail->nama_pemohon .  "\n" .
                // "*" .  "Target Penerima Manfaat"  . "*" .  "\n" .
                // $data_detail->nama_penerima .  "\n" .
                // "*" .  "Petugas Pentasyarufan"  . "*" .  "\n" .
                // $this->nama_pengurus_pc($data_detail->petugas_pc) . "\n" .
                // "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                // \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                // "*" .  "Tanggal Ditolak"  . "*" .  "\n" .
                // \Carbon\Carbon::parse($this->denial_date)->isoFormat('D MMMM Y')  .  "\n" .
                // "*" .  "Catatan"  . "*" .  "\n" .
                // $this->denial_note  . "\n" . "\n" .

                "*" .  "Nomor"  . "*" .  "\n" .
                $data->nomor_surat  . "\n" .
                "*" .  "Pemohon"  . "*" .  "\n" .
                $data->opsi_pemohon . " - " . $data_detail->nama_pemohon .  "\n" .
                "*" .  "Target Penerima Manfaat"  . "*" .  "\n" .
                $data_detail->nama_penerima .  "\n" .

                "*" .  "Jumlah Penerima Manfaat"  . "*" .  "\n" .
                $data_detail->jumlah_penerima .  "\n" .

                "*" .  "Survey"  . "*" .  "\n" .
                $data->survey_pc .  "\n" .


                "*" .  "Petugas Pentasyarufan"  . "*" .  "\n" .
                $this->nama_pengurus_pc($data_detail->petugas_pc) . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($data_detail->satuan_pengajuan, 0, '.', '.') . ',-' .  "\n" . "\n" .


                "========================" . "\n" . "\n" .
                "*" .  "Asnaf"  . "*" .  "\n" .
                $asnaf .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $D_ajuan->pengajuan_note .  "\n" .

                "*" .  "Alasan"  . "*" .  "\n" .
                $this->denial_note .  "\n" . "\n" .

                // "*" .  "Pilar"  . "*" .  "\n" .
                // $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                // "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                // $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" . "\n" .


                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );




        $this->none_block_tolak_direktur_keuangan = 'none';
        session()->flash('alert_direktur', 'Pengajuan Berhasil Ditolak');
        $this->emit('waktu_alert');
    }

    public function tombol_terbit()
    {

        if ($this->none_block_terbit == 'none') {
            $this->none_block_terbit = 'block';
        } elseif ($this->none_block_terbit == 'block') {
            $this->none_block_terbit = 'none';
        }
    }

    public function terbit_berita()
    {
        // dd('wdw');
        Berita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'tanggal_terbit' => date('Y-m-d'),
            'status' => 'Sudah Terbit',

        ]);
        session()->flash('alert_berita', 'Berita Berhasil Diterbitkan');
        $this->none_block_terbit = 'none';
        $this->emit('waktu_alert');
        // $this->modal_pengajuan_berita();
    }

    public function tambah_ubah_berita_pc()
    {
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();


        $a = Berita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        if ($a) {
            return redirect('/pc/arsip/detail_berita/' . $a->id_berita_umum);
        } else {
            $id_berita_umum = uniqid();
            Berita::create([
                'id_berita_umum' =>  $id_berita_umum,
                'status' => 'Belum Diinput',
                'id_pc' => $data->id_pc,
                'id_upzis' => $data->id_upzis,
                'id_ranting' => $data->id_ranting,
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'kategori_berita' => 'Lazisnu Cilacap',
            ]);

            return redirect('/pc/arsip/detail_berita/' .  $id_berita_umum);
        }
    }

    public function tambah_ubah_berita()
    {


        // TAMBAH
        if ($this->id_pengajuan_berita == NULL) {
            $id_pengajuan_berita = Str::uuid()->toString();
            if ($this->file_berita_baru != NULL) {
                $ext = $this->file_berita_baru->extension();
                $file_berita_name = 'BRT-UMUMPC-' . Str::random(10) . '.' . $ext;
                $this->file_berita_baru->storeAs('foto_berita', $file_berita_name);
            } else {
                $file_berita_name = NULL;
            }

            Pengajuanberita::create([
                'id_pengajuan_berita' => $id_pengajuan_berita,
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'judul' => $this->judul_berita,
                'tgl_terbit' => $this->tgl_terbit_berita,
                'narasi' => $this->narasi_berita2,
                'status' => 'Belum Terbit',

                'file' => $file_berita_name,
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);

            session()->flash('alert_berita', 'Berita Berhasil Diubah');
            $this->emit('waktu_alert');
        }
        // UBAH
        else {

            $berita = PengajuanBerita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
            if ($this->file_berita_baru != $berita->file and $this->file_berita_baru != NULL) {
                if ($berita->file != null) {
                    $path = public_path() . "/uploads/foto_berita/" . $berita->file;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $ext = $this->file_berita_baru->extension();
                $file_berita_name = 'BRT-UMUMPC-' . Str::random(10) . '.' . $ext;
                $this->file_berita_baru->storeAs('foto_berita', $file_berita_name);
            } else {
                $file_berita_name = $berita->file;
            }

            PengajuanBerita::where('id_pengajuan_berita', $this->id_pengajuan_berita)->update([
                'judul' => $this->judul_berita,
                'tgl_terbit' => $this->tgl_terbit_berita,
                'narasi' => $this->narasi_berita2,
                'file' => $file_berita_name,
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);

            session()->flash('alert_berita', 'Berita Berhasil Diubah');
            $this->emit('waktu_alert');
        }
        $this->modal_pengajuan_berita();
        $this->dispatchBrowserEvent('closeModal');
    }

    public function nama_pc($id)
    {
        $a = DB::table($this->gocap . '.pc')->where('id_pc', $id)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.pc.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_pc')
            ->first();
        $nama_pc_tanpa_titik = str_replace('. ', '', $a->nama_pc);
        $nama_pc_tanpa_kab = str_replace('KAB', '', $nama_pc_tanpa_titik);
        return 'PC NU Care Lazisnu ' .  $nama_pc_tanpa_kab;
    }

    public function tombol_tolak_program()
    {
        $this->none_block_acc = 'none';
        $this->none_block_acc_program = 'none';
        $this->none_block_tolak = 'none';

        if ($this->none_block_tolak_program == 'none') {
            $this->none_block_tolak_program = 'block';
        } elseif ($this->none_block_tolak_program == 'block') {
            $this->none_block_tolak_program = 'none';
        }

        $data = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $this->denial_date_divpro = date('Y-m-d');

        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();


        if ($data->denial_note_divpro == NULL) {
            $this->denial_note_divpro = NULL;
        } else {
            $this->denial_note_divpro = $data->denial_note_divpro;
        }
    }

    public function tombol_tolak()
    {
        $this->none_block_acc = 'none';
        $this->none_block_tolak_program = 'none';
        $this->none_block_acc_program = 'none';

        if ($this->none_block_tolak == 'none') {
            $this->none_block_tolak = 'block';
        } elseif ($this->none_block_tolak == 'block') {
            $this->none_block_tolak = 'none';
        }

        $data = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $this->denial_date = date('Y-m-d');

        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        $this->satuan_disetujui2 = number_format($data_detail->satuan_disetujui, 0, '.', '.');
        $this->total_pencairan = number_format($data_detail->nominal_disetujui, 0, '.', '.');

        if ($data->denial_note == NULL) {
            $this->denial_note = NULL;
        } else {
            $this->denial_note = $data->denial_note;
        }
    }

    public function tombol_tolak_direktur_keuangan()
    {
        $this->none_block_acc = 'none';
        $this->none_block_tolak_program = 'none';
        $this->none_block_acc_program = 'none';
        $this->none_block_acc_direktur_keuangan = 'none';


        if ($this->none_block_tolak_direktur_keuangan == 'none') {
            $this->none_block_tolak_direktur_keuangan = 'block';
        } elseif ($this->none_block_tolak_direktur_keuangan == 'block') {
            $this->none_block_tolak_direktur_keuangan = 'none';
        }

        $data = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $this->denial_date_pencairan_direktur = date('Y-m-d');

        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        $this->satuan_disetujui2 = number_format($data_detail->satuan_disetujui, 0, '.', '.');
        $this->total_pencairan = number_format($data_detail->nominal_disetujui, 0, '.', '.');

        if ($data->denial_note_pencairan_direktur == NULL) {
            $this->denial_note_pencairan_direktur = NULL;
        } else {
            $this->denial_note_pencairan_direktur = $data->denial_note_pencairan_direktur;
        }
    }


    public function tombol_acc_program()
    {
        // dd($this->none_block_acc_program);
        $this->approval_date_divpro = date('Y-m-d');
        $this->tgl_diserahkan_direktur = date('Y-m-d');

        $this->tab_v3();
        $this->none_block_tolak = 'none';
        $this->none_block_tolak_program = 'none';
        $this->none_block_acc = 'none';



        if ($this->none_block_acc_program == 'none') {
            $this->none_block_acc_program = 'block';
        } elseif ($this->none_block_acc_program == 'block') {
            $this->none_block_acc_program = 'none';
        }
        //  dd($this->none_block_acc_program);
        $this->approval_date = date('Y-m-d');

        // pencairan
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $rekening = Rekening::where('id_rekening', $data_detail->id_rekening)
            ->first();
        if ($rekening) {
            // $this->info_rekening = $rekening->nama_rekening . ' - ' . $rekening->no_rekening . ' - Rp' . number_format($rekening->saldo, 0, '.', '.');
            $this->id_rekening2 = $data_detail->id_rekening;
            $this->satuan_disetujui2 = number_format($data_detail->satuan_disetujui, 0, '.', '.');
        }

        $this->satuan_disetujui2 = number_format($data_detail->satuan_disetujui, 0, '.', '.');
        // dd($this->satuan_disetujui2);
    }

    public $id_asnaf_d;
    public $id_pilar_d;
    public $id_program_kegiatan_d;

    public function tombol_acc_direktur_keuangan()
    {

        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();


        $this->tab_v3();
        $this->none_block_tolak = 'none';
        $this->none_block_tolak_program = 'none';
        $this->none_block_acc_program = 'none';
        $this->none_block_acc = 'none';
        $this->none_block_tolak_direktur_keuangan = 'none';
        $this->id_asnaf_d = $data_detail->id_asnaf;
        $this->id_pilar_d = $data_detail->id_program_pilar;
        $this->id_program_kegiatan_d = $data_detail->id_program_kegiatan;



        if ($this->none_block_acc_direktur_keuangan == 'none') {
            $this->none_block_acc_direktur_keuangan = 'block';
        } elseif ($this->none_block_acc_direktur_keuangan == 'block') {
            $this->none_block_acc_direktur_keuangan = 'none';
        }
        $this->approval_date_divpro = date('Y-m-d');
        $this->approval_date = date('Y-m-d');
        $this->approval_date_pencairan_direktur = date('Y-m-d');



        // pencairan
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $rekening = Rekening::where('id_rekening', $data_detail->id_rekening)
            ->first();
        if ($rekening) {
            // $this->info_rekening = $rekening->nama_rekening . ' - ' . $rekening->no_rekening . ' - Rp' . number_format($rekening->saldo, 0, '.', '.');
            $this->id_rekening2 = $data_detail->id_rekening;
            $this->satuan_disetujui2 = number_format($data_detail->satuan_disetujui, 0, '.', '.');
        }

        $this->satuan_disetujui2 = number_format($data_detail->satuan_disetujui, 0, '.', '.');
        // dd($this->satuan_disetujui2);
    }

    public function tombol_acc()
    {

        $this->tab_v3();
        $this->none_block_tolak = 'none';
        $this->none_block_tolak_program = 'none';
        $this->none_block_acc_program = 'none';


        if ($this->none_block_acc == 'none') {
            $this->none_block_acc = 'block';
        } elseif ($this->none_block_acc == 'block') {
            $this->none_block_acc = 'none';
        }
        $this->approval_date_divpro = date('Y-m-d');
        $this->approval_date = date('Y-m-d');


        // pencairan
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $this->sumber_dana_opsi_keuangan = $data_detail->sumber_dana_opsi;

        $this->satuan_disetujui2 = $data_detail->satuan_disetujui_pencairan_direktur;


        // $this->satuan_disetujui2 = number_format($this->satuan_disetujui2, 0, '.', '.');
        // $this->nominal_disetujui2 = number_format($this->nominal_disetujui2, 0, '.', '.');







        // dd($this->id_rekening_cek);
        // $rekening = Rekening::where('id_rekening', $data_detail->id_rekening)
        //     ->first();
        // if ($rekening) {
        //     // $this->info_rekening = $rekening->nama_rekening . ' - ' . $rekening->no_rekening . ' - Rp' . number_format($rekening->saldo, 0, '.', '.');
        //     $this->id_rekening2 = $data_detail->id_rekening;
        //     $this->satuan_disetujui2 = number_format($data_detail->satuan_disetujui, 0, '.', '.');
        // }

        // $this->satuan_disetujui2 = number_format($data_detail->satuan_disetujui, 0, '.', '.');
        // dd($this->satuan_disetujui2);
    }
    
    public function tombol_acc_ketua()
    {

        $this->tab_v3();
        $this->none_block_tolak = 'none';
        $this->none_block_tolak_program = 'none';
        $this->none_block_acc_program = 'none';
        $this->none_block_acc = 'none';


        if ($this->none_block_acc_ketua == 'none') {
            $this->none_block_acc_ketua = 'block';
        } elseif ($this->none_block_acc_ketua == 'block') {
            $this->none_block_acc_ketua = 'none';
        }
        $this->approval_date_divpro = date('Y-m-d');
        $this->approval_date = date('Y-m-d');
        $this->approval_date_ketua = date('Y-m-d');
    }

    public function close()
    {
        $this->none_block_survey = 'none';
        $this->none_block_acc = 'none';
        $this->none_block_tolak = 'none';
        $this->none_block_acc_program = 'none';
        $this->none_block_tolak_program = 'none';
        $this->none_block_tolak_direktur_keuangan = 'none';
        $this->none_block_acc_direktur_keuangan = 'none';
        $this->none_block_terbit = 'none';
        $this->none_block_acc_ketua = 'none';
    }
    
    public function acc_ketua()
    {
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'approval_date_ketua' => $this->approval_date_ketua,
            'status_ketua' => 'Disetujui',
            'approver_ketua' => Auth::user()->gocap_id_pc_pengurus,
            'catatan_ketua' => $this->catatan_ketua,
        ]);
        
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        $direktur = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Kepala Cabang')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        if ($ajuan->opsi_pemohon == "Individu") {
            $pemohon = $D_ajuan->nama_pemohon;
        } elseif ($ajuan->opsi_pemohon == "Entitas") {
            $pemohon = $D_ajuan->nama_entitas;
        } elseif ($ajuan->opsi_pemohon == "Internal") {
            $pemohon = $this->nama_pengurus_pc($ajuan->pemohon_internal);
        }

        // kirim notif wa
        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

        $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');

        // petugas penyaluran
        $this->notif(
            // Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
            '089639481199',

            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                "*Pengajuan Umum Tingkat PC disetujui Ketua.*" . "\n" . "*Segera berikan respon persetujuan pencairan dana.*" . "\n" . "\n" .

                "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $ajuan->nomor_surat  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nama Pemohon"  . "*" .  "\n" .
                $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" . "\n" .
                "========================" . "\n" . "\n" .
                "*" .  "Asnaf"  . "*" .  "\n" .
                $asnaf .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $D_ajuan->pengajuan_note .  "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        $this->none_block_acc_ketua = 'none';
        session()->flash('alert_ketua', 'Pengajuan Berhasil Disetujui');
        $this->emit('waktu_alert');
    }

    public static function status_survey($id_pengajuan)
    {

        $hitungpenerima = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->first()->jumlah_penerima;
        $cekada = SurveyPenerimaManfaat::where('id_pengajuan', $id_pengajuan)->first();
        $hitungsurvey = SurveyPenerimaManfaat::where('id_pengajuan', $id_pengajuan)->count();

        $hitungsurveysetuju = SurveyPenerimaManfaat::where('id_pengajuan', $id_pengajuan)
            ->where('hasil', 'disetujui')->count();

        // dd($apaja);
        if ($cekada == null) { //belum survey samsek
            return  0;
        } else {
            if ($hitungsurvey != $hitungpenerima) { //baru survey sebagian
                return 1;
            } else { //sudah survey semua
                if ($hitungsurveysetuju != $hitungsurvey) { //ada yang tidak setuju
                    return 2;
                } elseif ($hitungsurveysetuju == $hitungsurvey) { //semua survey disetujui
                    return 3;
                }
            }
        }
        // return $a->pencairan_status;
    }

    public function modal_pengajuan_penerima_manfaat()
    {

        $this->nominal_bantuan = number_format(PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->first()->satuan_pengajuan, 0, '.', '.');

        $this->id_pengajuan_penerima = NULL;
        $this->nama = NULL;
        // $this->nominal_bantuan = NULL;
        $this->alamat = NULL;
        $this->keterangan = NULL;
    }

    public function kelolaSurvey($id)
    {
        $a = SurveyPenerimaManfaat::where('id_penerima_manfaat', $id)
            ->first();

        if ($a == null) {
            // blm survey
            $hasil = 0;
        } else {
            // sudah survey
            if ($a->hasil == 'disetujui') {
                $hasil = 1;
            } else {
                $hasil = 2;
            }
        };

        return $hasil;
    }

    public function belum_survey()
    {
        // dd('as');
        $this->emit('waktu_alert');
        session()->flash('alert_warning', 'Survey Belum dilakukan');
    }

    public function modal_pengajuan_penerima_manfaat_survey2($id_pengajuan_penerima)
    {


        // dd($id_pengajuan_penerima);
        $b = PengajuanPenerima::where('id_pengajuan_penerima', $id_pengajuan_penerima)->first();
        $this->survey = SurveyPenerimaManfaat::where('id_penerima_manfaat', $id_pengajuan_penerima)
            ->first();
        if ($this->survey) {
            $this->idsurveyini = $this->survey->id_survey_penerima_manfaat;
            $this->idsurveypenerima = $this->survey->id_penerima_manfaat;
            $this->tgl_survey = $this->survey->tanggal_survey;
            $this->nama_mustahik = $this->survey->nama_mustahik;
            $this->survey_lokasi = $this->survey->lokasi_survey;
            $this->alamat_mustahik = $this->survey->alamat_mustahik;
            $this->jenis_permohonan = $this->survey->jenis_permohonan;
            $this->jumlah_anak = $this->survey->jumlah_anak;
            $this->jumlah_total = $this->survey->jumlah_anggota_keluarga;
            $this->punya_pasangan = $this->survey->punya_suami_istri;
            $this->pekerjaan_suami = $this->survey->pekerjaan_suami;
            $this->pekerjaan_istri = $this->survey->pekerjaan_istri;
            $this->pekerjaan_anak = $this->survey->pekerjaan_anak;
            $this->penghasilan_suami = $this->survey->penghasilan_suami;
            $this->penghasilan_istri = $this->survey->penghasilan_istri;
            $this->penghasilan_anak = $this->survey->penghasilan_anak;
            $this->kondisi_atap = $this->survey->kondisi_atap_rumah;
            $this->kondisi_dinding = $this->survey->kondisi_dinding_rumah;
            $this->kondisi_ukuran_rumah = $this->survey->ukuran_rumah;
            $this->kondisi_lantai = $this->survey->kondisi_lantai_rumah;
            $this->kepemilikan_rumah = $this->survey->status_kepemilikan_rumah;
            $this->kepemilikan_tanah = $this->survey->status_kepemilikan_tanah;
            $this->harta_aset_kekayaan = $this->survey->aset_lainnya;
            $this->tanggungan_rutin_bulan = $this->survey->biaya_pengeluaran_bulanan;
            $this->kebutuhan_yg_dibutuhkan = $this->survey->kebutuhan_saat_ini;
            $this->bantuan_yg_pernah_didapat = $this->survey->bantuan_yang_pernah_didapat;
            $this->indeks_rumah = $this->survey->indeks_rumah;
            $this->indeks_rumah_keterangan = $this->survey->keterangan_indeks_rumah;
            $this->indeks_harta = $this->survey->kepemilikan_harta;
            $this->indeks_harta_keterangan = $this->survey->keterangan_kepemilikan_harta;
            $this->indeks_pendapatan = $this->survey->pendapatan;
            $this->indeks_pendapatan_keterangan = $this->survey->keterangan_pendapatan;
            $this->rokemendasi_surveyor = $this->survey->hasil_rekomendasi;
            $this->survey_hasil = $this->survey->hasil;
        } else {
            $this->tgl_survey = '';
            $this->nama_mustahik = '';
            $this->survey_lokasi = '';
            $this->alamat_mustahik = '';
            $this->jenis_permohonan = '';
            $this->jumlah_anak = '';
            $this->jumlah_total = '';
            $this->punya_pasangan = '';
            $this->pekerjaan_suami = '';
            $this->pekerjaan_istri = '';
            $this->pekerjaan_anak = '';
            $this->penghasilan_suami = '';
            $this->penghasilan_istri = '';
            $this->penghasilan_anak = '';
            $this->kondisi_atap = '';
            $this->kondisi_dinding = '';
            $this->kondisi_ukuran_rumah = '';
            $this->kondisi_lantai = '';
            $this->kepemilikan_rumah = '';
            $this->kepemilikan_tanah = '';
            $this->harta_aset_kekayaan = '';
            $this->tanggungan_rutin_bulan = '';
            $this->kebutuhan_yg_dibutuhkan = '';
            $this->bantuan_yg_pernah_didapat = '';
            $this->indeks_rumah = '';
            $this->indeks_rumah_keterangan = '';
            $this->indeks_harta = '';
            $this->indeks_harta_keterangan = '';
            $this->indeks_pendapatan = '';
            $this->indeks_pendapatan_keterangan = '';
            $this->rokemendasi_surveyor = '';
            $this->survey_hasil = '';
        }

        $this->id_pengajuan_penerima = $id_pengajuan_penerima;
        $this->nama_mustahik = $b->nama;
        $this->alamat_mustahik = $b->alamat;
    }

    public function modal_pengajuan_penerima_manfaat_survey($id_pengajuan_penerima)
    {


        // dd($id_pengajuan_penerima);
        $b = PengajuanPenerima::where('id_pengajuan_penerima', $id_pengajuan_penerima)->first();
        $this->survey = SurveyPenerimaManfaat::where('id_penerima_manfaat', $id_pengajuan_penerima)
            ->first();
        if ($this->survey) {
            $this->idsurveyini = $this->survey->id_survey_penerima_manfaat;
            $this->idsurveypenerima = $this->survey->id_penerima_manfaat;
            $this->tgl_survey = $this->survey->tanggal_survey;
            $this->nama_mustahik = $this->survey->nama_mustahik;
            $this->survey_lokasi = $this->survey->lokasi_survey;
            $this->alamat_mustahik = $this->survey->alamat_mustahik;
            $this->jenis_permohonan = $this->survey->jenis_permohonan;
            $this->jumlah_anak = $this->survey->jumlah_anak;
            $this->jumlah_total = $this->survey->jumlah_anggota_keluarga;
            $this->punya_pasangan = $this->survey->punya_suami_istri;
            $this->pekerjaan_suami = $this->survey->pekerjaan_suami;
            $this->pekerjaan_istri = $this->survey->pekerjaan_istri;
            $this->pekerjaan_anak = $this->survey->pekerjaan_anak;
            $this->penghasilan_suami = $this->survey->penghasilan_suami;
            $this->penghasilan_istri = $this->survey->penghasilan_istri;
            $this->penghasilan_anak = $this->survey->penghasilan_anak;
            $this->kondisi_atap = $this->survey->kondisi_atap_rumah;
            $this->kondisi_dinding = $this->survey->kondisi_dinding_rumah;
            $this->kondisi_ukuran_rumah = $this->survey->ukuran_rumah;
            $this->kondisi_lantai = $this->survey->kondisi_lantai_rumah;
            $this->kepemilikan_rumah = $this->survey->status_kepemilikan_rumah;
            $this->kepemilikan_tanah = $this->survey->status_kepemilikan_tanah;
            $this->harta_aset_kekayaan = $this->survey->aset_lainnya;
            $this->tanggungan_rutin_bulan = $this->survey->biaya_pengeluaran_bulanan;
            $this->kebutuhan_yg_dibutuhkan = $this->survey->kebutuhan_saat_ini;
            $this->bantuan_yg_pernah_didapat = $this->survey->bantuan_yang_pernah_didapat;
            $this->indeks_rumah = $this->survey->indeks_rumah;
            $this->indeks_rumah_keterangan = $this->survey->keterangan_indeks_rumah;
            $this->indeks_harta = $this->survey->kepemilikan_harta;
            $this->indeks_harta_keterangan = $this->survey->keterangan_kepemilikan_harta;
            $this->indeks_pendapatan = $this->survey->pendapatan;
            $this->indeks_pendapatan_keterangan = $this->survey->keterangan_pendapatan;
            $this->rokemendasi_surveyor = $this->survey->hasil_rekomendasi;
            $this->survey_hasil = $this->survey->hasil;
        } else {
            $this->tgl_survey = '';
            $this->nama_mustahik = '';
            $this->survey_lokasi = '';
            $this->alamat_mustahik = '';
            $this->jenis_permohonan = '';
            $this->jumlah_anak = '';
            $this->jumlah_total = '';
            $this->punya_pasangan = '';
            $this->pekerjaan_suami = '';
            $this->pekerjaan_istri = '';
            $this->pekerjaan_anak = '';
            $this->penghasilan_suami = '';
            $this->penghasilan_istri = '';
            $this->penghasilan_anak = '';
            $this->kondisi_atap = '';
            $this->kondisi_dinding = '';
            $this->kondisi_ukuran_rumah = '';
            $this->kondisi_lantai = '';
            $this->kepemilikan_rumah = '';
            $this->kepemilikan_tanah = '';
            $this->harta_aset_kekayaan = '';
            $this->tanggungan_rutin_bulan = '';
            $this->kebutuhan_yg_dibutuhkan = '';
            $this->bantuan_yg_pernah_didapat = '';
            $this->indeks_rumah = '';
            $this->indeks_rumah_keterangan = '';
            $this->indeks_harta = '';
            $this->indeks_harta_keterangan = '';
            $this->indeks_pendapatan = '';
            $this->indeks_pendapatan_keterangan = '';
            $this->rokemendasi_surveyor = '';
            $this->survey_hasil = '';
        }

        $this->id_pengajuan_penerima = $id_pengajuan_penerima;
        $this->nama_mustahik = $b->nama;
        $this->alamat_mustahik = $b->alamat;
    }

    public function modal_pengajuan_penerima_manfaat_hapus($id_pengajuan_penerima)
    {
        $this->id_pengajuan_penerima = $id_pengajuan_penerima;
    }

    public function modal_pengajuan_penerima_manfaat_ubah($id_pengajuan_penerima)
    {

        $a = PengajuanPenerima::where('id_pengajuan_penerima', $id_pengajuan_penerima)->first();
        $this->nominal_bantuan = number_format($a->nominal_bantuan, 0, '.', '.');
        $this->id_pengajuan_penerima = $id_pengajuan_penerima;
        $this->nama = $a->nama;
        $this->alamat = $a->alamat;
        $this->keterangan = $a->keterangan;

        $this->nik = $a->nik;
        $this->nokk = $a->nokk;
        $this->nohp = $a->nohp;
        $this->jenis_bantuan = $a->jenis_bantuan;
        $this->jns_bantuan = $a->jns_bantuan;
        $this->tgl_penyaluran = $a->tgl_penyaluran;
    }


    public function modal_lampiran_pencairan_ubah($id_lampiran_pencairan)
    {
        // dd($id_lampiran_pencairan);
        $a = LampiranPencairan::where('id_lampiran_pencairan', $id_lampiran_pencairan)->first();
        $this->id_lampiran_pencairan  = $id_lampiran_pencairan;
        $this->judul_file_pencairan = $a->judul;
        // $this->file_lampiran_pencairan = $a->file;
    }

    public function tambah_penerima()
    {

        $this->emit('dataTersimpan');
        $this->dispatchBrowserEvent('close-modal');

        $id_pengajuan_penerima = Str::uuid()->toString();
        PengajuanPenerima::create([
            'id_pengajuan_penerima' => $id_pengajuan_penerima,
            'id_pengajuan' => $this->id_pengajuan,
            'id_pengajuan_detail' => $this->id_pengajuan_detail,
            'tgl_penyaluran' => $this->tgl_penyaluran,
            'nik' => $this->nik,
            'nokk' => $this->nokk,
            'nohp' => $this->nohp,
            'nama' => $this->nama,
            'jenis_bantuan' => $this->jenis_bantuan,
            'jns_bantuan' => $this->jns_bantuan,
            'alamat' => $this->alamat,
            'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
            'keterangan' => $this->keterangan,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);
        $this->nama = '';
        $this->alamat = '';
        $this->nominal_bantuan = '';
        $this->keterangan = '';
        $this->nik = '';
        $this->nokk = '';
        $this->nohp = '';
        $this->jenis_bantuan = '';
        $this->jns_bantuan = '';
        $this->tgl_penyaluran = '';

        session()->flash('alert_penerima', 'Penerima Manfaat Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function ubah_penerima()
    {
        $this->emit('dataTersimpan');
        $this->dispatchBrowserEvent('close-modal');

        PengajuanPenerima::where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->update([
            'id_pengajuan' => $this->id_pengajuan,
            'id_pengajuan_detail' => $this->id_pengajuan_detail,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
            'keterangan' => $this->keterangan,
            'nik' => $this->nik,
            'nokk' => $this->nokk,
            'nohp' => $this->nohp,
            'jenis_bantuan' => $this->jenis_bantuan,
            'jns_bantuan' => $this->jns_bantuan,
            'tgl_penyaluran' => $this->tgl_penyaluran,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->nama = '';
        $this->alamat = '';
        $this->nominal_bantuan = '';
        $this->keterangan = '';
        $this->nik = '';
        $this->nokk = '';
        $this->nohp = '';
        $this->jenis_bantuan = '';
        $this->jns_bantuan = '';
        $this->tgl_penyaluran = '';

        session()->flash('alert_penerima', 'Penerima Manfaat Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function hapus_penerima()
    {

        SurveyPenerimaManfaat::where('id_penerima_manfaat', $this->id_pengajuan_penerima)->delete();
        PengajuanPenerima::where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->delete();


        session()->flash('alert_penerima', 'Penerima Manfaat Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function tolak_pencairan()
    {
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'pencairan_status' => 'Ditolak',
            'tgl_tolak_pencairan' => $this->tgl_tolak_pencairan,
            'dicairkan_kepada' => $data_detail->petugas_pc,
            'keterangan_tolak_pencairan' => $this->keterangan_tolak_pencairan,
        ]);

        $this->none_block_tolak = 'none';
        $this->none_block_acc = 'none';

        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

        // fo
        $front = DB::table($this->gocap . '.pengurus_jabatan as pj')
    ->where('pj.tingkat', 'pc')
    ->where('pj.id_pengurus_jabatan', '300ff4f3-725c-11ed-ad27-e4a8df91d8b3')
    ->join($this->gocap . '.pc_pengurus as pp', 'pp.id_pengurus_jabatan', '=', 'pj.id_pengurus_jabatan')
    ->where('pp.status', '1')
    ->select('pp.id_pc_pengurus')
    ->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');
        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        // petugas
        $this->notif(
            // $this->nohp_pengurus_pc($front->id_pc_pengurus),
            '089639481199',


            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                "Yth. " . "*" . $this->nama_pengurus_pc($front->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($front->id_pc_pengurus) . "\n" . "\n" .


                "Pengajuan UMUM PC Lazisnu Cilacap, " . "*" . "Ditolak" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .


                "*" .  "Nomor"  . "*" .  "\n" .
                $data->nomor_surat  . "\n" .
                "*" .  "Pemohon"  . "*" .  "\n" .
                $data->opsi_pemohon . " - " . $data_detail->nama_pemohon .  "\n" .
                "*" .  "Target Penerima Manfaat"  . "*" .  "\n" .
                $data_detail->nama_penerima .  "\n" .

                "*" .  "Jumlah Penerima Manfaat"  . "*" .  "\n" .
                $data_detail->jumlah_penerima .  "\n" .

                "*" .  "Survey"  . "*" .  "\n" .
                $data->survey_pc  .  "\n" .


                "*" .  "Petugas Pentasyarufan"  . "*" .  "\n" .
                $this->nama_pengurus_pc($data_detail->petugas_pc) . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($data_detail->nominal_pengajuan, 0, '.', '.') . ',-' .  "\n" .


                "========================" . "\n" . "\n" .
                "*" .  "Asnaf"  . "*" .  "\n" .
                $asnaf .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $D_ajuan->pengajuan_note .  "\n" .

                // "*" .  "Pilar"  . "*" .  "\n" .
                // $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                // "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                // $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" . "\n" .
                "*" .  "Alasan"  . "*" .  "\n" .
                $this->keterangan_tolak_pencairan .  "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );
    }

    public function pencairan()
    {

        try {
            DB::beginTransaction();
        
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');
        $program_pilar = $data_detail->id_program_pilar;
        $programPilar =  ProgramPilar::where('id_program_pilar', $data_detail->id_program_pilar)->value('id_program');
        $etasyaruf = config('app.database_etasyaruf');
        
        $data = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)
                ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
                ->value($etasyaruf . '.pengajuan.nomor_surat');
        // dd($data);

        $parts = explode('/', $data);

        // Ambil bagian yang diinginkan
        $nomor = $parts[0]; // 358
        $bulan = $parts[3]; // VI
        $tahun = $parts[4]; // 2024

        $nomor_kwitansi_pencairan = $nomor . '/' . 'keu_lazisnucilacap' . '/'  . $bulan . '/' . $tahun;

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'pencairan_status' => 'Berhasil Dicairkan',
            'tgl_pencairan' => $this->tgl_pencairan,
            'dicairkan_kepada' => $data_detail->petugas_pc,
            'nominal_pencairan' => str_replace('.', '', $this->nominal_disetujui2),
            'satuan_pencairan' => str_replace('.', '', $this->satuan_disetujui2),
            'keterangan_pencairan' => $this->keterangan_pencairan,
            'metode_pencairan' => $this->metode_pencairan,
            'id_rekening' => $this->id_rekening2,
            'nomor_kwitansi_pencairan' => $nomor_kwitansi_pencairan,
            'no_rek_penerima' => $this->no_rek_penerima,
            'nama_bank_penerima' => $this->nama_bank_penerima,
            'atas_nama_penerima' => $this->atas_nama_penerima,
            // 'file' => $kwitansi_name,
        ]);
        
        $year = Carbon::parse(now())->format('Y');
        $month = Carbon::parse(now())->format('m');

        $no_urut = JurnalUmum::whereYear('tgl_transaksi', $year)->whereMonth('tgl_transaksi', $month)->select('no_urut')->max('no_urut');
        $new_no =  JurnalUmum::whereYear('tgl_transaksi', $year)->whereMonth('tgl_transaksi', $month)->select('no_urut')->exists();

        if ($no_urut == null) {
            $nomor_urut = 1;
        } else {
            if ($new_no) {
                $nomor_urut = $no_urut + 1;
            } else {
                $nomor_urut = 1;
            }
        }

        if (strlen($nomor_urut) == 1) {
            $nomor = '000' . $nomor_urut;
        } elseif (strlen($nomor_urut) == 2) {
            $nomor = '00' . $nomor_urut;
        } elseif (strlen($nomor_urut) == 3) {
            $nomor = '0' . $nomor_urut;
        } elseif (strlen($nomor_urut) == 4) {
            $nomor = $nomor_urut;
        } else {
            $nomor = $nomor_urut;
        }


        $nomor = 'JURNAL/' . $month . '/' . $year . '/' . $nomor;
        $nomor_urut = $nomor_urut;

        $pilar = Helper::getDataPilar($data_detail->id_program_pilar)->pluck('pilar')->first();
        $nama_kegiatan = Helper::getDataKegiatan($data_detail->id_program_kegiatan)->pluck('nama_program')->first();
        $keterangan = $data_detail->pengajuan_note;


        if ($this->metode_pencairan == 'Langsung') {
            if ($this->sumber_dana_opsi_keuangan == 'Dana Zakat') {
                $akunkrd = '968cdc01-1f81-4b26-a397-348bc1d48db3';
            } elseif ($this->sumber_dana_opsi_keuangan == 'Dana Infak Terikat' || $this->sumber_dana_opsi_keuangan == 'Dana Infak Umum') {
                $akunkrd = '618944ad-2f49-4f9c-9c3d-cd7f75bb9db1';
            }
        } elseif ($this->metode_pencairan == 'Transfer') {
            if ($this->sumber_dana_opsi_keuangan == 'Dana Zakat') {
                $akunkrd = '98aab355-1cc9-4538-a7b7-f7d8ab7f7662';
            } elseif ($this->sumber_dana_opsi_keuangan == 'Dana Infak Terikat' || $this->sumber_dana_opsi_keuangan == 'Dana Infak Umum') {
                $akunkrd = 'd38525ee-416c-442b-bbad-679d861f032a';
            }
        }


        if ($this->sumber_dana_opsi_keuangan == 'Dana Zakat') {
            if ($asnaf == 'Amil') {
                $akundb = 'd3464293-098c-45fe-9874-58c1e5684a06';
            } elseif ($asnaf == 'Miskin') {
                $akundb = '719e6f29-2225-449f-b263-60a7721bbffd';
            } elseif ($asnaf == 'Ibnussabil') {
                $akundb = '5f0e300b-49d4-48f4-8b84-14b4dc597c75';
            } elseif ($asnaf == 'Riqab') {
                $akundb = 'f57e55dc-9279-4bfb-970a-b14fccf5d956';
            } elseif ($asnaf == 'Fisabilillah') {
                $akundb = 'f7192fa4-517d-4574-897f-b1f7a1a5662c';
            } elseif ($asnaf == 'Gharimin') {
                $akundb = 'eeb8b735-9f0c-428b-a1ca-2fc28f0ae634';
            } elseif ($asnaf == 'Muallaf') {
                $akundb = '4bcd3303-4088-4bc5-8240-756f6313f803';
            } elseif ($asnaf == 'Fakir') {
                $akundb = 'c1939a57-9ea5-4f02-baa9-f91a4a928273';
            }
        } 
        
        elseif ($this->sumber_dana_opsi_keuangan == 'Dana Infak Umum') {
            // pilar kesehatan
            if ($program_pilar == '2a700a8d-dd49-46d3-9e25-2953266cf9a5') {
                $akundb = '44f70ad4-0e05-4dbf-abe1-e38024d63d9c';
            }
            //pilar ekonomi
            elseif ($program_pilar == '30746c18-3f7a-4736-ae47-ea91154a5a00') {
                $akundb = 'ba4b92e4-5cba-4643-9bf6-420fb879ef98';
            }
            //pilar penguatan lembaga
            elseif ($program_pilar == '9e2ea277-9550-4ff7-bd6a-5fb36ef30633') {
                $akundb = '4250a6a0-2560-4d4b-94bb-b0d16f0a43bb';
            }
            //pilar dakwah dan advokasi
            elseif ($program_pilar == 'cde8bd7b-7467-40c5-a92a-957a8176aed9') {
                $akundb = '40b7c6f8-96ee-4104-82fd-a7c39b1f3bd1';
            }
            //pilar kemanusiaan
            elseif ($program_pilar == 'ce2ac72c-02bc-4d8c-b143-9d526b1edd2b') {
                $akundb = '8282d544-885c-413e-a2a2-a7797c9ee5ff';
            }
            //pilar lingkungan
            elseif ($program_pilar == 'd578e2e4-23d4-4cc6-9657-2415ba633420') {
                $akundb = '40b7c6f8-96ee-4104-82fd-a7c39b1f3bd1';
            }
            //pilar pendidikan
            elseif ($program_pilar == 'e47c6722-98b5-42b9-9b37-22f7b8437450') {
                $akundb = '8e25412d-5b17-4428-98cb-6239feadb9a2';
            }
        } 
        
        elseif ($this->sumber_dana_opsi_keuangan == 'Dana Infak Terikat') {
            // pilar kesehatan
            if ($program_pilar == '2a700a8d-dd49-46d3-9e25-2953266cf9a5') {
                $akundb = 'ddfe518d-381e-45f5-a81b-0f1f26066b3c';
            }
            //pilar ekonomi
            elseif ($program_pilar == '30746c18-3f7a-4736-ae47-ea91154a5a00') {
                $akundb = '93106421-ebed-4e9c-bea4-39f9aa2273b7';
            }
            //pilar penguatan lembaga
            elseif ($program_pilar == '9e2ea277-9550-4ff7-bd6a-5fb36ef30633') {
                $akundb = 'db1b6f13-370b-429d-aa82-3a840d5a30cc';
            }
            //pilar dakwah dan advokasi
            elseif ($program_pilar == 'cde8bd7b-7467-40c5-a92a-957a8176aed9') {
                $akundb = 'e1c520cc-e204-4c51-8a52-46f6409d15c9';
            }
            //pilar kemanusiaan
            elseif ($program_pilar == 'ce2ac72c-02bc-4d8c-b143-9d526b1edd2b') {
                $akundb = '60b7b60d-eb4f-4d1f-be90-e19eb970d8e0';
            }
            //pilar lingkungan
            elseif ($program_pilar == 'd578e2e4-23d4-4cc6-9657-2415ba633420') {
                $akundb = 'e1c520cc-e204-4c51-8a52-46f6409d15c9';
            }
            //pilar pendidikan
            elseif ($program_pilar == 'e47c6722-98b5-42b9-9b37-22f7b8437450') {
                $akundb = '24c76c72-9bd0-4252-8bdc-b987a1190952';
            }
        }
        


        // //PENGUATAN KELEMBAGAAN
        // if ($programPilar == 'ba84d782-81a8-11ed-b4ef-dc215c5aad51') {
        //     $akundb = '4250a6a0-2560-4d4b-94bb-b0d16f0a43bb';
        // }
        // //PROGRAM SOSIAL
        // elseif ($programPilar == 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51') {
        //     $akundb = 'a13e0322-7995-4f11-88f4-f51f862bcc57';
        // }
        // //OPERASIONAL UPZIS
        // elseif ($programPilar == 'c51700b1-81a8-11ed-b4ef-dc215c5aad51') {
        //     $akundb = '40b7c6f8-96ee-4104-82fd-a7c39b1f3bd1';
        // }


        JurnalUmum::create([
            'id_jurnal_umum' => Str::uuid()->toString(),
            'id_pengajuan_detail' => $data_detail->id_pengajuan_detail,
            'tgl_transaksi' => now()->format('Y-m-d'),
            'nomor' => $nomor,
            'no_urut' => $nomor_urut,
            'jenis' => 'Keluar',
            'akun' => $akunkrd,
            'bank' => $this->id_rekening2,
            'deskripsi' => '[ ' . $pilar . ']' . ' - ' . $nama_kegiatan . ' - ' . $keterangan,
            'debit' => 0,
            'kredit' => is_numeric(str_replace(',', '.', str_replace('.', '', $this->nominal_disetujui2))) ? str_replace(',', '.', str_replace('.', '', $this->nominal_disetujui2)) : 0,
            'id_pengguna' => Auth::user()->id_pengguna,
        ]);


        JurnalUmum::create([
            'id_jurnal_umum' => Str::uuid()->toString(),
            'id_pengajuan_detail' => $data_detail->id_pengajuan_detail,
            'tgl_transaksi' => now()->format('Y-m-d'),
            'nomor' => $nomor,
            'no_urut' => $nomor_urut,
            'jenis' => 'Keluar',
            'akun' => $akundb,
            'bank' => $this->id_rekening2,
            'deskripsi' => '[ ' . $pilar . ']' . ' - ' . $nama_kegiatan . ' - ' . $keterangan,
            'debit' => is_numeric(str_replace(',', '.', str_replace('.', '', $this->nominal_disetujui2))) ? str_replace(',', '.', str_replace('.', '', $this->nominal_disetujui2)) : 0,
            'kredit' => 0,
            'id_pengguna' => Auth::user()->id_pengguna,
        ]);

        // dd('Testing Data Jurnal Umum Tersimpan ' . $data_detail->id_pengajuan_detail);


        // $data = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();


        // $ext = $this->kwitansi->extension();
        // $kwitansi_name = 'KWT-PC-' . Str::random(10) . '.' . $ext;
        // $this->kwitansi->storeAs('pengajuan_kwitansi', $kwitansi_name);

        $id_arus_dana = Str::uuid();

      
        $rekening = Rekening::where('id_rekening', $this->id_rekening2)
            ->first();
        $saldo_sisa = $rekening->saldo - (str_replace('.', '', $this->total_pencairan));
        Rekening::where('id_rekening', $this->id_rekening2)->update([
            'saldo' => $saldo_sisa
        ]);
        

        // dd($this->nominal_disetujui);
        ArusDana::create([
            'id_arus_dana' => $id_arus_dana,
            'id_rekening' => $this->id_rekening2,
            'jenis_dana' => 'keluar',
            'jenis_kas' => 'Pentasyarufan Koin NU',
            'nominal' => str_replace('.', '', $this->nominal_disetujui2),
            'tanggal_input' => $this->tgl_pencairan,
            'petugas_input_pc' => $data_detail->staf_keuangan_pc,
            'id_etasyaruf_permohonan_pentasyarufan_koin' => $data_detail->id_pengajuan_detail,
            'uraian' => $this->nama_kegiatan($data_detail->id_program_kegiatan)
        ]);



        $pyl = DB::table($this->gocap . '.pengurus_jabatan')
        ->where($this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '20f2ff4d-1596-48ab-b60d-8a4b75a9784d')
        ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
        ->where($this->gocap . '.pc_pengurus.status', '1')
        ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
        ->first();


        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();


        if ($ajuan->opsi_pemohon == "Individu") {
            $pemohon = $D_ajuan->nama_pemohon;
        } elseif ($ajuan->opsi_pemohon == "Entitas") {
            $pemohon = $D_ajuan->nama_entitas;
        } elseif ($ajuan->opsi_pemohon == "Internal") {
            $pemohon = $this->nama_pengurus_pc($ajuan->pemohon_internal);
        }


        // kirim notif wa
        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

        $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
        // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
        // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

        // petugas penyaluran
        $this->notif(
            // Helper::getNohpPengurus('pc', $pyl->id_pc_pengurus),
            '089639481199',

            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                "Yth. " . "*" . $this->nama_pengurus_pc($pyl->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($pyl->id_pc_pengurus) . "\n" . "\n" .

                "*Pencairan dana disetujui Div. Keuangan.*" . "\n" . "\n" .
                "*Segera konfirmasi LPJ & BA Penyaluran.*" . "\n" . "\n" .

                "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $ajuan->nomor_surat  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nama Pemohon"  . "*" .  "\n" .
                $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($D_ajuan->satuan_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                "*" .  "Survey"  . "*" .  "\n" .
                $D_ajuan->pil_survey  . "\n" .
                "*" .  "Sumber Dana"  . "*" .  "\n" .
                $D_ajuan->sumber_dana_opsi .  "\n" . "\n" .
                "========================" . "\n" . "\n" .
                "*" .  "Asnaf"  . "*" .  "\n" .
                $asnaf .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $D_ajuan->pengajuan_note .  "\n" . "\n" .
                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );



        $this->none_block_acc = 'none';
        session()->flash('alert_keuangan', 'Pengajuan Berhasil Dicairkan');
        $this->emit('waktu_alert');
        
        DB::commit();
    } catch (\Exception $e) {
        // Rollback the transaction
        DB::rollBack();
    
        // Handle the error (log it, display a message to the user, etc.)
        throw $e;
    }
    }

    public function modal_pengajuan_kegiatan()
    {
        $kegiatan = PengajuanKegiatan::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        // dd($kegiatan);
        if ($kegiatan != null) {
            $this->tgl_kegiatan = $kegiatan->tgl_kegiatan;
            $this->lokasi = $kegiatan->lokasi;
            $this->judul = $kegiatan->judul;
            $this->jumlah_kehadiran = $kegiatan->jumlah_kehadiran;
            $this->kendala = $kegiatan->kendala;
            $this->ringkasan = $kegiatan->ringkasan;
        }
        // dd($kegiatan);
    }

    public function tambah_ubah_dokumentasi()
    {
        // TAMBAH
        if ($this->id_pengajuan_dokumentasi == NULL) {
            $id_pengajuan_dokumentasi = Str::uuid()->toString();
            $ext = $this->file_dokumentasi->extension();
            $file_dokumentasi_name = 'DK-' . Str::random(10) . '.' . $ext;
            $this->file_dokumentasi->storeAs('pengajuan_dokumentasi', $file_dokumentasi_name);

            PengajuanDokumentasi::create([
                'id_pengajuan_dokumentasi' => $id_pengajuan_dokumentasi,
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'judul' => $this->judul_dokumentasi,
                'file' => $file_dokumentasi_name,
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);

            $this->judul_dokumentasi = NULL;
            $this->file_dokumentasi = NULL;
            session()->flash('alert_dokumentasi', 'Dokumentasi Berhasil Ditambahkan');
            $this->emit('waktu_alert');
        }
        // UBAH
        else {

            $dokumentasi = PengajuanDokumentasi::where('id_pengajuan_dokumentasi', $this->id_pengajuan_dokumentasi)->first();
            if ($this->file_dokumentasi != NULL) {
                if ($dokumentasi->file != null) {
                    $path = public_path() . "/uploads/pengajuan_dokumentasi/" . $dokumentasi->file;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $ext = $this->file_dokumentasi->extension();
                $file_dokumentasi_name = 'DK-' . Str::random(10) . '.' . $ext;
                $this->file_dokumentasi->storeAs('pengajuan_dokumentasi', $file_dokumentasi_name);
            } else {
                $file_dokumentasi_name = $dokumentasi->file;
            }


            PengajuanDokumentasi::where('id_pengajuan_dokumentasi', $this->id_pengajuan_dokumentasi)->update([
                'judul' => $this->judul_dokumentasi,
                'file' => $file_dokumentasi_name,
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);

            session()->flash('alert_dokumentasi', 'Dokumentasi Berhasil Diubah');
            $this->emit('waktu_alert');
        }

        $this->tombol_kegiatan();
    }

    public function modal_pengajuan_berita()
    {

        $berita = PengajuanBerita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $this->berita = PengajuanBerita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();


        if ($berita != NULL) {
            $this->id_pengajuan_berita = $berita->id_pengajuan_berita;
            $this->file_berita = $berita->file;
            $this->tgl_terbit_berita = $berita->tgl_terbit;
            $this->judul_berita = $berita->judul;
            $this->pewarta_pc = $berita->maker_tingkat_pc;

            if ($berita->narasi == NULL or $berita->narasi == '') {
                $this->narasi_berita = '<p>&nbsp;</p>

                <p>&nbsp;</p>
                
                <p>&nbsp;</p>
                
                <p>&nbsp;</p>
                
                <p>&nbsp;</p>
                
                <p>Follow&nbsp;<a href="https://www.instagram.com/nucare_lazisnu_cilacap/?hl=id" role="link" tabindex="0">@nucare_lazisnu_cilacap</a><br />
                Twitter|Facebook|YouTube: NU Care Lazisnu Cilacap</p>
                ';
            } else {
                $this->narasi_berita = $berita->narasi;
            }
        } else {
            $this->narasi_berita = '<p>&nbsp;</p>

            <p>&nbsp;</p>
            
            <p>&nbsp;</p>
            
            <p>&nbsp;</p>
            
            <p>&nbsp;</p>
            
            <p>Follow&nbsp;<a href="https://www.instagram.com/nucare_lazisnu_cilacap/?hl=id" role="link" tabindex="0">@nucare_lazisnu_cilacap</a><br />
            Twitter|Facebook|YouTube: NU Care Lazisnu Cilacap</p>
            ';
        }
    }

    public function hapus_dokumentasi()
    {
        $dokumentasi = PengajuanDokumentasi::where('id_pengajuan_dokumentasi', $this->id_pengajuan_dokumentasi)->first();

        if ($dokumentasi->file != null) {
            $path = public_path() . "/uploads/pengajuan_dokumentasi/" . $dokumentasi->file;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        PengajuanDokumentasi::where('id_pengajuan_dokumentasi', $this->id_pengajuan_dokumentasi)->delete();
        $this->id_pengajuan_dokumentasi = '';
        $this->judul_dokumentasi = '';
        $this->file_dokumentasi = '';

        session()->flash('alert_dokumentasi', 'Dokumentasi Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->tombol_kegiatan();
    }

    public function modal_pengajuan_dokumentasi()
    {
    }
    
    public function modal_detail_barang()
    {
    }
    
    public function detail_barang($id_lpj_uraian_barang)
    {
        $this->id_lpj_uraian_barang = $id_lpj_uraian_barang;
        $a = DetailBarang::where('id_lpj_uraian_barang', $this->id_lpj_uraian_barang)->first();
        $this->jumlah_barang = $a->jumlah_barang;
        $this->jenis_barang = $a->jenis_barang;
        $this->nominal_barang = $a->nominal_barang;
    }

    public function hapus_barang()
    {
        $barang = DetailBarang::where('id_lpj_uraian_barang', $this->id_lpj_uraian_barang)->first();

        DetailBarang::where('id_lpj_uraian_barang', $this->id_lpj_uraian_barang)->delete();
        $this->id_lpj_uraian_barang = '';
        $this->jenis_barang = '';
        $this->jumlah_barang = '';
        $this->nominal_barang = '';

        session()->flash('alert_barang', 'Barang Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->tombol_kegiatan();
    }

    public function reset_barang()
    {
        $this->id_lpj_uraian_barang = '';
        $this->jumlah_barang = '';
        $this->jenis_barang = '';
        $this->nominal_barang = '';
    }
    
    public function tambah_ubah_barang()
    {
        // TAMBAH
        if ($this->id_lpj_uraian_barang == NULL) {
            $id_lpj_uraian_barang = Str::uuid()->toString();

            DetailBarang::create([
                'id_lpj_uraian_barang' => $id_lpj_uraian_barang,
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'jenis_barang' => $this->jenis_barang,
                'jumlah_barang' => $this->jumlah_barang,
                'nominal_barang' => str_replace('.', '', $this->nominal_barang),
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);

            $this->jenis_barang = NULL;
            $this->jumlah_barang = NULL;
            $this->nominal_barang = NULL;
            session()->flash('alert_barang', 'Barang Berhasil Ditambahkan');
            $this->emit('waktu_alert');
        }
        // UBAH
        else {

            $barang = DetailBarang::where('id_lpj_uraian_barang', $this->id_lpj_uraian_barang)->first();

            DetailBarang::where('id_lpj_uraian_barang', $this->id_lpj_uraian_barang)->update([
                'jenis_barang' => $this->jenis_barang,
                'jumlah_barang' => $this->jumlah_barang,
                'nominal_barang' => str_replace('.', '', $this->nominal_barang),
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);

            session()->flash('alert_barang', 'Barang  Berhasil Diubah');
            $this->emit('waktu_alert');
        }

        $this->tombol_kegiatan();
    }

    public function detail_dokumentasi($id_pengajuan_dokumentasi)
    {
        $this->id_pengajuan_dokumentasi = $id_pengajuan_dokumentasi;
        $a = PengajuanDokumentasi::where('id_pengajuan_dokumentasi', $this->id_pengajuan_dokumentasi)->first();
        $this->judul_dokumentasi = $a->judul;
    }


    public function reset_dokumentasi()
    {
        $this->id_pengajuan_dokumentasi = '';
        $this->judul_dokumentasi = '';
        $this->file_dokumentasi = '';
    }

    public function ubah_kegiatan()
    {
        // dd($this->id_pengajuan_detail);
        $a =  PengajuanKegiatan::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();


        if ($a == NULL) {
            PengajuanKegiatan::create([
                'id_pengajuan_kegiatan' => Str::uuid()->toString(),
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'tgl_kegiatan' => $this->tgl_kegiatan,
                'lokasi' => $this->lokasi,
                'judul' => $this->judul,
                'jumlah_kehadiran' => $this->jumlah_kehadiran,
                'kendala' => $this->kendala,
                'ringkasan' => $this->ringkasan,
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);
        } else {
            PengajuanKegiatan::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
                'tgl_kegiatan' => $this->tgl_kegiatan,
                'lokasi' => $this->lokasi,
                'judul' => $this->judul,
                'jumlah_kehadiran' => $this->jumlah_kehadiran,
                'kendala' => $this->kendala,
                'ringkasan' => $this->ringkasan,
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);
        }

        $url =  "https://e-tasyaruf.nucarecilacap.id";
        // divisi it dan media
        $it = DB::table($this->gocap . '.pengurus_jabatan')->where('id_pengurus_jabatan', 'ef77ea4b-725b-11ed-ad27-e4a8df91d8b3')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();
        // dd($c);


        $this->tombol_kegiatan();
        session()->flash('alert_kegiatan', 'Kegiatan Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function ajukan_pengajuan($id)
    {
        $gocap = config('app.database_gocap');
        $program = DB::table($gocap . '.pengurus_jabatan as pj')
        ->where('pj.id_pengurus_jabatan', '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')
        ->join($gocap . '.pc_pengurus as pp', 'pp.id_pengurus_jabatan', '=', 'pj.id_pengurus_jabatan')
        ->where('pp.status', '1')
        ->select('pp.id_pc_pengurus')
        ->first();



        $D_ajuan = PengajuanDetail::where('id_pengajuan', $id)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $id)->first();

        if ($ajuan->opsi_pemohon == "Individu") {
            $pemohon = $D_ajuan->nama_pemohon;
        } elseif ($ajuan->opsi_pemohon == "Entitas") {
            $pemohon = $D_ajuan->nama_entitas;
        } elseif ($ajuan->opsi_pemohon == "Internal") {
            $pemohon = $this->nama_pengurus_pc($ajuan->pemohon_internal);
        }

        PengajuanDetail::where('id_pengajuan', $id)->update([
            'tgl_diserahkan_div_program' => date('Y-m-d'),
        ]);

        // kirim notif wa
        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

        $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
        $id_program = PcPengurus::where('id_pengurus_jabatan', '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')->value('id_pc_pengurus');
        $nama_program = Pengguna::where('gocap_id_pc_pengurus', $id_program)->value('nama');


        // dd($D_ajuan->sumber_dana . '\\'. $this->nama_pengurus_pc($program->id_pc_pengurus) . '\\'. $this->jabatan_pengurus_pc($program->id_pc_pengurus) );
        $this->notif(
            // Helper::getNohpPengurus('pc', $program->id_pc_pengurus),
            '089639481199',

            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                "Yth. " . "*" . $this->nama_pengurus_pc($program->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($program->id_pc_pengurus) . "\n" . "\n" .

                "*Pengajuan selesai diinputkan oleh Front Office.*" . "\n" . "*Segera respon & teruskan kepada Direktur.*" . "\n" . "\n" .

                "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $ajuan->nomor_surat  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nama Pemohon"  . "*" .  "\n" .
                $ajuan->opsi_pemohon . " - " . $pemohon  .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" . "\n" .
                "========================" . "\n" . "\n" .
                "*" .  "Asnaf"  . "*" .  "\n" .
                $asnaf .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $D_ajuan->pengajuan_note .  "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        // dd('ajukan pengjuan' . $id);
        Pengajuan::where('id_pengajuan', $id)->update([
            'status_pengajuan' => 'Diajukan'
        ]);
    }

    public function batalkan_pengajuan($id)
    {
        // dd('batalkan pengajuaan' . $id);
        Pengajuan::where('id_pengajuan', $id)->update([
            'status_pengajuan' => 'Direncanakan'
        ]);
    }


    public function ajukan_pengajuan_survey($id)
    {
        // dd('ajukan pengjuan survey' . $id);
        Pengajuan::where('id_pengajuan', $id)->update([
            'status_survey' => 'Diajukan'
        ]);

        $direktur = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Kepala Cabang')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $D_ajuan = PengajuanDetail::where('id_pengajuan', $id)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $id)->first();

        if ($ajuan->opsi_pemohon == "Individu") {
            $pemohon = $D_ajuan->nama_pemohon;
        } elseif ($ajuan->opsi_pemohon == "Entitas") {
            $pemohon = $D_ajuan->nama_entitas;
        } elseif ($ajuan->opsi_pemohon == "Internal") {
            $pemohon = $this->nama_pengurus_pc($ajuan->pemohon_internal);
        }

        // kirim notif wa
        $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan;

        $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
        // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
        // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

        // petugas penyaluran
        $this->notif(
            // Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
            '089639481199',

            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                "*Survey penerima manfaat selesai.*" . "\n" . "*Segera berikan respon persetujuan pencairan dana.*" . "\n" . "\n" .

                "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $ajuan->nomor_surat  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nama Pemohon"  . "*" .  "\n" .
                $ajuan->opsi_pemohon . " - " . $D_ajuan->nama_pemohon .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" . "\n" .
                "========================" . "\n" . "\n" .
                "*" .  "Asnaf"  . "*" .  "\n" .
                $asnaf .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" .
                "*" .  "Keterangan Pengajuan"  . "*" .  "\n" .
                $D_ajuan->pengajuan_note .  "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );
    }

    public function batalkan_pengajuan_survey($id)
    {
        // dd('batalkan pengajuaan suvey' . $id);
        Pengajuan::where('id_pengajuan', $id)->update([
            'status_survey' => 'Direncanakan'
        ]);
    }

    public function tombol_pengajuan()
    {
        $this->bg_card_pengajuan = 'bg-success';
        // $this->bg_card_kegiatan = '';
        // $this->bg_card_berita = '';
        $this->tab_v2();
    }

    public function tombol_kegiatan()
    {
        // $this->bg_card_pengajuan = '';
        // $this->bg_card_kegiatan = 'bg-success';
        // $this->bg_card_berita = '';

        $this->kegiatan = PengajuanKegiatan::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $this->dokumentasi =  PengajuanDokumentasi::where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->orderBy('created_at', 'DESC')->get();
        $this->barang =  DetailBarang::where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->orderBy('created_at', 'DESC')->get();
    }

    public function tombol_berita()
    {
        $this->tombol_kegiatan();
        // $this->bg_card_pengajuan = '';
        // $this->bg_card_kegiatan = '';
        // $this->bg_card_berita = 'bg-success';
        // $this->none_block_terbit = 'none';

        // $this->kegiatan = PengajuanKegiatan::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        // $this->dokumentasi =  PengajuanDokumentasi::where('id_pengajuan_detail', $this->id_pengajuan_detail)
        //     ->orderBy('created_at', 'DESC')->get();
    }

    public function nama_kegiatan($id)
    {
        $a = ProgramKegiatan::where('id_program_kegiatan', $id)->first();

        return  $a->nama_program ?? '';
    }

    public function nama_pilar($id)
    {
        $a = ProgramPilar::where('id_program_pilar', $id)->first();

        return  $a->pilar ?? '';
    }

    public function modal_pc_hapus($id_pengajuan_detail)
    {
        $this->id_pengajuan_detail = $id_pengajuan_detail;
        // dd($id_lpj_internal);
    }

    public function hapus_pc()
    {
        // dd($this->id_lpj_internal);
        $data = Pengajuan::where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = PengajuanDetail::where('id_pengajuan', $data->id_pengajuan)->first();
        $lampiran = PengajuanLampiran::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->first();
        $penerima = PengajuanPenerima::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->first();
        $survey = SurveyPenerimaManfaat::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->first();

        if ($lampiran) {
            PengajuanLampiran::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->delete();
            if ($lampiran->file != null) {
                $path = public_path() . "/uploads/pengajuan_lampiran/" . $lampiran->file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        if ($penerima) {
            PengajuanLampiran::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->delete();
        }

        if ($survey) {
            SurveyPenerimaManfaat::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->delete();
        }

        if ($data->id_rekening !== null && $data->id_rekening !== '') {
            Rekening::where('id_rekening', $data->id_rekening)->increment('saldo', str_replace('.', '', $this->nominal_disetujui2));
            ArusDana::where('id_etasyaruf_permohonan_pentasyarufan_koin', $data_detail->id_pengajuan_detail)->delete();
            JurnalUmum::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->delete();
        }

        $lampiran_pencairan = LampiranPencairan::where('id_pengajuan', $data->id_pengajuan)->first();
        if ($lampiran_pencairan) {
            LampiranPencairan::where('id_pengajuan', $data->id_pengajuan)->delete();
            if ($lampiran_pencairan->file != null) {
                $path = public_path() . "/uploads/pengajuan_lampiran/" . $lampiran_pencairan->file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        $berita = Berita::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->first();
        if ($berita) {
            Berita::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->delete();
        }

        PengajuanDetail::where('id_pengajuan', $data->id_pengajuan)->delete();
        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->delete();

        session()->flash('success_pc', 'Pengajuan Umum Berhasil Dihapus');
        $this->dispatchBrowserEvent('success', ['message' => 'Pengajuan Umum Berhasil Dihapus']);
        return redirect('/pc/internalpc-pc');
    }

    public function nama_pengurus_pc($id)
    {

        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pc_pengurus', '=', $this->siftnu . '.pengguna.gocap_id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->select(
                $this->siftnu . '.pengguna.nama',
                $this->gocap . '.pengurus_jabatan.jabatan'
            )
            ->first();
        // dd($a->nama);
        return $a->nama ?? '';
    }

    public function nohp_pengurus_pc($id)
    {

        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        return $a->nohp;
    }
    public function alamat_pc($id)
    {

        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        return $a->alamat;
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
        return $a->jabatan ?? '';
    }

    public function modal_edit_berita($id)
    {
        $pengurus = Auth::user()->gocap_id_pc_pengurus;
        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $id)->first();
        // dd($data_detail);
        $data = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        //  dd($data);
        if ($data_detail->tgl_berita) {
            $this->tgl_berita = $data_detail->tgl_berita;
        } else {
            $this->tgl_berita = date('Y-m-d');
        }

        if ($data_detail->senilai) {
            $this->senilai = number_format($data_detail->senilai, 0, '.', '.');
        } else {
            $this->senilai = NULL;;
        }
        $this->berupa = $data_detail->berupa;
        $this->jumlah_bantuan = $data_detail->jumlah_bantuan;
        $this->metode_penyaluran = $data_detail->metode_penyaluran;
        $this->nama_bank_penerima = $data_detail->nama_bank_penerima;
        $this->cabang = $data_detail->cabang;
        $this->atas_nama_penerima = $data_detail->atas_nama_penerima;
        $this->no_rek_penerima = $data_detail->no_rek_penerima;

        if ($data_detail->nama1 or $data_detail->jabatan1 or $data_detail->nohp1 or $data_detail->alamat1 or $data_detail->nik1) {
            $this->nama1 = $data_detail->nama1;
            $this->jabatan1 = $data_detail->jabatan1;
            $this->nohp1 = $data_detail->nohp1;
            $this->alamat1 = $data_detail->alamat1;
            $this->nik1 = $data_detail->nik1;
        } else {
            if ($data->tingkat == 'Upzis MWCNU') {
                $this->nama1 = Helper::getNamaPengurus('upzis', $data_detail->petugas_upzis);
                $this->jabatan1 = Helper::getJabatanPengurus('upzis', $data_detail->petugas_upzis);
                $this->nohp1 = Helper::getNohpPengurus('upzis', $data_detail->petugas_upzis);
                $this->alamat1 = Helper::getAlamatPengurus('upzis', $data_detail->petugas_upzis);
                $this->nik1 = Helper::getNikPengurus('upzis', $data_detail->petugas_upzis);
            } elseif ($data->tingkat == 'Ranting NU') {
                $this->nama1 = Helper::getNamaPengurus('ranting', $data_detail->petugas_ranting);
                $this->jabatan1 = Helper::getJabatanPengurus('ranting', $data_detail->petugas_ranting);
                $this->nohp1 = Helper::getNohpPengurus('ranting', $data_detail->petugas_ranting);
                $this->alamat1 = Helper::getAlamatPengurus('ranting', $data_detail->petugas_ranting);
                $this->nik1 = Helper::getNikPengurus('ranting', $data_detail->petugas_ranting);
            } elseif ($data->tingkat == 'PC') {
                    $this->nama1 = Helper::getNamaPengurus('pc', $pengurus);
                    $this->jabatan1 = Helper::getJabatanPengurus('pc', $pengurus);
                    $this->nohp1 = Helper::getNohpPengurus('pc', $pengurus);
                    $this->alamat1 = Helper::getAlamatPengurus('pc', $pengurus);
                    $this->nik1 = Helper::getNikPengurus('pc', $pengurus);
            }
        }

        if ($data_detail->nama2 or $data_detail->jabatan2 or $data_detail->nohp2 or $data_detail->alamat2 or $data_detail->nik2) {
            $this->nama2 = $data_detail->nama2;
            $this->jabatan2 = $data_detail->jabatan2;
            $this->nohp2 = $data_detail->nohp2;
            $this->alamat2 = $data_detail->alamat2;
            $this->nik2 = $data_detail->nik2;
        } else {
            if ($data->opsi_pemohon == 'Entitas') {
                $this->nama2 = $data_detail->nama_pj_permohonan_entitas;
                $this->jabatan2 = $data_detail->jabatan_entitas;
                $this->nohp2 = $data_detail->no_hp_entitas;
                $this->alamat2 = $data_detail->alamat_entitas;
                $this->nik2 = $data_detail->nik_entitas;
            } elseif ($data->opsi_pemohon == 'Individu') {
                $this->nama2 = $data_detail->nama_pemohon;
                $this->nohp2 = $data_detail->nohp_pemohon;
                $this->alamat2 = $data_detail->alamat_pemohon;
                $this->nik2 = $data_detail->nik_individu;
            } elseif ($data->opsi_pemohon == 'Internal') {
                $this->nama2 = Helper::getNamaPengurus('pc', $data->pemohon_internal);
                $this->jabatan2 = Helper::getJabatanPengurus('pc', $data->pemohon_internal);
                $this->nohp2 = Helper::getNohpPengurus('pc', $data->pemohon_internal);
                $this->alamat2 = Helper::getAlamatPengurus('pc', $data->pemohon_internal);
                $this->nik2 = Helper::getNikPengurus('pc', $data->pemohon_internal);
            }
        }
    }

    public function edit_berita_pengajuan()
    {
        // dd('wef');
        // Pastikan $this->senilai tidak kosong dan memiliki nilai yang valid sebelum mengubahnya
        if ($this->senilai != null) {
            PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
                'tgl_berita' => $this->tgl_berita,
                'berupa' => $this->berupa,
                'senilai' => str_replace('.', '', $this->senilai),
                'nik1' => $this->nik1,
                'nama1' => $this->nama1,
                'jabatan1' => $this->jabatan1,
                'nohp1' => $this->nohp1,
                'alamat1' => $this->alamat1,
                'nama2' => $this->nama2,
                'jabatan2' => $this->jabatan2,
                'nohp2' => $this->nohp2,
                'alamat2' => $this->alamat2,
                'nik2' => $this->nik2,
                'metode_penyaluran' => $this->metode_penyaluran,
                'nama_bank_penerima' => $this->nama_bank_penerima,
                'cabang' => $this->cabang,
                'atas_nama_penerima' => $this->atas_nama_penerima,
                'no_rek_penerima' => $this->no_rek_penerima,
            ]);
        } else {
            // Lakukan pembaruan (update) tanpa mengubah nilai senilai
            PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
                'tgl_berita' => $this->tgl_berita,
                'berupa' => $this->berupa,
                'senilai' => null,
                'nama1' => $this->nama1,
                'nik1' => $this->nik1,
                'jabatan1' => $this->jabatan1,
                'nohp1' => $this->nohp1,
                'alamat1' => $this->alamat1,
                'nama2' => $this->nama2,
                'jabatan2' => $this->jabatan2,
                'nohp2' => $this->nohp2,
                'alamat2' => $this->alamat2,
                'nik2' => $this->nik2,
                'metode_penyaluran' => $this->metode_penyaluran,
                'nama_bank_penerima' => $this->nama_bank_penerima,
                'cabang' => $this->cabang,
                'atas_nama_penerima' => $this->atas_nama_penerima,
                'no_rek_penerima' => $this->no_rek_penerima,
                ]);
        }
        // $this->detail_laporan($this->id_pengajuan_detail);
        // $this->emit('waktu_alert');
        // $this->dispatchBrowserEvent('edit_penerima');
        // session()->flash('success', 'Berita Acara Berhasil Diubah');

        // $this->emit('dataTersimpanLpj');
        // $this->dispatchBrowserEvent('closeModal');
        session()->flash('alert_lpj_detail', 'Berhasil Menambah Data Berita Acara');
        $this->emit('waktu_alert');
    }

    public function tombol_acc_div_program_lpj($id)
    {

        PengajuanDetail::where('id_pengajuan', $id)->update([
            'konfirmasi_lpj_div_prog' => 'Dikonfirmasi',
            'tgl_diperiksa' => date('Y-m-d'),
            'lpj_pemeriksa_pc' => Auth::user()->gocap_id_pc_pengurus
        ]);
        session()->flash('acc_alert_lpj', 'Berhasil Mengkonfirmasi ACC');
        $this->emit('waktu_alert');
    }

    public function hapusBeritaUmum()
   {
        $a = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
    
        if ($a->file_berita != null) {
            $path = public_path() . "/uploads/pengajuan_berita/" . $a->file_berita;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'status_berita' => 'Belum Dikonfirmasi',
                'file_berita' => null,
                'konfirmasi_note' => null,
                'tgl_konfirmasi' => null,
                'berita_konfirmasi_pc' => null
        ]);
    
        session()->flash('upload_berkas_lpj', 'Lampiran Berhasil Dihapus');
        $this->emit('waktu_alert');
   }

    public function uploadBeritaUmumPc()
    {
        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        if ($this->scan_berita) {
            if ($data_detail->file_berita != null) {
                $path = public_path() . "/uploads/pengajuan_berita/" . $data_detail->file_berita;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $ext = $this->scan_berita->extension();
            $file_scan_name = Str::uuid()->toString() . '.' . $ext;
            $this->scan_berita->storeAs('pengajuan_berita', $file_scan_name);

            // if ($data_detail->status_berita == 'Belum Dikonfirmasi' or $data_detail->status_berita == 'Sudah Dikonfirmasi') {
            PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
                'status_berita' => 'Sudah Dikonfirmasi',
                'file_berita' => $file_scan_name,
                'konfirmasi_note' => $this->konfirmasi_note,
                'tgl_konfirmasi' => date('Y-m-d'),
                'berita_konfirmasi_pc' => Auth::user()->gocap_id_pc_pengurus
            ]);
            // }
            // if ($data_detail->status_berita == 'Revisi') {
            //     PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            //         'status_berita' => 'Revisi',
            //         'file_berita' => $file_scan_name,
            //         'konfirmasi_note' => $this->konfirmasi_note,
            //         'tgl_konfirmasi' => date('Y-m-d'),
            //         'berita_konfirmasi_pc' => Auth::user()->gocap_id_pc_pengurus
            //     ]);
            // }
            // dd($file_scan_name);

            // $this->scan_berita = '';
            // $this->konfirmasi_note = '';
            // $this->mount();
            // $this->detail_laporan(($this->id_pengajuan_detail));

            session()->flash('upload_berkas_lpj', 'Berkas Berhasil di-Upload');
            $this->emit('waktu_alert');
        } else {
            session()->flash('upload_berkas_lpj_gagal', 'Berkas Gagal di-Upload');
            $this->emit('waktu_alert');
        }
    }

    public function hydrate()
    {
        $this->emit('loadContactDeviceSelect2');
    }
}
