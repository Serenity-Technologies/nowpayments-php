<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Minimum amount response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class MinAmountResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $currency_from,
        public readonly string $currency_to,
        public readonly float $min_amount,
        public readonly ?float $fiat_equivalent,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     currency_from: string,
     *     currency_to: string,
     *     min_amount: float,
     *     fiat_equivalent?: float|null,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            currency_from: $data['currency_from'],
            currency_to: $data['currency_to'],
            min_amount: (float) $data['min_amount'],
            fiat_equivalent: isset($data['fiat_equivalent']) ? (float) $data['fiat_equivalent'] : null,
        );
    }
}
