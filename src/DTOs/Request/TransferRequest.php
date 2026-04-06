<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for transferring funds between accounts.
 *
 * @see https://api.nowpayments.io/v1/transfer
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class TransferRequest extends BaseRequestDto
{
    /**
     * @param string $currency Currency of the transfer.
     * @param float $amount Amount to transfer.
     * @param int|null $fromId Source account ID.
     * @param int|null $toId Destination account ID.
     */
    public function __construct(
        public readonly string $currency,
        public readonly float $amount,
        public readonly ?int $fromId = null,
        public readonly ?int $toId = null,
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

    public function getFromId(): ?int
    {
        return $this->fromId;
    }

    public function getToId(): ?int
    {
        return $this->toId;
    }

    public function toArray(): array
    {
        $array = [
            'currency' => $this->currency,
            'amount' => $this->amount,
        ];

        if ($this->fromId !== null) {
            $array['from_id'] = $this->fromId;
        }

        if ($this->toId !== null) {
            $array['to_id'] = $this->toId;
        }

        return $array;
    }

    public function validate(): bool
    {
        if (trim($this->currency) === '') {
            throw new \InvalidArgumentException('currency is required.');
        }

        if ($this->amount <= 0) {
            throw new \InvalidArgumentException('amount must be greater than zero.');
        }

        return true;
    }
}
