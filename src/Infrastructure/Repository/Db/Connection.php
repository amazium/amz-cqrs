<?php

namespace Amz\Cqrs\Infrastructure\Repository\Db;

interface Connection
{
    /**
     * @param string $table
     * @param array $values
     * @param array $columns
     * @return int
     */
    public function insert(string $table, array $values): int;

    /**
     * @param string $table
     * @param array $data
     * @param array $where
     * @return int
     */
    public function update(string $table, array $data, array $where): int;
}
