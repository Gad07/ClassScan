@extends('layouts.appStudent')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center mb-0">Editar Perfil</h2>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success text-center">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario para actualizar el perfil, incluyendo la foto -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="form-group mb-4 text-center">
                    <!-- Área circular para mostrar la foto de perfil -->
                    <div class="profile-image-container mt-3">
                        <img id="profileImagePreview" 
                             src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('https://cdn-icons-png.flaticon.com/512/6073/6073873.png') }}" 
                             alt="Foto de perfil" 
                             class="img-thumbnail rounded-circle"
                             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #ccc;">
                    </div>

                    <input type="file" name="photo" accept="image/png, image/jpeg, image/jpg" 
                           onchange="previewImage(event)" class="form-control mt-3">
                </div>

                <div class="form-group mb-4">
                    <label for="name" class="form-label font-weight-bold">Nombre</label>
                    <input type="text" name="name" class="form-control form-control-lg" value="{{ $user->name }}" required>
                </div>

                <div class="form-group mb-4">
                    <label for="email" class="form-label font-weight-bold">Correo electrónico</label>
                    <input type="email" name="email" class="form-control form-control-lg" value="{{ $user->email }}" readonly>
                </div>

                <div class="form-group mb-4">
                    <label for="current_password" class="form-label font-weight-bold">Contraseña Actual (solo si quieres cambiar la contraseña)</label>
                    <input type="password" name="current_password" class="form-control form-control-lg" placeholder="Ingresa tu contraseña actual si deseas cambiarla">
                </div>

                <div class="form-group mb-4">
                    <label for="new_password" class="form-label font-weight-bold">Nueva Contraseña</label>
                    <input type="password" name="new_password" class="form-control form-control-lg" placeholder="Ingresa la nueva contraseña">
                </div>

                <div class="form-group mb-4">
                    <label for="new_password_confirmation" class="form-label font-weight-bold">Confirmar Nueva Contraseña</label>
                    <input type="password" name="new_password_confirmation" class="form-control form-control-lg" placeholder="Confirma la nueva contraseña">
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Actualizar perfil
                    </button>
                </div>
            </form>

            <!-- Formulario para eliminar la foto de perfil -->
            @if ($user->photo)
                <form action="{{ route('profile.deletePhoto') }}" method="POST" class="d-flex justify-content-center mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-lg">
                        <i class="fas fa-trash-alt"></i> Eliminar foto de perfil
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mostrar toast en caso de error al cargar la imagen
        @if ($errors->has('photo'))
            showToast('{{ $errors->first('photo') }}', 'danger');
        @endif
    });

    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast alert alert-${type} fade show d-flex align-items-center`;
        toast.innerHTML = `
            <div class="toast-content">
                ${message}
            </div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        `;

        // Aplicar estilos al toast para mejorar la presentación
        toast.style.position = 'relative';
        toast.style.marginBottom = '10px';
        toast.style.padding = '15px';
        toast.style.borderRadius = '10px'; // Bordes más redondeados
        toast.style.minWidth = '300px'; // Incrementar el ancho mínimo
        toast.style.maxWidth = '500px'; // Incrementar el ancho máximo

        if (type === 'success') {
            toast.style.backgroundColor = '#007bff'; // Azul para alinearse con Bootstrap primary
            toast.style.color = '#fff';
        } else if (type === 'danger') {
            toast.style.backgroundColor = '#dc3545'; // Rojo de alerta para errores
            toast.style.color = '#fff';
        }

        // Añadir el toast al contenedor
        toastContainer.appendChild(toast);

        // Cerrar el toast después de 5 segundos automáticamente
        setTimeout(() => {
            if (toast.parentElement) {
                toastContainer.removeChild(toast);
            }
        }, 5000);
    }

    // Función para mostrar la vista previa de la imagen seleccionada
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profileImagePreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
