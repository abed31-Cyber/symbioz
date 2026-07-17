<?php

namespace Database\Factories;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * DECIMAL(10,2) pour le montant — jamais de FLOAT (ADR-010).
 *
 * @extends Factory<Quote>
 */
class QuoteFactory extends Factory
{
    protected $model = Quote::class;

    public function definition(): array
    {
        $status = fake()->randomElement(QuoteStatus::cases());

        return [
            'request_id' => Request::factory(),
            'amount'     => fake()->randomFloat(2, 500, 30000),
            'status'     => $status,
            'sent_at'    => in_array($status, [QuoteStatus::SENT, QuoteStatus::ACCEPTED, QuoteStatus::REFUSED, QuoteStatus::PAID])
                            ? fake()->dateTimeBetween('-30 days', 'now')
                            : null,
        ];
    }
}
