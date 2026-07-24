<?php

namespace App\Services;

use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use App\Models\Request as RequestModel;
use App\Notifications\NewRequestNotification;
use App\Notifications\RequestReceivedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

/**
 * Orchestration de la création et du cycle de vie des demandes.
 *
 * Les dépendances (ClientService, PhotoService) sont injectées par le
 * service container (IoC) — jamais instanciées à la main.
 */
class RequestService
{
    public function __construct(
        private readonly ClientService $clientService,
        private readonly PhotoService $photoService,
    ) {
    }

    /**
     * Crée une demande de devis (is_quick = false, priorité normale).
     *
     * @param  array<string, mixed>       $data
     * @param  array<int, int>            $serviceIds
     * @param  array<int, mixed>          $photos
     */
    public function createFromQuote(array $data, array $serviceIds, array $photos = []): RequestModel
    {
        return $this->create($data, $serviceIds, $photos, isQuick: false);
    }

    /**
     * Crée une demande urgente (is_quick = true, priorité urgente).
     * Utilisé au Sprint 2 (EPIC 3).
     *
     * @param  array<string, mixed>       $data
     * @param  array<int, int>            $serviceIds
     * @param  array<int, mixed>          $photos
     */
    public function createFromQuick(array $data, array $serviceIds, array $photos = []): RequestModel
    {
        return $this->create($data, $serviceIds, $photos, isQuick: true);
    }

    /**
     * Logique commune de création, factorisée.
     *
     * Enveloppée dans une transaction : si une étape échoue (services,
     * photos), rien n'est persisté — cohérence garantie.
     *
     * @param  array<string, mixed>  $data
     * @param  array<int, int>       $serviceIds
     * @param  array<int, mixed>     $photos
     */
    private function create(array $data, array $serviceIds, array $photos, bool $isQuick): RequestModel
    {
        $requestModel = DB::transaction(function () use ($data, $serviceIds, $photos, $isQuick) {
            $client = $this->clientService->findOrCreate([
                'first_name' => $data['first_name'] ?? null,
                'last_name'  => $data['last_name'],
                'email'      => $data['email'] ?? null,
                'phone'      => $data['phone'],
                'address'    => $data['address'] ?? null,
                'city'       => $data['city'] ?? null,
            ]);

            $requestModel = RequestModel::create([
                'client_id'       => $client->id,
                'reference'       => $this->generateReference(),
                'description'     => $data['description'],
                'budget_estimate' => $data['budget_estimate'] ?? null,
                'is_quick'        => $isQuick,
                'priority'        => $isQuick ? RequestPriority::URGENT : RequestPriority::NORMAL,
                'status'          => RequestStatus::NOUVEAU,
            ]);

            // N-N n°1 : sync() attache les services en une requête (jamais attach() en boucle)
            $requestModel->services()->sync($serviceIds);

            // Photos (1-N)
            $this->photoService->attachMany($requestModel, $photos);

            return $requestModel;
        });

        $this->notify($requestModel);

        return $requestModel;
    }

    /**
     * Notifie l'admin systématiquement, et le client seulement s'il a un email (RG-7/RG-8).
     */
    private function notify(RequestModel $requestModel): void
    {
        Notification::route('mail', config('mail.admin_email'))
            ->notify(new NewRequestNotification($requestModel));

        $client = $requestModel->client;

        if ($client->email) {
            $client->notify(new RequestReceivedNotification($requestModel));
        }
    }

    /**
     * Génère une référence unique de type REF-0042.
     * withTrashed() inclut les demandes soft-deleted pour ne jamais réutiliser un numéro.
     */
    private function generateReference(): string
    {
        $next = RequestModel::withTrashed()->count() + 1;

        return 'REF-' . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }
    /**
     * Met à jour le pilotage d'une demande : statut, priorité, notes internes.
     * RG-2 : si le statut n'est plus « perdu », on efface la raison de clôture
     * pour ne pas laisser une raison orpheline.
     *
     * @param array<string, mixed> $data données déjà validées par UpdateRequestRequest
     */
    public function updateStatus(RequestModel $requestModel, array $data): void
    {
        $requestModel->update([
            'status'         => $data['status'],
            'priority'       => $data['priority'],
            'admin_notes'    => $data['admin_notes'] ?? null,
            // La raison n'a de sens que si la demande est perdue.
            'closing_reason' => $data['status'] === RequestStatus::PERDU->value
                ? $data['closing_reason']
                : null,
        ]);
    }
}
