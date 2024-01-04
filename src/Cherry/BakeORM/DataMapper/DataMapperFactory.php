<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataMapper;

use Cherry\BakeORM\DataMapper\Exception\DataMapperException;
use Cherry\DBConnection\DBConnectionInterface;

/**
 * DataMapperFactory class
 * This class is used to create DataMapper objects.
 * 
 * @package Cherry
 * @subpackage BakeORM\DataMapper
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class DataMapperFactory
{
    public function __construct()
    {
    }

    /**
     * Creates a new DataMapper instance with the provided database connection string and data mapper environment configuration.
     *
     * @param string $dbConnectionString The database connection string.
     * @param string $dataMapperEnvConfig The data mapper environment configuration.
     * @throws DataMapperException If the database connection object is not a valid DBConnectionInterface instance.
     * @return DataMapperInterface The newly created DataMapper instance.
     */
    public function create(string $dbConnectionString, string $dataMapperEnvConfig): DataMapperInterface
    {
        $credentials = (new $dataMapperEnvConfig([]))->getDBCredentials('mysql');
        $dbConnectionObject = new $dbConnectionString($credentials);

        if (!$dbConnectionObject instanceof DBConnectionInterface) {
            throw new DataMapperException("{$dbConnectionString} is not a valid database connection object.");
        }

        return new DataMapper($dbConnectionObject);
    }
}
