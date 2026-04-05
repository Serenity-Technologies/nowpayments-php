<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fee response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class FeeResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $currency,
        public readonly float $depositFee,
        public readonly float $withdrawalFee,
        public readonly float $serviceFee,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     currency: string,
     *     depositFee: float,
     *     withdrawalFee: float,
     *     serviceFee: float,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            currency: $data['currency'],
            depositFee: (float) $data['depositFee'],
            withdrawalFee: (float) $data['withdrawalFee'],
            serviceFee: (float) $data['serviceFee'],
        );
    }
}
