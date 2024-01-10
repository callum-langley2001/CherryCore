<?php

declare(strict_types=1);

namespace Cherry\Session\Storage;

/**
 * Interface SessionStorageInterface
 * 
 * @package Cherry
 * @subpackage Session\Storage
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface SessionStorageInterface
{
    /**
     * Set the session name
     * 
     * @param string $name The session name
     * @return void No return
     */
    public function setSessionName(string $name): void;

    /**
     * Get the session name
     * 
     * @return string The session name
     */
    public function getSessionName(): string;

    /**
     * Set the session id
     * 
     * @param string $id The session id
     * @return void No return
     */
    public function setSessionId(string $id): void;

    /**
     * Get the session id
     * 
     * @return string The session id
     */
    public function getSessionId(): string;

    /**
     * Set a value in the session
     * 
     * @param string $key The key
     * @param mixed $value The value
     * @return void No return
     */
    public function setSession(string $key, mixed $value): void;

    /**
     * Set an array in the session
     * 
     * @param string $key The key
     * @param array $value The value
     * @return void No return
     */
    public function setSessionArray(string $key, array $value): void;

    /**
     * Get a value from the session
     * 
     * @param string $key The key
     * @param mixed $default (Optional) The default value
     * @return mixed The value
     */
    public function getSession(string $key, mixed $default = null): mixed;

    /**
     * Delete a value from the session
     * 
     * @param string $key The key
     * @return bool True on success, false on failure
     */
    public function deleteSession(string $key): bool;

    /**
     * Invalidate the session
     * 
     * @return void No return
     */
    public function invalidate(): void;

    /**
     * Flush a value from the session
     * 
     * @param string $key The key
     * @param mixed $default (Optional) The default value
     * @return void No return
     */
    public function flush(string $key, mixed $default = null);

    /**
     * Check if the session has a value
     * 
     * @param string $key The key
     * @return bool True if the session has the key
     */
    public function sessionHas(string $key): bool;
}
