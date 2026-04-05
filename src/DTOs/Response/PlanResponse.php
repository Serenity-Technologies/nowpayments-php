<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Plan response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PlanResponse extends BaseResponseDto
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $name,
        public readonly ?string $description,
        public readonly ?float $price,
        public readonly ?string $currency,
        public readonly ?string $interval,
        public readonly ?int $interval_count,
        public readonly ?string $status,
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
     *     description?: string|null,
     *     price?: float|null,
     *     currency?: string|null,
     *     interval?: string|null,
     *     interval_count?: int|null,
     *     status?: string|null,
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
            description: $data['description'] ?? null,
            price: isset($data['price']) ? (float) $data['price'] : null,
            currency: $data['currency'] ?? null,
            interval: $data['interval'] ?? null,
            interval_count: isset($data['interval_count']) ? (int) $data['interval_count'] : null,
            status: $data['status'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }
}
