<?php

namespace App\Http\Livewire;

use App\Models\Pc;
use App\Models\Berita;
use Livewire\Component;
use App\Models\ArusDana;
use App\Models\Programs;
use App\Models\Rekening;
use App\Models\Pengajuan;
use Illuminate\Support\Str;
use App\Models\ProgramPilar;
use Livewire\WithFileUploads;
use App\Models\LampiranBerita;
use App\Models\PengajuanDetail;
use App\Models\ProgramKegiatan;
use App\Http\Controllers\Helper;
use App\Models\PengajuanKegiatan;
use App\Models\PengajuanPenerima;
use Illuminate\Support\Facades\DB;
use App\Models\LampiranPenerimaLPJ;
use App\Models\PengajuanDokumentasi;
use App\Models\PengajuanPenerimaLPJ;
use App\Models\PengajuanPengeluaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\PengajuanController;

class DetailPengajuan extends Component
{
    use WithFileUploads;

    public $data;
    public $id_pengajuan;
    public $id_pengajuan_detail;
    public $url = 'https://e-tasyaruf.nucarecilacap.id';
    // db
    public $gocap;
    public $etasyaruf;
    public $siftnu;
    // tab-a
    public $rencana_a;
    public $rencana_b;
    public $rencana_c;
    public $jumlah_nominal_a;
    public $jumlah_nominal_b;
    public $jumlah_nominal_c;
    public $id_program_a = 'ba84d782-81a8-11ed-b4ef-dc215c5aad51';
    public $id_program_b = 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51';
    public $id_program_c = 'c51700b1-81a8-11ed-b4ef-dc215c5aad51';
    // modal add
    public $list_petugas = [];
    public $petugas;
    public $tgl_pelaksanaan;
    public $tgl_setor;
    public $list_program = [];
    public $list_pilar = [];
    public $list_kegiatan = [];
    public $id_program = '';
    public $id_program_pilar = '';
    public $id_program_kegiatan = '';
    public $nama_penerima;
    public $satuan_pengajuan;
    public $jumlah_penerima;
    public $total;
    public $pengajuan_note = '';
    // detail penerima manfaat
    public $data_detail;
    public $data_penerima = [];
    public $id_pengajuan_penerima = '';
    public $penerima_manfaat;
    public $nominal_bantuan;
    public $alamat_penerima;
    public $penerima_note;
    // for lpj
    public $tgl_bantuan;
    public $jenis_bantuan;
    public $nik;
    public $nokk;
    public $nohp;

    // acc tolak
    public $satuan_disetujui;
    public $nominal;
    public $approval_note;
    public $denial_note;
    // pencairan
    public $satuan_pencairan;
    public $pencairan_note;
    public $id_rekening = '';
    public $list_rekening = [];
    // konfirmasi
    public $scan_konfirmasi;
    // kegiatan
    // public $id_pengajuan_kegiatan = '';
    // public $dataDokumentasi = [];
    // public $kegiatan;
    // public $judul_kegiatan;
    // public $tgl_kegiatan;
    // public $lokasi;
    // public $jumlah_kehadiran;
    // public $kendala;
    // public $ringkasan;
    // public $judul_foto;
    // public $foto_kegiatan;
    // pengeluaran
    // public $dataPengeluaran = [];
    // public $id_pengajuan_pengeluaran = '';
    // public $judul_pengeluaran;
    // public $tgl_pengeluaran;
    // public $jumlah;
    // public $nominal_pengeluaran;
    // public $nota;

    // berita
    public $data_penerima_lpj = [];
    public $penerima_lpj;
    public $scan_berita;
    public $konfirmasi_note;
    public $diperiksa_note;
    public $diperiksa_note_rev;
    public $tgl_berita;
    public $berupa;
    public $senilai;
    public $nama1;
    public $jabatan1;
    public $nohp1;
    public $alamat1;
    public $nama2;
    public $jabatan2;
    public $nohp2;
    public $alamat2;

    // lampiran lpj per penerima
    public $judul_file;
    public $file;
    public $data_lampiran = [];

    // lampiran berita
    public $data_lampiran_berita = [];
    public $id_lampiran_berita;
    public $file_berita;




    // public $list_penerima = [];
    // public $no_identitas;
    // public $jalan;
    // public $rt;
    // public $rw;
    // public $desakelurahan;
    // public $kecamatan;
    // public $kabupaten;
    // public $tempat_tgl_lahir;
    // public $nohp;
    // public $jabatan;
    // public $tgl_bantuan;
    // public $tgl_pentasyarufan;



    public function hydrate()
    {
        $this->emit('loadContactDeviceSelect2');
    }



