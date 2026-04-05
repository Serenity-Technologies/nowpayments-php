<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for estimating cryptocurrency conversion.
 *
 * @see https://api.nowpayments.io/v1/estimate
 */
class EstimateRequest extends BaseRequestDto
{
    /**
     * @param string $currencyFrom Source currency (e.g., "btc")
     * @param string $currencyTo Target currency (e.g., "usdttrx")
     * @param float $amount Amount to convert
     * @param bool|null $isFixedRate Whether to use fixed rate
     * @param bool|null $isFeePaidByUser Whether network fee is paid by user
     */
    public function __construct(
        private readonly string $currencyFrom,
        private readonly string $currencyTo,
        private readonly float $amount,
        private readonly ?bool $isFixedRate = null,
        private readonly ?bool $isFeePaidByUser = null,
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

    public function getAmount(): float
    {
        return $this->amount;
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
            'amount' => $this->amount,
        ];

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

        if ($this->amount <= 0) {
            throw new \InvalidArgumentException('amount must be greater than zero.');
        }

        return true;
    }
}
