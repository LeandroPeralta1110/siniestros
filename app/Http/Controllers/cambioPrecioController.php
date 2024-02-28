<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Precio;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CambioPrecioController extends Controller
{
    public function index()
    {
        $listasPrecios = DB::connection('sqlsrv')->table('precios')->distinct()->pluck('IdListaPrecio');
        return view('form.formCambioPrecios', ['listasPrecios' => $listasPrecios]);
    }
    
    public function obtenerPrecioLocal($idProducto)
    {
        // Aquí deberías implementar la lógica para obtener el precio local del producto con el ID proporcionado
        // Por ejemplo, si los precios locales están en la tabla 'precios' y el precio se encuentra en el campo 'precio', podrías hacer algo como:
        $precioLocal = Precio::where('idProducto', $idProducto)->first();

        if ($precioLocal) {
            return response()->json(['precio' => $precioLocal->precio]);
        } else {
            return response()->json(['precio' => null]);
        }
    }

    public function getProductos($listaPrecioId)
{
    // Consulta a la base local
    $productosLocal = Precio::where('IdListaPrecio', $listaPrecioId)->get();

    // Consulta a la base SQL
    $productosSQL = DB::connection('sqlsrv')
                    ->table('precios')
                    ->join('productos', 'precios.IdProducto', '=', 'productos.idProducto')
                    ->select('productos.idProducto','productos.Descripcion', 'precios.Precio as precioSQL') // Alias precioSQL para distinguirlo del precio local
                    ->where('precios.IdListaPrecio', $listaPrecioId)
                    ->get();

    // Formatear los productos para el frontend
    $productosFormateados = [
        'productosLocal' => $productosLocal,
        'productosSQL' => $productosSQL
    ];

    return response()->json($productosFormateados);
}

public function updatePrecios(Request $request)
{
    $producto = $request->producto;
    $idListaPrecio = $request->idListaPrecio;

    // Busca el producto local basado en el idProducto y el idListaPrecio
    $precioLocal = Precio::where('idProducto', $producto['idProducto'])
                        ->where('idListaPrecio', $idListaPrecio)
                        ->first();
    
    // Si se encontró el precio local
    if ($precioLocal) {
        // Actualiza el precio y la fecha
        $precioLocal->precio = $producto['Precio'];
        $precioLocal->fecha = Carbon::now(); // Guarda la fecha actual
        $precioLocal->save();
        
        // Devuelve una respuesta indicando que la actualización fue exitosa
        return response()->json(['actualizacionExitosa' => true, 'message' => 'Precio actualizado correctamente']);
    }

    // Devuelve una respuesta indicando que no se realizó ninguna actualización
    return response()->json(['actualizacionExitosa' => false, 'message' => 'No se realizó ninguna actualización de precios']);
}

public function restorePrice(Request $request)
{
    $idProducto = $request->idProducto;
    $idListaPrecio = $request->idListaPrecio;
  

    // Obtener el precio original del producto en la lista de precios de SQL Server
    $precioSQL = DB::connection('sqlsrv')
                    ->table('precios')
                    ->select('Precio')
                    ->where('IdProducto', $idProducto)
                    ->where('IdListaPrecio', $idListaPrecio)
                    ->value('Precio');

    // Obtener el precio local del producto en la lista de precios
    $precioLocal = Precio::where('idProducto', $idProducto)
                         ->where('idListaPrecio', $idListaPrecio)
                         ->first();

    if ($precioSQL !== null && $precioLocal !== null) {
        // Si los precios son diferentes, actualizar el precio local con el precio de SQL Server
        if ($precioLocal->precio != $precioSQL) {
            $precioLocal->precio = $precioSQL;
            $precioLocal->save();
            return response()->json(['actualizacionExitosa' => true, 'message' => 'Precio actualizado correctamente']);
        } else {
            return response()->json(['actualizacionExitosa' => false, 'message' => 'Los precios ya son iguales, no se realizó ninguna actualización']);
        }
    } else {
        return response()->json(['actualizacionExitosa' => false, 'message' => 'No se pudo obtener el precio original de SQL Server o el precio local para el producto en la lista de precios especificada']);
    }
}

}
