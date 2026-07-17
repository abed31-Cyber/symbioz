<?php

namespace App\Services;

use App\Models\Client;

/**
 * Logique métier liée aux clients.
 */
class ClientService
{
    /**
     * Retrouve un client existant ou le crée à partir de ses coordonnées.
     *
     * Déduplication (OF-5) : l'email est la clé prioritaire ; si absent
     * (cas urgence, email nullable), on retombe sur le téléphone.
     * Évite de créer deux fiches pour le même client sur deux demandes.
     *
     * @param  array<string, mixed>  $data
     */
    public function findOrCreate(array $data): Client
    {
        if (! empty($data['email'])) {
            return Client::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        return Client::firstOrCreate(
            ['phone' => $data['phone']],
            $data
        );
    }
}
