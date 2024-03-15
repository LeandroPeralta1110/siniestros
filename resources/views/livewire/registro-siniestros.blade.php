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
                    <td><a href="{{ route('siniestro.pdf', ['id' => $siniestro->id]) }}">Ver PDF</a></td>
                    <td>
                        <!-- Botones de editar y eliminar -->
                        <button wire:click="editSiniestro({{ $siniestro->id }})" class="btn btn-primary">Editar</button>
                        <button wire:click="deleteSiniestro({{ $siniestro->id }})" class="btn btn-danger">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
