<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Subscription response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubscriptionResponse extends BaseResponseDto
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $plan_id,
        public readonly ?string $status,
        public readonly ?string $customer_id,
        public readonly ?string $customer_email,
        public readonly ?float $amount,
        public readonly ?string $currency,
        public readonly ?string $created_at,
        public readonly ?string $updated_at,
        public readonly ?string $next_billing_date,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id?: string|null,
     *     plan_id?: string|null,
     *     status?: string|null,
     *     customer_id?: string|null,
     *     customer_email?: string|null,
     *     amount?: float|null,
     *     currency?: string|null,
     *     created_at?: string|null,
     *     updated_at?: string|null,
     *     next_billing_date?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'] ?? null,
            plan_id: $data['plan_id'] ?? null,
            status: $data['status'] ?? null,
            customer_id: $data['customer_id'] ?? null,
            customer_email: $data['customer_email'] ?? null,
            amount: isset($data['amount']) ? (float) $data['amount'] : null,
            currency: $data['currency'] ?? null,
            created_at: $data['created_at'] ?? null,
            updated_at: $data['updated_at'] ?? null,
            next_billing_date: $data['next_billing_date'] ?? null,
        );
    }

    /**
     * Unwrap result from API response.
     * API returns { "result": { ...subscription data... } }
     *
     * @param array $data
     * @return array
     */
    public static function unwrapResult(array $data): array
    {
        return $data['result'] ?? $data;
    }
}
