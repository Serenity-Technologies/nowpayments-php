<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Minimum withdrawal amount response DTO.
 */
class MinWithdrawalAmountResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $currency,
        public readonly float $min_amount,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     currency: string,
     *     min_amount: float,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            currency: $data['currency'],
            min_amount: (float) $data['min_amount'],
        );
    }
}
