<?php

namespace Amz\Cqrs\Infrastructure\Repository\Db;

interface Connection
{
    /**
     * @param string $table
     * @param array $where
     * @param string|array   $columns
     * @return array
     */
    public function fetchOne(string $table, array $where, $columns = '*'): array;

    /**
     * @param string $table
     * @param array $where
     * @param string $columns
     * @param int $start
     * @param int $limit
     * @return array
     */
    public function fetchAll(string $table, array $where, $columns = '*', int $start = 0, int $limit = 0): array;

    /**
     * @param string $table
     * @param string $id
     * @param string|array $columns
     * @return array
     */
    public function fetchById(string $table, string $id, $columns = '*'): array;

    /**
     * @param string $table
     * @param int $internalId
     * @param string|array $columns
     * @return array
     */
    public function fetchByInternalId(string $table, int $internalId, $columns = '*'): array;

    /**
     * @param string $table
     * @param array $values
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
