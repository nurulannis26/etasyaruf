<?php

namespace App\Http\Livewire;

use App\Models\ProgramKegiatan;

use Livewire\Component;

class Zzzz extends Component
{
    public $id_program_pilar;
    public $i;
    public $tr;

    public function render()
    {

        return view('livewire.zzzz');
    }

    public function kegiatan($id)
    {
        $a = ProgramKegiatan::where('id_program_pilar', $id)->get();

        // return $a;
        foreach ($a as $b) {
            $this->i += 1;
            $this->tr .= "
                <tr>
                    <td align='center'> $this->i</td>
                    <td> $b->kegiatan </td>
                   
                </tr>
            ";
        };

        return  $this->tr;
    }
}
