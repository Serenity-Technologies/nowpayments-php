<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for fiat payout operations.
 *
 * @see https://api.nowpayments.io/v1/fiat/payout
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class FiatPayoutRequest extends BaseRequestDto
{
    /**
     * @param string $fiatCurrency Target fiat currency (e.g., "USD", "EUR").
     * @param string $cryptoCurrency Source cryptocurrency.
     * @param float $amount Amount to payout.
     * @param string $provider Payment provider name.
     */
    public function __construct(
        public readonly string $fiatCurrency,
        public readonly string $cryptoCurrency,
        public readonly float $amount,
        public readonly string $provider,
    ) {
    }

    public function getFiatCurrency(): string
    {
        return $this->fiatCurrency;
    }

    public function getCryptoCurrency(): string
    {
        return $this->cryptoCurrency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function toArray(): array
    {
        return [
            'fiatCurrency' => $this->fiatCurrency,
            'cryptoCurrency' => $this->cryptoCurrency,
            'amount' => $this->amount,
            'provider' => $this->provider,
        ];
    }

    public function validate(): bool
    {
        if (trim($this->fiatCurrency) === '') {
            throw new \InvalidArgumentException('fiatCurrency is required.');
        }

        if (trim($this->cryptoCurrency) === '') {
            throw new \InvalidArgumentException('cryptoCurrency is required.');
        }

        if ($this->amount <= 0) {
            throw new \InvalidArgumentException('amount must be greater than zero.');
        }

        if (trim($this->provider) === '') {
            throw new \InvalidArgumentException('provider is required.');
        }

        return true;
    }
}
