<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Programs;
use App\Models\ProgramPilar;
use App\Models\Rekening;
use App\Models\ArusDana;
use App\Models\Pengajuan;
use App\Models\PengajuanDetail;
use App\Models\Berita;
use App\Models\PengajuanPenerima;
use App\Models\PengajuanKegiatan;
use App\Models\PengajuanDokumentasi;
use App\Models\ProgramKegiatan;
use App\Models\PengajuanPengeluaran;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

use Livewire\Component;

class DetailUpzis extends Component
{
    use WithFileUploads;
    public $a = '';
    public $gocap;
    public $etasyaruf;
    public $siftnu;
    public $id_pengajuan;
    public $jumlah_nominal_a;
    public $jumlah_nominal_b;
    public $jumlah_nominal_c;
    public $rencana_a = [];
    public $rencana_b = [];
    public $rencana_c = [];

    // timeline
    public $color_tm1;
    public $color_tm2;
    public $color_tm3;
    public $color_tm4;
    public $color_tm5;
    public $judul_tm;
    public $baris1_tm;
    public $baris2_tm;

    // tambah rencana
    public $daftar_petugas = [];
    public $petugas;
    public $tgl_pelaksanaan;
    public $tgl_setor;
    public $pengajuan_note;
    public $daftar_program = [];
    public $daftar_kegiatan = [];
    public $daftar_kegiatan2 = [];
    public $daftar_pilar = [];
    public $daftar_rekening = [];
    public $id_program;
    public $id_program_pilar;
    public $id_program_kegiatan;
    public $nama_penerima;
    public $jumlah_penerima;
    public $satuan_pengajuan;
    public $nominal_pengajuan;


    // edit rencana
    public $edit_petugas;
    public $edit_tgl_pelaksanaan;
    public $edit_tgl_setor;
    // public $edit_id_program;
    // public $edit_id_program_pilar;
    public $edit_id_program_kegiatan;
    public $edit_daftar_pilar = [];
    public $edit_daftar_kegiatan = [];
    public $edit_daftar_kegiatan2 = [];
    public $edit_nama_penerima;
    public $edit_jumlah_penerima;
    public $edit_satuan_pengajuan;
    public $edit_nominal_pengajuan;
    public $edit_pengajuan_note;
    public $edit_id_rekening;
    public $programId;
    public $pilarId;


    // detail rencana
    public $id_pengajuan_detail;
    public $detail_a = [];
    public $none_block_acc = 'none';
    public $none_block_cair = 'none';
    public $none_block_tolak = 'none';


    // persetujuan lazisnu
    public $approval_date;
    public $approval_note;
    public $approver_tingkat_pc;
    public $satuan_disetujui;
    public $nominal_disetujui;
    public $rekening = [];
    public $id_rekening;
    public $saldo;
    public $nama_bmt;

    // penolakan lazisnu
    public $denial_date;
    public $denial_note;

    // pencairan
    public $tgl_pencairan;
    public $satuan_pencairan;
    public $nominal_pencairan;
    public $pencairan_note;

    // daftar penerima manfaat
    public $autofocus;
    public $id_pengajuan_penerima;
    public $penerima = [];
    public $nama;
    public $alamat;
    public $nominal_bantuan;
    public $keterangan;

    // kegiatan
    public $none_block_kegiatan = 'none';
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
    public $pengeluaran = [];
    public $judul_pengeluaran;
    public $jumlah_pengeluaran;
    public $nominal_pengeluaran;
    public $tgl_pengeluaran;
    public $nota_pengeluaran;
    public $pengeluaran_nominal_pencairan;
    public $dana_digunakan;
    public $status_rekomendasi;
    public $pencairan_status;


    // acc rekomendasi
    public $tgl_terbit_rekomendasi;
    public $total_kelembagaan;
    public $total_program_sosial;
    public $total_operasional_upzis;
    public $total_a;
    public $respon_a;
    public $total_b;
    public $respon_b;
    public $total_c;
    public $respon_c;
    public $file_scan_rekomendasi;
    public $nama_bmt2;


    // konfirmasi pengajuan
    public $file_scan;


    // berita
    public $none_block_berita = 'none';
    public $none_block_terbit = 'none';
    public $berita = [];
    public $id_pengajuan_berita;
    public $file_berita;
    public $file_berita_baru;
    public $tgl_terbit_berita;
    public $judul_berita;
    public $narasi_berita;
    public $narasi_berita2;
    public $pewarta_pc;
    // public $pewarta_upzis;
    public $status_kegiatan;

    public $selectedProgram;
    public $selectedProgramEdit;
    public $id_rekening2;


    public $bmts = [];

    public function getNamaBmtByIdRekening($id)
    {
        $data = DB::table($this->gocap . '.rekening')->where('id_rekening', $id)
            ->join($this->gocap . '.bmt', $this->gocap . '.bmt.id_bmt', '=', $this->gocap . '.rekening.id_bmt')->pluck('nama_bmt')
            ->first() ?? NULL;
        return $data;
    }

    public function countProgramByIdRekening($id)
    {
        $data = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('id_rekening', $id)->count('id_pengajuan_detail');

        return $data ?? NULL;
    }


    public function updatedSelectedProgram($value)
    {
        $this->id_program_kegiatan = $value;
        // Lakukan tindakan lain yang diperlukan dengan nilai yang dipilih
    }

    public function updatedSelectedProgramEdit($value)
    {
        $this->edit_id_program_kegiatan = $value;
        // Lakukan tindakan lain yang diperlukan dengan nilai yang dipilih
    }

    public function mount()
    {
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');
        // $this->timeline();
        // $this->modal_rencana_detail('1');
        $this->tgl_pelaksanaan = date('Y-m-d');
        $this->tgl_pencairan = date('Y-m-d');
        $this->tgl_terbit_rekomendasi = date('Y-m-d');
        // $this->detail_a = NULL;
        // $this->selectedProgram = 'wd';


    }

    public function render()
    {

        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {

            $data = Pengajuan::where('id_pengajuan', $this->id_pengajuan)->first();
            $tingkat = $data->tingkat;
            // dd($tingkat);

            if ($tingkat == 'Upzis MWCNU') {
                $this->daftar_petugas = DB::table($this->gocap . '.upzis_pengurus')
                    ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $this->gocap . '.upzis_pengurus.id_upzis_pengurus')
                    ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.upzis_pengurus.id_pengurus_jabatan')
                    ->select(
                        $this->siftnu . '.pengguna.nama',
                        $this->gocap . '.upzis_pengurus.id_upzis_pengurus',
                        $this->gocap . '.pengurus_jabatan.jabatan',
                    )
                    ->where($this->gocap . '.upzis_pengurus.id_upzis',  Auth::user()->UpzisPengurus->Upzis->id_upzis)
                    ->get();
                $this->daftar_program = Programs::orderBy('created_at', 'DESC')->get();
            }

            if ($tingkat == 'Ranting NU') {
                $this->daftar_petugas = DB::table($this->gocap . '.ranting_pengurus')
                    ->join($this->gocap . '.ranting', $this->gocap . '.ranting.id_ranting', '=', $this->gocap . '.ranting_pengurus.id_ranting')
                    ->where($this->gocap . '.ranting.id_upzis',  Auth::user()->UpzisPengurus->Upzis->id_upzis)
                    ->where($this->gocap . '.ranting.id_ranting',  $data->id_ranting)
                    ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_ranting_pengurus', '=', $this->gocap . '.ranting_pengurus.id_ranting_pengurus')
                    ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.ranting_pengurus.id_pengurus_jabatan')
                    ->select(
                        $this->siftnu . '.pengguna.nama',
                        $this->gocap . '.ranting_pengurus.id_ranting_pengurus',
                        $this->gocap . '.ranting.id_upzis',
                        $this->gocap . '.pengurus_jabatan.jabatan',
                    )
                    ->get();
                $this->daftar_program = Programs::orderBy('created_at', 'DESC')
                    ->whereNotIn('id_program', ['c51700b1-81a8-11ed-b4ef-dc215c5aad51'])
                    ->get();
            }

            // dd($this->daftar_petu)

            $this->daftar_pilar = ProgramPilar::where('id_program', $this->id_program)->orwhere('id_program2', $this->id_program)->orderBy('pilar', 'ASC')->get();
            $this->daftar_kegiatan = ProgramKegiatan::where('id_program_pilar', $this->id_program_pilar)
                ->whereRaw('LENGTH(no_urut) = 3')
                ->orderBy('no_urut', 'ASC')->get();
            $this->daftar_kegiatan2 = ProgramKegiatan::where('id_program_pilar', $this->id_program_pilar)
                ->whereRaw('LENGTH(no_urut) = 4')
                ->orderBy('no_urut', 'ASC')->get();
            // $this->daftar_kegiatan2 = ProgramKegiatan::where('id_program_pilar', $this->id_program_pilar)->orderBy('no_urut', 'ASC')->get();

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


            // // rekening
            // $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

            // if ($data->tingkat == 'Upzis MWCNU') {


            //     if ($this->id_program == 'ba84d782-81a8-11ed-b4ef-dc215c5aad51') {
            //         $rekening = Rekening::where('id_upzis', $data->id_upzis)
            //             ->where('id_ranting', NULL)
            //             ->where('nama_rekening', 'DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
            //             ->first();
            //         if ($rekening != null) {
            //             $this->id_rekening = $rekening->id_rekening;
            //         } else {
            //             session()->flash('alert_rencana', 'Rekening DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)) . ' Belum Ada!');
            //             return;
            //         }
            //     }

            //     // SOSIAL
            //     if ($this->id_program == 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51') {

            //         $rekening = Rekening::where('id_upzis', $data->id_upzis)
            //             ->where('id_ranting', NULL)
            //             ->where('nama_rekening', 'PROGRAM SOSIAL UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
            //             ->first();
            //         if ($rekening != null) {
            //             $this->id_rekening = $rekening->id_rekening;
            //         } else {

            //             session()->flash('alert_rencana', 'Rekening PROGRAM SOSIAL UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)) . ' Belum Ada!');
            //             return;
            //         }
            //     }

            //     // DANA OPERASIONAL
            //     if ($this->id_program == 'c51700b1-81a8-11ed-b4ef-dc215c5aad51') {

            //         $rekening = Rekening::where('id_upzis', $data->id_upzis)
            //             ->where('id_ranting', NULL)
            //             ->where('nama_rekening', 'DANA OPERASIONAL & UJROH UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
            //             ->first();
            //         if ($rekening != null) {
            //             $this->id_rekening = $rekening->id_rekening;
            //         } else {
            //             $this->emit('waktu_alert');
            //             session()->flash('alert_rencana', 'Rekening DANA OPERASIONAL & UJROH UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)) . ' Belum Ada!');
            //             return;
            //         }
            //     }
            // }

            // // RANTING
            // if ($data->tingkat == 'Ranting NU') {

            //     // $this->rekening = Rekening::where('id_ranting', $data->id_ranting)
            //     //     // ->where('nama_rekening', 'GOCAP PRNU ' . strtoupper($this->nama_ranting_rekening($data->id_ranting)))
            //     //     ->first();

            //     $cek_rekening = Rekening::where('id_ranting', $data->id_ranting)
            //         ->count();
            //     if ($cek_rekening > 1) {
            //         $this->daftar_rekening = Rekening::where('id_ranting', $data->id_ranting)->get();
            //     } else {
            //         $this->daftar_rekening = NULL;
            //         $rekening = Rekening::where('id_ranting', $data->id_ranting)
            //             ->first();

            //         if ($rekening != null) {
            //             $this->id_rekening = $rekening->id_rekening;
            //         } else {
            //             session()->flash('alert_rencana', 'Rekening ' . $this->nama_ranting_rekening($data->id_ranting) . ' Belum Ada!');
            //             $this->emit('waktu_alert');
            //             // return;
            //         }
            //         // // NAMA BMT
            //         // $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();
            //         // if ($bmt == NULL) {
            //         //     $this->nama_bmt = 'BMT Belum Ada';
            //         // } else {
            //         //     $this->nama_bmt = $bmt->nama_bmt;
            //         // }
            //     }
            // }
            // // $this->tambah_rencana();

        }





