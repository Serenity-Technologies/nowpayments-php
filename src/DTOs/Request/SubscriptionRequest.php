<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for creating subscriptions.
 *
 * @see https://api.nowpayments.io/v1/subscriptions
 */
class SubscriptionRequest extends BaseRequestDto
{
    /**
     * @param int $subscriptionPlanId ID of the subscription plan to subscribe to.
     * @param int|null $subPartnerId ID of the sub-partner (if applicable).
     * @param string|null $email Email address of the subscriber.
     */
    public function __construct(
        private readonly int $subscriptionPlanId,
        private readonly ?int $subPartnerId = null,
        private readonly ?string $email = null,
    ) {
    }

    public function getSubscriptionPlanId(): int
    {
        return $this->subscriptionPlanId;
    }

    public function getSubPartnerId(): ?int
    {
        return $this->subPartnerId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function toArray(): array
    {
        $array = [
            'subscription_plan_id' => $this->subscriptionPlanId,
        ];

        if ($this->subPartnerId !== null) {
            $array['sub_partner_id'] = $this->subPartnerId;
        }

        if ($this->email !== null) {
            $array['email'] = $this->email;
        }

        return $array;
    }

    public function validate(): bool
    {
        if ($this->subscriptionPlanId <= 0) {
            throw new \InvalidArgumentException('subscription_plan_id must be a positive integer.');
        }

        if ($this->email !== null && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('email must be a valid email address.');
        }

        return true;
    }
}
