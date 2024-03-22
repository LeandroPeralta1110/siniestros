<div>
    <h1 class="title">IVESS - Formulario Cambio de Precios</h1>

    <!-- Campo de carga de archivo y botón -->
    <div style="display: flex; align-items: center;">
        <!-- Campo de carga de archivo -->
        <div style="flex: 1; max-width: 30%;">
            <input type="file" wire:model="excelFile">
            <span wire:loading wire:target="excelFile" class="cargando-icono-blue" role="status" aria-hidden="true"></span>
        </div>
        
        <!-- Botón de envío -->
        <div>
            <button wire:click="procesarArchivoExcel" class="btn btn-primary">Procesar Archivo</button>
            <span wire:loading wire:target="procesarArchivoExcel" class="cargando-icono-blue" role="status" aria-hidden="true"></span>
        </div>
    </div>
    <br>

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

    <div class="form-group" style="display: flex;">
        <div style="flex: 1;">
            <label for="lista_precio" class="select-label">Selecciona una lista de precios:</label>
            <select wire:model="selectedListaPrecio" wire:change="actualizarSeleccion" id="lista_precio" class="select-list form-control">
                <option value="">Selecciona una lista de precios</option>
                @foreach($listasPrecios as $descripcion => $idListaPrecio)
                    <option value="{{ $idListaPrecio }}">{{ $descripcion }}</option>
                @endforeach
            </select>
        </div>
        <div style="flex: 1;">
            <label for="producto" class="select-label">Selecciona un producto:</label>
            <select wire:model="selectedProducto" wire:change="obtenerProductosPorListaPrecios" id="producto" class="select-list form-control">
                <option value="">Selecciona un producto</option>
                @foreach($listProductos as $idProducto)
                    <option value="{{ $idProducto }}">{{ $idProducto }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <button wire:click="restaurarPreciosALL" class="btn btn-primary">Restaurar todos</button>
        <span wire:loading wire:target="restaurarPreciosALL" class="cargando-icono-blue" role="status" aria-hidden="true"></span>
    </div>

    @if($productos)
    <table class="table">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Descripción</th>
                @foreach($productos as $producto)
                    @if(isset($producto['idListaPrecio']))
                        <th>Lista del Producto</th>
                        @break
                    @endif
                @endforeach
                <th>Precio a Cambiar</th>
                <th>Precio Original</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                @if(!empty($producto['PrecioLocal']) && !empty($producto['PrecioSQL']) )
                <tr>
                    <td>{{ $producto['idProducto'] }}</td>
                    <td>{{ $producto['Descripcion'] }}</td>
                    @if(isset($producto['descripcionLista']))
                        <td>{{ $producto['descripcionLista'] }}</td>
                    @endif
                    @if(!empty($producto['PrecioLocal']))
                        <td>
                            <!-- Utiliza Livewire para manejar el evento wire:change -->
                            <input type="text" 
                                   id="precioInput{{ $producto['idProducto'] }}" 
                                   value="{{ $producto['PrecioLocal'] }}" 
                                   data-id-lista-precio="{{ $producto['idListaPrecio'] }}" 
                                   data-precio-original="{{ $producto['PrecioSQL'] }}"
                                   wire:change="actualizarPrecioLocal('{{ $producto['idProducto'] }}', $event.target.value, '{{ $producto['idListaPrecio'] }}', '{{ $producto['PrecioSQL'] }}')">
                        </td>
                    @endif
                    <td>{{ $producto['PrecioSQL'] ?? '-' }}</td>
                    <td>
                        @if($producto['PrecioLocal'] != $producto['PrecioSQL'])
                            <button wire:click="restaurarPrecio('{{ $producto['idProducto'] }}', '{{ $producto['idListaPrecio'] }}')" class="btn btn-warning">Restaurar</button>
                        @endif
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@endif
</div>
<script>
    function actualizarPrecioLocal(idProducto, input) {
        // Obtener el nuevo valor del input
        var nuevoPrecio = input.value;
        var idListaPrecio = input.getAttribute('data-id-lista-precio');

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
                input.style.backgroundColor = 'lightgreen';
                var botonRestaurar = document.getElementById('restaurarBtn' + idProducto);
                if (botonRestaurar) {
                    botonRestaurar.style.display = 'inline-block';
                }
            } else {
                console.error('Error al actualizar los datos.');
                input.style.backgroundColor = 'lightcoral';
            }
        })
        .catch(error => {
            console.error('Error al procesar la solicitud:', error);
        });
    }

    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            // Se ejecuta después de que Livewire actualiza el DOM
            // Restaurar los select2 después de cada actualización de Livewire
            $('#lista_precio, #producto').select2();
        });
    });

    document.addEventListener('livewire:load', function () {
        Livewire.on('tablaActualizada', () => {
            Livewire.emit('refreshComponent'); // Emitir un evento para actualizar el componente Livewire
        });
    });

    document.addEventListener('livewire:load', function () {
        Livewire.on('datosActualizados', () => {
            Livewire.emit('mount'); // Volver a cargar los datos
        });
    });
</script>
