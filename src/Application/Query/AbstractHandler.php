<?php

namespace Amz\Cqrs\Application\Query;

use Amz\Core\Log\InjectLogger;
use Amz\Cqrs\Application\Query\Exception\HandlerInvokeMethodMissingException;
use Amz\Cqrs\Application\Query\Exception\InvalidQueryException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

abstract class AbstractHandler implements Handler
{
    use InjectLogger;

    /**
     * AbstractHandler constructor.
     * @param LoggerInterface|null $logger
     */
    public function __construct(?LoggerInterface $logger = null)
    {
        if (!is_null($logger)) {
            $this->setLogger($logger);
        }
    }

    /**
     * @return string
     */
    abstract public function queryClass(): string;

    /**
     * @param QueryMessage $query
     * @return QueryResult
     */
    abstract public function __invoke($query): QueryResult;

    /**
     * @param QueryMessage $message
     * @return QueryResult
     */
    final public function handle(QueryMessage $message): QueryResult
    {
        // Log starting
        $this->log(
            LogLevel::INFO,
            sprintf('Start processing %s', $message->name()),
            [
                'id' => $message->id(),
                'name' => $message->name(),
                'command' => $message->query()->getArrayCopy(),
                'context' => !is_null($message->context()) ? $message->context()->getArrayCopy() : [],
            ]
        );

        // Check we have the right incoming query class
        $queryClass = $this->queryClass();
        if (!$message->query() instanceof $queryClass) {
            throw InvalidQueryException::withHandlerAndQueryName(
                static::class,
                $queryClass,
                $message->query()
            );
        }

        // Process the query
        try {
            $result = $this($message);
            $this->log(
                LogLevel::INFO,
                sprintf('Done processing %s', $message->name()),
                $result->getArrayCopy([ 'RESULT_INFO_ONLY' => true ])
            );
        } catch (\Throwable $exception) {
            $result = new FailedResult($exception);
            $this->log(
                LogLevel::ERROR,
                sprintf('Error processing %s', $message->name()),
                $result->getArrayCopy()
            );
        }

        // Return the result
        return $result;
    }
}