        $this->edit_daftar_pilar = ProgramPilar::where('id_program', $this->programId)->orwhere('id_program2', $this->programId)->orderBy('pilar', 'ASC')->get();

        $this->edit_daftar_kegiatan = ProgramKegiatan::where('id_program_pilar', $this->pilarId)
            ->whereRaw('LENGTH(no_urut) = 3')
            ->orderBy('no_urut', 'ASC')->get();
        $this->edit_daftar_kegiatan2 = ProgramKegiatan::where('id_program_pilar', $this->pilarId)
            ->whereRaw('LENGTH(no_urut) = 4')
            ->orderBy('no_urut', 'ASC')->get();

        // perhitungan edit nominal total
        if ($this->edit_jumlah_penerima == '') {
            $this->edit_jumlah_penerima = NULL;
        }
        if ($this->edit_satuan_pengajuan == '') {
            $this->edit_satuan_pengajuan = NULL;
        }
        if ($this->edit_jumlah_penerima != NULL or $this->edit_satuan_pengajuan != NULL) {
            $a = str_replace('.', '', $this->edit_jumlah_penerima);
            $b = str_replace('.', '', $this->edit_satuan_pengajuan);
            $this->edit_nominal_pengajuan = (int)$a * (int)$b;
        }



        // rekening
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

