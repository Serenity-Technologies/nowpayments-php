<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Estimate response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class EstimateResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $currency_from,
        public readonly float $amount_from,
        public readonly string $currency_to,
        public readonly float $estimated_amount,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     currency_from: string,
     *     amount_from: float|string,
     *     currency_to: string,
     *     estimated_amount: float|string,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            currency_from: $data['currency_from'],
            amount_from: (float) $data['amount_from'],
            currency_to: $data['currency_to'],
            estimated_amount: (float) $data['estimated_amount'],
        );
    }
}
