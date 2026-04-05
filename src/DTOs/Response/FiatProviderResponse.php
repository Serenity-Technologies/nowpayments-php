<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat provider response DTO.
 */
class FiatProviderResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly bool $enabled,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     code: string,
     *     name: string,
     *     enabled: bool,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            code: $data['code'],
            name: $data['name'],
            enabled: $data['enabled'],
        );
    }
}
