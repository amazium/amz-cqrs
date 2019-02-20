<?php

namespace Amz\Cqrs\Application\Command;

use Amz\Core\Contracts\Extractable;
use Amz\Core\Exception\ExtractableException;
use Amz\Core\Exception\WrappedExtractableException;
use DateTime;
use Throwable;

class CommandResult implements Extractable
{
    /** @var CommandMessage */
    private $command;

    /** @var DateTime */
    private $finishedAt;

    private $state;

    private $result;

    private $isError;

    protected function __construct(
        CommandMessage $command,
        string $state,
        array $result,
        bool $isError,
        string $finishedAt = 'now'
    ) {
        $this->command = $command;
        $this->finishedAt = new DateTime($finishedAt);
        $this->state = $state;
        $this->result = $result;
        $this->isError = $isError;
    }

    /**
     * @param CommandMessage $command
     * @param string $state
     * @param array $result
     * @param string $finishedAt
     * @return CommandResult
     */
    public static function fromSuccess(
        CommandMessage $command,
        string $state,
        array $result,
        string $finishedAt = 'now'
    ): CommandResult {
        return new static($command, $state, $result, false, $finishedAt);
    }

    public static function fromException(
        CommandMessage $command,
        Throwable $exception,
        string $state = 'ERROR',
        string $finishedAt = 'now'
    ): CommandResult {
        if (!$exception instanceof ExtractableException) {
            $exception = WrappedExtractableException::fromException($exception);
        }
        return new static($command, $state, [ 'exception' => $exception->getArrayCopy() ], true, $finishedAt);
    }


    /**
     * @param array $options
     * @return array
     */
    public function getArrayCopy(array $options = []): array
    {
        return [
            'id' => $this->command()->id(),
            'finishedAt' => $this->finishedAt()->format('Y-m-d H:i:s'),
            'state' => $this->state(),
            'result' => $this->result(),
            'isError' => $this->isError(),
            'command' => [
                'name' => $this->command->name(),
                'createdAt' => $this->command->createdAt()->format('Y-m-d H:i:s'),
                'command' => $this->command->command()->getArrayCopy($options),
                'context' => $this->command->context()-> getArrayCopy($options),
            ],
        ];
    }

    /**
     * @return CommandMessage
     */
    public function command(): CommandMessage
    {
        return $this->command;
    }

    /**
     * @return DateTime
     */
    public function finishedAt(): DateTime
    {
        return $this->finishedAt;
    }

    /**
     * @return string
     */
    public function state(): string
    {
        return $this->state;
    }

    /**
     * @return array
     */
    public function result(): array
    {
        return $this->result;
    }

    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->isError;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return !$this->isError;
    }

}
