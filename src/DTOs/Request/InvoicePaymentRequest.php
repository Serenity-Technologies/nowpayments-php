<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for creating a payment on an invoice.
 *
 * @see https://api.nowpayments.io/v1/invoice-payment
 */
class InvoicePaymentRequest extends BaseRequestDto
{
    /**
     * @param int $iid Invoice ID to create a payment for.
     * @param string $payCurrency Cryptocurrency to pay with.
     * @param string|null $purchaseId Internal purchase ID for your system.
     * @param string|null $orderDescription Description of the order.
     * @param string|null $customerEmail Customer email.
     * @param string|null $payoutAddress Address for automatic payout.
     * @param string|null $payoutExtraId Extra ID (memo/destination tag) for the payout address.
     * @param string|null $payoutCurrency Currency for the payout.
     */
    public function __construct(
        private readonly int $iid,
        private readonly string $payCurrency,
        private readonly ?string $purchaseId = null,
        private readonly ?string $orderDescription = null,
        private readonly ?string $customerEmail = null,
        private readonly ?string $payoutAddress = null,
        private readonly ?string $payoutExtraId = null,
        private readonly ?string $payoutCurrency = null,
    ) {
    }

    public function getIid(): int
    {
        return $this->iid;
    }

    public function getPayCurrency(): string
    {
        return $this->payCurrency;
    }

    public function getPurchaseId(): ?string
    {
        return $this->purchaseId;
    }

    public function getOrderDescription(): ?string
    {
        return $this->orderDescription;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function getPayoutAddress(): ?string
    {
        return $this->payoutAddress;
    }

    public function getPayoutExtraId(): ?string
    {
        return $this->payoutExtraId;
    }

    public function getPayoutCurrency(): ?string
    {
        return $this->payoutCurrency;
    }

    public function toArray(): array
    {
        $array = [
            'iid' => $this->iid,
            'pay_currency' => $this->payCurrency,
        ];

        if ($this->purchaseId !== null) {
            $array['purchase_id'] = $this->purchaseId;
        }

        if ($this->orderDescription !== null) {
            $array['order_description'] = $this->orderDescription;
        }

        if ($this->customerEmail !== null) {
            $array['customer_email'] = $this->customerEmail;
        }

        if ($this->payoutAddress !== null) {
            $array['payout_address'] = $this->payoutAddress;
        }

        if ($this->payoutExtraId !== null) {
            $array['payout_extra_id'] = $this->payoutExtraId;
        }

        if ($this->payoutCurrency !== null) {
            $array['payout_currency'] = $this->payoutCurrency;
        }

        return $array;
    }

    public function validate(): bool
    {
        if ($this->iid <= 0) {
            throw new \InvalidArgumentException('iid must be a positive integer.');
        }

        if (trim($this->payCurrency) === '') {
            throw new \InvalidArgumentException('pay_currency is required.');
        }

        if ($this->customerEmail !== null && !filter_var($this->customerEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('customer_email must be a valid email address.');
        }

        return true;
    }
}
