<?php

namespace Cherry\DBConnection;

use PDO;

/**
 * Interface DBConnectionInterface
 * 
 * @package Cherry
 * @subpackage DBConnection
 * @author Callum Langley <callumlangley9@gmailcom>
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
