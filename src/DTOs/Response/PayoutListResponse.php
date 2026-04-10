<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Paginated payout list response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PayoutListResponse extends BaseResponseDto
{
    /**
     * @param PayoutStatusResponse[] $payouts
     */
    public function __construct(
        public readonly array $payouts,
        public readonly ?int $total = null,
        public readonly ?int $page = null,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{payouts?: array[], total?: int|null, page?: int|null, data?: array[]} $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        $payoutsData = $data['payouts'] ?? $data['data'] ?? [];
        $payouts = array_map(
            fn(array $item) => PayoutStatusResponse::fromArray($item),
            is_array($payoutsData) ? $payoutsData : []
        );

        return new self(
            payouts: $payouts,
            total: isset($data['total']) ? (int) $data['total'] : null,
            page: isset($data['page']) ? (int) $data['page'] : null,
        );
    }
}
