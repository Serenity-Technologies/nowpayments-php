<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for getting minimum payment amount.
 *
 * @see https://api.nowpayments.io/v1/min-amount
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class MinAmountRequest extends BaseRequestDto
{
    /**
     * @param string $currencyFrom Source currency (e.g., "btc")
     * @param string $currencyTo Target currency (e.g., "usdttrx")
     */
    public function __construct(
        public readonly string $currencyFrom,
        public readonly string $currencyTo,
    ) {
    }

    public function getCurrencyFrom(): string
    {
        return $this->currencyFrom;
    }

    public function getCurrencyTo(): string
    {
        return $this->currencyTo;
    }

    public function toArray(): array
    {
        return [
            'currency_from' => $this->currencyFrom,
            'currency_to' => $this->currencyTo,
        ];
    }

    public function validate(): bool
    {
        if (trim($this->currencyFrom) === '') {
            throw new \InvalidArgumentException('currency_from is required.');
        }

        if (trim($this->currencyTo) === '') {
            throw new \InvalidArgumentException('currency_to is required.');
        }

        return true;
    }
}
