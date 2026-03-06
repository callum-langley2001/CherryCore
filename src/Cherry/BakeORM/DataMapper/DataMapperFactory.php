<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataMapper;

use Cherry\BakeORM\DataMapper\DataMapperInterface;
use Cherry\BakeORM\DataMapper\Exception\DataMapperException;
use Cherry\DatabaseConnection\DatabaseConnectionInterface;

class DataMapperFactory
{
    public function __construct() {}

    public function create(string $databaseConnectionString, string $dataMapperEnvironmentConfiguration): DataMapperInterface
    {
        $credentials = (new $dataMapperEnvironmentConfiguration([]))->getDatabaseCredentials(['mysql']);
        $databaseConnectionObject = new $databaseConnectionString($credentials);

        if (!$databaseConnectionObject instanceof DatabaseConnectionInterface) {
            throw new DataMapperException("$databaseConnectionString is not an instance of database connection object");
        }

        return new DataMapper($databaseConnectionObject);
    }
}
