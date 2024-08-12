<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use App\Models\Penerimas;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Penerima extends Component
{
    public $nama_pc;

    // tabel
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    // public $page_number = '10';

    // modal tambah
    public $tab_a;
    public $tab_color_a;
    public $tab_b;
    public $tab_color_b;
    public $jenis;
    public $id_kategori;
    public $kategori;
    public $golongan;
    public $nomor_registrasi;
    public $nomor_perijinan;
    public $nama_lembaga;
    public $nama_pimpinan;
    public $alamat_lembaga;


    public function mount()
    {
        // supaya tab a aktif
        $this->tab_a = 'active';
        $this->tab_b = '';
        $this->tab_color_a = 'text-success';
        $this->tab_color_b = 'text-secondary';
    }

    public function render()
    {
        // untuk mengetahui nama pc
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $nama_pc_tanpa_titik = str_replace('. ', '', Auth::user()->PcPengurus->Pc->Wilayah->nama);
            $nama_pc_tanpa_kab = str_replace('KAB', '', $nama_pc_tanpa_titik);
            $nama_pc_lower = strtolower($nama_pc_tanpa_kab);
            $this->nama_pc = "PC Lazisnu " . ucfirst($nama_pc_lower);
        }

        // kategori
        $kategoris = Kategori::latest()->get();


        $data = Penerimas::latest()
            ->paginate(5);

        return view('livewire.penerima', compact('data', 'kategoris'));
    }

    public function modal_penerima_tambah()
    {
    }

    public function selanjutnya()
    {
        $this->tab_a = '';
        $this->tab_b = 'active';
        $this->tab_color_a = 'text-secondary';
        $this->tab_color_b = 'text-success';
    }

    public function kembali()
    {
        $this->tab_a = 'active';
        $this->tab_b = '';
        $this->tab_color_a = 'text-success';
        $this->tab_color_b = 'text-secondary';
    }
}
