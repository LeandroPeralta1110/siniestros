<?php

namespace App\Livewire;

use App\Models\Precio;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormCambioPrecioController extends Component
{

    public $listasPrecios;
    public $selectedListaPrecio;
    public $productos;

    public function mount()
    {
        // Consultar la base de datos para obtener las opciones del select
        $this->listasPrecios = DB::connection('sqlsrv')->table('precios')->distinct()->pluck('IdListaPrecio');
    }

    public function updatedSelectedListaPrecio($selectedListaPrecio)
    {
        dd($selectedListaPrecio);
        // Llamar al método para obtener productos cuando se selecciona una lista de precios
        $this->getProductos($selectedListaPrecio);
    }

    public function getProductos($listaPrecioId)
    {
        // Consulta a la base local
        $productosLocal = Precio::where('IdListaPrecio', $listaPrecioId)->get();

        // Consulta a la base SQL
        $productosSQL = DB::connection('sqlsrv')
            ->table('precios')
            ->join('productos', 'precios.IdProducto', '=', 'productos.idProducto')
            ->select('productos.idProducto', 'productos.Descripcion', 'precios.Precio as precioSQL') // Alias precioSQL para distinguirlo del precio local
            ->where('precios.IdListaPrecio', $listaPrecioId)
            ->get();

        // Combinar resultados de ambas consultas
        $this->productos = $productosLocal->map(function ($productoLocal) use ($productosSQL) {
            $productoSQL = $productosSQL->firstWhere('idProducto', $productoLocal->idProducto);
            return (object) [
                'idProducto' => $productoLocal->idProducto,
                'Descripcion' => $productoLocal->Descripcion,
                'precioLocal' => $productoLocal->Precio,
                'precioSQL' => $productoSQL ? $productoSQL->precioSQL : null,
            ];
        });
    }

    public function render()
    {
        return view('livewire.form-cambio-precio-controller');
    }
}
