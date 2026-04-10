<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Transfer response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class TransferResponse extends BaseResponseDto
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $status,
        public readonly ?float $amount,
        public readonly ?string $currency,
        public readonly ?string $from_sub_id,
        public readonly ?string $to_sub_id,
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
     *     amount?: string|float|null,
     *     currency?: string|null,
     *     from_sub_id?: string|null,
     *     to_sub_id?: string|null,
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
            amount: isset($data['amount']) ? (float) $data['amount'] : null,
            currency: $data['currency'] ?? null,
            from_sub_id: $data['from_sub_id'] ?? null,
            to_sub_id: $data['to_sub_id'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }
}
