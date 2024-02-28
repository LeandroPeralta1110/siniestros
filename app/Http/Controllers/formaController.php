<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use TCPDF;

class formaController extends Controller
{
    public function index(){
        return view('form.form');
    }

    public function submitForm(Request $request)
    {
        // Capturar los datos del formulario
        $datos = $request->all();

        // Crear un nuevo objeto TCPDF
        $pdf = new TCPDF();

        // Establecer el título del documento
        $pdf->SetTitle('Datos del formulario');

        // Agregar una página
        $pdf->AddPage();

        // Crear el contenido del PDF con los datos del formulario
        $contenido = '<h1>Datos del formulario</h1>';
        foreach ($datos as $key => $value) {
            $contenido .= "<p><strong>$key:</strong> $value</p>";
        }

        // Escribir el contenido en el PDF
        $pdf->writeHTML($contenido);

        // Obtener el contenido del PDF como una cadena
        $pdfContent = $pdf->Output('data', 'S');

        // Nombre del archivo
        $fileName = 'datos_formulario.pdf';

        // Generar la respuesta HTTP con el archivo PDF para descarga
        return Response::make($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
