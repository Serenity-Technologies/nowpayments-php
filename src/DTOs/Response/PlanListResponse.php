<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Plan list response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PlanListResponse extends BaseResponseDto
{
    /**
     * @param PlanResponse[] $plans
     */
    public function __construct(
        public readonly array $plans,
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
        $plansData = $data['result'] ?? $data;
        
        $plans = array_map(
            fn(array $item) => PlanResponse::fromArray($item),
            is_array($plansData) && array_is_list($plansData) ? $plansData : []
        );

        return new self(
            plans: $plans,
            count: $data['count'] ?? ($plansData['count'] ?? null),
        );
    }
}
