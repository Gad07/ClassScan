<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <!-- Notificaciones -->
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                    <div class="position-relative">
                        <i class="align-middle" data-feather="bell"></i>
                        @if(isset($notifications) && $notifications->count() > 0)
                            <span class="indicator">{{ $notifications->count() }}</span>
                        @endif
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                    <div class="dropdown-menu-header">
                        @if(isset($notifications) && $notifications->count() > 0)
                            {{ $notifications->count() }} Nueva(s) Notificación(es)
                        @else
                            Sin Notificaciones
                        @endif
                    </div>
                    <div class="list-group">
                        @if(isset($notifications) && $notifications->count() > 0)
                            @foreach($notifications as $notification)
                                <a href="#" class="list-group-item">
                                    <div class="row g-0 align-items-center">
                                        <div class="col-2">
                                            <i class="text-primary" data-feather="alert-circle"></i>
                                        </div>
                                        <div class="col-10">
                                            <div class="text-dark">{{ $notification->message }}</div>
                                            <div class="text-muted small mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                    <div class="dropdown-menu-footer">
                        @if(isset($notifications) && $notifications->count() > 0)
                            <form action="{{ route('notifications.clear') }}" method="POST" class="m-0 p-2">
                                @csrf
                                <button type="submit" class="btn btn-link text-muted w-100 text-center">Limpiar Notificaciones</button>
                            </form>
                        @else
                            <a href="{{ route('notifications.index') }}" class="text-muted">Ver todas las notificaciones</a>
                        @endif
                    </div>
                </div>
            </li>

            <!-- Menú de Usuario -->
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://cdn-icons-png.flaticon.com/512/6073/6073873.png' }}" class="avatar img-fluid rounded-circle me-1" alt="Avatar"> 
                    <span class="text-dark">{{ Auth::user()->name ?? 'Nombre Usuario' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="/perfil-profesor"><i class="align-middle me-1" data-feather="user"></i> Perfil</a>
                    <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="droplet"></i> Paleta de Colores</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="log-out"></i> Cerrar Sesión</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
