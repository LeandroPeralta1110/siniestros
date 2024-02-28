<div>
    <form wire:submit.prevent="submit">
        <div>
            <label for="lista_precio">Selecciona una lista de precios:</label>
            <select wire:model.defer="selectedListaPrecio" wire:input.debounce.400ms="updatedSelectedListaPrecio" id="lista_precio">
                <option value="">Selecciona una lista de precios</option>
                @foreach($listasPrecios as $listaPrecio)
                    <option value="{{ $listaPrecio }}">{{ $listaPrecio }}</option>
                @endforeach
            </select>
        </div>
    </form>

    @if($productos && $productos->isNotEmpty())
        <table class="table">
            <thead>
                <tr>
                    <th>ID Producto</th>
                    <th>Descripción</th>
                    <th>Precio con Cambio</th>
                    <th>Precio Actual</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->idProducto }}</td>
                        <td>{{ $producto->Descripcion }}</td>
                        <td>{{ $producto->precioLocal}}</td>
                        <td>{{ $producto->precioSQL }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>