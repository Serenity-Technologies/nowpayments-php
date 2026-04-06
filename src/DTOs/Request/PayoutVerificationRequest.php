<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for verifying payout operations.
 *
 * Used to confirm or verify a payout using a verification code.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PayoutVerificationRequest extends BaseRequestDto
{
    /**
     * @param string $verificationCode The verification code received for the payout.
     */
    public function __construct(
        public readonly string $verificationCode,
    ) {
    }

    public function getVerificationCode(): string
    {
        return $this->verificationCode;
    }

    public function toArray(): array
    {
        return [
            'verification_code' => $this->verificationCode,
        ];
    }

    public function validate(): bool
    {
        if (trim($this->verificationCode) === '') {
            throw new \InvalidArgumentException('verification_code is required.');
        }

        return true;
    }
}
