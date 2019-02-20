<?php

namespace Amz\Cqrs\Application\Command\Exception;

use Amz\Core\Exception\InvalidArgumentException;
use Throwable;

class InvalidCommandException extends InvalidArgumentException
{
    public static function withHandlerAndCommandName(
        string $handlerClass,
        string $commandClass,
        $command,
        int $code = 0,
        Throwable $previous = null
    ): InvalidCommandException {
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
