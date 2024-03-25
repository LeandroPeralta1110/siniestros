<div>
    <h1>Registro de precios</h1>
    <hr> <!-- Línea divisoria -->
    <div style="display: flex; justify-content: space-between;" class="pb-3">
        <button wire:click="actualizarDescuentos" class="btn btn-primary mr-6" style="margin-right: 10px;">
            <!-- Mostrar icono de carga si se está procesando la acción -->
            Registrar Descuentos
            <span wire:loading wire:target="actualizarDescuentos" class="cargando-icono" role="status" aria-hidden="true"></span>
        </button>
        <button wire:click="registrarPrecios" class="btn btn-primary mr-6" style="margin-right: 10px;">
            <!-- Mostrar icono de carga si se está procesando la acción -->
            Registrar Cambio de Precios
            <span wire:loading wire:target="registrarPrecios" class="cargando-icono" role="status" aria-hidden="true"></span>
        </button>
        <button wire:click="aplicarDescuentosClientes" class="btn btn-primary">
            <!-- Mostrar icono de carga si se está procesando la acción -->
            Aplicar Descuentos Clientes
            <span wire:loading wire:target="aplicarDescuentosClientes" class="cargando-icono" role="status" aria-hidden="true"></span>
        </button>
    </div>
    <!-- Mostrar mensaje de éxito si está presente -->
    @if ($successMessage)
        <div class="alert alert-success" role="alert">
            {{ $successMessage }}
        </div>
    @endif
    <!-- Mostrar mensaje de error si está presente -->
    @if ($errorMessage)
        <div class="alert alert-danger" role="alert">
            {{ $errorMessage }}
        </div>
    @endif
    @if ($productosDiferidosPorLista)
    @foreach ($productosDiferidosPorLista as $nombreListaPrecio => $productos)
    @php
        // Obtener el ID de la lista de precios usando el nombre como referencia
        $idListaPrecio = $listasPrecios->search($nombreListaPrecio);
        // Obtener la descripción de la lista de precios usando el nombre como referencia
        $descripcionListaPrecio = $listasPrecios[$nombreListaPrecio] ?? 'Sin descripción';
    @endphp
    <h2>Lista de Precios: {{ $nombreListaPrecio }} - {{ $idListaPrecio }}</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Descripción</th>
                <th>Precio Original</th>
                <th>Precio a cambiar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto['idProducto'] }}</td>
                    <td>{{ $producto['Descripcion'] }}</td>
                    <td>{{ $producto['PrecioSQL'] }}</td>
                    <td>{{ $producto['PrecioLocal'] }}</td>
                    <td>
                        @if (isset($producto['actualizado']) && $producto['actualizado'])
                            <!-- Mostrar icono de tick si el producto ha sido actualizado -->
                            <i class="fas fa-check-circle text-success"></i>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
    @endforeach
    @else 
        <h1>No hay precios para asignar</h1>
    @endif
</div>
