<?php

namespace Amz\Cqrs\Application\Command\Exception;

use Amz\Core\Exception\LogicException;
use Throwable;

class HandlerInvokeMethodMissingException extends LogicException
{
    /**
     * @param string $handlerClass
     * @param int $code
     * @param Throwable|null $previous
     * @return HandlerInvokeMethodMissingException
     */
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
