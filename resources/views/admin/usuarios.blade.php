@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<!-- Titulo y Botón Crear -->
<div class="bg-slate-900/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-black text-white flex items-center space-x-2">
            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span>Gestión de Usuarios y Roles</span>
        </h1>
        <p class="text-xs text-slate-400 mt-1">
            Crear, modificar cuentas, cambiar roles (Administrador / Capturista) y gestionar el acceso a S.E.P.A.
        </p>
    </div>

    <button type="button" onclick="openCreateModal()" class="py-2.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold text-xs rounded-xl shadow-lg shadow-blue-900/40 flex items-center space-x-2 transition border border-blue-400/30">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        <span>Nuevo Usuario</span>
    </button>
</div>

<!-- Errores de Validación (Si existen) -->
@if ($errors->any())
    <div class="bg-red-500/10 border border-red-500/30 backdrop-blur-md text-red-300 p-4 rounded-2xl shadow-lg text-xs space-y-1">
        <div class="font-bold flex items-center space-x-2 text-red-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Corrige los siguientes errores para continuar:</span>
        </div>
        <ul class="list-disc list-inside pl-6 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Filtros y Búsqueda -->
<div class="bg-slate-900/80 backdrop-blur-md p-4 rounded-2xl shadow-lg border border-slate-800">
    <form action="{{ route('admin.usuarios') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
        <div class="relative w-full sm:w-80">
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre, email o usuario..."
                   class="w-full bg-slate-800/90 text-white text-xs rounded-xl pl-9 pr-4 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500 placeholder-slate-500">
            <svg class="w-4 h-4 text-slate-500 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <div class="flex items-center space-x-3 w-full sm:w-auto">
            <select name="rol" class="bg-slate-800/90 text-slate-300 text-xs rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
                <option value="">Todos los Roles</option>
                <option value="administrador" {{ request('rol') === 'administrador' ? 'selected' : '' }}>Administradores</option>
                <option value="capturista" {{ request('rol') === 'capturista' ? 'selected' : '' }}>Capturistas</option>
            </select>

            <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white text-xs font-semibold rounded-xl border border-slate-700 transition">
                Filtrar
            </button>

            @if(request('buscar') || request('rol'))
                <a href="{{ route('admin.usuarios') }}" class="px-3 py-2.5 text-xs text-slate-400 hover:text-white transition">
                    Limpiar
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Tabla de Usuarios -->
<div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-300">
            <thead class="bg-slate-800/90 text-slate-400 uppercase font-semibold text-[10px] tracking-wider border-b border-slate-800">
                <tr>
                    <th class="px-6 py-4">Usuario</th>
                    <th class="px-6 py-4">Nombre Completo</th>
                    <th class="px-6 py-4">Correo Electrónico</th>
                    <th class="px-6 py-4 text-center">Rol Asignado</th>
                    <th class="px-6 py-4">Fecha Registro</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/80">
                @forelse($usuarios as $user)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="px-6 py-4 font-bold text-white flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-slate-700 to-slate-600 border border-slate-500/30 flex items-center justify-center font-bold text-xs text-blue-400 shadow-inner">
                                {{ strtoupper(substr($user->username ?? $user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span>{{ $user->username }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-200 font-medium">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-slate-400">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($user->rol === 'administrador')
                                <span class="bg-red-500/10 text-red-400 border border-red-500/30 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    Administrador
                                </span>
                            @else
                                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/30 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    Capturista
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <!-- Botón Editar (con atributos data-* totalmente seguros) -->
                                <button type="button"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-username="{{ $user->username }}"
                                        data-email="{{ $user->email }}"
                                        data-rol="{{ $user->rol }}"
                                        onclick="openEditModal(this)"
                                        class="p-1.5 bg-slate-800 hover:bg-blue-600/30 text-slate-300 hover:text-blue-400 rounded-lg border border-slate-700 transition"
                                        title="Editar usuario">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <!-- Botón Eliminar -->
                                @if(Auth::id() !== $user->id)
                                    <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-slate-800 hover:bg-red-600/30 text-slate-300 hover:text-red-400 rounded-lg border border-slate-700 transition" title="Eliminar usuario">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500 italic">
                            No se encontraron usuarios con los criterios especificados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($usuarios->hasPages())
        <div class="px-6 py-4 border-t border-slate-800">
            {{ $usuarios->withQueryString()->links() }}
        </div>
    @endif
</div>

<!-- Modal Crear Usuario -->
<div id="createModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center hidden">
    <div class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl shadow-2xl p-6 relative">
        <div class="flex justify-between items-center pb-4 border-b border-slate-800">
            <h3 class="text-lg font-bold text-white">Crear Nuevo Usuario</h3>
            <button type="button" onclick="closeCreateModal()" class="text-slate-400 hover:text-white">&times;</button>
        </div>

        <form action="{{ route('admin.usuarios.store') }}" method="POST" class="mt-4 space-y-4 text-xs">
            @csrf
            <div>
                <label class="block text-slate-300 font-semibold mb-1">Nombre Completo</label>
                <input type="text" name="name" required class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-300 font-semibold mb-1">Usuario (Username)</label>
                    <input type="text" name="username" required class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-slate-300 font-semibold mb-1">Rol</label>
                    <select name="rol" required class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
                        <option value="capturista">Capturista</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-slate-300 font-semibold mb-1">Correo Electrónico</label>
                <input type="email" name="email" required class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-slate-300 font-semibold mb-1">Contraseña</label>
                <input type="password" name="password" required minlength="6" class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
            </div>

            <div class="pt-4 border-t border-slate-800 flex justify-end space-x-3">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl font-semibold">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-semibold shadow-lg shadow-blue-900/40">Guardar Usuario</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div id="editModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 flex items-center justify-center hidden">
    <div class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl shadow-2xl p-6 relative">
        <div class="flex justify-between items-center pb-4 border-b border-slate-800">
            <h3 class="text-lg font-bold text-white">Editar Cuenta de Usuario</h3>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-white">&times;</button>
        </div>

        <form id="editForm" method="POST" class="mt-4 space-y-4 text-xs">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-slate-300 font-semibold mb-1">Nombre Completo</label>
                <input type="text" id="edit_name" name="name" required class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-300 font-semibold mb-1">Usuario (Username)</label>
                    <input type="text" id="edit_username" name="username" required class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-slate-300 font-semibold mb-1">Rol</label>
                    <select id="edit_rol" name="rol" required class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
                        <option value="capturista">Capturista</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-slate-300 font-semibold mb-1">Correo Electrónico</label>
                <input type="email" id="edit_email" name="email" required class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-slate-300 font-semibold mb-1">Nueva Contraseña (Opcional)</label>
                <input type="password" name="password" placeholder="Dejar en blanco para mantener la actual" minlength="6" class="w-full bg-slate-800 text-white rounded-xl px-3 py-2.5 border border-slate-700 focus:outline-none focus:border-blue-500">
            </div>

            <div class="pt-4 border-t border-slate-800 flex justify-end space-x-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl font-semibold">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-semibold shadow-lg shadow-blue-900/40">Actualizar Datos</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
    }
    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    function openEditModal(btn) {
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const username = btn.dataset.username;
        const email = btn.dataset.email;
        const rol = btn.dataset.rol;

        document.getElementById('editForm').action = '/admin/usuarios/' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_username').value = username || '';
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_rol').value = rol;
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
