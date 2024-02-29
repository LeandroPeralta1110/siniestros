<div>
    <h1>Registro de precios</h1>
    <hr> <!-- Línea divisoria -->
    <div class="text-right"> <!-- Contenedor para alinear el botón a la derecha -->
        <button class="btn btn-primary">Registrar Precios</button>
    </div>
    @foreach ($productosDiferidosPorLista as $listaPrecioId => $productos)
        <h2>Lista de Precios {{ $listaPrecioId }}</h2>
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
</div>
