<?php

namespace App\Http\Requests;

use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

/**
 * Validation de la mise à jour d'une demande côté admin (statut, priorité, notes).
 * Les données déclaratives (client, description, services) ne sont PAS ici : RG-1.
 */
class UpdateRequestRequest extends FormRequest
{
    /**
     * Accès réservé aux admins connectés (le middleware auth protège déjà la route).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation.
     */
    public function rules(): array
    {
        return [
            'status'         => ['required', Rule::enum(RequestStatus::class)],
            'priority'       => ['required', Rule::enum(RequestPriority::class)],
            'closing_reason' => ['nullable', 'string', 'max:500'],
            'admin_notes'    => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * RG-2 : une demande passée au statut « perdu » impose une raison de clôture.
     * On le vérifie après coup car la règle dépend de la valeur d'un autre champ.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $isPerdu = $this->input('status') === RequestStatus::PERDU->value;
            $reasonEmpty = blank($this->input('closing_reason'));

            if ($isPerdu && $reasonEmpty) {
                $validator->errors()->add(
                    'closing_reason',
                    'Une raison de clôture est obligatoire pour marquer la demande comme perdue.'
                );
            }
        });
    }

    /**
     * Messages personnalisés en français.
     */
    public function messages(): array
    {
        return [
            'status.required'   => 'Le statut est obligatoire.',
            'priority.required' => 'La priorité est obligatoire.',
        ];
    }
}
