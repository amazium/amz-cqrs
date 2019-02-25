<?php

namespace Amz\Cqrs\Domain\ValueObject\Exception;

use Amz\Core\Exception\InvalidArgumentException;
use Throwable;

class InvalidValueForEmailException extends InvalidArgumentException
{
    public static function withValue(
        string $valueObjectClass,
        $value,
        int $code = 0,
        Throwable $previous = null
    ): InvalidValueForEnumException {
        $message = sprintf(
            '%s expects a valid email, but received "%s"',
            $valueObjectClass,
            $value
        );
        return new static($message, $code, $previous);
    }
}
