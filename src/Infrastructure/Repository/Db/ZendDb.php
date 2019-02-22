<?php

namespace Amz\Cqrs\Infrastructure\Repository\Db;

use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\SqlInterface;

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
