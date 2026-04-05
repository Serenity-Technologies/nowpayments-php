<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class NowPaymentsEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly array $payload,
    ) {
    }
}
