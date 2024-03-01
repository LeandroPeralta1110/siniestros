<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use TCPDF;
use Livewire\Component;

class FormSiniestrosController extends Component
{
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

        // Definir estilos
        $style = [
            'border' => 1,
            'padding' => '2px',
            'fontsize' => 12,
        ];

        // Crear el contenido del PDF con los datos del formulario
        $contenido = '<h1 style="text-align:center;">Datos del formulario</h1>';

        // Agregar la fecha y hora de creación
        $contenido .= $this->crearPar('Hora y día de la Creación del Formulario Siniestro', $datos['Hora_y_dia_de_la_Creacion_del_Formulario_Siniestro']) . '<br><br>';

        // Organizar los datos en tablas y agregar espacios en blanco entre ellas
        $contenido .= $this->crearTabla($datos, ['nombreApellidoChofer', 'DNIchofer', 'legajoChofer', 'telChof', 'nom_ape_ayudante', 'imagen1', 'imagen2', 'patente-vehiculo', 'interno-vehiculo', 'cargamento-vehiculo', 'daños-vehiculo', 'daños1', 'daños2']) . '<br><br>';
        $contenido .= $this->crearTabla($datos, ['localidad_sini', 'calle_sini', 'altura_sini', 'interseccion_sini', 'direccion-vial']) . '<br><br>';
        $contenido .= $this->crearTabla($datos, ['vehiculo-tercero', 'pos-registro', 'pos-documentacion', 'pos-poliza', 'pos-poliza-tipo', 'vehiculo-tipo', 'pos-acompañantes', 'pos-cant-acomp', 'pos-menor-acomp', 'pos-daños-acomp', 'pos-desc-daños-acomp', 'int-pol', 'int-med', 'por-daños', 'tip-choque', 'desc-daños']) . '<br><br>';
        $contenido .= $this->crearTabla($datos, ['nombre-tercero', 'dni-tercero', 'gen-tercero', 'patente-tercero', 'desc-vehiculo-tercero', 'domic-tercero', 'tel-tercero', 'com-seguro-tercero', 'obs-adic']);

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

    // Función para crear un par de título y valor
    private function crearPar($titulo, $valor)
    {
        return "<table><tr><td>{$titulo}:</td><td>{$valor}</td></tr></table>";
    }

    // Función para crear una tabla con los datos recibidos
    private function crearTabla($datos, $keys)
    {
        $tabla = '<table border="1" cellpadding="5" cellspacing="0">';
        foreach ($keys as $key) {
            $value = $datos[$key] ?? '';
            $tabla .= "<tr><td>{$key}</td><td>{$value}</td></tr>";
        }
        $tabla .= '</table>';
        return $tabla;
    }
    
    public function render()
    {
        return view('livewire.form-siniestros-controller');
    }
}
