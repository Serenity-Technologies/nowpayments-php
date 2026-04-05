<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat currencies response DTO.
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
     *     data?: array[],
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        $currencies = array_map(
            fn(array $item) => FiatCurrencyResponse::fromArray($item),
            $data['data'] ?? $data
        );

        return new self(
            currencies: $currencies,
        );
    }
}
