<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Support;

/**
 * Payout status enum for NOWPayments.
 */
enum PayoutStatus: string
{
    case Creating = 'creating';
    case Waiting = 'waiting';
    case Processing = 'processing';
    case Sending = 'sending';
    case Finished = 'finished';
    case Failed = 'failed';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';

    /**
     * Check if payout is completed.
     */
    public function isFinal(): bool
    {
        return in_array($this, [self::Finished, self::Failed, self::Rejected, self::Cancelled], true);
    }

    /**
     * Check if payout is successful.
     */
    public function isSuccessful(): bool
    {
        return $this === self::Finished;
    }

    /**
     * Check if payout is pending.
     */
    public function isPending(): bool
    {
        return ! $this->isFinal();
    }
}
