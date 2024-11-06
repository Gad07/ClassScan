@php
    if (Auth::user()->role == 'profesor' && $group->profesor_id == Auth::id()) {
        $layout = 'layouts/app';
    } elseif (Auth::user()->role == 'alumno') {
        $layout = 'layouts/appStudent';
    } 
@endphp

@extends($layout)


@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-primary">Información del Grupo</h1>
   
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <h2 class="card-title mb-0 text-white"><i class="fas fa-users me-2"></i>{{ $group->name }}</h2>
        </div>
        <div class="card-body bg-light">
            <div class="row g-3">
                <!-- Información del Grupo -->
                <div class="col-md-6">
                    <p class="text-muted"><strong>Escuela:</strong> {{ $group->school->name ?? 'No asignada' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted"><strong>Profesor:</strong> {{ $group->profesor->name ?? 'Sin profesor' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted"><strong>Materia:</strong> {{ $group->subject->name ?? 'No especificada' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted"><strong>Días de Clases:</strong> {{ $group->class_days ?? 'No especificado' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted"><strong>Horario de Clases:</strong> {{ $group->class_schedule ?? 'No especificado' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted"><strong>Periodo Escolar:</strong> {{ $group->school_period ?? 'No especificado' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="text-muted"><strong>Tolerancia:</strong> {{ $group->tolerance ? 'Sí' : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Exportación de asistencia -->
    @if (Auth::user()->role == 'profesor' && $group->profesor_id == Auth::id())
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="card-title mb-0">Exportar Historial de Asistencias</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('groups.exportAttendanceHistory', $group->id) }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="startDateSelect" class="form-label">Fecha de Inicio:</label>
                        <select id="startDateSelect" name="start_date" class="form-select" required>
                            @foreach($dates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="endDateSelect" class="form-label">Fecha de Fin:</label>
                        <select id="endDateSelect" name="end_date" class="form-select" required>
                            @foreach($dates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-outline-success">Exportar Historial</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Gráfica de Resumen de Asistencias -->
    @if (Auth::user()->role == 'profesor' && $group->profesor_id == Auth::id())
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-secondary text-white d-flex align-items-center">
            <h3 class="card-title mb-0 text-white"><i class="fas fa-chart-bar me-2"></i>Resumen de Asistencias</h3>
        </div>
        <div class="card-body" style="height: 450px;">
            <div class="mb-3">
                <label for="dateSelect" class="form-label">Selecciona la fecha de la sesión:</label>
                <form method="GET" action="{{ route('groups.show', $group->id) }}">
                    <select id="dateSelect" name="selected_date" class="form-select" onchange="updateChartData()">
                        @foreach($dates as $date)
                            <option value="{{ $date }}" {{ request('selected_date') == $date ? 'selected' : '' }}>{{ $date }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="chart-container" style="position: relative; height: 350px;">
                <canvas id="attendanceChart"></canvas>
            </div>
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Alumno</th>
                            <th>Estado de Asistencia</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        <!-- Filas de asistencia se generarán dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif




    <!-- Lista de Alumnos y Opción para Agregar Alumnos -->
    @if (Auth::user()->role == 'profesor' && $group->profesor_id == Auth::id())
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-secondary text-white d-flex align-items-center">
                <h3 class="card-title mb-0 text-white"><i class="fas fa-user-graduate me-2"></i>Alumnos en el Grupo</h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($group->alumnos as $alumno)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('groups.showStudent', [$group->id, $alumno->id]) }}" class="text-dark fw-bold text-decoration-none">{{ $alumno->name }}</a>
                            <form action="{{ route('groups.removeAlumno', [$group->id, $alumno->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a este alumno del grupo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No hay alumnos en este grupo.</li>
                    @endforelse
                </ul>
                <a href="{{ route('groups.addAlumnosForm', $group->id) }}" class="btn btn-primary mt-3">
                    Agregar Alumnos
                </a>
            </div>
        </div>
    @endif

    <!-- Código QR restaurado y funcional -->
    @if(Auth::user()->role == 'profesor')
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-info text-white d-flex align-items-center">
                <h3 class="card-title mb-0 text-white"><i class="fas fa-qrcode me-2"></i>Pase de Lista con Código QR</h3>
            </div>
            <div class="card-body">
                <p class="text-muted"></p>
                <button id="generate-qr" class="btn btn-success mb-3">
                    Generar Código QR
                </button>
                <div id="qr-container" class="text-center" style="display: none;">
                    <img id="qr-image" src="" alt="Código QR para Pase de Lista" class="img-fluid mb-3">
                    <p class="text-muted">Expira en: <span id="qr-expiration" class="fw-bold"></span></p>
                </div>
            </div>
        </div>
    @endif

    @if(Auth::user()->role == 'profesor' && $group->profesor_id == Auth::id())
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('groups.manualAttendance', $group->id) }}" class="btn btn-warning" id="manual-attendance" style="display: none;">
                Pase de Lista Manual
            </a>
        </div>
    @endif

    @if (Auth::user()->role == 'alumno')
        <a href="{{ route('alumno.show', $group->id) }}" class="btn btn-info mb-3">
            Ver Mi Información
        </a>
    @endif

    @if(Auth::user()->role == 'profesor' && $group->profesor_id == Auth::id())
        <a href="{{ route('groups.index') }}" class="btn btn-danger">
            Volver a la Lista de Grupos
        </a>
    @endif
</div>

<!-- Script para Chart.js y QR Management -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container') || createToastContainer();
            const toast = document.createElement('div');
            toast.className = `toast alert alert-${type} fade show`;
            toast.innerHTML = `${message}`;
            toast.style.position = 'relative';
            toast.style.marginBottom = '10px';
            toast.style.padding = '15px';
            toast.style.borderRadius = '5px';
            toast.style.minWidth = '200px';

            if (type === 'success') {
                toast.style.backgroundColor = '#4caf50';
                toast.style.color = '#fff';
            } else if (type === 'danger') {
                toast.style.backgroundColor = '#f44336';
                toast.style.color = '#fff';
            }

            toastContainer.appendChild(toast);

            setTimeout(() => {
                if (toast.parentElement) {
                    toastContainer.removeChild(toast);
                }
            }, 5000);
        }

        function createToastContainer() {
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.style.position = 'fixed';
                toastContainer.style.top = '20px';
                toastContainer.style.right = '20px';
                toastContainer.style.zIndex = '9999';
                document.body.appendChild(toastContainer);
            }
            return toastContainer;
        }

        const startTime = "{{ explode(' - ', $group->class_schedule)[0] }}";
        const endTime = "{{ explode(' - ', $group->class_schedule)[1] }}";
        const classDays = "{{ $group->class_days }}".split(',');

        function isWithinClassTime() {
            const now = new Date();
            const dayNames = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
            const today = dayNames[now.getDay()];
            const currentTime = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

            return classDays.includes(today) && currentTime >= startTime && currentTime <= endTime;
        }

        const qrContainer = document.getElementById('qr-container');
        const generateQrButton = document.getElementById('generate-qr');
        const qrImage = document.getElementById('qr-image');
        const expirationElement = document.getElementById('qr-expiration');
        const manualAttendanceButton = document.getElementById('manual-attendance');

        // Verificar si hay un QR almacenado al cargar la página
        const groupId = "{{ $group->id }}";
        const storedQrCode = localStorage.getItem(`qrCode-${groupId}`);
        const storedExpiration = localStorage.getItem(`expiration-${groupId}`);
        const qrGenerated = localStorage.getItem(`qrGenerated-${groupId}`);

        if (qrGenerated === 'true' || (storedQrCode && storedExpiration)) {
            const nowTimestamp = Math.floor(Date.now() / 1000);
            if (storedExpiration > nowTimestamp && isWithinClassTime()) {
                showStoredQrCode(storedQrCode, storedExpiration);
            } else {
                // Limpiar el almacenamiento si el QR expiró o no estamos en el horario de clases
                localStorage.removeItem(`qrCode-${groupId}`);
                localStorage.removeItem(`expiration-${groupId}`);
                localStorage.setItem(`qrGenerated-${groupId}`, 'true');
                generateQrButton.style.display = 'none';
                manualAttendanceButton.style.display = 'block';
                markAllAbsentOnce();
            }
        }

        function showStoredQrCode(qrCode, expirationTimestamp) {
            qrContainer.style.display = 'block';
            qrImage.src = `data:image/svg+xml;base64,${qrCode}`;
            generateQrButton.style.display = 'none';
            manualAttendanceButton.style.display = 'none';

            const countdownInterval = setInterval(() => {
                const now = Math.floor(Date.now() / 1000);
                const timeLeft = expirationTimestamp - now;

                if (timeLeft > 0) {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    expirationElement.textContent = `${minutes}m ${seconds}s`;
                } else {
                    expirationElement.textContent = 'Expirado';
                    clearInterval(countdownInterval);
                    generateQrButton.style.display = 'none';
                    qrContainer.style.display = 'none';
                    manualAttendanceButton.style.display = 'block';
                    localStorage.removeItem(`qrCode-${groupId}`);
                    localStorage.removeItem(`expiration-${groupId}`);
                    localStorage.setItem(`qrGenerated-${groupId}`, 'true');
                    markAllAbsentOnce();
                }
            }, 1000);
        }

        function markAllAbsentOnce() {
            // Verificar si ya se marcó la asistencia una vez
            if (localStorage.getItem(`markedAbsent-${groupId}`) === 'true') {
                return;
            }

            // Realizar la petición para marcar a los ausentes
            fetch(`{{ route('groups.markAllAbsent', $group->id) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.setItem(`markedAbsent-${groupId}`, 'true'); // Marcar como realizada la acción
                    showToast('Asistencia actualizada: los ausentes han sido marcados.', 'success');
                } else {
                    showToast('Error al marcar a los ausentes: ' + data.error, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error al marcar a los ausentes.', 'danger');
            });
        }

        generateQrButton.addEventListener('click', function () {
            if (!isWithinClassTime()) {
                showToast('El código QR solo puede generarse durante el día y horario de clases.', 'danger');
                return;
            }

            if (localStorage.getItem(`qrGenerated-${groupId}`) === 'true') {
                showToast('El código QR ya fue generado para esta sesión de clase. Espere a la próxima sesión para generar uno nuevo.', 'danger');
                return;
            }

            fetch(`{{ route('groups.generateQr', $group->id) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.qrCode) {
                    localStorage.setItem(`qrCode-${groupId}`, data.qrCode);
                    localStorage.setItem(`expiration-${groupId}`, data.expiration);
                    localStorage.setItem(`qrGenerated-${groupId}`, 'true');
                    showStoredQrCode(data.qrCode, data.expiration);
                    showToast('Código QR generado exitosamente.', 'success');
                } else {
                    showToast('Error al generar el código QR.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error al generar el código QR:', error);
                showToast('Error al generar el código QR.', 'danger');
            });
        });

        function updateChartData() {
            const selectedDate = document.getElementById("dateSelect").value;
        
            fetch(`/groups/${groupId}/attendance-data?date=${selectedDate}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener los datos de asistencia');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    showToast('Error: ' + data.error, 'danger');
                    return;
                }
                renderChart(data);
                renderTable(data);
            })
            .catch(error => {
                console.error('Error al cargar los datos de asistencia:', error);
            });
        }

        function renderChart(data) {
            const ctx = document.getElementById("attendanceChart").getContext("2d");
            if (window.attendanceChart) {
                window.attendanceChart.destroy();
            }

            window.attendanceChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Asistencias",
                        data: data.attendance,
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function renderTable(data) {
            const tableBody = document.getElementById("attendanceTableBody");
            tableBody.innerHTML = "";
            data.attendanceDetails.forEach(detail => {
                const row = `<tr>
                                <td>${detail.alumno}</td>
                                <td>${detail.status}</td>
                             </tr>`;
                tableBody.innerHTML += row;
            });
        }

        updateChartData(); // Inicializar los datos de la gráfica y tabla
    });
</script>

@endsection