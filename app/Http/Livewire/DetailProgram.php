<?php

namespace App\Http\Livewire;

use App\Models\ProgramPilar;
use App\Models\ProgramKegiatan;
use App\Models\Programs;
use Livewire\Component;

class DetailProgram extends Component
{
    public $id_program_kegiatan;
    public $id_program_pilar;

    // modal ubah kegiatan
    public $kegiatan;
    public $ignore = 'wire:ignore';


    public function render()
    {

        $data = ProgramPilar::latest()
            ->paginate(5);


        // $tabel_kegiatan = ProgramKegiatan::where('id_program_pilar', $this->id_program_pilar)->get();

        return view('livewire.detail-program', compact('data'));
    }

    public function modal_ubah_kegiatan($id_program_kegiatan)
    {
        $this->ignore = 'wire:ignore.self';
        $a = ProgramKegiatan::where('id_program_kegiatan', $id_program_kegiatan)->first();
        $this->kegiatan = $a->kegiatan;
        $this->id_program_kegiatan = $a->id_program_kegiatan;
    }

    public function ubah_kegiatan()
    {

        ProgramKegiatan::where('id_program_kegiatan', $this->id_program_kegiatan)->update([
            'kegiatan' => $this->kegiatan
        ]);
        session()->flash('alert_kegiatan', 'Data Kegiatan Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function kegiatan($id_program_pilar)
    {
        $this->id_program_pilar = $id_program_pilar;
    }
}
