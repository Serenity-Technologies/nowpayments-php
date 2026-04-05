<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Sub-partner response DTO.
 */
class SubPartnerResponse extends BaseResponseDto
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $status,
        public readonly ?string $created_at,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id?: string|null,
     *     name?: string|null,
     *     email?: string|null,
     *     status?: string|null,
     *     created_at?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            status: $data['status'] ?? null,
            created_at: $data['created_at'] ?? null,
        );
    }
}
