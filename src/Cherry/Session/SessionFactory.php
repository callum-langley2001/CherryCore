<?php

declare(strict_types=1);

namespace Cherry\Session;

use Cherry\Session\Exception\SessionStorageInvalidArgumentException;
use Cherry\Session\Storage\SessionStorageInterface;
use Cherry\Session\SessionInterface;

/**
 * SessionFactory class
 * This class is used to create Session objects.
 * 
 * @package Cherry
 * @subpackage Session
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class SessionFactory
{
    public function __construct()
    {
    }

    /**
     * Create a new session.
     *
     * @param string $sessionName The name of the session.
     * @param string $storageString The string representation of the session storage class.
     * @param array|null $options (Optional) Additional options for the session storage class. Default is an empty array.
     * @throws SessionStorageInvalidArgumentException If the $storageString is not a valid session storage class.
     * @return SessionInterface The created session.
     */
    public function create(string $sessionName, string $storageString, ?array $options = []): SessionInterface
    {
        $storageObject = new $storageString($options);

        if (!$storageObject instanceof SessionStorageInterface) {
            throw new SessionStorageInvalidArgumentException("{$storageString} is not a valid session storage class");
        }

        return new Session($sessionName, $storageObject);
    }
}
