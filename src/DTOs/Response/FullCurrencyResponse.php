<?php declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Response;

/**
 * Full currency response DTO.
 */
class FullCurrencyResponse extends BaseResponseDto
{
    /**
     * @param array<int, array{id: int, code: string, name: string, enable: bool, wallet_regex: string, priority: int, extra_id_exists: bool, extra_id_regex: ?string, logo_url: string, track: bool, cg_id: string, is_maxlimit: bool, network: string, smart_contract: ?string, network_precision: int}> $currencies
     */
    public function __construct(
        public readonly array $currencies,
    ) {
    }

    /**
     * Create from array data.
     *
     * @param array{
     *     currencies: array<int, array{id: int, code: string, name: string, enable: bool, wallet_regex: string, priority: int, extra_id_exists: bool, extra_id_regex: ?string, logo_url: string, track: bool, cg_id: string, is_maxlimit: bool, network: string, smart_contract: ?string, network_precision: int}>,
     * } $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self(
            currencies: $data['currencies'],
        );
    }
}
