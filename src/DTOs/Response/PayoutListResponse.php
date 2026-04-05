<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Paginated payout list response DTO.
 */
class PayoutListResponse extends BaseResponseDto
{
    /**
     * @param array<int, array> $payouts
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
     * @param array{payouts?: array, total?: int|null, page?: int|null} $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            payouts: $data['payouts'] ?? $data['data'] ?? [],
            total: isset($data['total']) ? (int) $data['total'] : null,
            page: isset($data['page']) ? (int) $data['page'] : null,
        );
    }
}
