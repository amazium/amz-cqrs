<?php

namespace Amz\Cqrs\Application\Query\Exception;

use Amz\Core\Exception\InvalidArgumentException;
use Throwable;

class InvalidQueryException extends InvalidArgumentException
{
    /**
     * @param string $handlerClass
     * @param string $queryClass
     * @param mixed $query
     * @param int $code
     * @param Throwable|null $previous
     * @return InvalidQueryException
     */
    public static function withHandlerAndQueryName(
        string $handlerClass,
        string $queryClass,
        $query,
        int $code = 0,
        Throwable $previous = null
    ): InvalidQueryException {
        return new static(
            sprintf(
                'Handler class %s expects a %s but received %s',
                $handlerClass,
                $queryClass,
                is_object($query) ? get_class($query) : gettype($query)
            ),
            $code,
            $previous
        );
    }
}
