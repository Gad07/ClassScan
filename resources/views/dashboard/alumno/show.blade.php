@extends('dashboard.master')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-white mb-6">Información del Grupo</h1>

    <div class="bg-gray-800 rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-white mb-4">{{ $group->name }}</h2>

        <p class="text-gray-300 mb-2"><strong>Escuela:</strong> {{ $group->school ? $group->school->name : 'No asignada' }}</p>

        <p class="text-gray-300 mb-4"><strong>Profesor:</strong> {{ $group->profesor ? $group->profesor->name : 'Sin profesor' }}</p>
    </div>
    <a href="{{ route('alumno.index') }}" class="inline-block mt-6 px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow hover:bg-gray-700">
        Volver a la Lista de Grupos
    </a>
</div>
@endsection

