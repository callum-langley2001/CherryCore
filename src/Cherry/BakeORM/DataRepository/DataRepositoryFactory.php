<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataRepository;

use Cherry\BakeORM\DataRepository\Exception\DataRepositoryException;

class DataRepositoryFactory
{
    /**
     * The table schema
     *
     * @var string $tableSchema
     */
    protected string $tableSchema;

    /**
     * The table schema ID
     *
     * @var string $tableSchemaID
     */
    protected string $tableSchemaID;

    /**
     * The crud identifier
     *
     * @var string $crudIdentifier
     */
    protected string $crudIdentifier;

    public function __construct(string $crudIdentifier, string $tableSchema, string $tableSchemaID)
    {
        $this->crudIdentifier = $crudIdentifier;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
    }

    public function create(string $dataRepositoryString): DataRepositoryInterface
    {
        $dataRepositoryObject = new $dataRepositoryString();

        if (!$dataRepositoryObject instanceof DataRepositoryInterface) {
            throw new DataRepositoryException("$dataRepositoryString is not a valid data repository object");
        }

        return $dataRepositoryObject;
    }
}
