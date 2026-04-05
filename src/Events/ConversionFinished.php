<?php declare(strict_types=1);

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\Events;

class ConversionFinished extends NowPaymentsEvent
{
    public function __construct(
        array $payload,
        public readonly ?string $conversionId = null,
    ) {
        parent::__construct($payload);
    }
}
