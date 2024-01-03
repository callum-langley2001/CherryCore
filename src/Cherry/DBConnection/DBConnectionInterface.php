<?php

namespace Cherry\DBConnection;

use PDO;

/**
 * Interface DBConnectionInterface
 * 
 * @package Cherry
 * @subpackage DBConnection
 * @author Callum Langley <callumlangley9@gmailcom>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface DBConnectionInterface
{
    /**
     * Create and open a new PDO connection
     * 
     * @return PDO
     */
    public function open(): PDO;

    /**
     * Close the current PDO connection
     * 
     * @return void
     */
    public function close(): void;
}
