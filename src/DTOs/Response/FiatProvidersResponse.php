<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat providers response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
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
     *     result?: array[],
     *     data?: array[],
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        // Unwrap result if present (fiat endpoints wrap in 'result')
        $providersData = $data['result'] ?? $data['data'] ?? $data;
        
        $providers = array_map(
            fn(array $item) => FiatProviderResponse::fromArray($item),
            is_array($providersData) && array_is_list($providersData) ? $providersData : []
        );

        return new self(
            providers: $providers,
        );
    }
}
