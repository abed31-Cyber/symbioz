<?php

namespace App\Services;

use App\Models\QuoteRequest;

/**
 * Service de création d'une demande de devis.
 * Encapsule la logique métier et les règles de validation supplémentaires.
 */
class QuoteRequestService
{
    /**
     * Crée une demande de devis en base.
     *
     * @param  array<string, mixed>  $data  Données déjà validées par le Form Request.
     */
    public function create(array $data): QuoteRequest
    {
        // La notification email admin sera ajoutée ici au Sprint 5 (RG-6).
        return QuoteRequest::create($data);
    }
}
