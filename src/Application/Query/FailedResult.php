<?php

namespace Amz\Cqrs\Application\Query;

use Amz\Core\Exception\ExtractableException;
use Amz\Core\Exception\RuntimeException;
use Amz\Core\Exception\WrappedExtractableException;
use Throwable;

class FailedResult implements QueryResult
{
    protected $exception;

    public function __construct(Throwable $exception)
    {
        if (!$exception instanceof ExtractableException) {
            $exception = WrappedExtractableException::fromException($exception);
        }
        $this->exception = $exception;
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

    public function currentPage(): int
    {
        return 0;
    }

    public function numberOfPages(): int
    {
        return 0;
    }

    public function recordsPerPage(): int
    {
        return 0;
    }

    public function numberOfRecords(): int
    {
        return 0;
    }

    public function count(): int
    {
        return 0;
    }

    public function current()
    {
        return null;
    }

    public function next()
    {
        throw new RuntimeException('Cannot iterate records on a failed query result');
    }

    public function key()
    {
        return null;
    }

    public function valid()
    {
        return false;
    }

    public function rewind()
    {
        throw new RuntimeException('Cannot iterate records on a failed query result');
    }

    public function offsetExists($offset)
    {
        return false;
    }

    public function offsetGet($offset)
    {
        throw new RuntimeException('Cannot get records from a failed query result');
    }

    public function offsetSet($offset, $value)
    {
        throw new RuntimeException('Cannot add records on a failed query result');
    }

    public function offsetUnset($offset)
    {
        throw new RuntimeException('Cannot unset records on a failed query result');
    }

}