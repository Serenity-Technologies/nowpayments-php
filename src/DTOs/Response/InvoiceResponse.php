<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Invoice response DTO.
 */
class InvoiceResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $order_id,
        public readonly ?string $order_description,
        public readonly float $price_amount,
        public readonly string $price_currency,
        public readonly ?string $pay_currency,
        public readonly ?string $ipn_callback_url,
        public readonly string $invoice_url,
        public readonly ?string $success_url,
        public readonly ?string $cancel_url,
        public readonly ?string $partially_paid_url,
        public readonly ?string $token_id,
        public readonly ?string $payout_currency,
        public readonly ?bool $is_fixed_rate,
        public readonly ?bool $is_fee_paid_by_user,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id: string,
     *     order_id?: string|null,
     *     order_description?: string|null,
     *     price_amount: float,
     *     price_currency: string,
     *     pay_currency?: string|null,
     *     ipn_callback_url?: string|null,
     *     invoice_url: string,
     *     success_url?: string|null,
     *     cancel_url?: string|null,
     *     created_at: string,
     *     updated_at: string,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'],
            order_id: $data['order_id'] ?? null,
            order_description: $data['order_description'] ?? null,
            price_amount: (float) ($data['price_amount'] ?? 0),
            price_currency: $data['price_currency'],
            pay_currency: $data['pay_currency'] ?? null,
            ipn_callback_url: $data['ipn_callback_url'] ?? null,
            invoice_url: $data['invoice_url'],
            success_url: $data['success_url'] ?? null,
            cancel_url: $data['cancel_url'] ?? null,
            partially_paid_url: $data['partially_paid_url'] ?? null,
            token_id: $data['token_id'] ?? null,
            payout_currency: $data['payout_currency'] ?? null,
            is_fixed_rate: isset($data['is_fixed_rate']) ? (bool) $data['is_fixed_rate'] : null,
            is_fee_paid_by_user: isset($data['is_fee_paid_by_user']) ? (bool) $data['is_fee_paid_by_user'] : null,
            created_at: $data['created_at'],
            updated_at: $data['updated_at'],
        );
    }
}
