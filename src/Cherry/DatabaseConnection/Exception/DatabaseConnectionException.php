<?php

declare(strict_types=1);

namespace Cherry\DatabaseConnection\Exception;

use PDOException;

class DatabaseConnectionException extends PDOException
{
    protected $message;

    protected $code;

    /**
     * Constructor for DatabaseConnectionException.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
