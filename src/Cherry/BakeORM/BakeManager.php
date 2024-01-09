<?php

declare(strict_types=1);

namespace Cherry\BakeORM;

use Cherry\BakeORM\EntityManager\EntityManagerFactory;
use Cherry\BakeORM\QueryBuilder\QueryBuilderFactory;
use Cherry\BakeORM\DataMapper\DataMapperEnvConfig;
use Cherry\BakeORM\DataMapper\DataMapperFactory;
use Cherry\BakeORM\EntityManager\Crud;
use Cherry\BakeORM\QueryBuilder\QueryBuilder;
use Cherry\DBConnection\DBConnection;

/**
 * BakeManager class
 * This class is used to manage the creation of Bake ORM objects.
 * 
 * @package Cherry
 * @subpackage BakeORM
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class BakeManager
{
    /**
     * The table name for the Bake ORM.
     * 
     * @var string $tableSchema The table schema
     */
    protected string $tableSchema;

    /**
     * The table ID column for the Bake ORM.
     * 
     * @var string $tableSchemaID The table schema ID
     */
    protected string $tableSchemaID;

    protected ?array $options;

    /**
     * The environment configuration for the Bake ORM.
     * 
     * @var DataMapperEnvConfig $envConfig The environment configuration
     */
    protected DataMapperEnvConfig $envConfig;

    /**
     * Constructs a new instance of the class.
     *
     * @param DataMapperEnvConfig $envConfig The environment configuration object.
     * @param string $tableSchema The table schema.
     * @param string $tableSchemaID The table schema ID.
     * @param array|null $options The options array.
     * @return void
     */
    public function __construct(
        DataMapperEnvConfig $envConfig,
        string $tableSchema,
        string $tableSchemaID,
        ?array $options = null
    ) {
        $this->envConfig = $envConfig;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
        $this->options = $options;
    }

    public function init()
    {
        $dataMapperFactory = new DataMapperFactory();
        $dataMapper = $dataMapperFactory->create(DBConnection::class, DataMapperEnvConfig::class);

        if ($dataMapper) {
            $queryBuilderFactory = new QueryBuilderFactory();
            $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);

            if ($queryBuilder) {
                $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);

                return $entityManagerFactory->create(
                    Crud::class,
                    $this->tableSchema,
                    $this->tableSchemaID,
                    $this->options
                );
            }
        }
    }
}
