<?php

namespace Amz\Cqrs\Application\Command\Exception;

use Amz\Core\Exception\InvalidArgumentException;
use Throwable;

class InvalidCommandException extends InvalidArgumentException
{
    /**
     * @param string $handlerClass
     * @param string $commandClass
     * @param mixed $command
     * @param int $code
     * @param Throwable|null $previous
     * @return InvalidCommandException
     */
    public static function withHandlerAndCommandName(
        string $handlerClass,
        string $commandClass,
        $command,
        int $code = 0,
        Throwable $previous = null
    ): InvalidCommandException {
        return new static(
            sprintf(
                'Handler class %s expects a %s but received %s',
                $handlerClass,
                $commandClass,
                is_object($command) ? get_class($command) : gettype($command)
            ),
            $code,
            $previous
        );
    }
}
