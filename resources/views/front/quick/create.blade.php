@extends('layouts.public')

@section('title', 'Demande urgente — SYMBIOZ')

@section('content')
<section class="bg-gray-50 py-12 lg:py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ===== EN-TÊTE ===== --}}
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-accent/10 text-accent text-xs font-bold uppercase tracking-wide mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Intervention urgente
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Un problème urgent ?</h1>
            <p class="mt-4 text-gray-600 max-w-xl mx-auto">
                Laissez-nous votre numéro et décrivez la situation.
                Nous vous rappelons <strong class="text-gray-900">sous 2 heures</strong> pendant nos horaires d'ouverture.
            </p>
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
        <form action="{{ route('front.quick.store') }}" method="POST" enctype="multipart/form-data"
              x-data="quickForm()" class="space-y-6">
            @csrf

            <div class="bg-white border border-gray-200 rounded-2xl p-6 sm:p-8 shadow-sm">

                {{-- --- COORDONNÉES --- --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 rounded-lg bg-brand-light flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3l2 5-2.5 1.5a11 11 0 005 5L14 12l5 2v3a2 2 0 01-2 2A14 14 0 013 5z"/></svg>
                    </div>
                    <h2 class="text-lg font-bold">Pour vous rappeler</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
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
                        <label for="phone" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Téléphone <span class="text-accent">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="0612345678"
                               class="w-full px-3.5 py-3 border @error('phone') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">
                            Email <span class="normal-case tracking-normal text-gray-400 font-medium">(optionnel)</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full px-3.5 py-3 border @error('email') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                    <div>
                        <label for="address" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">
                            Adresse d'intervention <span class="normal-case tracking-normal text-gray-400 font-medium">(optionnel)</span>
                        </label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                               class="w-full px-3.5 py-3 border @error('address') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                    <div>
                        <label for="city" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">
                            Ville <span class="normal-case tracking-normal text-gray-400 font-medium">(optionnel)</span>
                        </label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}"
                               class="w-full px-3.5 py-3 border @error('city') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none">
                    </div>
                </div>

                <p class="text-sm text-gray-500 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 mb-8">
                    Sans email, pas d'accusé de réception : nous vous confirmons tout par téléphone.
                </p>

                {{-- --- SERVICES (N-N) --- --}}
                <fieldset class="mb-6">
                    <legend class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1">Service(s) concerné(s) <span class="text-accent">*</span></legend>
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

                {{-- --- DESCRIPTION --- --}}
                <div class="mb-6">
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Décrivez la situation <span class="text-accent">*</span></label>
                    <textarea id="description" name="description" rows="4" required
                              placeholder="Ex : fuite d'eau sous l'évier, dégât en cours…"
                              class="w-full px-3.5 py-3 border @error('description') border-red-400 bg-red-50 @else border-gray-300 @enderror rounded-lg text-sm focus:border-brand focus:ring-1 focus:ring-brand outline-none resize-y">{{ old('description') }}</textarea>
                </div>

                {{-- --- PHOTOS --- --}}
                <div>
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
            </div>

            {{-- --- CONSENTEMENT + SUBMIT --- --}}
            <label class="flex items-center gap-2.5 text-sm text-gray-600 px-1">
                <input type="checkbox" required class="w-4 h-4 rounded accent-brand">
                <span>J'accepte d'être rappelé au numéro indiqué.</span>
            </label>

            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-accent text-white font-semibold rounded-xl hover:opacity-90 transition">
                Envoyer ma demande urgente
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>

            <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs text-gray-400">
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Rappel sous 2h ouvrées</span>
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Sans engagement</span>
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Données RGPD sécurisées</span>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
    function quickForm() {
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
