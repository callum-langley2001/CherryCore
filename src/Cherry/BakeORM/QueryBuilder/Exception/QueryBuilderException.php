<?php

declare(strict_types=1);

namespace Cherry\BakeORM\QueryBuilder\Exception;

use Exception;

/**
 * QueryBuilderException class
 * 
 * @package Cherry
 * @subpackage BakeORM\QueryBuilder\Exception
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @extends Exception
 * @see Exception
 */
class QueryBuilderException extends Exception
{
    /**
     * Main constructor for the QueryBuilderException class.
     * Overrides the parent constructor to set the message and code which are optional
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