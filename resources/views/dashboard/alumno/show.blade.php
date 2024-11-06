@extends('layouts.appStudent')

@section('title', 'Información del Alumno')

@section('content')
<div class="container-fluid px-4">
    <div class="card mb-4 shadow border-0">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Información del Alumno</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="text-dark mb-3">{{ $alumno->name }}</h2>
                    <p class="text-muted"><strong>Email:</strong> {{ $alumno->email }}</p>
                    <p class="text-muted"><strong>Grupo:</strong> {{ $group->name }}</p>
                </div>
                <div class="col-md-6 text-center">
                    <h4 class="text-dark mb-4">Resumen de Asistencias</h4>
                    <canvas id="attendanceChart" width="400" height="200" class="shadow-lg rounded"></canvas>
                </div>
            </div>

            <!-- Tabla de Detalle de Asistencias -->
            <div class="table-responsive mb-4">
                <h3 class="text-dark mb-3">Detalle de Asistencias</h3>
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="bg-primary">
                        <tr>
                            <th scope="col" class="text-white">Fecha</th>
                            <th scope="col" class="text-white">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                                <td>
                                    @switch($attendance->status)
                                        @case('on_time')
                                            <span class="badge bg-success">Asistencia</span>
                                            @break
                                        @case('late_a')
                                            <span class="badge bg-warning text-dark">Retardo A</span>
                                            @break
                                        @case('late_b')
                                            <span class="badge bg-warning">Retardo B</span>
                                            @break
                                        @case('absent')
                                            <span class="badge bg-danger">Falta</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('groups.indexAlumno') }}" class="btn btn-danger">
                    <i class="fas fa-arrow-left"></i> Volver a la Lista de Grupos
                </a>
            </div>        
        </div>
    </div>
</div>

<!-- Incluir Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Asistencias', 'Faltas', 'Retardos A', 'Retardos B'],
            datasets: [{
                data: [{{ $attendanceCount }}, {{ $absentCount }}, {{ $lateACount }}, {{ $lateBCount }}],
                backgroundColor: ['#4CAF50', '#F44336', '#FFC107', '#FF9800'],
                hoverOffset: 4,
                borderColor: 'rgba(255, 255, 255, 0.2)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'black',
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
