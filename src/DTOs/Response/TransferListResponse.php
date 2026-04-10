<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Transfer list response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class TransferListResponse extends BaseResponseDto
{
    /**
     * @param TransferResponse[] $transfers
     */
    public function __construct(
        public readonly array $transfers,
        public readonly ?int $count = null,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     result?: array[],
     *     count?: int|null,
     *     data?: array[],
     *     total?: int|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        // Handle both {result: [...], count: N} and {data: [...], total: N} formats
        $transfersData = $data['result'] ?? $data['data'] ?? [];
        $transfers = array_map(
            fn(array $item) => TransferResponse::fromArray($item),
            is_array($transfersData) ? $transfersData : []
        );

        return new self(
            transfers: $transfers,
            count: $data['count'] ?? $data['total'] ?? null,
        );
    }
}
