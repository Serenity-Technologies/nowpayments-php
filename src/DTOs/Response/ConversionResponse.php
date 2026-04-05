<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Conversion response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class ConversionResponse extends BaseResponseDto
{
    public function __construct(
        public readonly ?string $conversion_id,
        public readonly ?string $status,
        public readonly ?float $amount_from,
        public readonly ?string $currency_from,
        public readonly ?float $amount_to,
        public readonly ?string $currency_to,
        public readonly ?string $created_at,
        public readonly ?string $updated_at,
        public readonly ?array $details,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     conversion_id?: string|null,
     *     status?: string|null,
     *     amount_from?: float|null,
     *     currency_from?: string|null,
     *     amount_to?: float|null,
     *     currency_to?: string|null,
     *     created_at?: string|null,
     *     updated_at?: string|null,
     *     details?: array|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            conversion_id: $data['conversion_id'] ?? null,
            status: $data['status'] ?? null,
            amount_from: isset($data['amount_from']) ? (float) $data['amount_from'] : null,
            currency_from: $data['currency_from'] ?? null,
            amount_to: isset($data['amount_to']) ? (float) $data['amount_to'] : null,
            currency_to: $data['currency_to'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
            details: $data['details'] ?? null,
        );
    }
}
