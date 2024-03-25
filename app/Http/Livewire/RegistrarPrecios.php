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
        $this->loading = true; // Activar estado de carga
        
        try {
            // Ejecutar la sentencia SQL en la conexión 'sqlsrv'
            DB::connection('sqlsrv')->statement("
                use h2o_jumi;
                go;
                drop table if exists tmp_descuentosXporcentaje;
                go;
    
                select c.nrocta, p.idproducto, precio, 
                    preciolista = (select dbo.Get_PrecioPorClienteProducto_sinprecioespecial(c.nrocta, p.idproducto, 0, 0)), 
                    descuento = convert(numeric(18,2), 0), 
                    atrib2, atrib3, atrib4, atrib5
                into tmp_descuentosXporcentaje
                from clientes c 
                inner join precios_clientes p on p.nrocta = c.nrocta
                order by c.nrocta, p.idproducto;
    
                update tmp_descuentosXporcentaje 
                set descuento = convert(numeric(18,2), 100 - (precio*100)/case preciolista when 0 then 1 else preciolista end);
            ");
            
            $this->successMessage = 'Descuentos actualizados correctamente.';
        } catch (\Exception $e) {
            // Manejar errores si ocurren
            $this->errorMessage = 'Error al actualizar descuentos: ' . $e->getMessage();
        } finally {
            $this->loading = false; // Desactivar estado de carga
        }
    }

    public function registrarPrecios()
    {
        $this->loading = true; // Activar estado de carga
        try {
            // Iterar sobre los productos diferidos por lista de precios
            foreach ($this->productosDiferidosPorLista as $listaPrecioId => &$productos) {
                // Verificar si el ID de lista de precios es numérico
                if (!is_numeric($listaPrecioId)) {
                    // Si el ID no es numérico, convertirlo a cadena (varchar)
                    $listaPrecioId = (string) $listaPrecioId;
                }{
                    $listaPrecioId = (string) $listaPrecioId;
                }
    
                foreach ($productos as $indice => &$producto) {
                    if (!is_numeric($producto['idProducto'])) {
                        // Si el ID no es numérico, convertirlo a cadena (varchar)
                        $producto['idProducto'] = (string) $producto['idProducto'];
                    }else{
                        $producto['idProducto'] = (string) $producto['idProducto'];
                    }
    
                    // Realizar una consulta de actualización para cambiar el precio en la tabla 'Precios'
                    DB::connection('sqlsrv')->table('Precios')
                        ->where('IdListaPrecio', $listaPrecioId)
                        ->where('IdProducto', $producto['idProducto'])
                        ->update(['Precio' => $producto['PrecioLocal']]);
    
                    // Eliminar el producto del array si se actualizó correctamente en la base de datos
                    $productos[$indice]['actualizado'] = true;
                }
            }

            $this->successMessage = 'Precios registrados correctamente.';
        } catch (\Exception $e) {
            // Manejar errores si ocurren
            $this->errorMessage = 'Error al registrar precios: ' . $e->getMessage();
        } finally {
            $this->loading = false; // Desactivar estado de carga
        }
    }
    
    public function aplicarDescuentosClientes()
    {
        $this->loading = true; // Activar estado de carga
    
        try {
            // Ejecutar consulta SQL para aplicar descuentos a clientes
            DB::connection('sqlsrv')->statement("
                alter table tmp_descuentosXporcentaje
                add precio_mod numeric(18,2)
                go
                
                update tmp_descuentosXporcentaje set  precio_mod=(select dbo.Get_PrecioPorClienteProducto_sinprecioespecial(tmp_descuentosXporcentaje.nrocta,tmp_descuentosXporcentaje.idproducto,0,0))
                
                delete from Precios_Clientes where nrocta in (select nrocta from tmp_descuentosXporcentaje)
                
                insert into Precios_Clientes
                select nrocta,idproducto,
                precio_descuento_esp=DBO.GET_ROUND_ESP(DBO.GET_ROUND_UP_5(round(precio_mod - DBO.GET_ROUND_UP_5(round(precio_mod*(descuento/100),0)),0)))  
                from tmp_descuentosXporcentaje
                where descuento > 0
            ");
            
            $this->successMessage = 'Descuentos aplicados a clientes correctamente.';
        } catch (\Exception $e) {
            // Manejar errores si ocurren
            $this->errorMessage = 'Error al aplicar descuentos a clientes: ' . $e->getMessage();
        } finally {
            $this->loading = false; // Desactivar estado de carga
        }
    }
    
    public function render()
    {
        return view('livewire.registrar-precios', [
            'productosDiferidosPorLista' => $this->productosDiferidosPorLista
        ]);
    }
}
