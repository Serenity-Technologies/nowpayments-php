<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Currency response DTO.
 */
class CurrencyResponse extends BaseResponseDto
{
    /**
     * @param array $currencies
     */
    public function __construct(
        public readonly array $currencies,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     currencies: array,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            currencies: $data['currencies'],
        );
    }
}
