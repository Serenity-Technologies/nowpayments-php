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
        public readonly ?string $title,
        public readonly ?int $intervalDay,
        public readonly ?float $amount,
        public readonly ?string $currency,
        public readonly ?string $ipnCallbackUrl,
        public readonly ?string $successUrl,
        public readonly ?string $cancelUrl,
        public readonly ?string $partiallyPaidUrl,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id?: string|null,
     *     title?: string|null,
     *     interval_day?: string|int|null,
     *     amount?: float|int|string|null,
     *     currency?: string|null,
     *     ipn_callback_url?: string|null,
     *     success_url?: string|null,
     *     cancel_url?: string|null,
     *     partially_paid_url?: string|null,
     *     created_at?: string|null,
     *     updated_at?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'] ?? null,
            intervalDay: isset($data['interval_day']) ? (int) $data['interval_day'] : null,
            amount: isset($data['amount']) ? (float) $data['amount'] : null,
            currency: $data['currency'] ?? null,
            ipnCallbackUrl: $data['ipn_callback_url'] ?? null,
            successUrl: $data['success_url'] ?? null,
            cancelUrl: $data['cancel_url'] ?? null,
            partiallyPaidUrl: $data['partially_paid_url'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }
}
