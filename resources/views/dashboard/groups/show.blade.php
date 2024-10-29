@extends('dashboard.master')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-white mb-6">Información del Grupo</h1>

    <div class="bg-gray-800 rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-white mb-4">{{ $group->name }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <p class="text-gray-300"><strong>Escuela:</strong> {{ $group->school->name ?? 'No asignada' }}</p>
            <p class="text-gray-300"><strong>Profesor:</strong> {{ $group->profesor->name ?? 'Sin profesor' }}</p>
            <p class="text-gray-300"><strong>Materia:</strong> {{ $group->subject ?? 'No especificada' }}</p>
            <p class="text-gray-300"><strong>Días de Clases:</strong> {{ $group->class_days ?? 'No especificado' }}</p>
            <p class="text-gray-300"><strong>Horario de Clases:</strong> {{ $group->class_schedule ?? 'No especificado' }}</p>
            <p class="text-gray-300"><strong>Periodo Escolar:</strong> {{ $group->school_period ?? 'No especificado' }}</p>
            <p class="text-gray-300"><strong>Tolerancia:</strong> {{ $group->tolerance ? 'Sí' : 'No' }}</p>
        </div>

        @if (Auth::user()->role == 'profesor' && $group->profesor_id == Auth::id())
            <h3 class="text-xl font-semibold text-white mt-6 mb-4">Alumnos en el Grupo</h3>
            <ul class="bg-gray-700 rounded-lg p-4 mb-4 space-y-2">
                @forelse($group->alumnos as $alumno)
                    <li class="flex items-center justify-between bg-gray-600 text-white p-2 rounded-md">
                        <span>{{ $alumno->name }}</span>
                        <form action="{{ route('groups.removeAlumno', [$group->id, $alumno->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a este alumno del grupo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Eliminar
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="bg-gray-600 text-white p-2 rounded-md">No hay alumnos en este grupo.</li>
                @endforelse
            </ul>

            <a href="{{ route('groups.addAlumnosForm', $group->id) }}" class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700">
                Agregar Alumnos
            </a>
        @endif
    </div>

    <a href="{{ route('groups.index') }}" class="inline-block mt-6 px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow hover:bg-gray-700">
        Volver a la Lista de Grupos
    </a>
</div>
@endsection




