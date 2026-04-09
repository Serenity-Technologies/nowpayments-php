<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for cancelling a scheduled payout.
 *
 * @see https://api.nowpayments.io/v1/payout/:w_id/cancel
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class CancelPayoutRequest extends BaseRequestDto
{
    /**
     * @param string $payoutId ID of the individual payout to cancel.
     */
    public function __construct(
        public readonly string $payoutId,
    ) {
    }

    public function getPayoutId(): string
    {
        return $this->payoutId;
    }

    public function toArray(): array
    {
        return [
            'payout_id' => $this->payoutId,
        ];
    }

    public function validate(): bool
    {
        if (trim($this->payoutId) === '') {
            throw new \InvalidArgumentException('payout_id is required.');
        }

        return true;
    }
}
