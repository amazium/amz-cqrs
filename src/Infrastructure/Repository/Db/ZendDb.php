<?php

namespace Amz\Cqrs\Infrastructure\Repository\Db;

use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\SqlInterface;
use Zend\Stdlib\ArrayUtils;

class ZendDb implements Connection
{
    /**
     * @var Sql
     */
    private $sql;

    /**
     * ZendDb constructor.
     * @param Sql $sql
     */
    public function __construct(Sql $sql)
    {
        $this->sql = $sql;
    }

    /**
     * @param string $table
     * @param array $where
     * @param string $columns
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function fetchAll(string $table, array $where, $columns = '*', int $offset = 0, int $limit = 0): array
    {
        $query = $this->sql->select($table)
                           ->where($where)
                           ->columns($columns);
        if ($offset > 0) {
            $query->offset($offset);
        }
        if ($limit > 0) {
            $query->limit($limit);
        }

        $result = $this->query($query);
        if (!($result instanceof ResultInterface && $result->count() > 0)) {
            return [];
        }
        return ArrayUtils::iteratorToArray($result, true);
    }

    /**
     * @param string $table
     * @param array $where
     * @param string $columns
     * @return array
     */
    public function fetchOne(string $table, array $where, $columns = '*'): array
    {
        $records = $this->fetchAll($table, $where, $columns, 0, 1);
        if (!empty($records)) {
            return $records[0];
        }
        return false;
    }

    /**
     * @param string $table
     * @param string $id
     * @param string $columns
     * @return array
     */
    public function fetchById(string $table, string $id, $columns = '*'): array
    {
        return $this->fetchOne($table, [ 'uuid' => $id ], $columns);
    }

    /**
     * @param string $table
     * @param int $internalId
     * @param string $columns
     * @return array
     */
    public function fetchByInternalId(string $table, int $internalId, $columns = '*'): array
    {
        return $this->fetchOne($table, [ 'id' => $internalId ], $columns);
    }

    /**
     * @param string $table
     * @param array $values
     * @return int
     */
    public function insert(string $table, array $values): int
    {
        $query = $this->sql
            ->insert($table)
            ->columns(array_keys($values))
            ->values(array_values($values));
        $result = $this->query($query);
        return $result->getGeneratedValue();
    }

    /**
     * @param string $table
     * @param array $data
     * @param array $where
     * @return int
     */
    public function update(string $table, array $data, array $where): int
    {
        $query = $this->sql
            ->update($table)
            ->set($data)
            ->where($where);
        $result = $this->query($query);
        return $result->getAffectedRows();
    }

    /**
     * @param SqlInterface $query
     * @return ResultInterface
     */
    protected function query(SqlInterface $query): ResultInterface
    {
        $statement = $this->sql->prepareStatementForSqlObject($query);
        return $statement->execute();
    }
}
