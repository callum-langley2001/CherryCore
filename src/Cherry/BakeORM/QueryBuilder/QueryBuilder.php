<?php

declare(strict_types=1);

namespace Cherry\BakeORM\QueryBuilder;

use Cherry\BakeORM\QueryBuilder\Enums\QueryTypesEnum;
use Cherry\BakeORM\QueryBuilder\Exception\QueryBuilderInvalidArgumentException;

class QueryBuilder implements QueryBuilderInterface
{

    /**
     * The query key
     * @var array $key
     */
    protected array $key;

    /**
     * The sql query
     * @var string $sqlQuery
     */
    protected string $sqlQuery;

    /**
     * The default query key
     * @var const array SQL_DEFAULT{'selectors', 'replace', 'distinct', 'from', 'where', 'and', 'or', 'orderBy', 'fields', 'primaryKey', 'table', 'type', 'raw'}
     */
    protected const SQL_DEFAULT = [
        'conditions' => [],
        'selectors' => [],
        'parameters' => [],
        'replace' => false,
        'distinct' => false,
        'from' => [],
        'where' => null,
        'and' => [],
        'or' => [],
        'orderBy' => [],
        'fields' => [],
        'primaryKey' => '',
        'table' => '',
        'type' => '',
        'raw' => ''
    ];

    public function __construct() {}

