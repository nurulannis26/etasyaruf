<?php

namespace App\Http\Livewire;

use App\Models\Berita;
use Livewire\Component;
use App\Models\ArusDana;
use App\Models\Internal;
use App\Models\Pengguna;
use App\Models\Programs;
use App\Models\Rekening;
use App\Models\Pengajuan;
use App\Models\PcPengurus;
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
    public $nokk;
    public $nik;
    public $nohp;
    public $keterangan_tolak_pencairan;
    public $tgl_tolak_pencairan;
    public $keterangan_pencairan;
    
    
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

    public $scan_berita;
    public $konfirmasi_note;


    public function mount()
    {
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan', $this->id_pengajuan)->first();
        $this->rek_cek = Rekening::where('id_rekening', $data_detail->id_rekening_pencairan_direktur)->first();
        $this->id_pengajuan_detail = $data_detail->id_pengajuan_detail;
        $this->none_block_survey = 'none';
        $this->none_block_acc = 'none';
        $this->none_block_tolak = 'none';
        $this->tgl_survey = date('Y-m-d');

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
                $this->gocap . '.pengurus_jabatan.jabatan'
            )
            ->get();

        $this->nomor_surat_edit = $pengajuan->nomor_surat;
        $this->opsi_pemohon_edit = $pengajuan->opsi_pemohon;
        $this->tgl_pengajuan_edit = $pengajuan->tgl_pengajuan;
        $this->jenis_permohonan_edit = $pengajuan->jenis_permohonan;

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
        $this->sumber_dana_edit = $data_detail->sumber_dana;
        $this->id_program_pilar_edit = $data_detail->id_program_pilar;
        $this->id_program_kegiatan_edit = $data_detail->id_program_kegiatan;
        $this->id_asnaf_edit = $data_detail->id_asnaf;
        $this->nama_penerima_edit = $data_detail->nama_penerima;
        $this->pengajuan_note_edit = $data_detail->pengajuan_note;
        $this->pemohon_internal_edit = $pengajuan->pemohon_internal;
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
        if($berita) {
            Berita::where('id_pengajuan_detail', $data_detail->id_pengajuan_detail)->delete();
        }

        PengajuanDetail::where('id_pengajuan', $data->id_pengajuan)->delete();
        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->delete();

        session()->flash('success_pc', 'Pengajuan Umum Berhasil Dihapus');
        $this->dispatchBrowserEvent('success', ['message' => 'Pengajuan Umum Berhasil Dihapus']);
        return redirect('/pc/internalpc-pc');


    }

    public function ubah_nominal_pengajuan()
    {
        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $pengajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();

        Pengajuan::where('id_pengajuan', $pengajuan->id_pengajuan)->update([
            'tgl_pengajuan' => $this->tgl_pengajuan_edit,
            'jenis_permohonan' => $this->jenis_permohonan_edit,
            'opsi_pemohon' => $this->opsi_pemohon_edit,
            'pemohon_internal' => $this->pemohon_internal_edit,
        ]);

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
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
            'sumber_dana' => $this->sumber_dana_edit,
            'id_program_pilar' => $this->id_program_pilar_edit,
            'id_program_kegiatan' => $this->id_program_kegiatan_edit,
            'id_asnaf' => $this->id_asnaf_edit,
            'nama_penerima' => $this->nama_penerima_edit,
            'pengajuan_note' => $this->pengajuan_note_edit,

        ]);

        session()->flash('alert_nominal', 'Nominal Pengajuan Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
        $this->reset_edit();

        // $this->modal_rencana_kegiatan($this->id_pengajuan_detail);
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

        $this->tgl_penyaluran = date('Y-m-d');





        $this->survey = SurveyPenerimaManfaat::where('id_pengajuan', $this->id_pengajuan)->where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->first() ?? null;
        // dd($this->survey);

        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan', $this->id_pengajuan)->first();
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
            ->where('jabatan', 'Direktur Eksekutif')
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
            ->where($this->gocap . '.pengurus_jabatan.jabatan',  'Divisi Keuangan')
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
            ->where($this->gocap . '.pengurus_jabatan.jabatan',  'Divisi Keuangan')
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


        $this->tab_v4();

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


        if ($this->rek_cek) {
            $this->rekening_keuangan = Rekening::where('id_pc', $data->id_pc)
                // ->join($this->gocap . '.bmt', $this->gocap . '.bmt.id_bmt', '=', $this->gocap . '.rekening.id_bmt')
                ->whereNull('id_upzis')->whereNull('id_ranting')
                // ->whereNotNull('id_pc')
                ->whereNotNull('no_rekening')
                ->where('id_rekening', '!=', $this->rek_cek->id_rekening)
                ->select(
                    $this->gocap . '.rekening.*',
                    // $this->gocap . '.bmt.nama_bmt',
                )
                // ->where('nama_rekening', 'PC LAZISNU CILACAP')
                ->get();
        } else {
            $this->rekening_keuangan = Rekening::where('id_pc', $data->id_pc)
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
        }
        // $this->tab_v3();

        $c = DB::table($this->gocap . '.pengurus_jabatan')
            ->where('tingkat', 'pc')
            ->where('jabatan', 'Divisi IT dan Media')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();
        // dd($c);
        $this->id_staf_media = $c->id_pc_pengurus;

        // $this->modal_pengajuan_berita();

        $this->berita = Berita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        // dd($berita);
        return view('livewire.detail-pc', compact(
            'data',
            // 'berita',
            'data_detail',
            'pengeluaran',
            'lampiran_pencairan',
        ));
    }

    public function nama_rekening($id)
    {
        $a = Rekening::where('id_rekening', $id)->first();

        return  $a->nama_rekening . " - " . $a->no_rekening ?? '';
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
        $b = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Front Office')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select(
                $this->siftnu . '.pengguna.*',
            )
            ->first();

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

    public function tab_v4()
    {
        $this->tgl_pencairan = date('Y-m-d');
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
        ]);


        // $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan_detail;
        $url =  "https://e-tasyaruf.nucarecilacap.id";
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        // $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');

        $direktur = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Direktur Eksekutif')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $d_penyaluran = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Divisi Penyaluran')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();


        // dd($D_ajuan->sumber_dana . '\\'. $this->nama_pengurus_pc($program->id_pc_pengurus) . '\\'. $this->jabatan_pengurus_pc($program->id_pc_pengurus) );
        if ($this->pil_survey == 'Tidak Perlu') {
            if ($D_ajuan->sumber_dana == "Dana Zakat") {

                // kirim notif wa
                $url =  "https://e-tasyaruf.nucarecilacap.id";

                $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
                // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
                // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

                // petugas penyaluran
                $this->notif(
                    Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
                    // '082138603051',

                    "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                        // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                        // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                        "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                        $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                        "*Pengajuan Umum Tingkat PC disetujui Direktur (tanpa survey).*" . "\n" . "*Segera berikan respon persetujuan pencairan dana.*" . "\n" . "\n" .

                        "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                        "*" .  "Nomor"  . "*" .  "\n" .
                        $ajuan->nomor_surat  . "\n" .
                        "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Tanggal Input"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                        'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .

                        "*" .  "Asnaf"  . "*" .  "\n" .
                        $asnaf .  "\n" . "\n" .

                        "Terima Kasih." . "\n" . "\n" .
                        url($url)
                );
            } else {

                // kirim notif wa
                $url =  "https://e-tasyaruf.nucarecilacap.id";

                // petugas penyaluran
                $this->notif(
                    Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
                    // '082138603051',

                    "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                        // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                        // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                        "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                        $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                        "*Pengajuan Umum Tingkat PC disetujui Direktur (tanpa survey).*" . "\n" . "*Segera berikan respon persetujuan pencairan dana.*" . "\n" . "\n" .

                        "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                        "*" .  "Nomor"  . "*" .  "\n" .
                        $ajuan->nomor_surat  . "\n" .
                        "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Tanggal Input"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                        'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                        "*" .  "Pilar"  . "*" .  "\n" .
                        $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                        "*" .  "Kegiatan"  . "*" .  "\n" .
                        $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" . "\n" .

                        "Terima Kasih." . "\n" . "\n" .
                        url($url)
                );
            }
        }


        if ($this->pil_survey == 'Perlu') {
            if ($D_ajuan->sumber_dana == "Dana Zakat") {

                // kirim notif wa
                $url =  "https://e-tasyaruf.nucarecilacap.id";

                $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
                // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
                // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

                // petugas penyaluran
                $this->notif(
                    Helper::getNohpPengurus('pc', $d_penyaluran->id_pc_pengurus),
                    // '082138603051',

                    "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                        // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                        // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                        "Yth. " . "*" . $this->nama_pengurus_pc($d_penyaluran->id_pc_pengurus) .  "*" . "\n" .
                        $this->jabatan_pengurus_pc($d_penyaluran->id_pc_pengurus) . "\n" . "\n" .

                        "*Pengajuan Umum Tingkat PC disetujui Direktur.*" . "\n" . "*Segera input survey penerima manfaat & konfirmasi jika telah selesai input survey.*" . "\n" . "\n" .

                        "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                        "*" .  "Nomor"  . "*" .  "\n" .
                        $ajuan->nomor_surat  . "\n" .
                        "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Tanggal Input"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                        'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .

                        "*" .  "Asnaf"  . "*" .  "\n" .
                        $asnaf .  "\n" . "\n" .

                        "Terima Kasih." . "\n" . "\n" .
                        url($url)
                );
            } else {

                // kirim notif wa
                $url =  "https://e-tasyaruf.nucarecilacap.id";

                // petugas penyaluran
                $this->notif(
                    Helper::getNohpPengurus('pc', $d_penyaluran->id_pc_pengurus),
                    // '082138603051',

                    "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                        // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                        // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                        "Yth. " . "*" . $this->nama_pengurus_pc($d_penyaluran->id_pc_pengurus) .  "*" . "\n" .
                        $this->jabatan_pengurus_pc($d_penyaluran->id_pc_pengurus) . "\n" . "\n" .

                        "*Pengajuan Umum Tingkat PC disetujui Direktur.*" . "\n" . "*Segera input survey penerima manfaat & konfirmasi jika telah selesai input survey.*" . "\n" . "\n" .

                        "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                        "*" .  "Nomor"  . "*" .  "\n" .
                        $ajuan->nomor_surat  . "\n" .
                        "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Tanggal Input"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                        'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                        "*" .  "Pilar"  . "*" .  "\n" .
                        $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                        "*" .  "Kegiatan"  . "*" .  "\n" .
                        $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" . "\n" .

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


        // dd($this->satuan_disetujui . $this->nominal_disetujui);
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'approval_date_pencairan_direktur' => $this->approval_date_pencairan_direktur,
            'approval_status_pencairan_direktur' => 'Disetujui',
            'approval_pencairan_direktur_id' => Auth::user()->gocap_id_pc_pengurus,
            'satuan_disetujui_pencairan_direktur' => str_replace('.', '', $this->satuan_disetujui),
            'nominal_disetujui_pencairan_direktur' => str_replace('.', '', $this->nominal_disetujui),
            'keterangan_acc_pencairan_direktur' => $this->keterangan_acc_pencairan_direktur,
            'id_rekening_pencairan_direktur' => $this->id_rekening,
            'sumber_dana_opsi' => $this->sumber_dana_opsi,
            // 'pil_survey' => $this->pil_survey,
            'staf_keuangan_pc' => $this->staf_keuangan,
        ]);


        // $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan_detail;
        $url =  "https://e-tasyaruf.nucarecilacap.id";
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        // $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');



        $keuangan = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Divisi Keuangan')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();


        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();


        if ($D_ajuan->sumber_dana == "Dana Zakat") {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
            // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
            // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $keuangan->id_pc_pengurus),
                // '082138603051',

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
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                    "*" .  "Survey"  . "*" .  "\n" .
                    $D_ajuan->pil_survey  . "\n" .
                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $this->sumber_dana_opsi .  "\n" .
                    "*" .  "Asnaf"  . "*" .  "\n" .
                    $asnaf .  "\n" . "\n" .
                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        } else {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $keuangan->id_pc_pengurus),
                // '082138603051',

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
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                    "*" .  "Survey"  . "*" .  "\n" .
                    $D_ajuan->pil_survey  . "\n" .
                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $this->sumber_dana_opsi .  "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }

        $this->none_block_acc_direktur_keuangan = 'none';
        session()->flash('alert_direktur', 'Pengajuan Berhasil Disetujui');
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
        $url =  "https://e-tasyaruf.nucarecilacap.id";
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


        $direktur = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Direktur Eksekutif')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();


        // dd($D_ajuan->sumber_dana . '\\'. $this->nama_pengurus_pc($program->id_pc_pengurus) . '\\'. $this->jabatan_pengurus_pc($program->id_pc_pengurus) );
        if ($D_ajuan->sumber_dana == "Dana Zakat") {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
            // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
            // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
                // '082138603051',

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                    // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                    "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                    "*Disposisi penyaluran diserahkan ke Direktur.*" . "\n" . "*Segera berikan respon persetujuan & kebutuhan survey penerima manfaat.*" . "\n" . "\n" .

                    "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $ajuan->nomor_surat  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .

                    "*" .  "Asnaf"  . "*" .  "\n" .
                    $asnaf .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        } else {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
                // '082138603051',

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                    // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                    "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                    "*Disposisi penyaluran diserahkan ke Direktur.*" . "\n" . "*Segera berikan respon persetujuan & kebutuhan survey penerima manfaat.*" . "\n" . "\n" .

                    "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $ajuan->nomor_surat  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }



        $this->none_block_acc_program = 'none';
        session()->flash('alert_direktur', 'Pengajuan Berhasil Disetujui');
        $this->emit('waktu_alert');
    }

    public function tolak()
    {
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $url =  "https://e-tasyaruf.nucarecilacap.id";

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'denial_date' => $this->denial_date,
            'denial_note' => $this->denial_note,
            'approval_status' => 'Ditolak',
            'denial_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        // fo
        $front = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Front Office')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');

        if ($data_detail->sumber_dana == 'Dana Zakat') {
            $this->notif(
                // nomor fo
                $this->nohp_pengurus_pc($front->id_pc_pengurus),
                // '082138603051',
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

                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $data_detail->sumber_dana .  "\n" .


                    "*" .  "Asnaf"  . "*" .  "\n" .
                    $asnaf .  "\n" .

                    "*" .  "Alasan"  . "*" .  "\n" .
                    $this->denial_note .  "\n" . "\n" .

                    // "*" .  "Pilar"  . "*" .  "\n" .
                    // $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    // "*" .  "Kegiatan"  . "*" .  "\n" .
                    // $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" . "\n" .


                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        } elseif ($data_detail->sumber_dana == 'Dana Infak') {
            $this->notif(
                // nomor fo
                $this->nohp_pengurus_pc($front->id_pc_pengurus),
                // '082138603051',
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

                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $data_detail->sumber_dana .  "\n" .


                    // "*" .  "Asnaf"  . "*" .  "\n" .
                    // $asnaf .  "\n" . "\n" .

                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" .

                    "*" .  "Alasan"  . "*" .  "\n" .
                    $this->denial_note .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }




        $this->none_block_tolak = 'none';
        session()->flash('alert_direktur', 'Pengajuan Berhasil Ditolak');
        $this->emit('waktu_alert');
    }

    public function tolak_direktur_keuangan()
    {
        // dd('TESTING PENOLAKAN PENCAIRAN DANA DIREKTUR');
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $url =  "https://e-tasyaruf.nucarecilacap.id";

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'denial_date_pencairan_direktur' => $this->denial_date_pencairan_direktur,
            'denial_note_pencairan_direktur' => $this->denial_note_pencairan_direktur,
            'approval_status_pencairan_direktur' => 'Ditolak',
            'denial_pencairan_direktur_id' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        // fo
        $front = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Front Office')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');

        if ($data_detail->sumber_dana == 'Dana Zakat') {
            $this->notif(
                // nomor fo
                $this->nohp_pengurus_pc($front->id_pc_pengurus),
                // '082138603051',
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

                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $data_detail->sumber_dana .  "\n" .


                    "*" .  "Asnaf"  . "*" .  "\n" .
                    $asnaf .  "\n" .

                    "*" .  "Alasan"  . "*" .  "\n" .
                    $this->denial_note .  "\n" . "\n" .

                    // "*" .  "Pilar"  . "*" .  "\n" .
                    // $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    // "*" .  "Kegiatan"  . "*" .  "\n" .
                    // $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" . "\n" .


                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        } elseif ($data_detail->sumber_dana == 'Dana Infak') {
            $this->notif(
                // nomor fo
                $this->nohp_pengurus_pc($front->id_pc_pengurus),
                // '082138603051',
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

                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $data_detail->sumber_dana .  "\n" .


                    // "*" .  "Asnaf"  . "*" .  "\n" .
                    // $asnaf .  "\n" . "\n" .

                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" .

                    "*" .  "Alasan"  . "*" .  "\n" .
                    $this->denial_note .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }




        $this->none_block_tolak_direktur_keuangan = 'none';
        session()->flash('alert_direktur', 'Pengajuan Berhasil Ditolak');
        $this->emit('waktu_alert');
    }
   

    public function tolak_program()
    {

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'denial_date_divpro' => $this->denial_date_divpro,
            'denial_note_divpro' => $this->denial_note_divpro,
            'approval_status_divpro' => 'Ditolak',
            'denial_divpro' => Auth::user()->gocap_id_pc_pengurus,
        ]);


        $this->none_block_tolak_program = 'none';
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

    public function tombol_acc_direktur_keuangan()
    {

        $this->tab_v3();
        $this->none_block_tolak = 'none';
        $this->none_block_tolak_program = 'none';
        $this->none_block_acc_program = 'none';
        $this->none_block_acc = 'none';
        $this->none_block_tolak_direktur_keuangan = 'none';


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
        $this->nominal_bantuan = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->first()->satuan_pengajuan;

        $a = PengajuanPenerima::where('id_pengajuan_penerima', $id_pengajuan_penerima)->first();
        $this->id_pengajuan_penerima = $id_pengajuan_penerima;
        $this->nama = $a->nama;
        $this->alamat = $a->alamat;
        $this->keterangan = $a->keterangan;

        $this->nik = $a->nik;
        $this->nokk = $a->nokk;
        $this->nohp = $a->nohp;
        $this->jenis_bantuan = $a->jenis_bantuan;
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
        $url =  "https://e-tasyaruf.nucarecilacap.id";

        // fo
        $front = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Front Office')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $asnaf = DB::table('asnaf')->where('id_asnaf', $data_detail->id_asnaf)->value('nama_asnaf');

        if ($data_detail->sumber_dana == 'Dana Zakat') {
            // petugas
            $this->notif(
                $this->nohp_pengurus_pc($front->id_pc_pengurus),
                // '082138603051',


                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($front->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($front->id_pc_pengurus) . "\n" . "\n" .


                    "Pengajuan UMUM PC Lazisnu Cilacap, " . "*" . "Ditolak" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .


                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "Pemohon"  . "*" .  "\n" .
                    $data_detail->nama_pemohon .  "\n" .
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

                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $data_detail->sumber_dana .  "\n" .


                    "*" .  "Asnaf"  . "*" .  "\n" .
                    $asnaf .  "\n" . "\n" .

                    // "*" .  "Pilar"  . "*" .  "\n" .
                    // $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    // "*" .  "Kegiatan"  . "*" .  "\n" .
                    // $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" . "\n" .
                    "*" .  "Alasan"  . "*" .  "\n" .
                    $this->keterangan_tolak_pencairan .  "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        } elseif ($data_detail->sumber_dana == 'Dana Infak') {
            $this->notif(
                $this->nohp_pengurus_pc($front->id_pc_pengurus),
                // '082138603051',


                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($front->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($front->id_pc_pengurus) . "\n" . "\n" .


                    "Pengajuan UMUM PC Lazisnu Cilacap, " . "*" . "Ditolak" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .

                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "Pemohon"  . "*" .  "\n" .
                    $data_detail->nama_pemohon .  "\n" .
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

                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $data_detail->sumber_dana .  "\n" .


                    // "*" .  "Asnaf"  . "*" .  "\n" .
                    // $asnaf .  "\n" . "\n" .

                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" .

                    "*" .  "Alasan"  . "*" .  "\n" .
                    $this->keterangan_tolak_pencairan .  "\n" . "\n" .
                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }
    }

    public function pencairan()
    {
        // $data = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

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

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'pencairan_status' => 'Berhasil Dicairkan',
            'tgl_pencairan' => $this->tgl_pencairan,
            'dicairkan_kepada' => $data_detail->petugas_pc,
            'nominal_pencairan' => str_replace('.', '', $this->nominal_disetujui2),
            'satuan_pencairan' => str_replace('.', '', $this->satuan_disetujui2),
            'keterangan_pencairan' => $this->keterangan_pencairan,
            'id_rekening' => $this->id_rekening2,
            // 'file' => $kwitansi_name,
        ]);




        $fo = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Front Office')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();


        $D_ajuan = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();


        if ($D_ajuan->sumber_dana == "Dana Zakat") {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
            // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
            // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $fo->id_pc_pengurus),
                // '082138603051',

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                    // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                    "Yth. " . "*" . $this->nama_pengurus_pc($fo->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($fo->id_pc_pengurus) . "\n" . "\n" .

                    "*Pencairan dana untuk Pengajuan Umum Tingkat PC telah disetujui Div. Keuangan.*" . "\n" . "\n" .

                    "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $ajuan->nomor_surat  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                    "*" .  "Survey"  . "*" .  "\n" .
                    $D_ajuan->pil_survey  . "\n" .
                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $D_ajuan->sumber_dana_opsi .  "\n" .
                    "*" .  "Asnaf"  . "*" .  "\n" .
                    $asnaf .  "\n" . "\n" .
                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        } else {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $fo->id_pc_pengurus),
                // '082138603051',

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                    // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                    "Yth. " . "*" . $this->nama_pengurus_pc($fo->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($fo->id_pc_pengurus) . "\n" . "\n" .

                    "*Pencairan dana untuk Pengajuan Umum Tingkat PC telah disetujui Div. Keuangan.*" . "\n" . "\n" .

                    "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $ajuan->nomor_surat  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                    "*" .  "Survey"  . "*" .  "\n" .
                    $D_ajuan->pil_survey  . "\n" .
                    "*" .  "Sumber Dana"  . "*" .  "\n" .
                    $D_ajuan->sumber_dana_opsi .  "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }



        $this->none_block_acc = 'none';
        session()->flash('alert_keuangan', 'Pengajuan Berhasil Dicairkan');
        $this->emit('waktu_alert');
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
        $it = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Divisi IT dan Media')
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

        $program = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Divisi Program dan Administrasi Umum')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();


        $D_ajuan = PengajuanDetail::where('id_pengajuan', $id)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $id)->first();

        PengajuanDetail::where('id_pengajuan', $id)->update([
            'tgl_diserahkan_div_program' => date('Y-m-d'),
        ]);

        // dd($D_ajuan->sumber_dana . '\\'. $this->nama_pengurus_pc($program->id_pc_pengurus) . '\\'. $this->jabatan_pengurus_pc($program->id_pc_pengurus) );
        if ($D_ajuan->sumber_dana == "Dana Zakat") {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
            $id_program = PcPengurus::where('id_pengurus_jabatan', '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')->value('id_pc_pengurus');
            $nama_program = Pengguna::where('gocap_id_pc_pengurus', $id_program)->value('nama');

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $program->id_pc_pengurus),
                // '082138603051',

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                    // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                    "Yth. " . "*" . $this->nama_pengurus_pc($program->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($program->id_pc_pengurus) . "\n" . "\n" .

                    "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $ajuan->nomor_surat  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .

                    "*" .  "Asnaf"  . "*" .  "\n" .
                    $asnaf .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        } else {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $program->id_pc_pengurus),
                // '082138603051',

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                    // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                    "Yth. " . "*" . $this->nama_pengurus_pc($program->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($program->id_pc_pengurus) . "\n" . "\n" .

                    "# Pengajuan UMUM PC Lazisnu Cilacap" .  "\n"  . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $ajuan->nomor_surat  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($ajuan->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }

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

        $direktur = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Direktur Eksekutif')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $D_ajuan = PengajuanDetail::where('id_pengajuan', $id)->first();
        $ajuan = Pengajuan::where('id_pengajuan', $id)->first();


        // dd($D_ajuan->sumber_dana . '\\'. $this->nama_pengurus_pc($program->id_pc_pengurus) . '\\'. $this->jabatan_pengurus_pc($program->id_pc_pengurus) );
        if ($D_ajuan->sumber_dana == "Dana Zakat") {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            $asnaf = DB::table('asnaf')->where('id_asnaf', $D_ajuan->id_asnaf)->value('nama_asnaf');
            // $id_keuangan = PcPengurus::where('id_pengurus_jabatan', '694f38af-5374-11ed-882e-e4a8df91d8b3')->value('id_pc_pengurus');
            // $nama_keuangan = Pengguna::where('gocap_id_pc_pengurus', $id_keuangan)->value('nama');

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
                // '082138603051',

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
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .

                    "*" .  "Asnaf"  . "*" .  "\n" .
                    $asnaf .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        } else {

            // kirim notif wa
            $url =  "https://e-tasyaruf.nucarecilacap.id";

            // petugas penyaluran
            $this->notif(
                Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),
                // '082138603051',
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
                    "*" .  "Tanggal Input"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($D_ajuan->tgl_pelaksanaan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                    'Rp' . number_format($D_ajuan->nominal_pengajuan * $D_ajuan->jumlah_penerima, 0, '.', '.') . ',-' . "(" . $D_ajuan->nominal_pengajuan . "x" . $D_ajuan->jumlah_penerima . "penerima )" . "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($D_ajuan->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($D_ajuan->id_program_kegiatan) .  "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }
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
    
    public function alamat_pc($id)
    {

        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        return $a->alamat;
    }
    
     public function modal_edit_berita($id)
    {

        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $id)->first();
        $data = PengajuanDetail::where('id_pengajuan', $data_detail->id_pengajuan)->first();

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

        if ($data_detail->nama1 or $data_detail->jabatan1 or $data_detail->nohp1 or $data_detail->alamat1) {
            $this->nama1 = $data_detail->nama1;
            $this->jabatan1 = $data_detail->jabatan1;
            $this->nohp1 = $data_detail->nohp1;
            $this->alamat1 = $data_detail->alamat1;
        } else {
            if ($data->tingkat == 'Upzis MWCNU') {
                $this->nama1 = Helper::getNamaPengurus('upzis', $data_detail->petugas_upzis);
                $this->jabatan1 = Helper::getJabatanPengurus('upzis', $data_detail->petugas_upzis);
                $this->nohp1 = Helper::getNohpPengurus('upzis', $data_detail->petugas_upzis);
                $this->alamat1 = Helper::getAlamatPengurus('upzis', $data_detail->petugas_upzis);
            } elseif ($data->tingkat == 'Ranting NU') {
                $this->nama1 = Helper::getNamaPengurus('ranting', $data_detail->petugas_ranting);
                $this->jabatan1 = Helper::getJabatanPengurus('ranting', $data_detail->petugas_ranting);
                $this->nohp1 = Helper::getNohpPengurus('ranting', $data_detail->petugas_ranting);
                $this->alamat1 = Helper::getAlamatPengurus('ranting', $data_detail->petugas_ranting);
            } elseif ($data->tingkat == 'PC') {
                $this->nama1 = Helper::getNamaPengurus('pc', $data_detail->petugas_ranting);
                $this->jabatan1 = Helper::getJabatanPengurus('pc', $data_detail->petugas_ranting);
                $this->nohp1 = Helper::getNohpPengurus('pc', $data_detail->petugas_ranting);
                $this->alamat1 = Helper::getAlamatPengurus('pc', $data_detail->petugas_ranting);
            }
        }

        $this->nama2 = $data_detail->nama2;
        $this->jabatan2 = $data_detail->jabatan2;
        $this->nohp2 = $data_detail->nohp2;
        $this->alamat2 = $data_detail->alamat2;
    }

    public function edit_berita_pengajuan()
    {
        // dd('wef');
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([

            'tgl_berita' => $this->tgl_berita,
            'berupa' => $this->berupa,
            'senilai' => str_replace('.', '', $this->senilai),
            'nama1' => $this->nama1,
            'jabatan1' => $this->jabatan1,
            'nohp1' => $this->nohp1,
            'alamat1' => $this->alamat1,
            'nama2' => $this->nama2,
            'jabatan2' => $this->jabatan2,
            'nohp2' => $this->nohp2,
            'alamat2' => $this->alamat2,

        ]);
        // $this->detail_laporan($this->id_pengajuan_detail);
        // $this->emit('waktu_alert');
        // $this->dispatchBrowserEvent('edit_penerima');
        // session()->flash('success', 'Berita Acara Berhasil Diubah');

        $this->emit('dataTersimpanLpj');
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('alert_lpj', 'Berhasil Menambah Data Berita Acara');
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
