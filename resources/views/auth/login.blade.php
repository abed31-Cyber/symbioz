<x-guest-layout>
    <div class="text-center mb-6">
        <span class="text-2xl font-extrabold tracking-tight">symbioz<span class="text-accent">.</span></span>
        <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-gray-400">Espace pro</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-8">

        <h1 class="text-2xl font-extrabold text-center">Bonjour</h1>
        <p class="mt-2 text-sm text-gray-600 text-center">
            Accédez à vos demandes, votre planning et vos chantiers en cours.
        </p>

        {{-- Message générique : ne distingue pas email inconnu / mot de passe faux --}}
        <x-auth-session-status class="mt-4" :status="session('status')" />

        @if ($errors->any())
            <div class="mt-4 bg-red-50 border border-red-200 rounded-lg px-4 py-3">
                <p class="text-sm text-red-700">{{ $errors->first() }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">
                    Email professionnel
                </label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       placeholder="karim.b@symbioz.fr"
                       class="w-full px-3.5 py-3 border border-gray-300 rounded-lg text-sm
                              focus:border-admin focus:ring-1 focus:ring-admin outline-none">
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-gray-500">
                        Mot de passe
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-admin hover:underline">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>
                <input id="password" name="password" type="password"
                       required autocomplete="current-password"
                       placeholder="Votre mot de passe"
                       class="w-full px-3.5 py-3 border border-gray-300 rounded-lg text-sm
                              focus:border-admin focus:ring-1 focus:ring-admin outline-none">
            </div>

            <label class="flex items-center gap-2.5 text-sm text-gray-600">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded accent-admin">
                <span>Se souvenir de moi</span>
            </label>

            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-admin text-white
                           font-semibold rounded-xl hover:bg-admin-dark transition">
                Se connecter
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>

            <p class="flex items-center justify-center gap-1.5 text-xs text-gray-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 4-3 7-7 9-4-2-7-5-7-9V7l7-4z"/></svg>
                Connexion sécurisée
            </p>
        </form>
    </div>

    <p class="mt-6 text-center">
        <a href="{{ route('front.home') }}" class="text-sm text-gray-500 hover:text-gray-900">
            &larr; Retour au site public
        </a>
    </p>
</x-guest-layout>
