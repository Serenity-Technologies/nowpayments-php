<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for currency conversion estimates.
 *
 * @see https://api.nowpayments.io/v1/estimate
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class ConversionRequest extends BaseRequestDto
{
    /**
     * @param float $amount Amount to convert.
     * @param string $fromCurrency Source currency code.
     * @param string $toCurrency Target currency code.
     */
    public function __construct(
        public readonly float $amount,
        public readonly string $fromCurrency,
        public readonly string $toCurrency,
    ) {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getFromCurrency(): string
    {
        return $this->fromCurrency;
    }

    public function getToCurrency(): string
    {
        return $this->toCurrency;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'from_currency' => $this->fromCurrency,
            'to_currency' => $this->toCurrency,
        ];
    }

    public function validate(): bool
    {
        if ($this->amount <= 0) {
            throw new \InvalidArgumentException('amount must be greater than zero.');
        }

        if (trim($this->fromCurrency) === '') {
            throw new \InvalidArgumentException('from_currency is required.');
        }

        if (trim($this->toCurrency) === '') {
            throw new \InvalidArgumentException('to_currency is required.');
        }

        if (strtoupper($this->fromCurrency) === strtoupper($this->toCurrency)) {
            throw new \InvalidArgumentException('from_currency and to_currency must be different.');
        }

        return true;
    }
}
