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
           class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 transition-transform lg:translate-x-0">

        <div class="h-16 flex items-center px-6">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-extrabold tracking-tight text-white">
                symbioz<span class="text-accent">.</span>
            </a>
        </div>

        {{-- Utilisateur connecté --}}
        <div class="mx-4 mb-6 flex items-center gap-3 rounded-xl bg-slate-800 px-4 py-3">
            <div class="w-9 h-9 rounded-full bg-admin flex items-center justify-center text-white text-xs font-bold">
                {{ Str::substr(auth()->user()?->name ?? '?', 0, 2) }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()?->name }}</p>
                <p class="text-xs text-slate-400">Gérant SYMBIOZ</p>
            </div>
        </div>

        <nav class="px-4 space-y-1">
            <p class="px-4 pb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">Pilotage</p>

            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                Tableau de bord
            </a>

            @foreach ([
                'admin.requests.index' => 'Demandes',
                'admin.clients.index'  => 'Clients',
                'admin.projects.index' => 'Chantiers',
                'admin.archives.index' => 'Archives',
            ] as $route => $label)
                @if (Route::has($route))
                    <a href="{{ route($route) }}"
                       class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs(Str::before($route, '.index') . '.*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        {{ $label }}
                    </a>
                @else
                    <span class="block px-4 py-2.5 rounded-lg text-sm font-medium text-slate-600 cursor-not-allowed">
                        {{ $label }}
                    </span>
                @endif
            @endforeach

            <p class="px-4 pt-6 pb-2 text-xs font-semibold uppercase tracking-widest text-slate-500">Compte</p>

            @if (Route::has('profile.edit'))
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('profile.*') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    Paramètres
                </a>
            @endif

            <div class="pt-4 mt-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:bg-slate-800 transition">
                        Déconnexion
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    {{-- ===== OVERLAY MOBILE ===== --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-gray-900/40 lg:hidden"></div>

    {{-- ===== CONTENU ===== --}}
    <div class="lg:pl-64">
<header class="h-16 bg-white border-b border-gray-200 flex items-center px-4 sm:px-6">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 -ml-2 text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <span class="text-xl font-extrabold tracking-tight ml-2 lg:ml-0">symbioz<span class="text-accent">.</span></span>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
