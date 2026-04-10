<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Conversion list response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class ConversionListResponse extends BaseResponseDto
{
    /**
     * @param ConversionResponse[] $conversions
     */
    public function __construct(
        public readonly array $conversions,
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
        $conversionsData = $data['result'] ?? $data['data'] ?? [];
        $conversions = array_map(
            fn(array $item) => ConversionResponse::fromArray($item),
            is_array($conversionsData) ? $conversionsData : []
        );

        return new self(
            conversions: $conversions,
            count: $data['count'] ?? $data['total'] ?? null,
        );
    }
}
