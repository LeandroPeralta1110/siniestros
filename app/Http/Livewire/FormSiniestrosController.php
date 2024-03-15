<?php

namespace App\Http\Livewire;

use App\Models\Siniestro;
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
        $datos = $request->except(['imagen1', 'imagen2', 'daños1', 'daños2','registroFrente','registroDorso','dañosTercero1','dañosTercero2']); // Excluir las imágenes de los datos

        // Procesar y guardar las imágenes
        $imagenes = [];
        foreach(['imagen1', 'imagen2', 'daños1', 'daños2','registroFrente','registroDorso','dañosTercero1','dañosTercero2'] as $imagenKey) {
            if($request->hasFile($imagenKey)) {
                $imagen = $request->file($imagenKey);
                $nombreImagen = $imagen->hashName(); // Obtener un nombre único para la imagen
                $rutaImagen = $imagen->store('public/images');
                $imagenes[$imagenKey] = asset('storage/images/' . $nombreImagen); // Utiliza la ruta completa de la imagen
            }
        }

        $siniestro = new Siniestro();
        $siniestro->user_id = $user->id;
        $siniestro->nombreApellidoChofer = $request->input('nombreApellidoChofer');
        $siniestro->DNIchofer = $request->input('DNIchofer');
        $siniestro->legajoChofer = $request->input('legajoChofer');
        $siniestro->telChof = $request->input('telChof');
        $siniestro->nom_ape_ayudante = $request->input('nom_ape_ayudante');
        $siniestro->patente_vehiculo = $request->input('patente-vehiculo'); // Aquí asignas el valor de la patente
        $siniestro->interno_vehiculo = $request->input('interno-vehiculo');
        $siniestro->cargamento_vehiculo = $request->input('cargamento-vehiculo');
        $siniestro->daños_vehiculo = $request->input('daños-vehiculo');
        $siniestro->localidad_sini = $request->input('localidad_sini');
        $siniestro->calle_sini = $request->input('calle_sini');
        $siniestro->altura_sini = $request->input('altura_sini');
        $siniestro->interseccion_sini = $request->input('interseccion_sini');
        $siniestro->direccion_vial = $request->input('direccion-vial');
        $siniestro->nombre_tercero = $request->input('nombre-tercero');
        $siniestro->vehiculo_tercero = $request->input('vehiculo-tercero');
        $siniestro->registro_tercero = $request->input('registroTercero');
        $siniestro->pos_documentacion = $request->input('pos-documentacion');
        $siniestro->poliza_tercero = $request->input('polizaTercero');
        $siniestro->pos_poliza_tipo = $request->input('pos-poliza-tipo');
        $siniestro->vehiculo_tipo = $request->input('vehiculo-tipo');
        $siniestro->pos_acompañantes = $request->input('pos-acompañantes');
        $siniestro->pos_cant_acomp = $request->input('pos-cant-acomp');
        $siniestro->pos_menor_acomp = $request->input('pos-menor-acomp');
        $siniestro->pos_daños_acomp = $request->input('pos-daños-acomp');
        $siniestro->pos_desc_daños_acomp = $request->input('pos-desc-daños-acomp');
        $siniestro->int_pol = $request->input('int-pol');
        $siniestro->int_med = $request->input('int-med');
        $siniestro->tip_choque = $request->input('tip-choque');
        $siniestro->daños_vehiculo_tercero = $request->input('daños-vehiculo-tercero');
        $siniestro->dni_tercero = $request->input('dni-tercero');
        $siniestro->patente_tercero = $request->input('patente-tercero');
        $siniestro->desc_vehiculo_tercero = $request->input('desc-vehiculo-tercero');
        $siniestro->domic_tercero = $request->input('domic-tercero');
        $siniestro->tel_tercero = $request->input('tel-tercero');
        $siniestro->com_seguro_tercero = $request->input('com-seguro-tercero');
        $siniestro->obs_adic = $request->input('obs-adic');
        $siniestro->imagen1_path = $imagenes['imagen1'] ?? null;
        $siniestro->imagen2_path = $imagenes['imagen2'] ?? null;
        $siniestro->daños1_path = $imagenes['daños1'] ?? null;
        $siniestro->daños2_path = $imagenes['daños2'] ?? null;
        $siniestro->registroFrente_path = $imagenes['registroFrente'] ?? null;
        $siniestro->registroDorso_path = $imagenes['registroDorso'] ?? null;
        $siniestro->dañosTercero1_path = $imagenes['dañosTercero1'] ?? null;
        $siniestro->dañosTercero2_path = $imagenes['dañosTercero2'] ?? null;
        $siniestro->save();


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