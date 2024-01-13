<?php

declare(strict_types=1);

namespace Cherry\Session;

/**
 * Interface SessionInterface
 * 
 * @package Cherry
 * @subpackage Session
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface SessionInterface
{
    /**
     * Set a value in the session
     * 
     * @param string $key The key to set
     * @param mixed $value The value to set
     * @return void No return
     */
    public function set(string $key, mixed $value): void;

    /**
     * Set an array in the session
     * 
     * @param string $key The key to set
     * @param array $value The value to set
     * @return void No return
     */
    public function setArray(string $key, array $value): void;

    /**
     * Get a value from the session
     * 
     * @param string $key The key to get
     * @param mixed $default (Optional) The default value
     * @return void The value
     */
    public function get(string $key, mixed $default = null);

    /**
     * Delete a value from the session
     * 
     * @param string $key The key to delete
     * @return bool True on success, false on failure
     */
    public function delete(string $key): bool;

    /**
     * Invalidate the session
     * 
     * @return void No return
     */
    public function invalidate(): void;

    /**
     * Flush a value from the session
     * 
     * @param string $key The key to flush
     * @param mixed $value The value to flush
     * @return void
     */
    public function flush(string $key, mixed $value = null);

    /**
     * Check if the session has a value
     * 
     * @param string $key The key to check
     * @return bool True if the session has the key
     */
    public function has(string $key): bool;
}
