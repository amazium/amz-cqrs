<?php

namespace Amz\Cqrs\Domain\ValueObject\Exception;

use Amz\Core\Exception\InvalidArgumentException;
use Throwable;

class InvalidValueForPasswordException extends InvalidArgumentException
{
    public static function withValue(
        string $valueObjectClass,
        array $failedRules,
        $value,
        int $code = 0,
        Throwable $previous = null
    ): InvalidValueForEnumException {
        $message = sprintf(
            '%s expects a valid password, but "%s" did not adhere to the rules [ %s ]',
            $valueObjectClass,
            $value,
            implode($failedRules)
        );
        return new static($message, $code, $previous);
    }
}
