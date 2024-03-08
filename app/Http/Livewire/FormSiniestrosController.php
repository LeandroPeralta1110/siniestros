<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use TCPDF;
use Livewire\Component;

class FormSiniestrosController extends Component
{
    private function guardarImagen($imagen)
{
    $nombreArchivo = $imagen->getClientOriginalName();
    $rutaImagen = 'images/' . $nombreArchivo;
    $imagen->move(public_path('images'), $nombreArchivo);
    return $rutaImagen;
}

public function submitForm(Request $request)
{
    // Obtener el usuario autenticado
    $user = Auth::user();
    $nombreUsuario = $user->name;
    $legajoAuth = $user->legajo;

    // Capturar los datos del formulario
    $datos = $request->all();
    
    // Guardar las imágenes y actualizar los datos del formulario con las rutas relativas
    if ($request->hasFile('imagen1')) {
        $rutaImagen1 = $this->guardarImagen($request->file('imagen1'));
        $datos['imagen1'] = $rutaImagen1;
    }
    if ($request->hasFile('imagen2')) {
        $rutaImagen2 = $this->guardarImagen($request->file('imagen2'));
        $datos['imagen2'] = $rutaImagen2;
    }
    
    // Crear un nuevo objeto TCPDF
    $pdf = new TCPDF();

    // Establecer el título del documento
    $pdf->SetTitle('Datos del formulario');

    // Agregar una nueva página para comenzar el contenido
    $pdf->AddPage();
    
    // Contenido inicial con el título
    $contenido = '<h1 style="text-align:center;">Registro de Siniestro</h1>';
    
    // Crear la primera tabla con los datos del usuario autenticado y aplicar estilos
    $contenido .= '<table style="width:100%; border-collapse:collapse; border: 2px solid #000; text-align:center; margin-bottom: 20px;">';
    $contenido .= '<tr><th colspan="2" style="background-color:#ccc; padding:10px;">Detalles del Siniestro</th></tr>';
    $contenido .= "<tr><td style='width:50%; background-color:#f2f2f2;'>Fecha y Hora de Creación del Formulario:</td><td style='background-color:#f9f9f9;'>{$datos['Hora_y_dia_de_la_Creacion_del_Formulario_Siniestro']}</td></tr>";
    $contenido .= "<tr><td style='width:50%; background-color:#f2f2f2;'>Localidad del Siniestro:</td><td style='background-color:#f9f9f9;'>{$datos['localidad_sini']}</td></tr>";
    $contenido .= "<tr><td style='width:50%; background-color:#f2f2f2;'>Incidente creado por:</td><td style='background-color:#f9f9f9;'>{$nombreUsuario}</td></tr>";
    $contenido .= "<tr><td style='width:50%; background-color:#f2f2f2;'>Legajo:</td><td style='background-color:#f9f9f9;'>{$legajoAuth}</td></tr>";
    $contenido .= '</table>';
    
    // Escribir el contenido de la primera tabla en el PDF
    $pdf->writeHTML($contenido);

    // Verificar si hay suficiente espacio en la página para agregar la próxima tabla
    $alturaMaximaTabla = 200; // Ajusta esto según la altura máxima que pueden tener tus tablas
    
    // Agregar las tablas restantes con estilos de color y diseño
    $this->agregarTabla($pdf, $datos, ['nombreApellidoChofer', 'DNIchofer', 'legajoChofer', 'telChof', 'nom_ape_ayudante', 'imagen1', 'imagen2', 'patente-vehiculo', 'interno-vehiculo', 'cargamento-vehiculo', 'daños-vehiculo', 'daños1', 'daños2'], $alturaMaximaTabla);
    $this->agregarTabla($pdf, $datos, ['calle_sini', 'altura_sini', 'interseccion_sini', 'direccion-vial'], $alturaMaximaTabla);
    $this->agregarTabla($pdf, $datos, ['vehiculo-tercero', 'pos-registro', 'pos-documentacion', 'pos-poliza', 'pos-poliza-tipo', 'vehiculo-tipo', 'pos-acompañantes', 'pos-cant-acomp', 'pos-menor-acomp', 'pos-daños-acomp', 'pos-desc-daños-acomp', 'int-pol', 'int-med', 'por-daños', 'tip-choque', 'desc-daños'], $alturaMaximaTabla);
    $this->agregarTabla($pdf, $datos, ['nombre-tercero', 'dni-tercero', 'gen-tercero', 'patente-tercero', 'desc-vehiculo-tercero', 'domic-tercero', 'tel-tercero', 'com-seguro-tercero', 'obs-adic'], $alturaMaximaTabla);

    // Obtener el contenido del PDF como una cadena
    $pdfContent = $pdf->Output('data', 'S');
    
    // Nombre del archivo
    $fileName = 'datos_formulario.pdf';
    
    // Generar la respuesta HTTP con el archivo PDF para descarga
    return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
}

// Función para agregar una tabla al PDF
private function agregarTabla($pdf, $datos, $keys, $alturaMaximaTabla)
{
    // Verificar si hay suficiente espacio en la página para agregar la próxima tabla
    if ($pdf->getPage() == 1) {
        // Si es la primera página, construir y escribir el contenido de la tabla
        $contenido = '<table style="width:100%; border-collapse:collapse; border: 2px solid #000; text-align:center; margin-bottom: 20px;">';
        foreach ($keys as $key) {
            // Obtener el nombre personalizado si está definido en $titulosPersonalizados
            $nombrePersonalizado = $this->obtenerTituloPersonalizado($key);
            // Obtener el valor del dato del formulario
            $value = $datos[$key] ?? '';
            // Agregar una fila a la tabla con el nombre personalizado y el valor
            if (strpos($key, 'imagen') === false) {
                $contenido .= "<tr><td>{$nombrePersonalizado}</td><td>{$value}</td></tr>";
            } else {
                // Si es una imagen, mostrarla
                $contenido .= "<tr><td>{$nombrePersonalizado}</td><td><img src='{$value}'></td></tr>";
            }
        }
        $contenido .= '</table>';
        
        // Escribir el contenido en el PDF
        $pdf->writeHTML($contenido);
    } else {
        // Si no es la primera página, verificar si hay suficiente espacio para agregar la tabla
        if ($pdf->getY() + $alturaMaximaTabla >= $pdf->getPageHeight()) {
            $pdf->AddPage();
        }
        
        // Construir y escribir el contenido de la tabla
        $contenido = '<table style="width:100%; border-collapse:collapse; border: 2px solid #000; text-align:center; margin-bottom: 20px;">';
        foreach ($keys as $key) {
            // Obtener el nombre personalizado si está definido en $titulosPersonalizados
            $nombrePersonalizado = $this->obtenerTituloPersonalizado($key);
            // Obtener el valor del dato del formulario
            $value = $datos[$key] ?? '';
            // Agregar una fila a la tabla con el nombre personalizado y el valor
            if (strpos($key, 'imagen') !== false) {
                // Si es una imagen, mostrarla
                $contenido .= "<tr><td>{$nombrePersonalizado}</td><td><img src='{$value}'></td></tr>";
            } else {
                $contenido .= "<tr><td>{$nombrePersonalizado}</td><td>{$value}</td></tr>";
            }
        }
        $contenido .= '</table>';
        
        // Escribir el contenido en el PDF
        $pdf->writeHTML($contenido);
    }
}

// Función para obtener el título personalizado
private function obtenerTituloPersonalizado($titulo)
{
    // Define un array asociativo con los títulos personalizados para cada campo
    $titulosPersonalizados = [
        'nombreApellidoChofer' => 'Nombre y Apellido del Chofer',
        'DNIchofer' => 'DNI del Chofer',
        'legajoChofer' => 'Legajo del Chofer',
        'telChof' => 'Teléfono del Chofer',
        'nom_ape_ayudante' => 'Nombre y Apellido del Ayudante',
        'imagen1' => 'DNI Frente del chofer',
        'imagen2' => 'DNI dorso del chofer',
        'patente-vehiculo' => 'Patente del Vehiculo',
        'interno-vehiculo' => 'Interno del Vehiculo',
        'daños-vehiculo' => 'Descripcion de los daños',
        'daños1' => 'Imagen 1 del daño del Vehiculo',
        'daños2' => 'Imagen 2 del daño del Vehiculo',
        'localidad_sini'=> 'Localidad del Siniestro',
        'calle_sini'=>'Calle del Siniestro',
         'altura_sini'=>'Altura del Siniestro', 
         'interseccion_sini'=>'Intersecciones/entrecalles del Siniestro', 
         'direccion-vial'=>'Direccion vial',
         'vehiculo-tercero'=>'Tipo de vehiculo del Tercero', 
         'pos-registro'=>'Numero de Registro', 
         'pos-documentacion'=>'Numero de documentacion del Tercero', 
         'pos-poliza'=>'Poliza del tercero', 
         'pos-poliza-tipo'=>'Tipo de poliza', 
         'vehiculo-tipo'=>'Vehiculo personal/alquiler', 
         'pos-acompañantes'=>'Tenia acompañantes', 
         'pos-cant-acomp'=>'Cantidad de acompañantes', 
         'pos-menor-acomp'=>'Algun acompañante era menor', 
         'pos-daños-acomp'=>'Algun acompañante sufrio daños', 
         'pos-desc-daños-acomp'=>'Descripcion de los daños del acompañante', 
         'int-pol'=>'Hubo intervencion Policial', 
         'int-med'=>'Hubo intervencion Medica', 
         'por-daños'=>'Porcentaje de daños del Vehiculo', 
         'tip-choque'=>'Tipo de choque', 
         'desc-daños'=>'Descripcion de los daños',
    ];

    // Si hay un título personalizado definido para el campo, úsalo; de lo contrario, usa el título original
    return $titulosPersonalizados[$titulo] ?? $titulo;
}
    
    public function render()
    {
        return view('livewire.form-siniestros-controller');
    }
}
