<?php

namespace Amz\Cqrs\Application\Query;

use Amz\Core\Exception\ExtractableException;
use Amz\Core\Exception\RuntimeException;
use Amz\Core\Exception\WrappedExtractableException;
use Throwable;
use Iterator;
use ArrayIterator;

class FailedResult implements QueryResult
{
    /** @var ExtractableException */
    protected $exception;

    /** @var Iterator */
    private $iterator;

    public function __construct(Throwable $exception)
    {
        if (!$exception instanceof ExtractableException) {
            $exception = WrappedExtractableException::fromException($exception);
        }
        $this->exception = $exception;
        $this->iterator = new ArrayIterator([]);
    }

    /**
     * @param array $options
     * @return array
     */
    public function getArrayCopy(array $options = []): array
    {
        return [
            'isSuccessfull' => $this->isSuccessful(),
            'currentPage' => $this->currentPage(),
            'numberOfPages' => $this->numberOfPages(),
            'recordsPerPage' => $this->recordsPerPage(),
            'numberOfRecords' => $this->numberOfRecords(),
            'count' => $this->count(),
        ];
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return false;
    }

    /**
     * @return ExtractableException
     */
    public function error(): ExtractableException
    {
        return $this->exception;
    }

    /**
     * @return Iterator
     */
    public function getIterator(): Iterator
    {
        return $this->iterator;
    }

    /**
     * @return int
     */
    public function currentPage(): int
    {
        return 0;
    }

    /**
     * @return int
     */
    public function numberOfPages(): int
    {
        return 0;
    }

    /**
     * @return int
     */
    public function recordsPerPage(): int
    {
        return 0;
    }

    /**
     * @return int
     */
    public function numberOfRecords(): int
    {
        return 0;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return 0;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return false;
    }

    /**
     * @param mixed $offset
     * @return mixed|void
     */
    public function offsetGet($offset)
    {
        throw new RuntimeException('Cannot get records from a failed query result');
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new RuntimeException('Cannot add records on a failed query result');
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        throw new RuntimeException('Cannot unset records on a failed query result');
    }
}
