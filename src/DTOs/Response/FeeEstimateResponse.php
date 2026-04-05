<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fee estimate response DTO.
 */
class FeeEstimateResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $currency,
        public readonly float $fee,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     currency: string,
     *     fee: float,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            currency: $data['currency'],
            fee: (float) $data['fee'],
        );
    }
}
