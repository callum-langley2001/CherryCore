<?php

declare(strict_types=1);

namespace Cherry\BakeORM\EntityManager;

use Cherry\BakeORM\QueryBuilder\QueryBuilder;
use Cherry\BakeORM\DataMapper\DataMapper;
use Throwable;

/**
 * Crud class
 * 
 * @package Cherry
 * @subpackage BakeORM\Crud
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements CrudInterface
 * @see CrudInterface
 * @see Throwable
 */
class Crud implements CrudInterface
{
    /**
     * The data mapper
     * 
     * @var DataMapper $dataMapper The data mapper class
     */
    protected DataMapper $dataMapper;

    /**
     * The query builder
     * 
     * @var QueryBuilder $queryBuilder The query builder
     */
    protected QueryBuilder $queryBuilder;

    /**
     * The table schema
     * (Table name e.g. `users`)
     * 
     * @var string $tableSchema The table schema
     */
    protected string $tableSchema;

    /**
     * The table schema ID
     * (Table primary key e.g. `id`)
     * 
     * @var string $tableSchemaID The table schema ID
     */
    protected string $tableSchemaID;

    /**
     * Constructor for the class.
     *
     * @param DataMapper $dataMapper The data mapper object.
     * @param QueryBuilder $queryBuilder The query builder object.
     * @param string $tableSchema The table schema.
     * @param string $tableSchemaID The table schema ID.
     * @return void
     */
    public function __construct(
        DataMapper $dataMapper,
        QueryBuilder $queryBuilder,
        string $tableSchema,
        string $tableSchemaID,
    ) {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
    }

    /**
     * Returns the schema of the table.
     *
     * @return string The schema of the table.
     */
    public function getSchema(): string
    {
        return $this->tableSchema;
    }

    /**
     * Retrieves the schema ID of the current table.
     *
     * @return string The schema ID of the table.
     */
    public function getSchemaID(): string
    {
        return $this->tableSchemaID;
    }

    /**
     * Retrieves the last ID from the data mapper.
     *
     * @throws Throwable if an error occurs while getting the last ID.
     * @return int the last ID retrieved from the data mapper.
     */
    public function lastID(): int
    {
        return $this->dataMapper->getLastID();
    }

    /**
     * Creates a new record in the database table.
     *
     * @param array $fields The fields to be inserted into the table.
     * @throws Throwable If an error occurs during the creation process.
     * @return bool Returns true if the creation was successful, false otherwise.
     */
    public function create(array $fields = []): bool
    {
        try {
            $args = [
                'table' => $this->tableSchema,
                'type' => 'insert',
                'fields' => $fields,
            ];
            $query = $this->queryBuilder->buildQuery($args)->insertQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParams($fields));
            if ($this->dataMapper->numRows() == 1) return true;
        } catch (Throwable $th) {
            throw $th;
        }
        return false;
    }

    /**
     * Reads data from the table based on the given selectors, conditions, parameters, and optional arguments.
     *
     * @param array $selectors (Optional) The columns to select from the table.
     * @param array $conditions (Optional) The conditions to apply to the query.
     * @param array $parameters (Optional) The parameters to bind to the query.
     * @param array $optional (Optional) The optional arguments for the query.
     * @throws Throwable If an error occurs during the execution of the function.
     * @return array The result of the query.
     */
    public function read(
        array $selectors = [],
        array $conditions = [],
        array $parameters = [],
        array $optional = [],
    ): array {
        try {
            $args = [
                'table' => $this->tableSchema,
                'type' => 'select',
                'selectors' => $selectors,
                'conditions' => $conditions,
                'params' => $parameters,
                'extras' => $optional,
            ];
            $query = $this->queryBuilder->buildQuery($args)->selectQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParams($conditions, $parameters));
            if ($this->dataMapper->numRows() > 0) return $this->dataMapper->results();
        } catch (Throwable $th) {
            throw $th;
        }
        return [];
    }

    /**
     * Updates a record in the database table.
     *
     * @param array $fields (Optional) The fields and their values to update.
     * @param string $primaryKey The primary key of the record to update.
     * @throws Throwable If an error occurs during the update process.
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function update(array $fields = [], string $primaryKey): bool
    {
        try {
            $args = [
                'table' => $this->tableSchema,
                'type' => 'update',
                'fields' => $fields,
                'primary_key' => $primaryKey,
            ];
            $query = $this->queryBuilder->buildQuery($args)->updateQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParams($fields));
            if ($this->dataMapper->numRows() == 1) return true;
        } catch (Throwable $th) {
            throw $th;
        }
        return false;
    }

    /**
     * Deletes records from the table based on the given conditions.
     *
     * @param array $conditions The conditions to filter the records.
     * @throws Throwable If an error occurs while deleting the records.
     * @return bool Returns true if the deletion is successful, false otherwise.
     */
    public function delete(array $conditions = []): bool
    {
        try {
            $args = [
                'table' => $this->tableSchema,
                'type' => 'delete',
                'conditions' => $conditions,
            ];
            $query = $this->queryBuilder->buildQuery($args)->deleteQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParams($conditions));
            if ($this->dataMapper->numRows() == 1) return true;
        } catch (Throwable $th) {
            throw $th;
        }
        return false;
    }

    public function search($selectors = [], $conditions = []): array
    {
        try {
            $args = [
                'table' => $this->tableSchema,
                'type' => 'select',
                'selectors' => $selectors,
                'conditions' => $conditions,
            ];
            $query = $this->queryBuilder->buildQuery($args)->searchQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParams($conditions));
            if ($this->dataMapper->numRows() > 0) return $this->dataMapper->results();
        } catch (Throwable $th) {
            throw $th;
        }
        return [];
    }

    public function rawQuery(string $query, ?array $params = []): array
    {



        return [];
    }
}
