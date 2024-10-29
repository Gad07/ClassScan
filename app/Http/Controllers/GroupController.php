<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == User::ROLE_PROFESOR) {
            $groups = Group::where('profesor_id', Auth::id())->get();
        } else {
            $groups = Auth::user()->groups;
        }

        return view('dashboard.groups.index', compact('groups'));
    }

    public function create()
    {
        if (Auth::user()->role != User::ROLE_PROFESOR) {
            return redirect()->route('groups.index');
        }
        $schools = School::all();

        return view('dashboard.groups.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'nullable|exists:schools,id',
            'new_school_name' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'class_days' => 'nullable|string|max:255',
            'class_schedule' => 'nullable|string|max:255',
            'school_period' => 'nullable|string|max:255',
            'tolerance' => 'nullable|boolean'
        ]);

        if (Auth::user()->role == User::ROLE_PROFESOR) {
            $schoolId = $request->school_id;

            if ($request->filled('new_school_name')) {
                $school = School::create(['name' => $request->new_school_name]);
                $schoolId = $school->id;
            }

            Group::create([
                'name' => $request->name,
                'profesor_id' => Auth::id(),
                'school_id' => $schoolId,
                'subject' => $request->subject,
                'class_days' => $request->class_days,
                'class_schedule' => $request->class_schedule,
                'school_period' => $request->school_period,
                'tolerance' => $request->tolerance ?? false
            ]);
        }

        return redirect()->route('groups.index');
    }

    public function edit($id)
    {
        $group = Group::findOrFail($id);
    
        if (Auth::user()->role != User::ROLE_PROFESOR || $group->profesor_id != Auth::id()) {
            return redirect()->route('groups.index');
        }
    
        $schools = School::all();
    
        return view('dashboard.groups.edit', compact('group', 'schools'));
    }
    

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if (Auth::user()->role != User::ROLE_PROFESOR || $group->profesor_id != Auth::id()) {
            return redirect()->route('groups.index');
        }

        $request->merge([
            'tolerance' => $request->has('tolerance') ? true : false
        ]);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'nullable|exists:schools,id',
            'new_school_name' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'class_days' => 'nullable|string|max:255',
            'class_schedule' => 'nullable|string|max:255',
            'school_period' => 'nullable|string|max:255',
            'tolerance' => 'boolean'
        ]);

        $schoolId = $request->school_id;

        if ($request->filled('new_school_name')) {
            $school = School::create(['name' => $request->new_school_name]);
            $schoolId = $school->id;
        }

        Group::create([
            'name' => $request->name,
            'profesor_id' => Auth::id(),
            'school_id' => $schoolId,
            'subject' => $request->subject,
            'class_days' => $request->class_days,
            'class_schedule' => $request->class_schedule,
            'school_period' => $request->school_period,
            'tolerance' => $request->tolerance ?? false
        ]);

        return redirect()->route('groups.index')->with('success', 'Grupo actualizado correctamente');
    }



    public function destroy($id)
    {
        $group = Group::findOrFail($id);
    
        if (Auth::user()->role != User::ROLE_PROFESOR || $group->profesor_id != Auth::id()) {
            return redirect()->route('groups.index');
        }
    
        // Elimina el grupo
        $group->delete();
    
        return redirect()->route('groups.index')->with('success', 'Grupo eliminado correctamente');
    }

    public function show($id)
    {
        $group = Group::with('school')->findOrFail($id);
    
        if (Auth::user()->role != User::ROLE_PROFESOR && !$group->alumnos->contains(Auth::user())) {
            return redirect()->route('groups.index');
        }
        return view('dashboard.groups.show', compact('group'));
    }

    public function addAlumnosForm(Request $request, $id)
    {
        // Encuentra el grupo
        $group = Group::findOrFail($id);

        if (Auth::user()->role != User::ROLE_PROFESOR || $group->profesor_id != Auth::id()) {
            return redirect()->route('groups.index');
        }


        $search = $request->input('search');

        $alumnos = User::where('role', User::ROLE_ALUMNO)
                    ->when($search, function ($query, $search) {
                        return $query->where('email', 'like', '%' . $search . '%');
                    })
                    ->get();

        return view('dashboard.groups.add-alumnos', compact('group', 'alumnos', 'search'));
    }

    public function addAlumnos(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if (Auth::user()->role != User::ROLE_PROFESOR || $group->profesor_id != Auth::id()) {
            return redirect()->route('groups.index');
        }
        $request->validate([
            'alumnos' => 'required|array',
            'alumnos.*' => 'exists:users,id',
        ]);

        $group->alumnos()->syncWithoutDetaching($request->alumnos);

        return redirect()->route('groups.show', $group->id)->with('success', 'Alumnos añadidos correctamente');
    }


    public function indexAlumno()
    {
        $user = Auth::user();
    
        $groups = Group::whereHas('alumnos', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('school', 'profesor')->get();
        
    
        return view('dashboard.alumno.index', compact('groups'));
    }

    public function importAlumnosPhpSpreadsheet(Request $request, Group $group)
    {
        if (Auth::user()->role != User::ROLE_PROFESOR || $group->profesor_id != Auth::id()) {
            return redirect()->route('groups.index');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);


        $filePath = $request->file('file')->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getRowIterator(2) as $row) { 
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }

            if (isset($data[1]) && filter_var($data[1], FILTER_VALIDATE_EMAIL)) {
                $alumno = User::firstOrCreate(
                    ['email' => $data[1]], 
                    [
                        'name' => $data[0],   
                        'role' => User::ROLE_ALUMNO,
                        'password' => bcrypt('defaultpassword'), 
                    ]
                );

                $group->alumnos()->syncWithoutDetaching($alumno->id);
            }
        }

        return redirect()->route('groups.show', $group->id)->with('success', 'Alumnos importados correctamente');
    }

    public function removeAlumno(Group $group, User $alumno)
    {
        if (Auth::user()->role != User::ROLE_PROFESOR || $group->profesor_id != Auth::id()) {
            return redirect()->route('groups.index');
        }
        $group->alumnos()->detach($alumno->id);

        return redirect()->route('groups.show', $group->id)->with('success', 'Alumno eliminado del grupo correctamente.');
    }

    

    // Añadir alumnos a un grupo (solo profesor)
    // public function addAlumnos(Request $request, $groupId)
    // {
    //     $group = Group::findOrFail($groupId);

    //     if (Auth::user()->role == User::ROLE_PROFESOR && $group->profesor_id === Auth::id()) {
    //         $alumnosIds = $request->input('alumnos', []);

    //         // Asegúrate de que solo se añaden usuarios de tipo "alumno"
    //         $validAlumnos = User::whereIn('id', $alumnosIds)->where('role', User::ROLE_ALUMNO)->pluck('id');
    //         $group->alumnos()->sync($validAlumnos);
    //     }

    //     // Cambiar redirección a la ruta correcta
    //     return redirect()->route('groups.index');
    // }
}
