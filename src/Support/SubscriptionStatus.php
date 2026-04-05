<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Support;

/**
 * Subscription status enum for NOWPayments.
 */
enum SubscriptionStatus: string
{
    case WaitingPay = 'WAITING_PAY';
    case Paid = 'PAID';
    case PartiallyPaid = 'PARTIALLY_PAID';
    case Expired = 'EXPIRED';

    /**
     * Check if subscription is active.
     */
    public function isActive(): bool
    {
        return $this === self::WaitingPay;
    }

    /**
     * Check if subscription is completed.
     */
    public function isFinal(): bool
    {
        return $this === self::Expired;
    }
}
