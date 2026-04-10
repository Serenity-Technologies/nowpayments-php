<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Payment list response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class PaymentListResponse extends BaseResponseDto
{
    /**
     * @param PaymentResponse[] $data
     * @param int $limit
     * @param int $page
     * @param int $pagesCount
     * @param int $total
     */
    public function __construct(
        public readonly array $data,
        public readonly int $limit,
        public readonly int $page,
        public readonly int $pagesCount,
        public readonly int $total,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     data: array[],
     *     limit: int,
     *     page: int,
     *     pagesCount: int,
     *     total: int,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        $payments = array_map(
            fn(array $item) => PaymentResponse::fromArray($item),
            $data['data'] ?? []
        );

        return new self(
            data: $payments,
            limit: $data['limit'] ?? 0,
            page: $data['page'] ?? 0,
            pagesCount: $data['pagesCount'] ?? 0,
            total: $data['total'] ?? 0,
        );
    }
}
