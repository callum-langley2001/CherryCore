<?php

declare(strict_types=1);

namespace Cherry\Session;

use Cherry\Session\Exception\SessionInvalidArgumentException;
use Cherry\Session\Storage\SessionStorageInterface;
use Cherry\Session\Exception\SessionException;
use Throwable;

/**
 * Class Session
 * 
 * @package Cherry
 * @subpackage Session
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements SessionInterface
 * @see SessionInterface
 */
class Session implements SessionInterface
{
    protected SessionStorageInterface $storage;

    protected string $sessionName;

    protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

    public function __construct(string $sessionName, SessionStorageInterface $storage = null)
    {
        if ($this->isSessionKeyValid($sessionName) === false) {
            throw new SessionInvalidArgumentException("Invalid session name: $sessionName");
        }

        $this->sessionName = $sessionName;
        $this->storage = $storage;
    }

    /**
     * Sets a value in the session storage.
     *
     * @param string $key The key of the value to be set.
     * @param mixed $value The value to be set.
     * @throws SessionException If an exception occurs while setting the session.
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->setSession($key, $value);
        } catch (Throwable $th) {
            throw new SessionException("An exception occurred while setting the session {$th}");
        }
    }

    /**
     * Sets an array value in the session.
     *
     * @param string $key The key of the value to set.
     * @param array $value The value to set.
     * @throws SessionException An exception occurred while setting the session.
     * @return void
     */
    public function setArray(string $key, array $value): void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->setSessionArray($key, $value);
        } catch (Throwable $th) {
            throw new SessionException("An exception occurred while setting the session {$th}");
        }
    }

    /**
     * Retrieves the value associated with the given key from the session storage.
     *
     * @param string $key The key to retrieve the value for.
     * @param mixed $default The default value to return if the key does not exist.
     * @throws SessionException An exception occurred while getting the session.
     * @return mixed The value associated with the given key, or the default value if the key does not exist.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            return $this->storage->getSession($key, $default);
        } catch (Throwable $th) {
            throw new SessionException();
        }
    }

    /**
     * Deletes a session with the given key.
     *
     * @param string $key The key of the session to be deleted.
     * @throws SessionException If an exception occurs while deleting the session.
     * @return bool Returns true if the session is successfully deleted, false otherwise.
     */
    public function delete(string $key): bool
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->deleteSession($key);
            return true;
        } catch (Throwable $th) {
            throw new SessionException();
        }
    }

    /**
     * Invalidates the session.
     * 
     * @return void
     */
    public function invalidate(): void
    {
        $this->storage->invalidateSession();
    }

    /**
     * Flushes a given key-value pair to the storage.
     *
     * @param string $key The key to flush.
     * @param mixed $value The value to flush.
     * @throws SessionException If an error occurs while flushing the key-value pair.
     */
    public function flush(string $key, mixed $value)
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->flush($key, $value);
        } catch (Throwable $th) {
            throw new SessionException();
        }
    }

    /**
     * Checks if the given key exists in the session storage.
     *
     * @param string $key The key to check.
     * @return bool Returns true if the key exists, false otherwise.
     */
    public function has(string $key): bool
    {
        $this->ensureSessionKeyIsValid($key);
        return $this->storage->sessionHas($key);
    }

    /**
     * Checks if the session key is valid.
     *
     * @param string $key The session key to check.
     * @return bool Returns true if the session key is valid, false otherwise.
     */
    protected function isSessionKeyValid(string $key): bool
    {
        return preg_match(self::SESSION_PATTERN, $key) === 1;
    }

    /**
     * Ensures that the provided session key is valid.
     *
     * @param string $key The session key to check for validity.
     * @throws SessionInvalidArgumentException If the session key is not valid.
     * @return void
     */
    protected function ensureSessionKeyIsValid(string $key): void
    {
        if ($this->isSessionKeyValid($key) === false) {
            throw new SessionInvalidArgumentException("{$key} is not a valid session key");
        }
    }
}
