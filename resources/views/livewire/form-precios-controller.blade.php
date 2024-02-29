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
                    @if($producto['PrecioLocal'])
                    <td>
                        <input type="text" wire:model="productos.{{ $producto['idProducto'] }}.PrecioLocal"
                            wire:change="actualizarPrecioLocal('{{ $producto['idProducto'] }}', $event.target.value)">
                    </td>
                    @endif
                    <td>{{ $producto['PrecioSQL'] ?? '-' }}</td>
                    <td>
                        <!-- Mostrar el botón "Restaurar" si el precio local difiere del precio SQL -->
                        @if($producto['PrecioLocal'] != $producto['PrecioSQL'])
                            <button wire:click="restaurarPrecio('{{ $producto['idProducto'] }}')" class="btn btn-warning">Restaurar</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
