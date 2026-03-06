<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataMapper;

use Cherry\BakeORM\DataMapper\Exception\DataMapperInvalidArgumentException;

class DataMapperEnvironmentConfiguration
{
    /**
     * The database credentials.
     * @var array
     */
    private array $credentials = [];

    /**
     * Initializes the DataMapperEnvironmentConfiguration object with the given database credentials.
     *
     * @param array $credentials The database credentials to use
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Returns an array of database credentials for the given driver.
     *
     * @param string $driver The database driver to retrieve the credentials for.
     * @return array An array of database credentials.
     */
    public function getDatabaseCredentials(string $driver): array
    {
        $connectionArray = [];

        foreach ($this->credentials as $credential) {
            if (array_key_exists($driver, $credential)) {
                $connectionArray = $credential[$driver];
            }
        }

        return $connectionArray;
    }

    /**
     * Validates the given database driver and the credentials.
     *
     * This method checks if the given driver is valid and if the credentials are set.
     * If the given driver is empty or not a string, a DataMapperInvalidArgumentException will be thrown.
     * If the credentials are not an array, a DataMapperInvalidArgumentException will be thrown.
     * If the given driver is not a valid database driver, a DataMapperInvalidArgumentException will be thrown.
     *
     * @param string $driver The database driver to validate.
     * @throws DataMapperInvalidArgumentException If the given driver is empty or not a string.
     * @throws DataMapperInvalidArgumentException If the credentials are not an array.
     * @throws DataMapperInvalidArgumentException If the given driver is not a valid database driver.
     */
    private function isCredentialsValid(string $driver)
    {
        if (empty($driver) && !is_string($driver)) {
            throw new DataMapperInvalidArgumentException('Invalid argument. This is either missing or of an invalid type.');
        }
        if (!is_array($this->credentials)) {
            throw new DataMapperInvalidArgumentException('Invalid credentials.');
        }
        if (!is_array($driver, array_keys($this->credentials['driver']))) {
            throw new DataMapperInvalidArgumentException('Invalid or unsupported database driver.');
        }
    }
}
