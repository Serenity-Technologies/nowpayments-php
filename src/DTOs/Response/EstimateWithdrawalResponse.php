<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Estimate withdrawal response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class EstimateWithdrawalResponse extends BaseResponseDto
{
    public function __construct(
        public readonly float $amount,
        public readonly string $currency,
        public readonly float $fee,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     amount: float,
     *     currency: string,
     *     fee: float,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            amount: $data['amount'],
            currency: $data['currency'],
            fee: $data['fee'],
        );
    }
}
