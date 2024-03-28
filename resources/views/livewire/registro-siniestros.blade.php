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
                    <td>{{ \carbon\carbon::parse($siniestro->created_at)->format('d-m-Y') }}</td>
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

    @if($mostrarEditPopup)
    <div class="popup-container">
        <div class="popup">
            <div>
                <h2>Editando Siniestro: {{ $siniestroParaEditar->id }}</h2>
                <p>Creado por: {{ $siniestroParaEditar->user->name }}</p>
                <p>Fecha de Creación: {{ $siniestroParaEditar->created_at }}</p>
                
                <form wire:submit.prevent="updateSiniestro">

                        <label for="nombreApellidoChofer">Nombre y Apellido del Chofer</label>
                        <input type="text" name="nombreApellidoChofer" id="nombreApellidoChofer" wire:model="siniestroParaEditar.nombreApellidoChofer" value="{{ $siniestroParaEditar->nombreApellidoChofer }}">

                        <label for="DNIchofer">DNI del Chofer</label>
                        <input type="text" name="DNIchofer" id="DNIchofer" wire:model="siniestroParaEditar.DNIchofer" value="{{ $siniestroParaEditar->DNIchofer }}">

                        <label for="legajoChofer">Legajo del Chofer</label>
                        <input type="text" name="legajoChofer" id="legajoChofer" wire:model="siniestroParaEditar.legajoChofer" value="{{ $siniestroParaEditar->legajoChofer }}">

                        <label for="telChof">Teléfono del Chofer</label>
                        <input type="text" name="telChof" id="telChof" wire:model="siniestroParaEditar.telChof" value="{{ $siniestroParaEditar->telChof }}">

                        <label for="nom_ape_ayudante">Nombre y Apellido del Ayudante</label>
                        <input type="text" name="nom_ape_ayudante" id="nom_ape_ayudante" wire:model="siniestroParaEditar.nom_ape_ayudante" value="{{ $siniestroParaEditar->nom_ape_ayudante }}">

                        <label for="patente_vehiculo">Patente del Vehículo</label>
                        <input type="text" name="patente_vehiculo" id="patente_vehiculo" wire:model="siniestroParaEditar.patente_vehiculo" value="{{ $siniestroParaEditar->patente_vehiculo }}">

                        <label for="interno_vehiculo">Interno del Vehículo</label>
                        <input type="text" name="interno_vehiculo" id="interno_vehiculo" wire:model="siniestroParaEditar.interno_vehiculo" value="{{ $siniestroParaEditar->interno_vehiculo }}">

                    <input type="hidden" name="id" value="{{ $siniestroParaEditar->id }}"> <!-- Agregar un campo oculto con el ID del siniestro -->
                    <button type="submit">Guardar cambios</button>
                    <button wire:click="closeEditPopup">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
@endif

    {{-- @if($mostrarEditPopup != false)
    <div class="popup-container">
        <div class="popup" style="overflow-y: auto;">
            <span class="close" wire:click="closeEditPopup">&times;</span>
            <!-- Mostrar los datos del siniestro para editar -->
            <div style="max-height: 80vh; overflow-y: auto;">
                <h2>Editando Siniestro: {{ $siniestroParaEditar->id }}</h2>
                <p>Creado por: {{ $siniestroParaEditar->user->name }}</p>
                <p>Fecha de Creación: {{ $siniestroParaEditar->created_at }}</p>
                
                <!-- Mostrar los demás campos del siniestro para editar -->
               <!-- Formulario -->
                <form wire:submit.prevent="guardarCambios">
                    @csrf
                    @foreach($siniestroParaEditar->getAttributes() as $key => $value)
                        @if (!str_ends_with($key, '_path'))
                            <div>
                                <label for="{{ $key }}">{{ $key }}</label>
                                @if(is_numeric($siniestroParaEditar->{$key}))
                                    <input type="number" id="{{ $key }}" value="{{ $siniestroParaEditar->{$key} }}" wire:model="siniestroParaEditar.{{ $key }}" required>
                                @elseif(is_a($siniestroParaEditar->{$key}, 'Illuminate\Support\Carbon'))
                                    <input type="datetime-local" id="{{ $key }}" value="{{ $siniestroParaEditar->{$key} }}" wire:model="siniestroParaEditar.{{ $key }}" required>
                                @else
                                    <input type="text" id="{{ $key }}"value="{{ $siniestroParaEditar->{$key} }}" wire:model="siniestroParaEditar.{{ $key }}" required>
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
@endif --}}

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
