<?php

namespace Amz\Cqrs\Application\Query\Exception;

use Amz\Core\Exception\LogicException;
use Throwable;

class HandlerInvokeMethodMissingException extends LogicException
{
    public static function withHandlerName(
        string $handlerClass,
        int $code = 0,
        Throwable $previous = null
    ): HandlerInvokeMethodMissingException {
        return new static(
            sprintf('Handler %s is missing an __invoke method', $handlerClass),
            $code,
            $previous
        );
    }
}
