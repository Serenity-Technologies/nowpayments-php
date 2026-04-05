<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for sub-partner payment operations.
 *
 * @see https://api.nowpayments.io/v1/sub-partner-payment
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubPartnerPaymentRequest extends BaseRequestDto
{
    /**
     * @param string $currency Currency of the payment.
     * @param float $amount Amount of the payment.
     * @param int $subPartnerId ID of the sub-partner.
     * @param bool|null $isFixedRate Whether the payment uses a fixed rate.
     * @param bool|null $isFeePaidByUser Whether the network fee is paid by the user.
     * @param string|null $ipnCallbackUrl URL for Instant Payment Notification.
     */
    public function __construct(
        private readonly string $currency,
        private readonly float $amount,
        private readonly int $subPartnerId,
        private readonly ?bool $isFixedRate = null,
        private readonly ?bool $isFeePaidByUser = null,
        private readonly ?string $ipnCallbackUrl = null,
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

    public function getIsFixedRate(): ?bool
    {
        return $this->isFixedRate;
    }

    public function getIsFeePaidByUser(): ?bool
    {
        return $this->isFeePaidByUser;
    }

    public function getIpnCallbackUrl(): ?string
    {
        return $this->ipnCallbackUrl;
    }

    public function toArray(): array
    {
        $array = [
            'currency' => $this->currency,
            'amount' => $this->amount,
            'sub_partner_id' => $this->subPartnerId,
        ];

        if ($this->isFixedRate !== null) {
            $array['is_fixed_rate'] = $this->isFixedRate;
        }

        if ($this->isFeePaidByUser !== null) {
            $array['is_fee_paid_by_user'] = $this->isFeePaidByUser;
        }

        if ($this->ipnCallbackUrl !== null) {
            $array['ipn_callback_url'] = $this->ipnCallbackUrl;
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

        if ($this->subPartnerId <= 0) {
            throw new \InvalidArgumentException('sub_partner_id must be a positive integer.');
        }

        return true;
    }
}
