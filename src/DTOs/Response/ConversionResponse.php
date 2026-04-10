<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Conversion response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class ConversionResponse extends BaseResponseDto
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $status,
        public readonly ?float $from_amount,
        public readonly ?string $from_currency,
        public readonly ?float $to_amount,
        public readonly ?string $to_currency,
        public readonly ?string $created_at,
        public readonly ?string $updated_at,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id?: string|null,
     *     status?: string|null,
     *     from_amount?: float|null,
     *     from_currency?: string|null,
     *     to_amount?: float|null,
     *     to_currency?: string|null,
     *     created_at?: string|null,
     *     updated_at?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'] ?? null,
            status: $data['status'] ?? null,
            from_amount: isset($data['from_amount']) ? (float) $data['from_amount'] : null,
            from_currency: $data['from_currency'] ?? null,
            to_amount: isset($data['to_amount']) ? (float) $data['to_amount'] : null,
            to_currency: $data['to_currency'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }
}
