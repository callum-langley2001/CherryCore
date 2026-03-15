<?php

declare(strict_types=1);

namespace Cherry\BakeORM\EntityManager;

use Throwable;
use Cherry\BakeORM\DataMapper\DataMapper;
use Cherry\BakeORM\QueryBuilder\QueryBuilder;

class Crud implements CrudInterface
{
    /**
     * The DataMapper object
     * @var DataMapper $dataMapper
     */
    protected DataMapper $dataMapper;

    /**
     * The QueryBuilder object
     * @var QueryBuilder $queryBuilder
     */
    protected QueryBuilder $queryBuilder;

    /**
     * The table name
     * @var string $tableSchema
     */
    protected string $tableSchema;

    /**
     * The table name
     * @var string $tableSchemaID
     */
    protected string $tableSchemaID;

    /**
     * Initializes the Crud object with the given DataMapper, QueryBuilder, table schema and table schema ID.
     *
     * @param DataMapper $dataMapper The DataMapper object to use
     * @param QueryBuilder $queryBuilder The QueryBuilder object to use
     * @param string $tableSchema The table schema
     * @param string $tableSchemaID The table schema ID
     */
    public function __construct(DataMapper $dataMapper, QueryBuilder $queryBuilder, string $tableSchema, string $tableSchemaID)
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
    }

    /**
     * Gets the table schema.
     *
     * @return string The table schema
     */
    public function getSchema(): string
    {
        return $this->tableSchema;
    }

    /**
     * Gets the table schema ID.
     *
     * @return string The table schema ID
     */
    public function getSchemaID(): string
    {
        return $this->tableSchemaID;
    }

    /**
     * Gets the last inserted ID.
     *
     * @return int The last inserted ID
     */
    public function lastID(): int
    {
        return $this->dataMapper->getLastId();
    }

    /**
     * Creates a new record in the database based on the given fields.
     *
     * This method builds an insert query based on the given fields and persists the query to the database using the given data mapper.
     * If any errors occur while preparing or executing the query, the method will throw a Throwable.
     *
     * @param array $fields The fields to insert into the database
     * @return bool True if the query was successful, false otherwise
     * @throws Throwable If any errors occur while preparing or executing the query
     */
    public function create(array $fields = []): bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'insert', 'fields' => $fields];
            $query = $this->queryBuilder->buildQuery($args)->insertQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));

            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        } catch (Throwable $thorowable) {
            throw $thorowable;
        }
        return false;
    }

    /**
     * Reads records from the database based on the given selectors, conditions, and parameters.
     *
     * This method builds a select query based on the given selectors, conditions, and parameters, and persists the query to the database using the given data mapper.
     * If any errors occur while preparing or executing the query, the method will throw a Throwable.
     *
     * @param array $selectors The fields to select from the database
     * @param array $conditions The conditions to filter the records by
     * @param array $parameters The values to bind to the prepared statement
     * @param array $optional The optional query parameters, such as LIMIT and ORDER BY
     * @return array The results of the query
     * @throws Throwable If any errors occur while preparing or executing the query
     */
    public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
    {
        try {
            $args = [
                'table' => $this->getSchema(),
                'type' => 'select',
                'selectors' => $selectors,
                'conditions' => $conditions,
                'parameters' => $parameters,
                'extra' => $optional
            ];
            $query = $this->queryBuilder->buildQuery($args)->selectQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions, $parameters));

            if ($this->dataMapper->numRows() > 0) {
                return $this->dataMapper->results();
            }
            return [];
        } catch (Throwable $thorowable) {
            throw $thorowable;
        }
    }

    /**
     * Updates a record in the database based on the given fields and primary key.
     *
     * This method builds an update query based on the given fields and primary key, and persists the query to the database using the given data mapper.
     * If any errors occur while preparing or executing the query, the method will throw a Throwable.
     *
     * @param array $fields The fields to update in the database
     * @param string $primaryKey The primary key of the record to update
     * @return bool True if the query was successful, false otherwise
     * @throws Throwable If any errors occur while preparing or executing the query
     */
    public function update(array $fields = [], string $primaryKey): bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'update', 'fields' => $fields, 'primaryKey' => $primaryKey];
            $query = $this->queryBuilder->buildQuery($args)->updateQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));

            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
            return false;
        } catch (Throwable $thorowable) {
            throw $thorowable;
        }
    }

    /**
     * Deletes a record from the database based on the given conditions.
     *
     * This method builds a delete query based on the given conditions, and persists the query to the database using the given data mapper.
     * If any errors occur while preparing or executing the query, the method will throw a Throwable.
     *
     * @param array $conditions The conditions to filter the records by
     * @return bool True if the query was successful, false otherwise
     * @throws Throwable If any errors occur while preparing or executing the query
     */
    public function delete(array $conditions = []): bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'delete', 'conditions' => $conditions];
            $query = $this->queryBuilder->buildQuery($args)->deleteQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));

            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
            return false;
        } catch (Throwable $thorowable) {
            throw $thorowable;
        }
    }

    /**
     * Searches for records in the database based on the given selectors and conditions.
     *
     * This method builds a search query based on the given selectors and conditions, and persists the query to the database using the given data mapper.
     * If any errors occur while preparing or executing the query, the method will throw a Throwable.
     *
     * @param array $selectors The selectors to filter the records by
     * @param array $conditions The conditions to filter the records by
     * @return array The search results
     * @throws Throwable If any errors occur while preparing or executing the query
     */
    public function search(array $selectors = [], array $conditions = []): array
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'search', 'selectors' => $selectors, 'conditions' => $conditions];
            $query = $this->queryBuilder->buildQuery($args)->searchQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));

            if ($this->dataMapper->numRows() > 0) {
                return $this->dataMapper->results();
            }
            return [];
        } catch (Throwable $thorowable) {
            throw $thorowable;
        }
    }

    /**
     * Executes a raw query and returns the results.
     *
     * This method takes a raw SQL query and an array of conditions, and executes the query using the data mapper.
     * It returns the results of the query, or an empty array if no results are found.
     *
     * @param string $rawQuery The raw SQL query to execute
     * @param array $conditions The conditions to filter the records by
     * @return array The results of the query
     * @throws Throwable If any errors occur while preparing or executing the query
     */
    public function rawQuery(string $rawQuery, array $conditions = [])
    {
        try {
            $this->dataMapper->persist($rawQuery, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() > 0) {
                return $this->dataMapper->results();
            }
            return [];
        } catch (Throwable $thorowable) {
            throw $thorowable;
        }
    }
}
