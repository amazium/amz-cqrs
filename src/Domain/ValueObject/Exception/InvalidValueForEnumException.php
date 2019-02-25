<?php

namespace Amz\Cqrs\Domain\ValueObject\Exception;

use Amz\Core\Exception\InvalidArgumentException;
use Throwable;

class InvalidValueForEnumException extends InvalidArgumentException
{
    public static function withValue(
        string $valueObjectClass,
        array $expectedValues,
        $value,
        int $code = 0,
        Throwable $previous = null
    ): InvalidValueForEnumException {
        $message = sprintf(
            '%s expects one of [ %s ] but received "%s"',
            $valueObjectClass,
            implode(', ', $expectedValues),
            $value
        );
        return new static($message, $code, $previous);
    }
}
