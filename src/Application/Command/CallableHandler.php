<?php

namespace Amz\Cqrs\Application\Command;

use Amz\Core\Log\InjectLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class CallableHandler implements Handler
{
    use InjectLogger;

    /** @var callable */
    private $handler;

    /**
     * CallableHandler constructor.
     * @param callable $handler
     * @param LoggerInterface|null $logger
     */
    public function __construct(callable $handler, ?LoggerInterface $logger)
    {
        $this->handler = $handler;
        if ($logger) {
            $this->setLogger($logger);
        }
    }

    /**
     * @param CommandMessage $message
     * @return CommandResult
     */
    final public function handle(CommandMessage $message): CommandResult
    {
        // Log starting
        $this->log(
            LogLevel::INFO,
            sprintf('Start processing %s', $message->name()),
            [
                'id' => $message->id(),
                'name' => $message->name(),
                'command' => $message->command()->getArrayCopy(),
                'context' => !is_null($message->context()) ? $message->context()->getArrayCopy() : [],
            ]
        );

        // Process the command
        try {
            $handler = $this->handler;
            $result = $handler($message->command(), $message->context());
            $this->log(
                LogLevel::INFO,
                sprintf('Done processing %s', $message->name()),
                $result->getArrayCopy()
            );
        } catch (\Throwable $exception) {
            $result = CommandResult::fromException($message, $exception);
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
