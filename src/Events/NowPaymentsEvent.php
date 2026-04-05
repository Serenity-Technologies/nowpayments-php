<?php declare(strict_types=1);

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
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
