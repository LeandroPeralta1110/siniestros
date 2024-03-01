<div>
    <h1 class="title">IVESS - Formulario Cambio de Precios</h1>

    <!-- Campo de carga de archivo -->
    <div>
        <input type="file" wire:model="excelFile">
    </div>
    <br>

    <!-- Botón de envío -->
    <button wire:click="procesarArchivoExcel" class="btn btn-primary">Procesar Archivo</button>

    <br><br>

    @if($successMessage)
    <div class="alert alert-success" role="alert">
        {{ $successMessage }}
    </div>
    @endif

    @if($errorMessage)
    <div class="alert alert-error" role="alert">
        {{ $errorMessage }}
    </div>
    @endif

    <label for="lista_precio" class="select-label">Selecciona una lista de precios:</label>
    <select wire:model="selectedListaPrecio" wire:change="actualizarSeleccion" id="lista_precio" class="select-list form-control">
        <option value="">Selecciona una lista de precios</option>
        @foreach($listasPrecios as $descripcion => $idListaPrecio)
            <option value="{{ $idListaPrecio }}">{{ $descripcion }}</option>
        @endforeach
    </select>

    @if($productos)
    <table class="table">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Descripción</th>
                <th>Precio a Cambiar</th>
                <th>Precio Original</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto['idProducto'] }}</td>
                    <td>{{ $producto['Descripcion'] }}</td>
                    @if(!empty($producto['PrecioLocal']))
                        <td>
                            <input type="text" id="precioInput{{ $producto['idProducto'] }}" value="{{ $producto['PrecioLocal'] }}" onchange="actualizarPrecioLocal('{{ $producto['idProducto'] }}')">                    
                        </td>
                    @endif
                    <td>{{ $producto['PrecioSQL'] ?? '-' }}</td>
                    <td>
                        <!-- Mostrar el botón "Restaurar" si el precio local difiere del precio SQL -->
                        @if($producto['PrecioLocal'] != $producto['PrecioSQL'])
                            <button id="restaurarBtn{{ $producto['idProducto'] }}" wire:click="restaurarPrecio('{{ $producto['idProducto'] }}')" class="btn btn-warning">Restaurar</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
</div>
<script>
    function actualizarPrecioLocal(idProducto) {
        // Obtener el nuevo valor del input
        var inputPrecio = document.getElementById('precioInput' + idProducto);
        var nuevoPrecio = inputPrecio.value;

        // Obtener el valor seleccionado del select de lista de precios
        var idListaPrecio = document.getElementById('lista_precio').value;

        // Realizar una petición HTTP POST para enviar los datos al backend
        fetch('/actualizar-precio-local', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                idProducto: idProducto,
                idListaPrecio: idListaPrecio,
                nuevoPrecio: nuevoPrecio
            })
        })
        .then(response => {
    if (response.ok) {
        // Procesar la respuesta si la petición fue exitosa
        console.log('Datos actualizados correctamente.');

        // Cambiar el color del input a verde
        inputPrecio.style.backgroundColor = 'lightgreen';

        // Obtener el botón de restaurar correspondiente al producto
        var botonRestaurar = document.getElementById('restaurarBtn' + idProducto);

        // Mostrar el botón de restaurar si está oculto
        if (botonRestaurar) {
            botonRestaurar.style.display = 'inline-block';
        }
    } else {
        // Manejar errores en caso de que la petición falle
        console.error('Error al actualizar los datos.');

        // Cambiar el color del input a rojo
        inputPrecio.style.backgroundColor = 'lightcoral';
    }

    // Verificar si el precio difiere y mostrar u ocultar el botón en consecuencia
    if (response.precioDifiere) {
        document.getElementById('restaurarBtnPlaceholder' + idProducto).innerHTML = '<button id="restaurarBtn' + idProducto + '" wire:click="restaurarPrecio(\'' + idProducto + '\')" class="btn btn-warning">Restaurar</button>';
    } else {
        document.getElementById('restaurarBtnPlaceholder' + idProducto).innerHTML = '';
    }
})
        .catch(error => {
            console.error('Error al procesar la solicitud:', error);
        });
    }
</script>
