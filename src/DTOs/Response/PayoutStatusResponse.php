<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Payout status response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PayoutStatusResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $address,
        public readonly string $currency,
        public readonly string $amount,
        public readonly ?string $batch_withdrawal_id,
        public readonly string $status,
        public readonly ?string $extra_id,
        public readonly ?string $hash,
        public readonly ?string $error,
        public readonly ?bool $is_request_payouts,
        public readonly ?string $ipn_callback_url,
        public readonly ?string $unique_external_id,
        public readonly ?string $payout_description,
        public readonly string $created_at,
        public readonly ?string $requested_at,
        public readonly ?string $updated_at,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id: string,
     *     address: string,
     *     currency: string,
     *     amount: string,
     *     batch_withdrawal_id: string,
     *     status: string,
     *     extra_id?: string|null,
     *     hash?: string|null,
     *     error?: string|null,
     *     is_request_payouts: bool,
     *     ipn_callback_url?: string|null,
     *     unique_external_id?: string|null,
     *     payout_description?: string|null,
     *     created_at: string,
     *     requested_at?: string|null,
     *     updated_at?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'],
            address: $data['address'],
            currency: $data['currency'],
            amount: $data['amount'],
            batch_withdrawal_id: $data['batch_withdrawal_id'] ?? null,
            status: $data['status'],
            extra_id: $data['extra_id'] ?? null,
            hash: $data['hash'] ?? null,
            error: $data['error'] ?? null,
            is_request_payouts: isset($data['is_request_payouts']) ? (bool) $data['is_request_payouts'] : null,
            ipn_callback_url: $data['ipn_callback_url'] ?? null,
            unique_external_id: $data['unique_external_id'] ?? null,
            payout_description: $data['payout_description'] ?? null,
            created_at: $data['created_at'],
            requested_at: $data['requested_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
        );
    }
}
