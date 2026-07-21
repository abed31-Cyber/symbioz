<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation de la demande urgente (formulaire public « prospect pressé »).
 *
 * Règles de gestion couvertes :
 * - RG-8 : email réellement optionnel (rappel par téléphone si absent).
 * - RG-9 : au moins un service sélectionné.
 * - Cas dégradé assumé : nom + téléphone suffisent à recontacter le prospect.
 *
 * Note : `is_quick` et `priority` NE SONT PAS validés ici — ils sont fixés
 * par le canal dans RequestService::createFromQuick() (RG-10). Les laisser
 * hors du formulaire empêche toute injection depuis la requête HTTP.
 */
class StoreQuickRequest extends FormRequest
{
    /**
     * Formulaire public : aucune autorisation requise.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            // Identité minimale du prospect pressé
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],

            // Téléphone : format souple, au moins 10 caractères (canal principal)
            'phone' => ['required', 'string', 'min:10', 'max:20'],

            // Email réellement optionnel (RG-8) ; validé RFC seulement s'il est fourni
            'email' => ['nullable', 'email:rfc', 'max:255'],

            // Localisation optionnelle en urgence (précisée par téléphone au besoin)
            'address' => ['nullable', 'string', 'max:255'],
            'city'    => ['nullable', 'string', 'max:100'],

            // Description requise, sans minimum (le prospect pressé va à l'essentiel)
            'description' => ['required', 'string', 'max:2000'],

            // Sélection multi-services — cœur de la relation N-N (RG-9)
            'service_ids'   => ['required', 'array', 'min:1'],
            'service_ids.*' => ['integer', 'exists:services,id'],

            // Photos optionnelles (formats image, taille limitée)
            'photos'   => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:5120'], // 5 Mo/photo
        ];
    }

    /**
     * Messages d'erreur personnalisés (français).
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'last_name.required'   => 'Merci d’indiquer votre nom ou votre raison sociale.',
            'phone.required'       => 'Le téléphone est indispensable pour vous rappeler.',
            'phone.min'            => 'Le numéro de téléphone doit contenir au moins 10 chiffres.',
            'email.email'          => 'L’adresse email n’est pas valide.',
            'description.required' => 'Décrivez brièvement votre problème.',
            'service_ids.required' => 'Sélectionnez au moins un service concerné.',
            'service_ids.min'      => 'Sélectionnez au moins un service concerné.',
            'service_ids.*.exists' => 'Un des services sélectionnés est invalide.',
            'photos.*.image'       => 'Seules les images sont acceptées.',
            'photos.*.max'         => 'Chaque photo ne doit pas dépasser 5 Mo.',
        ];
    }
}
