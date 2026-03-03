<?php

declare(strict_types=1);

namespace Cherry\DatabaseConnection;

use PDO;

interface DatabaseConnectionInterface
{
    /**
     * Create a new database connection
     *
     * @return PDO
     */
    public function open(): PDO;

    /**
     * Close the database connection
     */
    public function close(): void;
}
