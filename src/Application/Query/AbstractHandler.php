<?php

namespace Amz\Cqrs\Application\Query;

use Amz\Core\Application\Query\Exception\HandlerInvokeMethodMissingException;
use Amz\Core\Application\Query\Exception\InvalidQueryException;
use Amz\Core\Infrastructure\Log\InjectLogger;
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
        if ($logger) {
            $this->setLogger($logger);
        }
    }

    /**
     * @return string
     */
    abstract public function queryClass(): string;

    /**
     * @param $query
     * @return mixed
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
                'context' => $message->context()->getArrayCopy(),
            ]
        );

        // We need an invoke method
        if (!method_exists([ $this, '__invoke' ])) {
            throw HandlerInvokeMethodMissingException::withHandlerName(static::class);
        }

        // Check we have the right incoming query class
        $queryClass = $this->queryClass();
        if (!$message->query() instanceof $queryClass) {
            throw InvalidQueryException::withHandlerAndQueryName(static::class, $queryClass);
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
