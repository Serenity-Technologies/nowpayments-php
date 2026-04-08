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
     * @param string|null $fiatEquivalent Fiat currency to get equivalent amount (e.g., "usd")
     * @param bool|null $isFixedRate Whether to use fixed rate
     * @param bool|null $isFeePaidByUser Whether network fee is paid by user
     */
    public function __construct(
        public readonly string $currencyFrom,
        public readonly string $currencyTo,
        public readonly ?string $fiatEquivalent = null,
        public readonly ?bool $isFixedRate = null,
        public readonly ?bool $isFeePaidByUser = null,
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

    public function getFiatEquivalent(): ?string
    {
        return $this->fiatEquivalent;
    }

    public function getIsFixedRate(): ?bool
    {
        return $this->isFixedRate;
    }

    public function getIsFeePaidByUser(): ?bool
    {
        return $this->isFeePaidByUser;
    }

    public function toArray(): array
    {
        $array = [
            'currency_from' => $this->currencyFrom,
            'currency_to' => $this->currencyTo,
        ];

        if ($this->fiatEquivalent !== null) {
            $array['fiat_equivalent'] = $this->fiatEquivalent;
        }

        if ($this->isFixedRate !== null) {
            $array['is_fixed_rate'] = $this->isFixedRate;
        }

        if ($this->isFeePaidByUser !== null) {
            $array['is_fee_paid_by_user'] = $this->isFeePaidByUser;
        }

        return $array;
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
