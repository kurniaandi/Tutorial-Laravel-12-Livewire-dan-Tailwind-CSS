<?php

namespace App\Livewire\Catatan;

use App\Models\Catatan;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\On;

class Edit extends Component
{
    public $catatanId;
    public $judul;
    public $isi;

    #[On('edit-catatan')]
    public function edit($id)
    {
        $catatan = Catatan::findOrFail($id);

        $this->catatanId = $catatan->id;
        $this->judul = $catatan->judul;
        $this->isi = $catatan->isi;

        Flux::modal('edit-catatan')->show();
    }

    public function update()
    {
        $this->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
                Rule::unique('catatans', 'judul')->ignore($this->catatanId),
            ],
            'isi' => 'required|string',
        ]);

        Catatan::where('id', $this->catatanId)->update([
            'judul' => $this->judul,
            'isi' => $this->isi,
        ]);

        session()->flash('success', 'Catatan berhasil diperbarui.');

        Flux::modal('edit-catatan')->close();

        $this->reset(['catatanId', 'judul', 'isi']);

        $this->redirectRoute('catatans', navigate: true);
    }

    

    public function render()
    {
        return view('livewire.catatan.edit');
    }
}
