<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Subscription list response DTO.
 */
class SubscriptionListResponse extends BaseResponseDto
{
    /**
     * @param SubscriptionResponse[] $subscriptions
     */
    public function __construct(
        public readonly array $subscriptions,
        public readonly ?int $total,
        public readonly ?string $next,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     data?: array[],
     *     total?: int|null,
     *     next?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        $subscriptions = array_map(
            fn(array $item) => SubscriptionResponse::fromArray($item),
            $data['data'] ?? []
        );

        return new self(
            subscriptions: $subscriptions,
            total: $data['total'] ?? null,
            next: $data['next'] ?? null,
        );
    }
}
