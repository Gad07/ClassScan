<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ url('/about') }}">
            <img src="{{ asset('images/logo_final.png') }}" class="img-fluid" alt="Descripción de la imagen">
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ url('/dashboard-profesor') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Menú principal</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ url('groups/create') }}">
                    <i class="align-middle" data-feather="plus-circle"></i> <span class="align-middle">Crear Grupos</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ url('/groups') }}">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Mis Grupos</span>
                </a>
            </li>
            <!-- Añade más elementos del menú aquí -->
        </ul>
    </div>
</nav>
