<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Subscription list response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubscriptionListResponse extends BaseResponseDto
{
    /**
     * @param SubscriptionResponse[] $subscriptions
     */
    public function __construct(
        public readonly array $subscriptions,
        public readonly ?int $count,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     result?: array[],
     *     count?: int|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        // Unwrap result if present
        $subscriptionsData = $data['result'] ?? $data;
        
        $subscriptions = array_map(
            fn(array $item) => SubscriptionResponse::fromArray($item),
            is_array($subscriptionsData) ? $subscriptionsData : []
        );

        return new self(
            subscriptions: $subscriptions,
            count: $data['count'] ?? null,
        );
    }
}
