<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KategoriBerita extends Component
{
    public $etasyaruf;
    public $siftnu;
    public $gocap;

    public $daftar_upzis = [];
    public $daftar_ranting = [];
    public $id_pc;
    public $id_upzis;
    public $id_ranting;
    public $kategori_berita;


    public function mount()
    {
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');


        $daftar_upzis = DB::table($this->gocap . '.upzis')
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.upzis.id_wilayah')
            ->select(
                $this->gocap . '.upzis.id_upzis',
                $this->siftnu . '.wilayah.*',
            )
            ->orderBy('nama', 'ASC')
            ->first();
        $this->id_upzis = $daftar_upzis->id_upzis;
        $daftar_ranting = DB::table($this->gocap . '.ranting')->where('id_upzis', $this->id_upzis)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.ranting.id_wilayah')
            ->select(
                $this->gocap . '.ranting.id_ranting',
                $this->siftnu . '.wilayah.*',
            )
            ->orderBy('nama', 'ASC')
            ->first();
        $this->id_ranting = $daftar_ranting->id_ranting;
        $this->kategori_berita = 'Lazisnu Cilacap';
    }
    public function render()
    {

       

        $this->daftar_upzis = DB::table($this->gocap . '.upzis')
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.upzis.id_wilayah')
            ->select(
                $this->gocap . '.upzis.id_upzis',
                $this->siftnu . '.wilayah.*',
            )
            ->orderBy('nama', 'ASC')
            ->get();

        $this->daftar_ranting = DB::table($this->gocap . '.ranting')->where('id_upzis', $this->id_upzis)
            ->join($this->siftnu . '.wilayah', $this->siftnu . '.wilayah.id_wilayah', '=', $this->gocap . '.ranting.id_wilayah')
            ->select(
                $this->gocap . '.ranting.id_ranting',
                $this->siftnu . '.wilayah.*',
            )
            ->orderBy('nama', 'ASC')
            ->get();


        return view('livewire.kategori-berita');
    }
}
