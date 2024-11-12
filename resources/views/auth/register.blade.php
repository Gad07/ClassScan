<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-3g9smkdcKChJ7B50hKd1xAO9zTA5lA9bu1ynf00CspJS+FJAd7E6CyBk3r9Vfz6n" crossorigin="anonymous">

    <!-- AdminKit CSS (Local) -->
    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">

    <!-- Custom CSS (Opcional) -->
    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden; /* Evita el desplazamiento horizontal */
        }
        .register-section {
            height: 100vh;
            overflow: hidden; /* Evita el desplazamiento no deseado */
        }
        .register-left {
            position: relative;
            height: 100%;
            overflow: hidden; /* Evita el scroll si la imagen se sale del contenedor */
        }
        .register-left::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('https://img.freepik.com/fotos-premium/codigo-qr-fondo-azul-renderizado-3d_975254-1118.jpg');
            background-size: cover; /* La imagen cubre toda la columna */
            background-position: center; /* Centra la imagen en la columna */
            filter: blur(8px); /* Aplica el desenfoque a la imagen */
            transform: scale(1.1); /* Aumenta el tamaño para asegurarse de que no queden bordes visibles después del blur */
        }
        .register-right {
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 4rem;
            height: 100%; /* Ajusta la altura para que sea igual a la altura de la columna */
            overflow: hidden; /* Evita el desplazamiento no deseado */
        }
        .register-logo {
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>

    <div class="container-fluid register-section">
        <div class="row h-100 gx-0"> <!-- Se añade gx-0 para eliminar cualquier espacio horizontal no deseado -->
            <!-- Left Side - Promotional Section -->
            <div class="col-md-7 register-left d-none d-md-block"></div>

            <!-- Right Side - Register Form -->
            <div class="col-md-5 d-flex align-items-center justify-content-center register-right">
                <div style="max-width: 400px; width: 100%;">
                    <div class="text-center register-logo">
                        <img src="{{ asset('images/Recurso.png') }}" alt="Logo" width="150">
                    </div>
                    <h2 class="text-center mb-4">Registro de Usuario</h2>

                    <!-- Registration Form -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- User Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Tipo de Usuario</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="alumno">Alumno</option>
                                <option value="profesor">Profesor</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>    

                        <!-- Accept Terms and Privacy Policy -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Acepto los <a href="{{ url('/terms') }}" class="text-decoration-none">términos y condiciones</a> y la <a href="{{ url('/terms') }}" class="text-decoration-none">política de privacidad</a>
                                </label>
                            </div>
                        </div>

                        <!-- Register Button and Login Link -->
                        <div class="d-flex items-center justify-content-between mt-4">
                            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">
                                ¿Tienes una cuenta?
                            </a>
                            <button type="submit" class="btn btn-outline-primary ms-4">
                                Registrarse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ppY1MJxrHChx1YWObpRFOB5tu6FopO1wsyucog/7m5SbPbcg9kVtftT7n2B5r5z3" crossorigin="anonymous"></script>

    <!-- AdminKit JS (Local) -->
    <script src="{{ asset('adminkit/js/app.js') }}"></script>

</body>
</html>