    /**
     * Builds an insert query based on the given query key.
     *
     * This method builds an insert query based on the given query key.
     * If the given query type is not 'insert', an empty string will be returned.
     * If the given query key does not contain any fields, an empty string will be returned.
     *
     * @return string The built insert query, or an empty string if the query type is not 'insert' or if the query key does not contain any fields.
     */
    public function insertQuery(): string
    {
        if ($this->isQueryTypeValid('insert')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $index = array_keys($this->key['fields']);
                $value = array(implode(', ', $index), ':' . implode(', :', $index));
                $this->sqlQuery = "INSERT INTO {$this->key['table']} ({$value[0]}) VALUES ({$value[1]})";
                return $this->sqlQuery;
            }
        }
        return '';
    }

    public function selectQuery(): string
    {
        if ($this->isQueryTypeValid('select')) {
            $slectors = (!empty($this->key['selectors'])) ? implode(', ', $this->key['selectors']) : '*';
            $this->sqlQuery = "SELECT= {$slectors} FROM {$this->key['table']}";

            $this->sqlQuery = $this->hasConditions();
            return $this->sqlQuery;
        }
        return '';
    }

    /**
     * Builds an update query based on the given query key.
     *
     * This method builds an update query based on the given query key.
     * If the given query type is not 'update', an empty string will be returned.
     * If the given query key does not contain any fields, an empty string will be returned.
     * If the given query key does not contain a primary key, an empty string will be returned.
     * If the given query key contains a primary key with a value of '0', the LIMIT clause will be removed.
     *
     * @return string The built update query, or an empty string if the query type is not 'update', if the query key does not contain any fields, or if the query key does not contain a primary key.
     * @throws QueryBuilderInvalidArgumentException If the given query key does not contain a primary key with a value of '0'.
     */
    public function updateQuery(): string
    {
        if ($this->isQueryTypeValid('update')) {
            if (is_array($this->key['fields']) && count($this->key['fields']) > 0) {
                $values = '';
                foreach ($this->key['fields'] as $field) {
                    if ($field !== $this->key['primaryKey']) {
                        $values .= "$field = :$field, ";
                    }
                }

                $values = substr_replace($values, '', -2);
                if (count($this->key['where']) > 0) {
                    $this->sqlQuery = "UPDATE {$this->key['table']} SET {$values} WHERE {$this->key['primaryKey']} = :{$this->key['primaryKey']} LIMIT 1";

                    if (isset($this->key['primaryKey']) && $this->key['primaryKey'] === '0') {
                        unset($this->key['primaryKey']);
                        $this->sqlQuery = "UPDATE {$this->key['table']} SET {$values}";
                    }
                }
                return $this->sqlQuery;
            }
        }
        return '';
    }

    /**
     * Builds a delete query based on the given query key.
     *
     * This method builds a delete query based on the given query key.
     * If the given query type is not 'delete', an empty string will be returned.
     * If the given query key does not contain any fields, an empty string will be returned.
     * If the given query key contains any fields, the query will be built with the given fields.
     * If the given query key does not contain a primary key, an empty string will be returned.
     * If the given query key contains a primary key with a value of '0', the LIMIT clause will be removed.
     *
     * @return string The built delete query, or an empty string if the query type is not 'delete', if the query key does not contain any fields, or if the query key does not contain a primary key.
     */
    public function deleteQuery(): string
    {
        if ($this->isQueryTypeValid('delete')) {
            $index = array_keys($this->key['conditions']);
            $this->sqlQuery = "DELETE FROM {$this->key['table']} WHERE {$index[0]} = :{$index[0]} LIMIT 1";
            $bulkDelete = array_values($this->key['fields']);

            if (is_array($bulkDelete) && count($bulkDelete) > 1) {
                for ($i = 0; $i < count($bulkDelete); $i++) {
                    $this->sqlQuery = "DELETE FROM {$this->key['table']} WHERE {$index[0]} = :{$index[0]}";
                }
            }

            return $this->sqlQuery;
        }
        return '';
    }

    public function searchQuery(): string
    {
        return '';
    }

    public function rawQuery(): string
    {
        return '';
    }

    /**
     * Builds a query based on the given arguments.
     * 
     * If the given arguments are empty, the default query key will be used.
     * If the given arguments are not an array, a QueryBuilderInvalidArgumentException will be thrown.
     * 
     * @param array $args The arguments to build the query with.
     * @return self The QueryBuilder object with the built query.
     * @throws QueryBuilderInvalidArgumentException If the given arguments are empty or not an array.
     */
    public function buildQuery(array $args = []): self
    {
        if (count($args) < 0) {
            throw new QueryBuilderInvalidArgumentException('Invalid argument. This is either missing or of an invalid type.');
        }
        $arg = array_merge(self::SQL_DEFAULT, $args);
        $this->key = $arg;
        return $this;
    }

    /**
     * Checks if the given query type is valid.
     *
     * This method checks if the given query type is a valid query type.
     * If the given query type is not a valid query type, this method will return false.
     *
     * @param string $type The query type to check.
     * @return bool Whether the given query type is valid.
     */
    private function isQueryTypeValid(string $type): bool
    {
        return QueryTypesEnum::tryFrom($type) !== null;
    }

    /**
     * Checks if the given query key contains any conditions.
     *
     * This method checks if the given query key contains any conditions.
     * If the given query key contains any conditions, the method will return a WHERE clause.
     * If the given query key does not contain any conditions, the method will return an empty string.
     *
     * @return string The WHERE clause, or an empty string if the query key does not contain any conditions.
     */
    private function hasConditions(): string
    {
        if (isset($this->key['conditions']) && $this->key['conditions'] != '') {
            if (is_array($this->key['conditions'])) {
                $sort = [];

                foreach (array_keys($this->key['conditions']) as $whereKey => $where) {
                    if (isset($whereKey) && $where != '') {
                        $sort[] = "{$where} = :{$where}";
                    }
                }

                if (count($this->key['conditions']) > 0) {
                    $this->sqlQuery .= ' WHERE ' . implode(' AND ', $sort);
                }
            }
        } elseif (empty($this->key['conditions'])) {
            $this->sqlQuery = ' WHERE 1';
        }

        if (isset($this->key['orderBy']) && $this->key['orderBy'] != '') {
            $this->sqlQuery .= " ORDER BY {$this->key['orderBy']} ";
        }

        if (isset($this->key['limit']) && $this->key['offset'] != -1) {
            $this->sqlQuery .= " LIMIT :offset, :limit";
        }

        return $this->sqlQuery;
    }
}
