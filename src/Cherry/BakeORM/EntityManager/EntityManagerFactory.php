<?php

declare(strict_types=1);

namespace Cherry\BakeORM\EntityManager;

use Cherry\BakeORM\EntityManager\Exception\CrudException;
use Cherry\bakeorm\EntityManager\EntityManagerInterface;
use Cherry\BakeORM\QueryBuilder\QueryBuilderInterface;
use Cherry\BakeORM\DataMapper\DataMapperInterface;

/**
 * EntityManagerFactory class
 * This class is used to create EntityManager objects.
 * 
 * @package Cherry
 * @subpackage BakeORM\EntityManager
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class EntityManagerFactory
{
    /**
     * DataMapperInterface instance
     * 
     * @var DataMapperInterface $dataMapper DataMapperInterface instance
     */
    protected DataMapperInterface $dataMapper;

    /**
     * QueryBuilderInterface instance
     * 
     * @var QueryBuilderInterface $queryBuilder QueryBuilderInterface instance
     */
    protected QueryBuilderInterface $queryBuilder;

    /**
     * Constructor for the class.
     *
     * @param DataMapperInterface $dataMapper The data mapper object.
     * @param QueryBuilderInterface $queryBuilder The query builder object.
     */
    public function __construct(DataMapperInterface $dataMapper, QueryBuilderInterface $queryBuilder)
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * Creates a new entity manager based on the given CRUD string, table schema, and table schema ID.
     *
     * @param string $crudString The fully qualified class name of the CRUD object.
     * @param string $tableName The schema of the table.
     * @param string $tableIDColumn The ID of the table schema.
     * @param array $options (Optional) Additional options.
     * @throws CrudException If the CRUD object is not a valid instance of the CrudInterface.
     * @return EntityManagerInterface The created entity manager.
     */
    public function create(
        string $crudString,
        string $tableName,
        string $tableIDColumn,
        array $options = []
    ): EntityManagerInterface {
        $crudObject = (new $crudString($this->dataMapper, $this->queryBuilder, $tableName, $tableIDColumn, $options));

        if (!$crudObject instanceof CrudInterface) {
            throw new CrudException("{$crudString} is not a valid CRUD object");
        }

        return new EntityManager($crudObject);
    }
}
