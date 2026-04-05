<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Support;

/**
 * Payment status enum for NOWPayments.
 *
 * @see https://nowpayments.io/
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
enum PaymentStatus: string
{
    case Waiting = 'waiting';
    case Confirming = 'confirming';
    case Confirmed = 'confirmed';
    case Sending = 'sending';
    case PartiallyPaid = 'partially_paid';
    case Finished = 'finished';
    case Failed = 'failed';
    case Refunded = 'refunded';
    case Expired = 'expired';

    /**
     * Check if payment is completed.
     */
    public function isFinal(): bool
    {
        return in_array($this, [self::Finished, self::Failed, self::Refunded, self::Expired], true);
    }

    /**
     * Check if payment is successful.
     */
    public function isSuccessful(): bool
    {
        return $this === self::Finished;
    }

    /**
     * Check if payment is pending.
     */
    public function isPending(): bool
    {
        return ! $this->isFinal();
    }
}
