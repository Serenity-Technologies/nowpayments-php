<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat currency response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class FiatCurrencyResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $provider,
        public readonly string $currencyCode,
        public readonly bool $enabled,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     provider: string,
     *     currencyCode: string,
     *     enabled: bool,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            provider: $data['provider'],
            currencyCode: $data['currencyCode'],
            enabled: $data['enabled'],
        );
    }
}
