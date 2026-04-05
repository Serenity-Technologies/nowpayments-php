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
        $transfers = array_map(
            fn(array $item) => TransferResponse::fromArray($item),
            $data['data'] ?? []
        );

        return new self(
            transfers: $transfers,
            total: $data['total'] ?? null,
            next: $data['next'] ?? null,
        );
    }
}
