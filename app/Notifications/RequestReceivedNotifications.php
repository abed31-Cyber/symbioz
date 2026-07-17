<?php

namespace App\Notifications;

use App\Models\Request as RequestModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Accusé de réception envoyé au client.
 * Conditionnel : envoyé uniquement si le client a fourni un email (RG-7/RG-8).
 * L'envoi conditionnel est géré dans RequestService@notify().
 */
class RequestReceivedNotifications extends Notification
{
    use Queueable;

    public function __construct(
        private readonly RequestModel $requestModel,
    ) {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Construit l'accusé de réception client.
     * Le délai annoncé dépend du type de demande (2h urgence / 48h devis).
     */
    public function toMail(object $notifiable): MailMessage
    {
        $delai = $this->requestModel->is_quick
            ? 'sous 2h en journée'
            : 'sous 48h ouvrées';

        return (new MailMessage)
            ->subject("Votre demande a bien été reçue — {$this->requestModel->reference}")
            ->greeting("Bonjour {$notifiable->first_name},")
            ->line('Nous avons bien reçu votre demande et vous en remercions.')
            ->line("Votre référence de suivi : {$this->requestModel->reference}")
            ->line("Notre équipe vous recontacte {$delai} pour préciser votre projet.")
            ->line('À très bientôt,')
            ->salutation('L\'équipe SYMBIOZ');
    }
}

/**
 * Point soutenance : RequestReceivedNotification part sur le modèle Client via $client->notify()
 * — c'est le trait Notifiable sur le modèle qui le permet.
 *  $notifiable = le client, d'où $notifiable->first_name.
 */
