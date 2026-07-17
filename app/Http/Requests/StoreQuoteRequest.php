<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation de la demande de devis publique.
 *
 * authorize() = true : le formulaire est accessible à tous les visiteurs,
 * aucune authentification requise (OF-1). La protection contre les abus
 * est assurée par le throttle sur la route (US-1.8), pas ici.
 */
class StoreQuoteRequest extends FormRequest
{
    /**
     * Autorise tout visiteur (formulaire public).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation.
     *
     * service_ids : au moins un service obligatoire (RG-9), chacun devant
     * exister en base. photos optionnelles, images uniquement, 5 Mo max.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'first_name'      => ['nullable', 'string', 'max:100'],
            'last_name'       => ['required', 'string', 'max:150'],
            'email'           => ['required', 'email', 'max:255'],
            'phone'           => ['required', 'string', 'regex:/^0[1-9][0-9]{8}$/'],
            'address'         => ['required', 'string', 'max:255'],
            'city'            => ['required', 'string', 'max:100'],
            'service_ids'     => ['required', 'array', 'min:1'],
            'service_ids.*'   => ['integer', 'exists:services,id'],
            'description'     => ['required', 'string', 'min:10'],
            'budget_estimate' => ['nullable', 'numeric', 'min:0'],
            'photos'          => ['nullable', 'array', 'max:5'],
            'photos.*'        => ['image', 'max:5120'], // 5 Mo par photo
        ];
    }

    /**
     * Messages d'erreur en français.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'last_name.required'   => 'Le nom / raison sociale est obligatoire.',
            'email.required'       => 'L\'adresse email est obligatoire.',
            'email.email'          => 'Veuillez saisir un email valide.',
            'phone.required'       => 'Le numéro de téléphone est obligatoire.',
            'phone.regex'          => 'Le numéro doit comporter 10 chiffres (ex : 0612345678).',
            'address.required'     => 'L\'adresse des travaux est obligatoire.',
            'city.required'        => 'La ville est obligatoire.',
            'service_ids.required' => 'Veuillez sélectionner au moins un service.',
            'service_ids.min'      => 'Veuillez sélectionner au moins un service.',
            'service_ids.*.exists' => 'Le service sélectionné est invalide.',
            'description.required' => 'Veuillez décrire votre projet.',
            'description.min'      => 'La description doit faire au moins 10 caractères.',
            'budget_estimate.numeric' => 'Le budget doit être un montant valide.',
            'photos.max'           => 'Vous ne pouvez pas joindre plus de 5 photos.',
            'photos.*.image'       => 'Seuls les fichiers image sont acceptés.',
            'photos.*.max'         => 'Chaque photo ne doit pas dépasser 5 Mo.',
        ];
    }
}
