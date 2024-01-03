<?php

namespace Cherry\DBConnection;

use DBConnection\DBConnectionInterface;
use PDO;

/**
 * DBConnection class
 * 
 * @package Cherry
 * @subpackage DBConnection
 * @author Callum Langley <callumlangley9@gmailcom>
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
     * @var PDO $pdo
     */
    protected PDO $pdo;

    /**
     * @var array $credentials
     */
    protected array $credentials;
}
