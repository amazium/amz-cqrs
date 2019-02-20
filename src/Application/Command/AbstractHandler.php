<?php

namespace Amz\Cqrs\Application\Command;

use Amz\Cqrs\Application\Command\Exception\HandlerInvokeMethodMissingException;
use Amz\Cqrs\Application\Command\Exception\InvalidCommandException;
use Amz\Core\Log\InjectLogger;
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
    abstract public function commandClass(): string;

    /**
     * @param CommandMessage $command
     * @return CommandResult
     */
    abstract public function __invoke($command): CommandResult;

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

        // Check we have the right incoming command class
        $commandClass = $this->commandClass();
        if (!$message->command() instanceof $commandClass) {
            throw InvalidCommandException::withHandlerAndCommandName(
                static::class,
                $commandClass,
                $message->command()
            );
        }

        // Process the command
        try {
            $result = $this($message);
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
