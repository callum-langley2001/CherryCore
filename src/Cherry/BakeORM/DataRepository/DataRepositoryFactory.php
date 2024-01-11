<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataRepository;

use Cherry\BakeORM\DataRepository\Exception\DataRepositoryException;
use Cherry\BakeORM\DataRepository\DataRepositoryInterface;

/**
 * DataRepositoryFactory class
 * This class is used to create DataRepository objects.
 * 
 * @package Cherry
 * @subpackage BakeORM\DataRepository
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class DataRepositoryFactory
{
    /**
     * The table name for the DataRepository.
     * 
     * @var string $tableName The table schema
     */
    protected string $tableName;

    /**
     * The table ID column for the DataRepository.
     * 
     * @var string $tableIDColumn The table schema ID
     */
    protected string $tableIDColumn;

    /**
     * The CRUD identifier for the DataRepository.
     * 
     * @var string $crudIdentifier The CRUD identifier
     */
    protected string $crudIdentifier;

    /**
     * Constructor for the class.
     *
     * @param string $crudIdentifier The identifier for CRUD operations.
     * @param string $tableName The schema of the table.
     * @param string $tableIDColumn The ID of the table schema.
     */
    public function __construct(string $crudIdentifier, string $tableName, string $tableIDColumn)
    {
        $this->crudIdentifier = $crudIdentifier;
        $this->tableSchema = $tableName;
        $this->tableSchemaID = $tableIDColumn;
    }

    /**
     * Create a new object from the given data repository string.
     *
     * @param string $dataRepositoryString The fully qualified class name of the data repository.
     * @throws DataRepositoryException If the data repository object is not a valid repository.
     * @return object The created data repository object.
     */
    public function create(string $dataRepositoryString)
    {
        $dataRepositoryObject = (new $dataRepositoryString());

        if (!$dataRepositoryObject instanceof DataRepositoryInterface) {
            throw new DataRepositoryException("{$dataRepositoryString} is not a valid repository object.");
        }

        return $dataRepositoryObject;
    }
}
