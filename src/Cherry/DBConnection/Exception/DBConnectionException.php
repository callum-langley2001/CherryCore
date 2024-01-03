<?php

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
     * @var $message The message of the exception 
     */
    protected $message;

    /**
     * @var $code The code of the exception
     */
    protected $code;

    public function __construct($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
