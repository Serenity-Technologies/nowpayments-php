<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Error response DTO for handling API errors consistently.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class ErrorResponse extends BaseResponseDto
{
    public function __construct(
        public readonly bool $status,
        public readonly int $statusCode,
        public readonly string $code,
        public readonly string $message,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     status: bool,
     *     statusCode: int,
     *     code: string,
     *     message: string,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            status: (bool) $data['status'],
            statusCode: (int) $data['statusCode'],
            code: $data['code'],
            message: $data['message'],
        );
    }

    /**
     * Check if this is an error response.
     */
    public function isError(): bool
    {
        return $this->status === false;
    }
}
