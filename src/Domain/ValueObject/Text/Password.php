<?php

namespace Amz\Cqrs\Domain\ValueObject\Text;

use Amz\Cqrs\Domain\ValueObject\Exception\InvalidValueForEmailException;
use Amz\Cqrs\Domain\ValueObject\Exception\InvalidValueForPasswordException;
use Amz\Cqrs\Domain\ValueObject\TextValue;

class Password extends TextValue
{
    /**
     * Email constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->validatePassword($value);
        parent::__construct($value);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        $failedRules = [];
        if (!preg_match('/[a-z]/', $password)) {
            $failedRules[] = 'REQUIRES_LOWER_CASE';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $failedRules[] = 'REQUIRES_UPPER_CASE';
        }
        if (!preg_match('/\d/', $password)) {
            $failedRules[] = 'REQUIRES_DIGIT';
        }
        if (mb_strlen($password) < 8) {
            $failedRules[] = 'TOO_SHORT';
        }

        if (count($failedRules) > 0) {
            throw InvalidValueForPasswordException::withValue(
                static::class,
                $failedRules,
                $password
            );
        }
        return true;
    }
}
