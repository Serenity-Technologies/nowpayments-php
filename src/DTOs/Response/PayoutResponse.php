<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Payout response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PayoutResponse extends BaseResponseDto
{
    /**
     * @param PayoutStatusResponse[] $withdrawals
     */
    public function __construct(
        public readonly string $id,
        public readonly array $withdrawals,
        // public readonly ?string $batch_withdrawal_id,
        // public readonly ?string $status,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id: string,
     *     withdrawals: array[],
     *     batch_withdrawal_id?: string|null,
     *     status?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        $withdrawals = array_map(
            fn(array $item) => PayoutStatusResponse::fromArray($item),
            $data['withdrawals'] ?? []
        );

        return new self(
            id: $data['id'],
            withdrawals: $withdrawals,
            // batch_withdrawal_id: $data['batch_withdrawal_id'] ?? null,
            // status: $data['status'] ?? null,
        );
    }
}
