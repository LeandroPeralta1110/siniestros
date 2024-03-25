<?php

namespace App\Http\Livewire;

use App\Models\Siniestro;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class RegistroSiniestros extends Component
{
    public $siniestros;
    public $mostrarPopup = false;
    public $mostrarEditPopup = false; 
    public $pdfUrl;
    public $siniestroParaEditar;

    public function mount()
    {
        $this->siniestros = Siniestro::all();
    }

    public function showPdf($id)
    {
        $pdfUrl = asset('pdfs/siniestro_' . $id . '.pdf');
        $this->pdfUrl = $pdfUrl;
        $this->mostrarPopup = true;
    }

    public function closePdfModal()
    {
        $this->mostrarPopup = false;
    }

    public function closeEditPopup(){
        $this->mostrarEditPopup = false;
    }
   
    public function editSiniestro($id)
    {
        // Obtener los datos del siniestro correspondiente al ID
        $this->siniestroParaEditar = Siniestro::findOrFail($id);
        $this->mostrarEditPopup = true;
    }

    public function guardarCambios()
    {
        // Guardar los cambios en el siniestro
        $this->siniestroParaEditar->save();
        
        // Cerrar el popup de edición después de guardar los cambios
        $this->mostrarEditPopup = false;
        
        // Opcional: Mostrar un mensaje de éxito o redirigir a alguna otra página
    }

    public function deleteSiniestro($id)
    {
        $siniestro = Siniestro::findOrFail($id);
        $siniestro->delete();
        $this->siniestros = Siniestro::all();
    }

    public function render()
    {
        return view('livewire.registro-siniestros');
    }
}
