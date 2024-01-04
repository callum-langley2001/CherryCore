<?php

namespace Cherry\BakeORM\DataMapper;

use Cherry\BakeORM\DataMapper\Exception\DataMapperException;
use Cherry\DBConnection\DBConnectionInterface;
use PDOStatement;
use Throwable;
use stdClass;
use PDO;

/**
 * DataMapper class
 * 
 * @package Cherry
 * @subpackage BakeORM\DataMapper
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements DataMapperInterface
 * @see DataMapperInterface
 */
class DataMapper implements DataMapperInterface
{
    /**
     * The database connection
     * 
     * @var DBConnectionInterface
     */
    private DBConnectionInterface $dbh;

    /**
     * The prepared statement
     * 
     * @var PDOStatement
     */
    private PDOStatement $stmt;

    /**
     * DataMapper constructor
     * 
     * @param DBConnectionInterface $dbh
     */
    public function __construct(DBConnectionInterface $dbh)
    {
        $this->dbh = $dbh;
    }


    /**
     * Checks if a value is empty and throws an exception if it is.
     *
     * @param mixed $value The value to check.
     * @param string $errorMessage The error message to throw if the value is empty.
     * @throws DataMapperException If the value is empty.
     * @return void
     */
    private function isEmpty(mixed $value, string $errorMessage): void
    {
        if (empty($value)) {
            throw new DataMapperException($errorMessage);
        }
    }

    /**
     * Checks if the value is an array.
     * If the value is not an array, an exception is thrown.
     * 
     * @param array $value
     * @throws DataMapperException
     * @return void
     */
    private function isArray(array $value): void
    {
        if (!is_array($value)) {
            throw new DataMapperException('The value must be an array');
        }
    }

    /** @inheritDoc **/
    public function prepare(string $sql): self
    {
        $this->stmt = $this->dbh->open()->prepare($sql);
        return $this;
    }

    /** @inheritDoc **/
    public function bind($value): mixed
    {
        try {
            switch ($value) {
                case is_bool($value):
                case is_int($value):
                    $dataType = PDO::PARAM_INT;
                    break;

                case is_null($value):
                    $dataType = PDO::PARAM_NULL;
                    break;

                default:
                    $dataType = PDO::PARAM_STR;
                    break;
            }
            return $dataType;
        } catch (DataMapperException $e) {
            throw $e;
        }
    }

    /** @inheritDoc **/
    public function bindParams(array $fields, bool $isSearch = false): self|bool
    {
        if (is_array($fields)) {
            $type = ($isSearch === false) ? $this->bindValues($fields) : $this->bindSearchValues($fields);
            if ($type) {
                return $this;
            }
        }
        return false;
    }

    /**
     * Binds values to the query
     * 
     * @param array $fields
     * @return PDOStatement|bool
     */
    protected function bindValues(array $fields): PDOStatement|bool
    {
        $this->isArray($fields);

        foreach ($fields as $key => $value) {
            $this->stmt->bindValue(":{$key}", $value, $this->bind($value));
        }

        return $this->stmt;
    }

    /**
     * Binds search values to a prepared statement.
     *
     * @param array $fields The array of fields to bind.
     * @throws DataMapperException If the $fields parameter is not an array.
     * @return PDOStatement|bool The prepared statement with bound values.
     */
    protected function bindSearchValues(array $fields): PDOStatement|bool
    {
        $this->isArray($fields);

        foreach ($fields as $key => $value) {
            $this->stmt->bindValue(":{$key}", "%{$value}%", $this->bind($value));
        }

        return $this->stmt;
    }

    /** @inheritDoc **/
    public function execute(): bool
    {
        if ($this->stmt) return $this->stmt->execute();

        return false;
    }

    /** @inheritDoc **/
    public function numRows(): int
    {
        if ($this->stmt) return $this->stmt->rowCount();

        return 0;
    }

    /** @inheritDoc **/
    public function result(): object
    {
        if ($this->stmt) return $this->stmt->fetch(PDO::FETCH_OBJ);

        return new stdClass();
    }

    /** @inheritDoc **/
    public function results(): array
    {
        if ($this->stmt) return $this->stmt->fetchAll(PDO::FETCH_OBJ);

        return [];
    }

    /** @inheritDoc **/
    public function getLastID(): int
    {
        try {

            if ($this->dbh->open()) {
                $lastID = $this->dbh->open()->lastInsertId();

                if (!empty($lastID)) return (int)$lastID;

                return 0;
            }

            return 0;
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
