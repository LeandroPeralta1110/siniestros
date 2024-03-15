<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siniestro extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombreApellidoChofer',
        'DNIchofer',
        'legajoChofer',
        'telChof',
        'nom_ape_ayudante',
        'patente_vehiculo',
        'interno_vehiculo',
        'cargamento_vehiculo',
        'daños_vehiculo',
        'localidad_sini',
        'calle_sini',
        'altura_sini',
        'interseccion_sini',
        'direccion_vial',
        'nombre_tercero',
        'vehiculo_tercero',
        'registro_tercero',
        'pos_documentacion',
        'poliza_tercero',
        'pos_poliza_tipo',
        'vehiculo_tipo',
        'pos_acompañantes',
        'pos_cant_acomp',
        'pos_menor_acomp',
        'pos_daños_acomp',
        'pos_desc_daños_acomp',
        'int_pol',
        'int_med',
        'tip_choque',
        'daños_vehiculo_tercero',
        'dni_tercero',
        'patente_tercero',
        'desc_vehiculo_tercero',
        'domic_tercero',
        'tel_tercero',
        'com_seguro_tercero',
        'obs_adic',
        'imagen1_path',
        'imagen2_path',
        'registroFrente_path',
        'registroDorso_path',
        'daños1_path',
        'daños2_path',
        'dañosTercero1_path',
        'dañosTercero2_path',
        'imagen1_path',
        'imagen2_path',
        'daños1_path',
        'daños2_path',
        'registroFrente_path',
        'registroDorso_path',
        'dañosTercero1_path',
        'dañosTercero2_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
