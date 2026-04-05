<?php

declare(strict_types=1);

namespace SerenityTechnologies\NowPayments\DTOs\Request;

/**
 * Request DTO for authentication.
 *
 * Used for obtaining API tokens via email and password.
 * @author Kwadwo Kyeremeh <kyerematics@gmail.com>
 */
class AuthRequest extends BaseRequestDto
{
    /**
     * @param string $email User email address.
     * @param string $password User password.
     */
    public function __construct(
        private readonly string $email,
        private readonly string $password,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function validate(): bool
    {
        if (trim($this->email) === '') {
            throw new \InvalidArgumentException('email is required.');
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('email must be a valid email address.');
        }

        if (trim($this->password) === '') {
            throw new \InvalidArgumentException('password is required.');
        }

        return true;
    }
}
