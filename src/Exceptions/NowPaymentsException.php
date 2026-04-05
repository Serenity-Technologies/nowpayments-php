<?php

/**
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
namespace SerenityTechnologies\NowPayments\Exceptions;

use Exception;

class NowPaymentsException extends Exception
{
    /**
     * Create exception from API response.
     */
    public static function fromResponse(string $message, int $code = 0): self
    {
        return new self($message, $code);
    }

    /**
     * Create authentication exception.
     */
    public static function authenticationFailed(string $message = 'Authentication failed'): self
    {
        return new self($message, 401);
    }

    /**
     * Create validation exception.
     */
    public static function validationFailed(string $message = 'Validation failed'): self
    {
        return new self($message, 422);
    }

    /**
     * Create rate limit exception.
     */
    public static function rateLimitExceeded(string $message = 'Rate limit exceeded'): self
    {
        return new self($message, 429);
    }

    /**
     * Create server error exception.
     */
    public static function serverError(string $message = 'Server error occurred'): self
    {
        return new self($message, 500);
    }

    /**
     * Create IPN signature validation exception.
     */
    public static function invalidSignature(string $message = 'Invalid IPN signature'): self
    {
        return new self($message, 403);
    }
}
