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
        $conversions = array_map(
            fn(array $item) => ConversionResponse::fromArray($item),
            $data['data'] ?? []
        );

        return new self(
            conversions: $conversions,
            total: $data['total'] ?? null,
            next: $data['next'] ?? null,
        );
    }
}
