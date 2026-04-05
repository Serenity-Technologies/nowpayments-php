<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat payment methods list response DTO.
 */
class FiatPaymentMethodsResponse extends BaseResponseDto
{
    /**
     * @var array<int, array>
     */
    public function __construct(
        public readonly array $result,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     result: array<int, array>,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            result: $data['result'],
        );
    }
}
