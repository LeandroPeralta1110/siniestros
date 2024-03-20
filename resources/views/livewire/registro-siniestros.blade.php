<!-- Vista Blade -->
<div>
    <table class="table">
        <thead>
            <tr>
                <th>ID Siniestro</th>
                <th>Creado por</th>
                <th>Fecha de Creación</th>
                <th>Vista Previa PDF</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siniestros as $siniestro)
                <tr>
                    <td>{{ $siniestro->id }}</td>
                    <td>{{ $siniestro->user->name }}</td>
                    <td>{{ $siniestro->created_at }}</td>
                    <td>
                        <!-- Botón para abrir la ventana modal -->
                        <button wire:click="showPdf({{ $siniestro->id }})" class="btn btn-primary">Ver PDF</button>
                    </td>
                    <td>
                        <!-- Botones de editar y eliminar -->
                        <button wire:click="editSiniestro({{ $siniestro->id }})" class="btn btn-primary">Editar</button>
                        <button wire:click="deleteSiniestro({{ $siniestro->id }})" class="btn btn-danger">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($mostrarEditPopup != false)
    <div class="popup-container">
        <div class="popup" style="overflow-y: auto;">
            <span class="close" wire:click="closeEditPopup">&times;</span>
            <!-- Mostrar los datos del siniestro para editar -->
            <div style="max-height: 80vh; overflow-y: auto;">
                <h2>Editando Siniestro: {{ $siniestroParaEditar->id }}</h2>
                <p>Creado por: {{ $siniestroParaEditar->user->name }}</p>
                <p>Fecha de Creación: {{ $siniestroParaEditar->created_at }}</p>
                
                <!-- Mostrar los demás campos del siniestro para editar -->
                <form wire:submit.prevent="guardarCambios">
                    @foreach($siniestroParaEditar->getAttributes() as $key => $value)
                        @if (!str_ends_with($key, '_path')) <!-- Excluimos los campos que terminan con '_path' (las imágenes) -->
                            <div>
                                <label for="{{ $key }}">{{ $key }}</label>
                                @if(is_numeric($siniestroParaEditar->{$key}))
                                    <input type="number" id="{{ $key }}" value="{{$value}}" name="{{ $key }}" wire:model="siniestroParaEditar.{{ $key }}" required>
                                @elseif(is_a($siniestroParaEditar->{$key}, 'Illuminate\Support\Carbon'))
                                    <input type="datetime-local" id="{{ $key }}" value="{{$value}}" name="{{ $key }}" wire:model="siniestroParaEditar.{{ $key }}" required>
                                @else
                                    <input type="text" id="{{ $key }}" value="{{$value}}" name="{{ $key }}" wire:model="siniestroParaEditar.{{ $key }}" required>
                                @endif
                            </div>
                        @endif
                    @endforeach
                    <button type="submit">Guardar Cambios</button>
                </form>
                <!-- Agrega los demás campos según tus necesidades -->
            </div>
        </div>
    </div>
@endif

     <!-- Ventana modal para mostrar el PDF -->
     @if($mostrarPopup)
     <div class="popup-container">
         <div class="popup">
             <span class="close" wire:click="closePdfModal">&times;</span>
             <div id="pdfContainer">
                 <iframe id="pdfIframe" src="{{ $pdfUrl }}" frameborder="0" style="width: 100%; height: 80vh;"></iframe>
             </div>
         </div>
     </div>
     @endif
 </div>
