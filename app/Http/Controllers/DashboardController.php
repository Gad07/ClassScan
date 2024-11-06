<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Justificante;
use App\Models\User;
use App\Models\Group; // IMPORTAR EL MODELO GROUP
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Comprobar el rol del usuario y redirigir al dashboard correspondiente
        if ($user->isProfesor()) {
            return $this->profesorDashboard();
        } elseif ($user->isAlumno()) {
            return $this->alumnoDashboard();
        } else {
            return redirect('/')->with('error', 'No tiene permisos para acceder al dashboard.');
        }
    }

    public function profesorDashboard()
    {
        // Obtener los alumnos con más faltas (agrupando por usuario)
        $alumnosEnRiesgo = Attendance::select('user_id')
            ->where('status', 'falta')
            ->groupBy('user_id')
            ->orderByRaw('COUNT(*) DESC')
            ->with('user')
            ->take(5) // Opcional: Limitar a los 5 alumnos con más faltas
            ->get()
            ->map(function ($attendance) {
                $attendance->faltas = Attendance::where('user_id', $attendance->user_id)
                    ->where('status', 'falta')
                    ->count();
                return $attendance;
            });

        // Obtener los justificantes pendientes
        $justificantes = Justificante::where('estado', 'pendiente')->with('alumno')->get();

        // Pasar los datos a la vista del dashboard del profesor
        return view('dashboard-profesor', [
            'alumnosEnRiesgo' => $alumnosEnRiesgo,
            'justificantes' => $justificantes
        ]);
    }

    public function alumnoDashboard()
    {
        // Obtener el alumno autenticado
        $user = Auth::user();

        // Obtener los grupos a los que pertenece el alumno
        $grupos = $user->groups;

        // Obtener las asistencias del alumno, incluyendo el grupo y el justificante
        $asistencias = Attendance::where('user_id', $user->id)
            ->with(['group', 'justificante'])
            ->orderBy('date', 'desc')
            ->get();

        // Crear una colección para los días de clase
        $clasesPorDia = collect();

        // Obtener los días de clase del mes actual para cada grupo del alumno
        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentYear = $currentDate->year;
        $daysInMonth = $currentDate->daysInMonth;

        foreach ($grupos as $grupo) {
            // Obtener los días de clase (ej: "lunes, miércoles, viernes")
            $classDays = explode(',', $grupo->class_days);
            $classDays = array_map('trim', $classDays);
            $classDays = array_map('strtolower', $classDays); // Convertir a minúsculas para comparación

            // Obtener el horario de clase
            $classScheduleParts = explode(' - ', $grupo->class_schedule); // Separar la hora de inicio y la hora de fin

            $horario = [
                'inicio' => $classScheduleParts[0] ?? 'N/A',
                'fin' => $classScheduleParts[1] ?? 'N/A'
            ];

            // Iterar sobre todos los días del mes para identificar los días de clases
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($currentYear, $currentMonth, $day);
                $dayNameSpanish = strtolower($date->locale('es')->isoFormat('dddd'));

                // Si el día actual coincide con un día de clase del grupo
                if (in_array($dayNameSpanish, $classDays)) {
                    $clasesPorDia->push([
                        'date' => $date->toDateString(),
                        'group_name' => $grupo->name,
                        'horario' => $horario
                    ]);
                }
            }
        }

        // Agrupar las clases por fecha
        $clasesPorDia = $clasesPorDia->groupBy('date');

        // Pasar los datos a la vista
        return view('dashboard-alumno', [
            'user' => $user,
            'clasesPorDia' => $clasesPorDia,
            'asistencias' => $asistencias,
        ]);
    }
}
