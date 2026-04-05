<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Events;

class PayoutCompleted extends NowPaymentsEvent
{
    public function __construct(
        array $payload,
        public readonly ?string $payoutId = null,
        public readonly ?string $status = null,
    ) {
        parent::__construct($payload);
    }
}
