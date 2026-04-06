<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for validating payout addresses.
 *
 * @see https://api.nowpayments.io/v1/payout/address/validate
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PayoutAddressRequest extends BaseRequestDto
{
    /**
     * @param string $address Wallet address to validate.
     * @param string $currency Currency associated with the address.
     * @param string|null $extraId Extra ID (memo/destination tag) if required by the currency.
     */
    public function __construct(
        public readonly string $address,
        public readonly string $currency,
        public readonly ?string $extraId = null,
    ) {
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getExtraId(): ?string
    {
        return $this->extraId;
    }

    public function toArray(): array
    {
        $array = [
            'address' => $this->address,
            'currency' => $this->currency,
        ];

        if ($this->extraId !== null) {
            $array['extra_id'] = $this->extraId;
        }

        return $array;
    }

    public function validate(): bool
    {
        if (trim($this->address) === '') {
            throw new \InvalidArgumentException('address is required.');
        }

        if (trim($this->currency) === '') {
            throw new \InvalidArgumentException('currency is required.');
        }

        return true;
    }
}
