@extends('layouts.app')

@section('content')
<div>
    <h1>Form cambio precios</h1>
    <label for="select-lista-precios">Selecciona una lista de precios:</label>
    <select id="select-lista-precios">
        <option value="">Selecciona una lista de precios</option>
        @foreach($listasPrecios as $listaPrecio)
            <option value="{{ $listaPrecio }}">{{ $listaPrecio }}</option>
        @endforeach
    </select>
    <div id="productos-container">
        <!-- Aquí se mostrarán los productos -->
    </div>
</div>

<script>
    var idListaPrecioSeleccionado = '';
    var idProductoSeleccionado = '';

    document.getElementById('select-lista-precios').addEventListener('change', function() {
        idListaPrecioSeleccionado = this.value;
        if (idListaPrecioSeleccionado !== '') {
            fetchProductos(idListaPrecioSeleccionado);
        }
    });

    // Función para obtener el precio local del producto
    function obtenerPrecioLocal(idProducto) {
        return fetch('{{ route('obtener.precio.local', ['idProducto' => '__idProducto__']) }}'.replace('__idProducto__', idProducto))
            .then(response => response.json())
            .then(data => {
                return data.precio; // Suponiendo que el precio se devuelve en la propiedad 'precio' del objeto JSON
            })
            .catch(error => {
                console.error('Error al obtener el precio local:', error);
                return null;
            });
    }

    function fetchProductos(listaPrecioId) {
    fetch('{{ route('productos', ['listaPrecioId' => '__value__']) }}'.replace('__value__', listaPrecioId))
        .then(response => response.json())
        .then(data => {
            var productosContainer = document.getElementById('productos-container');
            productosContainer.innerHTML = ''; // Limpiar el contenedor antes de agregar los nuevos productos
            
            var table = '<table class="table"><thead><tr><th>ID Producto</th><th>Descripción</th><th>Precio con Cambio</th><th>Precio Actual</th><th>Acciones</th></tr></thead><tbody>';
            
            // Combinar productos locales y de SQL
            var combinedProducts = data.productosLocal.map(producto => {
                var productoSQL = data.productosSQL.find(p => p.idProducto === producto.idProducto);
                return {
                    idProducto: producto.idProducto,
                    Descripcion: producto.Descripcion || (productoSQL ? productoSQL.Descripcion : '-'), // Utilizar 'Descripcion' o intentar obtenerlo de productoSQL
                    PrecioLocal: producto.Precio,
                    PrecioSQL: (productoSQL !== undefined ? productoSQL.precioSQL : '-')
                };
            });

            combinedProducts.forEach(producto => {
                table += '<tr><td>' + producto.idProducto + '</td><td>' + producto.Descripcion + '</td>';
                // Precio a cambiar (local)
                if (producto.idProducto) {
                    table += '<td><input type="text" class="form-control" style="width: 100px;" value="' + producto.PrecioLocal + '" data-id="' + producto.idProducto + '" onchange="actualizarPrecio(\'' + producto.idProducto.toString() + '\', this.value, ' + producto.PrecioSQL.toString() + ')"></td>';
                }
                // Precio SQL
                table += '<td>' + (producto.PrecioSQL !== undefined ? producto.PrecioSQL : '-') + '</td>';
                // Botón de restaurar solo si los precios son diferentes
                if (producto.PrecioLocal != producto.PrecioSQL) {
                    console.log(producto.idProducto);
                    table += '<td><button onclick="restaurarPrecio(' + JSON.stringify(producto.idProducto) + ')" class="btn btn-danger">Restaurar</button></td>';
                } else {
                    table += '<td></td>'; // No agregar nada si los precios son iguales
                }
                table += '</tr>';
            });
                
            table += '</tbody></table>';
            productosContainer.innerHTML = table;
        })
        .catch(error => {
            console.error('Error al obtener los productos:', error);
            var productosContainer = document.getElementById('productos-container');
            productosContainer.innerHTML = '<p class="text-center">Error al obtener los productos.</p>';
        });
}

function actualizarPrecio(idProducto, nuevoPrecio, precioSQL) {
    var idListaPrecio = document.getElementById('select-lista-precios').value;

    // Construir el objeto de datos a enviar
    var data = {
        idListaPrecio: idListaPrecio,
        producto: {
            idProducto: idProducto,
            Precio: nuevoPrecio
        }
    };

    // Realizar la solicitud POST
    fetch('{{ route('update.precios') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        // Manejar la respuesta de la actualización del precio
        console.log(data);
        
        // Si la actualización fue exitosa, cambiar el color del input a verde
        if (data.actualizacionExitosa) {
            var input = document.querySelector('input[data-id="' + idProducto + '"]');
            if (input) {
                input.style.backgroundColor = 'lightgreen';
            }
        }

        // Modificar la apariencia del botón "Restaurar" si los precios son iguales
        var buttonRestaurar = document.querySelector('button[data-id="' + idProducto + '"]');
    if (buttonRestaurar) {
        // Convertir los precios a enteros
        var precioSQLEntero = parseInt(precioSQL);
        var nuevoPrecioEntero = parseInt(nuevoPrecio);

        // Si los precios son iguales, ocultar el botón
        if (precioSQLEntero === nuevoPrecioEntero) {
            buttonRestaurar.style.display = 'none';
        } else {
            buttonRestaurar.style.display = 'inline-block';
        }
    }
    })
    .catch(error => {
        // Manejar cualquier error que ocurra durante la actualización del precio
        console.error('Error al actualizar el precio:', error);
    });
}

function restaurarPrecio(idProducto) {
    var idListaPrecio = document.getElementById('select-lista-precios').value;

    // Verifica si idProducto tiene un valor válido antes de hacer la solicitud
    if (idProducto) {
        fetch('{{ route('restore.price') }}', {
            method: 'POST', // Cambiar el método a POST
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ idProducto: idProducto, idListaPrecio: idListaPrecio }) // Enviar datos en el cuerpo de la solicitud
        })
        .then(response => response.json())
        .then(data => {
            // Actualizar dinámicamente el valor del input con el precio original
            var input = document.querySelector('input[data-id="' + idProducto + '"]');
            if (input) {
                input.value = data.precioOriginal;
            }
        })
        .catch(error => {
            console.error('Error al restaurar el precio:', error);
        });
    }
}

</script>
@endsection
