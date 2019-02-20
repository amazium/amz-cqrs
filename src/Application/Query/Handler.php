<?php

namespace Amz\Cqrs\Application\Query;

interface Handler
{
    /**
     * @param QueryMessage $message
     * @return QueryResult
     */
    public function handle(QueryMessage $message): QueryResult;
}