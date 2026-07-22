<?php

namespace App\Services;

use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use App\Models\Request as RequestModel;
use Illuminate\Support\Carbon;

/**
 * Calcule les indicateurs affichés sur le tableau de bord admin (maquette 05).
 */
class DashboardService
{
    /**
     * Agrège tous les KPI du dashboard en un seul tableau prêt pour la vue.
     *
     * @return array<string, mixed>
     */
    public function kpis(): array
    {
        $countsByStatus = $this->countsByStatus();

        return [
            'countsByStatus'    => $countsByStatus,
            'activeTotal'       => array_sum($countsByStatus),
            'pipelineRevenue'   => $this->pipelineRevenue(),
            'requestsThisMonth' => $this->requestsThisMonth(),
            'processingRate'    => $this->processingRate($countsByStatus),
            'urgentRequest'     => $this->urgentRequest(),
        ];
    }

    /**
     * Nombre de demandes actives par statut.
     * Un seul GROUP BY plutôt qu'un COUNT par statut (4 requêtes évitées).
     * Les statuts absents sont forcés à 0 : la vue n'a jamais à tester l'existence.
     *
     * @return array<string, int> ex. ['nouveau' => 4, 'en_cours' => 6, ...]
     */
    private function countsByStatus(): array
    {
        // pluck('total', 'status') est impossible : 'status' est casté en enum par le modèle
        // et Arr::pluck() ne sait pas utiliser un enum (sans __toString) comme clé de tableau.
        $rows = RequestModel::query()
            ->active()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn (RequestModel $row) => [$row->status->value => (int) $row->total]);

        $counts = [];

        foreach (RequestStatus::cases() as $status) {
            $counts[$status->value] = (int) ($rows[$status->value] ?? 0);
        }

        return $counts;
    }

    /**
     * CA potentiel : somme des budgets estimés des demandes encore ouvertes.
     * Passera sur quotes.amount en couche 3, quand les devis existeront.
     */
    private function pipelineRevenue(): float
    {
        return (float) RequestModel::query()
            ->active()
            ->whereIn('status', [RequestStatus::NOUVEAU, RequestStatus::EN_COURS])
            ->sum('budget_estimate');
    }

    /**
     * Volume de demandes reçues depuis le 1er du mois courant (archivées incluses).
     */
    private function requestsThisMonth(): int
    {
        return RequestModel::query()
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();
    }

    /**
     * Taux de traitement = traités / (traités + perdus), en pourcentage entier.
     * Les demandes encore ouvertes sont exclues : leur issue n'est pas connue.
     *
     * @param array<string, int> $countsByStatus
     */
    private function processingRate(array $countsByStatus): int
    {
        $done   = $countsByStatus[RequestStatus::TRAITE->value];
        $closed = $done + $countsByStatus[RequestStatus::PERDU->value];

        return $closed > 0 ? (int) round($done / $closed * 100) : 0;
    }

    /**
     * Demande urgente non traitée qui attend depuis le plus longtemps.
     * oldest() et non latest() : l'alerte doit remonter la plus ancienne, pas la dernière arrivée.
     */
    private function urgentRequest(): ?RequestModel
    {
        return RequestModel::query()
            ->active()
            ->with(['client', 'services'])
            ->where('priority', RequestPriority::URGENT)
            ->where('status', RequestStatus::NOUVEAU)
            ->oldest()
            ->first();
    }
}
