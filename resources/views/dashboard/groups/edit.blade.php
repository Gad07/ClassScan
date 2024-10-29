@extends('dashboard.master')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-white mb-6">Editar Grupo</h1>

    <form action="{{ route('groups.update', $group->id) }}" method="POST" class="bg-gray-800 rounded-lg shadow-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-white font-semibold mb-2">Nombre del Grupo</label>
            <input type="text" class="w-full px-4 py-2 rounded-lg text-gray-900" id="name" name="name" value="{{ old('name', $group->name) }}" required>
        </div>

        <div class="mb-4">
            <label for="school_id" class="block text-white font-semibold mb-2">Escuela</label>
            <select id="school_id" name="school_id" class="w-full px-4 py-2 rounded-lg text-gray-900">
                <option value="">Selecciona una Escuela</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}" {{ old('school_id', $group->school_id) == $school->id ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>
            <a href="#" id="add-school-link" class="text-blue-400 hover:text-blue-600 mt-2 inline-block">Agregar Nueva Escuela</a>
        </div>

        <div class="mb-4" id="new-school-field" style="display: none;">
            <label for="new_school_name" class="block text-white font-semibold mb-2">Nombre de la Nueva Escuela</label>
            <input type="text" class="w-full px-4 py-2 rounded-lg text-gray-900" id="new_school_name" name="new_school_name" value="{{ old('new_school_name') }}">
        </div>

        <div class="mb-4">
            <label for="subject" class="block text-white font-semibold mb-2">Materia</label>
            <input type="text" class="w-full px-4 py-2 rounded-lg text-gray-900" id="subject" name="subject" value="{{ old('subject', $group->subject) }}" required>
        </div>

        <div class="mb-4">
            <label for="class_days" class="block text-white font-semibold mb-2">Días de Clases</label>
            <input type="text" class="w-full px-4 py-2 rounded-lg text-gray-900" id="class_days" name="class_days" value="{{ old('class_days', $group->class_days) }}" placeholder="Ej. Lunes, Miércoles, Viernes" required>
        </div>

        <div class="mb-4">
            <label for="class_schedule" class="block text-white font-semibold mb-2">Horario de Clases</label>
            <input type="text" class="w-full px-4 py-2 rounded-lg text-gray-900" id="class_schedule" name="class_schedule" value="{{ old('class_schedule', $group->class_schedule) }}" placeholder="Ej. 9:00 AM - 11:00 AM" required>
        </div>

        <div class="mb-4">
            <label for="school_period" class="block text-white font-semibold mb-2">Periodo Escolar</label>
            <input type="text" class="w-full px-4 py-2 rounded-lg text-gray-900" id="school_period" name="school_period" value="{{ old('school_period', $group->school_period) }}" placeholder="Ej. Enero - Junio 2024" required>
        </div>

        <div class="mb-4 flex items-center">
            <input type="checkbox" id="tolerance" name="tolerance" class="mr-2" {{ old('tolerance', $group->tolerance) ? 'checked' : '' }}>
            <label for="tolerance" class="text-white font-semibold">Tolerancia</label>
        </div>

        <div class="flex space-x-4 mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700">
                Actualizar Grupo
            </button>
            <a href="{{ route('groups.index') }}" class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow hover:bg-gray-700">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-school-link').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('new-school-field').style.display = 'block';
        document.getElementById('school_id').value = '';
    });
</script>
@endsection
