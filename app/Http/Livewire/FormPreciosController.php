<?php

namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use App\Models\Precio;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Session;

class FormPreciosController extends Component
{
    public $listasPrecios;
    public $selectedListaPrecio;
    public $productos;
    public $datos; 
    public $productosModificados = [];
    public $excelFile;
    public $successMessage;
    public $errorMessage;
    use WithFileUploads;
    
    public function mount()
    {
        // Consultar la base de datos para obtener las opciones del select
        $this->listasPrecios = DB::connection('sqlsrv')->table('Listas')->distinct()->pluck('idListaPrecio','Descrp');
        /* dd($this->listasPrecios); */
    }

    public function actualizarSeleccion()
    {
        // Limpiar los productos antes de actualizar
        $this->productos = [];
    
        // Acceder al valor seleccionado por el usuario
        $listaPrecioId = $this->selectedListaPrecio;
    
        // Consulta a la base local
        $productosLocal = Precio::where('IdListaPrecio', $listaPrecioId)->get();
    
        // Guardar los productos locales en el array de productos
        foreach ($productosLocal as $productoLocal) {
            $this->productos[$productoLocal->idProducto] = [
                'idProducto' => $productoLocal->idProducto,
                'PrecioLocal' => $productoLocal->Precio,
                'PrecioSQL' => null // Inicialmente no se conoce el precio SQL
            ];
        }
    
        // Consulta a la base SQL
        $productosSQL = DB::connection('sqlsrv')
                        ->table('precios')
                        ->join('productos', 'precios.IdProducto', '=', 'productos.idProducto')
                        ->select('productos.idProducto', 'productos.Descripcion', 'precios.Precio as precioSQL')
                        ->where('precios.IdListaPrecio', $listaPrecioId)
                        ->get();
    
        // Agregar los productos de SQL Server al array de productos, si no existen previamente
        foreach ($productosSQL as $productoSQL) {
            if (isset($this->productos[$productoSQL->idProducto])) {
                // Si el producto ya existe en la lista local, actualizar su precio SQL
                $this->productos[$productoSQL->idProducto]['PrecioSQL'] = $productoSQL->precioSQL;
                $this->productos[$productoSQL->idProducto]['Descripcion'] = $productoSQL->Descripcion;
            } else {
                // Si el producto no existe en la lista local, agregarlo con su precio SQL
                $this->productos[$productoSQL->idProducto] = [
                    'idProducto' => $productoSQL->idProducto,
                    'PrecioLocal' => null, // El precio local se desconoce
                    'PrecioSQL' => $productoSQL->precioSQL,
                    'Descripcion' => $productoSQL->Descripcion
                ];
            }
        }
    }

    public function actualizarPrecioLocal($idProducto, $nuevoPrecio)
    {
        // Actualizar el precio local en la base de datos
        $precioLocal = Precio::where('IdProducto', $idProducto)
                            ->where('IdListaPrecio', $this->selectedListaPrecio)
                            ->first();

        if ($precioLocal) {
            $precioLocal->Precio = $nuevoPrecio;
            $precioLocal->save();

            // Después de actualizar el precio local, volver a cargar los productos
           
        }
    }

