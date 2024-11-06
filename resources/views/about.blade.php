<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Nuestra Empresa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-3g9smkdcKChJ7B50hKd1xAO9zTA5lA9bu1ynf00CspJS+FJAd7E6CyBk3r9Vfz6n" crossorigin="anonymous">

    <!-- AdminKit CSS (Local) -->
    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc; /* Background similar to AdminKit */
        }
        .background-section {
            padding: 100px 0;
            color: #333;
            text-align: center;
            background-color: #f9f9f9;
        }
        .about-section, .services-section, .stories-section {
            padding: 60px 0;
        }
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
            background: #ffffff;
            padding: 20px;
        }
        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
        .navbar-custom {
            background-color: #343a40; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .navbar-custom .navbar-brand {
            font-weight: bold;
            color: #ffffff !important;
        }
        .btn-read-more {
            background-color: #0d6efd; /* AdminKit theme blue */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .btn-read-more:hover {
            background-color: #084298; /* Darker blue for hover effect */
        }
    </style>
</head>
<body>
    <!-- Navbar with Company Logo and Dashboard Button -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-5">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/Recurso.png') }}" alt="Logo Empresa" class="me-2" style="width: 100px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="{{ url('/dashboard') }}">
                            <i class="bi bi-house-door-fill me-1"></i> Menú Principal
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-4 text-primary">Acerca de Nosotros</h1>
                    <p class="lead">En nuestra empresa de software, nos apasiona la creación de soluciones tecnológicas innovadoras y de alta calidad. Creemos en la tecnología como el motor para el cambio positivo y ayudamos a nuestros clientes a alcanzar sus objetivos.</p>
                    <p>Estamos comprometidos con la excelencia y la innovación, trabajando estrechamente con nuestros clientes para entender sus necesidades y ofrecer soluciones que realmente marquen la diferencia en sus negocios.</p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f" alt="Nosotros" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section bg-light">
        <div class="container">
            <h1 class="mb-4 text-center text-primary">Nuestros Servicios</h1>
            <p class="lead text-center">Proporcionamos soluciones a medida, desarrollo de aplicaciones, consultoría en transformación digital y diseño de experiencia de usuario.</p>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card card-custom p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-laptop" style="font-size: 2.5rem; color: #0d6efd;"></i>
                        </div>
                        <h3>Desarrollo Web</h3>
                        <p>Creación de aplicaciones web responsivas y eficientes para su negocio.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-phone" style="font-size: 2.5rem; color: #0d6efd;"></i>
                        </div>
                        <h3>Aplicaciones Móviles</h3>
                        <p>Soluciones móviles para Android e iOS, adaptadas a sus necesidades.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 text-center">
                        <div class="mb-3">
                            <i class="bi bi-bar-chart" style="font-size: 2.5rem; color: #0d6efd;"></i>
                        </div>
                        <h3>Consultoría Digital</h3>
                        <p>Asesoramiento para mejorar la presencia digital y optimizar procesos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stories Section -->
    <section class="background-section stories-section bg-white">
        <div class="container text-dark stories-content">
            <h1 class="mb-4 text-primary">Historias y Testimonios</h1>
            <p class="lead">Escuche las historias de transformación de nuestros clientes y el impacto positivo de nuestras soluciones.</p>
            <div class="row justify-content-center mt-5">
                <div class="col-md-5 col-lg-4 mb-4 d-flex align-items-stretch">
                    <div class="card card-custom w-100">
                        <h4 class="mb-3 text-primary">Caso de Éxito: Transformación Digital en PyME</h4>
                        <p>Ayudamos a una pequeña empresa a modernizar sus sistemas y aumentar su productividad en un 40%.</p>
                        <button class="btn-read-more">Leer más</button>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4 mb-4 d-flex align-items-stretch">
                    <div class="card card-custom w-100">
                        <h4 class="mb-3 text-primary">Caso de Éxito: Plataforma Móvil</h4>
                        <p>Desarrollamos una aplicación móvil que mejoró la experiencia del cliente de un negocio local.</p>
                        <button class="btn-read-more">Leer más</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="container mt-5 mb-5">
        <div class="text-center mb-4">
            <h1 class="text-primary">Blog y Noticias</h1>
            <p>Descubre las últimas tendencias tecnológicas y noticias sobre nuestros proyectos recientes.</p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-custom">
                    <img src="https://bananotecnia.com/wp-content/uploads/2020/04/procesosiq_empresa_de_software.jpg" class="card-img-top" alt="Noticia 1">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Tendencias de Software 2024</h5>
                        <p class="card-text">Exploramos las últimas tendencias que están marcando el desarrollo de software en este año.</p>
                        <button class="btn-read-more">Leer más</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <img src="https://www.ecommercenews.pe/wp-content/uploads/2022/06/Transformacion-digital-Automatizacion-de-procesos-un-aumento-en-la-productividad-1-1280x720.jpg" class="card-img-top" alt="Noticia 2">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Automatización y Transformación</h5>
                        <p class="card-text">Cómo la automatización está ayudando a las empresas a reducir costos y mejorar la eficiencia.</p>
                        <button class="btn-read-more">Leer más</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <img src="https://digisap.com/wp-content/uploads/2020/10/Estrategias-digisap1-min.jpg" class="card-img-top" alt="Noticia 3">
                    <div class="card-body">
                        <h5 class="card-title text-primary">La Importancia de UX/UI</h5>
                        <p class="card-text">Por qué el diseño centrado en el usuario es crucial para el éxito de cualquier aplicación digital.</p>
                        <button class="btn-read-more">Leer más</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center p-3 mt-5">
        <p>© 2024 Hash. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ppY1MJxrHChx1YWObpRFOB5tu6FopO1wsyucog/7m5SbPbcg9kVtftT7n2B5r5z3" crossorigin="anonymous"></script>
</body>
</html>
