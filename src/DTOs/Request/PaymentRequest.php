<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for creating a payment.
 *
 * @see https://api.nowpayments.io/v1/payment
 */
class PaymentRequest extends BaseRequestDto
{
    /**
     * @param float $priceAmount Amount that the customer will have to pay (in price_currency).
     * @param string $priceCurrency Currency of the payment amount (e.g., "USD", "EUR").
     * @param string $payCurrency Cryptocurrency that the customer will pay with.
     * @param float|null $payAmount Exact amount in crypto that the customer needs to send. If set, overrides price_amount calculation.
     * @param string|null $ipnCallbackUrl URL for Instant Payment Notification.
     * @param string|null $orderId Internal order ID for your system.
     * @param string|null $orderDescription Description of the order.
     * @param string|null $payoutAddress Address for automatic payout.
     * @param string|null $payoutCurrency Currency for the payout.
     * @param string|null $payoutExtraId Extra ID (memo/destination tag) for the payout address.
     * @param bool|null $isFixedRate Whether the payment is created with a fixed rate.
     * @param bool|null $isFeePaidByUser Whether the network fee is paid by the user.
     */
    public function __construct(
        private readonly float $priceAmount,
        private readonly string $priceCurrency,
        private readonly string $payCurrency,
        private readonly ?float $payAmount = null,
        private readonly ?string $ipnCallbackUrl = null,
        private readonly ?string $orderId = null,
        private readonly ?string $orderDescription = null,
        private readonly ?string $payoutAddress = null,
        private readonly ?string $payoutCurrency = null,
        private readonly ?string $payoutExtraId = null,
        private readonly ?bool $isFixedRate = null,
        private readonly ?bool $isFeePaidByUser = null,
    ) {
    }

    public function getPriceAmount(): float
    {
        return $this->priceAmount;
    }

    public function getPriceCurrency(): string
    {
        return $this->priceCurrency;
    }

    public function getPayCurrency(): string
    {
        return $this->payCurrency;
    }

    public function getPayAmount(): ?float
    {
        return $this->payAmount;
    }

    public function getIpnCallbackUrl(): ?string
    {
        return $this->ipnCallbackUrl;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function getOrderDescription(): ?string
    {
        return $this->orderDescription;
    }

    public function getPayoutAddress(): ?string
    {
        return $this->payoutAddress;
    }

    public function getPayoutCurrency(): ?string
    {
        return $this->payoutCurrency;
    }

    public function getPayoutExtraId(): ?string
    {
        return $this->payoutExtraId;
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
            'price_amount' => $this->priceAmount,
            'price_currency' => $this->priceCurrency,
            'pay_currency' => $this->payCurrency,
        ];

        if ($this->payAmount !== null) {
            $array['pay_amount'] = $this->payAmount;
        }

        if ($this->ipnCallbackUrl !== null) {
            $array['ipn_callback_url'] = $this->ipnCallbackUrl;
        }

        if ($this->orderId !== null) {
            $array['order_id'] = $this->orderId;
        }

        if ($this->orderDescription !== null) {
            $array['order_description'] = $this->orderDescription;
        }

        if ($this->payoutAddress !== null) {
            $array['payout_address'] = $this->payoutAddress;
        }

        if ($this->payoutCurrency !== null) {
            $array['payout_currency'] = $this->payoutCurrency;
        }

        if ($this->payoutExtraId !== null) {
            $array['payout_extra_id'] = $this->payoutExtraId;
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
        if ($this->priceAmount <= 0) {
            throw new \InvalidArgumentException('price_amount must be greater than zero.');
        }

        if (trim($this->priceCurrency) === '') {
            throw new \InvalidArgumentException('price_currency is required.');
        }

        if (trim($this->payCurrency) === '') {
            throw new \InvalidArgumentException('pay_currency is required.');
        }

        if ($this->payAmount !== null && $this->payAmount <= 0) {
            throw new \InvalidArgumentException('pay_amount must be greater than zero.');
        }

        // Validate URL fields
        foreach ([$this->ipnCallbackUrl, $this->payoutAddress] as $url) {
            if ($url !== null && filter_var($url, FILTER_VALIDATE_URL) === false) {
                throw new \InvalidArgumentException('Invalid URL format.');
            }
        }

        return true;
    }
}
