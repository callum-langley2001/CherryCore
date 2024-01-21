<?php

declare(strict_types=1);

namespace Cherry\Session\Storage;

use Cherry\Session\Storage\AbstractSessionStorage;

/**
 * Class NativeSessionStorage
 * 
 * @package Cherry
 * @subpackage Session\Storage
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @extends AbstractSessionStorage
 * @see AbstractSessionStorage
 * @see SessionStorageInterface
 */
class NativeSessionStorage extends AbstractSessionStorage
{
    /**
     * Constructs a new instance of the class.
     *
     * @param array|null $options (Optional) An array of options for the constructor.
     * @return void
     * @see AbstractSessionStorage::__construct
     */
    public function __construct(?array $options = [])
    {
        parent::__construct($options);
    }

    /**
     * Sets a value in the session.
     *
     * @param string $key The key of the session value.
     * @param mixed $value The value to be set in the session.
     * @return void
     */
    public function setSession(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Set an array value in the session.
     *
     * @param string $key The key of the session array.
     * @param array $value The value to be added to the session array.
     * @return void
     */
    public function setSessionArray(string $key, array $value): void
    {
        $_SESSION[$key][] = $value;
    }

    /**
     * Retrieves a session value by key.
     *
     * @param string $key The key of the session value to retrieve.
     * @param mixed $default The default value to return if the session key does not exist.
     * @return mixed The session value associated with the key, or the default value if the key does not exist.
     */
    public function getSession(string $key, mixed $default = null): mixed
    {
        if ($this->sessionHas($key)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Deletes a session variable by key.
     *
     * @param string $key The key of the session variable to delete.
     * @return bool Returns true if the session variable was successfully deleted, false otherwise.
     */
    public function deleteSession(string $key): bool
    {
        if ($this->sessionHas($key)) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }

    /**
     * Invalidates the current session by clearing session data and destroying the session.
     * If session is using cookies, it also removes the session cookie.
     *
     * @return void
     */
    public function invalidate(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setCookie(
                $this->getSessionName(),
                '',
                time() - $params['lifetime'],
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );

            session_unset();
            session_destroy();
        }
    }

    /**
     * Flushes a value from the session and returns it if it exists,
     * otherwise returns a default value.
     *
     * @param string $key The key of the value to flush from the session.
     * @param mixed $default The default value to return if the key does not exist in the session. (optional)
     * @return mixed The flushed value if it exists in the session, otherwise the default value.
     */
    public function flush(string $key, mixed $default = null): mixed
    {
        if ($this->sessionHas($key)) {
            $value = $_SESSION[$key];
            $this->deleteSession($key);
            return $value;
        }
        return $default;
    }

    /**
     * Checks if a session variable with the specified key exists.
     *
     * @param string $key The key of the session variable to check.
     * @return bool True if the session variable exists, false otherwise.
     */
    public function sessionHas(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
}
