<?php

declare(strict_types=1);

namespace Cherry\BakeORM\QueryBuilder;

use Cherry\BakeORM\QueryBuilder\Exception\QueryBuilderInvalidArgumentException;
use Cherry\BakeORM\QueryBuilder\QueryBuilderInterface;

/**
 * QueryBuilder class
 * 
 * @package Cherry
 * @subpackage BakeORM\QueryBuilder
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements QueryBuilderInterface
 * @see QueryBuilderInterface
 */
class QueryBuilder implements QueryBuilderInterface
{
    /**
     * The key of the query
     * 
     * @var array $key The key of the query
     */
    protected array $key;

    /**
     * The SQL query
     * 
     * @var string $sqlQuery The SQL query
     */
    protected string $sqlQuery = '';

    /**
     * The default query values
     * 
     * @var array $SQL_DEFAULT The default query values
     */
    protected const SQL_DEFAULT = [
        'conditions' => [],
        'selectors' => [],
        'replace' => false,
        'distinct' => false,
        'from' => [],
        'where' => [],
        'and' => [],
        'or' => [],
        'order_by' => [],
        'fields' => [],
        'primary_key' => '',
        'table' => '',
        'type' => '',
        'raw' => '',
    ];

    protected const QUERY_TYPES = ['insert', 'select', 'update', 'delete', 'raw'];

    public function __construct()
    {
    }

    /**
     * Builds a query with the given arguments and returns the current instance of the class.
     *
     * @param array $args The arguments to build the query.
     * @throws QueryBuilderInvalidArgumentException If no query is provided.
     * @return self The current instance of the class.
     */
    public function buildQuery(array $args = []): self
    {
        if (count($args) < 0) {
            throw new QueryBuilderInvalidArgumentException("No query provided");
        }

        $arg = array_merge(self::SQL_DEFAULT, $args);
        $this->key = $arg;
        return $this;
    }

    /**
     * Check if the query type is valid.
     *
     * @param string $type The query type to check.
     * @return bool Returns true if the query type is valid, otherwise false.
     */
    private function isQueryTypeValid(string $type): bool
    {
        if (in_array($type, self::QUERY_TYPES)) return true;

        return false;
    }

    /**
     * Generates an SQL INSERT query based on the provided fields and values.
     *
     * @return string The generated SQL INSERT query.
     */
    public function insertQuery(): string
    {
        // INSERT INTO users (name, email) VALUES (:name, :email)
        // [user => callum, email => callumlangley9@gmail.com]
        if ($this->isQueryTypeValid('insert')) {
            if (
                is_array($this->key['fields'])
                && count($this->key['fields']) > 0
            ) {
                $index = array_keys($this->key['fields']);
                $value = array(
                    implode(', ', $index),
                    ':' . implode(', :', $index)
                );
                $this->sqlQuery = "INSERT INTO {$this->key['table']} ({$value[0]}) VALUES ({$value[1]})";
                return $this->sqlQuery;
            }
        }
        return '';
    }

    /**
     * Generates a SELECT query based on the provided selectors and table name.
     *
     * @return string The generated SELECT query.
     */
    public function selectQuery(): string
    {
        if ($this->isQueryTypeValid('select')) {
            $selectors = (!empty($this->key['selectors'])) ? implode(', ', $this->key['selectors']) : '*';
            $this->sqlQuery = "SELECT {$selectors} FROM {$this->key['table']}";

            $this->sqlQuery = $this->hasConditions();
            return $this->sqlQuery;
        }
        return '';
    }

    /**
     * Updates the query string based on the given key fields and primary key.
     *
     * @return string The updated query string.
     */
    public function updateQuery(): string
    {
        if ($this->isQueryTypeValid('update')) {
            if (
                is_array($this->key['fields'])
                && count($this->key['fields']) > 0
            ) {
                foreach ($this->key['fields'] as $field) {
                    if ($field !== $this->key['primary_key']) {
                        $values = "{$field} = :{$field}, ";
                    }
                }
                $values = substr_replace($values, '', -2);
                if (count($this->key['fields']) > 0) {
                    $this->sqlQuery = "UPDATE {$this->key['table']} SET {$values} WHERE {$this->key['primary_key']} = :{$this->key['primary_key']} LIMIT 1";
                    if (
                        isset($this->key['primary_key'])
                        && $this->key['primary_key'] === '0'
                    ) {
                        unset($this->key['primary_key']);
                        $this->sqlQuery = "UPDATE {$this->key['table']} SET {$values}";
                    }
                }
                return $this->sqlQuery;
            }
        }
        return '';
    }


    /**
     * Deletes a record from the database table based on the provided conditions.
     * Multiple conditions are supported to delete multiple records.
     *
     * @return string The generated SQL query for deleting the record.
     */
    public function deleteQuery(): string
    {
        if ($this->isQueryTypeValid('delete')) {
            $index = array_keys($this->key['conditions']);
            $this->sqlQuery = "DELETE FROM {$this->key['table']} WHERE {$index[0]} = :{$index[0]} LIMIT 1";
            $bulkDelete = array_values($this->key['fields']);
            if (
                is_array($bulkDelete)
                && count($bulkDelete) > 1
            ) {
                for ($i = 0; $i < count($bulkDelete); $i++) {
                    $this->sqlQuery = "DELETE FROM {$this->key['table']} WHERE {$index[0]} = :{$index[0]}";
                }
            }
            return $this->sqlQuery;
        }
        return '';
    }

    /**
     * Check if the function has any conditions.
     *
     * @return string The SQL query with the conditions.
     */
    private function hasConditions()
    {
        if (
            isset($this->key['conditions'])
            && $this->key['conditions'] != ''
        ) {
            if (is_array($this->key['conditions'])) {
                $sort = [];
                foreach (array_keys($this->key['conditions']) as $whereKey => $where) {
                    if (
                        isset($where)
                        && $where != ''
                    ) {
                        $sort[] = "{$where} = :{$where}";
                    }
                }
                if (count($this->key['conditions']) > 0) {
                    $this->sqlQuery .= " WHERE " . implode(' AND ', $sort);
                }
            }
        } elseif (empty($this->key['conditions'])) {
            $this->sqlQuery = " WHERE 1";
        }

        if (
            isset($this->key['order_by'])
            && $this->key['order_by'] != ''
        ) {
            $this->sqlQuery .= " ORDER BY {$this->key['order_by']} ";
        }
        if (
            isset($this->key['limit'])
            && $this->key['offset'] != -1
        ) {
            $this->sqlQuery .= " LIMIT :limit OFFSET :offset ";
        }

        return $this->sqlQuery;
    }
}
