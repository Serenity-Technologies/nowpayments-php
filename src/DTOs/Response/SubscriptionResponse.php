<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Subscription response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubscriptionResponse extends BaseResponseDto
{
    /**
     * @param SubscriberInfo|null $subscriber Subscriber information
     */
    public function __construct(
        public readonly ?string $id,
        public readonly string|int|null $subscriptionPlanId,
        public readonly ?bool $isActive,
        public readonly ?string $status,
        public readonly ?string $expireDate,
        public readonly ?SubscriberInfo $subscriber,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id?: string|null,
     *     subscription_plan_id?: string|int|null,
     *     is_active?: bool|null,
     *     status?: string|null,
     *     expire_date?: string|null,
     *     subscriber?: array{email?: string|null}|null,
     *     created_at?: string|null,
     *     updated_at?: string|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'] ?? null,
            subscriptionPlanId: $data['subscription_plan_id'] ?? null,
            isActive: $data['is_active'] ?? null,
            status: $data['status'] ?? null,
            expireDate: $data['expire_date'] ?? null,
            subscriber: isset($data['subscriber']) ? SubscriberInfo::fromArray($data['subscriber']) : null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }
}
