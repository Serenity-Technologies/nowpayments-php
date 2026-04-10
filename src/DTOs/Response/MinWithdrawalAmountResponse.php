<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Minimum withdrawal amount response DTO.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class MinWithdrawalAmountResponse extends BaseResponseDto
{
    public function __construct(
        public readonly bool $success,
        public readonly float $result,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     success?: bool,
     *     result?: float,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            success: $data['success'] ?? true,
            result: isset($data['result']) ? (float) $data['result'] : 0.0,
        );
    }
}
