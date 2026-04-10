@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Cinzel+Decorative:wght@400;700;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap');
    
    /* Estilos del director reutilizados */
    .director-card {
        backdrop-filter: blur(15px);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0.95) 100%);
        border: 2px solid rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1), 0 0 20px rgba(124, 58, 237, 0.1), inset 0 1px 0 rgba(255, 255, 255, 1);
        transition: all 0.3s ease;
    }
    
    .director-title {
        font-family: 'Cinzel', serif;
        font-weight: 700;
        color: #1f2937;
        text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
    }

    .director-button {
        background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
        color: white;
        font-family: 'Cinzel', serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
    }

    .director-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
        background: linear-gradient(135deg, #5b21b6 0%, #4c1d95 100%);
        text-decoration: none;
        color: white;
    }

    /* Tabla de usuarios */
    .user-table {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .user-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(124, 58, 237, 0.1);
    }

    .user-row:hover {
        background: rgba(124, 58, 237, 0.05);
    }

    /* Badges de rol */
    .role-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .role-teacher { background: #dbeafe; color: #1e40af; }
    .role-student { background: #dcfce7; color: #166534; }
    .role-parent { background: #fef3c7; color: #92400e; }
    .role-admin { background: #f3e8ff; color: #6b21a8; }

    /* Fondo del dashboard */
    .dashboard-bg {
        background: url('/fondo.png') center/cover;
        min-height: 100vh;
        position: relative;
    }

    .dashboard-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
        z-index: 1;
    }

    .dashboard-content {
        position: relative;
        z-index: 2;
    }
</style>

<div class="dashboard-bg">
    <div class="dashboard-content py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header de gestión de usuarios --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold director-title mb-2" style="font-family: 'Cinzel Decorative', serif;">
                    👥 GESTIÓN DE USUARIOS 👥
                </h1>
                <p class="text-lg director-title">Administra todos los súbditos del reino</p>
                <div class="mt-4">
                    <a href="{{ route('director.dashboard') }}" class="director-button">
                        ← Volver al Panel Imperial
                    </a>
                </div>
            </div>

            {{-- Estadísticas de usuarios --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">👥</div>
                    <div class="text-2xl font-bold director-title text-blue-600">{{ $stats['total_users'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Total Usuarios</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">✅</div>
                    <div class="text-2xl font-bold director-title text-green-600">{{ $stats['active_users'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Usuarios Activos</div>
                </div>
                
                <div class="director-card p-6 text-center">
                    <div class="text-3xl mb-2">❌</div>
                    <div class="text-2xl font-bold director-title text-red-600">{{ $stats['inactive_users'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Usuarios Inactivos</div>
                </div>
            </div>

            {{-- Tabla de usuarios --}}
            <div class="director-card p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold director-title flex items-center">
                        <span class="text-3xl mr-3">👥</span>
                        Súbditos del Reino
                    </h3>
                    <button onclick="showCreateUserModal()" class="director-button">
                        ➕ Crear Usuario
                    </button>
                </div>
                
                @if($users->count() > 0)
                    <div class="user-table">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registro</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $user)
                                        <tr class="user-row">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg
                                                        {{ $user->role === 'teacher' ? 'bg-blue-100' : ($user->role === 'student' ? 'bg-green-100' : ($user->role === 'parent' ? 'bg-yellow-100' : 'bg-purple-100')) }}">
                                                        @if($user->role === 'teacher')
                                                            🧙‍♂️
                                                        @elseif($user->role === 'student')
                                                            {{ $user->character_icon ?? '⚔️' }}
                                                        @elseif($user->role === 'parent')
                                                            🛡️
                                                        @else
                                                            ⚡
                                                        @endif
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="role-badge role-{{ $user->role }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    {{-- Cambiar rol --}}
                                                    <select onchange="changeUserRole('{{ $user->_id }}', this.value)" 
                                                            class="text-xs border rounded px-2 py-1">
                                                        <option value="">Cambiar rol...</option>
                                                        <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Maestro</option>
                                                        <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Estudiante</option>
                                                        <option value="parent" {{ $user->role === 'parent' ? 'selected' : '' }}>Padre</option>
                                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                    
                                                    {{-- Toggle estado --}}
                                                    <form method="POST" action="{{ route('director.users.toggle-status', $user) }}" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" 
                                                                class="px-2 py-1 {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded text-xs transition">
                                                            {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    {{-- Estado vacío --}}
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">👥</div>
                        <h4 class="text-xl font-bold director-title mb-3">No hay usuarios registrados</h4>
                        <p class="text-gray-600 mb-6">Aún no se han registrado usuarios en el sistema.</p>
                        <button onclick="showCreateUserModal()" class="director-button">
                            Crear Primer Usuario
                        </button>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- Modal para crear usuario --}}
<div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold director-title">Crear Nuevo Usuario</h3>
            <button onclick="closeCreateUserModal()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        
        <form id="createUserForm" method="POST" action="{{ route('director.createUser') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                    <input type="text" name="name" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rol</label>
                    <select name="role" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="">Seleccionar rol...</option>
                        <option value="teacher">🧙‍♂️ Maestro</option>
                        <option value="student">⚔️ Estudiante</option>
                        <option value="parent">🛡️ Padre</option>
                        <option value="admin">⚡ Admin</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="password" required minlength="8"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeCreateUserModal()" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Función para mostrar modal de crear usuario
    function showCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
    }
    
    // Función para cerrar modal de crear usuario
    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.add('hidden');
        document.getElementById('createUserForm').reset();
    }
    
    // Función para cambiar rol de usuario
    function changeUserRole(userId, newRole) {
        if (!newRole) return;
        
        if (confirm(`¿Estás seguro de cambiar el rol de este usuario a "${newRole}"?`)) {
            // Crear formulario dinámico para enviar el cambio
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/director/users/${userId}/role`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            
            const tokenField = document.createElement('input');
            tokenField.type = 'hidden';
            tokenField.name = '_token';
            tokenField.value = csrfToken;
            
            const roleField = document.createElement('input');
            roleField.type = 'hidden';
            roleField.name = 'role';
            roleField.value = newRole;
            
            form.appendChild(methodField);
            form.appendChild(tokenField);
            form.appendChild(roleField);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    // Efectos visuales para las cards
    document.querySelectorAll('.director-card, .user-row').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.01)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
</script>
@endsection