<?php

declare(strict_types=1);

namespace Cherry\BakeORM\DataMapper;

use Cherry\BakeORM\DataMapper\Exception\DataMapperInvalidArgumentException;

/**
 * DataMapperEnvConfig class
 * (DataMapper Environment Configuration)
 * 
 * @package Cherry
 * @subpackage BakeORM\DataMapper
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class DataMapperEnvConfig
{
    /**
     * The credentials for the database
     * @var array $credentials
     */
    private array $credentials = [];

    /**
     * Creates a new instance of the class.
     *
     * @param array $credentials The credentials for the instance.
     * @return void
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Retrieves the database credentials for the specified driver.
     *
     * @param string $driver The driver for which to retrieve the credentials.
     * @return array The array of database credentials.
     */
    public function getDBCredentials(string $driver): array
    {
        $connectionArray = [];
        $this->areCredentialsValid($driver);

        foreach ($this->credentials as $credential) {
            if (array_key_exists($driver, $credential)) {
                $connectionArray = $credential[$driver];
            }
        }

        return $connectionArray;
    }

    /**
     * Validates the credentials for a given driver.
     *
     * @param string $driver The driver to validate credentials for.
     * @throws DataMapperInvalidArgumentException If the argument is empty or not a string.
     * @throws DataMapperInvalidArgumentException If the credentials provided are not an array.
     * @throws DataMapperInvalidArgumentException If the driver is invalid or not supported.
     * @return void
     */
    private function areCredentialsValid(string $driver): void
    {
        if (empty($driver) && !is_string($driver)) {
            throw new DataMapperInvalidArgumentException('The argument you provided is invalid. Please provide a string.');
        }
        if (!is_array($this->credentials)) {
            throw new DataMapperInvalidArgumentException('Invalid credentials provided.');
        }
        if (!in_array($driver, array_keys($this->credentials[$driver]))) {
            throw new DataMapperInvalidArgumentException('Invalid or unsupported driver provided.');
        }
    }
}
