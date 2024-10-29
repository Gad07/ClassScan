<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\GroupController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-groups', function () {
    $user = Auth::user();

    // Asegúrate de que el usuario esté autenticado
    if ($user) {
        // Prueba la relación
        $groups = $user->groups;
        return $groups; // Esto debería devolver una colección de grupos si funciona correctamente
    }

    return 'Usuario no autenticado.';
});

// Route::get('/test-middleware', function () {
//     return 'Middleware CheckRole funciona correctamente';
// })->middleware([CheckRole::class . ':profesor']);

// Rutas específicas para profesores
Route::middleware(['auth', CheckRole::class . ':profesor'])->group(function () {
    Route::get('/dashboard-profesor', [ProfesorController::class, 'index'])->name('profesor.dashboard');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::get('/groups/{group}/add-alumnos', [GroupController::class, 'addAlumnosForm'])->name('groups.addAlumnosForm');
    Route::delete('/groups/{group}/remove-alumno/{alumno}', [GroupController::class, 'removeAlumno'])->name('groups.removeAlumno');


    // Ruta para guardar los alumnos añadidos al grupo
    Route::post('/groups/{group}/add-alumnos', [GroupController::class, 'addAlumnos'])->name('groups.addAlumnos');
    Route::post('/groups/{group}/import-alumnos-phpspreadsheet', [GroupController::class, 'importAlumnosPhpSpreadsheet'])->name('groups.importAlumnosPhpSpreadsheet');
});

// Gestión de grupos (profesor y alumno)
Route::middleware(['auth'])->group(function () {
    // Listado de grupos (profesor y alumno)
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
});

// Rutas específicas para alumnos
Route::middleware(['auth', CheckRole::class . ':alumno'])->group(function () {
    Route::get('/mis-grupos', [GroupController::class, 'indexAlumno'])->name('groups.indexAlumno');
    Route::get('/dashboard-alumno', [AlumnoController::class, 'index'])->name('alumno.dashboard');
    // Más rutas para alumnos
});

// Gestión de grupos
// Route::middleware(['auth'])->group(function () {
//     // Listado de grupos (profesor y alumno)
//     Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');

//     // Solo los profesores pueden crear y gestionar grupos
//     Route::middleware(['role:profesor'])->group(function () {
//         Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
//         Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
//         Route::post('/groups/{group}/add-alumnos', [GroupController::class, 'addAlumnos'])->name('groups.addAlumnos');
//     });
// });

require __DIR__.'/auth.php';
