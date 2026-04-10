<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Subscription response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubscriptionResponse extends BaseResponseDto
{
    public function __construct(
        public readonly ?string         $id,
        public readonly string|int|null $planId,
        public readonly ?string         $status,
        public readonly ?string         $customerId,
        public readonly ?string         $customerEmail,
        public readonly ?float          $amount,
        public readonly ?string         $currency,
        public readonly ?string         $createdAt,
        public readonly ?string         $updatedAt,
        public readonly ?string         $nextBillingDate,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id?: string|null,
     *     plan_id?: string|int|null,
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
            planId: $data['plan_id'] ?? null,
            status: $data['status'] ?? null,
            customerId: $data['customer_id'] ?? null,
            customerEmail: $data['customer_email'] ?? null,
            amount: isset($data['amount']) ? (float) $data['amount'] : null,
            currency: $data['currency'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            nextBillingDate: $data['next_billing_date'] ?? null,
        );
    }
}
