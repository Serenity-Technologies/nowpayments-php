<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for creating an invoice.
 *
 * @see https://api.nowpayments.io/v1/invoice
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class InvoiceRequest extends BaseRequestDto
{
    /**
     * @param float $priceAmount Amount that the customer will have to pay (in price_currency).
     * @param string $priceCurrency Currency of the payment amount (e.g., "USD", "EUR").
     * @param string|null $payCurrency Cryptocurrency that the customer will pay with.
     * @param string|null $ipnCallbackUrl URL for Instant Payment Notification.
     * @param string|null $orderId Internal order ID for your system.
     * @param string|null $orderDescription Description of the order.
     * @param string|null $successUrl URL to redirect after successful payment.
     * @param string|null $cancelUrl URL to redirect after cancelled payment.
     * @param string|null $partiallyPaidUrl URL to redirect after partial payment.
     * @param bool|null $isFixedRate Whether the invoice is created with a fixed rate.
     * @param bool|null $isFeePaidByUser Whether the network fee is paid by the user.
     */
    public function __construct(
        public readonly float $priceAmount,
        public readonly string $priceCurrency,
        public readonly ?string $payCurrency = null,
        public readonly ?string $ipnCallbackUrl = null,
        public readonly ?string $orderId = null,
        public readonly ?string $orderDescription = null,
        public readonly ?string $successUrl = null,
        public readonly ?string $cancelUrl = null,
        public readonly ?string $partiallyPaidUrl = null,
        public readonly ?bool $isFixedRate = null,
        public readonly ?bool $isFeePaidByUser = null,
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

    public function getPayCurrency(): ?string
    {
        return $this->payCurrency;
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

    public function getSuccessUrl(): ?string
    {
        return $this->successUrl;
    }

    public function getCancelUrl(): ?string
    {
        return $this->cancelUrl;
    }

    public function getPartiallyPaidUrl(): ?string
    {
        return $this->partiallyPaidUrl;
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
        ];

        if ($this->payCurrency !== null) {
            $array['pay_currency'] = $this->payCurrency;
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

        if ($this->successUrl !== null) {
            $array['success_url'] = $this->successUrl;
        }

        if ($this->cancelUrl !== null) {
            $array['cancel_url'] = $this->cancelUrl;
        }

        if ($this->partiallyPaidUrl !== null) {
            $array['partially_paid_url'] = $this->partiallyPaidUrl;
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

        // Validate URL fields
        foreach ([$this->ipnCallbackUrl, $this->successUrl, $this->cancelUrl, $this->partiallyPaidUrl] as $url) {
            if ($url !== null && filter_var($url, FILTER_VALIDATE_URL) === false) {
                throw new \InvalidArgumentException('Invalid URL format.');
            }
        }

        return true;
    }
}
