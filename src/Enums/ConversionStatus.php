<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\Enums;

/**
 * Conversion status enum for NOWPayments.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
enum ConversionStatus: string
{
    case Waiting = 'WAITING';
    case Processing = 'PROCESSING';
    case Finished = 'FINISHED';
    case Rejected = 'REJECTED';

    /**
     * Check if conversion is completed.
     */
    public function isFinal(): bool
    {
        return in_array($this, [self::Finished, self::Rejected], true);
    }

    /**
     * Check if conversion is successful.
     */
    public function isSuccessful(): bool
    {
        return $this === self::Finished;
    }

    /**
     * Check if conversion is pending.
     */
    public function isPending(): bool
    {
        return ! $this->isFinal();
    }
}
