<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Authentication response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class AuthResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $token,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{token: string} $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            token: $data['token'],
        );
    }
}
