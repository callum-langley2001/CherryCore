<?php

declare(strict_types=1);

namespace Cherry\DBConnection;

use Cherry\DBConnection\Exception\DBConnectionException;
use Cherry\DBConnection\DBConnectionInterface;
use PDOException;
use PDO;

/**
 * DBConnection class
 * 
 * @package Cherry
 * @subpackage DBConnection
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements DBConnectionInterface
 * @see DBConnectionInterface
 * @see DBConnectionException
 */
class DBConnection implements DBConnectionInterface
{
    /**
     * @var PDO $dbh
     */
    protected PDO $dbh;

    /**
     * @var array $credentials
     */
    protected array $credentials;

    /**
     * Main constructor for the DBConnection class
     * 
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @inheritDoc
     */
    public function open(): PDO
    {
        try {
            $options = [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            $this->dbh = new PDO(
                $this->credentials['dsn'],
                $this->credentials['username'],
                $this->credentials['password'],
                $options,
            );
        } catch (PDOException $e) {
            throw new DBConnectionException($e->getMessage(), (int)$e->getCode());
        }

        return $this->dbh;
    }

    /**
     * @inheritDoc
     */
    public function close(): void
    {
        $this->dbh = null;
    }
}
