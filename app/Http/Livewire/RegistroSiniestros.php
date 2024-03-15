<?php

namespace App\Http\Livewire;

use App\Models\Siniestro;
use Livewire\Component;

class RegistroSiniestros extends Component
{
    public $siniestros;

    public function mount()
    {
        $this->siniestros = Siniestro::all();
    }

    public function showPdf($id)
    {
        $siniestro = Siniestro::findOrFail($id);
        // Aquí lógica para mostrar la vista previa del PDF
    }

    public function editSiniestro($id)
    {
        // Lógica para editar el siniestro
    }

    public function deleteSiniestro($id)
    {
        $siniestro = Siniestro::findOrFail($id);
        $siniestro->delete();
        $this->siniestros = Siniestro::all(); // Actualizar la lista de siniestros después de eliminar uno
    }

    public function render()
    {
        return view('livewire.registro-siniestros');
    }
}
