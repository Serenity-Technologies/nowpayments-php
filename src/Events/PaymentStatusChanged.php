<?php declare(strict_types=1);

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\Events;

class PaymentStatusChanged extends NowPaymentsEvent
{
    public function __construct(
        array $payload,
        public readonly ?int $paymentId = null,
        public readonly ?string $status = null,
    ) {
        parent::__construct($payload);
    }
}
