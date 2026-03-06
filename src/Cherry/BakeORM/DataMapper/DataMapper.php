<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataMapper;

use PDO;
use stdClass;
use Throwable;
use PDOStatement;
use Cherry\DatabaseConnection\DatabaseConnectionInterface;
use Cherry\DatabaseConnection\Exception\DataMapperException;

class DataMapper implements DataMapperInterface
{
    /**
     * The database connection
     *
     * @var DatabaseConnectionInterface $dbh
     */
    private DatabaseConnectionInterface $dbh;

    /**
     * The prepared statement
     *
     * @var PDOStatement $statement
     */
    private PDOStatement $statement;

    /**
     * Initializes the DataMapper object with the given database connection.
     *
     * @param DatabaseConnectionInterface $dbh The database connection to use
     */
    public function __construct(DatabaseConnectionInterface $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * Throws a DataMapperException if the given value is empty.
     *
     * @param mixed $value
     * @param string $errorMessage
     * @throws DataMapperException
     * @return void
     */
    private function isEmpty(mixed $value, string $errorMessage = ''): void
    {
        if (empty($value)) {
            throw new DataMapperException($errorMessage);
        }
    }

    /**
     * Checks if the given value is an array and throws a DataMapperException if it is empty.
     *
     * @param mixed $value The value to check
     * @param string $errorMessage The error message to throw
     * @throws DataMapperException If the value is empty
     * @return void
     */
    private function isArray(mixed $value): void
    {
        if (!is_array($value)) {
            throw new DataMapperException('Your argument must be an array');
        }
    }

    /**
     * Prepares a SQL query using the database connection.
     *
     * This method opens the database connection and prepares a SQL query.
     * It returns the DataMapper object itself, allowing for method chaining.
     *
     * @param string $sqlQuery The SQL query to prepare
     * @return self The DataMapper object
     */
    public function prepare(string $sqlQuery): self
    {
        $this->statement = $this->dbh->open()->prepare($sqlQuery);
        return $this;
    }

    /**
     * Binds the given value to the prepared statement.
     * 
     * This method checks the type of the given value and returns the corresponding data type.
     * The data type is one of the following: PDO::PARAM_BOOL, PDO::PARAM_INT, PDO::PARAM_NULL, PDO::PARAM_STR.
     * 
     * @param mixed $value The value to bind
     * @return mixed The data type to bind
     * @throws DataMapperException If the given value is empty
     */
    public function bind(mixed $value): mixed
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
        } catch (DataMapperException $exception) {
            throw $exception;
        }
    }

    /**
     * Binds the given array of values to the prepared statement, either as plain values or as search values with a wildcard (%).
     *
     * @param array $fields The values to bind
     * @param bool $isSearch Whether to bind the values as search values (default: false)
     * @return mixed The prepared statement with the bound values, or false if the binding failed
     */
    public function bindParameters(array $fields, bool $isSearch = false): mixed
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
     * Binds the given values to the prepared statement.
     *
     * @param array $fields The values to bind
     * @throws DataMapperException If the given value is empty
     * @return PDOStatement The prepared statement with the bound values
     */
    protected function bindValues(array $fields): PDOStatement
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(':' . $key, $value, $this->bind($value));
        }
        return $this->statement;
    }

    /**
     * Binds the given values to the prepared statement with a wildcard (%).
     * This method is used for searching.
     *
     * @param array $fields The values to bind
     * @throws DataMapperException If the given value is empty
     * @return PDOStatement The prepared statement with the bound values
     */
    protected function bindSearchValues(array $fields): PDOStatement
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value) {
            $this->statement->bindValue(':' . $key, '%' . $value . '%', $this->bind($value));
        }
        return $this->statement;
    }

    /**
     * Executes the prepared statement
     *
     * If the statement is not set, this method will do nothing.
     *
     * @return void
     */
    public function execute(): void
    {
        if ($this->statement)
            $this->statement->execute();
    }

    /**
     * Get the number of rows in the result set
     *
     * @return int The number of rows
     */
    public function numRows(): int
    {
        if ($this->statement)
            return $this->statement->rowCount();
        return 0;
    }

    /**
     * Fetch a single result
     *
     * @return object The result of the query
     */
    public function result(): object
    {
        if ($this->statement)
            return $this->statement->fetch(PDO::FETCH_OBJ);
        return new stdClass();
    }

    /**
     * Fetch all results
     *
     * @return array[object] The results of the query
     */
    public function results(): array
    {
        if ($this->statement)
            return $this->statement->fetchAll();
        return [];
    }

    /**
     * Gets the last inserted ID.
     *
     * This method will return the last inserted ID if the database connection is open.
     * If the database connection is not open, it will throw a Throwable.
     *
     * @return int The last inserted ID
     * @throws Throwable If the database connection is not open
     */
    public function getLastId(): int
    {
        try {
            if ($this->dbh->open()) {
                $lastId = $this->dbh->open()->lastInsertId();
                if (!empty($lastId)) {
                    return intval($lastId);
                }
            }
        } catch (Throwable $thorowable) {
            throw $thorowable;
        }
    }
}
