<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Payment response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PaymentResponse extends BaseResponseDto
{
    public function __construct(
        public readonly int $payment_id,
        public readonly ?int $invoice_id,
        public readonly string $payment_status,
        public readonly string $pay_address,
        public readonly ?string $payin_extra_id,
        public readonly float $price_amount,
        public readonly string $price_currency,
        public readonly float $pay_amount,
        public readonly float $actually_paid,
        public readonly string $pay_currency,
        public readonly ?string $order_id,
        public readonly ?string $order_description,
        public readonly int $purchase_id,
        public readonly float $outcome_amount,
        public readonly string $outcome_currency,
        public readonly ?string $payout_hash,
        public readonly ?string $payin_hash,
        public readonly string $created_at,
        public readonly string $updated_at,
        public readonly ?string $burning_percent,
        public readonly string $type,
        public readonly ?array $payment_extra_ids,
        public readonly ?int $parent_payment_id,
        public readonly ?string $origin_type,
        public readonly ?FeeResponse $fee,
        public readonly ?string $smart_contract,
        public readonly ?string $network,
        public readonly ?int $network_precision,
        public readonly ?string $time_limit,
        public readonly ?string $valid_until,
        public readonly ?bool $is_fixed_rate,
        public readonly ?bool $is_fee_paid_by_user,
        public readonly ?string $expiration_estimate_date,
        public readonly ?float $amount_received,
        public readonly ?string $redirect_url,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     payment_id: int,
     *     invoice_id?: int|null,
     *     payment_status: string,
     *     pay_address: string,
     *     payin_extra_id?: string|null,
     *     price_amount: float,
     *     price_currency: string,
     *     pay_amount: float,
     *     actually_paid: float,
     *     pay_currency: string,
     *     order_id?: string|null,
     *     order_description?: string|null,
     *     purchase_id: int,
     *     outcome_amount: float,
     *     outcome_currency: string,
     *     payout_hash?: string|null,
     *     payin_hash?: string|null,
     *     created_at: string,
     *     updated_at: string,
     *     burning_percent?: string|null,
     *     type: string,
     *     payment_extra_ids?: array|null,
     *     parent_payment_id?: int|null,
     *     origin_type?: string|null,
     *     fee?: array|null,
     *     smart_contract?: string|null,
     *     network?: string|null,
     *     network_precision?: int|null,
     *     time_limit?: string|null,
     *     valid_until?: string|null,
     *     is_fixed_rate?: bool|null,
     *     is_fee_paid_by_user?: bool|null,
     *     expiration_estimate_date?: string|null,
     *     amount_received?: float|null,
     *     redirect_url?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            payment_id: isset($data['payment_id']) ? (int) $data['payment_id'] : 0,
            invoice_id: isset($data['invoice_id']) ? (int) $data['invoice_id'] : null,
            payment_status: $data['payment_status'],
            pay_address: $data['pay_address'],
            payin_extra_id: $data['payin_extra_id'] ?? null,
            price_amount: isset($data['price_amount']) ? (float) $data['price_amount'] : 0,
            price_currency: $data['price_currency'],
            pay_amount: isset($data['pay_amount']) ? (float) $data['pay_amount'] : 0,
            actually_paid: isset($data['actually_paid']) ? (float) $data['actually_paid'] : 0,
            pay_currency: $data['pay_currency'],
            order_id: $data['order_id'] ?? null,
            order_description: $data['order_description'] ?? null,
            purchase_id: isset($data['purchase_id']) ? (int) $data['purchase_id'] : 0,
            outcome_amount: isset($data['outcome_amount']) ? (float) $data['outcome_amount'] : 0,
            outcome_currency: $data['outcome_currency'],
            payout_hash: $data['payout_hash'] ?? null,
            payin_hash: $data['payin_hash'] ?? null,
            created_at: $data['created_at'],
            updated_at: $data['updated_at'],
            burning_percent: $data['burning_percent'] ?? null,
            type: $data['type'],
            payment_extra_ids: $data['payment_extra_ids'] ?? null,
            parent_payment_id: isset($data['parent_payment_id']) ? (int) $data['parent_payment_id'] : null,
            origin_type: $data['origin_type'] ?? null,
            fee: $data['fee'] ?? null,
            smart_contract: $data['smart_contract'] ?? null,
            network: $data['network'] ?? null,
            network_precision: isset($data['network_precision']) ? (int) $data['network_precision'] : null,
            time_limit: $data['time_limit'] ?? null,
            valid_until: $data['valid_until'] ?? null,
            is_fixed_rate: isset($data['is_fixed_rate']) ? (bool) $data['is_fixed_rate'] : null,
            is_fee_paid_by_user: isset($data['is_fee_paid_by_user']) ? (bool) $data['is_fee_paid_by_user'] : null,
            expiration_estimate_date: $data['expiration_estimate_date'] ?? null,
            amount_received: isset($data['amount_received']) ? (float) $data['amount_received'] : null,
            redirect_url: $data['redirect_url'] ?? null,
        );
    }
}
