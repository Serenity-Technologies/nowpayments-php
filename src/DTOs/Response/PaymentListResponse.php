<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Payment list response DTO.
 */
class PaymentListResponse extends BaseResponseDto
{
    /**
     * @param array $data
     * @param int   $limit
     * @param int   $page
     * @param int   $pagesCount
     * @param int   $total
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
     *     data: array,
     *     limit: int,
     *     page: int,
     *     pagesCount: int,
     *     total: int,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            data: $data['data'],
            limit: $data['limit'],
            page: $data['page'],
            pagesCount: $data['pagesCount'],
            total: $data['total'],
        );
    }
}
