@extends('dashboard.master')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-white mb-6">Agregar Alumnos al Grupo: {{ $group->name }}</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white text-center py-2 px-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('groups.addAlumnosForm', $group->id) }}" class="flex mb-6">
        <input type="text" name="search" class="flex-1 px-4 py-2 rounded-l-lg focus:outline-none" placeholder="Buscar por correo electrónico" value="{{ request('search') }}">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-r-lg hover:bg-blue-700">
            Buscar
        </button>
    </form>

    <form action="{{ route('groups.importAlumnosPhpSpreadsheet', $group->id) }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 rounded-lg p-6 shadow-lg mb-6">
        @csrf
        <div class="mb-4">
            <label for="file" class="block text-white font-semibold mb-2">Cargar Archivo Excel</label>
            <input type="file" name="file" id="file" class="w-full px-4 py-2 rounded-lg text-gray-900 bg-white" required>
            <small class="text-gray-400">Asegúrate de que el archivo sea un formato válido (.xlsx, .xls).</small>
        </div>
    
        <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700">
            Importar Alumnos
        </button>
    </form>
    

    <form action="{{ route('groups.addAlumnos', $group->id) }}" method="POST" class="bg-gray-800 rounded-lg p-6 shadow-lg">
        @csrf

        <div class="mb-4">
            <label for="alumnos" class="block text-white font-semibold mb-2">Selecciona Alumnos para Agregar</label>
            <select name="alumnos[]" id="alumnos" class="w-full px-4 py-2 rounded-lg text-gray-900" multiple required>
                @foreach ($alumnos as $alumno)
                    <option value="{{ $alumno->id }}">{{ $alumno->name }} ({{ $alumno->email }})</option>
                @endforeach
            </select>
            <small class="text-gray-400">Mantén presionada la tecla Ctrl (Cmd en Mac) para seleccionar múltiples alumnos.</small>
        </div>

        <div class="flex space-x-4 mt-4">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700">
                Agregar Alumnos
            </button>
            <a href="{{ route('groups.show', $group->id) }}" class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow hover:bg-gray-700">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection


