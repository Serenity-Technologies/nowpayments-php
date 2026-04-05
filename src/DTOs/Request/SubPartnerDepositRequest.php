<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for sub-partner deposit operations.
 *
 * @see https://api.nowpayments.io/v1/sub-partner-deposit
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubPartnerDepositRequest extends BaseRequestDto
{
    /**
     * @param string $currency Currency of the deposit.
     * @param float $amount Amount of the deposit.
     * @param int $subPartnerId ID of the sub-partner.
     */
    public function __construct(
        private readonly string $currency,
        private readonly float $amount,
        private readonly int $subPartnerId,
    ) {
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getSubPartnerId(): int
    {
        return $this->subPartnerId;
    }

    public function toArray(): array
    {
        return [
            'currency' => $this->currency,
            'amount' => $this->amount,
            'sub_partner_id' => $this->subPartnerId,
        ];
    }

    public function validate(): bool
    {
        if (trim($this->currency) === '') {
            throw new \InvalidArgumentException('currency is required.');
        }

        if ($this->amount <= 0) {
            throw new \InvalidArgumentException('amount must be greater than zero.');
        }

        if ($this->subPartnerId <= 0) {
            throw new \InvalidArgumentException('sub_partner_id must be a positive integer.');
        }

        return true;
    }
}
