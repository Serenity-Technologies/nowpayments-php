<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Fiat payout response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class FiatPayoutResponse extends BaseResponseDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $provider,
        public readonly string $requestId,
        public readonly string $status,
        public readonly string $fiatCurrencyCode,
        public readonly float $fiatAmount,
        public readonly string $cryptoCurrencyCode,
        public readonly float $cryptoCurrencyAmount,
        public readonly string $fiatAccountCode,
        public readonly string $fiatAccountNumber,
        public readonly ?string $payoutDescription,
        public readonly ?string $error,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     id: string,
     *     provider: string,
     *     requestId: string,
     *     status: string,
     *     fiatCurrencyCode: string,
     *     fiatAmount: float,
     *     cryptoCurrencyCode: string,
     *     cryptoCurrencyAmount: float,
     *     fiatAccountCode: string,
     *     fiatAccountNumber: string,
     *     payoutDescription?: string|null,
     *     error?: string|null,
     *     createdAt: string,
     *     updatedAt: string,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            id: $data['id'],
            provider: $data['provider'],
            requestId: $data['requestId'],
            status: $data['status'],
            fiatCurrencyCode: $data['fiatCurrencyCode'],
            fiatAmount: $data['fiatAmount'],
            cryptoCurrencyCode: $data['cryptoCurrencyCode'],
            cryptoCurrencyAmount: $data['cryptoCurrencyAmount'],
            fiatAccountCode: $data['fiatAccountCode'],
            fiatAccountNumber: $data['fiatAccountNumber'],
            payoutDescription: $data['payoutDescription'] ?? null,
            error: $data['error'] ?? null,
            createdAt: $data['createdAt'],
            updatedAt: $data['updatedAt'],
        );
    }
}
