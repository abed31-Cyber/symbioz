<?php

namespace App\Notifications;

use App\Models\Request as RequestModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifie l'admin de l'arrivée d'une nouvelle demande.
 * Envoyée sur le canal mail, à chaque soumission (devis ou urgence).
 */
class NewRequestNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly RequestModel $requestModel,
    ) {
    }

    /**
     * Canaux de diffusion.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Construit l'email envoyé à l'admin.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $client = $this->requestModel->client;
        $type   = $this->requestModel->is_quick ? 'URGENTE' : 'de devis';

        return (new MailMessage)
            ->subject("Nouvelle demande {$type} — {$this->requestModel->reference}")
            ->greeting('Nouvelle demande reçue')
            ->line("Référence : {$this->requestModel->reference}")
            ->line("Client : {$client->full_name}")
            ->line("Téléphone : {$client->phone}")
            ->line("Services : {$this->requestModel->services->pluck('name')->implode(', ')}")
            ->line("Description : {$this->requestModel->description}")
            ->action('Voir la demande', url('/admin/demandes/' . $this->requestModel->id))
            ->line('Merci de traiter cette demande rapidement.');
    }
}
