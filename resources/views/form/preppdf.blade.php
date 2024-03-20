<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Siniestro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin-top: 50px; /* Agregar margen superior para dejar espacio para el logo */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            font-size: 14px; /* Aumenta el tamaño de la letra */
            font-weight: bold; /* Haz que la letra sea negrita */
        }

        .nueva-pagina {
            page-break-after: always;
        }

        .imagen {
            max-width: 200px;
        }

        .align-right {
            text-align: right;
        }

        .logo {
            position: absolute; /* Establecer posición absoluta */
            top: 20px; /* Ajustar la distancia desde arriba */
            left: 20px; /* Ajustar la distancia desde la izquierda */
            max-width: 100px; /* Ajustar el tamaño máximo del logo */
        }
    </style>
</head>
<body>
    <!-- Logo en la esquina superior izquierda -->
    <img src="{{asset('images/editable logo azul oscuro y claro.png')}}" alt="" class="logo">

    <h1>Formulario de Siniestro</h1>

    <!-- Primera tabla -->
    <table>
        <tr>
            <th colspan="2">Informacion del Siniestro</th>
        </tr>
        <tr>
            <td>Hora y día de la Creación del Formulario/Siniestro</td>
            <td class="align-right">
                {{ \Carbon\Carbon::parse($siniestro->fechaHoraSiniestro)->format('d/m/Y H:i') }}
            </td>
        </tr>
        <tr>
            <td>Creado por</td>
            <td class="align-right">{{ $siniestro->user->name }}</td>
        </tr>
        <tr>
            <td>Legajo</td>
            <td class="align-right">{{ $siniestro->user->legajo }}</td>
        </tr>
        <tr>
            <td>Lugar del Siniestro</td>
            <td class="align-right">{{ $siniestro->localidad_sini }}</td>
        </tr>
    </table>

    <!-- Salto de página para empezar en la siguiente página -->
    <div class="nueva-pagina"></div>

    <!-- Segunda tabla -->
    <table>
        <tr>
            <th colspan="2">Datos del Chofer</th>
        </tr>
        <tr>
            <td>Nombre y Apellido del Chofer</td>
            <td class="align-right">{{ $siniestro->nombreApellidoChofer }}</td>
        </tr>
        <tr>
            <td>DNI del Chofer</td>
            <td class="align-right">{{ $siniestro->DNIchofer }}</td>
        </tr>
        <tr>
            <td>Legajo</td>
            <td class="align-right">{{ $siniestro->legajoChofer }}</td>
        </tr>
        <tr>
            <td>DNI Frente</td>
            <td class="align-right">
                @if (isset($siniestro->imagen1_path))
                    <img src="{{ $siniestro->imagen1_path }}" class="imagen" alt="DNI Frente" style="width: 100%;" >
                @endif
            </td>
        </tr>
        <tr>
            <td>DNI Dorso</td>
            <td class="align-right">
                @if (isset($siniestro->imagen2_path))
                    <img src="{{ $siniestro->imagen2_path }}" class="imagen" alt="DNI Dorso" style="width: 100%;" >
                @endif
            </td>
        </tr>
        <tr>
            <td>Registro de conducir Frente</td>
            <td class="align-right">
                @if (isset($siniestro->registroFrente_path))
                    <img src="{{ $siniestro->registroFrente_path }}" class="imagen" alt="registro Frente" style="width: 100%;" >
                @endif
            </td>
        </tr>
        <tr>
            <td>Registro de Conducir Dorso</td>
            <td class="align-right">
                @if (isset($siniestro->registroDorso_path))
                    <img src="{{ $siniestro->registroDorso_path }}" class="imagen" alt="registro Dorso" style="width: 100%;" >
                @endif
            </td>
        </tr>
    </table>

    <!-- Tabla Datos extra del chofer -->
<table>
    <tr>
        <th colspan="2">Datos extra del chofer</th>
    </tr>
    <tr>
        <td>Telefono</td>
        <td class="align-right">{{ $siniestro->telChof }}</td>
    </tr>
    <tr>
        <td>Ayudante del chofer</td>
        <td class="align-right">{{ $siniestro->nom_ape_ayudante }}</td>
    </tr>
</table>

<div class="nueva-pagina"></div>

<!-- Tabla Datos del Vehiculo del Chofer -->
<table>
    <tr>
        <th colspan="2">Datos del Vehiculo del Chofer</th>
    </tr>
    <tr>
        <td>Patente del vehiculo</td>
        <td class="align-right">{{ $siniestro->patente_vehiculo }}</td>
    </tr>
    <tr>
        <td>Interno del Vehiculo</td>
        <td class="align-right">{{ $siniestro->interno_vehiculo }}</td>
    </tr>
    <tr>
        <td>Daños del Vehiculo</td>
        <td class="align-right">{{ $siniestro->daños_vehiculo }}</td>
    </tr>
    <tr>
        <td>Imagen daño 1</td>
        <td class="align-right">
            @if (isset($siniestro->daños1_path))
                <img src="{{ $siniestro->daños1_path }}" class="imagen" alt="daños 1" style="width: 100%;" >
            @endif
        </td>
    </tr>
    <tr>
        <td>Imagen daño 2</td>
        <td class="align-right">
            @if (isset($siniestro->daños2_path))
                <img src="{{ $siniestro->daños2_path }}" class="imagen" alt="daños 2" style="width: 100%;" >
            @endif
        </td>
    </tr>
