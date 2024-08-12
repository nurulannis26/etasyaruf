<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ArusDana;
use App\Models\Internal;
use App\Models\Rekening;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\PengajuanArsip;
use App\Http\Controllers\Helper;
use App\Models\PengajuanLampiran;
use App\Models\lpjInternal;

use Illuminate\Support\Facades\DB;

use App\Models\PengajuanPengeluaran;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class DetailInternalPc extends Component
{
    use WithFileUploads;

    public $id_internal;
    public $gocap;
    public $etasyaruf;
    public $siftnu;
    
    public $page_number = 5;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $cari;

    // card tombol jenis data
    public $bg_card_pengajuan;
    public $bg_card_arsip;

    // lampiran
    public $id_pengajuan_lampiran;
    public $judul;
    public $file_lampiran;

    // direktur
    public $nama_direktur;
    public $none_block_acc = 'none';
    public $none_block_tolak = 'none';
    public $approval_date;
    public $approval_note;
    public $denial_date;
    public $denial_note;
    public $nominal_disetujui;
    public $staf_keuangan;
    public $pengurus_keuangan = [];
    public $rekening = [];
    public $id_rekening;
    public $saldo;
    public $nama_bmt;
    
    public $none_block_acc_program = 'none';
    public $none_block_tolak_program = 'none';
    public $tgl_diserahkan_direktur;
    public $approval_date_divpro;
    public $satuan_disetujui2;
    public $keterangan_acc_divpro;

    // pencairan
    public $tgl_pencairan;
    public $kwitansi;
    public $dicairkan_kepada;
    public $id_rekening2;
    public $nominal_pencairan2;
    public $bentuk_pencairan;
    public $atas_nama_pencairan;
    public $bank_tujuan_pencairan;
    public $no_rek_tujuan_pencairan;
    public $pencairan_note;
    
    // edit
    public $nomor_surat_edit;
    public $pemohon_edit;
    public $tgl_tenggat_edit;
    public $tgl_pengajuan_edit;
    public $bentuk_dana_edit;
    public $nominal_pengajuan_edit;
    public $tujuan_edit;
    public $atas_nama_edit;
    public $bank_tujuan_edit;
    public $keterangan_ppd_edit;
    public $note_edit;
    public $no_rek_tujuan_edit;
    public $maker_tingkat_pc;
    
    public $denial_keuangan_note;
    public $denial_keuangan_date;

    // arsip
    public $id_pengajuan_arsip;
    public $file_arsip;

    // pengeluaran
    public $id_pengajuan_pengeluaran;
    public $judul_pengeluaran;
    public $tgl_pengeluaran;
    public $jumlah_pengeluaran;
    public $nominal_pengeluaran;
    public $nota_pengeluaran;
    public $dana_digunakan;
    public $nominal_pencairan;



    public $selectedProgram = '';
    public $selectedProgramEdit;
    
    public $tgl_penggunaan_dana;
    public $dibayarkan_kepada;
    public $nominal;
    public $keterangan;
    public $nota;
    public $id_lpj_internal;
    
    public $tgl_penggunaan_dana_edit;
    // public $tgl_input_edit;
    public $dibayarkan_kepada_edit;
    public $nominal_edit;
    public $keterangan_edit;
    public $nota_edit;
    
    public $scan_kwitansi;
    public $konfirmasi_upload_kwitansi;
    public $tgl_upload;
    public $kwitansi_kofirmasi_pc;

    public function updatedSelectedProgram($value)
    {
        $this->id_rekening = $value;
        // Lakukan tindakan lain yang diperlukan dengan nilai yang dipilih
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function mount()
    {

        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');
        $this->tombol_pengajuan();
        $this->tgl_penggunaan_dana = now()->timezone('Asia/Jakarta')->format('Y-m-d');
    }

    public function render()
    {
        $data = Internal::where('id_internal', $this->id_internal)->first();
        $lampiran = PengajuanLampiran::where('id_internal', $this->id_internal)->orderBy('created_at', 'DESC')->get();
        $arsip = PengajuanArsip::where('id_internal', $this->id_internal)->orderBy('created_at', 'DESC')->get();
        $pengeluaran = PengajuanPengeluaran::where('id_internal', $this->id_internal)
            ->orderBy('created_at', 'DESC')->get();

        // PENGELUARAN
        $b = PengajuanPengeluaran::where('id_internal', $this->id_internal)->sum('nominal_pengeluaran');

        $this->dana_digunakan = $b;
        $this->nominal_pencairan = $data->nominal_pencairan;
        
        $datas = lpjInternal::where('id_internal', $this->id_internal)->orderBy('created_at', 'DESC')
                ->when($this->cari, function ($query) {
                    return $query->where(function ($subQuery) {
                        $subQuery->where('dibayarkan_kepada', 'like', '%' . $this->cari . '%');
                    })->orWhere(function ($subQuery) {
                        $subQuery->where('keterangan', 'like', '%' . $this->cari . '%');
                    });
                })
                ->latest()
                ->paginate($this->page_number);

        $this->updatingSearch();
        $dana_digunakan_internal = $datas->sum('nominal');
        $sisa_dana = $data->nominal_pencairan - $dana_digunakan_internal;      

        $this->tab_z2();
        $this->tab_z3();
        return view('livewire.detail-internal-pc', compact(
            'data',
            'lampiran',
            'arsip',
            'pengeluaran',
            'datas',
            'dana_digunakan_internal',
            'sisa_dana'
        ));
    }
    
    public function modal_internal_penggunaan_dana()
    {
        $this->id_lpj_internal = NULL;
        $this->tgl_penggunaan_dana = NULL;
        // $this->tgl_input = NULL;
        $this->dibayarkan_kepada = NULL;
        $this->nominal = NULL;
        $this->keterangan = NULL;
        $this->nota = NULL;
    }
    
    public function uploadKwitansiPencairan()
    {
        $internal = Internal::where('id_internal', $this->id_internal)->first();
        if ($this->scan_kwitansi) {
            if ($internal->scan_kwitansi != null) {
                $path = public_path() . "/uploads/kwitansi_pencairan/" . $internal->scan_kwitansi;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $ext = $this->scan_kwitansi->extension();
            $file_scan_name = Str::uuid()->toString() . '.' . $ext;
            $this->scan_kwitansi->storeAs('kwitansi_pencairan', $file_scan_name);

            Internal::where('id_internal', $this->id_internal)->update([
                'scan_kwitansi' => $file_scan_name,
                'konfirmasi_upload_kwitansi' => $this->konfirmasi_upload_kwitansi,
                'tgl_upload' => date('Y-m-d'),
                'kwitansi_konfirmasi_pc' => Auth::user()->gocap_id_pc_pengurus
            ]);

            session()->flash('upload_kwitansi', 'Kwitansi Berhasil di-Upload');
            $this->emit('waktu_alert');
            $this->reset_kwitansi();
        } else {
            session()->flash('upload_kwitansi_gagal', 'Kwitansi Gagal di-Upload');
            $this->emit('waktu_alert');
            $this->reset_kwitansi();
        }
        
    }

    public function reset_kwitansi()
    {
        $this->scan_kwitansi = null;
        $this->konfirmasi_upload_kwitansi = NULL;
    }
    
    public function tambah_internal_penggunaan_dana()
    {
        $id_lpj_internal = Str::uuid()->toString();
        $ext = $this->nota->extension();
        $file_nota_name = 'LPJ-INTERNAL-' . Str::random(10) . '.' . $ext;
        $this->nota->storeAs('penggunaan_dana', $file_nota_name);

        lpjInternal::create([
            'id_internal' => $this->id_internal,
            'id_lpj_internal' => $id_lpj_internal,
            'tgl_penggunaan_dana' => $this->tgl_penggunaan_dana . ' ' . now()->timezone('Asia/Jakarta')->format('H:i:s'),
            'keterangan' => $this->keterangan,
            'dibayarkan_kepada' => $this->dibayarkan_kepada,
            'nominal' => str_replace('.', '', $this->nominal),
            'nota' => $file_nota_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);
        session()->flash('alert_lampiran', 'Penggunaan Dana Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }
    
    public function modal_ubah_lpj($id_lpj_internal)
    {
        // Pisahkan tanggal dan waktu
        $lpj = lpjInternal::where('id_lpj_internal', $id_lpj_internal)->first();
        list($tanggal, $waktu) = explode(' ', $lpj->tgl_penggunaan_dana);

        $this->tgl_penggunaan_dana_edit = $tanggal;
        // $this->tgl_input_edit = $lpj->tgl_input;
        $this->dibayarkan_kepada_edit = $lpj->dibayarkan_kepada;
        $this->nominal_edit = number_format($lpj->nominal, 0, '.', '.');
        $this->keterangan_edit = $lpj->keterangan;
        $this->nota = $lpj->nota;
        // dd($this->tgl_penggunaan_dana_edit);

        $this->id_lpj_internal = $id_lpj_internal;
    }

    public function ubah_internal_penggunaan_dana()
    {
        $a = lpjInternal::where('id_lpj_internal', $this->id_lpj_internal)->first();
        // dd($a);
        if ($this->nota != null && $this->nota != $a->nota) {
            if ($a->nota != null) {
                $path = public_path() . "/uploads/penggunaan_dana/" . $a->nota;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $ext = $this->nota->extension();
            $nota_name = 'LMP-INTERNAL-' . Str::random(10) . '.' . $ext;
            $this->nota->storeAs('penggunaan_dana', $nota_name);
        } else {
            $nota_name = $a->nota;
        }

        lpjInternal::where('id_lpj_internal', $this->id_lpj_internal)->update([
            // 'tgl_input' => $this->tgl_input_edit,
            'tgl_penggunaan_dana' => $this->tgl_penggunaan_dana_edit . ' ' . now()->timezone('Asia/Jakarta')->format('H:i:s'),
            'keterangan' => $this->keterangan_edit,
            'dibayarkan_kepada' => $this->dibayarkan_kepada_edit,
            'nominal' => str_replace('.', '', $this->nominal_edit),
            'nota' => $nota_name
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
        $this->keterangan = NULL;
        $this->dibayarkan_kepada = NULL;
        $this->nominal = NULL;
        $this->nota = NULL;
    }
    
    public function modal_hapus_lpj($id_lpj_internal)
    {
        $this->id_lpj_internal = $id_lpj_internal;
        // dd($id_lpj_internal);
    }
    
    public function hapus_lpj()
    {
        // dd($this->id_lpj_internal);
        $a = lpjInternal::where('id_lpj_internal', $this->id_lpj_internal)->first();
        // dd($a);
        if ($a->nota != null) {
            $path = public_path() . "/uploads/pengajuan_lampiran/" . $a->nota;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        lpjInternal::where('id_lpj_internal', $this->id_lpj_internal)->delete();

        session()->flash('alert_lampiran', 'Penggunaan Dana Berhasil Dihapus');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('tutupModal');
    }
    
    public function modal_ubah_internal($id_internal)
    {
        $internal = Internal::where('id_internal', $id_internal)->first();
        $this->nomor_surat_edit = $internal->nomor_surat;
        // Ambil data pemohon dari database berdasarkan ID
        $pemohon_data = DB::table($this->siftnu . '.pengguna')
        ->where('gocap_id_pc_pengurus', $internal->maker_tingkat_pc)
        ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pc_pengurus', '=', $this->siftnu . '.pengguna.gocap_id_pc_pengurus')
        ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
        ->select(
            $this->siftnu . '.pengguna.nama',
            $this->gocap . '.pengurus_jabatan.jabatan',
            $this->gocap . '.pc_pengurus.id_pc_pengurus'
        )
        ->first();

        // Set nilai $pemohon_edit untuk digunakan di template
        $this->pemohon_edit = $pemohon_data ? $pemohon_data->nama . ' - ' . $pemohon_data->jabatan : '';
        $this->maker_tingkat_pc = $pemohon_data ? $pemohon_data->id_pc_pengurus : null;

        $this->tgl_tenggat_edit = $internal->tgl_tenggat;
        $this->tgl_pengajuan_edit = $internal->tgl_pengajuan;
        $this->bentuk_dana_edit = $internal->bentuk;
        $this->nominal_pengajuan_edit = number_format($internal->nominal_pengajuan, 0, '.', '.');
        $this->tujuan_edit = $internal->tujuan;
        $this->atas_nama_edit = $internal->atas_nama;
        $this->bank_tujuan_edit = $internal->bank_tujuan;
        $this->no_rek_tujuan_edit = $internal->no_rek_tujuan;
        $this->keterangan_ppd_edit = $internal->keterangan_ppd;
        $this->note_edit = $internal->note;

        
    }

    public function ubah_internal_pc()
    {
        Internal::where('id_internal', $this->id_internal)->update([
            'nomor_surat' => $this->nomor_surat_edit,
            'maker_tingkat_pc' => $this->maker_tingkat_pc,
            'tgl_tenggat' => $this->tgl_tenggat_edit,
            'tgl_pengajuan' => $this->tgl_pengajuan_edit,
            'bentuk' => $this->bentuk_dana_edit,
            'nominal_pengajuan' => str_replace('.', '', $this->nominal_pengajuan_edit),
            'tujuan' => $this->tujuan_edit,
            'atas_nama' => $this->atas_nama_edit,
            'bank_tujuan' => $this->bank_tujuan_edit,
            'no_rek_tujuan' => $this->no_rek_tujuan_edit,
            'keterangan_ppd' => $this->keterangan_ppd_edit,
            'note' => $this->note_edit,
        ]);

        // dd($data_internal);

        session()->flash('alert_nominal', 'Pengajuan Internal Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
        $this->reset_edit();
    }

    public function reset_edit()
    {
        $this->nomor_surat_edit = NULL;
        $this->pemohon_edit = NULL;
        $this->tgl_tenggat_edit = NULL;
        $this->tgl_pengajuan_edit = NULL;
        $this->bentuk_dana_edit = NULL;
        $this->nominal_pengajuan_edit = NULL;
        $this->tujuan_edit = NULL;
        $this->atas_nama_edit = NULL;
        $this->bank_tujuan_edit = NULL;
        $this->no_rek_tujuan_edit = NULL;
        $this->keterangan_ppd_edit = NULL;
        $this->note_edit = NULL;
    }
    
    public function hapus_internal()
    {
        $data = Internal::where('id_internal', $this->id_internal)->first();
        $lampiran = PengajuanLampiran::where('id_internal', $this->id_internal)->first();

        if ($lampiran) {
            PengajuanLampiran::where('id_internal', $this->id_internal)->delete();
            if ($lampiran->file != null) {
                $path = public_path() . "/uploads/pengajuan_lampiran/" . $lampiran->file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        if ($data->id_rekening !== null && $data->id_rekening !== '') {
            Rekening::where('id_rekening', $data->id_rekening)->increment('saldo', str_replace('.', '', $this->nominal_pencairan));
            ArusDana::where('id_etasyaruf_permohonan_internal', $this->id_internal)->delete();
        }        

        Internal::where('id_internal', $this->id_internal)->delete();
        session()->flash('success', 'Pengajuan Internal Berhasil Dihapus');
        $this->dispatchBrowserEvent('success', ['message' => 'Pengajuan Internal Berhasil Dihapus']);
        return redirect('/pc/internalpc-pc');
        
    }
    
    public function tombol_tolak_keuangan()
    {
        $this->none_block_acc = 'none';

        if ($this->none_block_tolak == 'none') {
            $this->none_block_tolak = 'block';
        } elseif ($this->none_block_tolak == 'block') {
            $this->none_block_tolak = 'none';
        }

        $data = Internal::where('id_internal', $this->id_internal)->first();
        $this->denial_keuangan_date = date('Y-m-d');

        if ($data->denial_keuangan_note == NULL) {
            $this->denial_keuangan_note = NULL;
        } else {
            $this->denial_keuangan_note = $data->denial_keuangan_note;
        }
    }
    
    public function tolak_keuangan()
    {

        $data = Internal::where('id_internal', $this->id_internal)->first();

        Internal::where('id_internal', $this->id_internal)->update([
            'denial_keuangan_date' => $this->denial_keuangan_date,
            'denial_keuangan_note' => $this->denial_keuangan_note,
            'pencairan_status' => 'Ditolak Dicairkan',
            'denial_keuangan_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $url =  "https://e-tasyaruf.nucarecilacap.id";

        $this->notif(
            //  Helper::getNohpPengurus('pc', $data->maker_tingkat_pc),
            '089639481199',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurus('pc', $data->maker_tingkat_pc) .  "*" . "\n" .
                Helper::getJabatanPengurus('pc', $data->maker_tingkat_pc)  . "\n" . "\n" .

                "*" .  "Mohon segera ditinjau kembali"  . "*" .  "\n" .
                "Pengajuan INTERNAL PC Lazisnu Cilacap telah " . "*" . "di-tolak" . "*" . " oleh Direktur PC Lazisnu Cilacap, dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $data->nomor_surat  . "\n" .
                "*" .  "Yang Mengajukan"  . "*" .  "\n" .
                Helper::getNamaPengurus('pc', $data->maker_tingkat_pc)   . "\n"  .
                "*" .  "Tanggal Ditolak"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->denial_keuangan_date)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Catatan"  . "*" .  "\n" .
                $this->denial_keuangan_note  . "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        $this->none_block_tolak = 'none';
        session()->flash('alert_keuangan', 'Pencairan Dana Berhasil Ditolak');
        $this->emit('waktu_alert');
    }

    public function tab_z2()
    {
        // nama direktur
        $b = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Direktur Eksekutif')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select(
                $this->siftnu . '.pengguna.nama'
            )
            ->first();
        if ($b == NULL) {
            $this->nama_direktur = 'Direktur Belum Ada';
        } else {
            $this->nama_direktur = $b->nama;
        }

        // pengurus keuangan
        // pengurus keuangan
        $pengurus_keuangan = DB::table($this->gocap . '.pc_pengurus')
            ->join($this->siftnu . '.pengguna', $this->siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->join($this->gocap . '.pengurus_jabatan', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $this->gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where($this->siftnu . '.pengguna.status', '1')
            ->select(
                $this->siftnu . '.pengguna.nama',
                $this->gocap . '.pc_pengurus.id_pc_pengurus',
                $this->gocap . '.pengurus_jabatan.jabatan'
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
                $this->gocap . '.pengurus_jabatan.jabatan'
            )
            ->where($this->gocap . '.pc_pengurus.id_pc',  Auth::user()->PcPengurus->Pc->id_pc)
            ->where($this->gocap . '.pengurus_jabatan.jabatan',  'Divisi Keuangan')
            ->get();
        $this->staf_keuangan = $pengurus_keuangan->id_pc_pengurus;

        // rekening

        // $this->rekening = Rekening::where('id_pc', $data->id_pc)
        //     ->where('nama_rekening', 'PC LAZISNU CILACAP')
        //     ->get();
        // $rekening = Rekening::where('id_pc', $data->id_pc)
        //     ->where('nama_rekening', 'PC LAZISNU CILACAP')
        //     ->first();
        // if ($rekening != null) {
        //     $this->id_rekening = $rekening->id_rekening;
        //     $this->saldo =  number_format($rekening->saldo, 0, '.', '.');
        //     // NAMA BMT
        //     $bmt = DB::table($this->gocap . '.bmt')->where('id_bmt', $rekening->id_bmt)->first();
        //     if ($bmt == NULL) {
        //         $this->nama_bmt = 'BMT Belum Ada';
        //     } else {
        //         $this->nama_bmt = $bmt->nama_bmt;
        //     }
        // } else {
        //     $this->id_rekening = NULL;
        // }

        $data = Internal::where('id_internal', $this->id_internal)->first();
        $this->rekening = Rekening::where('id_pc', $data->id_pc)->whereNull('id_upzis')->whereNull('id_ranting')
        ->whereNotNull('no_rekening')
        ->whereNotNull('id_pc')
            // ->where('nama_rekening', 'PC LAZISNU CILACAP')
            ->get();

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
    }

    public function tab_z3()
    {
        $this->tgl_pencairan = date('Y-m-d');
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

    public function modal_internal_lampiran_tambah()
    {
        $this->judul = NULL;
    }

    public function modal_internal_arsip_tambah()
    {
        $this->judul = NULL;
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

    public function modal_internal_lampiran_ubah($id_pengajuan_lampiran)
    {
        $a = PengajuanLampiran::where('id_pengajuan_lampiran', $id_pengajuan_lampiran)->first();
        $this->judul = $a->judul;
        $this->id_pengajuan_lampiran = $id_pengajuan_lampiran;
    }

    public function modal_internal_arsip_ubah($id_pengajuan_arsip)
    {
        $a = PengajuanArsip::where('id_pengajuan_arsip', $id_pengajuan_arsip)->first();
        $this->judul = $a->judul;
        $this->id_pengajuan_arsip = $id_pengajuan_arsip;
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

    public function modal_internal_lampiran_hapus($id_pengajuan_lampiran)
    {
        $this->id_pengajuan_lampiran = $id_pengajuan_lampiran;
    }

    public function modal_internal_arsip_hapus($id_pengajuan_arsip)
    {
        $this->id_pengajuan_arsip = $id_pengajuan_arsip;
    }

    public function modal_pengeluaran_hapus($id_pengajuan_pengeluaran)
    {
        $this->id_pengajuan_pengeluaran = $id_pengajuan_pengeluaran;
    }

    public function tambah_lampiran()
    {
        $id_pengajuan_lampiran = Str::uuid()->toString();
        $ext = $this->file_lampiran->extension();
        $file_lampiran_name = 'LMP-INTERNAL-' . Str::random(10) . '.' . $ext;
        $this->file_lampiran->storeAs('pengajuan_lampiran', $file_lampiran_name);

        PengajuanLampiran::create([
            'id_pengajuan_lampiran' => $id_pengajuan_lampiran,
            'id_internal' => $this->id_internal,
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

    public function tambah_arsip()
    {
        $id_pengajuan_arsip = Str::uuid()->toString();
        $ext = $this->file_arsip->extension();
        $file_arsip_name = 'ARS-INTERNAL-' . Str::random(10) . '.' . $ext;
        $this->file_arsip->storeAs('pengajuan_arsip', $file_arsip_name);

        PengajuanArsip::create([
            'id_pengajuan_arsip' => $id_pengajuan_arsip,
            'id_internal' => $this->id_internal,
            'judul' => $this->judul,
            'file' => $file_arsip_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul = NULL;
        $this->file_arsip = NULL;
        session()->flash('alert_arsip', 'Arsip Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }


    public function tambah_pengeluaran()
    {
        $id_pengajuan_pengeluaran = Str::uuid()->toString();
        $ext = $this->nota_pengeluaran->extension();
        $nota_pengeluaran_name = 'NP-INTERNAL-' . Str::random(10) . '.' . $ext;
        $this->nota_pengeluaran->storeAs('nota_pengeluaran', $nota_pengeluaran_name);

        PengajuanPengeluaran::create([
            'id_pengajuan_pengeluaran' => $id_pengajuan_pengeluaran,
            'id_internal' => $this->id_internal,
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
            $file_lampiran_name = 'LMP-INTERNAL-' . Str::random(10) . '.' . $ext;
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

    public function ubah_arsip()
    {
        $a = PengajuanArsip::where('id_pengajuan_arsip', $this->id_pengajuan_arsip)->first();
        if ($this->file_arsip != NULL) {
            if ($a->file != null) {
                $path = public_path() . "/uploads/pengajuan_arsip/" . $a->file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $ext = $this->file_arsip->extension();
            $file_arsip_name = 'ARS-INTERNAL-' . Str::random(10) . '.' . $ext;
            $this->file_arsip->storeAs('pengajuan_arsip', $file_arsip_name);
        } else {
            $file_arsip_name = $a->file;
        }

        PengajuanArsip::where('id_pengajuan_arsip', $this->id_pengajuan_arsip)->update([
            'judul' => $this->judul,
            'file' => $file_arsip_name,
            'maker_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->judul = NULL;
        $this->file_arsip = NULL;
        session()->flash('alert_arsip', 'Arsip Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
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
            $nota_pengeluaran_name = 'NP-INTERNAL-' . Str::random(10) . '.' . $ext;
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

    public function hapus_arsip()
    {
        $a = PengajuanArsip::where('id_pengajuan_arsip', $this->id_pengajuan_arsip)->first();

        if ($a->file != null) {
            $path = public_path() . "/uploads/pengajuan_arsip/" . $a->file;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        PengajuanArsip::where('id_pengajuan_arsip', $this->id_pengajuan_arsip)->delete();

        session()->flash('alert_arsip', 'Lampiran Berhasil Dihapus');
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



    public function tombol_tolak()
    {
        $this->none_block_acc = 'none';

        if ($this->none_block_tolak == 'none') {
            $this->none_block_tolak = 'block';
        } elseif ($this->none_block_tolak == 'block') {
            $this->none_block_tolak = 'none';
        }

        $data = Internal::where('id_internal', $this->id_internal)->first();
        $this->denial_date = date('Y-m-d');

        if ($data->denial_note == NULL) {
            $this->denial_note = NULL;
        } else {
            $this->denial_note = $data->denial_note;
        }
    }





    public function tombol_acc()
    {
        $this->none_block_tolak = 'none';

        if ($this->none_block_acc == 'none') {
            $this->none_block_acc = 'block';
        } elseif ($this->none_block_acc == 'block') {
            $this->none_block_acc = 'none';
        }

        $this->id_rekening2 = '';
        $data = Internal::where('id_internal', $this->id_internal)->first();
        $this->approval_date = date('Y-m-d');

        $this->nominal_pencairan2 = number_format($data->nominal_disetujui, 0, '.', '.');
        $this->nominal_disetujui = number_format($data->nominal_pengajuan, 0, '.', '.');
    }

    public function close()
    {
        $this->none_block_acc = 'none';
        $this->none_block_tolak = 'none';
    }

    public function acc()
    {
        $data = Internal::where('id_internal', $this->id_internal)->first();
        // create data
        Internal::where('id_internal', $this->id_internal)->update([
            'approval_date' => $this->approval_date,
            'approval_status' => 'Disetujui',
            'approver_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            'nominal_disetujui' => str_replace('.', '', $this->nominal_disetujui),
            'staf_keuangan_pc' => $this->staf_keuangan,
            'approval_note' => $this->approval_note,
            'id_rekening' => $this->id_rekening,

        ]);

        $url =  "https://e-tasyaruf.nucarecilacap.id";

        $this->notif(
            Helper::getNohpPengurus('pc', $this->staf_keuangan),
            // '082138603051',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurus('pc', $this->staf_keuangan) .  "*" . "\n" .
                Helper::getJabatanPengurus('pc', $this->staf_keuangan)  . "\n" . "\n" .
                "*" .  "Mohon segera dicairkan"  . "*" .  "\n" .
                "Pengajuan INTERNAL PC Lazisnu Cilacap telah " . "*" . "di-acc" . "*" . " oleh Direktur PC Lazisnu Cilacap, dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $data->nomor_surat  . "\n" .
                "*" .  "Yang Mengajukan"  . "*" .  "\n" .
                Helper::getNamaPengurus('pc', Auth::user()->gocap_id_pc_pengurus)   . "\n"  .
                "*" .  "PJ Pencairan Dana"  . "*" .  "\n" .
                Helper::getNamaPengurus('pc', $this->staf_keuangan)   . "\n"  .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Tanggal Disetujui"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->approval_date)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nominal Disetujui"  . "*" .  "\n" .
                '(Rp' .  $this->nominal_disetujui . ',-)' .  "\n" .
                "*" .  "Keterangan"  . "*" .  "\n" .
                $this->approval_note ?? '-' .  "\n" .


                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );


        $this->none_block_acc = 'none';
        session()->flash('alert_direktur', 'Pengajuan Internal Berhasil Disetujui');
        $this->emit('waktu_alert');
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
    public function tolak()
    {

        $data = Internal::where('id_internal', $this->id_internal)->first();

        Internal::where('id_internal', $this->id_internal)->update([
            'denial_date' => $this->denial_date,
            'denial_note' => $this->denial_note,
            'approval_status' => 'Ditolak',
            'denial_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $url =  "https://e-tasyaruf.nucarecilacap.id";

        $this->notif(
             Helper::getNohpPengurus('pc', $data->maker_tingkat_pc),
            // '082138603051',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurus('pc', $data->maker_tingkat_pc) .  "*" . "\n" .
                Helper::getJabatanPengurus('pc', $data->maker_tingkat_pc)  . "\n" . "\n" .

                "*" .  "Mohon segera ditinjau kembali"  . "*" .  "\n" .
                "Pengajuan INTERNAL PC Lazisnu Cilacap telah " . "*" . "di-tolak" . "*" . " oleh Direktur PC Lazisnu Cilacap, dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $data->nomor_surat  . "\n" .
                "*" .  "Yang Mengajukan"  . "*" .  "\n" .
                Helper::getNamaPengurus('pc', $data->maker_tingkat_pc)   . "\n"  .
                "*" .  "Tanggal Ditolak"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->denial_date)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Catatan"  . "*" .  "\n" .
                $this->denial_note  . "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        $this->none_block_tolak = 'none';
        session()->flash('alert_direktur', 'Pengajuan Internal Berhasil Ditolak');
        $this->emit('waktu_alert');
    }







    public function nama_rekening($id)
    {
        $a = Rekening::where('id_rekening', $id)->first();

        return  $a->nama_rekening . " - " . $a->no_rekening;
    }

    public function pencairan()
    {
        $data = Internal::where('id_internal', $this->id_internal)->first();

        Internal::where('id_internal', $this->id_internal)->update([
            'pencairan_status' => 'Berhasil Dicairkan',
            'tgl_pencairan' => $this->tgl_pencairan,
            'dicairkan_kepada' => $data->maker_tingkat_pc,
            'nominal_pencairan' => str_replace('.', '', $this->nominal_pencairan2),
            // 'file' => $kwitansi_name,
            'id_rekening' => $this->id_rekening2,
            'bentuk_pencairan' => $this->bentuk_pencairan,
            'atas_nama_pencairan' => $this->atas_nama_pencairan,
            'bank_tujuan_pencairan' => $this->bank_tujuan_pencairan,
            'no_rek_tujuan_pencairan' => $this->no_rek_tujuan_pencairan,
            'pencairan_note' => $this->pencairan_note
        ]);


        // update rekening and create arus dana
        Rekening::where('id_rekening', $this->id_rekening2)->decrement('saldo', str_replace('.', '', $this->nominal_pencairan2));
        $id_arus_dana = Str::uuid();
        ArusDana::create([
            'id_arus_dana' => $id_arus_dana,
            'id_rekening' => $this->id_rekening2,
            'jenis_dana' => 'keluar',
            'jenis_kas' => 'Pentasyarufan Koin NU',
            'nominal' => str_replace('.', '', $this->nominal_pencairan2),
            'tanggal_input' => date('Y-m-d'),
            'petugas_input_pc' => Auth::user()->gocap_id_pc_pengurus,
            'id_etasyaruf_permohonan_internal' => $data->id_internal,
            'uraian' => $data->tujuan . ' - ' . $data->note
        ]);


        // $url =  "https://e-tasyaruf.nucarecilacap.id/pc/detail-pengajuan-pc/" . $this->id_pengajuan_detail;
        $url =  "https://e-tasyaruf.nucarecilacap.id";


        $this->notif(
            Helper::getNohpPengurus('pc', $data->maker_tingkat_pc),
            // '082138603051',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurus('pc', $data->maker_tingkat_pc) .  "*" . "\n" .
                Helper::getJabatanPengurus('pc', $data->maker_tingkat_pc)  . "\n" . "\n" .

                "Pengajuan INTERNAL PC Lazisnu Cilacap, " . "*" . "berhasil dicairkan" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $data->nomor_surat  . "\n" .
                "*" .  "Yang Mengajukan"  . "*" .  "\n" .
                Helper::getNamaPengurus('pc', $data->maker_tingkat_pc)   . "\n"  .
                "*" .  "Tanggal Pencairan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->tgl_pencairan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Dicairkan Kepada"  . "*" .  "\n" .
                $this->nama_pengurus_pc($data->maker_tingkat_pc)  . "\n" .
                "*" .  "Nominal Pencairan"  . "*" .  "\n" .
                'Rp' . $this->nominal_pencairan2 . ',-' .  "\n" .
                "*" .  "Rekening"  . "*" .  "\n" .
                '(' .  Helper::getDataRekening2($this->id_rekening2)->pluck('nama_rekening')->first() . " - " . Helper::getDataRekening2($this->id_rekening2)->pluck('no_rekening')->first() . ")" . "\n" .
                "*" .  "BMT"  . "*" .  "\n" .
                Helper::getDataRekening2($this->id_rekening2)->pluck('nama_bmt')->first()  . "\n" . 
                "*" .  "Keterangan Pencairan"  . "*" .  "\n" .
                $this->pencairan_note .  "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );


        $this->none_block_acc = 'none';
        session()->flash('alert_keuangan', 'Pengajuan Berhasil Dicairkan');
        $this->emit('waktu_alert');

        // dd($this->id_rekening2);
    }


    public function tombol_pengajuan()
    {
        $this->bg_card_pengajuan = 'bg-success';
        $this->bg_card_arsip = '';
    }

    public function tombol_arsip()
    {
        $this->bg_card_pengajuan = '';
        $this->bg_card_arsip = 'bg-success';
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


    public function nohp_pengurus_pc($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)->first();
        return $a->nohp;
    }

    public function nama_pengurus_pc($id)
    {
        $a = DB::table($this->siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)->first();
        return $a->nama;
    }

    public function hydrate()
    {
        $this->emit('loadContactDeviceSelect2');
        $this->emit('select2');
    }
    
    public function close_internal()
    {
        $this->none_block_acc = 'none';
        $this->none_block_tolak = 'none';
        $this->none_block_acc_program = 'none';
        $this->none_block_tolak_program = 'none';
    }

    public function tombol_acc_internal()
    {

        $this->approval_date_divpro = date('Y-m-d');
        $this->tgl_diserahkan_direktur = date('Y-m-d');

        // $this->tab-z1();
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
        $data = Internal::where('id_internal', $this->id_internal)->first();
        // $this->satuan_disetujui2 = number_format($data->satuan_disetujui, 0, '.', '.');
    }

    public function acc_internal()
    {
        // dd($this->id_rekening);

        $data = Internal::where('id_internal', $this->id_internal)->first();


        Internal::where('id_internal', $this->id_internal)->update([
            'approval_date_divpro' => $this->approval_date_divpro,
            'approval_status_divpro' => 'Disetujui',
            'approver_divpro' => Auth::user()->gocap_id_pc_pengurus,
            'status_divpro' => 'Diterima',
            'tgl_diserahkan_direktur' => $this->tgl_diserahkan_direktur,
            'keterangan_acc_divpro' => $this->keterangan_acc_divpro,
        ]);

        $direktur = DB::table($this->gocap . '.pengurus_jabatan')->where('jabatan', 'Direktur Eksekutif')
            ->join($this->gocap . '.pc_pengurus', $this->gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $this->gocap . '.pengurus_jabatan.id_pengurus_jabatan')
            ->where($this->gocap . '.pc_pengurus.status', '1')
            ->select($this->gocap . '.pc_pengurus.id_pc_pengurus')
            ->first();

        // kirim notif wa
        $url =  "https://e-tasyaruf.nucarecilacap.id";

        // petugas penyaluran
        $this->notif(
            Helper::getNohpPengurus('pc', $direktur->id_pc_pengurus),

            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .

                // "Yth. " . "*" . $this->nama_pengurus_pc($this->petugas) .  "*" . "\n" .
                // $this->jabatan_pengurus_pc($this->petugas) . "\n" . "\n" .
                "Yth. " . "*" . $this->nama_pengurus_pc($direktur->id_pc_pengurus) .  "*" . "\n" .
                $this->jabatan_pengurus_pc($direktur->id_pc_pengurus) . "\n" . "\n" .

                "*Disposisi penyaluran diserahkan ke Direktur.*" . "\n" . "*Segera berikan respon persetujuan.*" . "\n" . "\n" .

                "# Pengajuan INTERNAL PC Lazisnu Cilacap" .  "\n"  . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $data->nomor_surat  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Tanggal Input"  . "*" .  "\n" .
                \Carbon\Carbon::parse($data->created_at)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nominal Diajukkan"  . "*" .  "\n" .
                'Rp' . number_format($data->nominal_pengajuan, 0, '.', '.') . ',-' . "\n" .
                "*" .  "Tujuan"  . "*" .  "\n" .
                ($data->tujuan) .  "\n" .
                "*" .  "Keterangan"  . "*" .  "\n" .
                ($data->note) .  "\n" . "\n" .

                "Terima Kasih." . "\n" . "\n" .
                url($url)
        );

        $this->none_block_acc_program = 'none';
        session()->flash('alert_direktur', 'Pengajuan Berhasil Disetujui');
        $this->emit('waktu_alert');
    }
}
