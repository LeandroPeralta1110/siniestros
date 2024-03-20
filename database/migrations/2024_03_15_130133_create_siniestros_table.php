<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siniestros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombreApellidoChofer');
            $table->string('DNIchofer');
            $table->string('legajoChofer');
            $table->string('telChof');
            $table->string('nom_ape_ayudante');
            $table->string('patente_vehiculo');
            $table->string('interno_vehiculo');
            $table->string('cargamento_vehiculo');
            $table->string('daños_vehiculo');
            $table->string('localidad_sini');
            $table->string('calle_sini');
            $table->string('altura_sini');
            $table->string('interseccion_sini');
            $table->string('direccion_vial');
            $table->string('nombre_tercero');
            $table->string('vehiculo_tercero');
            $table->string('registro_tercero')->nullable();
            $table->string('pos_documentacion')->nullable();
            $table->string('poliza_tercero')->nullable();
            $table->string('pos_poliza_tipo')->nullable();
            $table->string('vehiculo_tipo')->nullable();
            $table->string('pos_acompañantes')->nullable();
            $table->string('pos_cant_acomp')->nullable();
            $table->string('pos_menor_acomp')->nullable();
            $table->string('pos_daños_acomp')->nullable();
            $table->string('pos_desc_daños_acomp')->nullable();
            $table->string('int_pol')->nullable();
            $table->string('int_med')->nullable();
            $table->string('tip_choque')->nullable();
            $table->string('daños_vehiculo_tercero');
            $table->string('dni_tercero')->nullable();
            $table->string('patente_tercero')->nullable();
            $table->string('desc_vehiculo_tercero')->nullable();
            $table->string('domic_tercero')->nullable();
            $table->string('tel_tercero')->nullable();
            $table->string('com_seguro_tercero')->nullable();
            $table->string('obs_adic')->nullable();
            $table->string('imagen1_path')->nullable();
            $table->string('imagen2_path')->nullable();
            $table->string('registroFrente_path')->nullable();
            $table->string('registroDorso_path')->nullable();
            $table->string('daños1_path')->nullable();
            $table->string('daños2_path')->nullable();
            $table->string('dañosTercero1_path')->nullable();
            $table->string('dañosTercero2_path')->nullable();
            $table->timestamp('fechaHoraSiniestro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siniestros');
    }
};
