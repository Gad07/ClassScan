@extends('dashboard.master')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-black">Lista de Grupos</h1>
        @if(Auth::user()->isProfesor())
            <!-- Solo los profesores pueden crear un nuevo grupo -->
            <a href="{{ route('groups.create') }}" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700">
                + Crear Nuevo Grupo
            </a>
        @endif
    </div>

    <div class="bg-blue-200 shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            @if($groups->isEmpty())
                <div class="bg-yellow-500 text-white text-center p-4 rounded-md">
                    No hay grupos disponibles.
                </div>
            @else
                <ul class="divide-y divide-gray-700">
                    @foreach($groups as $group)
                        <li class="flex justify-between items-center p-4 bg-white hover:bg-gray-600 rounded-md mb-3">
                            
                            <a href="{{ route('groups.show', $group->id) }}" class="text-lg font-semibold text-black hover:underline">
                                <i class="fas fa-users mr-2"></i>{{ $group->name }}
                            </a>
                            
                            @if(Auth::user()->isProfesor())
                                
                                <div class="flex space-x-2">
                                    
                                    <a href="{{ route('groups.edit', $group->id) }}" class="px-3 py-1 bg-blue-500 text-white text-sm font-semibold rounded hover:bg-blue-600">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    
                                    
                                    <form action="{{ route('groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este grupo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm font-semibold rounded hover:bg-red-600">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
