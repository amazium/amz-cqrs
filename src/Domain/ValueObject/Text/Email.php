<?php

namespace Amz\Cqrs\Domain\ValueObject\Text;

use Amz\Cqrs\Domain\ValueObject\Exception\InvalidValueForEmailException;
use Amz\Cqrs\Domain\ValueObject\TextValue;

class Email extends TextValue
{
    /**
     * Email constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->validateEmail($value);
        parent::__construct($value);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function validateEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw InvalidValueForEmailException::withValue(static::class, $email);
        }
        return true;
    }
}
