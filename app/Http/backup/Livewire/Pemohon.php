<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;


class Pemohon extends Component
{
    public $nama_pc;

    public function render()
    {
        // untuk mengetahui nama pc
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $nama_pc_tanpa_titik = str_replace('. ', '', Auth::user()->PcPengurus->Pc->Wilayah->nama);
            $nama_pc_tanpa_kab = str_replace('KAB', '', $nama_pc_tanpa_titik);
            $nama_pc_lower = strtolower($nama_pc_tanpa_kab);
            $this->nama_pc = "PC Lazisnu " . ucfirst($nama_pc_lower);
        }
        

        return view('livewire.pemohon');
    }
}
