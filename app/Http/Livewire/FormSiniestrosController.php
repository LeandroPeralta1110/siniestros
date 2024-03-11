<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class FormSiniestrosController extends Component
{
    public function submitForm(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        $nombreUsuario = $user->name;
        $legajoAuth = $user->legajo;

        // Capturar los datos del formulario
        $datos = $request->except(['imagen1', 'imagen2', 'daños1', 'daños2']); // Excluir las imágenes de los datos
       
        // Procesar y guardar las imágenes
        $imagenes = [];
        foreach(['imagen1', 'imagen2', 'daños1', 'daños2'] as $imagenKey) {
            if($request->hasFile($imagenKey)) {
                $imagen = $request->file($imagenKey);
                $nombreImagen = $imagen->hashName(); // Obtener un nombre único para la imagen
                $rutaImagen = $imagen->store('public/images');
                $imagenes[$imagenKey] = asset('storage/images/' . $nombreImagen); // Utiliza la ruta completa de la imagen
            }
        }

        // Generar el PDF
        $pdf = $this->generatePdf($nombreUsuario, $legajoAuth, $datos, $imagenes);

        // Descargar el PDF
        return Response::make($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="siniestro.pdf"'
        ]);
    }

    // Método para generar el PDF
    private function generatePdf($nombreUsuario, $legajoAuth, $datos, $imagenes)
    {
        // Crear una instancia de Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
      
        // Renderizar el HTML del PDF
        $html = view('form.pdf', compact('nombreUsuario', 'legajoAuth', 'datos', 'imagenes'))->render();
        $dompdf->loadHtml($html);

        // Renderizar el PDF
        $dompdf->render();

        // Obtener el contenido del PDF
        $output = $dompdf->output();

        return $output;
    }
    
    public function render()
    {
        return view('livewire.form-siniestros-controller');
    }
}