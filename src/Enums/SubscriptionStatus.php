<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Enums;

/**
 * Subscription status enum for NOWPayments.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
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
        return $this === self::Paid;
    }

    /**
     * Check if subscription is in a terminal state.
     */
    public function isTerminal(): bool
    {
        return $this === self::Expired;
    }

    /**
     * Check if subscription is pending.
     */
    public function isPending(): bool
    {
        return in_array($this, [self::WaitingPay, self::PartiallyPaid]);
    }
}
