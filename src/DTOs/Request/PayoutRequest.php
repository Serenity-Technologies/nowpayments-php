<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for creating payouts.
 *
 * @see https://api.nowpayments.io/v1/payout
 */
class PayoutRequest extends BaseRequestDto
{
    /**
     * @param string|null $executeAt Date and time for scheduled payout execution (ISO 8601).
     * @param string|null $interval Interval for recurring payouts.
     * @param string|null $payoutDescription Description of the payout.
     * @param string|null $ipnCallbackUrl URL for Instant Payment Notification.
     * @param array<int, PayoutWithdrawalItem> $withdrawals Array of withdrawal items.
     */
    public function __construct(
        private readonly array $withdrawals,
        private readonly ?string $executeAt = null,
        private readonly ?string $interval = null,
        private readonly ?string $payoutDescription = null,
        private readonly ?string $ipnCallbackUrl = null,
    ) {
    }

    /**
     * @return array<int, PayoutWithdrawalItem>
     */
    public function getWithdrawals(): array
    {
        return $this->withdrawals;
    }

    public function getExecuteAt(): ?string
    {
        return $this->executeAt;
    }

    public function getInterval(): ?string
    {
        return $this->interval;
    }

    public function getPayoutDescription(): ?string
    {
        return $this->payoutDescription;
    }

    public function getIpnCallbackUrl(): ?string
    {
        return $this->ipnCallbackUrl;
    }

    public function toArray(): array
    {
        $array = [
            'withdrawals' => array_map(
                static fn(PayoutWithdrawalItem $item): array => $item->toArray(),
                $this->withdrawals,
            ),
        ];

        if ($this->executeAt !== null) {
            $array['execute_at'] = $this->executeAt;
        }

        if ($this->interval !== null) {
            $array['interval'] = $this->interval;
        }

        if ($this->payoutDescription !== null) {
            $array['payout_description'] = $this->payoutDescription;
        }

        if ($this->ipnCallbackUrl !== null) {
            $array['ipn_callback_url'] = $this->ipnCallbackUrl;
        }

        return $array;
    }

    public function validate(): bool
    {
        if (empty($this->withdrawals)) {
            throw new \InvalidArgumentException('At least one withdrawal is required.');
        }

        foreach ($this->withdrawals as $index => $withdrawal) {
            try {
                $withdrawal->validate();
            } catch (\InvalidArgumentException $e) {
                throw new \InvalidArgumentException(
                    sprintf('Invalid withdrawal at index %d: %s', $index, $e->getMessage()),
                );
            }
        }

        return true;
    }
}

/**
 * Represents a single withdrawal item within a PayoutRequest.
 */
class PayoutWithdrawalItem extends BaseRequestDto
{
    /**
     * @param string $address Withdrawal destination address.
     * @param string $currency Currency of the withdrawal.
     * @param float $amount Amount to withdraw.
     * @param string|null $extraId Extra ID (memo/destination tag) for the address.
     * @param string|null $ipnCallbackUrl IPN callback URL for this withdrawal.
     * @param float|null $fiatAmount Fiat equivalent amount.
     * @param string|null $fiatCurrency Currency of the fiat amount.
     * @param string|null $uniqueExternalId Unique external identifier for tracking.
     * @param string|null $payoutDescription Description for this specific withdrawal.
     */
    public function __construct(
        private readonly string $address,
        private readonly string $currency,
        private readonly float $amount,
        private readonly ?string $extraId = null,
        private readonly ?string $ipnCallbackUrl = null,
        private readonly ?float $fiatAmount = null,
        private readonly ?string $fiatCurrency = null,
        private readonly ?string $uniqueExternalId = null,
        private readonly ?string $payoutDescription = null,
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

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getExtraId(): ?string
    {
        return $this->extraId;
    }

    public function getIpnCallbackUrl(): ?string
    {
        return $this->ipnCallbackUrl;
    }

    public function getFiatAmount(): ?float
    {
        return $this->fiatAmount;
    }

    public function getFiatCurrency(): ?string
    {
        return $this->fiatCurrency;
    }

    public function getUniqueExternalId(): ?string
    {
        return $this->uniqueExternalId;
    }

    public function toArray(): array
    {
        $array = [
            'address' => $this->address,
            'currency' => $this->currency,
            'amount' => $this->amount,
        ];

        if ($this->extraId !== null) {
            $array['extra_id'] = $this->extraId;
        }

        if ($this->ipnCallbackUrl !== null) {
            $array['ipn_callback_url'] = $this->ipnCallbackUrl;
        }

        if ($this->fiatAmount !== null) {
            $array['fiat_amount'] = $this->fiatAmount;
        }

        if ($this->fiatCurrency !== null) {
            $array['fiat_currency'] = $this->fiatCurrency;
        }

        if ($this->uniqueExternalId !== null) {
            $array['unique_external_id'] = $this->uniqueExternalId;
        }

        if ($this->payoutDescription !== null) {
            $array['payout_description'] = $this->payoutDescription;
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

        if ($this->amount <= 0) {
            throw new \InvalidArgumentException('amount must be greater than zero.');
        }

        return true;
    }
}
