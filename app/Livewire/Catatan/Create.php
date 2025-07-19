<?php

namespace App\Livewire\Catatan;

use App\Models\Catatan;
use Flux\Flux;
use Livewire\Component;

class Create extends Component
{
    public $judul;
    public $isi;

    protected $rules = [
        'judul' => 'required|string|max:255',
        'isi' => 'required|string',
    ];

    public function save()
    {
        $this->validate();

        Catatan::create([
            'judul' => $this->judul,
            'isi' => $this->isi,
        ]);

        // Reset input fields
        $this->reset(['judul', 'isi']);

        // Emit event ke parent atau komponen lain jika perlu
        $this->dispatch('catatanCreated'); // optional

        // Tutup modal (pastikan flux:modal mendukung ini)
        Flux::modal('create-catatan')->close();
        session()->flash('success', 'Catatan berhasil ditambahkan.');

        $this->redirectRoute('catatans', navigate: true);
    }

    public function render()
    {
        return view('livewire.catatan.create');
    }
}
