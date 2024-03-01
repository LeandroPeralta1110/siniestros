<div>
    <h1>Registro de precios</h1>
    <hr> <!-- Línea divisoria -->
    <div class="text-right"> <!-- Contenedor para alinear el botón a la derecha -->
        <button class="btn btn-primary">Registrar Precios</button>
    </div>
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
                </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
    @else 
        <h1>No hay precios para asignar</h1>
    @endif
</div>
