<?php

namespace App\Livewire\Catatan;

use Livewire\Component;
use App\Models\Catatan ;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $catatanId;

    public function edit($id)
    {
        $this->dispatch('edit-catatan', $id); // Lanjutkan ke EditCatatan
    }

    public function render()
    {
        $catatans = Catatan::orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.catatan.index', [
            'catatans' => $catatans,
        ]);
    }
    public function delete($id)
    {
        $this->catatanId = $id;
        Flux::modal('delete-catatan')->show();
    }
    public function deleteCatatan()
    {
        Catatan::findOrFail($this->catatanId)->delete();
        Flux::modal('delete-catatan')->close();
        session()->flash('success', 'Catatan berhasil dihapus.');
    }
}
