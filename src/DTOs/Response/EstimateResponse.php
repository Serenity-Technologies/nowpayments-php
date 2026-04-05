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
        public readonly string $currency_to,
        public readonly float $estimated_amount,
        public readonly bool $is_fixed_rate,
        public readonly bool $is_fee_paid_by_user,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     currency_from: string,
     *     currency_to: string,
     *     estimated_amount: float,
     *     is_fixed_rate: bool,
     *     is_fee_paid_by_user: bool,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            currency_from: $data['currency_from'],
            currency_to: $data['currency_to'],
            estimated_amount: (float) $data['estimated_amount'],
            is_fixed_rate: (bool) $data['is_fixed_rate'],
            is_fee_paid_by_user: (bool) $data['is_fee_paid_by_user'],
        );
    }
}
