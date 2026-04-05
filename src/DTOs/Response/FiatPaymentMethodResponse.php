<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat payment method response DTO.
 */
class FiatPaymentMethodResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $paymentCode,
        public readonly array $fields,
        public readonly string $provider,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     name: string,
     *     paymentCode: string,
     *     fields: array,
     *     provider: string,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            name: $data['name'],
            paymentCode: $data['paymentCode'],
            fields: $data['fields'],
            provider: $data['provider'],
        );
    }
}
