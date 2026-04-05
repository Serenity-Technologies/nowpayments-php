<?php

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\DTOs\Response;

abstract class BaseResponseDto
{
    /**
     * Create DTO from array data.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new static(...$data);
    }

    /**
     * Convert DTO to array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Convert to JSON.
     *
     * @param int $options
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options | JSON_THROW_ON_ERROR);
    }
}
