<?php

namespace App\Http\Livewire;


use App\Models\Programs;
use App\Models\ProgramPilar;
use App\Models\ProgramKegiatan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


// use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Validator;

class Program extends Component
{
    public $role;
    // mount
    public $etasyaruf;
    public $siftnu;
    public $gocap;

    // tabel
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $page_number = '5';
    public $cari;


    // pilar
    public $id_program;
    public $program;
    public $ubah_pilar;

    // kegiatan
    public $id_program_kegiatan;
    public $id_program_pilar;
    public $pilar;
    public $no_urut;
    public $kegiatan;
    public $ubah_kegiatan;
    public $ubah_no_urut;

    public function mount()
    {
        $this->etasyaruf = config('app.database_etasyaruf');
        $this->siftnu = config('app.database_siftnu');
        $this->gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $this->role = 'pc';
        }
        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            $this->role = 'upzis';
        }
    }

    public function render()
    {

        $data = Programs::latest()
            ->paginate(5);


        $pilars = ProgramPilar::orderBy('created_at', 'ASC')->get();


        if ($this->id_program_pilar == NULL) {
            $kegiatans = NULL;
        } else {
            $kegiatans = ProgramKegiatan::where('id_program_pilar', $this->id_program_pilar)
                // cari 
                ->when($this->cari, function ($query) {
                    return $query->where('nama_program', 'like', '%' . $this->cari . '%')
                        ->orwhere('no_urut', 'like', '%' . $this->cari . '%');
                })
                ->orderBy('no_urut', 'ASC')

                ->paginate($this->page_number);
        }
        $this->updatingSearch();
        return view(
            'livewire.program',
            compact('data', 'pilars', 'kegiatans')
        );
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function jumlah_pilar($id_program)
    {
        $a = ProgramPilar::where('id_program', $id_program)->count();

        return $a;
    }

    public function jumlah_kegiatan($id_program)
    {
        $b = ProgramKegiatan::where('id_program', $id_program)->count();

        return $b;
    }

    public function click_pilar($id_program, $program)
    {
        $this->id_program = $id_program;
        $this->program = $program;
        $this->id_program_pilar = NULL;
    }

    public function click_kegiatan($id_program_pilar, $pilar)
    {
        // dd('wdw');

        $this->id_program_pilar = $id_program_pilar;
        $this->pilar = $pilar;
    }

    // pilar
    public function modal_pilar_tambah()
    {
        $this->pilar = '';
    }

    public function modal_pilar_ubah($id_program_pilar, $pilar)
    {
        $this->id_program_pilar = $id_program_pilar;
        $this->ubah_pilar = $pilar;
    }

    public function modal_pilar_hapus($id_program_pilar)
    {
        $this->id_program_pilar = $id_program_pilar;
    }

    public function tambah_pilar()
    {
        ProgramPilar::create([
            'id_program_pilar' => Str::uuid(),
            'id_program' => $this->id_program,
            'pilar' => $this->pilar
        ]);

        session()->flash('alert_pilar', 'Pilar Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }


    public function ubah_pilar()
    {
        ProgramPilar::where('id_program_pilar', $this->id_program_pilar)->update([
            'pilar' => $this->ubah_pilar
        ]);

        // set pilar yang baru untuk tampil
        $this->pilar = $this->ubah_pilar;

        session()->flash('alert_pilar', 'Pilar Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function hapus_pilar()
    {
        ProgramPilar::where('id_program_pilar', $this->id_program_pilar)->delete();

        // set pilar yang baru untuk tampil
        $this->click_kegiatan(NULL, NULL);
        session()->flash('alert_pilar', 'Pilar Berhasil Dihapus');
        $this->emit('waktu_alert');
    }
    // end pilar


    // kegiatan
    public function modal_kegiatan_tambah()
    {
        $this->kegiatan = '';
        $this->no_urut = '';
    }

    public function modal_kegiatan_ubah($id_program_kegiatan, $kegiatan, $no_urut)
    {
        $this->id_program_kegiatan = $id_program_kegiatan;
        $this->ubah_kegiatan = $kegiatan;
        $this->ubah_no_urut = $no_urut;
    }

    public function modal_kegiatan_hapus($id_program_kegiatan)
    {
        $this->id_program_kegiatan = $id_program_kegiatan;
    }

    public function tambah_kegiatan()
    {
        ProgramKegiatan::create([
            'id_program_kegiatan' => Str::uuid(),
            // 'id_program' => $this->id_program,
            'id_program_pilar' => $this->id_program_pilar,
            'no_urut' => $this->no_urut,
            'nama_program' => $this->kegiatan
        ]);

        session()->flash('alert_kegiatan', 'Program Berhasil Ditambahkan');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }


    public function ubah_kegiatan()
    {
        Programkegiatan::where('id_program_kegiatan', $this->id_program_kegiatan)->update([
            'no_urut' => $this->ubah_no_urut,
            'nama_program' => $this->ubah_kegiatan
        ]);

        // set kegiatan yang baru untuk tampil
        $this->kegiatan = $this->ubah_kegiatan;

        session()->flash('alert_kegiatan', 'Program Berhasil Diubah');
        $this->emit('waktu_alert');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function hapus_kegiatan()
    {
        try {
            ProgramKegiatan::where('id_program_kegiatan', $this->id_program_kegiatan)->delete();
            session()->flash('alert_kegiatan', 'Program Berhasil Dihapus');
            $this->emit('waktu_alert');
        } catch (\Exception $e) {
            session()->flash('alert_danger', 'Program Tidak Bisa Dihapus, Karena Sudah Digunakan Dalam Pentasyarufan');
            $this->emit('waktu_alert');
        }
    }

    // end kegiatan


}
