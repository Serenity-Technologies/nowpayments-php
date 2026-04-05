<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * API Status response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class ApiStatusResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $message,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{message: string} $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            message: $data['message'],
        );
    }
}
