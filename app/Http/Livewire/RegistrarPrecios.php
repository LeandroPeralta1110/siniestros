<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Precio;

class RegistrarPrecios extends Component
{
    public $productosDiferidosPorLista = [];

    public function mount()
    {
        // Obtener todas las listas de precios disponibles
        $listasPrecios = DB::connection('sqlsrv')->table('precios')->distinct()->pluck('IdListaPrecio');

        // Iterar sobre las listas de precios
        foreach ($listasPrecios as $listaPrecioId) {
            // Obtener los productos de la lista de precios SQL
            $productosSQL = DB::connection('sqlsrv')
                                ->table('precios')
                                ->join('productos', 'precios.IdProducto', '=', 'productos.idProducto')
                                ->select('productos.idProducto', 'productos.Descripcion', 'precios.Precio as precioSQL')
                                ->where('precios.IdListaPrecio', $listaPrecioId)
                                ->get();

            // Obtener los productos de la lista de precios local
            $productosLocal = Precio::where('IdListaPrecio', $listaPrecioId)->get();

            // Comparar los precios de los productos
            foreach ($productosSQL as $productoSQL) {
                foreach ($productosLocal as $productoLocal) {
                    if ($productoSQL->idProducto === $productoLocal->idProducto && $productoSQL->precioSQL != $productoLocal->Precio) {
                        // Agregar el producto al grupo de productos diferidos por lista de precios
                        $this->productosDiferidosPorLista[$listaPrecioId][] = [
                            'idProducto' => $productoSQL->idProducto,
                            'Descripcion' => $productoSQL->Descripcion,
                            'PrecioSQL' => $productoSQL->precioSQL,
                            'PrecioLocal' => $productoLocal->Precio
                        ];
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.registrar-precios', [
            'productosDiferidosPorLista' => $this->productosDiferidosPorLista
        ]);
    }
}
