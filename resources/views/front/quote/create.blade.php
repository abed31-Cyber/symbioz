@extends('layouts.public')

@section('title', 'Demander un devis — SYMBIOZ')

@section('content')
<section class="bg-gray-50 py-12 lg:py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Deux points soutenance :

has-[:checked] est un variant Tailwind moderne :
 la carte de service devient violette quand sa checkbox est cochée, sans JS.
 Élégant et accessible (la vraie checkbox reste le contrôle).
syncInput() en Alpine : le drag & drop ne remplit pas automatiquement l'<input type="file">.
Je reconstruis un DataTransfer pour que les fichiers droppés partent bien avec le formulaire.
C'est le genre de détail que le jury apprécie. --}}

        {{-- ===== EN-TÊTE ===== --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Parlez-nous de votre projet.</h1>
            <p class="mt-4 text-gray-600 max-w-xl mx-auto">
                Quelques informations sur votre besoin et nous vous rappelons sous 48h ouvrées
                pour préciser ensemble votre projet et vous transmettre un devis détaillé.
            </p>
        </div>

        {{-- ===== STEPPER ===== --}}
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-brand text-white text-xs font-bold flex items-center justify-center">1</span>
                <span class="text-sm font-bold">Vos infos</span>
            </div>
            <div class="w-12 h-px bg-gray-300 mx-3"></div>
            <div class="flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-gray-200 text-gray-400 text-xs font-bold flex items-center justify-center">2</span>
                <span class="text-sm font-semibold text-gray-400">Projet</span>
            </div>
            <div class="w-12 h-px bg-gray-300 mx-3"></div>
            <div class="flex items-center gap-2">
                <span class="w-7 h-7 rounded-full bg-gray-200 text-gray-400 text-xs font-bold flex items-center justify-center">3</span>
                <span class="text-sm font-semibold text-gray-400">Envoi</span>
            </div>
        </div>

        {{-- ===== BANDEAU RATE LIMIT ===== --}}
        <div class="flex items-center gap-3 bg-brand-light border border-brand/20 rounded-xl px-4 py-3 mb-6">
            <svg class="w-4 h-4 text-brand flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>
            <span class="text-sm text-brand-dark">Limite : 10 soumissions maximum par minute pour sécuriser le formulaire.</span>
        </div>

        {{-- ===== ERREURS GLOBALES ===== --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-6">
                <p class="text-sm font-semibold text-red-700 mb-1">Veuillez corriger les erreurs suivantes :</p>
                <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ===== FORMULAIRE ===== --}}
        <form action="{{ route('front.quote.store') }}" method="POST" enctype="multipart/form-data"
              x-data="quoteForm()" class="space-y-6">
            @csrf

            {{-- --- BLOC COORDONNÉES --- --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 rounded-lg bg-brand-light flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h2 class="text-lg font-bold">Vos coordonnées</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="first_name" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Prénom</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                               class="w-full px-3.5 py-3 border border-gray-300 rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                    <div>
                        <label for="last_name" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Nom / Raison sociale <span class="text-accent">*</span></label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                               class="w-full px-3.5 py-3 border @error('last_name') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Email <span class="text-accent">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-3.5 py-3 border @error('email') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Téléphone <span class="text-accent">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="0612345678"
                               class="w-full px-3.5 py-3 border @error('phone') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="address" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Adresse des travaux <span class="text-accent">*</span></label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" required
                               class="w-full px-3.5 py-3 border @error('address') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="city" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Ville <span class="text-accent">*</span></label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" required
                               class="w-full px-3.5 py-3 border @error('city') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                </div>
            </div>

            {{-- --- BLOC PROJET --- --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 rounded-lg bg-brand-light flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <h2 class="text-lg font-bold">Votre projet</h2>
                </div>

                {{-- Services (N-N) --}}
                <fieldset class="mb-6">
                    <legend class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">Type(s) de prestation <span class="text-accent">*</span></legend>
                    <p class="text-sm text-gray-400 mb-3">Sélectionnez au moins un service.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach ($services as $service)
                            <label class="flex items-center gap-3 px-4 py-3.5 rounded-xl border cursor-pointer transition
                                          has-[:checked]:border-brand has-[:checked]:bg-brand-light border-gray-200">
                                <input type="checkbox" name="service_ids[]" value="{{ $service->id }}"
                                       {{ in_array($service->id, old('service_ids', [])) ? 'checked' : '' }}
                                       class="w-5 h-5 rounded accent-brand">
                                <span class="text-sm font-medium">{{ $service->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('service_ids')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </fieldset>

                {{-- Description --}}
                <div class="mb-6">
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Description détaillée <span class="text-accent">*</span></label>
                    <textarea id="description" name="description" rows="5" required
                              placeholder="Surface, matériaux souhaités, contraintes spécifiques, délai…"
                              class="w-full px-3.5 py-3 border @error('description') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none resize-y">{{ old('description') }}</textarea>
                </div>

                {{-- Upload photos --}}
                <div class="mb-6">
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">
                        Ajouter des photos <span class="normal-case tracking-normal text-gray-400 font-medium">(optionnel)</span>
                    </label>
                    <div @click="$refs.fileInput.click()"
                         @dragover.prevent="dragging = true"
                         @dragleave.prevent="dragging = false"
                         @drop.prevent="handleDrop($event)"
                         :class="dragging ? 'border-brand bg-brand-light' : 'border-gray-300 bg-gray-50'"
                         class="border-2 border-dashed rounded-xl p-7 text-center cursor-pointer transition">
                        <input type="file" x-ref="fileInput" name="photos[]" multiple accept="image/*"
                               @change="handleFiles($event.target.files)" class="hidden">
                        <div class="w-11 h-11 rounded-xl bg-brand-light flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L7 9m5-5l5 5M4 17v2a1 1 0 001 1h14a1 1 0 001-1v-2"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">Glissez-déposez vos photos ici</p>
                        <p class="text-sm text-gray-400 mt-1">ou <span class="text-brand font-semibold">parcourez vos fichiers</span> · JPG, PNG — 5 Mo max</p>
                    </div>

                    {{-- Preview --}}
                    <div x-show="previews.length > 0" x-cloak class="grid grid-cols-4 gap-3 mt-4">
                        <template x-for="(preview, index) in previews" :key="index">
                            <div class="relative rounded-lg overflow-hidden border border-gray-200 aspect-square">
                                <img :src="preview" class="w-full h-full object-cover">
                                <button type="button" @click.stop="removeFile(index)"
                                        class="absolute top-1.5 right-1.5 w-6 h-6 rounded-full bg-gray-900/70 text-white text-sm flex items-center justify-center hover:bg-gray-900">
                                    &times;
                                </button>
                            </div>
                        </template>
                    </div>
                    @error('photos.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Budget --}}
                <div>
                    <label for="budget_estimate" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Budget estimé (€)</label>
                    <input type="number" id="budget_estimate" name="budget_estimate" value="{{ old('budget_estimate') }}"
                           min="0" step="0.01" placeholder="Ex : 5000"
                           class="w-full sm:w-1/2 px-3.5 py-3 border border-gray-300 rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                </div>
            </div>

            {{-- --- CONSENTEMENT + SUBMIT --- --}}
            <label class="flex items-center gap-2.5 text-sm text-gray-600 px-1">
                <input type="checkbox" required class="w-4 h-4 rounded accent-brand">
                <span>J'accepte que SYMBIOZ traite mes données pour me recontacter.</span>
            </label>

            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-brand text-white font-semibold rounded-xl hover:bg-brand-dark transition">
                Envoyer ma demande de devis
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>

            <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs text-gray-400">
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Réponse sous 48h ouvrées</span>
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Devis gratuit et sans engagement</span>
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Données RGPD sécurisées</span>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    function quoteForm() {
        return {
            dragging: false,
            previews: [],
            files: [],

            handleFiles(fileList) {
                Array.from(fileList).forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    this.files.push(file);
                    this.previews.push(URL.createObjectURL(file));
                });
                this.syncInput();
            },

            handleDrop(event) {
                this.dragging = false;
                this.handleFiles(event.dataTransfer.files);
            },

            removeFile(index) {
                this.files.splice(index, 1);
                this.previews.splice(index, 1);
                this.syncInput();
            },

            // Reconstruit le FileList de l'input (drag & drop ne le remplit pas seul)
            syncInput() {
                const dataTransfer = new DataTransfer();
                this.files.forEach(file => dataTransfer.items.add(file));
                this.$refs.fileInput.files = dataTransfer.files;
            },
        };
    }
</script>
@endpush

@endsection


