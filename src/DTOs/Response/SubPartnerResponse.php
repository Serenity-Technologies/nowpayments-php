<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Sub-partner response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubPartnerResponse extends BaseResponseDto
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $name,
        public readonly ?string $created_at,
        public readonly ?string $updated_at,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id?: string|null,
     *     name?: string|null,
     *     created_at?: string|null,
     *     updated_at?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'] ?? null,
            name: $data['name'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }
}
