<?php

declare(strict_types=1);

namespace Cherry\DBConnection\Exception;

use PDOException;

/**
 * DBConnectionException class
 * 
 * @package Cherry
 * @subpackage DBConnection\Exception
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @extends PDOException
 * @see PDOException
 */
class DBConnectionException extends PDOException
{
    /**
     * Main constructor for the DBConnectionException class.
     * Overrides the parent constructor to set the message and code which are Optional
     * 
     * @param string $message (Optional) The message of the exception
     * @param int $code (Optional) The code of the exception
     */
    public function __construct($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
