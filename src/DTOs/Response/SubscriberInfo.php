<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Subscriber information DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubscriberInfo extends BaseResponseDto
{
    public function __construct(
        public readonly ?string $email,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     email?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            email: $data['email'] ?? null,
        );
    }
}
