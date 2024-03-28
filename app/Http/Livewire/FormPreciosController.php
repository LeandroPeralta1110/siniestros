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
    public $datosArchivo; 
    public $mostrarPopUpDatosArchivo = false;
    public $datosPorListaPrecio;
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
    
    // Obtiene los productos por lista de precio.
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
            
            // Consultar el precio de la base AGUAS
            $precioSQL = DB::connection('sqlsrv')
                    ->table('precios')
                    ->join('productos', 'precios.IdProducto', '=', 'productos.idProducto')
                    ->join('listas','precios.IdListaPrecio', '=', 'listas.IdListaPrecio')
                    ->select('precios.Precio as precioSQL','productos.Descripcion','listas.Descrp as descripcionLista')
                    ->where('precios.IdListaPrecio', $idListaPrecio)
                    ->where('productos.idProducto', $idProducto)
                    ->first();

            if($precioSQL){
                // Agregar el producto con ambos precios a la lista de productos
                $this->productos[] = [
                    'idListaPrecio' => $idListaPrecio, 
                    'idProducto' => $idProducto, 
                    'Descripcion' => $precioSQL->Descripcion, 
                    'descripcionLista' => $precioSQL->descripcionLista,
                    'PrecioLocal' => $precioLocal,
                    'PrecioSQL' => $precioSQL->precioSQL, 
                ];
            }
        }
    }
    /* dd($this->productos); */
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
            'PrecioSQL' => null, // Inicialmente no se conoce el precio SQL
            'Descripcion' => $productoLocal->Descripcion,
            'Precio' => $productoLocal->Precio // Agregar el precio local
        ];
    }
    
    // Consulta a la base SQL
    $productosSQL = DB::connection('sqlsrv')
                    ->table('precios')
                    ->join('productos', 'precios.IdProducto', '=', 'productos.idProducto')
                    ->join('listas','precios.IdListaPrecio', '=', 'listas.IdListaPrecio')
                    ->select('productos.idProducto', 'productos.Descripcion', 'precios.Precio as precioSQL','listas.Descrp as descripcionLista')
                    ->where('precios.IdListaPrecio', $listaPrecioId)
                    ->get();

    // Agregar los productos de SQL Server al array de productos, si no existen previamente
    foreach ($productosSQL as $productoSQL) {
        if (isset($this->productos[$productoSQL->idProducto])) {
            // Si el producto ya existe en la lista local, actualizar su precio SQL
            $this->productos[$productoSQL->idProducto]['PrecioSQL'] = $productoSQL->precioSQL;
            $this->productos[$productoSQL->idProducto]['Descripcion'] = $productoSQL->Descripcion;
            $this->productos[$productoSQL->idProducto]['descripcionLista'] = $productoSQL->descripcionLista;
        } else {
            // Si el producto no existe en la lista local, agregarlo con su precio SQL
            $precioLocal = Precio::firstOrCreate([
                'idProducto' => $productoSQL->idProducto,
                'IdListaPrecio' => $listaPrecioId
            ],
            [
                'Precio' => $productoSQL->precioSQL,
                'idListaPrecio' => $listaPrecioId 
            ]);

            $this->productos[$productoSQL->idProducto] = [
                'idProducto' => $productoSQL->idProducto,
                'PrecioLocal' => null, // El precio local se desconoce
                'IdListaPrecio' => $precioLocal->IdListaPrecio,
                'PrecioSQL' => $productoSQL->precioSQL,
                'Descripcion' => $productoSQL->Descripcion,
                'Precio' => $productoSQL->precioSQL // Agregar el precio local
            ];
        }
    }
}


    public function actualizarPrecioLocal($idProducto, $nuevoPrecio, $idListaPrecio, $precioOriginal)
    {
        // Actualizar el precio local en la base de datos
        $precioLocal = Precio::where('IdProducto', $idProducto)
                            ->where('IdListaPrecio', $idListaPrecio)
                            ->first();
        
        if ($precioLocal) {
            $precioLocal->Precio = $nuevoPrecio;
            $precioLocal->save();
            $this->actualizarSeleccion();
        }
    
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

    public function restaurarPreciosALL()
{
    // Consulta a la base local
    $productosLocal = Precio::all();

    // Consulta a la base SQL
    $productosSQL = DB::connection('sqlsrv')
                    ->table('precios')
                    ->join('productos', 'precios.IdProducto', '=', 'productos.idProducto')
                    ->select('productos.idProducto', 'productos.Descripcion', 'precios.Precio as precioSQL', 'precios.IdListaPrecio')
                    ->get();

    // Combinar productos locales y de SQL en una sola matriz
    $productosTotales = [];

    // Agregar productos locales al array
    foreach ($productosLocal as $productoLocal) {
        $productosTotales[$productoLocal->idProducto][$productoLocal->idListaPrecio] = [
            'idProducto' => $productoLocal->idProducto,
            'IdListaPrecio' => $productoLocal->idListaPrecio,
            'PrecioLocal' => $productoLocal->Precio, // Agregar el precio local aquí
            'PrecioSQL' => null, // El precio SQL se desconoce inicialmente
            'Descripcion' => $productoLocal->Descripcion
        ];
    }
   
   // Agregar productos SQL al array
    foreach ($productosSQL as $productoSQL) {
        // Verificar si el producto local existe en la base SQL Server
        if (!isset($productosTotales[$productoSQL->idProducto])) {
            continue; // Saltar este producto y pasar al siguiente
        }

        // Verificar si la clave 'PrecioLocal' existe en el array combinado para este producto y lista de precios
        $precioLocal = isset($productosTotales[$productoSQL->idProducto][$productoSQL->IdListaPrecio]['PrecioLocal'])
            ? $productosTotales[$productoSQL->idProducto][$productoSQL->IdListaPrecio]['PrecioLocal']
            : null;

        // Agregar el producto SQL al array combinado
        $productosTotales[$productoSQL->idProducto][$productoSQL->IdListaPrecio] = [
            'idProducto' => $productoSQL->idProducto,
            'IdListaPrecio' => $productoSQL->IdListaPrecio,
            'PrecioLocal' => $precioLocal, // Usar el precio local del primer array
            'PrecioSQL' => $productoSQL->precioSQL,
            'Descripcion' => $productoSQL->Descripcion
        ];
    }

    // Iterar sobre los productos totales para comparar y actualizar los precios
    foreach ($productosTotales as $productosPorId) {
        foreach ($productosPorId as $producto) {
            // Verificar si el producto tiene un precio local y un precio de SQL
            if (!empty($producto['PrecioLocal']) && !empty($producto['PrecioSQL'])) {
                // Verificar si el precio local difiere del precio de SQL
                if ($producto['PrecioLocal'] != $producto['PrecioSQL']) {
                    // Actualizar el precio local con el precio de SQL
                    $productoDB = Precio::where('idProducto', $producto['idProducto'])
                                        ->where('IdListaPrecio', $producto['IdListaPrecio'])
                                        ->firstOrFail();
                    
                    $productoDB->Precio = $producto['PrecioSQL'];
                    $productoDB->save();
                }
            }
        }
    }
    $this->actualizarSeleccion();
}

public function procesarArchivoExcel()
{
    $this->validate([
        'excelFile' => 'required|mimes:csv,txt,xlsx|max:2048',
    ]);

    // Obtener la extensión del archivo
    $extension = $this->excelFile->getClientOriginalExtension();
    
    // Verificar si la extensión es de Excel
    if ($extension == 'xls' || $extension == 'xlsx') {
        // Crear un nuevo objeto PhpSpreadsheet para leer el archivo
        $documento = IOFactory::load($this->excelFile->getRealPath());

        // Obtener la quinta hoja del documento por su nombre
        $hoja = $documento->getSheetByName('Sheet5');

        // Verificar si la hoja se encontró
        if ($hoja) {
            // Array para almacenar los datos de la tabla
            $datos = [];

            // Array para almacenar los encabezados
            $headers = [];

            // Definir el rango de celdas para los encabezados
            $encabezadosRange = 'A5:K5';
            // Leer los encabezados de la quinta fila
            $encabezadosData = $hoja->rangeToArray($encabezadosRange, null, true, true, true);
            $headers = $encabezadosData[5];

            $encabezadosRange2 = 'Q5:V5';
            // Leer los encabezados de la quinta fila
            $encabezadosData2 = $hoja->rangeToArray($encabezadosRange2, null, true, true, true);
            $headers2 = $encabezadosData2[5];
           
           // Definir el mapeo entre los encabezados y los IDs de lista de precios para la primera tabla
        $mapeoIdListaPrecios = [
            'GBA' => 1, // ID 1 para GBA
            'CABA' => 222, // ID 222 para CABA
            'F/C GBA' => '07', // ID '07' para F/C GBA
            'F/C CABA' => 333, // ID 333 para F/C CABA
            'FRANQUICIAS' => 'L10', // ID 'L10' para FRANQUICIAS
            'Municipalidad 3F' => 10, // ID 10 para Municipalidad 3F
            'Colegios' => 555, // ID 555 para Colegios
            'Promociones' => null, // No asociar Promociones a ningún ID de lista de precios
        ];

        // Definir el mapeo entre los encabezados y el idListaPrecio 60 para la segunda tabla
        $mapeo2IdListaPrecios = [
            'Código' => 90,
            'PRODUCTO' => 90,
            'Precio' => 90,
        ];

       // Encontrar la última fila en la columna A
        $ultimaFilaTabla1 = $hoja->getCell('A' . $hoja->getHighestRow())->getRow();

        // Definir el rango dinámico
        $datosRangeTabla1 = 'A6:K' . $ultimaFilaTabla1;

        // Obtener los datos del rango dinámico
        $datosDataTabla1 = $hoja->rangeToArray($datosRangeTabla1, null, true, true, true);

        // Procesar los datos
        $datos = [];

        foreach ($datosDataTabla1 as $fila => $rowData) {
            if (isset($rowData['A']) && strlen($rowData['A']) <= 5) {
                $producto = $rowData['A'];

                for ($i = 3; $i <= 11; $i++) {
                    $precio = $rowData[chr(64 + $i)];
                    $clave = $headers[chr(64 + $i)] ?? null;

                    if ($clave && $precio !== null && $precio !== '') {
                        $idListaPrecio = $mapeoIdListaPrecios[$clave] ?? null;

                        if ($idListaPrecio !== null) {
                            $datos[] = [
                                'idListaPrecio' => $idListaPrecio,
                                'idProducto' => $producto,
                                'precio' => $precio,
                            ];
                        }
                    }
                }
            }
        }
       
        // Encontrar la última fila en la columna Q
        $ultimaFila = $hoja->getCell('Q' . $hoja->getHighestRow())->getRow();
        // Definir el rango dinámico
        $datosRange2 = 'Q6:V' . $ultimaFila;

        // Obtener los datos del rango dinámico
        $datosData2 = $hoja->rangeToArray($datosRange2, null, true, true, true);

        // Procesar los datos
        foreach ($datosData2 as $fila => $rowData) {
            if (isset($rowData['Q']) && strlen($rowData['Q']) <= 5) {
                $producto = $rowData['Q'];
                $precio = $rowData['U']; // El precio está en la columna T según tu descripción

                // Asignar el idListaPrecio 60 para los productos de la segunda tabla
                $datos[] = [
                    'idListaPrecio' => $mapeo2IdListaPrecios['Precio'],
                    'idProducto' => $producto,
                    'precio' => $precio,
                ];
            }
        }
        
         $this->mostrarPopUpDatos($datos);
           /*  // Recorrer los datos procesados del Excel
            foreach ($datos as $dato) {
                $idListaPrecio = $dato['idListaPrecio'];
                $idProducto = $dato['idProducto'];
                $precioNuevo = $dato['precio'];
            
                // Eliminar el signo "$" y las comas del precio
                $precioNuevo = str_replace(['$', ','], '', $precioNuevo);
            
                // Convertir el precio a un formato decimal
                $precioNuevo = number_format((float) $precioNuevo, 3, '.', ''); // Formato con tres decimales
            
                // Buscar en la base de datos local el precio existente para el mismo idListaPrecio y idProducto
                $precioExistente = Precio::where('idListaPrecio', $idListaPrecio)
                                        ->where('idProducto', $idProducto)
                                        ->first();

                // Si el precio existe, actualizarlo; de lo contrario, crear un nuevo registro en la base de datos
                if ($precioExistente) {
                    $precioExistente->precio = $precioNuevo;
                    $precioExistente->save();
                    $this->actualizarSeleccion();
                } 
            } */
                } else {
                    // Mostrar un mensaje de error si no se encontró la quinta hoja
                    session()->flash('error', 'La hoja "Sheet5" no se encontró en el archivo.');
                }
            } else {
                // Mostrar un mensaje de error si el archivo no es de Excel
                session()->flash('error', 'El archivo seleccionado no es un archivo Excel válido.');
            }
        }

        public function mostrarPopUpDatos($datos){
            $this->datosArchivo = $datos;
        
            // Agrupar los datos por idListaPrecio
            $this->datosPorListaPrecio = collect($datos)->groupBy('idListaPrecio')->toArray();
            // Asignar nombres a las listas de precios
            $mapeoNombresListaPrecios = [
                1 => 'GBA',
                222 => 'CABA',
                '07' => 'F/C GBA',
                333 => 'F/C CABA',
                'L10' => 'FRANQUICIAS',
                10 => 'Municipalidad 3F',
                555 => 'Colegios',
                90 => 'GASTRONOMIA',
            ];
        
            foreach ($this->datosPorListaPrecio as $idListaPrecio => $productos) {
                $nombreListaPrecio = $mapeoNombresListaPrecios[$idListaPrecio] ?? 'Desconocido';
                $this->datosPorListaPrecio[$idListaPrecio]['nombreListaPrecio'] = $nombreListaPrecio;
            }
        
            $this->mostrarPopUpDatosArchivo = true;
        }

        public function cerrarPopup(){
            $this->mostrarPopUpDatosArchivo = false;
            $this->datosArchivo = [];
        }

        public function aceptarCambios(){
            // Recorrer los datos procesados del Excel
            foreach ($this->datosArchivo as $dato) {
                $idListaPrecio = $dato['idListaPrecio'];
                $idProducto = $dato['idProducto'];
                $precioNuevo = $dato['precio'];
            
                // Eliminar el signo "$" y las comas del precio
                $precioNuevo = str_replace(['$', ','], '', $precioNuevo);
            
                // Convertir el precio a un formato decimal
                $precioNuevo = number_format((float) $precioNuevo, 3, '.', ''); // Formato con tres decimales
            
                // Buscar en la base de datos local el precio existente para el mismo idListaPrecio y idProducto
                $precioExistente = Precio::where('idListaPrecio', $idListaPrecio)
                                        ->where('idProducto', $idProducto)
                                        ->first();

                // Si el precio existe, actualizarlo;
                if ($precioExistente) {
                    $precioExistente->precio = $precioNuevo;
                    $precioExistente->save();
                    $this->actualizarSeleccion();
                } 
            }
            $this->mostrarPopUpDatosArchivo = false;
        }

        public function render()
        {
            return view('livewire.form-precios-controller');
        }
}
