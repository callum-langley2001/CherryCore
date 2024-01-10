<?php

declare(strict_types=1);

namespace Cherry\Session\Storage;

use Cherry\Session\Storage\SessionStorageInterface;

/**
 * Class Session
 * 
 * @package Cherry
 * @subpackage Session\Storage
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @abstract
 * @implements SessionStorageInterface
 * @see SessionStorageInterface
 */
abstract class AbstractSessionStorage implements SessionStorageInterface
{
    /**
     * Session options.
     * 
     * @var array $options The options to set on the session
     */
    protected array $options = [];

    /**
     * Constructs a new instance of the class.
     *
     * @param array $options (Optional) An array of options for the constructor.
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Sets the name of the session.
     *
     * @param string $name The name of the session.
     * @return void
     */
    public function setSessionName(string $name): void
    {
        session_name($name);
    }

    /**
     * Retrieves the session name.
     *
     * @return string The name of the session.
     */
    public function getSessionName(): string
    {
        return session_name();
    }

    /**
     * Sets the session ID for the PHP function.
     *
     * @param string $id The session ID to set.
     * @return void
     */
    public function setSessionId(string $id): void
    {
        session_id($id);
    }

    /**
     * Retrieves the session ID as a string.
     *
     * @return string The session ID.
     */
    public function getSessionId(): string
    {
        return (string)session_id();
    }
}
