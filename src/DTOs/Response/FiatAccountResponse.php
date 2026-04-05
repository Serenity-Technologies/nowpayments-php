<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat account response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class FiatAccountResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $partnerId,
        public readonly string $provider,
        public readonly string $fiatCurrencyCode,
        public readonly string $countryCode,
        public readonly string $providerAccountId,
        public readonly array $providerAccountInfo,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id: string,
     *     partnerId: string,
     *     provider: string,
     *     fiatCurrencyCode: string,
     *     countryCode: string,
     *     providerAccountId: string,
     *     providerAccountInfo: array,
     *     createdAt: string,
     *     updatedAt: string,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'],
            partnerId: $data['partnerId'],
            provider: $data['provider'],
            fiatCurrencyCode: $data['fiatCurrencyCode'],
            countryCode: $data['countryCode'],
            providerAccountId: $data['providerAccountId'],
            providerAccountInfo: $data['providerAccountInfo'],
            createdAt: $data['createdAt'],
            updatedAt: $data['updatedAt'],
        );
    }
}
