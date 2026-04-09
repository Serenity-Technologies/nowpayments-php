<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat currencies response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class FiatCurrenciesResponse extends BaseResponseDto
{
    /**
     * @param FiatCurrencyResponse[] $currencies
     */
    public function __construct(
        public readonly array $currencies,
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
        $currenciesData = $data['result'] ?? $data['data'] ?? null;
        
        $currencies = array_map(
            fn(array $item) => FiatCurrencyResponse::fromArray($item),
            is_array($currenciesData) && array_is_list($currenciesData) ? $currenciesData : []
        );

        return new self(
            currencies: $currencies,
        );
    }
}