    public function mount()
    {

        // $this->data_penerima_lpj = [];

        $this->data = Pengajuan::where('id_pengajuan', $this->id_pengajuan)->first();
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');
        $this->tgl_pelaksanaan = date('Y-m-d');
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $this->list_petugas = PengajuanController::getDaftarPengurus('upzis', $this->data->id_upzis);
            $this->petugas = $this->list_petugas->where('jabatan', 'Divisi Pentasyarufan')
                ->pluck('id_upzis_pengurus')
                ->first() ?? NULL;
            $this->list_rekening = Helper::getDataRekening($this->data->tingkat, $this->data->id_upzis) ?? NULL;
            // dd($this->list_rekening);
        } elseif ($this->data->tingkat == 'Ranting NU') {
            $this->list_petugas = PengajuanController::getDaftarPengurus('ranting', $this->data->id_ranting);
            $this->list_rekening = Helper::getDataRekening($this->data->tingkat, $this->data->id_ranting) ?? NULL;
            $this->petugas = '';
        }
        $this->list_program = Helper::getDaftarProgram($this->data->tingkat);
    }

    public function render()
    {
        $this->list_pilar = Helper::getDaftarPilarByProgram($this->id_program) ?? NULL;
        $this->list_kegiatan = Helper::getDaftarKegiatanByPilar($this->id_program_pilar) ?? NULL;
        // $this->updateTotal();
        // $this->updateTotal2();

        // tab-a
        $rencana_a = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC');
        $rencana_b = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC');
        $rencana_c = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)
            ->join($this->etasyaruf . '.program_kegiatan', $this->etasyaruf . '.program_kegiatan.id_program_kegiatan', '=', $this->etasyaruf . '.pengajuan_detail.id_program_kegiatan')
            ->select(
                $this->etasyaruf . '.program_kegiatan.*',
                $this->etasyaruf . '.pengajuan_detail.*',
            )
            ->orderBy('pengajuan_detail.created_at', 'ASC');
        // PROGRAM PENGUATAN KELEMBAGAAN
        $this->rencana_a = $rencana_a->where('pengajuan_detail.id_program', $this->id_program_a)->get();
        $this->jumlah_nominal_a = $this->rencana_a->sum('nominal_pengajuan');
        // PROGRAM SOSIAL
        $this->rencana_b = $rencana_b->where('pengajuan_detail.id_program', $this->id_program_b)->get();
        $this->jumlah_nominal_b = $this->rencana_b->sum('nominal_pengajuan');
        // OPERASIONAL UPZIS
        $this->rencana_c = $rencana_c->where('pengajuan_detail.id_program', $this->id_program_c)->get();
        $this->jumlah_nominal_c = $this->rencana_c->sum('nominal_pengajuan');

        return view('livewire.detail-pengajuan');
    }

    public function create_edit_rencana()
    {
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $tingkat = 'upzis';
        } elseif ($this->data->tingkat == 'Ranting NU') {
            $tingkat = 'ranting';
        }
        if ($this->tgl_setor == '') {
            $this->tgl_setor = NULL;
        }
        // create
        if ($this->id_pengajuan_detail == NULL or $this->id_pengajuan_detail == '') {
            $id_pengajuan_detail = Str::uuid()->toString();
            PengajuanDetail::create([
                'id_pengajuan_detail' =>  $id_pengajuan_detail,
                'id_pengajuan' => $this->id_pengajuan,
                'petugas_' . $tingkat => $this->petugas,
                'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
                'tgl_setor' => $this->tgl_setor,
                'pengajuan_note' => $this->pengajuan_note,
                'id_program' => $this->id_program,
                'id_program_pilar' => $this->id_program_pilar,
                'id_program_kegiatan' => $this->id_program_kegiatan,
                'nama_penerima' => $this->nama_penerima,
                'jumlah_penerima' => $this->jumlah_penerima,
                'satuan_pengajuan' => str_replace('.', '', $this->satuan_pengajuan),
                'nominal_pengajuan' => str_replace('.', '', $this->total),
                'pencairan_status' => 'Belum Dicairkan',
                'approval_status' => 'Belum Direspon',
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
            ]);
            $this->emit('waktu_alert');
            $this->dispatchBrowserEvent('create_rencana');
            $this->detail_rencana($id_pengajuan_detail);
            session()->flash('success', 'Rencana Pentasyarufan Berhasil Ditambahkan');
        }
        // update
        else {
            PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
                'petugas_' . $tingkat => $this->petugas,
                'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
                'tgl_setor' => $this->tgl_setor,
                'pengajuan_note' => $this->pengajuan_note,
                'id_program' => $this->id_program,
                'id_program_pilar' => $this->id_program_pilar,
                'id_program_kegiatan' => $this->id_program_kegiatan,
                'nama_penerima' => $this->nama_penerima,
                'jumlah_penerima' => $this->jumlah_penerima,
                'satuan_pengajuan' => str_replace('.', '', $this->satuan_pengajuan),
                'nominal_pengajuan' => str_replace('.', '', $this->total),
                'pencairan_status' => 'Belum Dicairkan',
                'approval_status' => 'Belum Direspon',
                'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
            ]);
            // $this->emit('waktu_alert');
            // $this->dispatchBrowserEvent('create_rencana');
            // $this->detail_rencana($this->id_pengajuan_detail);
            // session()->flash('success', 'Rencana Pentasyarufan Berhasil Diubah');
            return redirect('/upzis/detail-pengajuan/' . $this->id_pengajuan)->with('success', 'Rencana Pentasyarufan Berhasil Diubah');
        }
    }

    public function create_edit_penerima()
    {
        $id_pengajuan_penerima = Str::uuid()->toString();
        if ($this->data->status_rekomendasi == 'Belum Terbit') {
            // create
            if ($this->id_pengajuan_penerima == NULL or $this->id_pengajuan_detail == '') {
                PengajuanPenerima::create([
                    'id_pengajuan_penerima' =>  $id_pengajuan_penerima,
                    'id_pengajuan' => $this->id_pengajuan,
                    'id_pengajuan_detail' => $this->id_pengajuan_detail,
                    'nama' => $this->penerima_manfaat,
                    'alamat' => $this->alamat_penerima,
                    'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
                    'keterangan' => $this->penerima_note,
                    'tgl_bantuan' => $this->tgl_bantuan,
                    'jenis_bantuan' => $this->jenis_bantuan,
                    'nik' => $this->nik,
                    'nokk' => $this->nokk,
                    'nohp' => $this->nohp,
                ]);
                PengajuanPenerimaLPJ::create([
                    'id_pengajuan_penerima' =>  $id_pengajuan_penerima,
                    'id_pengajuan' => $this->id_pengajuan,
                    'id_pengajuan_detail' => $this->id_pengajuan_detail,
                    'nama' => $this->penerima_manfaat,
                    'alamat' => $this->alamat_penerima,
                    'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
                    'keterangan' => $this->penerima_note,
                    'tgl_bantuan' => $this->tgl_bantuan,
                    'jenis_bantuan' => $this->jenis_bantuan,
                    'nik' => $this->nik,
                    'nokk' => $this->nokk,
                    'nohp' => $this->nohp,
                ]);
                $this->emit('waktu_alert');
                $this->dispatchBrowserEvent('create_penerima2');
                $this->detail_rencana($this->id_pengajuan_detail);
                session()->flash('success', 'Penerima Manfaat Berhasil Ditambahkan');
            } else {
                PengajuanPenerima::where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->update([
                    'nama' => $this->penerima_manfaat,
                    'alamat' => $this->alamat_penerima,
                    'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
                    'keterangan' => $this->penerima_note,
                    'tgl_bantuan' => $this->tgl_bantuan,
                    'jenis_bantuan' => $this->jenis_bantuan,
                    'nik' => $this->nik,
                    'nokk' => $this->nokk,
                    'nohp' => $this->nohp,
                ]);
                PengajuanPenerimaLPJ::where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->update([
                    'nama' => $this->penerima_manfaat,
                    'alamat' => $this->alamat_penerima,
                    'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
                    'keterangan' => $this->penerima_note,
                    'tgl_bantuan' => $this->tgl_bantuan,
                    'jenis_bantuan' => $this->jenis_bantuan,
                    'nik' => $this->nik,
                    'nokk' => $this->nokk,
                    'nohp' => $this->nohp,
                ]);

                $this->emit('waktu_alert');
                $this->dispatchBrowserEvent('create_penerima2');
                $this->detail_rencana($this->id_pengajuan_detail);
                session()->flash('success', 'Penerima Manfaat Berhasil Diubah');
            }
        } elseif ($this->data->status_rekomendasi == 'Sudah Terbit') {
            // create
            if ($this->id_pengajuan_penerima == NULL or $this->id_pengajuan_detail == '') {
                PengajuanPenerimaLPJ::create([
                    'id_pengajuan_penerima' =>  $id_pengajuan_penerima,
                    'id_pengajuan' => $this->id_pengajuan,
                    'id_pengajuan_detail' => $this->id_pengajuan_detail,
                    'nama' => $this->penerima_manfaat,
                    'alamat' => $this->alamat_penerima,
                    'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
                    'keterangan' => $this->penerima_note,
                    'tgl_bantuan' => $this->tgl_bantuan,
                    'jenis_bantuan' => $this->jenis_bantuan,
                    'nik' => $this->nik,
                    'nokk' => $this->nokk,
                    'nohp' => $this->nohp,
                ]);
                $this->emit('waktu_alert');
                $this->dispatchBrowserEvent('create_penerima3');
                $this->detail_laporan($this->id_pengajuan_detail);
                session()->flash('success', 'Penerima Manfaat Berhasil Ditambahkan');
            } else {
                PengajuanPenerimaLPJ::where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->update([
                    'nama' => $this->penerima_manfaat,
                    'alamat' => $this->alamat_penerima,
                    'nominal_bantuan' => str_replace('.', '', $this->nominal_bantuan),
                    'keterangan' => $this->penerima_note,
                    'tgl_bantuan' => $this->tgl_bantuan,
                    'jenis_bantuan' => $this->jenis_bantuan,
                    'nik' => $this->nik,
                    'nokk' => $this->nokk,
                    'nohp' => $this->nohp,
                ]);

                $this->emit('waktu_alert');
                $this->dispatchBrowserEvent('create_penerima3');
                $this->detail_laporan($this->id_pengajuan_detail);
                session()->flash('success', 'Penerima Manfaat Berhasil Diubah');
            }
        }
    }

    // public function create_edit_kegiatan()
    // {
    //     $id_pengajuan_kegiatan = Str::uuid()->toString();
    //     if ($this->id_pengajuan_kegiatan == NULL or $this->id_pengajuan_kegiatan == '') {
    //         PengajuanKegiatan::create([
    //             'id_pengajuan_kegiatan' => $id_pengajuan_kegiatan,
    //             'id_pengajuan' => $this->id_pengajuan,
    //             'id_pengajuan_detail' => $this->id_pengajuan_detail,
    //             'tgl_kegiatan' => $this->tgl_kegiatan,
    //             'lokasi' => $this->lokasi,
    //             'judul' => $this->judul_kegiatan,
    //             'jumlah_kehadiran' => $this->jumlah_kehadiran,
    //             'kendala' => $this->kendala,
    //             'ringkasan' => $this->ringkasan,
    //             'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
    //         ]);
    //         session()->flash('success', 'Kegiatan Berhasil Ditambahkan');
    //     } else {
    //         PengajuanKegiatan::where('id_pengajuan_kegiatan', $this->id_pengajuan_kegiatan)->update([
    //             'tgl_kegiatan' => $this->tgl_kegiatan,
    //             'lokasi' => $this->lokasi,
    //             'judul' => $this->judul_kegiatan,
    //             'jumlah_kehadiran' => $this->jumlah_kehadiran,
    //             'kendala' => $this->kendala,
    //             'ringkasan' => $this->ringkasan,
    //             'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
    //         ]);
    //         session()->flash('success', 'Kegiatan Berhasil Diubah');
    //     }
    //     $this->emit('waktu_alert');
    //     $this->dispatchBrowserEvent('openTabDokumentasi');
    //     $this->detail_laporan($this->id_pengajuan_detail);
    // }

    // public function create_edit_pengeluaran()
    // {
    //     $id_pengajuan_pengeluaran = Str::uuid()->toString();
    //     if ($this->id_pengajuan_pengeluaran == NULL or $this->id_pengajuan_pengeluaran == '') {
    //         $ext = $this->nota->extension();
    //         $nota_name = 'NP-' . Str::random(10) . '.' . $ext;
    //         $this->nota->storeAs('nota_pengeluaran', $nota_name);
    //         PengajuanPengeluaran::create([
    //             'id_pengajuan_pengeluaran' => $id_pengajuan_pengeluaran,
    //             'id_pengajuan' => $this->id_pengajuan,
    //             'id_pengajuan_detail' => $this->id_pengajuan_detail,
    //             'judul' => $this->judul_pengeluaran,
    //             'tgl_pengeluaran' => $this->tgl_pengeluaran,
    //             'jumlah' => $this->jumlah,
    //             'nominal_pengeluaran' =>  str_replace('.', '', $this->nominal_pengeluaran),
    //             'nota' => $nota_name,
    //             'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
    //         ]);
    //         session()->flash('pengeluaran', 'Pengeluaran Berhasil Ditambahkan');
    //     } else {
    //         $pengeluaran = PengajuanPengeluaran::where('id_pengajuan_pengeluaran', $this->id_pengajuan_pengeluaran)->first();

    //         if ($this->nota != NULL) {
    //             $path = public_path() . "/uploads/nota_pengeluaran/" . $pengeluaran->nota;
    //             if (file_exists($path)) {
    //                 unlink($path);
    //             }
    //             $ext = $this->nota->extension();
    //             $nota_name = 'DK-' . Str::random(10) . '.' . $ext;
    //             $this->nota->storeAs('nota_pengeluaran', $nota_name);
    //         } else {
    //             $nota_name = $pengeluaran->nota;
    //         }
    //         PengajuanPengeluaran::where('id_pengajuan_pengeluaran', $this->id_pengajuan_pengeluaran)->update([
    //             'judul' => $this->judul_pengeluaran,
    //             'tgl_pengeluaran' => $this->tgl_pengeluaran,
    //             'jumlah' => $this->jumlah,
    //             'nominal_pengeluaran' =>  str_replace('.', '', $this->nominal_pengeluaran),
    //             'nota' => $nota_name,
    //             'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
    //         ]);
    //         session()->flash('pengeluaran', 'Pengeluaran Berhasil Diubah');
    //     }
    //     $this->id_pengajuan_pengeluaran = '';
    //     $this->judul_pengeluaran = '';
    //     $this->tgl_pengeluaran = '';
    //     $this->jumlah = '';
    //     $this->nominal_pengeluaran = '';
    //     $this->nota = null;
    //     $this->emit('waktu_alert');
    //     $this->dispatchBrowserEvent('openTabPengeluaran');
    //     $this->detail_laporan($this->id_pengajuan_detail);
    // }

    public function detail_rencana($id)
    {
        $this->id_pengajuan_detail = $id;
        $this->data_detail = PengajuanDetail::where('id_pengajuan_detail', $id)->first();
        $this->data_penerima = PengajuanPenerima::where('id_pengajuan_detail', $id)->orderBy('created_at', 'desc')->get();
        $this->data_penerima_lpj = PengajuanPenerimaLPJ::where('id_pengajuan_detail', $id)->orderBy('created_at', 'desc')->get();
        $this->data_lampiran_berita = LampiranBerita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->orderBy('created_at', 'desc')
            ->get();
        if ($this->data_detail->approval_status == 'Disetujui') {
            $this->satuan_disetujui = number_format($this->data_detail->satuan_disetujui, 0, '.', '.');
            $this->satuan_pencairan = number_format($this->data_detail->satuan_disetujui, 0, '.', '.');
        } elseif ($this->data_detail->approval_status == 'Belum Direspon') {
            $this->satuan_disetujui = number_format($this->data_detail->satuan_pengajuan, 0, '.', '.');
        } elseif ($this->data_detail->approval_status == 'Ditolak') {
            $this->satuan_disetujui = number_format($this->data_detail->satuan_pengajuan, 0, '.', '.');
        }
        $this->approval_note = $this->data_detail->approval_note;
        $this->denial_note = $this->data_detail->denial_note;
        if ($this->data_detail->pencairan_status == 'Berhasil Dicairkan') {
            $this->id_rekening = $this->data_detail->id_rekening;
            $this->satuan_pencairan = number_format($this->data_detail->satuan_pencairan, 0, '.', '.');
            $this->pencairan_note = $this->data_detail->pencairan_note;
        } else {
            $this->id_rekening = '';
            $this->satuan_pencairan = number_format($this->data_detail->satuan_disetujui, 0, '.', '.');
        }
        $this->pencairan_note = $this->data_detail->pencairan_note;
    }

    public function detail_laporan($id)
    {
        $this->data_detail = PengajuanDetail::where('id_pengajuan_detail', $id)->first();
        $this->id_pengajuan_detail = $id;
        // penerima manfaat lpj
        $this->data_penerima_lpj = PengajuanPenerimaLPJ::where('id_pengajuan_detail', $id)->orderBy('created_at', 'desc')->get();
        // berita
        // $this->konfirmasi_note = $this->data_detail->konfirmasi_note;
        $this->diperiksa_note = $this->data_detail->diperiksa_note;
        $this->diperiksa_note_rev = $this->data_detail->diperiksa_note_rev;
        // lampiran 
        $this->data_lampiran_berita = LampiranBerita::where('id_pengajuan_detail', $this->id_pengajuan_detail)->orderBy('created_at', 'desc')
            ->get();

        // // dokumentasi
        // $this->kegiatan = PengajuanKegiatan::where('id_pengajuan_detail', $id)->first();
        // $this->dataDokumentasi = PengajuanDokumentasi::where('id_pengajuan_detail', $id)->get();
        // $this->foto_kegiatan = NULL;
        // $this->judul_foto = '';
        // // pengeluaran
        // $this->dataPengeluaran = PengajuanPengeluaran::where('id_pengajuan_detail', $id)
        //     ->orderBy('created_at', 'DESC')->get();
        // // berita
        // $this->id_pengajuan_penerima = $this->data_detail->id_pengajuan_penerima ?? '';
        // $this->getPenerimaForBerita();
        // $this->list_penerima = PengajuanPenerima::where('id_pengajuan_detail', $id)->get();
    }

    public function detail_lampiran($id)
    {
        $this->penerima_lpj = PengajuanPenerimaLPJ::where('id_pengajuan_penerima', $id)->first();
        $this->data_lampiran = LampiranPenerimaLPJ::where('id_penerima_lpj', $this->penerima_lpj->id_pengajuan_penerima)->orderBy('created_at', 'desc')
            ->get();
        $this->judul_file = '';
        $this->file = '';
        $this->dispatchBrowserEvent('lampiran');
    }

    // public function modal_kegiatan($id)
    // {
    //     $this->id_pengajuan_kegiatan = $id;
    //     $this->judul_kegiatan = $this->kegiatan->judul;
    //     $this->lokasi = $this->kegiatan->lokasi;
    //     $this->tgl_kegiatan = $this->kegiatan->tgl_kegiatan;
    //     $this->jumlah_kehadiran = $this->kegiatan->jumlah_kehadiran;
    //     $this->kendala = $this->kegiatan->kendala;
    //     $this->ringkasan = $this->kegiatan->ringkasan;
    // }

    // public function modal_edit_pengeluaran($id, $judul_pengeluaran, $tgl_pengeluaran, $jumlah, $nominal_pengeluaran)
    // {
    //     $this->id_pengajuan_pengeluaran = $id;
    //     $this->judul_pengeluaran = $judul_pengeluaran;
    //     $this->tgl_pengeluaran = $tgl_pengeluaran;
    //     $this->jumlah = $jumlah;
    //     $this->nominal_pengeluaran = number_format($nominal_pengeluaran, 0, '.', '.');
    //     // $this->nota = $nota;
    // }

    public function modal_edit_rencana($id)
    {
        $this->id_pengajuan_detail = $id;
        $this->tgl_pelaksanaan = $this->data_detail->tgl_pelaksanaan;
        $this->tgl_setor = $this->data_detail->tgl_setor;
        $this->id_program = $this->data_detail->id_program;
        $this->id_program_pilar = $this->data_detail->id_program_pilar;
        $this->id_program_kegiatan = $this->data_detail->id_program_kegiatan;
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $this->petugas = $this->data_detail->petugas_upzis;
        } elseif ($this->data->tingkat == 'Ranting NU') {
            $this->petugas = $this->data_detail->petugas_ranting;
        }
        $this->nama_penerima = $this->data_detail->nama_penerima;
        $this->satuan_pengajuan = number_format($this->data_detail->satuan_pengajuan, 0, '.', '.');
        $this->jumlah_penerima = $this->data_detail->jumlah_penerima;
        $this->total = number_format($this->data_detail->total, 0, '.', '.');
        $this->pengajuan_note = $this->data_detail->jumlah_penerima;

        $this->dispatchBrowserEvent('edit_rencana');
    }

    // public function modal_edit_penerima($id, $nama, $nominal_bantuan, $alamat_penerima, $keterangan)
    // {
    //     // dd($this->data->status_rekomendasi);
    //     $this->id_pengajuan_penerima = $id;
    //     $this->penerima_manfaat = $nama;
    //     $this->nominal_bantuan = number_format($nominal_bantuan, 0, '.', '.');
    //     $this->alamat_penerima = $alamat_penerima;
    //     $this->penerima_note = $keterangan;

    //     $this->dispatchBrowserEvent('create_penerima');
    // }

    public function modal_edit_penerima($id, $nama, $nominal_bantuan, $alamat_penerima, $keterangan, $tgl_bantuan, $jenis_bantuan, $nik, $nokk, $nohp)
    {
        // dd($this->data->status_rekomendasi);
        $this->id_pengajuan_penerima = $id;
        $this->penerima_manfaat = $nama;
        $this->nominal_bantuan = number_format($nominal_bantuan, 0, '.', '.');
        $this->alamat_penerima = $alamat_penerima;
        $this->penerima_note = $keterangan;
        $this->tgl_bantuan = $tgl_bantuan;
        $this->jenis_bantuan = $jenis_bantuan;
        $this->nik = $nik;
        $this->nokk = $nokk;
        $this->nohp = $nohp;
        $this->dispatchBrowserEvent('create_penerima');
    }

    public function modal_edit_berita()
    {
        if ($this->data_detail->tgl_berita) {
            $this->tgl_berita = $this->data_detail->tgl_berita;
        } else {
            $this->tgl_berita = date('Y-m-d');
        }

        if ($this->data_detail->senilai) {
            $this->senilai = number_format($this->data_detail->senilai, 0, '.', '.');
        } else {
            $this->senilai = NULL;;
        }
        $this->berupa = $this->data_detail->berupa;

        if ($this->data_detail->nama1 or $this->data_detail->jabatan1 or $this->data_detail->nohp1 or $this->data_detail->alamat1) {
            $this->nama1 = $this->data_detail->nama1;
            $this->jabatan1 = $this->data_detail->jabatan1;
            $this->nohp1 = $this->data_detail->nohp1;
            $this->alamat1 = $this->data_detail->alamat1;
        } else {
            if ($this->data->tingkat == 'Upzis MWCNU') {
                $this->nama1 = Helper::getNamaPengurus('upzis', $this->data_detail->petugas_upzis);
                $this->jabatan1 = Helper::getJabatanPengurus('upzis', $this->data_detail->petugas_upzis);
                $this->nohp1 = Helper::getNohpPengurus('upzis', $this->data_detail->petugas_upzis);
                $this->alamat1 = Helper::getAlamatPengurus('upzis', $this->data_detail->petugas_upzis);
            } elseif ($this->data->tingkat == 'Ranting NU') {
                $this->nama1 = Helper::getNamaPengurus('ranting', $this->data_detail->petugas_ranting);
                $this->jabatan1 = Helper::getJabatanPengurus('ranting', $this->data_detail->petugas_ranting);
                $this->nohp1 = Helper::getNohpPengurus('ranting', $this->data_detail->petugas_ranting);
                $this->alamat1 = Helper::getAlamatPengurus('ranting', $this->data_detail->petugas_ranting);
            }
        }

        $this->nama2 = $this->data_detail->nama2;
        $this->jabatan2 = $this->data_detail->jabatan2;
        $this->nohp2 = $this->data_detail->nohp2;
        $this->alamat2 = $this->data_detail->alamat2;
    }

    public function edit_berita()
    {
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
        $this->detail_laporan($this->id_pengajuan_detail);
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('edit_penerima');
        session()->flash('success', 'Berita Acara Berhasil Diubah');
    }

    public function batalBerita()
    {
        $this->dispatchBrowserEvent('edit_penerima');
    }

    public function modal_tambah_lampiran_berita()
    {
        $this->judul_file = '';
        $this->file = '';
    }

    public function modal_tambah_penerima()
    {

        $this->id_pengajuan_penerima = '';
        $this->penerima_manfaat = '';
        $this->nominal_bantuan = number_format($this->data_detail->satuan_pengajuan, 0, '.', '.');
        $this->alamat_penerima = '';
        $this->penerima_note = '';
        $this->tgl_bantuan = '';
        $this->jenis_bantuan = '';
        $this->nik = '';
        $this->nokk = '';
        $this->nohp = '';
        $this->dispatchBrowserEvent('create_penerima');
    }

    // public function deleteFotoKegiatan($id, $foto_kegiatan)
    // {
    //     $path = public_path() . "/uploads/pengajuan_dokumentasi/" . $foto_kegiatan;
    //     if (file_exists($path)) {
    //         unlink($path);
    //     }
    //     PengajuanDokumentasi::where('id_pengajuan_dokumentasi', $id)->delete();
    //     $this->foto_kegiatan = NULL;
    //     $this->judul_foto = '';
    //     $this->emit('waktu_alert');
    //     // $this->emit('closeUploadFoto');
    //     $this->dispatchBrowserEvent('openTabDokumentasi');
    //     session()->flash('foto', 'Foto Kegiatan Berhasil Dihapus');
    //     $this->detail_laporan($this->id_pengajuan_detail);
    // }


    public function collapse_delete_penerima($id, $nama)
    {
        $this->id_pengajuan_penerima = $id;
        $this->nama_penerima = $nama;
        $this->detail_laporan($this->id_pengajuan_detail);
    }

    public function delete_penerima($id)
    {
        // $this->refresh();

        $data = LampiranPenerimaLPJ::where('id_penerima_lpj', $id)->get();
        foreach ($data as $a) {
            $path = public_path() . "/uploads/lampiran_penerima_lpj/" . str_replace('/', '_', $this->data->nomor_surat) . '/' . $a->file;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        try {
            File::delete($path);
        } catch (\Exception $e) {
            // Tangani error di sini
        }
        LampiranPenerimaLPJ::where('id_penerima_lpj', $id)->delete();

        if ($this->data->status_rekomendasi == 'Belum Terbit') {
            PengajuanPenerima::where('id_pengajuan_penerima', $id)->delete();
            PengajuanPenerimaLPJ::where('id_pengajuan_penerima', $id)->delete();
            $this->emit('waktu_alert');
            $this->dispatchBrowserEvent('create_penerima2');
            $this->detail_rencana($this->id_pengajuan_detail);
            session()->flash('success', 'Penerima Manfaat Berhasil Dihapus');
        } elseif ($this->data->status_rekomendasi == 'Sudah Terbit') {

            PengajuanPenerimaLPJ::where('id_pengajuan_penerima', $id)->delete();
            // DB::statement("DELETE FROM pengajuan_penerima_lpj WHERE id_pengajuan_penerima = ?", [$id]);

            $this->emit('waktu_alert');
            $this->dispatchBrowserEvent('create_penerima3');
            $this->detail_laporan($this->id_pengajuan_detail);
            session()->flash('success', 'Penerima Manfaat Berhasil Dihapus');
            // $this->emit('refreshComponent');
        }

        $this->penerima_lpj = '';
        $this->data_lampiran = [];

        $this->id_pengajuan_penerima = '';
        $this->nama_penerima = '';
    }

    public function delete_pengajuan_detail($id)
    {
        PengajuanPenerima::where('id_pengajuan_detail', $id)->delete();
        PengajuanDetail::where('id_pengajuan_detail', $id)->delete();

        return redirect()->to('/upzis/detail-pengajuan/' . $this->id_pengajuan)->with('success', 'Detail Rencana Pentasyarufan Berhasil Dihapus!');
    }

    public function acc()
    {
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'approval_date' =>  date('Y-m-d'),
            'approval_note' => $this->approval_note,
            'approval_status' => 'Disetujui',
            // 'id_rekening' => $this->id_rekening,
            'approver_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
            'satuan_disetujui' => str_replace('.', '', $this->satuan_disetujui),
            'nominal_disetujui' => str_replace('.', '', $this->satuan_disetujui) * $this->data_detail->jumlah_penerima,
        ]);
        $this->detail_rencana($this->id_pengajuan_detail);
        $this->emit('waktu_alert');
        $this->emit('acc');
        session()->flash('accTolak', 'Rencana Pentasyarufan Berhasil di-ACC');
    }

    public function tolak()
    {
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'approval_date' =>  NULL,
            'approval_note' => NULL,
            'approval_status' => 'Ditolak',
            'satuan_disetujui' => NULL,
            'nominal_disetujui' => NULL,
            'denial_date' => date('Y-m-d'),
            'denial_note' => $this->denial_note,
            'approval_status' => 'Ditolak',
            'denial_tingkat_pc' => Auth::user()->gocap_id_pc_pengurus,
        ]);

        $this->detail_rencana($this->id_pengajuan_detail);
        $this->emit('waktu_alert');
        $this->emit('tolak');
        session()->flash('accTolak', 'Rencana Pentasyarufan Berhasil di-Tolak');

        // send notif wa
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $nama_pj = Helper::getNamaPengurus('upzis', $this->data->pj_upzis);
            $tingkat = 'UPZIS MWCNU ' . Helper::getNamaUpzis($this->data->id_upzis);
        } else {
            $nama_pj = Helper::getNamaPengurus('ranting', $this->data->pj_ranting);
            $tingkat = 'PRNU ' . Helper::getNamaRanting($this->data->id_ranting);
        }


        // maker upzis
        $this->notif(
             Helper::getNohpPengurus('upzis', $this->data->maker_tingkat_upzis),
            // '082138603051',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurus('upzis', $this->data->maker_tingkat_upzis) .  "*" . "\n" .
                Helper::getJabatanPengurus('upzis', $this->data->maker_tingkat_upzis)  . "\n" . "\n" .
                "Pengajuan Pentasyarufan Tingkat " . $tingkat . ", " . "*" . "ditolak" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $this->data->nomor_surat  . "\n" .
                "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                $nama_pj  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Nominal"  . "*" .  "\n" .
                'Rp' . number_format($this->data_detail->nominal_pengajuan, 0, '.', '.') .  "\n" .
                "*" .  "Pilar"  . "*" .  "\n" .
                Helper::getDataPilar($this->data_detail->id_program_pilar ?? null)->pluck('pilar')->first() .  "\n" .
                "*" .  "Kegiatan"  . "*" .  "\n" .
                Helper::getDataKegiatan($this->data_detail->id_program_kegiatan ?? null)->pluck('nama_program')->first()  .  "\n" .
                "*" .  "Alasan Penolakan"  . "*" .  "\n" .
                $this->data_detail->denial_note .  "\n" . "\n" .
                "Harap revisi data pentasyarufan, Terimakasih." . "\n" . "\n" .
                url($this->url)
        );
    }

    public function tolakPencairan()
    {
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'id_rekening' => NULL,
            'tgl_pencairan' => NULL,
            'tgl_tolak_pencairan' => NULL,
            'pencairan_status' => 'Ditolak',
            'staf_keuangan_pc' => Auth::user()->gocap_id_pc_pengurus,
            'satuan_pencairan' => NULL,
            'nominal_pencairan' => NULL,
            'pencairan_note' => $this->pencairan_note,
        ]);
        $this->detail_rencana($this->id_pengajuan_detail);
        $this->emit('waktu_alert');
        $this->emit('pencairan');
        session()->flash('pencairan', 'Pencairan Rencana Pentasyarufan Berhasil Ditolak');
    }


    public function pencairan()
    {
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'id_rekening' => $this->id_rekening,
            'tgl_pencairan' => date('Y-m-d'),
            'pencairan_status' => 'Berhasil Dicairkan',
            'staf_keuangan_pc' => Auth::user()->gocap_id_pc_pengurus,
            'satuan_pencairan' => str_replace('.', '', $this->satuan_pencairan),
            'nominal_pencairan' => str_replace('.', '', $this->satuan_pencairan) * $this->data_detail->jumlah_penerima,
            'pencairan_note' => $this->pencairan_note,
        ]);

        $this->detail_rencana($this->id_pengajuan_detail);
        $this->emit('waktu_alert');
        $this->emit('pencairan');
        session()->flash('pencairan', 'Rencana Pentasyarufan Bisa Dicairkan');
    }

    public function updateTotal()
    {
        $a = str_replace('.', '', $this->jumlah_penerima);
        $b = str_replace('.', '', $this->satuan_pengajuan);
        $this->total = number_format((int)$a * (int)$b, 0, '.', '.');
        return ($this->total);
    }
    public function updateTotal2()
    {
        $a = str_replace('.', '', $this->data_detail->jumlah_penerima ?? null);
        $b = str_replace('.', '', $this->satuan_disetujui);
        $this->nominal = number_format((int)$a * (int)$b, 0, '.', '.');
        return ($this->nominal);
    }
    public function updateTotal3()
    {
        $a = str_replace('.', '', $this->data_detail->jumlah_penerima ?? null);
        $b = str_replace('.', '', $this->satuan_pencairan);
        $this->nominal = number_format((int)$a * (int)$b, 0, '.', '.');
        return ($this->nominal);
    }

    // public function getPenerimaForBerita()
    // {
    //     $data = PengajuanPenerima::where('id_pengajuan', $this->id_pengajuan)->where('id_pengajuan_detail', $this->id_pengajuan_detail)->where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->first() ?? null;
    //     $this->no_identitas = $data->no_identitas ?? null;
    //     $this->jalan = $data->jalan ?? null;
    //     $this->rt = $data->rt ?? null;
    //     $this->rw = $data->rw ?? null;
    //     $this->desakelurahan = $data->desakelurahan ?? null;
    //     $this->kecamatan = $data->kecamatan ?? null;
    //     $this->kabupaten = $data->kabupaten ?? null;
    //     $this->tempat_tgl_lahir = $data->tempat_tgl_lahir ?? null;
    //     $this->nohp = $data->nohp ?? null;
    //     $this->jabatan = $data->jabatan ?? null;
    //     $this->tgl_bantuan = $data->tgl_bantuan ?? null;
    //     $this->tgl_pentasyarufan = $data->tgl_pentasyarufan ?? null;
    // }

    public function resetValue()
    {
        // detail-rencana
        $this->data_detail = NULL;
        $this->id_pengajuan_detail = '';
        $this->tgl_pelaksanaan = date('Y-m-d');
        $this->tgl_setor = '';
        $this->id_program = '';
        $this->id_program_pilar = '';
        $this->id_program_kegiatan = '';
        $this->nama_penerima = '';
        $this->satuan_pengajuan = '';
        $this->jumlah_penerima = '';
        $this->total = '';
        $this->pengajuan_note = '';
        // detail-laporan
        // $this->kegiatan = NULL;
        $this->dispatchBrowserEvent('auto');
    }

    public function uploadLampiranPenerimaLPJ()
    {
        $ext = $this->file->extension();
        $file_name = Str::uuid()->toString() . '.' . $ext;
        $this->file->storeAs('lampiran_penerima_lpj/' . str_replace('/', '_', $this->data->nomor_surat), $file_name);

        $folderPath = public_path() . '/uploads/lampiran_penerima_lpj/' . str_replace('/', '_', $this->data->nomor_surat);
        chmod($folderPath, 0755);


        LampiranPenerimaLPJ::create([
            'id_lampiran_lpj' =>  Str::uuid()->toString(),
            'id_penerima_lpj' => $this->penerima_lpj->id_pengajuan_penerima,
            'judul_file' => $this->judul_file,
            'file' => $file_name,
        ]);
        $this->judul_file = '';
        $this->file = '';
        $this->detail_lampiran($this->penerima_lpj->id_pengajuan_penerima);
        // $this->mount();
        $this->emit('waktu_alert');
        session()->flash('success', 'File Berhasil di-Upload');
        // $this->dispatchBrowserEvent('afterUploadPengajuan');
    }

    public function uploadLampiranBerita()
    {
        $ext = $this->file->extension();
        $file_name = Str::uuid()->toString() . '.' . $ext;
        $this->file->storeAs('lampiran_berita/' . str_replace('/', '_', $this->data->nomor_surat), $file_name);

        $folderPath = public_path() . '/uploads/lampiran_berita/' . str_replace('/', '_', $this->data->nomor_surat);
        chmod($folderPath, 0755);

        LampiranBerita::create([
            'id_lampiran_berita' =>  Str::uuid()->toString(),
            'id_pengajuan_detail' => $this->id_pengajuan_detail,
            'judul_file' => $this->judul_file,
            'file' => $file_name,
        ]);
        $this->judul_file = '';
        $this->file = '';
        $this->detail_laporan(($this->id_pengajuan_detail));
        // $this->mount();
        $this->emit('waktu_alert');
        session()->flash('success', 'File Berhasil di-Upload');
        $this->dispatchBrowserEvent('afterUploadLampiranBerita');
    }

    public function deleteLampiranLPJ($id, $file)
    {
        $path = public_path() . "/uploads/lampiran_penerima_lpj/" . str_replace('/', '_', $this->data->nomor_surat) . '/' . $file;
        // dd($path);
        if (file_exists($path)) {
            unlink($path);
        }

        LampiranPenerimaLPJ::where('id_lampiran_lpj', $id)->delete();
        $this->detail_lampiran($this->penerima_lpj->id_pengajuan_penerima);
        // $this->mount();
        $this->emit('waktu_alert');
        session()->flash('success', 'File Berhasil Dihapus');
    }

    public function modalHapusLampiranBerita($id, $file)
    {
        $this->id_lampiran_berita = $id;
        $this->file_berita = $file;
    }

    public function deleteLampiranBerita()
    {

        // dd('wdwd');

        $path = public_path() . "/uploads/lampiran_berita/" . str_replace('/', '_', $this->data->nomor_surat) . '/' . $this->file_berita;
        // dd($path);
        if (file_exists($path)) {
            unlink($path);
        }

        LampiranBerita::where('id_lampiran_berita',  $this->id_lampiran_berita)->delete();

        $this->id_lampiran_berita = '';
        $this->file_berita = '';

        $this->detail_laporan($this->id_pengajuan_detail);
        $this->emit('waktu_alert');
        session()->flash('success', 'File Berhasil Dihapus');
    }

    public function uploadKonfirmasi()
    {
        if ($this->data->scan != null) {
            $path = public_path() . "/uploads/pengajuan_konfirmasi/" . $this->data->scan;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $ext = $this->scan_konfirmasi->extension();
        $file_scan_name = str_replace('/', '_', $this->data->nomor_surat) . '_PERMOHONAN' . '.' . $ext;
        $this->scan_konfirmasi->storeAs('pengajuan_konfirmasi', $file_scan_name);
        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'status_pengajuan' => 'Diajukan',
            'tgl_konfirmasi' => date('Y-m-d'),
            'scan' => $file_scan_name,
            'dikonfirmasi_oleh_upzis' => Auth::user()->gocap_id_upzis_pengurus
        ]);
        $this->scan_konfirmasi = '';
        $this->mount();
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('afterUploadPengajuan');
        session()->flash('konfirmasi', 'Berkas Berhasil di-Upload');

        // send notif wa
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $nama_pj = Helper::getNamaPengurus('upzis', $this->data->pj_upzis);
            $tingkat = 'UPZIS MWCNU ' . Helper::getNamaUpzis($this->data->id_upzis);
            $programs =  "*" .  "Nominal Pengajuan"  . "*" .  "\n" .
                "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                '(Rp' . number_format($this->jumlah_nominal_a, 0, '.', '.') . ')' . "\n" .
                "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                '(Rp' . number_format($this->jumlah_nominal_b, 0, '.', '.') . ')' . "\n" .
                "*" .  "3. OPERASIONAL UPZIS"  . "*" .  "\n" .
                '(Rp' . number_format($this->jumlah_nominal_c, 0, '.', '.') . ')' . "\n" . "\n";
        } else {
            $nama_pj = Helper::getNamaPengurus('ranting', $this->data->pj_ranting);
            $tingkat = 'PRNU ' . Helper::getNamaRanting($this->data->id_ranting);
            $programs =  "*" .  "Nominal Pengajuan"  . "*" .  "\n" .
                "*" .  "1. PROGRAM PENGUATAN KELEMBAGAAN"  . "*" .  "\n" .
                '(Rp' . number_format($this->jumlah_nominal_a, 0, '.', '.') . ')' . "\n" .
                "*" .  "2. PROGRAM SOSIAL"  . "*" .  "\n" .
                '(Rp' . number_format($this->jumlah_nominal_b, 0, '.', '.') . ')' . "\n" . "\n";
        }

        // direktur
        $this->notif(
             Helper::getNohpByIdJabatan('pc', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3'),
            // '082138603051',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurusByIdJabatan('pc', $this->data->id_pc, '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3') .  "*" . "\n" .
                Helper::getJabatanPengurusByIdJabatan('pc', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')  . "\n" . "\n" .
                "*" .  "Mohon segera direspon"  . "*" .  "\n" .
                "Pengajuan Pentasyarufan Tingkat " . $tingkat . ", " . "*" . "telah dikonfirmasi" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $this->data->nomor_surat  . "\n" .
                "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                $nama_pj . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                $programs .
                "Terima Kasih." . "\n" .
                url($this->url)
        );

        // divisi keuangan 2
        $this->notif(
             Helper::getNohpByIdJabatan('pc', '3b5ce3c4-a045-11ed-a0ac-040300000000'),
            // '082138603051',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurusByIdJabatan('pc', $this->data->id_pc, '3b5ce3c4-a045-11ed-a0ac-040300000000') .  "*" . "\n" .
                Helper::getJabatanPengurusByIdJabatan('pc', '3b5ce3c4-a045-11ed-a0ac-040300000000')  . "\n" . "\n" .
                "*" .  "Mohon segera direspon"  . "*" .  "\n" .
                "Pengajuan Pentasyarufan Tingkat " . $tingkat .  ", " . "*" . "telah dikonfirmasi" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $this->data->nomor_surat  . "\n" .
                "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                $nama_pj  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                $programs .
                "Terima Kasih." . "\n" .
                url($this->url)
        );

        // maker upzis
        $this->notif(
             Helper::getNohpPengurus('upzis', $this->data->maker_tingkat_upzis),
            // '082138603051',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurus('upzis', $this->data->maker_tingkat_upzis) .  "*" . "\n" .
                Helper::getJabatanPengurus('upzis', $this->data->maker_tingkat_upzis)  . "\n" . "\n" .
                "Pengajuan Pentasyarufan Tingkat " . $tingkat .  ", " . "*" . "telah dikonfirmasi" . "*" . " dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor"  . "*" .  "\n" .
                $this->data->nomor_surat  . "\n" .
                "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                $nama_pj  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Tanggal Konfirmasi"  . "*" .  "\n" .
                \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" .
                $programs .
                "Terima Kasih." . "\n" .
                url($this->url)
        );
    }

    public function uploadBerita()
    {

        if ($this->data_detail->file_berita != null) {
            $path = public_path() . "/uploads/pengajuan_berita/" . $this->data_detail->file_berita;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $ext = $this->scan_berita->extension();
        $file_scan_name = Str::uuid()->toString() . '.' . $ext;
        $this->scan_berita->storeAs('pengajuan_berita', $file_scan_name);
        if ($this->data_detail->status_berita == 'Belum Dikonfirmasi' or $this->data_detail->status_berita == 'Sudah Dikonfirmasi') {
            PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
                'status_berita' => 'Sudah Dikonfirmasi',
                'file_berita' => $file_scan_name,
                'konfirmasi_note' => $this->konfirmasi_note,
                'tgl_konfirmasi' => date('Y-m-d'),
                'berita_konfirmasi_upzis' => Auth::user()->gocap_id_upzis_pengurus
            ]);
        }
        if ($this->data_detail->status_berita == 'Revisi') {
            PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
                'status_berita' => 'Revisi',
                'file_berita' => $file_scan_name,
                'konfirmasi_note' => $this->konfirmasi_note,
                'tgl_konfirmasi' => date('Y-m-d'),
                'berita_konfirmasi_upzis' => Auth::user()->gocap_id_upzis_pengurus
            ]);
        }
        // dd($file_scan_name);

        $this->scan_berita = '';
        $this->konfirmasi_note = '';
        $this->mount();
        $this->detail_laporan(($this->id_pengajuan_detail));
        $this->emit('waktu_alert');
        session()->flash('success', 'Berkas Berhasil di-Upload');
    }

    public function accBerita()
    {
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'status_berita' => 'Sudah Diperiksa',
            'diperiksa_note' => $this->diperiksa_note,
            'tgl_diperiksa' => date('Y-m-d'),
            'berita_diperiksa_pc' => Auth::user()->gocap_id_pc_pengurus
        ]);
        $this->mount();
        $this->detail_laporan(($this->id_pengajuan_detail));
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('accTolakBerita');
        session()->flash('success', 'Berita Acara Berhasil di ACC');
    }

    public function tolakBerita()
    {
        PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
            'status_berita' => 'Revisi',
            'diperiksa_note_rev' => $this->diperiksa_note_rev,
            'tgl_diperiksa' => date('Y-m-d'),
            'berita_diperiksa_pc' => Auth::user()->gocap_id_pc_pengurus
        ]);
        $this->mount();
        $this->detail_laporan(($this->id_pengajuan_detail));
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('accTolakBerita');
        session()->flash('success', 'Berita Acara Ditolak/Revisi');
    }


    // public function uploadFotoKegiatan()
    // {

    //     $id_pengajuan_dokumentasi = Str::uuid()->toString();
    //     $ext = $this->foto_kegiatan->extension();
    //     $foto_kegiatan_name = 'DK-' . Str::random(10) . '.' . $ext;
    //     $this->foto_kegiatan->storeAs('pengajuan_dokumentasi', $foto_kegiatan_name);

    //     PengajuanDokumentasi::create([
    //         'id_pengajuan_dokumentasi' => $id_pengajuan_dokumentasi,
    //         'id_pengajuan' => $this->id_pengajuan,
    //         'id_pengajuan_detail' => $this->id_pengajuan_detail,
    //         'judul' => $this->judul_foto,
    //         'file' => $foto_kegiatan_name,
    //         'maker_tingkat_upzis' => Auth::user()->gocap_id_upzis_pengurus,
    //     ]);
    //     $this->judul_foto = '';
    //     $this->foto_kegiatan = NULL;
    //     $this->emit('waktu_alert');
    //     // $this->emit('closeUploadFoto');
    //     $this->dispatchBrowserEvent('openTabDokumentasi');
    //     session()->flash('foto', 'Foto Kegiatan Berhasil Ditambahkan');
    //     $this->detail_laporan($this->id_pengajuan_detail);
    // }

    public function buat_no_rekomendasi($tingkat)
    {
        if ($tingkat == 'upzis') {
            $tingkatDB = 'Upzis MWCNU';
            $tingkat = 'UPZIS';
        } elseif ($tingkat == 'ranting') {
            $tingkatDB = 'Ranting NU';
            $tingkat = 'RANTING';
        }
        $data = Pengajuan::where('tingkat', $tingkatDB)
            ->where('status_rekomendasi', 'Sudah Terbit')
            ->orderBy('tgl_terbit_rekomendasi', 'asc')
            ->get();

        // Mendapatkan nomor urut terakhir dari data yang ada di database
        $lastNoRekomendasi = $data->last()->no_rekom_bmt ?? null;

        // Jika data nomor urut terakhir tidak ada, nomor urut awal adalah 1
        if ($lastNoRekomendasi === null) {
            $no_urut = 1;
        } else {
            // Jika ada data nomor urut terakhir, ekstrak nomor urutnya dan tambahkan 1
            $no_urut = (int)explode('/', $lastNoRekomendasi)[0] + 1;
        }

        // Format nomor urut dengan 2 digit
        $no_urut_formatted = str_pad($no_urut, 2, '0', STR_PAD_LEFT);

        if ($tingkat == 'UPZIS') {
            foreach ($data as $a) {
                if (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '01') {
                    $romawi = 'I';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '02') {
                    $romawi = 'II';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '03') {
                    $romawi = 'III';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '04') {
                    $romawi = 'IV';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '05') {
                    $romawi = 'V';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '06') {
                    $romawi = 'VI';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '07') {
                    $romawi = 'VII';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '08') {
                    $romawi = 'VIII';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '09') {
                    $romawi = 'IX';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '10') {
                    $romawi = 'X';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '11') {
                    $romawi = 'XI';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '12') {
                    $romawi = 'XII';
                }

                // dd($this->data->tgl_terbit_rekomendasi);

                $no_rekom_bmt = $no_urut_formatted . 'A/RC-' . $tingkat . '/' . strtoupper(Helper::getNamaUpzis($a->id_upzis)) . '/11.34.10/' . $romawi . '/' . \Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('Y');
                $no_rekom_bri = $no_urut_formatted . 'B/RC-' . $tingkat . '/' . strtoupper(Helper::getNamaUpzis($a->id_upzis)) . '/11.34.10/' . $romawi . '/' . \Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('Y');

                Pengajuan::where('id_pengajuan', $a->id_pengajuan)->update([
                    'no_rekom_bmt' => $no_rekom_bmt,
                    'no_rekom_bri' => $no_rekom_bri
                ]);
                $no_urut++;
                $no_urut_formatted = str_pad($no_urut, 2, '0', STR_PAD_LEFT);
            }
        } elseif ($tingkat == 'RANTING') {
            foreach ($data as $a) {
                if (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '01') {
                    $romawi = 'I';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '02') {
                    $romawi = 'II';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '03') {
                    $romawi = 'III';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '04') {
                    $romawi = 'IV';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '05') {
                    $romawi = 'V';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '06') {
                    $romawi = 'VI';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '07') {
                    $romawi = 'VII';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '08') {
                    $romawi = 'VIII';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '09') {
                    $romawi = 'IX';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '10') {
                    $romawi = 'X';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '11') {
                    $romawi = 'XI';
                } elseif (\Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('MM') == '12') {
                    $romawi = 'XII';
                }
                $no_rekom_bmt = $no_urut_formatted . 'A/RC-' . $tingkat . '/' . strtoupper(Helper::getNamaUpzis($a->id_upzis)) . '-' . strtoupper(Helper::getNamaRanting($a->id_ranting)) . '/11.34.10/' . $romawi . '/' . \Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('Y');
                $no_rekom_bri = $no_urut_formatted . 'B/RC-' . $tingkat . '/' . strtoupper(Helper::getNamaUpzis($a->id_upzis)) . '-' . strtoupper(Helper::getNamaRanting($a->id_ranting)) . '/11.34.10/' . $romawi . '/' . \Carbon\Carbon::parse($a->tgl_terbit_rekomendasi)->isoFormat('Y');
                Pengajuan::where('id_pengajuan', $a->id_pengajuan)->update([
                    'no_rekom_bmt' => $no_rekom_bmt,
                    'no_rekom_bri' => $no_rekom_bri
                ]);
                $no_urut++;
                $no_urut_formatted = str_pad($no_urut, 2, '0', STR_PAD_LEFT);
            }
        }
    }

    public function rekomendasi()
    {
        // dd(Helper::getNohpByIdJabatan('pc', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3'));
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $tingkatDB = 'Upzis MWCNU';
            $tingkat = 'UPZIS';
        } elseif ($this->data->tingkat == 'Ranting NU') {
            $tingkatDB = 'Ranting NU';
            $tingkat = 'RANTING';
        }

        $max_no_urut = Pengajuan::where('tingkat', $tingkatDB)
            ->max(DB::raw("CAST(SUBSTRING_INDEX(no_rekom_bmt, '/', 1) AS UNSIGNED)"));

        // Jika data nomor urut terakhir tidak ada, nomor urut awal adalah 1
        if ($max_no_urut === null) {
            $no_urut1 = 1;
            $no_urut2 = 1;
        } else {
            // Jika ada data nomor urut terakhir, ekstrak nomor urutnya dan tambahkan 1
            $no_urut1 = (int)explode('A/', $max_no_urut)[0] + 1;
            $no_urut2 = (int)explode('B/', $max_no_urut)[0] + 1;
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

        // Format nomor urut dengan 2 digit
        $no_urut_formatted1 = str_pad($no_urut1, 2, '0', STR_PAD_LEFT);
        $no_urut_formatted2 = str_pad($no_urut2, 2, '0', STR_PAD_LEFT);

        if ($this->data->tingkat == 'Upzis MWCNU') {
            $no_rekom_bmt = $no_urut_formatted1 . 'A/RC-' . $tingkat . '/' . strtoupper(Helper::getNamaUpzis($this->data->id_upzis)) . '/11.34.10/' . $romawi . '/' . \Carbon\Carbon::parse($this->data->created_at)->isoFormat('Y');
            $no_rekom_bri = $no_urut_formatted2 . 'B/RC-' . $tingkat . '/' . strtoupper(Helper::getNamaUpzis($this->data->id_upzis)) . '/11.34.10/' . $romawi . '/' . \Carbon\Carbon::parse($this->data->created_at)->isoFormat('Y');
        } elseif ($this->data->tingkat == 'Ranting NU') {
            $no_rekom_bmt = $no_urut_formatted1 . 'A/RC-' . $tingkat . '/' . strtoupper(Helper::getNamaUpzis($this->data->id_upzis)) . '-' . strtoupper(Helper::getNamaRanting($this->data->id_ranting)) . '/11.34.10/' . $romawi . '/' . \Carbon\Carbon::parse($this->data->created_at)->isoFormat('Y');
            $no_rekom_bri = $no_urut_formatted2 . 'B/RC-' . $tingkat . '/' . strtoupper(Helper::getNamaUpzis($this->data->id_upzis)) . '-' . strtoupper(Helper::getNamaRanting($this->data->id_ranting)) . '/11.34.10/' . $romawi . '/' . \Carbon\Carbon::parse($this->data->created_at)->isoFormat('Y');
        }

        // dd($no_rekom_bmt);
        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'tgl_terbit_rekomendasi' => date('Y-m-d'),
            'status_rekomendasi' => 'Sudah Terbit',
            'no_rekom_bmt' => $no_rekom_bmt,
            'no_rekom_bri' => $no_rekom_bri,
            'direkomendasikan_oleh_pc' => Auth::user()->gocap_id_pc_pengurus
        ]);

        $data = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)->where('pencairan_status', 'Berhasil Dicairkan')->get();

        foreach ($data as $a) {
            Rekening::where('id_rekening', $a->id_rekening)->decrement('saldo', $a->nominal_pencairan);
            $id_arus_dana = Str::uuid();
            ArusDana::create([
                'id_arus_dana' => $id_arus_dana,
                'id_rekening' => $a->id_rekening,
                'jenis_dana' => 'keluar',
                'jenis_kas' => 'Pentasyarufan Koin NU',
                'nominal' => $a->nominal_pencairan,
                'tanggal_input' => date('Y-m-d'),
                'petugas_input_pc' => Auth::user()->gocap_id_pc_pengurus,
                'id_etasyaruf_permohonan_pentasyarufan_koin' => $a->id_pengajuan_detail,
                'uraian' => Helper::getDataKegiatan($a->id_program_kegiatan ?? null)->pluck('nama_program')->first()
            ]);
        }
        $this->mount();

        // send notif wa
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $nama_pj = Helper::getNamaPengurus('upzis', $this->data->pj_upzis);
            $tingkat = 'UPZIS MWCNU ' . Helper::getNamaUpzis($this->data->id_upzis);
            $kelembagaan = PrintController::sumTotalByProgram('bmt', $this->data->id_pengajuan, 'LEMBAGA');
            $sosial = PrintController::sumTotalByProgram('bmt', $this->data->id_pengajuan, 'SOSIAL');
            $operasional = PrintController::sumTotalByProgram('bmt', $this->data->id_pengajuan, 'OPERASIONAL');
            $kelembagaan2 = PrintController::sumTotalByProgram('bri', $this->data->id_pengajuan, 'LEMBAGA');
            $sosial2 = PrintController::sumTotalByProgram('bri', $this->data->id_pengajuan, 'SOSIAL');
            $operasional2 = PrintController::sumTotalByProgram('bri', $this->data->id_pengajuan, 'OPS');
            $total = $kelembagaan + $sosial + $operasional;
            $total2 = $kelembagaan2 + $sosial2 + $operasional2;
            $pesan =  "*" .  "Kelembagaan"  . "*" .  "\n" .
                '(' . $this->numberFormat($kelembagaan) . ')' . "\n" .
                "*" .  "Sosial"  . "*" .  "\n" .
                '(' . $this->numberFormat($sosial) . ')' . "\n" .
                "*" .  "Operasional"  . "*" .  "\n" .
                '(' . $this->numberFormat($operasional) . ')' . "\n" . "\n";
            $pesan2 =  "*" .  "Kelembagaan"  . "*" .  "\n" .
                '(' . $this->numberFormat($kelembagaan2) . ')' . "\n" .
                "*" .  "Sosial"  . "*" .  "\n" .
                '(' . $this->numberFormat($sosial2) . ')' . "\n" .
                "*" .  "Operasional"  . "*" .  "\n" .
                '(' . $this->numberFormat($operasional2) . ')' . "\n" . "\n";
        } else {
            $nama_pj = Helper::getNamaPengurus('ranting', $this->data->pj_ranting);
            $tingkat = 'PRNU ' . Helper::getNamaRanting($this->data->id_ranting);
            $kelembagaan = PrintController::sumTotalByProgram2('bmt', $this->data->id_pengajuan, 'ba84d782-81a8-11ed-b4ef-dc215c5aad51');
            $sosial = PrintController::sumTotalByProgram2('bmt', $this->data->id_pengajuan, 'bed10d9c-81a8-11ed-b4ef-dc215c5aad51');
            $kelembagaan2 = PrintController::sumTotalByProgram('bri', $this->data->id_pengajuan, 'LEMBAGA');
            $sosial2 = PrintController::sumTotalByProgram('bri', $this->data->id_pengajuan, 'SOSIAL');
            $total = $kelembagaan + $sosial;
            $total2 = $kelembagaan2 + $sosial2;
            $pesan =  "*" .  "Kelembagaan"  . "*" .  "\n" .
                '(' . $this->numberFormat($kelembagaan) . ')' . "\n" .
                "*" .  "Sosial"  . "*" .  "\n" .
                '(' . $this->numberFormat($sosial) . ')' . "\n" . "\n";
            $pesan2 =  "*" .  "Kelembagaan"  . "*" .  "\n" .
                '(' . $this->numberFormat($kelembagaan2) . ')' . "\n" .
                "*" .  "Sosial"  . "*" .  "\n" .
                '(' . $this->numberFormat($sosial2) . ')' . "\n" . "\n";
        }

        // direktur
        $this->notif(
             Helper::getNohpByIdJabatan('pc', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3'),
            // '082138603051',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurusByIdJabatan('pc', $this->data->id_pc, '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3') .  "*" . "\n" .
                Helper::getJabatanPengurusByIdJabatan('pc', '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')  . "\n" . "\n" .
                "Lembar Rekomendasi " . "*" . "telah diterbitkan" . "*" . " untuk Pengajuan Pentasyarufan Tingkat " . $tingkat .  ", dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor Pengajuan"  . "*" .  "\n" .
                $this->data->nomor_surat  . "\n" .
                "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                $nama_pj  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Tanggal Terbit Rekomendasi"  . "*" .  "\n" .
                \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" . "\n" .
                "*" .  "Nomor Rekomendasi BMT"  . "*" .  "\n" .
                $no_rekom_bmt  . "\n" .
                "*" .  "Nominal Dapat Dicairkan"  . "*" .  "\n" .
                $this->numberFormat($total)  . "\n" .
                $pesan .

                "*" .  "Nomor Rekomendasi BRI"  . "*" .  "\n" .
                $no_rekom_bri  . "\n" .
                "*" .  "Nominal Dapat Dicairkan"  . "*" .  "\n" .
                $this->numberFormat($total2)  . "\n" .
                $pesan2 .
                "Terima Kasih." . "\n" .
                url($this->url)
        );

        // divisi keuangan 2
        $this->notif(
            Helper::getNohpByIdJabatan('pc', '3b5ce3c4-a045-11ed-a0ac-040300000000'),
            // '082138603051',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurusByIdJabatan('pc', $this->data->id_pc, '3b5ce3c4-a045-11ed-a0ac-040300000000') .  "*" . "\n" .
                Helper::getJabatanPengurusByIdJabatan('pc', '3b5ce3c4-a045-11ed-a0ac-040300000000')  . "\n" . "\n" .
                "Lembar Rekomendasi " . "*" . "telah diterbitkan" . "*" . " untuk Pengajuan Pentasyarufan Tingkat " . $tingkat .  ", dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor Pengajuan"  . "*" .  "\n" .
                $this->data->nomor_surat  . "\n" .
                "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                $nama_pj  . "\n" .
                "*" .  "Tanggal Pengajuan"  . "*" .  "\n" .
                \Carbon\Carbon::parse($this->data->tgl_pengajuan)->isoFormat('D MMMM Y')  .  "\n" .
                "*" .  "Tanggal Terbit Rekomendasi"  . "*" .  "\n" .
                \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat('D MMMM Y')  .  "\n" . "\n" .
                "*" .  "Nomor Rekomendasi BMT"  . "*" .  "\n" .
                $no_rekom_bmt  . "\n" .
                "*" .  "Nominal Dapat Dicairkan"  . "*" .  "\n" .
                $this->numberFormat($total)  . "\n" .
                $pesan .

                "*" .  "Nomor Rekomendasi BRI"  . "*" .  "\n" .
                $no_rekom_bri  . "\n" .
                "*" .  "Nominal Dapat Dicairkan"  . "*" .  "\n" .
                $this->numberFormat($total2)  . "\n" .
                $pesan2 .
                "Terima Kasih." . "\n" .
                url($this->url)
        );
    }

    public function batalRekomendasi()
    {
        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'tgl_terbit_rekomendasi' => NULL,
            'status_rekomendasi' => 'Belum Terbit',
            'no_rekom_bmt' => NULL,
            'no_rekom_bri' => NULL,
            'notif_rekomendasi' => '0',
            'direkomendasikan_oleh_pc' => NULL
        ]);

        $data = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)->where('pencairan_status', 'Berhasil Dicairkan')->get();
        foreach ($data as $a) {
            Rekening::where('id_rekening', $a->id_rekening)->increment('saldo', $a->nominal_pencairan);
            ArusDana::where('id_etasyaruf_permohonan_pentasyarufan_koin', $a->id_pengajuan_detail)->delete();
        }
        $this->mount();
    }

    public function batalLaporan()
    {
        $this->id_pengajuan_penerima = '';
        $this->detail_laporan($this->id_pengajuan_detail);
        if ($this->data->status_rekomendasi == 'Belum Terbit') {
            $this->dispatchBrowserEvent('batalLaporan');
            $this->dispatchBrowserEvent('batalLampiran');
        } elseif ($this->data->status_rekomendasi == 'Sudah Terbit') {
            $this->dispatchBrowserEvent('batalLaporan2');
            $this->dispatchBrowserEvent('batalLampiran2');
        }
    }

    public function pengajuanValidation()
    {
        if ($this->tgl_pelaksanaan and $this->id_program and $this->id_program_pilar and $this->id_program_kegiatan and $this->petugas and $this->nama_penerima and $this->satuan_pengajuan and $this->jumlah_penerima) {
            return 1;
        } else {
            return 0;
        }
    }
    public function beritaValidation()
    {
        if (
            $this->tgl_berita and $this->berupa
            and $this->senilai
            and $this->nama1
            and $this->jabatan1
            and $this->nohp1
            and $this->alamat1
            and $this->nama2
            and $this->jabatan2
            and $this->nohp2
            and $this->alamat2

        ) {
            return 1;
        } else {
            return 0;
        }
    }
    public function penerimaValidation()
    {

        if ($this->penerima_manfaat and $this->tgl_bantuan and $this->nominal_bantuan and $this->alamat_penerima and $this->penerima_note) {
            return 1;
        } else {
            return 0;
        }
    }
    // public function beritaValidation()
    // {

    //     if (
    //         $this->id_pengajuan_penerima and $this->no_identitas and $this->jalan and $this->rt and
    //         $this->rw and $this->desakelurahan and $this->kecamatan and $this->kabupaten and
    //         $this->tempat_tgl_lahir and $this->tgl_bantuan and $this->nohp and $this->jabatan and $this->tgl_pentasyarufan
    //     ) {
    //         PengajuanDetail::where('id_pengajuan_detail', $this->id_pengajuan_detail)->update([
    //             'id_pengajuan_penerima' => $this->id_pengajuan_penerima
    //         ]);
    //         PengajuanPenerima::where('id_pengajuan_penerima', $this->id_pengajuan_penerima)->update([
    //             'no_identitas' => $this->no_identitas,
    //             'jalan' => $this->jalan,
    //             'rt' => $this->rt,
    //             'rw' => $this->rw,
    //             'desakelurahan' => $this->desakelurahan,
    //             'kecamatan' => $this->kecamatan,
    //             'kabupaten' => $this->kabupaten,
    //             'tempat_tgl_lahir' => $this->tempat_tgl_lahir,
    //             'tgl_bantuan' => $this->tgl_bantuan,
    //             'nohp' => $this->nohp,
    //             'jabatan' => $this->jabatan,
    //             'tgl_pentasyarufan' => $this->tgl_pentasyarufan,
    //         ]);

    //         return 1;
    //     } else {
    //         return 0;
    //     }
    // }

    // public function kegiatanValidation()
    // {
    //     if ($this->judul_kegiatan and $this->tgl_kegiatan and $this->lokasi and $this->jumlah_kehadiran) {
    //         return 1;
    //     } else {
    //         return 0;
    //     }
    // }
    // public function pengeluaranValidation()
    // {
    //     if ($this->judul_pengeluaran and $this->tgl_pengeluaran and $this->jumlah and $this->nominal_pengeluaran and $this->nota) {
    //         return 1;
    //     } else {
    //         return 0;
    //     }
    // }


    public function totalByProgram($id)
    {
        $jumlah = PengajuanDetail::where('id_pengajuan', $this->data->id_pengajuan)->where('id_program', $id)
            ->sum('nominal_pencairan');
        $total = PengajuanDetail::where('id_pengajuan', $this->data->id_pengajuan)->where('id_program', $id)->count();
        $a = PengajuanDetail::where('id_pengajuan', $this->data->id_pengajuan)
            ->where('id_program', $id)
            ->where('approval_status', 'Disetujui')
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('id_pengajuan', $this->data->id_pengajuan)
            ->where('id_program', $id)
            ->count();
        $a2 = PengajuanDetail::where('id_pengajuan', $this->data->id_pengajuan)
            ->where('id_program', $id)
            ->where('approval_status', 'Ditolak')
            ->where('id_pengajuan', $this->data->id_pengajuan)
            ->where('id_program', $id)
            ->count();
        $a3 = PengajuanDetail::where('id_pengajuan', $this->data->id_pengajuan)
            ->where('id_program', $id)
            ->where('pencairan_status', 'Ditolak')
            ->where('id_pengajuan', $this->data->id_pengajuan)
            ->where('id_program', $id)
            ->count();
        $respon = $a + $a2 + $a3;
        return [
            'jumlah' => $jumlah,
            'total' => $total,
            'respon' => $respon,
        ];
    }

    public function getListRekeningRencana($tipe)
    {
        $gocap = config('app.database_gocap');
        $etasyaruf = config('app.database_etasyaruf');
        $data = PengajuanDetail::where('id_pengajuan', $this->data->id_pengajuan)
            ->whereNotNull($etasyaruf . '.pengajuan_detail.id_rekening')->groupBy($etasyaruf . '.pengajuan_detail.id_rekening')
            ->join($gocap . '.rekening', $gocap . '.rekening.id_rekening', '=', $etasyaruf . '.pengajuan_detail.id_rekening')
            ->when($tipe == 'bri', function ($query) {
                return $query->where('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30']);
            })
            ->when($tipe == 'bmt', function ($query) {
                return $query->whereNotIn('id_bmt',  ['99713ffd-f09f-4c93-98cb-0c34abbaae30']);;
            })
            ->get();
        return $data ?? NULL;
    }
    public function totalByIdRekening($id)
    {
        $data = PengajuanDetail::where('id_pengajuan', $this->data->id_pengajuan)->where('id_rekening', $id)->sum('nominal_pencairan');
        return $data ?? NULL;
    }
    public function getTotalProgramByIdRekening($id)
    {
        $data = PengajuanDetail::where('id_pengajuan', $this->data->id_pengajuan)
            ->where('pencairan_status', 'Berhasil Dicairkan')
            ->where('id_rekening', $id)->count('id_pengajuan_detail');
        return $data ?? NULL;
    }

    public function numberFormat($data)
    {
        $result = Helper::numberFormat($data);
        return $result ?? "Rp0,-";
    }

    public function responValidation()
    {
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $a = $this->totalByProgram('ba84d782-81a8-11ed-b4ef-dc215c5aad51')['respon'] +
                $this->totalByProgram('bed10d9c-81a8-11ed-b4ef-dc215c5aad51')['respon'] +
                $this->totalByProgram('c51700b1-81a8-11ed-b4ef-dc215c5aad51')['respon'];
            $b = $this->totalByProgram('ba84d782-81a8-11ed-b4ef-dc215c5aad51')['total'] +
                $this->totalByProgram('bed10d9c-81a8-11ed-b4ef-dc215c5aad51')['total'] +
                $this->totalByProgram('c51700b1-81a8-11ed-b4ef-dc215c5aad51')['total'];
        } elseif ($this->data->tingkat == 'Ranting NU') {
            $a = $this->totalByProgram('ba84d782-81a8-11ed-b4ef-dc215c5aad51')['respon'] +
                $this->totalByProgram('bed10d9c-81a8-11ed-b4ef-dc215c5aad51')['respon'];
            $b = $this->totalByProgram('ba84d782-81a8-11ed-b4ef-dc215c5aad51')['total'] +
                $this->totalByProgram('bed10d9c-81a8-11ed-b4ef-dc215c5aad51')['total'];
        }

        if ($a == $b) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getNominalPencairan()
    {
        $data = $this->data_detail->nominal_pencairan ?? null;
        return $data ?? null;
    }
    public function getDanaDigunakan()
    {
        $data =  PengajuanPengeluaran::where('id_pengajuan_detail', $this->id_pengajuan_detail)->sum('nominal_pengeluaran');
        return $data ?? null;
    }

    public function getNominalPenyaluran($id_pengajuan_detail)
    {
        $a = PengajuanPenerimaLPJ::where('id_pengajuan_detail', $id_pengajuan_detail)
            ->sum('nominal_bantuan');
        return $a ?? NULL;
    }


    public function getJumlahPenerimaPenyaluran($id_pengajuan_detail)
    {
        $a = PengajuanPenerimaLPJ::where('id_pengajuan_detail', $id_pengajuan_detail)
            ->count();
        return $a ?? NULL;
    }


    public function sendNotifWa()
    {
        // update status notif wa
        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'notif_rekomendasi' => '1',
        ]);
        $this->mount();


        $bmt_info = '';
        $nomorIterasi = 1; // Variabel untuk nomor iterasi manual
        foreach ($this->getListRekeningRencana('bmt') as $a) {
            $nama_rekening = Helper::getDataRekening2($a->id_rekening ?? null)->pluck('nama_rekening')->first();
            $no_rekening = Helper::getDataRekening2($a->id_rekening ?? null)->pluck('no_rekening')->first();
            $bmt_info .= $nomorIterasi . ". " . $nama_rekening . " (" . $no_rekening . ")" . "\n" . $this->numberFormat($this->totalByIdRekening($a->id_rekening)) . "\n";
            $nomorIterasi++; // Tingkatkan nomor iterasi secara manual
        }

        $bri_info = '';
        $nomorIterasi = 1; // Variabel untuk nomor iterasi manual
        foreach ($this->getListRekeningRencana('bri') as $a) {
            $nama_rekening = Helper::getDataRekening2($a->id_rekening ?? null)->pluck('nama_rekening')->first();
            $no_rekening = Helper::getDataRekening2($a->id_rekening ?? null)->pluck('no_rekening')->first();
            $bri_info .= $nomorIterasi . ". " . $nama_rekening . " (" . $no_rekening . ")" . "\n" . $this->numberFormat($this->totalByIdRekening($a->id_rekening)) . "\n";
            $nomorIterasi++; // Tingkatkan nomor iterasi secara manual
        }

        // send notif wa
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $nama_pj = Helper::getNamaPengurus('upzis', $this->data->pj_upzis);
            $nohp_pj =  Helper::getNohpPengurus('upzis', $this->data->pj_upzis);
            $jabatan_pj =  Helper::getJabatanPengurus('upzis', $this->data->pj_upzis);
            $tingkat = 'UPZIS MWCNU ' . Helper::getNamaUpzis($this->data->id_upzis);
        } else {
            $nama_pj = Helper::getNamaPengurus('ranting', $this->data->pj_ranting);
            $nohp_pj =  Helper::getNohpPengurus('ranting', $this->data->pj_ranting);
            $jabatan_pj =  Helper::getJabatanPengurus('ranting', $this->data->pj_ranting);
            $tingkat = 'PRNU ' . Helper::getNamaRanting($this->data->id_ranting);
        }
        $this->mount();
        // maker
        $this->notif(
            Helper::getNohpPengurus('upzis', $this->data->maker_tingkat_upzis),
            //'081578447350',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurus('upzis', $this->data->maker_tingkat_upzis) .  "*" . "\n" .
                Helper::getJabatanPengurus('upzis', $this->data->maker_tingkat_upzis)  . "\n" . "\n" .
                "Dana pentasyarufan " . "*" . "sudah bisa dicairkan" . "*" .  " untuk Pentasyarufan Tingkat " . $tingkat . ", " . " dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor Pengajuan"  . "*" .  "\n" .
                $this->data->nomor_surat  . "\n" .
                "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                $nama_pj . "\n" . "\n" .
                "*" .  "Nomor Rekomendasi BMT"  . "*" .  "\n" .
                $this->data->no_rekom_bmt  . "\n" .
                "*" .  "Sumber Dana BMT"  . "*" .  "\n" .
                $bmt_info . "\n" . "\n" .
                "*" .  "Nomor Rekomendasi BRI"  . "*" .  "\n" .
                $this->data->no_rekom_bri  . "\n" .
                "*" .  "Sumber Dana BRI"  . "*" .  "\n" .
                $bri_info . "\n" .
                "Terima Kasih." . "\n" .
                url($this->url)
        );
        $this->dispatchBrowserEvent('success', [
            'message' => 'Notifikasi Pencairan Dana Terkirim ke <strong><br>' . Helper::getNamaPengurus('upzis', $this->data->maker_tingkat_upzis) . '</strong><br>' . Helper::getNohpPengurus('upzis', $this->data->maker_tingkat_upzis) . '<br>' . Helper::getJabatanPengurus('upzis', $this->data->maker_tingkat_upzis)
        ]);

        
        // pj
        $this->notif(
            $nohp_pj,
            //'081578447350',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . $nama_pj .  "*" . "\n" .
                $jabatan_pj  . "\n" . "\n" .
                "Dana pentasyarufan " . "*" . "sudah bisa dicairkan" . "*" .  " untuk Pentasyarufan Tingkat " . $tingkat . ", " . " dengan detail sebagai berikut :" . "\n" . "\n" .
                "*" .  "Nomor Pengajuan"  . "*" .  "\n" .
                $this->data->nomor_surat  . "\n" .
                "*" .  "PJ Pengambilan Dana"  . "*" .  "\n" .
                $nama_pj . "\n" . "\n" .
                "*" .  "Nomor Rekomendasi BMT"  . "*" .  "\n" .
                $this->data->no_rekom_bmt  . "\n" .
                "*" .  "Sumber Dana BMT"  . "*" .  "\n" .
                $bmt_info . "\n" . "\n" .
                "*" .  "Nomor Rekomendasi BRI"  . "*" .  "\n" .
                $this->data->no_rekom_bri  . "\n" .
                "*" .  "Sumber Dana BRI"  . "*" .  "\n" .
                $bri_info . "\n" .
                "Terima Kasih." . "\n" .
                url($this->url)
        );
        $this->dispatchBrowserEvent('success', [
            'message' => 'Notifikasi Pencairan Dana Terkirim ke <strong><br>' . $nama_pj . '</strong><br>' . $nohp_pj . '<br>' . $jabatan_pj
        ]);

    }
    
    public function kirimNotifWa()
    {
        // update status notif wa
        Pengajuan::where('id_pengajuan', $this->id_pengajuan)->update([
            'notif_lpj' => '1',
        ]);
        $this->mount();

        // send notif wa
        if ($this->data->tingkat == 'Upzis MWCNU') {
            $tingkat = 'UPZIS MWCNU ' . Helper::getNamaUpzis($this->data->id_upzis);
            $belum = PengajuanDetail::where('id_pengajuan', $this->id_pengajuan)->where('status_berita', 'Belum Dikonfirmasi')->count();
        } 

        // maker
        $this->notif(
            Helper::getNohpPengurus('upzis', $this->data->maker_tingkat_upzis),
            //'081578447350',
            "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" . "\n" .
                "Yth. " . "*" . Helper::getNamaPengurus('upzis', $this->data->maker_tingkat_upzis) .  "*" . "\n" .
                Helper::getNohpPengurus('upzis', $this->data->maker_tingkat_upzis)  . "\n" . "\n" .
                "Setelah pentasyarufan selesai. Segera lengkapi LPJ & BA." . "\n" .
                $belum . " Program Pentasyarufan " . "*" . "Belum LPJ" . "*" .  " untuk nomor pengajuan berikut : " . "\n" . "\n" .
                "*" .  "Nomor Pengajuan"  . "*" .  "\n" .
                $this->data->nomor_surat  . "\n" .
                "*" .  "Jenis Pentasyarufan"  . "*" .  "\n" .
                "Pentasyarufan Tingkat " . $tingkat . "\n" . "\n" .
                "Terima Kasih." . "\n" .
                url($this->url)
        );

        $this->dispatchBrowserEvent('success', [
            'message' => 'Notifikasi Belum LPJ Terkirim ke <strong><br>' . Helper::getNamaPengurus('upzis', $this->data->maker_tingkat_upzis) . '</strong><br>' . Helper::getNohpPengurus('upzis', $this->data->maker_tingkat_upzis). '<br>' . Helper::getJabatanPengurus('upzis', $this->data->maker_tingkat_upzis)
        ]);


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
}
