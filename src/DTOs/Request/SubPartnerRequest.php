<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for creating a sub-partner.
 *
 * @see https://api.nowpayments.io/v1/sub-partner
 */
class SubPartnerRequest extends BaseRequestDto
{
    /**
     * @param string $name Name of the sub-partner.
     */
    public function __construct(
        private readonly string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function validate(): bool
    {
        if (trim($this->name) === '') {
            throw new \InvalidArgumentException('name is required.');
        }

        return true;
    }
}
