<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat crypto currency response DTO.
 */
class FiatCryptoCurrencyResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $provider,
        public readonly string $currencyCode,
        public readonly string $currencyNetwork,
        public readonly bool $enabled,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{provider: string, currencyCode: string, currencyNetwork: string, enabled: bool} $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            provider: $data['provider'],
            currencyCode: $data['currencyCode'],
            currencyNetwork: $data['currencyNetwork'],
            enabled: (bool) ($data['enabled'] ?? false),
        );
    }
}
