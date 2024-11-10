@extends('layouts.app')

@section('title', 'Dashboard del Profesor')

@section('content')
<div class="container-fluid px-4">

    <!-- Bienvenida al Profesor -->
    <div class="card mb-4 shadow border-0">
        <div class="card-body text-black text-center py-5">
            <h2 class="mb-0 text-primary">Bienvenido, Profesor</h2>
            <p class="lead mt-3">Administre sus grupos y estudiantes con facilidad</p>
        </div>
    </div>

    <!-- Filas de Contenido -->
    <div class="row">
        <!-- Alumnos en Riesgo -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-primary text-dark text-center py-3">
                    <h2 class="card-title mb-0 text-white">Alumnos en Riesgo</h4>
                </div>
                <div class="card-body">
                    @if ($alumnosEnRiesgo->isEmpty())
                        <div class="alert alert-info text-center mb-0">
                            No hay alumnos en riesgo actualmente.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered">
                                <thead class="table-warning">
                                    <tr>
                                        <th>Nombre del Alumno</th>
                                        <th>Faltas</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alumnosEnRiesgo as $alumno)
                                    <tr>
                                        <td>{{ $alumno->name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6">{{ $alumno->faltas }}</span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-outline-info btn-sm">
                                                Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Justificantes Pendientes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h2 class="card-title mb-0 text-white">Justificantes Pendientes</h4>
                </div>
                <div class="card-body">
                    @if ($justificantes->isEmpty())
                        <div class="alert alert-info text-center mb-0">
                            No hay justificantes pendientes.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-bordered align-middle bg-white">
                                <thead class="table-white">
                                    <tr>
                                        <th>Alumno</th>
                                        <th>Fecha de Falta</th>
                                        <th>Archivo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($justificantes as $justificante)
                                    <tr>
                                        <td>{{ $justificante->alumno->name }}</td>
                                        <td>{{ $justificante->fecha }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $justificante->archivo) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                Ver PDF
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <form action="{{ route('justificantes.aceptar', $justificante->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success btn-sm">Aceptar</button>
                                                </form>
                                                <form action="{{ route('justificantes.rechazar', $justificante->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Rechazar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