        if ($data->tingkat == 'Upzis MWCNU') {


            if ($this->id_program == 'ba84d782-81a8-11ed-b4ef-dc215c5aad51') {
                $rekening = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->first();
                if ($rekening != null) {
                    $this->id_rekening = $rekening->id_rekening;
                } else {
                    session()->flash('alert_rencana', 'Rekening DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)) . ' Belum Ada!');
                    // return;
                }
            }

            // SOSIAL
            if ($this->id_program == 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51') {

                $rekening = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'PROGRAM SOSIAL UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->first();
                if ($rekening != null) {
                    $this->id_rekening = $rekening->id_rekening;
                } else {

                    session()->flash('alert_rencana', 'Rekening PROGRAM SOSIAL UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)) . ' Belum Ada!');
                    // return;
                }
            }

            // DANA OPERASIONAL
            if ($this->id_program == 'c51700b1-81a8-11ed-b4ef-dc215c5aad51') {

                $rekening = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'DANA OPERASIONAL & UJROH UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->first();
                if ($rekening != null) {
                    $this->id_rekening = $rekening->id_rekening;
                } else {
                    $this->emit('waktu_alert');
                    session()->flash('alert_rencana', 'Rekening DANA OPERASIONAL & UJROH UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)) . ' Belum Ada!');
                    // return;
                }
            }
        }


        if ($data->tingkat == 'Upzis MWCNU') {

            if ($this->programId == 'ba84d782-81a8-11ed-b4ef-dc215c5aad51') {
                $rekening_edit = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->first();

                if ($rekening_edit != null) {
                    $this->edit_id_rekening = $rekening_edit->id_rekening;
                } else {
                    $this->emit('waktu_alert');

                    session()->flash('alert_rencana', 'Rekening DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)) . ' Belum Ada!');
                    // return;
                }
            }

            // SOSIAL
            if ($this->programId == 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51') {

                $rekening_edit = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'PROGRAM SOSIAL UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->first();
                if ($rekening_edit != null) {
                    $this->edit_id_rekening = $rekening_edit->id_rekening;
                } else {
                    $this->emit('waktu_alert');

                    session()->flash('alert_rencana', 'Rekening PROGRAM SOSIAL UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)) . ' Belum Ada!');
                    // return;
                }
            }

            // DANA OPERASIONAL
            if ($this->programId == 'c51700b1-81a8-11ed-b4ef-dc215c5aad51') {

                $rekening_edit = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'DANA OPERASIONAL & UJROH UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->first();
                if ($rekening_edit != null) {
                    $this->edit_id_rekening = $rekening_edit->id_rekening;
                } else {
                    $this->emit('waktu_alert');
                    session()->flash('alert_rencana', 'Rekening DANA OPERASIONAL & UJROH UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)) . ' Belum Ada!');
                    // return;
                }
            }
        }



        // RANTING
        if ($data->tingkat == 'Ranting NU') {

            // $this->rekening = Rekening::where('id_ranting', $data->id_ranting)
            //     // ->where('nama_rekening', 'GOCAP PRNU ' . strtoupper($this->nama_ranting_rekening($data->id_ranting)))
            //     ->first();

            $cek_rekening = Rekening::where('id_ranting', $data->id_ranting)
                ->count();


            if ($cek_rekening > 0) {
                $rekening = Rekening::where('id_ranting', $data->id_ranting)
                    ->first();
                if ($rekening != null) {
                    $this->id_rekening = $rekening->id_rekening;
                } else {
                    $this->emit('waktu_alert');
                    session()->flash('alert_rencana', 'Rekening ' . $this->nama_ranting_rekening($data->id_ranting) . ' Belum Ada!');
                    // return;
                }
            }
        }
        // $this->tambah_rencana();




        $this->tab_a();
        $this->tab_c();

        // $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

        // PERSETUJUAN LAZISNU (MODAL DETAIL)
        $detail_a = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        if ($this->id_pengajuan_detail != NULL) {
            $this->nominal_disetujui = number_format((int)str_replace('.', '', $this->satuan_disetujui) * $detail_a->jumlah_penerima, 0, '.', '.');
            $this->nominal_pencairan = number_format((int)str_replace('.', '', $this->satuan_pencairan) * $detail_a->jumlah_penerima, 0, '.', '.');
            if ($this->id_rekening != NULL) {
                $a =  Rekening::where('id_rekening', $this->id_rekening)->first();
                $this->saldo = number_format($a->saldo, 0, '.', '.');
            } else {
                $this->saldo = '-';
            }
        }



        // DAFTAR PENERIMA MANFAAT (MODAL DETAIL)
        if ($this->id_pengajuan_detail != NULL) {
            $this->penerima = PengajuanPenerima::where('id_pengajuan', $this->id_pengajuan)->where('id_pengajuan_detail', $this->id_pengajuan_detail)
                ->orderBy('created_at', 'DESC')->get();
        }

        if ($data->tingkat == 'Upzis MWCNU') {
            $this->daftar_rekening = Rekening::where('id_upzis', $data->id_upzis)->get();
        }
        if ($data->tingkat == 'Ranting NU') {
            $this->daftar_rekening = Rekening::where('id_ranting', $data->id_ranting)->get();
        }

        $this->bmts = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)->where('pencairan_status', 'Berhasil Dicairkan')->groupBy('id_rekening')->get();


        // BERITA
        $this->berita = Berita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        return view('livewire.detail-upzis', compact(
            'data',

        ));
    }

    public function tambah_ubah_berita_upzis_ranting()
    {
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();


        $a = Berita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        if ($a) {
            return redirect('/upzis/arsip/detail_berita/' . $a->id_berita_umum);
        } else {
            $id_berita_umum = uniqid();
            if ($data->tingkat == 'Upzis MWCNU') {
                Berita::create([
                    'id_berita_umum' =>  $id_berita_umum,
                    'status' => 'Belum Diinput',
                    'id_pc' => $data->id_pc,
                    'id_upzis' => $data->id_upzis,
                    'id_ranting' => $data->id_ranting,
                    'id_pengajuan' => $this->id_pengajuan,
                    'id_pengajuan_detail' => $this->id_pengajuan_detail,
                    'kategori_berita' => 'Upzis MWCNU',
                ]);
            }

            if ($data->tingkat == 'Ranting NU') {
                Berita::create([
                    'id_berita_umum' =>  $id_berita_umum,
                    'status' => 'Belum Diinput',
                    'id_pc' => $data->id_pc,
                    'id_upzis' => $data->id_upzis,
                    'id_ranting' => $data->id_ranting,
                    'id_pengajuan' => $this->id_pengajuan,
                    'id_pengajuan_detail' => $this->id_pengajuan_detail,
                    'kategori_berita' => 'Ranting NU',
                ]);
            }


            return redirect('/upzis/arsip/detail_berita/' .  $id_berita_umum);
        }
    }

    public function tab_a()
    {
        $id_program_a = 'ba84d782-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_b = 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_c = 'c51700b1-81a8-11ed-b4ef-dc215c5aad51';

        // PROGRAM PENGUATAN KELEMBAGAAN
        $this->rencana_a = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program_a)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $this->jumlah_nominal_a = $this->rencana_a->sum('nominal_pengajuan');

        // PROGRAM SOSIAL
        $this->rencana_b = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program_b)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $this->jumlah_nominal_b = $this->rencana_b->sum('nominal_pengajuan');


        // OPERASIONAL UPZIS
        $this->rencana_c = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program_c)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $this->jumlah_nominal_c = $this->rencana_c->sum('nominal_pengajuan');
    }

    public function tab_c()
    {
        $id_program_a = 'ba84d782-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_b = 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_c = 'c51700b1-81a8-11ed-b4ef-dc215c5aad51';



        // REKOMENDASI
        $this->modal_pengajuan_rekomendasi($this->id_pengajuan);

        // KELEMBAGAAN
        $this->total_a = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)->where('id_program', $id_program_a)->count();
        $a = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_a)
            ->where('approval_status', 'Disetujui')
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_a)
            ->count();
        $a2 = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_a)
            ->where('approval_status', 'Ditolak')
            ->where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_a)
            ->count();
        $this->respon_a = $a + $a2;

        // PROGRAM SOSIAL
        $this->total_b = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)->where('id_program', $id_program_b)->count();
        $b = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_b)
            ->where('approval_status', 'Disetujui')
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_b)
            ->count();
        $b2 = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_b)
            ->where('approval_status', 'Ditolak')
            ->where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_b)
            ->count();
        $this->respon_b = $b + $b2;

        // OPERASIONAL UPZIS
        $this->total_c = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)->where('id_program', $id_program_c)->count();
        $c = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_c)
            ->where('approval_status', 'Disetujui')
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_c)
            ->count();
        $c2 = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_c)
            ->where('approval_status', 'Ditolak')
            ->where('id_pengajuan', $this->id_pengajuan)
            ->where('id_program', $id_program_c)
            ->count();
        $this->respon_c = $c + $c2;

        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

        $a = Rekening::where('id_upzis', $data->id_upzis)
            ->where('id_ranting', NULL)
            ->where('nama_rekening', 'DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
            ->first();
        if ($a == NULL) {
            $this->nama_bmt2 = 'BMT Belum Ada';
        } else {
            $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $a->id_bmt)->first();
            $this->nama_bmt2 = $bmt->nama_bmt;
        }
    }


    // public function timeline()
    // {
    //     $this->timeline1();
    //     $this->timeline2();
    //     $this->timeline3();
    // }

    // public function timeline1()
    // {
    //     $this->color_tm1 = 'bg-success';
    //     $this->judul_tm = '1. Data Pengajuan';
    //     $this->baris1_tm = 'Pengajuan berhasil diajukan, silahkan lanjut ke langkah berikutnya';
    // }

    // public function timeline2()
    // {
    //     $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

    //     $this->judul_tm = '2. Konfirmasi Pengajuan';
    //     if ($data->status_pengajuan == 'Direncanakan') {
    //         $this->color_tm2 = 'bg-warning';
    //         // $this->baris1_tm = 'Menunggu konfirmasi pengajuan oleh : ' . $this->nama_pengurus($data->maker_tingkat_upzis) . ' (' . $this->jabatan_pengurus($data->maker_tingkat_upzis) . ')';
    //         $this->baris1_tm = 'Menunggu konfirmasi pengajuan oleh Pengurus ' . $this->nama_upzis($data->id_upzis);
    //     } elseif ($data->status_pengajuan == 'Diajukan') {
    //         $this->color_tm2 = 'bg-success';
    //         // $this->baris1_tm = 'Berhasil dikonfirmasi pengajuan oleh : ' . $this->nama_pengurus($data->maker_tingkat_upzis) . ' (' . $this->jabatan_pengurus($data->maker_tingkat_upzis) . ')';
    //         $this->baris1_tm = 'Berhasil dikonfirmasi pengajuan  oleh Pengurus ' . $this->nama_upzis($data->id_upzis);
    //     }
    // }

    // public function timeline3()
    // {
    //     $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
    //     if ($data->status_pengajuan == 'Diajukan') {
    //         $this->judul_tm = '3. Rekomendasi';
    //         if ($data->status_rekomendasi == 'Belum Terbit') {
    //             $this->color_tm3 = 'bg-warning';
    //             $this->baris1_tm = 'Menunggu rekomendasi dari PC';
    //         } elseif ($data->status_rekomendasi == 'Sudah Terbit') {
    //             $this->color_tm3 = 'bg-success';
    //             $this->baris1_tm = 'Silahkan download rekomendasi';
    //         }
    //     }
    // }

    public function modal_rencana_tambah()
    {

        $this->petugas = NULL;
        $this->tgl_pelaksanaan = NULL;
        $this->tgl_setor = NULL;
        $this->id_program = NULL;
        $this->id_program_pilar = NULL;
        $this->id_program_kegiatan = NULL;
        $this->id_rekening = NULL;
        $this->nama_penerima = NULL;
        $this->jumlah_penerima = NULL;


        $this->satuan_pengajuan = NULL;
        $this->nominal_pengajuan = NULL;
        $this->pengajuan_note = NULL;

        $this->tgl_pelaksanaan = date('Y-m-d');

        $data = Pengajuan::where('id_pengajuan', $this->id_pengajuan)->first();

        if ($data->tingkat == 'Upzis MWCNU') {
            $a = DB::table($this->gocap . '.upzis_pengurus')
                ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $this->gocap . '.upzis_pengurus.id_upzis_pengurus')
                ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.upzis_pengurus.id_pengurus_jabatan')
                ->select(
                    $this->siftnu . '.pengguna.nama',
                    $this->gocap . '.upzis_pengurus.id_upzis_pengurus',
                    $this->gocap . '.pengurus_jabatan.jabatan',
                )
                ->where($this->gocap . '.upzis_pengurus.id_upzis',  Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->where($this->gocap . '.pengurus_jabatan.jabatan',  'Divisi Pentasyarufan')
                ->first();

            if ($a != NULL) {
                $this->petugas = $a->id_upzis_pengurus;
            }
        }
    }

    public function modal_rencana_acc()
    {
    }

    public function tambah_rencana()
    {
        $id_pengajuan_detail = Str::uuid()->toString();

        // dd($this->id_pengajuan);

        $tingkat = Pengajuan::where('id_pengajuan', $this->id_pengajuan)->first()->tingkat;
        if ($tingkat == 'Upzis MWCNU') {
            PengajuanDetail::create([
                'id_pengajuan_detail' =>  $id_pengajuan_detail,
                'id_pengajuan' => $this->id_pengajuan,
                'petugas_upzis' => $this->petugas,
                'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
                'tgl_setor' => $this->tgl_setor,
                'pengajuan_note' => $this->pengajuan_note,
                'id_program' => $this->id_program,
                'id_program_pilar' => $this->id_program_pilar,
                'id_program_kegiatan' => $this->id_program_kegiatan,
                'nama_penerima' => $this->nama_penerima,
                'jumlah_penerima' => $this->jumlah_penerima,
                'satuan_pengajuan' => str_replace('.', '', $this->satuan_pengajuan),
                // 'satuan_disetujui' => str_replace('.', '', $this->satuan_pengajuan),
                'nominal_pengajuan' => $this->nominal_pengajuan,
                'pencairan_status' => 'Belum Dicairkan',
                // 'id_rekening' => $this->id_rekening,
                // 'nominal_disetujui' => $this->nominal_pengajuan,
                'approval_status' => 'Belum Direspon',
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
                // 'id_rekening' => $this->id_rekening,
            ]);
        } else {
            PengajuanDetail::create([
                'id_pengajuan_detail' =>  $id_pengajuan_detail,
                'id_pengajuan' => $this->id_pengajuan,
                'petugas_ranting' => $this->petugas,
                'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
                'tgl_setor' => $this->tgl_setor,
                'pengajuan_note' => $this->pengajuan_note,
                'id_program' => $this->id_program,
                'id_program_pilar' => $this->id_program_pilar,
                'id_program_kegiatan' => $this->id_program_kegiatan,
                'nama_penerima' => $this->nama_penerima,
                'jumlah_penerima' => $this->jumlah_penerima,
                'satuan_pengajuan' => str_replace('.', '', $this->satuan_pengajuan),
                // 'satuan_disetujui' => str_replace('.', '', $this->satuan_pengajuan),
                'nominal_pengajuan' => $this->nominal_pengajuan,
                'pencairan_status' => 'Belum Dicairkan',
                // 'id_rekening' => $this->id_rekening,
                // 'nominal_disetujui' => $this->nominal_pengajuan,
                'approval_status' => 'Belum Direspon',
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
                // 'id_rekening' => $this->id_rekening,
            ]);
        }

        $this->petugas = NULL;
        $this->tgl_pelaksanaan = NULL;
        $this->tgl_setor = NULL;
        $this->id_program = NULL;
        $this->id_program_pilar = NULL;
        $this->id_program_kegiatan = NULL;
        $this->id_rekening = NULL;
        $this->nama_penerima = NULL;
        $this->jumlah_penerima = NULL;

        $this->updatedSelectedProgram(null);

        $this->satuan_pengajuan = NULL;
        $this->nominal_pengajuan = NULL;
        $this->pengajuan_note = NULL;

        $this->tgl_pelaksanaan = date('Y-m-d');
        $this->emit('waktu_alert');
        // $this->dispatchBrowserEvent('tambah_rencana');
        return redirect()->to('upzis/detail-pengajuan-upzis/' . $this->id_pengajuan)->with('success', 'Rencana Pentasyarufan Berhasil Ditambah!');
        // $this->dispatchBrowserEvent('berhasil_ubah_rencana');
        // $this->modal_rencana_detail($id_pengajuan_detail);
    }

    public function modal_rencana_ubah($id_pengajuan_detail)
    {
        $this->dispatchBrowserEvent('ubah_rencana');
        $data = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->first();
        $data2 = Pengajuan::where('id_pengajuan', $data->id_pengajuan)->first();

        if ($data2->tingkat == 'Upzis MWCNU') {
            $this->edit_petugas = $data->petugas_upzis;
        }

        if ($data2->tingkat == 'Ranting NU') {
            $this->edit_petugas = $data->petugas_ranting;
        }


        $this->edit_tgl_pelaksanaan = $data->tgl_pelaksanaan;
        $this->edit_tgl_setor = $data->tgl_setor;
        // $this->id_program = $data->id_program;
        $this->programId = $data->id_program;
        $this->pilarId = $data->id_program_pilar;
        $this->edit_id_program_kegiatan = $data->id_program_kegiatan;
        $this->edit_nama_penerima = $data->nama_penerima;
        $this->edit_jumlah_penerima = $data->jumlah_penerima;
        $this->edit_satuan_pengajuan = number_format($data->satuan_pengajuan, 0, ',', '.');
        $this->edit_pengajuan_note = $data->pengajuan_note;

        // $this->modal_rencana_detail($id_pengajuan_detail);
    }

    public function ubah_rencana($id_pengajuan_detail)
    {
        $data = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->first();
        $data2 = Pengajuan::where('id_pengajuan', $data->id_pengajuan)->first();


        if ($data2->tingkat == 'Upzis MWCNU') {
            PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->update([
                'petugas_upzis' => $this->edit_petugas,
                'tgl_pelaksanaan' => $this->edit_tgl_pelaksanaan,
                'tgl_setor' => $this->edit_tgl_setor,
                'id_program' => $this->programId,
                'id_program_pilar' => $this->pilarId,
                'id_program_kegiatan' => $this->edit_id_program_kegiatan,
                'nominal_pengajuan' => $this->edit_nominal_pengajuan,

                'nama_penerima' => $this->edit_nama_penerima,
                'jumlah_penerima' => $this->edit_jumlah_penerima,
                'satuan_pengajuan' => str_replace('.', '', $this->edit_satuan_pengajuan),
                'pengajuan_note' => $this->edit_pengajuan_note,
                // 'id_rekening' => $this->edit_id_rekening,
            ]);
        }

        if ($data2->tingkat == 'Ranting NU') {
            PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->update([
                'petugas_ranting' => $this->edit_petugas,
                'tgl_pelaksanaan' => $this->edit_tgl_pelaksanaan,
                'tgl_setor' => $this->edit_tgl_setor,
                'id_program' => $this->programId,
                'id_program_pilar' => $this->pilarId,
                'id_program_kegiatan' => $this->edit_id_program_kegiatan,
                'nominal_pengajuan' => $this->edit_nominal_pengajuan,

                'nama_penerima' => $this->edit_nama_penerima,
                'jumlah_penerima' => $this->edit_jumlah_penerima,
                'satuan_pengajuan' => str_replace('.', '', $this->edit_satuan_pengajuan),
                'pengajuan_note' => $this->edit_pengajuan_note,
                // 'id_rekening' => $this->edit_id_rekening,
            ]);
        }


        // dd($this->edit_id_program);


        $this->emit('waktu_alert');
        return redirect()->to('upzis/detail-pengajuan-upzis/' . $this->id_pengajuan)->with('success', 'Rencana Pentasyarufan Berhasil Diubah!');
        $this->dispatchBrowserEvent('berhasil_ubah_rencana');
        $this->modal_rencana_detail($id_pengajuan_detail);
        // session()->flash('alert_rencana', 'Rencana Pentasyarufan Berhasil Diubah');

    }


    public function modal_hapus_rencana($id_pengajuan_detail)
    {
        $this->id_pengajuan_detail = $id_pengajuan_detail;
    }

    public function hapus_rencana()
    {
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->delete();
        // PengajuanPenerima::where('id_pengajuan_detail', $this->id_pengajuan_detail)->delete();
        $this->id_pengajuan_detail = NULL;
        // $this->dispatchBrowserEvent('berhasil_hapus_rencana');
        // $this->emit('waktu_alert');
        // // PengajuanDetail::make();
        // session()->flash('alert_rencana_hapus', 'Rencana Pentasyarufan Berhasil Dihapus');

        // $this->render();
        // $this->reset();

        return redirect()->to('upzis/detail-pengajuan-upzis/' . $this->id_pengajuan)->with('success', 'Rencana Pentasyarufan berhasil dihapus!');;
    }

    public function updatedprogramId()
    {
        $this->pilarId = NULL;
    }

    public function updatedpilarId()
    {
        $this->edit_id_program_kegiatan = NULL;
    }





    public function tambah_ubah_penerima()
    {
        // TAMBAH
        if ($this->id_pengajuan_penerima == NULL) {
            $id_pengajuan_penerima = Str::uuid()->toString();
            PengajuanPenerima::create([
                'id_pengajuan_penerima' => $id_pengajuan_penerima,
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
                'keterangan' => $this->keterangan,
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
            ]);
            $this->nama = '';
            $this->alamat = '';
            $this->nominal_bantuan = '';
            $this->keterangan = '';
            $this->autofocus = 'autofocus';
            session()->flash('alert_penerima', 'Penerima Manfaat Berhasil Ditambahkan');
            $this->emit('waktu_alert');
        }
        // UBAH
        else {
            $id_pengajuan_penerima = Str::uuid()->toString();
            PengajuanPenerima::where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->update([
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
                'keterangan' => $this->keterangan,
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
            ]);

            $this->id_pengajuan_penerima = NULL;
            $this->nama = '';
            $this->alamat = '';
            $this->nominal_bantuan = '';
            $this->keterangan = '';

            session()->flash('alert_penerima', 'Penerima Manfaat Berhasil Diubah');
            $this->emit('waktu_alert');
        }
    }


    public function modal_rencana_detail($id_pengajuan_detail)
    {

        // $this->id_pengajuan_detail = NULL;
        $this->id_pengajuan_detail = $id_pengajuan_detail;
        $this->none_block_acc = 'none';
        $this->none_block_tolak = 'none';

        // RENCANA PENTASYARUFAN
        $this->detail_a = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->first();
        // dd($this->detail_a);
        $detail_a = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->first();

        // dd($detail_a);
        // PERSETUJUAN LAZISNU
        $this->approval_date = date('Y-m-d');
        $this->approval_note = $detail_a->approval_note;
        $this->id_rekening = '';
        $this->jumlah_penerima = $this->detail_a->jumlah_penerima;
        $this->satuan_disetujui = number_format($this->detail_a->satuan_pengajuan, 0, '.', '.');
        $this->nominal_disetujui = (int)str_replace('.', '', $this->satuan_disetujui) * $this->detail_a->jumlah_penerima;
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

        // upzis
        if ($data->tingkat == 'Upzis MWCNU') {
            // KELEMBAGAAN
            if ($detail_a->id_program == 'ba84d782-81a8-11ed-b4ef-dc215c5aad51') {
                $this->rekening = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->get();
                $rekening = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'DANA KELEMBAGAAN UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->first();
                if ($rekening != null) {
                    $this->id_rekening = $rekening->id_rekening;
                } else {
                    $this->id_rekening = NULL;
                }
            }

            // SOSIAL
            if ($detail_a->id_program == 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51') {
                $this->rekening = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'PROGRAM SOSIAL UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->get();
                $rekening = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'PROGRAM SOSIAL UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->first();
                if ($rekening != null) {
                    $this->id_rekening = $rekening->id_rekening;
                } else {
                    $this->id_rekening = NULL;
                }
            }

            // DANA OPERASIONAL
            if ($detail_a->id_program == 'c51700b1-81a8-11ed-b4ef-dc215c5aad51') {
                $this->rekening = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'DANA OPERASIONAL & UJROH UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->get();
                $rekening = Rekening::where('id_upzis', $data->id_upzis)
                    ->where('id_ranting', NULL)
                    ->where('nama_rekening', 'DANA OPERASIONAL & UJROH UPZIS MWC NU ' . strtoupper($this->nama_wilayah($data->id_upzis)))
                    ->first();
                if ($rekening != null) {
                    $this->id_rekening = $rekening->id_rekening;
                    // NAMA BMT
                    $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();
                    if ($bmt == NULL) {
                        $this->nama_bmt = 'BMT Belum Ada';
                    } else {
                        $this->nama_bmt = $bmt->nama_bmt;
                    }
                } else {
                    $this->id_rekening = NULL;
                }
            }
        }

        // RANTING
        if ($data->tingkat == 'Ranting NU') {
            // $this->rekening = Rekening::where('id_ranting', $data->id_ranting)
            //     ->where('nama_rekening', 'GOCAP PRNU ' . strtoupper($this->nama_ranting_rekening($data->id_ranting)))
            //     ->get();
            $this->rekening = Rekening::where('id_ranting', $data->id_ranting)
                // ->where('nama_rekening', 'GOCAP PRNU ' . strtoupper($this->nama_ranting_rekening($data->id_ranting)))
                ->get();
            $rekening = Rekening::where('id_ranting', $data->id_ranting)
                // ->where('nama_rekening', 'GOCAP PRNU ' . strtoupper($this->nama_ranting_rekening($data->id_ranting)))
                ->first();

            if ($rekening != null) {
                $this->id_rekening = $rekening->id_rekening;
            } else {
                $this->id_rekening = NULL;
            }
        }
        // PENOLAKAN LAZISNU
        $this->denial_date = date('Y-m-d');
        $this->id_pengajuan_detail = $id_pengajuan_detail;
        // dd($this->id_pengajuan_detail);
    }

    public function acc()
    {
        $data =  PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'approval_date' =>  date('Y-m-d'),
            'approval_note' => $this->approval_note,
            'approval_status' => 'Disetujui',
            // 'id_rekening' => $this->id_rekening,
            'approver_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            'satuan_disetujui' => str_replace('.', '', $this->satuan_disetujui),
            'nominal_disetujui' => str_replace('.', '', $this->satuan_disetujui) * $data->jumlah_penerima,
        ]);

        $this->modal_rencana_detail($this->id_pengajuan_detail);
        session()->flash('alert_persetujuan', 'Rencana Pentasyarufan Berhasil Di ACC');
        $this->emit('waktu_alert');
    }

    public function cairkan()
    {
        // dd($this->id_pengajuan_detail);
        $data =  PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        $rekening = Rekening::where('id_rekening', $this->id_rekening2)->first();
        $saldo_sisa = $rekening->saldo - (str_replace('.', '', $this->satuan_disetujui) * $data->jumlah_penerima);
        // dd(str_replace('.', '', $this->satuan_pencairan) * $data->jumlah_penerima);
        // dd($data->id_rekening);
        Rekening::where('id_rekening', $this->id_rekening2)->update([
            'saldo' => $saldo_sisa
        ]);
        // dd(Rekening::where('id_rekening', $this->id_rekening2)->first());

        $dana = ArusDana::where('id_etasyaruf_permohonan_pentasyarufan_koin', $data->id_pengajuan_detail)->first();

        if ($dana) {
            // update
            $dana->where('id_etasyaruf_permohonan_pentasyarufan_koin', $data->id_pengajuan_detail)->update([
                'jenis_dana' => 'keluar',
                'jenis_kas' => 'Pentasyarufan Koin NU',
                'nominal' => str_replace('.', '', $this->satuan_pencairan) * $data->jumlah_penerima,
                'tanggal_input' => $this->tgl_pencairan,
                'petugas_input_pc' => Auth::user()->gocap_id_pc_pengurus,
                'id_etasyaruf_permohonan_pentasyarufan_koin' => $data->id_pengajuan_detail,
                'uraian' => $this->nama_kegiatan($data->id_program_kegiatan)
            ]);
        } else {
            // create
            $id_arus_dana = Str::uuid();
            ArusDana::create([
                'id_arus_dana' => $id_arus_dana,
                'id_rekening' => $this->id_rekening2,
                'jenis_dana' => 'keluar',
                'jenis_kas' => 'Pentasyarufan Koin NU',
                'nominal' => str_replace('.', '', $this->satuan_pencairan) * $data->jumlah_penerima,
                'tanggal_input' => $this->tgl_pencairan,
                'petugas_input_pc' => Auth::user()->gocap_id_pc_pengurus,
                'id_etasyaruf_permohonan_pentasyarufan_koin' => $data->id_pengajuan_detail,
                'uraian' => $this->nama_kegiatan($data->id_program_kegiatan)
            ]);
        }

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'id_rekening' => $this->id_rekening2,
            'tgl_pencairan' => $this->tgl_pencairan,
            'pencairan_status' => 'Berhasil Dicairkan',
            'staf_keuangan_pc' => Auth::user()->gocap_id_pc_pengurus,
            'satuan_pencairan' => str_replace('.', '', $this->satuan_pencairan),
            'nominal_pencairan' => str_replace('.', '', $this->satuan_pencairan) * $data->jumlah_penerima,
            'pencairan_note' => $this->pencairan_note,
        ]);

        $this->modal_rencana_detail($this->id_pengajuan_detail);
        session()->flash('alert_pencairan', 'Rencana Pentasyarufan Berhasil Di Cairkan');
        $this->emit('waktu_alert');
        $this->close();
    }

    public function nama_ranting($id)
    {
        $a = DB::table($this->gocap . '.ranting')->where('id_ranting', $id)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.ranting.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_ranting')
            ->first();
        return 'RANTING NU ' . $a->nama_ranting ?? '';
    }

    public function nama_ranting_rekening($id)
    {
        $a = DB::table($this->gocap . '.ranting')->where('id_ranting', $id)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.ranting.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_ranting')
            ->first();
        return $a->nama_ranting;
    }


    public function modal_pengajuan_rekomendasi($id_pengajuan)
    {


        $data = PengajuanDetail::where('id_program', 'ba84d782-81a8-11ed-b4ef-dc215c5aad51')->where('id_pengajuan', $id_pengajuan)
            ->orwhere('id_program', 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51')->where('id_pengajuan', $id_pengajuan)
            ->orwhere('id_program', 'c51700b1-81a8-11ed-b4ef-dc215c5aad51')->where('id_pengajuan', $id_pengajuan)
            ->first();
        if ($data != NULL) {
            $rekening = Rekening::where('id_rekening', $data->id_rekening)->first();

            $this->total_kelembagaan = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('id_program', 'ba84d782-81a8-11ed-b4ef-dc215c5aad51')
                ->sum('nominal_pencairan');

            $this->total_program_sosial = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('id_program', 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51')
                ->sum('nominal_pencairan');

            $this->total_operasional_upzis = PengajuanDetail::where('id_pengajuan', $id_pengajuan)->where('id_program', 'c51700b1-81a8-11ed-b4ef-dc215c5aad51')
                ->sum('nominal_pencairan');


            if ($rekening != NULL) {
                $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();
                if ($bmt == NULL) {
                    $this->nama_bmt = 'BMT Belum Ada';
                } else {
                    $this->nama_bmt = $bmt->nama_bmt;
                }
            }
        }
    }



    public function tolak()
    {

        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'denial_date' => $this->denial_date,
            'denial_note' => $this->denial_note,
            'approval_status' => 'Ditolak',
            'denial_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);
        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $data = Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        $url =  "https://e-tasyaruf.nucarecilacap.id";

        if ($data->tingkat == 'Upzis MWCNU') {
            // wa ke pj
            $this->notif(
                // nomor pj
                 $this->nohp_pengurus_upzis($data->maker_tingkat_upzis),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_upzis($data->maker_tingkat_upzis) .  "*" . "\n" .
                    $this->jabatan_pengurus_upzis($data->maker_tingkat_upzis) . "\n" . "\n" .

                    "Pengajuan Pentasyarufan Tingkat " . $this->nama_upzis($data->id_upzis) . ", " . "*" . "ditolak" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->maker_tingkat_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal"  . "*" .  "\n" .
                    'Rp' . number_format($data_detail->nominal_pengajuan, 0, '.', '.') . ',-' .  "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" .
                    "*" .  "Alasan Penolakan"  . "*" .  "\n" .
                    $data_detail->denial_note .  "\n" . "\n" .

                    "Harap revisi data pentasyarufan, Terimakasih." . "\n" . "\n" .
                    // "Lihat progres pengajuan pentasyarufan melalui E-TASYARUF. Terimakasih."  . "\n" .
                    url($url)
            );
        }

        if ($data->tingkat == 'Ranting NU') {
            // wa ke pj
            $this->notif(
                // nomor pj
                 $this->nohp_pengurus_upzis($data->maker_tingkat_upzis),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_upzis($data->maker_tingkat_upzis) .  "*" . "\n" .
                    $this->jabatan_pengurus_upzis($data->maker_tingkat_upzis) . "\n" . "\n" .

                    "Pengajuan Pentasyarufan Tingkat " . $this->nama_ranting($data->id_ranting) . ", " . "*" . "ditolak" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->maker_tingkat_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal"  . "*" .  "\n" .
                    'Rp' . number_format($data_detail->nominal_pengajuan, 0, '.', '.') . ',-' .  "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    "*" .  "Kegiatan"  . "*" .  "\n" .
                    $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" .
                    "*" .  "Alasan Penolakan"  . "*" .  "\n" .
                    $data_detail->denial_note .  "\n" . "\n" .

                    "Harap revisi data pentasyarufan, Terimakasih." . "\n" . "\n" .
                    // "Lihat progres pengajuan pentasyarufan melalui E-TASYARUF. Terimakasih."  . "\n" .
                    url($url)
            );
        }

        $this->modal_rencana_detail($this->id_pengajuan_detail);
        session()->flash('alert_persetujuan', 'Rencana Pentasyarufan Berhasil Ditolak');
        $this->emit('waktu_alert');
    }

    public function cek_kegiatan($id_pengajuan_detail)
    {
        $a =  PengajuanKegiatan::where('id_pengajuan_detail', $id_pengajuan_detail)->count();

        if ($a == 0) {
            return '0';
        } else {
            return '1';
        }
    }

    public function cek_berita($id_pengajuan_detail)
    {
        $a =  Berita::where('id_pengajuan_detail', $id_pengajuan_detail)->where('status', 'Sudah Terbit')->first();

        if ($a == NULL) {
            return 'Belum Terbit';
        } else {
            return 'Sudah Terbit';
        }
    }

    public function nama_pc($id)
    {
        $a = DB::table($this->gocap . '.pc')->where('id_pc', $id)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.pc.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_pc')
            ->first();
        $nama_pc_tanpa_titik = str_replace('. ', '', $a->nama_pc);
        $nama_pc_tanpa_kab = str_replace('KAB', '', $nama_pc_tanpa_titik);
        $a = strtolower($nama_pc_tanpa_kab);
        return 'Lazisnu ' .  ucfirst($a);
    }

    public function nama_rekening($id)
    {
        $a = Rekening::where('id_rekening', $id)->first();

        return  $a->nama_rekening;
    }

    public function no_rekening($id)
    {
        $a = Rekening::where('id_rekening', $id)->first();

        return  $a->no_rekening;
    }

    public function nama_kegiatan($id)
    {
        $a = ProgramKegiatan::where('id_program_kegiatan', $id)->first();

        return  $a->nama_program;
    }

    public function nama_pilar($id)
    {
        $a = ProgramPilar::where('id_program_pilar', $id)->first();

        return  $a->pilar;
    }


    public function nama_upzis($id)
    {
        $a = DB::table($this->gocap . '.upzis')->where('id_upzis', $id)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.upzis.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_upzis')
            ->first();

        return 'UPZIS MWCNU ' . $a->nama_upzis ?? '';
    }



    public function nama_wilayah($id)
    {
        $a = DB::table($this->gocap . '.upzis')->where('id_upzis', $id)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.upzis.id_wilayah')
            ->select($this->siftnu . '.wilayah.nama as nama_upzis')
            ->first();
        return  $a->nama_upzis;
    }

    public function nama_pengurus_upzis($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_upzis_pengurus', $id)
            ->first();

        if ($a == null) {
            $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_ranting_pengurus', $id)
                ->first();
        }
        return $a->nama ?? '';
    }

    public function jabatan_pengurus_upzis($id)
    {
        // dd($id);

        $a = DB::table($this->gocap . '.upzis_pengurus')->where('id_upzis_pengurus', $id)
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.upzis_pengurus.id_pengurus_jabatan')
            ->select(
                $this->gocap . '.pengurus_jabatan.jabatan'
            )->first();

        if ($a == NULL) {

            $a = DB::table($this->gocap . '.ranting_pengurus')->where('id_ranting_pengurus', $id)
                ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.ranting_pengurus.id_pengurus_jabatan')
                ->select(
                    $this->gocap . '.pengurus_jabatan.jabatan'
                )->first();
        }
        // dd($a->jabatan);
        return $a->jabatan ?? '';
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
        return $a->jabatan ?? '';
    }

    public function hydrate()
    {
        $this->emit('loadContactDeviceSelect2');
        $this->emit('select2');
    }

    public function tutup_modal()
    {
        $this->id_pengajuan_detail = NULL;
    }

    public function tombol_acc($id_pengajuan_detail)
    {
        $this->none_block_tolak = 'none';
        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->first();

        $this->approval_note = $data_detail->approval_note;

        if ($this->none_block_acc == 'none') {
            $this->none_block_acc = 'block';
        } elseif ($this->none_block_acc == 'block') {
            $this->none_block_acc = 'none';
        }
    }

    public function tombol_cair($id_pengajuan_detail)
    {

        $data_detail = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)->first();
        $this->satuan_pencairan = number_format($data_detail->satuan_disetujui ?? 0, 0, '.', '.');
        $this->pencairan_note = $data_detail->pencairan_note;

        if ($this->none_block_cair == 'none') {
            $this->none_block_cair = 'block';
        } elseif ($this->none_block_cair == 'block') {
            $this->none_block_cair = 'none';
        }
    }

    public function tombol_terbit()
    {

        if ($this->none_block_terbit == 'none') {
            $this->none_block_terbit = 'block';
        } elseif ($this->none_block_terbit == 'block') {
            $this->none_block_terbit = 'none';
        }
    }

    public function modal_rencana_kegiatan($id_pengajuan_detail)
    {
        $this->id_pengajuan_detail = $id_pengajuan_detail;
        $this->kegiatan = PengajuanKegiatan::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $kegiatan = PengajuanKegiatan::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        if ($kegiatan != NULL) {
            $this->tgl_kegiatan = $kegiatan->tgl_kegiatan;
            $this->lokasi = $kegiatan->lokasi;
            $this->judul = $kegiatan->judul;
            $this->jumlah_kehadiran = $kegiatan->jumlah_kehadiran;
            $this->kendala = $kegiatan->kendala;
            $this->ringkasan = $kegiatan->ringkasan;
        }

        $this->dokumentasi =  PengajuanDokumentasi::where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->orderBy('created_at', 'DESC')->get();
        $this->pengeluaran = PengajuanPengeluaran::where('id_pengajuan_detail', $this->id_pengajuan_detail)
            ->orderBy('created_at', 'DESC')->get();

        // PENGELUARAN
        $a = PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        $this->pengeluaran_nominal_pencairan = $a->nominal_pencairan;
        $this->pencairan_status = $a->pencairan_status;

        $c = Pengajuan::where('id_pengajuan', $a->id_pengajuan)->first();
        $this->status_rekomendasi = $c->status_rekomendasi;

        $b = PengajuanPengeluaran::where('id_pengajuan_detail', $this->id_pengajuan_detail)->sum('nominal_pengeluaran');
        $this->dana_digunakan = $b;

        // dd($this->nominal_disetujui);
    }

    public function tombol_ubah_detail_kegiatan()
    {
        $this->none_block_kegiatan = 'block';
    }

    public function tombol_batal_rencana()
    {
        $this->petugas = NULL;
        $this->tgl_pelaksanaan = NULL;
        $this->tgl_setor = NULL;
        $this->id_program = NULL;
        $this->id_program_pilar = NULL;
        $this->id_program_kegiatan = NULL;
        $this->nama_penerima = NULL;
        $this->jumlah_penerima = NULL;
        $this->satuan_pengajuan = NULL;
        $this->nominal_pengajuan = NULL;

        $this->tgl_pelaksanaan = date('Y-m-d');
    }



    public function tombol_batal_detail_kegiatan()
    {
        $this->none_block_kegiatan = 'none';
    }

    public function tombol_batal_detail_berita()
    {
        $this->none_block_berita = 'none';
        $this->file_berita = NULL;
    }

    public function ubah_kegiatan()
    {
        $this->none_block_kegiatan = 'none';
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();
        $data_detail = DB::table($this->etasyaruf . '.pengajuan_detail')->where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

        // dd($this->id_pengajuan_detail);
        PengajuanKegiatan::where('id_pengajuan_detail', $this->id_pengajuan_detail)->delete();
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
            'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
        ]);

        $url =  "https://e-tasyaruf.nucarecilacap.id";


        // divisi it dan media
        $it = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Divisi IT dan Media')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();
        // dd($c);

        if ($data->tingkat == 'Upzis MWCNU') {
            $this->notif(
                // nomor it dan media
                 $this->nohp_pengurus_pc($it->id_pc_pengurus),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($it->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($it->id_pc_pengurus) . "\n" . "\n" .

                    "*" .  "Mohon segera dibuat berita acara"  . "*" .  "\n" .
                    "Pengajuan Pentasyarufan Tingkat " . $this->nama_upzis($data->id_upzis) . ", " . "*" . "telah melaporkan kegiatan" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .

                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->pj_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    "*" .  "Program"  . "*" .  "\n" .
                    $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" .
                    "*" .  "Tanggal Kegiatan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($this->tgl_kegiatan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Lokasi Kegiatan"  . "*" .  "\n" .
                    $this->lokasi  . "\n" .
                    "*" .  "Judul Kegiatan"  . "*" .  "\n" .
                    $this->judul  . "\n" .
                    "*" .  "Jumlah Kehadiran"  . "*" .  "\n" .
                    $this->jumlah_kehadiran  . "\n" .
                    "*" .  "Kendala Kegiatan"  . "*" .  "\n" .
                    $this->kendala  . "\n" .
                    "*" .  "Ringkasan Kegiatan"  . "*" .  "\n" .
                    $this->ringkasan  . "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }

        if ($data->tingkat == 'Ranting NU') {
            $this->notif(
                // nomor it dan media
                 $this->nohp_pengurus_pc($it->id_pc_pengurus),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($it->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($it->id_pc_pengurus) . "\n" . "\n" .

                    "*" .  "Mohon segera dibuat berita acara"  . "*" .  "\n" .
                    "Pengajuan Pentasyarufan Tingkat " . $this->nama_ranting($data->id_ranting) . ", " . "*" . "telah melaporkan kegiatan" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .

                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->pj_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Pilar"  . "*" .  "\n" .
                    $this->nama_pilars($data_detail->id_program_pilar) .  "\n" .
                    "*" .  "Program"  . "*" .  "\n" .
                    $this->nama_kegiatan($data_detail->id_program_kegiatan) .  "\n" .
                    "*" .  "Tanggal Kegiatan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($this->tgl_kegiatan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Lokasi Kegiatan"  . "*" .  "\n" .
                    $this->lokasi  . "\n" .
                    "*" .  "Judul Kegiatan"  . "*" .  "\n" .
                    $this->judul  . "\n" .
                    "*" .  "Jumlah Kehadiran"  . "*" .  "\n" .
                    $this->jumlah_kehadiran  . "\n" .
                    "*" .  "Kendala Kegiatan"  . "*" .  "\n" .
                    $this->kendala  . "\n" .
                    "*" .  "Ringkasan Kegiatan"  . "*" .  "\n" .
                    $this->ringkasan  . "\n" . "\n" .

                    "Terima Kasih." . "\n" . "\n" .
                    url($url)
            );
        }


        session()->flash('alert_kegiatan', 'Kegiatan Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->modal_rencana_kegiatan($this->id_pengajuan_detail);
    }

    public function tombol_tolak()
    {
        $this->none_block_acc = 'none';

        if ($this->none_block_tolak == 'none') {
            $this->none_block_tolak = 'block';
        } elseif ($this->none_block_tolak == 'block') {
            $this->none_block_tolak = 'none';
        }
    }

    public function nama_pilars($id)
    {
        $a = ProgramPilar::where('id_program_pilar', $id)->first();

        return  $a->pilar;
    }



    public function tambah_dokumentasi()
    {
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
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
            ]);

            $this->judul_dokumentasi = NULL;
            $this->file_dokumentasi = NULL;
            session()->flash('alert_kegiatan', 'Dokumentasi Berhasil Ditambahkan');
            $this->emit('waktu_alert');
            $this->modal_rencana_kegiatan($this->id_pengajuan_detail);
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
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
            ]);

            session()->flash('alert_kegiatan', 'Dokumentasi Berhasil Diubah');
            $this->emit('waktu_alert');
            $this->modal_rencana_kegiatan($this->id_pengajuan_detail);
        }
    }

    public function modal_rencana_berita($id_pengajuan_detail)
    {
        $a = PengajuanKegiatan::where('id_pengajuan_detail', $id_pengajuan_detail)->first();
        if ($a == NULL) {
            $this->status_kegiatan = '0';
        } else {
            $this->status_kegiatan = '1';
        }
        $this->id_pengajuan_detail = $id_pengajuan_detail;
    }

    public function tombol_ubah_detail_berita()
    {
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $this->none_block_berita = 'block';

            $berita = Berita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();
        }
        // $this->narasi_berita2 = 'as';
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

        $this->modal_rencana_berita($this->id_pengajuan_detail);
    }

    public function tambah_ubah_berita()
    {

        // dd($this->id_pengajuan_detail);
        // TAMBAH
        if ($this->id_pengajuan_berita == NULL) {
            $id_pengajuan_berita = Str::uuid()->toString();
            if ($this->file_berita != NULL) {
                $ext = $this->file_berita->extension();
                $file_berita_name = 'BRT-' . Str::random(10) . '.' . $ext;
                $this->file_berita->storeAs('foto_berita', $file_berita_name);
            } else {
                $file_berita_name = NULL;
            }

            berita::create([
                'id_pengajuan_berita' => $id_pengajuan_berita,
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'judul' => $this->judul_berita,
                'tgl_terbit' => $this->tgl_terbit_berita,
                'narasi' => $this->narasi_berita,
                'status' => 'Belum Terbit',

                'file' => $file_berita_name,
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);

            session()->flash('alert_berita', 'Berita Berhasil Diubah');
            $this->emit('waktu_alert');
            $this->modal_rencana_berita($this->id_pengajuan_detail);
            $this->none_block_berita = 'none';
        }
        // UBAH
        else {

            $berita = Berita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->first();

            if ($this->file_berita != $berita->file and $this->file_berita != NULL) {
                if ($berita->file != null) {
                    $path = public_path() . "/uploads/foto_berita/" . $berita->file;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $ext = $this->file_berita->extension();
                $file_berita_name = 'BRT-' . Str::random(10) . '.' . $ext;
                $this->file_berita->storeAs('foto_berita', $file_berita_name);
            } else {
                $file_berita_name = $berita->file;
            }

            Berita::where('id_pengajuan_berita', $this->id_pengajuan_berita)->update([
                'judul' => $this->judul_berita,
                'tgl_terbit' => $this->tgl_terbit_berita,
                'narasi' => $this->narasi_berita2,
                'file' => $file_berita_name,
                'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            ]);

            session()->flash('alert_berita', 'Berita Berhasil Diubah');
            $this->emit('waktu_alert');
            $this->modal_rencana_berita($this->id_pengajuan_detail);
            $this->none_block_berita = 'none';
        }
    }

    public function tambah_ubah_pengeluaran()
    {
        // TAMBAH
        if ($this->id_pengajuan_pengeluaran == NULL) {
            $id_pengajuan_pengeluaran = Str::uuid()->toString();
            $ext = $this->nota_pengeluaran->extension();
            $nota_pengeluaran_name = 'NP-' . Str::random(10) . '.' . $ext;
            $this->nota_pengeluaran->storeAs('nota_pengeluaran', $nota_pengeluaran_name);

            PengajuanPengeluaran::create([
                'id_pengajuan_pengeluaran' => $id_pengajuan_pengeluaran,
                'id_pengajuan' => $this->id_pengajuan,
                'id_pengajuan_detail' => $this->id_pengajuan_detail,
                'judul' => $this->judul_pengeluaran,
                'jumlah' => $this->jumlah_pengeluaran,
                'nominal_pengeluaran' =>  str_replace('.', '', $this->nominal_pengeluaran),
                'tgl_pengeluaran' => $this->tgl_pengeluaran,
                'nota' => $nota_pengeluaran_name,
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
            ]);

            $this->judul_pengeluaran = NULL;
            $this->jumlah_pengeluaran = NULL;
            $this->nominal_pengeluaran = NULL;
            $this->tgl_pengeluaran = NULL;
            $this->nota_pengeluaran = NULL;

            session()->flash('alert_pengeluaran', 'Pengeluaran Berhasil Ditambahkan');
            $this->emit('waktu_alert');
            $this->modal_rencana_kegiatan($this->id_pengajuan_detail);
        }
        // UBAH
        else {

            $pengeluaran = PengajuanPengeluaran::where('id_pengajuan_pengeluaran', $this->id_pengajuan_pengeluaran)->first();
            if ($this->nota_pengeluaran != NULL) {
                if ($pengeluaran->nota != null) {
                    $path = public_path() . "/uploads/nota_pengeluaran/" . $pengeluaran->nota;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $ext = $this->nota_pengeluaran->extension();
                $nota_pengeluaran_name = 'DK-' . Str::random(10) . '.' . $ext;
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
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
            ]);

            session()->flash('alert_pengeluaran', 'Pengeluaran Berhasil Diubah');
            $this->emit('waktu_alert');
            $this->modal_rencana_kegiatan($this->id_pengajuan_detail);
        }
    }

    public function reset_penerima()
    {
        $this->id_pengajuan_penerima = '';
        $this->nama = '';
        $this->alamat = '';
        $this->nominal_bantuan = '';
        $this->keterangan = '';
    }

    public function reset_dokumentasi()
    {
        $this->id_pengajuan_dokumentasi = '';
        $this->judul_dokumentasi = '';
        $this->file_dokumentasi = '';
    }

    public function reset_pengeluaran()
    {
        $this->id_pengajuan_pengeluaran = NULL;
        $this->judul_pengeluaran = NULL;
        $this->jumlah_pengeluaran = NULL;
        $this->nominal_pengeluaran = NULL;
        $this->tgl_pengeluaran = NULL;
        $this->nota_pengeluaran = NULL;
        // $this->hydrate();
    }

    public function hapus_penerima()
    {
        PengajuanPenerima::where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->delete();
        $this->id_pengajuan_penerima = '';
        $this->nama = '';
        $this->alamat = '';
        $this->nominal_bantuan = '';
        $this->keterangan = '';
        session()->flash('alert_penerima', 'Penerima Manfaat Berhasil Dihapus');
        $this->emit('waktu_alert');
    }

    public function detail_penerima($id_pengajuan_penerima)
    {
        $this->id_pengajuan_penerima = $id_pengajuan_penerima;
        $a = PengajuanPenerima::where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->first();
        $this->nama = $a->nama;
        $this->alamat = $a->alamat;
        $this->nominal_bantuan = number_format($a->nominal_bantuan, 0, '.', '.');
        $this->keterangan = $a->keterangan;
    }

    public function detail_dokumentasi($id_pengajuan_dokumentasi)
    {
        $this->id_pengajuan_dokumentasi = $id_pengajuan_dokumentasi;
        $a = PengajuanDokumentasi::where('id_pengajuan_dokumentasi', $this->id_pengajuan_dokumentasi)->first();
        $this->judul_dokumentasi = $a->judul;
    }

    public function detail_pengeluaran($id_pengajuan_pengeluaran)
    {
        $this->id_pengajuan_pengeluaran = $id_pengajuan_pengeluaran;
        $a = PengajuanPengeluaran::where('id_pengajuan_pengeluaran', $this->id_pengajuan_pengeluaran)->first();
        $this->judul_pengeluaran = $a->judul;
        $this->jumlah_pengeluaran = $a->jumlah;
        $this->nominal_pengeluaran =  number_format($a->nominal_pengeluaran, 0, '.', '.');
        $this->tgl_pengeluaran = $a->tgl_pengeluaran;
    }


    public function upload_berkas()
    {
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();

        $pengajuan = Pengajuan::where('id_pengajuan', $this->id_pengajuan)->first();
        if ($pengajuan->scan != null) {
            $path = public_path() . "/uploads/pengajuan_konfirmasi/" . $pengajuan->scan;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $ext = $this->file_scan->extension();
        $file_scan_name = str_replace('/', '_', $pengajuan->nomor_surat) . '_PERMOHONAN' . '.' . $ext;
        $this->file_scan->storeAs('pengajuan_konfirmasi', $file_scan_name);

        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'status_pengajuan' => 'Diajukan',
            'tgl_konfirmasi' => date('Y-m-d'),
            'scan' => $file_scan_name,
            'dikonfirmasi_oleh_upzis' => Auth::user()->gocap_id_upzis_pengurus
        ]);

        $id_program_a = 'ba84d782-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_b = 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_c = 'c51700b1-81a8-11ed-b4ef-dc215c5aad51';
        // PROGRAM PENGUATAN KELEMBAGAAN
        $rencana_a = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program_a)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $jumlah_nominal_a = $rencana_a->sum('nominal_pengajuan');

        // PROGRAM SOSIAL
        $rencana_b = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program_b)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $jumlah_nominal_b = $rencana_b->sum('nominal_pengajuan');

        // OPERASIONAL UPZIS
        $rencana_c = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program_c)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $jumlah_nominal_c = $rencana_c->sum('nominal_pengajuan');


        // nama direktur
        $direktur = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Kepala Cabang')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        // keuangan
        $keuangan = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Divisi Keuangan 2')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        $keuangan->id_pc_pengurus;

        // $url =  "https://e-tasyaruf.nucarecilacap.id/upzis/detail-pengajuan-upzis/" . $this->id_pengajuan;
        $url =  "https://e-tasyaruf.nucarecilacap.id";
        $berkas =  "https://e-tasyaruf.nucarecilacap.id/uploads/pengajuan_konfirmasi/" . str_replace('/', '_', $data->nomor_surat);

        // UPZIS
        if ($data->id_ranting == NULL) {
            $this->notif(
                // nomor direktur
                 $this->nohp_pengurus_pc($direktur->id_pc_pengurus),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                    "*" .  "Mohon segera direspon"  . "*" .  "\n" .
                    "Pengajuan Pentasyarufan Tingkat " . $this->nama_upzis($data->id_upzis) . ", " . "*" . "telah dikonfirmasi" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .

                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->pj_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Pengajuan"  . "*" .  "\n" .
                    "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_a, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_b, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "3. OPERASIONAL UPZIS"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_c, 0, '.', '.') . ',-)' . "\n" . "\n" .

                    "Terima Kasih." . "\n" .
                    url($url)
            );


            $this->notif(
                // nomor keuangan
                 $this->nohp_pengurus_pc($keuangan->id_pc_pengurus),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($keuangan->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($keuangan->id_pc_pengurus) . "\n" . "\n" .

                    "*" .  "Mohon segera direspon"  . "*" .  "\n" .
                    "Pengajuan Pentasyarufan Tingkat " . $this->nama_upzis($data->id_upzis) . ", " . "*" . "telah dikonfirmasi" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .

                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->pj_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Pengajuan"  . "*" .  "\n" .
                    "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_a, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_b, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "3. OPERASIONAL UPZIS"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_c, 0, '.', '.') . ',-)' . "\n" . "\n" .

                    "Terima Kasih." . "\n" .
                    url($url)
            );

            // wa ke pj


            // maker upzis
            $this->notif(
                // nomor pj
                 $this->nohp_pengurus_upzis($data->maker_tingkat_upzis),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_upzis($data->maker_tingkat_upzis) .  "*" . "\n" .
                    $this->jabatan_pengurus_upzis($data->maker_tingkat_upzis) . "\n" . "\n" .

                    "Pengajuan Pentasyarufan Tingkat " . $this->nama_upzis($data->id_upzis) . ", " . "*" . "telah berhasil dikonfirmasi" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->maker_tingkat_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Pengajuan"  . "*" .  "\n" .
                    "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_a, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_b, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "3. OPERASIONAL UPZIS"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_c, 0, '.', '.') . ',-)' . "\n" . "\n" .

                    "Menunggu respon Kepala Cabang PC Lazisnu Cilacap, Terimakasih." . "\n" . "\n" .
                    // "Lihat progres pengajuan pentasyarufan melalui E-TASYARUF. Terimakasih."  . "\n" .
                    url($url)
            );
        }

        // RANTING
        else {
            $this->notif(
                // nomor direktur
             $this->nohp_pengurus_pc($direktur->id_pc_pengurus),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                    "*" .  "Mohon segera direspon"  . "*" .  "\n" .
                    "Pengajuan Pentasyarufan Tingkat " . $this->nama_ranting($data->id_ranting) . ", " . "*" . "telah dikonfirmasi" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .

                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->pj_ranting)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Pengajuan"  . "*" .  "\n" .
                    "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_a, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_b, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "3. OPERASIONAL UPZIS"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_c, 0, '.', '.') . ',-)' . "\n" .  "\n" .

                    "Terima Kasih." . "\n" .
                    url($url)
            );


            $this->notif(
                // nomor keuangan
                 $this->nohp_pengurus_pc($keuangan->id_pc_pengurus),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($keuangan->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($keuangan->id_pc_pengurus) . "\n" . "\n" .

                    "*" .  "Mohon segera direspon"  . "*" .  "\n" .
                    "Pengajuan Pentasyarufan Tingkat " . $this->nama_ranting($data->id_ranting) . ", " . "*" . "telah dikonfirmasi" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .

                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->pj_ranting)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Pengajuan"  . "*" .  "\n" .
                    "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_a, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_b, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "3. OPERASIONAL UPZIS"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_c, 0, '.', '.') . ',-)' . "\n" . "\n" .

                    "Terima Kasih." . "\n" .
                    url($url)
            );



            // maker upzis
            $this->notif(
                // nomor pj
                 $this->nohp_pengurus_upzis($data->maker_tingkat_upzis),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .


                    "Yth. " . "*" . $this->nama_pengurus_upzis($data->maker_tingkat_upzis) .  "*" . "\n" .
                    $this->jabatan_pengurus_upzis($data->maker_tingkat_upzis) . "\n" . "\n" .

                    "Pengajuan Pentasyarufan Tingkat Ranting " . $this->nama_ranting($data->id_ranting) . ", " . "*" . "telah berhasil dikonfirmasi" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->maker_tingkat_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Pengajuan"  . "*" .  "\n" .
                    "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_a, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_b, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "3. OPERASIONAL UPZIS"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_c, 0, '.', '.') . ',-)' . "\n" . "\n" .


                    "Menunggu respon Kepala Cabang PC Lazisnu Cilacap, Terimakasih." . "\n" . "\n" .

                    url($url)
            );
        }

        session()->flash('alert_konfirmasi', 'Berkas Berhasil Diupload');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function rekomendasi()
    {
        $pengajuan = Pengajuan::where('id_pengajuan', $this->id_pengajuan)->first();
        $data = DB::table($this->etasyaruf . '.pengajuan')->where('id_pengajuan', $this->id_pengajuan)->first();


        if ($pengajuan->scan_rekomendasi != null) {
            $path = public_path() . "/uploads/pengajuan_rekomendasi/" . $pengajuan->scan_rekomendasi;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // $ext = $this->file_scan_rekomendasi->extension();
        // $file_scan_name = str_replace('/', '_', $pengajuan->nomor_surat) . '_REKOMENDASI' . '.' . $ext;
        // $this->file_scan_rekomendasi->storeAs('pengajuan_rekomendasi', $file_scan_name);

        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'tgl_terbit_rekomendasi' => $this->tgl_terbit_rekomendasi,
            'status_rekomendasi' => 'Sudah Terbit',
            // 'scan_rekomendasi' => $file_scan_name,
            'direkomendasikan_oleh_pc' => Auth::user()->gocap_id_pc_pengurus
        ]);


        $id_program_a = 'ba84d782-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_b = 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51';
        $id_program_c = 'c51700b1-81a8-11ed-b4ef-dc215c5aad51';
        // PROGRAM PENGUATAN KELEMBAGAAN
        $rencana_a = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program_a)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $jumlah_nominal_a = $rencana_a->sum('nominal_disetujui');

        // PROGRAM SOSIAL
        $rencana_b = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program_b)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $jumlah_nominal_b = $rencana_b->sum('nominal_disetujui');

        // OPERASIONAL UPZIS
        $rencana_c = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->where('pengajuan_detail.id_program', $id_program_c)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC')->get();
        $jumlah_nominal_c = $rencana_c->sum('nominal_disetujui');


        // nama direktur
        $direktur = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Kepala Cabang')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        // $url =  "https://e-tasyaruf.nucarecilacap.id/upzis/detail-pengajuan-upzis/" . $this->id_pengajuan;
        $url =  "https://e-tasyaruf.nucarecilacap.id";
        $berkas =  "https://e-tasyaruf.nucarecilacap.id/uploads/pengajuan_konfirmasi/" . str_replace('/', '_', $data->nomor_surat);

        // UPZIS
        if ($data->id_ranting == NULL) {
            $this->notif(
                // nomor direktur
                 $this->nohp_pengurus_pc($direktur->id_pc_pengurus),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                    "Lembar Rekomendasi " . "*" . "telah diterbitkan" . "*" . " untuk Pengajuan Pentasyarufan Tingkat " . $this->nama_upzis($data->id_upzis) .  ", dengan detail sebagai berikut :" . "\n" . "\n" .

                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->pj_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Disetujui"  . "*" .  "\n" .
                    "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_a, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_b, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "3. OPERASIONAL UPZIS"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_c, 0, '.', '.') . ',-)' . "\n" . "\n" .
                    
                    "Lengkapi LPJ pentasyarufan sebelum pengajuan berikutnya." . "\n" .


                    "Terima Kasih." . "\n" .
                    url($url)
            );
        }

        // RANTING
        else {
            $this->notif(
                // nomor direktur
             $this->nohp_pengurus_pc($direktur->id_pc_pengurus),
                // "081578447350",

                "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                    "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                    $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                    "Lembar Rekomendasi " . "*" . "telah diterbitkan" . "*" . " untuk Pengajuan Pentasyarufan Tingkat " . $this->nama_ranting($data->id_ranting) .  ", dengan detail sebagai berikut :" . "\n" . "\n" .

                    "*" .  "Nomor"  . "*" .  "\n" .
                    $data->nomor_surat  . "\n" .
                    "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                    $this->nama_pengurus_upzis($data->pj_upzis)  . "\n" .
                    "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                    \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                    \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                    "*" .  "Nominal Disetujui"  . "*" .  "\n" .
                    "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_a, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_b, 0, '.', '.') . ',-)' . "\n" .
                    "*" .  "3. OPERASIONAL UPZIS"  . "*" .  "\n" .
                    '(Rp' . number_format($jumlah_nominal_c, 0, '.', '.') . ',-)' . "\n" . "\n" .
                    
                    "Hubungi admin upzis (" . $this->nama_pengurus_upzis($data->maker_tingkat_upzis) . " - " . $this->nohp_pengurus_upzis($data->maker_tingkat_upzis) . ") untuk kelengkapan berkas pentasyarufan dan kirimkan LPJ pentasyarufan sebelum pengajuan berikutnya." . "\n" . "\n" .


                    "Terima Kasih." . "\n" .
                    url($url)
            );
        }






        session()->flash('alert_rekomendasi', 'Pengajuan Berhasil Direkomendasikan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function nohp_pengurus_pc($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        return $a->nohp ?? '';
    }

    public function nohp_pengurus_upzis($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_upzis_pengurus', $id)
            ->first();

        if ($a == null) {
            $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_ranting_pengurus', $id)
                ->first();
        }
        return $a->nohp ?? '';
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

        if ($httpResponseCode == 200) {
            return (int)$httpResponseCode;
        } else {
            return null;
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

        session()->flash('alert_kegiatan', 'Dokumentasi Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->modal_rencana_kegiatan($this->id_pengajuan_detail);
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
        $this->id_pengajuan_pengeluaran = NULL;
        $this->judul_pengeluaran = NULL;
        $this->jumlah_pengeluaran = NULL;
        $this->nominal_pengeluaran = NULL;
        $this->tgl_pengeluaran = NULL;
        $this->nota_pengeluaran = NULL;

        session()->flash('alert_pengeluaran', 'Pengeluaran Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->modal_rencana_kegiatan($this->id_pengajuan_detail);
    }

    public function close()
    {
        $this->none_block_acc = 'none';
        $this->none_block_cair = 'none';
        $this->none_block_tolak = 'none';
        $this->none_block_terbit = 'none';
    }
}
