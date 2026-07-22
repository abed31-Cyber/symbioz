<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Back-office') — SYMBIOZ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false }">

    {{-- ===== SIDEBAR ===== --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transition-transform lg:translate-x-0">

        <div class="h-16 flex items-center px-6 border-b border-gray-200">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-extrabold tracking-tight">symbioz.</a>
        </div>

        <nav class="p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.dashboard') ? 'bg-brand-light text-brand-dark' : 'text-gray-600 hover:bg-gray-100' }}">
                Tableau de bord
            </a>

            @if (Route::has('admin.requests.index'))
                <a href="{{ route('admin.requests.index') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.requests.*') ? 'bg-brand-light text-brand-dark' : 'text-gray-600 hover:bg-gray-100' }}">
                    Demandes
                </a>
            @else
                <span class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-300 cursor-not-allowed">Demandes</span>
            @endif

            @if (Route::has('admin.clients.index'))
                <a href="{{ route('admin.clients.index') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.clients.*') ? 'bg-brand-light text-brand-dark' : 'text-gray-600 hover:bg-gray-100' }}">
                    Clients
                </a>
            @else
                <span class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-300 cursor-not-allowed">Clients</span>
            @endif

            @if (Route::has('admin.projects.index'))
                <a href="{{ route('admin.projects.index') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.projects.*') ? 'bg-brand-light text-brand-dark' : 'text-gray-600 hover:bg-gray-100' }}">
                    Chantiers
                </a>
            @else
                <span class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-300 cursor-not-allowed">Chantiers</span>
            @endif

            @if (Route::has('admin.archives.index'))
                <a href="{{ route('admin.archives.index') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.archives.*') ? 'bg-brand-light text-brand-dark' : 'text-gray-600 hover:bg-gray-100' }}">
                    Archives
                </a>
            @else
                <span class="block px-4 py-2.5 rounded-lg text-sm font-medium text-gray-300 cursor-not-allowed">Archives</span>
            @endif

            @if (Route::has('profile.edit'))
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('profile.*') ? 'bg-brand-light text-brand-dark' : 'text-gray-600 hover:bg-gray-100' }}">
                    Paramètres
                </a>
            @endif
        </nav>
    </aside>

    {{-- ===== OVERLAY MOBILE ===== --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-gray-900/40 lg:hidden"></div>

    {{-- ===== CONTENU ===== --}}
    <div class="lg:pl-64">

        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 -ml-2 text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="flex items-center gap-4 ml-auto">
                <span class="text-sm text-gray-600">{{ auth()->user()?->name }}</span>

                {{-- Déconnexion en POST : modifie l'état de session, protégée par CSRF --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-900">
                        Déconnexion
                    </button>
                </form>
            </div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
