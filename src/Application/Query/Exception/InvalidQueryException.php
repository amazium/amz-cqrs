<?php

namespace Amz\Cqrs\Application\Query\Exception;

use Amz\Core\Exception\InvalidArgumentException;
use Throwable;

class InvalidQueryException extends InvalidArgumentException
{
    public static function withHandlerAndQueryName(
        string $handlerClass,
        string $commandClass,
        $command,
        int $code = 0,
        Throwable $previous = null
    ): InvalidQueryException {
        return new static(
            sprintf(
                'Handler %s is missing an __invoke method',
                $handlerClass,
                $commandClass,
                is_object($command) ? get_class($command) : gettype($command)
            ),
            $code,
            $previous
        );
    }
}
