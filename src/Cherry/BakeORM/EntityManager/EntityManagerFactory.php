<?php

declare(strict_types=1);

namespace Cherry\BakeORM\EntityManager;

use Cherry\BakeORM\DataMapper\DataMapperInterface;
use Cherry\BakeORM\QueryBuilder\QueryBuilderInterface;
use Cherry\BakeORM\EntityManager\EntityManagerInterface;
use Cherry\BakeORM\EntityManager\Exception\CrudException;

class EntityManagerFactory
{
    /**
     * The data mapper to use
     *
     * @var DataMapperInterface $dataMapper
     */
    protected DataMapperInterface $dataMapper;

    /**
     * The query builder to use
     *
     * @var QueryBuilderInterface $queryBuilder
     */
    protected QueryBuilderInterface $queryBuilder;

    /**
     * Initializes the EntityManagerFactory object with the given data mapper and query builder.
     *
     * @param DataMapperInterface $dataMapper The data mapper to use
     * @param QueryBuilderInterface $queryBuilder The query builder to use
     */
    public function __construct(DataMapperInterface $dataMapper, QueryBuilderInterface $queryBuilder)
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Creates a new EntityManager object based on the given crud string, table schema and table schema ID.
     *
     * @param string $crudString The crud string to use
     * @param string $tableSchema The table schema to use
     * @param string $tableSchemaID The table schema ID to use
     * @param array $options The optional parameters to use
     * @return EntityManagerInterface The created EntityManager object
     * @throws CrudException If the given crud string is not a valid crud object
     */
    public function create(string $crudString, string $tableSchema, string $tableSchemaID, array $options = []): EntityManagerInterface
    {
        $crudObject = new $crudString($this->dataMapper, $this->queryBuilder, $tableSchema, $tableSchemaID);

        if (!$crudObject instanceof CrudInterface) {
            throw new CrudException("$crudString is not a valid crud object");
        }

        return new EntityManager($crudObject);
    }
}
