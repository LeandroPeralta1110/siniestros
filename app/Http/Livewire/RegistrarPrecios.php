<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Precio;

class RegistrarPrecios extends Component
{
    public $productosDiferidosPorLista = [];
    public $listasPrecios;
    public $loading = false; // Estado de carga
    public $successMessage = ''; // Mensaje de éxito
    public $errorMessage = ''; // Mensaje de error

    public function mount()
    {
        // Obtener todas las listas de precios disponibles
        $this->listasPrecios = DB::connection('sqlsrv')->table('Listas')->distinct()->pluck('idListaPrecio', 'Descrp');

        // Iterar sobre las listas de precios
        foreach ($this->listasPrecios as $listaPrecioId) {
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

    public function actualizarDescuentos()
    {
        // Lógica para actualizar descuentos
        // Aquí puedes colocar la lógica para actualizar descuentos en el servidor
        // Por ejemplo:
        $this->loading = true; // Activar estado de carga
        // Simulación de una operación de larga duración
        sleep(2);
        $this->loading = false; // Desactivar estado de carga
        $this->successMessage = 'Descuentos actualizados correctamente.';
    }

    public function registrarPrecios()
    {
        // Lógica para registrar precios
        // Aquí puedes colocar la lógica para registrar precios en el servidor
        // Por ejemplo:
        $this->loading = true; // Activar estado de carga
        // Simulación de una operación de larga duración
        sleep(2);
        $this->loading = false; // Desactivar estado de carga
        $this->successMessage = 'Precios registrados correctamente.';
    }

    public function aplicarDescuentosClientes()
    {
        // Lógica para aplicar descuentos a clientes
        // Aquí puedes colocar la lógica para aplicar descuentos a clientes en el servidor
        // Por ejemplo:
        $this->loading = true; // Activar estado de carga
        // Simulación de una operación de larga duración
        sleep(2);
        $this->loading = false; // Desactivar estado de carga
        $this->successMessage = 'Descuentos aplicados a clientes correctamente.';
    }

    public function render()
    {
        return view('livewire.registrar-precios', [
            'productosDiferidosPorLista' => $this->productosDiferidosPorLista
        ]);
    }
}
