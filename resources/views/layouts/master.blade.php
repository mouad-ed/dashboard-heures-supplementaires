<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '⚡ Dashboard')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

 
</head>

<body>
<div class="db-app">

    {{-- Sidebar --}}
    <aside id="dbSidebar" class="db-sidebar">

        <div class="db-sidebar__brand">
            <div class="db-brand__mark">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <div class="db-brand__title">Education</div>
                <div class="db-brand__subtitle">Gestion Scolaire</div>
            </div>
        </div>

        <div class="db-sidebar__menu">
        @if(auth()->user()->role === 'admin')
            <a class="db-menu__item" href="{{ route('dashboard') }}">
                <span class="db-menu__icon"><i class="fas fa-chart-line"></i></span>
                <span class="db-menu__label">Dashboard</span>
            </a>
          @endif   

            <a class="db-menu__item" href="{{ route('eleves.index') }}">
                <span class="db-menu__icon"><i class="fas fa-user-graduate"></i></span>
                <span class="db-menu__label">Élèves</span>
            </a>

            <a class="db-menu__item" href="{{ route('enseignants.index') }}">
                <span class="db-menu__icon"><i class="fas fa-chalkboard-teacher"></i></span>
                <span class="db-menu__label">Enseignants</span>
            </a>

            <a class="db-menu__item" href="{{ route('seances.index') }}">
                <span class="db-menu__icon"><i class="fas fa-calendar"></i></span>
                <span class="db-menu__label">Séances</span>
            </a>

            <a class="db-menu__item" href="{{ route('heures.index') }}">
                <span class="db-menu__icon"><i class="fas fa-clock"></i></span>
                <span class="db-menu__label">Heures</span>
            </a>
           @if(auth()->user()->role === 'admin')
            <a class="db-menu__item" href="{{ route('salaires.index') }}">
                <span class="db-menu__icon"><i class="fas fa-dollar-sign"></i></span>
                <span class="db-menu__label">Salaires</span>
            </a>

          
                <a class="db-menu__item"  href="{{ route('admin.register') }}">
                    Ajouter utilisateur
                </a>
            @endif

            {{-- Logout FIXED --}}
            <div class="db-menu__item logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="db-link-btn" type="submit">
                        <i class="fas fa-right-from-bracket me-2"></i>
                        Logout
                    </button>
                </form>
            </div>

        </div>

    </aside>

    {{-- Main --}}
    <div class="db-main">

        {{-- Topbar --}}
        <header class="db-topbar">

            <button class="db-topbar__burger" type="button" data-db-sidebar-toggle>
                <i class="fas fa-bars"></i>
            </button>

            <div class="d-flex align-items-center justify-content-between w-100">

    {{-- TITLE --}}
    <div class="db-topbar__title">
        <i class="fas fa-school"></i>
        Gestion Scolaire
    </div>

    {{-- PROFILE --}}
    <div class="db-topbar__right">
        @auth
            <div class="db-profile">

                <div class="db-profile__avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="db-profile__meta">
                    <div class="db-profile__name">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="db-profile__role">
                        {{ ucfirst(auth()->user()->role) }}
                    </div>
                </div>

            </div>
        @endauth
    </div>

</div>
        </header>

        <main class="db-content">
            @yield('content')
        </main>

    </div>
</div>

{{-- Sidebar JS safe --}}
<script>
    const sidebar = document.getElementById('dbSidebar');
    const toggle = document.querySelector('[data-db-sidebar-toggle]');

    if (toggle) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('db-sidebar--open');
        });
    }
</script>

@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>