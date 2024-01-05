<?php

declare(strict_types=1);

namespace Cherry\BakeORM\QueryBuilder\Exception;

use InvalidArgumentException;

/**
 * QueryBuilderInvalidArgumentException class
 * 
 * @package Cherry
 * @subpackage BakeORM\QueryBuilder\InvalidArgumentException
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @extends InvalidArgumentException
 * @see InvalidArgumentException
 */
class QueryBuilderInvalidArgumentException extends InvalidArgumentException
{
    /**
     * Main constructor for the QueryBuilderInvalidArgumentException class.
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