</table>

<!-- Tabla Lugar del Siniestro -->
<table>
    <tr>
        <th colspan="2">Lugar del Siniestro</th>
    </tr>
    <tr>
        <td>Localidad del siniestro</td>
        <td class="align-right">{{ $siniestro->localidad_sini }}</td>
    </tr>
    <tr>
        <td>Calle del siniestro</td>
        <td class="align-right">{{ $siniestro->calle_sini }}</td>
    </tr>
    <tr>
        <td>Altura</td>
        <td class="align-right">{{ $siniestro->altura_sini }}</td>
    </tr>
    <tr>
        <td>Entre calles</td>
        <td class="align-right">{{ $siniestro->interseccion_sini }}</td>
    </tr>
</table>

<div class="nueva-pagina"></div>
<!-- Tabla Datos del Tercero -->
<table>
    <tr>
        <th colspan="2">Datos del Tercero</th>
    </tr>
    <tr>
        <td>Nombre y Apellido del Tercero</td>
        <td class="align-right">{{ $siniestro->nombre_tercero }}</td>
    </tr>
    <tr>
        <td>DNI del Tercero</td>
        <td class="align-right">{{ $siniestro->dni_tercero }}</td>
    </tr>
    <tr>
        <td>Tipo de Vehiculo del Tercero</td>
        <td class="align-right">{{ $siniestro->vehiculo_tercero }}</td>
    </tr>
    <tr>
        <td>Patente</td>
        <td class="align-right">{{ $siniestro->patente_tercero }}</td>
    </tr>
    <tr>
        <td>Vehiculo Personal/Alquiler</td>
        <td class="align-right">{{ $siniestro->vehiculo_tipo }}</td>
    </tr>
    <tr>
        <td>Descripcion del Vehiculo</td>
        <td class="align-right">{{ $siniestro->desc_vehiculo_tercero }}</td>
    </tr>
    <tr>
        <td>Nº Registro</td>
        <td class="align-right">{{ $siniestro->registro_tercero }}</td>
    </tr>
    <tr>
        <td>Nº Poliza</td>
        <td class="align-right">{{ $siniestro->poliza_tercero }}</td>
    </tr>
    <tr>
        <td>Tipo de Poliza</td>
        <td class="align-right">{{ $siniestro->pos_poliza_tipo }}</td>
    </tr>
    <tr>
        <td>Poseia acompañantes</td>
        <td class="align-right">{{ $siniestro->pos_acompañantes }}</td>
    </tr>
    @if($siniestro->pos_acompañantes == 'SI')
    <tr>
        <td>Cantidad de Acompañantes</td>
        <td class="align-right">{{ $siniestro->pos_cant_acompañantes }}</td>
    </tr>
    <tr>
        <td>Algun acompañante era menor</td>
        <td class="align-right">{{ $siniestro->pos_menor_acomp }}</td>
    </tr>
    <tr>
        <td>Algun acompañante sufrio daños</td>
        <td class="align-right">{{ $siniestro->pos_daños_acomp }}</td>
    </tr>
    <tr>
        <td>Descripcion de los daños de los acompañantes</td>
        <td class="align-right">{{ $siniestro->pos_desc_daños_acomp }}</td>
    </tr>
    @endif
    <tr>
        <td>Descripcion de los daños del Vehiculo del Tercero</td>
        <td class="align-right">{{ $siniestro->daños_vehiculo_tercero }}</td>
    </tr>
    <tr>
        <td>Imagen 1 daño del vehiculo del tercero</td>
        <td class="align-right">
            @if (isset($siniestro->dañosTercero1_path))
                <img src="{{ $siniestro->dañosTercero1_path }}" class="imagen" alt="daños Tercero 1" style="width: 100%;" >
            @endif
        </td>
    </tr>
    <tr>
        <td>Imagen 2 daño del vehiculo del tercero</td>
        <td class="align-right">
            @if (isset($siniestro->dañosTercero2_path))
                <img src="{{ $siniestro->dañosTercero2_path }}" class="imagen" alt="daños Tercero 2" style="width: 100%;" >
            @endif
        </td>
    </tr>
</table>

<div class="nueva-pagina"></div>
<table style="width: 100%;">
    <tr>
        <td class="align-right" style="width: 25%;">
            @if (isset($siniestro->imagen1_path))
                <img src="{{ $siniestro->imagen1_path }}" class="imagen" alt="DNI Frente" style="max-width: 100%; max-height: 100%;">
            @endif
        </td>
        <td class="align-right" style="width: 25%;">
            @if (isset($siniestro->imagen2_path))
                <img src="{{ $siniestro->imagen2_path }}" class="imagen" alt="DNI Dorso" style="max-width: 100%; max-height: 100%;">
            @endif
        </td>
    </tr>
    <tr>
        <td class="align-right" style="width: 25%;">
            @if (isset($siniestro->registroFrente_path))
                <img src="{{ $siniestro->registroFrente_path }}" class="imagen" alt="registro Frente" style="max-width: 100%; max-height: 100%;">
            @endif
        </td>
        <td class="align-right" style="width: 25%;">
            @if (isset($siniestro->registroDorso_path))
                <img src="{{ $siniestro->registroDorso_path }}" class="imagen" alt="registro Dorso" style="max-width: 100%; max-height: 100%;">
            @endif
        </td>
    </tr>
</table>

    <!-- Continúa agregando más tablas o datos según sea necesario -->

</body>
</html>
