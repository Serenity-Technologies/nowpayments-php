<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Sub-partner list response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class SubPartnerListResponse extends BaseResponseDto
{
    /**
     * @param SubPartnerResponse[] $subPartners
     */
    public function __construct(
        public readonly array $subPartners,
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
        $subPartnersData = $data['result'] ?? $data['data'] ?? [];
        $subPartners = array_map(
            fn(array $item) => SubPartnerResponse::fromArray($item),
            is_array($subPartnersData) ? $subPartnersData : []
        );

        return new self(
            subPartners: $subPartners,
            count: $data['count'] ?? $data['total'] ?? null,
        );
    }
}
