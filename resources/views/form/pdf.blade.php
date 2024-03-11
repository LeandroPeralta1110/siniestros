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
            <td class="align-right">{{ $datos['Hora_y_dia_de_la_Creacion_del_Formulario_Siniestro'] }}</td>
        </tr>
        <tr>
            <td>Creado por</td>
            <td class="align-right">{{ $nombreUsuario }}</td>
        </tr>
        <tr>
            <td>Legajo</td>
            <td class="align-right">{{ $legajoAuth }}</td>
        </tr>
        <tr>
            <td>Lugar del Siniestro</td>
            <td class="align-right">{{ $datos['localidad_sini'] }}</td>
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
            <td class="align-right">{{ $datos['nombreApellidoChofer'] }}</td>
        </tr>
        <tr>
            <td>DNI del Chofer</td>
            <td class="align-right">{{ $datos['DNIchofer'] }}</td>
        </tr>
        <tr>
            <td>Legajo</td>
            <td class="align-right">{{ $datos['legajoChofer'] }}</td>
        </tr>
        <tr>
            <td>DNI Frente</td>
            <td class="align-right">
                @if (isset($imagenes['imagen1']))
                    <img src="{{ $imagenes['imagen1'] }}" class="imagen" alt="DNI Frente" style="width: 100%;" >
                @endif
            </td>
        </tr>
        <tr>
            <td>DNI Dorso</td>
            <td class="align-right">
                @if (isset($imagenes['imagen2']))
                    <img src="{{ $imagenes['imagen2'] }}" class="imagen" alt="DNI Dorso" style="width: 100%;" >
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
        <td class="align-right">{{ $datos['telChof'] }}</td>
    </tr>
    <tr>
        <td>Ayudante del chofer</td>
        <td class="align-right">{{ $datos['nom_ape_ayudante'] }}</td>
    </tr>
</table>

<!-- Tabla Datos del Vehiculo del Chofer -->
<table>
    <tr>
        <th colspan="2">Datos del Vehiculo del Chofer</th>
    </tr>
    <tr>
        <td>Patente del vehiculo</td>
        <td class="align-right">{{ $datos['patente-vehiculo'] }}</td>
    </tr>
    <tr>
        <td>Interno del Vehiculo</td>
        <td class="align-right">{{ $datos['interno-vehiculo'] }}</td>
    </tr>
    <tr>
        <td>Daños del Vehiculo</td>
        <td class="align-right">{{ $datos['daños-vehiculo'] }}</td>
    </tr>
</table>

<!-- Tabla Lugar del Siniestro -->
<table>
    <tr>
        <th colspan="2">Lugar del Siniestro</th>
    </tr>
    <tr>
        <td>Localidad del siniestro</td>
        <td class="align-right">{{ $datos['localidad_sini'] }}</td>
    </tr>
    <tr>
        <td>Calle del siniestro</td>
        <td class="align-right">{{ $datos['calle_sini'] }}</td>
    </tr>
    <tr>
        <td>Altura</td>
        <td class="align-right">{{ $datos['altura_sini'] }}</td>
    </tr>
    <tr>
        <td>Entre calles</td>
        <td class="align-right">{{ $datos['interseccion_sini'] }}</td>
    </tr>
</table>

<!-- Tabla Datos del Tercero -->
<table>
    <tr>
        <th colspan="2">Datos del Tercero</th>
    </tr>
    <tr>
        <td>Nombre y Apellido del Tercero</td>
        <td class="align-right">{{ $datos['nombre-tercero'] }}</td>
    </tr>
    <tr>
        <td>DNI del Tercero</td>
        <td class="align-right">{{ $datos['dni-tercero'] }}</td>
    </tr>
    <tr>
        <td>Genero del Tercero</td>
        <td class="align-right">{{ $datos['gen-tercero'] }}</td>
    </tr>
    <tr>
        <td>Tipo de Vehiculo del Tercero</td>
        <td class="align-right">{{ $datos['vehiculo-tercero'] }}</td>
    </tr>
    <tr>
        <td>Patente</td>
        <td class="align-right">{{ $datos['patente-tercero'] }}</td>
    </tr>
    <tr>
        <td>Vehiculo Personal/Alquiler</td>
        <td class="align-right">{{ $datos['vehiculo-tipo'] }}</td>
    </tr>
    <tr>
        <td>Descripcion del Vehiculo</td>
        <td class="align-right">{{ $datos['desc-vehiculo-tercero'] }}</td>
    </tr>
    <tr>
        <td>Poseia Registro</td>
        <td class="align-right">{{ $datos['pos-registro'] }}</td>
    </tr>
    <tr>
        <td>Poseia documento</td>
        <td class="align-right">{{ $datos['pos-poliza'] }}</td>
    </tr>
    <tr>
        <td>Poseia poliza</td>
        <td class="align-right">{{ $datos['pos-poliza-tipo'] }}</td>
    </tr>
    <tr>
        <td>Poseia acompañantes</td>
        <td class="align-right">{{ $datos['pos-acompañantes'] }}</td>
    </tr>
    @if($datos['pos-acompañantes'] == 'SI')
    <tr>
        <td>Cantidad de Acompañantes</td>
        <td class="align-right">{{ $datos['pos-cant-acomp'] }}</td>
    </tr>
    <tr>
        <td>Algun acompañante era menor</td>
        <td class="align-right">{{ $datos['pos-menor-acomp'] }}</td>
    </tr>
    <tr>
        <td>Algun acompañante sufrio daños</td>
        <td class="align-right">{{ $datos['pos-daños-acomp'] }}</td>
    </tr>
    <tr>
        <td>Descripcion de los daños de los acompañantes</td>
        <td class="align-right">{{ $datos['pos-desc-daños-acomp'] }}</td>
    </tr>
    @endif
</table>

    <!-- Continúa agregando más tablas o datos según sea necesario -->

</body>
</html>