    public function procesarArchivoExcel()
    {
        // Obtener la extensión del archivo
        $extension = $this->excelFile->getClientOriginalExtension();
        // Verificar si la extensión es de Excel
        if ($extension == 'xls' || $extension == 'xlsx') {
            // Crear un nuevo objeto PhpSpreadsheet para leer el archivo
            $documento = IOFactory::load($this->excelFile->getRealPath());
    
            // Obtener la primera hoja del documento
            $hoja = $documento->getActiveSheet();
    
            // Obtener el número total de filas con datos en la hoja
            $totalFilas = $hoja->getHighestDataRow();
    
            // Array para almacenar los datos procesados del archivo Excel
            $datosArchivo = [];
    
            // Iterar sobre las filas para obtener los datos
            for ($i = 2; $i <= $totalFilas; $i++) { // Empezamos desde la fila 2 para omitir la fila de encabezados
                // Obtener los valores de las celdas en la fila actual y limpiarlos
                $idListaPrecio = strval($hoja->getCell('A'.$i)->getValue());
                $idProducto = strval($hoja->getCell('B'.$i)->getValue());
                $precio = $hoja->getCell('C'.$i)->getValue();
                $precio = trim($precio); // Limpiar el valor de espacios en blanco
               /*  dd($precio); */
                // Validar si el precio es un número válido
                if (is_numeric($precio)) {
                    // Convertir el precio a decimal y formatearlo con tres decimales
                    $precioDecimal = number_format(floatval($precio), 3, '.', '');
    
                    // Almacenar los datos en un array asociativo
                    $datosArchivo[] = [
                        'idListaPrecio' => $idListaPrecio,
                        'idProducto' => $idProducto,
                        'precio' => $precioDecimal
                    ];
    
                    // Actualizar el precio del producto en la base de datos local
                    Precio::where('IdListaPrecio', $idListaPrecio)
                          ->where('IdProducto', $idProducto)
                          ->update(['Precio' => $precioDecimal]);
                } else {
                    // Mostrar un mensaje de error si el precio no es un número válido
                    $this->errorMessage = 'El precio en la fila '.$i.' no es un número válido.';
                }
            }
    
            // Definir la variable $successMessage
            $this->successMessage = 'Archivo Excel procesado correctamente.';
            // Asignar el mensaje de éxito a la sesión
    
        } else {
            // Mostrar un mensaje de error si el archivo no es de Excel
            session()->flash('error', 'El archivo seleccionado no es un archivo Excel válido.');
        }
    }

    public function restaurarPrecio($idProducto)
{
    // Obtener el precio SQL correspondiente al producto
    $precioSQL = null;
    foreach ($this->productos as $producto) {
        if ($producto['idProducto'] == $idProducto) {
            $precioSQL = $producto['PrecioSQL'];
            break;
        }
    }

    // Restaurar el precio local al precio SQL
    if ($precioSQL !== null) {
        $producto = Precio::where('idProducto', $idProducto)
                          ->where('IdListaPrecio', $this->selectedListaPrecio)
                          ->first();

        if ($producto) {
            $producto->Precio = $precioSQL;
            $producto->save();

            // Actualizar el precio local en la lista de productos
            $this->productos[$idProducto]['PrecioLocal'] = $precioSQL;
        }

        // Actualizar la selección para reflejar los cambios en la tabla
        $this->actualizarSeleccion();
    }
}

    

   /*  public function updatedSelectedListaPrecio($value)
    {
        // La función updated se llama automáticamente cuando selectedListaPrecio cambia
        $this->getProductos($value);
    }

    public function getProductos($listaPrecioId)
    {
        // Consulta a la base local
        $productosLocal = Precio::where('IdListaPrecio', $listaPrecioId)->get();

        // Consulta a la base SQL
        $productosSQL = DB::connection('sqlsrv')
            ->table('precios')
            ->join('productos', 'precios.IdProducto', '=', 'productos.idProducto')
            ->select('productos.idProducto','productos.Descripcion', 'precios.Precio as precioSQL')
            ->where('precios.IdListaPrecio', $listaPrecioId)
            ->get();

        // Actualizar la propiedad $productos
        $this->productos = [
            'productosLocal' => $productosLocal,
            'productosSQL' => $productosSQL
        ];
    }

    public function fetchData()
    {
        // Simular la obtención de datos desde el servidor
        $this->datos = ['Dato 1', 'Dato 2', 'Dato 3'];

        // Puedes realizar aquí otras operaciones con los datos si es necesario
    } */

    public function render()
    {
        return view('livewire.form-precios-controller');
    }
}
