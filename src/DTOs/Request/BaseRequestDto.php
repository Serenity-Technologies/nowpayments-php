<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

use JsonSerializable;

/**
 * Abstract base class for all request DTOs.
 *
 * Provides common functionality for serialization and validation
 * of request data sent to the NOWPayments API.
 */
abstract class BaseRequestDto implements JsonSerializable
{
    /**
     * Convert the DTO to an array suitable for API requests.
     *
     * @return array<string, mixed>
     */
    abstract public function toArray(): array;

    /**
     * Validate the DTO data.
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function validate(): bool
    {
        return true;
    }

    /**
     * Serialize the DTO to JSON-compatible data.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Convert the DTO to JSON string.
     *
     * @return string
     * @throws \JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}
