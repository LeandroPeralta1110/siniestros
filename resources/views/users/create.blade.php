<x-app-layout>
<div>
    <h1>Crear Usuario</h1>
    
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="legajo">Legajo</label>
                <input type="text" name="legajo" id="legajo" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            @if ($allowedRoles)
                <div class="form-group">
                    <label for="role">Rol</label>
                    <select name="role" id="role" class="form-control" required>
                        @foreach ($allowedRoles as $roleId => $roleName)
                            <option value="{{ $roleId }}">{{ ucfirst($roleName) }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Crear Usuario</button>
        </form>
</div>
</x-app-layout>
