<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProfileProfesorController extends Controller
{
    /**
     * Mostrar el formulario del perfil del profesor.
     */
    public function edit(Request $request): View
    {
        // Pasar la información del profesor autenticado a la vista
        return view('profile.edit_profesor', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualizar la información del perfil del profesor, incluyendo la foto de perfil.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validar los campos del perfil y la imagen de perfil
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // 10 MB max
        ], [
            'photo.image' => 'El archivo debe ser una imagen.',
            'photo.mimes' => 'Solo se permiten archivos de tipo jpg, jpeg o png.',
            'photo.max' => 'La imagen no debe exceder los 10 MB.',
        ]);

        try {
            // Manejar la subida de la foto de perfil
            if ($request->hasFile('photo')) {
                // Eliminar la foto anterior si existe
                if ($user->photo) {
                    Storage::delete('public/' . $user->photo);
                }

                // Guardar la nueva foto en la carpeta `photos`
                $path = $request->file('photo')->store('photos', 'public');
                $user->photo = $path;  // Guardar la ruta en el campo `photo`
            }

            // Guardar la información del perfil
            $user->fill($validatedData);

            // Si el email fue modificado, desverificarlo
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            // Redirigir al perfil del profesor con un mensaje de éxito
            return Redirect::route('profesor.profile.edit')->with('status', 'Perfil actualizado correctamente.');

        } catch (\Exception $e) {
            // Registrar el error y redirigir con un mensaje de error general
            Log::error('Error al actualizar el perfil: ' . $e->getMessage());
            return Redirect::route('profesor.profile.edit')->withErrors('Ocurrió un error al actualizar el perfil. Inténtalo de nuevo.');
        }
    }

    /**
     * Eliminar la foto de perfil del profesor.
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->photo) {
            try {
                // Eliminar la foto de perfil del almacenamiento
                Storage::delete('public/' . $user->photo);
                $user->photo = null;
                $user->save();
                return Redirect::route('profesor.profile.edit')->with('status', 'Foto de perfil eliminada correctamente.');
            } catch (\Exception $e) {
                Log::error('Error al eliminar la foto de perfil: ' . $e->getMessage());
                return Redirect::route('profesor.profile.edit')->withErrors('Ocurrió un error al eliminar la foto de perfil. Inténtalo de nuevo.');
            }
        }

        return Redirect::route('profesor.profile.edit')->with('status', 'No se encontró ninguna foto de perfil para eliminar.');
    }

    /**
     * Eliminar la cuenta del profesor.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        try {
            // Eliminar la foto de perfil si existe
            if ($user->photo) {
                Storage::delete('public/' . $user->photo);
            }

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/')->with('status', 'Cuenta eliminada correctamente');

        } catch (\Exception $e) {
            // Registrar el error y redirigir con un mensaje de error general
            Log::error('Error al eliminar la cuenta: ' . $e->getMessage());
            return Redirect::route('profesor.profile.edit')->withErrors('Ocurrió un error al eliminar la cuenta. Inténtalo de nuevo.');
        }
    }
}
