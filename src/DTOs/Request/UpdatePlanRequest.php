<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for updating subscription plans.
 *
 * Unlike PlanRequest (for creation), all fields are optional for updates.
 * Only provided fields will be updated; omitted fields remain unchanged.
 *
 * @see https://api.nowpayments.io/v1/subscriptions/plans/{plan-id}
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class UpdatePlanRequest extends BaseRequestDto
{
    /**
     * @param string|null $title Name/title of the subscription plan.
     * @param int|null $intervalDay Billing interval in days.
     * @param float|null $amount Billing amount per interval.
     * @param string|null $currency Currency of the billing amount.
     * @param string|null $ipnCallbackUrl URL for Instant Payment Notification.
     * @param string|null $successUrl URL to redirect after successful payment.
     * @param string|null $cancelUrl URL to redirect after cancelled payment.
     * @param string|null $partiallyPaidUrl URL to redirect when a partial payment is made.
     */
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?int $intervalDay = null,
        public readonly ?float $amount = null,
        public readonly ?string $currency = null,
        public readonly ?string $ipnCallbackUrl = null,
        public readonly ?string $successUrl = null,
        public readonly ?string $cancelUrl = null,
        public readonly ?string $partiallyPaidUrl = null,
    ) {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getIntervalDay(): ?int
    {
        return $this->intervalDay;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getCurrency(): ?string
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
        $array = [];

        if ($this->title !== null) {
            $array['title'] = $this->title;
        }

        if ($this->intervalDay !== null) {
            $array['interval_day'] = $this->intervalDay;
        }

        if ($this->amount !== null) {
            $array['amount'] = $this->amount;
        }

        if ($this->currency !== null) {
            $array['currency'] = $this->currency;
        }

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
        // All fields are optional for update; validate only if provided
        if ($this->title !== null && trim($this->title) === '') {
            throw new \InvalidArgumentException('title cannot be empty.');
        }

        if ($this->intervalDay !== null && $this->intervalDay <= 0) {
            throw new \InvalidArgumentException('interval_day must be a positive integer.');
        }

        if ($this->amount !== null && $this->amount <= 0) {
            throw new \InvalidArgumentException('amount must be greater than zero.');
        }

        if ($this->currency !== null && trim($this->currency) === '') {
            throw new \InvalidArgumentException('currency cannot be empty.');
        }

        return true;
    }
}
