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
        $subPartners = array_map(
            fn(array $item) => SubPartnerResponse::fromArray($item),
            $data['data'] ?? []
        );

        return new self(
            subPartners: $subPartners,
            total: $data['total'] ?? null,
            next: $data['next'] ?? null,
        );
    }
}
