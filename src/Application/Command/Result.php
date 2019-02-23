<?php

/**
 * Amazium : Genesis
 *
 * Author: Jeroen Keppens <jeroen.keppens@amazium.eu>
 *
 * Copyright Amazium OOD, 2019
 */

namespace Amz\Cqrs\Application\Command;

use Amz\Core\Contracts\Extractable;
use Amz\Core\Exception\ExtractableException;
use Amz\Core\Exception\WrappedExtractableException;
use DateTime;
use Throwable;

class Result
{
    /** @var Extractable */
    private $payload;

    /** @var DateTime */
    private $finishedAt;

    /** @var string */
    private $state;

    /** @var array */
    private $result;

    /** @var bool */
    private $isError;

    protected function __construct(
        Extractable $payload,
        string $state,
        array $result,
        bool $isError,
        string $finishedAt = 'now'
    ) {
        $this->payload = $payload;
        $this->finishedAt = new DateTime($finishedAt);
        $this->state = $state;
        $this->result = $result;
        $this->isError = $isError;
    }

    /**
     * @param Command $command
     * @param string $state
     * @param array $result
     * @param string $finishedAt
     * @return CommandMessageResult
     */
    public static function fromSuccess(
        Extractable $payload,
        string $state,
        array $result,
        string $finishedAt = 'now'
    ): Result {
        return new static($payload, $state, $result, false, $finishedAt);
    }

    /**
     * @param Extractable $payload
     * @param Throwable $exception
     * @param string $state
     * @param string $finishedAt
     * @return Result
     */
    public static function fromException(
        Extractable $payload,
        Throwable $exception,
        string $state = 'ERROR',
        string $finishedAt = 'now'
    ): Result {
        if (!$exception instanceof ExtractableException) {
            $exception = WrappedExtractableException::fromException($exception);
        }
        return new static(
            $payload,
            $state,
            [ 'exception' => $exception->getArrayCopy() ],
            true,
            $finishedAt
        );
    }

    /**
     * @param array $options
     * @return array
     */
    public function getArrayCopy(array $options = []): array
    {
        return [
            'finishedAt' => $this->finishedAt()->format('Y-m-d H:i:s'),
            'state' => $this->state(),
            'result' => $this->result(),
            'isError' => $this->isError(),
            'request' => $this->payload()->getArrayCopy($options),
        ];
    }

    /**
     * @return Extractable
     */
    public function payload(): Extractable
    {
        return $this->payload;
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