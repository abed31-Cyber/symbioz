<?php

namespace App\Http\Requests;

use App\Enums\ServiceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteRequestRequest extends FormRequest
{
    /**
     * Formulaire public toute le monde a le droit de soumettre ce formulaire, pas de connection.. donc true
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation de la demande de devis.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name'      => ['required', 'string', 'max:100'],
            'last_name'       => ['required', 'string', 'max:100'],
            'email'           => ['required', 'email:rfc', 'max:255'],
            'phone'           => ['required', 'string', 'regex:/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/'],
            'address'         => ['nullable', 'string', 'max:255'],
            'service_type'    => ['required', Rule::enum(ServiceType::class)],
            'description'     => ['required', 'string', 'min:10'],
            'budget_estimate' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'consent'         => ['accepted'], // case RGPD obligatoire (maquette 02)
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
            'first_name.required'   => 'Le prénom est obligatoire.',
            'first_name.max'        => 'Le prénom ne peut pas dépasser 100 caractères.',
            'last_name.required'    => 'Le nom est obligatoire.',
            'last_name.max'         => 'Le nom ne peut pas dépasser 100 caractères.',
            'email.required'        => "L'adresse email est obligatoire.",
            'email.email'           => 'Veuillez saisir une adresse email valide.',
            'phone.required'        => 'Le numéro de téléphone est obligatoire.',
            'phone.regex'           => 'Veuillez saisir un numéro français valide (10 chiffres).',
            'service_type.required' => 'Veuillez sélectionner un service.',
            'service_type.enum'     => 'Le service sélectionné est invalide.',
            'description.required'  => 'Veuillez décrire votre projet.',
            'description.min'       => 'La description doit contenir au moins 10 caractères.',
            'budget_estimate.numeric' => 'Le budget doit être un montant valide.',
            'consent.accepted'      => 'Vous devez accepter le traitement de vos données pour continuer.',
        ];
    }

    /**
     * Noms lisibles des champs (pour les messages génériques).
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'first_name'      => 'prénom',
            'last_name'       => 'nom',
            'email'           => 'email',
            'phone'           => 'téléphone',
            'address'         => 'adresse',
            'service_type'    => 'service',
            'description'     => 'description',
            'budget_estimate' => 'budget',
        ];
    }
}
