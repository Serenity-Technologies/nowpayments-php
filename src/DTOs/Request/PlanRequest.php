<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for creating subscription plans.
 *
 * @see https://api.nowpayments.io/v1/subscriptions/plan
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PlanRequest extends BaseRequestDto
{
    /**
     * @param string $title Name/title of the subscription plan.
     * @param int $intervalDay Billing interval in days.
     * @param float $amount Billing amount per interval.
     * @param string $currency Currency of the billing amount.
     * @param string|null $ipnCallbackUrl URL for Instant Payment Notification.
     * @param string|null $successUrl URL to redirect after successful payment.
     * @param string|null $cancelUrl URL to redirect after cancelled payment.
     * @param string|null $partiallyPaidUrl URL to redirect when a partial payment is made.
     */
    public function __construct(
        public readonly string $title,
        public readonly int $intervalDay,
        public readonly float $amount,
        public readonly string $currency,
        public readonly ?string $ipnCallbackUrl = null,
        public readonly ?string $successUrl = null,
        public readonly ?string $cancelUrl = null,
        public readonly ?string $partiallyPaidUrl = null,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getIntervalDay(): int
    {
        return $this->intervalDay;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getIpnCallbackUrl(): ?string
    {
        return $this->ipnCallbackUrl;
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

    public function toArray(): array
    {
        $array = [
            'title' => $this->title,
            'interval_day' => $this->intervalDay,
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];

        if ($this->ipnCallbackUrl !== null) {
            $array['ipn_callback_url'] = $this->ipnCallbackUrl;
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

        return $array;
    }

    public function validate(): bool
    {
        if (trim($this->title) === '') {
            throw new \InvalidArgumentException('title is required.');
        }

        if ($this->intervalDay <= 0) {
            throw new \InvalidArgumentException('interval_day must be a positive integer.');
        }

        if ($this->amount <= 0) {
            throw new \InvalidArgumentException('amount must be greater than zero.');
        }

        if (trim($this->currency) === '') {
            throw new \InvalidArgumentException('currency is required.');
        }

        return true;
    }
}
