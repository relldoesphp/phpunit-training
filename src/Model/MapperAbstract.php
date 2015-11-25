<?php
namespace In2it\Phpunit\Model;

abstract class MapperAbstract
{
    /**
     * @var \PDO The PHP Data Object
     */
    protected $pdo;
    /**
     * @var string The name of the table
     */
    protected $table;
    /**
     * @var string The primary key of the table
     */
    protected $primary;

    public function __construct(\PDO $pdo, $table = null, $primary = null)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        if (null === $this->pdo) {
            throw new \RuntimeException('PDO is not set yet');
        }
        return $this->pdo;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param string $table
     * @return MapperAbstract
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @param string $primary
     * @return MapperAbstract
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
        return $this;
    }

    public function find($primaryKey)
    {
        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE ' . $this->getPrimary() . ' = ?';
        if (false === ($stmt = $this->pdo->prepare($sql))) {
            throw new \RuntimeException('Can\'t prepare the request: ' . implode(' - ', $this->pdo->errorInfo()));
        }
        $stmt->bindParam(1, $primaryKey);
        $stmt->execute();
        if (false === ($resultSet = $stmt->fetchObject())) {
            throw new \RuntimeException('Can\'t prepare the request: ' . implode(' - ', $stmt->errorInfo()));
        }
        return $resultSet;
    }

    public function fetchRow($where = array ())
    {
        $stmt = $this->prepareStatement($where);
        if (false === ($resultSet = $stmt->fetchObject())) {
            throw new \RuntimeException('Can\'t prepare the request: ' . implode(' - ', $stmt->errorInfo()));
        }
        return $resultSet;
    }

    public function fetchAll($where = array ())
    {
        $stmt = $this->prepareStatement($where);
        if (false === ($resultSet = $stmt->fetchAll())) {
            throw new \RuntimeException('Can\'t prepare the request: ' . implode(' - ', $stmt->errorInfo()));
        }
        return $resultSet;
    }

    public function save($rowData)
    {
        $id = 0;
        if (array_key_exists($this->getPrimary(), $rowData)) {
            $id = (int) $rowData[$this->getPrimary()];
            unset ($rowData[$this->getPrimary()]);
        }
        $fields = array_keys($rowData);
        $fieldCount = count($fields);

        if (0 < $id) {
            $sql = 'UPDATE ' . $this->getTable() . ' SET ';
            for ($i = 0; $i < $fieldCount; $i++) {
                $sql .= $fields[$i] . ' = ?';
                if (($fieldCount - 1) > $i) {
                    $sql .= ', ';
                }
            }
        } else {
            $values = array_pad(array (), $fieldCount, '?');
            $sql = 'INSERT INTO ' . $this->getTable() . '('
                . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
        }
        if (false === ($stmt = $this->pdo->prepare($sql))) {
            throw new \RuntimeException('Can\'t prepare the request: ' . implode(' - ', $this->pdo->errorInfo()));
        }
        $result = $stmt->execute(array_values($rowData));
        return $result;
    }

    /**
     * Prepares complex statements
     *
     * Requires to pass in the SQL query and the condition in a key/value
     * pair where the key is the field of the table and the value what the
     * field should contain.
     *
     * @param array $where
     * @return \PDOStatement
     */
    protected function prepareStatement($where)
    {
        $params = array ();
        $sql = 'SELECT * FROM ' . $this->getTable();
        if (array () !== $where) {
            $sql .= ' WHERE ';
            $fields = array_keys($where);
            $count = count($where);
            for($i = 0; $i < $count; $i++) {
                $sql .= '(' . $fields[$i] . ' = ?)';
                $params[$i + 1] = $where[$fields[$i]];
                if (($count - 1) > $i) {
                    $sql .= ' AND ';
                }

            }
        }
        if (false === ($stmt = $this->pdo->prepare($sql))) {
            throw new \RuntimeException('Can\'t prepare the request: ' . implode(' - ', $this->pdo->errorInfo()));
        }
        foreach ($params as $index => $value) {
            $stmt->bindParam($index, $value);
        }
        $stmt->execute();
        return $stmt;
    }
}