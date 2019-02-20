<?php

namespace Amz\Cqrs\Application\Query;

use ArrayAccess;
use Iterator;
use Countable;

interface QueryResult extends ArrayAccess, Iterator, Countable
{
    /**
     * Current page number
     *
     * @return int
     */
    public function currentPage(): int;

    /**
     * Total number of pages
     *
     * @return int
     */
    public function numberOfPages(): int;

    /**
     * Number of records per page
     *
     * @return int
     */
    public function recordsPerPage(): int;
    /**
     * Number of records in this record set
     *
     * @return int
     */
    public function numberOfRecords(): int;

    /**
     * Number of records in the current page
     *
     * @return int
     */
    public function count(): int;

    /**
     * @return bool
     */
    public function isSuccessful(): bool;
}