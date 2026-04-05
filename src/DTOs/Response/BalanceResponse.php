<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Balance response DTO.
 */
class BalanceResponse extends BaseResponseDto
{
    /**
     * @param array<string, array{amount: float, pendingAmount: float}> $balances
     */
    public function __construct(
        public readonly array $balances,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     balances: array<string, array{amount: float, pendingAmount: float}>,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        $balances = [];
        foreach ($data['balances'] as $currency => $balance) {
            $balances[$currency] = [
                'amount' => isset($balance['amount']) ? (float) $balance['amount'] : 0.0,
                'pendingAmount' => isset($balance['pendingAmount']) ? (float) $balance['pendingAmount'] : 0.0,
            ];
        }

        return new self(
            balances: $balances,
        );
    }
}
