<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataMapper;

use Cherry\BakeORM\DataMapper\DataMapperInterface;
use Cherry\DatabaseConnection\DatabaseConnectionInterface;
use Cherry\BakeORM\DataMapper\Exception\DataMapperException;

class DataMapperFactory
{
    public function __construct() {}

    /**
     * Creates a new DataMapper object based on the given database connection string and data mapper environment configuration.
     *
     * @param string $databaseConnectionString The database connection string to use
     * @param string $dataMapperEnvironmentConfiguration The data mapper environment configuration to use
     *
     * @return DataMapperInterface The created DataMapper object
     *
     * @throws DataMapperException If the given database connection string is not a valid database connection object
     */
    public function create(string $databaseConnectionString, string $dataMapperEnvironmentConfiguration): DataMapperInterface
    {
        $credentials = (new $dataMapperEnvironmentConfiguration([]))->getDatabaseCredentials(['mysql']);
        $databaseConnectionObject = new $databaseConnectionString($credentials);

        if (!$databaseConnectionObject instanceof DatabaseConnectionInterface) {
            throw new DataMapperException("$databaseConnectionString is not a valid database connection object");
        }

        return new DataMapper($databaseConnectionObject);
    }
}
