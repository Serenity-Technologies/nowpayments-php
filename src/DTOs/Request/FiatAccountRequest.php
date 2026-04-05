<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for creating fiat accounts.
 *
 * @see https://api.nowpayments.io/v1/fiat/account
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class FiatAccountRequest extends BaseRequestDto
{
    /**
     * @param string $currency Fiat currency code (e.g., "USD", "EUR").
     * @param string $paymentCode Payment code identifier.
     * @param array<string, mixed> $fields Additional fields required by the payment provider.
     * @param string|null $provider Payment provider name.
     * @param string|null $countryCode ISO country code.
     */
    public function __construct(
        private readonly string $currency,
        private readonly string $paymentCode,
        private readonly array $fields = [],
        private readonly ?string $provider = null,
        private readonly ?string $countryCode = null,
    ) {
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPaymentCode(): string
    {
        return $this->paymentCode;
    }

    /**
     * @return array<string, mixed>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function toArray(): array
    {
        $array = [
            'currency' => $this->currency,
            'paymentCode' => $this->paymentCode,
        ];

        if (!empty($this->fields)) {
            $array['fields'] = $this->fields;
        }

        if ($this->provider !== null) {
            $array['provider'] = $this->provider;
        }

        if ($this->countryCode !== null) {
            $array['countryCode'] = $this->countryCode;
        }

        return $array;
    }

    public function validate(): bool
    {
        if (trim($this->currency) === '') {
            throw new \InvalidArgumentException('currency is required.');
        }

        if (trim($this->paymentCode) === '') {
            throw new \InvalidArgumentException('paymentCode is required.');
        }

        return true;
    }
}
