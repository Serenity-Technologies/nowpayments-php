<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat providers response DTO.
 */
class FiatProvidersResponse extends BaseResponseDto
{
    /**
     * @param FiatProviderResponse[] $providers
     */
    public function __construct(
        public readonly array $providers,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     data?: array[],
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        $providers = array_map(
            fn(array $item) => FiatProviderResponse::fromArray($item),
            $data['data'] ?? $data
        );

        return new self(
            providers: $providers,
        );
    }
}
