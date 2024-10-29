@extends('dashboard.master')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Mis Grupos</h1>
        <a href="{{ route('groups.create') }}" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700">
            Crear Nuevo Grupo
        </a>
    </div>

    @if ($groups->isEmpty())
        <div class="bg-blue-500 text-white text-center py-4 px-4 rounded-md">
            No estás en ningún grupo actualmente.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($groups as $group)
                <div class="bg-gray-800 rounded-lg shadow-lg h-full flex flex-col">
                    <div class="bg-blue-600 rounded-t-lg px-4 py-3">
                        <h3 class="text-xl font-semibold text-white">{{ $group->name }}</h3>
                    </div>
                    <div class="p-4 flex-grow">
                        <p class="text-gray-300"><strong>Escuela:</strong> {{ $group->school ? $group->school->name : 'No asignada' }}</p>
                        <p class="text-gray-300"><strong>Profesor:</strong> {{ $group->profesor ? $group->profesor->name : 'Sin profesor' }}</p>
                    </div>
                    <div class="bg-gray-700 rounded-b-lg px-4 py-3 text-right">
                        <a href="{{ route('alumno.show', $group->id) }}" class="px-3 py-1 bg-blue-500 text-white text-sm font-semibold rounded hover:bg-blue-600">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection



