<?php

namespace Amz\Cqrs\Application\Query;

use Amz\Core\Application\AbstractMessage;

class QueryMessage extends AbstractMessage
{
    /**
     * QueryMessage constructor.
     * @param Query $query
     * @param string|null $id
     * @param string $createdAt
     */
    public function __construct(Query $query, string $id = null, string $createdAt = 'now')
    {
        parent::__construct($query, $id, $createdAt);
    }

    /**
     * @return Query
     */
    public function query(): Query
    {
        return $this->payload;
    }
}
