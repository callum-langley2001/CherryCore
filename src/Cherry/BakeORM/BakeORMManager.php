<?php

declare(strict_types=1);

namespace Cherry\BakeORM;

use Cherry\BakeORM\EntityManager\Crud;
use Cherry\BakeORM\QueryBuilder\QueryBuilder;
use Cherry\BakeORM\DataMapper\DataMapperFactory;
use Cherry\DatabaseConnection\DatabaseConnection;
use Cherry\BakeORM\QueryBuilder\QueryBuilderFactory;
use Cherry\BakeORM\EntityManager\EntityManagerFactory;
use Cherry\BakeORM\DataMapper\DataMapperEnvironmentConfiguration;

class BakeORMManager
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
     * The options
     *
     * @var array $options
     */
    protected array $options;

    /**
     * The data mapper environment configuration
     *
     * @var DataMapperEnvironmentConfiguration $environmentConfiguration
     */
    protected DataMapperEnvironmentConfiguration $environmentConfiguration;

    public function __construct(DataMapperEnvironmentConfiguration $environmentConfiguration, string $tableSchema, string $tableSchemaID, array $options = [])
    {
        $this->environmentConfiguration = $environmentConfiguration;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
        $this->options = $options;
    }

    public function initialise()
    {
        $dataMapperFactory = new DataMapperFactory();
        $dataMapper = $dataMapperFactory->create(DatabaseConnection::class, DataMapperEnvironmentConfiguration::class);

        if ($dataMapper) {
            $queryBuilderFactory = new QueryBuilderFactory();
            $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);

            if ($queryBuilder) {
                $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
                return $entityManagerFactory->create(Crud::class, $this->tableSchema, $this->tableSchemaID, $this->options);
            }
        }
    }
}
