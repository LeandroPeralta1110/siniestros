<?php
namespace App\Http\Livewire;

use Livewire\WithFileUploads;
use App\Models\Precio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Session;

class FormPreciosController extends Component
{
    protected $listeners = ['actualizarPrecioLocal'];
    public $cacheable = false;
    public $listasPrecios;
    public $selectedListaPrecio;
    public $productos;
    public $listProductos;
    public $datos; 
    public $productosModificados = [];
    public $excelFile;
    public $successMessage;
    public $errorMessage;
    public $selectedProducto;
    use WithFileUploads;
    
    public function mount()
    {
        // Consultar la base de datos para obtener las opciones del select
        $this->listasPrecios = DB::connection('sqlsrv')->table('Listas')->distinct()->pluck('idListaPrecio','Descrp');
       /*  dd($this->listasPrecios); */
        $this->listProductos = DB::connection('sqlsrv')->table('Productos')->distinct()->pluck('idProducto');
        /* dd($this->listasPrecios); */
    }

    public function updatedSelectedProducto($value)
    {
        if (!empty($value)) {
            $this->obtenerProductosPorListaPrecios($value);
        } else {
            $this->productos = null;
        }
        $this->selectedListaPrecio = null; // Reiniciar la selección de lista de precios cuando se cambia el producto
    }
    
    public function obtenerProductosPorListaPrecios()
{
    // Reiniciar la variable $productos antes de actualizar
    $this->productos = [];

    $idProducto = $this->selectedProducto;
    
    // Consultar todas las listas de precios disponibles
    $listasPrecios = $this->listasPrecios->values();
    
    // Consultar los productos para el producto seleccionado en todas las listas de precios
    foreach ($listasPrecios as $idListaPrecio) {
        // Consultar el producto para el producto y la lista de precios actual
        $producto = Precio::where('idProducto', $idProducto)
                        ->where('idListaPrecio', $idListaPrecio)
                        ->first();
        // Si se encontró un producto, agregarlo a la lista de productos
        if ($producto) {
            // Obtener el precio de la base local y el precio de la base SQL
            $precioLocal = $producto->Precio;
            
            // Consultar el precio de la base SQL
            $precioSQL = DB::connection('sqlsrv')
                    ->table('precios')
                    ->join('productos', 'precios.IdProducto', '=', 'productos.idProducto')
                    ->select('precios.Precio as precioSQL','productos.Descripcion')
                    ->where('precios.IdListaPrecio', $idListaPrecio)
                    ->where('productos.idProducto', $idProducto)
                    ->first();

            // Agregar el producto con ambos precios a la lista de productos
            $this->productos[] = [
                'idListaPrecio' => $idListaPrecio, // Utiliza $idListaPrecio en lugar de $producto->idListaPrecio
                'idProducto' => $idProducto, // Utiliza $idProducto en lugar de $producto->idProducto
                'Descripcion' => $precioSQL->Descripcion, // Accede a la descripción desde $precioSQL
                'PrecioLocal' => $precioLocal,
                'PrecioSQL' => $precioSQL->precioSQL, // Accede al precio desde $precioSQL
            ];
        }
    }
}

    public function actualizarSeleccion()
    {
        // Reiniciar la variable $productos antes de actualizar
        $this->productos = [];
    
        // Acceder al valor seleccionado por el usuario
        $listaPrecioId = $this->selectedListaPrecio;
        
        // Consulta a la base local
        $productosLocal = Precio::where('IdListaPrecio', $listaPrecioId)->get();

        // Guardar los productos locales en el array de productos
        foreach ($productosLocal as $productoLocal) {
            $this->productos[$productoLocal->idProducto] = [
                'idProducto' => $productoLocal->idProducto,
                'idListaPrecio' => $productoLocal->idListaPrecio, // Agregar el ID de la lista de precios
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
                    'IdListaPrecio' => $productoLocal->IdListaPrecio,
                    'PrecioSQL' => $productoSQL->precioSQL,
                    'Descripcion' => $productoSQL->Descripcion
                ];
            }
        }
        
        /* dd($this->productos); */
    }

    public function actualizarPrecioLocal(Request $request)
    {
        // Obtener los datos de la solicitud
        $idProducto = $request->idProducto;
        $nuevoPrecio = $request->nuevoPrecio;
        $idListaPrecio = $request->idListaPrecio;
        
        // Obtener el precio original del producto
        $precioOriginal = Precio::where('IdProducto', $idProducto)
                            ->where('IdListaPrecio', $idListaPrecio)
                            ->value('Precio');
    
        // Actualizar el precio local en la base de datos
        $precioLocal = Precio::where('IdProducto', $idProducto)
                            ->where('IdListaPrecio', $idListaPrecio)
                            ->first();
        
        if ($precioLocal) {
            $precioLocal->Precio = $nuevoPrecio;
            $precioLocal->save();
            
        }
    
        // Comprobar si el nuevo precio difiere del precio original
        $precioDifiere = ($nuevoPrecio != $precioOriginal);
    
        // Devolver una respuesta con la información necesaria
        return response()->json([
            'message' => 'Datos actualizados correctamente.',
            'precioDifiere' => $precioDifiere
        ]);
    }
    
    public function restaurarPrecio($idProducto, $idListaPrecio)
{
    // Obtener el precio SQL correspondiente al producto
    $precioSQL = null;
    foreach ($this->productos as $key => $producto) {
        if ($producto['idProducto'] == $idProducto && $producto['idListaPrecio'] == $idListaPrecio) {
            $precioSQL = $producto['PrecioSQL'];
            break;
        }
    }

    // Restaurar el precio local al precio SQL
    if ($precioSQL !== null) {
        // Actualizar el precio local del producto en la base de datos
        $producto = Precio::where('idProducto', $idProducto)
                        ->where('IdListaPrecio', $idListaPrecio)
                        ->firstOrFail(); // Obtiene el producto específico o lanza una excepción si no se encuentra
        $producto->Precio = $precioSQL;
        $producto->save();

        // Actualizar el precio local en la lista de productos
        foreach ($this->productos as $key => $producto) {
            if ($producto['idProducto'] == $idProducto && $producto['idListaPrecio'] == $idListaPrecio) {
                $this->productos[$key]['PrecioLocal'] = $precioSQL;
                break;
            }
        }
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

    public function render()
    {
        return view('livewire.form-precios-controller');
    }
}
