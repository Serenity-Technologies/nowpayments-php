<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Plan list response DTO.
 */
class PlanListResponse extends BaseResponseDto
{
    /**
     * @param PlanResponse[] $plans
     */
    public function __construct(
        public readonly array $plans,
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
        $plans = array_map(
            fn(array $item) => PlanResponse::fromArray($item),
            $data['data'] ?? []
        );

        return new self(
            plans: $plans,
            total: $data['total'] ?? null,
            next: $data['next'] ?? null,
        );
    }
}
